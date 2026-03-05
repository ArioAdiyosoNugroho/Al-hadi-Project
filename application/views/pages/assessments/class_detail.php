<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">
                    Al-Hadi /
                    <a href="<?= base_url('assessments') ?>" class="text-muted">Penilaian</a> /
                </span>
                <?= htmlspecialchars($kelas->class_name) ?>
            </h4>
            <p class="text-muted mb-0">Riwayat penilaian kebersihan <?= htmlspecialchars($kelas->class_name) ?></p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('assessments') ?>" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
            <?php $sudah_dinilai_hari_ini = $this->assessments->check_duplicate($kelas->id, date('Y-m-d')); ?>
            <?php if (!$sudah_dinilai_hari_ini): ?>
            <a href="<?= base_url('assessments/create?class_id=' . $kelas->id) ?>" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Nilai Hari Ini
            </a>
            <?php else: ?>
            <button class="btn btn-success" disabled>
                <i class="bx bx-check me-1"></i> Sudah Dinilai Hari Ini
            </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0">
                <i class="bx bx-clipboard me-2 text-primary"></i>
                Riwayat Penilaian — <?= htmlspecialchars($kelas->class_name) ?>
            </h5>
            <small class="text-muted">Total: <strong><?= count($assessments) ?></strong> penilaian</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Tanggal Penilaian</th>
                            <th>Dinilai Oleh</th>
                            <th class="text-center">Total Poin</th>
                            <th class="text-center">Predikat</th>
                            <th width="130" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($assessments as $row): ?>
                        <?php
                            if ($row->total_point >= 80)     $predikat = ['label' => 'Sangat Bersih', 'class' => 'bg-success'];
                            elseif ($row->total_point >= 60) $predikat = ['label' => 'Bersih',        'class' => 'bg-primary'];
                            elseif ($row->total_point >= 40) $predikat = ['label' => 'Cukup',         'class' => 'bg-warning'];
                            else                             $predikat = ['label' => 'Kurang',         'class' => 'bg-danger'];
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td>
                                <i class="bx bx-calendar me-1 text-muted"></i>
                                <?= date('d M Y', strtotime($row->assessment_date)) ?>
                                <?php if ($row->assessment_date === date('Y-m-d')): ?>
                                    <span class="badge bg-label-info ms-1">Hari ini</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <i class="bx bx-user me-1 text-muted"></i>
                                <?= htmlspecialchars($row->admin_name) ?>
                            </td>
                            <td class="text-center fw-bold fs-5"><?= $row->total_point ?></td>
                            <td class="text-center">
                                <span class="badge <?= $predikat['class'] ?>"><?= $predikat['label'] ?></span>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('assessments/detail/' . $row->id) ?>"
                                    class="btn btn-sm btn-icon btn-outline-info me-1" title="Detail">
                                    <i class="bx bx-show"></i>
                                </a>
                                <a href="<?= base_url('assessments/edit/' . $row->id) ?>"
                                    class="btn btn-sm btn-icon btn-outline-warning me-1" title="Edit">
                                    <i class="bx bx-edit-alt"></i>
                                </a>
                                <a href="<?= base_url('assessments/delete/' . $row->id) ?>"
                                    class="btn btn-sm btn-icon btn-outline-danger btn-delete"
                                    data-name="penilaian tanggal <?= date('d M Y', strtotime($row->assessment_date)) ?>"
                                    title="Hapus">
                                    <i class="bx bx-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
