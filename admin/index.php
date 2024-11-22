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