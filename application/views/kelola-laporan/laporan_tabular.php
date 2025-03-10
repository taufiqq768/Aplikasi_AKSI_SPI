    <title>PTPN I | Laporan Tabular</title>
<!--     <style type="text/css">
      /*Top and bottom scrollbar*/
    .large-table-container-3 {
     
      overflow-x: scroll;
      overflow-y: auto;
    }
    .large-table-container-3 table {
      
    }
    .large-table-fake-top-scroll-container-3 {
     
      overflow-x: scroll;
      overflow-y: auto;
    }
    .large-table-fake-top-scroll-container-3 div {
     
      font-size:1px;
      line-height:1px;
    }
    /*misc*/
    td {
      border: 1px solid gray;
    }

    th {
      text-align: left;
    }
    </style> -->
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
  
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Laporan Tabular<small>Pemeriksaan</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <?php  
                      $attributes = array('class'=>'form-horizontal','role'=>'form', 'id'=>'myform');
                      echo form_open('laporan/cari_laporan',$attributes);
                    ?>
                    <!-- LOAD VIEW SELECT PENCARIAN -->
                    <?php $this->load->view('kelola-laporan/pencarian_laporan'); ?>
                    <?php echo form_close(); ?>
                    </br >
                    <center><h4><strong>
                      <?php if ($record!=null) { ?>
                      Daftar Monitoring Tindak Lanjut <br>Semua Pemeriksaan<br><?php echo $bidang; ?><br>
                      <?php }else{ ?>
                       Tidak Ada Data Pemeriksaan<br><?php echo $bidang; ?><br>
                      <?php } ?>
                       <?php 
                       if ($rentang == "semua"){  
                         echo "Pada Semua Waktu Pemeriksaan";
                       }else{
                         echo "Pada Rentang Waktu : ".$rentang;
                       } ?>
                    </strong></h4></center> 
                   <!--  <div class="large-table-fake-top-scroll-container-3">
                      <div>&nbsp;</div>
                    </div> -->
                    <div class="large-table-container-3">
                      <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Jenis Audit</th>
                          <th style="width: 100px">Pemeriksaan</th>
                          <th>Unit</th>
                          <th style="width: 50px">Tgl. </th>
                          <th style="width: 50px">Bidang</th>
                          <th style="width: 300px">Hasil Temuan</th>
                          <th style="width: 150px">Rekomendasi</th>
                          <th style="width: 250px">Tindak Lanjut</th>
                          <th style="width: 200px">Tanggapan Tindak Lanjut</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 0; 
                          $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
                          $where=[];
                          if (strpos($role[0]['role_akses'],'29') OR $this->session->level=="administrasi") {
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
                        if ($this->session->level=="spi") {
                          $no =0;
                        }else{
                          $no=1;
                        }
                        // print_r($record);
                        foreach ($record as $key => $row) { 
                          $unit = $this->model_app->view_profile('tb_unit', array('unit_id'=> $row['unit_id']))->row_array();
                          $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $row['bidangtemuan_id']))->row_array();
                          if ($row['rekomendasi_status']=="Sesuai") {
                            $btn_class = 'btn btn-xs btn-round btn-success';
                          }elseif($row['rekomendasi_status']=="Belum Sesuai"){
                            $btn_class = 'btn btn-xs btn-round btn-warning';
                          }elseif ($row['rekomendasi_status']=="Belum di Tindak Lanjut") {
                            $btn_class = 'btn btn-xs btn-round btn-danger';
                          }elseif ($row['rekomendasi_status']=="Tidak dapat di Tindak Lanjuti") {
                            $btn_class = 'btn btn-xs btn-round btn-info';
                          }else{
                            $btn_class = 'btn btn-xs btn-round btn-dark';
                          }
                          ?>
                          <?php 
                          $aku = $this->session->username;
                          $user = explode("/", $row['pemeriksaan_petugas']);

                            if (in_array($aku, $user) && $this->session->level=="spi") { 
                                 $no++;
                          ?>
                        <tr>
                          <td><?php echo $no."."; ?></td>
                          <td><?php echo $row['pemeriksaan_jenis']; ?></td>
                          <td><?php echo $row['pemeriksaan_judul']; ?></td>
                          <td><?php echo $unit['unit_nama']; ?></td>
                          <td><?php 
                              $mulai = explode("-", $row['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $row['pemeriksaan_tgl_akhir']);
                              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d <br>".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                          ?></td>
                          <td><?php echo $bidang['bidangtemuan_nama'] ?></td>
                          <td><?php echo $row['temuan_judul']; ?></td>
                          <td><?php echo $row['rekomendasi_judul']; ?></td>
                          <td>
                          <?php 
                          $useropr = $this->session->username;
                          if ($this->session->level=="spi") {
                            if ($row['pemeriksaan_jenis']!="Rutin") {
                              $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$row[rekomendasi_id]' AND tl_publish_kabag='Y'")->result_array();
                              $tanggapan = $this->model_app->view_where('tb_tanggapan','rekomendasi_id',$row['rekomendasi_id']);
                              if ($tanggapan!=null) {
                                $tgl = explode("-", $tanggapan[0]['tanggapan_tgl']);
                                echo "<b>Tanggapan Manajer : </b><br>".$tanggapan[0]['tanggapan_deskripsi']."<br>";
                                echo "<i>ditanggapi pada ".$tgl[2]."-".$tgl[1]."-".$tgl[0]."</i><br><br>";
                              }
                            }else{
                              $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$row[rekomendasi_id]' AND tl_publish_spi='Y'")->result_array();
                            }
                          }elseif($this->session->level=="operator" OR $this->session->level=="viewer" OR $this->session->level=="administrasi" OR $this->session->level=="verifikator"){
                            $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$row[rekomendasi_id]'")->result_array();
                          }
                          
                          $tindak = "I";
                            foreach ($tl as $value) { 
                              $status = '-<br>';
                              ?>
                              <?php  $tgl = explode("-", $value['tl_tgl']); echo "<b>Tindak Lanjut ".$tindak." (".$tgl[2]."-".$tgl[1]."-".$tgl[0].") :</b>"."<br><b>Status : </b>"; 
                                $stt = $value['tl_status'];
                                if ($stt == "Sesuai" ) {
                                  $status = "<span class='label label-success'>".$stt."</span>";
                                }elseif ($stt == "Belum di Tindak Lanjut" ) {
                                  $status = "<span class='label label-danger'>".$stt."</span>";
                                }elseif ($stt == "Tidak dapat di Tindak Lanjuti" ) {
                                  $status = "<span class='label label-info'>".$stt."</span>";
                                }elseif ($stt == "Belum Sesuai" ) {
                                  $status = "<span class='label label-warning'>".$stt."</span>";
                                }
                                echo $status."<br>"; ?>
                              <?php echo $value['tl_deskripsi']; ?>
                              <br><br>
                          <?php  $tindak.="I";}
                          if ($tl==null) {
                            echo "<center><b>-</b></center>";
                          }
                          ?>
                        </td>
                        <td>
                          <?php 
                          $tindak = "I";
                          foreach ($tl as $value) { 
                              ?>
                              <?php if ($value['tl_tanggapan']!=null) {
                               echo "<b>Tanggapan Tindak Lanjut ".$tindak." :</b><br>"; ?>
                              <?php 
                                echo $value['tl_tanggapan'];;
                              }else{echo "<center></center>";} ?>
                              <br><br>
                          <?php  $tindak.="I";}if ($tl==null) {
                            echo "<center><b>-</b></center>";
                          } ?>
                        </td>
                        <td><center><span class="<?php echo $btn_class ?>"><?php echo $row['rekomendasi_status']; ?></span></center></td>
                        </tr>  
                          <?php
                          }elseif ($this->session->level!="spi") { ?>
                            <tr>
                          <td><?php echo $no."."; ?></td>
                          <td><?php echo $row['pemeriksaan_jenis']; ?></td>
                          <td><?php echo $row['pemeriksaan_judul']; ?></td>
                          <td><?php echo $unit['unit_nama']; ?></td>
                          <td><?php 
                              $mulai = explode("-", $row['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $row['pemeriksaan_tgl_akhir']);
                              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d <br>".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                          ?></td>
                          <td><?php echo $bidang['bidangtemuan_nama'] ?></td>
                          <td><?php echo $row['temuan_obyek'] ?></td>
                          <td><?php echo $row['temuan_judul']; ?></td>
                          <td><?php echo $row['rekomendasi_judul']; ?></td>
                          <td>
                          <?php 
                          $useropr = $this->session->username;
                          if ($this->session->level=="spi" OR $this->session->level=="admin" OR $this->session->level=="kabagspi" OR $this->session->level=="viewer" OR $this->session->level=="administrasi") {
                            $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$row[rekomendasi_id]' AND tl_publish_spi='Y'")->result_array();
                          }elseif($this->session->level=="operator" OR $this->session->level=="verifikator"){
                            $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$row[rekomendasi_id]' AND user_opr='$useropr'")->result_array();
                          }
                          
                          $tindak = "I";
                            foreach ($tl as $value) {
                            $status = ''; 
                              ?>
                              <?php  $tgl = explode("-", $value['tl_tgl']); echo "<b>Tindak Lanjut ".$tindak." (".$tgl[2]."-".$tgl[1]."-".$tgl[0].") :</b>"."<br><b>Status : </b>"; 
                                $stt = $value['tl_status'];
                                if ($stt == "Sesuai" ) {
                                  $status = "<span class='label label-success'>".$stt."</span>";
                                }elseif ($stt == "Belum di Tindak Lanjut" ) {
                                  $status = "<span class='label label-danger'>".$stt."</span>";
                                }elseif ($stt == "Tidak dapat di Tindak Lanjuti" ) {
                                  $status = "<span class='label label-info'>".$stt."</span>";
                                }elseif ($stt == "Belum Sesuai" ) {
                                  $status = "<span class='label label-warning'>".$stt."</span>";
                                }
                                echo $status."<br>"; ?>
                              <?php echo $value['tl_deskripsi']; ?>
                              <br><br>
                          <?php  $tindak.="I";}
                          if ($tl==null) {
                            echo "<center><b>-</b></center>";
                          }
                          ?>
                        </td>
                        <td>
                          <?php 
                          $tindak = "I";
                          foreach ($tl as $value) { 
                              ?>
                              <?php if ($value['tl_tanggapan']!=null) {
                               echo "<b>Tanggapan Tindak Lanjut ".$tindak." :</b><br>"; ?>
                              <?php 
                                echo $value['tl_tanggapan'];;
                              }else{echo "<center></center>";} ?>
                              <br><br>
                          <?php  $tindak.="I";}if ($tl==null) {
                            echo "<center><b>-</b></center>";
                          } ?>
                        </td>
                        <td><center><span class="<?php echo $btn_class ?>"><?php echo $row['rekomendasi_status']; ?></span></center></td>
                        </tr>

                    <?php $no++; }
                        
                        ?>
                        <?php  } ?>
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
    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/iCheck/icheck.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/select2/dist/js/select2.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
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
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/pdfmake/build/vfs_fonts.js"></script>
     <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
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
      !function ($) 
      {
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
        $('#lha').hide();
      }
      (window.jQuery);
    </script>
    <script type="text/javascript">
      // DOUBLE SCROLL
      // $(function() {
      //   var tableContainer = $(".large-table-container-3");
      //   var table = $(".large-table-container-3 table");
      //   var fakeContainer = $(".large-table-fake-top-scroll-container-3");
      //   var fakeDiv = $(".large-table-fake-top-scroll-container-3 div");

      //   var tableWidth = table.width();
      //   fakeDiv.width(tableWidth);
        
      //   fakeContainer.scroll(function() {
      //     tableContainer.scrollLeft(fakeContainer.scrollLeft());
      //   });
      //   tableContainer.scroll(function() {
      //     fakeContainer.scrollLeft(tableContainer.scrollLeft());
      //   });
      // });
      $('#datatable').dataTable( {
          "scrollX": true,
         
        });
    </script>
     <!-- <script>
      $(document).ready(function () {
        $('#jenis').select2({
          placeholder: "- Pilih Jenis Laporan -"
        });
      });
    </script> -->
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
            $('#rentang').hide();
            $('#pemeriksaan').hide();
            $('#status').hide();
            $('#jenis_pmr').hide();
            $('#exportexcel').hide();
            $('#form-kebun').hide();
            $('#form-pilihkebun').hide();
            $('#bidang').hide();
            $('#pakerentang').hide();
            $('#lha').hide();
          }else if($('#jenis').val()=="lha"){
            $('#lha').show();
            $('#pemeriksaan').hide();
            $('#status').hide();
            $('#jenis_pmr').hide();
            $('#exportexcel').hide();
            $('#form-kebun').hide();
            $('#form-pilihkebun').hide();
            $('#bidang').hide();
            $('#pakerentang').hide();
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
  </body>
</html>