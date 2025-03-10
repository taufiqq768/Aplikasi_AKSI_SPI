<title>PTPN XII | List Tindak Lanjut </title>

      <!-- page content -->
     <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Pemeriksaan Regional</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>
                    <a href="<?php echo base_url(); ?>administrator/list_pmr_verifikator"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-mail-reply"></i></button></a>
                    List Tindak Lanjut <small>(Verifikator)</small>
                  </h2>
                  <ul class="nav navbar-right panel_toolbox">&nbsp;   
                    <?php $id_pmr = $this->uri->segment(3);$id_temuan = $this->uri->segment(4); $id_rekom = $this->uri->segment(5);?>
                    <?php $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);?>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <?php if ($this->session->flashdata('berhasil')!=null) {
                    echo "<div class='alert alert-success' role='alert' id='forpesan'><em class='fa fa-lg fa-check-circle-o'>&nbsp;</em>".$this->session->flashdata('berhasil')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                  }
                  if ($this->session->flashdata('kembalikan_tl')!=null) {
                    echo "<div class='alert alert-success' role='alert' id='forpesan'><em class='fa fa-lg fa-check-circle-o'>&nbsp;</em>".$this->session->flashdata('kembalikan_tl')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                  } ?>
                  <form id="demo-form2" action="list_pemeriksaan.php" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <table class="table table-responsive">
                          <?php foreach ($record2 as $baris) { 
                            $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $baris['bidangtemuan_id']))->row_array();
                            if ($baris['rekomendasi_status']=="Sudah di Tindak Lanjut") {
                              $btn_class = 'btn btn-xs btn-round btn-success';
                            }elseif($baris['rekomendasi_status']=="Sudah TL (Belum Optimal)"){
                              $btn_class = 'btn btn-xs btn-round btn-warning';
                            }elseif ($baris['rekomendasi_status']=="Belum di Tindak Lanjut") {
                              $btn_class = 'btn btn-xs btn-round btn-danger';
                            }else{
                              $btn_class = 'btn btn-xs btn-round btn-info';
                            }
                          ?>
                          <tr>
                            <th style="width: 15%">Pemeriksaan</th>
                            <td>: <?php echo $baris['pemeriksaan_judul']; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Bidang</th>
                            <td>: <?php echo $bidang['bidangtemuan_nama']; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Temuan</th>
                            <td>: <?php echo $baris['temuan_judul']; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Rekomendasi</th>
                            <td>:  <?php echo $baris['rekomendasi_judul']; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Dokumen Rekomendasi</th>
                            <td>
                              <?php 
                              $dokumen = $this->model_app->view_where_ordering('rekomendasi_id','tb_upload_rekom',$id_rekom,'uploadrekom_id','ASC'); 
                              if (empty($dokumen)) {
                                echo ":  -";
                              }
                                foreach ($dokumen as $key => $value) { ?>
                                  <a target="_BLANK" title="Lihat Data" href="<?php echo base_url(); ?>/asset/file_rekomendasi/<?php echo $value['uploadrekom_nama']?>"><?php echo "- ".$value['uploadrekom_nama']."<br>"; 
                                }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Status Rekomendasi</th>
                            <td>
                              : <span class="<?php echo $btn_class ?>"><?php echo $baris['rekomendasi_status']; ?></span>
                            </td>
                          </tr>
                        <?php }?>
                        </table>
                        
                        <!-- setting disable untuk pemeriksaan sebelumnya jika ada data yang terbawa ke pemeriksaan baru-->
                        <?php 
                         $disable = '';
                         $countpmr = [];
                         $ambilpmr = $this->db->query("SELECT pemeriksaan_sebelumnya FROM tb_pemeriksaan")->result_array();
                         foreach ($ambilpmr as $key => $value) {
                            $explode = explode(" ", $value['pemeriksaan_sebelumnya']);
                            foreach ($explode as $k => $val) {
                              $countpmr[] = $val;
                            }
                          } 
                          // print_r($countpmr);
                          if (in_array($id_pmr, $countpmr)) {
                            $disable = "disabled";
                          }
                        ?>
                        <div class="table-responsive">
                          <table id="datatable" class="table table-bordered">
                            <thead>
                              <th style="width: 20px">No.</th>
                              <th style="width: 250px"><center>Tindak Lanjut</center></th>
                              <th style="width: 200px"><center>Tanggapan</center></th>
                              <th style="width: 200px"><center>Dokumen</center></th>
                              <th style="width: 70px">Tanggal</th>
                              <th style="width: 85px">Keterangan Kirim</th>
                              <th style="width: 180px"><center>Action</center></th>
                            </thead>
                            </thead>
                            <tbody>
                              <?php 
                             $no = 1;
                              $id_rekom = $this->uri->segment(5);
                              foreach ($record as $row) { 
                              if ($row['tl_publish_spi']=='Y') {
                                $kirim = "Terkirim ke SPI";
                              }elseif($row['tl_status_from_spi']=='Y'){
                                $kirim = "Dikembalikan oleh SPi";
                              }else{$kirim = "Belum Terkirim";}
                              ?>
                              <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $row['tl_deskripsi']; ?></td>
                                <td>
                                  <?php if ($row['tl_tanggapan']!=null){
                                    echo $row['tl_tanggapan'];
                                  }else{
                                    echo "<center>-</center>";
                                  } ?>
                                </td>
                                <td>
                                  <?php $hot = $this->model_app->view_where_ordering('tl_id','tb_upload_tl',$row['tl_id'],'uploadtl_id','ASC');
                                  $this->load->helper('directory'); 
                                  $map = directory_map('asset');
                                    foreach ($hot as $value) {
                                      // $nama = echo $value['uploadtl_nama'];
                                      echo "-";?><a target="_BLANK" title="Lihat Data" href="<?php echo base_url(); ?>/asset/file_tl/<?php echo $value['uploadtl_nama']?>"><?php echo $value['uploadtl_nama']; ?></a> <br>
                                    <?php }
                                  ?>

                                </td>
                                <td><?php $tgl = explode("-", $row['tl_tgl']);  echo $tgl[2]."-".$tgl[1]."-".$tgl[0]; ?></td>
                                <td><?php echo $kirim; ?></td>
                                <td>
                                  <?php if ($row['tl_publish_spi']=='N') { ?>
                                  <div class="form-group">
                                  <?php   echo "<a href='".base_url()."administrator/tl_sendto_spi/$id_pmr/$id_temuan/$id_rekom/$row[tl_id]'>" ?><button type="button" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Kirim ke SPI" <?php  echo strpos($role[0]['role_akses'],'13')!==FALSE?"":"disabled"; echo $disable; ?>><span class="fa fa-send"></span></button></a>
                                  <?php   echo "<a href='".base_url()."administrator/edit_tl_verifikator/$id_pmr/$id_temuan/$id_rekom/$row[tl_id]'>" ?><button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Lihat Data Tindak Lanjut" <?php  echo strpos($role[0]['role_akses'],'13')!==FALSE?"":"disabled"; echo $disable; ?>><span class="fa fa-edit"></span> Lihat TL</button></a>
                                  <?php   echo "<a href='".base_url()."administrator/delete_tl/$id_pmr/$id_temuan/$id_rekom/$row[tl_id]'"?><button type="button" class="btn btn-danger btn-xs" onclick="return confirm('Apa anda yakin untuk hapus Tindak Lanjut ini?')" data-toggle="tooltip" data-placement="top" title="Hapus Tindak Lanjut" <?php  echo strpos($role[0]['role_akses'],'14')!==FALSE?"":"disabled"; echo $disable; ?>><span class="fa fa-trash"></span> Hapus</button></a>
                                </div>
                                 <?php }else{ echo "<center>-</center>";} ?>
                              </td>
                            </tr>
                            <?php $no++; } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
               <!--  <div class="form-group">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  <a href="input_operator2.php"><button type="button" class="btn btn-primary pull-right">Kembali</button></a>
                  </div>
                </div> -->
                    </div>
                  </form>
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
      $('#datatable').dataTable( {
          "scrollX": true,
          "ordering": false,
          "searching": false,
          "bLengthChange": false 
      });
    </script>
    <script type="text/javascript">
      $('#myDatepicker').datetimepicker({
        format: 'YYYY-MM-DD' });
    </script>
    <script type="text/javascript">
      $("#bt-remove").on('click', function(){
        $('#forpesan').remove();
      });
    </script>