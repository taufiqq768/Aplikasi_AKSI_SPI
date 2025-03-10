<title>AKSI | Detail Pesan</title>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="row">
            <div class="center">
            <h3>Detail Pesan Masuk</h3>
            </div>
          <!-- start col12 -->
          <div class="col-lg-12">
            <div class="x_panel">
              <!-- judul -->
              <div class="x_content">
                <div class="table-responsive">
                  <table id="datatable" class="table">
                    <thead>
                      <tr>
                        <th>  </th>
                        <th>Keterangan</th>
                        <th>Pesan</th>
                      </tr>
                    </thead>
                    <?php 
                    $room = $this->uri->segment(3);
                    $judul = $this->model_app->view_select_where('*','tb_roompesan','roompesan_id',$this->uri->segment(3));
                    ?>
                  <h4><?php echo "<b>".$judul[0]->roompesan_judul."</b>"; ?>
                    <button class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target=".bs-example-modal-lg"  title="Balas Pesan"><span class="fa fa-mail-reply"></span> Balas</button>
                    <button class="btn btn-danger btn-xs pull-right" data-toggle="modal" title="Edit Judul Forum" data-target=".editjudul"><span class="fa fa-pencil"></span> Edit Judul</button>
                  </h4>
                      <tbody>
                        <?php foreach ($record as $key => $row) { ?>
                          <?php
                            $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $row['pesan_pengirim']))->row_array(); 
                            if ($row['pesan_pengirim']==$this->session->username) {
                                 $style = "bgcolor= '#eff4ff'";
                            }else{
                              $style = "bgcolor= '#ffffff'";
                            } 
                          ?>
                          <?php $cek = $this->model_app->view_where('tb_roompesan','roompesan_id',$this->uri->segment(3));
                           ?>
                          <?php 
                                   // if ((($row['pesan_hapus']!="0")&&($row['pesan_hapus']=="1" AND $row['pesan_pengirim']!=$this->session->username))||($row['pesan_hapus']=="2")) { ?>
                                    <tr <?php echo $style; ?>>
                                    <td><a href="#"></a>
                                    <?php if ($row['pesan_pengirim']==$this->session->username) { ?>
                                      <?php echo "<a href='".base_url()."message/delete_pesan/$room/$row[pesan_id]'>"?><button class="btn btn-xs btn-danger" type="button" data-toggle="tooltip" data-placement="top" onclick="return confirm('Hapus Pesan ini dari Forum ?')" title="Hapus pesan"><span class="fa fa-trash"></span></button>
                                    <?php } ?>
                                    </td>
                                    <td style="width: 20%">
                                      <?php echo "Dari : ".$usr['user_nama']; ?> <br>
                                      <?php $tgl = explode("-", $row['pesan_tgl']); echo "Dikirim pada : <br>".$tgl[2]."-".$tgl[1]."-".$tgl[0]." / ".$row['pesan_waktu']; ?>
                                    </td>
                                    <td style="width: 80%">
                                      <?php echo $row['pesan_deskripsi']."<br>"; ?>
                                      <?php $doc = $this->model_app->view_where('tb_upload_pesan','pesan_id',$row['pesan_id']);
                                        if ($doc!=null) {
                                           echo "<br><b>Lampiran : </b><br>";
                                         } 
                                        $no = 1;
                                        foreach ($doc as $k => $value) {
                                          echo $no."."; ?>
                                          <a target="_BLANK" title="Lihat Data" href="<?php echo base_url(); ?>/asset/file_pesan/<?php echo $value['uploadpesan_nama']?>"><font size="2"><?php echo $value['uploadpesan_nama']; ?></font></a>
                                         <?php echo"<br>"; $no++;
                                        }
                                      ?>    
                                    </td>
                                  </tr>                    
                                    <?php 
                                 // }
                          ?>                        
                        <?php } ?>
                      </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
         <!--  end col12 -->
        </div>
      </div>
        <!-- /page content -->
<?php $cek = $this->model_app->view_where('tb_roompesan','roompesan_id',$this->uri->segment(3));
  // print_r($cek);
  $pengirim =  $cek[0]['roompesan_user'];
  // $pengirim = '';
  // if ($cek[0]['roompesan_user_a'] == $this->session->username) {
  //   $pengirim = $cek[0]['roompesan_user_b'];
  // }else{
  //   $pengirim =  $cek[0]['roompesan_user_a'];
  // }
 ?>
 <div class="modal fade bs-example-modal-lg"  id="ModalaAdd" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><strong>Tambah Pesan</strong></h4>
      </div>
      <div class="modal-body">

    <form class="form-horizontal" role="form">
        <input type="hidden" class="form-control" id="id_pengirim" name="pengirim" value="<?php echo $pengirim; ?>">
        <input type="hidden" class="form-control" id="id_room" name="room" value="<?php echo $this->uri->segment(3); ?>">
        <input type="hidden" class="form-control" name="status" value="N">
        <input type='text' id='count' name='count' value=0 hidden="" />
        <div class="upload-file">
          <input type='text' id='files' name='files"+i+"' value='' hidden="" />
        </div>
        <div class="form-group">
          <label>Pesan :</label>
          <textarea class="form-control" rows="4" id="id_pesan" name="pesan"></textarea>
        </div>
        <div class="form-group">
            <strong>Upload File (max. size 2MB)</strong><br><span>(Accepted : .jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx, .odt)</span>
            <br>
            <div class="dropzone col-lg-12">
            <div class="dz-message">
             <h3> Klik atau Drop File disini</h3>
            </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="cancel_add" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="btn_simpan" name="balas" class="btn btn-primary">Kirim</button>
      </div>
    </form>
    </div>
  </div>
