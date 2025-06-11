<?php
// File: upload_materi.php
session_start();
if (!isset($_SESSION['nama']) || $_SESSION['role'] !== 'guru') {
  header("Location: login.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Upload Materi</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="header">
    <div class="container header-content">
      <h1 class="logo">Upload Materi</h1>
      <a href="dashboard.php" class="btn-login">Kembali</a>
    </div>
  </header>

  <section class="container">
    <h2>Form Upload Materi</h2>
    <form action="proses_upload_materi.php" method="POST" enctype="multipart/form-data">
      <input type="text" name="judul" placeholder="Judul Materi" required><br>
      <textarea name="deskripsi" placeholder="Deskripsi Materi" required></textarea><br>
      <select name="jenjang">
        <option value="SD">SD</option>
        <option value="SMP">SMP</option>
        <option value="SMA">SMA</option>
      </select><br>
      <input type="file" name="file_materi" required><br>
      <button type="submit">Upload</button>
    </form>
  </section>
</body>
</html>
