<?php
// pages/grafik.php — Visualisasi Keuangan Publik
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

$pageTitle  = 'Grafik Visualisasi';
$activePage = 'grafik';

$db   = getDB();
$year = (int)($_GET['tahun'] ?? date('Y'));

// Bar chart: anggaran vs realisasi per kategori
$barStmt = $db->prepare(
  "SELECT a.kategori,
          a.jumlah AS anggaran,
          COALESCE(SUM(r.jumlah),0) AS realisasi
   FROM anggaran a
   LEFT JOIN realisasi r ON r.kategori=a.kategori AND r.status='Selesai' AND YEAR(r.tanggal)=?
   WHERE a.tahun=?
   GROUP BY a.kategori, a.jumlah"
);
$barStmt->execute([$year, $year]);
$barData = $barStmt->fetchAll();

// Pie: sumber pendapatan
$pieData = $db->prepare("SELECT sumber, jumlah FROM sumber_pendapatan WHERE tahun=?")->execute([$year]);
$pieRows = $db->prepare("SELECT sumber, jumlah FROM sumber_pendapatan WHERE tahun=?");
$pieRows->execute([$year]);
$pieData = $pieRows->fetchAll();

// Line chart: realisasi per bulan
$lineStmt = $db->prepare(
  "SELECT MONTH(tanggal) AS bln, SUM(jumlah) AS total
   FROM realisasi WHERE YEAR(tanggal)=? AND status='Selesai'
   GROUP BY MONTH(tanggal) ORDER BY bln"
);
$lineStmt->execute([$year]);
$lineRaw = $lineStmt->fetchAll();

// Isi 12 bulan, yang tidak ada diisi 0
$lineData = array_fill(1, 12, 0);
foreach ($lineRaw as $row) $lineData[$row['bln']] = (int)$row['total'];

// Serapan per kategori
$serapanStmt = $db->prepare(
  "SELECT a.kategori, a.jumlah AS anggaran,
          COALESCE(SUM(r.jumlah),0) AS realisasi
   FROM anggaran a
   LEFT JOIN realisasi r ON r.kategori=a.kategori AND r.status='Selesai' AND YEAR(r.tanggal)=?
   WHERE a.tahun=?
   GROUP BY a.kategori, a.jumlah"
);
$serapanStmt->execute([$year, $year]);
$serapan = $serapanStmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-wrap">
  <div class="section">
    <div class="page-header" style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px">
      <div>
        <h2>Visualisasi Keuangan</h2>
        <p>Representasi visual data keuangan desa untuk kemudahan pemahaman masyarakat</p>
      </div>
      <form method="GET">
        <select name="tahun" onchange="this.form.submit()" style="padding:9px 14px;border:1.5px solid var(--border);border-radius:9px;font-family:inherit;font-size:.88rem">
          <?php foreach ([2026,2025,2024] as $y): ?>
          <option value="<?= $y ?>" <?= $year==$y?'selected':'' ?>><?= $y ?></option>
          <?php endforeach; ?>
        </select>
      </form>
    </div>

    <div class="grid-2">
      <div class="card">
        <h3>Anggaran vs Realisasi per Sektor</h3>
        <div style="height:280px"><canvas id="barChart"></canvas></div>
      </div>
      <div class="card">
        <h3>Komposisi Sumber Pendapatan</h3>
        <div style="height:280px"><canvas id="pieChart"></canvas></div>
      </div>
      <div class="card">
        <h3>Tren Realisasi Bulanan <?= $year ?></h3>
        <div style="height:280px"><canvas id="lineChart"></canvas></div>
      </div>
      <div class="card">
        <h3>Serapan Anggaran per Sektor</h3>
        <?php foreach ($serapan as $s):
          $pct = $s['anggaran'] > 0 ? round(($s['realisasi']/$s['anggaran'])*100, 1) : 0;
        ?>
        <div class="progress-item">
          <div class="progress-header">
            <span class="progress-label"><?= $s['kategori'] ?></span>
            <span class="progress-pct"><?= $pct ?>%</span>
          </div>
          <div class="progress-bar">
            <div class="progress-fill" style="width:<?= min($pct,100) ?>%"></div>
          </div>
          <div class="progress-amounts">
            <span><?= rupiah($s['realisasi']) ?></span>
            <span><?= rupiah($s['anggaran']) ?></span>
          </div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($serapan)): ?>
        <p style="color:var(--text-muted);font-size:.88rem">Belum ada data anggaran.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

<script>
const bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

makeBarChart('barChart',
  <?= json_encode(array_column($barData,'kategori')) ?>,
  [
    { label:'Anggaran',  data:<?= json_encode(array_map(fn($r)=>(int)$r['anggaran'], $barData)) ?>,  backgroundColor:'#1a3a6b', borderRadius:6 },
    { label:'Realisasi', data:<?= json_encode(array_map(fn($r)=>(int)$r['realisasi'], $barData)) ?>, backgroundColor:'#2a9d8f', borderRadius:6 }
  ]
);

makePieChart('pieChart',
  <?= json_encode(array_column($pieData,'sumber')) ?>,
  <?= json_encode(array_map(fn($r)=>(int)$r['jumlah'], $pieData)) ?>,
  ['#1a3a6b','#2a9d8f','#f4a261','#e63946']
);

makeLineChart('lineChart', bulan, <?= json_encode(array_values($lineData)) ?>.map(v => Math.round(v/1e6)));
</script>
