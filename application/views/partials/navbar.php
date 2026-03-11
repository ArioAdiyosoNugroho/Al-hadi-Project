<?php 
  $username = $this->session->userdata('username');
  $inisial = strtoupper(substr($username, 0, 1)); 
  $base = base_url();
?>

<style>
  :root {
    --nav-gap: 15px;
    --nav-blur: 15px;
  }

  #layout-navbar {
    position: sticky;
    top: 0;
    z-index: 1020;
    transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
    background-color: transparent;
    padding: 0.8rem 1.2rem;
    margin-top: 10px;
  }

  #layout-navbar.navbar-scrolled {
    top: var(--nav-gap);
    margin-left: auto;
    margin-right: auto;
    width: calc(100% - 40px);
    max-width: 1400px;
    background: linear-gradient(135deg, rgba(255,255,255,0.5), rgba(255,255,255,0.2)) !important;
    backdrop-filter: blur(var(--nav-blur)) saturate(200%);
    -webkit-backdrop-filter: blur(var(--nav-blur)) saturate(200%);
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05),
                0 10px 20px -5px rgba(0,0,0,0.08),
                inset 0 0 0 1px rgba(255,255,255,0.5);
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.3);
    transform: scaleX(0.99);
  }

  .navbar-nav-right {
    display: flex !important;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    width: 100%;
  }

  #layout-navbar .navbar-nav.align-items-center.search-section {
    flex: 0 1 400px;
    margin-right: 20px;
    position: relative;
  }

  #layout-navbar .nav-item.search-wrapper {
    display: flex;
    align-items: center;
    background: rgba(0,0,0,0.04);
    padding: 6px 15px;
    border-radius: 12px;
    width: 100%;
    transition: 0.3s;
  }

  #layout-navbar .nav-item.search-wrapper:focus-within {
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  }

  #layout-navbar .search-input {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    padding-left: 10px;
    width: 100%;
    outline: none;
    color: #495057;
  }

  #layout-navbar ul.ms-auto {
    margin-left: auto !important;
    flex-shrink: 0;
  }

  /* ── Search Dropdown ── */
  #searchDropdown {
    display: none;
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    right: 0;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    border: 1px solid rgba(0,0,0,0.06);
    overflow: hidden;
    z-index: 9999;
    max-height: 380px;
    overflow-y: auto;
  }

  #searchDropdown.show { display: block; }

  .search-group-label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    color: #aaa;
    text-transform: uppercase;
    padding: 10px 16px 4px;
  }

  .search-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 9px 16px;
    cursor: pointer;
    text-decoration: none;
    color: #333;
    transition: background 0.15s;
  }

  .search-item:hover {
    background: #f5f5ff;
    color: #696cff;
  }

  .search-item .si-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1rem;
  }

  .search-item .si-text { flex: 1; }
  .search-item .si-text strong { font-size: 0.875rem; display: block; }
  .search-item .si-text small { font-size: 0.75rem; color: #999; }

  .search-item .si-badge {
    font-size: 0.68rem;
    padding: 2px 7px;
    border-radius: 20px;
    flex-shrink: 0;
  }

  .search-empty {
    padding: 20px 16px;
    text-align: center;
    color: #aaa;
    font-size: 0.85rem;
  }

  .search-divider {
    border: none;
    border-top: 1px solid #f0f0f0;
    margin: 4px 0;
  }

  /* ── Mobile: search section perlebar ── */
  @media (max-width: 767px) {
    #layout-navbar .navbar-nav.align-items-center.search-section {
      flex: 1;
      margin-right: 10px;
    }
  }
