<?php
$servername = "localhost";
$username = "root";     // Sesuaikan jika Anda menggunakan username lain
$password = "";         // Sesuaikan jika database Anda memiliki password
$database = "test_session"; // Ini adalah nama database Anda

// Membuat koneksi menggunakan MySQLi berbasis objek (OOP)
$conn = new mysqli($servername, $username, $password, $database);

// Mengecek apakah koneksi berhasil atau gagal
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>