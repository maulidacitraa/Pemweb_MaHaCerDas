<?php
session_start();
require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_mapel = $_POST['nama_mapel'] ?? '';
    $jenjang = $_POST['jenjang'] ?? '';

    if ($nama_mapel && $jenjang) {
        // Cek duplikasi mapel
        $cek = $conn->prepare("SELECT id FROM mapel WHERE nama_mapel = ? AND jenjang = ?");
        $cek->bind_param("ss", $nama_mapel, $jenjang);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {
            header("Location: tambah_mapel.php?error=Mapel+telah+ada");
            exit();
        }

        // Insert mapel baru
        $stmt = $conn->prepare("INSERT INTO mapel (nama_mapel, jenjang) VALUES (?, ?)");
        $stmt->bind_param("ss", $nama_mapel, $jenjang);
        if ($stmt->execute()) {
            header("Location: kelola_mapel.php");
            exit();
        } else {
            echo "<p style='color:red; text-align:center;'>Gagal menambah mapel.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Mapel</title>
  <link rel="stylesheet" href="../css/admin.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>

<div class="main no-sidebar">
  <a href="kelola_mapel.php" class="back-button">← Kembali ke Kelola Mapel</a>
  <h1>Pilih Mata Pelajaran</h1>

  <div class="mapel-cards">
    <?php
    $mapelList = [
      ['Matematika', 'SMA', 'mat.jpeg', 'Pelajari konsep dasar hingga lanjutan dengan latihan interaktif.'],
      ['Fisika', 'SMA', 'fisika.jpeg', 'Uji pemahaman fisika secara adaptif dan menyenangkan.'],
      ['Biologi', 'SMA', 'biologi.jpeg', 'Pahami biologi dengan visualisasi yang menarik dan mudah dimengerti.'],
      ['Kimia', 'SMA', 'kim.jpeg', 'Kenali unsur dan reaksi kimia lewat eksperimen interaktif.'],
      ['Bahasa Indonesia', 'SMA', 'bindo.jpeg', 'Kuasai tata bahasa, membaca, dan menulis dengan baik dan benar.'],
      ['Bahasa Inggris', 'SMA', 'bing.jpeg', 'Pelajari grammar, vocabulary, dan kemampuan berbicara dengan mudah.']
    ];

    foreach ($mapelList as [$nama, $jenjang, $gambar, $deskripsi]) {
      echo '
        <div class="mapel-card">
          <img src="../Assets/' . $gambar . '" alt="' . htmlspecialchars($nama) . '">
          <h3>' . htmlspecialchars($nama) . '</h3>
          <p>' . htmlspecialchars($deskripsi) . '</p>
          <form method="POST">
            <input type="hidden" name="nama_mapel" value="' . htmlspecialchars($nama) . '">
            <input type="hidden" name="jenjang" value="' . htmlspecialchars($jenjang) . '">
            <button type="submit">Tambah</button>
          </form>
        </div>
      ';
    }
    ?>
  </div>
</div>

</body>
</html>
