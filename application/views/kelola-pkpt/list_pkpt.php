<title>PTPN I | List PKPT </title>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List PKPT<small>(AKSI)</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <?php $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);?>
                      <a href="./input_pkpt"><li><button type="button" class="btn btn-default btn-xs" <?php  echo strpos($role[0]['role_akses'],'15')!==FALSE?"":"disabled"; ?>>Tambah Data</button></a></li></a>
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php 
                     if ($this->session->flashdata('gagal')!=null) {
                        echo "<div class='alert alert-danger' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('gagal')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                       
                     }elseif ($this->session->flashdata('berhasil')!=null) {
                        echo "<div class='alert alert-success' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('berhasil')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                     }else{
                        echo '';
                     }
                    ?>
                    <div class="row">
                      <div class="col-md-2 col-sm-3 col-4"> 
                        <form method="GET">
                        <label for="tahun">Pilih Tahun:</label>
                          <select name="tahun" id="tahun" onchange="this.form.submit()" class="form-control">
                              <?php
                              $tahunSekarang = date('Y');
                              $tahunTerpilih = isset($_GET['tahun']) ? $_GET['tahun'] : $tahunSekarang;
                              for ($i = -1; $i <= 3; $i++) { // Menampilkan 3 tahun ke belakang dan ke depan
                                  $tahun = $tahunSekarang + $i;
                                  $selected = ($tahun == $tahunTerpilih) ? 'selected' : '';
                                  echo "<option value='$tahun' $selected>$tahun</option>";
                              }
                              ?>
                            </select>
                          </form></br>
                        </div>
                      </div>
                     <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                              <th>Uraian</th>
                              <?php foreach ($bulan as $b): ?>
                                  <th><?= $b ?></th>
                              <?php endforeach; ?>
                              <th>Total</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          $jenis_audit = array_unique(array_column($pkpt, 'jenis_audit'));
                          $grand_total = 0;

                          foreach ($jenis_audit as $jenis):
                              $total = 0;
                          ?>
                              <tr>
                                  <td><?= $jenis ?></td>
                                  <?php foreach ($bulan as $b): 
                                      $jumlah = 0;
                                      $id = null; // ID data jika tersedia
                                      foreach ($pkpt as $row) {
                                          if ($row['jenis_audit'] == $jenis && $row['bulan'] == $b) {
                                              $jumlah = $row['jumlah'];
                                              $id = $row['pkpt_id']; // Ambil ID dari data
                                              break;
                                          }
                                      }
                                      $total += $jumlah;
                                      ?>
                                      <td>
                                        <?php if ($jumlah): ?>
                                            <!-- Tambahkan hyperlink untuk edit -->
                                            <a href="<?= base_url('administrator/edit_pkpt/' . $id) ?>"><?= $jumlah ?></a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                  <?php endforeach; ?>
                                  <td><?= $total ?></td>
                              </tr>
                          <?php
                              $grand_total += $total;
                          endforeach;
                          ?>
                      </tbody>
                      <tfoot>
                      <tr>
                              <td><b>Jumlah</b></td>
                              <?php foreach ($bulan as $b):
                                  $jumlah_bulan = 0;
                                  foreach ($pkpt as $row) {
                                      if ($row['bulan'] == $b) {
                                          $jumlah_bulan += $row['jumlah'];
                                      }
                                  }
                              ?>
                                  <td><?= $jumlah_bulan ?></td>
                              <?php endforeach; ?>
                              <td><b><?= $grand_total ?></b></td>
                          </tr>
                      </tfoot>
                  </table>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->


<!-- Modal -->
<div class="modal fade" id="EditUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><h4><strong>Edit User</strong></h4></h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
          <form id="demo-form" data-parsley-validate>
             <label for="fullname">NIK * :</label>
            <input type="text" class="form-control" name="nik" required />
            <label for="fullname">Nama Lengkap * :</label>
            <input type="text" id="fullname" class="form-control" name="namalkp_user" required />

            <label for="email">Email * :</label>
            <input type="email" id="email" class="form-control" name="email_user" data-parsley-trigger="change" />
            <label for="email">Password * :</label>
            <input type="password" id="password" class="form-control" name="pass_user"/>
            <label for="email">Konfirmasi Password * :</label>
            <input type="password" id="password" class="form-control" name="pass_user2"/>
            <label>Gender *:</label>
             <p>
              Pria:
              <input type="radio" class="flat" name="gender" id="genderM" value="Pria" checked="" required /> Wanita:
              <input type="radio" class="flat" name="gender" id="genderF" value="Wanita" />
            </p>
            
            <label>Role *:</label>
            <p>
              <input type="radio" class="flat" name="level" value="admin" checked="" required /> Admin <br>
              <input type="radio" class="flat" name="level" value="petugas_spi" /> Petugas SPI <br>
              <input type="radio" class="flat" name="level" value="verifikator" /> Verifikator <br>
              <input type="radio" class="flat" name="level" value="petugas" />Petugas Kebun <br>
            </p>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="simpan" data-dismiss="modal">Simpan Perubahan</button>
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
    $("#bt-remove").on('click' , function () {
          $('#forpesan').remove();
        });
   
        $('#datatable').DataTable({
            ordering: false // Menonaktifkan fitur sorting
        });
    
  </script>
  </body>
</html>