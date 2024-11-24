<?php
session_start();
require './commons/env.php';
require './commons/helper.php';
require './commons/connect.php';
require './commons/model.php';

require_file(PATH_CONTROLLER);
require_file(PATH_MODELS);



// Điều hướng
$act = $_GET['act'] ?? '/';

// Chuyển hướng
adminUser_check($act);

$arrNeedAuth = [
    'cart-add',
    'cart',
    'cart-inc',
    'cart-dec',
    'cart-del',
];

middleware_auth_check($act, $arrNeedAuth);

match ($act) {
    // CRUD Trang chủ 
    '/' => Homeindex(),

    '404' => notFound(),

    // CRUD Danh mục
    'category' => listCatePro($_GET['id']),

    // CRUD Giới thiệu
    'about' => About(),

    // CRUD Tin tức
    'blog' => Blog(),

    // CRUD Liên hệ
    'contact' => Contact(),

    // CRUD đon hàng
    'cart-add' => cartAdd($_GET['productID'], $_GET['quantity']),
    'cart' => cartList(),
    'cart-inc' => cartInc($_GET['productID']),
    'cart-dec' => cartDec($_GET['productID']), 
    'cart-del' => cartDel($_GET['productID']),

    // CRUD đơn hàng
    'order-checkout' => orderCheckout(),
    'order-purcharse' => orderPurchase(),
    'order-success' => orderSuccess(),
    'order-nhanhang' => ordernhanhang($_GET['id']),
    'momopayment' => momopayment(),


    
    // CRUD Chi tiết sản phẩm
    'produc' => shopListAll(),
    'singer-detail' => singerDetail($_GET['id']),
    
    // CRUD Trang admin của người dùng
    'admin-client' => adminUser(),
    'history-order' => historyOrder($_GET['id']),
    'detail-order' => detailOrder($_GET['id']),
    'detail-order-delete' => deleteOrderUser($_GET['id']),


    // CRUD Login
    'login' => loginuser(),
    'logout' => logoutuser(),
    'register' => registeruser(),
    

};



require './commons/disconect.php';
