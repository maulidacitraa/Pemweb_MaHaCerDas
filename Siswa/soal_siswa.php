<?php
session_start();
require_once '../koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

$id_siswa = $_SESSION['user_id'];
$nama     = $_SESSION['nama'] ?? 'Siswa';
$role     = $_SESSION['role'];
$jenjang  = $_SESSION['jenjang'];
$mapel    = $_GET['mapel'] ?? '';

if (!$mapel) {
    exit("Mapel tidak ditemukan.");
}

// Ambil soal
$stmt = $conn->prepare("SELECT * FROM soal WHERE jenjang = ? AND mapel = ? LIMIT 10");
if (!$stmt) {
    exit("Query error (soal): " . $conn->error);
}
$stmt->bind_param("ss", $jenjang, $mapel);
$stmt->execute();
$soal = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jawaban = $_POST['jawaban'] ?? [];

    if (empty($jawaban)) {
        exit("Tidak ada jawaban dikirim.");
    }

    $jumlah_soal = count($jawaban);
    $benar = 0;

    foreach ($jawaban as $id_soal => $jawaban_siswa) {
        $cek = $conn->prepare("SELECT jawaban FROM soal WHERE id = ?");
        if (!$cek) {
            exit("Query error (cek jawaban): " . $conn->error);
        }

        $cek->bind_param("i", $id_soal);
        $cek->execute();
        $res = $cek->get_result();
        $data = $res->fetch_assoc();

        $benar_jawab = strtoupper(trim($jawaban_siswa)) === strtoupper($data['jawaban']) ? 1 : 0;
        if ($benar_jawab) $benar++;

        $insert = $conn->prepare("INSERT INTO jawaban_siswa (id_siswa, id_soal, jawaban, benar) VALUES (?, ?, ?, ?)");
        if ($insert) {
            $insert->bind_param("iisi", $id_siswa, $id_soal, $jawaban_siswa, $benar_jawab);
            $insert->execute();
        }
    }

    $salah = $jumlah_soal - $benar;
    $nilai = round(($benar / $jumlah_soal) * 100);

    // Simpan ke hasil_latihan
    $hasil = $conn->prepare("INSERT INTO hasil_latihan (id_siswa, mapel, jenjang, jumlah_soal, benar, salah, nilai) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($hasil) {
        $hasil->bind_param("issiiii", $id_siswa, $mapel, $jenjang, $jumlah_soal, $benar, $salah, $nilai);
        $hasil->execute();
    } else {
        exit("Query error (hasil_latihan): " . $conn->error);
    }

    // Simpan ke log aktivitas
    $aktivitas = "$nama menyelesaikan latihan mapel $mapel";
    $log = $conn->prepare("INSERT INTO aktivitas (user, role, aktivitas) VALUES (?, ?, ?)");
    if ($log) {
        $log->bind_param("sss", $nama, $role, $aktivitas);
        $log->execute();
    }

    $_SESSION['nilai_terakhir']   = $nilai;
    $_SESSION['benar']            = $benar;
    $_SESSION['salah']            = $salah;
    $_SESSION['mapel_terakhir']   = $mapel;

    header("Location: hasil_nilai.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Latihan Soal - <?= htmlspecialchars($mapel) ?></title>
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
  <h2>Latihan Soal: <?= htmlspecialchars($mapel) ?> (<?= htmlspecialchars($jenjang) ?>)</h2>
  <?php if ($soal->num_rows > 0): ?>
    <form method="post">
      <?php $no = 1; while ($row = $soal->fetch_assoc()): ?>
        <div class="soal-box">
          <p><strong><?= $no++ ?>.</strong> <?= htmlspecialchars($row['pertanyaan']) ?></p>
          <?php foreach (['A', 'B', 'C', 'D'] as $opt): ?>
            <label>
              <input type="radio" name="jawaban[<?= $row['id'] ?>]" value="<?= $opt ?>" required>
              <?= $opt ?>. <?= htmlspecialchars($row["pilihan_" . strtolower($opt)]) ?>
            </label><br>
          <?php endforeach; ?>
        </div>
        <hr>
      <?php endwhile; ?>
      <button type="submit">Selesai</button>
    </form>
  <?php else: ?>
    <p>Belum ada soal untuk mapel ini.</p>
  <?php endif; ?>
</main>
</body>
</html>