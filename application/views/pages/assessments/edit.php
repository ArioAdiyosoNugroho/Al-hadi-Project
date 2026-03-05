<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">
            <span class="text-muted fw-light">Al-Hadi / <a href="<?= base_url('assessments') ?>" class="text-muted">Penilaian</a> /</span> Edit Penilaian
        </h4>
        <p class="text-muted mb-0">Perbarui data penilaian kebersihan kelas</p>
    </div>

    <form action="<?= base_url('assessments/update/' . $assessment->id) ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

        <?php
        // Buat lookup detail lama: [aspect_id => detail_row]
        $detail_map = [];
        foreach ($details as $d) {
            $detail_map[$d->aspect_id] = $d;
        }
        ?>

        <div class="row">
            <!-- Kolom Kiri -->
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

            <!-- Kolom Kanan -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header d-flex align-items-center justify-content-between py-3">
                        <h6 class="mb-0"><i class="bx bx-list-check me-2 text-warning"></i>Penilaian Per Aspek</h6>
                        <span id="totalPointBadge" class="badge bg-warning text-dark fs-6 px-3">Total: 0 poin</span>
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
                                    <?php
                                        $existing  = isset($detail_map[$asp->id]) ? $detail_map[$asp->id] : null;
                                        $sel_cond  = $existing ? $existing->condition_status : 'bersih';
                                        if ($sel_cond === 'bersih')    $sel_point = $asp->point_bersih;
                                        elseif ($sel_cond === 'cukup') $sel_point = $asp->point_cukup;
                                        else                           $sel_point = $asp->point_kotor;
                                    ?>
                                    <tr>
                                        <td class="text-center text-muted"><?= $no++ ?></td>
                                        <td>
                                            <input type="hidden" name="aspect_id[]" value="<?= $asp->id ?>">
                                            <strong><?= htmlspecialchars($asp->aspect_name) ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                🟢 <?= $asp->point_bersih ?> &nbsp;
                                                🟡 <?= $asp->point_cukup ?> &nbsp;
                                                🔴 <?= $asp->point_kotor ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <select name="condition_status[]"
                                                class="form-select form-select-sm"
                                                data-bersih="<?= $asp->point_bersih ?>"
                                                data-cukup="<?= $asp->point_cukup ?>"
                                                data-kotor="<?= $asp->point_kotor ?>"
                                                onchange="handleConditionChange(this)"
                                                required>
                                                <option value="bersih" <?= $sel_cond == 'bersih' ? 'selected' : '' ?>>🟢 Bersih</option>
                                                <option value="cukup"  <?= $sel_cond == 'cukup'  ? 'selected' : '' ?>>🟡 Cukup</option>
                                                <option value="kotor"  <?= $sel_cond == 'kotor'  ? 'selected' : '' ?>>🔴 Kotor</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <input type="number"
                                                name="point[]"
                                                class="form-control form-control-sm text-center fw-bold point-input"
                                                value="<?= $sel_point ?>"
                                                min="0"
                                                readonly
                                            />
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total Poin:</td>
                                        <td class="text-center fw-bold fs-5 text-warning" id="totalPointCell">0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
    // Vanilla JS murni — tidak pakai $() sama sekali
    // dipanggil langsung via onchange="handleConditionChange(this)"

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

    // Hitung total awal saat halaman load (data kondisi sudah terisi dari DB)
    window.addEventListener('load', function () {
        hitungTotal();
    });
</script>
