<?php 
 header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=Laporan_Pemeriksaan_".$jenis.".xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");

?>
      <?php //print_r($record);
      if ($record!=null) {
        $judul = $this->model_app->view_profile('tb_pemeriksaan', array('pemeriksaan_id'=> $record[0]['pemeriksaan_id']))->row_array();
      }
     
      ?>
      <?php if ($record!=null) { ?>
      <center><h4><strong>Daftar Monitoring Tindak Lanjut<br>Jenis Pemeriksaan : 
       <?php echo $jenis; ?>
      </strong></h4></center><?php }else{ ?>
        <center><h4><strong>Tidak Ada Data untuk Pemeriksaan <br><?php echo "- ".$jenis." -"; ?><br><?php echo $bidang; ?></strong></h4></center> 
      <?php } ?>
      <div class="table-responsive">
        <table id="datatable" class="table table-striped table-bordered" border="1">
        <thead>
          <tr>
            <th bgcolor="#cef542">No.</th>
            <th bgcolor="#cef542">Pemeriksaan</th>
            <th bgcolor="#cef542">Tanggal</th>
            <th bgcolor="#cef542">Unit</th>
            <th bgcolor="#cef542" style="width: 75px">Bidang</th>
            <th style="width: 100px" bgcolor="#cef542">Obyek Pemeriksaan</th>
            <th style="width: 250px" bgcolor="#cef542">Hasil Temuan</th>
            <th style="width: 150px" bgcolor="#cef542">Rekomendasi</th>
            
           <?php 
            $loop = 0;
            $hitung = [];
            foreach ($record as $row) {
              $tul = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$row[rekomendasi_id]' AND tl_publish_spi='Y'")->result_array(); 
              $hitung[] = count($tul);
            } 
            // print_r($hitung);
            if (!empty($hitung)) {
              $loop =  max($hitung);
            }
            $n = "I";
            for ($i=0; $i < $loop ; $i++) { 
              echo "<th style='width: 200px' bgcolor='#cef542'>Tindak Lanjut ".$n."</th>
                    <th style='width: 100px' bgcolor='#cef542'>Tanggapan<br> TL ".$n."</th>";
              $n.="I";      
            }
            ?>
            <th style="width: 100px" bgcolor="#cef542">Status</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $no = 1;
          foreach ($record as $value) { 
             $unit = $this->model_app->view_profile('tb_unit', array('unit_id'=> $row['unit_id']))->row_array();
             $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $row['bidangtemuan_id']))->row_array();
          ?>
          <tr>
            <td style="vertical-align: top;"><?php echo $no; ?></td>
            <td style="vertical-align: top;"><?php echo $value['pemeriksaan_judul']; ?></td>
            <td style="vertical-align: top;"><?php 
            $mulai = explode("-", $value['pemeriksaan_tgl_mulai']);
            $akhir = explode("-", $value['pemeriksaan_tgl_akhir']);
            echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d <br>".$akhir[2]."-".$akhir[1]."-".$akhir[0];
            ?></td>
            <td style="vertical-align: top;"><?php echo $unit['unit_nama'] ?></td>
            <td style="vertical-align: top;"><?php echo $bidang['bidangtemuan_nama'] ?></td>
            <td style="vertical-align: top;"><?php echo $value['temuan_obyek'] ?></td>
            <td style="vertical-align: top;"><?php echo $value['temuan_judul']; ?></td>
            <td style="vertical-align: top;"><?php echo $value['rekomendasi_judul']; ?></td>
            <?php $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$value[rekomendasi_id]' AND tl_publish_spi='Y'")->result_array(); 
              for ($i=0; $i < count($tl) ; $i++) { ?>
              <td style="vertical-align: top;">
               <?php if ($tl[$i]['tl_deskripsi']!=null) {
                 echo $tl[$i]['tl_deskripsi'];
               }else{
                echo "<center>-</center>";
               } ?>
               <td style="vertical-align: top;"><?php if ($tl[$i]['tl_tanggapan']!=null) {
                 echo $tl[$i]['tl_tanggapan'];
               }else{
                echo "<center>-</center>";
               }  ?></td>
               </td>
              <?php }
              ?>
            <?php 
            $for =0;
            if ($loop==3) {
              if (count($tl)==0) {
                $for = 6; 
              }elseif (count($tl)==1) {
                $for = 4;
              }elseif (count($tl)==2) {
                $for = 2;
              }elseif (count($tl)==3) {
                $for = 0;
              }
            }elseif ($loop==1) {
              if (count($tl)==0) {
                $for = 2;
              }elseif (count($tl)==1) {
                $for = 0;
              }
            }elseif ($loop==2) {
              if (count($tl)==0) {
                $for = 4;
              }elseif(count($tl)==1){
                $for = 2;
              }elseif (count($tl)==2) {
                $for = 0;
              }
            }
               ?>
            <?php for ($k=0; $k < $for ; $k++) { 
              echo "<td style='vertical-align: top;'><center>-</center></td>";
            } ?>
            <td style="vertical-align: top;"><center><?php echo $value['rekomendasi_status']; ?></center></td>
          </tr>

          <?php $no++; } ?>
          
        </tbody>
      </table>
      </div>
  
        <!-- /page content -->