<head>
    <style>
        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">
                Danh Sách Sản Phẩm
                <a href="<?= BASE_URL_ADMIN ?>?act=produc-create" class="btn btn-primary">Thêm mới</a>
            </h3>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['success'] ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="list-unstyled m-0">
                        <?php foreach ($_SESSION['error'] as $error) : ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-bordered" style="text-align: center;" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">Mã</th>
                            <th width="25%">Ảnh</th>
                            <th width="20%">Tên sản phẩm</th>
                            <th width="10%">Loại</th>
                            <th width="10%">Giá</th>
                            <th width="15%">Ngày xuất bản</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($produc as $produc) : ?>
                            <tr>
                                <td>#<?= $produc['id'] ?></td>
                                <td>
                                    <div class="img-wrapper">
                                        <img src="<?= BASE_URL . $produc['anh_chinh'] ?>" width="80" style="border: 2px solid red; margin-bottom: 5px;">
                                    </div>
                                </td>
                                <td><?= $produc['ten'] ?></td>
                                <td><?= $produc['ten_danhmuc'] ?></td>
                                <td><?= number_format($produc['gia']) ?></td>
                                <td>Đã xuất bản<br><?= $produc['xuatban'] ?></td>
                                <td>
                                    <a href="<?= BASE_URL_ADMIN ?>?act=produc-detail&id=<?= $produc['id'] ?>" class="btn btn-info"><i class="fa-solid fa-circle-info"></i></a>
                                    <a href="<?= BASE_URL_ADMIN ?>?act=produc-update&id=<?= $produc['id'] ?>" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="<?= BASE_URL_ADMIN ?>?act=produc-delete&id=<?= $produc['id'] ?>" class="btn btn-primary" onclick="return confirm('Có xóa không ?')"><i class="fa-regular fa-trash-can"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>