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

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">
                    Al-Hadi / <a href="<?= base_url('assessments') ?>" class="text-muted">Penilaian</a> /
                </span>
                Edit Penilaian
            </h4>
            <p class="text-muted mb-0">Perbarui data penilaian kebersihan kelas</p>
        </div>
        <a href="<?= base_url('assessments/class_detail/' . $assessment->class_id) ?>" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back me-1"></i>Kembali
        </a>
    </div>

    <?php
    $detail_map = [];
    foreach ($details as $d) { $detail_map[$d->aspect_id] = $d; }
    ?>

    <form action="<?= base_url('assessments/update/' . $assessment->id) ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

        <div class="row g-4">

            <!-- ── Kolom Kiri: Info ── -->
            <div class="col-md-4">

                <!-- Stat card: Total Poin — Sneat style -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-3">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-bar-chart-alt-2"></i></span>
                            </div>
                            <span id="totalPointBadge" class="badge bg-label-warning px-2 py-1" style="font-size:0.8rem;">0 poin</span>
                        </div>
                        <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">TOTAL POIN</span>
                        <h3 class="card-title mb-0 text-warning" id="totalPointDisplay">0</h3>
                        <small class="text-muted">dihitung otomatis</small>
                    </div>
                </div>

                <!-- Info penilaian -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="m-0 me-2">Informasi Penilaian</h5>
                        <small class="text-muted">Kelas &amp; tanggal</small>
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
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Penilaian <span class="text-danger">*</span></label>
                            <input type="date" name="assessment_date" class="form-control"
                                value="<?= $assessment->assessment_date ?>" required />
                        </div>
                    </div>
                </div>

                <!-- Alert mode edit -->
                <div class="card" style="border-left: 3px solid #ff9f43;">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-3">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-edit-alt"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-1">Mode Edit</h6>
                                <small class="text-muted">Perubahan akan menggantikan data penilaian sebelumnya.</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ── Kolom Kanan: Aspek ── -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <h5 class="m-0 me-2">Penilaian Per Aspek</h5>
                            <small class="text-muted"><?= count($aspects) ?> aspek</small>
                        </div>
                        <span id="totalPointBadge2" class="badge bg-label-warning px-3 py-2" style="font-size:0.8125rem;">
                            Total: 0 poin
                        </span>
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
                            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <!-- Nama & poin hint -->
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="text-muted fw-semibold flex-shrink-0" style="font-size:0.8rem;min-width:22px;"><?= $no++ ?></span>
                                        <div class="avatar avatar-xs flex-shrink-0">
                                            <span class="avatar-initial rounded bg-label-warning">
                                                <i class="bx bx-check-shield" style="font-size:11px;"></i>
                                            </span>
                                        </div>
                                        <strong class="text-truncate" style="font-size:0.875rem;"><?= htmlspecialchars($asp->aspect_name) ?></strong>
                                    </div>
                                    <div class="ms-4 ps-1 d-flex gap-2" style="font-size:0.72rem;">
                                        <span class="text-success fw-semibold">🟢 <?= $asp->point_bersih ?></span>
                                        <span class="text-warning fw-semibold">🟡 <?= $asp->point_cukup ?></span>
                                        <span class="text-danger fw-semibold">🔴 <?= $asp->point_kotor ?></span>
                                    </div>
                                </div>
                                <!-- Kondisi + poin -->
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
                                    <input type="number"
                                        name="point[]"
                                        class="form-control form-control-sm text-center fw-bold point-input"
                                        value="<?= $sel_point ?>"
                                        min="0"
                                        readonly
                                        style="width:54px;" />
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <!-- Total row -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-1"
                             style="background:#fffcf0;border-radius:0 0 8px 8px;padding:10px 14px;margin:-12px -12px -12px -12px;">
                            <span class="fw-semibold text-muted">Total Poin</span>
                            <strong class="text-warning" style="font-size:1.4rem;" id="totalPointCell">0</strong>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="<?= base_url('assessments/class_detail/' . $assessment->class_id) ?>" class="btn btn-outline-secondary">
                        <i class="bx bx-x me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="bx bx-save me-1"></i>Perbarui Penilaian
                    </button>
                </div>
            </div>

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
    document.getElementById('totalPointCell').textContent     = total;
    document.getElementById('totalPointDisplay').textContent  = total;
    document.getElementById('totalPointBadge').textContent    = total + ' poin';
    document.getElementById('totalPointBadge2').textContent   = 'Total: ' + total + ' poin';
}

window.addEventListener('load', function () { hitungTotal(); });
</script>
