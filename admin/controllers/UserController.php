<?php

function userListAll()
{
    $title = 'Danh sách Tài khoản';
    $view = 'users/index';
    $scrips = 'datatable';
    $scrips2 = 'users/scrips';
    $style = 'datatable';

    $users = listAll('taikhoan');

    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}

function userCreate()
{
    $title = 'Thêm mới tài khoản';
    $view = 'users/create';

    $users = listAll('taikhoan');

    if (!empty($_POST)) {
        $data = [
            "ten" => $_POST['ten'] ?? null,
            "email" => $_POST['email'] ?? null,
            "matkhau" => $_POST['matkhau'] ?? null,
            "sodienthoai" => $_POST['sodienthoai'] ?? null,
            "ngaysinh" => $_POST['ngaysinh'] ?? null,
            "diachi" => $_POST['diachi'] ?? null,
            "trangthai" => $_POST['trangthai'] ?? null,
        ];

        $img = $_FILES['anh'] ?? null;

        if (!empty($img)) {
            $imgPath = 'upload/user/' . time() . '-' . basename($img['name']);
            if (move_uploaded_file($img['tmp_name'], PATH_UPLOAD . $imgPath)) {
                $data['anh'] = $imgPath;
            } else {
                $data['anh'] = $users['anh'];
            }
        }

        $errors = validateCreateUser($data);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['data'] = $data;

            header('location: ' . BASE_URL_ADMIN . '?act=user-create');
            exit();
        }
        $_SESSION['success'] = 'Thao tác thành công';
        insert('taikhoan', $data);

        header('location: ' . BASE_URL_ADMIN . '?act=user');
        exit();
    }

    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}
function validateCreateUser($data)
{
    $errors = [];
    // debug($data);

    // Kiểm tra tên
    if (empty($data['ten'])) {
        $errors['ten'] = 'Trường tên là bắt buộc';
    } else if (strlen($data['ten']) > 50) {
        $errors['ten'] = 'Tên chỉ cho phép tối đa 50 ký tự';
    } else if (!checkUniNameUser('taikhoan', $data['ten'])) {
        $errors['ten'] = 'Tên đã được sử dụng';
    }

    // Kiểm tra email
    if (empty($data['email'])) {
        $errors['email'] = 'Trường email là bắt buộc';
    } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ';
    } else if (!checkUniEmail('taikhoan', $data['email'])) {
        $errors['email'] = 'Email đã được sử dụng';
    }

    // Kiểm tra mật khẩu
    if (empty($data['matkhau'])) {
        $errors['matkhau'] = 'Trường mật khẩu là bắt buộc';
    } else if (strlen($data['matkhau']) < 6) {
        $errors['matkhau'] = 'Mật khẩu phải có ít nhất 6 ký tự';
    }

    // Kiểm tra số điện thoại
    if (!empty($data['sodienthoai']) && !preg_match('/^[0-9]{10,15}$/', $data['sodienthoai'])) {
        $errors['sodienthoai'] = 'Số điện thoại không hợp lệ';
    }

    // Kiểm tra địa chỉ
    if (empty($data['diachi'])) {
        $errors['diachi'] = 'Trường địa chỉ là bắt buộc';
    }

    // Kiểm tra trạng thái
    if ($data['trangthai'] === null) {
        $errors[] = 'Trường trạng thái là bắt buộc';
    } else if (!in_array($data['trangthai'], [0, 1])) {
        $errors[] = 'Trường trạng thái không phải là admin hay member';
    }

    return $errors;
}
function userShowOne($id)
{
    $users = showOne('taikhoan', $id);
    $title = 'Thông tin: ' . $users['ten'];
    $listorderOne = ListorderOne($id);

    // Khởi tạo biến $listorderOne nếu hàm ListorderOne() trả về null
    if (is_null($listorderOne)) {
        $listorderOne = [];
    }

    $title = 'Đơn hàng: ' . $users['ten'];
    $listorderhistory = UserOrderHistory($id, '8');
    $title = 'Lịch sử mua của  ' . $users['ten'];
    $view = 'users/show';
    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}

