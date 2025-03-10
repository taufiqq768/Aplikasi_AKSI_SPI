<title>AKSI | List Notifikasi Deadline</title>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
  
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><strong>List Notifikasi Deadline</strong><small>(Operator)</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable" class="table table-bordered table-striped">
                    	<thead>
                    		<tr>
                    			<th style="width: 7%"><center>No.</center></th>
                    			<th style="width: 10%"><center>Deadline</center></th>
                    			<th style="width: 30%"><center>Temuan</center></th>
                    			<th style="width: 33%"><center>Rekomendasi</center></th>
                    			<th style="width: 10%"><center>Action</center></th>
                    		</tr>
                    	</thead>
                    	<tbody>
                    		<?php 
                    			$no = 0;
                    			foreach ($record as $key => $value) {
                    			  $expired = '';
			                      $exp = '';
			                      $exp = explode("-", $value['rekomendasi_tgl']);
			                      $tgl = $exp[2];
			                      $thn = $exp[0];
			                      $bln = (int)$exp[1] + 4;
			                      if ($bln<=9) {
			                        $bln = "0".$bln;
			                      }
			                      
			                      // if ($exp[1]=="01" OR "02" OR "03") {
			                      //   if ($exp[1]=="01") {
			                      //     $thn = (int)$thn - 1;
			                      //     $bln = "10";  
			                      //   }
			                      //   if ($exp[1]=="02") {
			                      //     $thn = (int)$thn - 1;
			                      //     $bln = "11";  
			                      //   }
			                      //   if ($exp[1]=="03") {
			                      //     $thn = (int)$thn - 1;
			                      //     $bln = "12";  
			                      //   }
			                      // }
                                  if ($exp[1]=="09" OR "10" OR "11" OR "12") {
                                    if ($exp[1]=="09") {
                                      $thn = (int)$thn + 1;
                                      $bln = "01";  
                                    }
                                    if ($exp[1]=="10") {
                                      $thn = (int)$thn + 1;
                                      $bln = "02";  
                                    }
                                    if ($exp[1]=="11") {
                                      $thn = (int)$thn + 1;
                                      $bln = "03";  
                                    }
                                    if ($exp[1]=="12") {
                                      $thn = (int)$thn + 1;
                                      $bln = "04";  
                                    }
                                  }
			                      $expired = $thn."-".$bln."-".$tgl; 
			                      if (date('Y-m-d') <= $expired) { 
                                    $no++;
                    		?>                    		
	                    		<tr>
	                    			<td><center><?php echo $no."."; ?></center></td>
	                    			<td><center><?php echo $tgl."-".$bln."-".$thn; ?></center></td>
	                    			<td><?php echo $value['temuan_judul']; ?></td>
	                    			<td><?php echo $value['rekomendasi_judul']; ?></td>
	                    			<td>
	                    				<?php if ($this->session->level=="operator") {
	                    					echo "<a href='".base_url()."administrator/list_tl/$value[pemeriksaan_id]/$value[temuan_id]/$value[rekomendasi_id]'>";
	                    				}elseif ($this->session->level=="verifikator") {
	                    					echo "<a href='".base_url()."administrator/list_tl_verifikator/$value[pemeriksaan_id]/$value[temuan_id]/$value[rekomendasi_id]'>";
	                    				} ?>
	                    				<center><button type="button" class="btn btn-xs btn-danger"><span class="fa fa-folder-open-o"></span> Lihat detail</button></center></a>
	                    			</td>
	                    		</tr>
	                    	<?php  } ?>
                    		<?php //$no++; 
                                } ?>
                    	</tbody>
                    </table>
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
