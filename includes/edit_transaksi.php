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
$db = "data_tubes"; // PASTIKAN NAMA DATABASE SAMA
$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$user_id = $_SESSION['id'];
$transaction_data = null;
$error_message = "";
$success_message = "";

// =======================================================
// A. LOGIKA FETCH DATA TRANSAKSI SAAT INI (Jika ada ID di URL)
// =======================================================
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $transaction_id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    // Ambil semua data transaksi, pastikan user_email sesuai
    $query_fetch = "SELECT * FROM transaksi WHERE id = '$transaction_id' AND user_id = '$user_id'";
    $result_fetch = mysqli_query($koneksi, $query_fetch);

    if (mysqli_num_rows($result_fetch) == 1) {
        $transaction_data = mysqli_fetch_assoc($result_fetch);
    } else {
        $error_message = "Data transaksi tidak ditemukan atau Anda tidak memiliki akses.";
    }
} else if (!isset($_POST['update_transaksi'])) {
    $error_message = "ID transaksi tidak valid.";
}


// =======================================================
// B. LOGIKA UPDATE DATA (Saat Form Disubmit)
// =======================================================
if (isset($_POST['update_transaksi'])) {
    // Ambil data yang dikirim dari formulir
    $id_update = mysqli_real_escape_string($koneksi, $_POST['id']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']); // Menggunakan 'deskripsi'
    $jumlah = mysqli_real_escape_string($koneksi, $_POST['jumlah']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $tipe = mysqli_real_escape_string($koneksi, $_POST['tipe']); // Menggunakan 'tipe'
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']); // Menggunakan 'kategori'
    // Query UPDATE (SESUAIKAN NAMA KOLOM DI SINI!)
    $query_update = "
    UPDATE transaksi 
    SET 
        keterangan='$deskripsi',
        jumlah='$jumlah',
        tanggal='$tanggal',
        jenis='$tipe',
        kategori='$kategori'
    WHERE id='$id_update' AND user_id='$user_id'
";


    if (mysqli_query($koneksi, $query_update)) {
        // Jika sukses
        $success_message = "Transaksi berhasil diperbarui!";
        // Hapus baris redirect jika ada
        // header("Location: riwayat_transaksi.php?status=edit_sukses"); 
        
        // Refresh data setelah update agar form menampilkan data terbaru
        $query_refresh = "SELECT * FROM transaksi WHERE id = '$id_update' AND user_id = '$user_id'";
        $result_refresh = mysqli_query($koneksi, $query_refresh);
        $transaction_data = mysqli_fetch_assoc($result_refresh);
        
    } else {
        // Tampilkan error SQL yang spesifik
        $error_message = "❌ Gagal memperbarui transaksi: " . mysqli_error($koneksi) . ". Query: " . $query_update;
    }
}
// -------------------- END PHP LOGIC --------------------
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
            --primary: #8a9bbd; --secondary: #f4a7b9; --accent: #cce5ff; --dark: #2c3e50; --light: #f9fbfd;
            --gray: #7f8fa9; --success: #4CAF50; --danger: #F44336; --secondary-darker: #e97a9d;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--light); min-height: 100vh; display: flex; color: var(--dark); }
        .sidebar { width: 250px; background: var(--dark); padding: 30px 20px; position: sticky; top: 0; height: 100vh; }
        .logo { font-family: 'Montserrat', sans-serif; font-size: 1.8em; font-weight: 800; color: var(--light); text-align: center; margin-bottom: 40px; }
        .nav-list { list-style: none; }
        .nav-list a { display: flex; align-items: center; padding: 12px 15px; color: #cbd5e1; text-decoration: none; border-radius: 10px; transition: all 0.3s ease; font-weight: 500; }
        .nav-list li:nth-child(2) a { 
            background: linear-gradient(90deg, var(--secondary), var(--secondary-darker));
            color: white; box-shadow: 0 4px 10px rgba(244, 167, 185, 0.3); 
            font-weight: 600;
        }
        .main-content { flex: 1; padding: 40px; overflow-y: auto; }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
        .form-group input, .form-group select {
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 1em;
        }
        .submit-btn {
            background-color: var(--secondary-darker); color: white; padding: 12px 20px; border: none;
            border-radius: 8px; cursor: pointer; font-weight: 600; transition: background-color 0.3s;
        }
        .submit-btn:hover { background-color: var(--secondary-darker); }

        .alert-success { background-color: var(--success); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-danger { background-color: var(--danger); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; }

        .back-link { display: inline-block; margin-bottom: 20px; text-decoration: none; color: var(--primary); font-weight: 500; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="logo">FINWISE</div>
        <ul class="nav-list">
            <li><a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li><a href="transaksi.php"><i class="fas fa-wallet"></i> Transaksi</a></li> 
            <li><a href="tagihan.php"><i class="fas fa-clipboard-list"></i> Tagihan</a></li>
            <li><a href="tabungan.php"><i class="fas fa-piggy-bank"></i> Tabungan & Target</a></li>
            <li><a href="kalender_finwise.php"><i class="fas fa-calendar-alt"></i> Kalender</a></li>
            <li><a href="aset.php"><i class="fas fa-gem"></i> Aset</a></li>
        </ul>
        <div class="logout"><a href="index.php"><i class="fas fa-sign-out-alt"></i> Keluar</a></div>
    </aside>

    <main class="main-content">
        <a href="transaksi.php" class="back-link"><i class="fas fa-chevron-left"></i> Kembali ke Riwayat Transaksi</a>
        
        <h2>Edit Transaksi</h2>

        <?php if ($error_message): ?>
            <div class="alert-danger"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert-success"><?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>

        <?php if ($transaction_data): ?>
            <div class="card">
                <form action="edit_transaksi.php" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($transaction_data['id']) ?>">
                    
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi/Nama Transaksi</label>
                        <input type="text" id="deskripsi" name="deskripsi" value="<?= htmlspecialchars($transaction_data['keterangan']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" id="jumlah" name="jumlah" value="<?= htmlspecialchars($transaction_data['jumlah']) ?>" required min="1">
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal Transaksi</label>
                        <input type="date" id="tanggal" name="tanggal" value="<?= htmlspecialchars($transaction_data['tanggal']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="tipe">Tipe Transaksi</label>
                        <select name="tipe">
                         <option value="pemasukan" <?= ($transaction_data['jenis']=='pemasukan')?'selected':'' ?>>Pemasukan</option>
                         <option value="pengeluaran" <?= ($transaction_data['jenis']=='pengeluaran')?'selected':'' ?>>Pengeluaran</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select id="kategori" name="kategori" required>
                            <option value="makanan" <?= ($transaction_data['kategori'] == 'makanan') ? 'selected' : '' ?>>Makanan & Minuman</option>
                            <option value="gaji" <?= ($transaction_data['kategori'] == 'gaji') ? 'selected' : '' ?>>Gaji</option>
                            <option value="transportasi" <?= ($transaction_data['kategori'] == 'transportasi') ? 'selected' : '' ?>>Transportasi</option>
                            <option value="lainnya" <?= ($transaction_data['kategori'] == 'lainnya') ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>
                    

                    <button type="submit" name="update_transaksi" class="submit-btn">Simpan Perubahan</button>
                </form>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>