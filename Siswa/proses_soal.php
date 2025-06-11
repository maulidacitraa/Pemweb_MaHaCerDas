<?php
session_start();
include 'koneksi.php';

$siswa = $_SESSION['nama'];
$jawaban = $_POST['jawaban'];

foreach ($jawaban as $id_soal => $jawab) {
    $soal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM soal WHERE id=$id_soal"));
    $nilai = ($jawab == $soal['jawaban']) ? 100 : 0;
    mysqli_query($conn, "INSERT INTO hasil (siswa, soal, jawaban, nilai) 
        VALUES ('$siswa', '{$soal['pertanyaan']}', '$jawab', $nilai)");
}
echo "<script>alert('Jawaban telah dikirim!'); window.location='hasil.php';</script>";
?>
