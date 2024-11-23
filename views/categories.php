<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-12 pb-1">
        </div>
        <?php foreach ($pro as $pro) : ?>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <a href="<?= BASE_URL ?>?act=singer-detail&id=<?= $pro['id'] ?>" style="text-decoration: none;">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="<?= BASE_URL . '/' . $pro['anh_chinh']; ?>" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3"><?= $pro['ten'] ?></h6>
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
                    </a>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="<?= BASE_URL ?>?act=singer-detail&id=<?= $pro['id'] ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>