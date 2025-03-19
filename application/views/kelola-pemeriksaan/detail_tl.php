  <title>AKSI | Detail Tindak Lanjut </title>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>
                    <?php 
                      $id_pmr = $this->uri->segment(3);$id_temuan = $this->uri->segment(4); $id_rekom = $this->uri->segment(5);
                      //setting disable untuk pemeriksaan sebelumnya jika ada data yang terbawa ke pemeriksaan baru
                     $disable2 = '';
                     $countpmr = [];
                     $ambilpmr = $this->db->query("SELECT pemeriksaan_sebelumnya FROM tb_pemeriksaan")->result_array();
                     foreach ($ambilpmr as $keya => $valuea) {
                        $explode = explode(" ", $valuea['pemeriksaan_sebelumnya']);
                        foreach ($explode as $ka => $vala) {
                          $countpmr[] = $vala;
                        }
                      } 
                      // print_r($countpmr);
                      if (in_array($id_pmr, $countpmr)) {
                        $disable2 = "disabled";
                      }
                      echo "<a href='".base_url()."administrator/view_temuan/$id_pmr'"?>
                      <button class="btn btn-xs btn-default" type="button"><i class="fa fa-mail-reply"></i></button>
                      </a>
                    Detail Tindak Lanjut</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <?php $id_tl = $this->uri->segment(6); 
                  $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
                  ?>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                        <!-- <table class="table table-responsive tile-info"> -->
                        <table class="table table-responsive table-bordered">
                          <?php foreach ($record as $value) { 
                             $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $value['bidangtemuan_id']))->row_array();
                          ?>
                          <tr>
                            <th style="width: 15%">Pemeriksaan</th>
                            <td>:  <?php echo $value['pemeriksaan_judul']; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Bidang</th>
                            <td>:  <?php echo $bidang['bidangtemuan_nama']; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Temuan</th>
                            <td>:  <?php echo $value['temuan_judul']; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Rekomendasi</th>
                            <td>:  <?php echo $value['rekomendasi_judul']; ?></td>
                          </tr>
                           <tr>
                            <th style="width: 15%">Tindak Lanjut</th>
                            <td>: <?php echo $value['tl_deskripsi']; ?></td>
                          </tr>
                          <tr>
                            <th style="width: 15%">Tgl. Tindak Lanjut</th>
                            <td>:  <?php $tgl = explode("-", $value['tl_tgl']); echo $tgl[2]."-".$tgl[1]."-".$tgl[0]; ?></td>
                          </tr>
                          <?php  
                          //cek petugas spi
                            $select  = explode("/", $value['pemeriksaan_petugas']);
                            $nama = [];
                              if ($this->session->level=="spi") {
                                if (in_array($this->session->username, $select)) {
                                  $dis = "";
                                }else{
                                  $dis = "disabled";
                                }
                              }else{
                               $dis = "";
                              }
                          ?>
                          <tr>
                            <th style="width: 15%">Tanggapan</th>
                            <td>: <?php 
                                  if ($value['tl_tanggapan']==null AND ($value['rekomendasi_status']=="Belum di Tindak Lanjut" OR $value['rekomendasi_status']=="Dikembalikan")) {
                                    ?> 
                                    <?php if ($this->session->level=="spi"): ?>
                                    <button type="button" class="btn btn-primary btn-xs" title="Tambah Tanggapan" data-toggle="modal" data-target="#add"<?php  echo strpos($role[0]['role_akses'],'11')!==FALSE?"":"disabled"; ?><?php echo $disable2; echo $dis; ?>><span class="fa fa-plus"></span> Tanggapan</button>
                                   <?php endif ?>
                                    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                         <div class="modal-header">
                                          <div class="row">
                                            <h4 class="modal-title"><strong>Kelola Tanggapan Tindak Lanjut</strong>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button></h4>
                                          </div>
                                          </div>
                                          <div class="modal-body">
                                          <?php 
                                            $id_pmr = $this->uri->segment(3);
                                             $attributes = array('class'=>'form-horizontal','role'=>'form');
                                             echo form_open('administrator/status_tl_kirimkabag/'.$id_pmr,$attributes);
                                              echo "<div class='form-group'><input type='hidden' name='id' value='$id_tl'></div>";
                                              echo "<div class='form-group'><input type='hidden' name='id_rekom' value='$value[rekomendasi_id]'></div>";
                                           ?>
                                              <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                                <div class="input-group col-md-8 col-sm-8 col-xs-12">
                                                <select name="status" id="status" class="form-control">
                                                 <!-- <option ><?php //echo $row['rekomendasi_status']; ?></option> -->
                                                 <option value="Sesuai" <?php if ($value['rekomendasi_status_cache']=="Sesuai") {echo "selected";}?>>Sesuai</option>
                                                 <option value="Belum Sesuai" <?php if ($value['rekomendasi_status_cache']=="Belum Sesuai") {echo "selected";}?>>Belum Sesuai</option>
                                                 <option value="Belum di Tindak Lanjut" <?php if ($value['rekomendasi_status_cache']=="Belum di Tindak Lanjut") {echo "selected";}?>>Belum di Tindak Lanjut</option>
                                                 <option value="Tidak dapat di Tindak Lanjuti" <?php if ($value['rekomendasi_status_cache']=="Tidak dapat di Tindak Lanjuti") {echo "selected";}?>>Tidak dapat di Tindak Lanjuti</option>
                                                </select>
                                                </div>
                                              </div>
                                               <div class="form-group" id="tanggap">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggapan</label>
                                                  <div class="input-group col-md-8 col-sm-8 col-xs-12">
                                                  <textarea class="form-control" rows="5" placeholder="Masukkan Deskripsi Tanggapan" name="tanggapan"><?php echo $value['tl_tanggapan']; ?></textarea>
                                                  </div>
                                               </div>
                                          </div><div class="modal-footer">
                                            <div class="form-group">
                                              <div class="col-md-12 col-sm-12 col-xs-12">
                                              <button type="submit" name="simpan" class="btn btn-sm btn-primary pull-right">Simpan Draft</button>
                                              <button type="submit" name="kirim" class="btn btn-sm btn-success pull-right">Kirim</button>
                                              </div>
                                            </div>
                                            </div>
                                          <?php echo form_close(); ?>
                                        </div>
                                      </div>
                                    </div>
                                    <?php
                                  }elseif($value['tl_tanggapan_publish_kabag']=='N' AND $value['tl_tanggapan']!=null){ 
                                    echo $value['tl_tanggapan'];
                                    if ($value['tl_tanggapan_publish_kabag']=="N" AND $value['tl_status_from_spi']=='N') {
                                      $editable = "Edit ";
                                      $disable = "";
                                    }else{
                                      $editable = "";
                                      $disable = "disabled";
                                    }
                                    ?>
                                    <?php if ($this->session->level=="spi"): ?>
                                    <button type="button" class="btn btn-primary btn-xs" title="Tambah Tanggapan" data-toggle="modal" data-target="#editTL" <?php echo $disable; echo $dis;?><?php  echo strpos($role[0]['role_akses'],'11')!==FALSE?"":"disabled"; ?>><span class="fa fa-plus"></span> <?php echo $editable; echo $disable2; ?>Tanggapan</button>
                                    <?php endif ?>
                                    <div class="modal fade" id="editTL" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                         <div class="modal-header">
                                          <div class="row">
                                            <h4 class="modal-title"><strong>Kelola Tanggapan Tindak Lanjut</strong>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button></h4>
                                          </div>
                                          </div>
                                          <div class="modal-body">
                                          <?php 
                                            $id_pmr = $this->uri->segment(3);
                                             $attributes = array('class'=>'form-horizontal','role'=>'form');
                                             echo form_open('administrator/status_tl_kirimkabag/'.$id_pmr,$attributes);
                                              echo "<div class='form-group'><input type='hidden' name='id' value='$id_tl'></div>";
                                              echo "<div class='form-group'><input type='hidden' name='id_rekom' value='$value[rekomendasi_id]'></div>";
                                           ?>
                                              <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                                <div class="input-group col-md-8 col-sm-8 col-xs-12">
                                                <select name="status" id="status" class="form-control">
                                                 <!-- <option ><?php //echo $row['rekomendasi_status']; ?></option> -->
                                                 <option value="Sesuai" <?php if ($value['rekomendasi_status_cache']=="Sesuai") {echo "selected";}?>>Sesuai</option>
                                                 <option value="Belum Sesuai" <?php if ($value['rekomendasi_status_cache']=="Belum Sesuai") {echo "selected";}?>>Belum Sesuai</option>
                                                 <option value="Belum di Tindak Lanjut" <?php if ($value['rekomendasi_status_cache']=="Belum di Tindak Lanjut") {echo "selected";}?>>Belum di Tindak Lanjut</option>
                                                 <option value="Tidak dapat di Tindak Lanjuti" <?php if ($value['rekomendasi_status_cache']=="Tidak dapat di Tindak Lanjuti") {echo "selected";}?>>Tidak dapat di Tindak Lanjuti</option>
                                                </select>
                                                </div>
                                              </div>
                                               <div class="form-group" id="tanggap">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggapan</label>
                                                  <div class="input-group col-md-8 col-sm-8 col-xs-12">
                                                  <textarea class="form-control" rows="5" placeholder="Masukkan Deskripsi Tanggapan" name="tanggapan"><?php echo $value['tl_tanggapan']; ?></textarea>
                                                  </div>
                                               </div>
                                          </div><div class="modal-footer">
                                            <div class="form-group">
                                              <div class="col-md-12 col-sm-12 col-xs-12">
                                              <button type="submit" name="simpan" class="btn btn-sm btn-primary pull-right">Simpan Draft</button>
                                              <button type="submit" name="kirim" class="btn btn-sm btn-success pull-right">Kirim</button>
                                              </div>
                                            </div>
                                            </div>
                                          <?php echo form_close(); ?>
                                        </div>
                                      </div>
                                    </div> <?php 
                                  }elseif($value['tl_tanggapan']!=null){
                                    if ($this->session->level=="spi" OR $this->session->level=="admin" or $this->session->level=="viewer") {
                                      echo $value['tl_tanggapan'];  
                                    }elseif ($this->session->level=="kabagspi" AND $value['tl_tanggapan_publish_kabag']=='Y') {
                                      echo $value['tl_tanggapan'];
                                    }
                                    
                                  }  ?>
                            </td>
                          </tr>
                          
                          <?php } ?>
                        </table>
                        </div>
                      </div>
                  <hr>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                   <div class="table-responsive">
                      <table class="table table-bordered tabel-striped">
                        <thead>
                          <th style="width: 5%">No.</th>
                          <th style="width: 60%">File Tindak Lanjut</th>
                          <th style="width: 15%">Tgl. Upload</th>
                         
                        </thead>
                        <tbody>
                          <?php 
                          $no =1;
                          foreach ($record2 as $baris) { ?>
                          <tr>
                            <td><?php echo $no."."; ?></td>
                            <td><a target="_BLANK" title="Lihat Data" href="<?php echo base_url(); ?>/asset/file_tl/<?php echo $baris['uploadtl_nama']?>"><?php echo $baris['uploadtl_nama']; ?></a></td>
                            <td><?php $tgl = explode("-", $baris['uploadtl_tgl']);
                            echo $tgl[2]."-".$tgl[1]."-".$tgl[0]; ?></td>
                          </tr>
                          <?php $no++; } ?>
                        </tbody>
                      </table>
                      </div>
                  </div>
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