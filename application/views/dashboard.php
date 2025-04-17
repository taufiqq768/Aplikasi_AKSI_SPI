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
                            <h4>Tabular KK1</h4>
                            
                            <div class="clearfix">
                            </div>
                            <!-- <hr style="height:2px;border:none;color:lightgrey;background-color:lightgrey;"/> -->
                        </div>
                            <div class="x_content">
                                <button class="btn btn-success btn-lg" id="exportExcel" onclick="exportTableToExcel('auditTable', 'LHA_Audit')">
                                    <span class="fa fa-file-excel-o"></span>
                                </button>
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered datatable">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Uraian</th>
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
                                        <?php $nomer = 1; foreach ($record as $kk4) {  ?>
                                        <tr>
                                            <td><?php echo $nomer."." ?></td>
                                            <td>LHA Audit Tahun <?php echo $kk4['tahun']; ?></td>
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
                                                <td><?php echo $s; ?></td>
                                                <td><?php echo $bs; ?></td>
                                                <td><?php echo $bd; ?></td>
                                                <td><?php echo $tdd; ?></td>
                                                <td><?php echo $persen . "%"; ?></td>
                                            <?php } ?>
                                        </tr>
                                        <?php $nomer++; } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="footer">
                                            <td colspan="2">Jumlah</td>
                                            <td><?php echo array_sum(array_column($record, 'jumlah_temuan')); ?></td>
                                            <td><?php echo array_sum(array_column($record, 'jumlah_rekomendasi')); ?></td>

                                            <?php 
                                            $total_s = $total_bs = $total_bd = $total_tdd = $total_rekomendasi = array_fill(0, 12, 0);

                                            foreach ($record as $kk4) {
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

                    <div class="x_panel tile fixed_height_420 overflow_hidden">
                        <div class="x_title">
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li><!-- 
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>  -->
                            </ul>
                            <h4>Tabular KK2</h4>
                            
                            <div class="clearfix">
                            </div>
                            <!-- <hr style="height:2px;border:none;color:lightgrey;background-color:lightgrey;"/> -->
                        </div>
                        <!-- <div class="tab-container">
                            <button class="tab-button active" data-tab="temuan">Klasifikasi Temuan</button>
                            <button class="tab-button" data-tab="penyebab">Klasifikasi Penyebab</button>
                            <button class="tab-button" data-tab="coso">Klasifikasi COSO</button>
                            <button class="tab-button" data-tab="audit">Klasifikasi Kode A dan B</button>
                        </div> -->
                            <div id="temuan" class="tab-content" style="display: block;">
                                <div class="x_content">
                                    <button class="btn btn-success btn-lg" id="exportExcel" onclick="exportTableToExcel('auditTable', 'LHA_Audit')">
                                        <span class="fa fa-file-excel-o"></span>
                                    </button>
                                    
                                    <h2>Grafik Temuan</h2>
                                    <canvas id="grafikBulanBerjalan" height="100"></canvas>

                                    <h2>Grafik Temuan s/d Bulan Ini</h2>
                                    <canvas id="grafikTotalPerKlasifikasi" height="100"></canvas>

                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="x_panel tile fixed_height_420 overflow_hidden">
                        <div class="x_title">
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li><!-- 
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>  -->
                            </ul>
                            <h4>Tabular KK3</h4>
                            
                            <div class="clearfix">
                            </div>
                            <!-- <hr style="height:2px;border:none;color:lightgrey;background-color:lightgrey;"/> -->
                        </div>
                            <div class="x_content">
                            <!-- <div class="tab-container">
                                <button class="tab-button active" data-tab="rekomendasi">Klasifikasi Rekomendasi</button>
                                <button class="tab-button" data-tab="bidang">Bidang Pekerjaan</button>
                            </div> -->
                                <button class="btn btn-success btn-lg" id="exportExcel" onclick="exportTableToExcel('auditTable', 'LHA_Audit')">
                                    <span class="fa fa-file-excel-o"></span>
                                </button>
                                <div id="bidang" class="tab-content" style="display: block;">
                                
                                    <h2>Grafik Bidang Pekerjaan</h2>
                                    <canvas id="grafikBidangBulanBerjalan" height="100"></canvas>
                                    <h2>Grafik Bidang Pekerjaan s/d Bulan Ini</h2>
                                    <canvas id="grafikBidangKumulatif" height="100"></canvas>
                                </div>
                            </div>
                    </div>

                    <div class="x_panel tile fixed_height_420 overflow_hidden">
                        <div class="x_title">
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li><!-- 
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>  -->
                            </ul>
                            <h4>Tabular KK4</h4>
                            
                            <div class="clearfix">
                            </div>
                            <!-- <hr style="height:2px;border:none;color:lightgrey;background-color:lightgrey;"/> -->
                        </div>
                            <div class="x_content">
                            <!-- <div class="tab-container">
                                <button class="tab-button active" data-tab="kegiatan">Kegiatan DSPI</button>
                                <button class="tab-button" data-tab="lha">Jumlah LHA</button>
                            </div> -->
                                <button class="btn btn-success btn-lg" id="exportExcel" onclick="exportTableToExcel('auditTable', 'LHA_Audit')">
                                    <span class="fa fa-file-excel-o"></span>
                                </button>
                                <h2>Grafik Pelaksanaan Kegiatan Divisi SPI</h2>
                                <canvas id="grafikPkptBulanIni" height="100"></canvas>
                                <h2>Grafik Pelaksanaan Kegiatan Divisi SPI s/d Bulan Ini</h2>
                                <canvas id="grafikPkptKumulatif" height="100"></canvas>
                            </div>
                    </div>
                </div>
            </div>
            
            <!-- ------------------------- -->
            <!-- <div class="col-md-5 col-sm-5 col-xs-12">
              <div class="x_panel tile fixed_height_420 overflow_hidden">
                <div class="x_title">
                  <h2>Progress Jumlah Status</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                     <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <canvas id="myChart2" width="500px"></canvas>

               </div>
              </div>
            </div> -->

          </div>
          
        </div>
        <!-- /page content -->

    
   
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
<script>
    //GRAFIK 2
    // Ambil data dari PHP
    const dataBulanBerjalan = <?= json_encode($bulan_berjalan); ?>;
    const dataKumulatif = <?= json_encode($kumulatif); ?>;

    function getRandomColor() {
    const r = Math.floor(Math.random() * 200);
    const g = Math.floor(Math.random() * 200);
    const b = Math.floor(Math.random() * 200);
    return `rgba(${r}, ${g}, ${b}, 0.7)`;
    }
    
    
    function prosesDataTotalSampaiBulanIni(data) {
        const bulanSekarang = new Date().getMonth(); // 0 = Jan
        const tahunSekarang = new Date().getFullYear();
        const labelBulanIni = 'Sampai dengan Bulan ' + new Date(tahunSekarang, bulanSekarang, 1)
            .toLocaleDateString('id-ID', { month: 'long' });

        const dataKlasifikasi = {};

        data.forEach(item => {
            const tgl = new Date(item.tanggal);
            const bulan = tgl.getMonth();
            const tahun = tgl.getFullYear();

            // ✅ Hitung semua data sampai bulan ini
            if (tahun === tahunSekarang && bulan <= bulanSekarang) {
                const klasifikasi = item.klasifikasi_temuan;
                const jumlah = parseInt(item.jumlah_kemunculan);

                if (!dataKlasifikasi[klasifikasi]) {
                    dataKlasifikasi[klasifikasi] = 0;
                }

                dataKlasifikasi[klasifikasi] += jumlah;
            }
        });

        const datasets = Object.entries(dataKlasifikasi).map(([klasifikasi, jumlah]) => {
            const warna = getRandomColor();
            return {
                label: klasifikasi,
                data: [jumlah], // semua jumlah dalam satu bar (bulan ini)
                backgroundColor: warna,
                borderColor: warna,
                borderWidth: 1
            };
        });

        return {
            labels: [labelBulanIni],
            datasets
        };
    }


    function prosesData(data) {
    const labelsSet = new Set();
    const datasetMap = {};

    data.forEach(item => {
        // Format tanggal konsisten
        const tanggal = new Date(item.tanggal);
        const labelRaw = tanggal.getFullYear() + '-' + (tanggal.getMonth() + 1).toString().padStart(2, '0');
        const labelDisplay = tanggal.toLocaleDateString('id-ID', { day: '2-digit', month: 'long' });
        

        labelsSet.add(labelRaw);

        const klasifikasi = item.klasifikasi_temuan;

        if (!datasetMap[klasifikasi]) {
            datasetMap[klasifikasi] = {};
        }

        if (!datasetMap[klasifikasi][labelRaw]) {
            datasetMap[klasifikasi][labelRaw] = 0;
        }

        datasetMap[klasifikasi][labelRaw] += parseInt(item.jumlah_kemunculan);
    });

    const sortedLabels = Array.from(labelsSet).sort();
    const labelsDisplay = sortedLabels.map(labelRaw => {
    const [year, month] = labelRaw.split('-');
    const tanggal = new Date(`${year}-${month}-01`);
    return 'Bulan ' + tanggal.toLocaleDateString('id-ID', { month: 'long' });
    });

    const datasets = Object.keys(datasetMap).map(klasifikasi => {
        const color = getRandomColor();
        return {
            label: klasifikasi,
            data: sortedLabels.map(lbl => datasetMap[klasifikasi][lbl] || 0),
            backgroundColor: color,
            borderColor: color,
            borderWidth: 1
        };
    });


    return { labels: labelsDisplay, datasets };
}

    function buatChart(canvasId, chartData, chartTitle) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: chartData.datasets
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: chartTitle
                    },
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    const chartDataBulanBerjalan = prosesData(dataBulanBerjalan);
    buatChart('grafikBulanBerjalan', chartDataBulanBerjalan, 'Temuan Bulan Berjalan');

    const chartDataKumulatif = prosesDataTotalSampaiBulanIni(dataKumulatif);
    buatChart('grafikTotalPerKlasifikasi', chartDataKumulatif, 'Temuan Kumulatif (Jan - Sekarang)');

