<?php
if (!function_exists('checkUniName')) {
    function checkUniName($tableName, $name)
    {
        try {
            $sql = "SELECT * FROM $tableName WHERE ten_danhmuc = :ten_danhmuc LIMIT 1";

            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindValue(":name", $name);
            $stmt->execute();

            $data = $stmt->fetch();

            return empty($data) ? true : false;
        } catch (\Exception $e) {
            debug($e);
            return false; // Trả về false khi có lỗi
        }
    }
}
if (!function_exists('validateCreateCateUpdate')) {
    function validateCreateCateUpdate($tableName, $id, $name)
    {
        try {

            $sql = "SELECT * FROM $tableName WHERE ten_danhmuc = :ten_danhmuc AND id <> :id LIMIT 1";

            $stmt = $GLOBALS['conn']->prepare($sql);

            $stmt->bindValue(":ten_danhmuc", $name);
            $stmt->bindValue(":id", $id);


            $stmt->execute();


            $data = $stmt->fetch();
            
            return empty($data) ? true : false;

        } catch (\Exception $e) {
            debug($e);
        }
    }
}