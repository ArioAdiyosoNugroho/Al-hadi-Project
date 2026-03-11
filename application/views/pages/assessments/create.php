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
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
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
        <?php if ($selected_class): ?>
        <a href="<?= base_url('assessments/class_detail/' . $selected_class->id) ?>" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back me-1"></i>Kembali
        </a>
        <?php else: ?>
        <a href="<?= base_url('assessments') ?>" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back me-1"></i>Kembali
        </a>
        <?php endif; ?>
    </div>

    <form action="<?= base_url('assessments/store') ?>" method="POST" id="formPenilaian">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

        <div class="row g-4">

            <!-- ── Kolom Kiri: Info ── -->
            <div class="col-md-4">

                <!-- Stat card: Total Poin — Sneat style -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-3">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-bar-chart-alt-2"></i></span>
                            </div>
                            <span id="totalPointBadge" class="badge bg-label-primary px-2 py-1" style="font-size:0.8rem;">0 poin</span>
                        </div>
                        <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">TOTAL POIN</span>
                        <h3 class="card-title mb-0 text-primary" id="totalPointDisplay">0</h3>
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

                        <?php if ($selected_class): ?>
                        <input type="hidden" name="class_id" value="<?= $selected_class->id ?>">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Kelas</label>
                            <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#f8f9ff;border:1px solid #e0e1ff;">
                                <div class="avatar avatar-sm flex-shrink-0">
                                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-building-house"></i></span>
                                </div>
                                <div>
                                    <div class="fw-bold"><?= htmlspecialchars($selected_class->class_name) ?></div>
                                    <small class="text-success fw-semibold"><i class="bx bx-check-circle me-1"></i>Belum dinilai hari ini</small>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                            <?php if (empty($classes)): ?>
                                <div class="alert alert-warning p-3 mb-0">
                                    <i class="bx bx-info-circle me-2"></i>Semua kelas sudah dinilai hari ini!
                                </div>
                            <?php else: ?>
                                <select name="class_id" class="form-select" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php foreach ($classes as $cls): ?>
                                    <option value="<?= $cls->id ?>"><?= htmlspecialchars($cls->class_name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text">Hanya kelas yang <strong>belum dinilai hari ini</strong>.</div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Penilaian <span class="text-danger">*</span></label>
                            <input type="date" name="assessment_date" class="form-control"
                                value="<?= date('Y-m-d') ?>" required />
                        </div>
                    </div>
                </div>

                <!-- Panduan card — Sneat transactions-style list -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0 me-2">Panduan Penilaian</h5>
                        <small class="text-muted">keterangan kondisi</small>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <ul class="p-0 m-0">
                            <li class="d-flex align-items-center gap-3 px-4 mb-3">
                                <div class="avatar flex-shrink-0">
                                    <span class="avatar-initial rounded bg-label-success"><i class="bx bx-check-circle"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div>
                                        <h6 class="mb-0">Bersih</h6>
                                        <small class="text-muted">kondisi baik & terawat</small>
                                    </div>
                                    <small class="text-success fw-semibold">poin penuh</small>
                                </div>
                            </li>
                            <li class="d-flex align-items-center gap-3 px-4 mb-3">
                                <div class="avatar flex-shrink-0">
                                    <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-minus-circle"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div>
                                        <h6 class="mb-0">Cukup</h6>
                                        <small class="text-muted">perlu perhatian</small>
                                    </div>
                                    <small class="text-warning fw-semibold">poin sedang</small>
                                </div>
                            </li>
                            <li class="d-flex align-items-center gap-3 px-4 mb-2">
                                <div class="avatar flex-shrink-0">
                                    <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-x-circle"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div>
                                        <h6 class="mb-0">Kotor</h6>
                                        <small class="text-muted">perlu dibersihkan</small>
                                    </div>
                                    <small class="text-danger fw-semibold">poin rendah</small>
                                </div>
                            </li>
                        </ul>
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
                        <span id="totalPointBadge2" class="badge bg-label-primary px-3 py-2" style="font-size:0.8125rem;">
                            Total: 0 poin
                        </span>
                    </div>
                    <div class="card-body">

                        <?php $no = 1; foreach ($aspects as $asp): ?>
                        <div class="aspect-row-card">
                            <input type="hidden" name="aspect_id[]" value="<?= $asp->id ?>">
                            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <!-- Nama & poin hint -->
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="text-muted fw-semibold flex-shrink-0" style="font-size:0.8rem;min-width:22px;"><?= $no++ ?></span>
                                        <div class="avatar avatar-xs flex-shrink-0">
                                            <span class="avatar-initial rounded bg-label-success">
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
                                        <option value="bersih">🟢 Bersih</option>
                                        <option value="cukup">🟡 Cukup</option>
                                        <option value="kotor">🔴 Kotor</option>
                                    </select>
                                    <input type="number"
                                        name="point[]"
                                        class="form-control form-control-sm text-center fw-bold point-input"
                                        value="<?= $asp->point_bersih ?>"
                                        min="0"
                                        readonly
                                        style="width:54px;" />
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <!-- Total row -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-1"
                             style="background:#f8f9ff;border-radius:0 0 8px 8px;padding:10px 14px;margin:-12px -12px -12px -12px;">
                            <span class="fw-semibold text-muted">Total Poin</span>
                            <strong class="text-primary" style="font-size:1.4rem;" id="totalPointCell">0</strong>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <?php if ($selected_class): ?>
                        <a href="<?= base_url('assessments/class_detail/' . $selected_class->id) ?>" class="btn btn-outline-secondary">
                            <i class="bx bx-x me-1"></i>Batal
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('assessments') ?>" class="btn btn-outline-secondary">
                            <i class="bx bx-x me-1"></i>Batal
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
