<?php
include 'koneksi.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $conn->prepare("DELETE FROM pegawai WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    $stmt->execute();
    $stmt->close();
    
    header("Location: index.php");
    exit();
}

$conn->close();
?>