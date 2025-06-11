<?php
// File: laporan_aktivitas.php
session_start();
if (!isset($_SESSION['nama']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.html");
  exit();
}
$conn = new mysqli("localhost", "root", "", "mahacerdas");
$data = $conn->query("SELECT * FROM aktivitas ORDER BY waktu DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Aktivitas</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="header">
  <div class="container header-content">
    <h1 class="logo">Laporan Aktivitas Pengguna</h1>
    <a href="dashboard.php" class="btn-login">Kembali</a>
  </div>
</header>
<section class="container">
  <table border="1" cellpadding="10">
    <tr>
      <th>Nama</th>
      <th>Role</th>
      <th>Aktivitas</th>
      <th>Waktu</th>
    </tr>
    <?php while ($row = $data->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $row['nama']; ?></td>
        <td><?php echo $row['role']; ?></td>
        <td><?php echo $row['aksi']; ?></td>
        <td><?php echo $row['waktu']; ?></td>
      </tr>
    <?php } ?>
  </table>
</section>
</body>
</html>
