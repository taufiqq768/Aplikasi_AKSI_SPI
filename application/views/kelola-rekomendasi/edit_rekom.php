  <title>PTPN XII | Edit Rekomendasi </title>
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
                  <?php 
                   $id_pmr = $this->uri->segment(3);
                   $id_temuan = $this->uri->segment(4);
                  ?>
                  <h2><a href="<?php echo base_url(); ?>administrator/list_rekomendasi/<?php echo $id_pmr ?>/<?php echo $id_temuan ?>"><button type="button" class="btn btn-default btn-xs"><i class="fa fa-mail-reply"></i></button></a>
                  Form Edit Rekomendasi <small>(SPI)</small></h2>
                  <ul class="nav navbar-right panel_toolbox">&nbsp;                       
                    <li><a class="close-link"><i class=""></i></a>
                    </li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="form-group">
                     <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name"></label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                     <h2><center><strong>Data Rekomendasi</strong></center></h2>
                  <br><br>
                  <div class="table-responsive"> 
                      <table class="tile_info">
                        <tbody>
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
                        <th style="width: 150px">Tanggal Pemeriksaan</th>
                        <td>: <?php 
                              $mulai = explode("-", $row['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $row['pemeriksaan_tgl_akhir']);
                              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                              ?>
                        </td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Keterangan </th>
                        <td>: Keterangan</td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Nama Petugas SPI</th>
                        <td>: <?php 
                          $select  = explode("/", $row['pemeriksaan_petugas']);
                          $nama = [];
                          foreach ($select as $nik) {
                            $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $nik))->row_array();
                            $nama[] = $usr['user_nama'];
                          }
                          $petugas = implode(", ", $nama);
                          echo $petugas;
                         ?> </td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Temuan</th>
                        <td>: <?php echo $row['temuan_judul']; ?></td>  
                      </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                     </div>
                   </div>
                  <br>
                  <?php 
                  $id_rekom = $this->uri->segment(5);
                  $attributes = array('class'=>'form-horizontal','role'=>'form');
                  echo form_open_multipart('administrator/edit_rekomendasi/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,$attributes); 

                  foreach ($record as $row) { 
                    echo "<div class='form-group'><input type='hidden' name='id' value='$row[rekomendasi_id]'></div>"; ?>
                    <div class="form-group">
                     <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Klasifikasi Rekomendasi<span class="required ">*</span></label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                     <select class="form-control" id="m_rekomendasi" name="m_rekomendasi">
                            <option selected>Pilih</option>
                            <?php 
                              $m_rekomen = $this->db->query("SELECT * FROM tb_master_rekomendasi ORDER BY rekomen_id  ASC")->result_array(); 
                              foreach ($m_rekomen as $value) 
                              {
                            ?>
                              <option value="<?php echo $value['rekomen_id']?>"<?php if ($row['rekomen_id'] == $value['rekomen_id']) {echo "selected";}?>><?php echo $value['judul']; ?></option>
                            <?php } ?>
                          </select>
                     </div>
                   </div>
                   <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="select2">Deadline Pengerjaan<span class="required ">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="input-prepend input-group">
                                <input type="text" name="deadline" id="deadline" class="form-control" value="<?php echo $row['rekomendasi_tgl_deadline'];?>"/>
                                <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              </div>
                      </div>
                    </div>
                <script>
                  // JavaScript untuk mengontrol visibilitas input file
                  document.getElementById('upload-btn').addEventListener('click', function() {
                    const uploadContainer = document.getElementById('upload-container');
                    if (uploadContainer.style.display === 'none') {
                      uploadContainer.style.display = 'block';
                    } else {
                      uploadContainer.style.display = 'none';
                    }
                  });
                </script>
                    <div class="form-group">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12" >Rekomendasi</label>
                      <div class="col-md-8 col-sm-8 col-xs-12">
                        <textarea id="mytextarea" type="text" name="rekomendasi" class="form-control col-md-7 col-xs-12" rows="10"><?php echo $row['rekomendasi_judul']; ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-8">
                        <div class="table-responsive">
                        
                        </div>
                      </div>                      
                    </div>
                    <div class="form-group">
                     <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">List File Dokumen Rekomendasi <span class="required ">*</span></label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                      <table class="table table-bordered" id="mytable">
                            <thead>
                              <th style="width: 5%">No.</th>
                              <th style="width: 70%">File Tindak Lanjut</th>
                              <th style="width: 15%">Tgl. Upload</th>
                              <th style="width: 20%">Action</th>
                            </thead>
                            <tbody id="show_data">
                            </tbody>
                        </table>
                     </div>
                   </div>
                  <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">List File Rekomendasi <span class="required ">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <button type="button" class="btn btn-xs btn-primary" id="tambah-upload">Upload File</button>
                    </div>
                  </div>
                    <div class="form-group" id="form-upload">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12">Upload Dokumen (max. size 2MB)<br><span>(Accepted : .pdf)</span></label>
                    <div class="dropzone col-lg-8 col-md-12 col-xs-12 col-sm-12">
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
                  </div>
                    <div class="form-group">
                      <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-7">
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button type="submit" class="btn btn-success" name="edit">Simpan Perubahan</button>
                      </div>
                    </div>
                    <?php } ?>
                  <?php echo form_close(); ?>
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
           var BASE_URL = "<?php echo base_url('administrator/tampil_file_rekom/');?>";
           var urll = BASE_URL+id_rekom;
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
                          '<td>'+no+'</td>'+
                          '<td><a target="_BLANK" href="<?php echo base_url(); ?>asset/file_rekomendasi/'+data[i].uploadrekom_nama+'">'+data[i].uploadrekom_nama+'</td>'+
                            '<td>'+data[i].uploadrekom_tgl+'</td>'+
                            '<td style="text-align:right;">'+
                                    // '<a href="javascript:;" class="btn btn-primary btn-xs item_edit" data="'+data[i].uploadtl_id+'">Edit</a>'+' '+
                                    '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="'+data[i].uploadrekom_id+'">Hapus</a>'+
                                '</td>'+
                            '</tr>';
                no++;
                }
                $('#show_data').html(html);
                $('#form-upload').hide();
                }
                //window.alert(urll);
            });
        }

    Dropzone.autoDiscover = false;
    var id_pmr = <?php echo json_encode($id_pmr) ?>;
    var id_temuan = <?php echo json_encode($id_temuan) ?>;
    var id_rekom = <?php echo json_encode($id_rekom) ?>;
    var BASE_URL = "<?php echo base_url('administrator/uploadfile_rekom/');?>";
    var redirect = "<?php echo base_url('administrator/list_rekomendasi/');?>";
    var foto_upload= new Dropzone(".dropzone",{
    url: BASE_URL+id_pmr+'/'+id_temuan+'/'+id_rekom,
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
            window.location.href = redirect+id_pmr+'/'+id_temuan;
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
        url:"<?php echo base_url('administrator/remove_file_rekom') ?>",
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
    $('#show_data').on('click','.item_hapus',function(){
            var id=$(this).attr('data');
            $('#ModalHapus').modal('show');
            $('[name="kode"]').val(id);
    });
     $('#btn_hapus').on('click',function(){
     var kode=$('#textkode').val();
     $.ajax({
     type : "POST",
     url  : "<?php echo base_url('administrator/hapus_file_rekom')?>",
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
    $('#show_data').on('click','.item_edit',function(){
        var id=$(this).attr('data');
        $('[name="file_id"]').val(id);
        console.log(id);
        $.ajax({
            type : "GET",
            url  : "<?php echo base_url('administrator/get_file_rekom')?>",
            dataType : "JSON",
            data : {id:id},
            success: function(data){
              $.each(data,function(uploadrekom_id, uploadrekom_nama){
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
            url  : "<?php echo base_url('administrator/edit_file_rekom')?>",
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
  </body>
  </html>
