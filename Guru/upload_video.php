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
  <title>Upload Video</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Upload Video Pembelajaran</h2>
    <form action="proses_upload_video.php" method="POST">
      <input type="text" name="judul" placeholder="Judul Video" required><br>
      <input type="url" name="link" placeholder="Link Youtube Embed" required><br>
      <button type="submit">Upload</button>
    </form>
  </div>
</body>
</html>
