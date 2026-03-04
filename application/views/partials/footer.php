    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?= base_url('assets/') ?>assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url('assets/') ?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url('assets/') ?>assets/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url('assets/') ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="<?= base_url('assets/') ?>assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?= base_url('assets/') ?>assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="<?= base_url('assets/') ?>assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?= base_url('assets/') ?>assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>



	<script>
		$(document).ready(function () {
		    $('#example').DataTable({
		        paging:       true,
		        searching:    true,
		        ordering:     true,
		        info:         true,
		        lengthChange: true,
		        pageLength:   10,
		        // Kolom Aksi tidak perlu di-sort
		        columnDefs: [
		            { orderable: false, targets: [0, 3] }
		        ],
		        language: {
		            search:      "Cari:",
		            lengthMenu:  "Tampilkan _MENU_ data",
		            info:        "Menampilkan _START_ - _END_ dari _TOTAL_ data",
		            zeroRecords: "Data tidak ditemukan",
		            emptyTable:  "Tidak ada data yang tersedia pada tabel ini",
		            paginate: {
		                first:    "Awal",
		                last:     "Akhir",
		                next:     "›",
		                previous: "‹"
		            }
		        }
		    });
		});


		//=====================sweetallert========
		// Notifikasi Sukses
		<?php if ($this->session->flashdata('success')): ?>
		    setTimeout(function() {
		        Swal.fire({
		            icon: 'success',
		            title: 'Berhasil!',
		            text: '<?= $this->session->flashdata('success') ?>',
		            confirmButtonText: 'OK',
		            confirmButtonColor: '#696cff',
		            timer: 3000,
		            timerProgressBar: true
		        });
		    }, 300);
		<?php endif; ?>
		
		// Notifikasi Error
		<?php if ($this->session->flashdata('error')): ?>
		    setTimeout(function() {
		        Swal.fire({
		            icon: 'error',
		            title: 'Oops...',
		            text: '<?= $this->session->flashdata('error') ?>',
		            confirmButtonText: 'Tutup',
		            confirmButtonColor: '#d33'
		        });
		    }, 300);
		<?php endif; ?>
		
		// Konfirmasi Hapus
		$(document).on('click', '.btn-delete', function(e) {
		    e.preventDefault();
		    const href = $(this).attr('href');
		    Swal.fire({
		        title: 'Apakah anda yakin?',
		        text: "Data yang dihapus tidak bisa dikembalikan!",
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
	</script>
