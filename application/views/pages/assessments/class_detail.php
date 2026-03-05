<style>
.mobile-detail-card {
    transition: box-shadow 0.15s ease, border-color 0.15s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    cursor: default;
}
.mobile-detail-card:hover {
    box-shadow: 0 4px 14px rgba(105, 108, 255, 0.1);
    border-color: #d5d6ff !important;
}
.mobile-detail-card.hidden {
    display: none !important;
}
.predikat-badge {
    font-size: 0.7rem;
    padding: 3px 8px;
}
</style>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">
                    Al-Hadi /
                    <a href="<?= base_url('assessments') ?>" class="text-muted">Penilaian</a> /
                </span>
                <?= htmlspecialchars($kelas->class_name) ?>
            </h4>
            <p class="text-muted mb-0">Riwayat penilaian kebersihan <?= htmlspecialchars($kelas->class_name) ?></p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('assessments') ?>" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
            <?php $sudah_dinilai_hari_ini = $this->assessments->check_duplicate($kelas->id, date('Y-m-d')); ?>
            <?php if (!$sudah_dinilai_hari_ini): ?>
            <a href="<?= base_url('assessments/create?class_id=' . $kelas->id) ?>" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Nilai Hari Ini
            </a>
            <?php else: ?>
            <button class="btn btn-success" disabled>
                <i class="bx bx-check me-1"></i> Sudah Dinilai Hari Ini
            </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
            <h5 class="mb-0">
                <i class="bx bx-clipboard me-2 text-primary"></i>
                Riwayat Penilaian — <?= htmlspecialchars($kelas->class_name) ?>
            </h5>
            <span class="badge bg-label-primary px-3 py-2" style="font-size: 0.8125rem;">
                Total: <?= count($assessments) ?> penilaian
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
                                <th>Tanggal Penilaian</th>
                                <th>Dinilai Oleh</th>
                                <th class="text-center">Total Poin</th>
                                <th class="text-center">Predikat</th>
                                <th width="130" class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($assessments as $row):
                                if ($row->total_point >= 80)      $predikat = ['label' => 'Sangat Bersih', 'class' => 'bg-success'];
                                elseif ($row->total_point >= 60)  $predikat = ['label' => 'Bersih',        'class' => 'bg-primary'];
                                elseif ($row->total_point >= 40)  $predikat = ['label' => 'Cukup',         'class' => 'bg-warning text-dark'];
                                else                              $predikat = ['label' => 'Kurang',         'class' => 'bg-danger'];
                            ?>
                            <tr>
                                <td class="text-center text-muted ps-4"><?= $no++ ?></td>
                                <td>
                                    <i class="bx bx-calendar me-1 text-muted" style="font-size:13px;"></i>
                                    <?= date('d M Y', strtotime($row->assessment_date)) ?>
                                    <?php if ($row->assessment_date === date('Y-m-d')): ?>
                                        <span class="badge bg-label-info ms-1">Hari ini</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar avatar-xs bg-label-secondary rounded">
                                            <span class="avatar-initial rounded">
                                                <i class="bx bx-user" style="font-size:11px;"></i>
                                            </span>
                                        </div>
                                        <?= htmlspecialchars($row->admin_name) ?>
                                    </div>
                                </td>
                                <td class="text-center fw-bold fs-5"><?= $row->total_point ?></td>
                                <td class="text-center">
                                    <span class="badge <?= $predikat['class'] ?>"><?= $predikat['label'] ?></span>
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

            <!-- ===== MOBILE CARDS (di bawah md) ===== -->
            <div class="d-md-none">

                <!-- Search Mobile -->
                <div class="px-3 pt-3 pb-2">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 pe-1">
                            <i class="bx bx-search text-muted"></i>
                        </span>
                        <input type="text" id="mobileSearchDetail"
                            class="form-control border-start-0 ps-1"
                            placeholder="Cari tanggal atau penilai..." />
                    </div>
                </div>

                <!-- List Cards -->
                <div id="mobileDetailCardList" class="px-3 pb-3">
                    <?php if (!empty($assessments)):
                        $no = 1;
                        foreach ($assessments as $row):
                            if ($row->total_point >= 80)      $predikat = ['label' => 'Sangat Bersih', 'class' => 'bg-success'];
                            elseif ($row->total_point >= 60)  $predikat = ['label' => 'Bersih',        'class' => 'bg-primary'];
                            elseif ($row->total_point >= 40)  $predikat = ['label' => 'Cukup',         'class' => 'bg-warning text-dark'];
                            else                              $predikat = ['label' => 'Kurang',         'class' => 'bg-danger'];
                            $search_key = strtolower(date('d M Y', strtotime($row->assessment_date)) . ' ' . $row->admin_name);
                    ?>
                    <div class="mobile-detail-card d-flex align-items-center justify-content-between gap-2 p-3 mb-2 rounded-3 border bg-white"
                        data-name="<?= htmlspecialchars($search_key) ?>">

                        <div class="d-flex align-items-start gap-3 overflow-hidden flex-grow-1">
                            <!-- Nomor -->
                            <span class="text-muted fw-semibold flex-shrink-0" style="min-width:20px;font-size:0.8125rem;padding-top:2px;">
                                <?= $no++ ?>
                            </span>
                            <!-- Poin besar -->
                            <div class="flex-shrink-0 text-center" style="min-width:44px;">
                                <div class="fw-bold" style="font-size:1.35rem;line-height:1.2;"><?= $row->total_point ?></div>
                                <div style="font-size:0.65rem;color:#aaa;line-height:1;">poin</div>
                            </div>
                            <!-- Info -->
                            <div class="overflow-hidden flex-grow-1">
                                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                    <strong style="font-size:0.875rem;">
                                        <?= date('d M Y', strtotime($row->assessment_date)) ?>
                                    </strong>
                                    <?php if ($row->assessment_date === date('Y-m-d')): ?>
                                        <span class="badge bg-label-info" style="font-size:0.65rem;">Hari ini</span>
                                    <?php endif; ?>
                                    <span class="badge predikat-badge <?= $predikat['class'] ?>"><?= $predikat['label'] ?></span>
                                </div>
                                <small class="text-muted d-block">
                                    <i class="bx bx-user me-1" style="font-size:11px;"></i>
                                    <?= htmlspecialchars($row->admin_name) ?>
                                </small>
                            </div>
                        </div>

                        <!-- Tombol Aksi (vertikal) -->
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
                    <?php endforeach; ?>

                        <!-- Empty search state -->
                        <div id="mobileDetailEmpty" class="text-center py-4 d-none">
                            <i class="bx bx-search-alt d-block mb-2" style="font-size:2rem;opacity:0.3;"></i>
                            <span class="text-muted small">Penilaian tidak ditemukan</span>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bx bx-inbox d-block mb-2" style="font-size:2.5rem;opacity:0.3;"></i>
                            <span class="text-muted">Belum ada riwayat penilaian.</span>
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
    var mobileSearch = document.getElementById('mobileSearchDetail');
    if (mobileSearch) {
        mobileSearch.addEventListener('input', function () {
            var keyword = this.value.toLowerCase().trim();
            var cards   = document.querySelectorAll('.mobile-detail-card');
            var empty   = document.getElementById('mobileDetailEmpty');
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
