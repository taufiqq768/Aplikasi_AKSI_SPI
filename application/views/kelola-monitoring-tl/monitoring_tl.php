<title>AKSI | Dashboard</title>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring TL</title>
    <style>
    /* Styling untuk membuat tabel lebih rapi */
    .table-container {
        width: 100%;
        overflow-x: auto; /* Biar bisa di-scroll */
        white-space: nowrap; /* Mencegah teks pecah ke bawah */
    }

    .datatable {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .datatable th, .datatable td {
        padding: 5px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .datatable th {
        background-color: #003366; 
        color: white;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .datatable tfoot {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    /* Mengatur agar scroll tetap smooth */
    .table-container::-webkit-scrollbar {
        height: 8px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .table-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    </style>
</head>
<div class="right_col" role="main">
    <!-- AUDIT RUTIN -->
    <div class="row">
        <div>
            <div class="x_panel tile fixed_height_420 overflow_hidden">
                <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li><!-- 
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>  -->
                    </ul>
                    <h4>Audit Rutin</h4>
                </div>
                    <div class="x_content">
                        <div class="table-responsive">
                            <?php
                                $bulanSekarang = date('n'); // Contoh: 5 (Mei)
                                $namaBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                            ?>
                            <table class="table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun</th>
                                        <th>Jumlah Temuan</th>
                                        <th>Jumlah Rekomendasi</th>
                                        <th colspan="5">Status Rekomendasi s.d <?= $namaBulan[$bulanSekarang - 1] . " " . date('Y'); ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="4"></th>
                                        <th>S</th>
                                        <th>BS</th>
                                        <th>BD</th>
                                        <th>TDD</th>
                                        <th>% Status S</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $nomer = 1;
                                    $tahunList = [];

                                    // Kelompokkan data berdasarkan tahun
                                    foreach ($rutin as $row) {
                                        $tahun = $row['tahun'];
                                        if (!isset($tahunList[$tahun])) {
                                            $tahunList[$tahun] = [];
                                        }
                                        $tahunList[$tahun][] = $row;
                                    }

                                    foreach ($tahunList as $tahun => $dataTahun) {
                                        // Hitung jumlah temuan & rekomendasi tahunan
                                        $jumlah_temuan = array_sum(array_column($dataTahun, 'jumlah_temuan'));
                                        $jumlah_rekomendasi = array_sum(array_column($dataTahun, 'jumlah_rekomendasi'));

                                        $s = $bs = $bd = $tdd = $rekom = 0;

                                        // Akumulasi sampai bulan berjalan
                                        foreach ($dataTahun as $item) {
                                            $bulan = (int)date('n', strtotime($item['rekomendasi_status_tanggal']));
                                            if ($bulan <= $bulanSekarang) {
                                                $s += $item['jumlah_s'];
                                                $bs += $item['jumlah_bs'];
                                                $bd += $item['jumlah_bd'];
                                                $tdd += $item['jumlah_tdd'];
                                                $rekom += $item['jumlah_rekomendasi'];
                                            }
                                        }

                                        $persen_s = ($rekom > 0) ? ($s / $rekom * 100) : 0;
                                    ?>
                                    <tr>
                                        <?php $jenis_audit="Rutin"; ?>
                                        <td><?= $nomer++ ?>.</td>
                                        <td>
                                            <a href="<?= site_url('monitoring/rincian_tl/'.$jenis_audit.'/' . $tahun) ?>">
                                                <?= $tahun ?>
                                            </a>
                                        </td>
                                        <td><?= $jumlah_temuan ?></td>
                                        <td><?= $jumlah_rekomendasi ?></td>
                                        <td><?= $s ?></td>
                                        <td><?= $bs ?></td>
                                        <td><?= $bd ?></td>
                                        <td><?= $tdd ?></td>
                                        <td><?= number_format($persen_s) ?>%</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- AUDIT KHUSUS -->
    <div class="row">
        <div>
            <div class="x_panel tile fixed_height_420 overflow_hidden">
                <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li><!-- 
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>  -->
                    </ul>
                    <h4>Audit Khusus</h4>
                </div>
                    <div class="x_content">
                        <div class="table-responsive">
                            <?php
                                $bulanSekarang = date('n'); // Contoh: 5 (Mei)
                                $namaBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                            ?>
                        <table class="table table-striped table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun</th>
                                    <th>Jumlah Temuan</th>
                                    <th>Jumlah Rekomendasi</th>
                                    <th colspan="5">Status Rekomendasi s.d <?= $namaBulan[$bulanSekarang - 1] . " " . date('Y'); ?></th>
                                </tr>
                                <tr>
                                    <th colspan="4"></th>
                                    <th>S</th>
                                    <th>BS</th>
                                    <th>BD</th>
                                    <th>TDD</th>
                                    <th>% Status S</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $nomer = 1;
                                $tahunList = [];

                                // Kelompokkan data berdasarkan tahun
                                foreach ($khusus as $row) {
                                    $tahun = $row['tahun'];
                                    if (!isset($tahunList[$tahun])) {
                                        $tahunList[$tahun] = [];
                                    }
                                    $tahunList[$tahun][] = $row;
                                }

                                foreach ($tahunList as $tahun => $dataTahun) {
                                    // Hitung jumlah temuan & rekomendasi tahunan
                                    $jumlah_temuan = array_sum(array_column($dataTahun, 'jumlah_temuan'));
                                    $jumlah_rekomendasi = array_sum(array_column($dataTahun, 'jumlah_rekomendasi'));

                                    $s = $bs = $bd = $tdd = $rekom = 0;

                                    // Akumulasi sampai bulan berjalan
                                    foreach ($dataTahun as $item) {
                                        $bulan = (int)date('n', strtotime($item['rekomendasi_status_tanggal']));
                                        if ($bulan <= $bulanSekarang) {
                                            $s += $item['jumlah_s'];
                                            $bs += $item['jumlah_bs'];
                                            $bd += $item['jumlah_bd'];
                                            $tdd += $item['jumlah_tdd'];
                                            $rekom += $item['jumlah_rekomendasi'];
                                        }
                                    }

                                    $persen_s = ($rekom > 0) ? ($s / $rekom * 100) : 0;
                                ?>
                                <tr>
                                    <?php $jenis_audit="Khusus"; ?>
                                    <td><?= $nomer++ ?>.</td>
                                    <td>
                                        <a href="<?= site_url('monitoring/rincian_tl/'.$jenis_audit.'/' . $tahun) ?>">
                                            <?= $tahun ?>
                                        </a>
                                    </td>
                                    <td><?= $jumlah_temuan ?></td>
                                    <td><?= $jumlah_rekomendasi ?></td>
                                    <td><?= $s ?></td>
                                    <td><?= $bs ?></td>
                                    <td><?= $bd ?></td>
                                    <td><?= $tdd ?></td>
                                    <td><?= number_format($persen_s) ?>%</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- AUDIT TEMATIK -->
    <div class="row">
        <div>
            <div class="x_panel tile fixed_height_420 overflow_hidden">
                <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li><!-- 
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>  -->
                    </ul>
                    <h4>Audit Tematik</h4>
                </div>
                    <div class="x_content">
                        <div class="table-responsive">
                            <?php
                                $bulanSekarang = date('n'); // Contoh: 5 (Mei)
                                $namaBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                            ?>
                        <table class="table table-striped table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun</th>
                                    <th>Jumlah Temuan</th>
                                    <th>Jumlah Rekomendasi</th>
                                    <th colspan="5">Status Rekomendasi s.d <?= $namaBulan[$bulanSekarang - 1] . " " . date('Y'); ?></th>
                                </tr>
                                <tr>
                                    <th colspan="4"></th>
                                    <th>S</th>
                                    <th>BS</th>
                                    <th>BD</th>
                                    <th>TDD</th>
                                    <th>% Status S</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $nomer = 1;
                                $tahunList = [];

                                // Kelompokkan data berdasarkan tahun
                                foreach ($tematik as $row) {
                                    $tahun = $row['tahun'];
                                    if (!isset($tahunList[$tahun])) {
                                        $tahunList[$tahun] = [];
                                    }
                                    $tahunList[$tahun][] = $row;
                                }

                                foreach ($tahunList as $tahun => $dataTahun) {
                                    // Hitung jumlah temuan & rekomendasi tahunan
                                    $jumlah_temuan = array_sum(array_column($dataTahun, 'jumlah_temuan'));
                                    $jumlah_rekomendasi = array_sum(array_column($dataTahun, 'jumlah_rekomendasi'));

                                    $s = $bs = $bd = $tdd = $rekom = 0;

                                    // Akumulasi sampai bulan berjalan
                                    foreach ($dataTahun as $item) {
                                        $bulan = (int)date('n', strtotime($item['rekomendasi_status_tanggal']));
                                        if ($bulan <= $bulanSekarang) {
                                            $s += $item['jumlah_s'];
                                            $bs += $item['jumlah_bs'];
                                            $bd += $item['jumlah_bd'];
                                            $tdd += $item['jumlah_tdd'];
                                            $rekom += $item['jumlah_rekomendasi'];
                                        }
                                    }

                                    $persen_s = ($rekom > 0) ? ($s / $rekom * 100) : 0;
                                ?>
                                <tr>
                                <?php $jenis_audit="Tematik"; ?>
                                    <td><?= $nomer++ ?>.</td>
                                    <td>
                                        <a href="<?= site_url('monitoring/rincian_tl/'.$jenis_audit.'/' . $tahun) ?>">
                                            <?= $tahun ?>
                                        </a>
                                    </td>
                                    <td><?= $jumlah_temuan ?></td>
                                    <td><?= $jumlah_rekomendasi ?></td>
                                    <td><?= $s ?></td>
                                    <td><?= $bs ?></td>
                                    <td><?= $bd ?></td>
                                    <td><?= $tdd ?></td>
                                    <td><?= number_format($persen_s) ?>%</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

    
   
<!-- jQuery -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/Chart.js/dist/Chart.min.js"></script>
<!-- gauge.js -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/iCheck/icheck.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/select2/dist/js/select2.full.min.js"></script>
<!-- Autosize -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/autosize/dist/autosize.min.js"></script>
<!-- jQuery autocomplete -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap-datetimepicker -->    
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!-- bootstrap-wysiwyg -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/google-code-prettify/src/prettify.js"></script>
<!-- Skycons -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/skycons/skycons.js"></script>
<!-- Dropzone.js -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/dropzone/dist/min/dropzone.min.js"></script>
<!-- Flot -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/Flot/jquery.flot.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/Flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/Flot/jquery.flot.time.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/Flot/jquery.flot.stack.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- Datatables -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<!-- Custom Theme Scripts -->
<script src="<?php echo base_url(); ?>/asset/gentelella/build/js/custom.min.js"></script>
<script>
$(document).ready(function() {
$('.datatable').DataTable();

});
</script>
<script type="text/javascript">
$(document).ready(function() {
$('.tab-button').click(function() {
    var tab = $(this).data('tab');
    $('.tab-button').removeClass('active');
    $(this).addClass('active');
    $('.tab-content').hide();
    $('#' + tab).show();
});
});
</script>