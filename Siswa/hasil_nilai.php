<?php
session_start();

if (!isset($_SESSION['nilai_terakhir'])) {
    header("Location: dashboard_siswa.php");
    exit;
}

$nilai   = $_SESSION['nilai_terakhir'];
$benar   = $_SESSION['benar'];
$salah   = $_SESSION['salah'];
$mapel   = $_SESSION['mapel_terakhir'] ?? '';
$jenjang = $_SESSION['jenjang'] ?? '';

// Hapus data setelah ditampilkan
unset($_SESSION['nilai_terakhir'], $_SESSION['benar'], $_SESSION['salah'], $_SESSION['mapel_terakhir']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hasil Nilai</title>
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
  <div class="score-card">
    <h2>Hasil Latihan: <?= htmlspecialchars($mapel) ?> (<?= htmlspecialchars($jenjang) ?>)</h2>

    <div class="score-value <?= $nilai < 60 ? 'red' : '' ?>">
      <?= $nilai ?>
    </div>

    <div class="score-details">
      <p><strong>Benar:</strong> <?= $benar ?> | <strong>Salah:</strong> <?= $salah ?></p>
    </div>

    <a href="dashboard_siswa.php" class="btn-kembali">← Kembali ke Dashboard</a>
  </div>
</main>

</body>
</html>
