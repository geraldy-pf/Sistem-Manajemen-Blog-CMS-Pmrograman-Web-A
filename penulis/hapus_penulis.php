<?php
require_once '../koneksi.php';

$id = $_POST['id'] ?? 0;

if (empty($id)) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
    exit;
}

$check_query = "SELECT id FROM artikel WHERE id_penulis = ? LIMIT 1";
$check_stmt = mysqli_prepare($koneksi, $check_query);
mysqli_stmt_bind_param($check_stmt, "i", $id);
mysqli_stmt_execute($check_stmt);
$check_result = mysqli_stmt_get_result($check_stmt);

if (mysqli_num_rows($check_result) > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Penulis tidak dapat dihapus karena masih memiliki artikel']);
    exit;
}

// foto profil
$get_query = "SELECT foto FROM penulis WHERE id = ?";
$get_stmt = mysqli_prepare($koneksi, $get_query);
mysqli_stmt_bind_param($get_stmt, "i", $id);
mysqli_stmt_execute($get_stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($get_stmt));
$foto_name = $data['foto'];

$query = "DELETE FROM penulis WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    // Delete file if not default
    if ($foto_name !== 'default.png') {
        $file_path = '../upload_penulis/' . $foto_name;
        if (file_exists($file_path))
            unlink($file_path);
    }
    echo json_encode(['status' => 'success', 'message' => 'Penulis berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus penulis: ' . mysqli_error($koneksi)]);
}
?>