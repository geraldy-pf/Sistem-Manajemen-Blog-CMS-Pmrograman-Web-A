<?php
require_once '../koneksi.php';

$id = $_POST['id'] ?? 0;
$nama_kategori = $_POST['nama_kategori'] ?? '';
$keterangan = $_POST['keterangan'] ?? '';

if (empty($nama_kategori) || empty($id)) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit;
}

$query = "UPDATE kategori_artikel SET nama_kategori = ?, keterangan = ? WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "ssi", $nama_kategori, $keterangan, $id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil diupdate']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate kategori: ' . mysqli_error($koneksi)]);
}
?>
