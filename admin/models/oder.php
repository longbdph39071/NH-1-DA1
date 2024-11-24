<?php

// Show danh sách đơn hàng
if (!function_exists('Listorder')) {
    function Listorder()
    {
        try {
            $sql = "SELECT dh.id, dh.ngaydathang, tk.ten AS ten_khachhang, dh.diachi, dh.sodienthoai, tt.ten_trangthai, dh.tongtien 
                    FROM donhang dh
                    INNER JOIN taikhoan tk ON dh.id_taikhoan = tk.id
                    INNER JOIN trangthai_donhang tt ON dh.id_trangthai = tt.id
                    WHERE dh.deleted_at IS NULL
                    ";
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về tất cả các dòng kết quả dưới dạng mảng kết hợp
        } catch (\Exception $e) {
            debug($e);
        }
    }
}
// Show ra chi tiết đơn hàng
if (!function_exists('ListorderShowOne')) {
    function ListorderShowOne($id)
    {
        try {
            // Query to retrieve order details
            $sql = "SELECT donhang.id, 
                           donhang.ngaydathang, 
                           donhang.diachi,
                           donhang.sodienthoai,
                           taikhoan.ten AS ten_khachhang, 
                           taikhoan.id AS id_taikhoan,
                           trangthai_donhang.id AS id_trangthai,  -- Alias for id_trangthai
                           trangthai_donhang.ten_trangthai, 
                           donhang.tongtien, 
                           thanhtoan.id AS id_thanhtoan,  -- Alias for id_thanhtoan
                           thanhtoan.phuongthuc 
                    FROM donhang 
                    INNER JOIN taikhoan ON donhang.id_taikhoan = taikhoan.id
                    INNER JOIN trangthai_donhang ON donhang.id_trangthai = trangthai_donhang.id
                    INNER JOIN thanhtoan ON donhang.id_thanhtoan = thanhtoan.id
                    WHERE donhang.id = :order_id";

            // Prepare SQL statement
            $stmt = $GLOBALS['conn']->prepare($sql);

            // Bind parameter
            $stmt->bindParam(':order_id', $id, PDO::PARAM_INT); // Assuming $id is an integer

            // Execute query
            $stmt->execute();

            // Fetch single row as associative array
            $orderDetail = $stmt->fetch(PDO::FETCH_ASSOC);

            return $orderDetail; // Return order detail as associative array
        } catch (\Exception $e) {
            debug($e); // Handle exceptions (you can log or handle differently)
            return null; // Return null or handle error case as appropriate
        }
    }
}
// Show sản phẩm 
function GetProductsFromOrder($id)
{
    try {

        // Chuẩn bị câu truy vấn SQL để lấy thông tin sản phẩm của đơn hàng
        $sql = "SELECT sp.id AS id_sanpham, sp.ten, sp.gia, doi.soluong
                FROM sanpham sp
                JOIN chitiet_donhang doi ON sp.id = doi.id_sanpham
                WHERE doi.id_donhang = :id";

        // Chuẩn bị câu truy vấn
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Lấy danh sách sản phẩm của đơn hàng dưới dạng mảng kết hợp
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products; // Trả về danh sách sản phẩm
    } catch (\Exception $e) {
        // Xử lý các ngoại lệ (ghi log hoặc xử lý khác)
        debug($e->getMessage());
        return null; // Trả về null hoặc xử lý trường hợp lỗi phù hợp
    }
}
// Update đơn hàng 
function ListorderUpdate($id) {

}

function GetPaymentMethods()
{
    try {
        // SQL query to fetch payment methods
        $sql = "SELECT id, phuongthuc FROM thanhtoan";

        // Prepare SQL statement
        $stmt = $GLOBALS['conn']->prepare($sql);

        // Execute query
        $stmt->execute();

        // Fetch all rows as associative array
        $paymentMethods = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $paymentMethods; // Return array of payment methods
    } catch (\Exception $e) {
        debug($e); // Handle exceptions (you can log or handle differently)
        return []; // Return empty array or handle error case as appropriate
    }
}
function GetOrderStatuses()
{
    try {
        // SQL query to fetch order statuses
        $sql = "SELECT id, ten_trangthai FROM trangthai_donhang";

        // Prepare SQL statement
        $stmt = $GLOBALS['conn']->prepare($sql);

        // Execute query
        $stmt->execute();

        // Fetch all rows as associative array
        $orderStatuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $orderStatuses; // Return array of order statuses
    } catch (\Exception $e) {
        debug($e); // Handle exceptions (you can log or handle differently)
        return []; // Return empty array or handle error case as appropriate
    }
}
// Xóa đơn hàng 
function deleteOrder($id) {
    try {
        // Query to check order status
        $sqlCheck = "SELECT id_trangthai FROM donhang WHERE id = :id";
        $stmtCheck = $GLOBALS['conn']->prepare($sqlCheck);
        $stmtCheck->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtCheck->execute();
        $orderStatus = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        // Check if order status allows deletion
        if ($orderStatus['id_trangthai'] == 7 || $orderStatus['id_trangthai'] == 9) { // 7: Hủy đơn, 9: Đơn lỗi
            // Soft delete order
            $sqlDelete = "UPDATE donhang SET deleted_at = NOW() WHERE id = :id";
            $stmtDelete = $GLOBALS['conn']->prepare($sqlDelete);
            $stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtDelete->execute();

            return 'deleted'; // Đánh dấu là xóa thành công
        } else {
            return 'not_allowed'; // Đánh dấu là không được phép xóa
        }
    } catch (\Exception $e) {
        debug($e->getMessage());
        return 'error'; // Đánh dấu là lỗi xảy ra
    }
}
