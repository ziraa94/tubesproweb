<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tambah Transaksi - FINWISE</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    /* CSS untuk konsistensi */
    :root {
      --primary: #8a9bbd; --secondary: #f4a7b9; --accent: #cce5ff; --dark: #2c3e50; --light: #f9fbfd;
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
    
    /* Gaya Khusus Formulir */
    .transaction-form { 
        display: grid; grid-template-columns: 1fr 1fr; gap: 15px 20px; align-items: center;
    }
    .transaction-form input, .transaction-form select { 
        width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 1em; background-color: #fafafa; grid-column: span 1;
    }
    .transaction-form input[type="text"]:first-of-type { grid-column: 1 / 3; }
    .transaction-form button { 
        background: linear-gradient(90deg, var(--secondary), var(--primary)); 
        color: white; padding: 12px; border: none; border-radius: 8px; font-weight: 600; 
        cursor: pointer; transition: all 0.3s; grid-column: 1 / 3;
    }
  </style>
</head>
<body>

  <aside class="sidebar">
    <div class="logo">FINWISE</div>
    <ul class="nav-list">
      <li><a href="dashboard.php"><i class="fas fa-chart-line"></i> Kembali ke Dashboard</a></li>
  </aside>

  <main class="main-content">
    <div class="card">
      <div class="card-title"><i class="fas fa-wallet" style="margin-right: 10px; color: var(--primary);"></i> Formulir Tambah Transaksi Baru</div>
      <form class="transaction-form">
        <input type="number" placeholder="Jumlah (misal: 100000)" required>
        <select required>
            <option value="">Tipe Transaksi</option>
            <option value="pengeluaran">Pengeluaran</option>
            <option value="pemasukan">Pemasukan</option>
        </select>
        <input type="text" placeholder="Deskripsi (misal: Beli makan malam di Warung A)" required>
        <select required>
            <option value="">Pilih Kategori</option>
            <option value="makanan">Makanan & Minuman</option>
            <option value="gaji">Gaji</option>
            <option value="transportasi">Transportasi</option>
            <option value="lainnya">Lainnya</option>
        </select>
        <select required>
            <option value="">Pilih Akun Sumber</option>
            <option value="bank">Bank BCA</option>
            <option value="cash">Uang Tunai</option>
        </select>
        <button><i class="fas fa-plus-circle"></i> Catat Transaksi Sekarang</button>
      </form>
    </div>
  </main>

</body>
</html>