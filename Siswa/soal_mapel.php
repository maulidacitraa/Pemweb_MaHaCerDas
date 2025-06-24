<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

$jenjang = $_SESSION['jenjang'] ?? 'SMP';

// List mapel sesuai jenjang
$mapelList = [
    'SMP' => ['Matematika', 'Bahasa Indonesia', 'IPA', 'IPS', 'PPKN'],
    'SMA' => ['Matematika', 'Fisika', 'Kimia', 'Biologi', 'Bahasa Inggris', 'Sejarah Indonesia']
];
$mapelJenjang = $mapelList[$jenjang] ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Latihan Soal - Pilih Mapel</title>
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

<main class="dashboard-container latihan-mapel">
    <a href="dashboard_siswa.php" class="back-button-mapel">← Kembali</a>
    <h2>Pilih Mata Pelajaran - Jenjang <?= htmlspecialchars($jenjang) ?></h2>

    <div class="menu-grid">
        <?php foreach ($mapelJenjang as $mapel): ?>
            <div class="menu-box">
                <h3><?= htmlspecialchars($mapel) ?></h3>
                <p>Latihan soal untuk mata pelajaran ini.</p>
                <a href="soal_siswa.php?mapel=<?= urlencode($mapel) ?>" class="button">Mulai</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
