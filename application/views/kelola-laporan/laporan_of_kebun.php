<title>PTPN XII | Laporan Berdasarkan Pemeriksaan</title>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
  
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Laporan Berdasarkan Total Kebun / per Kebun</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <!-- <li><a href="daftar_pmr.php"><button type="button" class="btn btn-default btn-xs">Tambah Pemeriksaan</button></a></li> -->
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                   <!-- Retrieve data untuk role tamu -->
                  <?php 
                  $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
                   if (strpos($role[0]['role_akses'],'29') OR $this->session->level=="administrasi") {
                    $where=[];
                    if ($bun!="semua") {
                      $where[] = " tb_pemeriksaan.unit_id ".$bun."";
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
                    if ($build!="") {
                      $record = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id WHERE pemeriksaan_jenis = 'Rutin' AND pemeriksaan_aktif = 'Y' AND ".$build." ORDER BY tb_pemeriksaan.pemeriksaan_id ASC")->result_array();
                    }else{
                      $record = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id WHERE pemeriksaan_jenis = 'Rutin' AND pemeriksaan_aktif = 'Y' ORDER BY tb_pemeriksaan.pemeriksaan_id ASC")->result_array();
                    }
                   }
                  ?>
                  <div class="x_content">
                    <?php  
                      $attributes = array('class'=>'form-horizontal','role'=>'form');
                      echo form_open('laporan/cari_laporan',$attributes);
                    ?>
                   <?php $this->load->view('kelola-laporan/pencarian_laporan'); ?>
                    <?php echo form_close(); ?>
                    <br>
                    <center><h4><strong>
                    <?php if ($record!=null) { ?>
                    Daftar Monitoring Tindak Lanjut <br><?php if ($kebun !="Semua Kebun") {
                      echo "Kebun : ";
                    } ?> 
                     <?php echo $kebun; 
                     if ($multikebun!=null) {
                        foreach ($multikebun as $id) {
                           $kbn = $this->model_app->view_profile('tb_kebun', array('kebun_id'=> $id))->row_array();
                          echo "(".$kbn['kebun_nama'].") ";
                        }
                      }
                     ?>
                    <?php }else{ ?>
                      Tidak Ada Data untuk Kebun <br><?php echo "- ".$kebun." -"; ?><br><?php echo $bidang; ?>
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
                      <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Pemeriksaan</th>
                          <th>Kebun</th>
                          <th>Tanggal</th>
                          <th>Bidang</th>
                          <th style="width: 100px">Obyek Pemeriksaan</th>
                          <th style="width: 250px">Hasil Temuan</th>
                          <th style="width: 200px">Rekomendasi</th>
                          <!-- looping untuk banyaknya header / kolom tindak lanjut -->
                          <?php 
                          $loop = 0;
                          $hitung = [];
                          foreach ($record as $row) {
                            $tul = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$row[rekomendasi_id]' AND tl_publish_spi='Y'")->result_array(); 
                            $hitung[] = count($tul);
                          } 
                          // ambil jumlah tindak lanjut tiap rekomendasi
                          if (!empty($hitung)) {
                            $loop =  max($hitung);
                          }
                          $n = "I";
                          for ($i=0; $i < $loop ; $i++) { 
                            echo "<th style='width: 200px'>Tindak Lanjut ".$n."</th>
                                  <th style='width: 125px'>Tanggapan<br> TL ".$n."</th>
                                  <th style='width: 125px'>Status<br> TL ".$n."</th>";
                            $n.="I";      
                          }
                          ?>
                          <th style="width: 100px">Status</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        $no = 0;
                        foreach ($record as $value) { 
                          $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $value['bidangtemuan_id']))->row_array();
                          //span warna untuk status rekomendasi
                          if ($value['rekomendasi_status']=="Sudah di Tindak Lanjut") {
                            $btn_class = 'btn btn-xs btn-round btn-success';
                          }elseif($value['rekomendasi_status']=="Sudah TL (Belum Optimal)"){
                            $btn_class = 'btn btn-xs btn-round btn-warning';
                          }elseif ($value['rekomendasi_status']=="Belum di Tindak Lanjut") {
                            $btn_class = 'btn btn-xs btn-round btn-danger';
                          }elseif ($value['rekomendasi_status']=="Dikembalikan") {
                            $btn_class = 'btn btn-xs btn-round btn-info';
                          }else{
                            $btn_class = 'btn btn-xs btn-round btn-dark';
                          }
                          $aku = $this->session->username;
                          $user = explode("/", $value['pemeriksaan_petugas']);
                          //menampilkan untuk user SPI
                          if (in_array($aku, $user) && $this->session->level=="spi") {
                            $no++;
                        ?>
                        <tr>
                          <td><?php echo $no; ?></td>
                          <td><?php echo $value['pemeriksaan_judul']; ?></td>
                          <td><?php 
                          $bun = $this->model_app->view_profile('tb_kebun', array('kebun_id'=> $value['kebun_id']))->row_array();
                          echo $bun['kebun_nama']; ?></td>
                          <td><?php 
                              $mulai = explode("-", $value['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $value['pemeriksaan_tgl_akhir']);
                              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d <br>".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                          ?></td>
                          <td><?php echo $bidang['bidangtemuan_nama'] ?></td>
                          <td><?php echo $value['temuan_obyek'] ?></td>
                          <td><?php echo $value['temuan_judul']; ?></td>
                          <td><?php echo $value['rekomendasi_judul']; ?>
                            <?php 
                            $tanggapan = $this->model_app->view_where('tb_tanggapan','rekomendasi_id',$value['rekomendasi_id']);
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
                            <td>
                             <?php if ($tl[$i]['tl_deskripsi']!=null) {
                               echo $tl[$i]['tl_deskripsi'];
                             }else{
                              echo "<center>-</center>";
                             } ?>
                             </td>
                             <td><?php if ($tl[$i]['tl_tanggapan']!=null) {
                               echo $tl[$i]['tl_tanggapan'];
                             }else{
                              echo "<center>-</center>";
                             }  ?>
                             </td>
                             <td>
                              <!-- menampilkan status per tindak lanjut -->
                               <?php 
                                $status = '';
                                $stt = $tl[$i]['tl_status'];
                                if ($stt == "Sudah di Tindak Lanjut" ) {
                                  $status = "<span class='label label-success'>".$stt."</span>";
                                }elseif ($stt == "Belum di Tindak Lanjut" ) {
                                  $status = "<span class='label label-danger'>".$stt."</span>";
                                }elseif ($stt == "Dikembalikan" ) {
                                  $status = "<span class='label label-info'>".$stt."</span>";
                                }elseif ($stt == "Sudah TL (Belum Optimal)" ) {
                                  $status = "<span class='label label-warning'>".$stt."</span>";
                                }
                                echo "<center>".$status."</center>";
                                 ?>
                             </td>
                            <?php }
                            ?>
                          <?php 
                          //looping untuk memenuhi kolom tindak lanjut yang kosong
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
                            echo "<td><center>-</center></td>";
                          } ?>
                          <td><center><span class="<?php echo $btn_class ?>"><?php echo $value['rekomendasi_status']; ?></span></center></td>
                        </tr>
                      <?php }elseif ($this->session->level!="spi") {
                        $no++;
                        ?>
                        <tr>
                          <td><?php echo $no; ?></td>
                          <td><?php echo $value['pemeriksaan_judul']; ?></td>
                          <td><?php 
                          $bun = $this->model_app->view_profile('tb_kebun', array('kebun_id'=> $value['kebun_id']))->row_array();
                          echo $bun['kebun_nama']; ?></td>
                          <td><?php 
                              $mulai = explode("-", $value['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $value['pemeriksaan_tgl_akhir']);
                              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d <br>".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                          ?></td>
                          <td><?php echo $bidang['bidangtemuan_nama'] ?></td>
                          <td><?php echo $value['temuan_obyek'] ?></td>
                          <td><?php echo $value['temuan_judul']; ?></td>
                          <td><?php echo $value['rekomendasi_judul']; ?></td>
                                                    
                            <?php $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$value[rekomendasi_id]' AND tl_publish_spi='Y'")->result_array(); 
                            for ($i=0; $i < count($tl) ; $i++) { ?>
                            <td>
                             <?php if ($tl[$i]['tl_deskripsi']!=null) {
                               echo $tl[$i]['tl_deskripsi'];
                             }else{
                              echo "<center>-</center>";
                             } ?>
                             </td>
                             <td><?php if ($tl[$i]['tl_tanggapan']!=null) {
                               echo $tl[$i]['tl_tanggapan'];
                             }else{
                              echo "<center>-</center>";
                             }  ?>
                             </td>
                             <td>
                               <?php 
                                $status = '';
                                $stt = $tl[$i]['tl_status'];
                                if ($stt == "Sudah di Tindak Lanjut" ) {
                                  $status = "<span class='label label-success'>".$stt."</span>";
                                }elseif ($stt == "Belum di Tindak Lanjut" ) {
                                  $status = "<span class='label label-danger'>".$stt."</span>";
                                }elseif ($stt == "Dikembalikan" ) {
                                  $status = "<span class='label label-info'>".$stt."</span>";
                                }elseif ($stt == "Sudah TL (Belum Optimal)" ) {
                                  $status = "<span class='label label-warning'>".$stt."</span>";
                                }
                                echo "<center>".$status."</center>";
                              ?>
                             </td>
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
                            echo "<td><center>-</center></td>";
                          } ?>
                          <td><center><span class="<?php echo $btn_class ?>"><?php echo $value['rekomendasi_status']; ?></span></center></td>
                        </tr>
                      <?php
                      }

                      ?>
                        <?php } ?>
                        
                      </tbody>
                    </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
      $(document).ready(function () {
        $('#judul_pmr').select2({
          placeholder: "Pilih Judul Pemeriksaan"
        });
      });
    </script>
    <script type="text/javascript">
      $('#myDatepicker').datetimepicker({
        format: 'YYYY-MM-DD' });
    </script>
    <script type="text/javascript">
      $('#datatable').dataTable( {
          "scrollX": true,
         
        });
    </script>
    <script type="text/javascript">
      $('#bt-remove').on('click', function(){
        $('#forpesan').remove();
      });
    </script>
        <script type="text/javascript">
      !function ($) {
        document.getElementById('jenis').value = '0';
        $('#rentang').hide();
        $('#pemeriksaan').hide();
        $('#status').hide();
        $('#jenis_pmr').hide();
        $('#pakerentang').hide();
        $('#exportexcel').hide();
        $('#form-kebun').hide();
        $('#form-pilihkebun').hide();
        $('#bidang').hide();
      }(window.jQuery);
    </script>

    <script>
    $('input[name="waktu"]:radio').change(function(){    
        var isi = this.value;
        if (isi == "N") {
          $('#rentang').hide();
        }else{
          $('#rentang').show();
        }
    });
    </script>
    <script type="text/javascript">
      $('#jenis').change(function(){
        
        // var loop = $('#jenis').val();
        // console.log(loop);

        // loop.forEach(fungsi);
        // function fungsi(){
          if ($('#jenis').val()=="semua") {
            $('#rentang').show();
            $('#pemeriksaan').hide();
            $('#status').hide();
            $('#jenis_pmr').show();
            $('#exportexcel').show();
            $('#form-kebun').hide();
            $('#form-pilihkebun').hide();
            $('#bidang').show();
            $('#pakerentang').show();
          }else if($('#jenis').val()=="status"){
            $('#rentang').show();
            $('#pemeriksaan').hide();
            $('#status').show();
            $('#jenis_pmr').hide();
            $('#exportexcel').show();
            $('#form-kebun').hide();
            $('#form-pilihkebun').hide();
            $('#bidang').show();
            $('#pakerentang').show();
          }else if($('#jenis').val()=="pemeriksaan"){
            $('#rentang').show();
            $('#pemeriksaan').show();
            $('#status').hide();
            $('#jenis_pmr').hide();
            $('#exportexcel').show();
            $('#form-kebun').hide();
            $('#form-pilihkebun').hide();
            $('#bidang').show();
            $('#pakerentang').show();
          }else if($('#jenis').val()=="perkebun"){
            $('#rentang').show();
            $('#pemeriksaan').hide();
            $('#status').hide();
            $('#jenis_pmr').hide();
            $('#exportexcel').show();
            $('#form-kebun').show();
            $('#form-pilihkebun').hide();
            $('#bidang').show();
            $('#pakerentang').show();
          }else{
            $('#rentang').hide();
            $('#pemeriksaan').hide();
            $('#status').hide();
            $('#jenis_pmr').hide();
            $('#exportexcel').hide();
            $('#form-kebun').hide();
            $('#form-pilihkebun').hide();
            $('#bidang').hide();
            $('#pakerentang').hide();
          }
       // }
      });
    </script>
    <script type="text/javascript">
    $('#kebun').change(function(){
      if ($('#kebun').val()=="cekbox") {
        $('#form-pilihkebun').show();
      }else{
        $('#form-pilihkebun').hide();
      }
    });
    </script>
