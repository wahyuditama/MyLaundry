<?php
session_start();
include 'database/db.php';

// munculkan / pilih sebuah atau semua kolom dari table 
$queryOrder = mysqli_query($koneksi, "SELECT * FROM customer");

//join Dari Data detail_trans_order , service, trans_order
$id =  isset($_GET['ambil']) ? $_GET['ambil'] : '';
$querytrans_Detail = mysqli_query($koneksi, "SELECT customer.customer_name,customer.phone,
customer.alamat, trans_order.order_code,
trans_order.order_date,trans_order.status,trans_order.id_customer,
service.service_name,service.harga, 
detail_trans_order.*FROM detail_trans_order 
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
if (isset($_POST['simpan_transaksi'])) {
    $id_customer = $_POST['id_customer'];
    $id_order = $_POST['id_order'];
    $pickup_pay = $_POST['pickup_pay'];
    $pickup_change = $_POST['pickup_change'];

    $pickup_date = date("Y-m-d ");

    // insert ke table trans order 
    $insert = mysqli_query($koneksi, "INSERT INTO trans_laundry_pickup (id_customer, id_order, pickup_pay, pickup_change, pickup_date) VALUES ('$id_customer', '$id_order', '$pickup_pay', '$pickup_change', '$pickup_date')");


    //Ubah status Order jadi nilai[1]

    $update = mysqli_query($koneksi, "UPDATE trans_order SET status='1' WHERE id='$id_order'");

    header("location: trans-order.php?simpan=berhasil");
}

$queryPickup = mysqli_query($koneksi, "SELECT * FROM  trans_laundry_pickup WHERE id_order = '$id'");

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
                    <?php if (isset($_GET['ambil'])) : ?>
                        <!-- untuk detail -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <h5 class="m-0 p-0">Pengambilan Laundry : </h5>
                                                    <h5 class="text-warning fst-italic"><br> <?php echo $row[0]['customer_name'] ?></h5>
                                                </div>
                                                <div class="col-sm-6 mb-3 mb-sm-0" align="right">
                                                    <a href="trans-order.php" class="btn btn-secondary"><i class='bx bx-arrow-back'></i></a>
                                                    <a href="print.php?id=<?php echo $row[0]['id_order'] ?>" class="btn btn-success"><i class='bx bx-printer'></i></a>
                                                    <a href="tambah-pickup.php?ambil=<?php echo $row[0]['id_order'] ?>" class="btn btn-warning"><i class='bx bx-closet'></i></a>
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
                                            <form action="" method="POST">
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
                                                        $total = 0;
                                                        foreach ($row as $key => $value) : ?>
                                                            <tr>
                                                                <td> <?php echo $no++ ?></td>
                                                                <td> <?php echo $value['service_name'] ?></td>
                                                                <td> <?php echo $value['qty'] ?></td>
                                                                <td> <?php echo $value['harga'] ?></td>
                                                                <td> <?php echo $value['subtotal'] ?></td>
                                                            </tr>
                                                            <!-- Untuk menghitung total/sub-total -->
                                                            <?php
                                                            $total += $value['subtotal'];
                                                            ?>
                                                        <?php endforeach ?>
                                                        <tr>
                                                            <td colspan="4" class="text-left">
                                                                <strong>Total Keseluruhan :</strong>
                                                            </td>
                                                            <td>
                                                                <!-- panggil total disini -->
                                                                <strong><?php echo number_format($total) ?></strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-left">
                                                                <strong>Dibayar :</strong>
                                                            </td>
                                                            <td>
                                                                <strong>
                                                                    <?php if (mysqli_num_rows($queryPickup)): ?>
                                                                        <?php $rowPickup = mysqli_fetch_assoc($queryPickup); ?>
                                                                        <input type="text" name="pickup_pay" placeholder="dibayar" class="form-control" value="<?php echo number_format($rowPickup['pickup_pay']) ?>" readonly>
                                                                    <?php else: ?>
                                                                        <input type="text" name="pickup_pay" placeholder="dibayar" class="form-control" value="<?php echo isset($_POST['pickup_pay']) ?  $_POST['pickup_pay'] : '' ?>">
                                                                    <?php endif ?>
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-left">
                                                                <strong>Total Kembalian :</strong>
                                                            </td>
                                                            <?php if (isset($_POST['proses_pengembalian'])) {
                                                                $total = $_POST['total'];
                                                                $dibayar = $_POST['pickup_pay'];

                                                                $Kembalian = 0;
                                                                $Kembalian = (int)$dibayar - (int)$total;
                                                            } ?>
                                                            <td>
                                                                <input type="hidden" name="total" value="<?php echo $total ?>">
                                                                <input type="hidden" name="id_customer" value="<?php echo $row[0]['id_customer'] ?>">
                                                                <input type="hidden" name="id_order" value="<?php echo $row[0]['id_order'] ?>">
                                                                <strong>
                                                                    <?php if (mysqli_num_rows($queryPickup)): ?>
                                                                        <input type="text" name="" placeholder="Kembalian" class="form-control" value="<?php echo number_format($rowPickup['pickup_change']) ?>" readonly>
                                                                    <?php else: ?>
                                                                        <input type="text" name="pickup_change" placeholder="Kembalian" class="form-control" value="<?php echo isset($Kembalian) ? $Kembalian : 0 ?>" readonly>
                                                                    <?php endif ?>
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                        <?php if ($row[0]['status'] == 0) : ?>
                                                            <!-- button ini akan muncul saat meiliki status [0] -->
                                                            <tr>
                                                                <td colspan="5" class="text-left">
                                                                    <button class="btn-primary m-1" name="proses_pengembalian">Proses Kembalian</button>
                                                                    <button class="btn-success" name="simpan_transaksi">Simpan Transaksi</button>
                                                                </td>
                                                            </tr>
                                                        <?php endif ?>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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