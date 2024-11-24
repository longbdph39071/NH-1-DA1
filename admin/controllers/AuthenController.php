<?php

function login()
{
    if (!empty($_POST)) {
        authenLogin();
    }
    require_once PATH_VIEW_ADMIN . 'authen/login.php';
}

function authenLogin()
{
    $user = getAdmin($_POST['email'], $_POST['password']);

    if (empty($user)) {
        $_SESSION['error'] = 'Email or password is incorrect';
        header('Location: ' . BASE_URL_ADMIN . '?act=login');
        exit();
    }

    // Lưu thông tin người dùng vào session
    $_SESSION['user'] = $user;

    header('Location: ' . BASE_URL_ADMIN);
}
function logout()
{
    if (!empty($_SESSION['user'])) {
        session_destroy();
    }
    header('Location: ' . BASE_URL);
    exit();
}

function admindetail()
{
    $title = 'Thông tin tài khoản';
    $view = 'authen/admindetail';

    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $ten = $user['ten'];
        $anh = $user['anh']; 
        $email = $user['email'];
        $diachi = $user['diachi'];
        $matkhau = $user['matkhau'];
        $sodienthoai = $user['sodienthoai'];
        $ngaysinh = $user['ngaysinh'];

    }

    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}

function getUserInfo() {
    if (isset($_SESSION['user'])) {
        return $_SESSION['user'];
    }
    return null;
}
