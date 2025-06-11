<?php
// File: kelola_pengguna.php
session_start();
if (!isset($_SESSION['nama']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.html");
  exit();
}
$conn = new mysqli("localhost", "root", "", "mahacerdas");
$data = $conn->query("SELECT * FROM users WHERE validasi = 1");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Pengguna</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="header">
  <div class="container header-content">
    <h1 class="logo">Kelola Pengguna</h1>
    <a href="dashboard.php" class="btn-login">Kembali</a>
  </div>
</header>
<section class="container">
  <table border="1" cellpadding="10">
    <tr>
      <th>Nama</th>
      <th>Email</th>
      <th>Role</th>
      <th>Aksi</th>
    </tr>
    <?php while ($row = $data->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $row['nama']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['role']; ?></td>
        <td><a href="hapus_pengguna.php?id=<?php echo $row['id']; ?>">Hapus</a></td>
      </tr>
    <?php } ?>
  </table>
</section>
</body>
</html>
