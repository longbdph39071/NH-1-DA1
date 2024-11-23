<?php
$shipping = 10 * 23000; // Chi phí vận chuyển giả định $10 và tỷ giá 1 USD = 23,000 VND
$total = caculator_order_total() + $shipping; // Tổng tiền cần thanh toán

?>

<form action="<?= BASE_URL ?>?act=order-purcharse" method="post">
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Tên</label>
                            <input class="form-control" type="text" name="ten" value="<?= $_SESSION['user']['ten'] ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" name="email" value="<?= $_SESSION['user']['email'] ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại</label>
                            <input class="form-control" type="tel" name="sodienthoai" value="<?= $_SESSION['user']['sodienthoai'] ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ nhận hàng</label>
                            <input class="form-control" type="text" name="diachi" value="<?= $_SESSION['user']['diachi'] ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>

                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        <?php if (!empty($_SESSION['cart'])) : ?>
                            <?php foreach ($_SESSION['cart'] as $item) : ?>
                                <div class="d-flex justify-content-between">
                                    <p><?= $item['ten'] ?></p>
                                    <p><?= number_format($item['soluong'] * ($item['gia_sale'] ?: $item['gia']), 0, ',', ',') ?> VNĐ</p>
                                </div>
                                <!-- <div class="d-flex justify-content-between">
                        <p>Colorful Stylish Shirt 2</p>
                        <p>$150</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Colorful Stylish Shirt 3</p>
                        <p>$150</p>
                    </div> -->
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium"><?= caculator_order_total() ?> VNĐ</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium"><?= number_format($shipping, 0, ',', ',') ?> VNĐ</h6>
                        </div>
                    </div>

                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold"><?= number_format($total, 0, ',', ',') ?> VNĐ</h5> <!-- Assuming $10 is the shipping cost converted to VND -->
                        </div>
                    </div>
                </div>
                <div class="card border-secondary mb-5">
                    <form action="" method="post">
                        <?php foreach ($thanhtoan as $item) : ?>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" id="paypal<?= $item['id'] ?>" value="<?= $item['id'] ?>">
                                    <label class="custom-control-label" for="paypal<?= $item['id'] ?>"><?= $item['phuongthuc'] ?></label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </form>
                    <div class="card-footer border-secondary bg-transparent">
                        <a href="<?= BASE_URL ?>?act=order-success"><button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>