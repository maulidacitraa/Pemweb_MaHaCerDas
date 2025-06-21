<?php
session_start();
require_once '../koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}

$id_guru = $_SESSION['user_id'];
$errors = [];

// Proses tambah soal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mapel = mysqli_real_escape_string($conn, $_POST['mapel']);
    $jenjang = mysqli_real_escape_string($conn, $_POST['jenjang']);
    $pertanyaan = mysqli_real_escape_string($conn, $_POST['pertanyaan']);
    $a = mysqli_real_escape_string($conn, $_POST['opsi_a']);
    $b = mysqli_real_escape_string($conn, $_POST['opsi_b']);
    $c = mysqli_real_escape_string($conn, $_POST['opsi_c']);
    $d = mysqli_real_escape_string($conn, $_POST['opsi_d']);
    $jawaban = mysqli_real_escape_string($conn, $_POST['jawaban']);

    if (!$mapel || !$jenjang || !$pertanyaan || !$a || !$b || !$c || !$d || !$jawaban) {
        $errors[] = "Semua field harus diisi.";
    } else {
        $insert = "INSERT INTO soal (jenjang, mapel, pertanyaan, pilihan_a, pilihan_b, pilihan_c, pilihan_d, jawaban, id_guru)
                   VALUES ('$jenjang', '$mapel', '$pertanyaan', '$a', '$b', '$c', '$d', '$jawaban', $id_guru)";
        if (!mysqli_query($conn, $insert)) {
            $errors[] = "Gagal menambahkan soal: " . mysqli_error($conn);
        } else {
            // Catat aktivitas guru
            $nama = $_SESSION['nama'] ?? 'Guru';
            $role = $_SESSION['role'] ?? 'guru';
            $aktivitas = "$nama menambahkan soal $mapel untuk jenjang $jenjang";

            $log = $conn->prepare("INSERT INTO aktivitas (user_id, role, aktivitas) VALUES (?, ?, ?)");
            $log->bind_param("iss", $id_guru, $role, $aktivitas);
            $log->execute();
        }
    }
}

// Ambil soal guru
$query = "SELECT * FROM soal WHERE id_guru = $id_guru ORDER BY tanggal_upload DESC";
$soal = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Latihan Soal</title>
  <link rel="stylesheet" href="../css/guru.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <header class="topbar">
    <div class="logo">MaHa cerdAs</div>
    <nav>
      <a href="dashboard_guru.php">Dashboard</a>
      <a href="../logout.php">Logout</a>
    </nav>
  </header>

  <main class="main">
    <a href="dashboard_guru.php" class="back-button">← Kembali</a>
    <h1>Kelola Latihan Soal</h1>

    <?php if (!empty($errors)): ?>
      <div style="color: red;">
        <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
      </div>
    <?php endif; ?>

    <section class="form-container">
      <h2>Tambah Soal</h2>
      <form method="post">
        <div class="form-group">
          <label>Mapel</label>
          <input type="text" name="mapel" required>
        </div>
        <div class="form-group">
          <label>Jenjang</label>
          <select name="jenjang" required>
            <option value="">-- Pilih Jenjang --</option>
            <option value="SMP">SMP</option>
            <option value="SMA">SMA</option>
          </select>
        </div>
        <div class="form-group">
          <label>Pertanyaan</label>
          <textarea name="pertanyaan" rows="3" required></textarea>
        </div>
        <div class="form-group">
          <label>Pilihan Jawaban</label>
          <input type="text" name="opsi_a" placeholder="Pilihan A" required>
          <input type="text" name="opsi_b" placeholder="Pilihan B" required>
          <input type="text" name="opsi_c" placeholder="Pilihan C" required>
          <input type="text" name="opsi_d" placeholder="Pilihan D" required>
        </div>
        <div class="form-group">
          <label>Kunci Jawaban</label>
          <select name="jawaban" required>
            <option value="">-- Pilih Jawaban Benar --</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
          </select>
        </div>
        <button type="submit">Simpan</button>
      </form>
    </section>

    <section class="table-section">
      <h2>Daftar Soal</h2>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Mapel</th>
            <th>Pertanyaan</th>
            <th>Pilihan</th>
            <th>Jawaban</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($soal && mysqli_num_rows($soal) > 0): ?>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($soal)): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['mapel']) ?></td>
                <td><?= htmlspecialchars($row['pertanyaan']) ?></td>
                <td>
                  A. <?= htmlspecialchars($row['pilihan_a']) ?><br>
                  B. <?= htmlspecialchars($row['pilihan_b']) ?><br>
                  C. <?= htmlspecialchars($row['pilihan_c']) ?><br>
                  D. <?= htmlspecialchars($row['pilihan_d']) ?>
                </td>
                <td><?= htmlspecialchars($row['jawaban']) ?></td>
                <td>
                  <a href="#">Edit</a> |
                  <a href="#">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="6">Belum ada soal.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>
  </main>
</body>
</html>
