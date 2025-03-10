<title>PTPN XII | List Pemeriksaan</title>
 
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
  
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List Pemeriksaan dan Rekomendasi<small>(Verifikator)</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <!-- <li><a href="daftar_pmr.php"><button type="button" class="btn btn-default btn-xs">Tambah Pemeriksaan</button></a></li> -->
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <?php
                  $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
                    if (strpos($role[0]['role_akses'],'29')) {
                      $record = $this->db->query("SELECT * FROM tb_pemeriksaan WHERE pemeriksaan_jenis = 'Rutin' AND pemeriksaan_aktif = 'Y'")->result_array();
                    }

                  $no=1;$r=1;$bintang=""; $cc = "";$back =10000; $num = ''; $tback = 30000; $rowbaris = 0;
                  $span = "";
                   foreach ($record as $row) { 
                  $si = [];
                  $num.= $no." ";
                   $span1 = "";
                    // $tmn = $this->model_app->view_where('tb_temuan','pemeriksaan_id',$row['pemeriksaan_id']);
                    $tmn = $this->db->query("SELECT * FROM tb_temuan WHERE pemeriksaan_id = '$row[pemeriksaan_id]' AND temuan_kirim='Y' AND temuan_pmr_sebelumnya='0' ORDER BY temuan_id ASC")->result_array(); 
                    $cek = $this->db->query("SELECT rekomendasi_status FROM tb_rekomendasi WHERE pemeriksaan_id = '$row[pemeriksaan_id]'")->result_array();
                    foreach ($cek as $so) {
                      $si[] = $so['rekomendasi_status'];
                    }
                      $target = array('Belum di Tindak Lanjut', 'Dikembalikan');
                      if (in_array('Belum di Tindak Lanjut' , $si) OR in_array('Dikembalikan', $si)) {
                        $span1 = "class='fa fa-asterisk'";
                      }else{
                        $span1 = "";
                      } 
                    ?>
                  <div class="accordion" id="accordion<?php echo $no ?>" role="tablist" aria-multiselectable="true">
                     <div class="panel">
                      <a class="panel-heading collapsed" role="tab" id="headingTwo<?php echo $no; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo<?php echo $no; ?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $no; ?>"<?php echo $no; ?>>
                        <h4 class="panel-title"><span><i class="fa fa-plus">&nbsp;</i></span><strong><?php echo $row['pemeriksaan_judul']; ?> </strong> 
                          <?php 
                              $mulai = explode("-", $row['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $row['pemeriksaan_tgl_akhir']);
                              echo "(".$mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0].")";
                          ?> 
                          <i id="bintang<?php echo $row['pemeriksaan_id'];?>"<?php echo $span1; ?>></i></h4>
                      </a>
                    </div>
                    
                    
                      <div id="collapseTwo<?php echo $no; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo<?php echo $no; ?>" style="padding: 5px 0px 5px 20px" >
                        <!-- --------------------------------------------------------------- -->
                        <?php 
                          if ($row['pemeriksaan_sebelumnya']!=0) { ?>
                            <!-- <div class="panel"> -->
                              <a class="panel-heading collapsed" role="tab" id="headingTwo<?php echo $back?>" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo<?php echo $back?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $back?>">
                                <h4 class="panel-title"><span class="fa fa-caret-down"></span> Pemeriksaan Sebelumnya yang belum Close</h4>
                              </a>
                              <div id="collapseTwo<?php echo $back?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo<?php echo $back?>"  style="padding: 10px 0px 0px 20px" >
                                <!-- <div class="panel-body"> -->
                                  <?php 
                                  $huhu = $row['pemeriksaan_sebelumnya'];
                                  $huhu = explode(" ", $huhu);
                                  foreach ($huhu as $hmm) {
                                   $pmr_back = $this->db->query("SELECT * FROM tb_temuan JOIN tb_pemeriksaan ON tb_temuan.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE NOT(temuan_pmr_sebelumnya = '0') AND temuan_pmr_sebelumnya = '$hmm' AND tb_pemeriksaan.pemeriksaan_id = '$row[pemeriksaan_id]' ORDER BY temuan_id ASC")->result_array(); ?> 
                                   <?php if ($pmr_back!=null): ?>
                                   <strong><font size="3"><?php
                                  $judulpmr = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$pmr_back[0]['temuan_pmr_sebelumnya']);
                                  echo "Pemeriksaan : ".$judulpmr[0]['pemeriksaan_judul']; 
                                  $mulai = explode("-", $judulpmr[0]['pemeriksaan_tgl_mulai']);
                                  $akhir = explode("-", $judulpmr[0]['pemeriksaan_tgl_akhir']);
                                  echo "(".$mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0].")";
                                  ?></font>
                                  </strong><br>
                                     
                                   <?php endif ?>
                                  <?php
                                  if ($pmr_back!=null) {
                                    $htg_temuan = 1;
                                    foreach ($pmr_back as $nilai) { 
                                      $cek_ta = $this->db->query("SELECT rekomendasi_status FROM tb_rekomendasi WHERE temuan_id = '$nilai[temuan_id]' AND rekomendasi_kirim='Y'")->result_array();
                                      // print_r($cek_t);
                                      foreach ($cek_ta as $toa) {
                                        $tia[] = $toa['rekomendasi_status'];
                                      }
                                      // print_r($ti);
                                      $span1a ='';
                                      foreach ($target as $keya) {
                                       if (in_array($keya, $tia)) {
                                          $span1a = "<span class='fa fa-asterisk red'></span>";
                                        }
                                      }
                                  ?>
                                  <div class="panel">
                                  <a class="panel-heading collapsed" role="tab" id="headingTwo<?php echo $tback; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo<?php echo $tback; ?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $tback; ?>"<?php echo $back; ?>>
                                    <h5 class="panel-title"><span><i class="fa fa-plus">&nbsp;</i></span>
                                      <strong>
                                        <?php 
                                        echo "Temuan ".$htg_temuan.": </strong>";
                                        $temuan = explode(" ", $nilai['temuan_judul']);
                                        $count = count($temuan);
                                        if ($count < 10) {
                                          echo $nilai['temuan_judul'];
                                        }else{
                                          for ($i=0; $i < 10; $i++) { 
                                            echo $temuan[$i]." ";
                                          }
                                          if ($count > 10) {
                                            echo "...";
                                          }
                                        } ?> 
                                      <?php echo $span1a; ?></h5>
                                  </a>
                                  </div>
                                  <div id="collapseTwo<?php echo $tback; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo<?php echo $tback; ?>">
                                    <div class="panel-body">
                                      <?php  
                                      $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $nilai['bidangtemuan_id']))->row_array();
                                      echo "<b>Bidang : </b>".$bidang['bidangtemuan_nama']."<br>";
                                      echo "<b>Obyek Pemeriksaan : </b>".$nilai['temuan_obyek']."<br>";
                                      echo "<b>Detail Temuan : </b><br>".$nilai['temuan_judul'];
                                      $tmn_id = $nilai['temuan_id'];
                                      $rekomendasi = $this->db->query("SELECT * FROM tb_rekomendasi WHERE temuan_id='$tmn_id' AND rekomendasi_kirim = 'Y'")->result_array();
                                      ?>
                                      <div class="table-responsive">
                                        <table class="table table-bordered">
                                          <tr>
                                            <th style="width: 38%"><center>Rekomendasi</center></th>
                                            <th style="width: 10%"><center>Tanggal</center></th>
                                            <th style="width: 16%"><center>Status</center></th>
                                            <th style="width: 16%"><center>Status Terbaru</center></th>
                                            <th style="width: 19%"><center>Action</center></th>
                                          </tr>
                                          <tbody>
                                            <?php 
                                            $btn_class= '';
                                            foreach ($rekomendasi as $key => $rowr) {
                                            if ($rowr['rekomendasi_status']=="Sudah di Tindak Lanjut") {
                                              $btn_class = 'btn btn-xs btn-round btn-success';
                                            }elseif($rowr['rekomendasi_status']=="Sudah TL (Belum Optimal)"){
                                              $btn_class = 'btn btn-xs btn-round btn-warning';
                                            }elseif ($rowr['rekomendasi_status']=="Belum di Tindak Lanjut") {
                                              $btn_class = 'btn btn-xs btn-round btn-danger';
                                            }elseif ($rowr['rekomendasi_status']=="Dikembalikan") {
                                              $btn_class = 'btn btn-xs btn-round btn-info';
                                            }else{
                                              $btn_class = 'btn btn-xs btn-round btn-dark';
                                            }
                                            
                                            ?>
                                            <tr>
                                              <td>
                                                <?php $rekom2 = explode(" ", $rowr['rekomendasi_judul']); 
                                                  $htg_rekom2 = count($rekom2);
                                                  if ($htg_rekom2 <= 15) {
                                                    echo $rowr['rekomendasi_judul'];
                                                  }else{
                                                    for ($i=0; $i < 15; $i++) { 
                                                    echo $rekom2[$i]." ";
                                                    }
                                                    
                                                  }
                                                  if ($htg_rekom2 > 15) { ?>
                                                    ...&nbsp;<a href="#" id="ambilid<?php echo $rowbaris?>" data-toggle="modal" data-target="#exampleModal" data-id="<?php echo $rowr['rekomendasi_id']?>"><i style="color: black">Lihat Selengkapnya</i></a>    
                                                    <?php 
                                                    }   
                                                ?>
                                              </td>
                                              <td><?php $tgl = explode("-", $rowr['rekomendasi_tgl']);  echo $tgl[2]."-".$tgl[1]."-".$tgl[0]; ?></td>
                                              <td>
                                                <center><span class="<?php echo $btn_class ?>"><?php echo $rowr['rekomendasi_status']; ?></span></center></td>
                                                <td>
                                                <center><span class="<?php echo $btn_class2 ?>"><?php echo $rowr['rekomendasi_status_terbaru']; ?></span></center></td>
                                              <td><div class="form-group">
                                                <?php   echo "<a href='".base_url()."administrator/riwayat_tl_vrf/$row[pemeriksaan_id]/$value[temuan_id]/$rowr[rekomendasi_id]'>" ?><button type="button" class="btn btn-default btn-xs" title="Lihat Riwayat Tindak Lanjut"><span class="fa fa-history"></span> Riwayat</button></a>
                                                <?php   echo "<a href='".base_url()."administrator/list_tl_verifikator/$row[pemeriksaan_id]/$value[temuan_id]/$rowr[rekomendasi_id]'>" ?><button type="button" class="btn btn-primary btn-xs" title="Isi Usulan Tindak Lanjut"><span class="fa fa-list-alt"></span> List TL</button></a>
                                              </div>
                                              </td>
                                            </tr>
                                            <?php
                                            } ?>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                  <?php $back++;  $tback++; $htg_temuan++; }?>
                                    <!-- ---batas if--- -->
                                  <?php }
                                  ?>
                                 <?php } ?>
                                  
                                  <!-- ----batasloop--- -->
                                <!-- </div> -->
                              </div>
                            <!-- </div> -->
                            
                          <?php }
                        ?>
                        <!-- ------------------------------------------------------------ -->
                        <?php 
                        $temuan = 1; $ti = []; 
                        foreach($tmn as $key => $value){ 
                          $span = ""; $ti=[];
                          $rkm = $this->model_app->view_where2('tb_rekomendasi','temuan_id',$value['temuan_id'], '
                            rekomendasi_kirim','Y');
                          $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $value['bidangtemuan_id']))->row_array();
                          $cek_t = $this->db->query("SELECT rekomendasi_status FROM tb_rekomendasi WHERE temuan_id = '$value[temuan_id]' AND rekomendasi_kirim='Y'")->result_array();
                          // print_r($cek_t);
                          foreach ($cek_t as $to) {
                            $ti[] = $to['rekomendasi_status'];
                          }
                          // print_r($ti);
                          $span2 ='';
                          foreach ($target as $key) {
                           if (in_array($key, $ti)) {
                              $span2 = "<span class='fa fa-asterisk red'></span>";
                            }
                          }
                          // if (in_array('Belum di Tindak Lanjut' , $ti) OR in_array('Dikembalikan', $ti) OR in_array('Sudah TL (Belum Optimal)', $ti)) {
                          //   $span2 = "<span class='fa fa-asterisk red'></span>";
                          // }else{
                          //   $span2 = "";
                          // }
                           $kata = explode(" ", $value['temuan_judul']); $hitung = count($kata); 
                          ?>
                        <div class="panel">
                          <a class="panel-heading collapsed" role="tab" id="headingThree<?php echo $r; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapseThree<?php echo $r; ?>" aria-expanded="false" aria-controls="collapseThree<?php echo $r; ?>">
                           <h5 id="yuhu<?php echo $row['pemeriksaan_id']?>"><span><i class="fa fa-plus">&nbsp;</i></span><strong><?php echo "Temuan ".$temuan." : "; ?></strong> 
                          <?php 
                          if ($hitung < 9) {
                            echo $value['temuan_judul'];
                          }else{
                            for ($i=0; $i < 9; $i++) { 
                              echo $kata[$i]." ";
                            }
                            if ($hitung > 9) {
                              echo "...";
                            }
                          }
                          ?> &nbsp;<?php echo $span2; ?></h5>
                          </a>
                        </div>
                          <div id="collapseThree<?php echo $r; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree<?php echo $r; ?>">
                          <div class="panel-body">
                            <b>Bidang : </b><?= $bidang['bidangtemuan_nama'] ?><br>
                            <b>Obyek Pemeriksaan : </b><?= $value['temuan_obyek'] ?><br>
                             <strong>Detail Temuan : </strong><br>
                                <?php echo $value['temuan_judul']; ?>
                          <div class="table-responsive">
                            <table class="table table-bordered">
                              <thead>
                                <th style="width: 38%"><center>Rekomendasi</center></th>
                                <th style="width: 10%"><center>Tanggal</center></th>
                                <th style="width: 16%"><center>Status</center></th>
                                <th style="width: 16%"><center>Status Terbaru</center></th>
                                <th style="width: 19%"><center>Action</center></th>
                              </thead>
                              <tbody>
                                <?php
                                foreach ($rkm as $baris) {
                                  $rowbaris++; 
                                  $ro = [];
                                  $ro2 = []; 
                                $select = ""; 
                                    if ($baris['rekomendasi_status']=="Sudah di Tindak Lanjut") {
                                      $btn_class = 'btn btn-xs btn-round btn-success';
                                    }elseif($baris['rekomendasi_status']=="Sudah TL (Belum Optimal)"){
                                      $btn_class = 'btn btn-xs btn-round btn-warning';
                                    }elseif ($baris['rekomendasi_status']=="Belum di Tindak Lanjut") {
                                      $btn_class = 'btn btn-xs btn-round btn-danger';
                                      
                                      $bintang.=$value['temuan_id']." ";
                                    }elseif ($baris['rekomendasi_status']=="Dikembalikan"){
                                      $btn_class = 'btn btn-xs btn-round btn-info';
                                    }else{
                                      $btn_class = 'btn btn-xs btn-round btn-dark';
                                    }
                                    $btn_class2 = '';
                                     if ($baris['rekomendasi_status_terbaru']!=null) {
                                       if ($baris['rekomendasi_status_terbaru']=="Sudah di Tindak Lanjut") {
                                         $btn_class2 = 'btn btn-xs btn-round btn-success';
                                       }elseif($baris['rekomendasi_status_terbaru']=="Sudah TL (Belum Optimal)"){
                                         $btn_class2 = 'btn btn-xs btn-round btn-warning';
                                       }elseif ($baris['rekomendasi_status_terbaru']=="Belum di Tindak Lanjut") {
                                         $btn_class2 = 'btn btn-xs btn-round btn-danger';
                                       }elseif ($baris['rekomendasi_status_terbaru']=="Dikembalikan") {
                                         $btn_class2 = 'btn btn-xs btn-round btn-info';
                                       }else{
                                         $btn_class2 = 'btn btn-xs btn-round btn-dark';
                                       }
                                     }
                                    $select = $this->db->query("SELECT tl_publish_verif FROM tb_tl WHERE rekomendasi_id = '$baris[rekomendasi_id]'")->result_array();
                                    $select2 = $this->db->query("SELECT tl_publish_spi FROM tb_tl WHERE rekomendasi_id = '$baris[rekomendasi_id]'")->result_array();
                                    // print_r($select);
                                    foreach ($select as $v) {
                                      foreach ($v as $o => $val) {
                                        $ro[] = $val;
                                      }
                                    }
                                    foreach ($select2 as $f) {
                                      foreach ($f as $p => $val2) {
                                        $ro2[] = $val2;
                                      }
                                    }                                    
                                    $span3 ='';
                                    if (in_array('Y', $ro)) {
                                      if (in_array('N', $ro2)) {
                                        $span3 = "<span class='fa fa-circle red'></span>";
                                      }else{
                                        $span3 = "";
                                      }    
                                    }
                                ?>
                                <tr>
                                  <td>
                                    <?php $rekom = explode(" ", $baris['rekomendasi_judul']); 
                                      $htg_rekom = count($rekom);
                                      if ($htg_rekom <= 15) {
                                        echo $baris['rekomendasi_judul'];
                                      }else{
                                        for ($i=0; $i < 15; $i++) { 
                                        echo $rekom[$i]." ";
                                        }
                                        
                                      }
                                      if ($htg_rekom > 15) { ?>
                                        ...&nbsp;<a href="#" id="ambilid<?php echo $rowbaris?>" data-toggle="modal" data-target="#exampleModal" data-id="<?php echo $baris['rekomendasi_id']?>"><i style="color: black">Lihat Selengkapnya</i></a>    
                                        <?php 
                                        }
                                        echo " ".$span3;   
                                    ?>
                                  </td>
                                  <td><?php $tgl = explode("-", $baris['rekomendasi_tgl']);  echo $tgl[2]."-".$tgl[1]."-".$tgl[0]; ?></td>
                                  <td><center><span class="<?php echo $btn_class ?>"><?php echo $baris['rekomendasi_status']; ?></span></center></td>
                                   <td><center>
                                    <?php if ($baris['rekomendasi_status_terbaru']!=null): ?>
                                    <span class="<?php echo $btn_class2 ?>"><?php echo $baris['rekomendasi_status_terbaru']; ?></span>  
                                    <?php else: ?>
                                    <?php echo "-"; endif ?>
                                  </center></td>
                                  <td><div class="form-group">
                                    <?php   echo "<a href='".base_url()."administrator/riwayat_tl_vrf/$row[pemeriksaan_id]/$value[temuan_id]/$baris[rekomendasi_id]'>" ?><button type="button" class="btn btn-default btn-xs" title="Lihat Riwayat Tindak Lanjut"><span class="fa fa-history"></span> Riwayat</button></a>
                                    <?php   echo "<a href='".base_url()."administrator/list_tl_verifikator/$row[pemeriksaan_id]/$value[temuan_id]/$baris[rekomendasi_id]'>" ?><button type="button" class="btn btn-primary btn-xs" title="Isi Usulan Tindak Lanjut"><span class="fa fa-list-alt"></span> List TL</button></a>
                                  </div>
                                </td>
                              </tr>
                              <?php } ?>
                          </tbody>
                        </table>
                      </div>
                            </div>
                          </div>
                          <?php $r++; $temuan++;} ?>
                      </div>
                  </div>
                  <?php $no++; } ?>
                  <!-- end of accordion -->
                 <!--    </table> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
