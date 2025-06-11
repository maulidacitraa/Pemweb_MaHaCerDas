<?php
// File: validasi_proses.php
session_start();
if (!isset($_SESSION['nama']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.html");
  exit();
}
$id = $_GET['id'];
$conn = new mysqli("localhost", "root", "", "mahacerdas");
$conn->query("UPDATE users SET validasi = 1 WHERE id = $id");
header("Location: validasi_akun.php");
?>
