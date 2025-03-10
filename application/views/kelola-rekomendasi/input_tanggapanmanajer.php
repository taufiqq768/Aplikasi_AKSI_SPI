<title>PTPN XII | Tambah Tindak Lanjut </title>
  <script src="<?php echo base_url(); ?>/asset/tinymce/tinymce.min.js"></script>
  <script>
    tinymce.init({
      forced_root_block : "",
      selector : '#mytextarea',
       // menubar: false,
       image: false,
      plugins: [
        "paste",
        "searchreplace wordcount visualblocks visualchars fullscreen insertdatetime nonbreaking lists"
        ],
        paste_as_text: true
    });
  </script>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Form Pemeriksaan</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>
                    <?php 
                      $id_pmr = $this->uri->segment(3);$id_temuan = $this->uri->segment(4); $id_rekom = $this->uri->segment(5);
                      echo "<a href='".base_url()."administrator/list_tl/$id_pmr/$id_temuan/$id_rekom'"?>
                      <button class="btn btn-xs btn-default" type="button"><i class="fa fa-mail-reply"></i> </button>
                      </a>
                    Tambah Tanggapan Manajer<small>(SPI)</small></h2>
                  <ul class="nav navbar-right panel_toolbox">&nbsp;                       
                    <li><a class="close-link"><i class=""></i></a>
                    </li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="table-responsive"> 
                      <table class="tile_info">
                      <thead>
                        <center><b>Data Pemeriksaan</b></center>
                        <br>
                      </thead>
                      <?php foreach ($record as $row) { ?>
                      <tr>
                        <th scope="row" style="width: 150px">Jenis Audit</th>
                        <td>: <?php echo $row['pemeriksaan_jenis']; ?></td>
                      </tr>
                      <tr>
                        <th style="width: 150px">Judul</th>
                        <td>: <?php echo $row['pemeriksaan_judul']; ?></td>  
                      </tr>
                      <tr>
                      <tr>
                        <th style="width: 150px">Bidang </th>
                        <td>: <?php 
                        $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $row['bidangtemuan_id']))->row_array();
                        echo $bidang['bidangtemuan_nama']; ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Obyek Pemeriksaan</th>
                        <td>: <?php echo $row['temuan_obyek']; ?></td>  
                      </tr>
                        <th style="width: 150px">Tanggal Pemeriksaan</th>
                        <td>: <?php 
                              $mulai = explode("-", $row['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $row['pemeriksaan_tgl_akhir']);
                              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                         ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Nama Petugas SPI</th>
                        <td>: <?php 
                          $userr = explode("/", $row['pemeriksaan_petugas']);
                          foreach ($userr as $key => $value) {
                            $usra = $this->model_app->view_profile('tb_users', array('user_nik'=> $value))->row_array();
                             echo "(".$usra['user_nama'].") ";
                           }
                         ?>  </td>  
                      </tr>

                      <tr>
                        <th style="width: 150px">Temuan</th>
                        <td>: <?php echo $row['temuan_judul']; ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Rekomendasi</th>
                        <td>: <?php echo $row['rekomendasi_judul']; ?></td>  
                      </tr>
                      <?php } ?>
                    </table>
                  </div>
                  <br />
                  <?php 
                    $attributes = array('class'=>'form-horizontal form-label-left','role'=>'form', 'id'=>'demo-form2');
                    echo form_open_multipart('administrator/tambah_tanggapan/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,$attributes);
                  ?>
                    <div class="form-group">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12">Tanggal</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                       <div class="form-group">
                        <div class='input-group date' id='myDatepicker'>
                          <input type='text' class="form-control" name="tgl" autocomplete="off" />
                          <span class="input-group-addon">
                           <span class="glyphicon glyphicon-calendar"></span>
                         </span>
                        </div>
                       </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12" >Tanggapan Manajer <span class="required">*</span>
                      </label>
                      <div class="col-md-8 col-sm-8 col-xs-12">
                        <textarea id="mytextarea" class="resizable_textarea form-control" placeholder="Masukkan Deskripsi Tanggapan" name="tanggapan" rows="10"></textarea>
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-5">
                        <!-- <button class="btn btn-primary" type="submit" name="simpan">Simpan Draft</button> -->
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan Draft</button>
                        <button type="submit" name="kirim" class="btn btn-success">Kirim ke Kabag</button>
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
  <!-- Parsley -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/parsleyjs/dist/parsley.min.js"></script>
  <!-- Autosize -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/autosize/dist/autosize.min.js"></script>
  <!-- jQuery autocomplete -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
  <!-- starrr -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/starrr/dist/starrr.js"></script>
  <!-- Custom Theme Scripts -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/build/js/custom.min.js"></script> 
  <!-- Dropzone.js -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/dropzone/dist/min/dropzone.min.js"></script>
  <!-- Initialize datetimepicker -->
  <script>
    $('#myDatepicker').datetimepicker({
    format: 'YYYY-MM-DD' });
  </script>
  <script type="text/javascript">
    Dropzone.autoDiscover = false;

    var foto_upload= new Dropzone(".dropzone",{
    url: "<?php echo base_url('administrator/uploadfile_tl') ?>",
    maxFilesize: 50,
    method:"post",
    acceptedFiles:"image/*, .pdf, .doc, .docx, .xls, .xlsx, .odt",
    paramName:"userfile",
    dictInvalidFileType:"Type file ini tidak dizinkan",
    parallelUploads: 10,
    addRemoveLinks: true,
    dictMaxFilesExceeded: "You can only upload upto 10 Files",
    dictRemoveFile: "Delete",
    dictCancelUploadConfirmation: "Are you sure to cancel upload?",
    });


    //Event ketika Memulai mengupload
    foto_upload.on("sending",function(a,b,c){
      a.token=Math.random();
      c.append("token_foto",a.token); //Menmpersiapkan token untuk masing masing foto
    });
    //Event ketika foto dihapus
    foto_upload.on("removedfile",function(a){
      var token=a.token;
      $.ajax({
        type:"post",
        data:{token:token},
        url:"<?php echo base_url('administrator/remove_file_tl') ?>",
        cache:false,
        dataType: 'json',
        success: function(){
          console.log("Foto terhapus");
        },
        error: function(){
          console.log("Error");

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
  </body>
  </html>
