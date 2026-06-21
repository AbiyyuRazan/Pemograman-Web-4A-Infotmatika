<?php
session_start();
if (!isset($_SESSION['login_Un51k4'])) {
    header("Location: login.php?message=" . urlencode("Mengakses fitur harus login dulu bro."));
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Utama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mt-5">
                <div class="card-body text-center p-5">
                    <h2 class="mb-3">Selamat datang, <span class="text-primary"><?= htmlspecialchars($_SESSION['nama']); ?></span>!</h2>
                    <p class="text-muted">Anda telah berhasil masuk ke dalam sistem.</p>
                    <hr class="my-4">
                    <a href="logout.php" class="btn btn-danger px-4">Logout</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>