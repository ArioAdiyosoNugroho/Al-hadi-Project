<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="<?= base_url('assets/') ?>assets/"
  data-template="vertical-menu-template-free"
>
		<head>
		    <meta charset="utf-8" />
		    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

		    <title><?= $title ?? 'Al-Hadi Kebersihan Kelas' ?> | AL-Hadi</title>
		    <meta name="description" content="" />

		    <!-- Favicon -->
		    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/') ?>assets/img/favicon/favicon.ico" />

		    <!-- Fonts -->
		    <link rel="preconnect" href="https://fonts.googleapis.com" />
		    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

		    <!-- Icons -->
		    <link rel="stylesheet" href="<?= base_url('assets/') ?>assets/vendor/fonts/boxicons.css" />

		    <!-- Core CSS -->
		    <link rel="stylesheet" href="<?= base_url('assets/') ?>assets/vendor/css/core.css" class="template-customizer-core-css" />
		    <link rel="stylesheet" href="<?= base_url('assets/') ?>assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
		    <link rel="stylesheet" href="<?= base_url('assets/') ?>assets/css/demo.css" />

		    <!-- Vendors CSS -->
		    <link rel="stylesheet" href="<?= base_url('assets/') ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
		    <link rel="stylesheet" href="<?= base_url('assets/') ?>assets/vendor/libs/apex-charts/apex-charts.css" />
		    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

		    <!-- DataTables CSS — harus SEBELUM custom override -->
		    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />

		    <!-- Custom DataTable Override — harus PALING AKHIR agar menang -->
		    <link rel="stylesheet" href="<?= base_url('assets/') ?>assets/css/data-table.css" />

		    <!-- Helpers -->
		    <script src="<?= base_url('assets/') ?>assets/vendor/js/helpers.js"></script>
		    <script src="<?= base_url('assets/') ?>assets/js/config.js"></script>
		</head>
	<style>
		.swal2-container {
		    z-index: 99999 !important;
		}
	</style>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
			<?php $this->load->view('partials/sidebar') ?>

        <!-- Layout container -->
        <div class="layout-page">

          <!-- Navbar -->
					 <?php $this->load->view('partials/navbar')?>
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">

            <!-- Content -->
						<?php $this->load->view($content)?>
            <!-- / Content -->

							<footer class="content-footer footer bg-footer-theme border-top">
							  <div class="container-xxl d-flex flex-wrap justify-content-between py-3 flex-md-row flex-column text-center text-md-start">

							    <div class="mb-2 mb-md-0">
							      <span class="footer-link">
							        © <script>document.write(new Date().getFullYear());</script>
							        <span class="fw-bold text-primary text-uppercase">Al-Hadi</span>
							      </span>
							      <span class="d-none d-sm-inline-block text-muted ms-1"> — Admin Dashboard</span>
							    </div>

							    <div class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center gap-3">
							      <a href="https://github.com/ArioAdiyosoNugroho/" target="_blank" class="footer-link d-flex align-items-center">
							        <i class="bx bxl-github me-1"></i> GitHub
							      </a>

							      <span class="footer-link small text-muted d-none d-sm-inline-block">|</span>

							      <span class="footer-link small">
							        Made with <i class="tf-icons bx bxs-heart text-danger animate-pulse"></i>
							      </span>
							    </div>

							  </div>
							</footer>
							<style>
							  /* Animasi halus untuk icon hati */
							  @keyframes pulse {
							    0% { transform: scale(1); }
							    50% { transform: scale(1.15); }
							    100% { transform: scale(1); }
							  }
							  .animate-pulse {
							    display: inline-block;
							    animation: pulse 2s infinite ease-in-out;
							  }

							  /* Efek hover pada link github */
							  .footer-link:hover {
							    color: #696cff; /* Warna primary Sneat */
							    transition: 0.3s;
							  }
							</style>
            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

		<?php $this->load->view('partials/footer')?>
  </body>
</html>
