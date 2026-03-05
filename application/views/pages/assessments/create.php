<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">
            <span class="text-muted fw-light">
                Al-Hadi /
                <a href="<?= base_url('assessments') ?>" class="text-muted">Penilaian</a> /
                <?php if ($selected_class): ?>
                    <a href="<?= base_url('assessments/class_detail/' . $selected_class->id) ?>" class="text-muted">
                        <?= htmlspecialchars($selected_class->class_name) ?>
                    </a> /
                <?php endif; ?>
            </span>
            Tambah Penilaian
        </h4>
        <p class="text-muted mb-0">Isi form penilaian kebersihan kelas</p>
    </div>

    <form action="<?= base_url('assessments/store') ?>" method="POST" id="formPenilaian">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header py-3">
                        <h6 class="mb-0"><i class="bx bx-info-circle me-2 text-primary"></i>Informasi Penilaian</h6>
                    </div>
                    <div class="card-body">

                        <?php if ($selected_class): ?>
                        <!-- Mode: dari tombol "Nilai Hari Ini" — kelas sudah diketahui -->
                        <input type="hidden" name="class_id" value="<?= $selected_class->id ?>">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Kelas</label>
                            <div class="d-flex align-items-center gap-2 p-3 bg-light rounded border">
                                <div class="avatar avatar-sm bg-label-primary rounded">
                                    <span class="avatar-initial rounded"><i class="bx bx-building-house"></i></span>
                                </div>
                                <div>
                                    <div class="fw-bold"><?= htmlspecialchars($selected_class->class_name) ?></div>
                                    <small class="text-success"><i class="bx bx-check-circle me-1"></i>Belum dinilai hari ini</small>
                                </div>
                            </div>
                        </div>

                        <?php else: ?>
                        <!-- Mode: dari index — tampilkan dropdown kelas belum dinilai -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                            <?php if (empty($classes)): ?>
                                <div class="alert alert-warning mb-0 p-3">
                                    <i class="bx bx-info-circle me-2"></i>
                                    Semua kelas sudah dinilai hari ini!
                                </div>
                            <?php else: ?>
                                <select name="class_id" class="form-select" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php foreach ($classes as $cls): ?>
                                    <option value="<?= $cls->id ?>"><?= htmlspecialchars($cls->class_name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text text-muted">
                                    Hanya menampilkan kelas yang <strong>belum dinilai hari ini</strong>.
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Tanggal Penilaian <span class="text-danger">*</span></label>
                            <input type="date" name="assessment_date" class="form-control"
                                value="<?= date('Y-m-d') ?>" required />
                        </div>

                        <div class="alert alert-info mb-0 p-3">
                            <div class="d-flex align-items-start">
                                <i class="bx bx-bulb me-2 mt-1 fs-5"></i>
                                <div>
                                    <strong>Panduan Penilaian:</strong><br>
                                    <small>Pilih kondisi pada setiap aspek, poin akan <strong>terisi otomatis</strong> sesuai pengaturan aspek.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header d-flex align-items-center justify-content-between py-3">
                        <h6 class="mb-0"><i class="bx bx-list-check me-2 text-primary"></i>Penilaian Per Aspek</h6>
                        <span id="totalPointBadge" class="badge bg-primary fs-6 px-3">Total: 0 poin</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="40" class="text-center">#</th>
                                        <th>Aspek Penilaian</th>
                                        <th width="200" class="text-center">Kondisi</th>
                                        <th width="110" class="text-center">Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($aspects as $asp): ?>
                                    <tr>
                                        <td class="text-center text-muted"><?= $no++ ?></td>
                                        <td>
                                            <input type="hidden" name="aspect_id[]" value="<?= $asp->id ?>">
                                            <strong><?= htmlspecialchars($asp->aspect_name) ?></strong><br>
                                            <small class="text-muted">
                                                🟢 <?= $asp->point_bersih ?> &nbsp;
                                                🟡 <?= $asp->point_cukup ?> &nbsp;
                                                🔴 <?= $asp->point_kotor ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <select name="condition_status[]"
                                                class="form-select form-select-sm condition-select"
                                                data-bersih="<?= $asp->point_bersih ?>"
                                                data-cukup="<?= $asp->point_cukup ?>"
                                                data-kotor="<?= $asp->point_kotor ?>"
                                                onchange="handleConditionChange(this)"
                                                required>
                                                <option value="bersih">🟢 Bersih</option>
                                                <option value="cukup">🟡 Cukup</option>
                                                <option value="kotor">🔴 Kotor</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <input type="number"
                                                name="point[]"
                                                class="form-control form-control-sm text-center fw-bold point-input"
                                                value="<?= $asp->point_bersih ?>"
                                                min="0"
                                                readonly />
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total Poin:</td>
                                        <td class="text-center fw-bold fs-5 text-primary" id="totalPointCell">0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mb-4">
            <?php if ($selected_class): ?>
                <a href="<?= base_url('assessments/class_detail/' . $selected_class->id) ?>" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i>Batal
                </a>
            <?php else: ?>
                <a href="<?= base_url('assessments') ?>" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i>Batal
                </a>
            <?php endif; ?>

            <?php if (empty($classes) && !$selected_class): ?>
                <!-- Semua kelas sudah dinilai, disable tombol simpan -->
                <button type="button" class="btn btn-secondary" disabled>
                    <i class="bx bx-ban me-1"></i>Semua Kelas Sudah Dinilai
                </button>
            <?php else: ?>
                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i>Simpan Penilaian
                </button>
            <?php endif; ?>
        </div>
    </form>
</div>

<script>
function handleConditionChange(selectEl) {
    var val    = selectEl.value;
    var bersih = parseInt(selectEl.getAttribute('data-bersih'));
    var cukup  = parseInt(selectEl.getAttribute('data-cukup'));
    var kotor  = parseInt(selectEl.getAttribute('data-kotor'));

    var row   = selectEl.closest('tr');
    var input = row.querySelector('.point-input');

    if (val === 'bersih')     input.value = bersih;
    else if (val === 'cukup') input.value = cukup;
    else                      input.value = kotor;

    hitungTotal();
}

function hitungTotal() {
    var inputs = document.querySelectorAll('.point-input');
    var total  = 0;
    inputs.forEach(function (inp) {
        total += parseInt(inp.value) || 0;
    });
    document.getElementById('totalPointCell').textContent  = total;
    document.getElementById('totalPointBadge').textContent = 'Total: ' + total + ' poin';
}

window.addEventListener('load', function () {
    hitungTotal();
});
</script>
