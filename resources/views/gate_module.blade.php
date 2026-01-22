<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate Modul - Universitas Paramadina</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), 
                        url('bg_aplikasigate.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .bg-portal {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .portal-card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 1100px;
        }

        .portal-header {
            background: linear-gradient(to right, #003366, #00509d);
            padding: 20px 30px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-logo-container {
            background: white;
            padding: 8px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-logo-container img { height: 40px; }

        .portal-container {
            display: flex;
            min-height: 500px;
        }

        .module-section {
            flex: 1.5;
            padding: 40px;
            border-right: 1px solid #eee;
        }

        /* Sisi Kanan: Daftar Role Desktop */
        .role-section {
            flex: 1;
            padding: 40px;
            background-color: #f8f9fa;
            display: none; 
        }

        .module-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 20px;
        }

        .module-item {
            text-decoration: none !important;
            color: #444;
            background: white;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 20px 10px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
        }

        .module-item:hover, .module-item.active {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
            border-color: #00509d;
        }

        .module-item.active {
            background-color: #eef5ff;
            border-width: 2px;
        }

        .module-icon { font-size: 2.5rem; margin-bottom: 10px; display: block; }

        .badge-new {
            position: absolute; top: 8px; right: 8px;
            background: linear-gradient(135deg, #f06292 0%, #e91e63 100%);
            color: white; font-size: 9px; font-weight: bold;
            padding: 2px 6px; border-radius: 4px; text-transform: uppercase;
        }

        /* Role Cards Styling */
        .role-card {
            background: white;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-left: 5px solid #00509d;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            text-decoration: none !important;
            display: block;
        }

        .role-card:hover { transform: scale(1.02); background-color: #f0f7ff; }
        .role-title { color: #00509d; font-weight: 700; margin-bottom: 2px; }
        .role-sub { color: #888; font-size: 12px; }

        .btn-portal-sm { font-size: 12px; border-radius: 50px; padding: 5px 15px; }
        
        .icon-blue { color: #299cdb; }
        .icon-orange { color: #f7b84b; }
        .icon-green { color: #45cb85; }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .portal-container { flex-direction: column; }
            .module-section { border-right: none; padding: 20px; }
            .role-section { display: none !important; } /* Sembunyikan panel kanan di mobile */
            .portal-header { padding: 15px; flex-direction: column; text-align: center; gap: 15px; }
            .header-logo-container { margin-bottom: 5px; }
        }
    </style>
</head>
<body>

<div class="bg-portal">
    <div class="portal-card">
        
        <div class="portal-header">
            <div class="d-flex align-items-center flex-column flex-md-row">
                <div class="header-logo-container me-md-3">
                    <img src="{{ asset('logo-label.svg') }}" alt="Logo">
                </div>
                <div class="mt-2 mt-md-0">
                    <div style="font-size: 11px; opacity: 0.8; text-transform: uppercase;">Sistem Informasi</div>
                    <div style="font-size: 17px; font-weight: 800; letter-spacing: 0.5px;">UNIVERSITAS PARAMADINA</div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-light btn-portal-sm"><i class="ri-user-line me-1"></i> Hai, {{ Auth::user()->name }}</button>
                <a href="{{ route('logout') }}" class="btn btn-outline-light btn-portal-sm" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ri-logout-box-r-line me-1"></i> Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>

        <div class="portal-container">
            <div class="module-section">
                <h5 class="fw-bold mb-4">Daftar Modul</h5>
                <div class="module-grid">
                    @foreach ($modules as $item)
                        <div class="module-item" onclick="handleModuleClick('{{ $item->title }}', '{{ $item->url }}', this, '{{ $item->deskripsi }}')">
                            <i class="{{ $item->icon }} module-icon icon-{{ $item->color ?? 'blue' }}"></i>
                            <div class="fw-bold fs-13">{{ $item->title }}</div>
                        </div>
                    @endforeach
                    {{-- <div class="module-item" onclick="handleModuleClick('SIM Akademik', 'akademik', this)">
                        <i class="ri-book-read-fill module-icon icon-blue"></i>
                        <div class="fw-bold fs-13">SIM Akademik</div>
                    </div>

                    <div class="module-item" onclick="handleModuleClick('SIM Kepegawaian', 'kepegawaian', this)">
                        <span class="badge-new">NEW</span>
                        <i class="ri-group-fill module-icon icon-orange"></i>
                        <div class="fw-bold fs-13">SIM Kepegawaian</div>
                    </div>

                    <div class="module-item" onclick="handleModuleClick('SIM Keuangan', 'keuangan', this)">
                        <i class="ri-money-dollar-box-fill module-icon icon-green"></i>
                        <div class="fw-bold fs-13">SIM Keuangan</div>
                    </div>

                    <div class="module-item" onclick="handleModuleClick('CBT AI', 'cbt', this)">
                        <i class="ri-computer-line module-icon text-secondary"></i>
                        <div class="fw-bold fs-13">CBT AI</div>
                    </div> --}}
                </div>
            </div>

            <div class="role-section d-none d-md-block" id="roleSectionDesktop">
                <h5 class="fw-bold mb-1">Daftar Role</h5>
                <p class="text-muted small mb-4" id="selectedModuleNameDesktop">Pilih Modul</p>
                <div id="roleListDesktop"></div>
            </div>
        </div>

        <div class="text-center pb-3 bg-light border-top pt-3">
            <small class="text-muted">© 2026 Universitas Paramadina. All rights reserved.</small>
        </div>
    </div>
</div>

<div class="modal fade" id="roleModalMobile" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="roleModalLabel">Daftar Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small mb-3" id="selectedModuleNameMobile"></p>
                <div id="roleListMobile"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Ganti bagian <script> lama dengan ini
    const roleModalMobile = new bootstrap.Modal(document.getElementById('roleModalMobile'));

    async function handleModuleClick(moduleName, moduleType, element,modulDeskripsi) {
        // 1. Highlight active module
        document.querySelectorAll('.module-item').forEach(item => item.classList.remove('active'));
        element.classList.add('active');

        // 2. Tampilkan Loading State
        const loaderHtml = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted mt-2">Mengambil data role...</p>
            </div>`;
        
        if (window.innerWidth >= 768) {
            document.getElementById('roleSectionDesktop').style.display = 'block';
            document.getElementById('selectedModuleNameDesktop').innerText = moduleName +' ('+modulDeskripsi+')';
            document.getElementById('roleListDesktop').innerHTML = loaderHtml;
        }

        try {
            // 3. AJAX Fetch ke Laravel
            const response = await fetch(`/roles/${moduleType}`);
            const roles = await response.json();

            // 4. Cek lebar layar untuk output
            if (window.innerWidth < 768) {
                showMobileModal(moduleName, roles);
            } else {
                document.getElementById('roleListDesktop').innerHTML = generateRoleHtml(roles);
            }
        } catch (error) {
            console.error('Error fetching roles:', error);
            const errorMsg = '<div class="alert alert-danger">Gagal memuat data role.</div>';
            if (window.innerWidth < 768) {
                document.getElementById('roleListMobile').innerHTML = errorMsg;
                roleModalMobile.show();
            } else {
                document.getElementById('roleListDesktop').innerHTML = errorMsg;
            }
        }
    }

    function showMobileModal(moduleName, roles) {
        document.getElementById('selectedModuleNameMobile').innerText = moduleName;
        document.getElementById('roleListMobile').innerHTML = generateRoleHtml(roles);
        roleModalMobile.show();
    }

    function generateRoleHtml(roles) {
        if (roles.length === 0) return '<p class="text-center text-muted">Tidak ada role tersedia.</p>';
        
        return roles.map(role => `
            <a href="/set-active-role/${role.id}/${role.modul_id}" class="role-card">
                <div class="role-title">${role.title}</div>
                <div class="role-sub">${role.sub}</div>
            </a>
        `).join('');
    }
</script>

</body>
</html>