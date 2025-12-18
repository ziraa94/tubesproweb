<?php
session_start();
require 'koneksi.php';

$user_id = $_SESSION['id'];
$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM saving_goals WHERE id=? AND user_id=?"
);
mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
mysqli_stmt_execute($stmt);

header("Location: tabungan.php");
