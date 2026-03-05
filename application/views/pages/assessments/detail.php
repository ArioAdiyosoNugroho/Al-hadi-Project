<style>
.detail-aspect-card {
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 8px;
    background: #fff;
    transition: box-shadow 0.15s ease;
}
.detail-aspect-card:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.cond-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}
.cond-pill.bersih { background: #e8f5e9; color: #2e7d32; }
.cond-pill.cukup  { background: #fff8e1; color: #f57f17; }
.cond-pill.kotor  { background: #fce4ec; color: #c62828; }
</style>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Al-Hadi / <a href="<?= base_url('assessments') ?>" class="text-muted">Penilaian</a> /</span> Detail Penilaian
            </h4>
            <p class="text-muted mb-0">Rincian penilaian kebersihan kelas</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('assessments/edit/' . $assessment->id) ?>" class="btn btn-warning">
                <i class="bx bx-edit-alt me-1"></i>Edit
            </a>
            <a href="<?= base_url('assessments') ?>" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i>Kembali
            </a>
        </div>
    </div>

    <?php
        $total = $assessment->total_point;
        if ($total >= 80)      { $predikat = 'Sangat Bersih'; $p_class = 'success'; $p_icon = 'bx-trophy'; }
        elseif ($total >= 60)  { $predikat = 'Bersih';        $p_class = 'primary'; $p_icon = 'bx-like'; }
        elseif ($total >= 40)  { $predikat = 'Cukup';         $p_class = 'warning'; $p_icon = 'bx-minus-circle'; }
        else                   { $predikat = 'Kurang';         $p_class = 'danger';  $p_icon = 'bx-dislike'; }

        $count_bersih = 0; $count_cukup = 0; $count_kotor = 0;
        foreach ($details as $d) {
            if ($d->condition_status == 'bersih') $count_bersih++;
            elseif ($d->condition_status == 'cukup') $count_cukup++;
            else $count_kotor++;
        }
    ?>

    <!-- ===== Summary Cards ===== -->
    <div class="row mb-4">

        <!-- Info -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-start border-4 border-<?= $p_class ?> h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 small fw-semibold">KELAS</p>
                            <h5 class="fw-bold mb-0"><?= htmlspecialchars($assessment->class_name) ?></h5>
                        </div>
                        <div class="avatar bg-label-<?= $p_class ?> rounded">
                            <span class="avatar-initial rounded"><i class="bx <?= $p_icon ?> fs-4"></i></span>
                        </div>
                    </div>
                    <hr class="my-2">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <p class="text-muted mb-1 small fw-semibold">TANGGAL</p>
                            <strong style="font-size:0.85rem;"><?= date('d M Y', strtotime($assessment->assessment_date)) ?></strong>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1 small fw-semibold">DINILAI OLEH</p>
                            <strong style="font-size:0.85rem;"><?= htmlspecialchars($assessment->admin_name) ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Score -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm bg-<?= $p_class ?> text-white h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                    <p class="mb-1 fw-semibold opacity-75 small">TOTAL POIN</p>
                    <h1 class="display-3 fw-bold mb-1"><?= $assessment->total_point ?></h1>
                    <span class="badge bg-white text-<?= $p_class ?> fs-6 px-3 py-2">
                        <i class="bx <?= $p_icon ?> me-1"></i><?= $predikat ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Ringkasan kondisi -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header py-3">
                    <h6 class="mb-0"><i class="bx bx-pie-chart me-2 text-primary"></i>Ringkasan Kondisi</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light rounded">
                        <span><i class="bx bx-circle text-success me-2"></i>Bersih</span>
                        <span class="badge bg-success"><?= $count_bersih ?> aspek</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light rounded">
                        <span><i class="bx bx-circle text-warning me-2"></i>Cukup</span>
                        <span class="badge bg-warning text-dark"><?= $count_cukup ?> aspek</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                        <span><i class="bx bx-circle text-danger me-2"></i>Kotor</span>
                        <span class="badge bg-danger"><?= $count_kotor ?> aspek</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Detail Aspek ===== -->
    <div class="card shadow-sm">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
            <h5 class="mb-0"><i class="bx bx-list-ul me-2 text-primary"></i>Detail Penilaian Per Aspek</h5>
            <span class="badge bg-label-primary px-3 py-2" style="font-size:0.8125rem;">
                <?= count($details) ?> aspek
            </span>
        </div>
        <div class="card-body p-0">

            <!-- ===== DESKTOP TABLE (md ke atas) ===== -->
            <div class="d-none d-md-block">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="60" class="text-center ps-4">No</th>
                                <th>Aspek Penilaian</th>
                                <th class="text-center" width="180">Kondisi</th>
                                <th class="text-center" width="130">Poin Diperoleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($details as $d):
                                $cond_class = $d->condition_status == 'bersih' ? 'success' : ($d->condition_status == 'cukup' ? 'warning' : 'danger');
                                $cond_icon  = $d->condition_status == 'bersih' ? '🟢' : ($d->condition_status == 'cukup' ? '🟡' : '🔴');
                                $cond_label = ucfirst($d->condition_status);
                            ?>
                            <tr>
                                <td class="text-center text-muted ps-4"><?= $no++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar avatar-sm bg-label-<?= $cond_class ?> rounded">
                                            <span class="avatar-initial rounded">
                                                <i class="bx bx-check-shield" style="font-size:13px;"></i>
                                            </span>
                                        </div>
                                        <strong><?= htmlspecialchars($d->aspect_name) ?></strong>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="cond-pill <?= $d->condition_status ?>">
                                        <?= $cond_icon ?> <?= $cond_label ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold fs-5 text-<?= $cond_class ?>"><?= $d->point ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold pe-4">Total Poin:</td>
                                <td class="text-center fw-bold fs-4 text-<?= $p_class ?> pe-4"><?= $assessment->total_point ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- ===== MOBILE CARDS (di bawah md) ===== -->
            <div class="d-md-none p-3">
                <?php $no = 1; foreach ($details as $d):
                    $cond_class = $d->condition_status == 'bersih' ? 'success' : ($d->condition_status == 'cukup' ? 'warning' : 'danger');
                    $cond_icon  = $d->condition_status == 'bersih' ? '🟢' : ($d->condition_status == 'cukup' ? '🟡' : '🔴');
                    $cond_label = ucfirst($d->condition_status);
                ?>
                <div class="detail-aspect-card d-flex align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3 overflow-hidden flex-grow-1">
                        <span class="text-muted fw-semibold flex-shrink-0" style="min-width:20px;font-size:0.8rem;"><?= $no++ ?></span>
                        <div class="avatar avatar-sm bg-label-<?= $cond_class ?> rounded flex-shrink-0">
                            <span class="avatar-initial rounded">
                                <i class="bx bx-check-shield" style="font-size:13px;"></i>
                            </span>
                        </div>
                        <div class="overflow-hidden">
                            <strong class="d-block text-truncate" style="font-size:0.875rem;">
                                <?= htmlspecialchars($d->aspect_name) ?>
                            </strong>
                            <span class="cond-pill <?= $d->condition_status ?> mt-1">
                                <?= $cond_icon ?> <?= $cond_label ?>
                            </span>
                        </div>
                    </div>
                    <div class="text-center flex-shrink-0">
                        <span class="fw-bold fs-4 text-<?= $cond_class ?>"><?= $d->point ?></span>
                        <div style="font-size:0.65rem;color:#aaa;">poin</div>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Total mobile -->
                <div class="d-flex justify-content-between align-items-center p-3 mt-2 rounded-3 border fw-bold"
                     style="background:#f8f9ff;">
                    <span class="text-muted">Total Poin</span>
                    <span class="fs-3 text-<?= $p_class ?>"><?= $assessment->total_point ?></span>
                </div>
            </div>
            <!-- ===== / MOBILE CARDS ===== -->

        </div>
    </div>

</div>
