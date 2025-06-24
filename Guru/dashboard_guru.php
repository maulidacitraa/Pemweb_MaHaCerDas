<?php
session_start();

// Cek apakah sudah login dan role-nya guru
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Guru</title>
  <link rel="stylesheet" href="../css/guru.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <!-- NAVBAR -->
  <header class="topbar">
    <div class="logo">MaHa cerdAs</div>
    <nav>
      <a href="dashboard_guru.php">Dashboard</a>
      <a href="../logout.php">Logout</a>
    </nav>
  </header>

  <!-- MAIN CONTENT -->
  <div class="main">
    <h1>Selamat Datang, <?= htmlspecialchars($_SESSION['nama']) ?>!</h1>
    <div class="cards">
      <div class="card blue">
        <h3>Kelola Materi</h3>
        <p>Buat dan edit materi pelajaran</p>
        <a href="kelola_materi.php" class="button">Lihat</a>
      </div>
      <div class="card green">
        <h3>Latihan Soal</h3>
        <p>Atur soal dan kunci jawaban</p>
        <a href="kelola_latihan.php" class="button">Lihat</a>
      </div>
      <div class="card yellow">
        <h3>Lihat Hasil Latihan Soal</h3>
        <p>Lihat hasil latihan soal siswa disini</p>
        <a href="lihat_hasil_siswa.php" class="button">Lihat</a>
      </div>
    </div>
  </div>
</body>
</html>
