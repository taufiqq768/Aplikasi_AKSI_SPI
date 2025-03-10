<title>PTPN XII | Edit User</title>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Edit Data PKPT</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Edit PKPT <small></small></h2>
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
                    echo form_open('administrator/edit_pkpt/'.$this->uri->segment(3),$attributes);
                  ?>
                      <?php 
                      foreach ($pkpt as $row) { 
                        echo "<div class='form-group'><input type='hidden' name='id_pkpt' value='$row[pkpt_id]'></div>";
                      ?>
                      
                      <div class="form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Audit</label>
                   <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="audit" class="form-control" name="audit" required>
                            <option selected>Pilih Jenis Audit</option>
                            <option value="Rutin"  <?php if ($row['jenis_audit']=="Rutin") {echo "selected";}?>>Rutin</option>
                            <option value="Khusus"  <?php if ($row['jenis_audit']=="Khusus") {echo "selected";}?>>Khusus</option>
                            <option value="Tematik"  <?php if ($row['jenis_audit']=="Tematik") {echo "selected";}?>>Tematik</option>
                        </select>
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Bulan</label>
                   <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="bulan" class="form-control" name="bulan" required>
                            <option selected>Pilih Bulan</option>
                            <option value="Januari" <?php if ($row['bulan']=="Januari") {echo "selected";}?>>Januari</option>
                            <option value="Februari" <?php if ($row['bulan'] == "Februari") { echo "selected"; } ?>>Februari</option>
                            <option value="Maret" <?php if ($row['bulan'] == "Maret") { echo "selected"; } ?>>Maret</option>
                            <option value="April" <?php if ($row['bulan'] == "April") { echo "selected"; } ?>>April</option>
                            <option value="Mei" <?php if ($row['bulan'] == "Mei") { echo "selected"; } ?>>Mei</option>
                            <option value="Juni" <?php if ($row['bulan'] == "Juni") { echo "selected"; } ?>>Juni</option>
                            <option value="Juli" <?php if ($row['bulan'] == "Juli") { echo "selected"; } ?>>Juli</option>
                            <option value="Agustus" <?php if ($row['bulan'] == "Agustus") { echo "selected"; } ?>>Agustus</option>
                            <option value="September" <?php if ($row['bulan'] == "September") { echo "selected"; } ?>>September</option>
                            <option value="Oktober" <?php if ($row['bulan'] == "Oktober") { echo "selected"; } ?>>Oktober</option>
                            <option value="November" <?php if ($row['bulan'] == "November") { echo "selected"; } ?>>November</option>
                            <option value="Desember" <?php if ($row['bulan'] == "Desember") { echo "selected"; } ?>>Desember</option>
                        </select>
                   </div>
                 </div>
                   <div class="form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah<span class="required ">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                       <input type="text" id="jumlah" required="required" name="jumlah" class="form-control col-md-7 col-xs-12" value="<?php echo $row['jumlah'] ?>">
                     </div>
                   </div>
                <?php } ?>
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
