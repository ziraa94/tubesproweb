<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$koneksi = mysqli_connect("localhost", "root", "", "data_tubes");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$pesan = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Ambil dan bersihkan data
    $tanggal = $_POST['tanggal_transaksi'];
    $jumlah = (float)$_POST['jumlah'];
    $tipe = $_POST['tipe'];
    $deskripsi = mysqli_real_escape_string($koneksi, trim($_POST['deskripsi']));
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']); // 🔥 BARU: Variabel Kategori
    $akun_sumber = mysqli_real_escape_string($koneksi, $_POST['akun_sumber']);
    $user_email = $_SESSION['email']; 

    // 2. Validasi
    if ($jumlah <= 0 || empty($tipe) || empty($akun_sumber) || empty($kategori)) { // Tambah validasi kategori
        $pesan = "Semua kolom wajib diisi!";
    } else {
        // 3. Query INSERT INTO (Termasuk Kategori)
        $query = "INSERT INTO transaksi (user_email, deskripsi, jumlah, tipe, kategori, akun_sumber, tanggal) 
                  VALUES ('$user_email', '$deskripsi', $jumlah, '$tipe', '$kategori', '$akun_sumber', '$tanggal')";

        if (mysqli_query($koneksi, $query)) {
            // Jika sukses, arahkan ke riwayat transaksi
            header("Location: transaksi.php?status=tambah_sukses");
            exit;
        } else {
            // Tampilkan error SQL yang spesifik
            $pesan = "Error saat menyimpan: " . mysqli_error($koneksi); 
        }
    }
}
// Jangan tutup koneksi di sini, kita butuh koneksi untuk fetch data dropdown di masa depan
// Tapi untuk saat ini, kita biarkan saja agar tidak mengganggu (meskipun idealnya ditutup di akhir)
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tambah Transaksi - FINWISE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #8a9bbd; --secondary: #f4a7b9; --accent: #cce5ff; --dark: #2c3e50; --light: #f9fbfd;
            --success: #4CAF50; --danger: #F44336;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--light); min-height: 100vh; display: flex; color: var(--dark); }
        .sidebar { width: 250px; background: var(--dark); padding: 30px 20px; display: flex; flex-direction: column; box-shadow: 4px 0 20px rgba(0,0,0,0.1); position: sticky; top: 0; height: 100vh; }
        .logo { font-family: 'Montserrat', sans-serif; font-size: 1.8em; font-weight: 800; color: var(--light); text-align: center; margin-bottom: 40px; letter-spacing: 1px; }
        .nav-list { list-style: none; flex-grow: 1; }
        .nav-list a { display: flex; align-items: center; padding: 12px 15px; color: #cbd5e1; text-decoration: none; border-radius: 10px; transition: all 0.3s ease; font-weight: 500; }
        .nav-list a i { margin-right: 15px; font-size: 1.2em; }
        .nav-list a:hover { background: rgba(255, 255, 255, 0.1); color: white; }
        .nav-list .active a { background: linear-gradient(90deg, var(--primary), #6f809f); color: white; box-shadow: 0 4px 10px rgba(138, 155, 189, 0.3); font-weight: 600; }
        .main-content { flex: 1; padding: 40px; overflow-y: auto; }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #eee; margin-bottom: 30px; }
        .card-title { font-size: 1.4em; margin-bottom: 20px; font-weight: 600; border-bottom: 2px solid var(--accent); padding-bottom: 10px; color: var(--dark); }
        .transaction-form { 
            display: grid; grid-template-columns: 1fr 1fr; gap: 15px 20px; align-items: center;
        }
        .transaction-form input, .transaction-form select { 
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 1em; background-color: #fafafa; grid-column: span 1;
        }
        .transaction-form input[type="text"]:first-of-type, .transaction-form input[type="number"]:first-of-type { grid-column: 1 / 3; }
        .transaction-form button { 
            background: linear-gradient(90deg, var(--secondary), var(--primary)); 
            color: white; padding: 12px; border: none; border-radius: 8px; font-weight: 600; 
            cursor: pointer; transition: all 0.3s; grid-column: 1 / 3;
        }
        .alert-error { background-color: var(--danger); color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="logo">FINWISE</div>
        <ul class="nav-list">
            <li><a href="dashboard.php"><i class="fas fa-chart-line"></i> Kembali ke Dashboard</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="card">
            <div class="card-title"><i class="fas fa-wallet" style="margin-right: 10px; color: var(--primary);"></i> Formulir Tambah Transaksi Baru</div>

            <?php if ($pesan && !str_contains($pesan, "Error saat menyimpan:")): ?>
                <div class="alert-error" style="background-color: var(--success);"><?= htmlspecialchars($pesan) ?></div>
            <?php elseif ($pesan): ?>
                <div class="alert-error"><?= htmlspecialchars($pesan) ?></div>
            <?php endif; ?>

            <form class="transaction-form" method="POST" action="">
                <div style="grid-column: 1 / 3;">
                    <input type="number" name="jumlah" placeholder="Jumlah (misal: 100000)" required value="<?= isset($_POST['jumlah']) ? htmlspecialchars($_POST['jumlah']) : '' ?>">
                </div>

                <select name="tipe" required>
                    <option value="">Tipe Transaksi</option>
                    <option value="pengeluaran" <?= (isset($_POST['tipe']) && $_POST['tipe'] == 'pengeluaran') ? 'selected' : '' ?>>Pengeluaran</option>
                    <option value="pemasukan" <?= (isset($_POST['tipe']) && $_POST['tipe'] == 'pemasukan') ? 'selected' : '' ?>>Pemasukan</option>
                </select>
                
                <select name="kategori" required> 
                    <option value="">Pilih Kategori</option>
                    <option value="makanan" <?= (isset($_POST['kategori']) && $_POST['kategori'] == 'makanan') ? 'selected' : '' ?>>Makanan & Minuman</option>
                    <option value="gaji" <?= (isset($_POST['kategori']) && $_POST['kategori'] == 'gaji') ? 'selected' : '' ?>>Gaji</option>
                    <option value="transportasi" <?= (isset($_POST['kategori']) && $_POST['kategori'] == 'transportasi') ? 'selected' : '' ?>>Transportasi</option>
                    <option value="lainnya" <?= (isset($_POST['kategori']) && $_POST['kategori'] == 'lainnya') ? 'selected' : '' ?>>Lainnya</option>
                </select>
                
                <input type="text" name="deskripsi" placeholder="Deskripsi (misal: Beli makan malam di Warung A)" required value="<?= isset($_POST['deskripsi']) ? htmlspecialchars($_POST['deskripsi']) : '' ?>">
                
                <select name="akun_sumber" required>
                    <option value="">Pilih Akun Sumber</option>
                    <option value="bank" <?= (isset($_POST['akun_sumber']) && $_POST['akun_sumber'] == 'bank') ? 'selected' : '' ?>>Bank BCA</option>
                    <option value="cash" <?= (isset($_POST['akun_sumber']) && $_POST['akun_sumber'] == 'cash') ? 'selected' : '' ?>>Uang Tunai</option>
                </select>
                
                <div class="form-group">
                    <label for="tanggal_transaksi">Tanggal Transaksi</label>
                    <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" required value="<?= isset($_POST['tanggal_transaksi']) ? htmlspecialchars($_POST['tanggal_transaksi']) : date('Y-m-d') ?>">
                </div>
                
                <button type="submit"><i class="fas fa-plus-circle"></i> Catat Transaksi Sekarang</button>
            </form>
        </div>
    </main>

</body>
</html>