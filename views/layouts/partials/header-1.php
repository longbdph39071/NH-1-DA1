<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>HHD Shop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>upload/upage/logo.png" type="image/x-icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d2a428f875.js" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS and jQuery (required for Bootstrap functionality) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Libraries Stylesheet -->
    <link href="<?= BASE_URL ?>assets/client/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= BASE_URL ?>assets/client/css/style.css" rel="stylesheet">
</head>

<div class="container-fluid">
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a href="<?= BASE_URL ?>" class="text-decoration-none">
                <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">HHD</span>Shop</h1>
            </a>
        </div>
        <div class="col-lg-6 col-6 text-left">
            <form action="">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for products">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-primary">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 col-6 text-right">
            <a href="<?= BASE_URL . '?act=cart' ?>" class="btn border position-relative mx-3 font_txt">
                <i class="fas fa-shopping-cart text-primary"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-light">
                    <?= $cartItemCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                </span>
            </a>
            <a href="<?= isset($_SESSION['user']) ? BASE_URL . '?act=admin-client' : BASE_URL . '?act=login' ?>" class="btn border mx-3 font_txt">
                <?php if (isset($_SESSION['user'])) : ?>
                    <img src="<?= BASE_URL . $_SESSION['user']['anh'] ?>" alt="" class="fa-solid fa-user rounded-circle" width="35">
                <?php else : ?>
                    <i class="fa-solid fa-user"></i>
                <?php endif; ?>
                <span class="badge"></span>
            </a>
        </div>
    </div>
</div>
<div class="container-fluid mb-3">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0">Danh mục</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
                <div class="navbar-nav w-100 overflow-hidden" style="max-height: 247px; overflow-y: auto;">
                    <?php foreach ($cate as $category) : ?>
                        <a href="<?= BASE_URL ?>?act=category&id=<?= $category['id'] ?>" class="nav-item nav-link"><?= $category['ten_danhmuc'] ?></a>
                    <?php endforeach; ?>
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="<?= BASE_URL ?>" class="nav-item">Trang chủ</a>
                        <a href="<?= BASE_URL ?>?act=produc" class="nav-item">Cửa hàng</a>
                        <a href="<?= BASE_URL ?>?act=about" class="nav-item">Giới thiệu</a>
                        <a href="<?= BASE_URL ?>?act=blog" class="nav-item">Tin tức</a>
                        <a href="<?= BASE_URL ?>?act=contact" class="nav-item">Liên hệ</a>
                    </div>
                    <?php if (isset($_SESSION['user'])) : ?>
                    <?php else : ?>
                        <!-- User is not logged in, show login and register links -->
                        <a href="<?= BASE_URL ?>?act=login" class="nav-item nav-link">Login</a>
                        <a href="<?= BASE_URL ?>?act=register" class="nav-item nav-link">Register</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Trong file header.php -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lấy đường dẫn URL hiện tại
        var currentUrl = window.location.href;

        // Lấy tất cả các liên kết trong menu
        var menuLinks = document.querySelectorAll('.nav-item');

        // Duyệt qua từng liên kết và kiểm tra
        menuLinks.forEach(function(link) {
            // So sánh đường dẫn URL hiện tại với href của từng liên kết
            if (link.href === currentUrl) {
                link.classList.add('active'); // Thêm class 'active' nếu là trang hiện tại
            }
        });
    });
</script>
<!-- Trong file header.php -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lấy đường dẫn URL hiện tại
        var currentUrl = window.location.href;

        // Lấy tất cả các liên kết trong menu
        var menuLinks = document.querySelectorAll('.nav-item');

        // Duyệt qua từng liên kết và kiểm tra
        menuLinks.forEach(function(link) {
            // So sánh đường dẫn URL hiện tại với href của từng liên kết
            if (link.href === currentUrl) {
                link.classList.add('active'); // Thêm class 'active' nếu là trang hiện tại
            }
        });
    });
</script>