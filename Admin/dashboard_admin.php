<?php
session_start();
require_once '../koneksi.php';

// Cek login dan role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Ambil data pengguna
$sql = "SELECT nama, email, role, created_at FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);

// Hitung jumlah pengguna berdasarkan role
$jumlahPengguna = 0;
$jumlahGuru = 0;
$jumlahSiswa = 0;
$pengguna = [];

if ($result && $result->num_rows > 0) {
    $jumlahPengguna = $result->num_rows;

    while ($row = $result->fetch_assoc()) {
        if ($row['role'] === 'guru') $jumlahGuru++;
        if ($row['role'] === 'siswa') $jumlahSiswa++;
        $pengguna[] = $row;
    }
}

// Hitung jumlah aktivitas dari tabel aktivitas
$jumlahAktivitas = 0;
$hasilAktivitas = $conn->query("SELECT COUNT(*) AS total FROM aktivitas");
if ($hasilAktivitas && $hasilAktivitas->num_rows > 0) {
    $jumlahAktivitas = $hasilAktivitas->fetch_assoc()['total'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/admin.css">

  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="sidebar">
    <h2>Admin</h2>
    <ul>
      <li><a href="dashboard_admin.php">Dashboard</a></li>
      <li><a href="kelola_pengguna.php">Kelola Pengguna</a></li>
      <li><a href="kelola_mapel.php">Kelola Mapel</a></li>
      <li><a href="laporan_aktivitas.php">Laporan Aktivitas</a></li>
      <li><a href="../logout.php">Logout</a></li>
    </ul>
  </div>

  <div class="main">
    <h1>Dashboard</h1>

    <div class="cards">
      <div class="card blue">Pengguna<br><span><?= $jumlahPengguna ?></span></div>
      <div class="card yellow">Guru<br><span><?= $jumlahGuru ?></span></div>
      <div class="card green">Siswa<br><span><?= $jumlahSiswa ?></span></div>
      <div class="card red">Aktivitas<br><span><?= $jumlahAktivitas ?></span></div>
    </div>

    <div class="charts">
      <div class="chart"><canvas id="areaChart"></canvas></div>
      <div class="chart"><canvas id="barChart"></canvas></div>
    </div>

    <div class="table-section">
      <h2>Data Pengguna</h2>
      <table>
        <thead>
          <tr>
            <th>Nama</th>
            <th>Role</th>
            <th>Email</th>
            <th>Tanggal Daftar</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($pengguna)): ?>
            <?php foreach ($pengguna as $user): ?>
              <tr>
                <td><?= htmlspecialchars($user['nama']) ?></td>
                <td><?= ucfirst($user['role']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= date("d-m-Y", strtotime($user['created_at'])) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="4">Tidak ada data pengguna.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Chart.js scripts -->
  <script>
    const areaCtx = document.getElementById('areaChart').getContext('2d');
    const barCtx = document.getElementById('barChart').getContext('2d');

    new Chart(areaCtx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
        datasets: [{
          label: 'Aktivitas',
          data: [5, 10, 7, 15, 8, 12],
          borderColor: 'rgba(75,192,192,1)',
          backgroundColor: 'rgba(75,192,192,0.2)',
          fill: true,
          tension: 0.4
        }]
      }
    });

    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: ['Admin', 'Guru', 'Siswa'],
        datasets: [{
          label: 'Jumlah',
          data: [1, <?= $jumlahGuru ?>, <?= $jumlahSiswa ?>],
          backgroundColor: ['#007bff', '#ffc107', '#28a745']
        }]
      }
    });
  </script>
</body>
</html>
