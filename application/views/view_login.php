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
    <?php  $usr = $this->model_app->view_profile('tb_identitas', array('identitas_id'=> '1'))->row_array(); ?>
    <title><?= $usr['identitas_namaweb'] ?> | Login </title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>asset/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>asset/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <!-- NProgress -->
    <link href="<?php echo base_url(); ?>asset/gentelella/vendors/nprogress/nprogress.css" rel="stylesheet"/>
    <!-- Animate.css -->
    <link href="<?php echo base_url(); ?>asset/gentelella/vendors/animate.css/animate.min.css" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>asset/gentelella/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
       
        <div class="animate form login_form col-lg-12 col-xs-12 col-sm-12 col-md-12">
           <?php 
           if ($this->input->post('email')!=''){
                    echo "<div class='alert alert-warning'><center>$pesan</center></div>";
                  }elseif($this->input->post('username')!=''){
                    echo "<div class='alert alert-danger'><center>$pesan</center></div>";
                  }
         ?>
          <section class="login_content">
            <?php echo form_open('administrator/index'); ?>
            <form>
              <h1>Login <?php $usr = $this->model_app->view('tb_identitas');
                foreach ($usr->result_array() as $row) {
                   echo "<img src='".base_url()."asset/images/$row[identitas_logo]' style='width: 50px'>";
                   echo $row['identitas_namaweb'];
                } ?></h1>
              <div>
                <input type="text" class="form-control" name="username" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password" required="" />
              </div>
              <div>
               <!--  <a href="<?php //echo site_url('administrator/index') ?>"> --><button class="btn btn-default" type="submit" name="submit">Log in</button><!-- </a> -->
                <a class="reset_pass" href="<?php echo base_url(); ?>sendemail/lupa_password">Lupa password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                  <p><a href="http://ptpn1.co.id" target="_BLANK">PT. Perkebunan Nusantara I</a></p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>