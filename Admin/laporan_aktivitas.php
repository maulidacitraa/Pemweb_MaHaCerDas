<?php
session_start();
require_once '../koneksi.php';

// Cek role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Ambil data aktivitas (tanpa join, karena tabel aktivitas menyimpan 'user' langsung)
$sql = "SELECT * FROM aktivitas ORDER BY waktu DESC";
$result = $conn->query($sql);
$log = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $log[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Aktivitas</title>
  <link rel="stylesheet" href="../css/admin.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
</head>
<body>
  <div class="sidebar">
    <h2>Admin</h2>
    <ul>
      <li><a href="dashboard_admin.php">Dashboard</a></li>
      <li><a href="kelola_pengguna.php">Kelola Pengguna</a></li>
      <li><a href="kelola_mapel.php">Kelola Mapel</a></li>
      <li><a href="laporan_aktivitas.php">Laporan Aktivitas</a></li>
      <li><a href="../logout.php">Logout</a></li>
    </ul>
  </div>

  <div class="main">
    <h1>Laporan Aktivitas</h1>

    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Role</th>
          <th>Aktivitas</th>
          <th>Waktu</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($log)): ?>
          <?php foreach ($log as $item): ?>
            <tr>
              <td><?= htmlspecialchars($item['user']) ?></td>
              <td><?= htmlspecialchars($item['role']) ?></td>
              <td><?= htmlspecialchars($item['aktivitas']) ?></td>
              <td><?= htmlspecialchars($item['waktu']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4">Belum ada aktivitas tercatat.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
