<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="icon" href="images/favicon.ico" type="image/ico" /> -->
    <link rel="shortcut icon" href="<?php echo base_url() ?>/asset/images/logo.png">
    <title>AKSI | Lupa Password</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/animate.css/animate.min.css" rel="stylesheet">

   <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>asset/gentelella/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <?php if ($this->session->flashdata('berhasil')!=null) {
                   echo "<div class='alert alert-success' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('berhasil')."<a href=''' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                }elseif ($this->session->flashdata('unregistered')!=null) {
                   echo "<div class='alert alert-danger' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('unregistered')."<a href=''' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                }else{
                   echo '';
                } ?>
          <section class="login_content">
            <form method="post" action="<?php echo base_url(); ?>sendemail/lupa_password">
              <h1>Lupa Password</h1>
              <div>
              	<label>Username</label>
                <input type="text" class="form-control" placeholder="Masukkan Username / NIK" required="" name="nik" />
              </div>
              <div>
              	<label>Email</label>
                <input type="email" class="form-control" placeholder="Masukkan Email" required="" name="email" />
              </div>
              <div>
              	<a href="<?php echo base_url(); ?>administrator"><button class="btn btn-default" type="button">Kembali</button></a>
              	<!-- PHP Mailer -->
                <!-- <a href="http://www.gmail.com"> --><button type="submit" class="btn btn-primary" name="submit">Kirim Link Verifikasi</button><!-- </a> -->
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                  <p>PT. Perkebunan Nusantara XII</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
      <script type="text/javascript">
        $("#bt-remove").on('click' , function () {
          $('#forpesan').remove();
        });
  </script>
  </body>
</html>