<?php
echo "<h3>Jawaban Soal 2: Looping For Bilangan Genap</h3>";
?>

<form method="POST" action="">
    <label for="batas_angka">Masukkan batas angka maksimal: </label>
    <input type="number" name="batas_angka" id="batas_angka" required min="2" placeholder="Contoh: 50">
    <button type="submit" name="submit_genap">Tampilkan</button>
</form>
<br>

<?php
if (isset($_POST['submit_genap'])) {
    $batas = $_POST['batas_angka'];

    echo "Bilangan genap dari 2 sampai <strong>" . $batas . "</strong> adalah: <br>";
    echo "<div style='margin-top: 10px; word-wrap: break-word;'>";
    
    for ($i = 2; $i <= $batas; $i += 2) {
        echo $i . " ";
    }
    
    echo "</div>";
}
?>