<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="<?= BASE_URL ?>upload/upage/logo.png" type="image/x-icon">

    <title><?= $title ?? 'Dashboard' ?> - Admin</title>
    <script src="https://kit.fontawesome.com/d2a428f875.js" crossorigin="anonymous"></script>
    <!-- Custom fonts for this template-->
    <link href="<?= BASE_URL ?>assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template-->

    <link href="<?= BASE_URL ?>assets/admin/css/sb-admin-2.min.css" rel="stylesheet">
    <?php
    if (isset($style) && $style) {
        require_once PATH_VIEW_ADMIN . 'styles/' . $style . '.php';
    }
    if (isset($style2) && $style2) {
        require_once PATH_VIEW_ADMIN . $style2 . '.php';
    }
    ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require_once PATH_VIEW_ADMIN . "layouts/partials/sidebar.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php require_once PATH_VIEW_ADMIN . "layouts/partials/topbar.php"; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <?php require_once PATH_VIEW_ADMIN . $view . '.php'; ?>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require_once PATH_VIEW_ADMIN . "layouts/partials/footer.php"; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php require_once PATH_VIEW_ADMIN . "components/logoutadmin.php"; ?>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?= BASE_URL ?>assets/admin/dist/js/pages/dashboard3.js"></script>


    <!-- Bootstrap core JavaScript-->
    <script src="<?= BASE_URL ?>assets/admin/vendor/jquery/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= BASE_URL ?>assets/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= BASE_URL ?>assets/admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= BASE_URL ?>assets/admin/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= BASE_URL ?>assets/admin/js/demo/chart-area-demo.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/js/demo/chart-pie-demo.js"></script>

    <!-- Bootstrap 4 -->
    <script src="<?= BASE_URL ?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="<?= BASE_URL ?>assets/admin/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="<?= BASE_URL ?>assets/admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="<?= BASE_URL ?>assets/admin/plugins/moment/moment.min.js"></script>
    <script src="<?= BASE_URL ?>assets/admin/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="<?= BASE_URL ?>assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="<?= BASE_URL ?>assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= BASE_URL ?>assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="<?= BASE_URL ?>assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="<?= BASE_URL ?>assets/admin/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= BASE_URL ?>assets/admin/dist/js/adminlte.min.js"></script>

    <?php
    if (isset($scrips) && $scrips) {
        require_once PATH_VIEW_ADMIN . 'scrips/' . $scrips . '.php';
    }
    if (isset($scrips2) && $scrips2) {
        require_once PATH_VIEW_ADMIN . $scrips2 . '.php';
    }
    ?>
</body>

</html>