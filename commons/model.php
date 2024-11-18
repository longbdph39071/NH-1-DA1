<?php

// CRUD Danh sách chi tiết
if (!function_exists('get_str_keys')) {

    function get_str_keys($data)
    {
        return implode(',', array_keys($data));
    }
}

if (!function_exists('get_virual_params')) {

    function get_virual_params($data)
    {
        $keys = array_keys($data);
        $tmp = [];

        foreach ($keys as $key) {
            $tmp[] = ":$key";
        }

        return implode(',', $tmp);
    }
}

if (!function_exists('get_set_params')) {

    function get_set_params($data)
    {
        $keys = array_keys($data);
        $tmp = [];

        foreach ($keys as $key) {
            $tmp[] = "$key = :$key";
        }

        return implode(',', $tmp);
    }
}
if (!function_exists('get_virtual_params')) {
    function get_virtual_params($data)
    {
        $keys = array_keys($data);

        $tmp = [];
        foreach ($keys as $key) {
            $tmp[] = ":$key";
        }

        return implode(',', $tmp);
    }
}
// Thêm vào database
if (!function_exists('insert')) {
    function insert($tableName, $data = [])
    {
        try {
            $strKeys = get_str_keys($data);
            $virual_params = get_virual_params($data);

            $sql = "INSERT INTO $tableName($strKeys) VALUES ($virual_params)";

            $stmt = $GLOBALS['conn']->prepare($sql);

            foreach ($data as $fieldName => $value) {
                $stmt->bindValue(":$fieldName", $value);
            }

            $stmt->execute();
        } catch (\Exception $e) {
            debug($e);
        }
    }
}

// Show ra danh sách
if (!function_exists('listAll')) {
    function listAll($tableName)
    {
        try {

            $sql = "SELECT * FROM $tableName ORDER BY id ASC";

            $stmt = $GLOBALS['conn']->prepare($sql);

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            debug($e);
        }
    }
}

