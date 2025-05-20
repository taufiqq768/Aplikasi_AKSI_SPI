<title>AKSI | Dashboard</title>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel LHA Audit</title>
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
    <div class="row">
        <div>
            <div class="x_panel tile fixed_height_420 overflow_hidden">
                <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li><!-- 
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>  -->
                    </ul>
                    <h4><?php echo "Table Audit ".$rincian_tl[0]['pemeriksaan_jenis']; ?></h4>
                    
                    <div class="clearfix">
                    </div>
                    <!-- <hr style="height:2px;border:none;color:lightgrey;background-color:lightgrey;"/> -->
                </div>
                    <div class="x_content">
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable">
                            <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Uraian Pemeriksaan</th>
                                    <th rowspan="2">Jumlah Temuan</th>
                                    <th rowspan="2">Rekomendasi</th>
                                    <?php 
                                        $bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                                        foreach ($bulan as $bln) {
                                            echo "<th colspan='5'>$bln</th>";
                                        }
                                    ?>
                                </tr>
                                <tr>
                                    <?php foreach ($bulan as $bln) { ?>
                                        <th>S</th>
                                        <th>BS</th>
                                        <th>BD</th>
                                        <th>TDD</th>
                                        <th>% Status S</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomer = 1; foreach ($rincian_tl as $kk4) {  ?>
                                <tr>
                                    <td><?php echo $nomer."." ?></td>
                                    <td>
                                        <a href="<?= site_url('monitoring/detail_tl/'.$kk4['pemeriksaan_id']) ?>">
                                            <?= $kk4['pemeriksaan_judul']; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $kk4['jumlah_temuan']; ?></td>
                                    <td><?php echo $kk4['jumlah_rekomendasi']; ?></td>

                                    <?php foreach ($bulan as $index => $bln) { 
                                        // Ambil bulan dari rekomendasi_status_tanggal
                                        $bulanData = date('n', strtotime($kk4['rekomendasi_status_tanggal'])); // 1-12
                                        $bulanSekarang = $index + 1; // 1-12

                                        if ($bulanData == $bulanSekarang) { // Tampilkan data hanya jika bulan cocok
                                            $s = $kk4['jumlah_s'];
                                            $bs = $kk4['jumlah_bs'];
                                            $bd = $kk4['jumlah_bd'];
                                            $tdd = $kk4['jumlah_tdd'];
                                            $persen = ($kk4['jumlah_rekomendasi'] > 0) ? $s / $kk4['jumlah_rekomendasi'] * 100 : 0;
                                        } else {
                                            $s = $bs = $bd = $tdd = $persen = "-";
                                        }
                                    ?>
                                        <td>
                                            <!-- Form untuk status "Sesuai" -->
                                           <form id="form_bs_<?= $index ?>" action="<?= site_url('monitoring/detail_tl') ?>" method="post">
                                                <input type="hidden" name="status_rekomendasi" value="Sesuai">
                                                <input type="hidden" name="pemeriksaan_id" value="<?= $kk4['pemeriksaan_id'] ?>">
                                                <button type="submit" style="background:none;border:none;color:blue;cursor:pointer;">
                                                    <?= $s ?>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <!-- Form untuk status "Belum Sesuai" -->
                                           <form id="form_bs_<?= $index ?>" action="<?= site_url('monitoring/detail_tl') ?>" method="post">
                                                <input type="hidden" name="status_rekomendasi" value="Belum Sesuai">
                                                <input type="hidden" name="pemeriksaan_id" value="<?= $kk4['pemeriksaan_id'] ?>">
                                                <button type="submit" style="background:none;border:none;color:blue;cursor:pointer;">
                                                    <?= $bs ?>
                                                </button>
                                            </form>
                                        </td>

                                        <td>
                                            <!-- Form untuk status "Belum di Tindak Lanjut" -->
                                            <form id="form_bs_<?= $index ?>" action="<?= site_url('monitoring/detail_tl') ?>" method="post">
                                                <input type="hidden" name="status_rekomendasi" value="Belum di Tindak Lanjut">
                                                <input type="hidden" name="pemeriksaan_id" value="<?= $kk4['pemeriksaan_id'] ?>">
                                                <button type="submit" style="background:none;border:none;color:blue;cursor:pointer;">
                                                    <?= $bd ?>
                                                </button>
                                            </form>
                                        </td>

                                        <td>
                                            <!-- Form untuk status "Tidak dapat di Tindak Lanjuti" -->
                                            <form id="form_bs_<?= $index ?>" action="<?= site_url('monitoring/detail_tl') ?>" method="post">
                                                <input type="hidden" name="status_rekomendasi" value="Tidak dapat di Tindak Lanjuti">
                                                <input type="hidden" name="pemeriksaan_id" value="<?= $kk4['pemeriksaan_id'] ?>">
                                                <button type="submit" style="background:none;border:none;color:blue;cursor:pointer;">
                                                    <?= $tdd ?>
                                                </button>
                                            </form>
                                        </td>
                                        <td><?php echo $persen . "%"; ?></td>
                                    <?php } ?>
                                </tr>
                                <?php $nomer++; } ?>
                            </tbody>
                            <tfoot>
                                <tr class="footer">
                                    <td colspan="2">Jumlah</td>
                                    <td><?php echo array_sum(array_column($rincian_tl, 'jumlah_temuan')); ?></td>
                                    <td><?php echo array_sum(array_column($rincian_tl, 'jumlah_rekomendasi')); ?></td>

                                    <?php 
                                    $total_s = $total_bs = $total_bd = $total_tdd = $total_rekomendasi = array_fill(0, 12, 0);

                                    foreach ($rincian_tl as $kk4) {
                                        $bulanData = date('n', strtotime($kk4['rekomendasi_status_tanggal'])) - 1; // Index array (0-11)
                                        if ($bulanData >= 0 && $bulanData < 12) {
                                            $total_s[$bulanData] += $kk4['jumlah_s'];
                                            $total_bs[$bulanData] += $kk4['jumlah_bs'];
                                            $total_bd[$bulanData] += $kk4['jumlah_bd'];
                                            $total_tdd[$bulanData] += $kk4['jumlah_tdd'];
                                            $total_rekomendasi[$bulanData] += $kk4['jumlah_rekomendasi'];
                                        }
                                    }

                                    foreach ($bulan as $index => $bln) {
                                        $persen_s = ($total_rekomendasi[$index] > 0) ? ($total_s[$index] / $total_rekomendasi[$index] * 100) : 0;
                                        echo "<td>{$total_s[$index]}</td>";
                                        echo "<td>{$total_bs[$index]}</td>";
                                        echo "<td>{$total_bd[$index]}</td>";
                                        echo "<td>{$total_tdd[$index]}</td>";
                                        echo "<td>" . number_format($persen_s) . "%</td>";
                                    }
                                    ?>
                                </tr>
                            </tfoot>

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