<?php
require_once '../koneksi.php';

$query = "SELECT a.*, p.nama_depan, p.nama_belakang, k.nama_kategori 
          FROM artikel a 
          JOIN penulis p ON a.id_penulis = p.id 
          JOIN kategori_artikel k ON a.id_kategori = k.id 
          ORDER BY a.id DESC";
$result = mysqli_query($koneksi, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
