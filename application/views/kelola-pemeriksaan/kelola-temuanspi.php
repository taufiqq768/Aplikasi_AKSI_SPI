<title>AKSI | Kelola Pemeriksaan</title>
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Kelola Pemeriksaan </h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Form Pemeriksaan <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">&nbsp;                       
                  <li><a class="close-link"><i class=""></i></a>
                  </li>
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <?php 
                  if ($this->session->flashdata('kirimrekom_tokabag')!=null) { 
                    echo "<div class='alert alert-success' role='alert' id='forpesan'><em class='fa fa-lg fa-check-circle-o'>&nbsp;</em>".$this->session->flashdata('kirimrekom_tokabag')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                  }
                  if ($this->session->flashdata('simpan')!=null) { 
                    echo "<div class='alert alert-info' role='alert' id='forpesan'><em class='fa fa-lg fa-check-circle-o'>&nbsp;</em>".$this->session->flashdata('simpan')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                  }
                  if ($this->session->flashdata('kirim')!=null) { 
                    echo "<div class='alert alert-success' role='alert' id='forpesan'><em class='fa fa-lg fa-check-circle-o'>&nbsp;</em>".$this->session->flashdata('kirim')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                  }
                ?>
                <div class="table-responsive"> 
                    <table class="tile_info">
                        <tbody>
                      <?php foreach ($record as $value) { ?>
                      <tr>
                        <th scope="row" style="width: 150px">Jenis Audit</th>
                        <td>: <?php echo $value['pemeriksaan_jenis']; ?></td>
                      </tr>
                      <tr>
                        <th style="width: 150px">Judul</th>
                        <td>: <?php echo $value['pemeriksaan_judul']; ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Unit</th>
                        <td>: <?php echo $value['unit_nama']; ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Tanggal Pemeriksaan</th>
                        <td>: <?php 
                              $mulai = explode("-", $value['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $value['pemeriksaan_tgl_akhir']);
                              $tgl =  $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                              echo $tgl; ?>
                        </td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Nama Petugas SPI</th>
                        <td>:
                         <?php 
                          $select  = explode("/", $value['pemeriksaan_petugas']);
                          $nama = [];
                          foreach ($select as $nik) {
                            $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $nik))->row_array();
                            $nama[] = $usr['user_nama'];
                          }
                          $petugas = implode(", ", $nama);
                        ?> 
                          <?php echo $petugas; ?> 
                        </td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Dokumen</th>
                        <td>: 
                          <?php if ($value['pemeriksaan_doc']!=null): ?>
                          <a target="_BLANK" title="Lihat Data" href="<?php echo base_url(); ?>asset/file_pemeriksaan/<?php echo $value['pemeriksaan_doc']?>"><font size="2">
                         <?php  echo $value['pemeriksaan_doc'] ?></font></a> 
                        <?php else:  echo "-"; 
                              endif ?>
                        </td>
                      </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  <?php 
                      $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
                      $id_pmr = $this->uri->segment(3);
                      if ($this->session->level=="spi") {
                        if (in_array($this->session->username, $select)) {
                          $dis = "";
                        }else{
                          $dis = "disabled";
                        }
                      }else{
                       $dis = "";
                      }
                  //setting disable untuk pemeriksaan sebelumnya jika ada data yang terbawa ke pemeriksaan baru
                   $disable = '';
                   $countpmr = [];
                   $ambilpmr = $this->db->query("SELECT pemeriksaan_sebelumnya FROM tb_pemeriksaan")->result_array();
                   foreach ($ambilpmr as $key => $value) {
                      $explode = explode(" ", $value['pemeriksaan_sebelumnya']);
                      foreach ($explode as $k => $val) {
                        $countpmr[] = $val;
                      }
                    } 
                    if (in_array($id_pmr, $countpmr)) {
                      $disable = "disabled";
                    }
                      echo "<div class='row'><a href='".base_url()."administrator/tambah_temuan/$id_pmr'>" ?><button type="button" class="btn btn-primary tambah-lagi pull-right" <?php  echo strpos($role[0]['role_akses'],',3,')!==FALSE?"":"disabled";?> <?php echo $dis; echo $disable; ?>><i class="fa fa-plus"></i> Temuan Rekomendasi</button></a></div>
                  <?php 
                    $bdgtemuan = $this->db->query("SELECT * FROM tb_bidangtemuan ORDER BY bidangtemuan_id ASC")->result_array(); 
                    $atribut = array('class'=>'form-horizontal','role'=>'form');
                    echo form_open('administrator/multikirim_temuanrekom_tokabag/'.$id_pmr,$atribut); 
                  ?>
                  <button type="submit" name="kirim" class="btn btn-xs btn-success" <?php  echo strpos($role[0]['role_akses'],',26,')!==FALSE?"":"disabled";?><?php echo $dis; echo $disable; ?>><span class="fa fa-send"></span> Kirim Temuan</button>
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <?php foreach ($bdgtemuan as $nilai) {
                      $aktif = ""; 
                      if ($nilai['bidangtemuan_id']==1) {
                        $aktif = "active";
                      }
                    ?>
                      <li role="presentation" class="<?php echo $aktif ?>"><a href="#tab_content<?php echo $nilai['bidangtemuan_id']?>" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo $nilai['bidangtemuan_nama']; ?></a>
                    </li>
                    <?php } ?>
                    </ul>
                      <div id="myTabContent" class="tab-content">
                        <?php foreach ($bdgtemuan as $nilai) { 
                          $aktif2 = ""; 
                          if ($nilai['bidangtemuan_id']==1) {
                            $aktif2 = "fade active in";
                          }else{
                            $aktif2 = "fade";
                          }
                        ?>
                        <div role="tabpanel" class="tab-pane <?php echo $aktif2 ?>" id="tab_content<?php echo $nilai['bidangtemuan_id']?>" aria-labelledby="home-tab">
                          <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 table-responsive">
                          <table class="table table-bordered table-striped datatable">
                            <thead>
                              <tr>
                                <th><input type="checkbox" class="select_all" value="ck<?php echo $nilai['bidangtemuan_id'] ?>" /></th>
                                <th>No.</th>
                                <th>Temuan</th>
                                <th>Rekomendasi</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $id_bidang = $nilai['bidangtemuan_id'];
                              $temuan = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id WHERE bidangtemuan_id='$id_bidang' AND tb_temuan.pemeriksaan_id = '$id_pmr' ORDER BY tb_temuan.temuan_id")->result_array();
                              $no = 1;
                              foreach ($temuan as $key => $row) { ?>
                              <tr>
                                <td>
                                  <?php if ($row['rekomendasi_publish_kabag']=="N"): ?>
                                  <input type="checkbox" class="form-control checkbox ck<?php echo $row['bidangtemuan_id'] ?> " name="select[]" value="<?php echo $row['rekomendasi_id']?>">  
                                  <?php endif ?>
                                  </td>
                                <td><?= $no.".";?></td>
                                <td>
                                  <?php if ($row['temuan_pmr_sebelumnya']!='0'){
                                        $pmr = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$row['temuan_pmr_sebelumnya']);
                                    echo "<i class='fa fa-caret-right'></i><b>Temuan dari Pemeriksaan : </b><br>".$pmr[0]['pemeriksaan_judul']."<br>";
                                  }
                                  ?>
                                  <b><?php echo "(".$row['temuan_obyek'].")"; ?></b><br>
                                  <?= $row['temuan_judul']; ?>
                                </td>
                                <td><?= $row['rekomendasi_judul']; ?></td>
                                <td>
                                  <?php 
                                  if ($row['rekomendasi_publish_kabag']=='Y' AND $row['rekomendasi_kirim']=='N') {
                                      echo "Terkirim ke Kabag";
                                  }elseif ($row['rekomendasi_publish_kabag']=='N' AND $row['rekomendasi_kirim']=='N') {
                                      echo "Belum Terkirim";
                                  }elseif ($row['rekomendasi_kirim']=='Y' AND $row['rekomendasi_kirim']=='Y') {
                                      echo "Telah disetujui oleh Kabag";
                                  }elseif ($row['rekomendasi_kirim']=='K') {
                                      echo "<span class='red'>Dikembalikan</span>";
                                  } ?>
                                </td>
                                <td>
                                  <center>
                                  <?php if ($row['rekomendasi_publish_kabag']=="N"): ?>
                                  <a href="<?php echo base_url(); ?>administrator/kirimrekom_tokabag/<?php echo $row['pemeriksaan_id']?>/<?php echo $row['temuan_id']?>/<?php echo $row['rekomendasi_id'] ?>"><button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Kirim ke Kabag" <?php echo $disable; ?> <?php  echo strpos($role[0]['role_akses'],',26,')!==FALSE?"":"disabled";?>><i class="fa fa-send"></i></button></a>
                                  <a href="<?php echo base_url(); ?>administrator/edit_temuanspi/<?php echo $row['pemeriksaan_id']?>/<?php echo $row['temuan_id']?>/<?php echo $row['rekomendasi_id']?>"><button type="button" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Edit Temuan dan Rekomendasi" <?php echo $dis; echo $disable; ?> <?php  echo strpos($role[0]['role_akses'],',4,')!==FALSE?"":"disabled";?>><i class="fa fa-edit"></i> Edit</button></a>
                                  <a href="<?php echo base_url(); ?>administrator/delete_temuanspi/<?php echo $row['pemeriksaan_id']?>/<?php echo $row['temuan_id']?>/<?php echo $row['rekomendasi_id']?>"><button type="button" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus Data ini ?');"  <?php  echo strpos($role[0]['role_akses'],',5,')!==FALSE?"":"disabled";?> <?php echo $dis; echo $disable; ?>><i class="fa fa-trash"></i> Hapus</button></a>
                                  <?php endif ?>
                                  </center>
                                  <center>
                                  <a href="<?php echo base_url(); ?>administrator/list_tanggapantl/<?php echo $row['pemeriksaan_id']?>/<?php echo $row['temuan_id']?>/<?php echo $row['rekomendasi_id']?>"><button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="bottom" title="Lihat Tanggapan Manajer dan TL">Kelola Tanggapan dan TL</button></a>
                                  </center>
                                  
                                </td>
                              </tr>
                        <?php $no++;
                              } ?>
                            </tbody>
                          </table>
                          </div>
                        </div>
                        <?php } ?>
                        <?php echo form_close(); ?>
                      </div>
                    </div>
                  </div>
<!-- ------------------------------------------------------------------------------- -->                    
                  
              </div>
            </div>
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
      $(document).ready(function(){
        $('.datatable').DataTable({
           "ordering": false,
           "bInfo" : false,
           "bLengthChange": false,
           "searching": false,
           "scrollX": false           
        });
      });
    </script>
    <script type="text/javascript">
      $('#bt-remove').on('click', function(){
        $('#forpesan').remove();
      });
      
    </script>
   
    <script type="text/javascript">
     var i=1;
    $(document).ready(function(){
        $('.select_all').on('click',function(){
            if(this.checked){
                $('.'+this.value).each(function(){
                    this.checked = true;
                });
            }else{
                 $('.'+this.value).each(function(){
                    this.checked = false;
                });
            }
        });
        
        $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('.select_all').prop('checked',true);
            }else{
                $('.select_all').prop('checked',false);
            }
        });
    });
    </script>
    