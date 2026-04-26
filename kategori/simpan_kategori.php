<?php
require_once '../koneksi.php';

$nama_kategori = $_POST['nama_kategori'] ?? '';
$keterangan = $_POST['keterangan'] ?? '';

if (empty($nama_kategori)) {
    echo json_encode(['status' => 'error', 'message' => 'Nama kategori tidak boleh kosong']);
    exit;
}

$query = "INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?, ?)";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "ss", $nama_kategori, $keterangan);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil disimpan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan kategori: ' . mysqli_error($koneksi)]);
}
?>
