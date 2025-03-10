 <title>PTPN XII | Temuan dan Tindak Lanjut Pemeriksaan</title>
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>
                  <a href="<?php echo base_url(); ?>administrator/list_pmr_verifikator"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-mail-reply"></i></button></a>
                  Pemeriksaaan <small>Kebun</small>
                </h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <?php if ($this->session->flashdata('kirim')!=null) {
                          echo "<div class='alert alert-success' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('kirim')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                    }elseif ($this->session->flashdata('simpan')!=null) {
                          echo "<div class='alert alert-info' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('simpan')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                    } ?>
                    <div class="table-responsive">
                    <table class="tile_info">
                      <thead>
                        <center><b>Data Pemeriksaan</b></center>
                        <br>
                      </thead>
                    <?php foreach ($record2 as $row) { 
                      $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $row['bidangtemuan_id']))->row_array();
                      if ($row['rekomendasi_status']=="Sudah di Tindak Lanjut") {
                        $btn_class = 'btn btn-xs btn-round btn-success';
                      }elseif($row['rekomendasi_status']=="Sudah TL (Belum Optimal)"){
                        $btn_class = 'btn btn-xs btn-round btn-warning';
                      }elseif ($row['rekomendasi_status']=="Belum di Tindak Lanjut") {
                        $btn_class = 'btn btn-xs btn-round btn-danger';
                      }else{
                        $btn_class = 'btn btn-xs btn-round btn-info';
                      }
                    ?> 
                       <tr>
                        <th scope="row" style="width: 150px">Jenis Audit</th>
                        <td>: <?php echo $row['pemeriksaan_jenis']; ?></td>
                      </tr>
                      <tr>
                        <th style="width: 150px">Judul</th>
                        <td>: <?php echo $row['pemeriksaan_judul']; ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Tanggal Pemeriksaan</th>
                        <td>: <?php 
                              $mulai = explode("-", $row['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $row['pemeriksaan_tgl_akhir']);
                              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                        ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Keterangan </th>
                        <td>: Keterangan</td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Nama Petugas SPI</th>
                        <td><?php 
                        $select  = explode("/", $row['pemeriksaan_petugas']);
                          // print_r($select);
                           if (count($select)==1) {
                            $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $row['pemeriksaan_petugas']))->row_array();
                             echo ": ".$usr['user_nama'];
                           }else{
                           $no = 1;
                             foreach ($select as $nik) {
                              $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $nik))->row_array();
                              echo $no.". ".$usr['user_nama']."<br>";
                              $no++;
                             }
                           } ?> </td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Bidang</th>
                        <td>: <?php echo $bidang['bidangtemuan_nama']; ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Obyek Pemeriksaan</th>
                        <td>: <?php echo $row['temuan_obyek']; ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px; vertical-align: top;">Temuan</th>
                        <td>: <?php echo $row['temuan_judul']; ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Rekomendasi</th>
                        <td>: <?php echo $row['rekomendasi_judul']; ?></td>
                      </tr>
                      <tr>
                        <th style="width: 150px">Status Rekomendasi</th>
                        <td>: <span class="<?php echo $btn_class; ?>"><?php echo $row['rekomendasi_status']; ?>
                          <?php $id_pmr = $this->uri->segment(3);$id_temuan = $this->uri->segment(4); $id_rekom = $this->uri->segment(5);?>
                         <?php $limit = $this->db->where('rekomendasi_id',$id_rekom)->from("tb_tl")->count_all_results(); ?>
                        <?php if ($limit < 3  AND $row['rekomendasi_status']!="Sudah di Tindak Lanjut"){ ?>
                        <!-- <td><?php   //echo "<a href='".base_url()."administrator/input_tl/$id_pmr/$id_temuan/$id_rekom'>"?><button type="button" class="btn btn-default btn-xs pull-right">Input Tindak Lanjut</button></a></td> -->
                        <?php } ?>
                        </td>
                      </tr>
                      <?php } ?>
                    </table>

                    </div>
                    <br>

                    <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 5%">No.</th>
                          <th style="width: 35%"><center>Tindak lanjut</center></th>
                          <th style="width: 9%"><center>Tanggal</center></th>
                          <th style="width: 24%"><center>Tanggapan</center></th>
                          <th style="width: 18%"><center>Status</center></th>
                          <th style="width: 9%"><center>Tgl Status</center></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);?>
                        <?php
                        $no = 1;
                        // $tl = $this->model_app->view_where2('tb_tl','rekomendasi_id',$id_rekom, 'tl_status_publish', "Y");
                        $tl = $this->db->query("SELECT * FROM tb_tl JOIN tb_rekomendasi ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id WHERE tb_rekomendasi.rekomendasi_id = '$id_rekom' AND tl_tanggapan_kirim='Y'")->result_array();
                        foreach ($tl as $baris) {
                          if ($baris['tl_status']=="Sudah di Tindak Lanjut") {
                            $status = "<span class='btn btn-success btn-xs btn-round'>".$baris['tl_status']."</span";
                          }
                          if ($baris['tl_status']=="Belum di Tindak Lanjut") {
                            $status = "<span class='btn btn-danger btn-xs btn-round'>".$baris['tl_status']."</span";
                          }
                          if ($baris['tl_status']=="Sudah TL (Belum Optimal)") {
                            $status = "<span class='btn btn-warning btn-xs btn-round'>".$baris['tl_status']."</span";
                          }
                          if ($baris['tl_status']=="Dikembalikan") {
                            $status = "<span class='btn btn-info btn-xs btn-round'>".$baris['tl_status']."</span";
                          }
                        ?>
                        <tr>
                          <td><?php echo $no."."; ?></td>
                          <td><?php echo $baris['tl_deskripsi'];?></td>
                          <td><center><?php $tgl = explode("-", $baris['tl_tgl']); echo $tgl[2]."-".$tgl[1]."-".$tgl[0]; ?></center></td>
                          <td><?php if($baris['tl_tanggapan_kirim']=="Y"){echo $baris['tl_tanggapan'];}else{echo "<center>-</center>";} ?></td>
                          <td>
                            <?= "<center>".$status."</center>"; ?>
                          </td>
                          <td><?php $tgl_s = explode("-", $baris['tl_status_tgl']); echo $tgl_s[2]."-".$tgl_s[1]."-".$tgl_s[0];?></td>
                          
                        </tr>
                        <?php $no++; } ?>
                      </tbody>
                    </table>
                    </div>
                    <br>
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
    <script type="text/javascript">
      $('#myDatepicker').datetimepicker({
        format: 'YYYY-MM-DD' });
    </script>
    <script type="text/javascript">
      $("#bt-remove").on("click", function(){
        $("#forpesan").remove();
      });
    </script>
    <script type="text/javascript">
      $('#datatable').dataTable( {
          "paging": false,
          "searching": false,
          "ordering": false,
          "bLengthChange": false

      } );
    </script>