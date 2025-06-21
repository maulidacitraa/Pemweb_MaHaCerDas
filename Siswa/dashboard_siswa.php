<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

$nama = $_SESSION['nama'] ?? 'Siswa';
$jenjang = $_SESSION['jenjang'] ?? 'Belum ditentukan';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Siswa</title>
  <link rel="stylesheet" href="../css/siswa.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

  <!-- NAVBAR -->
  <header class="topbar">
    <div class="logo">MaHa cerdAs</div>
    <nav>
      <a href="#">Dashboard</a>
      <a href="../logout.php" class="logout">Logout</a>
    </nav>
  </header>

  <!-- MAIN CONTENT -->
  <main class="main">
    <h1>Selamat Datang, <?= htmlspecialchars($nama) ?>!</h1>

    <div class="card-grid">
      <div class="card blue">
        <h3>Materi Pembelajaran</h3>
        <p>Lihat materi sesuai jenjang kamu: <strong><?= htmlspecialchars($jenjang) ?></strong></p>
        <a href="materi_mapel.php?jenjang=<?= urlencode($jenjang) ?>">Lihat</a>
      </div>

      <div class="card green">
        <h3>Latihan Soal</h3>
        <p>Mengerjakan soal & cek nilai langsung.</p>
        <a href="soal_mapel.php?jenjang=<?= urlencode($jenjang) ?>">Mulai Latihan</a>
      </div>

      <div class="card orange">
        <h3>Riwayat Nilai</h3>
        <p>Lihat hasil & progres kamu.</p>
        <a href="riwayat_latihan.php">Lihat Hasil</a>
      </div>
    </div>
  </main>

</body>
</html>
