<?php
session_start();
if ($_SESSION['role'] != 'siswa') {
  header('Location: dashboard.php');
  exit();
}
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM hasil WHERE siswa='".$_SESSION['nama']."'");
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Hasil Nilai</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
  <h2>Nilai Kamu</h2>
  <table border="1" cellpadding="10">
    <tr><th>No</th><th>Soal</th><th>Jawaban</th><th>Nilai</th></tr>
    <?php $no=1; while($r = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $r['soal'] ?></td>
        <td><?= $r['jawaban'] ?></td>
        <td><?= $r['nilai'] ?></td>
      </tr>
    <?php } ?>
  </table>
</div></body></html>
