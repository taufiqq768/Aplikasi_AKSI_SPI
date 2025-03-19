  <title>AKSI | Tambah Pemeriksaan </title>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Daftar Pemeriksaan </h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Form Pemeriksaan <small></small></h2>
                  <ul class="nav navbar-right panel_toolbox">&nbsp;                       
                    <li><a class="close-link"><i class=""></i></a>
                    </li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                  <?php $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);?>
                  <?php 
                    $attributes = array('class'=>'form-horizontal','role'=>'form', 'id'=>'demo-form2');
                    echo form_open_multipart('administrator/daftar_pmr',$attributes);
                  ?>
                  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="pkpt" class="form-control" name="pkpt" required>
                          <option selected>Pilih</option>
                          <option value="pkpt">PKPT</option>
                          <option value="tidak">Tidak PKPT</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Pemeriksaan</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="heard" class="form-control" name="a" required>
                          <option selected>Pilih</option>
                          <option value="Rutin">Rutin</option>
                          <option value="Khusus">Khusus</option>
                          <option value="Tematik">Tematik</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Judul <span class="required ">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="judul_pmr" required="required" name="b" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Objek Audit</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="objek" class="form-control" name="objek" required>
                          <option selected>Pilih</option>
                          <option value="divisi">Divisi</option>
                          <option value="regional">Regional</option>
                          <option value="anper">Anak Perusahaan</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="data-result" class="form-control" name="c" required>
                            <option selected>Silakan pilih objek audit terlebih dahulu</option>
                        </select>
                      </div>
                    </div></br>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nomor Dokumen Surat Tugas <span class="required ">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="no_st" required="required" name="no_st" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Tanggal Dokumen Surat Tugas <span class="required ">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">                       
                          <div class="control-group">
                          <div class="controls">
                            <div class="input-prepend input-group">
                              <input type="text" name="tgl_st" id="tgl_st" class="form-control" />
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              </div>
                          </div>
                          </div>
                      </div>
                    </div>
                 </div>
                 <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Pengawas <span class="required ">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select name="pengawas" class="form-control" id="pengawas" required>
                      <option>Pilih Anggota DSPI</option> 
                        <?php 
                            foreach ($spi as $value) {
                              echo "<option value='$value[user_nik]'>$value[user_nama]</option>";
                        
                        }?>
                        </select>
                    </div>
                  </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ketua <span class="required ">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select name="ketua" class="form-control" id="ketua" required>
                        <option>Pilih Anggota DSPI</option>
                        <?php 
                            foreach ($spi as $value) {
                              echo "<option value='$value[user_nik]'>$value[user_nama]</option>";
                        
                        }?>
                        </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Anggota DSPI <span class="required ">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select name="d[]" class="select2_single form-control" multiple="multiple" id="anggota" required>
                        <?php 
                            foreach ($spi as $value) {
                              echo "<option value='$value[user_nik]'>$value[user_nama]</option>";
                        
                        }?>
                        </select>
                    </div>
                  </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-3">Tanggal Pemeriksaan <span class="required ">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">                       
                        <div class="control-group">
                        <div class="controls">
                          <div class="input-prepend input-group">
                            <input type="text" name="e" id="reservation" class="form-control" />
                            <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                            </div>
                        </div>
                        </div>
                     </div>
                   </div>
                 </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" enctype="multipart/form-data">Upload Dokumen Surat Tugas</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file" name="file_pmr" id="dokumen" accept=".jpg, .pdf, .xls, .xlsx, .doc, .docx, .odt, .png">
                        <p><strong>(Accepted : .jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx, .odt)</strong></p>
                        <p><strong>Max. size 20MB</strong></p>
                      </div>
                    </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <button type="submit" class="btn btn-success" name="submit" <?php  echo strpos($role[0]['role_akses'],',1,')!==FALSE?"":"disabled"; ?>>Submit</button></a>
                  </div>
                </div>
                <br/><br> 
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
    <!-- Select2 -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/select2/dist/js/select2.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
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
        $('#ketua, #pengawas, #anggota').select2({
          placeholder: "Pilih Petugas DSPI"
        });
      });
    </script>
    <script type="text/javascript">
      $('#tgl_st').datetimepicker({
        format: 'DD-MM-YYYY' });
    </script>
    <script>
  $(document).ready(function () {
    $("#objek").change(function () {
      const selectedValue = $("#objek").val();

      // Clear existing options in the result dropdown
      $("#data-result").html('<option selected>Loading...</option>');

      // Check if a valid option is selected
      if (selectedValue) {
        $.ajax({
          url: "<?= site_url('administrator/get_data') ?>", // URL ke controller method
          method: "POST",
          data: { objek: selectedValue },
          dataType: "json",
          success: function (response) {
            // Populate the data-result dropdown
            $("#data-result").html('<option selected>Pilih Data</option>');
            response.forEach(item => {
              $("#data-result").append(`<option value="${item.key}">${item.value}</option>`);
            });
          },
          error: function () {
            alert("Terjadi kesalahan saat mengambil data!");
          }
        });
      } else {
        $("#data-result").html('<option selected>Silakan pilih objek audit terlebih dahulu</option>');
      }
    });
  });
</script>