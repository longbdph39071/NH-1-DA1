<?php

function  manageOrder()
{
    $view = 'manageorder/index';
    $title = 'Danh sách đơn hàng';
    $scrips = 'datatable';
    $scrips2 = 'manageorder/scrips';
    $style = 'datatable';

    $manageorder = Listorder('donhang');

    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}

function  manageOrderShowdetail($id)
{
    $view = 'manageorder/detail-order';
    $scrips = 'datatable';
    $scrips2 = 'manageorder/scrips';
    $style = 'datatable';

    $manageorderShowOne = ListorderShowOne($id);
    $ListorderShowOneSP = GetProductsFromOrder($id);


    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}
function manageOrderUpdate($id)
{
    $view = 'manageorder/update-order';
    $scrips = 'datatable';
    $scrips2 = 'manageorder/scrips';
    $style = 'datatable';

    $manageorderShowOne = ListorderShowOne($id);
    $manageorderUpdate = ListorderUpdate($id);
    $ListorderShowOneSP = GetProductsFromOrder($id);
    $updateOrderpayment = GetPaymentMethods();
    $updateOrderstatus = GetOrderStatuses();

    if (!empty($_POST)) {
        $data = [
            'ngaydathang' =>  $_POST['ngaydathang'] ?? null,
            'id_thanhtoan' =>  $_POST['id_thanhtoan'] ?? null,
            'id_trangthai' =>  $_POST['id_trangthai'] ?? null,
            'diachi' =>  $_POST['diachi'] ?? null,
        ];
        $currentStatus = $manageorderShowOne['id_trangthai'];
        $newStatus = $data['id_trangthai'];
        
        // Các trạng thái không được phép thay đổi
        $lockedStatuses = [id_trangthai_huy, id_trangthai_thatbai]; // Thay id_trangthai_huy và id_trangthai_thatbai bằng giá trị tương ứng

        // Kiểm tra nếu trạng thái hiện tại là "Hủy" hoặc "Thất bại"
        if (in_array($currentStatus, $lockedStatuses)) {
            $_SESSION['error'] = 'Đơn hàng đã ở trạng thái không thể thay đổi.';
            header('location: ' . BASE_URL_ADMIN . '?act=manage-order-update&id=' . $id);
            exit();
        }

        // Kiểm tra nếu trạng thái hiện tại là "Xác nhận" và trạng thái mới khác trạng thái hiện tại
        if ($currentStatus == id_trangthai_xacnhan && $newStatus == id_trangthai_chuaxacnhan) {
            $_SESSION['error'] = 'Không thể chuyển trạng thái từ "Xác nhận" về "Chờ xác nhận".';
            header('location: ' . BASE_URL_ADMIN . '?act=manage-order-update&id=' . $id);
            exit();
        }

        update('donhang', $id, $data);
        $_SESSION['message'] = 'Cập nhật đơn hàng thành công.';
        header('location: ' . BASE_URL_ADMIN . '?act=manage-order-update&id=' . $id);
        exit();
    }


    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}
function manageOrderxuly($id) {
    if(isset($id)) {
        // Lấy thông tin đơn hàng hiện tại
        $order = ListorderShowOne($id);
        $currentStatus = $order['id_trangthai'];

        // Nếu trạng thái hiện tại là "Chưa xác nhận", cho phép xác nhận đơn hàng
        if($currentStatus == id_trangthai_chuaxacnhan) {
            // Cập nhật trạng thái đơn hàng thành "Đã xác nhận"
            $data = [
                'id_trangthai' => id_trangthai_xacnhan,
                'ngaydathang' => date('Y-m-d H:i:s') // Thêm ngày xác nhận
            ];
            update('donhang', $id, $data);

            // Thông báo thành công
            $_SESSION['message'] = 'Cập nhật đơn hàng thành công.';
        } else {
            // Nếu trạng thái không phải là "Chưa xác nhận", thông báo lỗi
            $_SESSION['error'] = "Đơn hàng không thể xác nhận do trạng thái hiện tại không hợp lệ.";
        }

        // Chuyển hướng về trang quản lý đơn hàng
        header('location: ' . BASE_URL_ADMIN . '?act=manage-order');
        exit();
    } else {
        // Nếu không có ID, thông báo lỗi
        $_SESSION['error'] = "Không tìm thấy đơn hàng.";
        header('location: ' . BASE_URL_ADMIN . '?act=manage-order');
        exit();
    }
}
function manageOrderdelete($id)
{
    $result = deleteOrder($id);  
    
    if ($result === 'deleted') {
        $_SESSION['message'] = "Đơn hàng đã được xóa thành công.";
    } elseif ($result === 'not_allowed') {
        $_SESSION['error'] = "Đơn hàng không thể được xóa vì đang ở trạng thái thành công.";
    } else {
        $_SESSION['error'] = "Đã xảy ra lỗi khi xóa đơn hàng.";
    }
    header('location: ' . BASE_URL_ADMIN . '?act=manage-order');
    exit();
}
