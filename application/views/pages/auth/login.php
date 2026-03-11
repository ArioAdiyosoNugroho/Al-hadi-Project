<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="<?= base_url('assets/') ?>assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login | Al-Hadi Kebersihan Kelas</title>
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

    <!-- Page Auth CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>assets/vendor/css/pages/page-auth.css" />

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Helpers -->
    <script src="<?= base_url('assets/') ?>assets/vendor/js/helpers.js"></script>
    <script src="<?= base_url('assets/') ?>assets/js/config.js"></script>

    <style>
      .authentication-wrapper .card {
        box-shadow: 0 4px 24px rgba(0,0,0,.08) !important;
        border-radius: 12px !important;
      }
      .school-badge {
        background: linear-gradient(135deg, #696cff 0%, #9a9cff 100%);
        color: white;
        border-radius: 50px;
        padding: 4px 16px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .5px;
      }
			#togglePassword i {
  			pointer-events: none;
			}
    </style>
  </head>

  <body>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">

          <div class="card">
            <div class="card-body">

              <!-- Logo & Brand -->
              <div class="app-brand justify-content-center mb-1">
                <a href="<?= base_url('auth') ?>" class="app-brand-link gap-2">
					<span class="app-brand-logo demo">
					    <img src="<?= base_url('assets/') ?>assets/img/logo.png" 
					         alt="Al-Hadi" 
					         style="height: 36px; width: auto; display: block;">
					</span>
                  	<span class="app-brand-text demo text-body fw-bolder" style="font-size: 1.5rem; text-transform: capitalize;">Al-Hadi</span>
                </a>
              </div>

              <div class="text-center mb-4">
                <span class="school-badge">Sistem Penilaian Kebersihan Kelas</span>
              </div>

              <h4 class="mb-1">Selamat Datang! 👋</h4>
              <p class="mb-4 text-muted">Silakan masuk untuk mengakses sistem</p>

              <!-- Form Login -->
              <form id="formLogin" action="<?= base_url('auth/login') ?>" method="POST" class="mb-3">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                    <input
                      type="text"
                      class="form-control"
                      id="username"
                      name="username"
                      placeholder="Masukkan username Anda"
                      value="<?= set_value('username') ?>"
                      autofocus
                      required
                    />
                  </div>
                </div>

                <div class="mb-4 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="••••••••••••"
                      required
                    />
                    <span class="input-group-text cursor-pointer" id="togglePassword">
                      <i class="bx bx-hide" id="eyeIcon"></i>
                    </span>
                  </div>
                </div>

                <div class="mb-4">
                  <button class="btn btn-primary d-grid w-100" type="submit">
                    Masuk
                  </button>
                </div>
              </form>

              <div class="text-center">
                <small class="text-muted">© <?= date('Y') ?> Al-Hadi. All rights reserved.</small>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Core JS -->
    <script src="<?= base_url('assets/') ?>assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url('assets/') ?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url('assets/') ?>assets/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url('assets/') ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?= base_url('assets/') ?>assets/vendor/js/menu.js"></script>
    <script src="<?= base_url('assets/') ?>assets/js/main.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      // Toggle show/hide password
// Toggle show/hide password
document.getElementById('togglePassword').addEventListener('click', function (e) {
  // Mencegah aksi default agar tidak terjadi double-trigger
  e.preventDefault();

  const input = document.getElementById('password');
  const icon = document.getElementById('eyeIcon');
  
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.replace('bx-hide', 'bx-show');
  } else {
    input.type = 'password';
    icon.classList.replace('bx-show', 'bx-hide');
  }
});

      // SweetAlert - Notifikasi Error Login
      <?php if ($this->session->flashdata('error')): ?>
      Swal.fire({
        icon: 'error',
        title: 'Login Gagal!',
        text: '<?= addslashes($this->session->flashdata('error')) ?>',
        confirmButtonColor: '#696cff',
        confirmButtonText: 'Coba Lagi'
      });
      <?php endif; ?>

      // SweetAlert - Notifikasi Sukses (misal habis logout)
      <?php if ($this->session->flashdata('success')): ?>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '<?= addslashes($this->session->flashdata('success')) ?>',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
      });
      <?php endif; ?>
    </script>

  </body>
</html>
