<h2 style="color: #9c1328;">Soal 4: Ternary Ganjil / Genap</h2>
<p>Masukkan sembarang angka untuk dicek statusnya.</p>

<form method="POST" action="">
    <label for="angka">Masukkan Angka:</label>
    <input type="number" name="angka" id="angka" required placeholder="Contoh: 15">
    <button type="submit" name="submit4" class="btn">Cek Ganjil / Genap</button>
</form>

<?php
if (isset($_POST['submit4'])) {
    $angka = $_POST['angka'];
    
    // Penggunaan Ternary Operator
    $status = ($angka % 2 == 0) ? "Genap" : "Ganjil";
    
    echo "<div class='hasil-box'>";
    echo "Angka <strong>$angka</strong> adalah bilangan <strong>$status</strong>.";
    echo "</div>";
}
?>