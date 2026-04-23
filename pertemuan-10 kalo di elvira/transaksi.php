<?php include 'koneksi_db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Pesanan Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="container mt-4">
        <h2>Buat Pesanan Baru</h2>
        <form action="proses_transaksi.php" method="POST">
            <div class="card mb-3">
                <div class="card-body">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" class="form-control" placeholder="Masukkan nama pelanggan baru" required>
                </div>
            </div>

            <h4>Daftar Buku</h4>
            <div class="card mb-3">
                <div class="card-body">
                    <label class="form-label">Pilih Buku</label>
                    <select name="buku[0][id]" class="form-control mb-2" required>
                        <option value="">Pilih Buku</option>
                        <?php
                        $res = $conn->query("SELECT ID, Judul, Harga FROM buku WHERE Stok > 0");
                        while($row = $res->fetch_assoc()) {
                            echo "<option value='{$row['ID']}'>{$row['Judul']} - Rp".number_format($row['Harga'])."</option>";
                        }
                        ?>
                    </select>
                    <label class="form-label">Jumlah Buku</label>
                    <input type="number" name="buku[0][kuantitas]" class="form-control" min="1" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Buat Pesanan</button>
        </form>
    </div>
</body>
</html>