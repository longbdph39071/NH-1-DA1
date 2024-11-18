<?php

function adminUser()
{
    $view = 'authen/admin-client';
    $cate =  listAll('danhmuc');

    if (!empty($_POST)) {
        try {
            // Prepare data from form
            $data = [
                'ten' => $_POST['ten'],
                'email' => $_POST['email'],
                'sodienthoai' => $_POST['sodienthoai'],
                'ngaysinh' => $_POST['ngaysinh'],
                'diachi' => $_POST['diachi'],
                'matkhau' => $_POST['matkhau'],
                'id' => $_SESSION['user']['id']
            ];

            // Handle image upload if there's a new file
            $img = $_FILES['anh'] ?? null;

            if (!empty($img['name'])) {
                $imgPath = 'upload/user/' . time() . '-' . basename($img['name']);
                if (move_uploaded_file($img['tmp_name'], PATH_UPLOAD . $imgPath)) {
                    $data['anh'] = $imgPath;
                } else {
                    throw new Exception("Failed to move uploaded file.");
                }
            } else {
                // If no new image uploaded, retain the existing image path
                $data['anh'] = $_SESSION['user']['anh'];
            }

            // debug($data);

            $errors = validateUpdateClient($data);
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['data'] = $data;

                header('location: ' . BASE_URL . '?act=admin-client');
                exit();
            }
         
            // Update user in database
            update('taikhoan', $data['id'], $data);

            // Update session with new user data
            $_SESSION['user']['ten'] = $data['ten'];
            $_SESSION['user']['email'] = $data['email'];
            $_SESSION['user']['sodienthoai'] = $data['sodienthoai'];
            $_SESSION['user']['ngaysinh'] = $data['ngaysinh'];
            $_SESSION['user']['diachi'] = $data['diachi'];
            $_SESSION['user']['matkhau'] = $data['matkhau'];
            $_SESSION['user']['anh'] = $data['anh']; // Update image path in session

            $_SESSION['success'] = 'Thao tác thành công';
        } catch (PDOException $e) {
            echo "Có lỗi xảy ra khi cập nhật thông tin: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Có lỗi xảy ra: " . $e->getMessage();
        }
    }

    require_once PATH_VIEW . 'authen/index.php';
}
function validateUpdateClient($data)
{
    $errors = [];

    // Kiểm tra tên
    if (empty($data['ten'])) {
        $errors[] = 'Tên không được để trống.';
    }

    // Kiểm tra email
    if (empty($data['email'])) {
        $errors[] = 'Email không được để trống.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email không hợp lệ.';
    }

    // Kiểm tra số điện thoại
    if (empty($data['sodienthoai'])) {
        $errors[] = 'Số điện thoại không được để trống.';
    } elseif (!preg_match('/^[0-9]{10,15}$/', $data['sodienthoai'])) {
        $errors[] = 'Số điện thoại không hợp lệ.';
    }

    // Kiểm tra ngày sinh
    if (empty($data['ngaysinh'])) {
        $errors[] = 'Ngày sinh không được để trống.';
    } elseif (!DateTime::createFromFormat('Y-m-d', $data['ngaysinh'])) {
        $errors[] = 'Ngày sinh không hợp lệ. Định dạng đúng là YYYY-MM-DD.';
    }

    // Kiểm tra địa chỉ
    if (empty($data['diachi'])) {
        $errors[] = 'Địa chỉ không được để trống.';
    }

    // Kiểm tra mật khẩu (nếu có thay đổi)
    if (empty($data['matkhau'])) {
        $errors[] = 'Mật khẩu không được để trống.';
    } elseif (strlen($data['matkhau']) < 6) {
        $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    }

    return $errors;
}

function historyOrder($id)
{
    $listorderOne = ListorderOnel($id);
    $odder = listAll('donhang');
    $users = showOne('taikhoan', $id);
    $view = 'authen/admin-history';
    $title = '- Người dùng: ' . $users['ten'];

    $listorderhistory = UserOrderHistory($id, '8');

    // debug($listorderOne);

    require_once PATH_VIEW . 'authen/index.php';
}

function detailOrder($id)
{
    require_file(PATH_MODELS);
    $view = 'authen/detail-order';

    // Lấy thông tin đơn hàng
    $manageorderShowOne = ListorderShowOneP($id);
    $ListorderShowOneSP = GetProductsFromOrder($id);
    $updateOrderstatus = GetOrderStatuses();
    $order = ListorderShowOne($id);

    // Xử lý khi có dữ liệu gửi lên
    if (!empty($_POST)) {
        $data = [
            'diachi' => $_POST['diachi'] ?? null,
        ];

        // Cập nhật trạng thái đơn hàng
        update('donhang', $id, $data);
        $_SESSION['message'] = 'Cập nhật đơn hàng thành công.';
        header('location: ' . BASE_URL . '?act=detail-order&id=' . $id);
        exit();
    }


    require_once PATH_VIEW . 'authen/index.php';
}

