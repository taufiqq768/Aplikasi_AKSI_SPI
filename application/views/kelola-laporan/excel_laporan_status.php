<?php 
 header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=Laporan_Status_".$status.".xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");

?>
    <?php 
    if ($record!=null) {
      $judul = $this->model_app->view_profile('tb_pemeriksaan', array('pemeriksaan_id'=> $record[0]['pemeriksaan_id']))->row_array();
    }
    ?>
    <center><h4><strong>
    <?php 
    if ($record!=null) { ?>
      Daftar Monitoring Tindak Lanjut Berdasarkan Status<br>-
     <?php echo $status." -<br>".$bidang;
    }else{ ?>
      Tidak Ada Data untuk Status <br><?php echo "- ".$status." -"; ?><br><?php echo $bidang; ?>
    <?php } ?>
    <br>
    <?php 
      if ($rentang == "semua"){  
        echo "Pada Semua Waktu Pemeriksaan";
      }else{
        echo "Pada Rentang Waktu : ".$rentang;
      }
    ?>
    </strong></h4></center>
<!-- Retrieve data untuk role tamu -->
<?php 
$role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
if (strpos($role[0]['role_akses'],'29') OR $this->session->level=="administrasi") {
  if ($status_tamu!='') {
    $where[] = " rekomendasi_status = '".$status_tamu."'";
  }
  if ($bidang_tmn!='semuabidang') {
    $where[] = " tb_temuan.bidangtemuan_id = '".$bidang_tmn."'";
  }
  if ($tgl_mulai!="") {
    $where[] = " (pemeriksaan_tgl_mulai BETWEEN '$tgl_mulai' AND '$tgl_akhir' OR pemeriksaan_tgl_akhir BETWEEN '$tgl_mulai' AND '$tgl_akhir')";
  }
  $build = "";
  for ($i=0; $i < sizeof($where) ; $i++) { 
    if($i == sizeof($where)-1 ) $build .=$where[$i];
    else  $build .=$where[$i]." AND";
  }
  $record = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id WHERE pemeriksaan_jenis = 'Rutin' AND pemeriksaan_aktif = 'Y' AND ".$build." ORDER BY tb_pemeriksaan.pemeriksaan_id ASC")->result_array();
 }
