    <title>PTPN XII | Laporan Tabular</title>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
  
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Pencarian Data</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php  
                      if ($this->session->flashdata('gagal')!=null) {
                        echo "<div class='alert alert-danger' role='alert' id='forpesan'><center><strong><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('gagal')."</strong><a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></center></a></div>";
                      }
                      if ($this->session->flashdata('berhasil')!=null) {
                        echo "<div class='alert alert-success' role='alert' id='forpesan'><center><strong><em class='fa fa-lg fa-check-circle-o'>&nbsp;</em>".$this->session->flashdata('berhasil')."</strong><a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></center></a></div>";
                      }
                    ?>
                    <div class="col-lg-4 col-xs-12 col-md-6">
                        <?php 
                        $attributes = array('class'=>'form-horizontal','role'=>'form', 'id'=>'myform');
                        echo form_open('data/cari_data',$attributes);
                       ?>
                      <div id="pemeriksaan">
                        <div class="form-group">
                          <label><b>Pemeriksaan : </b></label><br>
                          <?php $pmr = $this->model_app->view_ordering('tb_pemeriksaan', 'pemeriksaan_id', 'ASC'); ?>
                          <select class="select2_single form-control" name="judul_pmr" id="judul_pmr">
                            <option></option>
                            <?php foreach ($pmr as $key => $value) { ?>
                                  <option value="<?php echo $value['pemeriksaan_id']?>"><?php echo $value['pemeriksaan_judul']; ?></option> 
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div id="data">
                        <div class="form-group">
                          <label><b>Data yang dicari : </b></label>
                          <select class="select2_single form-control" name="data" id="data">
                            <option value="temuan">Temuan</option>
                            <option value="rekomendasi">Rekomendasi</option>
                            <option value="tl">Tindak Lanjut</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right" name="submit"> Submit</button>
                        </div>
                      </div>
                      <?php echo form_close(); ?>
                      <?php if ($record2!=null): ?>

                      <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="datatable">
                          <thead>
                            <tr>
                              <th style="width: 5%">No.</th>
                              <?php if ($cari == 'temuan'): ?>
                              <th style="width: 20%">Obyek Pemeriksaan</th>
                              <th style="width: 60%">Temuan</th>  
                              <?php endif ?>
                              <?php if ($cari == 'rekomendasi'): ?>
                              <th style="width: 60%">Rekomendasi</th>
                              <th style="width: 20%">Status</th>  
                              <?php endif ?>
                              <?php if ($cari == 'tl'): ?>
                              <th style="width: 60%">Tindak Lanjut</th>
                              <th style="width: 20%">Status</th>  
                              <?php endif ?>
                              <th style="width: 15%">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
                            $no = 1;
                            
                              foreach ($record2 as $key => $value) { ?>
                              
                            <tr>
                              <td><?= $no."."; ?></td>
                              <?php if ($cari=='temuan'): ?>
                              <td><?= $value['temuan_obyek'] ?></td>
                              <td><?= $value['temuan_judul'] ?></td>  
                              <?php endif ?>
                              <?php if ($cari=='rekomendasi'): ?>
                              <?php if ($value['rekomendasi_status']=='Sudah di Tindak Lanjut') {
                                $status = "<span class='btn btn-xs btn-round btn-success'>".$value['rekomendasi_status']."</span>";
                              }elseif ($value['rekomendasi_status']=='Belum di Tindak Lanjut') {
                                $status = "<span class='btn btn-xs btn-round btn-danger'>".$value['rekomendasi_status']."</span>";
                              }elseif ($value['rekomendasi_status']=='Sudah TL (Belum Optimal)') {
                                $status = "<span class='btn btn-xs btn-round btn-warning'>".$value['rekomendasi_status']."</span>";
                              }elseif ($value['rekomendasi_status']=='Dikembalikan') {
                                $status = "<span class='btn btn-xs btn-round btn-info'>".$value['rekomendasi_status']."</span>";
                              }else{
                                $status = "<span class='btn btn-xs btn-round btn-dark'>".$value['rekomendasi_status']."</span>";
                              } ?>
                              <td><?= $value['rekomendasi_judul'] ?></td>
                              <td><?= "<center>".$status."</center>" ?></td>  
                              <?php endif ?>
                              <?php if ($cari=='tl'): ?>
                              <td><?= $value['tl_deskripsi'] ?></td>
                              <td><?= $value['tl_status'] ?></td>  
                              <?php endif ?>
                              <td><center>
                                <?php if ($cari=='temuan'): ?>
                                  <?php   echo "<a href='".base_url()."data/delete_temuan/$value[temuan_id]'>" ?><button class="btn btn-xs btn-danger" onclick="return confirm('Apakah yakin data ini dihapus ?');"><span class="fa fa-trash"></span> Hapus</button></a>
                                <?php endif ?>
                                <?php if ($cari=='rekomendasi'): ?>
                                  <?php   echo "<a href='".base_url()."data/delete_rekomendasi/$value[rekomendasi_id]'>" ?><button class="btn btn-xs btn-danger" onclick="return confirm('Apakah yakin data ini dihapus ?');"><span class="fa fa-trash"></span> Hapus</button></a>
                                <?php endif ?>
                                <?php if ($cari=='tl'): ?>
                                  <?php   echo "<a href='".base_url()."data/delete_tl/$value[tl_id]'>" ?><button class="btn btn-xs btn-danger" onclick="return confirm('Apakah yakin data ini dihapus ?');"><span class="fa fa-trash"></span> Hapus</button></a>
                                <?php endif ?>
                              </center>
                              </td>
                            </tr>
                            <?php
                            $no++;  }
                            
                            ?>
                          </tbody>
                        </table>  
                      </div>
                      </div>          
                      <?php endif ?>
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
    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/iCheck/icheck.min.js"></script>
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
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/pdfmake/build/vfs_fonts.js"></script>
     <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/build/js/custom.min.js"></script>
    <script>
      $(document).ready(function () {
        $('#judul_pmr').select2({
          placeholder: "Pilih Judul Pemeriksaan"
        });
      });
    </script>

    <script type="text/javascript">
      $('#datatable').dataTable( {
          "scrollX": false,
          "ordering": false
        });
    </script>
    <script type="text/javascript">
      $('#bt-remove').on('click', function(){
        $('#forpesan').remove();
      });
    </script>
  </body>
</html>