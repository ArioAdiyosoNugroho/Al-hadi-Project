<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">
                    Al-Hadi / <a href="<?= base_url('assessments') ?>" class="text-muted">Penilaian</a> /
                </span>
                Detail Penilaian
            </h4>
            <p class="text-muted mb-0">Rincian penilaian kebersihan kelas</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('assessments/edit/' . $assessment->id) ?>" class="btn btn-warning">
                <i class="bx bx-edit-alt me-1"></i>Edit
            </a>
            <a href="<?= base_url('assessments/class_detail/' . $assessment->class_id) ?>" class="btn btn-outline-secondary">
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

    <!-- ── Summary Row: 4 stat cards (Sneat style) ── -->
    <div class="row g-3 mb-4">

        <!-- Kelas -->
        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-3">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-building-house"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Kelas</span>
                    <h3 class="card-title mb-0 text-primary" style="font-size:1rem;"><?= htmlspecialchars($assessment->class_name) ?></h3>
                    <small class="text-muted"><?= date('d M Y', strtotime($assessment->assessment_date)) ?></small>
                </div>
            </div>
        </div>

        <!-- Total Poin -->
        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-3">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-<?= $p_class ?>"><i class="bx <?= $p_icon ?>"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Total Poin</span>
                    <h3 class="card-title mb-0 text-<?= $p_class ?>"><?= $total ?></h3>
                    <small class="text-<?= $p_class ?> fw-semibold"><?= $predikat ?></small>
                </div>
            </div>
        </div>

        <!-- Dinilai Oleh -->
        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-3">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-user-check"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Dinilai Oleh</span>
                    <h3 class="card-title mb-0 text-info" style="font-size:1rem;"><?= htmlspecialchars($assessment->admin_name) ?></h3>
                    <small class="text-muted"><?= count($details) ?> aspek dinilai</small>
                </div>
            </div>
        </div>

        <!-- Ringkasan Kondisi -->
        <div class="col-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-3">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-pie-chart-alt-2"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-muted" style="font-size:0.8rem;">Kondisi Aspek</span>
                    <div class="d-flex align-items-center gap-2 flex-wrap mt-1">
                        <span class="badge bg-label-success"><?= $count_bersih ?> Bersih</span>
                        <span class="badge bg-label-warning"><?= $count_cukup ?> Cukup</span>
                        <span class="badge bg-label-danger"><?= $count_kotor ?> Kotor</span>
                    </div>
                    <small class="text-muted d-block mt-1">total <?= count($details) ?> aspek</small>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Detail Aspek Card ── -->
    <div class="row g-4">

        <!-- Tabel Aspek -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h5 class="m-0 me-2">Detail Per Aspek</h5>
                        <small class="text-muted"><?= count($details) ?> aspek penilaian</small>
                    </div>
                    <span class="badge bg-label-<?= $p_class ?> px-3 py-2" style="font-size:0.8125rem;">
                        <i class="bx <?= $p_icon ?> me-1"></i><?= $predikat ?>
                    </span>
                </div>

                <!-- DESKTOP TABLE -->
                <div class="d-none d-md-block">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="50" class="text-center ps-4">No</th>
                                    <th>Aspek Penilaian</th>
                                    <th class="text-center" width="160">Kondisi</th>
                                    <th class="text-center" width="120">Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($details as $d):
                                    $cp = $d->condition_status == 'bersih' ? 'success' : ($d->condition_status == 'cukup' ? 'warning' : 'danger');
                                    $cl = ucfirst($d->condition_status);
                                ?>
                                <tr>
                                    <td class="text-center text-muted ps-4"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar avatar-sm flex-shrink-0">
                                                <span class="avatar-initial rounded bg-label-<?= $cp ?>">
                                                    <i class="bx bx-check-shield" style="font-size:13px;"></i>
                                                </span>
                                            </div>
                                            <strong><?= htmlspecialchars($d->aspect_name) ?></strong>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-label-<?= $cp ?>"><?= $cl ?></span>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-<?= $cp ?>" style="font-size:1.1rem;"><?= $d->point ?></strong>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold pe-3">Total Poin:</td>
                                    <td class="text-center">
                                        <strong class="text-<?= $p_class ?>" style="font-size:1.25rem;"><?= $total ?></strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- MOBILE -->
                <div class="d-md-none p-3">
                    <?php $no = 1; foreach ($details as $d):
                        $cp = $d->condition_status == 'bersih' ? 'success' : ($d->condition_status == 'cukup' ? 'warning' : 'danger');
                        $cl = ucfirst($d->condition_status);
                    ?>
                    <div class="d-flex align-items-center gap-3 p-2 mb-2 rounded-3 border bg-white">
                        <span class="text-muted fw-semibold flex-shrink-0" style="min-width:18px;font-size:0.8rem;"><?= $no++ ?></span>
                        <div class="avatar avatar-sm flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-<?= $cp ?>">
                                <i class="bx bx-check-shield" style="font-size:13px;"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <strong class="d-block text-truncate" style="font-size:0.875rem;"><?= htmlspecialchars($d->aspect_name) ?></strong>
                            <span class="badge bg-label-<?= $cp ?>" style="font-size:0.7rem;"><?= $cl ?></span>
                        </div>
                        <div class="text-center flex-shrink-0">
                            <strong class="text-<?= $cp ?>" style="font-size:1.2rem;"><?= $d->point ?></strong>
                            <div class="text-muted" style="font-size:0.65rem;">poin</div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <!-- Total -->
                    <div class="d-flex justify-content-between align-items-center p-3 mt-2 rounded-3"
                         style="background:#f8f9ff;border:1px solid #e0e1ff;">
                        <span class="fw-semibold text-muted">Total Poin</span>
                        <strong class="text-<?= $p_class ?>" style="font-size:1.5rem;"><?= $total ?></strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan sidebar — Sneat "Transactions" list style -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="m-0 me-2">Ringkasan Kondisi</h5>
                    <small class="text-muted">per aspek penilaian</small>
                </div>
                <div class="card-body px-0">
                    <ul class="p-0 m-0">
                        <!-- Bersih -->
                        <li class="d-flex align-items-center gap-3 px-4 mb-3 pb-1">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-check-circle"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div>
                                    <h6 class="mb-0">Bersih</h6>
                                    <small class="text-muted">kondisi baik</small>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-0 text-success"><?= $count_bersih ?></h6>
                                    <small class="text-muted">aspek</small>
                                </div>
                            </div>
                        </li>
                        <!-- Cukup -->
                        <li class="d-flex align-items-center gap-3 px-4 mb-3 pb-1">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-minus-circle"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div>
                                    <h6 class="mb-0">Cukup</h6>
                                    <small class="text-muted">perlu perhatian</small>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-0 text-warning"><?= $count_cukup ?></h6>
                                    <small class="text-muted">aspek</small>
                                </div>
                            </div>
                        </li>
                        <!-- Kotor -->
                        <li class="d-flex align-items-center gap-3 px-4 mb-3 pb-1">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-x-circle"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div>
                                    <h6 class="mb-0">Kotor</h6>
                                    <small class="text-muted">perlu segera dibersihkan</small>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-0 text-danger"><?= $count_kotor ?></h6>
                                    <small class="text-muted">aspek</small>
                                </div>
                            </div>
                        </li>
                        <!-- Divider total -->
                        <li class="px-4 pt-2" style="border-top:1px solid #eee;">
                            <div class="d-flex align-items-center justify-content-between py-2">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar flex-shrink-0">
                                        <span class="avatar-initial rounded bg-label-<?= $p_class ?>">
                                            <i class="bx <?= $p_icon ?>"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Predikat Akhir</h6>
                                        <small class="text-muted">berdasarkan total poin</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <h5 class="mb-0 text-<?= $p_class ?>"><?= $total ?></h5>
                                    <span class="badge bg-label-<?= $p_class ?>"><?= $predikat ?></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