function deleteOrderUser($id)
{
    // Lấy thông tin đơn hàng từ cơ sở dữ liệu, bao gồm cả id_taikhoan
    $order = ListorderShowOne($id);

    // Kiểm tra nếu đơn hàng không tồn tại
    if (!$order) {
        $_SESSION['error'] = 'Đơn hàng không tồn tại.';
        header('location: ' . BASE_URL . '?act=history-order&id=' . $order['id_taikhoan']);
        exit();
    }

    // Kiểm tra nếu trạng thái đơn hàng là "Xác nhận" (id_trangthai_xacnhan)
    if ($order['id_trangthai'] == id_trangthai_xacnhan) {
        $_SESSION['error'] = 'Không thể hủy đơn hàng đã được xác nhận.';
        header('location: ' . BASE_URL . '?act=history-order&id=' . $order['id_taikhoan']);
        exit();
    }

    // Cập nhật trạng thái đơn hàng thành "Hủy" (id_trangthai_huy)
    $data = [
        'id_trangthai' => id_trangthai_huy,
    ];

    // Thực hiện cập nhật trạng thái đơn hàng
    $result = update('donhang', $id, $data);

    if ($result) {
        $_SESSION['message'] = 'Đơn hàng đã được hủy thành công.';
    }

    // Chuyển hướng về trang lịch sử đơn hàng của người dùng
    header('location: ' . BASE_URL . '?act=history-order&id=' . $order['id_taikhoan']);
    exit();
}
function ordernhanhang($id) {
    try {
        // Lấy thông tin đơn hàng
        $order = ListorderShowOne($id);

        // Kiểm tra trạng thái hiện tại của đơn hàng
        $currentStatus = $order['id_trangthai'];

        // Xác định trạng thái "Đang giao"
        if ($currentStatus != id_trangthai_danggiao) {
            $_SESSION['error'] = 'Đơn hàng phải có trạng thái "Đang giao" mới có thể nhận hàng.';
            header('location: ' . BASE_URL . '?act=history-order&id=' . $order['id_taikhoan']);
            exit();
        }

        // Cập nhật trạng thái đơn hàng thành "Đã nhận hàng" và "Đã thanh toán"
        $data = [
            'id_trangthai' => id_trangthai_thanhcong, // Thay thế với ID của trạng thái "Đã nhận hàng"
            'id_thanhtoan' => id_trangthaithanhtoan_dathanhtoan // Thay thế với ID của phương thức thanh toán "Đã thanh toán"
        ];

        // Cập nhật đơn hàng
        update('donhang', $id, $data);

        // Thiết lập thông báo thành công
        $_SESSION['message'] = 'Đơn hàng đã được cập nhật thành công.';

        // Chuyển hướng người dùng đến trang lịch sử đơn hàng
        header('location: ' . BASE_URL . '?act=history-order&id=' . $order['id_taikhoan']);
        exit();
    } catch (\Exception $e) {
        // Xử lý lỗi
        debug($e);
        $_SESSION['error'] = 'Đã xảy ra lỗi khi cập nhật đơn hàng.';
        header('location: ' . BASE_URL . '?act=history-order&id=' . $order['id_taikhoan']);
        exit();
    }
}

// Show ra chi tiết đơn hàng
if (!function_exists('ListorderShowOneP')) {
    function ListorderShowOneP($id)
    {
        try {
            // Query to retrieve order details
            $sql = "SELECT donhang.id, 
                           donhang.ngaydathang, 
                           donhang.diachi,
                           donhang.email,
                           donhang.sodienthoai,
                           taikhoan.id AS id_taikhoan, 
                           taikhoan.ten AS ten_khachhang, 
                           trangthai_donhang.id AS id_trangthai,  -- Alias for id_trangthai
                           trangthai_donhang.ten_trangthai, 
                           trangthai_thanhtoan.trangthai, 
                           donhang.tongtien, 
                           thanhtoan.id AS id_thanhtoan,  -- Alias for id_thanhtoan
                           thanhtoan.phuongthuc 
                    FROM donhang 
                    INNER JOIN taikhoan ON donhang.id_taikhoan = taikhoan.id
                    INNER JOIN trangthai_donhang ON donhang.id_trangthai = trangthai_donhang.id
                    INNER JOIN thanhtoan ON donhang.id_thanhtoan = thanhtoan.id
                    INNER JOIN trangthai_thanhtoan ON donhang.id_trangthaithanhtoan  = trangthai_thanhtoan.id
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
function deleteOrder($id)
{
    try {
        // Query to check order status
        $sqlCheck = "SELECT id_trangthai FROM donhang WHERE id = :id";
        $stmtCheck = $GLOBALS['conn']->prepare($sqlCheck);
        $stmtCheck->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtCheck->execute();
        $orderStatus = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        // Check if order status allows deletion
        if ($orderStatus['id_trangthai'] == 7 || $orderStatus['id_trangthai'] == 9) { // 3: Hủy đơn, 4: Đơn lỗi
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
