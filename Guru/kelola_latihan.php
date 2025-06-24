<?php
session_start();
require_once '../koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}

$id_guru = $_SESSION['user_id'];
$errors = [];
$editData = null;

// HAPUS
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $stmt = $conn->prepare("DELETE FROM soal WHERE id = ? AND id_guru = ?");
    $stmt->bind_param("ii", $id, $id_guru);
    $stmt->execute();
    echo "<script>alert('Soal berhasil dihapus'); window.location='kelola_latihan.php';</script>";
    exit;
}

// EDIT LOAD DATA
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM soal WHERE id = ? AND id_guru = ?");
    $stmt->bind_param("ii", $id, $id_guru);
    $stmt->execute();
    $res = $stmt->get_result();
    $editData = $res->fetch_assoc();
}

// UPDATE
if (isset($_POST['update_id'])) {
    $id_update = intval($_POST['update_id']);
    $mapel = trim($_POST['mapel'] ?? '');
    $jenjang = trim($_POST['jenjang'] ?? '');
    $pertanyaan = trim($_POST['pertanyaan'] ?? '');
    $a = trim($_POST['opsi_a'] ?? '');
    $b = trim($_POST['opsi_b'] ?? '');
    $c = trim($_POST['opsi_c'] ?? '');
    $d = trim($_POST['opsi_d'] ?? '');
    $jawaban = trim($_POST['jawaban'] ?? '');

    if (!$mapel || !$jenjang || !$pertanyaan || !$a || !$b || !$c || !$d || !$jawaban) {
        $errors[] = "❗ Semua field harus diisi.";
    } else {
        $stmt = $conn->prepare("UPDATE soal SET jenjang=?, mapel=?, pertanyaan=?, pilihan_a=?, pilihan_b=?, pilihan_c=?, pilihan_d=?, jawaban=? WHERE id=? AND id_guru=?");
        $stmt->bind_param("ssssssssii", $jenjang, $mapel, $pertanyaan, $a, $b, $c, $d, $jawaban, $id_update, $id_guru);
        $stmt->execute();

        echo "<script>alert('✅ Soal berhasil diperbarui!'); window.location='kelola_latihan.php';</script>";
        exit;
    }
}

// TAMBAH
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['update_id'])) {
    $mapel = trim($_POST['mapel'] ?? '');
    $jenjang = trim($_POST['jenjang'] ?? '');
    $pertanyaan = trim($_POST['pertanyaan'] ?? '');
    $a = trim($_POST['opsi_a'] ?? '');
    $b = trim($_POST['opsi_b'] ?? '');
    $c = trim($_POST['opsi_c'] ?? '');
    $d = trim($_POST['opsi_d'] ?? '');
    $jawaban = trim($_POST['jawaban'] ?? '');

    if (!$mapel || !$jenjang || !$pertanyaan || !$a || !$b || !$c || !$d || !$jawaban) {
        $errors[] = "❗ Semua field harus diisi.";
    } else {
        $insert = $conn->prepare("INSERT INTO soal 
            (jenjang, mapel, pertanyaan, pilihan_a, pilihan_b, pilihan_c, pilihan_d, jawaban, id_guru)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("ssssssssi", $jenjang, $mapel, $pertanyaan, $a, $b, $c, $d, $jawaban, $id_guru);
        $insert->execute();

        echo "<script>alert('✅ Soal berhasil ditambahkan!'); window.location='kelola_latihan.php';</script>";
        exit;
    }
}

// AMBIL SEMUA SOAL
$query = "SELECT * FROM soal WHERE id_guru = ? ORDER BY tanggal_upload DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_guru);
$stmt->execute();
$soal = $stmt->get_result();
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
        <?php if ($editData): ?>
          <input type="hidden" name="update_id" value="<?= $editData['id'] ?>">
        <?php endif; ?>

        <div class="form-group">
          <label>Mapel</label>
          <input type="text" name="mapel" value="<?= htmlspecialchars($editData['mapel'] ?? '') ?>" required>
        </div>

        <div class="form-group">
          <label>Jenjang</label>
          <select name="jenjang" required>
            <option value="">-- Pilih Jenjang --</option>
            <option value="SMP" <?= (isset($editData) && $editData['jenjang'] == 'SMP') ? 'selected' : '' ?>>SMP</option>
            <option value="SMA" <?= (isset($editData) && $editData['jenjang'] == 'SMA') ? 'selected' : '' ?>>SMA</option>
          </select>
        </div>

        <div class="form-group">
          <label>Pertanyaan</label>
          <textarea name="pertanyaan" rows="3" required><?= htmlspecialchars($editData['pertanyaan'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
          <label>Pilihan Jawaban</label>
          <input type="text" name="opsi_a" placeholder="Pilihan A" value="<?= htmlspecialchars($editData['pilihan_a'] ?? '') ?>" required>
          <input type="text" name="opsi_b" placeholder="Pilihan B" value="<?= htmlspecialchars($editData['pilihan_b'] ?? '') ?>" required>
          <input type="text" name="opsi_c" placeholder="Pilihan C" value="<?= htmlspecialchars($editData['pilihan_c'] ?? '') ?>" required>
          <input type="text" name="opsi_d" placeholder="Pilihan D" value="<?= htmlspecialchars($editData['pilihan_d'] ?? '') ?>" required>
        </div>

        <div class="form-group">
          <label>Kunci Jawaban</label>
          <select name="jawaban" required>
            <option value="">-- Pilih Jawaban Benar --</option>
            <?php foreach (['A', 'B', 'C', 'D'] as $opsi): ?>
              <option value="<?= $opsi ?>" <?= (isset($editData) && $editData['jawaban'] == $opsi) ? 'selected' : '' ?>>
                <?= $opsi ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <button type="submit"><?= $editData ? 'Update' : 'Simpan' ?></button>
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
          <?php if ($soal && $soal->num_rows > 0): ?>
            <?php $no = 1; while ($row = $soal->fetch_assoc()): ?>
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
                  <a href="?edit=<?= $row['id'] ?>">Edit</a> |
                  <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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