</script>


<script>
    //GRAFIK 3
    const dataBidangBulan = <?= json_encode($record_bidang_bulan); ?>;
    const dataBidangKumulatif = <?= json_encode($record_bidang_kumulatif); ?>;

    function getRandomColor() {
        const r = Math.floor(Math.random() * 156) + 100;
        const g = Math.floor(Math.random() * 156) + 100;
        const b = Math.floor(Math.random() * 156) + 100;
        return `rgba(${r}, ${g}, ${b}, 0.8)`;
    }

    function prosesDataKumulatif(data) {
        const bulanSekarang = 'Sampai Dengan Bulan ' + new Date().toLocaleDateString('id-ID', { month: 'long' });

        const datasetMap = {};

        data.forEach(item => {
            const nama = item.bidangtemuan_nama;
            const jumlah = parseInt(item.jumlah_kemunculan);

            if (!datasetMap[nama]) {
                datasetMap[nama] = 0;
            }

            datasetMap[nama] += jumlah;
        });

        const datasets = Object.keys(datasetMap).map(nama => {
            return {
                label: nama,
                data: [datasetMap[nama]], // hanya 1 nilai karena hanya 1 bulan di sumbu X
                backgroundColor: getRandomColor(),
                borderWidth: 1
            };
        });

        return {
            labels: [bulanSekarang], // hanya bulan berjalan yang ditampilkan
            datasets
        };
    }

    function prosesData(data, gunakanLabelBulan = false) {
        const labelsSet = new Set();
        const datasetMap = {};

        data.forEach(item => {
            const tanggal = new Date(item.tanggal);
            const label = 'Bulan ' + tanggal.toLocaleDateString('id-ID', { month: 'long' });
                
            labelsSet.add(label);

            if (!datasetMap[item.bidangtemuan_nama]) {
                datasetMap[item.bidangtemuan_nama] = {};
            }

            if (!datasetMap[item.bidangtemuan_nama][label]) {
                datasetMap[item.bidangtemuan_nama][label] = 0;
            }

            datasetMap[item.bidangtemuan_nama][label] += parseInt(item.jumlah_kemunculan);
        });

        const labels = Array.from(labelsSet);
        const datasets = Object.keys(datasetMap).map(nama => {
            return {
                label: nama,
                data: labels.map(lbl => datasetMap[nama][lbl] || 0),
                backgroundColor: getRandomColor(),
                borderWidth: 1
            };
        });

        return { labels, datasets };
    }


    function buatChart(canvasId, chartData, chartTitle) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: chartData.datasets
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: chartTitle
                    },
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            maxRotation: 0,
                            minRotation: 0
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    const chartDataBidangBulan = prosesData(dataBidangBulan, false);
    const chartDataBidangKumulatif = prosesDataKumulatif(dataBidangKumulatif);


    buatChart('grafikBidangBulanBerjalan', chartDataBidangBulan, 'Grafik Temuan per Bidang - Bulan Berjalan');
    buatChart('grafikBidangKumulatif', chartDataBidangKumulatif, 'Grafik Temuan per Bidang - Jan s/d Bulan Ini');
