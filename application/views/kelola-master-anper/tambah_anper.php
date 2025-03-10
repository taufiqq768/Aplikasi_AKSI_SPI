<title>PTPN XII | Tambah Master COSO </title>

<!-- page content -->
     <div class="right_col" role="main">
       <div class="">
         <div class="page-title">
           <div class="title_left">
             <h3>Tambah Data Anak Perusahaan PTPN I</h3>
              <?php //if ($pesan!='') {
                    //echo "<center><h4>".$pesan."</h4></center>";}  ?>
           </div>
         </div>
         <div class="clearfix"></div>
         <div class="row">
           <div class="col-md-10 col-sm-10 col-xs-12">
             <div class="x_panel">
                 <div class="x_title">
                   <h2><a href="<?php echo base_url(); ?>administrator/list_anper"><button type="button" class="btn btn-default btn-xs"><i class="fa fa-mail-reply"></i></button></a>
                     Form Master Anak Perusahaan PTPN I <small></small></h2>
                   <ul class="nav navbar-right panel_toolbox">
                     <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                     </li>
                   </ul>
                   <div class="clearfix"></div>
                 </div>
                 <div class="x_content">
                    <br />
                   
                 <?php 
                   if ($this->session->flashdata('x')!=null) {
                      echo "<div class='alert alert-danger' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em><b>".$this->session->flashdata('x')."</b><a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                   }
                   $attributes = array('class'=>'form-horizontal','role'=>'form', 'id'=>'demo-form2');
                   echo form_open('administrator/input_anper',$attributes);
                 ?>
                   <div class="form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama Anak Perusahaan <span class="required ">*</span></label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                       <input type="text" id="anper" required="required" name="anper" class="form-control col-md-7 col-xs-12" value="<?php echo set_value('anper'); ?>">
                     </div>
                   </div>
                     <?php 
                         echo "<span class='red' id='pesan'>".$this->session->flashdata('gagal')."</span>"; ?>
                       <span id='message'></span>
                   </div>
               <div class="ln_solid"></div>
               <div class="form-group">
                 <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                   <button class="btn btn-primary" type="reset">Reset</button>
                   <button type="submit" class="btn btn-success" name="submit">Submit</button></a>
                 </div>
               </div>
               <?php echo form_close(); ?>
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
   $("#bt-remove").on('click' , function () {
         $('#forpesan').remove();
       });
 </script>
 </body>
</html>
