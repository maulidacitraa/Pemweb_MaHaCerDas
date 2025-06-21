<?php
session_start();

if (!isset($_SESSION['nama']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit();
}

$conn = new mysqli("localhost", "root", "", "mahacerdas");
$pending = $conn->query("SELECT * FROM users WHERE validasi = 0");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Validasi Akun</title>
  <link rel="stylesheet" href="../css/admin.css"> 
</head>
<body>
<header class="topbar">
  <div class="logo">MaHa cerdAs</div>
  <nav>
    <a href="dashboard_admin.php">Dashboard</a>
    <a href="../logout.php" class="logout">Logout</a>
  </nav>
</header>

<main class="main">
  <h1>Validasi Akun Baru</h1>
  <table border="1" cellpadding="10">
    <tr>
      <th>Nama</th>
      <th>Email</th>
      <th>Role</th>
      <th>Aksi</th>
    </tr>
    <?php while ($row = $pending->fetch_assoc()) { ?>
      <tr>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['role']) ?></td>
        <td>
          <a href="validasi_proses.php?id=<?= $row['id'] ?>" onclick="return confirm('Validasi akun ini?')">Validasi</a>
        </td>
      </tr>
    <?php } ?>
  </table>
</main>
</body>
</html>
