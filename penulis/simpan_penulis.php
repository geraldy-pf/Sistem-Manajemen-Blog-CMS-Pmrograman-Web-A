<?php
require_once '../koneksi.php';

$nama_depan = $_POST['nama_depan'] ?? '';
$nama_belakang = $_POST['nama_belakang'] ?? '';
$user_name = $_POST['user_name'] ?? '';
$password = $_POST['password'] ?? '';
$foto_name = 'default.png';

if (empty($nama_depan) || empty($user_name) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Data wajib diisi']);
    exit;
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['foto']['tmp_name'];
    $file_name = $_FILES['foto']['name'];
    $file_size = $_FILES['foto']['size'];

    // 2 mb
    if ($file_size > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'message' => 'Ukuran file maksimal 2MB']);
        exit;
    }

    // finfo
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file_tmp);
    $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];

    if (!in_array($mime_type, $allowed_types)) {
        echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak didukung (Gunakan JPG, PNG, atau WEBP)']);
        exit;
    }

    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
    $new_name = uniqid() . '.' . $extension;
    $upload_dir = '../upload_penulis/';

    if (!is_dir($upload_dir))
        mkdir($upload_dir, 0755, true);

    if (move_uploaded_file($file_tmp, $upload_dir . $new_name)) {
        $foto_name = $new_name;
    }
}

$query = "INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "sssss", $nama_depan, $nama_belakang, $user_name, $hashed_password, $foto_name);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'success', 'message' => 'Penulis berhasil disimpan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan penulis: ' . mysqli_error($koneksi)]);
}
?>