<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$koneksi = mysqli_connect("localhost", "root", "", "data_tubes");
if (!$koneksi) {
    die("Koneksi gagal");
}

$pesan = "";

if (isset($_POST['simpan'])) {
    $user_id = $_SESSION['id'];
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama_tagihan']);
    $jumlah  = (int) $_POST['jumlah'];
    $kategori = $_POST['kategori'];
    $frekuensi = $_POST['frekuensi'];
    $tanggal = $_POST['tanggal_jatuh_tempo'];

    // Validasi keras (bukan basa-basi)
    if ($jumlah <= 0) {
        $pesan = "Jumlah tagihan tidak valid";
    } else {
        $query = "
            INSERT INTO tagihan 
            (user_id, nama_tagihan, jumlah, kategori, frekuensi, tanggal_jatuh_tempo)
            VALUES 
            ($user_id, '$nama', $jumlah, '$kategori', '$frekuensi', '$tanggal')
        ";

        if (mysqli_query($koneksi, $query)) {
            header("Location: tagihan.php?status=berhasil");
            exit;
        } else {
            $pesan = "Gagal menyimpan tagihan: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tambah Tagihan - FINWISE</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    /* CSS untuk konsistensi */
    :root {
      --primary: #8a9bbd; --secondary: #f4a7b9; --accent: #cce5ff; --dark: #2c3e50; --light: #f9fbfd;
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

    .main-content { flex: 1; padding: 40px; overflow-y: auto; }
    .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #eee; margin-bottom: 30px; }
    .card-title { font-size: 1.4em; margin-bottom: 20px; font-weight: 600; border-bottom: 2px solid var(--accent); padding-bottom: 10px; color: var(--dark); }

    /* Gaya Khusus Formulir */
    .bill-form { display: flex; flex-direction: column; gap: 15px; }
    .bill-form input, .bill-form select { 
        width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 1em; background-color: #fafafa;
    }
    .bill-form button { 
        background-color: var(--secondary); 
        color: white; padding: 12px; border: none; border-radius: 8px; font-weight: 600; 
        cursor: pointer; transition: all 0.3s; 
    }
    .bill-form button:hover { background-color: #e97a9d; }
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
      <div class="card-title"><i class="fas fa-receipt" style="margin-right: 10px; color: var(--secondary);"></i> Formulir Tambah Tagihan Baru</div>
      <form class="bill-form" method="POST" action="">
  <input type="text" name="nama_tagihan" placeholder="Nama Tagihan (misal: Pulsa Telkomsel)" required>

  <input type="number" name="jumlah" placeholder="Jumlah Tagihan (Rp)" required>

  <label for="due-date">Tanggal Jatuh Tempo:</label>
  <input type="date" id="due-date" name="tanggal_jatuh_tempo" required>

  <select name="kategori" required>
    <option value="">Pilih Kategori Tagihan</option>
    <option value="listrik">Listrik & Air</option>
    <option value="internet">Internet & TV Kabel</option>
    <option value="kredit">Kartu Kredit</option>
  </select>

  <select name="frekuensi" required>
    <option value="">Frekuensi Pembayaran</option>
    <option value="bulanan">Bulanan</option>
    <option value="tahunan">Tahunan</option>
  </select>

  <button type="submit" name="simpan">
    <i class="fas fa-save"></i> Simpan Tagihan
  </button>
</form>

    </div>
  </main>

</body>
</html>