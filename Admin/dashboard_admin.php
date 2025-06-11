<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <h2>Selamat datang, Admin <?= htmlspecialchars($_SESSION['nama']); ?></h2>

    <nav>
        <ul>
            <li><a href="kelola_pengguna.php">Kelola Pengguna</a></li>
            <li><a href="kelola_mapel.php">Kelola Mapel</a></li>
            <li><a href="tambah_mapel.php">Tambah Mapel</a></li>
            <li><a href="validasi.php">Validasi Pengguna</a></li>
            <li><a href="laporan_aktivitas.php">Laporan Aktivitas</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>

    <section>
        <h3>Statistik Singkat</h3>
        <ul>
            <li>Total Pengguna: (ambil dari database)</li>
            <li>Mapel Tersedia: (ambil dari database)</li>
            <li>Validasi Tertunda: (ambil dari database)</li>
        </ul>
    </section>
</body>
</html>

