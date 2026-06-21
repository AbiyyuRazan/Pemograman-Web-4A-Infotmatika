<?php
// Mulai sesi
session_start();

// Hapus semua data session [cite: 31]
session_unset();

// Hancurkan sesi sepenuhnya [cite: 33]
session_destroy();

// Arahkan kembali ke halaman login dengan pesan sukses 
header("Location: login.php?message=" . urlencode("Anda telah berhasil logout."));
exit;
?>