<?php
require_once "../includes/koneksi.php";

/* ================== PAGINATION ================== */
$batas   = 5;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman - 1) * $batas;

/* ================== PROSES HAPUS ================== */
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM data_masuk WHERE id=$id");
    header("Location: admin.php?halaman=$halaman");
    exit;
}

/* ================== PROSES UPDATE ================== */
if (isset($_POST['update'])) {
    $id      = (int)$_POST['id'];
    $nama    = $_POST['nama'];
    $email   = $_POST['email'];
    $halaman = (int)$_POST['halaman'];

    mysqli_query(
        $koneksi,
        "UPDATE data_masuk SET nama='$nama', email='$email' WHERE id=$id"
    );

    header("Location: admin.php?halaman=$halaman");
    exit;
}

/* ================== AMBIL DATA ================== */
$query = mysqli_query(
    $koneksi,
    "SELECT * FROM data_masuk LIMIT $halaman_awal, $batas"
);

$total_data = mysqli_fetch_row(
    mysqli_query($koneksi, "SELECT COUNT(*) FROM data_masuk")
)[0];

$total_halaman = ceil($total_data / $batas);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>FINWISE — Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Montserrat:wght@800&display=swap" rel="stylesheet">

<style>
body{
  font-family:Poppins,sans-serif;
  background:linear-gradient(135deg,#cce5ff,#f4a7b9);
}
.header{
  max-width:1400px;
  margin:auto;
  padding:20px 40px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  background:rgba(255,255,255,.9);
  border-radius:0 0 20px 20px;
}
.logo{
  font-family:Montserrat;
  font-size:1.8em;
  font-weight:800;
}
.container{
  max-width:1000px;
  margin:60px auto;
  background:white;
  padding:30px;
  border-radius:20px;
}
table{
  width:100%;
  border-collapse:collapse;
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
.btn{
  padding:6px 14px;
  border-radius:12px;
  text-decoration:none;
  font-weight:600;
}
.btn-edit{
  background:#fff;
  border:2px solid #8a9bbd;
  color:#2c3e50;
}
.btn-hapus{
  background:#8a9bbd;
  color:white;
}
.pagination{
  text-align:center;
  margin-top:20px;
}
.pagination a{
  padding:6px 12px;
  margin:2px;
  border-radius:8px;
  background:#eee;
  text-decoration:none;
}
.pagination a.active{
  background:#f4a7b9;
  color:white;
}
form input{
  padding:8px;
  margin:5px 0;
  width:100%;
}
</style>
</head>
<body>

<!-- ===== NAVBAR ASLI (TIDAK DIUBAH) ===== -->
<header class="header">
  <div class="logo">FINWISE</div>
  <a href="login.php" class="btn btn-hapus">Masuk</a>
</header>

<div class="container">
<h3 style="text-align:center">Selamat Datang Admin 👋</h3>

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
while ($d = mysqli_fetch_assoc($query)) {
?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= $d['nama'] ?></td>
  <td><?= $d['email'] ?></td>
  <td>********</td>
  <td>
    <a href="?halaman=<?= $halaman ?>&edit=<?= $d['id'] ?>" class="btn btn-edit">Edit</a>
    <a href="?halaman=<?= $halaman ?>&hapus=<?= $d['id'] ?>"
       onclick="return confirm('Yakin hapus data?')"
       class="btn btn-hapus">Hapus</a>
  </td>
</tr>
<?php } ?>
</table>

<!-- ===== FORM EDIT ===== -->
<?php
if (isset($_GET['edit'])) {
  $id = (int)$_GET['edit'];
  $e  = mysqli_fetch_assoc(
      mysqli_query($koneksi, "SELECT * FROM data_masuk WHERE id=$id")
  );
?>
<hr>
<h3>Edit Data User</h3>
<form method="POST">
  <input type="hidden" name="id" value="<?= $e['id'] ?>">
  <input type="hidden" name="halaman" value="<?= $halaman ?>">
  <input type="text" name="nama" value="<?= $e['nama'] ?>" required>
  <input type="email" name="email" value="<?= $e['email'] ?>" required>
  <button class="btn btn-hapus" name="update">Update</button>
</form>
<?php } ?>

<div class="pagination">
<?php
for ($i=1; $i<=$total_halaman; $i++) {
  $active = ($i==$halaman) ? 'active' : '';
  echo "<a class='$active' href='?halaman=$i'>$i</a>";
}
?>
</div>

</div>
</body>
</html>
