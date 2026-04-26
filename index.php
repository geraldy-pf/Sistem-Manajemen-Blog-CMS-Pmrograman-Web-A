<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4caf50;
            /* Green from the Tambah button */
            --edit-blue: #2196f3;
            --delete-red: #f44336;
            --header-bg: #34495e;
            --body-bg: #f4f7f6;
            --text-dark: #333;
            --text-muted: #888;
            --sidebar-active-bg: #f1f8f1;
            --sidebar-active-border: #4caf50;
            --sidebar-active-text: #2e7d32;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Open Sans', sans-serif;
        }

        body {
            background-color: var(--body-bg);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: var(--header-bg);
            color: white;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header-icon {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px;
            border-radius: 8px;
            font-size: 1.2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-titles h1 {
            font-size: 1.1rem;
            margin: 0;
        }

        .header-titles p {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        .layout {
            display: flex;
            padding: 30px;
            gap: 30px;
            flex: 1;
        }

        .sidebar {
            width: 250px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 20px 0;
            height: fit-content;
        }

        .sidebar h3 {
            padding: 0 25px 15px;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #bbb;
            letter-spacing: 1px;
        }

        .nav-item {
            list-style: none;
        }

        .nav-link {
            padding: 12px 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            cursor: pointer;
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }

        .nav-link:hover {
            background: #f9f9f9;
        }

        .nav-link.active {
            background: var(--sidebar-active-bg);
            border-left-color: var(--sidebar-active-border);
            color: var(--sidebar-active-text);
            font-weight: 600;
        }

        .main-content {
            flex: 1;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .content-header h2 {
            font-size: 1.4rem;
            color: var(--text-dark);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .btn-add {
            background: var(--primary);
            color: white;
        }

        .btn-add:hover {
            background: #43a047;
        }

        .btn-edit {
            background: var(--edit-blue);
            color: white;
        }

        .btn-delete {
            background: var(--delete-red);
            color: white;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            font-size: 0.75rem;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px;
            border-bottom: 2px solid #f4f7f6;
        }

        td {
            padding: 20px 15px;
            border-bottom: 1px solid #f4f7f6;
            font-size: 0.9rem;
            color: #444;
            vertical-align: middle;
        }

        .img-thumb {
            width: 50px;
            height: 50px;
            border-radius: 6px;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            color: #999;
            object-fit: cover;
        }

        .badge-user {
            background: #e3f2fd;
            color: #1976d2;
            padding: 4px 10px;
            border-radius: 4px;
            font-family: monospace;
        }

        .hash-placeholder {
            color: #ccc;
            font-size: 0.8rem;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal {
            background: white;
            width: 500px;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
        }

        .btn-cancel {
            background: #aaa;
            color: white;
        }

        #alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
    </style>
</head>

<body>

    <header>
        <div class="header-icon"><i class="fas fa-th-large"></i></div>
        <div class="header-titles">
            <h1>Sistem Manajemen Blog (CMS)</h1>
            <p>Blog Keren</p>
        </div>
    </header>

    <div class="layout">
        <aside class="sidebar">
            <h3>Menu Utama</h3>
            <div class="nav-item">
                <a class="nav-link active" id="nav-penulis" onclick="switchTab('penulis')">
                    <i class="far fa-user"></i> Kelola Penulis
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link" id="nav-artikel" onclick="switchTab('artikel')">
                    <i class="far fa-file-alt"></i> Kelola Artikel
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link" id="nav-kategori" onclick="switchTab('kategori')">
                    <i class="far fa-folder"></i> Kelola Kategori
                </a>
            </div>
        </aside>

        <main class="main-content">
            <div class="content-header">
                <h2 id="content-title">Data Penulis</h2>
                <div id="action-btn-container"></div>
            </div>

            <div class="card" id="data-container">
                <!-- tabel -->
            </div>
        </main>
    </div>

    <div class="modal-overlay" id="modal-overlay">
        <div class="modal">
            <h3 id="modal-title" style="margin-bottom: 25px;">Tambah Data</h3>
            <form id="main-form">
                <div id="form-fields"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn btn-add" id="btn-submit">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="delete-overlay">
        <div class="modal" style="width: 400px; text-align: center;">
            <div
                style="background: #fff5f5; color: #f44336; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 1.5rem;">
                <i class="far fa-trash-alt"></i>
            </div>
            <h3 style="margin-bottom: 10px;">Hapus data ini?</h3>
            <p style="color: #888; font-size: 0.9rem; margin-bottom: 30px;">Data yang dihapus tidak dapat dikembalikan.
            </p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button class="btn btn-cancel" onclick="closeDeleteModal()"
                    style="background: #ddd; color: #444;">Batal</button>
                <button class="btn btn-delete" id="btn-confirm-delete">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <div id="alert-container"></div>

    <script>
        let currentState = 'penulis';

        window.onload = () => switchTab('penulis');

        function switchTab(tab) {
            currentState = tab;
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            document.getElementById('nav-' + tab).classList.add('active');

            const titles = { penulis: 'Data Penulis', artikel: 'Data Artikel', kategori: 'Data Kategori Artikel' };
            const btnTexts = { penulis: '+ Tambah Penulis', artikel: '+ Tambah Artikel', kategori: '+ Tambah Kategori' };

            document.getElementById('content-title').innerText = titles[tab];
            document.getElementById('action-btn-container').innerHTML = `<button class="btn btn-add" onclick="openModal()">${btnTexts[tab]}</button>`;

            if (tab === 'penulis') loadPenulis();
            else if (tab === 'artikel') loadArtikel();
            else if (tab === 'kategori') loadKategori();
        }

        async function loadPenulis() {
            const res = await fetch('penulis/ambil_penulis.php');
            const data = await res.json();
            let html = `<table><thead><tr><th>Foto</th><th>Nama</th><th>Username</th><th>Password</th><th>Aksi</th></tr></thead><tbody>`;
            data.forEach(p => {
                html += `<tr>
                    <td><img src="upload_penulis/${p.foto}" class="img-thumb" onerror="this.src='upload_penulis/default.png'"></td>
                    <td style="font-weight:600">${p.nama_depan} ${p.nama_belakang}</td>
                    <td><span class="badge-user">${p.user_name}</span></td>
                    <td class="hash-placeholder">$2y$10$abc...</td>
                    <td>
                        <div style="display:flex; gap:8px">
                            <button class="btn btn-edit" onclick="openModal(${p.id})">Edit</button>
                            <button class="btn btn-delete" onclick="confirmDelete('penulis', ${p.id})">Hapus</button>
                        </div>
                    </td>
                </tr>`;
            });
            document.getElementById('data-container').innerHTML = html + `</tbody></table>`;
        }

        async function loadKategori() {
            const res = await fetch('kategori/ambil_kategori.php');
            const data = await res.json();
            let html = `<table><thead><tr><th>Nama Kategori</th><th>Keterangan</th><th>Aksi</th></tr></thead><tbody>`;
            data.forEach(k => {
                html += `<tr>
                    <td style="font-weight:600"><span class="badge-user" style="background:#e8f5e9; color:#2e7d32">${k.nama_kategori}</span></td>
                    <td style="color:#666">${k.keterangan || '-'}</td>
                    <td>
                        <div style="display:flex; gap:8px">
                            <button class="btn btn-edit" onclick="openModal(${k.id})">Edit</button>
                            <button class="btn btn-delete" onclick="confirmDelete('kategori', ${k.id})">Hapus</button>
                        </div>
                    </td>
                </tr>`;
            });
            document.getElementById('data-container').innerHTML = html + `</tbody></table>`;
        }

        async function loadArtikel() {
            const res = await fetch('artikel/ambil_artikel.php');
            const data = await res.json();
            let html = `<table><thead><tr><th>Gambar</th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Tanggal</th><th>Aksi</th></tr></thead><tbody>`;
            data.forEach(a => {
                html += `<tr>
                    <td><img src="upload_artikel/${a.gambar}" class="img-thumb"></td>
                    <td style="font-weight:600; max-width: 250px;">${a.judul}</td>
                    <td><span class="badge-user" style="background:#e3f2fd; color:#1976d2">${a.nama_kategori}</span></td>
                    <td>${a.nama_depan} ${a.nama_belakang}</td>
                    <td style="font-size:0.75rem; color:#888">${a.hari_tanggal}</td>
                    <td>
                        <div style="display:flex; gap:8px">
                            <button class="btn btn-edit" onclick="openModal(${a.id})">Edit</button>
                            <button class="btn btn-delete" onclick="confirmDelete('artikel', ${a.id})">Hapus</button>
                        </div>
                    </td>
                </tr>`;
            });
            document.getElementById('data-container').innerHTML = html + `</tbody></table>`;
        }

        async function openModal(id = null) {
            const fields = document.getElementById('form-fields');
            const title = document.getElementById('modal-title');
            const btnSubmit = document.getElementById('btn-submit');

            title.innerText = (id ? 'Edit ' : 'Tambah ') + (currentState === 'penulis' ? 'Penulis' : currentState === 'artikel' ? 'Artikel' : 'Kategori');
            btnSubmit.innerText = id ? 'Simpan Perubahan' : 'Simpan Data';

            let data = {};
            if (id) {
                const res = await fetch(`${currentState}/ambil_satu_${currentState}.php?id=${id}`);
                data = await res.json();
            }

            if (currentState === 'penulis') {
                fields.innerHTML = `
                    <input type="hidden" name="id" value="${data.id || ''}">
                    <div style="display:flex; gap:20px">
                        <div class="form-group" style="flex:1">
                            <label style="color:#666">Nama Depan</label>
                            <input type="text" name="nama_depan" class="form-control" required value="${data.nama_depan || ''}" placeholder="Ahmad">
                        </div>
                        <div class="form-group" style="flex:1">
                            <label style="color:#666">Nama Belakang</label>
                            <input type="text" name="nama_belakang" class="form-control" value="${data.nama_belakang || ''}" placeholder="Fauzi">
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="color:#666">Username</label>
                        <input type="text" name="user_name" class="form-control" required value="${data.user_name || ''}" placeholder="ahmad_f">
                    </div>
                    <div class="form-group">
                        <label style="color:#666">${id ? 'Password Baru (kosongkan jika tidak diganti)' : 'Password'}</label>
                        <input type="password" name="password" class="form-control" ${id ? '' : 'required'} placeholder="••••••••">
                    </div>
                    <div class="form-group">
                        <label style="color:#666">Foto Profil ${id ? '(kosongkan jika tidak diganti)' : ''}</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>`;
            } else if (currentState === 'kategori') {
                fields.innerHTML = `
                    <input type="hidden" name="id" value="${data.id || ''}">
                    <div class="form-group">
                        <label style="color:#666">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" required value="${data.nama_kategori || ''}" placeholder="Nama kategori...">
                    </div>
                    <div class="form-group">
                        <label style="color:#666">Keterangan</label>
                        <textarea name="keterangan" class="form-control" placeholder="Deskripsi kategori...">${data.keterangan || ''}</textarea>
                    </div>`;
            } else {
                const [resP, resK] = await Promise.all([fetch('penulis/ambil_penulis.php'), fetch('kategori/ambil_kategori.php')]);
                const writers = await resP.json();
                const cats = await resK.json();
                fields.innerHTML = `
                    <input type="hidden" name="id" value="${data.id || ''}">
                    <div class="form-group">
                        <label style="color:#666">Judul</label>
                        <input type="text" name="judul" class="form-control" required value="${data.judul || ''}" placeholder="Judul artikel...">
                    </div>
                    <div style="display:flex; gap:20px">
                        <div class="form-group" style="flex:1">
                            <label style="color:#666">Penulis</label>
                            <select name="id_penulis" class="form-control" required>
                                ${writers.map(w => `<option value="${w.id}" ${w.id == data.id_penulis ? 'selected' : ''}>${w.nama_depan} ${w.nama_belakang}</option>`).join('')}
                            </select>
                        </div>
                        <div class="form-group" style="flex:1">
                            <label style="color:#666">Kategori</label>
                            <select name="id_kategori" class="form-control" required>
                                ${cats.map(c => `<option value="${c.id}" ${c.id == data.id_kategori ? 'selected' : ''}>${c.nama_kategori}</option>`).join('')}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="color:#666">Isi Artikel</label>
                        <textarea name="isi" class="form-control" required placeholder="Tulis isi artikel di sini...">${data.isi || ''}</textarea>
                    </div>
                    <div class="form-group">
                        <label style="color:#666">Gambar ${id ? '(kosongkan jika tidak diganti)' : ''}</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" ${id ? '' : 'required'}>
                    </div>`;
            }

            document.getElementById('modal-overlay').style.display = 'flex';
            document.getElementById('main-form').onsubmit = e => handleFormSubmit(e, id);
        }

        async function handleFormSubmit(e, id) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const url = `${currentState}/${id ? 'update' : 'simpan'}_${currentState}.php`;
            const res = await fetch(url, { method: 'POST', body: formData });
            const result = await res.json();
            if (result.status === 'success') {
                showAlert('success', result.message);
                closeModal();
                switchTab(currentState);
            } else {
                showAlert('error', result.message);
            }
        }

        function closeModal() { document.getElementById('modal-overlay').style.display = 'none'; }
        function closeDeleteModal() { document.getElementById('delete-overlay').style.display = 'none'; }

        function confirmDelete(table, id) {
            document.getElementById('delete-overlay').style.display = 'flex';
            document.getElementById('btn-confirm-delete').onclick = async () => {
                const fd = new FormData(); fd.append('id', id);
                const res = await fetch(`${table}/hapus_${table}.php`, { method: 'POST', body: fd });
                const result = await res.json();
                if (result.status === 'success') {
                    showAlert('success', result.message);
                    closeDeleteModal();
                    switchTab(table);
                } else {
                    showAlert('error', result.message);
                    closeDeleteModal();
                }
            };
        }

        function showAlert(type, msg) {
            const div = document.createElement('div');
            div.style.padding = '15px 30px';
            div.style.borderRadius = '8px';
            div.style.background = type === 'success' ? '#4caf50' : '#f44336';
            div.style.color = 'white';
            div.style.marginBottom = '10px';
            div.style.boxShadow = '0 5px 15px rgba(0,0,0,0.2)';
            div.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i> &nbsp; ${msg}`;
            document.getElementById('alert-container').appendChild(div);
            setTimeout(() => div.remove(), 3000);
        }
    </script>
</body>

</html>