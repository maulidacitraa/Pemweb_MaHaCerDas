<?php
require_once '../koneksi.php';

$jenjang = $_GET['jenjang'] ?? '';

if ($jenjang) {
    $stmt = $conn->prepare("SELECT nama_mapel FROM mapel WHERE jenjang = ?");
    $stmt->bind_param("s", $jenjang);
    $stmt->execute();
    $result = $stmt->get_result();

    $mapel = [];
    while ($row = $result->fetch_assoc()) {
        $mapel[] = ['nama_mapel' => $row['nama_mapel']];
    }

    header('Content-Type: application/json');
    echo json_encode($mapel);
}
?>
