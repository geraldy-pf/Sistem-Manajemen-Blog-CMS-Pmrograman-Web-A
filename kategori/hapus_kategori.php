<?php
require_once '../koneksi.php';

$id = $_POST['id'] ?? 0;

if (empty($id)) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
    exit;
}

$check_query = "SELECT id FROM artikel WHERE id_kategori = ? LIMIT 1";
$check_stmt = mysqli_prepare($koneksi, $check_query);
mysqli_stmt_bind_param($check_stmt, "i", $id);
mysqli_stmt_execute($check_stmt);
$check_result = mysqli_stmt_get_result($check_stmt);

if (mysqli_num_rows($check_result) > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Kategori tidak dapat dihapus karena masih memiliki artikel']);
    exit;
}

$query = "DELETE FROM kategori_artikel WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus kategori: ' . mysqli_error($koneksi)]);
}
?>