<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$koneksi = mysqli_connect("localhost","root","","data_tubes");
if (!$koneksi) {
    die("Koneksi database gagal");
}

$user_id = $_SESSION['id'];
$data = [];

/* ================= TAGIHAN ================= */
$q1 = mysqli_query($koneksi,"
    SELECT nama_tagihan, jumlah, tanggal_jatuh_tempo
    FROM tagihan
    WHERE user_id = $user_id
");

while ($row = mysqli_fetch_assoc($q1)) {
    $tgl = $row['tanggal_jatuh_tempo'];
    $data[$tgl][] =
        "💡 Tagihan: " .
        htmlspecialchars($row['nama_tagihan']) .
        " - Rp " .
        number_format($row['jumlah'],0,',','.');
}

/* ================= TABUNGAN ================= */
$q2 = mysqli_query($koneksi,"
    SELECT nama_target, target_nominal, saldo_sekarang, tanggal_target
    FROM saving_goals
    WHERE user_id = $user_id
");

while ($row = mysqli_fetch_assoc($q2)) {
    $tgl = $row['tanggal_target'];
    $persen = $row['target_nominal'] > 0
        ? round(($row['saldo_sekarang'] / $row['target_nominal']) * 100)
        : 0;

    $data[$tgl][] =
        "🎯 Target: " .
        htmlspecialchars($row['nama_target']) .
        " ($persen%)";
}

/* KIRIM KE JS */
$calendar_json = json_encode(
    $data,
    JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kalender Keuangan - FINWISE</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
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
*{margin:0;padding:0;box-sizing:border-box}
body{font-family: 'Poppins', sans-serif;
      background-color: var(--light);
      min-height: 100vh;
      display: flex;
      color: var(--dark);}
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

.card {
  max-width: 800px;
  margin: auto;
  background: white;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.card-title {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 1.4em;
  font-weight: 600;
  margin-bottom: 20px;
}

.action-btn {
  background: var(--secondary);
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 8px;
  cursor: pointer;
}

#monthYear {
  text-align: center;
  font-size: 1.3em;
  margin-bottom: 15px;
  font-weight: 600;
}

.calendar {
  display: grid;
  grid-template-columns: repeat(7,1fr);
  gap: 8px;
  text-align: center;
}

.day-name {
  font-weight: 600;
  color: var(--secondary);
}

.calendar-day {
  padding: 14px;
  border-radius: 10px;
  cursor: pointer;
  background: #f1f1f1;
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

#billList {
  margin-top: 25px;
  background: #fff3f6;
  padding: 15px;
  border-radius: 12px;
}

#billList h4 {
  margin-bottom: 10px;
  color: var(--secondary-darker);
}


.main-content {
  flex: 1;
  padding: 40px;
  overflow-y: auto;
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}

.user-profile {
  display: flex;
  align-items: center;
  font-weight: 600;
}

.profile-avatar {
  width: 40px;
  height: 40px;
  background: var(--secondary);
  color: white;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-left: 10px;
}

</style>
</head>

<body>
 <aside class="sidebar">
    <div class="logo">FINWISE</div>

    <ul class="nav-list">
        <li>
            <a href="dashboard.php">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="transaksi.php">
                <i class="fas fa-wallet"></i> Transaksi
            </a>
        </li>
        <li>
            <a href="tagihan.php">
                <i class="fas fa-clipboard-list"></i> Tagihan
            </a>
        </li>
        <li>
            <a href="tabungan.php">
                <i class="fas fa-piggy-bank"></i> Tabungan & Target
            </a>
        </li>
        <li class="active">
            <a href="kalender.php">
                <i class="fas fa-calendar-alt"></i> Kalender
            </a>
        </li>
        <li>
            <a href="aset.php">
                <i class="fas fa-gem"></i> Aset
            </a>
        </li>
    </ul>

    <div class="logout">
        <a href="index.php">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </a>
    </div>
</aside>
 
<main class="main-content">

    <div class="header-content">
        <h2>Kalender Keuangan</h2>
        <div class="user-profile">
            <span><?= htmlspecialchars($_SESSION['nama']) ?></span>
            <div class="profile-avatar">
                <?= strtoupper(substr($_SESSION['nama'],0,1)) ?>
            </div>
        </div>
    </div>

<div class="card">
  <div class="card-title">
    Kalender Keuangan FINWISE
    <div>
      <button id="prev" class="action-btn"><i class="fas fa-chevron-left"></i></button>
      <button id="next" class="action-btn"><i class="fas fa-chevron-right"></i></button>
    </div>
  </div>

  <div id="monthYear"></div>

  <div class="calendar">
    <div class="day-name">Min</div>
    <div class="day-name">Sen</div>
    <div class="day-name">Sel</div>
    <div class="day-name">Rab</div>
    <div class="day-name">Kam</div>
    <div class="day-name">Jum</div>
    <div class="day-name">Sab</div>
  </div>

  <div class="calendar" id="days"></div>

  <div id="billList">
    <h4>📌 Tagihan pada tanggal ini</h4>
    <p>Klik tanggal untuk melihat detail</p>
  </div>
</div>
</main>
<script>
const monthYear = document.getElementById("monthYear");
const daysEl = document.getElementById("days");
const billList = document.getElementById("billList");

let current = new Date();

/* DATA TAGIHAN */
const bills = <?= $calendar_json ?>;

function renderCalendar() {
  daysEl.innerHTML = "";
  const year = current.getFullYear();
  const month = current.getMonth();

  const firstDay = new Date(year, month, 1).getDay();
  const lastDate = new Date(year, month + 1, 0).getDate();

  const months = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
  monthYear.textContent = `${months[month]} ${year}`;

  for (let i = 0; i < firstDay; i++) {
    daysEl.innerHTML += "<div></div>";
  }

  for (let d = 1; d <= lastDate; d++) {
    const dateKey = `${year}-${String(month+1).padStart(2,"0")}-${String(d).padStart(2,"0")}`;
    const today = new Date();

    let className = "calendar-day";
    if (
      d === today.getDate() &&
      month === today.getMonth() &&
      year === today.getFullYear()
    ) className += " today";

    if (bills[dateKey]) className += " due";

    const dot = bills[dateKey] ? `<span class="dot"></span>` : "";

    daysEl.innerHTML += `
      <div class="${className}" onclick="showBills('${dateKey}')">
        ${d}
        ${dot}
      </div>`;
  }
}

function showBills(date) {
  billList.innerHTML = `<h4>📅 ${date}</h4>`;
  if (bills[date]) {
    bills[date].forEach(b =>
      billList.innerHTML += `<p>${b}</p>`
    );
  } else {
    billList.innerHTML += "<p>Tidak ada tagihan 🎉</p>";
  }
}

document.getElementById("prev").onclick = () => {
  current.setMonth(current.getMonth() - 1);
  renderCalendar();
};

document.getElementById("next").onclick = () => {
  current.setMonth(current.getMonth() + 1);
  renderCalendar();
};

renderCalendar();
</script>

</body>
</html>