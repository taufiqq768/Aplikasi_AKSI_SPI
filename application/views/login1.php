<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo base_url() ?>/asset/images/logo.png">
    <title>AKSI | Ubah Password</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- page content -->
        <div class="col-md-12">
          <div class="col-middle">
            <div class="text-center text-center">
              <h1 style="color: white">AKSI</h1>
              <?php $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $this->session->username))->row_array(); ?>
              <h2><?php echo $usr['user_nama']; ?></h2>
              <h4><?php echo $usr['user_nik']; ?></h4>
              <?php $nik = $this->uri->segment(3); ?>
              <h4 style="color: white">Silahkan ganti password untuk login user pertama kali</h4>
              <div class="mid_center">
                <?php 
                if ($this->session->flashdata('gagal')!=null) {
                  echo "<div class='alert alert-danger' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('gagal')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                }else{
                  echo "";
                }
                  
                ?>
                <?php 
                    $attributes = array('class'=>'form-horizontal');
                    echo form_open_multipart('administrator/login_satu/'.$this->uri->segment(3),$attributes); 
                    echo "<input type='hidden' name='id' value='$usr[user_nik]'/>";
                ?>
                  <div>
                    <label style="color: lightgrey">Password Baru : </label>
                    <input type="password" class="form-control" placeholder="Masukkan password baru" required="" id="password" name="password" />
                  </div>
                  <br>
                  <div>
                    <label style="color: lightgrey">Konfirmasi Password Baru :</label>
                    <input type="password" class="form-control" placeholder="Masukkan ulang password" required="" id="confirm_password" name="confirm_password" />
                  </div>
                  <span id='message'></span>
                  <br>
                  <br>
                  <div>
                    <a href="<?php echo base_url(); ?>administrator"><button type="button" class="btn btn-default">Kembali</button></a>
                     <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/nprogress/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/build/js/custom.min.js"></script>
    <script type="text/javascript">
      $('#confirm_password').on('keyup', function(){
          if ($('#password').val() == $('#confirm_password').val()) {
        $('#message').html('Password cocok').css('color', 'lightgreen');
          // alert('Matching'+$('#password').val()+" "+$('#confirm_password').val());
      } else
      // alert('NOT Matching'+$('#password').val()+" "+$('#confirm_password').val()); 
        $('#message').html('Password tidak cocok ! ').css('color', 'yellow');
    
      })
      
  </script>
  <script type="text/javascript">
    $("#bt-remove").on('click' , function () {
          $('#forpesan').remove();
        });
  </script>
  </body>
</html>