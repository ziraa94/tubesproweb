<?php
session_start();

/* ================== KONEKSI DATABASE ================== */
$host = "localhost";
$user = "root";
$pass = "";
$db   = "data_tubes";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi database gagal");
}

/* ================== PROSES LOGIN ================== */
$error = "";

if (isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM data_masuk WHERE email='$email'");
    $data  = mysqli_fetch_assoc($query);

    if ($data) {
        if (password_verify($password, $data['password'])) {
            $_SESSION['email'] = $data['email'];
            $_SESSION['nama']  = $data['nama'];
            header("Location: fitur.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email belum terdaftar!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - FINWISE</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    /* ==== CSS ASLI KAMU (TIDAK DIUBAH) ==== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(135deg, #cce5ff 0%, #f4a7b9 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .login-container {
      width: 100%;
      max-width: 420px;
      background-color: white;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(138, 155, 189, 0.2);
      text-align: center;
    }

    .logo h1 {
      font-size: 2.2em;
      font-weight: 700;
      background: linear-gradient(90deg, #8a9bbd, #f4a7b9);
      -webkit-background-clip: text;
      color: transparent;
    }

    .subtitle {
      color: #7f8fa9;
      margin-bottom: 30px;
    }

    .input-group {
      position: relative;
      margin: 16px 0;
      text-align: left;
    }

    .login-input {
      width: 100%;
      padding: 14px 16px 14px 48px;
      border: 1px solid #ddd;
      border-radius: 8px;
    }

    .input-icon {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #8a9bbd;
    }

    .btn-login {
      width: 100%;
      padding: 14px;
      background: linear-gradient(90deg, #8a9bbd, #a4b8d0);
      border: none;
      color: white;
      font-weight: 600;
      border-radius: 8px;
      margin-top: 20px;
      cursor: pointer;
    }

    .error {
      color: red;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<div class="login-container">

  <div class="logo">
    <h1>FINWISE</h1>
    <p class="subtitle">Masuk untuk mengelola keuanganmu</p>
  </div>

  <!-- PESAN ERROR -->
  <?php if ($error != "") { ?>
    <div class="error"><?= $error; ?></div>
  <?php } ?>

  <!-- FORM LOGIN -->
  <form method="POST">

    <div class="input-group">
      <i class="fas fa-envelope input-icon"></i>
      <input type="email" name="email" class="login-input" placeholder="Email" required>
    </div>

    <div class="input-group">
      <i class="fas fa-lock input-icon"></i>
      <input type="password" name="password" class="login-input" placeholder="Password" required>
    </div>

    <button type="submit" name="login" class="btn-login">Masuk</button>

  </form>

  <div class="signup-link">
    Belum punya akun? <a href="register.php">Daftar di sini</a>
  </div>

</div>

</body>
</html>
