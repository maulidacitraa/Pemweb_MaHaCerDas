<?php
session_start();
require_once '../koneksi.php';

// Pastikan user admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Proses tambah mapel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nama_mapel = mysqli_real_escape_string($conn, $_POST['nama_mapel']);
    $jenjang = mysqli_real_escape_string($conn, $_POST['jenjang']);

    $insert = "INSERT INTO mapel (nama_mapel, jenjang) VALUES ('$nama_mapel', '$jenjang')";
    if ($conn->query($insert)) {
        header("Location: kelola_mapel.php");
        exit();
    } else {
        echo "Gagal menambahkan mapel: " . $conn->error;
    }
}

// Ambil data mapel
$sql = "SELECT id, nama_mapel, jenjang FROM mapel ORDER BY id DESC";
$result = $conn->query($sql);
$mapel = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mapel[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Mapel</title>
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
    <h1>Kelola Mata Pelajaran</h1>

    <!-- Form Tambah Mapel -->
    <h2>Tambah Mata Pelajaran</h2>
    <form method="post" action="">
      <label>Nama Mapel:</label><br>
      <input type="text" name="nama_mapel" required><br><br>

      <label>Jenjang:</label><br>
      <input type="text" name="jenjang" required><br><br>

      <button type="submit" name="tambah">Tambah</button>
    </form>

    <br><hr><br>

    <!-- Tabel Data Mapel -->
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama Mapel</th>
          <th>Jenjang</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($mapel)): ?>
          <?php foreach ($mapel as $m): ?>
            <tr>
              <td><?= htmlspecialchars($m['id']) ?></td>
              <td><?= htmlspecialchars($m['nama_mapel']) ?></td>
              <td><?= htmlspecialchars($m['jenjang']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="3">Belum ada mata pelajaran.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
