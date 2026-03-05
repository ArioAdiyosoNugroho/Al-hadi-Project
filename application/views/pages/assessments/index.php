<style>
.mobile-assess-card {
    transition: box-shadow 0.15s ease, border-color 0.15s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    cursor: default;
}
.mobile-assess-card:hover {
    box-shadow: 0 4px 14px rgba(105, 108, 255, 0.1);
    border-color: #d5d6ff !important;
}
.mobile-assess-card.hidden {
    display: none !important;
}
</style>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
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

    <div class="card shadow-sm">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
            <h5 class="mb-0">
                <i class="bx bx-building-house me-2 text-primary"></i>Daftar Kelas
            </h5>
            <span class="badge bg-label-primary px-3 py-2" style="font-size: 0.8125rem;">
                Total: <?= count($classes) ?> kelas
            </span>
        </div>
        <div class="card-body p-0">

            <!-- ===== DESKTOP TABLE (md ke atas) ===== -->
            <div class="d-none d-md-block">
                <div class="table-responsive">
                    <table id="example" class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="60" class="text-center ps-4">No</th>
                                <th>Nama Kelas</th>
                                <th class="text-center">Total Penilaian</th>
                                <th class="text-center">Penilaian Terakhir</th>
                                <th class="text-center">Status Hari Ini</th>
                                <th width="100" class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($classes)):
                                $today = date('Y-m-d');
                                $no    = 1;
                                foreach ($classes as $cls):
                                    $sudah_dinilai = $this->assessments->check_duplicate($cls->id, $today);
                                    $rekap         = $this->assessments->get_rekap_satu_kelas($cls->id);
                            ?>
                            <tr>
                                <td class="text-center text-muted ps-4"><?= $no++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar avatar-sm bg-label-primary rounded">
                                            <span class="avatar-initial rounded">
                                                <i class="bx bx-building-house" style="font-size:14px;"></i>
                                            </span>
                                        </div>
                                        <strong><?= htmlspecialchars($cls->class_name) ?></strong>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-label-primary"><?= $rekap->total_penilaian ?? 0 ?> kali</span>
                                </td>
                                <td class="text-center text-muted">
                                    <?= $rekap && $rekap->terakhir_dinilai
                                        ? date('d M Y', strtotime($rekap->terakhir_dinilai))
                                        : '<span class="fst-italic">Belum pernah</span>' ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($sudah_dinilai): ?>
                                        <span class="badge bg-success"><i class="bx bx-check me-1"></i>Sudah Dinilai</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><i class="bx bx-time me-1"></i>Belum Dinilai</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center pe-4">
                                    <a href="<?= base_url('assessments/class_detail/' . $cls->id) ?>"
                                       class="btn btn-sm btn-primary" title="Lihat Penilaian">
                                        <i class="bx bx-list-ul me-1"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bx bx-inbox d-block mb-2" style="font-size:2.5rem;opacity:0.3;"></i>
                                    <span class="text-muted">Belum ada kelas. Silakan tambahkan kelas terlebih dahulu.</span>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ===== MOBILE CARDS (di bawah md) ===== -->
            <div class="d-md-none">

                <!-- Search Mobile -->
                <div class="px-3 pt-3 pb-2">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 pe-1">
                            <i class="bx bx-search text-muted"></i>
                        </span>
                        <input type="text" id="mobileSearchAssess"
                            class="form-control border-start-0 ps-1"
                            placeholder="Cari kelas..." />
                    </div>
                </div>

                <!-- List Cards -->
                <div id="mobileAssessCardList" class="px-3 pb-3">
                    <?php if (!empty($classes)):
                        $today = date('Y-m-d');
                        $no    = 1;
                        foreach ($classes as $cls):
                            $sudah_dinilai = $this->assessments->check_duplicate($cls->id, $today);
                            $rekap         = $this->assessments->get_rekap_satu_kelas($cls->id);
                    ?>
                    <div class="mobile-assess-card d-flex align-items-center justify-content-between gap-2 p-3 mb-2 rounded-3 border bg-white"
                        data-name="<?= strtolower(htmlspecialchars($cls->class_name)) ?>">

                        <div class="d-flex align-items-start gap-3 overflow-hidden flex-grow-1">
                            <!-- Nomor -->
                            <span class="text-muted fw-semibold flex-shrink-0" style="min-width:20px;font-size:0.8125rem;padding-top:2px;">
                                <?= $no++ ?>
                            </span>
                            <!-- Avatar -->
                            <div class="avatar avatar-sm bg-label-primary rounded flex-shrink-0">
                                <span class="avatar-initial rounded">
                                    <i class="bx bx-building-house" style="font-size:13px;"></i>
                                </span>
                            </div>
                            <!-- Info -->
                            <div class="overflow-hidden flex-grow-1">
                                <strong class="d-block text-truncate mb-1" style="font-size:0.9rem;">
                                    <?= htmlspecialchars($cls->class_name) ?>
                                </strong>
                                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                    <!-- Status hari ini -->
                                    <?php if ($sudah_dinilai): ?>
                                        <span class="badge bg-success" style="font-size:0.7rem;">
                                            <i class="bx bx-check me-1"></i>Sudah Dinilai
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark" style="font-size:0.7rem;">
                                            <i class="bx bx-time me-1"></i>Belum Dinilai
                                        </span>
                                    <?php endif; ?>
                                    <!-- Total penilaian -->
                                    <span class="badge bg-label-primary" style="font-size:0.7rem;">
                                        <?= $rekap->total_penilaian ?? 0 ?> kali
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <i class="bx bx-calendar me-1" style="font-size:11px;"></i>
                                    <?= $rekap && $rekap->terakhir_dinilai
                                        ? 'Terakhir: ' . date('d M Y', strtotime($rekap->terakhir_dinilai))
                                        : '<span class="fst-italic">Belum pernah dinilai</span>' ?>
                                </small>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex-shrink-0">
                            <a href="<?= base_url('assessments/class_detail/' . $cls->id) ?>"
                               class="btn btn-sm btn-primary" title="Lihat Penilaian">
                                <i class="bx bx-list-ul"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>

                        <!-- Empty search state -->
                        <div id="mobileAssessEmpty" class="text-center py-4 d-none">
                            <i class="bx bx-search-alt d-block mb-2" style="font-size:2rem;opacity:0.3;"></i>
                            <span class="text-muted small">Kelas tidak ditemukan</span>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bx bx-inbox d-block mb-2" style="font-size:2.5rem;opacity:0.3;"></i>
                            <span class="text-muted">Belum ada kelas. Silakan tambahkan kelas terlebih dahulu.</span>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <!-- ===== / MOBILE CARDS ===== -->

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Mobile Search Filter
    var mobileSearch = document.getElementById('mobileSearchAssess');
    if (mobileSearch) {
        mobileSearch.addEventListener('input', function () {
            var keyword = this.value.toLowerCase().trim();
            var cards   = document.querySelectorAll('.mobile-assess-card');
            var empty   = document.getElementById('mobileAssessEmpty');
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
                if (visible === 0) {
                    empty.classList.remove('d-none');
                } else {
                    empty.classList.add('d-none');
                }
            }
        });
    }

});
</script>
