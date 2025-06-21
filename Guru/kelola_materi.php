<?php
session_start();
require_once '../koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}

$id_guru = $_SESSION['user_id'];
$nama_guru = $_SESSION['nama'];

// Hapus materi
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $cek = $conn->prepare("SELECT file FROM materi WHERE id = ? AND id_guru = ?");
    $cek->bind_param("ii", $id, $id_guru);
    $cek->execute();
    $res = $cek->get_result();
    $data = $res->fetch_assoc();

    if ($data && file_exists("../uploads/" . $data['file'])) {
        unlink("../uploads/" . $data['file']);
    }

    $del = $conn->prepare("DELETE FROM materi WHERE id = ? AND id_guru = ?");
    $del->bind_param("ii", $id, $id_guru);
    $del->execute();

    $aktivitas = "$nama_guru menghapus materi '" . $data['file'] . "'";
    $log = $conn->prepare("INSERT INTO aktivitas (user, aktivitas) VALUES (?, ?)");
    $log->bind_param("ss", $nama_guru, $aktivitas);
    $log->execute();

    header("Location: kelola_materi.php");
    exit;
}

// Edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM materi WHERE id = ? AND id_guru = ?");
    $stmt->bind_param("ii", $id, $id_guru);
    $stmt->execute();
    $res = $stmt->get_result();
    $editData = $res->fetch_assoc();
}

// Update
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $judul = $_POST['judul'];
    $mapel = $_POST['mapel'];
    $deskripsi = $_POST['deskripsi'];
    $jenjang = $_POST['jenjang'];

    $stmt = $conn->prepare("UPDATE materi SET mapel=?, judul=?, deskripsi=?, jenjang=? WHERE id=? AND id_guru=?");
    $stmt->bind_param("ssssii", $mapel, $judul, $deskripsi, $jenjang, $id, $id_guru);
    $stmt->execute();

    $aktivitas = "$nama_guru mengedit materi '$judul'";
    $log = $conn->prepare("INSERT INTO aktivitas (user, aktivitas) VALUES (?, ?)");
    $log->bind_param("ss", $nama_guru, $aktivitas);
    $log->execute();

    echo "<script>alert('Materi berhasil diperbarui'); window.location='kelola_materi.php';</script>";
    exit;
}

// Upload
if (isset($_POST['upload'])) {
    $judul = $_POST['judul'];
    $mapel = $_POST['mapel'];
    $deskripsi = $_POST['deskripsi'];
    $jenjang = $_POST['jenjang'];
    $fileName = $_FILES['file']['name'];
    $tempName = $_FILES['file']['tmp_name'];
    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($fileName);

    if (move_uploaded_file($tempName, $targetFile)) {
        $stmt = $conn->prepare("INSERT INTO materi (mapel, judul, deskripsi, file, id_guru, jenjang) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssis", $mapel, $judul, $deskripsi, $fileName, $id_guru, $jenjang);
        $stmt->execute();

        $aktivitas = "$nama_guru mengupload materi '$judul'";
        $log = $conn->prepare("INSERT INTO aktivitas (user, aktivitas) VALUES (?, ?)");
        $log->bind_param("ss", $nama_guru, $aktivitas);
        $log->execute();

        echo "<script>alert('Materi berhasil diupload.'); window.location.href='kelola_materi.php';</script>";
        exit;
    } else {
        echo "Gagal upload file.";
    }
}

$stmt = $conn->prepare("SELECT * FROM materi WHERE id_guru = ? ORDER BY tanggal_upload DESC");
$stmt->bind_param("i", $id_guru);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kelola Materi - Guru</title>
  <link rel="stylesheet" href="../css/guru.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <header class="topbar">
    <div class="logo">MaHa cerdAs</div>
    <nav>
      <a href="dashboard_guru.php">Dashboard</a>
      <a href="../logout.php" class="logout">Logout</a>
    </nav>
  </header>

  <main class="main">
    <a href="dashboard_guru.php" class="back-button">← Kembali</a>
    <h1>Kelola Materi</h1>

    <section class="form-container">
      <h2><?= $editData ? "Edit Materi" : "Upload Materi" ?></h2>
      <form method="post" enctype="multipart/form-data">
        <?php if ($editData): ?>
          <input type="hidden" name="id" value="<?= $editData['id'] ?>">
        <?php endif; ?>

        <div class="form-group">
          <label for="jenjang">Jenjang</label>
          <select id="jenjang" name="jenjang" required>
            <option value="">-- Pilih Jenjang --</option>
            <option value="SMP" <?= ($editData && $editData['jenjang'] == 'SMP') ? 'selected' : '' ?>>SMP</option>
            <option value="SMA" <?= ($editData && $editData['jenjang'] == 'SMA') ? 'selected' : '' ?>>SMA</option>
          </select>
        </div>

        <div class="form-group">
          <label for="mapel">Mata Pelajaran</label>
          <select name="mapel" id="mapel" required>
            <option value="">-- Pilih Mata Pelajaran --</option>
          </select>
        </div>

        <div class="form-group">
          <label for="judul">Judul</label>
          <input type="text" name="judul" id="judul" value="<?= $editData['judul'] ?? '' ?>" required>
        </div>

        <div class="form-group">
          <label for="deskripsi">Deskripsi</label>
          <textarea name="deskripsi" id="deskripsi" required><?= $editData['deskripsi'] ?? '' ?></textarea>
        </div>

        <?php if (!$editData): ?>
        <div class="form-group">
          <label for="file">Upload File</label>
          <input type="file" name="file" id="file" accept=".pdf,.docx,.pptx,.mp4" required>
        </div>
        <?php endif; ?>

        <button type="submit" name="<?= $editData ? 'update' : 'upload' ?>">
          <?= $editData ? 'Simpan Perubahan' : 'Upload' ?>
        </button>
      </form>
    </section>

    <section class="table-section">
      <h2>Daftar Materi Saya</h2>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Jenjang</th>
            <th>Mata Pelajaran</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>File</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['jenjang']) ?></td>
            <td><?= htmlspecialchars($row['mapel']) ?></td>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
            <td><a href="../uploads/<?= htmlspecialchars($row['file']) ?>" target="_blank"><?= htmlspecialchars($row['file']) ?></a></td>
            <td>
              <a href="?edit=<?= $row['id'] ?>">Edit</a> |
              <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </section>
  </main>

  <script>
  document.getElementById("jenjang").addEventListener("change", function () {
    const jenjang = this.value;
    const mapelSelect = document.getElementById("mapel");
    mapelSelect.innerHTML = `<option value="">-- Memuat Mapel... --</option>`;

    fetch(`get_mapel.php?jenjang=${jenjang}`)
      .then(res => res.json())
      .then(data => {
        mapelSelect.innerHTML = `<option value="">-- Pilih Mata Pelajaran --</option>`;
        data.forEach(mapel => {
          const option = document.createElement("option");
          option.value = mapel.nama_mapel;
          option.textContent = mapel.nama_mapel;

          // Auto-select if editing
          if (mapel.nama_mapel === "<?= $editData['mapel'] ?? '' ?>") {
            option.selected = true;
          }

          mapelSelect.appendChild(option);
        });
      });
  });

  // Trigger saat halaman load (untuk edit)
  window.onload = function () {
    const jenjang = document.getElementById("jenjang").value;
    if (jenjang) {
      document.getElementById("jenjang").dispatchEvent(new Event("change"));
    }
  };
  </script>
</body>
</html>
