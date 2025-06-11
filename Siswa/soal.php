<?php
session_start();
if ($_SESSION['role'] != 'siswa') {
  header('Location: dashboard.php');
  exit();
}
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM soal");
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Latihan Soal</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container">
  <h2>Latihan Soal</h2>
  <form action="proses_soal.php" method="POST">
    <?php $no = 1; while ($s = mysqli_fetch_assoc($result)) { ?>
      <div>
        <p><strong><?= $no . '. ' . $s['pertanyaan'] ?></strong></p>
        <?php foreach (['a', 'b', 'c', 'd'] as $opt) { ?>
          <label>
            <input type="radio" name="jawaban[<?= $s['id'] ?>]" value="<?= strtoupper($opt) ?>" required>
            <?= strtoupper($opt) ?>. <?= $s["opsi_" . $opt] ?>
          </label><br>
        <?php } ?>
      </div><br>
    <?php $no++; } ?>
    <button type="submit">Kirim Jawaban</button>
  </form>
</div></body></html>
