<?php
session_start();
include 'database/db.php';

// jika button simpan di tekan
if (isset($_POST['simpan'])) {
    $costumer_name = $_POST['costumer_name'];
    $phone = $_POST['phone'];
    $alamat = $_POST['alamat'];

    $insert = mysqli_query($koneksi, "INSERT INTO costumer (costumer_name, phone, alamat) VALUES ('$costumer_name','$phone','$alamat')");
    header("location: costumer.php?tambah=berhasil");
}


$id  = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM costumer WHERE id ='$id'");
$rowEdit   = mysqli_fetch_assoc($queryEdit);


// jika button edit di klik

if (isset($_POST['edit'])) {
    $costumer_name   = $_POST['costumer_name'];
    $phone = $_POST['phone'];
    $alamat = $_POST['alamat'];
    $update = mysqli_query($koneksi, "UPDATE costumer SET costumer_name='$costumer_name', phone='phone', alamat='alamat' WHERE id='$id'");
    header("location:costumer.php?ubah=berhasil");
}
?>
<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <?php include 'inc/head.php' ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?php include 'inc/sidebar.php'; ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php include 'inc/nav.php'; ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Costumers</div>
                                    <div class="card-body">
                                        <?php if (isset($_GET['hapus'])): ?>
                                            <div class="alert alert-success" role="alert">
                                                Data berhasil dihapus
                                            </div>
                                        <?php endif ?>

                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="mb-3 row">
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">Tambah Nama costumer</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="costumer_name"
                                                        placeholder="Masukkan nama costumer anda"
                                                        required
                                                        value="<?php echo isset($_GET['edit']) ? $rowEdit['costumer_name'] : '' ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">Nomor Telepon</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="phone"
                                                        placeholder="Masukkan nomor telepon anda"
                                                        required
                                                        value="<?php echo isset($_GET['edit']) ? $rowEdit['phone'] : '' ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">Alamat</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="alamat"
                                                        placeholder="Masukkan nama costumer disini"
                                                        required
                                                        value="<?php echo isset($_GET['edit']) ? $rowEdit['alamat'] : '' ?>">
                                                </div>

                                                <div class="mb-3">
                                                    <button class="btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>" type="submit">
                                                        Simpan
                                                    </button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , made with ❤️ by
                                <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                            </div>
                            <div>
                                <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                                <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                                <a
                                    href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                                    target="_blank"
                                    class="footer-link me-4">Documentation</a>

                                <a
                                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                                    target="_blank"
                                    class="footer-link me-4">Support</a>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/admin/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/admin/assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/admin/assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/admin/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/admin/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../assets/admin/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/admin/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>