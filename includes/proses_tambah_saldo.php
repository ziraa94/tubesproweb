<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];
$id = (int) ($_POST['id'] ?? 0);
$nominal = (int) ($_POST['nominal'] ?? 0);

if ($id <= 0 || $nominal <= 0) {
    die("Input tidak valid");
}

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT saldo_sekarang, target_nominal
     FROM saving_goals
     WHERE id = ? AND user_id = ?"
);
mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
mysqli_stmt_execute($stmt);
$row = mysqli_stmt_get_result($stmt)->fetch_assoc();

if (!$row) {
    die("Target tidak ditemukan");
}

$saldo_baru = $row['saldo_sekarang'] + $nominal;

if ($saldo_baru > $row['target_nominal']) {
    die("Saldo melebihi target");
}

$status = ($saldo_baru >= $row['target_nominal']) ? 'tercapai' : 'aktif';

$update = mysqli_prepare(
    $koneksi,
    "UPDATE saving_goals
     SET saldo_sekarang = ?, status = ?
     WHERE id = ? AND user_id = ?"
);
mysqli_stmt_bind_param($update, "isii",
    $saldo_baru, $status, $id, $user_id
);
mysqli_stmt_execute($update);

header("Location: tabungan.php");
exit;
