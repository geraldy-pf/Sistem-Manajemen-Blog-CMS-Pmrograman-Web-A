<?php
require_once '../koneksi.php';

$query = "SELECT * FROM penulis ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
