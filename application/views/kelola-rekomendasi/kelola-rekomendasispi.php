  <title>PTPN XII | List Rekomendasi</title>
  <script>
  	tinymce.init({
    selector: "textarea",
    width:      '100%',
    height:     270,
    plugins:    [ "anchor link" ],
    statusbar:  false,
    menubar:    false,
    toolbar:    "link anchor | alignleft aligncenter alignright alignjustify",
    rel_list:   [ { title: 'Lightbox', value: 'lightbox' } ]
});
  </script>
      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Kelola Tanggapan dan Tindak Lanjut</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                 <h2>
                 <?php 
                 	$id_pmr = $this->uri->segment(3);
					$id_temuan = $this->uri->segment(4);
					$id_rekom = $this->uri->segment(5);
					$role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
                 	echo "<a href='".base_url()."administrator/input_spi/$id_pmr'"; ?>
					<button class="btn btn-xs btn-default" type="button"><i class="fa fa-mail-reply"></i> </button></a>	
                 List Temuan dan Rekomendasi
             	</h2>
                  <!-- <ul class="nav navbar-right panel_toolbox">&nbsp;  -->
                   <!-- </ul> -->
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <?php  
                  if ($this->session->flashdata('gagal')!=null) {
                    echo "<div class='alert alert-danger' role='alert' id='forpesan'><center><strong><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('gagal')."</strong><a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></center></a></div>";
                  }  
                  if ($this->session->flashdata('berhasil')!=null) {
                    echo "<div class='alert alert-success' role='alert' id='forpesan'><center><strong><em class='fa fa-lg fa-check-circle-o'>&nbsp;</em>".$this->session->flashdata('berhasil')."</strong><a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></center></a></div>";
                  }
                ?>
                  <div class="table-responsive">
                  	<table class="tile_info">
                  		<tbody>
                  			<?php foreach ($record as $key => $value): ?>
                  			<tr>
                  				<th scope="row" style="width: 150px">Jenis Audit</th>
                        		<td>: <?php echo $value['pemeriksaan_jenis']; ?></td>
                  			</tr>
                  			<tr>
                  				<th scope="row" style="width: 150px">Judul Pemeriksaan</th>
                        		<td>: <?php echo $value['pemeriksaan_judul']; ?></td>
                  			</tr>
                        <tr>
                          <th style="width: 150px">Bidang</th>
                          <td>: <?php 
                           $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $value['bidangtemuan_id']))->row_array();
                           echo $bidang['bidangtemuan_nama'];
                          ?></td>  
                        </tr>
                        <tr>
                          <th style="width: 150px">Obyek Pemeriksaan</th>
                          <td>: <?php echo $value['temuan_obyek']; ?></td>  
                        </tr>
                  			<tr>
                  				<th scope="row" style="width: 150px">Tgl. Pemeriksaan</th>
                        		<td>: <?php  
                              $mulai = explode("-", $value['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $value['pemeriksaan_tgl_akhir']);
                              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                            ?></td>
                  			</tr>
                  			<tr>
                  				<th scope="row" style="width: 150px">Temuan</th>
                        		<td>: <?php echo $value['temuan_judul']; ?></td>
                  			</tr>
                  			<tr>
                  				<th scope="row" style="width: 150px">Rekomendasi</th>
                        		<td>: <?php echo $value['rekomendasi_judul']; ?></td>
                  			</tr>
                  			<tr>
                  				<th scope="row" style="width: 150px">Status Rekomendasi</th>
                        		<td>: 
                        			<?php
                        			$stt = $value['rekomendasi_status_cache']; 
                        			if ($stt=="") {
                        				$stt = $value['rekomendasi_status'];
                        			}
                        			if($stt=="Sudah di Tindak Lanjut"){
                        				$status = "<span class='btn btn-xs btn-round btn-success'>".$stt."</span>";
                        			}elseif ($stt=="Belum di Tindak Lanjut") {
                        				$status = "<span class='btn btn-xs btn-round btn-danger'>".$stt."</span>";
                        			}elseif ($stt=="Sudah TL (Belum Optimal)") {
                        				$status = "<span class='btn btn-xs btn-round btn-warning'>".$stt."</span>";
                        			}elseif ($stt=="Dikembalikan") {
                        				$status = "<span class='btn btn-xs btn-round btn-info'>".$stt."</span>";
                        			}elseif ($stt=="Closed") {
                                $status = "<span class='btn btn-xs btn-round btn-dark'>".$stt."</span>";
                              } 
                        			echo $status;
                        			?>
                        			
                        		</td>
                  			</tr>
                        <?php  
                        //setting disable untuk pemeriksaan sebelumnya jika ada data yang terbawa ke pemeriksaan baru
                         $disable2 = '';
                         $countpmr = [];
                         $ambilpmr = $this->db->query("SELECT pemeriksaan_sebelumnya FROM tb_pemeriksaan")->result_array();
                         foreach ($ambilpmr as $k1 => $val1) {
                            $explode = explode(" ", $val1['pemeriksaan_sebelumnya']);
                            foreach ($explode as $k2 => $val2) {
                              $countpmr[] = $val2;
                            }
                          } 
                          // print_r($countpmr);
                          if (in_array($id_pmr, $countpmr)) {
                            $disable2 = "disabled";
                          }
                        ?>
                  			<tr>
                  				<th scope="row" style="width: 150px; vertical-align: top;">Tanggapan Manajer</th>
                        		<td>: 
                        		<?php $tanggapan = $this->db->query("SELECT * FROM tb_tanggapan WHERE rekomendasi_id =$value[rekomendasi_id]")->result_array();
                            $userspi = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id', $id_pmr);
                            $userspi = explode("/", $userspi[0]['pemeriksaan_petugas']);
                            if (in_array($this->session->username, $userspi)) {
                              $hak = "";
                            }else{
                              $hak = "disabled";
                            }
                        		if (!empty($tanggapan)) {
                        			$tgl = explode("-", $tanggapan[0]['tanggapan_tgl']);
                        			$tgl = $tgl[2]."-".$tgl[1]."-".$tgl[0];
                        		}
                        		if (empty($tanggapan)) {
                        			if ($value['rekomendasi_kirim']=="N" OR $value['rekomendasi_status']=="Closed") {
                        				$disable = "disabled";
                        			}else{
                        				$disable = "";
                        			}
                        			?>
                        			<a href="<?php echo base_url(); ?>administrator/tambah_tanggapan/<?php echo $id_pmr?>/<?php echo $id_temuan?>/<?php echo $id_rekom ?>"><button type="button" class="btn btn-primary btn-xs" <?php echo $disable; echo $hak; echo $disable2;?>><span class="fa fa-plus-circle"></span> Tanggapan</button></a>
                        		<?php
                        		}elseif($tanggapan[0]['tanggapan_publish_kabag']=="N"){
                        			$id_tanggapan = $tanggapan[0]['tanggapan_id'];
                        			echo $tanggapan[0]['tanggapan_deskripsi']." (".$tgl.")";?>
                        			<a href="<?php echo base_url(); ?>administrator/edit_tanggapan/<?php echo $id_pmr?>/<?php echo $id_temuan?>/<?php echo $id_rekom ?>/<?php echo $id_tanggapan ?>"><button type="button" class="btn btn-xs btn-primary" <?php echo $disable2; ?>><span class="fa fa-edit"></span> Edit Tanggapan</button></a>
                        		<?php
                        		}elseif (!empty($tanggapan) && $tanggapan[0]['tanggapan_publish_kabag']=="Y") {
                        			echo $tanggapan[0]['tanggapan_deskripsi']."<br>&nbsp;&nbsp;<b>Terkirim ke Kabag pada ".$tgl."</b>";
                        		}
                        		?>		
                        		</td>
                  			</tr>
                        <!-- ambil file tanggapan -->
                        <?php if (!empty($tanggapan)): ?>
                        <tr>
                          <th scope="row" style="width: 150px; vertical-align: top;">File Tanggapan</th>
                            <td>: <?php 
                            $dokumen_t = $this->model_app->view_where_ordering('tanggapan_id','tb_upload_tanggapan',$tanggapan[0]['tanggapan_id'],'uploadtanggapan_id','ASC'); 
                               if (empty($dokumen_t)) {
                                 echo "-";
                               }
                                 foreach ($dokumen_t as $key2 => $row2) { ?>
                                   <a target="_BLANK" title="Lihat Data" href="<?php echo base_url(); ?>/asset/file_tanggapan/<?php echo $row2['uploadtanggapan_nama']?>"><?php echo "- ".$row2['uploadtanggapan_nama']."<br> &nbsp;"; 
                                 }
                            ?></td>
                        </tr>  
                        <?php endif ?>
                  				
                  			<?php endforeach ?>
                  		</tbody>
                  	</table>
                  	<br>
                  	<!-- <div class="col-lg-6 col-md-6 col-xs-12"> -->
                  		<?php if (!empty($tanggapan)): ?>
                  		<?php   
                  		if ($tanggapan[0]['tanggapan_kirim']=="Y") {
                        if ($value['rekomendasi_status']=="Dikembalikan" OR $value['rekomendasi_status']=="Belum di Tindak Lanjut") {
                        echo "<a href='".base_url()."administrator/input_tl_spi/$id_pmr/$id_temuan/$id_rekom'>"?><button type="button" class="btn btn-default pull-right" <?php  echo strpos($role[0]['role_akses'],'12')!==FALSE?"":"disabled"; echo $hak; echo $disable2; ?>>Input Tindak Lanjut</button></a>
                  		  
                  <?php } ?>
	                  	<table class="table table-bordered">
	                  		<thead>
	                  			<th style="width: 4%">No.</th>
	                  			<th style="width: 34%">Tindak Lanjut</th>
	                  			<th style="width: 9%">Status</th>
	                  			<th style="width: 26%">Dokumen</th>
	                  			<th style="width: 9%">Tgl. TL</th>
	                  			<th style="width: 18%">Action</th>
	                  		</thead>
	                  		<tbody>
	                  			<?php 
	                  			$tl = $this->db->query("SELECT * FROM tb_tl WHERE rekomendasi_id='$id_rekom'")->result_array(); 
	                  			$no = 1;
	                  			foreach ($tl as $value) { ?>
	                  			<tr>
	                  				<td><?= $no.".";?></td>
	                  				<td><?= $value['tl_deskripsi'];?></td>
	                  				<td><?= $value['tl_status']?></td>
	                  				<td>
	                  				<?php 
			                         $dokumen = $this->model_app->view_where_ordering('tl_id','tb_upload_tl',$value['tl_id'],'uploadtl_id','ASC'); 
			                         if (empty($dokumen)) {
			                           echo "<center>-</center>";
			                         }
			                           foreach ($dokumen as $key => $row) { ?>
			                             <a target="_BLANK" title="Lihat Data" href="<?php echo base_url(); ?>/asset/file_tl/<?php echo $row['uploadtl_nama']?>"><?php echo "- ".$row['uploadtl_nama']."<br>"; 
			                           }
			                         ?>
	                  				</td>
	                  				<td><?php 
	                  				$tgl = explode("-", $value['tl_tgl']);
	                  				echo $tgl[2]."-".$tgl[1]."-".$tgl[0];
	                  				?></td>
	                  				<td>
	                  					<center>
	                  					<?php if ($value['tl_publish_kabag']=="N"): ?>
	                  					<a href="<?php echo base_url(); ?>administrator/kirim_tl_tokabag/<?php echo $value['pemeriksaan_id'] ?>/<?php echo $value['temuan_id'] ?>/<?php echo $value['rekomendasi_id'] ?>/<?php echo $value['tl_id'] ?>"><button type="button" class="btn btn-success btn-xs" title="Kirim ke Kabag" <?php echo $disable2; ?>><i class="fa fa-send"></i></button></a>
		                                <?php if ($value['tl_publish_kabag']=="N"): ?>
		                                <a href="<?php echo base_url(); ?>administrator/edit_tl_spi/<?php echo $value['pemeriksaan_id']?>/<?php echo $value['temuan_id']?>/<?php echo $value['rekomendasi_id']?>/<?php echo $value['tl_id']?>"><button type="button" class="btn btn-primary btn-xs" title="Edit Temuan dan Rekomendasi" <?php echo $disable2; ?>><i class="fa fa-edit"></i> Edit</button></a>
		                                <a href="<?php echo base_url(); ?>administrator/delete_tl/<?php echo $value['pemeriksaan_id']?>/<?php echo $value['temuan_id']?>/<?php echo $value['rekomendasi_id']?>/<?php echo $value['tl_id']?>"><button type="button" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus Data ini ?');" <?php echo $disable2; ?>><i class="fa fa-trash"></i> Hapus</button></a>
		                                <?php endif ?>
		                                <?php elseif($value['tl_publish_kabag']=="Y" && $value['tl_status_kirim']=="N"): echo "<center>Terkirim ke Kabag</center>"; 
		                                elseif ($value['tl_status_kirim']=="Y" && $value['tl_publish_kabag']=="Y"):
                                      echo "<center>Telah di Setujui Kabag";
                                    endif;
		                                	if($value['tl_status_kirim']=="K"):
		                                		echo "<span class='red'>Dikembalikan oleh Kabag</span>";
		                                	endif
		                                ?>
	                                  	</center>
	                  				</td>
	                  			</tr>
	                <?php $no++;} ?>
	                  		</tbody>
	                  	</table>
	                  	<?php } ?>

                  	<?php endif ?>
                  	<!-- </div> -->
                  </div>
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
      $('#myDatepicker').datetimepicker({
        format: 'YYYY-MM-DD' });
    </script>
  <script type="text/javascript">
    var jumlah_form = 1;
    $(".add-more").on('click' , function () {
        // body...
        $(".tambah-form").append('<div class="txt-form'+jumlah_form+'"><label class="control-label col-md-3 col-sm-3 col-xs-12"></label><div class="input-group col-md-12 col-sm-12 col-xs-12"> <input type="text" class="form-control col-md-7 col-xs-12" name="rekom[]" ><span class="input-group-btn"><button type="button" class="btn btn-danger bt-remove" id="'+jumlah_form+'">Remove</button></span></div><b>Upload Dokumen</b> <span class="file-info">(ekstensi .jpg/ .pdf)</span><div class="col-md-9 col-sm-9 col-xs-12"><input type="file" name="upload[]" id="upload" multiple accept=".jpg, .pdf"><br></div>');
        jumlah_form++;
        $(".bt-remove").on('click',function(){
          confirm("Apakah Anda yakin ingin Menghapus Tindak Lanjut ?");
          $('.txt-form'+this.id).remove();
        }); 
      });
    </script>
    <script type="text/javascript">
      $('#datatable').dataTable( {
          "scrollX": true,
          "ordering": false,
          "searching": false,
          "bLengthChange": false
      });
    </script>
    <script type="text/javascript">
     var i=1;
    $(document).ready(function(){
        $('#select_all').on('click',function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked = true;
                });
            }else{
                 $('.checkbox').each(function(){
                    this.checked = false;
                });
            }
        });
        
        $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }
        });
    });
    </script>
    <script type="text/javascript">
      $("#upload").change(function() {
        var files = $(this)[0].files;
        for (var i = 0; i < files.length; i++) {
            $("#upload_prev").append(files[i].name);
        }
    });
    </script>
    <script type="text/javascript">
      $('#bt-remove').on('click', function(){
        $('#forpesan').remove();
      });
    </script>
 