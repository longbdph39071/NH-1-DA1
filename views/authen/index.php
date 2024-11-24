<?php require_once PATH_VIEW . "layouts/partials/header-1.php";?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content admin-user-HHD pl-5">
        <div class="container-fluid">
            <div class="row">
                <?php require_once PATH_VIEW . "layouts/partials/sidebar.php"; ?>
                <!-- /.col -->
                <?php require_once PATH_VIEW . $view . '.php'; ?>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<?php require_once PATH_VIEW . "layouts/partials/footer.php"; ?>