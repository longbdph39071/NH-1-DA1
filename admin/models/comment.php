<?php

if (!function_exists('ListshowALLComment')) {
    function ListshowALLComment($tableName)
    {
        try {
            $sql = "SELECT bl.id, 
                       bl.id_sanpham, 
                       sp.ten AS ten_sanpham, 
                       bl.ten, 
                       bl.ngay, 
                       bl.text, 
                       bl.id_taikhoan, 
                       tk.ten AS ten_taikhoan
                FROM binhluan bl
                INNER JOIN sanpham sp ON bl.id_sanpham = sp.id
                INNER JOIN taikhoan tk ON bl.id_taikhoan = tk.id";

            // Prepare SQL statement
            $stmt = $GLOBALS['conn']->prepare($sql);

            // Execute query
            $stmt->execute();
            // Fetch single row as associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            debug($e); // Handle exceptions (you can log or handle differently)
            return null; // Return null or handle error case as appropriate
        }
    }
}
if (!function_exists('ListshowONEComment')) {
    function ListshowONEComment($tableName, $id)
    {
        try {
            $sql = "SELECT bl.id, 
                           bl.id_sanpham, 
                           sp.ten AS ten_sanpham, 
                           sp.id AS id_sanpham,
                           bl.ten, 
                           bl.ngay, 
                           bl.text, 
                           bl.id_taikhoan, 
                           tk.ten AS ten_taikhoan
                    FROM binhluan bl
                    INNER JOIN sanpham sp ON bl.id_sanpham = sp.id
                    INNER JOIN taikhoan tk ON bl.id_taikhoan = tk.id
                    WHERE bl.id_sanpham = :id
                    ORDER BY bl.id DESC";

            // Prepare SQL statement
            $stmt = $GLOBALS['conn']->prepare($sql);

            // Bind parameter
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Assuming $id is an integer

            // Execute query
            $stmt->execute();

            // Fetch all rows as associative array
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $comments; // Return array of comments
        } catch (\Exception $e) {
            debug($e); // Handle exceptions (you can log or handle differently)
            return []; // Return empty array or handle error case as appropriate
        }
    }
}
function hideCommentPro($id) {
    try {
        // Chuẩn bị câu truy vấn SQL
        $sql = "UPDATE binhluan SET hidden = 1 WHERE id = :id";

        // Chuẩn bị và thực thi câu truy vấn
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return true; // Trả về true nếu thành công
    } catch (PDOException $e) {
        // Xử lý ngoại lệ nếu có lỗi khi thực hiện câu truy vấn
        // Thay thế bằng xử lý lỗi phù hợp trong thực tế
        echo "Lỗi: " . $e->getMessage();
        return false; // Trả về false nếu có lỗi
    }
}
