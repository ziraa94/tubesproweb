<?php
session_start();
require 'koneksi.php';

$user_id = $_SESSION['id'];
$id = (int) $_POST['id'];

$nama = trim($_POST['nama_target']);
$target = (int) $_POST['target_nominal'];
$tanggal = $_POST['tanggal_target'];

if ($nama === '' || $target <= 0) die("Data tidak valid");

$stmt = mysqli_prepare(
    $koneksi,
    "UPDATE saving_goals
     SET nama_target=?, target_nominal=?, tanggal_target=?
     WHERE id=? AND user_id=?"
);
mysqli_stmt_bind_param($stmt, "sisii",
    $nama, $target, $tanggal, $id, $user_id
);
mysqli_stmt_execute($stmt);

header("Location: tabungan.php");
