<?php

if (!function_exists('getAdmin')) {
    function getAdmin($email, $matkhau)
    {
        try {
            $sql = "SELECT * FROM taikhoan WHERE email = :email AND matkhau = :matkhau AND trangthai = 1 LIMIT 1";

            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":matkhau", $matkhau);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC); // Sử dụng FETCH_ASSOC để lấy mảng liên kết
        } catch (\Throwable $e) {
            debug($e);
        }
    }
}

if (!function_exists('authen_checkAdmin')) {
    function authen_checkAdmin($act)
    {
        // Danh sách các hành động yêu cầu quyền admin
        $admin_actions = [
            'category', 'category-create', 'category-update', 'category-delete',
            'produc', 'produc-create', 'produc-update', 'produc-delete',
            'attributes', 'attributes-delete', 'variant-delete',
            'user', 'user-create', 'user-show', 'user-update', 'user-delete',
            'comment', 'hide-comment', 'comment-delete',
            'manage-order', 'manage-order-show', 'manage-order-update', 'manage-order-delete'
        ];

        // Kiểm tra nếu là trang đăng nhập
        if ($act == 'login') {
            // Nếu đã đăng nhập, chuyển hướng đến trang admin
            if (!empty($_SESSION['user'])) {
                header('Location: ' . BASE_URL_ADMIN);
                exit();
            }
        } elseif (empty($_SESSION['user'])) {
            // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
            header('Location: ' . BASE_URL_ADMIN . '?act=login');
            exit();
        } elseif (in_array($act, $admin_actions)) {
            // Nếu là hành động yêu cầu quyền admin
            if ($_SESSION['user']['trangthai'] !== 1) {
                // Nếu không phải là admin, chuyển hướng đến trang chính
                header('Location: ' . BASE_URL_ADMIN);
                exit();
            }
        }
    }
}

// function getAdminUser($email, $matkhau)
// {
//     try {
//         $sql = "SELECT * FROM taikhoan WHERE email = :email AND matkhau = :matkhau AND trangthai = 0 LIMIT 1";

//         $stmt = $GLOBALS['conn']->prepare($sql);
//         $stmt->bindValue(":email", $email);
//         $stmt->bindValue(":matkhau", $matkhau);
//         $stmt->execute();

//         return $stmt->fetch();
//     } catch (\Throwable $e) {
//         debug($e);
//         return false;
//     }
// }
if (!function_exists('checkUniEmail')) {
    function checkUniEmail($tableName, $email)
    {
        try {

            $sql = "SELECT * FROM $tableName WHERE email = :email LIMIT 1";

            $stmt = $GLOBALS['conn']->prepare($sql);

            $stmt->bindValue(":email", $email);

            $stmt->execute();


            $data = $stmt->fetch();

            return empty($data) ? true : false;
        } catch (\Exception $e) {
            debug($e);
        }
    }
}
if (!function_exists('checkUniEmailUpdate')) {
    function checkUniEmailUpdate($tableName, $id, $email)
    {
        try {

            $sql = "SELECT * FROM $tableName WHERE email = :email AND id <> :id LIMIT 1";

            $stmt = $GLOBALS['conn']->prepare($sql);

            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":id", $id);


            $stmt->execute();


            $data = $stmt->fetch();

            return empty($data) ? true : false;
        } catch (\Exception $e) {
            debug($e);
        }
    }
}
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
if (!function_exists('checkUniNameUser')) {
    function checkUniNameUser($tableName, $name)
    {
        try {
            $sql = "SELECT * FROM $tableName WHERE ten = :ten LIMIT 1";

            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindValue(":ten", $name);
            $stmt->execute();

            $data = $stmt->fetch();

            return empty($data) ? true : false;
        } catch (\Exception $e) {
            debug($e);
            return false; // Trả về false khi có lỗi
        }
    }
}

if (!function_exists('checkUniEmail')) {
    function checkUniEmail($tableName, $email)
    {
        try {

            $sql = "SELECT * FROM $tableName WHERE email = :email LIMIT 1";

            $stmt = $GLOBALS['conn']->prepare($sql);

            $stmt->bindValue(":email", $email);

            $stmt->execute();


            $data = $stmt->fetch();

            return empty($data) ? true : false;
        } catch (\Exception $e) {
            debug($e);
        }
    }
}
if (!function_exists('checkUniEmailUpdate')) {
    function checkUniEmailUpdate($tableName, $id, $email)
    {
        try {

            $sql = "SELECT * FROM $tableName WHERE email = :email AND id <> :id LIMIT 1";

            $stmt = $GLOBALS['conn']->prepare($sql);

            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":id", $id);


            $stmt->execute();


            $data = $stmt->fetch();

            return empty($data) ? true : false;
        } catch (\Exception $e) {
            debug($e);
        }
    }
}
function canDeleteUser($userId)
{
    try {
        // Kiểm tra xem tài khoản có đơn hàng không
        $sql = "SELECT COUNT(*) FROM donhang WHERE id_taikhoan = :userId";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        $orderCount = $stmt->fetchColumn();
        
        if ($orderCount > 0) {
            // Tài khoản có đơn hàng, không thể xóa
            $_SESSION['error'] = 'Tài khoản này có đơn hàng, không thể xóa.';
            return false;
        }
        
        return true;
    } catch (PDOException $e) {
        // Xử lý lỗi
        $_SESSION['error'] = 'Có lỗi xảy ra khi kiểm tra đơn hàng.';
        return false;
    }
}