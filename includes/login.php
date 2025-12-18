<?php
session_start();
require_once "koneksi.php";

$error = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM data_masuk WHERE email='$email' OR nama='$email' LIMIT 1");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['login'] = true;
        $_SESSION['email'] = $user['email'];
        $_SESSION['role']  = $user['role'];

        // AUTO REDIRECT
        if ($user['role'] === 'admin') {
          header("Location: ../includes/admin.php");
        } else {
          header("Location: ../includes/dashboard.php");
        }
        exit;
    } else {
        $error = "Email atau password salah";
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FINWISE-LOGIN</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>

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
  <?php if (!empty($error)) { ?>
    <div class="error"><?= $error; ?></div>
  <?php } ?>

  <!-- FORM LOGIN -->
  <form method="POST">

      <div class="input-group">
        <i class="fas fa-envelope input-icon"></i>
        <input type="text" name="email" class="login-input" placeholder="Email atau username" required>
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