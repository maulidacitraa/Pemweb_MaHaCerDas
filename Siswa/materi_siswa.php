<?php
session_start();
require_once '../koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

$id_siswa = $_SESSION['user_id'];
$nama     = $_SESSION['nama'] ?? 'Siswa';
$role     = $_SESSION['role'] ?? 'siswa';
$jenjang  = $_SESSION['jenjang'] ?? 'SMP';
$mapel    = $_GET['mapel'] ?? '';

if (empty($mapel)) {
    echo "<script>alert('Mapel tidak ditemukan.'); window.location='materi_mapel.php';</script>";
    exit;
}

$aktivitas = "$nama mengakses materi mapel $mapel";
$log = $conn->prepare("INSERT INTO aktivitas (user_id, role, aktivitas) VALUES (?, ?, ?)");
if ($log) {
    $log->bind_param("iss", $id_siswa, $role, $aktivitas);
    $log->execute();
}

$jenjang_lower = strtolower($jenjang);
$mapel_lower   = strtolower($mapel);

$stmt = $conn->prepare("SELECT * FROM materi WHERE LOWER(jenjang) = ? AND LOWER(mapel) = ?");
if (!$stmt) {
    die("Query error: " . $conn->error);
}
$stmt->bind_param("ss", $jenjang_lower, $mapel_lower);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Materi <?= htmlspecialchars($mapel) ?></title>
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

<main class="main">
  <a href="materi_mapel.php?jenjang=<?= urlencode($jenjang) ?>" class="back-button">← Kembali</a> 

  <h2>Materi <?= htmlspecialchars($mapel) ?> (<?= htmlspecialchars($jenjang) ?>)</h2>

  <div class="materi-list">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="materi-card">
          <h3><?= htmlspecialchars($row['judul']) ?></h3>
          <p><?= htmlspecialchars($row['deskripsi']) ?></p>
          <a href="../uploads/<?= htmlspecialchars($row['file']) ?>" target="_blank" class="btn-materi-siswa">Lihat Materi</a>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>Tidak ada materi untuk mapel ini.</p>
    <?php endif; ?>
  </div>
</main>
</body>
</html>