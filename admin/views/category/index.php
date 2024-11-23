<head>
  <style>
    .table th,
    .table td {
      vertical-align: middle;
      text-align: center;
    }

    .table td:last-child {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
  </style>
</head>
<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h3 class="m-0 font-weight-bold text-primary">
        Danh Sách Danh Mục
        <a href="<?= BASE_URL_ADMIN ?>?act=category-create" class="btn btn-primary">Thêm mới</a>
      </h3>
    </div>
    <div class="card-body">
      <?php if (isset($_SESSION['success'])) : ?>
        <div class="alert alert-danger">
          <?= $_SESSION['success'] ?>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>
      <div class="table-responsive">
        <table class="table table-bordered" id="" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width="10%">Mã</th>
              <th width="35%">Tên</th>
              <th width="30%">Ảnh</th>
              <th>Tính năng</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($category as $cate) : ?>
              <tr>
                <th>#<?= $cate['id'] ?></th>
                <th><?= $cate['ten_danhmuc'] ?></th>
                <th><?php if (!empty($cate['anh_danhmuc'])) : ?>
                    <img src="<?= BASE_URL . '/' . $cate['anh_danhmuc']; ?>" width="100">
                  <?php else : ?>
                    Không có ảnh
                  <?php endif; ?>
                </th>

                <th><a href="<?= BASE_URL_ADMIN ?>?act=category-detail&id=<?= $cate['id'] ?>" class="btn btn-info"><i class="fa-solid fa-circle-info"></i></a>
                  <a href="<?= BASE_URL_ADMIN ?>?act=category-update&id=<?= $cate['id'] ?>" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                  <a href="<?= BASE_URL_ADMIN ?>?act=category-delete&id=<?= $cate['id'] ?>" class="btn btn-primary" onclick="return confirm('Có muốn xóa không ?')"><i class="fa-regular fa-trash-can"></i></a>
                </th>

              </tr>
            <?php endforeach;  ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>