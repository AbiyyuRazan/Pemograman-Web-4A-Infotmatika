<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id      = $_POST['id'];
    $nip     = $_POST['nip'];
    $nama    = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $email   = $_POST['email'];
    $gaji    = $_POST['gaji'];

    $query = "UPDATE pegawai SET nip = ?, nama = ?, jabatan = ?, email = ?, gaji = ? WHERE id = ?";
    $stmt  = $conn->prepare($query);

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param("ssssdi", $nip, $nama, $jabatan, $email, $gaji, $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data pegawai berhasil diperbarui!');
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