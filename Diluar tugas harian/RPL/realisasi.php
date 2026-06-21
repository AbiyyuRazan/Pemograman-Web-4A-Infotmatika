<?php
$role = isset($_GET['role']) ? $_GET['role'] : 'public';
$headerTitle = 'Realisasi Dana';
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
                    <a href="realisasi.php?role=<?php echo $role; ?>" class="nav-item active"><i class="fa-solid fa-arrow-trend-up"></i> <span>Realisasi Dana</span></a>
                    <a href="laporan.php?role=<?php echo $role; ?>" class="nav-item"><i class="fa-solid fa-file-lines"></i> <span>Laporan Publik</span></a>
                </nav>

                <div class="sidebar-footer">
                    <?php if($role === 'admin'): ?>
                        <a href="index.php?role=public" class="btn-role logout"><i class="fa-solid fa-right-from-bracket"></i> Logout ke Publik</a>
                    <?php else: ?>
                        <a href="index.php?role=admin" class="btn-role login"><i class="fa-solid fa-lock"></i> Login Admin</a>
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
            </header>

            <main class="content-area">
                <?php if($role === 'admin'): ?>
                <div class="form-card">
                    <h3 id="formTitle">Catat Realisasi Pengeluaran</h3>
                    <form id="formTransaction">
                        <input type="hidden" id="editId" value="">

                        <div class="form-group">
                            <label>Nama Pengeluaran</label>
                            <input type="text" id="inputName" class="form-control" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group"><label>Tanggal</label><input type="date" id="inputDate" class="form-control" required></div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select id="inputCat" class="form-control"><option>Infrastruktur</option><option>Pendidikan</option><option>Kesehatan</option></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Terpakai (Rp)</label>
                            <input type="number" id="inputAmount" class="form-control" required>
                        </div>
                        <div style="display:flex; gap:10px;">
                            <button type="submit" id="btnSubmit" class="btn-submit" style="background:#10b981;">Simpan Realisasi</button>
                            <button type="button" id="btnCancel" class="btn-submit" style="background:#64748b; display:none;" onclick="resetForm()">Batal</button>
                        </div>
                    </form>
                </div>
                <?php endif; ?>

                <div class="table-container">
                    <div class="table-header"><h3>Daftar Realisasi Dana</h3></div>
                    <table class="main-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th><th>Kegiatan</th><th>Kategori</th><th>Status</th><th class="text-right">Jumlah</th>
                                <?php if($role === 'admin'): ?><th class="text-center">Aksi</th><?php endif; ?>
                            </tr>
                        </thead>
                        <tbody id="tableData"></tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="app.js"></script>
    <script>
        const isAdmin = <?php echo ($role === 'admin') ? 'true' : 'false'; ?>;
        let db = JSON.parse(localStorage.getItem('sitangkis_db')) || [];

        function renderTable() {
            const tbody = document.getElementById('tableData');
            tbody.innerHTML = '';
            let filtered = db.filter(tx => tx.type === 'Realisasi').reverse();
            filtered.forEach(tx => {
                let action = isAdmin ? `
                    <td class="text-center">
                        <button class="btn-action edit" style="color:#2563eb;" onclick="editData(${tx.id})" title="Edit"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn-action delete" onclick="deleteData(${tx.id})" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                    </td>` : '';
                tbody.innerHTML += `<tr><td>${tx.date}</td><td class="fw-600">${tx.name}</td><td><span class="tag-category">${tx.cat}</span></td><td><span class="badge-status status-completed">Selesai</span></td><td class="text-right fw-600">${formatRp(tx.amount)}</td>${action}</tr>`;
            });
        }

        window.editData = function(id) {
            const item = db.find(tx => tx.id === id);
            if(item) {
                document.getElementById('editId').value = item.id;
                document.getElementById('inputName').value = item.name;
                document.getElementById('inputDate').value = item.date;
                document.getElementById('inputCat').value = item.cat;
                document.getElementById('inputAmount').value = item.amount;
                
                document.getElementById('formTitle').innerText = "Edit Data Realisasi";
                document.getElementById('btnSubmit').innerText = "Update Realisasi";
                document.getElementById('btnCancel').style.display = "block";
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        window.resetForm = function() {
            document.getElementById('formTransaction').reset();
            document.getElementById('editId').value = "";
            document.getElementById('formTitle').innerText = "Catat Realisasi Pengeluaran";
            document.getElementById('btnSubmit').innerText = "Simpan Realisasi";
            document.getElementById('btnCancel').style.display = "none";
        }

        const form = document.getElementById('formTransaction');
        if(form) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const id = document.getElementById('editId').value;
                const data = {
                    date: document.getElementById('inputDate').value,
                    name: document.getElementById('inputName').value,
                    cat: document.getElementById('inputCat').value,
                    amount: parseInt(document.getElementById('inputAmount').value),
                    type: 'Realisasi'
                };

                if(id) {
                    const index = db.findIndex(tx => tx.id == id);
                    db[index] = { ...db[index], ...data };
                    alert("Realisasi Berhasil Diperbarui!");
                } else {
                    db.push({ id: Date.now(), ...data });
                    alert("Realisasi Berhasil Disimpan!");
                }

                localStorage.setItem('sitangkis_db', JSON.stringify(db));
                resetForm(); 
                renderTable();
            });
        }

        window.deleteData = function(id) {
            if(confirm('Hapus realisasi ini secara permanen?')) { 
                db = db.filter(tx => tx.id !== id); 
                localStorage.setItem('sitangkis_db', JSON.stringify(db)); 
                renderTable(); 
            }
        }

        renderTable();
    </script>
</body>
</html>