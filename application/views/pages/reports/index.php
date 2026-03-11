<style>
.mobile-rekap-card {
    transition: box-shadow 0.15s ease, border-color 0.15s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.mobile-rekap-card:hover {
    box-shadow: 0 4px 14px rgba(105,108,255,0.1);
    border-color: #d5d6ff !important;
}
.mobile-rekap-card.hidden { display: none !important; }
.stat-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.78rem;
    padding: 3px 0;
}
.stat-row .label { color: #888; }
.ranking-medal { font-size: 1.2rem; min-width: 32px; text-align: center; }
.rank-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px; height: 26px;
    border-radius: 50%;
    background: #f0f0f0;
    color: #666;
    font-size: 0.75rem;
    font-weight: 700;
}
/* Rapikan tampilan DataTables di dalam card */
#tableRekap_wrapper .dataTables_filter input {
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 4px 10px;
    font-size: 0.875rem;
}
#tableRekap_wrapper .dataTables_filter label {
    font-size: 0.875rem;
}
#tableRekap_wrapper .dataTables_length select {
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 2px 6px;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
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

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end g-3">
                <div class="col-6 col-sm-auto">
                    <label class="form-label fw-semibold mb-1">Bulan</label>
                    <select id="filterBulan" class="form-select form-select-sm" style="min-width:120px;">
                        <?php
                        $bulan_list = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
                            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
                            9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                        foreach ($bulan_list as $n => $nm): ?>
                        <option value="<?= $n ?>" <?= $bulan == $n ? 'selected' : '' ?>><?= $nm ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 col-sm-auto">
                    <label class="form-label fw-semibold mb-1">Tahun</label>
                    <select id="filterTahun" class="form-select form-select-sm" style="min-width:90px;">
                        <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                        <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button onclick="filterLaporan()" class="btn btn-sm btn-primary">
                        <i class="bx bx-filter-alt me-1"></i>Tampilkan
                    </button>
                </div>
                <div class="col-12 col-sm-auto ms-sm-auto">
                    <?php
                    $bn = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                           7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                    ?>
                    <span class="badge bg-label-primary px-3 py-2" style="font-size:0.8125rem;">
                        <i class="bx bx-calendar me-1"></i><?= $bn[$bulan] . ' ' . $tahun ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <?php $bn_label = $bn; ?>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-3">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-buildings"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Kelas Dinilai</span>
                    <h3 class="card-title mb-0 text-primary"><?= $summary->total_kelas_dinilai ?? 0 ?></h3>
                    <small class="text-muted">kelas bulan ini</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-3">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-clipboard"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Total Penilaian</span>
                    <h3 class="card-title mb-0 text-info"><?= $summary->total_penilaian ?? 0 ?></h3>
                    <small class="text-muted">penilaian dilakukan</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-3">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-bar-chart-alt-2"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Rata-rata Poin</span>
                    <h3 class="card-title mb-0 text-success"><?= $summary->rata_rata_keseluruhan ?? '-' ?></h3>
                    <small class="text-muted">rata keseluruhan</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-3">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-trophy"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Kelas Terbersih</span>
                    <h3 class="card-title mb-0 text-warning text-nowrap" style="font-size:1rem;">
                        <?= $terbersih ? htmlspecialchars($terbersih->class_name) : '-' ?>
                    </h3>
                    <?php if ($terbersih): ?>
                    <small class="text-success fw-semibold">
                        <i class="bx bx-up-arrow-alt"></i><?= number_format((float)$terbersih->rata_rata, 1) ?> poin
                    </small>
                    <?php else: ?>
                    <small class="text-muted">belum ada data</small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Row -->
    <div class="row g-4">

        <!-- Rekap Nilai -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h5 class="m-0 me-2">Nilai Kebersihan</h5>
                        <small class="text-muted"><?= $bn_label[$bulan] . ' ' . $tahun ?></small>
                    </div>
                    <span class="badge bg-label-primary px-3 py-2" style="font-size:0.8125rem;">
                        <?= count($rekap) ?> kelas
                    </span>
                </div>

                <!-- DESKTOP TABLE — DataTables dengan search + sort nomor -->
                <div class="d-none d-md-block">
                    <div class="px-3 pt-3">
                        <table id="tableRekap" class="table table-hover align-middle mb-0 w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="50">No</th>
                                    <th>Kelas</th>
                                    <th class="text-center">Penilaian</th>
                                    <th class="text-center">Rata-rata</th>
                                    <th class="text-center">Tertinggi</th>
                                    <th class="text-center">Terendah</th>
                                    <th class="text-center">Predikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($rekap)): $no = 1; foreach ($rekap as $row):
                                    $avg = (float)$row->rata_rata;
                                    if ($row->jumlah_penilaian == 0)   { $p='secondary'; $l='Belum Ada Data'; }
                                    elseif ($avg >= 80)                { $p='success';   $l='Sangat Bersih'; }
                                    elseif ($avg >= 60)                { $p='primary';   $l='Bersih'; }
                                    elseif ($avg >= 40)                { $p='warning';   $l='Cukup'; }
                                    else                               { $p='danger';    $l='Kurang'; }
                                ?>
                                <tr>
                                    <td class="text-center text-muted"><?= $no++ ?></td>
                                    <td><strong><?= htmlspecialchars($row->class_name) ?></strong></td>
                                    <td class="text-center">
                                        <span class="badge bg-label-secondary"><?= $row->jumlah_penilaian ?>x</span>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-<?= $p ?>" style="font-size:1rem;"><?= $row->rata_rata ?? '-' ?></strong>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-success fw-semibold">
                                            <i class="bx bx-up-arrow-alt"></i><?= $row->tertinggi ?? '-' ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-danger fw-semibold">
                                            <i class="bx bx-down-arrow-alt"></i><?= $row->terendah ?? '-' ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-label-<?= $p ?>"><?= $l ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bx bx-info-circle d-block mb-2" style="font-size:2.5rem;opacity:0.25;"></i>
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
                    <div class="px-3 pt-3 pb-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bx bx-search text-muted"></i>
                            </span>
                            <input type="text" id="mobileSearchRekap"
                                class="form-control border-start-0" placeholder="Cari kelas..." />
                        </div>
                    </div>
                    <div class="px-3 pb-3">
                        <?php if (!empty($rekap)): $no = 1; foreach ($rekap as $row):
                            $avg = (float)$row->rata_rata;
                            if ($row->jumlah_penilaian == 0)   { $p='secondary'; $l='Belum Ada Data'; }
                            elseif ($avg >= 80)                { $p='success';   $l='Sangat Bersih'; }
                            elseif ($avg >= 60)                { $p='primary';   $l='Bersih'; }
                            elseif ($avg >= 40)                { $p='warning';   $l='Cukup'; }
                            else                               { $p='danger';    $l='Kurang'; }
                        ?>
                        <div class="mobile-rekap-card rounded-3 border bg-white p-3 mb-2"
                            data-name="<?= strtolower(htmlspecialchars($row->class_name)) ?>">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="text-muted fw-semibold flex-shrink-0" style="min-width:18px;font-size:0.8rem;"><?= $no++ ?></span>
                                <div class="flex-grow-1">
                                    <strong style="font-size:0.875rem;"><?= htmlspecialchars($row->class_name) ?></strong>
                                </div>
                                <span class="badge bg-label-<?= $p ?>"><?= $l ?></span>
                            </div>
                            <div class="ms-3 ps-3 border-start border-2" style="border-color:#eee !important;">
                                <div class="stat-row">
                                    <span class="label">Penilaian</span>
                                    <span class="badge bg-label-secondary"><?= $row->jumlah_penilaian ?>x</span>
                                </div>
                                <div class="stat-row">
                                    <span class="label">Rata-rata</span>
                                    <strong class="text-<?= $p ?>"><?= $row->rata_rata ?? '-' ?></strong>
                                </div>
                                <div class="stat-row">
                                    <span class="label">Tertinggi</span>
                                    <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i><?= $row->tertinggi ?? '-' ?></small>
                                </div>
                                <div class="stat-row">
                                    <span class="label">Terendah</span>
                                    <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i><?= $row->terendah ?? '-' ?></small>
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

        <!-- Ranking -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="m-0 me-2">Ranking Kebersihan</h5>
                        <small class="text-muted"><?= count($ranking) ?> kelas</small>
                    </div>
                    <span class="badge bg-label-warning px-3 py-2" style="font-size:0.8125rem;">
                        <i class="bx bx-trophy me-1"></i>Top Kelas
                    </span>
                </div>
                <div class="card-body px-0 pb-0">
                    <?php if (!empty($ranking)): ?>
                    <ul class="p-0 m-0">
                        <?php $rank = 1; foreach ($ranking as $row):
                            $avg = (float)$row->rata_rata;
                            if ($row->jumlah_penilaian == 0)   { $p='secondary'; $score='-'; }
                            elseif ($avg >= 80)                { $p='success';   $score=number_format($avg,1); }
                            elseif ($avg >= 60)                { $p='primary';   $score=number_format($avg,1); }
                            elseif ($avg >= 40)                { $p='warning';   $score=number_format($avg,1); }
                            else                               { $p='danger';    $score=number_format($avg,1); }

                            if ($rank == 1)     $medal = '🥇';
                            elseif ($rank == 2) $medal = '🥈';
                            elseif ($rank == 3) $medal = '🥉';
                            else                $medal = null;
                        ?>
                        <li class="d-flex align-items-center gap-3 px-4 <?= $rank < count($ranking) ? 'mb-3 pb-1' : 'mb-2' ?>">
                            <div class="avatar flex-shrink-0">
                                <?php if ($medal): ?>
                                    <span class="avatar-initial rounded bg-label-warning fs-5"><?= $medal ?></span>
                                <?php else: ?>
                                    <span class="avatar-initial rounded bg-label-secondary fw-bold" style="font-size:0.8rem;">#<?= $rank ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2 overflow-hidden">
                                    <h6 class="mb-0 text-truncate"><?= htmlspecialchars($row->class_name) ?></h6>
                                    <small class="text-muted"><?= $row->jumlah_penilaian ?> penilaian</small>
                                </div>
                                <div class="text-end flex-shrink-0">
                                    <h6 class="mb-0 text-<?= $p ?>"><?= $score ?></h6>
                                    <small class="text-muted">poin</small>
                                </div>
                            </div>
                        </li>
                        <?php $rank++; endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bx bx-trophy d-block mb-2" style="font-size:2.5rem;opacity:0.25;"></i>
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
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.DataTable !== 'undefined') {
        jQuery('#tableRekap').DataTable({
            paging      : true,
            searching   : true,   // aktifkan search box
            info        : true,
            pageLength  : 25,
            // kolom 0 (No) bisa di-sort, kolom 6 (Predikat) tidak
            columnDefs  : [
                { orderable: true,  targets: [0] },   // No bisa diurutkan
                { orderable: false, targets: [6] },   // Predikat tidak
                // Paksa kolom No agar sort numerik bukan string
                { type: 'num', targets: [0] }
            ],
            order       : [[0, 'asc']],  // default urut No asc
            language    : {
                search      : 'Cari kelas:',
                lengthMenu  : 'Tampilkan _MENU_ data',
                info        : 'Menampilkan _START_–_END_ dari _TOTAL_ kelas',
                infoEmpty   : 'Tidak ada data',
                zeroRecords : 'Kelas tidak ditemukan',
					paginate    : { previous: '&laquo;', next: '&raquo;' }
            },
            dom: '<"d-flex flex-wrap align-items-center justify-content-between gap-2 px-3 pt-3 pb-2"lf>t<"d-flex justify-content-between align-items-center px-3 pb-3 pt-2"ip>',
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
                var match = keyword === '' || (card.getAttribute('data-name') || '').includes(keyword);
                if (match) { card.classList.remove('hidden'); visible++; }
                else         card.classList.add('hidden');
            });
            if (empty) {
                if (visible === 0) empty.classList.remove('d-none');
                else               empty.classList.add('d-none');
            }
        });
    }
});
</script>
