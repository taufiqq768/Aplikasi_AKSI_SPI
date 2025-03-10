  <title>AKSI | Detail Tindak Lanjut </title>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <!-- <div class="title_left">
              <h3>Detail Tindak Lanjut</h3> -->
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>
                    <?php 
                      $id_pmr = $this->uri->segment(3);$id_temuan = $this->uri->segment(4); $id_rekom = $this->uri->segment(5);
                      echo "<a href='".base_url()."administrator/view_temuan/$id_pmr'"?>
                      <button class="btn btn-xs btn-default" type="button"><i class="fa fa-mail-reply"></i></button>
                      </a>
                    Detail Tindak Lanjut</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <?php $id_tl = $this->uri->segment(6); 
                  $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
                  ?>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                        <!-- <table class="table table-responsive tile-info"> -->
                        <table class="table table-responsive table-bordered">
                          <?php foreach ($record as $value) { 
                             $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $value['bidangtemuan_id']))->row_array();
                          ?>
                          <tr>
                            <th style="width: 15%">Pemeriksaan</th>
                            <td>:  <?php echo $value['pemeriksaan_judul']; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Bidang</th>
                            <td>:  <?php echo $bidang['bidangtemuan_nama']; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Obyek Pemeriksaan</th>
                            <td>:  <?php echo $value['temuan_obyek']; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Temuan</th>
                            <td>:  <?php echo $value['temuan_judul']; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Rekomendasi</th>
                            <td>:  <?php echo $value['rekomendasi_judul']; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Tanggapan Manajer</th>
                            <td>: 
                              <?php
                              $tanggapan = $this->db->query("SELECT * FROM tb_tanggapan WHERE rekomendasi_id = $value[rekomendasi_id]")->row_array();
                              if ($tanggapan!=null) {
                                echo $tanggapan['tanggapan_deskripsi']."<br>&nbsp;&nbsp;<i>Ditanggapi pada ";
                                $tgl = explode("-", $tanggapan['tanggapan_tgl']);
                                echo $tgl[2]."-".$tgl[1]."-".$tgl[0]."</i>";
                              }else{
                                echo "-";
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Tindak Lanjut</th>
                            <td>: <?php echo $value['tl_deskripsi']; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Tgl. Tindak Lanjut</th>
                            <td>:  <?php $tgl = explode("-", $value['tl_tgl']); echo $tgl[2]."-".$tgl[1]."-".$tgl[0]; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Status Tindak Lanjut</th>
                            <td>: <?php echo $value['tl_status']; ?></td>
                          </tr>
                          
                          <?php } ?>
                        </table>
                        </div>
                      </div>
                  <hr>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                   <div class="table-responsive">
                      <table class="table table-bordered tabel-striped">
                        <thead>
                          <th style="width: 5%">No.</th>
                          <th style="width: 60%">File Tindak Lanjut</th>
                          <th style="width: 15%">Tgl. Upload</th>
                         
                        </thead>
                        <tbody>
                          <?php 
                          $no =1;
                          foreach ($record2 as $baris) { ?>
                          <tr>
                            <td><?php echo $no."."; ?></td>
                            <td><a target="_BLANK" title="Lihat Data" href="<?php echo base_url(); ?>/asset/file_tl/<?php echo $baris['uploadtl_nama']?>"><?php echo $baris['uploadtl_nama']; ?></a></td>
                            <td><?php 
                            $tgl = explode("-", $baris['uploadtl_tgl']);
                            echo $tgl[2]."-".$tgl[1]."-".$tgl[0];
                            ?>
                              
                            </td>
                          </tr>
                          <?php $no++; } ?>
                        </tbody>
                      </table>
                      </div>
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
    <script type="text/javascript">
      $('#myDatepicker').datetimepicker({
        format: 'YYYY-MM-DD' });
    </script>