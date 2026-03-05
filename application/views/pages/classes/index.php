<style>
	.mobile-class-card.hidden {
    display: none !important;
}
</style>
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
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
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
            <h5 class="mb-0">
                <i class="bx bx-home me-2 text-primary"></i>Daftar Kelas
            </h5>
            <span class="badge bg-label-primary px-3 py-2" style="font-size: 0.8125rem;">
                Total: <?= count($classes) ?> kelas
            </span>
        </div>
        <div class="card-body p-0">

            <!-- ===== DESKTOP TABLE (md ke atas) ===== -->
            <div class="d-none d-md-block">
                <div class="table-responsive p-3">
                    <table id="example" class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="60" class="text-center ps-4">No</th>
                                <th>Nama Kelas</th>
                                <th>Tanggal Dibuat</th>
                                <th width="120" class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($classes)): ?>
                                <?php $no = 1; foreach ($classes as $row): ?>
                                <tr>
                                    <td class="text-center text-muted ps-4"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar avatar-sm bg-label-primary rounded">
                                                <span class="avatar-initial rounded">
                                                    <i class="bx bx-building-house" style="font-size:14px;"></i>
                                                </span>
                                            </div>
                                            <strong><?= htmlspecialchars($row->class_name) ?></strong>
                                        </div>
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
                                                data-bs-target="#modalEditKelas"
                                                data-id="<?= $row->id ?>"
                                                data-name="<?= htmlspecialchars($row->class_name) ?>"
                                                title="Edit">
                                                <i class="bx bx-edit-alt"></i>
                                            </button>
                                            <a href="<?= base_url('classes/delete/' . $row->id) ?>"
                                                class="btn btn-sm btn-icon btn-outline-danger btn-delete"
                                                data-name="<?= htmlspecialchars($row->class_name) ?>"
                                                title="Hapus">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="bx bx-inbox d-block mb-2" style="font-size:2.5rem;opacity:0.3;"></i>
                                        <span class="text-muted">Belum ada data kelas.</span>
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
                        <input type="text" id="mobileSearch"
                            class="form-control border-start-0 ps-1"
                            placeholder="Cari kelas..." />
                    </div>
                </div>

                <!-- List Cards -->
                <div id="mobileCardList" class="px-3 pb-3">
                    <?php if (!empty($classes)): ?>
                        <?php $no = 1; foreach ($classes as $row): ?>
                        <div class="mobile-class-card d-flex align-items-center justify-content-between gap-2 p-3 mb-2 rounded-3 border bg-white"
                            data-name="<?= strtolower(htmlspecialchars($row->class_name)) ?>">

                            <div class="d-flex align-items-center gap-3 overflow-hidden">
                                <!-- Nomor -->
                                <span class="text-muted fw-semibold flex-shrink-0" style="min-width:20px;font-size:0.8125rem;">
                                    <?= $no++ ?>
                                </span>
                                <!-- Avatar -->
                                <div class="avatar avatar-sm bg-label-primary rounded flex-shrink-0">
                                    <span class="avatar-initial rounded">
                                        <i class="bx bx-building-house" style="font-size:13px;"></i>
                                    </span>
                                </div>
                                <!-- Info -->
                                <div class="overflow-hidden">
                                    <strong class="d-block text-truncate" style="font-size:0.9rem;">
                                        <?= htmlspecialchars($row->class_name) ?>
                                    </strong>
                                    <small class="text-muted">
                                        <i class="bx bx-calendar me-1" style="font-size:11px;"></i>
                                        <?= date('d M Y', strtotime($row->created_at)) ?>
                                    </small>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="d-flex gap-1 flex-shrink-0">
                                <button type="button"
                                    class="btn btn-sm btn-icon btn-outline-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditKelas"
                                    data-id="<?= $row->id ?>"
                                    data-name="<?= htmlspecialchars($row->class_name) ?>"
                                    title="Edit">
                                    <i class="bx bx-edit-alt"></i>
                                </button>
                                <a href="<?= base_url('classes/delete/' . $row->id) ?>"
                                    class="btn btn-sm btn-icon btn-outline-danger btn-delete"
                                    data-name="<?= htmlspecialchars($row->class_name) ?>"
                                    title="Hapus">
                                    <i class="bx bx-trash"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <!-- Empty search state -->
                        <div id="mobileEmpty" class="text-center py-4 d-none">
                            <i class="bx bx-search-alt d-block mb-2" style="font-size:2rem;opacity:0.3;"></i>
                            <span class="text-muted small">Kelas tidak ditemukan</span>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bx bx-inbox d-block mb-2" style="font-size:2.5rem;opacity:0.3;"></i>
                            <span class="text-muted">Belum ada data kelas.</span>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <!-- ===== / MOBILE CARDS ===== -->

        </div>
    </div>

</div>


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
                        <label for="class_name_add" class="form-label fw-semibold">
                            Nama Kelas <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="class_name_add" name="class_name"
                            placeholder="Contoh: Kelas 7A, Kelas 8B..." required autofocus />
                        <div class="form-text text-muted">
                            Masukkan nama kelas yang unik dan mudah dikenali.
                        </div>
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
                        <label for="class_name_edit" class="form-label fw-semibold">
                            Nama Kelas <span class="text-danger">*</span>
                        </label>
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


<style>
.mobile-class-card {
    transition: box-shadow 0.15s ease, border-color 0.15s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    cursor: default;
}
.mobile-class-card:hover {
    box-shadow: 0 4px 14px rgba(105, 108, 255, 0.1);
    border-color: #d5d6ff !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Modal Edit
    var modalEditEl = document.getElementById('modalEditKelas');
    if (modalEditEl) {
        modalEditEl.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            document.getElementById('class_name_edit').value = btn.getAttribute('data-name');
            document.getElementById('formEditKelas').action  = '<?= base_url('classes/update/') ?>' + btn.getAttribute('data-id');
        });
    }

// Mobile search filter
var mobileSearch = document.getElementById('mobileSearch');
if (mobileSearch) {
    mobileSearch.addEventListener('input', function () {
		console.log('Search triggered:', this.value)
        var keyword = this.value.toLowerCase().trim();
        var cards   = document.querySelectorAll('.mobile-class-card');
        var empty   = document.getElementById('mobileEmpty');
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
