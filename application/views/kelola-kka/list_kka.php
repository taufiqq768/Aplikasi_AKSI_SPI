<title>AKSI | List Pemeriksaan</title>
<style>
    .hidden { display: none; }
    .read-more:hover + .hidden { display: inline; }
    .timeline {margin-left:200px; padding-right:320px;}
    .konten-tinymce img {
        max-width: 100%;     /* biar responsif */
        height: auto;        /* proporsi tetap */
        width: 300px;        /* ukuran kecil */
      }
    .event{
    white-space: nowrap; /* Cegah teks wrap */
    text-overflow: ellipsis; /* Tambahkan "..." jika teks terlalu panjang */
    max-width: 100%; /* Pastikan lebar maksimal mengikuti container */
    display: block; /* Pastikan tetap sebagai blok */
}
    
</style>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
  
            <div class="row">
              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                    <?php  
                    //FORM UNTUK PENCARIAN DATA PEMERIKSAAN
                      $attributes = array('class'=>'form-horizontal');
                      echo form_open('administrator/cari_pemeriksaan',$attributes);
                    ?>
                      <!-- <div class="form-group col-lg-2">
                        <label>Jenis : </label>
                        <select class="form-control" name="jenis">
                          <option value="0">-Pilih Jenis-</option>
                          <option value="Rutin">Rutin</option>
                          <?php if ($this->session->level!="viewer"): ?>
                          <option value="Khusus">Khusus</option>
                          <option value="Penting">Tematik</option>
                          <?php endif ?>
                        </select>
                      </div>
                      <div class="form-group col-lg-2">
                        <label>Status : </label>
                        <select class="form-control" name="status">
                          <option value="0">-Pilih Status-</option>
                          <option value="Y">Aktif</option>
                          <option value="N">Non - Aktif</option>
                        </select>
                      </div>
                      <div class="form-group col-lg-3">
                        <label>Unit : </label>
                        <select class="form-control" name="unit">
                          <option value="">-Pilih Unit-</option>
                          <?php foreach ($unit as $k => $val): ?>
                            <option value="<?php echo $val['unit_id'] ?>"><?= $val['unit_nama']?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div id="tanyarentang">
                        <div class="form-group col-lg-2">
                          <label>Rentang Tanggal :</label>
                            <div class="radio">
                              <label>
                                <input type="radio" class=""  value='Y' name='waktu'> Ya &nbsp; &nbsp; &nbsp; &nbsp;
                                <input type="radio" class="" checked value='N' name='waktu'> Tidak
                              </label>
                            </div>
                        </div>
                      </div>
                      <div id="pakerentang">
                        <div class="form-group col-lg-3">
                          <label>Rentang Tanggal :</label>
                            <div class="control-group">
                              <div class="controls">
                                <div class="input-prepend input-group">
                                  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                  <input type="text" value="" name="rentang" id="reservation" class="form-control"  />
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                      &nbsp;
                      <br>
                      <div class="form-group col-lg-2">
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                      </div> -->
                    <?php echo form_close(); ?>
                  </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List Kertas Kerja Audit (KKA)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                   <?php 
                   $ket = '';
                   $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
                     if ($this->session->flashdata('berhasil')!=null) {
                       echo "<div class='alert alert-success' role='alert' id='forpesan'><center><strong><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('berhasil')."</strong><a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></center></a></div>";
                     }
                    ?>
                  <div class="x_content">
                    <div style="overflow-x:auto;">
                    <table id="datatable" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Judul</th>
                          <th style="width: 30%">Kondisi</th>
                          <th style="width: 30%">Penyebab</th>
                          <th style="width: 20%">Unit</th>
                          <th>Tanggal Pemeriksaan Audit</th>
                          <th style="width: 10%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no=1;
                        foreach ($record as $row) {
                            $kondisi=!empty($row['kka_kondisi']) ? $row['kka_kondisi'] : 'Belum ada data';
                            $short_kondisi = substr($kondisi, 0, 100); // Ambil 100 karakter pertama 
                            $penyebab=!empty($row['kka_penyebab']) ? $row['kka_penyebab'] : 'Belum ada data';
                            $short_penyebab = substr($penyebab, 0, 100); // Ambil 100 karakter pertama 
                        ?>
                        <tr>
                          <td><?php echo $no; ?></td>
                          <td><?php echo $row['pemeriksaan_judul']; ?></td>
                          <td>
                            <p>
                                <?= $short_kondisi; ?>...<span id="dots" class="konten-tinymce">...</span>
                                <span id="more" style="display:none;"><?= substr($kondisi, 100); ?></span>
                            </p>
                            <button onclick="toggleReadMore()" id="myBtn">Read More</button>
                          </td>
                          <td>
                            <p>
                                <?= $short_penyebab; ?>...<span id="dots1">...</span>
                                <span id="more1" style="display:none;"><?= substr($penyebab, 100); ?></span>
                            </p>
                            <button onclick="toggleReadMore1()" id="myBtn1">Read More</button>
                          </td>
                          <td><?php echo $row['unit_nama']; ?></td>
                          <td><?php echo $row['pemeriksaan_tgl_mulai']."-".$row['pemeriksaan_tgl_akhir']; ?></td>
                          <td>
                            <!-- ANGGOTA AUDIT -->
                            <?php 
                              if ($row['kka_kirim_kadiv_dspi']=="0") { 
                            ?>
                            <?php
                              echo "<a href='".base_url()."administrator/kirim_kka_kadiv_spi/$row[id_kka]/$row[pemeriksaan_id]'>" 
                            ?>
                              <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"  title="Kirim" data-toggle="modal" data-target="#EditTemuan<?php echo $row['id_kka']?>" <?php  echo strpos($role[0]['role_akses'],',4,')!==FALSE?"":"disabled";?>><span class="fa fa-send"></span>&nbsp; Ketua Audit</button></a>
                            <?php
                              echo "<a href='".base_url()."administrator/edit_kka/$row[id_kka]'>" 
                            ?>
                              <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top"  title="Edit" data-toggle="modal" data-target="#EditKKA<?php echo $row['id_kka']?>" <?php  echo strpos($role[0]['role_akses'],',4,')!==FALSE?"":"disabled";?>><span class="fa fa-pencil"></button></a>
                            <?php
                              echo "<a href='".base_url()."administrator/delete_temuan/$row[id_kka]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\">" 
                            ?>
                              <button type="button" class="btn btn-warning btn-sm btn-history"  <?php  echo strpos($role[0]['role_akses'],',5,')!==FALSE?"":"disabled";?> data-id="<?= $row['pemeriksaan_id'] ?>" data-toggle="tooltip" data-placement="top" title="History"><span class="fa fa-history"></button></a>
                              <!-- /ANGGOTA AUDIT -->
                            <?php } elseif($row['kka_kirim_kadiv_dspi'] == "1" && $row['pembuat_kka'] == $this->session->username){ ?>
                              <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"  <?php  echo strpos($role[0]['role_akses'],',6,')!==FALSE?"":"disabled"; ?>>Terkirim Ke Ketua</button></a>
                              <!-- block KETUA -->
                            <?php } elseif($row['kka_kirim_kadiv_dspi'] == "1" && $row['pemeriksaan_ketua'] == $this->session->username){ ?>
                              <?php echo "<a href='".base_url()."administrator/kirim_kka_kadiv_spi/$row[id_kka]/$row[pemeriksaan_id]'>" ?>
                              <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"  title="Kirim" data-toggle="modal" data-target="#EditTemuan<?php echo $row['id_kka']?>" <?php  echo strpos($role[0]['role_akses'],',4,')!==FALSE?"":"disabled";?>><span class="fa fa-send"></span>&nbsp; Pengawas </br>Audit</button></a></br>
                              <?php
                              echo "<a href='".base_url()."administrator/edit_kka/$row[id_kka]'>" 
                              ?>
                              <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" <?php  echo strpos($role[0]['role_akses'],',6,')!==FALSE?"":"disabled"; ?>><span class="fa fa-pencil"></span>&nbsp;</button></a>
                              <button type="button" class="btn btn-warning btn-sm btn-history"  <?php  echo strpos($role[0]['role_akses'],',5,')!==FALSE?"":"disabled";?> data-id="<?= $row['pemeriksaan_id'] ?>" data-toggle="tooltip" data-placement="top" title="History"><span class="fa fa-history"></button></a>
                              <?php echo "<a href='".base_url()."administrator/reject_kka/$row[pemeriksaan_id]'>" ?><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-placement="top" title="Kembalikan KKA ke Anggota SPI"><span class="fa fa-mail-reply"></span></button></a>
                            <?php } elseif($row['kka_kirim_kadiv_dspi'] == "2" && $row['pemeriksaan_ketua'] == $this->session->username){ ?>
                              <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"  <?php  echo strpos($role[0]['role_akses'],',6,')!==FALSE?"":"disabled"; ?>>Terkirim Ke Pengawas</button></a>
                              <!-- /block KETUA -->
                              <!-- block PENGAWAS -->
                            <?php } elseif($row['kka_kirim_kadiv_dspi'] == "2" && $row['pemeriksaan_pengawas'] == $this->session->username){ ?>
                              <?php echo "<a href='".base_url()."administrator/kirim_kka_kadiv_spi/$row[id_kka]/$row[pemeriksaan_id]''>" ?>
                              <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"  title="Kirim" data-toggle="modal" data-target="#EditTemuan<?php echo $row['id_kka']?>" <?php  echo strpos($role[0]['role_akses'],',4,')!==FALSE?"":"disabled";?>><span class="fa fa-send"></span>&nbsp; KADIV </br>DSPI</button></a>
                              <?php
                              echo "<a href='".base_url()."administrator/edit_kka/$row[id_kka]'>" 
                              ?>
                              <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" <?php  echo strpos($role[0]['role_akses'],',6,')!==FALSE?"":"disabled"; ?>><span class="fa fa-pencil"></span>&nbsp;</button></a>
                              <button type="button" class="btn btn-warning btn-sm btn-history"  <?php  echo strpos($role[0]['role_akses'],',5,')!==FALSE?"":"disabled";?> data-id="<?= $row['pemeriksaan_id'] ?>" data-toggle="tooltip" data-placement="top" title="History"><span class="fa fa-history"></button></a>
                              <?php echo "<a href='".base_url()."administrator/reject_kka/$row[pemeriksaan_id]'>" ?><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-placement="top" title="Kembalikan KKA ke SPI"><span class="fa fa-mail-reply"></span></button></a>
                              <?php } elseif($row['kka_kirim_kadiv_dspi'] == "2" && $row['pemeriksaan_pengawas'] == $this->session->username){ ?>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"  <?php  echo strpos($role[0]['role_akses'],',6,')!==FALSE?"":"disabled"; ?>>Terkirim Ke </br>KADIV SPI</button></a>
                              <!-- /block PENGAWAS -->
                              <!-- block KADIV -->
                            <?php } elseif($row['kka_kirim_kadiv_dspi'] == "3" && "1001773" == $this->session->username){ ?>
                              <?php echo "<a href='".base_url()."administrator/kirim_kka_kadiv_spi/$row[id_kka]/$row[pemeriksaan_id]'>" ?>
                              <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"  title="Kirim" data-toggle="modal" data-target="#EditTemuan<?php echo $row['id_kka']?>"><span class="fa fa-check"></span>&nbsp; Approve KADIV </br>DSPI</button></a>
                              <?php
                              echo "<a href='".base_url()."administrator/edit_kka/$row[id_kka]'>" 
                              ?>
                              <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" <?php  echo strpos($role[0]['role_akses'],',6,')!==FALSE?"":"disabled"; ?>><span class="fa fa-pencil"></span>&nbsp;</button></a>
                              <button type="button" class="btn btn-warning btn-sm btn-history"  data-id="<?= $row['pemeriksaan_id'] ?>" data-toggle="tooltip" data-placement="top" title="History"><span class="fa fa-history"></button></a>
                              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-placement="top" data-target="#modalreject" title="Kembalikan KKA ke Petugas DSPI"><span class="fa fa-mail-reply"></span></button></a>
                              <?php } elseif($row['kka_kirim_kadiv_dspi'] == "4"){ ?>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"  <?php  echo strpos($role[0]['role_akses'],',6,')!==FALSE?"":"disabled"; ?>><span class="fa fa-thumbs-up"></span>&nbsp;Approved</button></a>
                                <button type="button" class="btn btn-warning btn-sm btn-history"  data-id="<?= $row['pemeriksaan_id'] ?>" data-toggle="tooltip" data-placement="top" title="History"><span class="fa fa-history"></button>
                              <!-- /block KADIV -->
                            <?php } else{
                                if($row['kka_kirim_kadiv_dspi'] == null){
                                  echo "<a href='".base_url()."administrator/tambah_kka/$row[id_kka]'>
                                          <button type='button' class='btn btn-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Tambah Data KKA' ".
                                          (strpos($role[0]['role_akses'], ',6,') !== FALSE ? "" : "disabled") . ">
                                          <span class='fa fa-plus'></span>&nbsp;KKA</button>
                                        </a>";
                                        echo "<button type='button' class='btn btn-warning btn-sm btn-history' " . 
                                        (strpos($role[0]['role_akses'], ',5,') !== FALSE ? "" : "disabled") . 
                                        " data-id='" . $row['pemeriksaan_id'] . "' data-toggle='tooltip' data-placement='top' title='History'>
                                        <span class='fa fa-history'></span>
                                        </button>";
                                }elseif($row['kka_kirim_kadiv_dspi'] == "1"){
                                  echo "<button type='button' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' " . 
                                  (strpos($role[0]['role_akses'], ',6,') !== FALSE ? "" : "disabled") . ">
                                  Terkirim Ke <br> Ketua
                                  </button>";
                                  echo "<button type='button' class='btn btn-warning btn-sm btn-history' " . 
                                        (strpos($role[0]['role_akses'], ',5,') !== FALSE ? "" : "disabled") . 
                                        " data-id='" . $row['pemeriksaan_id'] . "' data-toggle='tooltip' data-placement='top' title='History'>
                                        <span class='fa fa-history'></span>
                                        </button>";

                                }elseif($row['kka_kirim_kadiv_dspi'] == "2"){
                                  echo "<button type='button' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' " . 
                                  (strpos($role[0]['role_akses'], ',6,') !== FALSE ? "" : "disabled") . ">
                                  Terkirim Ke <br>Pengawas
                                  </button>";
                                  echo "<button type='button' class='btn btn-warning btn-sm btn-history' " . 
                                        (strpos($role[0]['role_akses'], ',5,') !== FALSE ? "" : "disabled") . 
                                        " data-id='" . $row['pemeriksaan_id'] . "' data-toggle='tooltip' data-placement='top' title='History'>
                                        <span class='fa fa-history'></span>
                                        </button>";

                                }elseif($row['kka_kirim_kadiv_dspi'] == "3"){
                                  echo "<button type='button' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' " . 
                                  (strpos($role[0]['role_akses'], ',6,') !== FALSE ? "" : "disabled") . ">
                                  Terkirim Ke <br>KADIV SPI
                                  </button>";
                                  echo "<button type='button' class='btn btn-warning btn-sm btn-history' " . 
                                        (strpos($role[0]['role_akses'], ',5,') !== FALSE ? "" : "disabled") . 
                                        " data-id='" . $row['pemeriksaan_id'] . "' data-toggle='tooltip' data-placement='top' title='History'>
                                        <span class='fa fa-history'></span>
                                        </button>";
                                }
                                else{
                                  echo "<button type='button' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' " . 
                                  (strpos($role[0]['role_akses'], ',6,') !== FALSE ? "" : "disabled") . ">
                                  Approve Ke <br>KADIV SPI
                                  </button>";
                                  echo "<button type='button' class='btn btn-warning btn-sm btn-history' " . 
                                        (strpos($role[0]['role_akses'], ',5,') !== FALSE ? "" : "disabled") . 
                                        " data-id='" . $row['pemeriksaan_id'] . "' data-toggle='tooltip' data-placement='top' title='History'>
                                        <span class='fa fa-history'></span>
                                        </button>";
                                }
                              ?>
                            <?php }?>
                          </td>
                        </tr>
                        <?php $no++; } ?>
                      </tbody>
                    </table>
                  </div>
                  </div>
                </div>
                <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="historyModalLabel">Riwayat Pengiriman Kertas Kerja Audit</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="historyContent">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div id="content">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                  </div>
              </div>
              <!-- modal reject -->
               <?php $id_pmr = $this->uri->segment(3); ?>
                <div class="modal fade" id="modalreject" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="modalLabel">Konfirmasi Pengembalian</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <form id="formKKA" method="POST" action="<?= base_url('administrator/reject_kka') ?>">
                              <div class="modal-body">
                                  <p>Silakan masukkan alasan pengembalian:</p>
                                  <textarea name="alasan" id="alasanKKA" class="form-control" rows="3" placeholder="Masukkan alasan..." required></textarea>
                                  <input type="hidden" name="id_pmr" value="<?= $id_pmr; ?>"> <!-- ID Pemeriksaan -->
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-danger">Ya, Kembalikan</button>
                              </div>
                          </form>
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
    <!-- Sweet Alert -->
    <script src="<?php echo base_url(); ?>/asset/sweetalert/sweetalert.min.js"></script>
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
     !function ($) {
        document.getElementById('tanyarentang').value = 'N';
        $('#pakerentang').hide();
      }(window.jQuery);
    </script>
    <script>
    $('input[name="waktu"]:radio').change(function(){    
        var isi = this.value;
        if (isi == "N") {
          $('#pakerentang').hide();
        }else{
          $('#tanyarentang').hide();
          $('#pakerentang').show();
        }
    });
    </script>
      <script type="text/javascript">
        <?php if ($this->session->flashdata('gagal')!=null) { ?>
        swal("Gagal!", "Sudah ada Tindak Lanjut pada pemeriksaan ini!", "warning");
        <?php } ?>
      </script>
      <script>
    function toggleReadMore() {
        var dots = document.getElementById("dots");
        var moreText = document.getElementById("more");
        var btnText = document.getElementById("myBtn");

        if (dots.style.display === "none") {
            dots.style.display = "inline";
            btnText.innerHTML = "Read More";
            moreText.style.display = "none";
        } else {
            dots.style.display = "none";
            btnText.innerHTML = "Read Less";
            moreText.style.display = "inline";
        }
    }
    function toggleReadMore1() 
    {
        var dots = document.getElementById("dots1");
        var moreText = document.getElementById("more1");
        var btnText = document.getElementById("myBtn1");

        if (dots.style.display === "none") {
            dots.style.display = "inline";
            btnText.innerHTML = "Read More";
            moreText.style.display = "none";
        } else {
            dots.style.display = "none";
            btnText.innerHTML = "Read Less";
            moreText.style.display = "inline";
        }
    }