</div>
<?php $id_room = $this->uri->segment(3); ?>
<!-- modal confirm -->
 <div class="modal fade editjudul" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><strong>Edit Judul Forum Pesan</strong></h4>
      </div>
      <div class="modal-body">
        <?php 
        $attributes = array('class'=>'form-horizontal form-label-left','role'=>'form');
        echo form_open_multipart('message/edit_pesan/'.$id_room,$attributes);
         ?>
        <div class="form-group">
          <label>Judul Pesan</label>
          <input type="text" name="judul" class="form-control" value="<?php echo $judul[0]->roompesan_judul ?>">
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-success" name="edit" >Simpan</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
</div>
  <!-- modal confirm -->
 <div class="modal fade" id="ModalConfirm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Kirim Pesan</h4>
      </div>
      <div class="modal-body">
        <?php 
        $attributes = array('class'=>'form-horizontal form-label-left','role'=>'form');
        echo form_open_multipart('message/pesan_upload/'.$this->uri->segment(3),$attributes);
         ?>
        <div class="alert alert-info"><p>Apakah Anda ingin mengupload file ?</p></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" name="tidak" data-dismiss="modal">Tidak</button>
        <button type="submit"  class="btn btn-success" name="ya" >Ya</button>
      </div>
      <?php echo form_close(); ?>
    </div>
    </div>
  </div>
</div>
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
    <!-- Skycons -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/skycons/skycons.js"></script>
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
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Dropzone.js -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/dropzone/dist/min/dropzone.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/build/js/custom.min.js"></script>
    <script type="text/javascript">
      var i=1;
      $('#datatable').dataTable( {
          "paging": true,
          "searching": false,
          "ordering": false,
          "bLengthChange": false

      } );
    </script>
	 <script type="text/javascript">
      $("#form-upload").hide();
      $("#tambah-upload").on('click', function(){
        $("#form-upload").show();
      });
    </script>
    <?php $room_id = $this->uri->segment(3); ?>
    <script type="text/javascript">
        $('#btn_simpan').on('click',function(){
            var pengirim=$('#id_pengirim').val();
            var room=$('#id_room').val();
            var pesan=$('#id_pesan').val();
            var files=$('#files').val();
            
            var count = $('#count').val();
            var idroom = <?php echo json_encode($room_id) ?>;
            var BASEURL = "<?php echo base_url('message/balas_pesan/')?>";
            var url = BASEURL + idroom;
            console.log(url);
            $.ajax({
                type : "POST",
                url  : url,
                dataType : "JSON",
                data : {pengirim:pengirim , room:idroom, pesan:pesan, files:files, count:count},
                success: function(data){
                    $('[name="pengirim"]').val("");
                    $('[name="room"]').val("");
                    $('[name="pesan"]').val("");
                    $('#ModalaAdd').modal('hide');
                    $("#ModalUpload").hide();
                    console.log(data);
                    location.reload();
                }
            });
                 // location.reload();
            // return false;
        });
    </script>
    <script type="text/javascript">
    Dropzone.autoDiscover = false;
    var BASE_URL = "<?php echo base_url('message/uploadfile_pesan/');?>";
    var redirect = "<?php echo base_url('message/kotakmasuk/');?>";
    var foto_upload= new Dropzone(".dropzone",{
    url: BASE_URL,
    maxFilesize: 50,
    method:"post",
    maxFiles: 10,
    acceptedFiles:"image/*, .pdf, .doc, .docx, .xls, .xlsx, .odt",
    paramName:"userfile",
    dictInvalidFileType:"Type file ini tidak dizinkan",
    addRemoveLinks:true,
    success: function(data) {
      
        if (data.redirect) {
            // data.redirect contains the string URL to redirect to
            window.location.href = redirect;
        }
    }
    });
     //Event ketika Memulai mengupload
      foto_upload.on("sending",function(a,b,c){
        a.token=Math.random();
        var temp = $('#files').val();
        $('#files').val(temp+" "+a.token);
        // $('.upload-file').append("<input type='text' id='files"+i+"' name='files"+i+"' value='"+a.token +"' />");
        $('#count').val(i);
        i++;
        c.append("token_foto",a.token); //Menmpersiapkan token untuk masing masing foto

        console.log(a.name + a.token);
      });
    //Event ketika foto dihapus
    foto_upload.on("removedfile",function(a){
      var token=a.token;
      $.ajax({
        type:"post",
        data:{token:token},
        url:"<?php echo base_url('message/remove_file_pesan') ?>",
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
  </body>
</html>
