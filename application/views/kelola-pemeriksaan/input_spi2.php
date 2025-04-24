<title>AKSI | Kelola Pemeriksaan </title>
      <!-- page content ---------------------------->
       <style>
        /* The switch - the box around the slider */
        .switch {
        position: relative;
        display: inline-block;
        width: 48px; /* 60px * 0.8 */
        height: 27.2px; /* 34px * 0.8 */
      }

      .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
      }

      .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
      }

      .slider:before {
        position: absolute;
        content: "";
        height: 20.8px; /* 26px * 0.8 */
        width: 20.8px; /* 26px * 0.8 */
        left: 3.2px; /* 4px * 0.8 */
        bottom: 3.2px; /* 4px * 0.8 */
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
      }

      input:checked + .slider {
        background-color: #2196F3;
      }

      input:focus + .slider {
        box-shadow: 0 0 0.8px #2196F3; /* 1px * 0.8 */
      }

      input:checked + .slider:before {
        -webkit-transform: translateX(20.8px); /* 26px * 0.8 */
        -ms-transform: translateX(20.8px);
        transform: translateX(20.8px);
      }

      /* Rounded sliders */
      .slider.round {
        border-radius: 16px; /* 20px * 0.8 */
      }

      .slider.round:before {
        border-radius: 50%;
      }
      .popup-error {
        display: none;
        position: absolute;
        background-color: #ffdddd;
        color: #a94442;
        border: 1px solid #a94442;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.9em;
        z-index: 10;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        animation: fadeIn 0.3s ease-in-out;
        margin-top: 5px;
      }

      .popup-error::after {
        content: "";
        position: absolute;
        top: -10px;
        left: 15px;
        border-width: 5px;
        border-style: solid;
        border-color: transparent transparent #ffdddd transparent;
      }

      .file-upload-wrapper {
        position: relative;
        display: inline-block;
      }

      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
      }

      .show-popup {
        display: block !important;
      }
      </style>
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Pemeriksaan</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Form Pemeriksaan Regional<small></small></h2>
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
                  //MENAMPILKAN ALERT
                    if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Unit</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="jenis_pmr" readonly="readonly" class="form-control col-md-7 col-xs-12" value="<?php echo $value['unit_nama'] ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Petugas SPI</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php 
                           $upload_lha = isset($record4[0]['file_lha']) ? trim(json_encode($record4[0]['file_lha']), '"') : '0';
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
                    </form>
                 <?php } ?>
                  <!-- <div class="form-group"> -->
                        <div class="form-group">
                          <label class="control-label col-md-3" style="padding-left: 150px">Dokumen LHA</label>
                          <?php 
                            $filelha = isset($record4[0]['file_lha']) ? trim(json_encode($record4[0]['file_lha']), '"') : '0';
                            if ($filelha === '0' || empty($filelha)) { 
                          ?>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <button type="button" id="lha" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Upload Dokumen LHA">Upload Dokumen LHA</button>
                          </div>
                          <?php }else{ 
                              echo "<a href='".base_url("asset/file_lha/").$filelha."' target='_blank'><button type=button class='btn btn-warning btn-sm' data-toggle=tooltip data-placement=top title=Download Dokumen LHA style='margin-left: 10px'>Download Dokumen LHA</button></a>";
                            }
                          ?>
                        </div></br>
                        <div class="form-group lha" style="display:none;">
                          <div class="form-groupm">
                            <?php $id_pmr = $this->uri->segment(3); ?>
                            <form action="<?= site_url('administrator/upload_lha/'.$id_pmr) ?>" method="post" enctype="multipart/form-data">
                                  <label class="control-label col-md-3" style="padding-left: 196px">Nomor LHA</label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="text" id="no_lha" required="required" name="no_lha" class="form-control col-md-7 col-xs-12" value="<?php echo set_value('Nomor LHA'); ?>"></br></br></br>
                                  <input type="file" name="file_lha" accept=".pdf" required="required" onchange="validateFileSize(this)">
                                  <div id="popupSizeError" class="popup-error">Ukuran file terlalu besar! Maksimal 25MB.</div>
                                      <p><strong>(Accepted : .pdf)</strong></p>
                                      <p><strong>Max. size 25MB</strong></p></br>
                                  <button type="submit" name="upload" class="btn btn-primary">simpan</button>
                                </div>
                            </form>
                          </div>
                        </div></br>
                        <div class="form-group row">
                          <label class="control-label col-md-3 col-form-label">Dokumen LHA Kirim ke Regional/Divisi</label>
                          <div class="col-md-9">
                              <?php 
                                  $checked = (!empty($record4) && isset($record4[0]['status']) && $record4[0]['status'] == 1) ? "checked" : "";
                              ?>
                              <label class="switch">
                                  <input type="checkbox" class="send-lha" id="statusCheckbox" data-id="<?= $id_pmr ?>" <?= $checked ?>>
                                  <span class="slider round"></span>
                              </label>
                          </div>
                      </div>

                    <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
                     <?php 
                     $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
                     $id_pmr = $this->uri->segment(3); 
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
                    <div class="row"> 
                      <?php 
                      if ($this->session->level=="spi") {
                        if (in_array($this->session->username, $select)) {
                          if($upload_lha !== "0"  || !empty($upload_lha)){
                            $dis = "";
                          }
                          else{
                            $dis = "disabled";
                          }
                        }else{
                          $dis = "disabled";
                        }
                      }else{
                       $dis = "";
                      } ?>
                    <?php   echo "<a href='".base_url()."administrator/tambah_temuan/$id_pmr'>" ?><button type="button" class="btn btn-primary tambah-lagi pull-right" <?php  echo strpos($role[0]['role_akses'],',3,')!==FALSE?"":"disabled";?> <?php echo $dis; echo $disable; ?>>Tambah Temuan</button></a>
                  <!-- </div> -->
                  <?php 
                    //action untuk kirim temuan
                    $atribut = array('class'=>'form-horizontal','role'=>'form');
                    echo form_open('administrator/multikirimtemuan_tokabag/'.$id_pmr,$atribut); ?>
                    <button type="submit" name="kirim" class="btn btn-xs btn-success" <?php  echo strpos($role[0]['role_akses'],',26,')!==FALSE?"":"disabled"; echo $disable; echo $dis; ?>><span class="fa fa-send"></span> Kirim Semua Temuan & Rekomendasi ke Kadiv DSPI</button>

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
                          <!-- <th style="width: 20%;">Status</th> -->
                          <th style="width: 20%;">Action</th>
                        </tr>
                      </thead>
                      
                      <?php $nomer = 1; foreach ($record3 as $value) {  ?>
                        <tbody>
                          <tr>
                            <td>
                                <?php if ($value['temuan_publish_kabag']=='N'): ?>
                                      <input type="checkbox" class="form-control checkbox ck" name="select[]" value="<?php echo $value['temuan_id']?>">  
                                <?php endif ?>
                            </td>
                            <td><?php echo $nomer."." ?></td>
                            <td style=width:50px;><?php echo $value['temuan_judul']; ?></td>
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
                            <?php 
                              // if ($value['temuan_publish_kabag']=='Y') {
                              //   echo "<td>Terkirim ke KADIV DSPI</td>";
                              // }elseif ($value['temuan_publish_kabag']=='N' AND $value['temuan_kirim']=="N") {
                              //   echo "<td>Belum Terkirim</td>";
                              // }
                              // else{ 
                              //   echo "<td>Dikembalikan oleh KADIV DSPI</td>"; 
                              // }
                            ?>
                            <td>
                              <?php   
                                  echo "<a href='".base_url()."administrator/list_rekomendasi/$id_pmr/$value[temuan_id]'>" 
                                ?>
                                  <button type="button" class="btn btn-default btn-xs">Lihat Rekomendasi</button></a></br></br>
                                <?php 
                                  if ($value['temuan_publish_kabag']=='N') { 
                                ?>
                                <?php
                                  echo "<a href='".base_url()."administrator/edit_temuan/$id_pmr/$value[temuan_id]'>" 
                                ?>
                                  <button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"  title="Ubah Data Temuan" data-toggle="modal" data-target="#EditTemuan<?php echo $value['temuan_id']?>" <?php  echo strpos($role[0]['role_akses'],',4,')!==FALSE?"":"disabled";?> <?php echo $dis; echo $disable; ?>><span class="fa fa-pencil"></span></button></a>
                                <?php
                                  //echo "<a href='".base_url()."administrator/kirim_temuan_kadiv_spi/$id_pmr/$value[temuan_id]'>" 
                                ?>
                                  <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top"  title="Kirim ke Kadiv DSPI Temuan" data-toggle="modal" data-target="#EditTemuan<?php echo $value['temuan_id']?>" <?php  echo strpos($role[0]['role_akses'],',4,')!==FALSE?"":"disabled";?> <?php echo $dis; echo $disable; ?>><span class="fa fa-send"></span></button></a> -->
                                <?php
                                  echo "<a href='".base_url()."administrator/delete_temuan/$id_pmr/$value[temuan_id]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\">" 
                                ?>
                                  <button type="button" class="btn btn-danger btn-sm bt-remove"  <?php  echo strpos($role[0]['role_akses'],',5,')!==FALSE?"":"disabled";?> data-toggle="tooltip" data-placement="top" title="Hapus Temuan" <?php echo $dis; echo $disable; ?>><span class="fa fa-trash"></span></button></a>
                                <?php 
                                  echo "<a href='".base_url()."administrator/send_temuan_rekomendasi/$value[temuan_id]/$id_pmr'" ;
                                ?>
                                  </br></br></br><button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top"  title="Kirim Temuan Rekomendasi ke KADIV SPI" data-toggle="modal" data-target="#EditTemuan<?php echo $value['temuan_id']?>" <?php  echo strpos($role[0]['role_akses'],',4,')!==FALSE?"":"disabled";?> <?php echo $dis; echo $disable; ?>><span class="fa fa-send"></span></button></a>
                                <?php  
                                }
                              ?>
                            </td>
                          </tr>
                            <?php $nomer++;  ?>
                        </tbody>
                      <?php } ?>
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
        <div class="col-md-12 col-sm-12 col-xs-12">
          <button type="submit" name="simpan" class="btn btn-sm btn-primary pull-right">Simpan Draft</button>
          <button type="submit" name="kirim" class="btn btn-sm btn-success pull-right">Kirim</button>
        </div>
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
      function validateFileSize(input) {
        const popup = document.getElementById('popupSizeError');
        popup.classList.remove('show-popup');

        if (input.files.length > 0 && input.files[0].size > 25000000) {
          input.value = ""; // reset file input
          popup.classList.add('show-popup');

          // auto-close after 6 seconds
          setTimeout(() => {
            popup.classList.remove('show-popup');
          }, 6000);
        }
      }
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
            //alert(this.value);
        });
        
        $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('.select_all').prop('checked',true);
                //alert("all");
            }else{
                $('.select_all').prop('checked',false);
                //alert("salah satu");
            }
        });
      
        $('#lha').click(function() {
            $('.lha').removeAttr('style');
        });

        $("#statusCheckbox").change(function() {
          var isChecked = $(this).is(":checked") ? 1 : 0; // 1 jika dicentang, 0 jika tidak
          var id_pmr = $(this).data("id"); // Ambil ID dari checkbox

          $.ajax({
              url: "<?= base_url('administrator/send_lha_reg') ?>", // Ganti dengan route controller
              type: "POST",
              data: { id_pmr: id_pmr, status: isChecked }, // Kirim status juga
              dataType: "json",
              success: function(response) {
                  if (response.status === "error") {
                      alert("Harap upload dokumen terlebih dahulu sebelum mengubah status!");
                      $("#statusCheckbox").prop("checked", !isChecked); // Batalkan perubahan status
                  } else {
                      console.log("Status berhasil diubah menjadi " + isChecked);
                  }
              },
              error: function(xhr, status, error) {
                  alert("Terjadi kesalahan, coba lagi.");
                  $("#statusCheckbox").prop("checked", !isChecked); // Batalkan perubahan status jika error
              }
          });
      });


    });
    </script>
    