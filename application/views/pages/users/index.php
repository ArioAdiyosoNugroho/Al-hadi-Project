<style>
.mobile-user-card {
    transition: box-shadow 0.15s ease, border-color 0.15s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    cursor: default;
}
.mobile-user-card:hover {
    box-shadow: 0 4px 14px rgba(105, 108, 255, 0.1);
    border-color: #d5d6ff !important;
}
.mobile-user-card.hidden {
    display: none !important;
}
</style>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Al-Hadi /</span> Kelola User
            </h4>
            <p class="text-muted mb-0">Manajemen data pengguna Sekolah Al-Hadi</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
            <i class="bx bx-plus me-1"></i> Tambah User
        </button>
    </div>

    <!-- Card Tabel User -->
    <div class="card shadow-sm">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
            <h5 class="mb-0">
                <i class="bx bx-user me-2 text-primary"></i>Daftar User
            </h5>
            <span class="badge bg-label-primary px-3 py-2" style="font-size: 0.8125rem;">
                Total: <?= count($users) ?> user
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
                                <th>Username</th>
                                <th>Tanggal Dibuat</th>
                                <th width="120" class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                                <?php $no = 1; foreach ($users as $row): ?>
                                <tr>
                                    <td class="text-center text-muted ps-4"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar avatar-sm bg-label-primary rounded">
                                                <span class="avatar-initial rounded">
                                                    <i class="bx bx-user" style="font-size:14px;"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <strong><?= htmlspecialchars($row->username) ?></strong>
                                                <?php if ($row->id == $this->session->userdata('user_id')): ?>
                                                    <span class="badge bg-label-success ms-1">Anda</span>
                                                <?php endif; ?>
                                            </div>
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
                                                data-bs-target="#modalEditUser"
                                                data-id="<?= $row->id ?>"
                                                data-username="<?= htmlspecialchars($row->username) ?>"
                                                title="Edit">
                                                <i class="bx bx-edit-alt"></i>
                                            </button>
                                            <?php if ($row->id != $this->session->userdata('user_id')): ?>
                                            <a href="<?= base_url('users/delete/' . $row->id) ?>"
                                                class="btn btn-sm btn-icon btn-outline-danger btn-delete"
                                                data-name="<?= htmlspecialchars($row->username) ?>"
                                                title="Hapus">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                            <?php else: ?>
                                            <button class="btn btn-sm btn-icon btn-outline-secondary" disabled title="Tidak bisa hapus akun sendiri">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="bx bx-inbox d-block mb-2" style="font-size:2.5rem;opacity:0.3;"></i>
                                        <span class="text-muted">Belum ada data user.</span>
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
                        <input type="text" id="mobileSearchUser"
                            class="form-control border-start-0 ps-1"
                            placeholder="Cari user..." />
                    </div>
                </div>

                <!-- List Cards -->
                <div id="mobileUserCardList" class="px-3 pb-3">
                    <?php if (!empty($users)): ?>
                        <?php $no = 1; foreach ($users as $row): ?>
                        <div class="mobile-user-card d-flex align-items-center justify-content-between gap-2 p-3 mb-2 rounded-3 border bg-white"
                            data-name="<?= strtolower(htmlspecialchars($row->username)) ?>">

                            <div class="d-flex align-items-center gap-3 overflow-hidden">
                                <!-- Nomor -->
                                <span class="text-muted fw-semibold flex-shrink-0" style="min-width:20px;font-size:0.8125rem;">
                                    <?= $no++ ?>
                                </span>
                                <!-- Avatar -->
                                <div class="avatar avatar-sm bg-label-primary rounded flex-shrink-0">
                                    <span class="avatar-initial rounded">
                                        <i class="bx bx-user" style="font-size:13px;"></i>
                                    </span>
                                </div>
                                <!-- Info -->
                                <div class="overflow-hidden">
                                    <div class="d-flex align-items-center gap-1">
                                        <strong class="d-block text-truncate" style="font-size:0.9rem;">
                                            <?= htmlspecialchars($row->username) ?>
                                        </strong>
                                        <?php if ($row->id == $this->session->userdata('user_id')): ?>
                                            <span class="badge bg-label-success" style="font-size:0.7rem;">Anda</span>
                                        <?php endif; ?>
                                    </div>
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
                                    data-bs-target="#modalEditUser"
                                    data-id="<?= $row->id ?>"
                                    data-username="<?= htmlspecialchars($row->username) ?>"
                                    title="Edit">
                                    <i class="bx bx-edit-alt"></i>
                                </button>
                                <?php if ($row->id != $this->session->userdata('user_id')): ?>
                                <a href="<?= base_url('users/delete/' . $row->id) ?>"
                                    class="btn btn-sm btn-icon btn-outline-danger btn-delete"
                                    data-name="<?= htmlspecialchars($row->username) ?>"
                                    title="Hapus">
                                    <i class="bx bx-trash"></i>
                                </a>
                                <?php else: ?>
                                <button class="btn btn-sm btn-icon btn-outline-secondary" disabled title="Tidak bisa hapus akun sendiri">
                                    <i class="bx bx-trash"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <!-- Empty search state -->
                        <div id="mobileUserEmpty" class="text-center py-4 d-none">
                            <i class="bx bx-search-alt d-block mb-2" style="font-size:2rem;opacity:0.3;"></i>
                            <span class="text-muted small">User tidak ditemukan</span>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bx bx-inbox d-block mb-2" style="font-size:2.5rem;opacity:0.3;"></i>
                            <span class="text-muted">Belum ada data user.</span>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <!-- ===== / MOBILE CARDS ===== -->

        </div>
    </div>

