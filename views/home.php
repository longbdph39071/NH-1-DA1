<div class="container-fluid">
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="height: 410px;">
                <img class="img-fluid" src="upload/img/slide1.jpg" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 700px;">
                        <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order</h4>
                        <h3 class="display-4 text-white font-weight-semi-bold mb-4">Smart Life</h3>
                        <a href="<?= BASE_URL ?>?act=produc" style="border-radius: 10px;" class="btn btn-light py-2 px-3">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item" style="height: 410px;">
                <img class="img-fluid" src="upload/img/slide2.jpg" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 700px;">
                        <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order</h4>
                        <h3 class="display-4 text-white font-weight-semi-bold mb-4">Reasonable Price</h3>
                        <a href="<?= BASE_URL ?>?act=produc" style="border-radius: 10px;" class="btn btn-light py-2 px-3">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-prev-icon mb-n2"></span>
            </div>
        </a>
        <a class="carousel-control-next" href="#header-carousel" data-slide="next">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-next-icon mb-n2"></span>
            </div>
        </a>
    </div>
</div>
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
            </div>
        </div>
    </div>
</div>
<!-- Categories Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <?php foreach ($cate as $catephone) : ?>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px; text-align: center;">
                    <a href="" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="<?= BASE_URL . '/' . $catephone['anh_danhmuc']; ?>" alt="" width="190px">
                    </a>
                    <h5 class="font-weight-semi-bold m-0"><?= $catephone['ten_danhmuc'] ?></h5>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- Categories End -->

<!-- Offer Start -->
<div class="container-fluid offer pt-5">
    <div class="row px-xl-5">
        <div class="col-md-6 pb-4">
            <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                <img src="upload/img/offer-1.png" alt="">
                <div class="position-relative" style="z-index: 1;">
                    <h5 class="text-uppercase text-primary mb-3">5% off the all order</h5>
                    <h1 class="mb-4 font-weight-semi-bold">Iphone</h1>
                    <a href="<?= BASE_URL ?>?act=produc" style="border-radius: 10px;" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 pb-4">
            <div class="position-relative bg-secondary text-center text-md-left text-white mb-2 py-5 px-5">
                <img src="upload/img/offer-2.png" alt="">
                <div class="position-relative" style="z-index: 1;">
                    <h5 class="text-uppercase text-primary mb-3">5% off the all order</h5>
                    <h1 class="mb-4 font-weight-semi-bold">Samsung</h1>
                    <a href="<?= BASE_URL ?>?act=produc" style="border-radius: 10px;" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Offer End -->


<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Trandy Products</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        <?php foreach ($pro as $pro) : ?>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="<?= BASE_URL ?>?act=singer-detail&id=<?= $pro['id'] ?>" style="text-decoration: none;">
                            <img class="img-fluid w-100" src="<?= BASE_URL . '/' . $pro['anh_chinh']; ?>" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <a href="<?= BASE_URL ?>?act=singer-detail&id=<?= $pro['id'] ?>" style="text-decoration: none;">
                            <h4 class="text-truncate mb-3"><?= $pro['ten'] ?></h3>
                        </a>
                        <div class="d-flex justify-content-center">
                            <h6>
                                <?php if (isset($pro['gia_sale']) && !empty($pro['gia_sale'])) : ?>
                                    <?= number_format($pro['gia_sale']) ?> VNĐ<br>
                                    <del><?= number_format($pro['gia']) ?></del> VNĐ
                                <?php else : ?>
                                    $<?= number_format($pro['gia']) ?>
                                <?php endif; ?>
                            </h6>
                            <!-- <h6 class="text-muted ml-2"><del>$<?= $pro['gia'] ?></del></h6> -->
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="<?= BASE_URL ?>?act=singer-detail&id=<?= $pro['id'] ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        <a href="<?= BASE_URL . '?act=cart-add&productID=' . $pro['id'] . '&quantity=1'  ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                    </div>

                </div>
            </div>

        <?php endforeach; ?>


    </div>
</div>
<!-- Products End -->

<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Just Arrived</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        <?php foreach ($proNew as $proNew) : ?>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <a href="<?= BASE_URL ?>?act=singer-detail&id=<?= $proNew['id'] ?>" style="text-decoration: none;">
                            <img class="img-fluid w-100" src="<?= BASE_URL . '/' . $proNew['anh_chinh']; ?>" alt="">
                        </a>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <a href="<?= BASE_URL ?>?act=singer-detail&id=<?= $proNew['id'] ?>" style="text-decoration: none;">
                            <h4 class="text-truncate mb-3"><?= $proNew['ten'] ?></h4>
                        </a>
                        <div class="d-flex justify-content-center">
                            <h6>
                                <?php if (isset($proNew['gia_sale']) && !empty($pro['gia_sale'])) : ?>
                                    <?= number_format($proNew['gia_sale']) ?> VNĐ<br>
                                    <del><?= number_format($proNew['gia']) ?></del> VNĐ
                                <?php else : ?>
                                    $<?= number_format($proNew['gia']) ?>
                                <?php endif; ?>
                            </h6>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="<?= BASE_URL ?>?act=singer-detail&id=<?= $proNew['id'] ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        <a href="<?= BASE_URL . '?act=cart-add&productID=' . $proNew['id'] . '&quantity=1'  ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- Products End -->