        <?php
				// Ambil segment pertama URI untuk menentukan menu aktif
				$uri = $this->uri->segment(1); // contoh: 'dashboard', 'classes', 'students'
				?>
				<!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
					<div class="app-brand demo">
					    <a href="<?= base_url('dashboard') ?>" class="app-brand-link">
					        <span class="app-brand-logo demo">
					            <img src="<?= base_url('assets/') ?>assets/img/logo.png" 
					                 alt="Al-Hadi" 
					                 style="height: 36px; width: auto; display: block;">
					        </span>
									<span class="app-brand-text demo menu-text fw-bolder ms-2" style="font-size: 1.5rem; text-transform: capitalize;">Al-Hadi</span>
					    </a>
								
					    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
					        <i class="bx bx-chevron-left bx-sm align-middle"></i>
					    </a>
					</div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item <?= $uri === 'dashboard' ? 'active' : '' ?>">
              <a href="<?= base_url('dashboard') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Master</span>
            </li>

				    <li class="menu-item <?= $uri === 'classes' ? 'active' : '' ?>">
              <a href="<?= base_url('classes') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Analytics">Kelas</div>
              </a>
            </li>
				    <li class="menu-item <?= $uri === 'aspects' ? 'active' : '' ?>">
              <a href="<?= base_url('aspects') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-note"></i>
                <div data-i18n="Analytics">Aspek Penilaian</div>
              </a>
            </li>

						<!-- assessments -->
						<li class="menu-header small text-uppercase">
              <span class="menu-header-text">Penilaian</span>
            </li>
						<li class="menu-item <?= $uri === 'assessments' ? 'active' : '' ?>">
              <a href="<?= base_url('assessments') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check"></i>
                <div data-i18n="Analytics">Penilaian</div>
              </a>
            </li>


            <!-- Components -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Laporan</span></li>
            <!-- Cards -->
            <li class="menu-item <?= $uri === 'reports' ? 'active' : '' ?>">
              <a href="<?= base_url('reports') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Basic">Laporan</div>
              </a>
            </li>
            <!-- User interface -->
          </ul>
        </aside>
        <!-- / Menu -->
