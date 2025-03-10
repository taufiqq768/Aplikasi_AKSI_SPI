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
              <h3>Form Pemeriksaan Regional</h3>
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
                      echo "<a href='".base_url()."administrator/list_tl_verifikator/$id_pmr/$id_temuan/$id_rekom'"?>
                      <button class="btn btn-xs btn-default" type="button"><i class="fa fa-mail-reply"></i> </button>
                      </a>
                    Edit Tindak Lanjut <small>(Verifikator)</small></h2>
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
                  echo form_open_multipart('administrator/edit_tl_verifikator/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,$attributes); 

                  foreach ($record as $row) { 
                    echo "<div class='form-group'><input type='hidden' name='id' value='$row[tl_id]'></div>"; ?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" >Tindak Lanjut</label>
                      <div class="col-md-8 col-sm-8 col-xs-12">
                       <textarea id="mytextarea" name="tl" class="resizable_textarea form-control"><?php echo $row['tl_deskripsi']; ?></textarea>
                      </div>
                    </div>
                   <!-- muncul setelah SPI memberi status -->
                    <!-- <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan Belum Optimal <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="nama_pmr"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div> -->
                    <div class="form-group">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12">List File Tindak Lanjut
                        <br><button type="button" class="btn btn-xs btn-primary" id="tambah-upload">Upload File</button>
                      </label>
                    <div class="col-lg-8 col-sm-12 col-md-12">

                      <div class="table-responsive">
                      <table class="table table-bordered" id="mytable">
                        <thead>
                          <th style="width: 5%">No.</th>
                          <th style="width: 70%">File Tindak Lanjut</th>
                          <th style="width: 15%">Tgl. Upload</th>
                          <th style="width: 20%">Action</th>
                        </thead>
                        <tbody id="show_dataa">
                        </tbody>
                      </table>
                      </div>
                    </div>
                    </div>
                    <div class="form-group" id="form-upload">
                    <label class="control-label col-lg-3 col-md-12 col-sm-12">Upload Dokumen (max. size 20MB)<br><span>(Accepted : .jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx, .odt)</span></label>
                    <div class="dropzone col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="dz-message">
                     <h3> Klik atau Drop File disini</h3>
                    </div>
                    </div>
                  </div>
                    <div class="ln_solid"></div>
                    <?php $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);?>
                    <div class="form-group">
                      <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-6">
                        <button class="btn btn-primary" type="submit" name="simpan" <?php  echo strpos($role[0]['role_akses'],'13')!==FALSE?"":"disabled"; ?>>Simpan Draft</button>
                        <button class="btn btn-danger" type="submit" name="back"> <?php  echo strpos($role[0]['role_akses'],'13')!==FALSE?"":"disabled"; ?>Kembalikan</button>
                        <button type="submit" name="edit" class="btn btn-success" <?php  echo strpos($role[0]['role_akses'],'13')!==FALSE?"":"disabled"; ?>>Kirim ke SPI</button>
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
      <!-- /page content -->

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

  <!-- jQuery -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- FastClick -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/nprogress/nprogress.js"></script>
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/dropzone/dist/min/dropzone.min.js"></script>
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
  <!-- <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/parsleyjs/dist/parsley.min.js"></script> -->
  <!-- Autosize -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/autosize/dist/autosize.min.js"></script>
  <!-- jQuery autocomplete -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
  <!-- starrr -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/starrr/dist/starrr.js"></script>
  <!-- Custom Theme Scripts -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/build/js/custom.min.js"></script> 
  <?php $id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
    $id_rekom = $this->uri->segment(5); $id_tl = $this->uri->segment(6); ?>
     <script type="text/javascript">
    $(document).ready(function(){
        tampil_data();
          
        //fungsi tampil barang
        function tampil_data(){
          console.log('masuk');
          var id_pmr = <?php echo json_encode($id_pmr) ?>;
          var id_temuan = <?php echo json_encode($id_temuan) ?>;
          var id_rekom = <?php echo json_encode($id_rekom) ?>;
          var id_tl = <?php echo json_encode($id_tl) ?>;
           var BASE_URL = "<?php echo base_url('administrator/tampil_data/');?>";
           var urll = BASE_URL+id_tl;
           console.log(urll);
            $.ajax({
                type  : 'ajax',
                url   : urll,
                async : true,
                dataType : 'json',
                success : function(data){
                var html = '';
                var i;
                var no=1;
                for(i=0; i<data.length; i++){
                    html += '<tr>'+
                          '<td>'+no+'.</td>'+
                          '<td><a target="_BLANK" href="<?php echo base_url(); ?>asset/file_tl/'+data[i].uploadtl_nama+'">'+data[i].uploadtl_nama+'</td>'+
                            '<td>'+data[i].uploadtl_tgl+'</td>'+
                            '<td style="text-align:right;">'+
                                    // '<a href="javascript:;" class="btn btn-primary btn-xs item_edit" data="'+data[i].uploadtl_id+'">Edit</a>'+' '+
                                    '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="'+data[i].uploadtl_id+'">Hapus</a>'+
                                '</td>'+
                            '</tr>';
                no++;
                }
                $('#show_dataa').html(html);
                $('#form-upload').hide();
                }
                //window.alert(urll);
            });
        }

    Dropzone.autoDiscover = false;
    var id_pmr = <?php echo json_encode($id_pmr) ?>;
    var id_temuan = <?php echo json_encode($id_temuan) ?>;
    var id_rekom = <?php echo json_encode($id_rekom) ?>;
    var id_tl = <?php echo json_encode($id_tl) ?>;
    var BASE_URL = "<?php echo base_url('administrator/uploadfile_tl/');?>";
    var redirect = "<?php echo base_url('administrator/list_tl/');?>";
    var foto_upload= new Dropzone(".dropzone",{
    url: BASE_URL+id_pmr+'/'+id_temuan+'/'+id_rekom+'/'+id_tl,
    maxFilesize: 50,
    method:"post",
    maxFiles: 10,
    acceptedFiles:"image/*, .pdf, .doc, .docx, .xls, .xlsx, .odt",
    paramName:"userfile",
    dictInvalidFileType:"Type file ini tidak dizinkan",
    addRemoveLinks:true,
    success: function(data) {
      tampil_data();
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
          tampil_data();
        },
        error: function(){
          console.log("Error");
          tampil_data();

        }

      });
    });
    $('#show_dataa').on('click','.item_hapus',function(){
            var id=$(this).attr('data');
            $('#ModalHapus').modal('show');
            $('[name="kode"]').val(id);
    });
     $('#btn_hapus').on('click',function(){
     var kode=$('#textkode').val();
     $.ajax({
     type : "POST",
     url  : "<?php echo base_url('administrator/hapus_file')?>",
     dataType : "JSON",
             data : {kode: kode},
             success: function(data){
                     $('#ModalHapus').modal('hide');
                     tampil_data();
             }
         });
         return false;
     });
    //GET UPDATE
    $('#show_dataa').on('click','.item_edit',function(){
        var id=$(this).attr('data');
        $('[name="file_id"]').val(id);
        console.log(id);
        $.ajax({
            type : "GET",
            url  : "<?php echo base_url('administrator/get_file')?>",
            dataType : "JSON",
            data : {id:id},
            success: function(data){
              $.each(data,function(uploadtl_id, uploadtl_nama){
                  $('#ModalaEdit').modal('show');
              $('[name="filee"]').val(data.uploadtl_nama);
              $('[name="file_id"]').val(data.uploadtl_id);
            });
            }
        });
        return false;
    });
    //Simpan Barang
    $('#btn_update').on('click',function(){
        var filee= document.getElementById("filee").files[0].name;
        var file_id =$('#file_id').val();
        console.log(filee);
        console.log(file_id);
        $.ajax({
            type : "POST",
            url  : "<?php echo base_url('administrator/edit_file')?>",
            dataType : "JSON",
            data : {filee:filee, file_id:file_id},
            success: function(data){
                $('[name="file_id"]').val("");
                $('[name="filee"]').val("");
                $('#ModalaEdit').modal('hide');
                tampil_data();
            }
        });
        return false;
    });

  });
  </script>
   <script type="text/javascript">
      $("#form-upload").hide();
      $("#tambah-upload").on('click', function(){
        $("#form-upload").show();
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
      $("#upload").change(function() {
        var files = $(this)[0].files;
        for (var i = 0; i < files.length; i++) {
            $("#upload_prev").append(files[i].name);
        }
    });
    </script>
  </body>
  </html>
