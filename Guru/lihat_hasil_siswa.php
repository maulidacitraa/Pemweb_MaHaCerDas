<?php
session_start();
if ($_SESSION['role'] != 'guru') {
  header('Location: dashboard.php');
  exit();
}
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM hasil ORDER BY siswa");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lihat Hasil Siswa</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Hasil Latihan Siswa</h2>
    <table border="1" cellpadding="10">
      <tr><th>No</th><th>Nama Siswa</th><th>Soal</th><th>Jawaban</th><th>Nilai</th></tr>
      <?php $no=1; while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $row['siswa'] ?></td>
          <td><?= $row['soal'] ?></td>
          <td><?= $row['jawaban'] ?></td>
          <td><?= $row['nilai'] ?></td>
        </tr>
      <?php } ?>
    </table>
  </div>
</body>
</html>
