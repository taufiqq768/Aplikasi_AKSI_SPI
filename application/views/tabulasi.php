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
                            <h4>Tabular KK4</h4>
                            
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
                                            <td><?php echo $kk4['pemeriksaan_judul']; ?></td>
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
                            <h4>Tabular KK3</h4>
                            
                            <div class="clearfix">
                            </div>
                            <!-- <hr style="height:2px;border:none;color:lightgrey;background-color:lightgrey;"/> -->
                        </div>
                        <div class="tab-container">
                            <button class="tab-button active" data-tab="temuan">Klasifikasi Temuan</button>
                            <button class="tab-button" data-tab="penyebab">Klasifikasi Penyebab</button>
                            <button class="tab-button" data-tab="coso">Klasifikasi COSO</button>
                            <button class="tab-button" data-tab="ab">Klasifikasi Kode A dan B</button>
                        </div>
                            <div id="temuan" class="tab-content" style="display: block;">
                                <div class="x_content">
                                    <button class="btn btn-success btn-lg" id="exportExcel" onclick="exportTableToExcel('auditTable', 'LHA_Audit')">
                                        <span class="fa fa-file-excel-o"></span>
                                    </button>
                                    <div class="table-responsive">
                                        <?php
                                            // Array bulan dalam Bahasa Indonesia (Januari - Desember)
                                            $bulan_indonesia = [
                                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                            ];
                                            // Inisialisasi data
                                            $data_temuan = [];
                                            $total_per_bulan = array_fill_keys(array_keys($bulan_indonesia), 0); // Setiap bulan default 0
                                            $total_semua = 0;

                                            // Proses data dari database
                                            foreach ($record2 as $row) {
                                                $bulan = date('m', strtotime($row['tanggal'] . '-01')); // Ambil bulan dalam format MM
                                                $kode_temuan = $row['kode_temuan'];

                                                // Jika bulan tidak valid, lewati iterasi ini
                                                if (!isset($bulan_indonesia[$bulan])) {
                                                    continue;
                                                }

                                                // Simpan data temuan
                                                $data_temuan[$kode_temuan]['kode'] = $row['kode_temuan'];
                                                $data_temuan[$kode_temuan]['uraian'] = $row['klasifikasi_temuan'];
                                                $data_temuan[$kode_temuan]['data'][$bulan] = $row['jumlah_kemunculan'];

                                                // Hitung total per bulan
                                                $total_per_bulan[$bulan] += $row['jumlah_kemunculan'];
                                            }

                                            // Total semua temuan
                                            $total_semua = array_sum($total_per_bulan);
                                        ?>
                                        <h4>Tabel Klasifikasi Temuan</h4>
                                        <table class="table table-striped table-bordered datatable">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">No</th>
                                                    <th colspan="2">Klasifikasi Temuan</th>
                                                    <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                        <th colspan="2"><?php echo $bulan; ?></th>
                                                    <?php endforeach; ?>
                                                </tr>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Uraian</th>
                                                    <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                        <th>Jumlah</th>
                                                        <th>%</th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $nomer = 1; foreach ($data_temuan as $temuan): ?>
                                                    <tr>
                                                        <td><?php echo $nomer++; ?></td>
                                                        <td><?php echo $temuan['kode']; ?></td>
                                                        <td><?php echo $temuan['uraian']; ?></td>
                                                        <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                            <?php $jumlah = $temuan['data'][$key] ?? 0; ?>
                                                            <td><?php echo $jumlah; ?></td>
                                                            <td><?php echo ($total_per_bulan[$key] > 0) ? number_format(($jumlah / $total_per_bulan[$key]) * 100) . '%' : '0%'; ?></td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr class="footer">
                                                    <td colspan="3">Jumlah</td>
                                                    <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                        <td><?php echo $total_per_bulan[$key]; ?></td>
                                                        <td><?php echo ($total_semua > 0) ? number_format(($total_per_bulan[$key] / $total_semua) * 100) . '%' : '0%'; ?></td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="penyebab" class="tab-content" style="display: none;">
                                <div class="x_content">
                                    <button class="btn btn-success btn-lg" id="exportExcel" onclick="exportTableToExcel('auditTable', 'LHA_Audit')">
                                        <span class="fa fa-file-excel-o"></span>
                                    </button>
                                    <div class="table-responsive">
                                        <?php
                                            // Array bulan dalam Bahasa Indonesia (Januari - Desember)
                                            $bulan_indonesia = [
                                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                            ];
                                            // Inisialisasi data
                                            $data_penyebab = [];
                                            $total_per_bulan = array_fill_keys(array_keys($bulan_indonesia), 0); // Setiap bulan default 0
                                            $total_semua = 0;

                                            // Proses data dari database
                                            foreach ($record5 as $row) {
                                                $bulan = date('m', strtotime($row['temuan_tgl'] . '-01')); // Ambil bulan dalam format MM
                                                $kode_sebab = $row['sebab_kode'];

                                                // Jika bulan tidak valid, lewati iterasi ini
                                                if (!isset($bulan_indonesia[$bulan])) {
                                                    continue;
                                                }

                                                // Simpan data temuan
                                                $data_penyebab[$kode_sebab]['kode'] = $row['sebab_kode'];
                                                $data_penyebab[$kode_sebab]['uraian'] = $row['klasifikasi_sebab'];
                                                $data_penyebab[$kode_sebab]['data'][$bulan] = $row['jumlah_kemunculan'];

                                                // Hitung total per bulan
                                                $total_per_bulan[$bulan] += $row['jumlah_kemunculan'];
                                            }

                                            // Total semua temuan
                                            $total_semua = array_sum($total_per_bulan);
                                        ?>
                                        <h4>Tabel Klasifikasi Penyebab</h4>
                                        <table class="table table-striped table-bordered datatable">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">No</th>
                                                    <th colspan="2">Klasifikasi Penyebab</th>
                                                    <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                        <th colspan="2"><?php echo $bulan; ?></th>
                                                    <?php endforeach; ?>
                                                </tr>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Uraian</th>
                                                    <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                        <th>Jumlah</th>
                                                        <th>%</th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $nomer = 1; foreach ($data_penyebab as $sebab): ?>
                                                    <tr>
                                                        <td><?php echo $nomer++; ?></td>
                                                        <td><?php echo $sebab['kode']; ?></td>
                                                        <td><?php echo $sebab['uraian']; ?></td>
                                                        <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                            <?php $jumlah = $sebab['data'][$key] ?? 0; ?>
                                                            <td><?php echo $jumlah; ?></td>
                                                            <td><?php echo ($total_per_bulan[$key] > 0) ? number_format(($jumlah / $total_per_bulan[$key]) * 100) . '%' : '0%'; ?></td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr class="footer">
                                                    <td colspan="3">Jumlah</td>
                                                    <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                        <td><?php echo $total_per_bulan[$key]; ?></td>
                                                        <td><?php echo ($total_semua > 0) ? number_format(($total_per_bulan[$key] / $total_semua) * 100) . '%' : '0%'; ?></td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="coso" class="tab-content" style="display: none;"> 
                                <div class="x_content">
                                    <button class="btn btn-success btn-lg" onclick="exportTableToExcel('cosoTable', 'LHA_Coso')">
                                        <span class="fa fa-file-excel-o"></span>
                                    </button>
                                    <div class="table-responsive">
                                        <?php
                                            $bulan_indonesia = [
                                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                            ];
                                            $data_coso = [];
                                            $total_per_bulan_coso = array_fill_keys(array_keys($bulan_indonesia), 0);
                                            $total_coso = 0;

                                            foreach ($record6 as $row) {
                                                $bulan = date('m', strtotime($row['temuan_tgl'] . '-01'));
                                                $kode_coso = $row['kode_coso'];

                                                if (!isset($bulan_indonesia[$bulan])) continue;

                                                $data_coso[$kode_coso]['kode'] = $row['kode_coso'];
                                                $data_coso[$kode_coso]['uraian'] = $row['klasifikasi_coso'];
                                                $data_coso[$kode_coso]['data'][$bulan] = $row['jumlah_kemunculan'];

                                                $total_per_bulan_coso[$bulan] += $row['jumlah_kemunculan'];
                                            }

                                            $total_coso = array_sum($total_per_bulan_coso);
                                        ?>
                                        <h4>Tabel Klasifikasi COSO</h4>
                                        <table class="table table-striped table-bordered datatable" id="cosoTable">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">No</th>
                                                    <th colspan="2">Klasifikasi COSO</th>
                                                    <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                        <th colspan="2"><?php echo $bulan; ?></th>
                                                    <?php endforeach; ?>
                                                </tr>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Uraian</th>
                                                    <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                        <th>Jumlah</th>
                                                        <th>%</th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; foreach ($data_coso as $coso): ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td><?php echo $coso['kode']; ?></td>
                                                        <td><?php echo $coso['uraian']; ?></td>
                                                        <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                            <?php $jumlah = $coso['data'][$key] ?? 0; ?>
                                                            <td><?php echo $jumlah; ?></td>
                                                            <td><?php echo ($total_per_bulan_coso[$key] > 0) ? number_format(($jumlah / $total_per_bulan_coso[$key]) * 100) . '%' : '0%'; ?></td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr class="footer">
                                                    <td colspan="3">Jumlah</td>
                                                    <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                        <td><?php echo $total_per_bulan_coso[$key]; ?></td>
                                                        <td><?php echo ($total_coso > 0) ? number_format(($total_per_bulan_coso[$key] / $total_coso) * 100) . '%' : '0%'; ?></td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="ab" class="tab-content" style="display: none;"> 
                                <div class="x_content">
                                    <button class="btn btn-success btn-lg" onclick="exportTableToExcel('abTable', 'LHA_AB')">
                                        <span class="fa fa-file-excel-o"></span>
                                    </button>
                                    <div class="table-responsive">
                                        <?php
                                            $bulan_indonesia = [
                                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                            ];
                                            $data_ab = [];
                                            $total_per_bulan_ab = array_fill_keys(array_keys($bulan_indonesia), 0);
                                            $total_ab = 0;

                                            foreach ($record7 as $row) {
                                                $bulan = date('m', strtotime($row['temuan_tgl'] . '-01'));
                                                $kode_ab = $row['kode_ab'];

                                                if (!isset($bulan_indonesia[$bulan])) continue;

                                                $data_ab[$kode_ab]['kode'] = $row['kode_ab'];
                                                $data_ab[$kode_ab]['uraian'] = $row['judul_ab'];
                                                $data_ab[$kode_ab]['data'][$bulan] = $row['jumlah_kemunculan'];

                                                $total_per_bulan_ab[$bulan] += $row['jumlah_kemunculan'];
                                            }

                                            $total_ab = array_sum($total_per_bulan_ab);
                                        ?>
                                        <h4>Tabel Klasifikasi AB</h4>
                                        <table class="table table-striped table-bordered datatable" id="abTable">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">No</th>
                                                    <th colspan="2">Klasifikasi AB</th>
                                                    <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                        <th colspan="2"><?php echo $bulan; ?></th>
                                                    <?php endforeach; ?>
                                                </tr>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Judul</th>
                                                    <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                        <th>Jumlah</th>
                                                        <th>%</th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; foreach ($data_ab as $ab): ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td><?php echo $ab['kode']; ?></td>
                                                        <td><?php echo $ab['uraian']; ?></td>
                                                        <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                            <?php $jumlah = $ab['data'][$key] ?? 0; ?>
                                                            <td><?php echo $jumlah; ?></td>
                                                            <td><?php echo ($total_per_bulan_ab[$key] > 0) ? number_format(($jumlah / $total_per_bulan_ab[$key]) * 100) . '%' : '0%'; ?></td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr class="footer">
                                                    <td colspan="3">Jumlah</td>
                                                    <?php foreach ($bulan_indonesia as $key => $bulan): ?>
                                                        <td><?php echo $total_per_bulan_ab[$key]; ?></td>
                                                        <td><?php echo ($total_ab > 0) ? number_format(($total_per_bulan_ab[$key] / $total_ab) * 100) . '%' : '0%'; ?></td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
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
                            <h4>Tabular KK2</h4>
                            
                            <div class="clearfix">
                            </div>
                            <!-- <hr style="height:2px;border:none;color:lightgrey;background-color:lightgrey;"/> -->
                        </div>
                            <div class="x_content">
                            <div class="tab-container">
                                <button class="tab-button active" data-tab="rekomendasi">Klasifikasi Rekomendasi</button>
                                <button class="tab-button" data-tab="bidang">Bidang Pekerjaan</button>
                            </div>
                                <button class="btn btn-success btn-lg" id="exportExcel" onclick="exportTableToExcel('auditTable', 'LHA_Audit')">
                                    <span class="fa fa-file-excel-o"></span>
                                </button>
                                <div id="rekomendasi" class="tab-content" style="display: none;">
                                    <div class="table-container">
                                        <h3>Klasifikasi Rekomendasi</h3>
                                        <?php
                                        // Daftar nama bulan
                                        $bulan_list = [
                                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                        ];

                                        // Inisialisasi array rekap data
                                        $rekap = [];
                                        $total_per_bulan = array_fill_keys(array_keys($bulan_list), 0);

                                        // Proses data hasil query
                                        foreach ($record9 as $row) {
                                            $judul = $row['judul']; // Klasifikasi
                                            $bulan = date('m', strtotime($row['tanggal']));
                                            $jumlah = $row['jumlah_kemunculan'];

                                            // Inisialisasi jika belum ada
                                            if (!isset($rekap[$judul])) {
                                                $rekap[$judul] = array_fill_keys(array_keys($bulan_list), 0);
                                                $rekap[$judul]['total'] = 0;
                                            }

                                            // Tambahkan jumlah
                                            $rekap[$judul][$bulan] += $jumlah;
                                            $rekap[$judul]['total'] += $jumlah;

                                            $total_per_bulan[$bulan] += $jumlah;
                                        }
                                        ?>

                                        <h3>Rekap Klasifikasi Rekomendasi</h3>
                                        <table class="table table-striped table-bordered datatable">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">No</th>
                                                    <th rowspan="2">Klasifikasi Rekomendasi</th>
                                                    <?php foreach ($bulan_list as $bulan): ?>
                                                        <th colspan="2"><?= $bulan ?></th>
                                                    <?php endforeach; ?>
                                                </tr>
                                                <tr>
                                                    <?php foreach ($bulan_list as $bulan): ?>
                                                        <th>Jumlah</th>
                                                        <th>%</th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; foreach ($rekap as $judul => $data): ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $judul ?></td>
                                                        <?php foreach ($bulan_list as $key => $nama_bulan): ?>
                                                            <td><?= $data[$key] ?></td>
                                                            <td><?= ($total_per_bulan[$key] > 0) ? round(($data[$key] / $total_per_bulan[$key]) * 100, 2) . "%" : "0%" ?></td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2">Jumlah</th>
                                                    <?php foreach ($bulan_list as $key => $nama_bulan): ?>
                                                        <th><?= $total_per_bulan[$key] ?></th>
                                                        <th><?= ($total_per_bulan[$key] > 0) ? "100%" : "-" ?></th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div id="bidang" class="tab-content" style="display: block;">
                                <?php
                                    // Daftar nama bulan dalam bahasa Indonesia
                                    $bulan_list = [
                                        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                    ];

                                    // Inisialisasi array data per bidang pekerjaan
                                    $rekapitulasi = [];
                                    $total_per_bulan = array_fill_keys(array_keys($bulan_list), 0);
                                    $total_keseluruhan = 0;

                                    // Proses data hasil query
                                    foreach ($record3 as $row) {
                                        $bidang = $row['bidangtemuan_nama'];
                                        $bulan = date('m', strtotime($row['tanggal'])); // Ambil bulan dari tanggal
                                        $jumlah = $row['jumlah_kemunculan'];

                                        // Buat array default jika bidang pekerjaan belum ada
                                        if (!isset($rekapitulasi[$bidang])) {
                                            $rekapitulasi[$bidang] = array_fill_keys(array_keys($bulan_list), 0);
                                            $rekapitulasi[$bidang]['total'] = 0;
                                        }

                                        // Simpan jumlah temuan dalam bulan yang sesuai
                                        $rekapitulasi[$bidang][$bulan] += $jumlah;
                                        $rekapitulasi[$bidang]['total'] += $jumlah;

                                        // Tambahkan ke total bulanan
                                        $total_per_bulan[$bulan] += $jumlah;
                                    }

                                    // Hitung total keseluruhan
                                    $total_keseluruhan = array_sum($total_per_bulan);
                                ?>
                                    <h3>Tabel Bidang Pekerjaan</h3>
                                    <table class="table table-striped table-bordered datatable">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th rowspan="2">Bidang Pekerjaan</th>
                                                <?php foreach ($bulan_list as $bulan) : ?>
                                                    <th colspan="2"><?= $bulan ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                            <tr>
                                                <?php foreach ($bulan_list as $bulan) : ?>
                                                    <th>Jumlah</th>
                                                    <th>%</th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach ($rekapitulasi as $bidang => $data) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $bidang ?></td>
                                                    <?php foreach ($bulan_list as $key => $nama_bulan) : ?>
                                                        <td><?= $data[$key] ?></td>
                                                        <td><?= ($total_per_bulan[$key] > 0) ? round(($data[$key] / $total_per_bulan[$key]) * 100, 2) . "%" : "0%" ?></td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Jumlah</th>
                                                <?php foreach ($bulan_list as $key => $nama_bulan) : ?>
                                                    <th><?= $total_per_bulan[$key] ?></th>
                                                    <th><?= ($total_per_bulan[$key] > 0) ? "100%" : "-" ?></th>
                                                <?php endforeach; ?>
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
                            <h4>Tabular KK1</h4>
                            
                            <div class="clearfix">
                            </div>
                            <!-- <hr style="height:2px;border:none;color:lightgrey;background-color:lightgrey;"/> -->
                        </div>
                            <div class="x_content">
                            <div class="tab-container">
                                <button class="tab-button active" data-tab="kegiatan">Kegiatan DSPI</button>
                                <button class="tab-button" data-tab="lha">Jumlah LHA</button>
                            </div>
                                <button class="btn btn-success btn-lg" id="exportExcel" onclick="exportTableToExcel('auditTable', 'LHA_Audit')">
                                    <span class="fa fa-file-excel-o"></span>
                                </button>
                                <div id="kegiatan" class="tab-content" style="display: block;">
                                    <div class="table-container">
                                        <h3>Tabel Audit</h3>
                                        <?php
                                            $bulan_list = [
                                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', 
                                                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                                '07' => 'Juli', '08' => 'Agustus', '09' => 'September', 
                                                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                            ];

                                            $jenis_audit_list = ['Rutin' => 'Audit Rutin (Operasional)', 
                                                                'Khusus' => 'Audit Dengan Tujuan Tertentu (Audit Khusus)', 
                                                                'Tematik' => 'Evaluasi/Audit Tematik'];

                                            // Buat array kosong untuk menampung data yang diformat ulang
                                            $data_audit = [];
                                            $total_bulanan = [];

                                            // Format ulang hasil query menjadi array yang lebih mudah diakses di view
                                            foreach ($record4 as $row) {
                                                $bulan = substr($row['bulan'], 5, 2); // Ambil MM dari YYYY-MM
                                                $jenis_audit = $row['jenis_audit'];

                                                // Simpan data berdasarkan bulan dan jenis audit
                                                $data_audit[$bulan][$jenis_audit] = [
                                                    'jumlah_pemeriksaan' => $row['jumlah_pemeriksaan'],
                                                    'jumlah_pkpt' => $row['jumlah_pkpt']
                                                ];

                                                // Hitung total per bulan
                                                if (!isset($total_bulanan[$bulan])) {
                                                    $total_bulanan[$bulan] = ['jumlah_pemeriksaan' => 0, 'jumlah_pkpt' => 0];
                                                }
                                                $total_bulanan[$bulan]['jumlah_pemeriksaan'] += $row['jumlah_pemeriksaan'];
                                                $total_bulanan[$bulan]['jumlah_pkpt'] += $row['jumlah_pkpt'];
                                            }

                                            // Menampilkan tabel
                                        ?>
                                            <table class="table table-striped table-bordered datatable">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">No</th>
                                                        <th rowspan="2">Uraian</th>
                                                        <?php foreach ($bulan_list as $nama_bulan) { ?>
                                                            <th colspan="3"><?php echo $nama_bulan; ?></th>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <?php foreach ($bulan_list as $nama_bulan) { ?>
                                                            <th>Real</th>
                                                            <th>PKPT</th>
                                                            <th>%</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $nomor = 1; 
                                                    foreach ($jenis_audit_list as $jenis_audit => $label) { ?>
                                                        <tr>
                                                            <td><?php echo $nomor++; ?>.</td>
                                                            <td><?php echo $label; ?></td>
                                                            <?php foreach ($bulan_list as $periode => $nama_bulan) {
                                                                // Cek apakah data ada untuk bulan ini, jika tidak, tampilkan 0
                                                                $real = $data_audit[$periode][$jenis_audit]['jumlah_pemeriksaan'] ?? 0;
                                                                $pkpt = $data_audit[$periode][$jenis_audit]['jumlah_pkpt'] ?? 0;
                                                                $persentase = ($pkpt > 0) ? round(($real / $pkpt) * 100, 2) : 0;
                                                            ?>
                                                                <td><?php echo $real; ?></td>
                                                                <td><?php echo $pkpt; ?></td>
                                                                <td><?php echo $persentase . "%"; ?></td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>

                                                    <!-- Baris Total -->
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2"><strong>Jumlah</strong></td>
                                                            <?php 
                                                            foreach ($bulan_list as $periode => $nama_bulan) {
                                                                $total_real = $total_bulanan[$periode]['jumlah_pemeriksaan'] ?? 0;
                                                                $total_pkpt = $total_bulanan[$periode]['jumlah_pkpt'] ?? 0;

                                                                // Hitung rata-rata persentase dari masing-masing jenis audit
                                                                $jumlah_persen = 0;
                                                                $jumlah_dibagi = 0;

                                                                foreach ($jenis_audit_list as $jenis_audit => $label) {
                                                                    $real = $data_audit[$periode][$jenis_audit]['jumlah_pemeriksaan'] ?? 0;
                                                                    $pkpt = $data_audit[$periode][$jenis_audit]['jumlah_pkpt'] ?? 0;
                                                                    if ($pkpt > 0) {
                                                                        $jumlah_persen += ($real / $pkpt) * 100;
                                                                        $jumlah_dibagi++;
                                                                    }
                                                                }

                                                                $rata_rata_persen = ($jumlah_dibagi > 0) ? round($jumlah_persen / $jumlah_dibagi, 2) : 0;
                                                            ?>
                                                                <td><strong><?php echo $total_real; ?></strong></td>
                                                                <td><strong><?php echo $total_pkpt; ?></strong></td>
                                                                <td><strong><?php echo $rata_rata_persen; ?>%</strong></td>
                                                            <?php } ?>
                                                        </tr>
                                                    </tfoot>
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                                <div id="lha" class="tab-content" style="display: none;">
                                <h3>Tabel Laporan Hasil Audit (LHA) yang Terbit</h3>
                                <?php
// Inisialisasi array bulan
$bulan = [
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
    '04' => 'April', '05' => 'Mei', '06' => 'Juni',
    '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
    '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
];

// Siapkan data per pemeriksaan_judul dan per bulan
$data_grouped = [];
foreach ($record8 as $row) {
    $judul = $row['pemeriksaan_judul'];
    $bulan_str = date('m', strtotime($row['rekomendasi_status_tanggal']));

    if (!isset($data_grouped[$judul][$bulan_str])) {
        $data_grouped[$judul][$bulan_str] = ['lha' => 0, 'temuan' => 0, 'rekomendasi' => 0];
    }

    $data_grouped[$judul][$bulan_str]['lha'] += 1;
    $data_grouped[$judul][$bulan_str]['temuan'] += $row['jumlah_temuan'];
    $data_grouped[$judul][$bulan_str]['rekomendasi'] += $row['jumlah_rekomendasi'];
}
?>

<table class="table table-striped table-bordered datatable">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Uraian</th>
            <?php foreach ($bulan as $b => $nama): ?>
                <th colspan="3"><?= $nama ?></th>
                <?php if (in_array($b, ['03', '06', '09', '12'])): ?>
                    <th colspan="3">Triwulan <?= ceil($b / 3) ?></th>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach ($bulan as $b => $nama): ?>
                <th>LHA</th><th>Temuan</th><th>Rekomendasi</th>
                <?php if (in_array($b, ['03', '06', '09', '12'])): ?>
                    <th>LHA</th><th>Temuan</th><th>Rekomendasi</th>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($data_grouped as $judul => $bulanan) {
            echo "<tr><td>{$no}</td><td>{$judul}</td>";

            $triwulan = ['lha' => 0, 'temuan' => 0, 'rekomendasi' => 0];
            foreach ($bulan as $b => $nama) {
                $lha = $bulanan[$b]['lha'] ?? 0;
                $temuan = $bulanan[$b]['temuan'] ?? 0;
                $rekomendasi = $bulanan[$b]['rekomendasi'] ?? 0;

                echo "<td>{$lha}</td><td>{$temuan}</td><td>{$rekomendasi}</td>";

                $triwulan['lha'] += $lha;
                $triwulan['temuan'] += $temuan;
                $triwulan['rekomendasi'] += $rekomendasi;

                if (in_array($b, ['03', '06', '09', '12'])) {
                    echo "<td><strong>{$triwulan['lha']}</strong></td>
                          <td><strong>{$triwulan['temuan']}</strong></td>
                          <td><strong>{$triwulan['rekomendasi']}</strong></td>";
                    $triwulan = ['lha' => 0, 'temuan' => 0, 'rekomendasi' => 0];
                }
            }

            echo "</tr>";
            $no++;
        }
        ?>
    </tbody>
</table>

                                </div>
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