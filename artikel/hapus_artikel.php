<?php
require_once '../koneksi.php';

$id = $_POST['id'] ?? 0;

if (empty($id)) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
    exit;
}

$get_query = "SELECT gambar FROM artikel WHERE id = ?";
$get_stmt = mysqli_prepare($koneksi, $get_query);
mysqli_stmt_bind_param($get_stmt, "i", $id);
mysqli_stmt_execute($get_stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($get_stmt));
$gambar_name = $data['gambar'];

$query = "DELETE FROM artikel WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    $file_path = '../upload_artikel/' . $gambar_name;
    if (file_exists($file_path))
        unlink($file_path);
    echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus artikel: ' . mysqli_error($koneksi)]);
}
?>