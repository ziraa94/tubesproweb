<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// 🔥 Tambahkan koneksi & ambil data tagihan
$host = "localhost";
$user = "root";
$pass = "";
$db = "data_tubes";
$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi database gagal");
}

$bulan = $_GET['bulan'] ?? date('n');
$tahun = $_GET['tahun'] ?? date('Y');

$user_id = $_SESSION['id'];
$query_tagihan = "SELECT * FROM tagihan WHERE user_id = '$user_id' ORDER BY tanggal_jatuh_tempo ASC";
$result_tagihan = mysqli_query($koneksi, $query_tagihan);

$user_id = $_SESSION['id'];
$query = "SELECT tanggal_jatuh_tempo, nama_tagihan, jumlah FROM tagihan WHERE user_id = '$user_id'";
$result = mysqli_query($koneksi, $query);

$tagihan = [];
while ($row = mysqli_fetch_assoc($result)) {
    $tgl = $row['tanggal_jatuh_tempo'];
    if (!isset($tagihan[$tgl])) {
        $tagihan[$tgl] = [];
    }
    $tagihan[$tgl][] = "💡 " . htmlspecialchars($row['nama_tagihan']) . " - Rp " . number_format($row['jumlah'], 0, ',', '.');
}

$tagihan_json = json_encode($tagihan, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

// TOTAL PEMASUKAN BULAN INI
$stmt = mysqli_prepare($koneksi, "
    SELECT SUM(jumlah)
    FROM transaksi
    WHERE user_id = ?
      AND jenis = 'pemasukan'
      AND MONTH(tanggal) = ?
      AND YEAR(tanggal) = ?
");
mysqli_stmt_bind_param($stmt, "iii", $user_id, $bulan, $tahun);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $total_masuk);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// TOTAL PENGELUARAN BULAN INI
$stmt = mysqli_prepare($koneksi, "
    SELECT SUM(jumlah)
    FROM transaksi
    WHERE user_id = ?
      AND jenis = 'pengeluaran'
      AND MONTH(tanggal) = ?
      AND YEAR(tanggal) = ?
");
mysqli_stmt_bind_param($stmt, "iii", $user_id, $bulan, $tahun);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $total_keluar);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$total_masuk  = $total_masuk  ?? 0;
$total_keluar = $total_keluar ?? 0;

$stmt = mysqli_prepare($koneksi, "
    SELECT keterangan, jenis, jumlah, tanggal, kategori
    FROM transaksi
    WHERE user_id = ?
    ORDER BY tanggal DESC
    LIMIT 5
");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result_transaksi = mysqli_stmt_get_result($stmt);

?>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - FINWISE</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* Skema Warna FINWISE  */
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

    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--light);
      min-height: 100vh;
      display: flex;
      color: var(--dark);
    }

    /* ====== SIDEBAR (NAVIGASI) ====== */
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
    
    /* ====== MAIN CONTENT & CARD ====== */
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }
    
    /* REVISI: Kontainer Header untuk memposisikan Nama Pengguna */
    .header-content { 
      display: flex; 
      justify-content: space-between; /* Untuk memisahkan Judul dan Profil */
      align-items: center; 
      margin-bottom: 30px; 
    }
    .header-content h2 { font-size: 2em; font-weight: 700; color: var(--dark); }


.day-name {
  font-weight: 600;
  color: var(--secondary);
  text-align: center;
}

    /* Gaya Profil Pengguna di kanan atas */
    .user-profile { 
      display: flex; 
      align-items: center; 
      font-weight: 600; 
      color: var(--dark);
    }
    .profile-avatar { 
        width: 40px; height: 40px; border-radius: 50%; 
        background-color: var(--secondary); /* Diubah ke pink */
        color: white; 
        display: flex; justify-content: center; align-items: center; 
        font-size: 1.1em; margin-left: 10px; 
    }
    
    .finance-summary { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 40px; }
    .summary-card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
    .income i { background-color: var(--accent); color: var(--dark); }
    .expense i { background-color: var(--secondary); color: white; } 
    .summary-text p { color: var(--gray); font-size: 0.9em; margin: 0;}
    .summary-text h3 { font-size: 1.8em; font-weight: 700; color: var(--dark); margin: 5px 0 0; }

    /*  Ikon Panah jadi lingkaran */
.summary-card i {
  /* properti untuk membuat lingkaran */
  width: 40px; 
  height: 40px; 
  border-radius: 50%;
  display: flex; /* Untuk memposisikan ikon fa-arrow di tengah */
  justify-content: center;
  align-items: center;
  font-size: 1.2em;
}

