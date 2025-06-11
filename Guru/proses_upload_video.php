<?php
include 'koneksi.php';

$judul = $_POST['judul'];
$link = $_POST['link'];

mysqli_query($conn, "INSERT INTO video (judul, link) VALUES ('$judul', '$link')");

header("Location: upload_video.php");
?>
