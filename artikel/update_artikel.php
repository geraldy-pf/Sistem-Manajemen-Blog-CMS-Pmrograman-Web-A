<?php
require_once '../koneksi.php';

$id = $_POST['id'] ?? 0;
$id_penulis = $_POST['id_penulis'] ?? 0;
$id_kategori = $_POST['id_kategori'] ?? 0;
$judul = $_POST['judul'] ?? '';
$isi = $_POST['isi'] ?? '';

if (empty($id) || empty($id_penulis) || empty($id_kategori) || empty($judul) || empty($isi)) {
    echo json_encode(['status' => 'error', 'message' => 'Data wajib diisi']);
    exit;
}

// gambar sekarang
$get_query = "SELECT gambar FROM artikel WHERE id = ?";
$get_stmt = mysqli_prepare($koneksi, $get_query);
mysqli_stmt_bind_param($get_stmt, "i", $id);
mysqli_stmt_execute($get_stmt);
$current_data = mysqli_fetch_assoc(mysqli_stmt_get_result($get_stmt));
$gambar_name = $current_data['gambar'];

// file upload
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['gambar']['tmp_name'];
    $file_name = $_FILES['gambar']['name'];
    $file_size = $_FILES['gambar']['size'];

    if ($file_size <= 2 * 1024 * 1024) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->file($file_tmp);
        $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];

        if (in_array($mime_type, $allowed_types)) {
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_name = uniqid() . '.' . $extension;
            $upload_dir = '../upload_artikel/';

            if (move_uploaded_file($file_tmp, $upload_dir . $new_name)) {
                if (file_exists($upload_dir . $gambar_name)) {
                    unlink($upload_dir . $gambar_name);
                }
                $gambar_name = $new_name;
            }
        }
    }
}

$query = "UPDATE artikel SET id_penulis = ?, id_kategori = ?, judul = ?, isi = ?, gambar = ? WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "iisssi", $id_penulis, $id_kategori, $judul, $isi, $gambar_name, $id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil diupdate']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate artikel: ' . mysqli_error($koneksi)]);
}
?>
