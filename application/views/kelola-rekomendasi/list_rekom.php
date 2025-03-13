  <title>PTPN XII | List Rekomendasi</title>
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
                  <!-- setting disable untuk pemeriksaan sebelumnya jika ada data yang terbawa ke pemeriksaan baru-->
                  <?php 
                   $disable = '';
                   $countpmr = [];
                   $ambilpmr = $this->db->query("SELECT pemeriksaan_sebelumnya FROM tb_pemeriksaan")->result_array();
                   foreach ($ambilpmr as $key => $value) {
                      $explode = explode(" ", $value['pemeriksaan_sebelumnya']);
                      foreach ($explode as $k => $val) {
                        $countpmr[] = $val;
                      }
                    } 
                    // print_r($countpmr);
                    if (in_array($id_pmr, $countpmr)) {
                      $disable = "disabled";
                    }
                    
                  ?>
                    <h2>
                      <?php 
                      echo "<a href='".base_url()."administrator/input_spi/$id_pmr'"?>
                      <button class="btn btn-xs btn-default" type="button"><i class="fa fa-mail-reply"></i> </button>
                      </a> List Rekomendasi
                    </h2>
                      <?php
                        $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
                        $cek = $this->db->query("SELECT * FROM tb_pemeriksaan WHERE pemeriksaan_id='$id_pmr'")->result_array();
                        $petugas =  explode("/", $cek[0]['pemeriksaan_petugas']);
                        if ($this->session->level=="spi") {
                          if (in_array($this->session->username, $petugas)) {
                            $dis = "";
                          }else{
                            $dis = "disabled";
                          }
                        }else{
                         $dis = "";
                        }
                        ?>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <?php 
                   //var_dump($this->model_app->select_tabel($jenis)->result_array());
                   $ket = '';
                     if ($this->session->flashdata('gagal')!=null) {
                        echo "<div class='alert alert-danger' role='alert' id='forpesan'><center><strong><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('gagal')."</strong><a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></center></a></div>";
                     }
                     
                     if ($this->session->flashdata('kirimrekom_tokabag')!=null){
                        echo "<div class='alert alert-success' role='alert' id='forpesan'><center><strong><em class='fa fa-lg fa-check-circle-o'>&nbsp;</em>".$this->session->flashdata('kirimrekom_tokabag')."</strong><a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></center></a></div>";
                     }
                     if ($this->session->flashdata('gagalkirim')!=null) {
                        echo "<div class='alert alert-danger' role='alert' id='forpesan'><center><strong><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('gagalkirim')."</strong><a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></center></a></div>";
                     }
                     
                  ?>
                  <?php $judulpmr = $this->model_app->view_select_where('pemeriksaan_judul','tb_pemeriksaan','pemeriksaan_id',$id_pmr);  ?>
                  <table class="table table-responsive">
                    <tr>
                      <th style="width: 15%">Pemeriksaan</th>
                      <td>: <?php echo $judulpmr[0]->pemeriksaan_judul; ?></td>
                    </tr>
                    <tr>
                      <th style="width: 15%">Bidang</th>
                      <td>: <?php  foreach($record2 as $value) { 
                        $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $value['bidangtemuan_id']))->row_array();
                        echo $bidang['bidangtemuan_nama'];} ?></td>
                    </tr>
                    <tr>
                      <th style="width: 15%">Klasifikasi Temuan</th>
                      <td>: <?php  foreach($record2 as $value) { 
                        $bidang = $this->model_app->view_profile('tb_master_temuan', array('temu_id'=> $value['temu_id']))->row_array();
                        echo $bidang['klasifikasi_temuan'];} ?></td>
                    </tr>
                    <tr>
                      <th style="width: 15%">Klasifikasi Penyebab</th>
                      <td>: 
                        <?php  
                        foreach($record2 as $value) { 
                            $pecah = explode("/", $value['sebab_id']); // Pecah sebab_id menjadi array
                            $hasil = []; // Array untuk menyimpan klasifikasi_sebab
                            
                            foreach ($pecah as $id) {
                                $bidang = $this->model_app->view_profile('tb_master_penyebab', array('sebab_id' => $id))->row_array();
                                if ($bidang) { // Periksa apakah data ditemukan
                                    $hasil[] = $bidang['klasifikasi_sebab']; // Tambahkan ke hasil
                                }
                            }
                            
                            echo implode(", ", $hasil); // Gabungkan hasil dengan pemisah koma
                        } 
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <th style="width: 15%">Klasifikasi COSO</th>
                      <td>: <?php  foreach($record2 as $value) { 
                        $bidang = $this->model_app->view_profile('tb_master_coso', array('coso_id '=> $value['coso_id']))->row_array();
                        echo $bidang['klasifikasi_coso'];} ?></td>
                    </tr>
                    <tr>
                      <th style="width: 15%">Temuan</th>
                      <td>: <?php  foreach($record2 as $value) { echo $value['temuan_judul'];} ?></td>
                    </tr>
                    
                  </table>
                  <?php 
                      $attributes = array('class'=>'form-horizontal');
                      echo form_open('administrator/multikirimrekom_tokabag/'.$id_pmr.'/'.$id_temuan,$attributes);
                      ?>
                  <!-- <button type="submit" name="kirim" class="btn btn-xs btn-success" <?php  //echo strpos($role[0]['role_akses'],',27,')!==FALSE?"":"disabled"; echo $disable; echo $dis; ?>><span class="fa fa-send"></span> Kirim Rekomendasi ke Kadiv DSPI</button> -->
                  <div class="row"> 
                      <?php echo "<a href='".base_url()."administrator/input_rekomendasi/$id_pmr/$id_temuan'>" ?><button type="button" class="btn btn-primary tambah-lagi pull-right" <?php  echo strpos($role[0]['role_akses'],',8,')!==FALSE?"":"disabled";?> <?php echo $dis; echo $disable; ?>>Tambah Rekomendasi</button></a>
                  </div>
                  <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th><input type="checkbox" id="select_all" /></th>
                          <th>No.</th>
                          <th style="width: 350px"><center>Rekomendasi</center></th>
                          <th style="width: 170px"><center>Klasifikasi Rekomendasi</center></th>
                          <th style="width: 170px"><center>Dokumen</center></th>
                          <th style="width: 70px"><center>Tanggal Deadline</center></th>
                          <th style="width: 135px"><center>Status</center></th>
                          <th style="width: 110px"><center>Action</center></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            $no = 1;
                            $id_pmr = $this->uri->segment(3);
                            $id_temuan = $this->uri->segment(4);
                             foreach ($record as $row) { 
                              if ($row['rekomendasi_aktif']=="Y") {
                                $aktif = "Aktif";
                              }else{
                                $aktif = "Non-Aktif";
                              }
                              if ($row['rekomendasi_status']=="Sudah di Tindak Lanjut") {
                                $status = "<span class='btn btn-round btn-xs btn-success'>".$row['rekomendasi_status']."</span></td>";
                              }elseif ($row['rekomendasi_status']=="Belum di Tindak Lanjut") {
                                $status = "<span class='btn btn-round btn-xs btn-danger'>".$row['rekomendasi_status']."</span></td>";
                              }elseif($row['rekomendasi_status']=="Sudah TL (Belum Optimal)"){
                                $status = "<span class='btn btn-round btn-xs btn-warning'>".$row['rekomendasi_status']."</span></td>";
                              }elseif($row['rekomendasi_status']=="Dikembalikan"){
                                $status = "<span class='btn btn-round btn-xs btn-info'>".$row['rekomendasi_status']."</span></td>";
                              }
                            ?>
                            <tr>
                              <td>
                                <?php if ($row['rekomendasi_publish_kabag']=="N"): ?>
                                      <input type="checkbox" class="form-control checkbox" name="select[]" value="<?php echo $row['rekomendasi_id']?>">  
                                <?php endif ?>
                              </td>
                              <td><?php echo $no."."; ?></td>
                              <td><?php echo $row['rekomendasi_judul']; ?></td>
                              <td>
                                <?php
                                 $id_rekomen=$row['rekomen_id'];
                                 $m_rekomen = $this->model_app->view_where('tb_master_rekomendasi','rekomen_id',$id_rekomen);
                                 if (!empty($m_rekomen)) {
                                  echo $m_rekomen[0]['judul'];
                                  } else {
                                      echo "-";
                                  }
                                ?>
                              </td>
                                <?php if ($row['rekomendasi_kirim']=='K') {
                                  echo " <i class='fa fa-circle' style='color: red'></i>";
                                } ?>
                              </td>
                              <td>
                                <?php $hot = $this->model_app->view_where_ordering('rekomendasi_id','tb_upload_rekom',$row['rekomendasi_id'],'uploadrekom_id','ASC');
                                  $this->load->helper('directory'); 
                                  $map = directory_map('asset');
                                    foreach ($hot as $value) {
                                      echo "-";?><a target="_BLANK" title="Lihat Data" href="<?php echo base_url(); ?>/asset/file_rekomendasi/<?php echo $value['uploadrekom_nama']?>"><?php echo $value['uploadrekom_nama']; ?></a> <br>
                                    <?php }
                                  ?>
                                <?php if ($row['rekomendasi_aktif']=='Y') {
                                   $placeholder = 'Nok-Aktifkan';
                                }else{
                                  $placeholder = 'Aktifkan';
                                } ?>
                              </td>
                              <td><center><?php $tgl =  explode('-', $row['rekomendasi_tgl_deadline']); echo $tgl[2]."-".$tgl[1]."-".$tgl[0] ?></center></td>
                              <td><center><?php echo $status; ?></center></td>
                              <td>
                                  <?php if ($row['rekomendasi_publish_kabag']=='N') { ?>
                                    <?php  // echo "<a href='".base_url()."administrator/kirimrekom_tokabag/$id_pmr/$id_temuan/$row[rekomendasi_id]'>" ?>
                                      <!-- <button class="btn btn-sm btn-primary" type="button" title="Kirim Rekomendasi ke Kabag" <?php  //echo strpos($role[0]['role_akses'],',27,')!==FALSE?"":"disabled"; echo $disable; echo $dis; ?>><span class="fa fa-send-o"></span></button></a> -->

                                   <?php   echo "<a href='".base_url()."administrator/edit_rekomendasi/$id_pmr/$id_temuan/$row[rekomendasi_id]'"?><button type="button" class="btn btn-warning btn-sm" <?php  echo strpos($role[0]['role_akses'],',9,')!==FALSE?"":"disabled";?> <?php echo $dis; echo $disable; ?>><span class="fa fa-pencil"></button></a>

                                  <?php   echo "<a href='".base_url()."administrator/delete_rekomendasi/$id_pmr/$id_temuan/$row[rekomendasi_id]'"?><button type="button" class="btn btn-danger btn-sm" onclick="return confirm('Apa anda yakin untuk hapus Rekomendasi ini?')" <?php  echo strpos($role[0]['role_akses'],'10')!==FALSE?"":"disabled";?> <?php echo $dis; echo $disable;?>><span class="fa fa-trash"></span></button></a>  
                                  <?php }else{
                                    echo "<center>Terkirim ke KADIV DSPI</center>";
                                  } ?>
                              </td>
                            </tr>
                            <?php $no++; } ?>
                          </tbody>
                        </table>
                        <?php echo form_close(); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /page content -->

      <!-- footer content -->
      <!-- <footer class="fixed_footer">
        <div class="pull-right">
          PT. Perkebunan Nusantara XII
        </div>
        <div class="clearfix"></div>
      </footer> -->
      <!-- /footer content -->
    <!-- </div>
  </div> -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
        <h5 class="modal-title" id="exampleModalLabel"><h4><strong>Tambah Rekomendasi</strong></h4></h5>
      </div>
      <div class="modal-body">
       <?php 
        $id_pmr = $this->uri->segment(3);
        $id_temuan = $this->uri->segment(4);
         $attributes = array('class'=>'form-horizontal','role'=>'form', 'id'=>'demo-form2');
         echo form_open_multipart('administrator/input_rekomendasi/'.$id_pmr.'/'.$id_temuan,$attributes);
       ?>
           <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" >Rekomendasi <span class="required">*</span>
             </label>
             <div class="col-md-9 col-sm-9 col-xs-12">
               <textarea class="resizable_textarea form-control" rows="8" placeholder="Masukkan Deskripsi Rekomendasi" name="a"></textarea>
             </div>
           </div>
      </div>
      <div class="modal-footer">
        <div class="form-group">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <button type="submit" name="simpan" class="btn btn-sm btn-primary pull-right">Simpan Draft</button>
           <button type="submit" name="kirim" class="btn btn-sm btn-success pull-right">Kirim</button>
        </div>
      </div>
      <?php echo form_close(); ?>
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
      $('#bt-remove').on('click', function(){
        $('#forpesan').remove();
      });
    </script>
 