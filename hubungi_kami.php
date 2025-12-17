<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Hubungi Kami - FINWISE</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --primary: #8a9bbd;        
      --secondary: #f4a7b9;      
      --accent: #cce5ff;         
      --dark: #2c3e50;           
      --light: #f9fbfd;          
      --gray: #7f8fa9;           
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
      max-width: 600px;
      background: white;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    }

    .page-title {
      text-align: center;
      font-size: 2em;
      font-weight: 700;
      margin-bottom: 15px;
      color: var(--dark);
    }

    .page-subtitle {
      text-align: center;
      color: var(--gray);
      margin-bottom: 30px;
      font-size: 1em;
    }

    .contact-info {
      display: flex;
      flex-direction: column;
      gap: 25px;
    }

    .contact-item {
      display: flex;
      align-items: flex-start;
      gap: 15px;
    }

    .contact-icon {
      width: 50px;
      height: 50px;
      background: var(--accent);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary);
      font-size: 1.3em;
      flex-shrink: 0;
    }

    .contact-text h3 {
      font-size: 1.15em;
      margin-bottom: 6px;
      color: var(--dark);
    }

    .contact-text p, .contact-text a {
      color: var(--gray);
      text-decoration: none;
      transition: color 0.2s;
      font-size: 1em;
    }

    .contact-text a:hover {
      color: var(--secondary);
    }

    .back-link {
      display: inline-block;
      margin-top: 30px;
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
    <h1 class="page-title">Hubungi Kami</h1>
    <p class="page-subtitle">Butuh bantuan? Kami siap membantu kamu kapan saja!</p>

    <div class="contact-info">
      <!-- Nomor Telepon -->
      <div class="contact-item">
        <div class="contact-icon">
          <i class="fas fa-phone-alt"></i>
        </div>
        <div class="contact-text">
          <h3>Nomor Telepon</h3>
          <p><a href="tel:+6281234567890">+62 812-3456-7890</a></p>
        </div>
      </div>

      <!-- Email -->
      <div class="contact-item">
        <div class="contact-icon">
          <i class="fas fa-envelope"></i>
        </div>
        <div class="contact-text">
          <h3>Email</h3>
          <p><a href="mailto:support@finwise.local">finwise@gmail.com</a></p>
        </div>
      </div>

      <!-- Lokasi -->
      <div class="contact-item">
        <div class="contact-icon">
          <i class="fas fa-map-marker-alt"></i>
        </div>
        <div class="contact-text">
          <h3>Lokasi Kami</h3>
          <p>Universitas Sumatera Utara, Prodi Teknologi Informasi<br>Jl. Alumni No.3, Padang Bulan, Kec. Medan Baru, Kota Medan, Sumatera Utara</p>
        </div>
      </div>

      <!-- Jam Operasional -->
      <div class="contact-item">
        <div class="contact-icon">
          <i class="fas fa-clock"></i>
        </div>
        <div class="contact-text">
          <h3>Jam Operasional</h3>
          <p>Senin – Jumat: Libur<br>Sabtu: Tidur<br>Minggu: Tutup</p>
        </div>
      </div>
    </div>

    <a href="index.php" class="back-link">
      <i class="fas fa-arrow-left"></i> Kembali ke Beranda
    </a>
  </div>
</body>
</html>