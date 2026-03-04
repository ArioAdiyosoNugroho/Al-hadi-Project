<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Al-Hadi /</span> Kelola Kelas
            </h4>
            <p class="text-muted mb-0">Manajemen data kelas Sekolah Al-Hadi</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
            <i class="bx bx-plus me-1"></i> Tambah Kelas
        </button>
    </div>

    <!-- Card Tabel Kelas -->
    <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0"><i class="bx bx-group me-2 text-primary"></i>Daftar Kelas</h5>
            <small class="text-muted">Total: <strong><?= count($classes) ?></strong> kelas</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60" class="text-center">No</th>
                            <th>Nama Kelas</th>
                            <th>Tanggal Dibuat</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($classes)): ?>
                            <?php $no = 1; foreach ($classes as $row): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-3 bg-label-primary rounded">
                                            <span class="avatar-initial rounded"><i class="bx bx-building-house"></i></span>
                                        </div>
                                        <strong><?= htmlspecialchars($row->class_name) ?></strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        <?= date('d M Y, H:i', strtotime($row->created_at)) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <!-- Tombol Edit -->
                                    <button type="button"
                                        class="btn btn-sm btn-icon btn-outline-warning me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditKelas"
                                        data-id="<?= $row->id ?>"
                                        data-name="<?= htmlspecialchars($row->class_name) ?>"
                                        title="Edit">
                                        <i class="bx bx-edit-alt"></i>
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <a href="<?= base_url('classes/delete/' . $row->id) ?>"
                                        class="btn btn-sm btn-icon btn-outline-danger btn-delete"
                                        data-name="<?= htmlspecialchars($row->class_name) ?>"
                                        title="Hapus">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bx bx-inbox fs-1 d-block mb-2"></i>
                                        Belum ada data kelas. Silakan tambahkan kelas baru.
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
<!-- / Content -->


<!-- ===== MODAL TAMBAH KELAS ===== -->
<div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('classes/store') ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bx bx-plus-circle me-2 text-primary"></i>Tambah Kelas Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="class_name_add" class="form-label fw-semibold">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="class_name_add" name="class_name"
                            placeholder="Contoh: Kelas 7A, Kelas 8B..." required autofocus />
                        <div class="form-text text-muted">Masukkan nama kelas yang unik dan mudah dikenali.</div>
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
<!-- ===== / MODAL TAMBAH KELAS ===== -->


<!-- ===== MODAL EDIT KELAS ===== -->
<div class="modal fade" id="modalEditKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formEditKelas" action="" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bx bx-edit me-2 text-warning"></i>Edit Kelas
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="class_name_edit" class="form-label fw-semibold">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="class_name_edit" name="class_name"
                            placeholder="Masukkan nama kelas..." required />
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
<!-- ===== / MODAL EDIT KELAS ===== -->


<script>
// Modal Edit - tidak butuh jQuery
document.addEventListener('DOMContentLoaded', function () {
    var modalEditEl = document.getElementById('modalEditKelas');
    if (modalEditEl) {
        modalEditEl.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            document.getElementById('class_name_edit').value = btn.getAttribute('data-name');
            document.getElementById('formEditKelas').action  = '<?= base_url('classes/update/') ?>' + btn.getAttribute('data-id');
        });
    }
});
</script>
