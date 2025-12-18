<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// 🔥 Koneksi Database
$host = "localhost";
$user = "root";
$pass = "";
$db = "data_tubes"; // PASTIKAN NAMA DATABASE ANDA BENAR
$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// 🔥 Query untuk mengambil data TRANSAKSI
$user_id = $_SESSION['id'];
// ASUMSI NAMA TABEL ANDA ADALAH 'transaksi' DAN MEMILIKI KOLOM 'id', 'tanggal', 'nama', 'jenis', 'jumlah'
$query_transaksi = "SELECT 
        id,
        tanggal,
        keterangan AS nama,
        jenis,
        jumlah,
        kategori
    FROM transaksi
    WHERE user_id = $user_id ORDER BY tanggal DESC"; 
// Menggunakan AS (Alias) agar tampilan tetap sama
$result_transaksi = mysqli_query($koneksi, $query_transaksi);

$transactions = [];
if ($result_transaksi) {
    while ($row = mysqli_fetch_assoc($result_transaksi)) {
        $transactions[] = $row;
    }
}

?>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Riwayat Transaksi - FINWISE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Skema Warna FINWISE (DISALIN DARI KODE ASLI ANDA) */
        :root {
            --primary: #8a9bbd;      /* biru pastel */
            --secondary: #f4a7b9;    /* pink pastel (DOMINAN) */
            --accent: #cce5ff;       /* biru muda terang */
            --dark: #2c3e50;         /* abu-biru gelap */
            --light: #f9fbfd;        /* putih kebiruan */
            --gray: #7f8fa9;         /* abu-abu lembut */
            --success: #4CAF50;
            --danger: #F44336;
            --secondary-darker: #e97a9d;
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
        .sidebar { width: 250px; background: var(--dark); padding: 30px 20px; display: flex; flex-direction: column; box-shadow: 4px 0 20px rgba(0,0,0,0.1); position: sticky; top: 0; height: 100vh; }
        .logo { font-family: 'Montserrat', sans-serif; font-size: 1.8em; font-weight: 800; color: var(--light); text-align: center; margin-bottom: 40px; letter-spacing: 1px; }
        .nav-list { list-style: none; flex-grow: 1; }
        .nav-list li { margin-bottom: 10px; }
        .nav-list a { display: flex; align-items: center; padding: 12px 15px; color: #cbd5e1; text-decoration: none; border-radius: 10px; transition: all 0.3s ease; font-weight: 500; }
        .nav-list a i { margin-right: 15px; font-size: 1.2em; }
        .nav-list a:hover { background: rgba(255, 255, 255, 0.1); color: white; }
        
        /* Navigasi AKTIF pada halaman ini */
        .nav-list .active a {
            background: linear-gradient(90deg, var(--secondary), var(--secondary-darker));
            color: white; box-shadow: 0 4px 10px rgba(244, 167, 185, 0.3); 
            font-weight: 600;
        }
        .logout { margin-top: auto; }
        .logout a { color: var(--secondary); }
        
        /* ====== MAIN CONTENT & CARD ====== */
        .main-content { flex: 1; padding: 40px; overflow-y: auto; }
        .header-content { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header-content h2 { font-size: 2em; font-weight: 700; color: var(--dark); }
        .user-profile { display: flex; align-items: center; font-weight: 600; color: var(--dark); }
        .profile-avatar { width: 40px; height: 40px; border-radius: 50%; background-color: var(--secondary); color: white; display: flex; justify-content: center; align-items: center; font-size: 1.1em; margin-left: 10px; }
        
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
            background-color: var(--secondary); 
        }
        .action-btn:hover { background-color: var(--secondary-darker); }
        .action-btn i { margin-right: 5px; }

        /* === List Styles (Modifikasi) === */
        .transaction-item { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 12px 0; 
            border-bottom: 1px dotted #eee; 
        }
        .transaction-item:last-child { border-bottom: none; }
        .trans-expense { color: var(--danger); }
        .trans-income { color: var(--success); }
        
        /* Gaya untuk Kontainer Aksi dan Tombol */
        .transaction-info {
            flex-grow: 1;
            /* Pastikan info dan aksi tidak terlalu dekat */
            margin-right: 20px; 
        }

        .transaction-actions {
            display: flex;
            align-items: center;
            min-width: 80px; /* Lebar minimum agar tombol terlihat rapi */
        }

        .transaction-actions a {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1em;
            margin-left: 10px;
            padding: 5px;
            border-radius: 5px;
            transition: background-color 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .transaction-actions .edit-btn {
            color: var(--primary); 
        }
        .transaction-actions .delete-btn {
            color: var(--secondary); 
        }

        .transaction-actions .edit-btn:hover {
            background-color: var(--accent);
        }
        .transaction-actions .delete-btn:hover {
            background-color: rgba(244, 67, 54, 0.1);
        }

        .empty-state {
            text-align: center; 
            padding: 40px; 
            color: var(--gray);
            font-size: 1.1em;
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="logo">FINWISE</div>
        
        <ul class="nav-list">
            <li data-tab="dashboard"><a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li data-tab="catatan" class="active"><a href="#"><i class="fas fa-wallet"></i> Transaksi</a></li> 
            <li data-tab="tagihan"><a href="tagihan.php"><i class="fas fa-clipboard-list"></i> Tagihan</a></li>
            <li data-tab="tabungan"><a href="tabungan.php"><i class="fas fa-piggy-bank"></i> Tabungan & Target</a></li>
            <li data-tab="kalender"><a href="kalender.php"><i class="fas fa-calendar-alt"></i> Kalender</a></li>
            <li data-tab="aset"><a href="aset.php"><i class="fas fa-gem"></i> Aset</a></li>
        </ul>

        <div class="logout">
            <a href="index.php"><i class="fas fa-sign-out-alt"></i> Keluar</a>
        </div>
    </aside>

    <main class="main-content">
        
        <div class="header-content">
            <h2>Riwayat Transaksi</h2>
            <div class="user-profile">
                <span><?= htmlspecialchars($_SESSION['nama']) ?></span>
                <div class="profile-avatar"><?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?></div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-title">
                Semua Transaksi Tercatat
                <a href="tambah_transaksi.php" class="action-btn">
                    <i class="fas fa-plus"></i> Tambah Transaksi
                </a>
            </div>
            <div class="transaction-list">
                
                <?php if (count($transactions) > 0): ?>
                    <?php foreach ($transactions as $t): ?>
                        <?php
                            $formatted_amount = number_format($t['jumlah'], 0, ',', '.');
                            $class = ($t['jenis'] == 'pemasukan') ? 'trans-income' : 'trans-expense';
                            $sign  = ($t['jenis'] == 'pemasukan') ? '+ ' : '- ';
                            $date_format = date('d M Y', strtotime($t['tanggal']));
                        ?>
                        <div class="transaction-item">
                            <div class="transaction-info">
                                <h4><?= htmlspecialchars($t['nama']) ?></h4>
                                <p style="color: var(--gray); font-size: 0.9em;">
                                    <?= $date_format ?> | Kategori: <?= htmlspecialchars($t['jenis']) ?>
                                </p>
                            </div>
                            
                            <span class="<?= $class ?>" style="font-weight: 600; min-width: 150px; text-align: right; margin-right: 20px;">
                                <?= $sign ?> Rp <?= $formatted_amount ?>
                            </span>

                            <div class="transaction-actions">
                                <a href="edit_transaksi.php?id=<?= $t['id'] ?>" class="edit-btn" title="Edit Transaksi">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="hapus_transaksi.php?id=<?= $t['id'] ?>" class="delete-btn" title="Hapus Transaksi" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-money-bill-wave" style="font-size: 3em; margin-bottom: 15px; color: var(--secondary);"></i>
                        <p>Belum ada riwayat transaksi yang tercatat.</p>
                        <p style="margin-bottom: 20px;">Mari mulai kelola keuanganmu sekarang!</p>
                        <a href="tambah_transaksi.php" class="action-btn" style="background-color: var(--primary);">
                            <i class="fas fa-plus"></i> Tambah Transaksi Pertama
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        </main>
</body>
</html>