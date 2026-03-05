<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Al-Hadi /</span> Penilaian Kelas
            </h4>
            <p class="text-muted mb-0">Pilih kelas untuk melihat riwayat penilaian</p>
        </div>
        <a href="<?= base_url('assessments/create') ?>" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Tambah Penilaian
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0"><i class="bx bx-building-house me-2 text-primary"></i>Daftar Kelas</h5>
            <small class="text-muted">Total: <strong><?= count($classes) ?></strong> kelas</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Nama Kelas</th>
                            <th class="text-center">Total Penilaian</th>
                            <th class="text-center">Penilaian Terakhir</th>
                            <th class="text-center">Status Hari Ini</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($classes)): ?>
                        <?php
                        $today = date('Y-m-d');
                        $no    = 1;
                        foreach ($classes as $cls):
                            // Cek apakah sudah dinilai hari ini
                            $sudah_dinilai = $this->assessments->check_duplicate($cls->id, $today);
                            // Ambil ringkasan per kelas
                            $rekap = $this->assessments->get_rekap_satu_kelas($cls->id);
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2 bg-label-primary rounded">
                                        <span class="avatar-initial rounded"><i class="bx bx-building-house"></i></span>
                                    </div>
                                    <strong><?= htmlspecialchars($cls->class_name) ?></strong>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-label-primary">
                                    <?= $rekap->total_penilaian ?? 0 ?> kali
                                </span>
                            </td>
                            <td class="text-center text-muted">
                                <?= $rekap && $rekap->terakhir_dinilai
                                    ? date('d M Y', strtotime($rekap->terakhir_dinilai))
                                    : '<span class="text-muted fst-italic">Belum pernah</span>' ?>
                            </td>
                            <td class="text-center">
                                <?php if ($sudah_dinilai): ?>
                                    <span class="badge bg-success">
                                        <i class="bx bx-check me-1"></i>Sudah Dinilai
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="bx bx-time me-1"></i>Belum Dinilai
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('assessments/class_detail/' . $cls->id) ?>"
                                   class="btn btn-sm btn-primary" title="Lihat Penilaian">
                                    <i class="bx bx-list-ul me-1"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bx bx-inbox fs-1 d-block mb-2"></i>
                                Belum ada kelas. Silakan tambahkan kelas terlebih dahulu.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
