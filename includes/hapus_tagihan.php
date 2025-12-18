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

$koneksi = mysqli_connect("localhost", "root", "", "data_tubes");
if (!$koneksi) {
    die("Koneksi database gagal");
}

$user_id = $_SESSION['id'];
$id_tagihan = (int) $_GET['id'];

/* =========================
   HAPUS TAGIHAN MILIK USER
========================= */
$query = "
    DELETE FROM tagihan 
    WHERE id = $id_tagihan 
    AND user_id = $user_id
";

mysqli_query($koneksi, $query);

/* Redirect kembali */
header("Location: tagihan.php?status=hapus_sukses");
exit;
