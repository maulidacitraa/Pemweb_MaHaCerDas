<!-- tambah_mapel.php -->
<?php
include 'koneksi.php';
$nama = $_POST['nama_mapel'];
$jenjang = $_POST['jenjang'];
mysqli_query($conn, "INSERT INTO mapel (nama_mapel, jenjang) VALUES ('$nama','$jenjang')");
header("Location: kelola_mapel.php");
?>

