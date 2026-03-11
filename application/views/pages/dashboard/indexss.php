<!-- application/views/pages/dashboard/index.php -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    <!-- ── Selamat Datang ── -->
    <div class="col-lg-8 mb-4 order-0">
      <div class="card">
        <div class="d-flex align-items-end row">
          <div class="col-sm-7">
            <div class="card-body">
              <h5 class="card-title text-primary">Aplikasi Penilai Kebersihan Al-Hadi</h5>
              <p class="mb-4">
                <span class="fw-bold">"Kebersihan adalah sebagian dari Iman."</span><br>
                Pantau skor kebersihan kelas secara real-time dan buat penilaian hari ini.
              </p>
              <a href="<?= base_url('assessments') ?>" class="btn btn-sm btn-outline-primary">
                <i class="bx bx-check-circle me-1"></i>Mulai Penilaian
              </a>
            </div>
          </div>
          <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img src="<?= base_url('assets/') ?>assets/img/illustrations/man-with-laptop-light.png"
                height="140" alt="Dashboard"
                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                data-app-light-img="illustrations/man-with-laptop-light.png" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── Stat Cards ── -->
    <div class="col-lg-4 col-md-4 order-1">
      <div class="row">
        <div class="col-lg-6 col-md-12 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <span class="avatar-initial rounded bg-label-success">
                    <i class="bx bx-star fs-4"></i>
                  </span>
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Rata-rata Skor</span>
              <h3 class="card-title mb-2"><?= number_format($avg_point_month, 1) ?></h3>
              <small class="<?= $avg_percent >= 60 ? 'text-success' : 'text-danger' ?> fw-semibold">
                <i class="bx bx-<?= $avg_percent >= 60 ? 'up' : 'down' ?>-arrow-alt"></i>
                <?= $avg_percent ?>% dari maks
              </small>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <span class="avatar-initial rounded bg-label-primary">
                    <i class="bx bx-list-check fs-4"></i>
                  </span>
                </div>
              </div>
              <span class="d-block mb-1">Total Penilaian</span>
              <h3 class="card-title text-nowrap mb-1"><?= number_format($assessments_month) ?></h3>
              <small class="text-success fw-semibold">
                <i class="bx bx-calendar me-1"></i>Bulan <?= date('M Y') ?>
              </small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── Grafik Tren Bulanan (7 bulan) ── -->
    <div class="col-12 col-lg-8 order-2 mb-4">
      <div class="card">
        <div class="row row-bordered g-0">
          <div class="col-md-8">
            <h5 class="card-header m-0 me-2 pb-3">Tren Penilaian 7 Bulan Terakhir</h5>
            <div id="totalRevenueChart" class="px-2"></div>
          </div>
          <div class="col-md-4">
            <div class="card-body">
              <div class="text-center mb-2">
                <span class="badge bg-label-primary px-3 py-2" style="font-size:0.8rem;">
                  <?= date('Y') ?>
                </span>
              </div>
            </div>
            <div id="growthChart"></div>
            <div class="text-center fw-semibold pt-3 mb-2"><?= $avg_percent ?>% Rata-rata Skor</div>
            <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
              <div class="d-flex">
                <div class="me-2">
                  <span class="badge bg-label-primary p-2">
                    <i class="bx bx-building-house text-primary"></i>
                  </span>
                </div>
                <div class="d-flex flex-column">
                  <small>Kelas Terdata</small>
                  <h6 class="mb-0"><?= $total_classes ?></h6>
                </div>
              </div>
              <div class="d-flex">
                <div class="me-2">
                  <span class="badge bg-label-warning p-2">
                    <i class="bx bx-time text-warning"></i>
                  </span>
                </div>
                <div class="d-flex flex-column">
                  <small>Belum Dinilai</small>
                  <h6 class="mb-0"><?= $classes_not_assessed ?></h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── Kelas Terbaik/Terburuk + Tren Mingguan ── -->
    <div class="col-12 col-md-8 col-lg-4 order-3 mb-4">
      <div class="row">
        <?php
          $best  = !empty($ranking) ? $ranking[0]      : null;
          $worst = !empty($ranking) ? end($ranking)    : null;
        ?>
        <div class="col-6 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="avatar flex-shrink-0 mb-3">
                <span class="avatar-initial rounded bg-label-success">
                  <i class="bx bx-trophy fs-4 text-success"></i>
                </span>
              </div>
              <span class="d-block mb-1 small text-muted">Kelas Terbersih</span>
              <h6 class="card-title text-nowrap mb-2 text-truncate" style="max-width:120px;">
                <?= $best ? htmlspecialchars($best->class_name) : '-' ?>
              </h6>
              <small class="text-success fw-semibold">
                <i class="bx bx-up-arrow-alt"></i> Skor <?= $best ? round($best->avg_point, 1) : 0 ?>
              </small>
            </div>
          </div>
        </div>
        <div class="col-6 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="avatar flex-shrink-0 mb-3">
                <span class="avatar-initial rounded bg-label-danger">
                  <i class="bx bx-error-circle fs-4 text-danger"></i>
                </span>
              </div>
              <span class="fw-semibold d-block mb-1 small text-muted">Kelas Terkotor</span>
              <h6 class="card-title text-nowrap mb-2 text-truncate" style="max-width:120px;">
                <?= $worst ? htmlspecialchars($worst->class_name) : '-' ?>
              </h6>
              <small class="text-danger fw-semibold">
                <i class="bx bx-down-arrow-alt"></i> Skor <?= $worst ? round($worst->avg_point, 1) : 0 ?>
              </small>
            </div>
          </div>
        </div>

        <!-- Skor Mingguan Sparkline -->
        <div class="col-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                  <div class="card-title">
                    <h5 class="text-nowrap mb-2">Tren Mingguan</h5>
                    <span class="badge bg-label-warning rounded-pill">7 Hari Terakhir</span>
                  </div>
                  <div class="mt-sm-auto">
                    <small class="text-success text-nowrap fw-semibold">
                      <i class="bx bx-chevron-up"></i> Aktif
                    </small>
                    <h3 class="mb-0"><?= $assessments_today ?> <small class="fs-6 text-muted">hari ini</small></h3>
                  </div>
                </div>
                <div id="profileReportChart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ── Row 2 ── -->
  <div class="row">

    <!-- Distribusi Kondisi Donut -->
    <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between pb-0">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2">Distribusi Kondisi</h5>
            <small class="text-muted">Bulan <?= $bulan_ini ?></small>
          </div>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column align-items-center gap-1">
              <?php $condArr = json_decode($chart_condition, true); ?>
              <h2 class="mb-2"><?= array_sum($condArr) ?></h2>
              <span class="small text-muted">Total Detail</span>
            </div>
            <div id="orderStatisticsChart"></div>
          </div>
          <ul class="p-0 m-0">
            <li class="d-flex mb-4 pb-1">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-check"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Bersih</h6>
                  <small class="text-muted">Kondisi terbaik</small>
                </div>
                <span class="badge bg-label-success"><?= $condArr['bersih'] ?? 0 ?></span>
              </div>
            </li>
            <li class="d-flex mb-4 pb-1">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-minus"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Cukup</h6>
                  <small class="text-muted">Perlu perhatian</small>
                </div>
                <span class="badge bg-label-warning"><?= $condArr['cukup'] ?? 0 ?></span>
              </div>
            </li>
            <li class="d-flex">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-x"></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Kotor</h6>
                  <small class="text-muted">Perlu tindakan</small>
                </div>
                <span class="badge bg-label-danger"><?= $condArr['kotor'] ?? 0 ?></span>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Rata-rata per Kelas Horizontal Bar -->
    <div class="col-md-6 col-lg-4 order-1 mb-4">
      <div class="card h-100">
        <div class="card-header">
          <h5 class="card-title">Rata-rata Poin per Kelas</h5>
          <small class="text-muted">Bulan <?= $bulan_ini ?></small>
        </div>
        <div class="card-body">
          <div id="incomeChart"></div>
          <div class="d-flex justify-content-center pt-3 gap-3">
            <div id="expensesOfWeek"></div>
            <div>
              <p class="mb-0 mt-1 fw-semibold">Penilaian Hari Ini</p>
              <small class="text-muted"><?= $assessments_today ?> kali</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Penilaian Terbaru -->
    <div class="col-md-6 col-lg-4 order-2 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Penilaian Terbaru</h5>
          <a href="<?= base_url('assessments') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body" style="max-height: 360px; overflow-y: auto;">
          <ul class="p-0 m-0">
            <?php if (!empty($recent_assessments)): ?>
              <?php foreach ($recent_assessments as $item):
                $total = $item->total_point;
                if ($total >= 80)     { $cls = 'success'; $icon = 'bx-trophy'; }
                elseif ($total >= 60) { $cls = 'primary'; $icon = 'bx-like'; }
                elseif ($total >= 40) { $cls = 'warning'; $icon = 'bx-minus-circle'; }
                else                  { $cls = 'danger';  $icon = 'bx-dislike'; }
              ?>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-<?= $cls ?>">
                    <i class="bx <?= $icon ?>"></i>
                  </span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0"><?= htmlspecialchars($item->class_name) ?></h6>
                    <small class="text-muted"><?= $item->assessor ?? 'Admin' ?></small>
                  </div>
                  <div class="text-end">
                    <span class="badge bg-label-<?= $cls ?> mb-1"><?= $total ?> poin</span>
                    <small class="text-muted d-block">
                      <?= date('d M', strtotime($item->assessment_date)) ?>
                    </small>
                  </div>
                </div>
              </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="text-center py-4 text-muted">
                <i class="bx bx-inbox d-block mb-2" style="font-size:2rem;opacity:0.3;"></i>
                Belum ada penilaian
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- ── Inject data PHP ke JavaScript ── -->
<script>
window._dash = {
  weekly:       <?= $chart_weekly ?>,
  monthly:      <?= $chart_monthly ?>,
  perClass:     <?= $chart_avg_per_class ?>,
  condition:    <?= $chart_condition ?>,
  avgPercent:   <?= (int)$avg_percent ?>,
  todayCount:   <?= (int)$assessments_today ?>,
  totalClasses: <?= (int)$total_classes ?>
};
</script>
