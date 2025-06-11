<?php
include 'koneksi.php';

$nama = $_POST['nama'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 🔐 aman & fleksibel
$role = $_POST['role'];

// Cek email sudah terdaftar
$cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Email sudah digunakan!'); window.location='register.html';</script>";
    exit;
}

// Masukkan data
$sql = "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')";
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Registrasi berhasil! Tunggu validasi admin.'); window.location='login.html';</script>";
} else {
    echo "Gagal registrasi: " . mysqli_error($conn);
}
?>
