<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];
$id = (int) ($_GET['id'] ?? 0);

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT nama_target, target_nominal, saldo_sekarang 
     FROM saving_goals 
     WHERE id = ? AND user_id = ?"
);
mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt)->fetch_assoc();

if (!$data) {
    die("Target tidak ditemukan");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Saldo Tabungan - FINWISE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary: #8a9bbd;
            --secondary: #f4a7b9;
            --accent: #cce5ff;
            --dark: #2c3e50;
            --light: #f9fbfd;
            --success: #4CAF50;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            min-height: 100vh;
            display: flex;
            color: var(--dark);
        }

        .sidebar {
            width: 250px;
            background: var(--dark);
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
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
            transition: all 0.3s;
            font-weight: 500;
        }

        .nav-list a i {
            margin-right: 12px;
        }

        .nav-list a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .main-content {
            flex: 1;
            padding: 40px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            border: 1px solid #eee;
            max-width: 600px;
        }

        .card-title {
            font-size: 1.4em;
            font-weight: 600;
            margin-bottom: 20px;
            border-bottom: 2px solid var(--accent);
            padding-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-box {
            background: var(--accent);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.95em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1em;
            background-color: #fafafa;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            color: white;
            background: linear-gradient(90deg, var(--secondary), var(--primary));
        }

        button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="logo">FINWISE</div>
    <ul class="nav-list">
        <li>
            <a href="dashboard.php">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </li>
    </ul>
</aside>

<main class="main-content">
    <div class="card">
        <div class="card-title">
            <i class="fas fa-coins"></i>
            Tambah Saldo Tabungan
        </div>

        <div class="info-box">
            <strong><?= htmlspecialchars($data['nama_target']) ?></strong><br>
            Target: Rp <?= number_format($data['target_nominal'], 0, ',', '.') ?><br>
            Saldo Saat Ini: Rp <?= number_format($data['saldo_sekarang'], 0, ',', '.') ?>
        </div>

        <form action="proses_tambah_saldo.php" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="form-group">
                <label>Nominal Tambahan (Rp)</label>
                <input type="number" name="nominal" min="1" required>
            </div>

            <button type="submit">
                <i class="fas fa-plus-circle"></i> Tambah Saldo
            </button>
        </form>
    </div>
</main>

</body>
</html>
