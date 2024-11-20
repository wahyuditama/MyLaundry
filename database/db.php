<?php 

$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname = 'laundry';

$koneksi = mysqli_connect($hostname, $username, $password, $dbname);

if (!$koneksi) {
    die('Gagal koneksi: ');
}