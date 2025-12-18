<?php
session_start();

/* ================== KONEKSI DATABASE ================== */
require_once "koneksi.php";
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$error = "";

if (isset($_POST['login_admin'])) {
    $identifier = trim($_POST['user_input']);
    $pass       = $_POST['password'];

    if ($identifier === '' || $pass === '') {
        $error = "Email/Username dan password harus diisi!";
    } else {
        $sql = "SELECT * FROM data_masuk WHERE (email = ? OR nama = ?) LIMIT 1";
        $data = null;

        if ($stmt = mysqli_prepare($koneksi, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ss', $identifier, $identifier);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result) {
                $data = mysqli_fetch_assoc($result);
            }
            mysqli_stmt_close($stmt);
        }

        if ($data) {
            if (!isset($data['role']) || $data['role'] !== 'admin') {
                $error = "Akun bukan admin.";
            } elseif (password_verify($pass, $data['password'])) {
                $_SESSION['login'] = true;
                $_SESSION['role']  = 'admin';
                $_SESSION['id']    = $data['id'];
                $_SESSION['nama']  = $data['nama'];
                $_SESSION['email'] = $data['email'];

                header("Location: ../includes/admin.php");
                exit;
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Akun admin tidak ditemukan!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>FINWISE-ADMIN_LOGIN</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif}
body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#cce5ff,#f4a7b9);
}
.login-box{
    background:#fff;
    width:100%;
    max-width:420px;
    padding:40px 30px;
    border-radius:16px;
    box-shadow:0 15px 35px rgba(0,0,0,.15);
}
.logo{text-align:center;margin-bottom:25px}
.logo h1{
    font-size:2.2em;
    background:linear-gradient(90deg,#8a9bbd,#f4a7b9);
    -webkit-background-clip:text;
    color:transparent;
}
.logo p{color:#7f8fa9;font-size:.9em}
.input-group{position:relative;margin-bottom:18px}
.input-group i{
    position:absolute;
    top:50%;
    left:14px;
    transform:translateY(-50%);
    color:#8a9bbd;
}
.input-group input{
    width:100%;
    padding:14px 14px 14px 44px;
    border:1px solid #ddd;
    border-radius:10px;
}
.btn-login{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background:linear-gradient(90deg,#8a9bbd,#f4a7b9);
    color:white;
    font-weight:600;
    cursor:pointer;
}
.error-box{
    background:#ffebee;
    color:#c62828;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
}
.footer{text-align:center;margin-top:20px;font-size:.85em}
.footer a{color:#f4a7b9;text-decoration:none;font-weight:600}
</style>
</head>

<body>

<div class="login-box">
    <div class="logo">
        <h1>FINWISE</h1>
        <p>Admin Panel Login</p>
    </div>

    <?php if ($error): ?>
        <div class="error-box">
            <i class="fas fa-circle-exclamation"></i> <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="input-group">
            <i class="fas fa-user-shield"></i>
            <input type="text" name="user_input" placeholder="Email / Username Admin" required>
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password Admin" required>
        </div>

        <button type="submit" name="login_admin" class="btn-login">
            Masuk Admin
        </button>
    </form>

    <div class="footer">
        <a href="login.php">← Login User</a>
    </div>
</div>

</body>
</html>
