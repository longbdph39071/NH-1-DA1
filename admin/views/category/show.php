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
        Chi Tiết Danh Mục
        <!-- <a href="<?= BASE_URL_ADMIN ?>?act=category" class="btn btn-warning">LIST</a> -->
      </h3>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width="10%">ID</th>
              <th width="45%">Tên</th>
              <th width="45%">Ảnh</th>
            </tr>
          </thead>
          <tbody>

            <tr>
              <th><?= $category['id'] ?></th>
              <th><?= $category['ten_danhmuc'] ?></th>
              <th><?php if (!empty($category['anh_danhmuc'])) : ?>
                  <img src="<?php echo BASE_URL . '/' . $category['anh_danhmuc']; ?>" width="100">
                <?php else : ?>
                  Không có ảnh
                <?php endif; ?>
              </th>
            </tr>

          </tbody>
        </table>
        <div class="mt-4">
          <a href="<?= BASE_URL_ADMIN ?>?act=category" class="btn btn-primary"><i class="fa-solid fa-arrow-right-from-bracket"></i> Quay lại</a>
        </div>
      </div>
    </div>
  </div>
</div>