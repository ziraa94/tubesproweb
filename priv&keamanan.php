<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Privasi & Keamanan - FINWISE</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --primary: #8a9bbd;        /* Biru keabu-abuan */
      --secondary: #f4a7b9;      /* Pink muda */
      --accent: #cce5ff;         /* Biru sangat muda */
      --dark: #2c3e50;           /* Teks gelap */
      --light: #f9fbfd;          /* Background card */
      --gray: #7f8fa9;           /* Teks sekunder */
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #cce5ff 0%, #f4a7b9 100%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 30px 20px;
      color: var(--dark);
      line-height: 1.6;
    }

    .logo {
      font-family: 'Montserrat', sans-serif;
      font-size: 1.8em;
      font-weight: 800;
      background: linear-gradient(90deg, var(--secondary), var(--primary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      margin-bottom: 30px;
      text-align: center;
    }

    .container {
      width: 100%;
      max-width: 700px;
      background: white;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    }

    .page-title {
      text-align: center;
      font-size: 2em;
      font-weight: 700;
      margin-bottom: 25px;
      color: var(--dark);
    }

    .section {
      margin-bottom: 35px;
    }

    .section h2 {
      font-size: 1.4em;
      margin-bottom: 15px;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .section h2 i {
      background: var(--accent);
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary);
    }

    .section p {
      color: var(--gray);
      margin-bottom: 12px;
    }

    .security-highlight {
      background: var(--accent);
      padding: 3px 8px;
      border-radius: 6px;
      font-weight: 600;
      color: var(--primary);
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      color: var(--dark);
      text-decoration: none;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .back-link:hover {
      color: var(--secondary);
    }

    @media (max-width: 600px) {
      .container {
        padding: 30px 20px;
      }
      .page-title {
        font-size: 1.7em;
      }
    }
  </style>
</head>
<body>
  <div class="logo">FINWISE</div>

  <div class="container">
    <h1 class="page-title">Privasi & Keamanan</h1>
    <p style="text-align: center; color: var(--gray); margin-bottom: 30px;">
      Kami menjaga data keuanganmu seperti harta karun — dengan kunci terkuat dan pengawasan paling ketat.
    </p>

    <div class="section">
      <h2><i class="fas fa-lock"></i> Enkripsi Data</h2>
      <p>
        Semua data pribadimu <span class="security-highlight">dienkripsi secara end-to-end</span> sejak pertama kali kamu input. 
        Bahkan kami tidak bisa melihat rincian transaksimu.
      </p>
    </div>

    <div class="section">
      <h2><i class="fas fa-user-shield"></i> Tidak Dijual ke Pihak Ketiga</h2>
      <p>
        Kami <strong>tidak pernah menjual, menyewa, atau membagikan</strong> data keuanganmu kepada pihak ketiga, 
        termasuk iklan atau perusahaan analitik.
      </p>
    </div>

    <div class="section">
      <h2><i class="fas fa-database"></i> Penyimpanan Aman</h2>
      <p>
        Data disimpan di server yang dilindungi dengan <span class="security-highlight">firewall tingkat enterprise</span> 
        dan pemantauan 24/7 terhadap aktivitas mencurigakan.
      </p>
    </div>

    <div class="section">
      <h2><i class="fas fa-key"></i> Password yang Aman</h2>
      <p>
        Kami menyimpan passwordmu dalam bentuk <span class="security-highlight">hash satu arah</span> (menggunakan algoritma modern).
        Jadi, bahkan tim kami tidak tahu password aslimu.
      </p>
    </div>

    <div class="section">
      <h2><i class="fas fa-file-contract"></i> Kepatuhan terhadap Regulasi</h2>
      <p>
        FINWISE mematuhi prinsip perlindungan data sesuai standar privasi internasional, 
        termasuk prinsip transparansi, konsent, dan hak pengguna atas datanya.
      </p>
    </div>

    <a href="index.php" class="back-link">
      <i class="fas fa-arrow-left"></i> Kembali ke Beranda
    </a>
  </div>
</body>
</html>

   <a href="privasi-keamanan.html">Privasi & Keamanan</a>
   