<div class="modal fade exampleModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
        <h5 class="modal-title" id="exampleModalLabel"><h5><strong>Detail Rekomendasi</strong></h5></h5>
      </div>
      <div class="modal-body">
       <p id="tampildata">
         
       </p>
      </div>
      <div class="modal-footer">
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
    <script type="text/javascript">
      $('#myDatepicker').datetimepicker({
        format: 'YYYY-MM-DD' });
      var test = '<?php echo $bintang ?>';
      // console.log(test);
      <?php $b = explode(" ", $bintang);
        foreach ($b as $key => $value) {

          ?>
            // $("#bintang<?php echo $value ?>").append("<i class='fa fa-asterisk'></i>");
            // $("#yuhu<?php echo $value ?>").append(" <i class='fa fa-asterisk' style='color: #ff3f3f'></i>");
          <?php
        }
       ?>
    </script>
    <script type="text/javascript">
      // var num = '<?php //echo $num ?>';
      // console.log(num);
      // <?php //$c = explode(" ", $num); 
      // foreach ($c as $key => $value) { ?>
      // var no = '<?php //echo $value ?>';
      // console.log(no);
      // $('#accordion' + no).on('shown.bs.collapse', function () {
        
      //   var panel = $(this).find('.in');
        
      //   $('html, body').animate({
      //         scrollTop: panel.offset().top
      //   }, 500);
        
      // });
      <?php //} ?>
    </script>
    <script type="text/javascript">
      <?php for ($i=1; $i <= $rowbaris ; $i++) { ?>
        $('#ambilid<?php echo $i ?>').click(function(){
          var idrekom = $(this).attr('data-id');
          var BASE_URL = "<?php echo base_url('administrator/tampil_readmore_rekom/');?>";
           var urll = BASE_URL+idrekom;
           console.log(urll);
            $.ajax({
                type  : 'ajax',
                url   : urll,
                async : true,
                dataType : 'json',
                success : function(data){
                console.log(data);
                $('#tampildata').html(data);
                }
                //window.alert(urll);
            });
        });
      <?php } ?>
      
    </script>