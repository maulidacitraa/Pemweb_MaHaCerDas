<?php
session_start();
require_once '../koneksi.php';

// Cek apakah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Proses validasi user jika ada permintaan
if (isset($_GET['verifikasi'])) {
    $id = intval($_GET['verifikasi']);
    $stmt = $conn->prepare("UPDATE users SET validasi = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: kelola_pengguna.php");
    exit();
}

// Ambil semua pengguna dari database (kecuali admin)
$sql = "SELECT id, nama, email, role, validasi FROM users WHERE role != 'admin' ORDER BY nama ASC";
$result = $conn->query($sql);
$pengguna = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pengguna[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Pengguna</title>
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
    <h1>Kelola Pengguna</h1>

    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Role</th>
          <th>Validasi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($pengguna)): ?>
          <?php foreach ($pengguna as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['nama']) ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td><?= htmlspecialchars($user['role']) ?></td>
              <td><?= $user['validasi'] ? 'Tervalidasi' : 'Belum' ?></td>
              <td>
                <?php if (!$user['validasi']): ?>
                  <a href="?verifikasi=<?= $user['id'] ?>" onclick="return confirm('Validasi pengguna ini?')">Validasi</a>
                <?php else: ?>
                  <span>✓</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="5">Tidak ada pengguna ditemukan.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