</script>

    <!-- <script type="text/javascript">
        $(document).ready(function() {
                $('.tab-button').click(function() {
                    var tab = $(this).data('tab');
                    $('.tab-button').removeClass('active');
                    $(this).addClass('active');
                    $('.tab-content').hide();
                    $('#' + tab).show();
                });
            });
    </script> -->
<script>
    const dataPkpt = <?= json_encode($record4); ?>;

    function getRandomColor() {
        const r = Math.floor(Math.random() * 255);
        const g = Math.floor(Math.random() * 255);
        const b = Math.floor(Math.random() * 255);
        return `rgba(${r}, ${g}, ${b}, 0.7)`;
    }

    function prosesPkptBulanIni(data) {
    const jenisAudit = ['Rutin', 'Khusus', 'Tematik'];

    // Ambil bulan dan tahun saat ini
    const now = new Date();
    const bulanSekarang = now.getMonth() + 1; // 0-based, jadi tambah 1
    const tahunSekarang = now.getFullYear();

    // Format periode: "YYYY-MM"
    const bulanFormatted = bulanSekarang < 10 ? `0${bulanSekarang}` : bulanSekarang;
    const periodeSekarang = `${tahunSekarang}-${bulanFormatted}`;

    const labelTambahan = ` (Bulan ${now.toLocaleDateString('id-ID', { month: 'long' })})`;
    const kategori = [`PKPT${labelTambahan}`, `Realisasi${labelTambahan}`];

    const datasets = [];

    jenisAudit.forEach(jenis => {
        const warna = getRandomColor();

        // Filter data hanya untuk bulan sekarang dan jenis audit ini
        const dataBulanIni = data.find(item =>
            item.bulan === periodeSekarang && item.jenis_audit === jenis
        );

        datasets.push({
            label: jenis,
            backgroundColor: warna,
            data: [
                dataBulanIni ? dataBulanIni.jumlah_pkpt : 0,
                dataBulanIni ? dataBulanIni.jumlah_pemeriksaan : 0
            ]
        });
    });

    return {
        labels: kategori,
        datasets: datasets
    };
}



