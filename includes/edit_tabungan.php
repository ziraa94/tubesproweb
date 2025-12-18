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
    "SELECT * FROM saving_goals WHERE id=? AND user_id=?"
);
mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt)->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Target Tabungan - FINWISE</title>
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

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light);
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
            transition: 0.3s;
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
            max-width: 700px;
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

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 20px;
        }

        .form-grid input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1em;
            background: #fafafa;
        }

        .form-grid input[type="text"] {
            grid-column: 1 / 3;
        }

        button {
            grid-column: 1 / 3;
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
        <li><a href="dashboard.php"><i class="fas fa-arrow-left"></i>&nbsp; Kembali</a></li>
    </ul>
</aside>

<main class="main-content">
    <div class="card">
        <div class="card-title">
            <i class="fas fa-pen-to-square"></i>
            Edit Target Tabungan
        </div>

        <form class="form-grid" action="proses_edit_tabungan.php" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">

            <input type="text" name="nama_target"
                   value="<?= htmlspecialchars($data['nama_target']) ?>"
                   placeholder="Nama Target Tabungan" required>

            <input type="number" name="target_nominal"
                   value="<?= $data['target_nominal'] ?>"
                   placeholder="Target Nominal" min="1" required>

            <input type="date" name="tanggal_target"
                   value="<?= $data['tanggal_target'] ?>" required>

            <button type="submit">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</main>

</body>
</html>
