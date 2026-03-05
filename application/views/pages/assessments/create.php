<style>
.aspect-row-card {
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 10px;
    background: #fff;
    transition: box-shadow 0.15s ease, border-color 0.15s ease;
}
.aspect-row-card:hover {
    box-shadow: 0 3px 10px rgba(105,108,255,0.08);
    border-color: #d5d6ff;
}
.condition-btn-group .btn {
    font-size: 0.78rem;
    padding: 4px 10px;
}
.condition-btn-group .btn.active {
    font-weight: 700;
}
</style>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
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
            <!-- ===== Kolom Info ===== -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header py-3">
                        <h6 class="mb-0"><i class="bx bx-info-circle me-2 text-primary"></i>Informasi Penilaian</h6>
                    </div>
                    <div class="card-body">

                        <?php if ($selected_class): ?>
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
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                            <?php if (empty($classes)): ?>
                                <div class="alert alert-warning mb-0 p-3">
                                    <i class="bx bx-info-circle me-2"></i>Semua kelas sudah dinilai hari ini!
                                </div>
                            <?php else: ?>
                                <select name="class_id" class="form-select" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php foreach ($classes as $cls): ?>
                                    <option value="<?= $cls->id ?>"><?= htmlspecialchars($cls->class_name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text text-muted">Hanya menampilkan kelas yang <strong>belum dinilai hari ini</strong>.</div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Tanggal Penilaian <span class="text-danger">*</span></label>
                            <input type="date" name="assessment_date" class="form-control"
                                value="<?= date('Y-m-d') ?>" required />
                        </div>

                        <!-- Total poin — sticky summary -->
                        <div class="p-3 rounded-3 border text-center mb-3" style="background:#f8f9ff;">
                            <p class="text-muted small mb-1 fw-semibold">TOTAL POIN</p>
                            <h2 class="fw-bold text-primary mb-0" id="totalPointDisplay">0</h2>
                        </div>

                        <div class="alert alert-info mb-0 p-3">
                            <div class="d-flex align-items-start">
                                <i class="bx bx-bulb me-2 mt-1 fs-5"></i>
                                <div>
                                    <strong>Panduan:</strong><br>
                                    <small>Pilih kondisi tiap aspek, poin terisi <strong>otomatis</strong>.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== Kolom Aspek ===== -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header d-flex align-items-center justify-content-between py-3">
                        <h6 class="mb-0"><i class="bx bx-list-check me-2 text-primary"></i>Penilaian Per Aspek</h6>
                        <span id="totalPointBadge" class="badge bg-primary fs-6 px-3">Total: 0 poin</span>
                    </div>
                    <div class="card-body">

                        <?php $no = 1; foreach ($aspects as $asp): ?>
                        <div class="aspect-row-card">
                            <input type="hidden" name="aspect_id[]" value="<?= $asp->id ?>">
                            <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
                                <!-- Nama & info poin -->
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="text-muted fw-semibold" style="font-size:0.8rem;min-width:22px;"><?= $no++ ?></span>
                                        <strong style="font-size:0.9rem;"><?= htmlspecialchars($asp->aspect_name) ?></strong>
                                    </div>
                                    <div class="ms-4" style="font-size:0.75rem;color:#888;">
                                        🟢 <?= $asp->point_bersih ?> &nbsp;🟡 <?= $asp->point_cukup ?> &nbsp;🔴 <?= $asp->point_kotor ?>
                                    </div>
                                </div>
                                <!-- Kondisi & poin -->
                                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                    <select name="condition_status[]"
                                        class="form-select form-select-sm"
                                        style="width:130px;"
                                        data-bersih="<?= $asp->point_bersih ?>"
                                        data-cukup="<?= $asp->point_cukup ?>"
                                        data-kotor="<?= $asp->point_kotor ?>"
                                        onchange="handleConditionChange(this)"
                                        required>
                                        <option value="bersih">🟢 Bersih</option>
                                        <option value="cukup">🟡 Cukup</option>
                                        <option value="kotor">🔴 Kotor</option>
                                    </select>
                                    <div class="text-center" style="min-width:52px;">
                                        <input type="number"
                                            name="point[]"
                                            class="form-control form-control-sm text-center fw-bold point-input"
                                            value="<?= $asp->point_bersih ?>"
                                            min="0"
                                            readonly
                                            style="width:52px;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <!-- Total footer -->
                        <div class="d-flex justify-content-end align-items-center gap-3 pt-2 border-top mt-2">
                            <span class="fw-bold text-muted">Total Poin:</span>
                            <span class="fw-bold fs-4 text-primary" id="totalPointCell">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi -->
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
    var card   = selectEl.closest('.aspect-row-card');
    var input  = card.querySelector('.point-input');
    if (val === 'bersih')     input.value = bersih;
    else if (val === 'cukup') input.value = cukup;
    else                      input.value = kotor;
    hitungTotal();
}

function hitungTotal() {
    var inputs = document.querySelectorAll('.point-input');
    var total  = 0;
    inputs.forEach(function (inp) { total += parseInt(inp.value) || 0; });
    document.getElementById('totalPointCell').textContent    = total;
    document.getElementById('totalPointBadge').textContent   = 'Total: ' + total + ' poin';
    document.getElementById('totalPointDisplay').textContent = total;
}

window.addEventListener('load', function () { hitungTotal(); });
</script>
