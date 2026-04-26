<?php
require_once '../koneksi.php';

// date format
date_default_timezone_set('Asia/Jakarta');
$hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$bulan = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];
$sekarang = new DateTime();
$nama_hari = $hari[$sekarang->format('w')];
$tanggal = $sekarang->format('j');
$nama_bulan = $bulan[(int) $sekarang->format('n')];
$tahun = $sekarang->format('Y');
$jam = $sekarang->format('H:i');
$hari_tanggal = "$nama_hari, $tanggal $nama_bulan $tahun | $jam";

$id_penulis = $_POST['id_penulis'] ?? 0;
$id_kategori = $_POST['id_kategori'] ?? 0;
$judul = $_POST['judul'] ?? '';
$isi = $_POST['isi'] ?? '';
$gambar_name = '';

if (empty($id_penulis) || empty($id_kategori) || empty($judul) || empty($isi)) {
    echo json_encode(['status' => 'error', 'message' => 'Data wajib diisi']);
    exit;
}

// artikel gambar
if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'Gambar artikel wajib diupload']);
    exit;
}

$file_tmp = $_FILES['gambar']['tmp_name'];
$file_name = $_FILES['gambar']['name'];
$file_size = $_FILES['gambar']['size'];

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
$upload_dir = '../upload_artikel/';

if (!is_dir($upload_dir))
    mkdir($upload_dir, 0755, true);

if (move_uploaded_file($file_tmp, $upload_dir . $new_name)) {
    $gambar_name = $new_name;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mengupload gambar']);
    exit;
}

$query = "INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "iissss", $id_penulis, $id_kategori, $judul, $isi, $gambar_name, $hari_tanggal);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil disimpan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan artikel: ' . mysqli_error($koneksi)]);
}
?>