/* Warna untuk Ikon Pemasukan (biru muda, ikon gelap) */
.summary-card.income i { 
  background-color: var(--accent); /* #cce5ff */
  color: var(--dark);              /* #2c3e50 */
}

/* Warna untuk Ikon Pengeluaran (pink, ikon putih) */
.summary-card.expense i { 
  background-color: var(--secondary); /* #f4a7b9 */
  color: white; 
}

    /* Feature Content Management */
    .feature-content { display: none; padding: 30px 0; }
    .feature-content.active { display: block; }
    
    .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #eee; margin-bottom: 30px; }
    .card-title {
      font-size: 1.4em; margin-bottom: 20px; font-weight: 600;
      border-bottom: 2px solid var(--accent); padding-bottom: 10px;
      color: var(--dark); display: flex; justify-content: space-between; align-items: center;
    }
    
    .action-btn {
        color: white; border: none; padding: 8px 15px; border-radius: 8px; font-size: 0.9em;
        cursor: pointer; transition: background-color 0.3s; text-decoration: none;
        font-weight: 600;
        /* Diubah ke Pink/Secondary untuk konsistensi */
        background-color: var(--secondary); 
    }
    .action-btn i { margin-right: 5px; }

    /* === Diagram Lingkaran Style === */
    .chart-placeholder { height: 300px; background-color: var(--accent); border-radius: 10px; display: flex; flex-direction: column; justify-content: center; align-items: center; font-weight: 600; color: var(--dark); border: 2px dashed var(--primary); }
    .pie-chart-mockup {
        width: 150px; height: 150px; border-radius: 50%;
        /* Gradien menggunakan Pink dan Biru */
        background: conic-gradient(var(--secondary) 0% 30%, var(--primary) 30% 100%);
        margin-bottom: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .chart-legend p { font-size: 0.9em; margin: 5px 0; display: flex; align-items: center; }
    .legend-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 8px; }

    /* === List Styles === */
    .transaction-item, .bill-item, .asset-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px dotted #eee; }
    .transaction-item:last-child, .bill-item:last-child, .asset-item:last-child { border-bottom: none; }
    .trans-expense { color: var(--danger); }
    .trans-income { color: var(--success); }
    .bill-amount { font-weight: 700; color: var(--secondary); } /* Diubah ke pink */
    .asset-item i { color: var(--secondary) !important; margin-right: 10px; } /* Diubah ke pink */
    .asset-value { font-weight: 600; color: var(--dark); }
    .goal-progress { margin-bottom: 15px; }
    .progress-bar-container { height: 10px; background-color: #eee; border-radius: 5px; overflow: hidden; }
    .progress-bar { height: 100%; background-color: var(--secondary); width: 50%; /* Diubah ke pink */ }
    
    /* Kalender Icon */
    #kalender i.fa-calendar-alt { color: var(--secondary) !important; }

    @media (max-width: 900px) {
        .finance-summary { grid-template-columns: 1fr; }
        .sidebar { width: 100%; height: auto; position: relative; padding: 20px; }
        .nav-list { display: flex; flex-wrap: wrap; justify-content: center; margin-bottom: 20px; }
        .main-content { padding: 20px; }
    }
  </style>
</head>
<body>

  <aside class="sidebar">
    <div class="logo">FINWISE</div>
    
    <ul class="nav-list">
      <li data-tab="dashboard" class="active"><a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
      <li data-tab="catatan"><a href="transaksi.php"><i class="fas fa-wallet"></i> Transaksi</a></li>
      <li data-tab="tagihan"><a href="tagihan.php"><i class="fas fa-clipboard-list"></i> Tagihan</a></li>
      <li data-tab="tabungan"><a href="tabungan.php"><i class="fas fa-piggy-bank"></i> Tabungan & Target</a></li>
      <li data-tab="kalender"><a href="kalender.php"><i class="fas fa-calendar-alt"></i> Kalender</a></li>
      <li data-tab="aset"><a href="aset.php"><i class="fas fa-gem"></i> Aset</a></li>
    </ul>

    <div class="logout">
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>
  </aside>

  <main class="main-content">
    
    <div class="header-content">
      <h2>
        Ringkasan Keuangan — 
        <?= date('F Y', mktime(0,0,0,$bulan,1,$tahun)) ?>
      </h2>

      <form method="GET" style="display:flex; gap:10px;">
  <select name="bulan">
    <?php for ($b = 1; $b <= 12; $b++): ?>
      <option value="<?= $b ?>" <?= ($b == ($_GET['bulan'] ?? date('n'))) ? 'selected' : '' ?>>
        <?= date('F', mktime(0,0,0,$b,1)) ?>
      </option>
    <?php endfor; ?>
  </select>

  <select name="tahun">
    <?php for ($t = date('Y')-5; $t <= date('Y'); $t++): ?>
      <option value="<?= $t ?>" <?= ($t == ($_GET['tahun'] ?? date('Y'))) ? 'selected' : '' ?>>
        <?= $t ?>
      </option>
    <?php endfor; ?>
  </select>

  <button type="submit" class="action-btn">Terapkan</button>
</form>

      <div class="user-profile">
        <span><?= htmlspecialchars($_SESSION['nama']) ?></span>
        <div class="profile-avatar"><?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?></div>
      </div>
    </div>
    
    <div class="finance-summary">
    <div class="summary-card income">
        <div class="summary-text">
            <p>Total Penghasilan (Bulan Ini)</p>
            <h3>Rp <?= number_format($total_masuk,0,',','.') ?></h3>
        </div>
        <i class="fas fa-arrow-up"></i>
    </div>
    <div class="summary-card expense">
        <div class="summary-text">
            <p>Total Pengeluaran (Bulan Ini)</p>
            <h3>Rp <?= number_format($total_keluar,0,',','.') ?></h3>
        </div>
        <i class="fas fa-arrow-down"></i>
    </div>
</div>
    
    <div id="dashboard" class="feature-content active">
        <div class="card">
            <div class="card-title">Diagram Analisis Total Keuangan (Diagram Lingkaran)</div>
              <div style="width: 300px; margin: auto;">
                 <canvas id="financeChart"></canvas>
              </div>
            </div>
    </div>

    <div id="catatan" class="feature-content">
        <div class="card">
            <div class="card-title">
                Riwayat Transaksi Terbaru
                <a href="tambah_transaksi.php" class="action-btn"> 
                    <i class="fas fa-plus"></i> Tambah Transaksi
                </a>
            </div>
            <?php while ($t = mysqli_fetch_assoc($result_transaksi)): ?>
<div class="transaction-item">
  <div>
    <h4><?= htmlspecialchars($t['nama_transaksi']) ?></h4>
    <p style="color: var(--gray);">
      <?= date('d M Y', strtotime($t['tanggal'])) ?> | <?= $t['kategori'] ?>
    </p>
  </div>
  <span class="<?= $t['jenis']=='pemasukan'?'trans-income':'trans-expense' ?>">
    <?= $t['jenis']=='pemasukan'?'+':'-' ?>
    Rp <?= number_format($t['jumlah'],0,',','.') ?>
  </span>
</div>
<?php endwhile; ?>

        </div>
    </div>

    <div id="tagihan" class="feature-content">
  <div class="card">
    <div class="card-title">
      Daftar Tagihan Mendatang
      <a href="tambah_tagihan.php" class="action-btn">
        <i class="fas fa-plus"></i> Tambah Tagihan
      </a>
    </div>

    <?php if (mysqli_num_rows($result_tagihan) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result_tagihan)): ?>
        <div class="bill-item">
          <div>
            <h4><?= htmlspecialchars($row['nama_tagihan']) ?></h4>
            <p style="color: var(--gray);">
              Jatuh Tempo: <?= date('d M Y', strtotime($row['tanggal_jatuh_tempo'])) ?>
            </p>
          </div>
          <div class="bill-amount">
            Rp <?= number_format($row['jumlah'], 0, ',', '.') ?>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align: center; color: var(--gray); margin-top: 20px;">
        Belum ada tagihan. <a href="tambah_tagihan.php" style="color: var(--secondary);">Tambah sekarang?</a>
      </p>
    <?php endif; ?>
  </div>
</div>

    
  </main>

  <script>
const monthYear = document.getElementById("monthYear");
const daysEl = document.getElementById("days");
const billList = document.getElementById("billList");

let current = new Date();

// 🔥 Data tagihan dari database
const bills = <?= $tagihan_json ?>;

const totalMasuk = <?= $total_masuk ?>;
const totalKeluar = <?= $total_keluar ?>;
const sisaDana = totalMasuk - totalKeluar;

const ctx = document.getElementById('financeChart').getContext('2d');

new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Pengeluaran', 'Sisa Dana'],
        datasets: [{
            data: [totalKeluar, sisaDana > 0 ? sisaDana : 0],
        }]
    },
    options: {
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>


</body>
</html>