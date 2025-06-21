<?php
session_start();
require_once '../koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

$id_siswa = $_SESSION['user_id'];
$nama_siswa = $_SESSION['nama'] ?? '';
$jenjang = $_SESSION['jenjang'] ?? '';

// Ambil hasil latihan
$stmt = $conn->prepare("SELECT * FROM hasil_latihan WHERE id_siswa = ? ORDER BY tanggal DESC");
$stmt->bind_param("i", $id_siswa);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Nilai</title>
  <link rel="stylesheet" href="../css/siswa.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<header class="topbar">
  <div class="logo">MaHa cerdAs</div>
  <nav>
    <a href="dashboard_siswa.php">Dashboard</a>
    <a href="../logout.php">Logout</a>
  </nav>
</header>

<main class="dashboard-container">
  <a href="dashboard_siswa.php" class="back-button">← Kembali</a>
  <h2>Riwayat Nilai Latihan</h2>

  <!-- FLASH NILAI JIKA ADA -->
  <?php if (isset($_SESSION['nilai_terakhir'])): ?>
    <div class="flash-msg success" style="margin-bottom: 20px;">
      ✅ Latihan terakhir kamu: <strong><?= $_SESSION['nilai_terakhir'] ?></strong>
    </div>
    <?php unset($_SESSION['nilai_terakhir']); ?>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Mapel</th>
        <th>Jenjang</th>
        <th>Benar</th>
        <th>Salah</th>
        <th>Nilai</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): $no = 1; ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['mapel']) ?></td>
            <td><?= htmlspecialchars($row['jenjang']) ?></td>
            <td><?= $row['benar'] ?></td>
            <td><?= $row['salah'] ?></td>
            <td><strong><?= $row['nilai'] ?></strong></td>
            <td><?= date("d-m-Y H:i", strtotime($row['tanggal'])) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" style="text-align: center;">Belum ada data latihan.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>

</body>
</html>
