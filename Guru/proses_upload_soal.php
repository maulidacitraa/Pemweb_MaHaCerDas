<?php
include 'koneksi.php';

$pertanyaan = $_POST['pertanyaan'];
$opsi_a = $_POST['opsi_a'];
$opsi_b = $_POST['opsi_b'];
$opsi_c = $_POST['opsi_c'];
$opsi_d = $_POST['opsi_d'];
$jawaban = strtoupper($_POST['jawaban']); // Konversi ke huruf besar

if (!in_array($jawaban, ['A', 'B', 'C', 'D'])) {
  echo "<script>alert('Jawaban harus berupa A, B, C, atau D.'); window.location='upload_soal.php';</script>";
  exit();
}

mysqli_query($conn, "INSERT INTO soal (pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban)
VALUES ('$pertanyaan', '$opsi_a', '$opsi_b', '$opsi_c', '$opsi_d', '$jawaban')");

header("Location: upload_soal.php");
?>
