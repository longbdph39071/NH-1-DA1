<?php

function producListAll()
{
    $title = 'Danh sách sản phẩm';
    $view = 'produc/index';
    $scrips = 'datatable';
    $scrips2 = 'produc/scrips';
    $style = 'datatable';

    $produc = listAllForProLi();
    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}

function producCreate()
{
    $view = 'produc/create';
    $category = listAll('danhmuc');
    $pro = listAll('sanpham');
    if (!empty($_POST)) {
        $data = [
            'ten' => $_POST['ten'] ?? null,
            'gia' => (float)$_POST['gia'] ?? null,
            'gia_sale' => (float)$_POST['giamgia'] ?? null,
            'soluong' => (int)$_POST['soluong'] ?? null,
            'mota_ngan' => $_POST['motangan'] ?? null,
            'mota' => $_POST['mota'] ?? null,
            'id_danhmuc' => $_POST['id_danhmuc'] ?? null,
            'xuatban' => date('Y-m-d H:i:s'),
        ];

        $img = $_FILES['anh_chinh'] ?? null;

        if (!empty($img)) {
            $imgPath = 'upload/user/' . time() . '-' . basename($img['name']);
            if (move_uploaded_file($img['tmp_name'], PATH_UPLOAD . $imgPath)) {
                $data['anh_chinh'] = $imgPath;
            }
        }

        $id_sanpham = insertPro('sanpham', $data);


        $img = $_FILES['anh'] ?? null;
        if ($img && is_array($img['name'])) {
            $uploadedFiles = [];

            foreach ($img['name'] as $key => $name) {
                $imgPath = 'upload/produc/' . time() . '-' . basename($name);
                if (move_uploaded_file($img['tmp_name'][$key], PATH_UPLOAD . $imgPath)) {
                    $dataimgSP = [
                        'ten_anh' => $imgPath,
                        'id_sanpham' => $id_sanpham,
                    ];
                    $uploadedFiles[] = $imgPath;
                    $id_anhsp = insertPro('anhsp', $dataimgSP);
                    $data['anh'] = $uploadedFiles;
                }
            }
            $dataSanPham = ['id_hinhanh_chinh' => $id_anhsp];
            updatePro('sanpham', $id_sanpham, $dataSanPham);
        }
        $errors = validateCreatePro($data);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['data'] = $data;

            header('location: ' . BASE_URL_ADMIN . '?act=produc-create');
            exit();
        }
        $_SESSION['success'] = 'Thao tác thành công';
        header('Location: ' . BASE_URL_ADMIN . '?act=produc');
        exit();
    }
    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}
function validateCreatePro($data)
{
    $errors = [];

    // Kiểm tra tên sản phẩm
    if (empty($data['ten'])) {
        $errors['ten'] = 'Tên sản phẩm không được để trống.';
    }

    // Kiểm tra giá
    if (empty($data['gia']) || !is_numeric($data['gia']) || $data['gia'] < 0) {
        $errors['gia'] = 'Giá sản phẩm phải là một số dương.';
    }

    // Kiểm tra giá giảm
    if (!empty($data['gia_sale']) && (!is_numeric($data['gia_sale']) || $data['gia_sale'] < 0)) {
        $errors['gia_sale'] = 'Giá giảm phải là một số dương.';
    }

    // Kiểm tra số lượng
    if (empty($data['soluong']) || !is_numeric($data['soluong']) || $data['soluong'] < 0) {
        $errors['soluong'] = 'Số lượng sản phẩm phải là một số nguyên dương.';
    }

    // Kiểm tra mô tả ngắn
    if (empty($data['mota_ngan'])) {
        $errors['mota_ngan'] = 'Mô tả ngắn không được để trống.';
    }

    // Kiểm tra mô tả
    if (empty($data['mota'])) {
        $errors['mota'] = 'Mô tả không được để trống.';
    }

    // Kiểm tra danh mục
    if (empty($data['id_danhmuc']) || !is_numeric($data['id_danhmuc'])) {
        $errors['id_danhmuc'] = 'Danh mục không hợp lệ.';
    }

    return $errors;
}
function producShowOne($id)
{
    $pro = oneForProLi($id);
    $commentshowone = ListshowONEComment('binhluan', $id);

    $view = 'produc/detail';
    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}
