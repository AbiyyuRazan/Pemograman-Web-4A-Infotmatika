<html>
<head>
  <title>Hasil Belanja</title>
</head>
<body>
    <h2>Hasil Pemesanan</h2>
<?php
define("PAJAK", 0.15);
$harga = [
  "Pencil" => 2000,
  "Penghapus" => 2000,
  "Peruncing" => 3000
];

$nama = $_POST['nama'];
$nim = $_POST['NIM'];
$email = $_POST['email'];
$layanan = $_POST['layanan'];
$barang = $_POST['barang'] ?? [];

$subtotal = 0;
$detail = "";

if (empty($barang)) {
  echo "Tidak ada barang dipilih!";
} else {

  foreach ($barang as $b) {

    if ($b == "Pencil") {
      $jumlah = $_POST['jumlah_pencil'];
    } else if ($b == "Penghapus") {
      $jumlah = $_POST['jumlah_penghapus'];
    } else {
      $jumlah = $_POST['jumlah_peruncing'];
    }

    $total_item = $harga[$b] * $jumlah;
    $subtotal += $total_item;

    $detail .= "<tr>
                  <td>$b</td>
                  <td>$jumlah</td>
                  <td>Rp " . number_format($harga[$b],0,",",".") . "</td>
                  <td>Rp " . number_format($total_item,0,",",".") . "</td>
                </tr>";
  }

  $pajak = $subtotal * PAJAK;

  if ($layanan == "Prioritas") {
    $biaya_layanan = 3000;
  } else {
    $biaya_layanan = 0;
  }

  $total = $subtotal + $pajak + $biaya_layanan;

  echo "<table border='1' cellpadding='10'>
        <tr><th colspan='4'>Data Pemesanan</th></tr>
        <tr><td>Nama</td><td colspan='3'>$nama</td></tr>
        <tr><td>NIM</td><td colspan='3'>$nim</td></tr> <tr><td>Email</td><td colspan='3'>$email</td></tr>
        <tr><td>Layanan</td><td colspan='3'>$layanan</td></tr>

        <tr>
          <th>Barang</th>
          <th>Jumlah</th>
          <th>Harga</th>
          <th>Total</th>
        </tr>

        $detail
        <tr><td colspan='3'>Subtotal</td><td>Rp " . number_format($subtotal,0,",",".") . "</td></tr>
        <tr><td colspan='3'>Pajak (15%)</td><td>Rp " . number_format($pajak,0,",",".") . "</td></tr>
        <tr><td colspan='3'>Biaya Layanan</td><td>Rp " . number_format($biaya_layanan,0,",",".") . "</td></tr>
        <tr><td colspan='3'><b>Total</b></td><td><b>Rp " . number_format($total,0,",",".") . "</b></td></tr>
        </table>";
}
?>
</body>
</html>