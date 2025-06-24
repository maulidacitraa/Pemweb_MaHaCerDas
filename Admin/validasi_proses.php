<?php
session_start();
require_once '../koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "UPDATE users SET validasi = 1 WHERE id = $id";
    if ($conn->query($query)) {
        echo "<script>alert('Akun berhasil divalidasi.'); window.location.href='validasi_akun.php';</script>";
    } else {
        echo "Gagal memvalidasi: " . $conn->error;
    }
} else {
    echo "ID tidak ditemukan.";
}