function HideComment($id)
{
    $commentshowone = ListshowONEComment('binhluan', $id);  
    // debug($commentshowone['id_sanpham']);
    $pro = oneForProLi($id);

    $hideComment = delete('binhluan', $id);
    header('Location: ' . BASE_URL_ADMIN . '?act=produc-detail&id=' . $commentshowone['id_sanpham']);
    // dù đã truyền id_sanpham ở đây để nó quay lại đúng cái id_sanpham
}
function producUpdate($id)
{
    $view = 'produc/update';
    $pro = oneForProLi($id);
    $thuoctinh = listAll('thuoctinh');
    $category = listAll('danhmuc');
    $title = $pro['ten'];
    $id_sanpham = $pro['id_sanpham'];
    
    $query = "SELECT id_thuoctinh FROM sanpham_thuoctinh WHERE id_sanpham = :id_sanpham";
    $stmt = $GLOBALS['conn']->prepare($query);
    $stmt->execute(['id_sanpham' => $id_sanpham]);
    $selected_thuoctinh = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($_POST)) {
        // Dữ liệu cần cập nhật
        $data = [
            'ten' => $_POST['ten'] ?? $pro['ten'],
            'gia' => $_POST['gia'] ?? $pro['gia'],
            'gia_sale' => $_POST['giamgia'] ?? $pro['gia_sale'],
            'soluong' => $_POST['soluong'] ?? $pro['soluong'],
            'mota_ngan' => $_POST['motangan'] ?? null,
            'mota' => $_POST['mota'] ?? $pro['mota'],
            'id_danhmuc' => $_POST['update_danhmuc'] ?? $pro['id_danhmuc'],
        ];

        // Xử lý ảnh chính
        $imgChinh = $_FILES['anh_chinh'] ?? null;
        if (!empty($imgChinh) && $imgChinh['error'] == 0) {
            $imgPath = 'upload/produc/' . time() . '-' . basename($imgChinh['name']);
            if (move_uploaded_file($imgChinh['tmp_name'], PATH_UPLOAD . $imgPath)) {
                $data['anh_chinh'] = $imgPath;
            }
        }

        // Xử lý xóa hình ảnh đã chọn
        $deleteImages = $_POST['delete_images'] ?? [];
        if (!empty($deleteImages)) {
            foreach ($deleteImages as $imageId) {
                // Lấy thông tin hình ảnh từ bảng anhsp dựa trên ID
                $stmt = $GLOBALS['conn']->prepare("SELECT ten_anh FROM anhsp WHERE id = :id");
                $stmt->execute([':id' => $imageId]);
                $imageInfo = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($imageInfo) {
                    $filePath = PATH_UPLOAD . $imageInfo['ten_anh'];
                    if (file_exists($filePath)) {
                        unlink($filePath); // Xóa tệp tin
                    }
                    // Xóa ảnh khỏi cơ sở dữ liệu
                    $stmt = $GLOBALS['conn']->prepare("DELETE FROM anhsp WHERE id = :id");
                    $stmt->execute([':id' => $imageId]);
                }
            }
        }

        // Xử lý hình ảnh mới
        $img = $_FILES['anh'] ?? null;
        if ($img && is_array($img['name'])) {
            foreach ($img['name'] as $key => $name) {
                if (!empty($name)) {
                    $imgPath = 'upload/produc/' . time() . '-' . basename($name);
                    if (move_uploaded_file($img['tmp_name'][$key], PATH_UPLOAD . $imgPath)) {
                        $dataimgSP = [
                            'ten_anh' => $imgPath,
                            'id_sanpham' => $id,
                        ];
                        insertPro('anhsp', $dataimgSP);
                    }
                }
            }
        }

        // Cập nhật dữ liệu sản phẩm
        update('sanpham', $id, $data);

        // Xử lý thuộc tính sản phẩm
        $selected_thuoctinh = $_POST['thuoctinh'] ?? [];

        // Lấy danh sách thuộc tính hiện tại của sản phẩm
        $stmt = $GLOBALS['conn']->prepare("SELECT id_thuoctinh FROM sanpham_thuoctinh WHERE id_sanpham = :id_sanpham");
        $stmt->execute(['id_sanpham' => $id_sanpham]);
        $current_thuoctinh = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        // Xóa các thuộc tính không còn được chọn của sản phẩm
        foreach ($current_thuoctinh as $thuoctinh_id) {
            if (!in_array($thuoctinh_id, $selected_thuoctinh)) {
                $stmt = $GLOBALS['conn']->prepare("DELETE FROM sanpham_thuoctinh WHERE id_sanpham = :id_sanpham AND id_thuoctinh = :id_thuoctinh");
                $stmt->execute(['id_sanpham' => $id_sanpham, 'id_thuoctinh' => $thuoctinh_id]);
            }
        }

        // Thêm các thuộc tính mới
        foreach ($selected_thuoctinh as $thuoctinh_id) {
            if (!in_array($thuoctinh_id, $current_thuoctinh)) {
                $stmt = $GLOBALS['conn']->prepare("INSERT INTO sanpham_thuoctinh (id_sanpham, id_thuoctinh) VALUES (:id_sanpham, :id_thuoctinh)");
                $stmt->execute(['id_sanpham' => $id_sanpham, 'id_thuoctinh' => $thuoctinh_id]);
            }
        }

        $errors = validateUpdatePro($data);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['data'] = $data;

            header('location: ' . BASE_URL_ADMIN . '?act=produc-update');
            exit();
        }
        $_SESSION['success'] = 'Thao tác thành công';

        header('Location: ' . BASE_URL_ADMIN . '?act=produc-update&id=' . $id);
        exit();
    }

    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}
function validateUpdatePro($data)
{
    $errors = [];

    // Kiểm tra tên sản phẩm
    if (empty($data['ten'])) {
        $errors[] = 'Tên sản phẩm không được để trống.';
    }

    // Kiểm tra giá
    if (!is_numeric($data['gia']) || $data['gia'] <= 0) {
        $errors[] = 'Giá sản phẩm phải là một số dương.';
    }

    // Kiểm tra số lượng
    if (!is_numeric($data['soluong']) || $data['soluong'] < 0) {
        $errors[] = 'Số lượng sản phẩm không hợp lệ.';
    }

    // Kiểm tra danh mục
    if (empty($data['id_danhmuc'])) {
        $errors[] = 'Danh mục sản phẩm không được để trống.';
    }

    return $errors;
}
function producDelete($id)
{

    if (isProductInOrders($id)) {
        $_SESSION['error'] = ['Sản phẩm không thể xóa vì đã được đặt hàng.'];
        header('Location: ' . BASE_URL_ADMIN . '?act=produc');
        exit();
    } else {
        deleteProductWithRelatedImages($id);
        delete('sanpham', $id);
        $_SESSION['success'] = "Thao tác thành công!";
    }
    header('Location: ' . BASE_URL_ADMIN . '?act=produc');
    exit();
}
