<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - FINWISE</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    /* Skema Warna FINWISE (DOMINASI PINK) */
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

    .calendar {
  display: grid;
  grid-template-columns: repeat(7,1fr);
  gap: 8px;
}

.day-name {
  font-weight: 600;
  color: var(--secondary);
  text-align: center;
}

.calendar-day {
  padding: 12px;
  border-radius: 10px;
  text-align: center;
  background: #f1f1f1;
  cursor: pointer;
  transition: 0.2s;
  position: relative;
}

.calendar-day:hover {
  background: var(--secondary);
  color: white;
}

.today {
  background: var(--secondary-darker);
  color: white;
  font-weight: bold;
}

.due {
  background: rgba(244,167,185,0.4);
  font-weight: 700;
}

.dot {
  width: 6px;
  height: 6px;
  background: var(--secondary-darker);
  border-radius: 50%;
  position: absolute;
  bottom: 6px;
  left: 50%;
  transform: translateX(-50%);
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

    /* Styling Ikon Panah agar menjadi lingkaran */
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
      <li data-tab="dashboard" class="active"><a href="#"><i class="fas fa-chart-line"></i> Dashboard</a></li>
      <li data-tab="catatan"><a href="#"><i class="fas fa-wallet"></i> Transaksi</a></li>
      <li data-tab="tagihan"><a href="#"><i class="fas fa-clipboard-list"></i> Tagihan</a></li>
      <li data-tab="tabungan"><a href="#"><i class="fas fa-piggy-bank"></i> Tabungan & Target</a></li>
      <li data-tab="kalender"><a href="#"><i class="fas fa-calendar-alt"></i> Kalender</a></li>
      <li data-tab="aset"><a href="#"><i class="fas fa-gem"></i> Aset</a></li>
    </ul>

    <div class="logout">
        <a href="loginn.html"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>
  </aside>

  <main class="main-content">
    
    <div class="header-content">
      <h2>Ringkasan Keuanganmu</h2>
      <div class="user-profile">
        <span>Pengguna FINWISE</span>
        <div class="profile-avatar">P</div>
      </div>
    </div>
    
    <div class="finance-summary">
    <div class="summary-card income">
        <div class="summary-text">
            <p>Total Penghasilan (Bulan Ini)</p>
            <h3>Rp 10.500.000</h3>
        </div>
        <i class="fas fa-arrow-up"></i>
    </div>
    <div class="summary-card expense">
        <div class="summary-text">
            <p>Total Pengeluaran (Bulan Ini)</p>
            <h3>Rp 4.250.000</h3>
        </div>
        <i class="fas fa-arrow-down"></i>
    </div>
</div>
    
    <div id="dashboard" class="feature-content active">
        <div class="card">
            <div class="card-title">Diagram Analisis Total Keuangan (Diagram Lingkaran)</div>
            <div class="chart-placeholder">
                <div class="pie-chart-mockup"></div>
                <p style="font-size: 1em; margin-bottom: 10px;">Visualisasi Penggunaan Dana Bulan Ini</p>
                <div class="chart-legend">
                    <p><span class="legend-dot" style="background-color: var(--primary);"></span> Sisa Dana: 70%</p>
                    <p><span class="legend-dot" style="background-color: var(--secondary);"></span> Pengeluaran: 30%</p>
                </div>
            </div>
        </div>
    </div>

    <div id="catatan" class="feature-content">
        <div class="card">
            <div class="card-title">
                Riwayat Transaksi Terbaru
                <a href="tambah_transaksi.html" class="action-btn"> 
                    <i class="fas fa-plus"></i> Tambah Transaksi
                </a>
            </div>
            <div class="transaction-list">
                <div class="transaction-item">
                    <div><h4>Gaji Bulan Desember</h4><p style="color: var(--gray);">10 Des 2025 | Kategori: Pemasukan</p></div>
                    <span class="trans-income">+ Rp 10.000.000</span>
                </div>
                <div class="transaction-item">
                    <div><h4>Bayar Langganan Netflix</h4><p style="color: var(--gray);">05 Des 2025 | Kategori: Hiburan</p></div>
                    <span class="trans-expense">- Rp 120.000</span>
                </div>
                <div class="transaction-item">
                    <div><h4>Beli Makan Siang</h4><p style="color: var(--gray);">14 Des 2025 | Kategori: Makanan</p></div>
                    <span class="trans-expense">- Rp 55.000</span>
                </div>
            </div>
        </div>
    </div>

    <div id="tagihan" class="feature-content">
        <div class="card">
          <div class="card-title">
            Daftar Tagihan Mendatang
            <a href="tambah_tagihan.html" class="action-btn">
                <i class="fas fa-plus"></i> Tambah Tagihan
            </a>
          </div>
          <div class="bill-item">
            <div><h4>Listrik Bulanan</h4><p style="color: var(--gray);">Jatuh Tempo: 20 Des</p></div>
            <div class="bill-amount">Rp 250.000</div>
          </div>
          <div class="bill-item">
            <div><h4>Kartu Kredit BCA</h4><p style="color: var(--gray);">Jatuh Tempo: 25 Des</p></div>
            <div class="bill-amount">Rp 1.500.000</div>
          </div>
        </div>
    </div>

    <div id="tabungan" class="feature-content">
        <div class="card">
          <div class="card-title">Tabungan & Target Saya
              <a href="tambah_tabungan.html" class="action-btn"><i class="fas fa-plus"></i> Target Baru</a>
          </div>
          <div class="goal-progress">
            <div style="display: flex; justify-content: space-between; font-size: 0.9em; margin-bottom: 5px;">
              <span>✈️ Liburan ke Bali</span>
              <span>Rp 5.000.000 / Rp 15.000.000 (33%)</span>
            </div>
            <div class="progress-bar-container">
              <div class="progress-bar" style="width: 33%;"></div>
            </div>
          </div>
          <div class="goal-progress">
            <div style="display: flex; justify-content: space-between; font-size: 0.9em; margin-bottom: 5px;">
              <span>🏠 Dana Darurat</span>
              <span>Rp 10.000.000 / Rp 12.000.000 (83%)</span>
            </div>
            <div class="progress-bar-container">
              <div class="progress-bar" style="width: 83%;"></div>
            </div>
          </div>
        </div>
    </div>

   <div id="kalender" class="feature-content">
  <div class="card">
    <div class="card-title">
      Kalender Keuangan
      <div>
        <button id="prevMonth" class="action-btn"><i class="fas fa-chevron-left"></i></button>
        <button id="nextMonth" class="action-btn"><i class="fas fa-chevron-right"></i></button>
      </div>
    </div>

    <h3 id="monthYear" style="text-align:center;"></h3>

    <div class="calendar">
      <div class="day-name">Min</div>
      <div class="day-name">Sen</div>
      <div class="day-name">Sel</div>
      <div class="day-name">Rab</div>
      <div class="day-name">Kam</div>
      <div class="day-name">Jum</div>
      <div class="day-name">Sab</div>
    </div>

    <div class="calendar" id="calendarDays"></div>

    <div id="billList" style="margin-top:20px; background:#fff3f6; padding:15px; border-radius:10px;">
      <strong>📌 Detail Tanggal</strong>
      <p>Klik tanggal pada kalender</p>
    </div>
  </div>
</div>


    <div id="aset" class="feature-content">
        <div class="card">
            <div class="card-title">
                Ringkasan Aset yang Ada
                <a href="tambah_aset.html" class="action-btn"><i class="fas fa-plus"></i> Tambah Aset</a>
            </div>
            <div class="asset-item">
                <p><i class="fas fa-hand-holding-usd"></i> Kas & Saldo Bank</p>
                <span class="asset-value">Rp 12.500.000</span>
            </div>
            <div class="asset-item">
                <p><i class="fas fa-chart-pie"></i> Investasi Saham</p>
                <span class="asset-value">Rp 5.200.000</span>
            </div>
            <div class="asset-item">
                <p><i class="fas fa-building"></i> Properti</p>
                <span class="asset-value">Rp 450.000.000</span>
            </div>
        </div>
    </div>
    
  </main>

  <script>
document.addEventListener('DOMContentLoaded', function () {

  /* ================= NAVIGASI TAB ================= */
  const navLinks = document.querySelectorAll('.nav-list li');
  const featureContents = document.querySelectorAll('.feature-content');

  function showContent(tabId) {
    featureContents.forEach(c => c.classList.remove('active'));
    navLinks.forEach(n => n.classList.remove('active'));

    document.getElementById(tabId).classList.add('active');
    document.querySelector(`.nav-list li[data-tab="${tabId}"]`).classList.add('active');

    if (tabId === "kalender") {
      renderCalendar(); // 🔥 PENTING
    }
  }

  navLinks.forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      showContent(this.dataset.tab);
    });
  });

  showContent("dashboard");

  /* ================= KALENDER ================= */
  const monthYear = document.getElementById("monthYear");
  const calendarDays = document.getElementById("calendarDays");
  const billList = document.getElementById("billList");
  const prevBtn = document.getElementById("prevMonth");
  const nextBtn = document.getElementById("nextMonth");

  let currentDate = new Date();

  const bills = {
    "2025-12-20": ["💡 Bayar Listrik - Rp250.000"],
    "2025-12-25": ["💳 Kartu Kredit BCA - Rp1.500.000"]
  };

  const transactions = {
    "2025-12-14": [
      { name: "Makan Siang", type: "expense", amount: "Rp 55.000" }
    ],
    "2025-12-10": [
      { name: "Gaji Bulanan", type: "income", amount: "Rp 10.000.000" }
    ]
  };

  window.renderCalendar = function () {
    calendarDays.innerHTML = "";

    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    const months = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
    monthYear.textContent = `${months[month]} ${year}`;

    for (let i = 0; i < firstDay; i++) calendarDays.innerHTML += "<div></div>";

    for (let d = 1; d <= lastDate; d++) {
      const key = `${year}-${String(month+1).padStart(2,"0")}-${String(d).padStart(2,"0")}`;
      const today = new Date();

      let cls = "calendar-day";
      if (d === today.getDate() && month === today.getMonth() && year === today.getFullYear()) cls += " today";
      if (bills[key] || transactions[key]) cls += " due";

      calendarDays.innerHTML += `
        <div class="${cls}" data-date="${key}">
          ${d}
          ${(bills[key] || transactions[key]) ? '<span class="dot"></span>' : ''}
        </div>`;
    }

    document.querySelectorAll(".calendar-day").forEach(day => {
      day.addEventListener("click", function () {
        showDetails(this.dataset.date);
      });
    });
  };

  function showDetails(date) {
    billList.innerHTML = `<strong>📅 ${date}</strong><hr>`;

    billList.innerHTML += `<h4>📌 Tagihan</h4>`;
    if (bills[date]) {
      bills[date].forEach(b => billList.innerHTML += `<p>${b}</p>`);
    } else {
      billList.innerHTML += "<p>Tidak ada tagihan</p>";
    }

    billList.innerHTML += `<h4 style="margin-top:15px;">💸 Transaksi</h4>`;
    if (transactions[date]) {
      transactions[date].forEach(t => {
        const sign = t.type === "income" ? "+" : "-";
        const color = t.type === "income" ? "green" : "red";
        billList.innerHTML += `<p style="color:${color}; font-weight:600;">
          ${t.name} (${sign} ${t.amount})
        </p>`;
      });
    } else {
      billList.innerHTML += "<p>Tidak ada transaksi</p>";
    }
  }

  prevBtn.onclick = () => { currentDate.setMonth(currentDate.getMonth() - 1); renderCalendar(); };
  nextBtn.onclick = () => { currentDate.setMonth(currentDate.getMonth() + 1); renderCalendar(); };

});
</script>


</body>
</html>