function prosesPkptKumulatif(data) {
    const jenisAudit = ['Rutin', 'Khusus', 'Tematik'];
    const bulanSekarang = new Date().toLocaleDateString('id-ID', { month: 'long' });
    const labelTambahan = ` (Sampai dengan Bulan ${bulanSekarang})`;
    const kategori = [`PKPT${labelTambahan}`, `Realisasi${labelTambahan}`];
    const datasets = [];

    jenisAudit.forEach(jenis => {
        const warna = getRandomColor();

        // Filter data untuk jenis audit tersebut dan hitung total kumulatif
        const dataAudit = data.filter(item => item.jenis_audit === jenis);
        const totalPkpt = dataAudit.reduce((sum, item) => sum + parseInt(item.jumlah_pkpt), 0);
        const totalPemeriksaan = dataAudit.reduce((sum, item) => sum + parseInt(item.jumlah_pemeriksaan), 0);

        datasets.push({
            label: jenis,
            backgroundColor: warna,
            data: [totalPkpt, totalPemeriksaan]
        });
    });

    return {
        labels: kategori,
        datasets: datasets
    };
}


    function buatChart(canvasId, chartData, chartTitle) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: chartTitle
                    },
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                barPercentage: 0.5,
                categoryPercentage: 0.6
            }
        });
    }

    const chartPkptBulanIni = prosesPkptBulanIni(dataPkpt);
    const chartPkptKumulatif = prosesPkptKumulatif(dataPkpt);

    buatChart('grafikPkptBulanIni', chartPkptBulanIni, 'PKPT & Realisasi Bulan Berjalan');
    buatChart('grafikPkptKumulatif', chartPkptKumulatif, 'Jumlah PKPT Jan - Sekarang');
</script>