    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <!-- Shop Sidebar Start -->

            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <form action="">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search by name">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-transparent text-primary">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            <div class="dropdown ml-4">
                                <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sort by
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                    <a class="dropdown-item" href="#">Latest</a>
                                    <a class="dropdown-item" href="#">Popularity</a>
                                    <a class="dropdown-item" href="#">Best Rating</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($pro as $pro) : ?>
                        <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                            <div class="card product-item border-0 mb-4">
                                <a href="<?= BASE_URL ?>?act=singer-detail&id=<?= $pro['id'] ?>" style="text-decoration: none;">
                                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                        <img style="padding: 50px;" class="img-fluid w-100" src="<?= BASE_URL . '/' . $pro['anh_chinh']; ?>" alt="">
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
                                            <!-- <h6 class="text-muted ml-2"><del>$123.00</del></h6> -->
                                        </div>
                                    </div>
                                </a>
                                <div class="card-footer d-flex justify-content-between bg-light border">
                                    <a href="<?= BASE_URL ?>?act=singer-detail&id=<?= $pro['id'] ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                    <a href="<?= isset($_SESSION['user']) ? BASE_URL . '?act=cart-add&productID=' . $pro['id'] . '&quantity=1' : BASE_URL . '?act=login' ?>" class="btn btn-sm text-dark p-0">
                                        <i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- <div class="col-12 pb-1">
                        <nav aria-label="Page navigation">
                          <ul class="pagination justify-content-center mb-3">
                            <li class="page-item disabled">
                              <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                              </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                              <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                              </a>
                            </li>
                          </ul>
                        </nav>
                    </div> -->
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->