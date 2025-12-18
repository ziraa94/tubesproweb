<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id, nama_aset, jenis_aset, nilai, tanggal_perolehan
     FROM aset
     WHERE user_id = ?
     ORDER BY created_at DESC"
);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Aset - FINWISE</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
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
*{margin:0;padding:0;box-sizing:border-box}
body{font-family: 'Poppins', sans-serif;
      background-color: var(--light);
      min-height: 100vh;
      display: flex;
      color: var(--dark);}
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

/* MAIN */
.main-content{
  flex:1;
  padding:40px;
}

/* CARD */
.card{
  background:white;
  border-radius:15px;
  padding:30px;
  box-shadow:0 5px 20px rgba(0,0,0,.05);
}
.card-title{
  display:flex;
  justify-content:space-between;
  align-items:center;
  font-size:1.4em;
  font-weight:600;
  border-bottom:2px solid var(--accent);
  padding-bottom:10px;
  margin-bottom:25px;
}

/* BUTTON */
.action-btn{
  background:var(--secondary);
  color:white;
  padding:10px 18px;
  border-radius:8px;
  text-decoration:none;
  font-weight:600;
}
.action-btn:hover{background:#e97a9d}

/* ASET LIST */
.asset-item{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:15px 0;
  border-bottom:1px dashed #eee;
}
.asset-item:last-child{border-bottom:none}

.asset-info h4{
  font-size:1.05em;
  margin-bottom:5px;
}
.asset-info p{
  font-size:.9em;
  color:var(--gray);
}

.asset-value{
  font-weight:600;
  color:var(--primary);
  min-width:160px;
  text-align:right;
}

/* EMPTY */
.empty{
  text-align:center;
  padding:40px;
  color:var(--gray);
}
.asset-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.asset-actions a {
    padding: 6px;
    border-radius: 6px;
    font-size: 1em;
    text-decoration: none;
    transition: background 0.2s;
}

.edit-btn {
    color: var(--primary);
}

.delete-btn {
    color: var(--secondary);
}

.edit-btn:hover {
    background: var(--accent);
}

.delete-btn:hover {
    background: rgba(244, 67, 54, 0.1);
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
        <li>
            <a href="tabungan.php">
                <i class="fas fa-piggy-bank"></i> Tabungan & Target
            </a>
        </li>
        <li>
            <a href="kalender.php">
                <i class="fas fa-calendar-alt"></i> Kalender
            </a>
        </li>
        <li class="active">
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
  <div class="card">
    <div class="card-title">
      Daftar Aset
      <a href="tambah_aset.php" class="action-btn">
        <i class="fas fa-plus"></i> Tambah Aset
      </a>
    </div>

    <?php if (mysqli_num_rows($result) === 0): ?>
      <div class="empty">
        <i class="fas fa-gem" style="font-size:3em;color:var(--secondary)"></i>
        <p>Belum ada aset tercatat.</p>
      </div>
    <?php endif; ?>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="asset-item">
        <div class="asset-info">
          <h4><?= htmlspecialchars($row['nama_aset']) ?></h4>
          <p>
            <?= ucfirst($row['jenis_aset']) ?>
            <?= $row['tanggal_perolehan'] ? ' | '.$row['tanggal_perolehan'] : '' ?>
          </p>
        </div>
        <div class="asset-value">
          Rp <?= number_format($row['nilai'],0,',','.') ?>
          <div class="asset-actions">
            <a href="edit_aset.php?id=<?= $row['id'] ?>" 
              class="edit-btn" title="Edit Aset">
                <i class="fas fa-edit"></i>
            </a>

            <a href="hapus_aset.php?id=<?= $row['id'] ?>" 
              class="delete-btn"
              title="Hapus Aset"
              onclick="return confirm('Hapus aset ini?')">
                <i class="fas fa-trash-alt"></i>
            </a>
          </div>

        </div>
      </div>
    <?php endwhile; ?>

  </div>
</main>

</body>
</html>
