<!-- views/pages/reports/index.php -->
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
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

    <!-- Filter Bulan -->
    <div class="card shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end g-3">
                <div class="col-auto">
                    <label class="form-label fw-semibold mb-1">Bulan</label>
                    <select id="filterBulan" class="form-select">
                        <?php
                        $bulan_list = [
                            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
                            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
                            9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
                        ];
                        foreach ($bulan_list as $n => $nm):
                        ?>
                        <option value="<?= $n ?>" <?= $bulan == $n ? 'selected' : '' ?>><?= $nm ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-auto">
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
                <div class="col-auto ms-auto text-end">
                    <span class="text-muted small">
                        Periode: <strong><?php
                            $bn = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                                   7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                            echo $bn[$bulan] . ' ' . $tahun;
                        ?></strong>
                    </span>
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
            <div class="card shadow-sm text-center border-top border-3 border-primary">
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
            <div class="card shadow-sm text-center border-top border-3 border-info">
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
            <div class="card shadow-sm text-center border-top border-3 border-success">
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
            <div class="card shadow-sm text-center border-top border-3 border-warning">
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

    <div class="row g-4">
        <!-- Rekap Nilai Per Kelas -->
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0">
                        <i class="bx bx-table me-2 text-primary"></i>
                        Nilai Kebersihan — <?= $bn_label[$bulan] . ' ' . $tahun ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableRekap" class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="50">No</th>
                                    <th>Nama Kelas</th>
                                    <th class="text-center">Penilaian</th>
                                    <th class="text-center">Rata-rata</th>
                                    <th class="text-center">Tertinggi</th>
                                    <th class="text-center">Terendah</th>
                                    <th class="text-center">Predikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($rekap)): $no = 1; foreach ($rekap as $row): ?>
                                <?php
                                    $avg = (float)$row->rata_rata;
                                    if ($row->jumlah_penilaian == 0)    { $p='secondary'; $l='Belum Ada Data'; }
                                    elseif ($avg >= 80)                 { $p='success';   $l='Sangat Bersih'; }
                                    elseif ($avg >= 60)                 { $p='primary';   $l='Bersih'; }
                                    elseif ($avg >= 40)                 { $p='warning';   $l='Cukup'; }
                                    else                                { $p='danger';    $l='Kurang'; }
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><strong><?= htmlspecialchars($row->class_name) ?></strong></td>
                                    <td class="text-center"><?= $row->jumlah_penilaian ?> kali</td>
                                    <td class="text-center">
                                        <span class="fw-bold text-<?= $p ?>"><?= $row->rata_rata ?? '-' ?></span>
                                    </td>
                                    <td class="text-center text-success fw-bold"><?= $row->tertinggi ?? '-' ?></td>
                                    <td class="text-center text-danger fw-bold"><?= $row->terendah ?? '-' ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-<?= $p ?>"><?= $l ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr><td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bx bx-info-circle fs-1 d-block mb-2"></i>
                                    Tidak ada data penilaian untuk bulan ini.
                                </td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ranking -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header py-3">
                    <h5 class="mb-0">
                        <i class="bx bx-trophy me-2 text-warning"></i>
                        Ranking Kebersihan
                    </h5>
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

                            // Medali untuk top 3
                            if ($rank == 1)     $medal = '🥇';
                            elseif ($rank == 2) $medal = '🥈';
                            elseif ($rank == 3) $medal = '🥉';
                            else                $medal = $rank;
                        ?>
                        <li class="list-group-item d-flex align-items-center px-3 py-2">
                            <span class="me-3 fs-5" style="min-width:30px;text-align:center"><?= $medal ?></span>
                            <div class="flex-grow-1">
                                <div class="fw-semibold"><?= htmlspecialchars($row->class_name) ?></div>
                                <small class="text-muted"><?= $row->jumlah_penilaian ?> penilaian</small>
                            </div>
                            <span class="badge bg-<?= $p ?> ms-2"><?= $l ?></span>
                        </li>
                        <?php $rank++; endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bx bx-trophy fs-1 d-block mb-2"></i>
                        Belum ada data ranking.
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
                paging: false, searching: false, info: false,
                order: [[3, 'desc']],
                columnDefs: [{ orderable: false, targets: [0, 6] }]
            });
        }
    });
</script>
