<title>AKSI | Kelola Pemeriksaan </title>
<!-- 
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php //include 'menu_sidebar.php'; ?>            
        <?php //include 'main-header.php'; ?>  
 -->
      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Daftar Temuan dan Rekomendasi</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Form Pemeriksaan Regional dan Divisi <small></small></h2>
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
                        if ($this->session->flashdata('gagal')!=null) { 
                          echo "<div class='alert alert-danger' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('gagal')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                        }
                        if ($this->session->flashdata('kirimtemuan')!=null) { 
                          echo "<div class='alert alert-success' role='alert' id='forpesan'><em class='fa fa-lg fa-check-circle-o'>&nbsp;</em>".$this->session->flashdata('kirimtemuan')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                        }
                        if ($this->session->flashdata('kembalikan')!=null) { 
                          echo "<div class='alert alert-success' role='alert' id='forpesan'><em class='fa fa-lg fa-check-circle-o'>&nbsp;</em>".$this->session->flashdata('kembalikan')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                        }
                        if ($this->session->flashdata('error')) { 
                          echo "<div class='alert alert-danger' role='alert' id='forpesan'><em class='fa fa-lg fa-check-circle-o'>&nbsp;</em>".$this->session->flashdata('error')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                        }
                  ?>
                  <br />
                  <?php foreach ($record as $value) {  ?>
                    <form class="form-horizontal" role="form">  
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Jenis Audit</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="jenis_pmr" readonly="readonly" class="form-control col-md-7 col-xs-12" value="<?php echo $value['pemeriksaan_jenis'] ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Judul</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="judul_pmr" readonly="readonly" class="form-control col-md-7 col-xs-12" value="<?php echo $value['pemeriksaan_judul'] ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kebun</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php $namakebun = $this->db->query("SELECT unit_nama FROM tb_unit WHERE unit_id = '$value[unit_id]'")->result(); ?>
                        <input type="text" id="jenis_pmr" readonly="readonly" class="form-control col-md-7 col-xs-12" value="<?php echo $namakebun[0]->unit_nama ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Petugas SPI</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php 
                        $select  = explode("/", $value['pemeriksaan_petugas']);
                        $nama = [];
                          foreach ($select as $nik) {
                            $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $nik))->row_array();
                            $nama[] = $usr['user_nama'];
                          }
                          $petugas = implode(", ", $nama);
                        ?>
                        <input type="text" name="nama_pmr" readonly="readonly" class="form-control col-md-7 col-xs-12" value="<?php echo $petugas ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-3">Tanggal Pemeriksaan</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                         <?php
                              $mulai = explode("-", $value['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $value['pemeriksaan_tgl_akhir']);
                              $tgl =  $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                              ?>
                          <input type='text' class="form-control" readonly="readonly" value="<?php echo $tgl; ?>" />
                    
                      </div>
                    </div>
                 <div class="form-group">
                   <label class="control-label col-md-3">Surat Tugas</label>
                   <div class="col-md-6 col-sm-6 col-xs-12">
                     <?php if ($value['pemeriksaan_doc']!=null): ?>
                      <a target="_BLANK" title="Lihat Data" href="<?php echo base_url(); ?>asset/file_pemeriksaan/<?php echo $value['pemeriksaan_doc']?>"><font size="2">
                      <input type="text" class="form-control" value="<?php  echo $value['pemeriksaan_doc'] ?>" readonly>
                      </font></a> 
                    <?php else: ?>
                     <input type="text" class="form-control" value="-" readonly>
                      </font>
                    <?php endif ?>
                    </div>
                 </div>
                 <?php } ?>
              </form>
              <div class="form-group">
                    <?php $id_pmr = $this->uri->segment(3); ?>
                        <div class="form-group">
                          <label class="control-label col-md-3" style="padding-left: 150px">Dokumen LHA</label>
                          <?php 
                            $filelha = isset($record4[0]['file_lha']) ? trim(json_encode($record4[0]['file_lha']), '"') : '0';
                            if ($filelha === '0' || empty($filelha)) { 
                          ?>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top">Belum Ada Dokumen LHA</button>
                          </div>
                          <?php }else{ 
                              echo "<a href='".base_url("asset/file_lha/").$filelha."' target='_blank'><button type=button class='btn btn-warning btn-sm' data-toggle=tooltip data-placement=top title=Download Dokumen LHA style='margin-left: 10px'>Download Dokumen LHA</button></a>";
                            }
                          ?>
                        </div>
                  </div>
              <?php //print_r($select);
               ?>
                    <div class="col-lg-12 col-md-12 col-xs-12">
                     <?php $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);?>
                    <div class="row"> 
                      <?php 
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
                      ?>
                  </div>
                  <?php 
                  //action untuk kirim temuan
                    $bdgtemuan = $this->db->query("SELECT * FROM tb_bidangtemuan ORDER BY bidangtemuan_id ASC")->result_array(); 
                    $atribut = array('class'=>'form-horizontal','role'=>'form');
                    echo form_open('administrator/multikirimtemuan_tokebun/'.$id_pmr,$atribut); ?>
                    <button type="submit" name="kirim" class="btn btn-xs btn-success" <?php echo $disable; ?>><span class="fa fa-send"></span> Kirim Semua Temuan dan Rekomendasi ke Regional atau Divisi</button> 
                    <table class="table table-bordered table-striped datatable">
                      <thead>
                        <tr>
                          <th>Pilih Semua<input type="checkbox" class="select_all" value="ck"/></th>
                          <th style="width: 5%;">No</th>
                          <th style="width: 30%;">Temuan</th>
                          <th style="width: 15%;">Bidang</th>
                          <th style="width: 15%;">Klasifikasi Temuan</th>
                          <th style="width: 15%;">Klasifikasi A & B</th>
                          <th style="width: 30%;">Penyebab</th>
                          <th style="width: 15%;">Klasifikasi Penyebab</th>
                          <th style="width: 20%;">Klasifikasi COSO</th>
                          <th style="width: 20%;">Action</th>
                        </tr>
                      </thead>
                      <?php  $nomer = 1; foreach ($record3 as $value) {  ?>
                      <tbody>
                      <tr>
                        <td>
                            <?php if ($value['temuan_kirim']=='N'): ?>
                                  <input type="checkbox" class="checkbox ck" name="select[]" value="<?php echo $value['temuan_id']?>">  
                            <?php endif ?>
                        </td>
                        <td><?php echo $nomer."." ?></td>
                        <td><?php echo $value['temuan_judul']; ?></td>
                        <td><?php echo $value['bidangtemuan_nama']; ?></td>
                        <td><?php echo $value['klasifikasi_temuan']; ?></td>
                        <td><?php echo $value['judul_ab']; ?></td>
                        <?php 
                        $select  = explode("/", $value['sebab_id']);
                        $sebab = [];
                          foreach ($select as $penyebab) {
                            $q = $this->model_app->view_profile('tb_master_penyebab', array('sebab_id'=> $penyebab))->row_array();
                            $sebab[] = $q['klasifikasi_sebab'];
                          }
                          $gab_sebab = implode(", ", $sebab);
                        ?>
                        <td><?php echo $value['penyebab']; ?></td>
                        <td><?php echo $gab_sebab; ?></td>
                        <td><?php echo $value['klasifikasi_coso']; ?></td>
                        <td>
                           <!-- HAK AKSES KABAG SPI -->
                           <div class="form-group">
                              <?php echo "<a href='".base_url()."administrator/list_rekomendasi/$id_pmr/$value[temuan_id]'>" ?><button type="button" class="btn btn-default btn-xs">Lihat Rekomendasi</button></a>
                            </div>
                           <?php 
                              if ($this->session->level=="kabagspi" AND $value['temuan_publish_kabag']=="Y" AND  $value['temuan_kirim'] != "Y") {
                              echo "<a href='".base_url()."administrator/kembalikan_temuan/$id_pmr/$value[temuan_id]'>" 
                            ?>
                              <button class="btn btn-sm btn-danger" type="button" title="Kembalikan Temuan ke SPI"><span class="fa fa-mail-reply"></span></button></a>
                            <?php 
                              //echo "<a href='".base_url()."administrator/kirim_temuan/$id_pmr/$value[temuan_id]'>" 
                            ?>
                              <!-- <button class="btn btn-xs btn-success" type="button" title="Kirim Temuan ke Regional/Divisi">Kirim Temuan dan rekomendasi all</span></button></a> -->
                            <?php
                              //$id_rekomendasi = isset($record5[0]['rekomendasi_id']) ? trim(json_encode($record5[0]['rekomendasi_id']), '"') : '0'; 
                              echo "<a href='".base_url()."administrator/send_temuan_rekomendasi_unit/$value[temuan_id]/$id_pmr'";
                            ?>
                              <button class="btn btn-sm btn-success" type="button" title="Kirim Temuan dan Rekomendasi ke Regional/Divisi"><span class="fa fa-send-o"></span></button></a>
                            <?php 
                              } 
                            ?>
                            
                        </td>
                      </tr>
                      <?php $nomer++;  ?>
                      </tbody>
                      <?php } ?>
                    </table>
                    <?php echo form_close(); ?>
