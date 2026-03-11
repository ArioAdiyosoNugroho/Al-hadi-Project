<style>
.mobile-assess-card {
    transition: box-shadow 0.15s ease, border-color 0.15s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    cursor: default;
}
.mobile-assess-card:hover {
    box-shadow: 0 4px 14px rgba(105,108,255,0.1);
    border-color: #d5d6ff !important;
}
.mobile-assess-card.hidden { display: none !important; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Al-Hadi /</span> Penilaian Kelas
            </h4>
            <p class="text-muted mb-0">Pilih kelas untuk melihat riwayat penilaian</p>
        </div>
        <a href="<?= base_url('assessments/create') ?>" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Tambah Penilaian
        </a>
    </div>

    <!-- Stat Cards -->
    <?php
        $today       = date('Y-m-d');
        $total_kelas = count($classes);
        $sudah_count = 0;
        foreach ($classes as $cls) {
            if ($this->assessments->check_duplicate($cls->id, $today)) $sudah_count++;
        }
        $belum_count = $total_kelas - $sudah_count;
    ?>
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-3">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-buildings"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Total Kelas</span>
                    <h3 class="card-title mb-0 text-primary"><?= $total_kelas ?></h3>
                    <small class="text-muted">kelas terdaftar</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-3">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-check-circle"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Sudah Dinilai</span>
                    <h3 class="card-title mb-0 text-success"><?= $sudah_count ?></h3>
                    <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> hari ini</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-3">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-time-five"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Belum Dinilai</span>
                    <h3 class="card-title mb-0 text-warning"><?= $belum_count ?></h3>
                    <small class="text-muted">perlu dinilai hari ini</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-3">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-calendar-check"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Tanggal</span>
                    <h3 class="card-title mb-0 text-info" style="font-size:1rem;"><?= date('d M Y') ?></h3>
                    <small class="text-muted">hari ini</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h5 class="m-0 me-2">Daftar Kelas</h5>
                <small class="text-muted"><?= $total_kelas ?> kelas terdaftar</small>
            </div>
            <span class="badge bg-label-primary px-3 py-2" style="font-size:0.8125rem;">
                <?= $sudah_count ?>/<?= $total_kelas ?> dinilai hari ini
            </span>
        </div>

        <!-- DESKTOP TABLE -->
        <div class="d-none d-md-block">
            <div class="table-responsive">
                <table id="example" class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="text-center ps-4">No</th>
                            <th>Nama Kelas</th>
                            <th class="text-center">Total Penilaian</th>
                            <th class="text-center">Penilaian Terakhir</th>
                            <th class="text-center">Status Hari Ini</th>
                            <th width="100" class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($classes)): $no = 1;
                            foreach ($classes as $cls):
                                $sudah_dinilai = $this->assessments->check_duplicate($cls->id, $today);
                                $rekap         = $this->assessments->get_rekap_satu_kelas($cls->id);
                                $bp            = $sudah_dinilai ? 'success' : 'warning';
                        ?>
                        <tr>
                            <td class="text-center text-muted ps-4"><?= $no++ ?></td>
                            <td>
                                <strong><?= htmlspecialchars($cls->class_name) ?></strong>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-label-secondary"><?= $rekap->total_penilaian ?? 0 ?>x</span>
                            </td>
                            <td class="text-center">
                                <small class="text-muted">
                                    <?= $rekap && $rekap->terakhir_dinilai
                                        ? date('d M Y', strtotime($rekap->terakhir_dinilai))
                                        : '<span class="fst-italic">Belum pernah</span>' ?>
                                </small>
                            </td>
                            <td class="text-center">
                                <?php if ($sudah_dinilai): ?>
                                    <span class="badge bg-label-success"><i class="bx bx-check me-1"></i>Sudah Dinilai</span>
                                <?php else: ?>
                                    <span class="badge bg-label-warning"><i class="bx bx-time me-1"></i>Belum Dinilai</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-4">
                                <a href="<?= base_url('assessments/class_detail/' . $cls->id) ?>" class="btn btn-sm btn-primary">
                                    <i class="bx bx-list-ul me-1"></i>Lihat
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bx bx-inbox d-block mb-2" style="font-size:2.5rem;opacity:0.25;"></i>
                                <span class="text-muted">Belum ada kelas. Silakan tambahkan kelas terlebih dahulu.</span>
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
                    <span class="input-group-text bg-white border-end-0"><i class="bx bx-search text-muted"></i></span>
                    <input type="text" id="mobileSearchAssess" class="form-control border-start-0" placeholder="Cari kelas..." />
                </div>
            </div>
            <div class="px-3 pb-3">
                <?php if (!empty($classes)): $no = 1;
                    foreach ($classes as $cls):
                        $sudah_dinilai = $this->assessments->check_duplicate($cls->id, $today);
                        $rekap         = $this->assessments->get_rekap_satu_kelas($cls->id);
                        $bp            = $sudah_dinilai ? 'success' : 'warning';
                ?>
                <div class="mobile-assess-card rounded-3 border bg-white p-3 mb-2"
                    data-name="<?= strtolower(htmlspecialchars($cls->class_name)) ?>">
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted fw-semibold flex-shrink-0" style="min-width:18px;font-size:0.8rem;"><?= $no++ ?></span>
                        <div class="flex-grow-1 overflow-hidden">
                            <strong class="d-block text-truncate mb-1" style="font-size:0.875rem;"><?= htmlspecialchars($cls->class_name) ?></strong>
                            <div class="d-flex flex-wrap gap-1 mb-1">
                                <?php if ($sudah_dinilai): ?>
                                    <span class="badge bg-label-success" style="font-size:0.7rem;"><i class="bx bx-check me-1"></i>Sudah Dinilai</span>
                                <?php else: ?>
                                    <span class="badge bg-label-warning" style="font-size:0.7rem;"><i class="bx bx-time me-1"></i>Belum Dinilai</span>
                                <?php endif; ?>
                                <span class="badge bg-label-secondary" style="font-size:0.7rem;"><?= $rekap->total_penilaian ?? 0 ?>x</span>
                            </div>
                            <small class="text-muted">
                                <i class="bx bx-calendar me-1" style="font-size:11px;"></i>
                                <?= $rekap && $rekap->terakhir_dinilai
                                    ? 'Terakhir: ' . date('d M Y', strtotime($rekap->terakhir_dinilai))
                                    : '<span class="fst-italic">Belum pernah dinilai</span>' ?>
                            </small>
                        </div>
                        <a href="<?= base_url('assessments/class_detail/' . $cls->id) ?>"
                           class="btn btn-sm btn-primary flex-shrink-0">
                            <i class="bx bx-list-ul"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
                <div id="mobileAssessEmpty" class="text-center py-4 d-none">
                    <i class="bx bx-search-alt d-block mb-2" style="font-size:2rem;opacity:0.3;"></i>
                    <span class="text-muted small">Kelas tidak ditemukan</span>
                </div>
                <?php else: ?>
                <div class="text-center py-5">
                    <i class="bx bx-inbox d-block mb-2" style="font-size:2.5rem;opacity:0.25;"></i>
                    <span class="text-muted">Belum ada kelas. Silakan tambahkan kelas terlebih dahulu.</span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var s = document.getElementById('mobileSearchAssess');
    if (s) {
        s.addEventListener('input', function () {
            var kw = this.value.toLowerCase().trim();
            var cards = document.querySelectorAll('.mobile-assess-card');
            var empty = document.getElementById('mobileAssessEmpty');
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
