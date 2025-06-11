<?php
// Konfigurasi koneksi
$host = "localhost";      // Biasanya 'localhost' di XAMPP/Laragon
$user = "root";           // Username default MySQL
$pass = "";               // Kosong jika pakai XAMPP default
$db   = "mahacerdas";     // Nama database kamu

// Buat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
