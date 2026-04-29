<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip     = $_POST['nip'];
    $nama    = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $email   = $_POST['email'];
    $gaji    = $_POST['gaji'];

    $query = "INSERT INTO pegawai (nip, nama, jabatan, email, gaji) VALUES (?, ?, ?, ?, ?)";
    $stmt  = $conn->prepare($query);

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param("ssssd", $nip, $nama, $jabatan, $email, $gaji);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data pegawai berhasil ditambahkan!');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "Gagal: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Akses ditolak.";
}
?>