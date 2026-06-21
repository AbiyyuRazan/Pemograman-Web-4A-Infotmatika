<?php
// Wajib diletakkan di paling atas sebelum kode HTML/sintaksis lain
session_start();

// Proteksi halaman: Jika user belum login, lempar kembali ke halaman login.php
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latihan Praktikum Web</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; 
        }

        header {
            background-color: #9c1328;
            color: white;
            text-align: center;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 35px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .content {
            flex: 2;
            padding: 20px;
            background-color: #ECF0F1;
            border-radius: 10px;
            min-height: 400px;
        }

        .sidebar {
            flex: 1;
            margin-left: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #9c1328;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #7d0f20;
        }

        /* Styling khusus tombol logout */
        .btn-logout {
            background-color: #333;
        }
        .btn-logout:hover {
            background-color: #000;
        }

        .hasil-box {
            margin-top: 15px;
            padding: 15px;
            background-color: #fff;
            border-left: 5px solid #9c1328;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Latihan Praktikum Percabangan, Perulangan, dan Include pada PHP</h1>
    </header>

    <div class="container">
        <div class="content">
            <?php
            if (isset($_GET['halaman'])) {
                $halaman = $_GET['halaman'];

                switch ($halaman) {
                    case 'soal1': include 'soal1.php'; break;
                    case 'soal2': include 'soal2.php'; break;
                    case 'soal3': include 'soal3.php'; break;
                    case 'soal4': include 'soal4.php'; break;
                    default: echo "<h2>Halaman tidak ditemukan.</h2>"; break;
                }
            } else {
                echo "<h2>Selamat Datang, <strong>" . htmlspecialchars($_SESSION['username']) . "</strong>!</h2>";
                echo "<p style='margin-top:10px;'>Silakan klik salah satu menu di sidebar samping untuk mencoba aplikasi.</p>";
            }
            ?>
        </div>

        <div class="sidebar">
            <h3 style=\"text-align:center; color:#333; margin-bottom:15px;\">Menu Navigasi</h3>
            <a href="index.php?halaman=soal1" class="btn">Soal 1</a>
            <a href="index.php?halaman=soal2" class="btn">Soal 2</a>
            <a href="index.php?halaman=soal3" class="btn">Soal 3</a>
            <a href="index.php?halaman=soal4" class="btn">Soal 4</a>
            
            <hr style="margin: 15px 0; border: 0; border-top: 1px solid #ddd;">
            
            <a href="logout.php" class="btn btn-logout" onclick="return confirm('Apakah Anda yakin ingin logout?')">Logout</a>
        </div>
    </div>

</body>
</html>