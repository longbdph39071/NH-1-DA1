<?php

function categoryListAll()
{
    $title = 'Danh sách danh mục';
    $view = 'category/index';
    $scrips = 'datatable';
    $scrips2 = 'category/scrips';
    $style = 'datatable';

    $category = listAll('danhmuc');

    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}

function categoryCreate()
{
    $title = 'Thêm mới danh mục';
    $view = 'category/create';
    $category = listAll('danhmuc');
    if (!empty($_POST)) {
        $data = [
            "ten_danhmuc" => $_POST['ten_danhmuc'],
            "anh_danhmuc" => '',  // Khởi tạo giá trị rỗng cho ảnh       
        ];

        $img = $_FILES['anh_danhmuc'] ?? null;

        if (!empty($img) && $img['error'] == 0) {
            $imgPath = 'upload/cate/' . time() . '-' . basename($img['name']);
            if (move_uploaded_file($img['tmp_name'], PATH_UPLOAD . $imgPath)) {
                $data['anh_danhmuc'] = $imgPath;
            } else {
                $data['anh_danhmuc'] = $category['anh_danhmuc'];
            }
        }
        $errors = validateCreateCate($data);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['data'] = $data;

            header('location: ' . BASE_URL_ADMIN . '?act=category-create');
            exit();
        }
        $_SESSION['success'] = 'Thao tác thành công';
        insert('danhmuc', $data);
        header('Location: ' . BASE_URL_ADMIN . '?act=category');
        exit();
    }
    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}

function validateCreateCate($data)
{
    $errors = [];
    // debug($data);

    if (empty($data['ten_danhmuc'])) {
        $errors[] = 'Trường tên danh mục là bắt buộc';
    } else if (strlen($data['ten_danhmuc']) > 50) {
        $errors[] = 'Trường tên danh mục chỉ cho phép tối đa 50 ký tự';
    } else if (!checkUniName('danhmuc', $data['ten_danhmuc'])) {
        $errors[] = 'Tên danh mục đã được sử dụng';
    }

    return $errors;
}
function categoryShowOne($id)
{
    $category = showOne('danhmuc', $id);
    // if(empty($category)){
    //     e404();
    // }
    $title = 'Danh sach danh muc' . $category['ten_danhmuc'];
    $view = 'category/show';
    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}
function categoryUpdate($id)
{
    $category = showOne('danhmuc', $id);
    // if(empty($category)){
    //     e404();
    // }
    if (!empty($_POST)) {
        $data = [
            "ten_danhmuc" => $_POST['ten_danhmuc'] ?? null,
        ];

        $img = $_FILES['anh_danhmuc'] ?? null;

        if (!empty($img) && $img['error'] == 0) {
            $imgPath = 'upload/cate/' . time() . '-' . basename($img['name']);
            if (move_uploaded_file($img['tmp_name'], PATH_UPLOAD . $imgPath)) {
                $data['anh_danhmuc'] = $imgPath;
            } else {
                $data['anh_danhmuc'] = $category['anh_danhmuc'];
            }
        }
        $errors = validateCateUpdate($id, $data);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['data'] = $data;

            header('Location: ' . BASE_URL_ADMIN . '?act=category-update&id=' . $id);
            exit();
        }
        $_SESSION['success'] = 'Thao tác thành công';
        update('danhmuc', $id, $data);
        header('Location: ' . BASE_URL_ADMIN . '?act=category-update&id=' . $id);
        exit();
    }
    $title = 'Danh sach danh muc';
    $view = 'category/update';
    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}

function validateCateUpdate($id, $data)
{

    $errors = [];

    if (empty($data['ten_danhmuc'])) {
        $errors[] = 'Trường name là bắt buộc';
    } else if (strlen($data['ten_danhmuc']) > 50) {
        $errors[] = 'Trường name độ dài tối đa';
    } else if (!validateCreateCateUpdate('danhmuc', $id, $data['ten_danhmuc'])) {
        $errors[] = 'Name đã được sử dụng';
    };

    return $errors;
}

function categoryDelete($id)
{
    $_SESSION['oke'] = 'Thao tác thành công';
    
    delete('danhmuc', $id);
    header('Location: ' . BASE_URL_ADMIN . '?act=category');
    exit();
    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}
