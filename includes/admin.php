<?php
require_once "../includes/koneksi.php";
if (!$koneksi) {
    die("Koneksi database GAGAL! Mohon periksa file ../includes/koneksi.php: " . mysqli_connect_error());
}
if (isset($_POST['tambah_data'])) {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = password_hash(mysqli_real_escape_string($koneksi, $_POST['password']), PASSWORD_DEFAULT); 

    $insert_query = "INSERT INTO data_masuk (nama, email, password) 
                     VALUES ('$nama', '$email', '$password')";
    
    if (mysqli_query($koneksi, $insert_query)) {
        header("Location: admin.php");
        exit;
    } else {
        echo "<script>alert('Error saat menambahkan data: " . mysqli_error($koneksi) . "');</script>";
    }
}

$batas = 5;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
if ($halaman < 1) $halaman = 1; 
$halaman_awal = ($halaman - 1) * $batas;

/* ================== PROSES HAPUS ================== */
if (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    $cek = mysqli_query($koneksi, "SELECT email FROM data_masuk WHERE id='$id'");
    $user = mysqli_fetch_assoc($cek);
    if ($user && $user['email'] === 'admin@finwise.com') {
        echo "<script>alert('Akun admin TIDAK BOLEH dihapus!');window.location='admin.php';</script>";
        exit;
    }
    if (mysqli_query($koneksi, "DELETE FROM data_masuk WHERE id='$id'")) {
        header("Location: admin.php");
        exit;
    } else {
        echo "<script>alert('Gagal menghapus data');</script>";
    }
}


/* ================== PROSES EDIT ================== */
if (isset($_POST['update'])) {
    $id    = mysqli_real_escape_string($koneksi, $_POST['id']);
    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    $update_query = "UPDATE data_masuk 
                     SET nama='$nama', email='$email' 
                     WHERE id='$id'";
    
    if (mysqli_query($koneksi, $update_query)) {
        header("Location: admin.php");
        exit;
    } else {
        echo "<script>alert('Error saat mengupdate data: " . mysqli_error($koneksi) . "');</script>";
    }
}

$query = mysqli_query(
    $koneksi,
    "SELECT id, nama, email, password FROM data_masuk LIMIT $halaman_awal, $batas"
);
$total_data_query = mysqli_query($koneksi, "SELECT COUNT(id) AS total FROM data_masuk");
$total_row = mysqli_fetch_assoc($total_data_query);
$total_data = (int) ($total_row['total'] ?? 0); 
$total_halaman = ceil($total_data / $batas);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FINWISE-ADMIN</title>

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
      display: inline-block;
      text-align: center;
      transition: background 0.3s;
    }
    .btn-primary{
      background:var(--primary);
      color:white;
    }
    .btn-outline{
      background:transparent;
      border:2px solid var(--primary);
      color:var(--dark);
      padding: 6px 16px; 
    }
    .container{
      max-width:1100px;
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
      table-layout: fixed;
    }
    th,td{
      padding:12px;
      text-align:center;
      word-wrap: break-word; 
    }
    th{
      background:#8a9bbd;
      color:white;
    }
    th:nth-child(1), td:nth-child(1) { width: 5%; }
    th:nth-child(2), td:nth-child(2) { width: 20%; } 
    th:nth-child(3), td:nth-child(3) { width: 25%; } 
    th:nth-child(4), td:nth-child(4) { width: 35%; } 
    th:nth-child(5), td:nth-child(5) { width: 15%; } 


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
    
    .form-edit {
        display: flex;
        flex-direction: column; 
        gap: 10px;
        margin-top: 20px;
        align-items: flex-start;
    }
    .form-edit label {
        font-weight: 600;
        margin-top: 5px;
    }
    .form-edit input {
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 100%;
        max-width: 400px;
    }
    .form-edit .button-group {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }
    .form-edit .button-group button,
    .form-edit .button-group a {
        padding: 10px 20px;
        border-radius: 8px;
        flex: 1;
        max-width: 150px;
    }
    
    .form-edit .btn-outline-custom {
        background: #f4f6fb;
        border: 1px solid #ccc;
        color: var(--dark);
        padding: 10px 20px;
        text-decoration: none;
        display: inline-block;
        border-radius: 8px;
        text-align: center;
        font-weight: 600;
    }

    
    .form-tambah {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        flex-wrap: wrap;
        align-items: center;
    }
    .form-tambah input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        flex: 1;
        min-width: 150px;
    }
    .form-tambah button, .form-tambah a.btn {
        width: auto;
    }
  </style>
