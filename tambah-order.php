<?php
session_start();
include 'database/db.php';

// munculkan / pilih sebuah atau semua kolom dari table 
$queryOrder = mysqli_query($koneksi, "SELECT * FROM customer");

//join Dari Data detail_trans_order , service, trans_order
$id =  isset($_GET['detail']) ? $_GET['detail'] : '';
$querytrans_Detail = mysqli_query($koneksi, "SELECT customer.customer_name,customer.phone,customer.alamat, trans_order.order_code,trans_order.order_date,trans_order.status, service.service_name,service.harga, detail_trans_order.*FROM detail_trans_order 
LEFT JOIN service ON service.id = detail_trans_order.id_service 
LEFT JOIN trans_order ON trans_order.id = detail_trans_order.id_order 
LEFT JOIN customer ON trans_order.id_customer = customer.id
WHERE detail_trans_order.id_order='$id'");

$row = [];
while ($dataTrans = mysqli_fetch_assoc($querytrans_Detail)) {
    $row[] = $dataTrans;
}

//Ambil data dari table service
$queryService = mysqli_query($koneksi, "SELECT * FROM service");
$rowService = [];
while ($data = mysqli_fetch_assoc($queryService)) {
    $rowService[] = $data;
}
// jika button simpan di tekan
if (isset($_POST['simpan'])) {

    $id_customer = $_POST['id_customer'];
    $order_code = $_POST['order_code'];
    $order_date = $_POST['order_date'];
    $keterangan = $_POST['keterangan'];

    $id_service = $_POST['id_service'];
    // insert ke table trans order 
    $insert = mysqli_query($koneksi, "INSERT INTO trans_order (id_customer, order_code, order_date, keterangan) VALUES ('$id_customer', '$order_code', '$order_date', '$keterangan')");

    $last_id = mysqli_insert_id($koneksi);
    // Insert ke table trans_detail_order
    foreach ($id_service as $key => $value) {
        // if ($key > 0) {
        // }
        $id_service = array_filter($_POST['id_service']);
        $qty = array_filter($_POST['qty']);
        $id_service = $_POST['id_service'][$key];
        $qty = $_POST['qty'][$key];

        $queryService = mysqli_query($koneksi, "SELECT id, harga FROM service WHERE id = '$id_service'");
        $rowService = mysqli_fetch_assoc($queryService);
        $harga = isset($rowService['harga']) ? $rowService['harga'] : '';
        //sub-total
        $subtotal = (int)$qty * (int)$harga;

        $insertTransDetail = mysqli_query($koneksi, "INSERT INTO detail_trans_order (id_order,id_service, qty,subtotal) VALUES ('$last_id','$id_service','$qty','$subtotal')");

        header("location: trans-order.php?tambah=berhasil");
    }
}


// Nomor Invoice
// 001, jika ada auto increment id + 1 = 002, selain itu 001
// menggunakan MAX/MIN (untuk ambil data terbesar/terkecil)

$queryInvoice = mysqli_query($koneksi, "SELECT MAX(id) AS order_code FROM trans_order");
$no_unique = "INV";
$data_now = date("dmY");
if (mysqli_num_rows($queryInvoice) > 0) {
    $rowInvoice = mysqli_fetch_assoc($queryInvoice);
    $incrementPlus = $rowInvoice['order_code'] + 1;
    $codeInput = $no_unique . "/" . $data_now . "/" . "000" . $incrementPlus;
} else {
    $codeInput = $no_unique . "/" . $data_now . "/" . "001";
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

            <?php include 'inc/sidebar.php' ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php include 'inc/nav.php' ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <?php if (isset($_GET['detail'])) : ?>
                        <!-- untuk detail -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <h5 class="m-0 p-0">Transaksi Laundry :</h5>
                                                    <h5 class="text-warning fst-italic"><br> <?php echo $row[0]['customer_name'] ?></h5>
                                                </div>
                                                <div class="col-sm-6 mb-3 mb-sm-0" align="right">
                                                    <a href="trans-order.php" class="btn btn-secondary"><i class='bx bx-arrow-back'></i></a>
                                                    <a href="print.php?id=<?php echo $row[0]['id_order'] ?>" class="btn btn-success"><i class='bx bx-printer'></i></a>
                                                    <?php if ($row[0]['status'] == 0): ?>
                                                        <a href="tambah-pickup.php?ambil=<?php echo $row[0]['id_order'] ?>" class="btn btn-warning"><i class='bx bx-closet'></i></a>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Detail Data Transaksi</h5>
                                        </div>
                                        <?php include 'helper.php' ?>
                                        <div class="card-Body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>No Invoice</th>
                                                    <td><?php echo $row[0]['order_code'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <td><?php echo $row[0]['order_date'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td><?php echo changeStatus($row[0]['status']) ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Pelanggan</h5>
                                        </div>
                                        <div class="card-Body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>Nama </th>
                                                    <td><?php echo $row[0]['customer_name'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>nomor Telepon</th>
                                                    <td><?php echo $row[0]['phone'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td><?php echo $row[0]['alamat'] ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Transaksi Detail</h5>
                                        </div>
                                        <div class="card-Body">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama service</th>
                                                        <th>Qty</th>
                                                        <th>Harga</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($row as $key => $value) : ?>
                                                        <tr>
                                                            <td> <?php echo $no++ ?></td>
                                                            <td> <?php echo $value['service_name'] ?></td>
                                                            <td> <?php echo $value['qty'] ?></td>
                                                            <td> <?php echo $value['harga'] ?></td>
                                                            <td> <?php echo $value['subtotal'] ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- untuk tambah -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Transaksi</div>
                                            <div class="card-body">
                                                <?php if (isset($_GET['hapus'])): ?>
                                                    <div class="alert alert-success" role="alert">
                                                        Data berhasil dihapus
                                                    </div>
                                                <?php endif ?>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-12">
                                                        <label for="" class="form-label"> customer</label>
                                                        <select data-mdb-select-init name="id_customer" class="form-control">
                                                            <option value="">Pilih customer</option>
                                                            <?php while ($rowOrder = mysqli_fetch_assoc($queryOrder)) { ?>
                                                                <option <?php echo isset($rowEdit['id_customer']) ? ($rowOrder['id'] == $rowEdit['id_customer']) ? 'selected' : '' : '' ?>
                                                                    value="<?php echo $rowOrder['id'] ?>"><?php echo $rowOrder['customer_name'] ?></option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">No Invoice</label>
                                                        <input type="text" class="form-control" name="order_code" value="#<?php echo $codeInput ?>" readonly>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Tanggal</label>
                                                        <input type="date"
                                                            class="form-control"
                                                            name="order_date"
                                                            placeholder="Masukkan tanggal"
                                                            required
                                                            value="<?php echo isset($_GET['edit']) ? $rowEdit['date'] : '' ?>">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-12">
                                                        <label for="" class="form-label">Keterangan</label>
                                                        <input type="text"
                                                            name="keterangan"
                                                            placeholder="Tulis Keterangan atau Note disini"
                                                            class=" form-control"
                                                            id="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Detail' ?> Transaksi</div>
                                            <div class="card-body">
                                                <?php if (isset($_GET['hapus'])): ?>
                                                    <div class="alert alert-success" role="alert">
                                                        Data berhasil dihapus
                                                    </div>
                                                <?php endif ?>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label for="" class="form-label"> Service</label>

                                                    </div>
                                                    <div class="col-sm-10">
                                                        <select data-mdb-select-init name="id_service[]" class="form-control">
                                                            <option value="">Pilih service</option>
                                                            <?php foreach ($rowService as $key => $value) { ?>
                                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['service_name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label for="" class="form-label">qty </label>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="qty[]" value="">
                                                    </div>

                                                </div>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label for="" class="form-label"> Service</label>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <select data-mdb-select-init name="id_service[]" class="form-control">
                                                            <option value="">Pilih service</option>
                                                            <?php foreach ($rowService as $key => $value) { ?>
                                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['service_name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label for="" class="form-label">qty </label>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="qty[]" value="">
                                                    </div>

                                                </div>

                                                <div class="mb-3">
                                                    <button class="btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>" type="submit">
                                                        Simpan
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    <?php endif ?>
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