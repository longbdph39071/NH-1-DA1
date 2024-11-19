<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= BASE_URL ?>">
        <div class="sidebar-brand-icon">
            <img src="<?= BASE_URL ?>upload/upage/logo.png" alt="" width="50" class="rounded-circle">
        </div>
        <div class="sidebar-brand-text mx-3">HHD</div>
    </a>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL_ADMIN ?>">
            <i class="fa-solid fa-chart-line"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa-solid fa-user"></i>
            <span>Quản lý tài khoản</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= BASE_URL_ADMIN ?>?act=user">Danh sách tài khoản</a>
                <a class="collapse-item" href="<?= BASE_URL_ADMIN ?>?act=user-create">Thêm mới</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
            <i class="fa-solid fa-list"></i>
            <span>Quản lý danh mục</span>
        </a>
        <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= BASE_URL_ADMIN ?>?act=category">Danh sách danh mục</a>
                <a class="collapse-item" href="<?= BASE_URL_ADMIN ?>?act=category-create">Thêm mới</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
            <i class="fa-solid fa-dolly"></i>
            <span>Quản lý sản phẩm</span>
        </a>
        <div id="collapse2" class="collapse" aria-labelledby="heading1" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= BASE_URL_ADMIN ?>?act=produc">Danh sách sản phẩm</a>
                <a class="collapse-item" href="<?= BASE_URL_ADMIN ?>?act=produc-create">Thêm mới</a>
                <a class="collapse-item" href="<?= BASE_URL_ADMIN ?>?act=attributes">Các thuộc tính</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="<?= BASE_URL_ADMIN ?>?act=manage-order">
        <i class="fa-solid fa-cart-arrow-down"></i>
            <span>Quản lý đơn hàng</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="<?= BASE_URL_ADMIN ?>?act=comment">
            <i class="fa-solid fa-comments"></i>
            <span>Quản lý bình luận</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="<?= BASE_URL_ADMIN ?>?act=logout">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Đăng xuất</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>