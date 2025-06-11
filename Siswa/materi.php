<?php
session_start();
if ($_SESSION['role'] != 'siswa') {
  header('Location: dashboard.php');
  exit();
}
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM materi ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Materi Pembelajaran</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Materi Pembelajaran</h2>
    <ul>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <li>
          <h4><?= $row['judul']; ?></h4>
          <p><?= $row['deskripsi']; ?></p>
          <a href="uploads/<?= $row['file']; ?>" target="_blank">Unduh Materi</a>
        </li>
      <?php } ?>
    </ul>
    <a href="dashboard.php">Kembali</a>
  </div>
</body>
</html>
