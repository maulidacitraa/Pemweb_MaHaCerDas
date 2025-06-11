<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Guru</title>
    <link rel="stylesheet" href="css/guru.css">
</head>
<body>
    <h2>Selamat datang, Guru <?= htmlspecialchars($_SESSION['nama']); ?></h2>

    <nav>
        <ul>
            <li><a href="upload_materi.php">Upload Materi</a></li>
            <li><a href="upload_soal.php">Upload Soal</a></li>
            <li><a href="upload_video.php">Upload Video</a></li>
            <li><a href="lihat_hasil_siswa.php">Lihat Hasil Siswa</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>

    <section>
        <h3>Statistik Guru</h3>
        <ul>
            <li>Materi Diupload: (ambil dari database)</li>
            <li>Soal Diupload: (ambil dari database)</li>
            <li>Video Diupload: (ambil dari database)</li>
        </ul>
    </section>
</body>
</html>

