<?php require_once PATH_VIEW . "layouts/partials/header-1.php"; ?>

<section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Đăng nhập</p>
                                <?php if (isset($_SESSION['errors'])) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul class="list-unstyled m-0">
                                            <?php foreach ($_SESSION['errors'] as $error) : ?>
                                                <li><?= htmlspecialchars($error) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <?php unset($_SESSION['errors']); ?>
                                <?php endif; ?>

                                <!-- Hiển thị thông báo lỗi đăng nhập -->
                                <?php if (isset($_SESSION['error'])) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?= htmlspecialchars($_SESSION['error']) ?>
                                    </div>
                                    <?php unset($_SESSION['error']); ?>
                                <?php endif; ?>
                                <form class="mx-1 mx-md-4" method="post">

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg mr-2"></i>
                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                            <input type="text" id="form3Example1c" class="form-control" placeholder="Email" name="email" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg mr-2"></i>
                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                            <input type="password" id="form3Example4c" class="form-control" placeholder="Password" name="matkhau" />
                                        </div>
                                    </div>

                                    <!-- <div class="form-check d-flex ">
                                        <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" />
                                        <label class="form-check-label none" for="form2Example3">
                                            Nhớ mật khẩu
                                        </label>
                                    </div> -->

                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg">Đăng nhập</button>
                                    </div>

                                    <div class="form-check d-flex justify-content-center ">
                                        <label class="form-check-label" for="form2Example3">
                                            Bạn chưa có tài khoản ? <a href="<?= BASE_URL ?>?act=register">Đăng ký</a>
                                        </label>
                                    </div>
                                </form>

                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                <img src="<?= BASE_URL ?>upload/upage/logo.png" class="img-fluid" alt="Sample image">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once PATH_VIEW . "layouts/partials/footer.php"; ?>