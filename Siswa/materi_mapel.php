<?php
session_start();
require_once '../koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

$jenjang = $_GET['jenjang'] ?? ($_SESSION['jenjang'] ?? 'SMP');
$stmt = $conn->prepare("
    SELECT DISTINCT mapel 
    FROM materi 
    WHERE jenjang = ?
    ORDER BY mapel ASC
");
$stmt->bind_param("s", $jenjang);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pilih Mata Pelajaran</title>
  <link rel="stylesheet" href="../css/siswa.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
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
  <a href="dashboard_siswa.php" class="back-button">← Kembali</a>

  <h2>Pilih Mata Pelajaran (<?= htmlspecialchars($jenjang) ?>)</h2>

  <div class="grid-materi">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="materi-card">
          <h3><?= htmlspecialchars($row['mapel']) ?></h3>
          <a href="materi_siswa.php?mapel=<?= urlencode($row['mapel']) ?>" class="btn-materi-mapel">Lihat Materi</a>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>Tidak ada mata pelajaran tersedia.</p>
    <?php endif; ?>
  </div>
</main>
</body>
</html>
