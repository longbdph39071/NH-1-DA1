<?php

// Khai báo hàm dùng Global
if (!function_exists('require_file')) {
    function require_file($pathFolder)
    {
        $files = array_diff(scandir($pathFolder), ['.', '..']);

        foreach ($files as $file) {
            require_once $pathFolder . $file;
        }
    }
}

if (!function_exists('debug')) {
    function debug($data)
    {
        echo "<pre>";
        print_r($data);
        die;
    }
}
if (!function_exists('e404')) {
    function e404($data)
    {
        echo "404 NOT FOUND";
        die;
    }
}


if (!function_exists('authen_check')) {
    function authen_check($act)
    {
        // Nếu hành động là login, kiểm tra xem người dùng đã đăng nhập chưa
        if ($act == 'login') {
            if (!empty($_SESSION['user'])) {
                header('Location: ' . BASE_URL_ADMIN);
                exit();
            }
        } else {
            // Kiểm tra xem người dùng đã đăng nhập chưa
            if (empty($_SESSION['user'])) {
                header('Location: ' . BASE_URL_ADMIN . '?act=login');
                exit();
            }

            // Kiểm tra quyền của người dùng
            $user = $_SESSION['user'];

            // Kiểm tra xem người dùng có phải là admin hay không
            if ($user['trangthai'] != 1) { // Assuming 'trangthai' is the column for role
                // Nếu người dùng không phải admin và đang cố gắng truy cập vào trang admin
                header('Location: ' . BASE_URL . '?act=404');
                exit();
            }
        }
    }
}
if (!function_exists('adminUser_check')) {
    function adminUser_check($act)
    {
        if ($act == 'admin-user') {
            if (!empty($_SESSION['user'])) {
                header('Location: ' . BASE_URL . '?act=admin-user');
                exit();
            }
        }
    }
}
if (!function_exists('middleware_auth_check')) {
    function middleware_auth_check($act, $arrRouteNeedAuth) {
        if ($act == 'login') {
            if (!empty($_SESSION['user'])) {
                header('Location: ' . BASE_URL);
                exit();
            } elseif (empty($_SESSION['user']) && in_array($act, $arrRouteNeedAuth)) {
                header('Location: ' . BASE_URL . '?act=login');
                exit();
            }
        } elseif (in_array($act, $arrRouteNeedAuth) && empty($_SESSION['user'])) {
            // Nếu người dùng chưa đăng nhập và cố gắng truy cập hành động yêu cầu đăng nhập
            $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
            header('Location: ' . BASE_URL . '?act=login');
            exit();
        }
    }
}

if (!function_exists('caculator_order_total')) {
    function caculator_order_total() {
        if (isset($_SESSION['cart'])) {
            $total = 0;
            foreach($_SESSION['cart'] as $item) {
                $price = ($item['gia_sale'] ?: $item['gia']);
                $total += $price * $item['soluong'];
            }
            return $total; // Trả về tổng tiền chưa định dạng
        }
        return 0;
    }
    
}

