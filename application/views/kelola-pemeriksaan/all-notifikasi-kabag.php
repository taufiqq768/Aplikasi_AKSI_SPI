<title>AKSI | List Notifikasi Deadline</title>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
  
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><strong>List Notifikasi</strong><small>(Kabag SPI)</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <h4><strong>List Notifikasi Temuan</strong></h4>
                    <table class="table table-bordered table-striped datatable">
                    	<thead>
                    		<tr>
                    			<th style="width: 5%"><center>No.</center></th>
                                <th style="width: 35%">Pemeriksaan</th>
                    			<th style="width: 50%"><center>Temuan</center></th>
                    			<th style="width: 10%"><center>Action</center></th>
                    		</tr>
                    	</thead>
                    	<tbody>
                    		<?php 
                    			$no = 1;
                    			foreach ($record as $key => $value) {
                    		?>                    		
	                    		<tr>
	                    			<td><center><?php echo $no."."; ?></center></td>
                                    <td><?php echo $value['pemeriksaan_judul']; ?></td>
	                    			<td><?php echo $value['temuan_judul']; ?></td>
	                    			<td>
	                    				<?php
                                        if ($this->session->level=="kabagspi") {
	                    					echo "<a href='".base_url()."administrator/kirim_temuan/$value[pemeriksaan_id]/$value[temuan_id]'>";
	                    				} ?>
	                    				<center><button type="button" class="btn btn-xs btn-success"><span class="fa fa-send-o"></span> Kirim</button></center></a>
	                    			</td>
	                    		</tr>
                    		<?php $no++; } ?>
                    	</tbody>
                    </table>
                    <hr><br>
                    <h4><strong>List Notifikasi Rekomendasi</strong></h4>
                    <table class="table table-bordered table-striped datatable">
                        <thead>
                            <tr>
                                <th style="width: 5%"><center>No.</center></th>
                                <th style="width: 20%"><center>Temuan</center></th>
                                <th style="width: 35%"><center>Rekomendasi</center></th>
                                <th style="width: 30%"><center>Dokumen</center></th>
                                <th style="width: 10%"><center>Action</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no = 1;
                                foreach ($record2 as $key => $value) {
                            ?>                          
                                <tr>
                                    <td><center><?php echo $no."."; ?></center></td>
                                    <td><?php echo $value['temuan_judul']; ?></td>
                                    <td><?php echo $value['rekomendasi_judul']; ?></td>
                                    <td>
                                    <?php $hot = $this->model_app->view_where_ordering('rekomendasi_id','tb_upload_rekom',$value['rekomendasi_id'],'uploadrekom_id','ASC');
                                      $this->load->helper('directory'); 
                                      $map = directory_map('asset');
                                      if ($hot==null) {
                                          echo "<center>-</center>";
                                      }
                                        foreach ($hot as $value) {
                                          echo "-";?><a target="_BLANK" title="Lihat Data" href="<?php echo base_url(); ?>/asset/file_rekomendasi/<?php echo $value['uploadrekom_nama']?>"><?php echo $value['uploadrekom_nama']; ?></a> <br>
                                        <?php }
                                    ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($this->session->level=="kabagspi") {
                                            echo "<a href='".base_url()."administrator/kirim_rekomendasi/$value[pemeriksaan_id]/$value[temuan_id]/$value[rekomendasi_id]'>";
                                        } ?>
                                        <center><button type="button" class="btn btn-xs btn-success"><span class="fa fa-send-o"></span> Kirim</button></center></a>
                                    </td>
                                </tr>
                            <?php $no++; } ?>
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
    <script type="text/javascript">
        $(document).ready(function(){
            $('.datatable').DataTable();
        });
    </script>
