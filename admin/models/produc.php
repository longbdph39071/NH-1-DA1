<?php
if (!function_exists('updatePro')) {
    function updatePro($tableName, $id, $data = [])
    {
        try {
            // Tạo câu lệnh SQL với các tham số
            $setParams = implode(', ', array_map(function ($key) {
                return "$key = :$key";
            }, array_keys($data)));

            $sql = "UPDATE $tableName SET $setParams WHERE id = :id";

            // Hiển thị câu lệnh SQL (để debug)
            error_log("SQL Query: " . $sql);

            $stmt = $GLOBALS['conn']->prepare($sql);

            // Gán giá trị cho các tham số
            foreach ($data as $fieldName => $value) {
                $stmt->bindValue(":$fieldName", $value);
            }

            $stmt->bindValue(":id", $id);

            // Thực thi câu lệnh
            $stmt->execute();

            // Kiểm tra số dòng bị ảnh hưởng
            if ($stmt->rowCount() === 0) {
                error_log("No rows updated. Ensure that the 'id' exists.");
            }
        } catch (\Exception $e) {
            // Ghi lại lỗi
            error_log("Error: " . $e->getMessage());
        }
    }
}

if (!function_exists('insertPro')) {
    function insertPro($tableName, $data = [])
    {
        try {
            $strKeys = implode(', ', array_keys($data));
            $virtualParams = ':' . implode(', :', array_keys($data));

            $sql = "INSERT INTO $tableName ($strKeys) VALUES ($virtualParams)";

            $stmt = $GLOBALS['conn']->prepare($sql);

            foreach ($data as $fieldName => $value) {
                $stmt->bindValue(":$fieldName", $value);
            }

            $stmt->execute();
            return $GLOBALS['conn']->lastInsertId();
        } catch (\Exception $e) {
            debug($e);
            return false;
        }
    }
}
if (!function_exists('listAllForProLi')) {
    function listAllForProLi()
    {
        try {
            $sql = "
                SELECT 
                    sanpham.id,
                    sanpham.ten,
                    sanpham.gia,
                    sanpham.soluong,
                    sanpham.mota,
                    sanpham.mota_ngan,
                    sanpham.id_danhmuc,
                    sanpham.id_hinhanh_chinh,
                    sanpham.anh_chinh,
                    sanpham.xuatban,
                    danhmuc.ten_danhmuc,
                    danhmuc.anh_danhmuc,
                    GROUP_CONCAT(anhsp.ten_anh ORDER BY anhsp.id ASC SEPARATOR ',') AS anh_all
                FROM sanpham
                INNER JOIN danhmuc ON sanpham.id_danhmuc = danhmuc.id
                LEFT JOIN anhsp ON sanpham.id = anhsp.id_sanpham
                GROUP BY sanpham.id    
                ";
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            debug($e);
        }
    }
}
if (!function_exists('oneForProLi')) {
    function oneForProLi($id)
    {
        try {
            $sql = "
                SELECT 
                sanpham.id AS id_sanpham,
                sanpham.ten,
                sanpham.gia,
                sanpham.gia_sale,
                sanpham.soluong,
                sanpham.mota,
                sanpham.mota_ngan,
                sanpham.id_danhmuc,
                sanpham.id_hinhanh_chinh,
                sanpham.anh_chinh,
                sanpham.xuatban,
                danhmuc.ten_danhmuc,
                danhmuc.anh_danhmuc,
                GROUP_CONCAT(DISTINCT anhsp.ten_anh ORDER BY anhsp.id ASC SEPARATOR ',') AS anh_all,
                GROUP_CONCAT(DISTINCT CONCAT(thuoctinh.ten_thuoctinh, ': ', bien_the.value) ORDER BY thuoctinh.id ASC SEPARATOR ', ') AS thuoctinh_all,
                GROUP_CONCAT(DISTINCT CONCAT(binhluan.ten, ': ', binhluan.text) ORDER BY binhluan.id ASC SEPARATOR ' | ') AS binhluan_all
                FROM 
                sanpham
                INNER JOIN 
                danhmuc ON sanpham.id_danhmuc = danhmuc.id
                LEFT JOIN 
                anhsp ON sanpham.id = anhsp.id_sanpham
                LEFT JOIN 
                sanpham_thuoctinh ON sanpham.id = sanpham_thuoctinh.id_sanpham
                LEFT JOIN 
                thuoctinh ON sanpham_thuoctinh.id_thuoctinh = thuoctinh.id
                LEFT JOIN 
                bien_the ON sanpham_thuoctinh.id_thuoctinh = bien_the.id_thuoctinh
                LEFT JOIN 
                binhluan ON sanpham.id = binhluan.id_sanpham
                WHERE
                sanpham.id = :id
                GROUP BY 
                sanpham.id
            ";
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Chuyển đổi chuỗi thuoctinh_all thành mảng variants
            if ($result && isset($result['thuoctinh_all'])) {
                $thuoctinh_all = explode(', ', $result['thuoctinh_all']);
                $result['variants'] = [];
                foreach ($thuoctinh_all as $thuoctinh) {
                    $parts = explode(': ', $thuoctinh);
                    if (count($parts) === 2) {
                        $result['variants'][$parts[0]][] = $parts[1]; // Group by attribute name
                    }
                }
            } else {
                $result['variants'] = [];
            }

            return $result;
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}




if (!function_exists('deleteLi')) {
    function deleteLi($tableName, $id)
    {
        try {
            if (is_numeric($id)) {
                $sql = "DELETE FROM $tableName WHERE id = :id";
                $stmt = $GLOBALS['conn']->prepare($sql);
                $stmt->bindValue(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                throw new Exception("Invalid ID format");
            }
        } catch (\Exception $e) {
            debug($e);
        }
    }
}
if (!function_exists('deleteFile')) {
    function deleteFile($filePath)
    {
        try {
            if (file_exists($filePath)) {
                unlink($filePath);
            } else {
                throw new Exception("File does not exist: " . $filePath);
            }
        } catch (\Exception $e) {
            debug($e);
        }
    }
}
function deleteProduc($id)
{
    try {
        $sql = "DELETE FROM anhsp WHERE id_sanpham = :id";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        // Xóa các hàng liên kết trong bảng `giohang_item`
        $sql = "DELETE FROM giohang_item WHERE id_sanpham = :id";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        // Xóa hàng trong bảng `sanpham`
        $sql = "DELETE FROM sanpham WHERE id = :id";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        // Xóa hàng trong bảng `bienthe`
        $sql = "DELETE FROM bienthe WHERE id = :id";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        // Xóa hàng trong bảng `binhluan`
        $sql = "DELETE FROM binhluan WHERE id = :id";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['success'] = "Xóa sản phẩm thành công!";
    } catch (\Exception $e) {
        $_SESSION['error'] = "Đã có lỗi xảy ra: " . $e->getMessage();
    }

    header('Location: ' . BASE_URL_ADMIN . '?act=produc');
    exit();
}
function getImageIdFromPath($path)
{
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM anhsp WHERE ten_anh = :path");
    $stmt->execute([':path' => $path]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['id'] : null;
}

function isProductInOrders($productId)
{
    try {
        // Câu lệnh SQL kiểm tra sản phẩm trong đơn hàng
        $sql = "SELECT COUNT(*) FROM donhang WHERE id_sanpham = :id_sanpham";

        // Chuẩn bị và thực thi câu lệnh SQL
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bindParam(':id_sanpham', $productId, PDO::PARAM_INT);
        $stmt->execute();

        // Lấy số lượng đơn hàng chứa sản phẩm
        $count = $stmt->fetchColumn();

        // Nếu có đơn hàng chứa sản phẩm, trả về true
        return $count > 0;
    } catch (\Exception $e) {
        // Xử lý lỗi nếu cần
        return false;
    }
}
function deleteProductWithRelatedImages($id)
{
    try {
        // Xóa các thuộc tính liên quan
        $stmt = $GLOBALS['conn']->prepare("DELETE FROM sanpham_thuoctinh WHERE id_sanpham = :id_sanpham");
        $stmt->execute(['id_sanpham' => $id]);

        // Xóa các ảnh liên quan
        $stmt = $GLOBALS['conn']->prepare("SELECT ten_anh FROM anhsp WHERE id_sanpham = :id_sanpham");
        $stmt->execute(['id_sanpham' => $id]);
        $images = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($images as $imagePath) {
            $fullPath = PATH_UPLOAD . $imagePath;
            if (file_exists($fullPath)) {
                unlink($fullPath); // Xóa tệp tin
            }
        }

        // Xóa các bản ghi ảnh
        $stmt = $GLOBALS['conn']->prepare("DELETE FROM anhsp WHERE id_sanpham = :id_sanpham");
        $stmt->execute(['id_sanpham' => $id]);

        // Xóa sản phẩm
        $stmt = $GLOBALS['conn']->prepare("DELETE FROM sanpham WHERE id = :id_sanpham");
        $stmt->execute(['id_sanpham' => $id]);

        $_SESSION['success'] = "Sản phẩm đã được xóa thành công.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Không thể xóa sản phẩm: " . $e->getMessage();
    }
}
