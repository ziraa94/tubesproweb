<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id     = (int) $_POST['id'];
$user_id = $_SESSION['id'];
$nama   = trim($_POST['nama_aset']);
$jenis  = $_POST['jenis_aset'];
$nilai  = (int) $_POST['nilai'];
$tgl    = $_POST['tanggal_perolehan'];

$stmt = mysqli_prepare(
    $koneksi,
    "UPDATE aset 
     SET nama_aset=?, jenis_aset=?, nilai=?, tanggal_perolehan=?
     WHERE id=? AND user_id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "ssisii",
    $nama,
    $jenis,
    $nilai,
    $tgl,
    $id,
    $user_id
);

mysqli_stmt_execute($stmt);

header("Location: aset.php?updated=1");
exit;
