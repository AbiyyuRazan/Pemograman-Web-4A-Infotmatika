<?php
// pages/tentang.php
require_once __DIR__ . '/../config/app.php';
$pageTitle  = 'Tentang';
$activePage = 'tentang';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="page-wrap">
  <div class="section" style="max-width:820px">
    <div class="page-header">
      <h2>Tentang SITANGKIS</h2>
      <p>Sistem Transparansi Keuangan Desa — UNSIKA Karawang</p>
    </div>

    <div class="card" style="margin-bottom:20px">
      <h3>Apa itu SITANGKIS?</h3>
      <p style="color:var(--text-muted);line-height:1.75;font-size:.95rem">
        <strong>SITANGKIS</strong> (Sistem Transparansi Keuangan Desa) adalah platform web yang membantu pemerintah desa dalam melakukan input anggaran, mencatat realisasi dana, serta menyajikan laporan publik dan grafik visualisasi agar mudah dipahami masyarakat. Sistem ini dikembangkan menggunakan pendekatan <em>User-Centered Design</em>.
      </p>
    </div>

    <div class="card" style="margin-bottom:20px">
      <h3>Pengguna Sistem</h3>
      <div class="grid-2" style="margin-bottom:0">
        <?php
        $pengguna = [
          ['🏦','Bendahara Desa','Mengelola dan menginput data anggaran desa'],
          ['📋','Sekretaris Desa','Mengelola anggaran, realisasi, laporan publik & grafik'],
          ['👨‍💼','Kepala Desa','Validasi dan persetujuan realisasi dana'],
          ['👥','Masyarakat Umum','Melihat laporan publik dan grafik visualisasi'],
        ];
        foreach ($pengguna as [$icon,$nama,$desc]):
        ?>
        <div style="padding:16px;background:var(--bg);border-radius:10px;border:1px solid var(--border)">
          <div style="font-weight:700;margin-bottom:6px"><?= $icon ?> <?= $nama ?></div>
          <div style="font-size:.84rem;color:var(--text-muted)"><?= $desc ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="card" style="margin-bottom:20px">
      <h3>Fitur Utama</h3>
      <div style="display:flex;flex-wrap:wrap;gap:10px">
        <?php
        $fitur = ['Login Multi-Role','Kelola Anggaran (CRUD)','Catat Realisasi Dana','Validasi Kepala Desa',
                  'Laporan Publik','Grafik Visualisasi Real-time','Ekspor CSV','Responsif Mobile'];
        foreach ($fitur as $f): ?>
        <span class="chip chip-blue">✅ <?= $f ?></span>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="card">
      <h3>Teknologi yang Digunakan</h3>
      <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:16px">
        <?php
        $tech = [
          ['PHP 8+','chip-blue'],['MySQL','chip-yellow'],['HTML5 + CSS3','chip-green'],
          ['JavaScript (ES6)','chip-green'],['Chart.js','chip-purple'],['Vercel / Netlify','chip-red'],
          ['GitHub','chip-blue'],['VSCode','chip-purple'],
        ];
        foreach ($tech as [$t,$c]): ?>
        <span class="chip <?= $c ?>"><?= $t ?></span>
        <?php endforeach; ?>
      </div>
      <p style="font-size:.83rem;color:var(--text-muted)">
        Dikembangkan oleh <strong>Kelompok 6, Kelas 4A Informatika — UNSIKA Karawang</strong>
      </p>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
