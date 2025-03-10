  <title>PTPN XII | Reset Password </title>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="x_panel" id="formreset">
                  <div class="x_title">
                    <h2>Form Reset Password</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <!-- start form for validation -->
                   <?php 
                   if ($this->session->flashdata('gagal')!=null) {
                     echo "<div class='alert alert-danger' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('gagal')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>"; 
                  }elseif ($this->session->flashdata('lama')!=null) {
                      echo "<div class='alert alert-danger' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('lama')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                  }elseif ($this->session->flashdata('berhasil')!=null) {
                      echo "<div class='alert alert-success' role='alert' id='forpesan'><em class='fa fa-lg fa-check-circle-o'>&nbsp;</em>".$this->session->flashdata('berhasil')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                  }else{
                    echo "";
                  }
                   ?>
                  

                  <?php 
                    $attributes = array('class'=>'form-horizontal','role'=>'form');
                    echo form_open('captcha/reset_password/'.$this->uri->segment(3),$attributes); 
                    
                        foreach ($record as $row) { 
                        echo "<input type='hidden' name='id' value=$row[user_nik]>";
                  ?>
                      
                      <label>Password Lama :</label>
                      <input type="password" class="form-control" name="pass_lama" placeholder="Masukkan Password Lama" />
                      <br>  
                      <label for="email">Password Baru * :</label>
                      <input type="password" id="password" class="form-control" name="password" placeholder="Masukkan password baru" value="<?php echo set_value('password'); ?>"/><br> 
                      <label for="email">Konfirmasi Password Baru * :</label>
                      <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="Masukkan password baru" value="<?php echo set_value('confirm_password'); ?>" />
                      <span id='message'></span>
                      <br>
                      <label>Kode Captcha : </label>
                      <?php echo $cap_img;?>
                      <br><br>
                      <input type="text" name="kode_captcha" class="form-control" autocomplete="off" placeholder="Masukkan angka diatas" />
                      <br><br>
                      <button class="btn btn-primary pull-right" type="submit" name="submit">Simpan</button>
                      <?php   echo "<a href='".base_url()."administrator/edit_profile/$row[user_nik]'>"?><button class="btn btn-default pull-right" type="button">Kembali</button></a>
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
