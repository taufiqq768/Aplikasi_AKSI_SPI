<title>PTPN XII | Upload File TL </title>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Form Upload Tindak Lanjut</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Upload File Tindak Lanjut <small>(Petugas Kebun)</small></h2>
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
                        <center><b>Data Pemeriksaan (Temuan)</b></center>
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
                        <th style="width: 150px">Tanggal Pemeriksaan</th>
                        <td>: <?php 
                              $mulai = explode("-", $row['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $row['pemeriksaan_tgl_akhir']);
                              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                         ?></td>  
                      </tr>
                      <!-- <tr>
                        <th style="width: 150px">Keterangan </th>
                        <td>: Keterangan</td>  
                      </tr> -->
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
                      <?php if ($this->session->level=="spi"): ?>
                      <tr>
                        <th style="width: 150px">Tanggapan Manajer</th>
                        <td>: 
                          <?php $tanggapan =  $this->db->query("SELECT * FROM tb_tanggapan WHERE rekomendasi_id =$row[rekomendasi_id]")->result_array();
                          if (!empty($tanggapan)) {
                            echo $tanggapan[0]['tanggapan_deskripsi'];
                          }else{
                            echo "-";
                          }
                          ?>
                        </td>  
                      </tr>
                      <?php endif ?>
                      <tr>
                        <th style="width: 150px">Tindak Lanjut</th>
                        <td>: <?php echo $row['tl_deskripsi']; ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Tgl. Tindak Lanjut</th>
                        <td>: <?php $tgl = explode("-", $row['tl_tgl']); echo $tgl[2]."-".$tgl[1]."-".$tgl[0]; ?></td>  
                      </tr>
                      <?php } ?>
                    </table>
                  </div>
                  <br />
                  <div class="form-group">
                    <strong>Upload Dokumen (max. size 25MB)</strong><br>(Accepted : .jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx, .odt)
                    <br>
                    <div class="dropzone col-lg-12 col-md-12 col-xs-12">
                    <div class="dz-message">
                     <h3> Klik atau Drop File disini</h3>
                    </div>
                    <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Dokumen<br></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="file" name="file[]" id="file" multiple accept=".jpg, .pdf">
                      <span class="file-info">(ekstensi .jpg/ .pdf)</span>
                    </div> -->
                    </div>
                  </div>
                  <br><br><br><br><br><br><br><br><hr>
                  <div class="form-group">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <?php   
                        $id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
                        $id_rekom = $this->uri->segment(5);
                        if ($this->session->level=="spi") {
                          echo "<a href='".base_url()."administrator/list_tanggapantl/$id_pmr/$id_temuan/$id_rekom'>";
                        }else{
                        echo "<a href='".base_url()."administrator/list_tl/$id_pmr/$id_temuan/$id_rekom'>";} ?><button type="button" class="btn btn-primary pull-right">Done</button></a>
                      </div>
                  </div>
                   <!-- muncul setelah SPI memberi status -->
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
  <?php $id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
    $id_rekom = $this->uri->segment(5); $id_tl = $this->uri->segment(6); ?>
   <script type="text/javascript">
    Dropzone.autoDiscover = false;
    var id_pmr = <?php echo json_encode($id_pmr) ?>;
    var id_temuan = <?php echo json_encode($id_temuan) ?>;
    var id_rekom = <?php echo json_encode($id_rekom) ?>;
    var id_tl = <?php echo json_encode($id_tl) ?>;
    var BASE_URL = "<?php echo base_url('administrator/uploadfile_tl/');?>";
    var redirect = "<?php echo base_url('administrator/list_tl/');?>";
    var foto_upload= new Dropzone(".dropzone",{
    url: BASE_URL+id_pmr+'/'+id_temuan+'/'+id_rekom+'/'+id_tl,
    maxFilesize: 25,
    method:"post",
    maxFiles: 10,
    acceptedFiles:"image/*, .pdf, .doc, .docx, .xls, .xlsx, .odt",
    paramName:"userfile",
    dictInvalidFileType:"Type file ini tidak dizinkan",
    addRemoveLinks:true,
    success: function(data, textStatus) {
        if (data.redirect) {
            // data.redirect contains the string URL to redirect to
            window.location.href = redirect+id_pmr+'/'+id_temuan+'/'+id_rekom;
        }
    }
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
  <script>
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
      $("#upload").change(function() {
        var files = $(this)[0].files;
        for (var i = 0; i < files.length; i++) {
            $("#upload_prev").append(files[i].name);
        }
    });
    </script>
  </body>
  </html>
