<?php
if (!function_exists('ListorderOne')) {
    function ListorderOne($id_taikhoan)
    {
        try {
            // Prepare the SQL query
            $sql = "SELECT dh.id, dh.ngaydathang, tk.ten AS ten_khachhang, tk.diachi, tk.sodienthoai, tt.ten_trangthai, dh.tongtien 
                    FROM donhang dh
                    INNER JOIN taikhoan tk ON dh.id_taikhoan = tk.id
                    INNER JOIN trangthai_donhang tt ON dh.id_trangthai = tt.id
                    WHERE tk.id = :id_taikhoan"; // Filter orders by customer ID

            // Prepare and execute the statement
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(':id_taikhoan', $id_taikhoan, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch all rows as associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            // Handle exceptions
            debug($e);
            return []; // Return empty array on error
        }
    }
}
if (!function_exists('UserOrderHistory')) {
    function UserOrderHistory($id_taikhoan, $id_trangthai)
    {
        try {
            // Prepare the SQL query
            $sql = "SELECT dh.id, dh.ngaydathang, tk.ten AS ten_khachhang, tk.diachi, tk.sodienthoai, tt.ten_trangthai, dh.tongtien 
                    FROM donhang dh
                    INNER JOIN taikhoan tk ON dh.id_taikhoan = tk.id
                    INNER JOIN trangthai_donhang tt ON dh.id_trangthai = tt.id
                    WHERE tk.id = :id_taikhoan
                    AND dh.id_trangthai = :id_trangthai";

            // Prepare and execute the statement
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(':id_taikhoan', $id_taikhoan, PDO::PARAM_INT);
            $stmt->bindParam(':id_trangthai', $id_trangthai, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch all rows as associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            // Handle exceptions
            debug($e);
            return []; // Return empty array on error
        }
    }
}
if (!function_exists('ListorderOnel')) {
    function ListorderOnel($id_taikhoan)
    {
        try {
            // Prepare the SQL query
            $sql = "SELECT 
            dh.id, 
            dh.ngaydathang, 
            dh.sodienthoai, 
            dh.diachi,
            dh.deleted_at,
            dh.ten, 
            tt.ten_trangthai, 
            dh.tongtien 
                    FROM donhang dh
                    INNER JOIN taikhoan tk ON dh.id_taikhoan = tk.id
                    INNER JOIN trangthai_donhang tt ON dh.id_trangthai = tt.id
                    WHERE tk.id = :id_taikhoan AND dh.deleted_at IS NULL"; // Filter orders by customer ID

            // Prepare and execute the statement
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(':id_taikhoan', $id_taikhoan, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch all rows as associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            // Handle exceptions
            debug($e);
            return []; // Return empty array on error
        }
    }
}
if (!function_exists('ListorderShowOne')) {
    function ListorderShowOne($id)
    {
        try {
            // Query to retrieve order details
            $sql = "SELECT donhang.id, 
                           donhang.ngaydathang, 
                           taikhoan.ten AS ten_khachhang, 
                           taikhoan.id AS id_taikhoan,
                           taikhoan.diachi, 
                           taikhoan.sodienthoai, 
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