<title>AKSI | List Pemeriksaan</title>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
  
            <div class="row">
              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                    <?php  
                    //FORM UNTUK PENCARIAN DATA PEMERIKSAAN
                      $attributes = array('class'=>'form-horizontal');
                      echo form_open('administrator/cari_pemeriksaan',$attributes);
                    ?>
                      <div class="form-group col-lg-2">
                        <label>Jenis : </label>
                        <select class="form-control" name="jenis">
                          <option value="0">-Pilih Jenis-</option>
                          <option value="Rutin">Rutin</option>
                          <?php if ($this->session->level!="viewer"): ?>
                          <option value="Khusus">Khusus</option>
                          <option value="Penting">Tematik</option>
                          <?php endif ?>
                        </select>
                      </div>
                      <div class="form-group col-lg-2">
                        <label>Status : </label>
                        <select class="form-control" name="status">
                          <option value="0">-Pilih Status-</option>
                          <option value="Y">Aktif</option>
                          <option value="N">Non - Aktif</option>
                        </select>
                      </div>
                      <div class="form-group col-lg-3">
                        <label>Unit : </label>
                        <select class="form-control" name="unit">
                          <option value="">-Pilih Unit-</option>
                          <?php foreach ($unit as $k => $val): ?>
                            <option value="<?php echo $val['unit_id'] ?>"><?= $val['unit_nama']?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div id="tanyarentang">
                        <div class="form-group col-lg-2">
                          <label>Rentang Tanggal :</label>
                            <div class="radio">
                              <label>
                                <input type="radio" class=""  value='Y' name='waktu'> Ya &nbsp; &nbsp; &nbsp; &nbsp;
                                <input type="radio" class="" checked value='N' name='waktu'> Tidak
                              </label>
                            </div>
                        </div>
                      </div>
                      <div id="pakerentang">
                        <div class="form-group col-lg-3">
                          <label>Rentang Tanggal :</label>
                            <div class="control-group">
                              <div class="controls">
                                <div class="input-prepend input-group">
                                  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                  <input type="text" value="" name="rentang" id="reservation" class="form-control"  />
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                      &nbsp;
                      <br>
                      <div class="form-group col-lg-2">
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                      </div>
                    <?php echo form_close(); ?>
                  </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List Pemeriksaan<small>(Unit)</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                   <?php 
                   $ket = '';
                   $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
                     if ($this->session->flashdata('berhasil')!=null) {
                       echo "<div class='alert alert-success' role='alert' id='forpesan'><center><strong><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('berhasil')."</strong><a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></center></a></div>";
                     }
                    ?>
                  <div class="x_content">
                    <div style="overflow-x:auto;">
                    <table id="datatable" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th style="width: 12%">Jenis Audit</th>
                          <th>Nama Ketua</th>
                          <th>Nama Pengawas</th>
                          <th>Nama Anggota</th>
                          <th style="width: 25%">Judul</th>
                          <th>Unit</th>
                          <th>Tanggal</th>
                          <th>Status</th>
                          <?php if ($this->session->level=="admin"){ ?>
                          <th style="width: 17%">Action</th>  
                          <?php }else{ ?>
                          <th style="width: 10%">Action</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                         $no = 1; $number=1;
                        foreach ($record as $value) 
                        { 
                          if ($value['pemeriksaan_aktif']=='Y') {
                            $status = "Aktif";
                          }else{
                            $status = "Non-Aktif";
                          }
                        ?>
                        <?php if ($value['pemeriksaan_aktif']=='Y') {
                                 $placeholder = 'Non-Aktifkan';
                              }else{
                                $placeholder = 'Aktifkan';
                              } 
                        ?>
                        <tr>
                          <td><center><?php echo $no."."; ?></center></td>
                          <td><?php echo $value['pemeriksaan_jenis']; ?></td>
                          <?php 
                              $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $value['pemeriksaan_ketua']))->row_array();
                          ?>
                            <td><?php echo $usr['user_nama'] != 0 ? '-' : $usr['user_nama']; ?></td>
                          <?php 
                              $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $value['pemeriksaan_pengawas']))->row_array();
                          ?>
                          <td><?php echo $usr['user_nama'] != 0 ? '-' : $usr['user_nama']; ?></td>
                          <td><?php 
                           $select  = explode("/", $value['pemeriksaan_petugas']);
                           $nomer = 1;
                            foreach ($select as $nik) {
                              $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $nik))->row_array();
                              echo $nomer.". ".$usr['user_nama']."<br>";
                              $nomer++;
                            } ?>
                          </td>
                          <td><?php   echo "<a href='".base_url()."administrator/view_temuan/$value[pemeriksaan_id]' data-toggle='tooltip' data-placement='top' title='Lihat Detail Pemeriksaan'><u>" ?><?php echo $value['pemeriksaan_judul']; ?></u></a></td>
                          <td><?php echo $value['unit_nama']; ?></td>
                          <td><?php 
                              $mulai = explode("-", $value['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $value['pemeriksaan_tgl_akhir']);
                              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d <br>".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                            ?>
                          </td>
                          <?php 
                          $select  = explode("/", $value['pemeriksaan_petugas']);
                          $nama = [];
                            foreach ($select as $nik) {
                              $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $nik))->row_array();
                              $nama[] = $usr['user_nama'];
                            }
                            if ($this->session->level=="spi") {
                              if (in_array($this->session->username, $select)) {
                                $dis = "";
                              }else{
                                $dis = "disabled";
                              }
                            }else{
                             $dis = "";
                            }
                          ?>
                          <td>
                            <?php if ($this->session->level=="admin") { ?>
                            <center><?php   echo "<a href='".base_url()."administrator/status_pemeriksaan/$value[pemeriksaan_id]/$value[pemeriksaan_aktif]'"?><button type="button" class='btn btn-default btn-xs' data-toggle="tooltip" data-placement="top" title='<?php echo $placeholder ?>' <?php  echo strpos($role[0]['role_akses'],',2,')!==FALSE?"":"disabled"; ?> <?php echo $dis; ?>><?php echo $status;  ?></button></center></a>
                            <?php }else{
                              echo "<center>".$status."</center>";
                            } ?>
                          </td>
                          <?php if ($this->session->level!="viewer"): ?>
                          <td><?php   echo "<a href='".base_url()."administrator/input_spi/$value[pemeriksaan_id]'>" ?><button type="button" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Kelola Data Pemeriksaan" <?php  echo strpos($role[0]['role_akses'],',6,')!==FALSE?"":"disabled"; ?>>Kelola Data</button></a>  
                          <?php else: ?>
                          <td><?php   echo "<a href='".base_url()."administrator/view_temuan/$value[pemeriksaan_id]'>" ?><button type="button" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Lihat Data Pemeriksaan"> <i class="fa fa-external-link"></i> Lihat Data</button></a>
                          <?php endif ?>
                           <?php   echo "<a href='".base_url()."administrator/delete_pemeriksaan/$value[pemeriksaan_id]'>" ?>
                           <?php if ($this->session->level=="admin"): ?>
                           <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Hapus Pemeriksaan" onclick="return confirm('Apa anda yakin untuk hapus Data ini?')" <?php  echo strpos($role[0]['role_akses'],',7,')!==FALSE?"":"disabled"; ?> <?php echo $dis; ?>>Hapus</button></a>
                           <?php endif ?>
                          </td>
                        </tr>
                  <?php 
                  $no++; } ?>
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
    <!-- Sweet Alert -->
    <script src="<?php echo base_url(); ?>/asset/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript">
      $('#myDatepicker').datetimepicker({
        format: 'YYYY-MM-DD' });
    </script>
    <script type="text/javascript">
      $('#bt-remove').on('click', function(){
        $('#forpesan').remove();
      });
    </script>
    <script type="text/javascript">
     !function ($) {
        document.getElementById('tanyarentang').value = 'N';
        $('#pakerentang').hide();
      }(window.jQuery);
    </script>
    <script>
    $('input[name="waktu"]:radio').change(function(){    
        var isi = this.value;
        if (isi == "N") {
          $('#pakerentang').hide();
        }else{
          $('#tanyarentang').hide();
          $('#pakerentang').show();
        }
    });
    </script>
      <script type="text/javascript">
        <?php if ($this->session->flashdata('gagal')!=null) { ?>
        swal("Gagal!", "Sudah ada Tindak Lanjut pada pemeriksaan ini!", "warning");
        <?php } ?>
      </script>
    
