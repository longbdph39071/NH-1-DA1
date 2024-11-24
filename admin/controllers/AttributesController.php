<?php
function Attributes()
{
    $view = 'produc/attributes';
    $attribut = listAll('thuoctinh');

    // Khởi tạo biến $variants
    $variants = [];

    // Truy xuất các biến thể từ cơ sở dữ liệu
    foreach ($attribut as $attr) {
        $attr_id = $attr['id'];
        $variants[$attr_id] = listVariantsByAttribute($attr_id);
    }

    if (!empty($_POST)) {
        if (isset($_POST['add_attribute'])) {
            // Thêm mới thuộc tính
            $ten_thuoctinh = $_POST['ten_thuoctinh'];
            $data = ['ten_thuoctinh' => $ten_thuoctinh];
            insertAttribu('thuoctinh', $data);

            header('location: ' . BASE_URL_ADMIN . '?act=attributes');
            exit();
        } elseif (isset($_POST['add_variant'])) {
            // Thêm biến thể vào thuộc tính
            $id_thuoctinh = $_POST['id_thuoctinh'];
            $gia_tri_thuoctinh = $_POST['gia_tri_thuoctinh'];
            $gia = $_POST['gia'];

            // Kiểm tra giá trị thuộc tính
            if (empty($gia_tri_thuoctinh)) {
                echo "Vui lòng nhập giá trị thuộc tính.";
                return;
            }

            // Tách các giá trị thuộc tính thành mảng
            $gia_tri_array = explode(',', $gia_tri_thuoctinh);
            $gia_array = explode(',', $gia);

            // Lưu các giá trị thuộc tính vào bảng `bien_the`
            foreach ($gia_tri_array as $index => $value) {
                $value_data = [
                    'id_thuoctinh' => $id_thuoctinh,
                    'value' => trim($value),
                ];

                // Insert attribute value
                insertVariant($value_data);
            }

            // Cập nhật lại biến variants sau khi thêm mới
            $variants[$id_thuoctinh] = listVariantsByAttribute($id_thuoctinh);

            header('location: ' . BASE_URL_ADMIN . '?act=attributes');
            exit();
        }
    }

    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}



function AttributesDelete($id)
{

    deleteAttributes($id);

    header('location: ' . BASE_URL_ADMIN . '?act=attributes');
    exit();
}

function deleteVariant($id)
{
    deleteAttriVariant($id);

    header('location: ' . BASE_URL_ADMIN . '?act=attributes');
    exit();
}
