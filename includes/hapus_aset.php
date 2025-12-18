<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = (int) $_GET['id'];
$user_id = $_SESSION['id'];

mysqli_query(
    $koneksi,
    "DELETE FROM aset WHERE id = $id AND user_id = $user_id"
);

header("Location: aset.php?deleted=1");
exit;
