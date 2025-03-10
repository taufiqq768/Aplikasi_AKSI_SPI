<title>PTPN XII | List Role User</title>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List Role User<small>(AKSI)</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <?php $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);?>
                      <li><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#exampleModal" <?php  echo strpos($role[0]['role_akses'],'19')!==FALSE?"":"disabled"; ?>>Tambah Role</button></li>
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php 
                     if ($this->session->flashdata('berhasil')!=null) {
                       echo "<div class='alert alert-danger' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('berhasil')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                     }if ($this->session->flashdata('gagal')!=null) {
                       echo "<div class='alert alert-danger' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('gagal')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                     }
                    ?>
                    <div style="overflow-x:auto;">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 5%">No.</th>
                          <th style="width: 25%"><center>Role</center></th>
                          <th style="width: 30"><center>Hak Akses</center></th>
                          <th style="width: 20%"><center>Tanggal Buat</center></th>
                          <th style="width: 20%"><center>Action</center></th>
                        </tr>
                      </thead>
                      <tbody>
                    <?php 
                    $no = 1;
                    foreach ($record as $value) { ?>
                    <tr>
                      <td><?php echo $no."."; ?></td>
                      <td><?php echo $value['role_nama']; ?></td>
                      <td>
                        <?php 
                        $akses = explode(',', $value['role_akses']);
                        for ($i=1; $i <sizeof($akses)-1 ; $i++) { 
                          $nama = $this->model_app->view_where('tb_hakakses','hakakses_id',$akses[$i]);
                          echo "- ".$nama[0]['hakakses_nama']."<br>";  
                        }
                         ?>
                      </td>
                      <td><?php $tgl = explode("-", $value['role_tgl']); echo $tgl[2]."-".$tgl[1]."-".$tgl[0]; ?></td>
                      <td>
                        <button type="button" class="btn btn-success btn-xs" title="Ubah Data Role" data-toggle="modal" data-target="#EditRole<?php echo $value['role_id']?>" <?php  echo strpos($role[0]['role_akses'],'20')!==FALSE?"":"disabled"; ?>><span class="fa fa-pencil"></span> Edit</button>

                        <?php echo "<a href='".base_url()."administrator/delete_role/$value[role_id]'>" ?><button type="button" class="btn btn-danger btn-xs" title="Hapus Role" onclick="return confirm('Apa anda yakin untuk hapus Role ini?')" <?php  echo strpos($role[0]['role_akses'],'21')!==FALSE?"":"disabled"; ?>><span class="fa fa-trash"></span> Hapus</button></a>
                        <!-- Bisa dihapus jika tidak ada user yang menggunakan role tsb -->
                          </td>
                      <div class="modal fade" id="EditRole<?php echo $value['role_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel<?php echo $value['role_id']?>" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                           <div class="row">
                             <h4 class="modal-title"><strong>&nbsp;Edit Role</strong>
                             <button type="button" class="close" data-dismiss="modal">&times;</button></h4>
                           </div>
                           </div>
                          <div class="modal-body">
                            <?php 
                            $cek = '';
                             $attributes = array('class'=>'form-horizontal','role'=>'form');
                                       echo form_open('administrator/edit_role',$attributes); 
                            echo "<input type='hidden' name='id' value=$value[role_id]>";
                            ?>
                             <label>Nama Role * :</label>
                             <input type="text" id="fullname" class="form-control" name="nama" required value="<?php echo $value['role_nama'] ?>" readonly/>
                             <br>
                             <label>Hak Akses User:</label>
                             <br>
                             <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-sm-12 col-md-12 col-xs-12">
                                <?php 
                                  foreach ($record2 as $row) {
                                 $cek = strpos($value['role_akses'],",".$row['hakakses_id'].",")!==false ? $cek = "checked='checked'" : "";
                                
                                ?>
                                 <div class="col-md-4 col-sm-4 col-xs-12">
                                    <input type="checkbox" name="p[]" value="<?php echo $row['hakakses_id'] ?>" <?php echo $cek; ?>/> <?php echo $row['hakakses_nama']; ?>
                                 </div>
                                <?php } ?>
                                </div>
                               </div>
                              </div>
                              <br>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="edit" class="btn btn-primary" id="simpan">Simpan</button>
                            </div>
                            <?php echo form_close(); ?>
                          </div>
                        </div>
                      </div>
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
        <!-- /page content -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <div class="row">
         <h4 class="modal-title"><strong>Tambah Role</strong>
         <button type="button" class="close" data-dismiss="modal">&times;</button></h4>
       </div>
       </div>
      <div class="modal-body">
        <?php 
         $attributes = array('class'=>'form-horizontal','role'=>'form');
                   echo form_open('administrator/input_role',$attributes); ?>
         <label>Nama Role * :</label>
         <input type="text" id="fullname" class="form-control" name="nama" required />
         <br>
         <label>Hak Akses User:</label>
         <br>
          <?php foreach ($record2 as $row) { ?>
            <div class="col-md-6 col-sm-6 col-xs">
              <div class="checkbox">
                <input type="checkbox" name="akses[]" value="<?php echo $row['hakakses_id'] ?>" class="flat" /> <?php echo $row['hakakses_nama']; ?>
              </div>
            </div>
          <?php } ?>
          <br>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary" id="simpan">Simpan</button>
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
      $('#bt-remove').on('click', function(){
        $('#forpesan').hide();
      });
    </script>
  </body>
</html>