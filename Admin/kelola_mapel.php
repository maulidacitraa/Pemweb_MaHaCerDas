<?php
session_start();
if ($_SESSION['role'] != 'admin') {
  header('Location: login.html');
  exit();
}
include 'koneksi.php';
$mapel = mysqli_query($conn, "SELECT * FROM mapel");
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Kelola Mapel</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
<h2>Mata Pelajaran</h2>
<ul><?php while($m = mysqli_fetch_assoc($mapel)) { ?><li><?= $m['nama_mapel'] ?> (<?= $m['jenjang'] ?>)</li><?php } ?></ul>
<form action="tambah_mapel.php" method="POST">
<input type="text" name="nama_mapel" placeholder="Nama Mapel" required>
<select name="jenjang">
<option value="SD">SD</option>
<option value="SMP">SMP</option>
<option value="SMA">SMA</option>
</select>
<button type="submit">Tambah</button>
</form></div></body></html>

