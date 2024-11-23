<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h3 class="m-0 font-weight-bold text-primary">
        Thêm Danh Mục
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
            <div class="mb-3">
              <label for="ten_danhmuc" class="form-label">Tên Danh Mục</label>
              <input type="text" class="form-control <?= isset($_SESSION['errors']['ten_danhmuc']) ? 'is-invalid' : '' ?>" name="ten_danhmuc" value="<?= htmlspecialchars($_POST['ten_danhmuc'] ?? '') ?>">
              <?php if (isset($_SESSION['errors']['ten_danhmuc'])) : ?>
                <div class="invalid-feedback">
                  <?= $_SESSION['errors']['ten_danhmuc'] ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="mb-3 mt-3">
              <label for="anh_danhmuc" class="form-label">Ảnh</label>
              <input style="padding: 3px;" type="file" class="form-control <?= isset($_SESSION['errors']['anh_danhmuc']) ? 'is-invalid' : '' ?>" name="anh_danhmuc">
              <?php if (isset($_SESSION['errors']['anh_danhmuc'])) : ?>
                <div class="invalid-feedback">
                  <?= $_SESSION['errors']['anh_danhmuc'] ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="mt-4">
          <a href="<?= BASE_URL_ADMIN ?>?act=category" class="btn btn-primary"><i class="fa-solid fa-arrow-right-from-bracket"></i> Quay lại</a>
          <button type="submit" class="btn btn-warning">Thêm mới</button>
        </div>
      </form>
    </div>
  </div>
</div>