</div>


<!-- ===== MODAL TAMBAH USER ===== -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('users/store') ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bx bx-user-plus me-2 text-primary"></i>Tambah User Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username"
                            placeholder="Masukkan username..." required autofocus />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password"
                                id="password_add" placeholder="Masukkan password..." required />
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password_add">
                                <i class="bx bx-hide"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="confirm_password"
                                id="confirm_add" placeholder="Ulangi password..." required />
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="confirm_add">
                                <i class="bx bx-hide"></i>
                            </button>
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


<!-- ===== MODAL EDIT USER ===== -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formEditUser" action="" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bx bx-edit me-2 text-warning"></i>Edit User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_username" name="username"
                            placeholder="Masukkan username..." required />
                    </div>
                    <hr>
                    <p class="text-muted small mb-3">
                        <i class="bx bx-info-circle me-1"></i>
                        Kosongkan password jika tidak ingin mengubah password.
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password"
                                id="password_edit" placeholder="Kosongkan jika tidak diubah" />
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password_edit">
                                <i class="bx bx-hide"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="confirm_password"
                                id="confirm_edit" placeholder="Kosongkan jika tidak diubah" />
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="confirm_edit">
                                <i class="bx bx-hide"></i>
                            </button>
                        </div>
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
    var modalEditEl = document.getElementById('modalEditUser');
    if (modalEditEl) {
        modalEditEl.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            document.getElementById('edit_username').value = btn.getAttribute('data-username');
            document.getElementById('formEditUser').action = '<?= base_url('users/update/') ?>' + btn.getAttribute('data-id');
            document.getElementById('password_edit').value = '';
            document.getElementById('confirm_edit').value  = '';
        });
    }

    // ===== Toggle Show/Hide Password =====
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var targetId = this.getAttribute('data-target');
            var input    = document.getElementById(targetId);
            var icon     = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bx-hide', 'bx-show');
            } else {
                input.type = 'password';
                icon.classList.replace('bx-show', 'bx-hide');
            }
        });
    });

    // ===== Mobile Search Filter =====
    var mobileSearch = document.getElementById('mobileSearchUser');
    if (mobileSearch) {
        mobileSearch.addEventListener('input', function () {
            var keyword = this.value.toLowerCase().trim();
            var cards   = document.querySelectorAll('.mobile-user-card');
            var empty   = document.getElementById('mobileUserEmpty');
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
