<?php
require_once "../includes/koneksi.php";

/* ================== PAGINATION ================== */
$batas = 5;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman - 1) * $batas;

/* ================== PROSES HAPUS ================== */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM data_masuk WHERE id='$id'");
    header("Location: admin.php");
    exit;
}

/* ================== PROSES EDIT ================== */
if (isset($_POST['update'])) {
    $id    = $_POST['id'];
    $nama  = $_POST['nama'];
    $email = $_POST['email'];

    mysqli_query($koneksi,
        "UPDATE data_masuk 
         SET nama='$nama', email='$email' 
         WHERE id='$id'"
    );

    header("Location: admin.php");
    exit;
}

/* ================== DATA ================== */
$query = mysqli_query(
    $koneksi,
    "SELECT * FROM data_masuk LIMIT $halaman_awal, $batas"
);

$total_data = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM data_masuk")
);
$total_halaman = ceil($total_data / $batas);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FINWISE — Smart Finance, Smarter You</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- ===== CSS ASLI KAMU (TIDAK DIUBAH) ===== -->
  <style>
    :root {
      --primary:#8a9bbd;
      --secondary:#f4a7b9;
      --dark:#2c3e50;
    }
    body{
      font-family:'Poppins',sans-serif;
      background:linear-gradient(135deg,#cce5ff 0%,#f4a7b9 100%);
      min-height:100vh;
    }
    .header{
      width:100%;
      max-width:1400px;
      padding:20px 40px;
      display:flex;
      justify-content:space-between;
      align-items:center;
      position:fixed;
      top:0;
      left:50%;
      transform:translateX(-50%);
      background:rgba(255,255,255,.85);
      border-radius:0 0 20px 20px;
      box-shadow:0 4px 20px rgba(0,0,0,.1);
    }
    .logo{
      font-family:'Montserrat',sans-serif;
      font-size:1.8em;
      font-weight:800;
      background:linear-gradient(90deg,var(--secondary),var(--primary));
      -webkit-background-clip:text;
      color:transparent;
    }
    .nav a{
      text-decoration:none;
      font-weight:600;
      color:var(--dark);
    }
    .btn{
      padding:8px 18px;
      border-radius:20px;
      font-weight:600;
      text-decoration:none;
      cursor:pointer;
      border:none;
    }
    .btn-primary{
      background:var(--primary);
      color:white;
    }
    .btn-outline{
      background:transparent;
      border:2px solid var(--primary);
      color:var(--dark);
    }
    .container{
      max-width:1000px;
      margin:120px auto;
      background:white;
      padding:30px;
      border-radius:20px;
      box-shadow:0 10px 30px rgba(0,0,0,.1);
    }
    table{
      width:100%;
      border-collapse:collapse;
      margin-top:20px;
    }
    th,td{
      padding:12px;
      text-align:center;
    }
    th{
      background:#8a9bbd;
      color:white;
    }
    tr:nth-child(even){
      background:#f4f6fb;
    }
    .pagination{
      margin-top:20px;
      text-align:center;
    }
    .pagination a{
      padding:8px 14px;
      margin:0 3px;
      border-radius:8px;
      background:#eee;
      text-decoration:none;
      font-weight:600;
    }
    .pagination a.active{
      background:#f4a7b9;
      color:white;
    }
  </style>
</head>
<body>

<!-- ===== NAVBAR ASLI (TIDAK DIUBAH) ===== -->
<header class="header">
  <div class="logo">FINWISE</div>
  <nav class="nav">
    <a href="#">Dashboard Admin</a>
  </nav>
  <a href="login.php" class="btn btn-primary">Masuk</a>
</header>

<div class="container">
<h3 style="text-align:center">Selamat datang Admin 👋</h3>

<table>
<tr>
  <th>No</th>
  <th>Nama</th>
  <th>Email</th>
  <th>Password</th>
  <th>Aksi</th>
</tr>

<?php
$no = $halaman_awal + 1;
while ($data = mysqli_fetch_assoc($query)) {
?>
<tr>
  <td><?= $no++; ?></td>
  <td><?= $data['nama']; ?></td>
  <td><?= $data['email']; ?></td>
  <td>********</td>
  <td>
    <a href="?edit=<?= $data['id']; ?>" class="btn btn-outline">Edit</a>
    <a href="?hapus=<?= $data['id']; ?>" 
       class="btn btn-primary"
       onclick="return confirm('Yakin ingin menghapus data?')">
       Hapus
    </a>
  </td>
</tr>
<?php } ?>
</table>

<!-- ===== FORM EDIT (MUNCUL JIKA KLIK EDIT) ===== -->
<?php
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $e = mysqli_fetch_assoc(
      mysqli_query($koneksi, "SELECT * FROM data_masuk WHERE id='$id'")
  );
?>
<hr><br>
<h3>Edit Data User</h3>
<form method="POST">
  <input type="hidden" name="id" value="<?= $e['id']; ?>">
  <input type="text" name="nama" value="<?= $e['nama']; ?>" required>
  <input type="email" name="email" value="<?= $e['email']; ?>" required>
  <button type="submit" name="update" class="btn btn-primary">Update</button>
</form>
<?php } ?>

<div class="pagination">
<?php
if ($halaman > 1)
  echo '<a href="?halaman='.($halaman-1).'">Prev</a>';

for ($i=1; $i<=$total_halaman; $i++) {
  $active = ($i==$halaman) ? 'active' : '';
  echo '<a class="'.$active.'" href="?halaman='.$i.'">'.$i.'</a>';
}

if ($halaman < $total_halaman)
  echo '<a href="?halaman='.($halaman+1).'">Next</a>';
?>
</div>

</div>
</body>
</html>
