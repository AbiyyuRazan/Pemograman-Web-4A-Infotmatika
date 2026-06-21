<?php
$role = isset($_GET['role']) ? $_GET['role'] : 'public';
$headerTitle = 'Laporan Publik';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITANGKIS | <?php echo $headerTitle; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="app-layout">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-content">
                <div class="logo-area">
                    <div class="logo-wrapper"><div class="logo-glow"></div><div class="logo-icon"><i class="fa-solid fa-shield-halved"></i></div></div>
                    <div class="logo-text">
                        <h1 class="text-gradient">SITANGKIS</h1>
                        <p><?php echo ($role === 'admin') ? 'Editor Mode' : 'Spectator Mode'; ?></p>
                    </div>
                </div>

                <nav class="nav-menu">
                    <a href="index.php?role=<?php echo $role; ?>" class="nav-item"><i class="fa-solid fa-table-columns"></i> <span>Dashboard</span></a>
                    <a href="anggaran.php?role=<?php echo $role; ?>" class="nav-item"><i class="fa-solid fa-wallet"></i> <span>Kelola Anggaran</span></a>
                    <a href="realisasi.php?role=<?php echo $role; ?>" class="nav-item"><i class="fa-solid fa-arrow-trend-up"></i> <span>Realisasi Dana</span></a>
                    <a href="laporan.php?role=<?php echo $role; ?>" class="nav-item active"><i class="fa-solid fa-file-lines"></i> <span>Laporan Publik</span></a>
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

                <div id="viewGridLaporan">
                    
                    <div class="hero-section">
                        <div class="hero-content">
                            <h1>Transparansi Dana Desa</h1>
                            <p>Pantau langsung perkembangan infrastruktur dan program pemberdayaan. Kami mewujudkan desa yang akuntabel dan terbuka untuk seluruh warga.</p>
                        </div>
                    </div>

                    <div class="search-wrapper">
                        <div class="search-input-group">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="searchInput" placeholder="Cari laporan proyek atau kegiatan desa...">
                        </div>

                        <div class="filter-group">
                            <button class="filter-btn active" onclick="filterData('All', this)">Semua Laporan</button>
                            <button class="filter-btn" onclick="filterData('Infrastruktur', this)">Infrastruktur</button>
                            <button class="filter-btn" onclick="filterData('Pendidikan', this)">Pendidikan</button>
                            <button class="filter-btn" onclick="filterData('Kesehatan', this)">Kesehatan</button>
                            <button class="filter-btn" onclick="filterData('Pemberdayaan', this)">Pemberdayaan</button>
                        </div>
                    </div>

                    <div class="report-grid" id="gridContainer">
                        </div>

                    <?php if($role === 'admin'): ?>
                    <div class="form-card" id="cardFormAdmin">
                        <h3 id="formLapTitle">Publish Laporan Baru</h3>
                        <p style="font-size: 14px; color:#64748b; margin-bottom: 24px;">Lengkapi detail di bawah ini untuk menerbitkan laporan publik.</p>
                        
                        <form id="formUploadLaporan">
                            <input type="hidden" id="editLapId" value="">

                            <div class="form-group" style="background:#f8fafc; padding:16px; border-radius:12px; border:1px dashed #cbd5e1;">
                                <label style="color:#334155;"><i class="fa-solid fa-wand-magic-sparkles" style="color:#3b82f6;"></i> Opsi Auto-Fill: Tarik dari Data Transaksi</label>
                                <select id="upSelectTx" class="form-control" style="background: white;">
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Judul Laporan</label>
                                <input type="text" id="upTitle" class="form-control" placeholder="Contoh: Penyelesaian Jalan RT 05..." required>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group"><label>Tanggal Publikasi</label><input type="date" id="upDate" class="form-control" required></div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select id="upCat" class="form-control">
                                        <option>Infrastruktur</option>
                                        <option>Pendidikan</option>
                                        <option>Kesehatan</option>
                                        <option>Pemberdayaan</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Ringkasan Laporan (Tampil di Kartu)</label>
                                <input type="text" id="upShort" class="form-control" placeholder="Tuliskan intisari kegiatan dalam 1-2 kalimat..." required>
                            </div>
                            
                            <div class="form-group">
                                <label>Isi Lengkap Laporan</label>
                                <textarea id="upLong" class="form-control" placeholder="Tuliskan rincian, proses pengerjaan, hingga hasil proyek di sini..." required></textarea>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Link Gambar Dokumentasi</label>
                                    <input type="text" id="upImg" class="form-control" placeholder="https://contoh.com/gambar-proyek.jpg">
                                </div>
                                <div class="form-group">
                                    <label>Upload Bukti Dokumen (PDF)</label>
                                    <input type="file" id="upPdf" class="form-control" style="padding: 11px;" accept=".pdf">
                                </div>
                            </div>
                            
                            <div style="display:flex; gap:12px; margin-top: 24px;">
                                <button type="submit" id="btnLapSubmit" class="btn-submit" style="flex:1;">Publish Laporan</button>
                                <button type="button" id="btnLapCancel" class="btn-submit" style="background:#f1f5f9; color:#0f172a; flex:1; display:none;" onclick="resetFormLaporan()">Batal Edit</button>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>

                <div id="viewDetailLaporan" style="display: none;">
                    <div class="detail-container">
                        <div class="btn-back-detail" onclick="kembaliKeGrid()">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Laporan
                        </div>
                        
                        <div class="detail-header-text">
                            <h1 id="detailTitle" class="detail-title"></h1>
                            <div class="detail-meta">
                                <span id="detailCat"><i class="fa-solid fa-tag"></i> Kategori</span>
                                <span id="detailDate"><i class="fa-regular fa-calendar"></i> Tanggal</span>
                            </div>
                        </div>

                        <img id="detailHeroImage" class="detail-cover" src="" alt="Cover Laporan">

                        <div class="detail-body-text" id="detailDesc"></div>
                        
                        <div class="download-box">
                            <div class="download-info">
                                <h4>Dokumen Lampiran Transparansi</h4>
                                <p>Unduh dokumen kelengkapan laporan, berita acara, atau kuitansi realisasi.</p>
                            </div>
                            <button class="btn-download-pdf" onclick="alert('File Laporan sedang diunduh ke perangkat Anda...')">
                                <i class="fa-solid fa-file-pdf"></i> Unduh Dokumen (PDF)
                            </button>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script src="app.js"></script>
    <script>
        const isAdmin = <?php echo ($role === 'admin') ? 'true' : 'false'; ?>;

        // MENGAMBIL DATA TRANSAKSI UNTUK AUTO-FILL
        let dbTrans = JSON.parse(localStorage.getItem('sitangkis_db')) || [];
        const selectTx = document.getElementById('upSelectTx');
        if (selectTx) {
            selectTx.innerHTML = '<option value="">-- Pilih untuk Auto-Fill (Opsional) --</option>';
            dbTrans.slice().reverse().forEach(tx => {
                selectTx.innerHTML += `<option value="${tx.id}" data-title="${tx.name}" data-date="${tx.date}" data-cat="${tx.cat}">
                    ${tx.date} - ${tx.name} (${tx.type})
                </option>`;
            });

            selectTx.addEventListener('change', function() {
                const opt = this.options[this.selectedIndex];
                if(opt.value) {
                    document.getElementById('upTitle').value = opt.getAttribute('data-title');
                    document.getElementById('upDate').value = opt.getAttribute('data-date');
                    document.getElementById('upCat').value = opt.getAttribute('data-cat');
                }
            });
        }

        // DATABASE LAPORAN PUBLIK
        const defaultReports = [
            {
                id: 1,
                title: 'Pembangunan Jalan Utama Desa RT 05 Rampung 100%',
                date: '2026-03-28',
                cat: 'Infrastruktur',
                img: 'https://images.unsplash.com/photo-1541888053-ce207fb31b14?auto=format&fit=crop&w=800&q=80',
                shortDesc: 'Jalan utama di wilayah RT 05 telah selesai dikerjakan dengan kualitas aspal terbaik.',
                longDesc: 'Pembangunan jalan utama di RT 05 telah berhasil diselesaikan dengan baik dan mencapai target pengerjaan 100%.\n\nTotal dana yang digunakan sebesar Rp 125.000.000. Pengerjaan dilakukan secara padat karya, melibatkan warga setempat secara langsung untuk meningkatkan pendapatan ekonomi warga.'
            }
        ];

        let dbLaporan = JSON.parse(localStorage.getItem('sitangkis_reports_v3'));
        if(!dbLaporan) { dbLaporan = defaultReports; localStorage.setItem('sitangkis_reports_v3', JSON.stringify(dbLaporan)); }

        function formatModernDate(dateStr) {
            const d = new Date(dateStr);
            const day = d.getDate().toString().padStart(2, '0');
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
            const month = monthNames[d.getMonth()];
            const year = d.getFullYear();
            return `${day} ${month} ${year}`;
        }

        function renderGrid(dataToRender) {
            const container = document.getElementById('gridContainer');
            container.innerHTML = '';
            
            dataToRender.slice().reverse().forEach(rep => {
                const cleanDate = formatModernDate(rep.date);
                const defaultImg = "https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=800&q=80";

                let actionHtml = '';
                if(isAdmin) {
                    actionHtml = `
                    <div class="card-actions-wrapper">
                        <button class="btn-edit-card" onclick="event.stopPropagation(); editLaporan(${rep.id})"><i class="fa-solid fa-pen"></i> Edit</button>
                        <button class="btn-delete-card" onclick="event.stopPropagation(); hapusLaporan(${rep.id})"><i class="fa-solid fa-trash"></i> Hapus</button>
                    </div>`;
                }

                container.innerHTML += `
                    <div class="report-card" onclick="bukaDetail(${rep.id})">
                        <div class="report-img-wrapper">
                            <img src="${rep.img}" onerror="this.src='${defaultImg}'" alt="Cover">
                            <div class="badge-date"><i class="fa-regular fa-calendar"></i> ${cleanDate}</div>
                        </div>
                        <div class="report-content">
                            <div class="tag-category" style="align-self: flex-start; margin-bottom: 12px;">${rep.cat}</div>
                            <h3 class="report-title">${rep.title}</h3>
                            <p class="report-desc">${rep.shortDesc}</p>
                        </div>
                        ${actionHtml}
                    </div>
                `;
            });
        }

        // FUNGSI KLIK DETAIL
        window.bukaDetail = function(id) {
            const rep = dbLaporan.find(r => r.id === id);
            if(rep) {
                document.getElementById('viewGridLaporan').style.display = 'none';
                
                document.getElementById('detailHeroImage').src = rep.img;
                document.getElementById('detailTitle').innerText = rep.title;
                document.getElementById('detailCat').innerHTML = `<i class="fa-solid fa-tag"></i> ${rep.cat}`;
                document.getElementById('detailDate').innerHTML = `<i class="fa-regular fa-calendar"></i> ${formatModernDate(rep.date)}`;
                document.getElementById('detailDesc').innerText = rep.longDesc;
                
                document.getElementById('viewDetailLaporan').style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        window.kembaliKeGrid = function() {
            document.getElementById('viewDetailLaporan').style.display = 'none';
            document.getElementById('viewGridLaporan').style.display = 'block';
        }

        // FUNGSI EDIT LAPORAN
        window.editLaporan = function(id) {
            const rep = dbLaporan.find(r => r.id === id);
            if(rep) {
                document.getElementById('editLapId').value = rep.id;
                document.getElementById('upTitle').value = rep.title;
                document.getElementById('upDate').value = rep.date;
                document.getElementById('upCat').value = rep.cat;
                document.getElementById('upShort').value = rep.shortDesc;
                document.getElementById('upLong').value = rep.longDesc;
                document.getElementById('upImg').value = rep.img;
                
                document.getElementById('formLapTitle').innerText = "Edit Laporan Publik";
                document.getElementById('btnLapSubmit').innerText = "Simpan Perubahan";
                document.getElementById('btnLapCancel').style.display = "block";
                document.getElementById('upSelectTx').value = "";

                document.getElementById('cardFormAdmin').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // FUNGSI HAPUS LAPORAN
        window.hapusLaporan = function(id) {
            if(confirm('Yakin ingin menghapus laporan ini dari publik?')) {
                dbLaporan = dbLaporan.filter(r => r.id !== id);
                localStorage.setItem('sitangkis_reports_v3', JSON.stringify(dbLaporan));
                renderGrid(dbLaporan);
            }
        }

        // FUNGSI RESET FORM
        window.resetFormLaporan = function() {
            const formUpload = document.getElementById('formUploadLaporan');
            if(formUpload) {
                formUpload.reset();
                document.getElementById('editLapId').value = "";
                document.getElementById('formLapTitle').innerText = "Publish Laporan Baru";
                document.getElementById('btnLapSubmit').innerText = "Publish Laporan";
                document.getElementById('btnLapCancel').style.display = "none";
            }
        }

        // FUNGSI FILTER SEARCH
        window.filterData = function(cat, btnElement) {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btnElement.classList.add('active');
            let filtered = (cat === 'All') ? dbLaporan : dbLaporan.filter(r => r.cat === cat);
            renderGrid(filtered);
        }

        document.getElementById('searchInput').addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            renderGrid(dbLaporan.filter(r => r.title.toLowerCase().includes(term) || r.shortDesc.toLowerCase().includes(term)));
        });

        // PROSES FORM UPLOAD / UPDATE
        const formUpload = document.getElementById('formUploadLaporan');
        if(formUpload) {
            formUpload.addEventListener('submit', (e) => {
                e.preventDefault();
                
                let imgInput = document.getElementById('upImg').value;
                if(!imgInput) imgInput = 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=800&q=80';

                const idEdit = document.getElementById('editLapId').value;
                const dataObj = {
                    title: document.getElementById('upTitle').value,
                    date: document.getElementById('upDate').value,
                    cat: document.getElementById('upCat').value,
                    shortDesc: document.getElementById('upShort').value,
                    longDesc: document.getElementById('upLong').value,
                    img: imgInput
                };

                if(idEdit) {
                    const index = dbLaporan.findIndex(r => r.id == idEdit);
                    dbLaporan[index] = { ...dbLaporan[index], ...dataObj };
                    alert('Laporan berhasil diperbarui!');
                } else {
                    dbLaporan.push({ id: Date.now(), ...dataObj });
                    alert('Laporan berhasil dipublikasikan!');
                }
                
                localStorage.setItem('sitangkis_reports_v3', JSON.stringify(dbLaporan));
                resetFormLaporan(); 
                renderGrid(dbLaporan); 
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        // Init Grid
        renderGrid(dbLaporan);
    </script>
</body>
</html>