<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Siswa - MahaCerdas</title>
  <link rel="stylesheet" href="css/siswa.css" />
</head>
<body>

  <nav>
    <div class="logo">MahaCerdas</div>
    <ul>
      <li><a href="#">Dashboard</a></li>
      <li><a href="#">Profil</a></li>
      <li><a href="#">Logout</a></li>
    </ul>
  </nav>

  <div class="container">
    <div class="welcome">Selamat datang, <strong>Siswa!</strong></div>

    <div class="cards">
      <div class="card">
        <img src="assets/img/materi.svg" alt="Materi">
        <h3>Materi Interaktif</h3>
        <p>Belajar dengan materi sesuai jenjang dan kurikulum.</p>
      </div>
      <div class="card">
        <img src="assets/img/soal.svg" alt="Soal">
        <h3>Latihan Soal</h3>
        <p>Uji kemampuanmu dengan soal adaptif dan pembahasan.</p>
      </div>
      <div class="card">
        <img src="assets/img/video.svg" alt="Video">
        <h3>Video Pembelajaran</h3>
        <p>Tonton video guru terbaik dengan visual menarik.</p>
      </div>
    </div>
  </div>

  <footer>
    &copy; 2025 MahaCerdas. Semua hak dilindungi.
  </footer>

</body>
</html>

