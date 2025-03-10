<?php 
 header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=Laporan_LHA.xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");

?>
      <?php //print_r($record);
     // if ($record!=null) {
       // $judul = $this->model_app->view_profile('tb_pemeriksaan', array('pemeriksaan_id'=> $record[0]['pemeriksaan_id']))->row_array();
      //}
     
      ?>
      
      </br>
      <center><h4><strong>
      <?php if ($record!=null) { ?>
              Daftar Monitoring Tindak Lanjut <br>Semua Pemeriksaan
      <?php  }else{ ?>
              Tidak Ada Data untuk Pemeriksaan<br><?php //echo $bidang; ?> 
      <?php } ?>
      <br>
      <?php 
        // if ($rentang == "semua"){  
        //   echo "Pada Semua Waktu Pemeriksaan";
        // }else{
        //   echo "Pada Rentang Waktu : ".//$rentang;
        // }
      ?>
      </strong></h4></center>
<!-- Retrieve data untuk role tamu -->
<?php 
// $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
// $where=[];
//  if (strpos($role[0]['role_akses'],'29') OR $this->session->level=="administrasi") {
//   if ($bidang_tmn!='semuabidang') {
//     $where[] = " tb_temuan.bidangtemuan_id = '".$bidang_tmn."'";
//   }
//   if ($tgl_mulai!="") {
//     $where[] = " (pemeriksaan_tgl_mulai BETWEEN '$tgl_mulai' AND '$tgl_akhir' OR pemeriksaan_tgl_akhir BETWEEN '$tgl_mulai' AND '$tgl_akhir')";
//   }
//   $build = "";
//   for ($i=0; $i < sizeof($where) ; $i++) { 
//     if($i == sizeof($where)-1 ) $build .=$where[$i];
//     else  $build .=$where[$i]." AND";
//   }
//   if ($build!="") {
//     $record = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id WHERE pemeriksaan_jenis = 'Rutin' AND pemeriksaan_aktif = 'Y' AND ".$build." ORDER BY tb_pemeriksaan.pemeriksaan_id ASC")->result_array();
//   }else{
//     $record = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id WHERE pemeriksaan_jenis = 'Rutin' AND pemeriksaan_aktif = 'Y' ORDER BY tb_pemeriksaan.pemeriksaan_id ASC")->result_array();
//   }
//  }
?>
    <style>
         table {
            table-layout: fixed; /* Mengatur tata letak tabel fixed */
            width: 100%; /* Tabel akan menyesuaikan lebar kontainer */
            border-collapse: collapse; /* Menyatukan border */
        }
        th, td {
            border: 1px solid #ccc; /* Tambahkan border */
            text-align: center; /* Rata tengah */
            overflow: hidden; /* Menyembunyikan konten yang melebihi lebar */
            text-overflow: ellipsis; /* Tambahkan ellipsis jika konten terlalu panjang */
            white-space: nowrap; /* Jangan memotong baris teks */
        }
        th {
            background-color: #f4f4f4; /* Warna latar untuk header */
        }
        /* Atur lebar spesifik per kolom */
        th:nth-child(1),
        td:nth-child(1) {
            width: 50px; /* Lebar kolom pertama */
        }
        th:nth-child(2),
        td:nth-child(2) {
            width: 150px; /* Lebar kolom kedua */
        }
        th:nth-child(3),
        td:nth-child(3) {
            width: 100px; /* Lebar kolom ketiga */
        }
        th:nth-child(4),
        td:nth-child(4),
        th:nth-child(5),
        td:nth-child(5),
        th:nth-child(6),
        td:nth-child(6) {
            width: 80px; /* Lebar kolom untuk jumlah */
        }
    </style>
      <div class="table-responsive">
        <table id="datatable" class="table table-striped table-bordered" border="1">
        <thead>
        
            <tr>
                <td colspan="21"><p style="text-align: left;">Nomor LHA : <?= $record[0]['no_lha'] ?></p></td>
            </tr>
            <tr>
                <td colspan="21"><p style="text-align: left;">Tanggal LHA</p></td>
            </tr>
            <tr>
                <td colspan="21"><p style="text-align: left;">Tanggal dan Jam Download : <?php echo date("Y-m-d H:i:s"); ?></p></td>
            </tr>
            <tr>
                <th rowspan="3">No.</th>
                <th colspan="3">Temuan Pemeriksa</th>
                <th colspan="4">Rekomendasi</th>
                <th rowspan="3">Tindak Lanjut</th>
                <th rowspan="3">Target Waktu</th>
                <th rowspan="3">Unit / PIC</th>
                <th colspan="8">Hasil Monitoring Tindak Lanjut</th>
                <th rowspan="3">Keterangan</th>
                <th rowspan="3">Komoditi</th>
            </tr>
            <tr>
                <th rowspan="2">Judul</th>
                <th rowspan="2">Jml</th>
                <th rowspan="2">Nilai (Rp)</th>
                <th rowspan="2" colspan="2">Uraian</th>
                <th rowspan="2">Jml</th>
                <th rowspan="2">Nilai (Rp)</th>
                <th colspan="2">Sesuai</th>
                <th colspan="2">Belum Sesuai</th>
                <th colspan="2">Belum Ditindaklanjuti</th>
                <th colspan="2">Tidak Dapat Ditindaklanjuti</th>
            </tr>
            <tr>            
                <th>Jml</th>
                <th>Nilai (Rp)</th>
                <th>Jml</th>
                <th>Nilai (Rp)</th>
                <th>Jml</th>
                <th>Nilai (Rp)</th>
                <th>Jml</th>
                <th>Nilai (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <!-- Tambahkan data baris di sini -->
            <?php
            $groupedData = [];
            $no = 0;
            foreach ($record as $row) {
                $judul = $row['temuan_judul'];
                if (!isset($groupedData[$judul])) {
                    $groupedData[$judul] = [
                        'nominal' => $row['nominal'],
                        'jumlah' => 'jumlah',
                        'details' => []
                    ];
                }
                $groupedData[$judul]['details'][] = [
                    'nominal' => $row['nominal'],
                    'rekomendasi_judul' => $row['rekomendasi_judul'],
                    'target' => "target",
                    'sesuai_count' => $row['sesuai_count'],
                    'belum_sesuai_count' => $row['belum_sesuai_count'],
                    'belum_tindaklanjut_count' => $row['belum_tindaklanjut_count'],
                    'tidak_dapat_tindaklanjuti_count' => $row['tidak_dapat_tindaklanjuti_count'],
                    'tl_deskripsi' => $row['tl_deskripsi'],
                    'temuan_judul' => $row['temuan_judul'],
                    'unit_nama' => $row['unit_nama'],
                    'keterangan' => "keterangan",
                    'komoditi' => "komoditi",
                    'jumlah_temuan' => "jumlah_temuan",
                    'jumlah' => "jumlah"
                ];
            }

            // Menampilkan data dalam tabel
            foreach ($groupedData as $judul => $data) {
                $rowspan = count($data['details']);
                $no++;
                 // Urutkan `details` berdasarkan `rekomendasi_judul` (A-Z)
                usort($data['details'], function ($a, $b) {
                    return strcmp($a['rekomendasi_judul'], $b['rekomendasi_judul']);
                });

                // Inisialisasi urutan huruf (A, B, C, ...)
                $charIndex = 65; // ASCII untuk 'A'
                echo "<tr>";
                echo "<td rowspan='$rowspan'>{$no}</td>";
                echo "<td rowspan='$rowspan'>{$judul}</td>";
                echo "<td rowspan='$rowspan'>{$data['jumlah']}</td>";
                echo "<td rowspan='$rowspan'>{$data['nominal']}</td>";

                $first = true;
                foreach ($data['details'] as $detail) {
                    if (!$first) echo "<tr>";
                    $urutanAbjad = chr($charIndex); // Konversi angka ASCII ke huruf (A, B, C, ...)
                    $charIndex++; // Increment ASCII untuk huruf selanjutnya
                    echo "<td>{$urutanAbjad}</td>"; // Menampilkan urutan abjad
                    echo "<td>{$detail['rekomendasi_judul']}</td>";
                    echo "<td>{$detail['jumlah']}</td>";
                    echo "<td>{$detail['nominal']}</td>";
                    echo "<td>{$detail['tl_deskripsi']}</td>";
                    echo "<td>{$detail['target']}</td>";
                    echo "<td>{$detail['unit_nama']}</td>";
                    echo "<td>{$detail['sesuai_count']}</td>";
                    echo "<td>{$detail['nominal']}</td>";
                    echo "<td>{$detail['belum_sesuai_count']}</td>";
                    echo "<td>{$detail['nominal']}</td>";
                    echo "<td>{$detail['belum_tindaklanjut_count']}</td>";
                    echo "<td>{$detail['nominal']}</td>";
                    echo "<td>{$detail['tidak_dapat_tindaklanjuti_count']}</td>";
                    echo "<td>{$detail['nominal']}</td>";
                    echo "<td>{$detail['keterangan']}</td>";
                    echo "<td>{$detail['komoditi']}</td>";
                    echo "</tr>";
                    $first = false;
                }
            }
            ?>
        </tbody>
      </table>
      </div>
  
        <!-- /page content -->