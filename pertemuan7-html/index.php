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
            padding: 20px;
            background-color: #BDC3C7;
            border-radius: 10px;
            margin-left: 20px;
        }

        .btn {
            width: 100%;
            display: inline-block;
            padding: 10px 20px;
            background-color: #db343f;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
            font-size: 16px;
        }

        .btn:hover {
            background-color: gray;
            transform: scale(1.02);
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .hasil-box {
            margin-top: 20px;
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
                echo "<h2>Selamat Datang!</h2>";
                echo "<p>Silakan klik salah satu menu di sidebar samping untuk mencoba aplikasi.</p>";
            }
            ?>
        </div>

        <div class="sidebar">
            <h3 style="text-align:center; color:#333; margin-bottom:15px;">Menu Navigasi</h3>
            <a href="index.php?halaman=soal1" class="btn">Soal 1</a>
            <a href="index.php?halaman=soal2" class="btn">Soal 2 </a>
            <a href="index.php?halaman=soal3" class="btn">Soal 3</a>
            <a href="index.php?halaman=soal4" class="btn">Soal 4 </a>
        </div>
    </div>

</body>
</html>