function userUpdate($id)
{
    $users = showOne('taikhoan', $id);
    $title = 'Cập nhật tài khoản: ' . $users['ten'];
    $view = 'users/update';

    if (!empty($_POST)) {
        $data = [
            "ten" => $_POST['ten'] ?? null,
            "email" => $_POST['email'] ?? null,
            "matkhau" => $_POST['matkhau'] ?? null,
            "sodienthoai" => $_POST['sodienthoai'] ?? null,
            "ngaysinh" => $_POST['ngaysinh'] ?? null,
            "diachi" => $_POST['diachi'] ?? null,
            "trangthai" => $_POST['trangthai'] ?? null,
        ];

        $img = $_FILES['anh'] ?? null;

        if (!empty($img)) {
            $imgPath = 'upload/user/' . time() . '-' . basename($img['name']);
            if (move_uploaded_file($img['tmp_name'], PATH_UPLOAD . $imgPath)) {
                $data['anh'] = $imgPath;
            } else {
                $data['anh'] = $users['anh'];
            }
        }
        $errors = validateUpdateUser($id, $data);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['data'] = $data;
        } else {
            update('taikhoan', $id, $data);

            $_SESSION['success'] = 'Thao tác thành công';
        }

        header('location: ' . BASE_URL_ADMIN . '?act=user-update&id=' . $id);
        exit();
    }
    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}
function validateUpdateUser($id, $data)
{
    $errors = [];
    // debug($data);

    // Kiểm tra tên
    if (empty($data['ten'])) {
        $errors['ten'] = 'Trường tên là bắt buộc';
    } else if (strlen($data['ten']) > 50) {
        $errors['ten'] = 'Tên chỉ cho phép tối đa 50 ký tự';
    }

    // Kiểm tra email
    if (empty($data['email'])) {
        $errors['email'] = 'Trường email là bắt buộc';
    } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ';
    } else if (!checkUniEmailUpdate('taikhoan', $id, $data['email'])) {
        $errors['email'] = 'Email đã được sử dụng';
    }

    // Kiểm tra mật khẩu
    if (empty($data['matkhau'])) {
        $errors['matkhau'] = 'Trường mật khẩu là bắt buộc';
    } else if (strlen($data['matkhau']) < 6) {
        $errors['matkhau'] = 'Mật khẩu phải có ít nhất 6 ký tự';
    }

    // Kiểm tra số điện thoại
    if (!empty($data['sodienthoai']) && !preg_match('/^[0-9]{10,15}$/', $data['sodienthoai'])) {
        $errors['sodienthoai'] = 'Số điện thoại không hợp lệ';
    }

    // Kiểm tra địa chỉ
    if (empty($data['diachi'])) {
        $errors['diachi'] = 'Trường địa chỉ là bắt buộc';
    }

    // Kiểm tra trạng thái
    if ($data['trangthai'] === null) {
        $errors[] = 'Trường trạng thái là bắt buộc';
    } else if (!in_array($data['trangthai'], [0, 1])) {
        $errors[] = 'Trường trạng thái không phải là admin hay member';
    }

    return $errors;
}

// function userOrder($id) {
//     $view = 'users/show';
//     $users = showOne('taikhoan',$id);
//     $listorderOne = ListorderOne($id);

//     // Khởi tạo biến $listorderOne nếu hàm ListorderOne() trả về null
//     if (is_null($listorderOne)) {
//         $listorderOne = [];
//     }

//     $title = 'Đơn hàng: ' . $users['ten'];

//     require_once PATH_VIEW_ADMIN . 'layouts/master.php';
// }


// function userHistoryOrder($id) {
//     $users = showOne('taikhoan',$id);
//     $listorderhistory = UserOrderHistory($id,'6');
//     $view = 'users/userhistoryorder';
//     $title = 'Lịch sử mua của  ' . $users['ten'];

//     require_once PATH_VIEW_ADMIN . 'layouts/master.php';
// }

function userDelete($id)
{


    if (canDeleteUser($id)) {
        try {
            // Xóa tài khoản
            delete('taikhoan', $id);
            $_SESSION['success'] = 'Xóa tài khoản thành công.';
        } catch (PDOException $e) {
            // Xử lý lỗi
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa tài khoản.';
        }
    }

    $_SESSION['oke'] = 'Thao tác thành công';

    header('location: ' . BASE_URL_ADMIN . '?act=user');
    exit();

    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}
