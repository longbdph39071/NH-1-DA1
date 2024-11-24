<?php

function checkExistingAttribu($table, $data)
{
    $conditions = [];
    foreach ($data as $key => $val) {
        if ($key != 'value') { // Kiểm tra dựa trên tất cả các cột ngoại trừ giá trị thuộc tính
            $conditions[] = "$key = :$key";
        }
    }
    $whereClause = implode(" AND ", $conditions);

    $sql = "SELECT COUNT(*) FROM $table WHERE $whereClause";
    $stmt = $GLOBALS['conn']->prepare($sql);

    foreach ($data as $key => &$val) {
        if ($key != 'value') {
            $stmt->bindParam(":$key", $val);
        }
    }

    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function insertAttribu($table, $data)
{
    if (checkExistingAttribu($table, $data)) {
        return false; // Hoặc bạn có thể cập nhật giá trị hiện có nếu muốn
    }

    $columns = implode(", ", array_keys($data));
    $placeholders = ":" . implode(", :", array_keys($data));

    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    $stmt = $GLOBALS['conn']->prepare($sql);

    foreach ($data as $key => &$val) {
        $stmt->bindParam(":$key", $val);
    }

    if ($stmt->execute()) {
        return $GLOBALS['conn']->lastInsertId();
    } else {
        return false;
    }
}
function insertVariant($data)
{
    $columns = implode(", ", array_keys($data));
    $placeholders = ":" . implode(", :", array_keys($data));

    $sql = "INSERT INTO bien_the ($columns) VALUES ($placeholders)";
    $stmt = $GLOBALS['conn']->prepare($sql);

    foreach ($data as $key => &$val) {
        $stmt->bindParam(":$key", $val);
    }

    if ($stmt->execute()) {
        return $GLOBALS['conn']->lastInsertId();
    } else {
        return false;
    }
}

function listVariantsByAttribute($id_thuoctinh)
{
    $sql = 'SELECT * FROM bien_the WHERE id_thuoctinh = :id_thuoctinh';
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->execute(['id_thuoctinh' => $id_thuoctinh]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function deleteAttributes($id_thuoctinh)
{
    // Xóa các bản ghi liên quan trong bảng `bien_the`
    $sql = "DELETE FROM bien_the WHERE id_thuoctinh = :id_thuoctinh";
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->bindValue(":id_thuoctinh", $id_thuoctinh, PDO::PARAM_INT);
    $stmt->execute();

    // Xóa các bản ghi liên quan trong bảng `sanpham_thuoctinh`
    $sql = "DELETE FROM sanpham_thuoctinh WHERE id_thuoctinh = :id_thuoctinh";
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->bindValue(":id_thuoctinh", $id_thuoctinh, PDO::PARAM_INT);
    $stmt->execute();

    // Xóa thuộc tính chính từ bảng `thuoctinh`
    $sql = "DELETE FROM thuoctinh WHERE id = :id_thuoctinh";
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->bindValue(":id_thuoctinh", $id_thuoctinh, PDO::PARAM_INT);
    $stmt->execute();
}

function deleteAttriVariant($id)
{
    try {
        // Xóa biến thể khỏi cơ sở dữ liệu
        $sql = "DELETE FROM bien_the WHERE id = :id";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['success'] = "Xóa biến thể thành công!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Đã có lỗi xảy ra: " . $e->getMessage();
    }
}

function insertImage($data)
{
    $sql = "INSERT INTO bien_the_images (id_bien_the, image_url) VALUES (:id_bien_the, :image_url)";
    $stmt = $GLOBALS['conn']->prepare($sql);

    foreach ($data as $key => &$val) {
        $stmt->bindParam(":$key", $val);
    }

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
