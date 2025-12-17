<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FINWISE — Smart Finance, Smarter You</title>
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
      overflow-x: hidden;
      color: var(--dark);
    }

    /* ====== ANIMATIONS ====== */
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-15px); }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animated {
      opacity: 0;
      animation: fadeInUp 0.8s ease forwards;
    }

    .delay-1 { animation-delay: 0.2s; }
    .delay-2 { animation-delay: 0.4s; }
    .delay-3 { animation-delay: 0.6s; }

    /* ====== HEADER ====== */
    .header {
      width: 100%;
      max-width: 1400px;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: fixed;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
      z-index: 1000;
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.85);
      border-radius: 0 0 20px 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }

    .logo {
      font-family: 'Montserrat', sans-serif;
      font-size: 1.8em;
      font-weight: 800;
      background: linear-gradient(90deg, var(--secondary), var(--primary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      letter-spacing: 1px;
    }

    .nav {
      display: flex;
      gap: 25px;
    }

    .nav a {
      color: var(--dark);
      text-decoration: none;
      font-weight: 600;
      font-size: 1em;
      position: relative;
      padding: 5px 0;
      transition: all 0.3s ease;
    }

    .nav a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--secondary);
      border-radius: 2px;
      transition: width 0.3s ease;
    }

    .nav a:hover {
      color: var(--secondary);
    }

    .nav a:hover::after {
      width: 100%;
    }

    .btn {
      display: inline-block;
      padding: 10px 24px;
      border-radius: 30px;
      font-weight: 600;
      text-decoration: none;
      text-align: center;
      transition: all 0.3s ease;
      cursor: pointer;
      font-size: 1em;
      border: none;
    }

    .btn-primary {
      background: var(--primary);
      color: white;
      box-shadow: 0 4px 12px rgba(138, 155, 189, 0.3);
    }

    .btn-primary:hover {
      background: #7a8ab5;
      transform: translateY(-3px);
      box-shadow: 0 6px 16px rgba(138, 155, 189, 0.4);
    }

    .btn-outline {
      background: transparent;
      color: var(--dark);
      border: 2px solid var(--primary);
    }

    .btn-outline:hover {
      background: var(--primary);
      color: white;
      transform: translateY(-3px);
    }

    /* ====== MAIN CONTENT ====== */
    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 120px;
      padding-bottom: 60px;
    }

    .hero {
      width: 100%;
      max-width: 1200px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 40px;
      padding: 0 30px;
      margin-bottom: 80px;
    }

    .hero-text {
      flex: 1;
      max-width: 550px;
    }

    .hero-text h1 {
      font-size: 3.2em;
      line-height: 1.2;
      margin-bottom: 20px;
      font-weight: 800;
      color: var(--dark);
    }

    /* ✨ Teks "uangmu" dengan gradasi lebih kontras */
    .hero-text h1 span {
      background: linear-gradient(90deg, #e97a9d, #8ab4f8, #5b7fa6);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      font-weight: 800;
    }

    .hero-text p {
      font-size: 1.1em;
      line-height: 1.7;
      color: var(--gray);
      margin-bottom: 30px;
    }

    .hero-cta {
      display: flex;
      gap: 15px;
    }

    .hero-image {
      flex: 1;
      display: flex;
      justify-content: center;
      position: relative;
    }

    .hero-image img {
      max-width: 80%;
      animation: float 4s ease-in-out infinite;
      filter: drop-shadow(0 10px 20px rgba(0,0,0,0.15));
    }

    /* ====== SECTIONS ====== */

    .section-title {
      text-align: center;
      font-size: 2.2em;
      margin-bottom: 20px;
      color: var(--dark);
    }

    .section-subtitle {
      text-align: center;
      font-size: 1.1em;
      color: var(--gray);
      max-width: 700px;
      margin: 0 auto 60px;
      line-height: 1.6;
    }

    /* FEATURES */
    .features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
    }

    .feature-card {
      background: white;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
      transition: all 0.4s ease;
      text-align: center;
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }

    .feature-icon {
      width: 70px;
      height: 70px;
      background: linear-gradient(135deg, var(--secondary), var(--accent));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      font-size: 1.8em;
      color: var(--dark);
    }

    .feature-card h3 {
      font-size: 1.4em;
      margin-bottom: 15px;
      color: var(--dark);
    }

    .feature-card p {
      color: var(--gray);
      line-height: 1.6;
    }

    /* ====== FOOTER ====== */
    .footer {
      background: var(--dark);
      color: white;
      padding-top: 70px;
    }

    .footer-content {
      max-width: 1200px;
      padding: 0 30px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 40px;
      margin-bottom: 50px;
    }

    .footer-column h3 {
      font-size: 1.4em;
      margin-bottom: 25px;
      position: relative;
      padding-bottom: 10px;
    }

    .footer-column h3::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: 0;
      width: 50px;
      height: 3px;
      background: var(--accent);
      border-radius: 3px;
    }

    .footer-links {
      list-style: none;
    }

    .footer-links li {
      margin-bottom: 12px;
    }

    .footer-links a {
      color: #cbd5e1;
      text-decoration: none;
      transition: color 0.3s;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .footer-links a:hover {
      color: var(--accent);
    }

    .social-links {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }

    .social-links a {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(255,255,255,0.1);
      color: white;
      transition: all 0.3s;
    }

    .social-links a:hover {
      background: var(--accent);
      color: var(--dark);
      transform: translateY(-3px);
    }

    .newsletter input {
      width: 100%;
      padding: 14px 20px;
      border-radius: 30px;
      border: none;
      margin: 10px 0;
      background: rgba(255,255,255,0.1);
      color: white;
    }

    .newsletter input::placeholder {
      color: #94a3b8;
    }

    .newsletter button {
      width: 100%;
      padding: 12px;
      border-radius: 30px;
      background: var(--accent);
      color: var(--dark);
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: all 0.3s;
    } 

    .newsletter button:hover {
      background: #b3d9ff;
      transform: scale(1.03);
    }

    .footer-bottom {
      text-align: center;
      padding: 25px 30px;
      border-top: 1px solid rgba(255,255,255,0.1);
      font-size: 0.9em;
      color: #94a3b8;
    }

    .easter-egg {
      cursor: pointer;
      display: inline-block;
    }

    .easter-egg:hover::after {
      content: " 🎀 So pretty!";
      margin-left: 10px;
      color: var(--accent);
      animation: fadeInUp 0.5s forwards;
    }

    /* ====== RESPONSIVE ====== */
    @media (max-width: 900px) {
      .hero {
        flex-direction: column;
        text-align: center;
      }
      .hero-text h1 { font-size: 2.4em; }
      .hero-cta { justify-content: center; }
      .section-title { font-size: 2em; }
    }

    @media (max-width: 600px) {
      .hero-text h1 { font-size: 2em; }
      .section { padding: 60px 20px; }
      .hero-cta { flex-direction: column; }
      .header { padding: 15px 20px; }
      .nav { display: none; }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header class="header">
    <div class="logo">FINWISE</div>
    <nav class="nav">
      <a href="#features">Fitur</a>
      <a href="#footer">Tentang</a>
    </nav>
    <a href="login.php" class="btn btn-primary">Masuk</a>
  </header>

  <!-- Hero Section -->
  <main class="main-content">
    <section id="hero" class="hero">
      <div class="hero-text animated">
        <h1>Kelola <span>uangmu</span> tanpa ribet!</h1>
        <p>FINWISE membantumu mencatat pengeluaran, menabung otomatis, dan mewujudkan impian finansialmu — semua dalam satu aplikasi yang sederhana dan menyenangkan.</p>
        <div class="hero-cta">
          <a href="register.php" class="btn btn-primary">Daftar Sekarang</a>
          <a href="#features" class="btn btn-outline">Jelajahi Fitur</a>
        </div>
      </div>
      <div class="hero-image animated delay-1">
        <!-- SVG Ilustrasi Embedded (diperbaiki) -->
        <img src="landing pageee.jpg" alt="Dashboard Ilustrasi">
      </div>
    </section>

    <!-- Features -->
    <section id="features" class="section">
      <h2 class="section-title animated">Kenapa Pilih FINWISE?</h2>
      <p class="section-subtitle animated delay-1">Dibuat untuk kamu yang ingin mandiri secara finansial, tanpa jargon ribet dan spreadsheet membosankan.</p>
      
      <div class="features">
        <div class="feature-card animated delay-2">
          <div class="feature-icon"><i class="fas fa-wallet"></i></div>
          <h3>Pencatatan Instan</h3>
          <p>Masukkan pengeluaran hanya dalam 3 detik — lewat suara, foto, atau ketik. Kami mengenali kategori otomatis!</p>
        </div>
        <div class="feature-card animated delay-3">
          <div class="feature-icon"><i class="fas fa-piggy-bank"></i></div>
          <h3>Menabung Otomatis</h3>
          <p>Tentukan tujuan (liburan, DP motor, dll), lalu kami sisihkan uangmu tiap kali kamu gajian — tanpa kamu sadari!</p>
        </div>
        <div class="feature-card animated delay-3">
          <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
          <h3>Insight Pintar</h3>
          <p>Laporan mingguan dengan visualisasi menyenangkan — kamu jadi paham ke mana uangmu mengalir.</p>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <section id="footer" class="section">
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-column">
        <h3>FINWISE</h3>
        <p style="color: #cbd5e1; line-height: 1.6;">Platform keuangan pribadi yang membantumu hidup lebih tenang, bijak, dan bahagia — tanpa khawatir soal uang.</p>
      </div>
      <div class="footer-column">
        <h3>Link Cepat</h3>
        <ul class="footer-links">
          <li><a href="#hero"><i class="fas fa-chevron-right"></i> Beranda</a></li>
          <li><a href="#features"><i class="fas fa-chevron-right"></i> Fitur Unggulan</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Bantuan</h3>
        <ul class="footer-links">
          <li><a href="priv&keamanan.php"><i class="fas fa-chevron-right"></i> Privasi & Keamanan</a></li>
          <li><a href="hubungi_kami.php"><i class="fas fa-chevron-right"></i> Hubungi Kami</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 FINWISE.</p>
      <p>By Kelompok FINWISE mata kuliah ProWeb <i class="fas fa-heart" style="color: var(--accent);"></i></p>
      <p class="easter-egg">✨ Klik ini kalau kamu suka warna-warni</p>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animated');
          }
        });
      }, { threshold: 0.1 });

      document.querySelectorAll('.feature-card, .section-title, .section-subtitle, .mockup-title').forEach(el => {
        observer.observe(el);
      });

      document.querySelector('.easter-egg').addEventListener('click', () => {
        document.body.style.background = `linear-gradient(135deg, #a7d1c3, #f4a7b9, #cce5ff, #c3b0e0)`;
        setTimeout(() => {
          document.body.style.background = `linear-gradient(135deg, #cce5ff 0%, #f4a7b9 100%)`;
        }, 1500);
      });
    });
  </script>

</body>
</html>