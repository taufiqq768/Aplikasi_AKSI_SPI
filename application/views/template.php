<?php   if (!isset($this->session->level)) {
  redirect('administrator');
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo base_url() ?>/asset/images/logo.png">

	<!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
	<link href="<?php echo base_url(); ?>/asset/gentelella/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
	<!-- Select2 -->
	<link href="<?php echo base_url(); ?>/asset/gentelella/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
	<!-- Switchery -->
	<link href="<?php echo base_url(); ?>/asset/gentelella/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
	<!-- starrr -->
	<link href="<?php echo base_url(); ?>/asset/gentelella/vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/build/css/custom.min.css" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
  	<link href="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
  	<link href="<?php echo base_url(); ?>/asset/gentelella/vendors/cropper/dist/cropper.min.css" rel="stylesheet">
          <!-- Custom styling plus plugins -->
    <link href="<?php echo base_url(); ?>/asset/gentelella/build/css/custom.min.css" rel="stylesheet">
    <!-- Dropzone.js -->
  <link href="<?php echo base_url(); ?>/asset/gentelella/vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
  <!-- Sweet Alert -->
    <link href="<?php echo base_url(); ?>/asset/sweetalert/sweetalert.css" rel="stylesheet">
     <!-- History -->
    <link href="<?php echo base_url(); ?>/asset/css/history.css" rel="stylesheet">
    <style type="text/css">
      .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: #ffff;
      }
      .preloader .loading {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%,-50%);
        font: 14px arial;
      }
      </style>
</head>
                            <!-- CONTENT -->

    <body class="nav-md" >
      <div class="preloader">
        <div class="loading">
          <img src="<?php echo base_url() ?>/asset/images/poi3.gif" width="180">
        </div>
      </div>
        <div class="container body">
          <div class="main_container">
            <?php include 'menu_sidebar.php'; ?>
            <?php include 'main_header.php'; ?>  
            <div class="main-content">
              <?php echo $contents; ?>
            </div>
            <footer>
              <div class="pull-right">
               <a href="http://ptpn1.co.id" target="_BLANK">PT. Perkebunan Nusantara I </a>
              </div>
              <div class="clearfix"></div>
            </footer>
          </div>
        </div> 
    <script>
    $(document).ready(function(){
    $(".preloader").fadeOut();
    })
    </script>
    </body>
</html>