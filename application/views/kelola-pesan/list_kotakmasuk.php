<title>AKSI | Kotak Masuk</title>
<style>
#moreuser {display: none;}
</style>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="row">
            <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Kotak Masuk Pesan</h2>
                <!--   <ul class="nav navbar-right panel_toolbox"> -->
                    <?php  // echo "<a href='".base_url()."message/input_pesan'>"?><button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#ModalAdd"><i class="fa fa-plus"></i> Tulis Pesan</button><!-- </a> --></li>
                 <!--  </ul> -->
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                   <?php 
                    $attributes = array('class'=>'form-horizontal','role'=>'form', 'id'=>'demo-form');
                    echo form_open('message/multidelete_pesan',$attributes);
                    ?>
                    <?php 
                     if ($this->session->flashdata()==null) {
                       echo '';
                     }else{
                      echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>×</span></button><center><strong>".$this->session->flashdata('berhasil')."</strong></center></div>";
                     }
                     ?>
                    <table class="table table-striped" id="datatable">
                      <thead>
                        <td style="width: 5%"><!-- <input type="checkbox" id="select_all" /> --></td>
                        <td style="width: 27%"><center><b>User</b></center></td>
                        <td style="width: 45%"><center><b>Judul</b></center></td>
                        <td style="width: 10%"><center><b>Waktu</b></center></td>
                        <td style="width: 23%"><center><b>Action</b></center></td>
                      </thead>
                      <tbody>
                        <?php foreach ($record as $row) { 
                          // $notif = $this->model_app->view_where('tb_notifpesan','roompesan_id',$row['roompesan_id']);
                          if ($row['status']=='N'){ 
                            $bold = 'bold'; 
                          }else{ 
                            $bold = 'none'; 
                          }
                        ?>
                        <?php //echo $row['roompesan_hapus']."<br>"; 
                            $tampil = explode(" ", $row['roompesan_hapus']);
                            if (in_array($this->session->username, $tampil)) {                            
                        ?>
                        <tr style='font-weight:<?php echo $bold; ?>'>
                          <td><center> <?php echo "<a href='".base_url()."message/delete_forum/$row[roompesan_id]'>"?><button class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" type="button" onclick="return confirm('Yakin ingin menghapus ?')" title="Hapus Forum"><span class="fa fa-trash"></span></button></a><!-- <input type="checkbox" class="form-control checkbox" name="select[]" value="<?php //echo $row['roompesan_id']?>"> --></center></td>
                          <td><?php   //echo "<a href='".base_url()."message/detail_forum/$row[roompesan_id]'>"?>
                          <?php
                          $userr = explode(" ", $row['roompesan_user']);
                          $hitung = count($userr);
                          if ($hitung < 6) {
                            foreach ($userr as $key => $value) {
                               $usra = $this->model_app->view_profile('tb_users', array('user_nik'=> $value))->row_array();
                                echo "(".$usra['user_nama'].") ";
                            }
                          }else{
                            for ($i=0; $i < 5; $i++) { 
                              $usra = $this->model_app->view_profile('tb_users', array('user_nik'=> $userr[$i]))->row_array();
                             echo "(".$usra['user_nama'].") ";
                            }
                            if ($hitung > 5) {
                              $more = $hitung - 6; ?>
                              <span id="dots">..</span>
                              <span id="moreuser">
                                <?php  
                                  for ($i=0; $i < $hitung; $i++) { 
                                    if ($i > 5) {
                                      echo " (".$userr[$i].")";
                                    }
                                  }
                                ?>
                              </span>
                              <button class="btn btn-xs btn-round btn-default" type="button" id="myBtn" onclick="RMore()"><?= "(+".$more.")" ?></button>
                            <?php
                            }
                          }
                          ?></td>
                         
                            <td>
                              <?php   echo "<a href='".base_url()."message/detail_forum/$row[roompesan_id]'>"?>
                            <?php $c = $row['roompesan_judul']; ?>
                            <?php echo substr($c, 0, 100); //mbatesi char ?>
                            </a>
                            </td>
                          <td><center><?php   echo "<a href='".base_url()."message/detail_forum/$row[roompesan_id]'>"?><?php $datetime = explode(" ", $row['notifpesan_date']); $date = explode("-", $datetime[0]); echo $date[2]."-".$date[1]."-".$date[0]." / ".$datetime[1]; //echo $row['notifpesan_date']; ?></a></center></td>
                          <td>
                            <center>  
                            <?php   echo "<a href='".base_url()."message/detail_forum/$row[roompesan_id]'>"?><button class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Lihat/Balas Pesan" type="button"><span class="fa fa-eye"></span></button></a>
                            &nbsp;
                            <?php   
                            if ($row['status']=="Y") {
                              $title = "Tandai Belum Dibaca";
                            }else{
                              $title = "Tandai Sudah Dibaca";
                            }
                            echo "<a href='".base_url()."message/status_dibaca/$row[roompesan_id]/$row[status]'>"?><button class="btn btn-xs btn-dark" type="button" data-toggle="tooltip" data-placement="top" title="<?php echo $title ?>"><span class="fa fa-check-circle"></span></button>
                            &nbsp;
                             <?php   //echo "<a href='".base_url()."message/delete_pesan/$row[roompesan_id]'>"?><!-- <button class="btn btn-danger btn-xs" title="Hapus Pesan" type="button"  onclick="return confirm('Apa anda yakin untuk hapus Pesan ini?')" disabled=""><span class="fa fa-trash"></span></button> -->
                            </center>
                          </td>
                        </tr>
                        <?php 
                        }
                      } ?>
                      </tbody>
                    </table>
                    <!-- <button type="submit" class="btn btn-danger btn-xs" name="submit" onclick="return confirm('Anda Yakin ingin menghapus pesan terpilih ?')" disabled=""><span class="fa fa-trash"></span> Hapus</button> -->
                    <?php echo form_close(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <!-- /page content -->
 <div class="modal fade bs-example-modal-lg" id="ModalAdd" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><strong>Tambah Pesan</strong></h4>
      </div>
      <div class="modal-body">

    <form class="form-horizontal" role="form">
        <input type='text' id='count' name='count' value=0 hidden="" />
        <div class="upload-file">
          <input type='text' id='files' name='files"+i+"' value='' hidden="" />
        </div>

        <div class="form-group">
          <label>Kepada : </label><br>
          <!-- <select id="penerima" class="form-control"> -->
          <select class="select2_single form-control" tabindex="-1" multiple="multiple" id="penerima"  name="penerima[]" style="width: 50%">
            <option value="">-Pilih Penerima Pesan-</option>
            <option value="semua">Semua User</option>
           <?php foreach ($record2 as $key => $value) { 
                  if ($value['user_nik']!=$this->session->username) {
            ?>
               <option value="<?php echo $value['user_nik'] ?>"><?php echo $value['user_nama'];?></option>
           <?php  }
                 } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="first-name">Judul</label>
          <input type="text" required="required" name="judul" id="judul" class="form-control col-md-7 col-xs-12">
        </div>
        <div class="form-group">
          <label>Pesan :</label>
          <textarea class="form-control" rows="3" id="pesan" name="pesan"></textarea>
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
        <button type="button" id="btn_simpan" name="balas" class="btn btn-primary">Kirim</button>
      </div>
    </form>
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
    <!-- Select2 -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/select2/dist/js/select2.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
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
    <script>
  $(document).ready(function () {
    $('#penerima').select2({
      placeholder: "Pilih Penerima",
      dropdownParent: $('#ModalAdd')
    });
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
    <?php $user = $this->session->username; ?>
    <script type="text/javascript">
        $('#btn_simpan').on('click',function(){
            var penerima=$('#penerima').val();
            var judul=$('#judul').val();
            var pesan=$('#pesan').val();
            var files=$('#files').val();
            penerima.push('<?php echo $user ?>');
            console.log(penerima);
            var count = $('#count').val();
            var BASEURL = "<?php echo base_url('message/input_room')?>";
            console.log(BASEURL);
            $.ajax({
                type : "POST",
                url  : BASEURL,
                dataType : "JSON",
                data : {penerima:penerima , judul:judul, pesan:pesan, files:files, count:count},
                success: function(data){
                    $('[name="penerima"]').val("");
                    $('[name="judul"]').val("");
                    $('[name="pesan"]').val("");
                    $('#ModalAdd').modal('hide');
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
    maxFilesize: 2,
    method:"post",
    maxFiles: 5,
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
<script>
  function RMore(){
    var dots = document.getElementById('dots');
    var moreuser = document.getElementById('moreuser');
    var buton = document.getElementById('myBtn');
    console.log('yuhu');
    if (dots.style.display === "none") {
      dots.style.display = "inline";
      moreuser.style.display = "none";
      buton.innerHTML = "(+<?php echo $more ?>)";
    }else{
      dots.style.display = "none";
      moreuser.style.display = "inline";
      buton.innerHTML = "-";
    }
  }

  $('#datatable').dataTable({
    "ordering": false
  });
</script>
  </body>
</html>
