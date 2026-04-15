<h2 style="color: #9c1328;">Soal 1: Switch Jenis Kendaraan</h2>
<p>Masukkan jumlah roda untuk mengetahui jenis kendaraannya.</p>

<form method="POST" action="">
    <label for="roda">Jumlah Roda:</label>
    <input type="number" name="roda" id="roda" required placeholder="Contoh: 2, 3, 4, 6">
    <button type="submit" name="submit1" class="btn">Cek Kendaraan</button>
</form>

<?php
if (isset($_POST['submit1'])) {
    $roda = $_POST['roda'];
    echo "<div class='hasil-box'>";
    echo "Jumlah roda yang diinput: <strong>$roda</strong><br>";
    
    switch ($roda) {
        case 2: echo "Jenis Kendaraan: <strong>Sepeda / Sepeda Motor</strong>"; break;
        case 3: echo "Jenis Kendaraan: <strong>Becak / Bajaj</strong>"; break;
        case 4: echo "Jenis Kendaraan: <strong>Mobil</strong>"; break;
        case 6: 
        case 8: 
        case 10: echo "Jenis Kendaraan: <strong>Truk / Bus</strong>"; break;
        default: echo "Jenis Kendaraan: <strong>Tidak terdaftar dalam sistem</strong>"; break;
    }
    echo "</div>";
}
?>