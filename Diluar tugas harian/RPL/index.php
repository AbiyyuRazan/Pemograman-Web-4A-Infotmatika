<?php
$role = isset($_GET['role']) ? $_GET['role'] : 'public';
$headerTitle = ($role === 'admin') ? 'Admin Panel' : 'Dashboard Publik';

// Simulasi Data Server-Side (Opsional untuk Inisialisasi)
$recentTransactions = [
    ['id' => 1, 'date' => '2026-03-28', 'name' => 'Pembangunan Jalan Desa RT 05', 'cat' => 'Infrastruktur', 'status' => 'Selesai', 'amount' => 125000000, 'type' => 'Realisasi'],
    ['id' => 2, 'date' => '2026-03-25', 'name' => 'Bantuan Operasional Sekolah', 'cat' => 'Pendidikan', 'status' => 'Selesai', 'amount' => 45000000, 'type' => 'Realisasi']
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITANGKIS | <?php echo $headerTitle; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css"> </head>
<body>

    <div class="app-layout">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-content">
                <div class="logo-area">
                    <div class="logo-wrapper">
                        <div class="logo-glow"></div>
                        <div class="logo-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    </div>
                    <div class="logo-text">
                        <h1 class="text-gradient">SITANGKIS</h1>
                        <p><?php echo ($role === 'admin') ? 'Editor Mode' : 'Spectator Mode'; ?></p>
                    </div>
                </div>

                <nav class="nav-menu">
                    <a href="index.php?role=<?php echo $role; ?>" class="nav-item active"><i class="fa-solid fa-table-columns"></i> <span>Dashboard</span></a>
                    <a href="anggaran.php?role=<?php echo $role; ?>" class="nav-item"><i class="fa-solid fa-wallet"></i> <span>Kelola Anggaran</span></a>
                    <a href="realisasi.php?role=<?php echo $role; ?>" class="nav-item"><i class="fa-solid fa-arrow-trend-up"></i> <span>Realisasi Dana</span></a>
                    <a href="laporan.php?role=<?php echo $role; ?>" class="nav-item"><i class="fa-solid fa-file-lines"></i> <span>Laporan Publik</span></a>
                </nav>

                <div class="sidebar-footer">
                    <?php if($role === 'admin'): ?>
                        <a href="?role=public" class="btn-role logout"><i class="fa-solid fa-right-from-bracket"></i> Logout ke Publik</a>
                    <?php else: ?>
                        <a href="?role=admin" class="btn-role login"><i class="fa-solid fa-lock"></i> Login Admin</a>
                    <?php endif; ?>
                </div>
            </div>
        </aside>

        <div class="main-wrapper">
            <header class="top-header">
                <div class="header-left">
                    <button class="mobile-toggle" id="mobileToggle"><i class="fa-solid fa-bars"></i></button>
                    <h2 class="page-title"><?php echo $headerTitle; ?></h2>
                </div>
                <div class="header-right">
                    <div class="user-profile">
                        <p class="user-name"><?php echo ($role === 'admin') ? 'Administrator' : 'Pengunjung'; ?></p>
                        <p class="user-role"><?php echo ($role === 'admin') ? 'admin@desa.go.id' : 'Tamu Desa'; ?></p>
                    </div>
                </div>
            </header>

            <main class="content-area">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue"><i class="fa-solid fa-wallet"></i></div>
                        <div class="stat-info">
                            <p>Total Anggaran</p>
                            <h3 id="totAnggaran">Rp 0</h3>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green"><i class="fa-solid fa-arrow-trend-up"></i></div>
                        <div class="stat-info">
                            <p>Total Realisasi</p>
                            <h3 id="totRealisasi">Rp 0</h3>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon yellow"><i class="fa-solid fa-percent"></i></div>
                        <div class="stat-info">
                            <p>Serapan Dana</p>
                            <h3 id="totSerapan">0%</h3>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    <div class="table-header">
                        <h3>Semua Transaksi Terbaru</h3>
                    </div>
                    <div class="table-wrapper">
                        <table class="main-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kegiatan</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th class="text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="dashboardTable">
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="app.js"></script>
    <script>
        // Logika spesifik halaman Dashboard
        let db = JSON.parse(localStorage.getItem('sitangkis_db'));
        if(!db) { 
            db = <?php echo json_encode($recentTransactions); ?>;
            localStorage.setItem('sitangkis_db', JSON.stringify(db));
        }

        let sumAnggaran = 0; 
        let sumRealisasi = 0;
        const tbody = document.getElementById('dashboardTable');
        
        db.slice().reverse().forEach(tx => {
            if(tx.type === 'Anggaran') sumAnggaran += parseInt(tx.amount);
            if(tx.type === 'Realisasi') sumRealisasi += parseInt(tx.amount);
            
            const statusClass = tx.type === 'Realisasi' ? 'status-completed' : 'status-processing';
            
            tbody.innerHTML += `<tr>
                <td>${tx.date}</td>
                <td class="fw-600">${tx.name}</td>
                <td><span class="tag-category">${tx.cat}</span></td>
                <td><span class="badge-status ${statusClass}">${tx.type}</span></td>
                <td class="text-right fw-600">${formatRp(tx.amount)}</td>
            </tr>`;
        });

        document.getElementById('totAnggaran').innerText = formatRp(sumAnggaran);
        document.getElementById('totRealisasi').innerText = formatRp(sumRealisasi);
        let serapan = sumAnggaran > 0 ? ((sumRealisasi / sumAnggaran) * 100).toFixed(1) : 0;
        document.getElementById('totSerapan').innerText = serapan + '%';
    </script>
</body>
</html>