<?php
session_start();
require_once '../koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

$id_siswa = $_SESSION['user_id'];
$jenjang = $_SESSION['jenjang'] ?? 'SMP';
$mapel = $_POST['mapel'] ?? '';
$jawaban = $_POST['jawaban'] ?? [];

if (empty($mapel) || empty($jawaban)) {
    echo "Data tidak lengkap.";
    exit;
}

// Ambil kunci jawaban
$ids = array_keys($jawaban);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$paramTypes = str_repeat('i', count($ids));

$query = "SELECT id, jawaban FROM soal WHERE id IN ($placeholders)";
$stmt = $conn->prepare($query);
$stmt->bind_param($paramTypes, ...$ids);
$stmt->execute();
$result = $stmt->get_result();

$kunci = [];
while ($row = $result->fetch_assoc()) {
    $kunci[$row['id']] = $row['jawaban'];
}

// Hitung skor
$total = count($kunci);
$benar = 0;

foreach ($jawaban as $id => $jwb) {
    if (isset($kunci[$id]) && strtoupper($kunci[$id]) === strtoupper($jwb)) {
        $benar++;
    }
}

$salah = $total - $benar;
$nilai = round(($benar / $total) * 100);

// Simpan ke DB
$stmt = $conn->prepare("INSERT INTO hasil_latihan (id_siswa, mapel, jenjang, total_soal, benar, salah, nilai) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issiiii", $id_siswa, $mapel, $jenjang, $total, $benar, $salah, $nilai);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hasil Latihan</title>
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
    <h2>Hasil Latihan: <?= htmlspecialchars($mapel) ?></h2>
    <p><strong>Jenjang:</strong> <?= htmlspecialchars($jenjang) ?></p>
    <p><strong>Total Soal:</strong> <?= $total ?></p>
    <p><strong>Benar:</strong> <?= $benar ?></p>
    <p><strong>Salah:</strong> <?= $salah ?></p>
    <p><strong>Nilai:</strong> <?= $nilai ?></p>

    <a href="soal_siswa.php?jenjang=<?= urlencode($jenjang) ?>" class="btn-kembali">← Kembali ke Pilihan Mapel</a>
  </main>
</body>
</html>
