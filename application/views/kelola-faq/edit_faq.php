<title>PTPN XII | Edit FAQ </title>

  <script src="<?php echo base_url(); ?>/asset/tinymce/tinymce.min.js"></script>
  <script>
    tinymce.init({
      forced_root_block : "",
      selector : '#mytextarea',
       menubar: true,
        plugins: [
        "paste",
        // "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars fullscreen insertdatetime nonbreaking lists",
        ],
        paste_as_text: true
    });
  </script>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Edit FAQ</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>
                    <?php 
                    echo "<a href='".base_url()."faq/list_faq'"?>
                      <button class="btn btn-xs btn-default" type="button"><i class="fa fa-mail-reply"></i></button>
                      </a>
                    Form Ubah Informasi FAQ<small></small></h2>
                  <ul class="nav navbar-right panel_toolbox">&nbsp;                       
                    <li><a class="close-link"><i class=""></i></a>
                    </li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                  <?php 
                    $attributes = array('class'=>'form-horizontal form-label-left','role'=>'form', 'id'=>'demo-form2');
                    echo form_open_multipart('faq/edit_faq',$attributes);
                    foreach ($record as $row) {
                      echo "<div class='form-group'><input type='hidden' name='id' value='$row[faq_id]'></div>"; ?>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Judul / Pertanyaan</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="pertanyaan" class="form-control col-md-7 col-xs-12" value="<?php echo $row['faq_judul'] ?>">
                      </div>
                    </div>
                    <div class="form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Jawaban
                     </label>
                     <div class="col-md-8 col-sm-8 col-xs-12">
                      <textarea id="mytextarea" class="form-control col-md-9 col-xs-12" name="jawaban" rows="7"><?php echo $row['faq_jawaban']; ?></textarea>
                     </div>
                   </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">File Pendukung <br>
                        <button class="btn btn-primary btn-xs pull-right" type="button" id="tambah-upload">Upload File</button>
                      </label>
                       <div class="col-md-8 col-sm-8 col-xs-12 table-responsive">
                        
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
                    <div class="form-group" id="form-upload">
                    <label class="control-label col-lg-3">Upload Dokumen (max. size 20MB)<br><span>(Accepted : .jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx, .odt)</span></label>

                      <div class="dropzone col-lg-8">
                        <div class="dz-message">
                         <h3> Klik atau Drop File disini</h3>
                        </div>
                    </div>
                  </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <button type="submit" name="submit" class="btn btn-success">Simpan Perubahan</button>
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
      $("#form-upload").hide();
      $("#tambah-upload").on('click', function(){
        $("#form-upload").show();
      });
    </script>
    <?php $id_faq = $this->uri->segment(3); ?>
      <script type="text/javascript">
    $(document).ready(function(){
        tampil_data();
          
        //fungsi tampil barang
        function tampil_data(){
          console.log('masuk');
          var id_faq = <?php echo json_encode($id_faq) ?>;
           var BASE_URL = "<?php echo base_url('faq/tampil_data/');?>";
           var urll = BASE_URL+id_faq;
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
                          '<td><a target="_BLANK" href="<?php echo base_url(); ?>asset/file_faq/'+data[i].uploadfaq_filename+'">'+data[i].uploadfaq_filename+'</td>'+
                            '<td>'+data[i].uploadfaq_tgl+'</td>'+
                            '<td style="text-align:right;">'+
                                    // '<a href="javascript:;" class="btn btn-primary btn-xs item_edit" data="'+data[i].uploadtl_id+'">Edit</a>'+' '+
                                    '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="'+data[i].uploadfaq_id+'">Hapus</a>'+
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
    var id_faq = <?php echo json_encode($id_faq) ?>;
    var BASE_URL = "<?php echo base_url('faq/uploadfile_faq/');?>";
    var redirect = "<?php echo base_url('faq/list_faq/');?>";
    var foto_upload= new Dropzone(".dropzone",{
    url: BASE_URL+id_faq,
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
            window.location.href = redirect+id_faq;
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
        url:"<?php echo base_url('faq/remove_file_faq') ?>",
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
     url  : "<?php echo base_url('faq/hapus_file')?>",
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