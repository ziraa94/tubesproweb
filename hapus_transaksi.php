<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: transaksi.php");
    exit;
}

// 🔥 Koneksi Database
$host = "localhost";
$user = "root";
$pass = "";
$db = "data_tubes"; 
$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$transaction_id = mysqli_real_escape_string($koneksi, $_GET['id']);
$user_email = $_SESSION['email'];

// Query Hapus
$query_hapus = "DELETE FROM transaksi WHERE id = '$transaction_id' AND user_email = '$user_email'";

if (mysqli_query($koneksi, $query_hapus)) {
    // 🔥 PENTING: Redirect otomatis setelah berhasil
    header("Location: transaksi.php?status=hapus_sukses");
} else {
    // Jika ada error (misalnya hak akses), kembali ke riwayat dengan pesan error
    // Ini adalah fallback, karena Anda bilang DELETE berhasil
    header("Location: transaksi.php?status=hapus_gagal"); 
}

mysqli_close($koneksi);
exit;
?>