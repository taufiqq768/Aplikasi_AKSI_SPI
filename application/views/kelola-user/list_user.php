 <title>PTPN XII | List User</title>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List User<small>(AKSI)</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <?php $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);?>
                      <a href="./input_user"><li><button type="button" class="btn btn-default btn-xs" <?php  echo strpos($role[0]['role_akses'],'15')!==FALSE?"":"disabled"; ?>>Tambah User</button></a></li></a>
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
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 5%">No</th>
                          <th style="width: 10%">NIK</th>
                          <th style="width: 23%">Nama Lengkap</th>
                          <th style="width: 10%">Unit</th>
                          <th style="width: 10%">Level</th>
                          <th style="width: 5%">Role</th>
                          <th style="width: 20%">Email / No.tlp</th>
                          <th style="width: 10%">Status</th>
                          <th style="width: 7%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $no=1;
                        foreach ($record as $row) { 
                        if ($row['user_aktif']=='Y'){ 
                          $btnaktif = "type='button' title='Non Aktifkan' class='btn-xs btn-success'"; 
                          $status = 'Aktif';
                          $span = "class='glyphicon glyphicon-ok'";
                        }else{ 
                          $btnaktif = "type='button' title='Aktifkan' class='btn-xs btn-danger'"; 
                          $status = 'Non-Aktif';
                          $span = "class='glyphicon glyphicon-remove'";
                        } 
                        ?>
                        <tr>
                          <td><?php echo $no; ?></td>
                          <td><?php echo $row['user_nik']; ?></td>
                          <td><?php echo $row['user_nama']; ?></td>
                          <td><?php $unit = $this->model_app->view_profile('tb_unit', array('unit_id'=> $row['unit_id']))->row_array(); echo $unit['unit_nama']; ?></td>
                          <td><?php echo $row['user_level']; ?></td>
                          <td><?php echo $row['role_nama'];?></td>
                          <td>
                            <?php echo $row['user_email']; 
                              if ($row['user_tlp']==null) {
                                echo "";
                              }else{
                                echo " / ".$row['user_tlp'];
                              }
                            ?>  
                          </td>
                          <td>
                            <center><?php   echo "<a href='".base_url()."administrator/status_user/$row[user_nik]/$row[user_aktif]'"?><button <?php echo $btnaktif; echo strpos($role[0]['role_akses'],'18')!==FALSE?"":"disabled"; ?>><span <?php echo $span; ?>></span> <?php echo $status; ?></button></a></center>
                          </td>
                          <td>  <center>
                            <?php   echo "<a href='".base_url()."administrator/edit_user/$row[user_nik]'"?><button type="button" class="btn btn-primary btn-xs" title="Edit User" <?php  echo strpos($role[0]['role_akses'],'16')!==FALSE?"":"disabled"; ?>><i class="fa fa-edit"></i> Edit</a></button></center>
                            <?php   //echo "<a href='".base_url()."administrator/delete_user/$row[user_nik]'"?><!-- <button type="button" class="btn btn-danger btn-xs" title="Hapus User" onclick="return confirm('Apa anda yakin untuk hapus User ini?')" <?php  //echo strpos($role[0]['role_akses'],'17')!==FALSE?"":"disabled"; ?>>Hapus</button></a> -->
                          </td>
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
  </script>
  </body>
</html>