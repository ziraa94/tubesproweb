<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: tambah_aset.php");
    exit;
}

$user_id = $_SESSION['id'];

$nama   = trim($_POST['nama_aset'] ?? '');
$jenis  = $_POST['jenis_aset'] ?? '';
$nilai  = (int) ($_POST['nilai'] ?? 0);
$tgl    = $_POST['tanggal_perolehan'] ?? null;

if ($nama === '' || $jenis === '' || $nilai <= 0) {
    die("Data aset tidak valid");
}

$stmt = mysqli_prepare(
    $koneksi,
    "INSERT INTO aset 
     (user_id, nama_aset, jenis_aset, nilai, tanggal_perolehan)
     VALUES (?, ?, ?, ?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "issis",
    $user_id,
    $nama,
    $jenis,
    $nilai,
    $tgl
);

mysqli_stmt_execute($stmt);

header("Location: aset.php?success=1");
exit;
