<!-- Core JS -->
    <script src="<?= base_url('assets/') ?>assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url('assets/') ?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url('assets/') ?>assets/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url('assets/') ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url('assets/') ?>assets/vendor/js/menu.js"></script>

    <!-- Vendors JS -->
    <script src="<?= base_url('assets/') ?>assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="<?= base_url('assets/') ?>assets/js/main.js"></script>

    <?php
    // Hanya load JS dashboard di halaman dashboard saja
    $current_uri = $this->uri->segment(1);
    if ($current_uri === 'dashboard' || $current_uri === ''):
    ?>
    <script src="<?= base_url('assets/') ?>assets/js/dashboards-analytics.js"></script>
    <?php endif; ?>

    <script>
    $(document).ready(function () {

        // ── DataTable (hanya jika ada tabel #example) ──
        if ($('#example').length) {
            $('#example').DataTable({
                paging:       true,
                searching:    true,
                ordering:     true,
                info:         true,
                lengthChange: true,
                pageLength:   25,
                language: {
                    search:      "Cari:",
                    lengthMenu:  "Tampilkan _MENU_ data",
                    info:        "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    zeroRecords: "Data tidak ditemukan",
                    emptyTable:  "Tidak ada data yang tersedia pada tabel ini",
                    paginate:    { previous: '&laquo;', next: '&raquo;' }
                },
                dom: '<"d-flex flex-wrap align-items-center justify-content-between gap-2 px-3 pt-3 pb-2"lf>t<"d-flex justify-content-between align-items-center px-3 pb-3 pt-2"ip>',
            });
        }

        // ── SweetAlert: Sukses ──
        <?php if ($this->session->flashdata('success')): ?>
        setTimeout(function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= addslashes($this->session->flashdata('success')) ?>',
                confirmButtonText: 'OK',
                confirmButtonColor: '#696cff',
                timer: 3000,
                timerProgressBar: true
            });
        }, 300);
        <?php endif; ?>

        // ── SweetAlert: Error ──
        <?php if ($this->session->flashdata('error')): ?>
        setTimeout(function () {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= addslashes($this->session->flashdata('error')) ?>',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#d33'
            });
        }, 300);
        <?php endif; ?>

        // ── SweetAlert: Konfirmasi Hapus ──
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            const href = $(this).attr('href');
            const name = $(this).data('name') ? ' "' + $(this).data('name') + '"' : '';
            Swal.fire({
                title: 'Hapus' + name + '?',
                text: 'Data yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });

    });
    </script>
