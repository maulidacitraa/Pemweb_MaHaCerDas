<?php
// File: proses_upload_materi.php
session_start();
if (!isset($_SESSION['nama']) || $_SESSION['role'] !== 'guru') {
  header("Location: login.html");
  exit();
}
$conn = new mysqli("localhost", "root", "", "mahacerdas");

$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];
$jenjang = $_POST['jenjang'];
$file = $_FILES['file_materi']['name'];
$tmp = $_FILES['file_materi']['tmp_name'];
$path = "uploads/" . basename($file);

if (move_uploaded_file($tmp, $path)) {
  $query = "INSERT INTO materi (judul, deskripsi, jenjang, file) VALUES ('$judul', '$deskripsi', '$jenjang', '$file')";
  if ($conn->query($query)) {
    echo "<script>alert('Materi berhasil diupload'); window.location='dashboard.php';</script>";
  } else {
    echo "<script>alert('Gagal menyimpan ke database'); window.location='upload_materi.php';</script>";
  }
} else {
  echo "<script>alert('Upload file gagal'); window.location='upload_materi.php';</script>";
}
?>
