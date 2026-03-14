<?php
  define("PAJAK", 0.10);
  $barang = ["Keyboard" => 150000,"Headset" => 40000,"Monitor" => 2000000, "Kursi Gaming" => 400000,"Mouse" => 60000 ];
  $nama_barang = "Keyboard";
  $harga_satuan = $barang[$nama_barang];
  $jumlah_beli = 2;
  $total_harga = $jumlah_beli * $harga_satuan;
  $pajak = $total_harga * PAJAK;

    echo "<h1>Perhitungan Total Pembelian (Dengan Array)</h1>";
    echo "<hr>";
    echo "Nama Barang: $nama_barang <br>";
    echo "Harga Satuan: Rp.$harga_satuan <br>";
    echo "Jumlah Beli: $jumlah_beli <br>";
    echo "Total Harga (Sebelum Pajak): Rp." . $total_harga .  "<br>";
    echo "Pajak (10%): Rp" . $pajak . "<br>";
    echo "<b>Total Bayar: Rp." . ($total_harga + $pajak) . "</b>";

?>