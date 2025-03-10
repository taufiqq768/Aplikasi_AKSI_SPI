  <title>PTPN XII | Edit Profile </title>

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
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Foto Profile</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <?php
                     if ($this->session->flashdata('berhasil')!=null) {
                        echo "<div class='alert alert-success' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('berhasil')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                     }else{
                        echo '';
                     }
                     ?>
                    <!-- start form for validation -->
                  <?php 
                    $attributes = array('class'=>'form-horizontal','role'=>'form');
                    echo form_open_multipart('administrator/edit_profile/'.$this->uri->segment(3),$attributes); 
                        
                        foreach ($record as $row) { 
                  ?>
                  <div class="profile_img">
                    <div id="crop-avatar">
                      <!-- Current avatar -->
                      <center><img height="200" class="avatar-view" <?php if ($row['user_foto']!=null) { ?>src="<?php echo base_url(); ?>asset/foto_user/<?php echo $row['user_foto'] ?>"<?php }else{ ?>src="<?php echo base_url() ?>/asset/images/user.png"<?php } ?> title="Ganti Foto"></center><br>
                      <center><button type="button" class="btn btn-sm btn-default" id="upfile1" style="cursor: pointer;"><i class="fa fa-cloud-upload"></i> Ganti Foto&nbsp;</button></center>
                      <input type="file" name="file" id="file1" class="form-control" style="display: none" /><center><span id="namafile"></span></center>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="x_panel">
                  <div class="x_title">

                    <h2>Form Edit Profile <small></small></h2>
                    <!-- <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul> -->
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php 
                     
                        echo "<input type='hidden' name='id' value=$row[user_nik]>";
                  ?>
                      
                      <label for="fullname">NIK * :</label>
                      <input type="text" class="form-control" readonly="readonly" name="nik" value="<?php echo $row['user_nik'] ?>" /><br>  
                      <label for="fullname">Nama Lengkap * :</label>
                      <input type="text" id="fullname" class="form-control" name="nama_user" value="<?php echo $row['user_nama'] ?>" />
                        <br>  
                      <label for="email">Email * :</label>
                      <input type="email" id="email" class="form-control" name="email_user" data-parsley-trigger="change" value="<?php echo $row['user_email'] ?>" />
                      <br>  
                       <label for="email">No. HP/ Telp. :</label>
                      <input type="text" class="form-control" name="tlp_user" value="<?php echo $row['user_tlp'] ?>" />
                      <br><br>
                      
                      <button class="btn btn-success pull-right" type="submit" name="edit">Simpan Perubahan</button>
                      <?php   echo "<a href='".base_url()."captcha/reset_password/$row[user_nik]'>" ?><button type="button" id="reset_pass" class="btn btn-danger pull-right">Reset Password</button></a>
                      <button type="reset" class="btn btn-primary pull-right">Reset</button>
                      <?php } ?>
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
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/dropzone/dist/min/dropzone.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/iCheck/icheck.min.js"></script>
<!-- jquery.inputmask -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap-datetimepicker -->    
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<!-- bootstrap-wysiwyg -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/google-code-prettify/src/prettify.js"></script>
<!-- jQuery Tags Input -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
<!-- Switchery -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/switchery/dist/switchery.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/select2/dist/js/select2.full.min.js"></script>
<!-- Autosize -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/autosize/dist/autosize.min.js"></script>
<!-- jQuery autocomplete -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
<!-- starrr -->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/starrr/dist/starrr.js"></script>
<!-- Custom Theme Scripts -->
<script src="<?php echo base_url(); ?>/asset/gentelella/build/js/custom.min.js"></script> 

<!-- Initialize datetimepicker -->
<script>
  $('#myDatepicker').datetimepicker({
    format: 'DD/MM/YYYY  hh:mm A' });
</script>
<script type="text/javascript">
  $("#upfile1").click(function () {
    $("#file1").trigger('click');
  });

  $('#file1').on('change', function(){
    var nama_file = $('#file1').val();
    nama_file = nama_file.substr('12');
    $('#namafile').html(nama_file);
  });
</script>
<script type="text/javascript">
  var jumlah_form = 1;
  $(".add-more").on('click' , function () {
        // body...
        $(".tambah-form").append('<div class="txt-form'+jumlah_form+'"><label class="control-label col-md-3 col-sm-3 col-xs-12"></label><div class="input-group col-md-6 col-sm-6 col-xs-12"> <input type="text" class="form-control col-md-7 col-xs-12" name="rekom[]" ><span class="input-group-btn"><button type="button" class="btn btn-danger bt-remove" id="'+jumlah_form+'">Remove</button></span></div>');
        jumlah_form++;
        $(".bt-remove").on('click',function(){
          confirm("Apakah Anda yakin ingin Menghapus Rekomendasi?");
          $('.txt-form'+this.id).remove();
        }); 
      });
    </script>
    <script type="text/javascript">
    $("#bt-remove").on('click' , function () {
          $('#forpesan').remove();
        });
  </script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
  </body>
</html>
