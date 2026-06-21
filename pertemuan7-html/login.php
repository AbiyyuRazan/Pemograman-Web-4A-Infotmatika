<?php
session_start();

// Jika sudah login, langsung dialihkan ke halaman utama index.php
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$error = false;

// Cek apakah tombol login sudah ditekan
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi username & password (bisa diganti sesuai kebutuhan)
    if ($username === 'admin' && $password === 'admin123') {
        // Set session login
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        
        // Alihkan ke halaman utama
        header("Location: index.php");
        exit;
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Praktikum Web</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 350px;
            border-top: 5px solid #9c1328;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn-login {
            width: 100%;
            padding: 10px;
            background-color: #9c1328;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-login:hover {
            background-color: #7d0f20;
        }
        .error-msg {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login Aplikasi</h2>
    
    <?php if ($error) : ?>
        <p class="error-msg">Username atau Password salah!</p>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required placeholder="admin">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required placeholder="admin123">
        </div>
        <button type="submit" name="login" class="btn-login">Login</button>
    </form>
</div>

</body>
</html>