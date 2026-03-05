<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
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

    <!-- Card Tabel -->
    <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0"><i class="bx bx-list-check me-2 text-primary"></i>Daftar Aspek Penilaian</h5>
            <small class="text-muted">Total: <strong><?= count($aspects) ?></strong> aspek</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Nama Aspek</th>
                            <th class="text-center">🟢 Bersih</th>
                            <th class="text-center">🟡 Cukup</th>
                            <th class="text-center">🔴 Kotor</th>
                            <th>Dibuat</th>
                            <th width="110" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($aspects)): ?>
                            <?php $no = 1; foreach ($aspects as $row): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-3 bg-label-info rounded">
                                            <span class="avatar-initial rounded"><i class="bx bx-check-shield"></i></span>
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
                                <td><span class="text-muted"><?= date('d M Y', strtotime($row->created_at)) ?></span></td>
                                <td class="text-center">
                                    <button type="button"
                                        class="btn btn-sm btn-icon btn-outline-warning me-1"
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
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bx bx-inbox fs-1 d-block mb-2"></i>
                                        Belum ada aspek penilaian.
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL TAMBAH ===== -->
<div class="modal fade" id="modalTambahAspek" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('aspects/store') ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-plus-circle me-2 text-primary"></i>Tambah Aspek Penilaian</h5>
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
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bx bx-x me-1"></i>Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== MODAL EDIT ===== -->
<div class="modal fade" id="modalEditAspek" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="example" action="" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-edit me-2 text-warning"></i>Edit Aspek Penilaian</h5>
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
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bx bx-x me-1"></i>Batal</button>
                    <button type="submit" class="btn btn-warning"><i class="bx bx-save me-1"></i>Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    // Isi data modal edit
    document.getElementById('modalEditAspek').addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        document.getElementById('edit_aspect_name').value  = btn.getAttribute('data-name');
        document.getElementById('edit_point_bersih').value = btn.getAttribute('data-bersih');
        document.getElementById('edit_point_cukup').value  = btn.getAttribute('data-cukup');
        document.getElementById('edit_point_kotor').value  = btn.getAttribute('data-kotor');
        document.getElementById('formEditAspek').action    = '<?= base_url('aspects/update/') ?>' + btn.getAttribute('data-id');
    });
});
</script>
