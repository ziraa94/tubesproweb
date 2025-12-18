<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: tambah_tabungan.php");
    exit;
}

$user_id = $_SESSION['id'];

$nama    = trim($_POST['nama_target'] ?? '');
$target  = (int) ($_POST['target_nominal'] ?? 0);
$saldo   = (int) ($_POST['saldo_awal'] ?? 0);
$tanggal = $_POST['tanggal_target'] ?? '';

if ($nama === '' || $target <= 0 || $saldo < 0 || $saldo > $target || $tanggal === '') {
    die("Data tabungan tidak valid");
}

$status = ($saldo >= $target) ? 'tercapai' : 'aktif';

$stmt = mysqli_prepare(
    $koneksi,
    "INSERT INTO saving_goals 
     (user_id, nama_target, target_nominal, saldo_sekarang, tanggal_target, status)
     VALUES (?, ?, ?, ?, ?, ?)"
);

mysqli_stmt_bind_param($stmt, "isiiss",
    $user_id, $nama, $target, $saldo, $tanggal, $status
);

mysqli_stmt_execute($stmt);

header("Location: tabungan.php?success=1");
exit;
