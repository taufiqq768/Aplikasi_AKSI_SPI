 <title>PTPN XII | Edit Tindak Lanjut </title>
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
              <h3>Form Pemeriksaan Kebun</h3>
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
                      echo "<a href='".base_url()."administrator/list_tanggapantl/$id_pmr/$id_temuan/$id_rekom'"?>
                      <button class="btn btn-xs btn-default" type="button"><i class="fa fa-mail-reply"></i> </button>
                      </a>
                    Edit Tanggapan Manajer</h2>
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
                      <?php foreach ($record2 as $row) { ?>
                      <tr>
                        <th scope="row" style="width: 150px">Jenis Audit</th>
                        <td>: <?php echo $row['pemeriksaan_jenis']; ?></td>
                      </tr>
                      <tr>
                        <th style="width: 150px">Judul</th>
                        <td>: <?php echo $row['pemeriksaan_judul']; ?></td>  
                      </tr>
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
                      <tr>
                        <th style="width: 150px">Tanggal Pemeriksaan</th>
                        <td>: <?php 
                              $mulai = explode("-", $row['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $row['pemeriksaan_tgl_akhir']);
                              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                        ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Keterangan </th>
                        <td>: Keterangan</td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Nama Petugas SPI</th>
                        <td>: <?php 
                          $userr = explode("/", $row['pemeriksaan_petugas']);
                          foreach ($userr as $key => $value) {
                            $usra = $this->model_app->view_profile('tb_users', array('user_nik'=> $value))->row_array();
                             echo "(".$usra['user_nama'].") ";
                          }
                         ?> </td>  
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
                  $attributes = array('class'=>'form-horizontal form-label-left','role'=>'form');
                  echo form_open_multipart('administrator/edit_tanggapan/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,$attributes); 

                  foreach ($record as $row) { 
                    echo "<div class='form-group'><input type='hidden' name='id' value='$row[tanggapan_id]'></div>"; ?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" >Tanggapan</label>
                      <div class="col-md-8 col-sm-8 col-xs-12">
                       <textarea id="mytextarea" name="tanggapan" class="resizable_textarea form-control" rows="8"><?php echo $row['tanggapan_deskripsi']; ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
	                    <label class="control-label col-lg-3">List File Tanggapan
	                      <br><button type="button" class="btn btn-xs btn-primary" id="tambah-upload">Upload File</button>
	                    </label>
	                    <div class="col-lg-8">
	                      <div class="table-responsive">
	                      <table class="table table-bordered" id="mytable">
	                        <thead>
	                          <th style="width: 5%">No.</th>
	                          <th style="width: 70%">File Tanggapan</th>
	                          <th style="width: 15%">Tgl. Upload</th>
	                          <th style="width: 20%">Action</th>
	                        </thead>
	                        <tbody id="show_dataa6">
	                        </tbody>
	                      </table>
	                      </div>
	                    </div>
                    </div>
                    <div class="form-group" id="form-upload6">
                    <label class="control-label col-lg-3">Upload Dokumen (max. size 20MB)<br><span>(Accepted : .jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx, .odt)</span></label>

	                    <div class="dropzone col-lg-8 col-md-12 col-xs-12 col-sm-12">
		                    <div class="dz-message">
		                     <h3> Klik atau Drop File disini</h3>
		                    </div>
                    </div>
                  </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-6">
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan Perubahan</button>
                        <button type="submit" name="kirim" class="btn btn-success">Kirim ke Kabag</button>
                      </div>
                    </div>
                  <?php } ?>
                  <?php echo form_close(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<!--MODAL HAPUS-->
        <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                        <h4 class="modal-title" id="myModalLabel">Hapus File</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                          
                            <input type="hidden" name="kode" id="textkode" value="">
                            <div class="alert alert-info"><p>Apakah Anda yakin ingi menghapus file ini?</p></div>
                                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button class="btn_hapus btn btn-danger" id="btn_hapus">Hapus</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--END MODAL HAPUS-->
<!-- MODAL EDIT -->
        <div class="modal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Edit File</h3>
            </div>
            <form class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="control-label col-xs-3" >Ganti File</label>
                        <div class="col-xs-9">
                            <input type="hidden" name="file_id" id="file_id" value="">
                            <input name="filee" id="filee" class="form-control" type="file">
                        </div>
                    </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="btn_update">Update</button>
                </div>
            </form>
            </div>
            </div>
        </div>
        <!--END MODAL EDIT-->
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
  
     <!-- Datatables -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
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
  <!-- <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/parsleyjs/dist/parsley.min.js"></script> -->
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
    $id_rekom = $this->uri->segment(5); $id_tanggapan = $this->uri->segment(6); ?>
  <script type="text/javascript">
    $(document).ready(function(){
        tampil_data6();
          
        //fungsi tampil barang
        function tampil_data6(){
          console.log('masuk');
          var id_pmr = <?php echo json_encode($id_pmr) ?>;
          var id_temuan = <?php echo json_encode($id_temuan) ?>;
          var id_rekom = <?php echo json_encode($id_rekom) ?>;
          var id_tanggapan = <?php echo json_encode($id_tanggapan) ?>;
           var BASE_URL6 = "<?php echo base_url('administrator/tampil_filetanggapan/');?>";
           var urll6 = BASE_URL6+id_tanggapan;
           console.log(urll6);
            $.ajax({
                type  : 'ajax',
                url   : urll6,
                async : true,
                dataType : 'json',
                success : function(data){
                var html = '';
                var i;
                var no=1;
                for(i=0; i<data.length; i++){
                    html += '<tr>'+
                          '<td>'+no+'.</td>'+
                          '<td><a target="_BLANK" href="<?php echo base_url(); ?>asset/file_tanggapan/'+data[i].uploadtanggapan_nama+'">'+data[i].uploadtanggapan_nama+'</td>'+
                            '<td>'+data[i].uploadtanggapan_tgl+'</td>'+
                            '<td style="text-align:right;">'+
                                    // '<a href="javascript:;" class="btn btn-primary btn-xs item_edit" data="'+data[i].uploadtl_id+'">Edit</a>'+' '+
                                    '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="'+data[i].uploadtanggapan_id+'">Hapus</a>'+
                                '</td>'+
                            '</tr>';
                no++;
                }
                $('#show_dataa6').html(html);
                $('#form-upload6').hide();
                }
                //window.alert(urll);
            });
        }

    Dropzone.autoDiscover = false;
    var id_pmr = <?php echo json_encode($id_pmr) ?>;
    var id_temuan = <?php echo json_encode($id_temuan) ?>;
    var id_rekom = <?php echo json_encode($id_rekom) ?>;
    var id_tanggapan = <?php echo json_encode($id_tanggapan) ?>;
    var BASE_URL6 = "<?php echo base_url('administrator/uploadfile_tanggapan/');?>";
    var redirect = "<?php echo base_url('administrator/list_tl/');?>";
    var foto_upload= new Dropzone(".dropzone",{
    url: BASE_URL6+id_pmr+'/'+id_temuan+'/'+id_rekom+'/'+id_tanggapan,
    maxFilesize: 50,
    method:"post",
    maxFiles: 10,
    acceptedFiles:"image/*, .pdf, .doc, .docx, .xls, .xlsx, .odt",
    paramName:"userfile",
    dictInvalidFileType:"Type file ini tidak dizinkan",
    addRemoveLinks:true,
    success: function(data) {
      tampil_data6();
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
        url:"<?php echo base_url('administrator/remove_file_tanggapan') ?>",
        cache:false,
        dataType: 'json',
        success: function(){
          console.log("Foto terhapus");
          tampil_data6();
        },
        error: function(){
          console.log("Error");
          tampil_data6();

        }

      });
    });
    $('#show_dataa6').on('click','.item_hapus',function(){
            var id=$(this).attr('data');
            $('#ModalHapus').modal('show');
            $('[name="kode"]').val(id);
    });
     $('#btn_hapus').on('click',function(){
     var kode=$('#textkode').val();
     $.ajax({
     type : "POST",
     url  : "<?php echo base_url('administrator/hapus_file_tanggapan')?>",
     dataType : "JSON",
             data : {kode: kode},
             success: function(data){
                     $('#ModalHapus').modal('hide');
                     tampil_data6();
             }
         });
         return false;
     });
    //GET UPDATE
    $('#show_dataa6').on('click','.item_edit',function(){
        var id=$(this).attr('data');
        $('[name="file_id"]').val(id);
        console.log(id);
        $.ajax({
            type : "GET",
            url  : "<?php echo base_url('administrator/get_file')?>",
            dataType : "JSON",
            data : {id:id},
            success: function(data){
              $.each(data,function(uploadtanggapan_id, uploadtanggapan_nama){
                  $('#ModalaEdit').modal('show');
              $('[name="filee"]').val(data.uploadtanggapan_nama);
              $('[name="file_id"]').val(data.uploadtanggapan_id);
            });
            }
        });
        return false;
    });

  });
  </script>
  <!-- Initialize datetimepicker -->
  <script>
    $('#myDatepicker').datetimepicker({
    format: 'DD/MM/YYYY  hh:mm A' });
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
      $("#form-upload6").hide();
      $("#tambah-upload").on('click', function(){
        $("#form-upload6").show();
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