// SP bán chạy
function listSelling($tableName)
{
    try {
        $sql = "SELECT * FROM $tableName ORDER BY gia DESC LIMIT 0,4";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (\Exception $e) {
        debug($e);
    }
}

// SP mới
function listNew($tableName)
{
    try {
        $sql = "SELECT * FROM $tableName ORDER BY id DESC LIMIT 0,4";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (\Exception $e) {
        debug($e);
    }
}

// Chi tiết thông tin
if (!function_exists('showOne')) {
    function showOne($tableName, $id)
    {
        try {

            $sql = "SELECT * FROM $tableName WHERE id = :id LIMIT 1";

            $stmt = $GLOBALS['conn']->prepare($sql);

            $stmt->bindValue(":id", $id);

            $stmt->execute();

            return $stmt->fetch();
        } catch (\Exception $e) {
            debug($e);
        }
    }
}

// SP khác
function listCL($tableName, $id)
{
    try {
        $sql = "SELECT * FROM $tableName WHERE id <> $id ORDER BY id DESC LIMIT 0,5  ";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (\Exception $e) {
        debug($e);
    }
}

// Cập nhật thông tin database
if (!function_exists('update')) {
    function update($tableName, $id, $data = [])
    {
        try {
            $setParams = get_set_params($data);

            $sql = "
                UPDATE $tableName 
                SET $setParams
                WHERE id = :id 
            ";

            $stmt = $GLOBALS['conn']->prepare($sql);

            foreach ($data as $fieldName => $value) {
                $stmt->bindValue(":$fieldName", $value);
            }

            $stmt->bindValue(":id", $id);

            $stmt->execute();
        } catch (\Exception $e) {
            debug($e);
        }
    }
}

// Xóa thông tin database
if (!function_exists('delete')) {
    function delete($tableName, $id)
    {
        try {
            $sql = "DELETE FROM $tableName WHERE id = :id";

            $stmt = $GLOBALS['conn']->prepare($sql);

            $stmt->bindValue(":id", $id);

            $stmt->execute();
        } catch (\Exception $e) {
            debug($e);
        }
    }
}

function updateAdminUser($tableName, $id, $data = [])
{
    try {
        // Generate SET parameters for SQL update
        $setParams = get_set_params($data);

        // Prepare SQL statement
        $sql = "
            UPDATE $tableName 
            SET $setParams
            WHERE id = :id 
        ";

        // Prepare and execute the statement
        $stmt = $GLOBALS['conn']->prepare($sql);

        // Bind parameters
        foreach ($data as $fieldName => $value) {
            $stmt->bindValue(":$fieldName", $value);
        }
        $stmt->bindValue(":id", $id);

        // Execute SQL statement
        $stmt->execute();
    } catch (\Exception $e) {
        debug($e); // Handle exception or debug as needed
    }
}
if (!function_exists('delete2')) {
    function delete2($tableName, $id)
    {
        try {
            if ($tableName === 'giohang') {
                // Xóa tất cả các bản ghi liên quan trong giohang_item trước
                $sqlDeleteItems = "DELETE FROM giohang_item WHERE id_giohang = :id_giohang";
                $stmtDeleteItems = $GLOBALS['conn']->prepare($sqlDeleteItems);
                $stmtDeleteItems->bindValue(":id_giohang", $id, PDO::PARAM_INT);
                $stmtDeleteItems->execute();
            }

            // Sau đó xóa bản ghi trong bảng giohang
            $sql = "DELETE FROM $tableName WHERE id = :id";
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Exception $e) {
            debug($e->getMessage());
        }
    }
}
// Join bảng Sản Phẩm vs Danh Mục
if (!function_exists('listAllForPro')) {
    function listAllForPro()
    {
        try {
            $sql = "
                SELECT 
                    sanpham.id,
                    sanpham.ten,
                    sanpham.gia,
                    sanpham.soluong,
                    sanpham.mota,
                    sanpham.anh,
                    sanpham.anh1,
                    sanpham.anh2,
                    sanpham.anh3,
                    sanpham.id_danhmuc,
                    danhmuc.ten_danhmuc,
                    danhmuc.anh_danhmuc
                FROM sanpham
                INNER JOIN danhmuc 
                ON sanpham.id_danhmuc = danhmuc.id;    
                ";
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            debug($e);
        }
    }
}

if (!function_exists('oneForPro')) {
    function oneForPro($id)
    {
        try {
            $sql = "
                SELECT 
                    sanpham.id,
                    sanpham.ten,
                    sanpham.gia,
                    sanpham.soluong,
                    sanpham.mota,
                    sanpham.anh,
                    sanpham.anh1,
                    sanpham.anh2,
                    sanpham.anh3,
                    sanpham.id_danhmuc,
                    danhmuc.ten_danhmuc,
                    danhmuc.anh_danhmuc
                FROM sanpham
                INNER JOIN danhmuc 
                ON sanpham.id_danhmuc = danhmuc.id
                WHERE sanpham.id = :id
                LIMIT 1
                ";
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\Exception $e) {
            debug($e);
        }
    }
}

// SP Theo Danh Muc
function listCateProAll($idCate)
{
    try {
        // Câu lệnh SQL với tham số placeholder
        $sql = "
            SELECT 
                sanpham.id,
                sanpham.ten,
                sanpham.gia,
                sanpham.soluong,
                sanpham.mota,
                sanpham.anh_chinh,
                sanpham.id_danhmuc,
                danhmuc.ten_danhmuc,
                danhmuc.anh_danhmuc
            FROM sanpham
            INNER JOIN danhmuc 
                ON sanpham.id_danhmuc = danhmuc.id  
            WHERE sanpham.id_danhmuc = :idCate
        ";

        // Chuẩn bị và thực thi câu lệnh SQL
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bindParam(':idCate', $idCate, PDO::PARAM_INT);

        $stmt->execute();

        // Trả về kết quả
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
        // Ghi lại lỗi
        error_log($e->getMessage());
        return false;
    }
}

if (!function_exists('insert_get_last_id')) {
    function insert_get_last_id($tableName, $data = [])
    {
        try {
            // Loại bỏ trường 'payment' nếu không tồn tại trong cấu trúc bảng
            if (array_key_exists('payment', $data) && !in_array('payment', ['id_taikhoan', 'tongtien', 'id_trangthai', 'id_trangthaithanhtoan', 'id_thanhtoan'])) {
                unset($data['payment']);
            }

            // Xây dựng danh sách các trường và các tham số ảo
            $strKeys = get_str_keys($data);
            $virtualParams = get_virtual_params($data);

            // Tạo câu lệnh SQL chèn dữ liệu vào bảng
            $sql = "INSERT INTO $tableName($strKeys) VALUES ($virtualParams)";

            // Chuẩn bị câu lệnh SQL
            $stmt = $GLOBALS['conn']->prepare($sql);

            // Liên kết các tham số vào câu SQL
            foreach ($data as $fieldName => &$value) {
                $stmt->bindParam(":$fieldName", $value);
            }

            // Thực thi câu lệnh SQL
            $stmt->execute();

            // Trả về ID của bản ghi vừa chèn vào
            return $GLOBALS['conn']->lastInsertId();
        } catch (\Exception $e) {
            // Xử lý ngoại lệ nếu có lỗi xảy ra
            debug($e);
        }
    }
}
