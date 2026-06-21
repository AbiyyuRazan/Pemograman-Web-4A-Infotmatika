<?php
// ============================================
// config/koneksi.php
// File koneksi ke database MySQL
// ============================================

// Aktifkan error reporting agar semua error PHP terlihat saat pengembangan
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definisi Konstanta Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');      // Default XAMPP adalah root
define('DB_PASS', '');          // Default XAMPP adalah kosong
define('DB_NAME', 'campus_events');
define('BASE_URL', 'http://localhost/campus_events');

// Buat koneksi ke database
$koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Cek apakah koneksi berhasil
if (!$koneksi) {
    die('<div style="font-family:sans-serif;padding:20px;color:red;border:1px solid red;background:#fff5f5;max-width:600px;margin:20px auto;border-radius:5px;">
        <h3 style="margin-top:0;">❌ Koneksi Database Gagal!</h3>
        <p><strong>Pesan Error:</strong> ' . mysqli_connect_error() . '</p>
        <p>Silakan cek pengaturan username, password, atau nama database di file <strong>config/koneksi.php</strong></p>
    </div>');
}

// Set charset ke utf8mb4 agar mendukung karakter khusus dan emoji
mysqli_set_charset($koneksi, 'utf8mb4');
?>