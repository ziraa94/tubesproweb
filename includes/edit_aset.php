<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = (int) $_GET['id'];
$user_id = $_SESSION['id'];

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM aset WHERE id = $id AND user_id = $user_id"
);

$data = mysqli_fetch_assoc($query);
if (!$data) {
    die("Aset tidak ditemukan");
}
?>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Transaksi - FINWISE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
  --primary: #8a9bbd;
  --secondary: #f4a7b9;
  --accent: #cce5ff;
  --dark: #2c3e50;
  --light: #f9fbfd;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Poppins', sans-serif;
  background-color: var(--light);
  min-height: 100vh;
  display: flex;
  color: var(--dark);
}

/* SIDEBAR */
.sidebar {
  width: 250px;
  background: var(--dark);
  padding: 30px 20px;
  display: flex;
  flex-direction: column;
  position: sticky;
  top: 0;
  height: 100vh;
}

.logo {
  font-family: 'Montserrat', sans-serif;
  font-size: 1.8em;
  font-weight: 800;
  color: white;
  text-align: center;
  margin-bottom: 40px;
}

.nav-list {
  list-style: none;
}

.nav-list a {
  display: flex;
  align-items: center;
  padding: 12px 15px;
  color: #cbd5e1;
  text-decoration: none;
  border-radius: 10px;
  transition: 0.3s;
}

.nav-list a i {
  margin-right: 12px;
}

.nav-list a:hover {
  background: rgba(255,255,255,0.1);
  color: white;
}

/* MAIN CONTENT */
.main-content {
  flex: 1;
  padding: 40px;
}

.card {
  background: white;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.05);
  max-width: 600px;
}

.card-title {
  font-size: 1.4em;
  font-weight: 600;
  margin-bottom: 25px;
  border-bottom: 2px solid var(--accent);
  padding-bottom: 10px;
}

/* FORM */
.asset-form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.asset-form label {
  font-weight: 500;
}

.asset-form input,
.asset-form select {
  padding: 12px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 1em;
  background-color: #fafafa;
}

.asset-form button {
  margin-top: 10px;
  padding: 12px;
  background: linear-gradient(90deg, var(--primary), #6f809f);
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s;
}

.asset-form button:hover {
  opacity: 0.9;
}
</style>
</head>
<body>

<aside class="sidebar">
  <div class="logo">FINWISE</div>
  <ul class="nav-list">
    <li>
      <a href="aset.php">
        <i class="fas fa-arrow-left"></i> Kembali ke Aset
      </a>
    </li>
  </ul>
</aside>

<main class="main-content">
  <div class="card">
    <div class="card-title">
      <i class="fas fa-pen"></i> Edit Aset
    </div>

    <form class="asset-form" method="POST" action="proses_edit_aset.php">
      <input type="hidden" name="id" value="<?= $data['id'] ?>">

      <label>Nama Aset</label>
      <input type="text" name="nama_aset" value="<?= $data['nama_aset'] ?>" required>

      <label>Jenis Aset</label>
      <select name="jenis_aset" required>
        <option value="investasi" <?= $data['jenis_aset']=='investasi'?'selected':'' ?>>Investasi</option>
        <option value="properti" <?= $data['jenis_aset']=='properti'?'selected':'' ?>>Properti</option>
        <option value="kendaraan" <?= $data['jenis_aset']=='kendaraan'?'selected':'' ?>>Kendaraan</option>
      </select>

      <label>Nilai Aset (Rp)</label>
      <input type="number" name="nilai" value="<?= $data['nilai'] ?>" required>

      <label>Tanggal Perolehan</label>
      <input type="date" name="tanggal_perolehan" value="<?= $data['tanggal_perolehan'] ?>" required>

      <button type="submit">
        <i class="fas fa-save"></i> Simpan Perubahan
      </button>
    </form>

  </div>
</main>

</body>
</html>