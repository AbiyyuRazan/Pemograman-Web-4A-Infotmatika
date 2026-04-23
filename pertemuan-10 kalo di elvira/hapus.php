<?php include 'koneksi_db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hapus Buku - Toko Buku Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Halaman Manajemen Hapus Buku</h2>
        </div>
        <p class="text-muted">Pilih buku yang ingin dihapus secara permanen dari sistem.</p>
        
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <thead class="table-danger">
                        <tr>
                            <th>ID</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM buku";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['ID']}</td>
                                    <td>{$row['Judul']}</td>
                                    <td>{$row['Penulis']}</td>
                                    <td>{$row['Stok']}</td>
                                    <td class='text-center'>
                                        <a href='proses_hapus.php?id={$row['ID']}' 
                                           class='btn btn-outline-danger btn-sm' 
                                           onclick=\"return confirm('Yakin ingin menghapus buku ini?')\">
                                           Hapus Permanen
                                        </a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>Tidak ada data buku.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>