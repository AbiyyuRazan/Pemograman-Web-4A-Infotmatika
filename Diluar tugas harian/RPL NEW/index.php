<?php
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';

$pageTitle  = 'Beranda';
$activePage = 'home';
$db = getDB();

$desa           = $db->query("SELECT * FROM desa_info LIMIT 1")->fetch();
$totalAnggaran  = (int)$db->query("SELECT SUM(jumlah) FROM anggaran WHERE tahun=YEAR(NOW())")->fetchColumn();
$totalRealisasi = (int)$db->query("SELECT SUM(jumlah) FROM realisasi WHERE YEAR(tanggal)=YEAR(NOW()) AND status='Selesai'")->fetchColumn();
$serapan        = $totalAnggaran > 0 ? round(($totalRealisasi/$totalAnggaran)*100,1) : 0;

$recent = $db->query("SELECT * FROM realisasi WHERE is_publik=1 ORDER BY tanggal DESC LIMIT 6")->fetchAll();

$barStmt = $db->prepare("SELECT a.kategori, a.jumlah AS anggaran, COALESCE(SUM(r.jumlah),0) AS realisasi
  FROM anggaran a LEFT JOIN realisasi r ON r.kategori=a.kategori AND r.status='Selesai' AND YEAR(r.tanggal)=YEAR(NOW())
  WHERE a.tahun=YEAR(NOW()) GROUP BY a.kategori, a.jumlah");
$barStmt->execute();
$barData = $barStmt->fetchAll();

$pieRows = $db->query("SELECT sumber, jumlah FROM sumber_pendapatan WHERE tahun=YEAR(NOW())")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Beranda — <?= APP_NAME ?></title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<style>
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Plus Jakarta Sans',sans-serif;background:#f0f7f9;color:#0f223a;min-height:100vh}

/* NAVBAR */
.nav{background:#0e4060;position:sticky;top:0;z-index:100;height:62px;display:flex;align-items:center;justify-content:space-between;padding:0 48px;box-shadow:0 4px 20px rgba(14,64,96,0.15)}
.nav-brand{display:flex;align-items:center;gap:10px;text-decoration:none;color:#fff}
.nav-icon{width:34px;height:34px;background:#00a896;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0}
.nav-name{font-weight:800;font-size:1.05rem}
.nav-sub{font-size:.62rem;color:rgba(255,255,255,.6)}
.nav-links{display:flex;gap:4px;align-items:center}
.nav-a{color:rgba(255,255,255,.8);text-decoration:none;padding:7px 14px;border-radius:7px;font-size:.85rem;font-weight:500;transition:all .18s}
.nav-a:hover,.nav-a.active{color:#fff;background:rgba(255,255,255,.15)}
.nav-btn{background:#02c39a;color:#0e4060;text-decoration:none;padding:8px 18px;border-radius:8px;font-size:.85rem;font-weight:700;transition:all .18s}
.nav-btn:hover{background:#00a896;color:#fff}

/* HERO - PURE IMAGE, BOTTOM ALIGNED */
.hero{
  background-image: url('mandeh.jpg'); 
  background-size: cover; 
  background-position: center bottom; /* Mengambil gambar dari sisi bawah habis */
  padding: 75px 48px 90px; 
  color: #fff; 
  position: relative;
}
.hero-badge{
  display:inline-flex;
  align-items:center;
  gap:6px;
  background:rgba(0, 0, 0, 0.4); /* Menggunakan warna hitam transparan tipis agar kontras di atas foto murni */
  backdrop-filter:blur(8px);
  padding:6px 14px;
  border-radius:20px;
  font-size:.78rem;
  font-weight:600;
  margin-bottom:18px;
  border:1px solid rgba(255,255,255,0.2);
  text-shadow: 0 1px 2px rgba(0,0,0,0.5);
}
.hero h1{
  font-size:2.8rem;
  font-weight:800;
  margin-bottom:12px;
  line-height:1.2;
  text-shadow: 0 2px 12px rgba(0,0,0,0.7), 0 1px 3px rgba(0,0,0,0.9); /* Bayangan teks lebih tebal agar terbaca jelas tanpa filter */
}
.hero p{
  color:#fff;
  text-shadow: 0 2px 8px rgba(0,0,0,0.7), 0 1px 3px rgba(0,0,0,0.9);
  font-size:1.1rem;
  margin-bottom:32px;
  max-width:540px;
  font-weight:600;
}
.hero-search{display:flex;gap:0;max-width:520px;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 12px 36px rgba(0,0,0,0.3)}
.hero-search input{flex:1;padding:14px 20px;border:none;font-size:.92rem;outline:none;font-family:inherit;color:#0f223a}
.hero-search button{background:#02c39a;color:#0e4060;border:none;padding:14px 24px;font-weight:700;cursor:pointer;font-size:.88rem;font-family:inherit;white-space:nowrap;transition:background .18s}
.hero-search button:hover{background:#00a896;color:#fff}

/* STAT CARDS */
.stat-section{padding:0 48px;margin-top:-40px;position:relative;z-index:10}
.stat-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.stat-card{background:#fff;border-radius:16px;padding:24px;box-shadow:0 8px 24px rgba(14,64,96,0.06);display:flex;align-items:center;justify-content:space-between;border:1px solid #e1ecf0;transition: transform 0.2s}
.stat-card:hover{transform: translateY(-2px)}
.stat-label{font-size:.76rem;color:#627d98;font-weight:600;margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em}
.stat-val{font-size:1.45rem;font-weight:800;color:#0e4060;line-height:1}
.stat-icon{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0}
.si-b{background:#e0f2fe;color:#0284c7}.si-g{background:#ccfbf1;color:#0d9488}.si-o{background:#fef3c7;color:#d97706}

/* SECTION */
.section{padding:36px 48px}
.sec-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
.sec-title{font-size:1.1rem;font-weight:800;color:#0e4060}
.sec-link{font-size:.82rem;color:#00a896;text-decoration:none;font-weight:600}

/* CARD */
.card{background:#fff;border-radius:16px;padding:24px;border:1px solid #e1ecf0;box-shadow:0 4px 12px rgba(14,64,96,0.02)}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px}
.card-title{font-size:.88rem;font-weight:700;color:#0e4060;margin-bottom:16px}

/* TABLE */
.tw{overflow-x:auto}
table{width:100%;border-collapse:collapse}
th{font-size:.72rem;font-weight:700;color:#627d98;text-transform:uppercase;letter-spacing:.05em;padding:12px 14px;border-bottom:2px solid #f0f7f9;text-align:left;white-space:nowrap}
td{padding:14px 14px;font-size:.85rem;border-bottom:1px solid #f0f7f9;color:#334e68}
tr:last-child td{border-bottom:none}
tbody tr:hover td{background:#f7fbfd}
.badge{display:inline-block;padding:4px 10px;border-radius:20px;font-size:.72rem;font-weight:700;white-space:nowrap}
.bs{background:#ccfbf1;color:#0d9488}.bw{background:#fef3c7;color:#b45309}.bd{background:#fee2e2;color:#b91c1c}

/* FOOTER */
.footer{background:#0e4060;color:rgba(255,255,255,0.65);padding:32px 48px;margin-top:40px;border-top: 4px solid #02c39a}
.footer-brand{display:flex;align-items:center;gap:10px;margin-bottom:8px}
.footer-brand strong{color:#fff;font-size:1rem}
.footer p{font-size:.8rem}

@media(max-width:768px){
  .nav{padding:0 20px}.hero{padding:50px 20px 70px}.hero h1{font-size:2rem}
  .stat-section{padding:0 20px}.stat-grid{grid-template-columns:1fr}.section{padding:24px 20px}
  .grid2{grid-template-columns:1fr}.footer{padding:24px 20px}
  .nav-links{display:none}
}
</style>
</head>
<body>

<nav class="nav">
  <a class="nav-brand" href="<?= BASE_URL ?>/index.php">
    <div class="nav-icon">🏛️</div>
    <div><div class="nav-name"><?= APP_NAME ?></div><div class="nav-sub"><?= APP_DESC ?></div></div>
  </a>
  <div class="nav-links">
    <a class="nav-a active" href="<?= BASE_URL ?>/index.php">Beranda</a>
    <a class="nav-a" href="<?= BASE_URL ?>/pages/laporan.php">Laporan</a>
    <a class="nav-a" href="<?= BASE_URL ?>/pages/grafik.php">Grafik</a>
    <a class="nav-a" href="<?= BASE_URL ?>/pages/tentang.php">Tentang</a>
    <a class="nav-btn" href="<?= BASE_URL ?>/login.php">Login Admin</a>
  </div>
</nav>

<div class="hero">
  <div class="hero-badge">📍 Desa Ampang Pulai &nbsp;•&nbsp; Tahun Anggaran <?= htmlspecialchars($desa['tahun_anggaran']) ?></div>
  <h1>Transparansi<br>Dana Desa</h1>
  <p>Mewujudkan Desa yang Akuntabel, Terbuka, dan Sejahtera untuk Seluruh Masyarakat</p>
  <form class="hero-search" action="<?= BASE_URL ?>/pages/laporan.php" method="GET">
    <input type="text" name="cari" placeholder="Cari kegiatan, kategori, atau laporan...">
    <button type="submit">🔍 Cari</button>
  </form>
</div>

<div class="stat-section">
  <div class="stat-grid">
    <div class="stat-card">
      <div class="stat-left">
        <div class="stat-label">Total Anggaran <?= htmlspecialchars($desa['tahun_anggaran']) ?></div>
        <div class="stat-val"><?= rupiah($totalAnggaran ?: $desa['total_apbdes']) ?></div>
      </div>
      <div class="stat-icon si-b">📊</div>
    </div>
    <div class="stat-card">
      <div class="stat-left">
        <div class="stat-label">Total Realisasi (Selesai)</div>
        <div class="stat-val"><?= rupiah($totalRealisasi) ?></div>
      </div>
      <div class="stat-icon si-g">💸</div>
    </div>
    <div class="stat-card">
      <div class="stat-left">
        <div class="stat-label">Serapan Anggaran</div>
        <div class="stat-val"><?= $serapan ?>%</div>
      </div>
      <div class="stat-icon si-o">📈</div>
    </div>
  </div>
</div>

<div class="section">
  <div class="grid2">
    <div class="card">
      <div class="card-title">Alokasi Anggaran per Sektor</div>
      <div style="height:260px"><canvas id="barChart"></canvas></div>
    </div>
    <div class="card">
      <div class="card-title">Sumber Pendapatan Desa</div>
      <div style="height:260px"><canvas id="pieChart"></canvas></div>
    </div>
  </div>

  <div class="card">
    <div class="sec-head" style="margin-bottom:16px">
      <span class="sec-title">Pengeluaran Terbaru</span>
      <a class="sec-link" href="<?= BASE_URL ?>/pages/laporan.php">Lihat semua →</a>
    </div>
    <div class="tw">
      <table>
        <thead><tr><th>Tanggal</th><th>Nama Kegiatan</th><th>Kategori</th><th>Jumlah</th><th>Status</th></tr></thead>
        <tbody>
          <?php foreach($recent as $r):
            $bc=['Selesai'=>'bs','Proses'=>'bw','Batal'=>'bd'];
          ?>
          <tr>
            <td><?= date('d M Y', strtotime($r['tanggal'])) ?></td>
            <td><strong><?= htmlspecialchars($r['nama_kegiatan']) ?></strong></td>
            <td><?= htmlspecialchars($r['kategori']) ?></td>
            <td><?= rupiah($r['jumlah']) ?></td>
            <td><span class="badge <?= $bc[$r['status']]??'bi' ?>"><?= htmlspecialchars($r['status']) ?></span></td>
          </tr>
          <?php endforeach; ?>
          <?php if(empty($recent)): ?>
          <tr><td colspan="5" style="text-align:center;padding:32px;color:#627d98">Belum ada data laporan publik.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<footer class="footer">
  <div class="footer-brand">
    <div class="nav-icon" style="width:30px;height:30px;font-size:.85rem">🏛️</div>
    <strong><?= APP_NAME ?></strong> — <?= APP_DESC ?>
  </div>
  <p>© <?= date('Y') ?> Pemerintah Desa Ampang Pulai. Kelompok 6 — 4A Informatika UNSIKA Karawang.</p>
</footer>

<script>
new Chart(document.getElementById('barChart'),{type:'bar',data:{
  labels:<?= json_encode(array_column($barData,'kategori')) ?>,
  datasets:[
    {label:'Anggaran',data:<?= json_encode(array_map(fn($r)=>(int)$r['anggaran'],$barData)) ?>,backgroundColor:'#becbd6',borderRadius:6},
    {label:'Realisasi',data:<?= json_encode(array_map(fn($r)=>(int)$r['realisasi'],$barData)) ?>,backgroundColor:'#0e4060',borderRadius:6}
  ]
},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom'}},scales:{y:{ticks:{callback:v=>'Rp'+(v/1e6)+'jt'},grid:{color:'#f0f7f9'}},x:{grid:{display:false}}}}});

new Chart(document.getElementById('pieChart'),{type:'doughnut',data:{
  labels:<?= json_encode(array_column($pieRows,'sumber')) ?>,
  datasets:[{data:<?= json_encode(array_map(fn($r)=>(int)$r['jumlah'],$pieRows)) ?>,backgroundColor:['#0e4060','#00a896','#f4a261'],borderWidth:3,borderColor:'#fff'}]
},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom'}},cutout:'65%'}});
</script>
</body>
</html>