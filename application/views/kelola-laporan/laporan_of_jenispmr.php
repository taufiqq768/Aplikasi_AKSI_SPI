<title>PTPN XII | Laporan Berdasarkan Pemeriksaan</title>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
  
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Laporan Berdasarkan Status</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <!-- <li><a href="daftar_pmr.php"><button type="button" class="btn btn-default btn-xs">Tambah Pemeriksaan</button></a></li> -->
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                   <?php 
                   //var_dump($this->model_app->select_tabel($jenis)->result_array());
                   $ket = '';
                     if ($this->session->flashdata()==null) {
                       echo '';
                     }else{
                     echo "<div class='alert alert-danger' role='alert' id='forpesan'><center><strong><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('gagal')."</strong><a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></center></a></div>";
                     }
                           ?>
                      <?php $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);?>
                  <div class="x_content">
                    <?php  
                      $attributes = array('class'=>'form-horizontal','role'=>'form');
                      echo form_open('laporan/cari_laporan',$attributes);
                    ?>
                   <?php $this->load->view('kelola-laporan/pencarian_laporan'); ?>
                    <?php echo form_close(); ?>
                    <br>
                    <?php //print_r($record);
                    if ($record!=null) {
                      $judul = $this->model_app->view_profile('tb_pemeriksaan', array('pemeriksaan_id'=> $record[0]['pemeriksaan_id']))->row_array();
                    }
                   
                    ?>
                    <?php if ($record!=null) { ?>
                    <center><h4><strong>Daftar Monitoring Tindak Lanjut <br>Jenis Pemeriksaan : 
                     <?php echo $jenis; ?>
                    </strong></h4></center><?php }else{ ?>
                      <center><h4><strong>Tidak Ada Data untuk Pemeriksaan <br><?php echo "- ".$jenis." -"; ?><br><?php echo $bidang; ?></strong></h4></center> 
                    <?php } ?>
                    <div class="table-responsive">
                      <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Pemeriksaan</th>
                          <th>Tanggal</th>
                          <th>Unit</th>
                          <th style="width: 75px">Bidang</th>
                          <th style="width: 75px">Obyek Pemeriksaan</th>
                          <th style="width: 300px">Hasil Temuan</th>
                          <th style="width: 150px">Rekomendasi</th>
                          <th style="width: 100px">Status</th>
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
                            echo "<th style='width: 250px'>Tindak Lanjut ".$n."</th>
                                  <th style='width: 100;px'>Tanggapan<br> TL ".$n."</th>";
                            $n.="I";      
                          }
                          ?>
                          <!-- <th style="width: 150px">Tindak<br>Lanjut I</th>
                          <th style="width: 100px">Tanggapan<br> TL I</th>
                          <th style="width: 150px">Tindak Lanjut II</th>
                          <th style="width: 100px">Tanggapan<br> TL II</th>
                          <th style="width: 150px">Tindak Lanjut III</th>
                          <th style="width: 100px">Tanggapan<br> TL III</th> -->
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        $no = 1;
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
                        ?>
                        <tr>
                          <td><?php echo $no."."; ?></td>
                          <td><?php echo $value['pemeriksaan_judul']; ?></td>
                          <td><?php $tgl = explode("-", $value['pemeriksaan_tgl']); echo $tgl[2]."-".$tgl[1]."-".$tgl[0];?></td>
                          <td><?php echo $unit['unit_nama'] ?></td>
                          <td><?php echo $bidang['bidangtemuan_nama'] ?></td>
                          <td><?php echo $value['temuan_obyek'] ?></td>
                          <td><?php echo $value['temuan_judul']; ?></td>
                          <td><?php echo $value['rekomendasi_judul']; ?></td>
                           <td><center><span class="<?php echo $btn_class ?>"><?php echo $value['rekomendasi_status']; ?></span></center></td>
                         
                            <?php $tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id = '$value[rekomendasi_id]' AND tl_publish_spi='Y'")->result_array(); 
                            for ($i=0; $i < count($tl) ; $i++) { ?>
                            <td>
                             <?php if ($tl[$i]['tl_deskripsi']!=null) {
                               echo $tl[$i]['tl_deskripsi'];
                             }else{
                              echo "<center>-</center>";
                             } ?>
                             <td><?php if ($tl[$i]['tl_tanggapan']!=null) {
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
                            echo "<td><center>-</center></td>";
                          } ?>
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
        $('#exportexcel').hide();
        $('#form-kebun').hide();
        $('#form-pilihkebun').hide();
        $('#bidang').hide();
      }(window.jQuery);
    </script>

    <script type="text/javascript">
      $('#jenis').change(function(){
        if ($('#jenis').val()=="semua") {
          $('#rentang').hide();
          $('#pemeriksaan').hide();
          $('#status').hide();
          $('#jenis_pmr').hide();
          $('#exportexcel').show();
          $('#form-kebun').hide();
          $('#form-pilihkebun').hide();
          $('#bidang').show();
        }else if($('#jenis').val()=="status"){
          $('#rentang').show();
          $('#pemeriksaan').hide();
          $('#status').show();
          $('#jenis_pmr').hide();
          $('#exportexcel').show();
          $('#form-kebun').hide();
          $('#form-pilihkebun').hide();
          $('#bidang').show();
        }else if($('#jenis').val()=="pemeriksaan"){
          $('#rentang').hide();
          $('#pemeriksaan').show();
          $('#status').hide();
          $('#jenis_pmr').hide();
          $('#exportexcel').show();
          $('#form-kebun').hide();
          $('#form-pilihkebun').hide();
          $('#bidang').show();
        }else if($('#jenis').val()=="jenispmr"){
          $('#rentang').hide();
          $('#pemeriksaan').hide();
          $('#status').hide();
          $('#jenis_pmr').show();
          $('#exportexcel').show();
          $('#form-kebun').hide();
          $('#form-pilihkebun').hide();
          $('#bidang').show();
        }else if($('#jenis').val()=="perkebun"){
          $('#rentang').hide();
          $('#pemeriksaan').hide();
          $('#status').hide();
          $('#jenis_pmr').hide();
          $('#exportexcel').show();
          $('#form-kebun').show();
          $('#form-pilihkebun').hide();
          $('#bidang').show();
        }else{
          $('#bidang').show();
          $('#rentang').hide();
          $('#pemeriksaan').hide();
          $('#status').hide();
          $('#jenis_pmr').hide();
          $('#exportexcel').hide();
          $('#form-kebun').hide();
          $('#form-pilihkebun').hide();
        }
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
