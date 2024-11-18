<div class="col-md-3">
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <a href="<?= BASE_URL . '?act=admin-client' ?>" class="text-decoration-none"><i class="fa-regular fa-user mr-2"></i> <b>Thông tin tài khoản</b></a>
                </li>
                <li class="list-group-item">
                    <a href="<?= BASE_URL?>?act=history-order&id=<?=  $_SESSION['user']['id'] ?>" class="text-decoration-none"><i class="fa-solid fa-cart-arrow-down mr-2"></i> <b>Lịch sử mua hàng</b></a>
                </li>
                <li class="list-group-item">
                    <a href="<?= BASE_URL . '?act=logout' ?>" class="text-decoration-none"><i class="fa-solid fa-right-from-bracket mr-2"></i> <b>Đăng xuất</b></a>
                </li>
            </ul>
        </div>
    </div>
</div>