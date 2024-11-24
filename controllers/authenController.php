<?php
function registeruser()
{
    if (!empty($_POST)) {
        $data = [
            "ten" => $_POST['ten'] ?? null,
            "email" => $_POST['email'] ?? null,
            "matkhau" => $_POST['matkhau'] ?? null,
        ];

        $errors = validateAddregister($data);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['data'] = $data;

            header('location: ' . BASE_URL . '?act=register');
            exit();
        }

        insert('taikhoan', $data);

        $_SESSION['success'] = 'Thao tác thành công';

        header('location: ' . BASE_URL . '?act=login');
        exit();
    }
    require_once PATH_VIEW . 'authen/register.php';
}
function validateAddregister($data)
{
    $errors = [];

    // Kiểm tra tên
    if (empty($data['ten'])) {
        $errors['ten'] = 'Tên không được để trống.';
    }

    // Kiểm tra email
    if (empty($data['email'])) {
        $errors['email'] = 'Email không được để trống.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Địa chỉ email không hợp lệ.';
    } elseif (!checkUniEmail('taikhoan', $data['email'])) {
        $errors['email'] = 'Email đã được sử dụng.';
    }

    // Kiểm tra mật khẩu
    if (empty($data['matkhau'])) {
        $errors['matkhau'] = 'Mật khẩu không được để trống.';
    } elseif (strlen($data['matkhau']) < 6) {
        $errors['matkhau'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    }

    return $errors;
}

function loginuser()
{

    if (isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . '?act=admin-user');
        exit();
    }

    if (!empty($_POST)) {
        $data = [
            "email" => $_POST['email'] ?? null,
            "matkhau" => $_POST['matkhau'] ?? null,
        ];

        // Xác thực dữ liệu
        $errors = validateLogin($data);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['data'] = $data;

            header('location: ' . BASE_URL . '?act=login');
            exit();
        }

        // Nếu không có lỗi, thực hiện đăng nhập
        authenLoginUser($data);
    }

    require_once PATH_VIEW . 'authen/login.php';
}
function validateLogin($data)
{
    $errors = [];

    // Kiểm tra email
    if (empty($data['email'])) {
        $errors['email'] = 'Email không được để trống.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Địa chỉ email không hợp lệ.';
    }

    // Kiểm tra mật khẩu
    if (empty($data['matkhau'])) {
        $errors['matkhau'] = 'Mật khẩu không được để trống.';
    }

    return $errors;
}
function authenLoginUser($data)
{
    $user = getAdminUser($data['email'], $data['matkhau']);

    if (empty($user)) {
        $_SESSION['error'] = 'Email or password is incorrect';
        header('Location: ' . BASE_URL . '?act=login');
        exit();
    }

    $_SESSION['user'] = $user;
    header('Location: ' . BASE_URL);
    exit();
}

function logoutuser()
{
    if (!empty($_SESSION['user'])) {
        session_destroy();
    }
    header('Location: ' . BASE_URL);
    exit();
}

function getAdminUser($email, $matkhau)
{
    try {
        $sql = "SELECT * FROM taikhoan WHERE email = :email AND matkhau = :matkhau AND trangthai = 0 LIMIT 1";

        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":matkhau", $matkhau);
        $stmt->execute();

        return $stmt->fetch();
    } catch (\Throwable $e) {
        debug($e);
        return false;
    }
}
