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
                    <h2>List KKA KADIV</h2>
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
                          <th>Kondisi</th>
                          <th>Penyebab</th>
                          <th style="width: 20%">Unit</th>
                          <th>Tanggal Pemeriksaan Audit</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no=1;
                        foreach ($record as $row) { 
                        ?>
                        <tr>
                          <td><?php echo $no; ?></td>
                          <td><?php echo !empty($row['kka_kondisi']) ? $row['kka_kondisi'] : 'Belum ada data'; ?></td>
                          <td><?php echo !empty($row['kka_penyebab']) ? $row['kka_penyebab'] : 'Belum ada data'; ?></td>
                          <td><?php echo $row['unit_nama']; ?></td>
                          <td><?php echo $row['pemeriksaan_tgl_mulai']."-".$row['pemeriksaan_tgl_akhir']; ?></td>
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
    
