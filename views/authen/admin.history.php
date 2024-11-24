<head>
    <style>
        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to initialize table behavior
            function initializeTable(tableId, itemClass) {
                const selectAllCheckbox = document.querySelector(`#${tableId} #selectAll`);
                const itemCheckboxes = document.querySelectorAll(`#${tableId} .${itemClass}`);

                function updateHeaderCheckbox() {
                    const allChecked = Array.from(itemCheckboxes).every(function(itemCheckbox) {
                        return itemCheckbox.checked;
                    });

                    selectAllCheckbox.checked = allChecked;
                }

                selectAllCheckbox.addEventListener('change', function() {
                    itemCheckboxes.forEach(function(checkbox) {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                });

                itemCheckboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('change', function() {
                        updateHeaderCheckbox();
                    });
                });
            }

            // Initialize each table
            initializeTable('dataTable1', 'item1');
            initializeTable('dataTable2', 'item2');
        });
    </script>
</head>


<div class="card shadow col-md-9">
    <div class="card-body">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">
                Danh sách đơn hàng của <?= $users['ten'] ?>
            </h3>
        </div><?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error'];
                    unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['message'];
                unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <div class="tab-pane fade show active" id="table1" role="tabpanel" aria-labelledby="table1-tab">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Mã đơn hàng</th>
                            <th>Tên khách hàng</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Trạng thái đơn hàng</th>
                            <th>Tổng tiền</th>
                            <th>Xem chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  foreach ($listorderOne as $order) : ?>
                            <tr>
                                <td><input type="checkbox" class="item1"></td>
                                <td>HD0<?= $order['id'] ?></td>
                                <td><?= $order['ten'] ?></td>
                                <td><?= $order['diachi'] ?></td>
                                <td><?= $order['sodienthoai'] ?></td>
                                <td><span class="text-capitalize"><?= $order['ten_trangthai'] ?></span></td>
                                <td><?= number_format($order['tongtien']) ?> VNĐ</td>
                                <td><a href="<?= BASE_URL ?>?act=detail-order&id=<?= $order['id'] ?>" class="btn btn-info"><i class="fa-solid fa-circle-info"></i></a>
                                    <a href="<?= BASE_URL ?>?act=order-nhanhang&id=<?= $order['id'] ?>" class="btn btn-warning"><i class="fa-regular fa-square-check"></i></a>
                                    <a href="<?= BASE_URL ?>?act=detail-order-delete&id=<?= $order['id'] ?>" class="btn btn-primary" onclick="return confirm('Có muốn xóa không ?')"><i class="fa-regular fa-trash-can"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- Các dòng dữ liệu bổ sung ở đây -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- LỊCH SỬ  -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">
                    Lịch sử mua hàng của <?= $users['ten'] ?>
                </h3>
            </div>
            <div class="card-body">
                <div class="tab-content mt-3" id="myTabContent">
                    <!-- Table 1 - Tất cả đơn hàng -->
                    <div class="tab-pane fade show active" id="table1" role="tabpanel" aria-labelledby="table1-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>Mã đơn hàng</th>
                                        <th>Tên khách hàng</th>
                                        <th>Địa chỉ</th>
                                        <th>Trạng thái đơn hàng</th>
                                        <th>Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listorderhistory as $order) : ?>
                                        <tr>
                                            <td><input type="checkbox" class="item1"></td>
                                            <td>HD0<?= $order['id'] ?></td>
                                            <td><?= $order['ten_khachhang'] ?></td>
                                            <td><?= $order['diachi'] ?></td>
                                            <td><span class="text-capitalize"><?= $order['ten_trangthai'] ?></span></td>
                                            <td><?= number_format($order['tongtien']) ?> VNĐ</td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- Các dòng dữ liệu bổ sung ở đây -->
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>