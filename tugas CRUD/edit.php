<?php
include 'koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tidak valid!");
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM pegawai WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Data tidak ditemukan!");
}

$row = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pegawai - HRIS</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 500px; margin: 40px auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-top: 5px solid #800000; }
        h2 { color: #800000; text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input[type="text"], input[type="email"], input[type="number"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-size: 14px; }
        input[type="text"]:focus, input[type="email"]:focus, input[type="number"]:focus { border-color: #800000; outline: none; }
        .btn-group { margin-top: 25px; display: flex; justify-content: space-between; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: bold; text-decoration: none; text-align: center; flex: 1; margin: 0 5px; }
        .btn-submit { background-color: #800000; color: white; }
        .btn-submit:hover { background-color: #5c0000; }
        .btn-kembali { background-color: #6c757d; color: white; }
        .btn-kembali:hover { background-color: #5a6268; }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Data Pegawai</h2>
    <form action="proses_edit.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']); ?>">
        
        <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" id="nip" name="nip" value="<?= htmlspecialchars($row['nip']); ?>" required>
        </div>
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($row['nama']); ?>" required>
        </div>
        <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" id="jabatan" name="jabatan" value="<?= htmlspecialchars($row['jabatan']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($row['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="gaji">Gaji (Rp)</label>
            <input type="number" id="gaji" name="gaji" value="<?= htmlspecialchars($row['gaji']); ?>" required>
        </div>
        
        <div class="btn-group">
            <a href="index.php" class="btn btn-kembali">Kembali</a>
            <button type="submit" class="btn btn-submit">Update Data</button>
        </div>
    </form>
</div>

</body>
</html>