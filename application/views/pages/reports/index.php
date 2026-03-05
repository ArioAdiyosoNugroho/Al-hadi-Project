<style>
.mobile-rekap-card {
    transition: box-shadow 0.15s ease, border-color 0.15s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.mobile-rekap-card:hover {
    box-shadow: 0 4px 14px rgba(105,108,255,0.1);
    border-color: #d5d6ff !important;
}
.mobile-rekap-card.hidden {
    display: none !important;
}
.stat-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.78rem;
    padding: 3px 0;
}
.stat-row .label { color: #888; }
.ranking-medal {
    font-size: 1.2rem;
    min-width: 32px;
    text-align: center;
}
.rank-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #f0f0f0;
    color: #666;
    font-size: 0.75rem;
    font-weight: 700;
}
</style>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Al-Hadi /</span> Laporan Kebersihan
            </h4>
            <p class="text-muted mb-0">Rekap nilai kebersihan kelas per bulan</p>
        </div>
        <a href="<?= base_url('reports/export_pdf?bulan=' . $bulan . '&tahun=' . $tahun) ?>"
            class="btn btn-danger" target="_blank">
            <i class="bx bxs-file-pdf me-1"></i> Export PDF
        </a>
    </div>

    <!-- Filter -->
    <div class="card shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end g-3">
                <div class="col-6 col-sm-auto">
                    <label class="form-label fw-semibold mb-1">Bulan</label>
                    <select id="filterBulan" class="form-select">
                        <?php
                        $bulan_list = [
                            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
                            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
                            9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
                        ];
                        foreach ($bulan_list as $n => $nm): ?>
                        <option value="<?= $n ?>" <?= $bulan == $n ? 'selected' : '' ?>><?= $nm ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 col-sm-auto">
                    <label class="form-label fw-semibold mb-1">Tahun</label>
                    <select id="filterTahun" class="form-select">
                        <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                        <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button onclick="filterLaporan()" class="btn btn-primary">
                        <i class="bx bx-filter me-1"></i> Tampilkan
                    </button>
                </div>
                <div class="col-12 col-sm-auto ms-sm-auto">
                    <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-light">
                        <i class="bx bx-calendar text-primary"></i>
                        <span class="text-muted small">Periode: <strong>
                            <?php
                            $bn = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                                   7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                            echo $bn[$bulan] . ' ' . $tahun;
                            ?>
                        </strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    $bn_label = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                 7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
    ?>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm text-center border-top border-3 border-primary h-100">
                <div class="card-body py-3">
                    <div class="avatar bg-label-primary rounded mx-auto mb-2">
                        <span class="avatar-initial rounded"><i class="bx bx-buildings"></i></span>
                    </div>
                    <h4 class="fw-bold mb-0 text-primary"><?= $summary->total_kelas_dinilai ?? 0 ?></h4>
                    <small class="text-muted">Kelas Dinilai</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm text-center border-top border-3 border-info h-100">
                <div class="card-body py-3">
                    <div class="avatar bg-label-info rounded mx-auto mb-2">
                        <span class="avatar-initial rounded"><i class="bx bx-clipboard"></i></span>
                    </div>
                    <h4 class="fw-bold mb-0 text-info"><?= $summary->total_penilaian ?? 0 ?></h4>
                    <small class="text-muted">Total Penilaian</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm text-center border-top border-3 border-success h-100">
                <div class="card-body py-3">
                    <div class="avatar bg-label-success rounded mx-auto mb-2">
                        <span class="avatar-initial rounded"><i class="bx bx-bar-chart-alt-2"></i></span>
                    </div>
                    <h4 class="fw-bold mb-0 text-success"><?= $summary->rata_rata_keseluruhan ?? 0 ?></h4>
                    <small class="text-muted">Rata-rata Poin</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm text-center border-top border-3 border-warning h-100">
                <div class="card-body py-3">
                    <div class="avatar bg-label-warning rounded mx-auto mb-2">
                        <span class="avatar-initial rounded"><i class="bx bx-trophy"></i></span>
                    </div>
                    <h4 class="fw-bold mb-0 text-warning" style="font-size:14px;">
                        <?= $terbersih ? htmlspecialchars($terbersih->class_name) : '-' ?>
                    </h4>
                    <small class="text-muted">Kelas Terbersih</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">

        <!-- ===== Rekap Nilai ===== -->
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
                    <h5 class="mb-0">
                        <i class="bx bx-table me-2 text-primary"></i>
                        Nilai Kebersihan — <?= $bn_label[$bulan] . ' ' . $tahun ?>
                    </h5>
                    <span class="badge bg-label-primary px-3 py-2" style="font-size:0.8125rem;">
                        <?= count($rekap) ?> kelas
                    </span>
                </div>
                <div class="card-body p-0">

                    <!-- DESKTOP TABLE -->
                    <div class="d-none d-md-block">
                        <div class="table-responsive">
                            <table id="tableRekap" class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="60" class="text-center ps-4">No</th>
                                        <th>Nama Kelas</th>
                                        <th class="text-center">Penilaian</th>
                                        <th class="text-center">Rata-rata</th>
                                        <th class="text-center">Tertinggi</th>
                                        <th class="text-center">Terendah</th>
                                        <th class="text-center pe-4">Predikat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($rekap)): $no = 1; foreach ($rekap as $row):
                                        $avg = (float)$row->rata_rata;
                                        if ($row->jumlah_penilaian == 0)    { $p='secondary'; $l='Belum Ada Data'; }
                                        elseif ($avg >= 80)                 { $p='success';   $l='Sangat Bersih'; }
                                        elseif ($avg >= 60)                 { $p='primary';   $l='Bersih'; }
                                        elseif ($avg >= 40)                 { $p='warning';   $l='Cukup'; }
                                        else                                { $p='danger';    $l='Kurang'; }
                                    ?>
                                    <tr>
                                        <td class="text-center text-muted ps-4"><?= $no++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar avatar-sm bg-label-<?= $p ?> rounded">
                                                    <span class="avatar-initial rounded">
                                                        <i class="bx bx-building-house" style="font-size:13px;"></i>
                                                    </span>
                                                </div>
                                                <strong><?= htmlspecialchars($row->class_name) ?></strong>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-label-primary"><?= $row->jumlah_penilaian ?> kali</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-<?= $p ?> fs-5"><?= $row->rata_rata ?? '-' ?></span>
                                        </td>
                                        <td class="text-center text-success fw-bold"><?= $row->tertinggi ?? '-' ?></td>
                                        <td class="text-center text-danger fw-bold"><?= $row->terendah ?? '-' ?></td>
                                        <td class="text-center pe-4">
                                            <span class="badge bg-<?= $p ?>"><?= $l ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="bx bx-info-circle d-block mb-2" style="font-size:2.5rem;opacity:0.3;"></i>
                                            <span class="text-muted">Tidak ada data penilaian untuk bulan ini.</span>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- MOBILE CARDS -->
                    <div class="d-md-none">
                        <!-- Search -->
                        <div class="px-3 pt-3 pb-2">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 pe-1">
                                    <i class="bx bx-search text-muted"></i>
                                </span>
                                <input type="text" id="mobileSearchRekap"
                                    class="form-control border-start-0 ps-1"
                                    placeholder="Cari kelas..." />
                            </div>
                        </div>

                        <div id="mobileRekapList" class="px-3 pb-3">
                            <?php if (!empty($rekap)): $no = 1; foreach ($rekap as $row):
                                $avg = (float)$row->rata_rata;
                                if ($row->jumlah_penilaian == 0)    { $p='secondary'; $l='Belum Ada Data'; }
                                elseif ($avg >= 80)                 { $p='success';   $l='Sangat Bersih'; }
                                elseif ($avg >= 60)                 { $p='primary';   $l='Bersih'; }
                                elseif ($avg >= 40)                 { $p='warning';   $l='Cukup'; }
                                else                                { $p='danger';    $l='Kurang'; }
                            ?>
                            <div class="mobile-rekap-card rounded-3 border bg-white p-3 mb-2"
                                data-name="<?= strtolower(htmlspecialchars($row->class_name)) ?>">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <span class="text-muted fw-semibold" style="min-width:20px;font-size:0.8rem;"><?= $no++ ?></span>
                                    <div class="avatar avatar-sm bg-label-<?= $p ?> rounded flex-shrink-0">
                                        <span class="avatar-initial rounded">
                                            <i class="bx bx-building-house" style="font-size:13px;"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong style="font-size:0.9rem;"><?= htmlspecialchars($row->class_name) ?></strong>
                                    </div>
                                    <span class="badge bg-<?= $p ?>"><?= $l ?></span>
                                </div>
                                <!-- Stats -->
                                <div class="ms-4 ps-3 border-start border-2" style="border-color:#eee !important;">
                                    <div class="stat-row">
                                        <span class="label">Penilaian</span>
                                        <span class="badge bg-label-primary"><?= $row->jumlah_penilaian ?> kali</span>
                                    </div>
                                    <div class="stat-row">
                                        <span class="label">Rata-rata</span>
                                        <strong class="text-<?= $p ?>"><?= $row->rata_rata ?? '-' ?></strong>
                                    </div>
                                    <div class="stat-row">
                                        <span class="label">Tertinggi</span>
                                        <strong class="text-success"><?= $row->tertinggi ?? '-' ?></strong>
                                    </div>
                                    <div class="stat-row">
                                        <span class="label">Terendah</span>
                                        <strong class="text-danger"><?= $row->terendah ?? '-' ?></strong>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <div id="mobileRekapEmpty" class="text-center py-4 d-none">
                                <i class="bx bx-search-alt d-block mb-2" style="font-size:2rem;opacity:0.3;"></i>
                                <span class="text-muted small">Kelas tidak ditemukan</span>
                            </div>

                            <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bx bx-info-circle d-block mb-2" style="font-size:2.5rem;opacity:0.3;"></i>
                                <span class="text-muted">Tidak ada data penilaian untuk bulan ini.</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ===== Ranking ===== -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0">
                        <i class="bx bx-trophy me-2 text-warning"></i>Ranking Kebersihan
                    </h5>
                    <span class="badge bg-label-warning px-3 py-2" style="font-size:0.8125rem;">
                        <?= count($ranking) ?> kelas
                    </span>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($ranking)): ?>
                    <ul class="list-group list-group-flush">
                        <?php $rank = 1; foreach ($ranking as $row):
                            $avg = (float)$row->rata_rata;
                            if ($row->jumlah_penilaian == 0)    { $p='secondary'; $l='–'; }
                            elseif ($avg >= 80)                 { $p='success';   $l=number_format($avg,1); }
                            elseif ($avg >= 60)                 { $p='primary';   $l=number_format($avg,1); }
                            elseif ($avg >= 40)                 { $p='warning';   $l=number_format($avg,1); }
                            else                                { $p='danger';    $l=number_format($avg,1); }

                            if ($rank == 1)     $medal = '🥇';
                            elseif ($rank == 2) $medal = '🥈';
                            elseif ($rank == 3) $medal = '🥉';
                            else                $medal = null;
                        ?>
                        <li class="list-group-item d-flex align-items-center gap-3 px-3 py-2
                            <?= $rank == 1 ? 'bg-warning bg-opacity-10' : '' ?>">
                            <?php if ($medal): ?>
                                <span class="ranking-medal"><?= $medal ?></span>
                            <?php else: ?>
                                <span class="rank-num"><?= $rank ?></span>
                            <?php endif; ?>
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="fw-semibold text-truncate" style="font-size:0.875rem;">
                                    <?= htmlspecialchars($row->class_name) ?>
                                </div>
                                <small class="text-muted"><?= $row->jumlah_penilaian ?> penilaian</small>
                            </div>
                            <span class="badge bg-<?= $p ?> flex-shrink-0"><?= $l ?></span>
                        </li>
                        <?php $rank++; endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bx bx-trophy d-block mb-2" style="font-size:2.5rem;opacity:0.3;"></i>
                        <span class="text-muted">Belum ada data ranking.</span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function filterLaporan() {
    var bulan = document.getElementById('filterBulan').value;
    var tahun = document.getElementById('filterTahun').value;
    window.location.href = '<?= base_url('reports') ?>?bulan=' + bulan + '&tahun=' + tahun;
}

window.addEventListener('load', function () {
    // DataTables untuk desktop
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.DataTable !== 'undefined') {
        jQuery('#tableRekap').DataTable({
            paging: false, searching: false, info: false,
            order: [[3, 'desc']],
            columnDefs: [{ orderable: false, targets: [0, 6] }]
        });
    }
});

// Mobile search
document.addEventListener('DOMContentLoaded', function () {
    var mobileSearch = document.getElementById('mobileSearchRekap');
    if (mobileSearch) {
        mobileSearch.addEventListener('input', function () {
            var keyword = this.value.toLowerCase().trim();
            var cards   = document.querySelectorAll('.mobile-rekap-card');
            var empty   = document.getElementById('mobileRekapEmpty');
            var visible = 0;

            cards.forEach(function (card) {
                var name  = card.getAttribute('data-name') || '';
                var match = keyword === '' || name.includes(keyword);
                if (match) {
                    card.classList.remove('hidden');
                    visible++;
                } else {
                    card.classList.add('hidden');
                }
            });

            if (empty) {
                if (visible === 0) empty.classList.remove('d-none');
                else               empty.classList.add('d-none');
            }
        });
    }
});
</script>
