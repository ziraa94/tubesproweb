<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

/* Ambil target tabungan user */
$query = "
    SELECT id, nama_target, target_nominal, saldo_sekarang, tanggal_target, status
    FROM saving_goals
    WHERE user_id = ?
    ORDER BY created_at DESC
";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tabungan & Target - FINWISE</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
:root {
      --primary: #8a9bbd;        /* biru pastel */
      --secondary: #f4a7b9;      /* pink pastel (DOMINAN) */
      --accent: #cce5ff;         /* biru muda terang */
      --dark: #2c3e50;           /* abu-biru gelap */
      --light: #f9fbfd;          /* putih kebiruan */
      --gray: #7f8fa9;           /* abu-abu lembut */
      --success: #4CAF50;
      --danger: #F44336;
      --secondary-darker: #e97a9d; /* Pink sedikit lebih gelap untuk hover/gradien */
    }

/* Layout */
body{font-family: 'Poppins', sans-serif;
      background-color: var(--light);
      min-height: 100vh;
      display: flex;
      color: var(--dark);}
.main-content {
    flex: 1;
    padding: 40px;
}

/* Sidebar */
.sidebar {
      width: 250px; background: var(--dark); padding: 30px 20px;
      display: flex; flex-direction: column; box-shadow: 4px 0 20px rgba(0,0,0,0.1);
      position: sticky; top: 0; height: 100vh;
    }
    .logo { font-family: 'Montserrat', sans-serif; font-size: 1.8em; font-weight: 800; color: var(--light); text-align: center; margin-bottom: 40px; letter-spacing: 1px; }
    .nav-list { list-style: none; flex-grow: 1; }
    .nav-list li { margin-bottom: 10px; }
    .nav-list a {
      display: flex; align-items: center; padding: 12px 15px; color: #cbd5e1;
      text-decoration: none; border-radius: 10px; transition: all 0.3s ease; font-weight: 500;
    }
    .nav-list a i { margin-right: 15px; font-size: 1.2em; }
    .nav-list a:hover { background: rgba(255, 255, 255, 0.1); color: white; }
    /* Navigasi aktif menggunakan warna pink (--secondary) */
    .nav-list .active a {
      background: linear-gradient(90deg, var(--secondary), var(--secondary-darker));
      color: white; box-shadow: 0 4px 10px rgba(244, 167, 185, 0.3); 
      font-weight: 600;
    }
    .logout { margin-top: auto; }
    .logout a { color: var(--secondary); }

.container {
    max-width: 900px;
    margin: auto;
}
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}
.header h2 {
    margin: 0;
}
.btn {
    padding: 10px 16px;
    background: linear-gradient(90deg, #8a9bbd, #a4b8d0);
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}
.card {
    background: white;
    border-radius: 14px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}
.progress-box {
    margin-top: 12px;
}
.progress-bar {
    width: 100%;
    height: 14px;
    background: #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
}
.progress {
    height: 100%;
    background: linear-gradient(90deg, #f4a7b9, #8a9bbd);
}
.meta {
    display: flex;
    justify-content: space-between;
    font-size: 0.9em;
    margin-top: 8px;
    color: #555;
}
.status {
    font-weight: 600;
}
.status.tercapai {
    color: green;
}
.status.aktif {
    color: #e67e22;
}
.empty {
    text-align: center;
    color: #777;
    margin-top: 60px;
}
.transaction-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.transaction-actions a {
    font-size: 1em;
    padding: 6px;
    border-radius: 6px;
    transition: .2s;
}

.edit-btn {
    color: var(--primary);
}

.edit-btn:hover {
    background: #cce5ff;
}

.delete-btn {
    color: var(--danger);
}

.delete-btn:hover {
    background: rgba(244,67,54,.1);
}

</style>
</head>
<body>
    <aside class="sidebar">
    <div class="logo">FINWISE</div>

    <ul class="nav-list">
        <li>
            <a href="dashboard.php">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="transaksi.php">
                <i class="fas fa-wallet"></i> Transaksi
            </a>
        </li>
        <li>
            <a href="tagihan.php">
                <i class="fas fa-clipboard-list"></i> Tagihan
            </a>
        </li>
        <li class="active">
            <a href="tabungan.php">
                <i class="fas fa-piggy-bank"></i> Tabungan & Target
            </a>
        </li>
        <li>
            <a href="kalender.php">
                <i class="fas fa-calendar-alt"></i> Kalender
            </a>
        </li>
        <li>
            <a href="aset.php">
                <i class="fas fa-gem"></i> Aset
            </a>
        </li>
    </ul>

    <div class="logout">
        <a href="index.php">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </a>
    </div>
</aside>


<main class="main-content">

<div class="header">
    <h2><i class="fas fa-piggy-bank"></i> Target Tabungan</h2>
    <a href="tambah_tabungan.php" class="btn">
        <i class="fas fa-plus"></i> Tambah Target
    </a>
</div>

<?php if (mysqli_num_rows($result) === 0): ?>
    <div class="empty">
        <p>Belum ada target tabungan.</p>
    </div>
<?php endif; ?>

<?php while ($row = mysqli_fetch_assoc($result)): 
    $target = $row['target_nominal'];
    $saldo  = $row['saldo_sekarang'];
    $progress = ($target > 0) ? min(100, round(($saldo / $target) * 100)) : 0;
?>
<div class="card">
    <h3><?= htmlspecialchars($row['nama_target']) ?></h3>

    <div class="progress-box">
        <div class="progress-bar">
            <div class="progress" style="width: <?= $progress ?>%"></div>
        </div>
    </div>

    <div class="meta">
        <span>Rp <?= number_format($saldo, 0, ',', '.') ?> /
            Rp <?= number_format($target, 0, ',', '.') ?></span>
        <span><?= $progress ?>%</span>
    </div>

    <div class="meta">
        <span>Target: <?= date('d M Y', strtotime($row['tanggal_target'])) ?></span>
        <span class="status <?= $row['status'] ?>">
            <?= strtoupper($row['status']) ?>
        </span>
        <a href="tambah_saldo.php?id=<?= $row['id'] ?>" class="btn">
        <i class="fas fa-plus-circle"></i> Tambah Saldo
        </a>
        <div class="transaction-actions">
          <a href="edit_tabungan.php?id=<?= $row['id'] ?>"
            class="edit-btn"
            title="Edit Target">
             <i class="fas fa-edit"></i>
          </a>

          <a href="hapus_tabungan.php?id=<?= $row['id'] ?>"
                class="delete-btn"
                title="Hapus Target"
                onclick="return confirm('Yakin hapus target ini?')">
             <i class="fas fa-trash-alt"></i>
          </a>
        </div>

    </div>
</div>
<?php endwhile; ?>

</main>

</body>
</html>