?>
    <div class="table-responsive">
      <table id="datatable" class="table table-striped table-bordered" border="1">
      <thead>
        <tr>
          <th bgcolor="#cef542"><center>No.</center></th>
          <th bgcolor="#cef542">Pemeriksaan</th>
          <th bgcolor="#cef542">Jenis</th>
          <th bgcolor="#cef542" style="width: 75px">Tanggal</th>
          <th bgcolor="#cef542">Unit</th>
          <th style="width: 65px" bgcolor="#cef542">Bidang</th>
          <th style="width: 100px" bgcolor="#cef542">Obyek Pemeriksaan</th>
          <th style="width: 250px" bgcolor="#cef542">Hasil Temuan</th>
          <th style="width: 150px" bgcolor="#cef542">Rekomendasi</th>
          <?php 
            $loop = 0;
            $hitung = [];
            foreach ($record as $row) {
               $jenis = $row['pemeriksaan_jenis'];
               if ($jenis!="Rutin") {
                 $tul = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$row[rekomendasi_id]' AND tl_publish_kabag='Y'")->result_array(); 
               }else{
                 $tul = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$row[rekomendasi_id]' AND tl_publish_spi='Y'")->result_array(); 
               }
              $hitung[] = count($tul);
            } 
            // print_r($hitung);
            if (!empty($hitung)) {
              $loop =  max($hitung);
            }
            $n = "I";
            for ($i=0; $i < $loop ; $i++) { 
              echo "<th style='width: 250px' bgcolor='#cef542'>Tindak Lanjut ".$n."</th>
                    <th style='width: 150px' bgcolor='#cef542'>Tanggapan<br> TL ".$n."</th>
                    <th style='width: 100px' bgcolor='#cef542'>Status<br> TL ".$n."</th>";
              $n.="I";      
            }
            ?>
            <th style="width: 100px" bgcolor="#cef542">Status</th>
        </tr>
      </thead>
      <tbody>

        <?php
        $no = 0;
        foreach ($record as $value) { 
           $unit = $this->model_app->view_profile('tb_unit', array('unit_id'=> $value['unit_id']))->row_array();
           $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $value['bidangtemuan_id']))->row_array();
          if ($value['rekomendasi_status']=="Sudah di Tindak Lanjut") {
            $btn_class = 'btn btn-xs btn-round btn-success';
          }elseif($value['rekomendasi_status']=="Sudah TL (Belum Optimal)"){
            $btn_class = 'btn btn-xs btn-round btn-warning';
          }elseif ($value['rekomendasi_status']=="Belum di Tindak Lanjut") {
            $btn_class = 'btn btn-xs btn-round btn-danger';
          }else{
            $btn_class = 'btn btn-xs btn-round btn-info';
          }
          $aku = $this->session->username;
          $user = explode("/", $value['pemeriksaan_petugas']);
          if (in_array($aku, $user) && $this->session->level=="spi") {
            $no++;
        ?>
        <tr>
          <td style="vertical-align: top;"><?php echo $no; ?></td>
          <td style="vertical-align: top;"><?php echo $value['pemeriksaan_judul']; ?></td>
          <td style="vertical-align: top;"><?php echo $value['pemeriksaan_jenis']; ?></td>
          <td style="vertical-align: top;"><?php 
              $mulai = explode("-", $value['pemeriksaan_tgl_mulai']);
              $akhir = explode("-", $value['pemeriksaan_tgl_akhir']);
              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
          ?></td>
           <td style="vertical-align: top;"><?php echo $unit['unit_nama'] ?></td>
           <td style="vertical-align: top;"><?php echo $bidang['bidangtemuan_nama'] ?></td>
           <td style="vertical-align: top;"><?php echo $value['temuan_obyek'] ?></td>
          <td style="vertical-align: top;"><?php echo $value['temuan_judul']; ?></td>
          <td style="vertical-align: top;"><?php echo $value['rekomendasi_judul']; ?></td>
            <?php 
              $tanggapan = $this->model_app->view_where('tb_tanggapan', 'rekomendasi_id', $value['rekomendasi_id']);
              if ($tanggapan!=null) {
                echo "<br><br><b>Tanggapan Manajer : </b><br>".$tanggapan[0]['tanggapan_deskripsi'];
              }else{
                echo "<center>-</center>";
              }
            ?>
            <?php 
            if ($value['pemeriksaan_jenis']!="Rutin") {
              $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$value[rekomendasi_id]' AND tl_publish_kabag='Y'")->result_array();
            }else{
              $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$value[rekomendasi_id]' AND tl_publish_spi='Y'")->result_array(); 
            }
            for ($i=0; $i < count($tl) ; $i++) { ?>
            <td style="vertical-align: top;">
             <?php if ($tl[$i]['tl_deskripsi']!=null) {
               echo $tl[$i]['tl_deskripsi'];
             }else{
              echo "<center>-</center>";
             } ?>
             </td>
             <td style="vertical-align: top;"><?php if ($tl[$i]['tl_tanggapan']!=null) {
               echo $tl[$i]['tl_tanggapan'];
             }else{
              echo "<center>-</center>";
             }  ?>
             </td>
             <td style="vertical-align: top;"><?php echo $tl[$i]['tl_status']; ?></td>
            <?php }
            ?>
          <?php
          $for =0; 
            if ($loop==3) {
              if (count($tl)==0) {
                $for = 9; 
              }elseif (count($tl)==1) {
                $for = 6;
              }elseif (count($tl)==2) {
                $for = 3;
              }elseif (count($tl)==3) {
                $for = 0;
              }
            }elseif ($loop==1) {
              if (count($tl)==0) {
                $for = 3;
              }elseif (count($tl)==1) {
                $for = 0;
              }
            }elseif ($loop==2) {
              if (count($tl)==0) {
                $for = 6;
              }elseif(count($tl)==1){
                $for = 3;
              }elseif (count($tl)==2) {
                $for = 0;
              }
            }
               ?>
            <?php for ($k=0; $k < $for ; $k++) { 
              echo "<td style='vertical-align: top;'><center>-</center></td>";
            } ?>
            <td style="vertical-align: top;"><center><span class="<?php echo $btn_class ?>"><?php echo $value['rekomendasi_status']; ?></span></center></td>
        </tr>
      <?php }elseif ($this->session->level!="spi") {
        $no++; ?>
        <tr>
          <td style="vertical-align: top;"><?php echo $no; ?></td>
          <td style="vertical-align: top;"><?php echo $value['pemeriksaan_judul']; ?></td>
          <td style="vertical-align: top;"><?php echo $value['pemeriksaan_jenis']; ?></td>
          <td style="vertical-align: top;"><?php 
              $mulai = explode("-", $value['pemeriksaan_tgl_mulai']);
              $akhir = explode("-", $value['pemeriksaan_tgl_akhir']);
              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
          ?></td>
           <td style="vertical-align: top;"><?php echo $unit['unit_nama'] ?></td>
           <td style="vertical-align: top;"><?php echo $bidang['bidangtemuan_nama'] ?></td>
           <td style="vertical-align: top;"><?php echo $value['temuan_obyek'] ?></td>
          <td style="vertical-align: top;"><?php echo $value['temuan_judul']; ?></td>
          <td style="vertical-align: top;"><?php echo $value['rekomendasi_judul']; ?>
            <?php 
              $tanggapan = $this->model_app->view_where('tb_tanggapan', 'rekomendasi_id', $value['rekomendasi_id']);
              if ($tanggapan!=null) {
                echo "<br><br><b>Tanggapan Manajer : </b><br>".$tanggapan[0]['tanggapan_deskripsi'];
              }else{
                echo "<center>-</center>";
              }
            ?>
          </td>
            <?php 
            if ($value['pemeriksaan_jenis']!="Rutin") {
              $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$value[rekomendasi_id]' AND tl_publish_kabag='Y'")->result_array();
            }else{
              $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$value[rekomendasi_id]' AND tl_publish_spi='Y'")->result_array(); 
            }
            for ($i=0; $i < count($tl) ; $i++) { ?>
            <td style="vertical-align: top;">
             <?php if ($tl[$i]['tl_deskripsi']!=null) {
               echo $tl[$i]['tl_deskripsi'];
             }else{
              echo "<center>-</center>";
             } ?>
             </td>
             <td style="vertical-align: top;"><?php if ($tl[$i]['tl_tanggapan']!=null) {
               echo $tl[$i]['tl_tanggapan'];
             }else{
              echo "<center>-</center>";
             }  ?>
             </td>
             <td style="vertical-align: top;"><?php echo $tl[$i]['tl_status']; ?></td>
            <?php }
            ?>
          <?php
          $for =0; 
            if ($loop==3) {
              if (count($tl)==0) {
                $for = 9; 
              }elseif (count($tl)==1) {
                $for = 6;
              }elseif (count($tl)==2) {
                $for = 3;
              }elseif (count($tl)==3) {
                $for = 0;
              }
            }elseif ($loop==1) {
              if (count($tl)==0) {
                $for = 3;
              }elseif (count($tl)==1) {
                $for = 0;
              }
            }elseif ($loop==2) {
              if (count($tl)==0) {
                $for = 6;
              }elseif(count($tl)==1){
                $for = 3;
              }elseif (count($tl)==2) {
                $for = 0;
              }
            }
               ?>
            <?php for ($k=0; $k < $for ; $k++) { 
              echo "<td style='vertical-align: top;'><center>-</center></td>";
            } ?>
            <td style="vertical-align: top;"><center><span class="<?php echo $btn_class ?>"><?php echo $value['rekomendasi_status']; ?></span></center></td>
        </tr>
      <?php } ?>
        <?php } ?>
        
      </tbody>
    </table>
    </div>
  
        <!-- /page content -->