<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h3 class="m-0 font-weight-bold text-primary">
        Sửa Danh Mục
      </h3>
    </div>
    <div class="card-body">
      <?php if (isset($_SESSION['success'])) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= $_SESSION['success'] ?>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['errors'])) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <ul class="list-unstyled m-0">
            <?php foreach ($_SESSION['errors'] as $error) : ?>
              <li><?= $error ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
      <?php endif; ?>
      <form action="" enctype="multipart/form-data" method="post">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3 mt-3">
              <div class="form-group">
                <label for="" class="form-label">Tên Danh Mục:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa-solid fa-file-signature"></i></span>
                  </div>
                  <input type="text" class="form-control" name="ten_danhmuc" value="<?= $category['ten_danhmuc'] ?>">
                </div>
              </div>
            </div>
            <div class="mb-3 mt-3">
              <div class="form-group">
                <label for="" class="form-label">Ảnh:</label>
                <img class="mt-3 mb-3" src="<?php echo BASE_URL . '/' . $category['anh_danhmuc']; ?>" width="130" height="150">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text border"><i class="fa-solid fa-image"></i></span>
                  </div>
                  <input style="padding: 3px;" type="file" class="form-control" name="anh_danhmuc">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-4">
          <a href="<?= BASE_URL_ADMIN ?>?act=category" class="btn btn-primary"><i class="fa-solid fa-arrow-right-from-bracket"></i> Quay lại</a>
          <button type="submit" class="btn btn-warning">Cập nhật</button>
        </div>
      </form>
    </div>
  </div>
</div>