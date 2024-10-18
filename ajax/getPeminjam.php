<?php
include '../koneksi.php';

if (isset($_GET['no_peminjaman'])) {
    $no_peminjaman = $_GET['no_peminjaman'];

    $query = mysqli_query($koneksi, "SELECT * FROM  peminjaman 
    LEFT JOIN anggota ON anggota.id = peminjaman.id_anggota
     WHERE no_peminjaman='$no_peminjaman'");

    $data  = mysqli_fetch_assoc($query);
    $response = ['data' => $data, 'message' => 'Fetch success'];
    echo json_encode($response);
}
