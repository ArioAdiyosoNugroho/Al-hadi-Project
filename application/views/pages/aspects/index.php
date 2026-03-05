<style>
.mobile-aspect-card {
    transition: box-shadow 0.15s ease, border-color 0.15s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    cursor: default;
}
.mobile-aspect-card:hover {
    box-shadow: 0 4px 14px rgba(105, 108, 255, 0.1);
    border-color: #d5d6ff !important;
}
.mobile-aspect-card.hidden {
    display: none !important;
}
.point-list {
    display: flex;
    flex-direction: column;
    gap: 2px;
    margin: 3px 0;
}
.point-list-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.75rem;
    font-weight: 600;
    line-height: 1.4;
}
.point-list-item .dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}
.point-list-item.bersih .dot { background: #2e7d32; }
.point-list-item.cukup  .dot { background: #f57f17; }
.point-list-item.kotor  .dot { background: #c62828; }
.point-list-item.bersih { color: #2e7d32; }
.point-list-item.cukup  { color: #f57f17; }
.point-list-item.kotor  { color: #c62828; }
</style>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Al-Hadi /</span> Aspek Penilaian
            </h4>
            <p class="text-muted mb-0">Kelola aspek dan poin penilaian kebersihan kelas</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahAspek">
            <i class="bx bx-plus me-1"></i> Tambah Aspek
        </button>
    </div>

    <!-- Card -->
    <div class="card shadow-sm">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
            <h5 class="mb-0">
                <i class="bx bx-list-check me-2 text-primary"></i>Daftar Aspek Penilaian
            </h5>
            <span class="badge bg-label-primary px-3 py-2" style="font-size: 0.8125rem;">
                Total: <?= count($aspects) ?> aspek
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
                                <th>Nama Aspek</th>
                                <th class="text-center">🟢 Bersih</th>
                                <th class="text-center">🟡 Cukup</th>
                                <th class="text-center">🔴 Kotor</th>
                                <th>Dibuat</th>
                                <th width="120" class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($aspects)): ?>
                                <?php $no = 1; foreach ($aspects as $row): ?>
                                <tr>
                                    <td class="text-center text-muted ps-4"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar avatar-sm bg-label-primary rounded">
                                                <span class="avatar-initial rounded">
                                                    <i class="bx bx-check-shield" style="font-size:14px;"></i>
                                                </span>
                                            </div>
                                            <strong><?= htmlspecialchars($row->aspect_name) ?></strong>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><?= $row->point_bersih ?> poin</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark"><?= $row->point_cukup ?> poin</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger"><?= $row->point_kotor ?> poin</span>
                                    </td>
                                    <td class="text-muted">
                                        <i class="bx bx-calendar me-1" style="font-size:13px;"></i>
                                        <?= date('d M Y', strtotime($row->created_at)) ?>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-outline-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditAspek"
                                                data-id="<?= $row->id ?>"
                                                data-name="<?= htmlspecialchars($row->aspect_name) ?>"
                                                data-bersih="<?= $row->point_bersih ?>"
                                                data-cukup="<?= $row->point_cukup ?>"
                                                data-kotor="<?= $row->point_kotor ?>"
                                                title="Edit">
                                                <i class="bx bx-edit-alt"></i>
                                            </button>
                                            <a href="<?= base_url('aspects/delete/' . $row->id) ?>"
                                                class="btn btn-sm btn-icon btn-outline-danger btn-delete"
                                                data-name="<?= htmlspecialchars($row->aspect_name) ?>"
                                                title="Hapus">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bx bx-inbox d-block mb-2" style="font-size:2.5rem;opacity:0.3;"></i>
                                        <span class="text-muted">Belum ada aspek penilaian.</span>
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
                        <input type="text" id="mobileSearchAspek"
                            class="form-control border-start-0 ps-1"
                            placeholder="Cari aspek penilaian..." />
                    </div>
                </div>

                <!-- List Cards -->
                <div id="mobileAspekCardList" class="px-3 pb-3">
                    <?php if (!empty($aspects)): ?>
                        <?php $no = 1; foreach ($aspects as $row): ?>
                        <div class="mobile-aspect-card d-flex align-items-center justify-content-between gap-2 p-3 mb-2 rounded-3 border bg-white"
                            data-name="<?= strtolower(htmlspecialchars($row->aspect_name)) ?>">

                            <div class="d-flex align-items-start gap-3 overflow-hidden flex-grow-1">
                                <!-- Nomor -->
                                <span class="text-muted fw-semibold flex-shrink-0" style="min-width:20px;font-size:0.8125rem;padding-top:2px;">
                                    <?= $no++ ?>
                                </span>
                                <!-- Avatar -->
                                <div class="avatar avatar-sm bg-label-primary rounded flex-shrink-0">
                                    <span class="avatar-initial rounded">
                                        <i class="bx bx-check-shield" style="font-size:13px;"></i>
                                    </span>
                                </div>
                                <!-- Info -->
                                <div class="overflow-hidden flex-grow-1">
                                    <strong class="d-block text-truncate mb-1" style="font-size:0.9rem;">
                                        <?= htmlspecialchars($row->aspect_name) ?>
                                    </strong>
                                    <!-- Poin list vertikal -->
                                    <div class="point-list mb-1">
                                        <span class="point-list-item bersih">
                                            <span class="dot"></span> Bersih: <?= $row->point_bersih ?> poin
                                        </span>
                                        <span class="point-list-item cukup">
                                            <span class="dot"></span> Cukup: <?= $row->point_cukup ?> poin
                                        </span>
                                        <span class="point-list-item kotor">
                                            <span class="dot"></span> Kotor: <?= $row->point_kotor ?> poin
                                        </span>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bx bx-calendar me-1" style="font-size:11px;"></i>
                                        <?= date('d M Y', strtotime($row->created_at)) ?>
                                    </small>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="d-flex flex-column gap-1 flex-shrink-0">
                                <button type="button"
                                    class="btn btn-sm btn-icon btn-outline-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditAspek"
                                    data-id="<?= $row->id ?>"
                                    data-name="<?= htmlspecialchars($row->aspect_name) ?>"
                                    data-bersih="<?= $row->point_bersih ?>"
                                    data-cukup="<?= $row->point_cukup ?>"
                                    data-kotor="<?= $row->point_kotor ?>"
                                    title="Edit">
                                    <i class="bx bx-edit-alt"></i>
                                </button>
                                <a href="<?= base_url('aspects/delete/' . $row->id) ?>"
                                    class="btn btn-sm btn-icon btn-outline-danger btn-delete"
                                    data-name="<?= htmlspecialchars($row->aspect_name) ?>"
                                    title="Hapus">
                                    <i class="bx bx-trash"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <!-- Empty search state -->
                        <div id="mobileAspekEmpty" class="text-center py-4 d-none">
                            <i class="bx bx-search-alt d-block mb-2" style="font-size:2rem;opacity:0.3;"></i>
                            <span class="text-muted small">Aspek tidak ditemukan</span>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bx bx-inbox d-block mb-2" style="font-size:2.5rem;opacity:0.3;"></i>
                            <span class="text-muted">Belum ada aspek penilaian.</span>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <!-- ===== / MOBILE CARDS ===== -->

        </div>
    </div>
</div>


<!-- ===== MODAL TAMBAH ASPEK ===== -->
<div class="modal fade" id="modalTambahAspek" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('aspects/store') ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bx bx-plus-circle me-2 text-primary"></i>Tambah Aspek Penilaian
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Aspek <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="aspect_name"
                            placeholder="Contoh: Kebersihan Lantai, Kebersihan Meja..." required autofocus />
                    </div>
                    <p class="text-muted small mb-2">Tentukan poin untuk setiap kondisi:</p>
                    <div class="row g-3">
                        <div class="col-4">
                            <label class="form-label fw-semibold text-success">🟢 Bersih <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control text-center" name="point_bersih"
                                    placeholder="10" min="0" required />
                                <span class="input-group-text small">poin</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-semibold text-warning">🟡 Cukup <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control text-center" name="point_cukup"
                                    placeholder="5" min="0" required />
                                <span class="input-group-text small">poin</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-semibold text-danger">🔴 Kotor <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control text-center" name="point_kotor"
                                    placeholder="0" min="0" required />
                                <span class="input-group-text small">poin</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-text text-muted mt-2">
                        <i class="bx bx-info-circle me-1"></i>Poin Bersih harus ≥ Cukup, dan Cukup harus ≥ Kotor.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ===== MODAL EDIT ASPEK ===== -->
<div class="modal fade" id="modalEditAspek" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formEditAspek" action="" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bx bx-edit me-2 text-warning"></i>Edit Aspek Penilaian
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Aspek <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_aspect_name" name="aspect_name" required />
                    </div>
                    <p class="text-muted small mb-2">Tentukan poin untuk setiap kondisi:</p>
                    <div class="row g-3">
                        <div class="col-4">
                            <label class="form-label fw-semibold text-success">🟢 Bersih <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control text-center" id="edit_point_bersih" name="point_bersih" min="0" required />
                                <span class="input-group-text small">poin</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-semibold text-warning">🟡 Cukup <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control text-center" id="edit_point_cukup" name="point_cukup" min="0" required />
                                <span class="input-group-text small">poin</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-semibold text-danger">🔴 Kotor <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control text-center" id="edit_point_kotor" name="point_kotor" min="0" required />
                                <span class="input-group-text small">poin</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-text text-muted mt-2">
                        <i class="bx bx-info-circle me-1"></i>Poin Bersih harus ≥ Cukup, dan Cukup harus ≥ Kotor.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bx bx-save me-1"></i>Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== Modal Edit - isi data =====
    var modalEditEl = document.getElementById('modalEditAspek');
    if (modalEditEl) {
        modalEditEl.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            document.getElementById('edit_aspect_name').value  = btn.getAttribute('data-name');
            document.getElementById('edit_point_bersih').value = btn.getAttribute('data-bersih');
            document.getElementById('edit_point_cukup').value  = btn.getAttribute('data-cukup');
            document.getElementById('edit_point_kotor').value  = btn.getAttribute('data-kotor');
            document.getElementById('formEditAspek').action    = '<?= base_url('aspects/update/') ?>' + btn.getAttribute('data-id');
        });
    }

    // ===== Mobile Search Filter =====
    var mobileSearch = document.getElementById('mobileSearchAspek');
    if (mobileSearch) {
        mobileSearch.addEventListener('input', function () {
            var keyword = this.value.toLowerCase().trim();
            var cards   = document.querySelectorAll('.mobile-aspect-card');
            var empty   = document.getElementById('mobileAspekEmpty');
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