//     $(document).ready(function () {
//     $(".btn-history").click(function () {
//         var id = $(this).data("id"); // Ambil ID dari tombol
//         var url = "<?= base_url('administrator/history_kka/') ?>" + id; // Buat URL lengkap
        
//         console.log("URL yang dikirim: " + url); // Debug: Cek URL di Console

//         // Panggil AJAX untuk mengambil data history
//         $.ajax({
//             url: url, // Gunakan URL yang sudah dibuat
//             type: "GET",
//             success: function (response) {  
//                 $("#historyModal").modal("show"); // Tampilkan modal
//             },
//             error: function () {
//                 $("#historyContent").html("<p class='text-danger'>Gagal memuat data.</p>");
//             }
//         });
//     });
// });
$(document).ready(function () {
    $(".btn-history").click(function () {
        var id = $(this).data("id"); // Ambil ID dari tombol
        var url1 = "<?= base_url('administrator/history_kka/') ?>" + id; // Buat URL lengkap

        console.log("URL yang dikirim: " + url1); // Debug: Cek URL di Console

        // Panggil AJAX untuk mengambil data history
        $.ajax({
            url: "<?= base_url('administrator/history_kka') ?>/" + id, // URL dengan ID
            type: "GET",
            success: function (response) {
                if (response.success) {
                    var html = "<ul class='timeline'>";

                    response.data.forEach(function (item) {
                        var textColor = item.revisi == 1 ? "text-danger" : ""; // Jika revisi = 1, ubah warna merah
                        var ApprovedColor = item.user_level == "kabagspi" ? "text-success" : ""; // Jika revisi = 1, ubah warna merah
                        var revisiText = item.revisi == 1 ? " (Revisi)" : ""; // Tambahkan teks "Revisi" jika revisi = 1
                        var ApprovedText = item.user_level == "kabagspi" ? " (Approved)" : ""; // Tambahkan teks "Revisi" jika revisi = 1

                        html += "<li class='event' data-date='" + item.waktu_kirim + "'>";
                        html += "<p style='font-size:20px;' class='" + textColor + ApprovedColor +"'>" + item.user_nama + revisiText + ApprovedText + "</p>";
                        html += "</li>";
                    });

                    html += "</ul>";

                    $("#historyContent").html(html);
                } else {
                    $("#historyContent").html("<p class='text-danger'>Data tidak ditemukan.</p>");
                }

                $("#historyModal").modal("show"); // Tampilkan modal
            },
            error: function () {
                $("#historyContent").html("<p class='text-danger'>Gagal memuat data.</p>");
            }
        });
    });
});



</script>
    
