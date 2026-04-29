<?php
include 'koneksi.php';

$sql    = "SELECT * FROM pegawai";
$result = $conn->query($sql);

if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pegawai - HRIS</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 30px;
        }
        .header {
            background-color: #800000;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header h2 {
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th, td { 
            border-bottom: 1px solid #ddd; 
            padding: 12px 15px; 
            text-align: left; 
        }
        th { 
            background-color: #800000; 
            color: white; 
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn { 
            padding: 8px 12px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
        }
        .btn-tambah { 
            background-color: #800000; 
            color: white; 
            margin-bottom: 10px;
        }
        .btn-tambah:hover {
            background-color: #5c0000;
        }
        .btn-edit { 
            background-color: #f39c12; 
            color: white; 
        }
        .btn-edit:hover {
            background-color: #e67e22;
        }
        .btn-hapus { 
            background-color: #c0392b; 
            color: white; 
        }
        .btn-hapus:hover {
            background-color: #a93226;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Sistem Manajemen Data Kepegawaian</h2>
    </div>

    <div class="container">
        <a href="tambah.php" class="btn btn-tambah">+ Tambah Pegawai Baru</a>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Email</th>
                    <th>Gaji</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while ($row = $result->fetch_assoc()) : 
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nip']); ?></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><?= htmlspecialchars($row['jabatan']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td>Rp <?= number_format($row['gaji'], 0, ',', '.'); ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-edit">Edit</a>
                        <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php $conn->close(); ?>

</body>
</html>