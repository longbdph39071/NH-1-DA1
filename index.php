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


  



