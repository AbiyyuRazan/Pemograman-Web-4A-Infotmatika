<?php
// pages/laporan.php — Laporan Publik
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

$pageTitle  = 'Laporan Publik';
$activePage = 'laporan';

$db = getDB();

// Filter
$tahun  = (int)($_GET['tahun'] ?? date('Y'));
$kat    = $_GET['kat'] ?? '';
$cari   = trim($_GET['cari'] ?? '');
$status = $_GET['status'] ?? '';

// Build query
$where  = ["is_publik = 1", "YEAR(tanggal) = ?"];
$params = [$tahun];

if ($kat) { $where[] = "kategori = ?"; $params[] = $kat; }
if ($cari){ $where[] = "nama_kegiatan LIKE ?"; $params[] = "%$cari%"; }
if ($status){ $where[] = "status = ?"; $params[] = $status; }

$sql  = "SELECT * FROM realisasi WHERE " . implode(' AND ', $where) . " ORDER BY tanggal DESC";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

// Ekspor CSV
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=laporan-sitangkis-' . $tahun . '.csv');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['No','Tanggal','Nama Kegiatan','Kategori','Jumlah (Rp)','Status']);
    foreach ($rows as $i => $r) {
        fputcsv($out, [
            $i+1,
            date('d/m/Y', strtotime($r['tanggal'])),
            $r['nama_kegiatan'],
            $r['kategori'],
            $r['jumlah'],
            $r['status']
        ]);
    }
    fclose($out);
    exit;
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-wrap">
  <div class="section">
    <div class="page-header">
      <h2>Laporan Publik</h2>
      <p>Data keuangan desa yang terbuka dan dapat diakses oleh seluruh masyarakat</p>
    </div>

    <!-- Filter -->
    <form method="GET" action="">
      <div class="filter-bar">
        <select name="tahun" onchange="this.form.submit()">
          <?php foreach ([2026,2025,2024] as $y): ?>
          <option value="<?= $y ?>" <?= $tahun==$y?'selected':'' ?>><?= $y ?></option>
          <?php endforeach; ?>
        </select>

        <select name="kat" onchange="this.form.submit()">
          <option value="">Semua Kategori</option>
          <?php foreach (['Infrastruktur','Pendidikan','Kesehatan','Administrasi','Pemberdayaan'] as $k): ?>
          <option value="<?= $k ?>" <?= $kat===$k?'selected':'' ?>><?= $k ?></option>
          <?php endforeach; ?>
        </select>

        <select name="status" onchange="this.form.submit()">
          <option value="">Semua Status</option>
          <option value="Selesai" <?= $status==='Selesai'?'selected':'' ?>>Selesai</option>
          <option value="Proses"  <?= $status==='Proses'?'selected':'' ?>>Proses</option>
          <option value="Batal"   <?= $status==='Batal'?'selected':'' ?>>Batal</option>
        </select>

        <input type="search" name="cari" placeholder="🔍 Cari kegiatan..." value="<?= clean($cari) ?>">
        <button type="submit" class="btn btn-primary btn-sm">Cari</button>

        <div class="ml-auto" style="display:flex;gap:8px">
          <?php if ($cari || $kat || $status): ?>
          <a href="laporan.php?tahun=<?= $tahun ?>" class="btn btn-warning btn-sm">✕ Reset</a>
          <?php endif; ?>
          <a href="?<?= http_build_query(array_merge($_GET, ['export'=>'csv'])) ?>"
             class="btn btn-success btn-sm">⬇️ Unduh CSV</a>
        </div>
      </div>
    </form>

    <div class="card">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
        <h3 style="border:none;padding:0;margin:0">
          Transaksi <?= $tahun ?><?= $kat?" — $kat":'' ?>
        </h3>
        <span style="font-size:.82rem;color:var(--text-muted)"><?= count($rows) ?> data ditemukan</span>
      </div>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Tanggal</th>
              <th>Nama Kegiatan</th>
              <th>Kategori</th>
              <th>Jumlah</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $i => $r):
              $bc = ['Selesai'=>'badge-success','Proses'=>'badge-warning','Batal'=>'badge-danger'];
            ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td><?= date('d M Y', strtotime($r['tanggal'])) ?></td>
              <td><strong><?= clean($r['nama_kegiatan']) ?></strong></td>
              <td><?= clean($r['kategori']) ?></td>
              <td><?= rupiah($r['jumlah']) ?></td>
              <td><span class="badge <?= $bc[$r['status']] ?? 'badge-info' ?>"><?= $r['status'] ?></span></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($rows)): ?>
            <tr><td colspan="6" style="text-align:center;padding:32px;color:var(--text-muted)">
              Tidak ada data yang cocok dengan filter.
            </td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
