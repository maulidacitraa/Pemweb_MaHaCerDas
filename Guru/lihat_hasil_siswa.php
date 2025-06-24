<?php
session_start();
require_once '../koneksi.php';

// Cek role guru
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../login.php");
    exit;
}

// Ambil data hasil latihan siswa
$jenjang = $_SESSION['jenjang'];
$sql = "SELECT hs.*, u.nama 
        FROM hasil_latihan hs 
        JOIN users u ON hs.id_siswa = u.id
        WHERE hs.jenjang = ?
        ORDER BY hs.tanggal DESC";
        
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $jenjang);
$stmt->execute();
$result = $stmt->get_result();

$hasil = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hasil[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Hasil Latihan Siswa</title>
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
    <h1>Hasil Latihan Siswa</h1>

    <table class="table-hasil">
      <thead>
        <tr>
          <th>Nama Siswa</th>
          <th>Jenjang</th>
          <th>Mapel</th>
          <th>Benar</th>
          <th>Salah</th>
          <th>Nilai</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($hasil) > 0): ?>
          <?php foreach ($hasil as $row): ?>
            <tr>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td><?= htmlspecialchars($row['jenjang']) ?></td>
              <td><?= htmlspecialchars($row['mapel']) ?></td>
              <td><?= $row['benar'] ?></td>
              <td><?= $row['salah'] ?></td>
              <td><?= $row['nilai'] ?></td>
              <td><?= date('d-m-Y H:i', strtotime($row['tanggal'])) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="7">Belum ada data latihan siswa.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </main>
</body>
</html>