</head>
<body>

<header class="header">
  <div class="logo">FINWISE</div>
  <nav class="nav">
    <a href="#">Dashboard Admin</a>
  </nav>
  <a href="login.php" class="btn btn-primary">Masuk</a>
</header>

<div class="container">
<h3 style="text-align:center">Selamat datang Admin 👋</h3>

<?php
// ===============================================
// TAMPILAN FORM ESIT DAN TAMBAH DATA
// ===============================================

if (isset($_GET['edit'])) {
  $id_edit = mysqli_real_escape_string($koneksi, $_GET['edit']);
  $e_query = mysqli_query($koneksi, "SELECT * FROM data_masuk WHERE id='$id_edit'");
  $e = mysqli_fetch_assoc($e_query);
  
  if ($e) {
?>
<hr><br>
<h3>Edit Data User</h3>
<form method="POST" action="admin.php" class="form-edit">
  <input type="hidden" name="id" value="<?php echo htmlspecialchars($e['id'] ?? ''); ?>">
  
  <label for="edit_nama">Nama Lengkap:</label>
  <input type="text" id="edit_nama" name="nama" value="<?php echo htmlspecialchars($e['nama'] ?? ''); ?>" required>
  
  <label for="edit_email">Alamat Email:</label>
  <input type="email" id="edit_email" name="email" value="<?php echo htmlspecialchars($e['email'] ?? ''); ?>" required>
  
  <div class="button-group">
      <button type="submit" name="update" class="btn btn-primary">Update</button>
      <a href="admin.php" class="btn-outline-custom">Batal</a>
  </div>
</form>
<br>
<?php 
  } else {
    echo "<p>Data yang ingin diedit tidak ditemukan. <a href='admin.php'>Kembali</a></p>";
  }
} 
else if (isset($_GET['action']) && $_GET['action'] == 'add') {
?>
<hr><br>
<h3>Tambah Data User Baru</h3>
<form method="POST" action="admin.php" class="form-tambah"> 
    <input type="text" name="nama" placeholder="Nama Lengkap" required>
    <input type="email" name="email" placeholder="Alamat Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="tambah_data" class="btn btn-primary">Simpan</button>
    <a href="admin.php" class="btn btn-outline">Batal</a>
</form>
<br>
<?php
}
?>

<hr>
<h3 style="margin-top:20px; text-align:center">Daftar Data User</h3>

<?php
if (!isset($_GET['edit']) && (!isset($_GET['action']) || $_GET['action'] != 'add')) {
    echo '<p style="text-align:right; margin-bottom:15px;"><a href="?action=add" class="btn btn-primary">[+] Tambah Data</a></p>';
}
?>

<table>
<tr>
  <th>No</th> 
  <th>Nama</th>
  <th>Email</th>
  <th>Password</th> 
  <th>Aksi</th>
</tr>

<?php
$nomor_urut = $halaman_awal + 1;

if ($query && mysqli_num_rows($query) > 0) {
    while ($data = mysqli_fetch_assoc($query)) {
?>
<tr>
  <td><?php echo $nomor_urut; ?></td>
  <td><?php echo htmlspecialchars($data['nama'] ?? ''); ?></td>
  <td><?php echo htmlspecialchars($data['email'] ?? ''); ?></td>
  <td><?php echo htmlspecialchars($data['password'] ?? ''); ?></td> 
  <td>
    <a href="?edit=<?php echo $data['id']; ?>" class="btn btn-outline">Edit</a>
    <a href="?hapus=<?php echo $data['id']; ?>" 
        class="btn btn-primary"
        onclick="return confirm('Yakin ingin menghapus data <?php echo htmlspecialchars($data['nama']); ?>?')">
        Hapus
    </a>
  </td>
</tr>
<?php 
    $nomor_urut++;
    }
} else {
    echo "<tr><td colspan='5'>Tidak ada data ditemukan. (Total Data: $total_data)</td></tr>";
}
?>
</table>

<div class="pagination">
<?php
if ($total_halaman > 1) {
    if ($halaman > 1)
      echo '<a href="?halaman='.($halaman-1).'">Prev</a>';

    for ($i=1; $i<=$total_halaman; $i++) {
      $active = ($i==$halaman) ? 'active' : '';
      echo '<a class="'.$active.'" href="?halaman='.$i.'">'.$i.'</a>';
    }

    if ($halaman < $total_halaman)
      echo '<a href="?halaman='.($halaman+1).'">Next</a>';
}
?>
</div>

</div>
</body>
</html>
