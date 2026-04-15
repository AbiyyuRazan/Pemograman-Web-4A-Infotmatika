<h2 style="color: #9c1328;">Soal 3: Foreach Daftar Hewan</h2>
<p>Ketikkan nama-nama hewan dipisahkan dengan tanda koma.</p>

<form method="POST" action="">
    <label for="hewan">Daftar Hewan:</label>
    <input type="text" name="hewan" id="hewan" required placeholder="Contoh: Kucing, Singa, Jerapah, Kuda">
    <button type="submit" name="submit3" class="btn">Buat Array & Tampilkan</button>
</form>

<?php
if (isset($_POST['submit3'])) {
    // Menangkap inputan string
    $input_hewan = $_POST['hewan'];
    
    // Fungsi explode() mengubah teks yang dipisah koma menjadi Array
    $array_hewan = explode(",", $input_hewan);
    
    echo "<div class='hasil-box'>";
    echo "Daftar Hewan dalam Array: <ul>";
    
    // Looping array menggunakan foreach
    foreach ($array_hewan as $nama) {
        echo "<li>" . trim($nama) . "</li>"; // trim() untuk menghapus spasi berlebih
    }
    
    echo "</ul></div>";
}
?>