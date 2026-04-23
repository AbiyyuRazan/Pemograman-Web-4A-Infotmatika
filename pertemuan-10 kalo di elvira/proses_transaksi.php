<?php 
include 'koneksi_db.php'; 
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
   $conn->begin_transaction(); 
   try { 
       // 1. Ambil Nama Pelanggan dari form
       $nama_pelanggan = $_POST['nama_pelanggan']; 
       $tanggal_pesanan = date('Y-m-d'); 
       $total_harga = 0; 
 
       // 2. Simpan ke tabel pelanggan terlebih dahulu
       $stmt_p = $conn->prepare("INSERT INTO pelanggan (Nama) VALUES (?)");
       $stmt_p->bind_param("s", $nama_pelanggan);
       $stmt_p->execute();
       
       // 3. Ambil ID pelanggan yang baru saja dibuat
       $pelanggan_id = $conn->insert_id; 
       $stmt_p->close();

       // 4. Masukkan ke tabel pesanan menggunakan $pelanggan_id tadi
       $stmt = $conn->prepare("INSERT INTO pesanan (Tanggal_Pesanan, Pelanggan_ID, Total_Harga) VALUES (?, ?, ?)"); 
       $stmt->bind_param("sid", $tanggal_pesanan, $pelanggan_id, $total_harga); 
       $stmt->execute(); 
       $pesanan_id = $conn->insert_id; 
 
       // Proses detail pesanan (Buku)
       foreach ($_POST['buku'] as $buku) { 
           $buku_id = $buku['id']; 
           $kuantitas = $buku['kuantitas']; 
 
           $stmt = $conn->prepare("SELECT Harga, Stok FROM buku WHERE ID = ?"); 
           $stmt->bind_param("i", $buku_id); 
           $stmt->execute(); 
           $stmt->bind_result($harga_per_satuan, $stok); 
           $stmt->fetch(); 
           $stmt->close(); 
 
           if ($stok < $kuantitas) { 
               throw new Exception("Stok tidak cukup."); 
           } 
 
           $stmt = $conn->prepare("INSERT INTO detail_pesanan (Pesanan_ID, Buku_ID, Kuantitas, Harga_Per_Satuan) VALUES (?, ?, ?, ?)"); 
           $stmt->bind_param("iiid", $pesanan_id, $buku_id, $kuantitas, $harga_per_satuan); 
           $stmt->execute(); 
 
           $total_harga += $kuantitas * $harga_per_satuan; 
 
           $stmt = $conn->prepare("UPDATE buku SET Stok = Stok - ? WHERE ID = ?"); 
           $stmt->bind_param("ii", $kuantitas, $buku_id); 
           $stmt->execute(); 
       } 
 
       // Update total harga akhir
       $stmt = $conn->prepare("UPDATE pesanan SET Total_Harga = ? WHERE ID = ?"); 
       $stmt->bind_param("di", $total_harga, $pesanan_id); 
       $stmt->execute();
       
       $conn->commit();
       header("Location: lihat_transaksi.php?message=Berhasil"); 
       exit; 
   } catch (Exception $e) { 
       $conn->rollback(); 
       echo "Gagal: " . $e->getMessage();
   } 
} 
?>