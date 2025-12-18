<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: tagihan.php");
    exit;
}

$koneksi = mysqli_connect("localhost","root","","data_tubes");
if (!$koneksi) {
    die("Koneksi database gagal");
}

$user_id = $_SESSION['id'];
$id = (int) $_GET['id'];

/* =========================
   AMBIL DATA TAGIHAN
========================= */
$q = mysqli_query($koneksi, "
    SELECT nama_tagihan, jumlah, kategori
    FROM tagihan
    WHERE id = $id AND user_id = $user_id AND status = 'belum'
");

$tagihan = mysqli_fetch_assoc($q);

/* Jika tagihan tidak valid atau sudah lunas */
if (!$tagihan) {
    header("Location: tagihan.php");
    exit;
}

/* =========================
   UPDATE STATUS TAGIHAN
========================= */
mysqli_query($koneksi, "
    UPDATE tagihan
    SET status = 'lunas'
    WHERE id = $id AND user_id = $user_id
");

/* =========================
   INSERT KE TRANSAKSI
========================= */
$nama     = mysqli_real_escape_string($koneksi, $tagihan['nama_tagihan']);
$kategori = mysqli_real_escape_string($koneksi, $tagihan['kategori']);
$jumlah   = $tagihan['jumlah'];
$tanggal  = date('Y-m-d');

mysqli_query($koneksi, "
    INSERT INTO transaksi 
    (user_id, jenis, kategori, jumlah, keterangan, tanggal)
    VALUES
    ($user_id, 'pengeluaran', '$kategori', $jumlah, 'Tagihan: $nama', '$tanggal')
");

/* =========================
   KEMBALI
========================= */
header("Location: tagihan.php");
exit;
