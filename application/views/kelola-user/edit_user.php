<title>PTPN XII | Edit User</title>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Edit Informasi User</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Edit User <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <?php 
                  if ($this->session->flashdata('gagal')!=null) {
                     echo "<div class='alert alert-danger' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('gagal')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>"; 
                  }else{
                    echo "";
                  }
                  ?>
                  

                  <?php 
                    $attributes = array('class'=>'form-horizontal','role'=>'form', 'id'=>'demo-form');
                    echo form_open('administrator/edit_user/'.$this->uri->segment(3),$attributes);
                  ?>
                      <?php foreach ($record as $row) { 
                        echo "<div class='form-group'><input type='hidden' name='id' value='$row[user_nik]'></div>";
                      ?>
                      
                      <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">NIK <span class="required ">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="nik" required="required" name="nik" class="form-control col-md-7 col-xs-12" value="<?php echo $row['user_nik'] ?>">
                      </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama<span class="required ">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="nama" required="required" name="nama" class="form-control col-md-7 col-xs-12" value="<?php echo $row['user_nama'] ?>">
                          <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="judul_pmr" name="email" class="form-control col-md-7 col-xs-12" value="<?php echo $row['user_email'] ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Password</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" name="password" class="form-control col-md-7 col-xs-12" id="password">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Konfirmasi Password</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" name="confirm_password" class="form-control col-md-7 col-xs-12" id="confirm_password">
                        </div>
                        <span id='message'></span>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">Must Change Password</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div class="radio">
                            <label>
                              <input type="radio" class="flat" checked value='1' name='ganti'> Tidak
                      
                              <input type="radio" class="flat" value='0' name='ganti'> Ya
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Unit</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="unit" class="select2_single form-control" name="unit" required>
                          <!-- <option value="<?php //echo $row['role_id']?>"><?php  //echo $row['role_nama']; ?></option> -->
                          <?php foreach ($record3 as $key => $value) { ?>
                          <option value='<?php echo $value['unit_id'];?>' <?php  if($value['unit_id']==$row['unit_id']) echo "selected"; ?>> <?php echo $value['unit_nama']?></option>";
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                       <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Level</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select id="heard" class="form-control" name="level" required>
                                <option value="admin" <?php if ($row['user_level']=="admin") {echo "selected";}?>>Admin</option>
                                <option value="administrasi" <?php if ($row['user_level']=="administrasi") {echo "selected";}?>>Admin (administrasi)</option>
                                <option value="spi" <?php if ($row['user_level']=="spi") {echo "selected";}?>>Petugas SPI</option>
                                <option value="kabagspi" <?php if ($row['user_level']=="kabagspi") {echo "selected";}?>>Kabag SPI</option>
                                <option value="verifikator" <?php if ($row['user_level']=="verifikator") {echo "selected";}?>>Verifikator</option>
                                <option value="operator" <?php if ($row['user_level']=="operator") {echo "selected";}?>>Operator</option>
                                <option value="viewer" <?php if ($row['user_level']=="viewer") {echo "selected";}?>>Viewer</option>
                              </select>
                            </div>
                          </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Role</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="heard" class="form-control" name="role" required>
                          <!-- <option value="<?php //echo $row['role_id']?>"><?php  //echo $row['role_nama']; ?></option> -->
                          <?php foreach ($record2 as $key => $value) { ?>
                          <option value='<?php echo $value['role_id'];?>' <?php  if($value['role_id']==$row['role_id']) echo "selected"; ?>> <?php echo $value['role_nama']?></option>";
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                        <?php } ?>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success" name="edit">Submit</button></a>
                        </div>
                      </div>

                      <?php echo form_close(); ?>
                    <!-- end form for validations -->

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
        $('#unit').select2({
          placeholder: "Pilih Unit"
        });
      });
    </script>
    <script type="text/javascript">
      $('#myDatepicker').datetimepicker({
        format: 'YYYY-MM-DD' });
    </script>
    <script type="text/javascript">
      $('#confirm_password').on('keyup', function(){
          if ($('#password').val() == $('#confirm_password').val()) {
        $('#message').html('Password cocok').css('color', 'green');
          // alert('Matching'+$('#password').val()+" "+$('#confirm_password').val());
      } else
      // alert('NOT Matching'+$('#password').val()+" "+$('#confirm_password').val()); 
        $('#message').html('Password tidak cocok ! ').css('color', 'red');
    
      })
      
  </script>
  <script type="text/javascript">
    $("#bt-remove").on('click' , function () {
          $('#forpesan').remove();
        });
  </script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
  </body>
</html>