<!-- ------------------------------------------------------------------------------------------------------------- -->                    
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->

  <!-- footer content -->
<!--   <footer>
    <div class="pull-right">
      <a href="/www.ptpn12.com">PT. Perkebunan Nusantara XII</a>
    </div>
    <div class="clearfix"></div>
  </footer> -->
  <!-- /footer content -->
 <!--  </div>
</div> -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
        <h5 class="modal-title" id="exampleModalLabel"><h4><strong>Tambah Temuan</strong></h4></h5>
      </div>
      <div class="modal-body">
      <?php 
      $id_pmr = $this->uri->segment(3);
         $attributes = array('class'=>'form-horizontal','role'=>'form', 'id'=>'demo-form2');
         echo form_open_multipart('administrator/tambah_temuan/'.$id_pmr,$attributes);
       ?>   <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Bidang </label>
              <div  class="col-md-9 col-sm-9 col-xs-12">
                  <select class="form-control" name="bidang">
                    <?php $bidang = $this->db->query("SELECT * FROM tb_bidangtemuan ORDER BY bidangtemuan_id ASC")->result_array(); 
                    foreach ($bidang as $value) {
                    ?>
                      <option value="<?php echo $value['bidangtemuan_id']?>"><?php echo $value['bidangtemuan_nama']; ?></option>
                  <?php } ?>
                  </select> 
              </div>
            </div>
           <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Temuan
             </label>
             <div class="col-md-9 col-sm-9 col-xs-12">
               <textarea type="text" name="temuan" rows="3" class="form-control col-md-7 col-xs-12"></textarea>
             </div>
           </div>
      </div>
      <div class="modal-footer">
        <div class="form-group">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
        <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
        </div>
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
            // alert(this.value);
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