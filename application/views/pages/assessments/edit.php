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
    border-color: #ffe08a;
}
</style>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="mb-4">
        <h4 class="fw-bold mb-1">
            <span class="text-muted fw-light">
                Al-Hadi / <a href="<?= base_url('assessments') ?>" class="text-muted">Penilaian</a> /
            </span> Edit Penilaian
        </h4>
        <p class="text-muted mb-0">Perbarui data penilaian kebersihan kelas</p>
    </div>

    <?php
    $detail_map = [];
    foreach ($details as $d) { $detail_map[$d->aspect_id] = $d; }
    ?>

    <form action="<?= base_url('assessments/update/' . $assessment->id) ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

        <div class="row">
            <!-- ===== Kolom Info ===== -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header py-3">
                        <h6 class="mb-0"><i class="bx bx-info-circle me-2 text-warning"></i>Informasi Penilaian</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                            <select name="class_id" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach ($classes as $cls): ?>
                                <option value="<?= $cls->id ?>" <?= $cls->id == $assessment->class_id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cls->class_name) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Tanggal Penilaian <span class="text-danger">*</span></label>
                            <input type="date" name="assessment_date" class="form-control"
                                value="<?= $assessment->assessment_date ?>" required />
                        </div>

                        <!-- Total poin summary -->
                        <div class="p-3 rounded-3 border text-center mb-3" style="background:#fffbf0;">
                            <p class="text-muted small mb-1 fw-semibold">TOTAL POIN</p>
                            <h2 class="fw-bold text-warning mb-0" id="totalPointDisplay">0</h2>
                        </div>

                        <div class="alert alert-warning mb-0 p-3">
                            <div class="d-flex align-items-start">
                                <i class="bx bx-edit-alt me-2 mt-1 text-warning fs-5"></i>
                                <div>
                                    <strong>Mode Edit</strong><br>
                                    <small>Perubahan akan menggantikan data penilaian sebelumnya.</small>
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
                        <h6 class="mb-0"><i class="bx bx-list-check me-2 text-warning"></i>Penilaian Per Aspek</h6>
                        <span id="totalPointBadge" class="badge bg-warning text-dark fs-6 px-3">Total: 0 poin</span>
                    </div>
                    <div class="card-body">

                        <?php $no = 1; foreach ($aspects as $asp):
                            $existing  = isset($detail_map[$asp->id]) ? $detail_map[$asp->id] : null;
                            $sel_cond  = $existing ? $existing->condition_status : 'bersih';
                            if ($sel_cond === 'bersih')    $sel_point = $asp->point_bersih;
                            elseif ($sel_cond === 'cukup') $sel_point = $asp->point_cukup;
                            else                           $sel_point = $asp->point_kotor;
                        ?>
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
                                        <option value="bersih" <?= $sel_cond == 'bersih' ? 'selected' : '' ?>>🟢 Bersih</option>
                                        <option value="cukup"  <?= $sel_cond == 'cukup'  ? 'selected' : '' ?>>🟡 Cukup</option>
                                        <option value="kotor"  <?= $sel_cond == 'kotor'  ? 'selected' : '' ?>>🔴 Kotor</option>
                                    </select>
                                    <div class="text-center" style="min-width:52px;">
                                        <input type="number"
                                            name="point[]"
                                            class="form-control form-control-sm text-center fw-bold point-input"
                                            value="<?= $sel_point ?>"
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
                            <span class="fw-bold fs-4 text-warning" id="totalPointCell">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi -->
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="<?= base_url('assessments') ?>" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i>Batal
            </a>
            <button type="submit" class="btn btn-warning">
                <i class="bx bx-save me-1"></i>Perbarui Penilaian
            </button>
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
