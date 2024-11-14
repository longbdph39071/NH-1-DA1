<?php

function orderCheckout()
{
    $view = 'checkout';
    $title = ' - Thanh toán';
    $thanhtoan = listAll('thanhtoan');
    require_once PATH_VIEW . 'layouts/master.php';
}
if (!function_exists('orderPurchase')) {
    function orderPurchase()
    {
        try {
            if (!empty($_POST) && !empty($_SESSION['cart'])) {
                if (isset($_POST['payment'])) {
                    $id_thanhtoan = $_POST['payment']; // Lấy giá trị phương thức thanh toán từ POST
                } else {
                    throw new Exception("No payment method selected.");
                }

                $data = [
                    'ten' => $_POST['ten'],
                    'email' => $_POST['email'],
                    'sodienthoai' => $_POST['sodienthoai'],
                    'diachi' => $_POST['diachi'],
                    'id_taikhoan' => $_SESSION['user']['id'],
                    'tongtien' => caculator_order_total(),
                    'id_trangthai' => id_trangthai_chuaxacnhan,
                    'id_trangthaithanhtoan' => id_trangthaithanhtoan_chuathanhtoan,
                    'id_thanhtoan' => $id_thanhtoan
                ];



                // Tìm id_sanpham đầu tiên trong giỏ hàng và gán vào $data['id_sanpham']
                foreach ($_SESSION['cart'] as $productID => $item) {
                    $data['id_sanpham'] = $productID;
                    break; // Đảm bảo chỉ lấy id_sanpham của sản phẩm đầu tiên trong giỏ hàng
                }

                // Kiểm tra xem $data['id_sanpham'] có giá trị không
                if (empty($data['id_sanpham'])) {
                    throw new Exception("No product found in the cart or invalid product ID.");
                }

                // Insert into 'donhang' table
                $order_id = insert_get_last_id('donhang', $data);

                // Loop through each product in cart and insert into 'chitiet_donhang' table
                foreach ($_SESSION['cart'] as $productID => $item) {
                    $orderItem = [
                        'id_donhang'   => $order_id,
                        'id_sanpham'   => $productID,
                        'soluong'      => $item['soluong'],
                        'price'        => $item['gia_sale'] ?: $item['gia'],
                    ];
                    insert('chitiet_donhang', $orderItem);
                }

                // Clean up cart after order
                deleteCartitemByCartID($_SESSION['cartId'], $productID);
                delete2('giohang', $_SESSION['cartId']);

                unset($_SESSION['cart']);
                unset($_SESSION['cartId']);
            }
            header('Location:' . BASE_URL . '?act=order-success');
            exit();
        } catch (\Exception $e) {
            debug($e);
        }
    }
}
function orderSuccess()
{
    $view = 'order-success';
    $title = ' - Đặt hàng thành công';
    require_once PATH_VIEW . 'layouts/master.php';
}
