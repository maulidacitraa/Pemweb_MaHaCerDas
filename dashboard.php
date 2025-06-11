<?php
session_start();
if (!isset($_SESSION['nama']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin - MaHa cerdAs</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="header">
    <div class="container header-content">
      <h1 class="logo">Dashboard - Admin</h1>
      <a href="logout.php" class="btn-login">Logout</a>
    </div>
  </header>

  <section class="container">
    <h2>Selamat datang Admin, <?php echo $_SESSION['nama']; ?>!</h2>
    <ul>
      <li><a href="validasi_akun.php">Validasi Pendaftaran</a></li>
      <li><a href="kelola_pengguna.php">Kelola Data Pengguna</a></li>
      <li><a href="kelola_mapel.php">Kelola Mata Pelajaran</a></li>
      <li><a href="laporan_aktivitas.php">Laporan Aktivitas Pengguna</a></li>
    </ul>
  </section>
</body>
</html>
