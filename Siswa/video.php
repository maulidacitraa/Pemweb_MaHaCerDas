<?php
session_start();
if ($_SESSION['role'] != 'siswa') {
  header('Location: dashboard.php');
  exit();
}
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM video");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Video Pembelajaran</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Video Pembelajaran</h2>
    <?php while ($v = mysqli_fetch_assoc($result)) { ?>
      <div>
        <h4><?= $v['judul']; ?></h4>
        <iframe width="560" height="315" src="<?= $v['link']; ?>" frameborder="0" allowfullscreen></iframe>
      </div>
    <?php } ?>
  </div>
</body>
</html>
