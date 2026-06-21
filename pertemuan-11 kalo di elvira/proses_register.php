<?php
include 'koneksi_db.php'; // Pastikan file koneksi Anda sudah ada

// Proses jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; 
    
    // Menyimpan user baru ke database
    $stmt = $conn->prepare("INSERT INTO pengguna (nama, katasandi) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    
    if ($stmt->execute()) {
        // Jika berhasil, arahkan ke login
        header("Location: login.php?message=" . urlencode("Akun berhasil dibuat, silakan login."));
        exit;
    } else {
        // Jika gagal
        header("Location: register.php?message=" . urlencode("Gagal membuat akun."));
        exit;
    }
    
    $stmt->close();
}
?>