</style>

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center" id="layout-navbar">
  
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right" id="navbar-collapse">
    
    <div class="navbar-nav align-items-center search-section">
      <div class="nav-item search-wrapper">
        <i class="bx bx-search fs-4 lh-0"></i>
        <input 
          type="text" 
          id="globalSearch"
          class="search-input" 
          placeholder="Cari kelas, menu..." 
          autocomplete="off"
        />
        <i class="bx bx-x fs-4 lh-0 text-muted" id="searchClear" style="cursor:pointer;display:none;"></i>
      </div>
      <div id="searchDropdown"></div>
    </div>

    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <span class="avatar-initial rounded-circle bg-info"><?= $inisial ?></span>
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="#">
              <div class="d-flex">
                <div class="flex-grow-1">
                  <span class="fw-semibold d-block"><?= $this->session->userdata('username') ?></span>
                </div>
              </div>
            </a>
          </li>
          <li><div class="dropdown-divider"></div></li>
          <li>
            <a class="dropdown-item" href="<?= base_url('auth/logout') ?>">
              <i class="bx bx-power-off me-2"></i>
              <span class="align-middle">Log Out</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {

  const BASE_URL = '<?= $base ?>';

  const MENU_ITEMS = [
    { label: 'Dashboard',        url: BASE_URL + 'dashboard',   icon: 'bx-home-circle',    color: '#696cff', type: 'Menu' },
    { label: 'Daftar Kelas',     url: BASE_URL + 'classes',     icon: 'bx-buildings',      color: '#696cff', type: 'Menu' },
    { label: 'Penilaian',        url: BASE_URL + 'assessments', icon: 'bx-check-circle',   color: '#696cff', type: 'Menu' },
    { label: 'Aspek Penilaian',  url: BASE_URL + 'aspects',     icon: 'bx-list-ul',        color: '#696cff', type: 'Menu' },
    { label: 'Laporan',          url: BASE_URL + 'reports',     icon: 'bx-file',           color: '#696cff', type: 'Menu' },
    { label: 'Pengguna',         url: BASE_URL + 'users',       icon: 'bx-user',           color: '#696cff', type: 'Menu' },
    { label: 'Nilai Hari Ini',   url: BASE_URL + 'assessments', icon: 'bx-calendar-check', color: '#71dd37', type: 'Menu' },
    { label: 'Export PDF',       url: BASE_URL + 'reports',     icon: 'bxs-file-pdf',      color: '#ff3e1d', type: 'Menu' },
  ];

  const input    = document.getElementById('globalSearch');
  const dropdown = document.getElementById('searchDropdown');
  const clearBtn = document.getElementById('searchClear');
  let debounceTimer = null;

  // ── showDropdown: handle posisi mobile vs desktop ─────────────
  function showDropdown() {
    dropdown.classList.add('show');
    if (window.innerWidth < 768) {
      // Mobile: fixed positioning supaya full width layar
      const rect = document.querySelector('.search-wrapper').getBoundingClientRect();
      dropdown.style.position = 'fixed';
      dropdown.style.top      = (rect.bottom + 8) + 'px';
      dropdown.style.left     = '12px';
      dropdown.style.right    = '12px';
      dropdown.style.width    = 'auto';
    } else {
      // Desktop: kembali ke absolute normal
      dropdown.style.position = '';
      dropdown.style.top      = '';
      dropdown.style.left     = '';
      dropdown.style.right    = '';
      dropdown.style.width    = '';
    }
  }

  // ── Render dropdown ───────────────────────────────────────────
  function renderDropdown(menuResults, classResults) {
    let html = '';

    if (menuResults.length === 0 && classResults.length === 0) {
      html = '<div class="search-empty"><i class="bx bx-search-alt d-block mb-1" style="font-size:1.5rem;"></i>Tidak ditemukan</div>';
      dropdown.innerHTML = html;
      showDropdown(); // ← instance 1
      return;
    }

    if (menuResults.length > 0) {
      html += '<div class="search-group-label">Menu</div>';
      menuResults.forEach(item => {
        html += `
          <a href="${item.url}" class="search-item">
            <div class="si-icon bg-label-primary">
              <i class="bx ${item.icon}" style="color:${item.color}"></i>
            </div>
            <div class="si-text">
              <strong>${item.label}</strong>
              <small>Halaman</small>
            </div>
            <span class="si-badge bg-label-primary">${item.type}</span>
          </a>`;
      });
    }

    if (menuResults.length > 0 && classResults.length > 0) {
      html += '<hr class="search-divider">';
    }

    if (classResults.length > 0) {
      html += '<div class="search-group-label">Kelas</div>';
      classResults.forEach(item => {
        html += `
          <a href="${item.url}" class="search-item">
            <div class="si-icon bg-label-success">
              <i class="bx bx-building-house text-success"></i>
            </div>
            <div class="si-text">
              <strong>${item.label}</strong>
              <small>Lihat detail penilaian</small>
            </div>
            <span class="si-badge bg-label-success">${item.type}</span>
          </a>`;
      });
    }

    dropdown.innerHTML = html;
    showDropdown(); // ← instance 2
  }

  function filterMenu(q) {
    if (!q) return [];
    return MENU_ITEMS.filter(m => m.label.toLowerCase().includes(q.toLowerCase()));
  }

  function fetchClasses(q, callback) {
    fetch(BASE_URL + 'search/classes?q=' + encodeURIComponent(q))
      .then(res => res.json())
      .then(data => callback(data))
      .catch(() => callback([]));
  }

  input.addEventListener('input', function () {
    const q = this.value.trim();
    clearBtn.style.display = q.length > 0 ? 'block' : 'none';

    if (q.length === 0) {
      dropdown.classList.remove('show');
      dropdown.innerHTML = '';
      return;
    }

    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(function () {
      const menuResults = filterMenu(q);
      if (q.length >= 2) {
        fetchClasses(q, function (classResults) {
          renderDropdown(menuResults, classResults);
        });
      } else {
        renderDropdown(menuResults, []);
      }
    }, 250);
  });

  clearBtn.addEventListener('click', function () {
    input.value = '';
    clearBtn.style.display = 'none';
    dropdown.classList.remove('show');
    dropdown.innerHTML = '';
    input.focus();
  });

  document.addEventListener('click', function (e) {
    if (!e.target.closest('.search-section') && !e.target.closest('#searchDropdown')) {
      dropdown.classList.remove('show');
    }
  });

  // Recalculate posisi saat resize
  window.addEventListener('resize', function () {
    if (dropdown.classList.contains('show')) showDropdown();
  });

  const navbar = document.getElementById('layout-navbar');
  window.addEventListener('scroll', function () {
    if (window.scrollY > 15) navbar.classList.add('navbar-scrolled');
    else navbar.classList.remove('navbar-scrolled');
  }, { passive: true });

});
</script>
