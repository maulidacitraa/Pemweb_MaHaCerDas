<?php
include 'koneksi.php';

$nama = $_POST['nama'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];

$cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Email sudah digunakan!'); window.location='register.php';</script>";
    exit;
}

$sql = "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')";
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
} else {
    echo "Gagal registrasi: " . mysqli_error($conn);
}
?>
