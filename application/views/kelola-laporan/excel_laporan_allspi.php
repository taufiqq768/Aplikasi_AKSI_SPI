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
     
      ?><center><h4><strong>
      <?php if ($record!=null) { ?>
              Daftar Monitoring Tindak Lanjut <br>Semua Pemeriksaan
      <?php  }else{ ?>
              Tidak Ada Data untuk Pemeriksaan<br><?php echo $bidang; ?> 
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
      <div class="table-responsive">
        <table id="datatable" class="table table-striped table-bordered" border="1">
        <thead>
          <tr>
            <th bgcolor="#cef542">No.</th>
            <th bgcolor="#cef542">Jenis</th>
            <th bgcolor="#cef542">Pemeriksaan</th>
            <th bgcolor="#cef542" style="width: 100px">Unit</th>
            <th bgcolor="#cef542" style="width: 100px">Tanggal</th>
            <th bgcolor="#cef542" style="width: 75px">Bidang</th>
            <th bgcolor="#cef542" style="width: 100px">Obyek<br>Pemeriksaan</th>
            <th style="width: 250px" bgcolor="#cef542">Hasil Temuan</th>
            <th style="width: 200px" bgcolor="#cef542">Rekomendasi</th>
            <th style="width: 150px" bgcolor="#cef542">Tanggapan Manajer</th>
           <?php 
            $loop = 0;
            $hitung = [];
            foreach ($record as $row) {
              $tul = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$row[rekomendasi_id]' AND tl_publish_kabag='Y'")->result_array(); 
              $hitung[] = count($tul);
            } 
            // print_r($hitung);
            if (!empty($hitung)) {
              $loop =  max($hitung);
            }
            $n = "I";
            for ($i=0; $i < $loop ; $i++) { 
              echo "<th style='width: 250px' bgcolor='#cef542'>Tindak Lanjut ".$n;
              $n.="I";      
            }
            ?>
            <th style="width: 100px" bgcolor="#cef542">Status</th>
          </tr>
        </thead>
        <tbody>

          <?php
           $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
            if (strpos($role[0]['role_akses'],'29')) {
                $record = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id WHERE pemeriksaan_jenis = 'Rutin' AND pemeriksaan_aktif = 'Y' ORDER BY pemeriksaan_tgl ASC")->result_array();
            }
            if ($this->session->level=="operator") {
                $unit = $this->session->unit;
                // echo $unit;
                $record = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id WHERE pemeriksaan_jenis = 'Rutin' AND pemeriksaan_aktif = 'Y' AND kebun_id = '$unit' ORDER BY pemeriksaan_tgl ASC")->result_array(); 
            }
          $no = 0;
          foreach ($record as $value) {
          $user = explode("/", $value['pemeriksaan_petugas']);
          if (in_array($this->session->username, $user) && $this->session->level=="spi") { 
            $no++;
          ?>
          <tr>
            <td style="vertical-align: top;"><center><?php echo $no; ?></center></td>
            <td style="vertical-align: top;"><?php echo $value['pemeriksaan_jenis']; ?></td>
            <td style="vertical-align: top;"><?php echo $value['pemeriksaan_judul']; ?></td>
            <td style="vertical-align: top;">
              <?php 
                $unit = $this->model_app->view_profile('tb_unit', array('unit_id'=> $value['unit_id']))->row_array();
                echo $unit['unit_nama']; ?>
            </td>
            <td style="vertical-align: top;"><?php
              $mulai = explode("-", $value['pemeriksaan_tgl_mulai']);
              $akhir = explode("-", $value['pemeriksaan_tgl_akhir']);
              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
            ?></td>
            <td style="vertical-align: top;">
              <?php 
                $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $value['bidangtemuan_id']))->row_array();
                echo $bidang['bidangtemuan_nama']; ?>
            </td>
            <td style="vertical-align: top;"><?php echo $value['temuan_obyek']; ?></td>
            <td style="vertical-align: top;"><?php echo $value['temuan_judul']; ?></td>
            <td style="vertical-align: top;"><?php echo $value['rekomendasi_judul']; ?></td>
            <td style="vertical-align: top;">
              <?php $tanggapan = $this->model_app->view_where('tb_tanggapan','rekomendasi_id',$value['rekomendasi_id']);
                    if ($tanggapan!=null) {
                      echo $tanggapan[0]['tanggapan_deskripsi'];
                      $tgl = explode("-", $tanggapan[0]['tanggapan_tgl']);
                      echo " (<i>pada ".$tgl[2]."-".$tgl[1]."-".$tgl[0]."</i>)";
                    }else{
                      echo "<center>-</center>";
                    }
              ?>              
            </td>
              <?php $useropr = $this->session->username;
              
                    if ($this->session->level=="spi" || $this->session->level=="admin" || $this->session->level=="kabagspi") {
                      if ($value['pemeriksaan_jenis']!="Rutin") {
                        $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$value[rekomendasi_id]' AND tl_publish_kabag='Y'")->result_array();
                      }else{
                        $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$value[rekomendasi_id]' AND tl_publish_spi='Y'")->result_array();
                      }
                    }elseif($this->session->level=="operator"){
                      $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$value[rekomendasi_id]' AND user_opr='$useropr'")->result_array();
                    }else{
                      $tl = "<center>-</center>";
                    }
                  
              for ($i=0; $i < count($tl) ; $i++) { ?>
              <td style="vertical-align: top;">
               <?php if ($tl[$i]['tl_deskripsi']!=null) {
                 echo $tl[$i]['tl_deskripsi'];
               }else{
                echo "<center>-</center>";
               } ?>
               
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

          <?php  }elseif ($this->session->level!="spi") {
            $no++; ?>
            <tr>
            <td style="vertical-align: top;"><center><?php echo $no; ?></center></td>
            <td style="vertical-align: top;"><?php echo $value['pemeriksaan_jenis']; ?></td>
            <td style="vertical-align: top;"><?php echo $value['pemeriksaan_judul']; ?></td>
            <td style="vertical-align: top;">
              <?php 
                $unit = $this->model_app->view_profile('tb_unit', array('unit_id'=> $value['unit_id']))->row_array();
                echo $unit['unit_nama']; ?>
            </td>
            <td style="vertical-align: top;"><?php
              $mulai = explode("-", $value['pemeriksaan_tgl_mulai']);
              $akhir = explode("-", $value['pemeriksaan_tgl_akhir']);
              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
            ?></td>
            <td style="vertical-align: top;">
              <?php 
                $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $value['bidangtemuan_id']))->row_array();
                echo $bidang['bidangtemuan_nama']; ?>
            </td>
            <td style="vertical-align: top;"><?php echo $value['temuan_obyek']; ?></td>
            <td style="vertical-align: top;"><?php echo $value['temuan_judul']; ?></td>
            <td style="vertical-align: top;"><?php echo $value['rekomendasi_judul']; ?></td>
            <td style="vertical-align: top;">
              <?php $tanggapan = $this->model_app->view_where('tb_tanggapan','rekomendasi_id',$value['rekomendasi_id']);
                    if ($tanggapan!=null) {
                      echo $tanggapan[0]['tanggapan_deskripsi'];
                      $tgl = explode("-", $tanggapan[0]['tanggapan_tgl']);
                      echo " (<i>pada ".$tgl[2]."-".$tgl[1]."-".$tgl[0]."</i>)";
                    }else{
                      echo "<center>-</center>";
                    }
              ?>              
            </td>
              <?php $useropr = $this->session->username;
              
                    if ($this->session->level=="spi" || $this->session->level=="admin" || $this->session->level=="kabagspi") {
                      if ($value['pemeriksaan_jenis']!="Rutin") {
                        $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$value[rekomendasi_id]' AND tl_publish_kabag='Y'")->result_array();
                      }else{
                        $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$value[rekomendasi_id]' AND tl_publish_spi='Y'")->result_array();
                      }
                    }elseif($this->session->level=="operator"){
                      $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$value[rekomendasi_id]' AND user_opr='$useropr'")->result_array();
                    }else{
                      $tl = "<center>-</center>";
                    }
                  
              for ($i=0; $i < count($tl) ; $i++) { ?>
              <td style="vertical-align: top;">
               <?php if ($tl[$i]['tl_deskripsi']!=null) {
                 echo $tl[$i]['tl_deskripsi'];
               }else{
                echo "<center>-</center>";
               } ?>
               
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
          <?php
          }

          } ?>
          
        </tbody>
      </table>
      </div>
  
        <!-- /page content -->