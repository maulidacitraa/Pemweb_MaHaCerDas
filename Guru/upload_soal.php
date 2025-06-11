<?php
session_start();
if ($_SESSION['role'] != 'guru') {
  header('Location: dashboard.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Upload Soal</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Upload Soal Baru</h2>
    <form action="proses_upload_soal.php" method="POST">
      <input type="text" name="pertanyaan" placeholder="Tulis pertanyaan..." required><br>
      <input type="text" name="opsi_a" placeholder="Pilihan A" required><br>
      <input type="text" name="opsi_b" placeholder="Pilihan B" required><br>
      <input type="text" name="opsi_c" placeholder="Pilihan C" required><br>
      <input type="text" name="opsi_d" placeholder="Pilihan D" required><br>
      <input type="text" name="jawaban" placeholder="Jawaban Benar (A/B/C/D)" maxlength="1" required><br>
      <button type="submit">Upload Soal</button>
    </form>
  </div>
</body>
</html>
