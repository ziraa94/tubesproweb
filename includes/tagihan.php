<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$koneksi = mysqli_connect("localhost", "root", "", "data_tubes");
if (!$koneksi) {
    die("Koneksi database gagal");
}

$user_id = $_SESSION['id'];

/* ======================
   AMBIL DATA TAGIHAN
====================== */
$query = "
    SELECT 
        id,
        nama_tagihan,
        jumlah,
        kategori,
        frekuensi,
        tanggal_jatuh_tempo,
        status
    FROM tagihan
    WHERE user_id = $user_id
    ORDER BY tanggal_jatuh_tempo ASC
";

$result = mysqli_query($koneksi, $query);
$tagihan = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tagihan[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tagihan - FINWISE</title>
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


.main-content{flex:1;padding:40px}
.header{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px}
.card{background:white;padding:30px;border-radius:15px;box-shadow:0 5px 20px rgba(0,0,0,.05)}

.tagihan-item{
  display:flex;justify-content:space-between;align-items:center;
  padding:15px 0;border-bottom:1px dotted #eee
}
.tagihan-item:last-child{border-bottom:none}

.status-belum{color:var(--danger);font-weight:600}
.status-lunas{color:var(--success);font-weight:600}

.action-btn{
  background:var(--secondary);color:white;
  padding:8px 14px;border-radius:8px;
  text-decoration:none;font-weight:600;font-size:.9em
}
.action-btn:hover{opacity:.9}

.empty{text-align:center;color:var(--gray);padding:40px}
</style>
</head>
<body>

<aside class="sidebar">
    <div class="logo">FINWISE</div>
    
    <ul class="nav-list">
        <li data-tab="dashboard">
            <a href="dashboard.php">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
        </li>
        <li data-tab="catatan">
            <a href="transaksi.php">
                <i class="fas fa-wallet"></i> Transaksi
            </a>
        </li> 
        <li data-tab="tagihan" class="active">
            <a href="tagihan.php">
                <i class="fas fa-clipboard-list"></i> Tagihan
            </a>
        </li>
        <li data-tab="tabungan">
            <a href="tabungan.php">
                <i class="fas fa-piggy-bank"></i> Tabungan & Target
            </a>
        </li>
        <li data-tab="kalender">
            <a href="kalender.php">
                <i class="fas fa-calendar-alt"></i> Kalender
            </a>
        </li>
        <li data-tab="aset">
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
    <h2>Daftar Tagihan</h2>
    <a href="tambah_tagihan.php" class="action-btn">
      <i class="fas fa-plus"></i> Tambah Tagihan
    </a>
  </div>

  <div class="card">
    <?php if (count($tagihan) > 0): ?>
      <?php foreach ($tagihan as $t): ?>
        <?php
          $tanggal = date('d M Y', strtotime($t['tanggal_jatuh_tempo']));
          $jumlah = number_format($t['jumlah'],0,',','.');
          $statusClass = $t['status'] === 'lunas' ? 'status-lunas' : 'status-belum';
        ?>
        <div class="tagihan-item">
          <div>
            <h4><?= htmlspecialchars($t['nama_tagihan']) ?></h4>
            <p style="font-size:.9em;color:var(--gray)">
              Jatuh tempo: <?= $tanggal ?> |
              <?= ucfirst($t['frekuensi']) ?> |
              <?= htmlspecialchars($t['kategori']) ?>
            </p>
          </div>

        <div style="text-align:right">
    <div><strong>Rp <?= $jumlah ?></strong></div>
    <div class="<?= $statusClass ?>">
    <?= strtoupper($t['status']) ?>
</div>

<?php if ($t['status'] === 'belum'): ?>
    <div style="margin-top:6px">
        <a href="lunas_tagihan.php?id=<?= $t['id'] ?>"
           class="action-btn"
           style="background:var(--success);font-size:.8em"
           onclick="return confirm('Tandai tagihan ini sebagai lunas?')">
           <i class="fas fa-check"></i> Lunas
        </a>
    </div>
<?php endif; ?>


    <div style="margin-top:8px">
        <a href="hapus_tagihan.php?id=<?= $t['id'] ?>"
           onclick="return confirm('Yakin ingin menghapus tagihan ini?')"
           style="color:#F44336;font-size:.85em;text-decoration:none">
           <i class="fas fa-trash"></i> Hapus
        </a>
    </div>
</div>

        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="empty">
        <i class="fas fa-receipt" style="font-size:3em;color:var(--secondary)"></i>
        <p>Belum ada tagihan.</p>
      </div>
    <?php endif; ?>
  </div>
</main>

</body>
</html>
