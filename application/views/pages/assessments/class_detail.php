<style>
.mobile-detail-card {
    transition: box-shadow 0.15s ease, border-color 0.15s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    cursor: default;
}
.mobile-detail-card:hover {
    box-shadow: 0 4px 14px rgba(105,108,255,0.1);
    border-color: #d5d6ff !important;
}
.mobile-detail-card.hidden { display: none !important; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">
                    Al-Hadi / <a href="<?= base_url('assessments') ?>" class="text-muted">Penilaian</a> /
                </span>
                <?= htmlspecialchars($kelas->class_name) ?>
            </h4>
            <p class="text-muted mb-0">Riwayat penilaian kebersihan <?= htmlspecialchars($kelas->class_name) ?></p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('assessments') ?>" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i>Kembali
            </a>
            <?php $sudah_dinilai_hari_ini = $this->assessments->check_duplicate($kelas->id, date('Y-m-d')); ?>
            <?php if (!$sudah_dinilai_hari_ini): ?>
            <a href="<?= base_url('assessments/create?class_id=' . $kelas->id) ?>" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i>Nilai Hari Ini
            </a>
            <?php else: ?>
            <button class="btn btn-outline-success" disabled>
                <i class="bx bx-check me-1"></i>Sudah Dinilai Hari Ini
            </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Stat Cards -->
    <?php
        $total_ass  = count($assessments);
        $pts        = array_column((array)$assessments, 'total_point');
        $avg_all    = $total_ass > 0 ? round(array_sum($pts) / $total_ass, 1) : 0;
        $max_point  = $total_ass > 0 ? max($pts) : 0;
    ?>
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-3">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-clipboard"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Total Penilaian</span>
                    <h3 class="card-title mb-0 text-primary"><?= $total_ass ?></h3>
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
                    <h3 class="card-title mb-0 text-success"><?= $avg_all ?></h3>
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
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Poin Tertinggi</span>
                    <h3 class="card-title mb-0 text-warning"><?= $max_point ?: '-' ?></h3>
                    <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> terbaik</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-3">
                        <div class="avatar flex-shrink-0">
                            <?php if ($sudah_dinilai_hari_ini): ?>
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-check-circle"></i></span>
                            <?php else: ?>
                            <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-time-five"></i></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Status Hari Ini</span>
                    <?php if ($sudah_dinilai_hari_ini): ?>
                    <h3 class="card-title mb-0 text-success" style="font-size:1rem;">Sudah Dinilai</h3>
                    <small class="text-success fw-semibold"><i class="bx bx-check"></i> selesai</small>
                    <?php else: ?>
                    <h3 class="card-title mb-0 text-warning" style="font-size:1rem;">Belum Dinilai</h3>
                    <small class="text-muted">perlu dinilai</small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Table Card -->
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h5 class="m-0 me-2">Riwayat Penilaian</h5>
                <small class="text-muted"><?= htmlspecialchars($kelas->class_name) ?></small>
            </div>
            <span class="badge bg-label-primary px-3 py-2" style="font-size:0.8125rem;">
                <?= count($assessments) ?> penilaian
            </span>
        </div>

        <!-- DESKTOP TABLE -->
        <div class="d-none d-md-block">
            <div class="table-responsive">
                <table id="example" class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="text-center ps-4">No</th>
                            <th>Tanggal Penilaian</th>
                            <th>Dinilai Oleh</th>
                            <th class="text-center">Total Poin</th>
                            <th class="text-center">Predikat</th>
                            <th width="130" class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($assessments as $row):
                            if ($row->total_point >= 80)      { $p='success'; $l='Sangat Bersih'; }
                            elseif ($row->total_point >= 60)  { $p='primary'; $l='Bersih'; }
                            elseif ($row->total_point >= 40)  { $p='warning'; $l='Cukup'; }
                            else                              { $p='danger';  $l='Kurang'; }
                        ?>
                        <tr>
                            <td class="text-center text-muted ps-4"><?= $no++ ?></td>
                            <td>
                                <?= date('d M Y', strtotime($row->assessment_date)) ?>
                                <?php if ($row->assessment_date === date('Y-m-d')): ?>
                                    <span class="badge bg-label-info ms-1" style="font-size:0.7rem;">Hari ini</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row->admin_name) ?></td>
                            <td class="text-center">
                                <strong class="text-<?= $p ?>" style="font-size:1.1rem;"><?= $row->total_point ?></strong>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-label-<?= $p ?>"><?= $l ?></span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="<?= base_url('assessments/detail/' . $row->id) ?>"
                                        class="btn btn-sm btn-icon btn-outline-info" title="Detail">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <a href="<?= base_url('assessments/edit/' . $row->id) ?>"
                                        class="btn btn-sm btn-icon btn-outline-warning" title="Edit">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>
                                    <a href="<?= base_url('assessments/delete/' . $row->id) ?>"
                                        class="btn btn-sm btn-icon btn-outline-danger btn-delete"
                                        data-name="penilaian tanggal <?= date('d M Y', strtotime($row->assessment_date)) ?>"
                                        title="Hapus">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MOBILE CARDS -->
        <div class="d-md-none">
            <div class="px-3 pt-3 pb-2">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="bx bx-search text-muted"></i></span>
                    <input type="text" id="mobileSearchDetail" class="form-control border-start-0"
                        placeholder="Cari tanggal atau penilai..." />
                </div>
            </div>
            <div class="px-3 pb-3">
                <?php if (!empty($assessments)): $no = 1;
                    foreach ($assessments as $row):
                        if ($row->total_point >= 80)      { $p='success'; $l='Sangat Bersih'; }
                        elseif ($row->total_point >= 60)  { $p='primary'; $l='Bersih'; }
                        elseif ($row->total_point >= 40)  { $p='warning'; $l='Cukup'; }
                        else                              { $p='danger';  $l='Kurang'; }
                        $sk = strtolower(date('d M Y', strtotime($row->assessment_date)) . ' ' . $row->admin_name);
                ?>
                <div class="mobile-detail-card rounded-3 border bg-white p-3 mb-2"
                    data-name="<?= htmlspecialchars($sk) ?>">
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted fw-semibold flex-shrink-0" style="min-width:18px;font-size:0.8rem;"><?= $no++ ?></span>
                        <div class="flex-shrink-0 text-center" style="min-width:44px;">
                            <strong class="text-<?= $p ?>" style="font-size:1.35rem;line-height:1.1;"><?= $row->total_point ?></strong>
                            <div class="text-muted" style="font-size:0.65rem;">poin</div>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                <strong style="font-size:0.875rem;"><?= date('d M Y', strtotime($row->assessment_date)) ?></strong>
                                <?php if ($row->assessment_date === date('Y-m-d')): ?>
                                    <span class="badge bg-label-info" style="font-size:0.65rem;">Hari ini</span>
                                <?php endif; ?>
                                <span class="badge bg-label-<?= $p ?>" style="font-size:0.7rem;"><?= $l ?></span>
                            </div>
                            <small class="text-muted">
                                <i class="bx bx-user me-1" style="font-size:11px;"></i>
                                <?= htmlspecialchars($row->admin_name) ?>
                            </small>
                        </div>
                        <div class="d-flex flex-column gap-1 flex-shrink-0">
                            <a href="<?= base_url('assessments/detail/' . $row->id) ?>"
                                class="btn btn-sm btn-icon btn-outline-info" title="Detail">
                                <i class="bx bx-show"></i>
                            </a>
                            <a href="<?= base_url('assessments/edit/' . $row->id) ?>"
                                class="btn btn-sm btn-icon btn-outline-warning" title="Edit">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <a href="<?= base_url('assessments/delete/' . $row->id) ?>"
                                class="btn btn-sm btn-icon btn-outline-danger btn-delete"
                                data-name="penilaian tanggal <?= date('d M Y', strtotime($row->assessment_date)) ?>"
                                title="Hapus">
                                <i class="bx bx-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <div id="mobileDetailEmpty" class="text-center py-4 d-none">
                    <i class="bx bx-search-alt d-block mb-2" style="font-size:2rem;opacity:0.3;"></i>
                    <span class="text-muted small">Penilaian tidak ditemukan</span>
                </div>
                <?php else: ?>
                <div class="text-center py-5">
                    <i class="bx bx-inbox d-block mb-2" style="font-size:2.5rem;opacity:0.25;"></i>
                    <span class="text-muted">Belum ada riwayat penilaian.</span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var s = document.getElementById('mobileSearchDetail');
    if (s) {
        s.addEventListener('input', function () {
            var kw = this.value.toLowerCase().trim();
            var cards = document.querySelectorAll('.mobile-detail-card');
            var empty = document.getElementById('mobileDetailEmpty');
            var vis = 0;
            cards.forEach(function (c) {
                var match = kw === '' || (c.getAttribute('data-name') || '').includes(kw);
                if (match) { c.classList.remove('hidden'); vis++; } else c.classList.add('hidden');
            });
            if (empty) { if (vis === 0) empty.classList.remove('d-none'); else empty.classList.add('d-none'); }
        });
    }
});
</script>
