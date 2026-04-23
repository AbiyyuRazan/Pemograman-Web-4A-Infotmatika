<h2 style="color: #9c1328;">Soal 3: Foreach Daftar Hewan</h2>
<p>Ketikkan nama-nama hewan dipisahkan dengan tanda koma.</p>

<form method="POST" action="">
    <label for="hewan">Daftar Hewan:</label>
    <input type="text" name="hewan" id="hewan" required placeholder="Contoh: Kucing, Singa, Jerapah, Kuda">
    <button type="submit" name="submit3" class="btn">Buat Array & Tampilkan</button>
</form>

<?php
if (isset($_POST['submit3'])) {
    $input_hewan = $_POST['hewan'];
    
    $array_hewan = explode(",", $input_hewan);
    
    echo "<div class='hasil-box'>";
    echo "Daftar Hewan dalam Array: <ul>";
    
    foreach ($array_hewan as $nama) {
        echo "<li>" . trim($nama) . "</li>"; 
    
    echo "</ul></div>";
}
?>