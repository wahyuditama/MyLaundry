<?php
session_start();

// empty() : kosong
if (empty($_SESSION['NAMA'])) {
  header("location:login.php?access=failed");
}
include 'koneksi.php';
include 'function/helper.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Perpus</title>
  <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css" />
</head>

<body>
  <div class="wrapper">
    <?php include 'inc/navbar.php'; ?>

    <div class="content">
      <?php
      if (isset($_GET['pg'])) {
        if (file_exists('content/' . $_GET['pg'] . '.php')) {
          include 'content/' . $_GET['pg'] . '.php';
        } else {
          echo "<h1>Halaman tidak ditemukan</h1>";
        }
      } else {
        include 'content/dashboard.php';
      }
      ?>
    </div>

    <!-- <footer class="text-center  p-3">Copyright &copy; 2024 PPKD - Jakarta Pusat.</footer> -->
  </div>
  <!-- <script src="assets/dist/js/jquery-3.7.1.min.js"></script> -->
  <!-- <script src="assets/dist/js/bootstrap.min.js"></script> -->
  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="app.js"></script>


</body>

</html>