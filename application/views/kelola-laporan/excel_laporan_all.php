<?php 
 header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=Laporan_Pemeriksaan.xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");

?>
      <?php //print_r($record);
     // if ($record!=null) {
       // $judul = $this->model_app->view_profile('tb_pemeriksaan', array('pemeriksaan_id'=> $record[0]['pemeriksaan_id']))->row_array();
      //}
     
      ?><center><h4><strong>
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
            <th rowspan="2">No.</th>
            <th rowspan="2">Nomor LHA</th>
            <th rowspan="2">Unit Kerja</th>
            <th colspan="2">Jumlah</th>
            <th colspan="4">Status Rekomendasi</th>
          </tr>
          <tr>
                <th>Temuan</th>
                <th colspan="1">Rekomendasi</th>
                <th>S</th>
                <th>BS</th>
                <th>BD</th>
                <th>TDD</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!empty($record)) : ?>
          <?php foreach ($record as $index => $row) : ?>
              <tr>
                  <td><?= $index + 1; ?></td>
                  <td><?= $row['no_lha']; ?></td>
                  <td><?= $row['unit_nama']; ?></td>
                  <td><?= $row['jumlah_temuan']; ?></td>
                  <td><?= $row['jumlah_rekomendasi']; ?></td>
                  <td><?= $row['jumlah_s']; ?></td>
                  <td><?= $row['jumlah_bs']; ?></td>
                  <td><?= $row['jumlah_bd']; ?></td>
                  <td><?= $row['jumlah_tdd']; ?></td>
              </tr>
          <?php endforeach; ?>
          <?php else : ?>
            <tr>
                <td colspan="9">Tidak ada data tersedia.</td>
            </tr>
        <?php endif; ?>
      </tbody>
      </table>
      </div>
  
        <!-- /page content -->