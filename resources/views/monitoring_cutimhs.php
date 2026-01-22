<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa Cuti - Lengkap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-blue: #2196F3;
            --light-blue: #E3F2FD;
            --dark-blue: #1976D2;
            --orange: #FF9800;
            --light-bg: #F5F9FC;
        }

        body { background: var(--light-bg); font-family: 'Segoe UI', sans-serif; }

        /* Header Styles */
        .header-card {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            border-radius: 20px;
            padding: 2rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(33, 150, 243, 0.3);
        }

        .filter-select {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 12px;
            padding: 0.5rem 1rem;
        }
        .filter-select option { color: #333; }

        .total-badge {
            background: var(--orange);
            border-radius: 20px;
            padding: 1rem 1.5rem;
            text-align: center;
            min-width: 140px;
        }

        /* Chart Styles */
        .chart-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            border: 2px solid #eee;
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
        }
        
        .chart-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-blue);
        }

        .chart-card::after {
            content: '👆 Klik chart untuk detail';
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            font-size: 0.75rem;
            color: #999;
            font-style: italic;
        }

        .chart-container { position: relative; height: 320px; width: 100%; }

        /* Table Styles */
        .table-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            border: 1px solid #eee;
        }

        .table-header {
            background: var(--primary-blue);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .prodi-badge { padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.8rem; font-weight: bold; }
    </style>
</head>
<body>

<div class="container-fluid px-4 py-4">
    
    <div class="header-card">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-12 mb-3 mb-lg-0">
                <h2 class="fw-bold mb-1">Data Mahasiswa Cuti</h2>
                <p class="mb-0 opacity-75">Semester Gasal 2025-2026</p>
                <div class="badge bg-white text-primary mt-2">
                    <i class="bi bi-clock-history me-1"></i> Update: Jan 21, 2026
                </div>
            </div>
            <div class="col-lg-6 col-md-8 mb-3 mb-lg-0">
                <div class="d-flex gap-2 flex-wrap">
                    <select class="form-select filter-select w-auto">
                        <option selected>Semua Kampus</option>
                        <option>Kuningan</option><option>Cipayung</option><option>Cikarang</option>
                    </select>
                    <select class="form-select filter-select w-auto">
                        <option selected>Semua Prodi</option>
                        <option>PMM</option><option>PPS</option><option>PIK</option>
                    </select>
                    <select class="form-select filter-select w-auto">
                        <option selected>Semua Angkatan</option>
                        <option>2024</option><option>2023</option><option>2022</option>
                    </select>
                    <select class="form-select filter-select w-auto">
                        <option selected>Semua Jalur</option>
                        <option>Sabtu</option><option>Malam</option><option>Pagi</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 text-end">
                <div class="total-badge d-inline-block">
                    <div class="display-5 fw-bold lh-1">661</div>
                    <small class="fw-bold text-uppercase">Total Data</small>
                </div>
            </div>
        </div>
    </div>

    <div class="chart-card">
        <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-bar-chart-fill me-2"></i>Data per Program Studi</h5>
        <div class="chart-container">
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="chart-card text-center">
                <h6 class="fw-bold mb-3">Jalur Pendaftaran</h6>
                <div class="chart-container" style="height: 250px;">
                    <canvas id="pieChart1"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="chart-card text-center">
                <h6 class="fw-bold mb-3">Distribusi Kampus</h6>
                <div class="chart-container" style="height: 250px;">
                    <canvas id="pieChart2"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="chart-card">
                <h6 class="fw-bold mb-3 text-center">Data per Angkatan</h6>
                <div class="chart-container" style="height: 250px;">
                    <canvas id="barChart2"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-header">
            <span><i class="bi bi-person-badge me-2"></i>Statistik Pembimbing Akademik</span>
            <span class="badge bg-light text-primary">Top 5</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">#</th>
                        <th>Kode Dosen</th>
                        <th>Nama Pembimbing Akademik</th>
                        <th class="text-center">Jumlah Bimbingan Cuti</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>223020434</td>
                        <td>Sofia Tri Putri, S.Psi., M.Psi</td>
                        <td class="text-center fw-bold text-primary">16</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>201050048</td>
                        <td>Prof. Dr Iin Mayasari, S.Pd., S.I.P., M.M.</td>
                        <td class="text-center fw-bold text-primary">15</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>221002367</td>
                        <td>Syarifaniaty Miranda Agustina, M.Psi</td>
                        <td class="text-center fw-bold text-primary">15</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>220011359</td>
                        <td>Prof. Dr. Ahmad Azmy, S.E., M.M.</td>
                        <td class="text-center fw-bold text-primary">14</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>203060097</td>
                        <td>Dr. Rini Sudarmanti, M.Si</td>
                        <td class="text-center fw-bold text-primary">13</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-3 bg-light border-top text-center text-muted small">
            Menampilkan 5 dari 98 Pembimbing Akademik
        </div>
    </div>

    <div class="table-card">
        <div class="table-header">
            <span><i class="bi bi-people-fill me-2"></i>Daftar Mahasiswa Cuti</span>
            <span class="badge bg-light text-primary">Record: 661</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Prodi</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Angkatan</th>
                        <th>Pembimbing Akademik</th>
                        <th>No. Telp</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="prodi-badge bg-success-subtle text-success">PDV</span></td>
                        <td>119101065</td>
                        <td>NOVIAN DWI HARJANTO</td>
                        <td>2019</td>
                        <td>Rio Satriyo Hadiwijoyo, S.Ds., M.Ds</td>
                        <td>085773817396</td>
                    </tr>
                    <tr>
                        <td><span class="prodi-badge bg-warning-subtle text-warning">PTI</span></td>
                        <td>119103030</td>
                        <td>KLARISA NAVYANTIKA</td>
                        <td>2019</td>
                        <td>Retno Hendrowati, S.T., M.T.</td>
                        <td>085715917779</td>
                    </tr>
                    <tr>
                        <td><span class="prodi-badge bg-info-subtle text-info">PFA</span></td>
                        <td>119104023</td>
                        <td>HARI AKBAR APRIAWAN</td>
                        <td>2019</td>
                        <td>Fuad Mahbub Siraj, S.Fil., M.A.</td>
                        <td>089604089298</td>
                    </tr>
                    <tr>
                        <td><span class="prodi-badge bg-primary-subtle text-primary">PHI</span></td>
                        <td>119105026</td>
                        <td>RISDA YANTI SIHITE</td>
                        <td>2019</td>
                        <td>Emil Radhiansyah, S.IP, M.Si</td>
                        <td>082311993050</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center">
            <small class="text-muted">Menampilkan 1-4 dari 661 data</small>
            <div>
                <button class="btn btn-sm btn-outline-secondary disabled"><i class="bi bi-chevron-left"></i></button>
                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="drillDownModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header bg-primary text-white">
                <div>
                    <h5 class="modal-title fw-bold" id="modalTitle">Detail Data</h5>
                    <small id="modalSubtitle" class="text-light opacity-75">Detail breakdown</small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Angkatan</th>
                                <th>Kategori</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="modalTableBody">
                            </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script>
    Chart.register(ChartDataLabels);

    // --- GENERATOR DATA PALSU UNTUK MODAL (Sesuai jumlah yang diklik) ---
    function generateDummyStudents(label, count) {
        let students = [];
        for (let i = 1; i <= count; i++) {
            students.push({
                nim: `119${Math.floor(10000 + Math.random() * 90000)}`,
                nama: `MAHASISWA ${label.toUpperCase()} ${i}`,
                angkatan: 2020 + Math.floor(Math.random() * 4),
                kategori: label,
                status: 'Cuti'
            });
        }
        return students;
    }

    // --- FUNGSI HANDLE KLIK CHART ---
    function handleChartClick(event, elements, chart) {
        if (elements.length === 0) return;

        const index = elements[0].index;
        const label = chart.data.labels[index];
        const value = chart.data.datasets[0].data[index];

        // 1. Generate data
        const studentList = generateDummyStudents(label, value);

        // 2. Update Modal
        document.getElementById('modalTitle').innerText = `Detail Kategori: ${label}`;
        document.getElementById('modalSubtitle').innerText = `Menampilkan ${value} mahasiswa`;

        // 3. Render Table
        const tableBody = document.getElementById('modalTableBody');
        let html = '';
        studentList.forEach((student, idx) => {
            html += `
                <tr>
                    <td>${idx + 1}</td>
                    <td><span class="font-monospace fw-bold">${student.nim}</span></td>
                    <td>${student.nama}</td>
                    <td>${student.angkatan}</td>
                    <td><span class="badge bg-info text-dark">${student.kategori}</span></td>
                    <td><span class="badge bg-warning text-dark">${student.status}</span></td>
                </tr>
            `;
        });
        tableBody.innerHTML = html;

        // 4. Show Modal
        new bootstrap.Modal(document.getElementById('drillDownModal')).show();
    }

    // --- KONFIGURASI CHART ---
    window.onload = function() {
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            onClick: (e, elements, chart) => handleChartClick(e, elements, chart), // Aktifkan Klik
            plugins: {
                datalabels: {
                    color: '#fff',
                    font: { weight: 'bold', size: 11 },
                    formatter: (val) => val
                },
                legend: { display: false }
            }
        };

        // 1. Bar Chart Prodi
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: ['PMM', 'PPS', 'PIK', 'PMK', 'PMJ', 'PHI', 'PMH', 'PDV', 'PTI', 'PFA'],
                datasets: [{
                    data: [131, 126, 79, 73, 60, 60, 39, 38, 31, 14],
                    backgroundColor: '#2196F3',
                    borderRadius: 5
                }]
            },
            options: {
                ...commonOptions,
                scales: { 
                    y: { beginAtZero: true, display: true, grid: { color: 'rgba(0,0,0,0.05)' } }, 
                    x: { grid: { display: false } } 
                }
            }
        });

        // 2. Pie Jalur
        new Chart(document.getElementById('pieChart1'), {
            type: 'doughnut',
            data: {
                labels: ['Sabtu', 'Malam', 'Pagi'],
                datasets: [{
                    data: [387, 145, 129],
                    backgroundColor: ['#2196F3', '#FF9800', '#9C27B0']
                }]
            },
            options: {
                ...commonOptions,
                plugins: { ...commonOptions.plugins, legend: { position: 'bottom', display: true } }
            }
        });

        // 3. Pie Kampus
        new Chart(document.getElementById('pieChart2'), {
            type: 'pie',
            data: {
                labels: ['Kuningan', 'Cipayung', 'Cikarang'],
                datasets: [{
                    data: [315, 185, 161],
                    backgroundColor: ['#1976D2', '#FFA726', '#E91E63']
                }]
            },
            options: {
                ...commonOptions,
                plugins: { ...commonOptions.plugins, legend: { position: 'bottom', display: true } }
            }
        });

        // 4. Bar Angkatan
        new Chart(document.getElementById('barChart2'), {
            type: 'bar',
            data: {
                labels: ['2024', '2023', '2022', '2021'],
                datasets: [{
                    data: [170, 210, 147, 72],
                    backgroundColor: '#4CAF50',
                    borderRadius: 5
                }]
            },
            options: {
                ...commonOptions,
                scales: { 
                    y: { beginAtZero: true, display: true, grid: { color: 'rgba(0,0,0,0.05)' } }, 
                    x: { grid: { display: false } } 
                }
            }
        });
    };
</script>

</body>
</html>