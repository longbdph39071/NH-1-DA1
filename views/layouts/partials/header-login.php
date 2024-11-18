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
            <a href="<?=BASE_URL . '?act=cart' ?>" class="btn border">
                <i class="fas fa-shopping-cart text-primary"></i>
                <span class="badge"></span>
            </a>
            <a href="<?= isset($_SESSION['user']) ? BASE_URL . '?act=admin-client' : BASE_URL . '?act=login' ?>" class="btn border">
                <i class="fa-solid fa-user"></i>
                <span class="badge"></span>
            </a>
        </div>
    </div>
</div>
<div class="container-fluid mb-5">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
        <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0">Danh mục</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
                <div class="navbar-nav w-100 overflow-hidden" style="height: 247px">
                    <?php foreach($cate as $cate) : ?>
                        <a href="<?= BASE_URL?>?act=category&id=<?= $cate['id'] ?>" class="nav-item nav-link"><?= $cate['ten_danhmuc']?></a>
                    <?php endforeach;?>
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
                        <a href="<?= BASE_URL?>" class="nav-item nav-link active">Home</a>
                        <a href="<?= BASE_URL?>?act=produc" class="nav-item nav-link">Products</a>
                    </div>
                    <div class="navbar-nav ml-auto py-0">
                        <a href="<?= BASE_URL?>?act=logout" class="nav-item nav-link"><i style="font-size: x-large;" class="fa-solid fa-right-from-bracket"></i></a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>