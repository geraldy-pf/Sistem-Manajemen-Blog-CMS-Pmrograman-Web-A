<?php
require_once '../koneksi.php';

$id = $_POST['id'] ?? 0;
$nama_depan = $_POST['nama_depan'] ?? '';
$nama_belakang = $_POST['nama_belakang'] ?? '';
$user_name = $_POST['user_name'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($id) || empty($nama_depan) || empty($user_name)) {
    echo json_encode(['status' => 'error', 'message' => 'Data wajib diisi']);
    exit;
}

// data sekarang
$get_query = "SELECT foto, password FROM penulis WHERE id = ?";
$get_stmt = mysqli_prepare($koneksi, $get_query);
mysqli_stmt_bind_param($get_stmt, "i", $id);
mysqli_stmt_execute($get_stmt);
$current_data = mysqli_fetch_assoc(mysqli_stmt_get_result($get_stmt));

$foto_name = $current_data['foto'];
$hashed_password = $current_data['password'];

if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
}

// file upload
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['foto']['tmp_name'];
    $file_name = $_FILES['foto']['name'];
    $file_size = $_FILES['foto']['size'];

    if ($file_size <= 2 * 1024 * 1024) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->file($file_tmp);
        $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];

        if (in_array($mime_type, $allowed_types)) {
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_name = uniqid() . '.' . $extension;
            $upload_dir = '../upload_penulis/';

            if (move_uploaded_file($file_tmp, $upload_dir . $new_name)) {
                // hapus foto lama
                if ($foto_name !== 'default.png' && file_exists($upload_dir . $foto_name)) {
                    unlink($upload_dir . $foto_name);
                }
                $foto_name = $new_name;
            }
        }
    }
}

$query = "UPDATE penulis SET nama_depan = ?, nama_belakang = ?, user_name = ?, password = ?, foto = ? WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "sssssi", $nama_depan, $nama_belakang, $user_name, $hashed_password, $foto_name, $id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'success', 'message' => 'Penulis berhasil diupdate']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate penulis: ' . mysqli_error($koneksi)]);
}
?>