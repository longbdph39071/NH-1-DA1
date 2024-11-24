<?php
session_start();

require '../commons/env.php';
require '../commons/helper.php';
require '../commons/connect.php';
require '../commons/model.php';

require_file(PATH_CONTROLLER_ADMIN);
require_file(PATH_MODELS_ADMIN);

// Điều hướng
$act = $_GET['act'] ?? '/';

// Kiểm tra điều hướng
authen_check($act);

match ($act) {
    // Admin
    '/' => dashboard(),

    // Authen
    'login' => login(),
    'logout' => logout(),
    'admin-detail' => admindetail(),

    // CRUD Danh mục 
    'category' => categoryListAll(),
    'category-detail' => categoryShowOne($_GET['id']),
    'category-create' => categoryCreate(),
    'category-update' => categoryUpdate($_GET['id']),
    'category-delete' => categoryDelete($_GET['id']),

    // CRUD Sản phẩm
    'produc' => producListAll(),
    'produc-create' => producCreate(),
    'produc-detail' => producShowOne($_GET['id']),
    'produc-update' => producUpdate($_GET['id']),
    'produc-delete' => producDelete($_GET['id']),

    // CRUD Thuộc tính và Biến thể
    'attributes' => Attributes(),
    'attributes-delete' => AttributesDelete($_GET['id']),
    'variant-delete' => deleteVariant($_GET['id']),


    // CRUD Tài khoản
    'user' => userListAll(),
    'user-create' => userCreate(),
    'user-show' => userShowOne($_GET['id']),
    'user-update' => userUpdate($_GET['id']),
    'user-delete' => userDelete($_GET['id']),
    // 'user-order' => userOrder($_GET['id']),
    // 'user-history-order' => userHistoryOrder($_GET['id']),

    // CRUD Bình luận
    'comment' => commentListAll(),
    'hide-comment' => HideComment($_GET['id']),
    'comment-delete' => commentDelete($_GET['id']),
    
    
    // CRUD Đơn hàng
    'manage-order' => manageOrder(),
    'manage-order-show' => manageOrderShowdetail($_GET['id']),
    'manage-order-update' => manageOrderUpdate($_GET['id']),
    'manage-order-delete' => manageOrderdelete($_GET['id']),
    'manage-order-xuly' => manageOrderxuly($_GET['id']),


};

require '../commons/disconect.php';