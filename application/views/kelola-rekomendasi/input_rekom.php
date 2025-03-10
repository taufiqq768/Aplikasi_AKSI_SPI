  <title>PTPN XII | Tambah Rekomendasi </title>
  <script src="<?php echo base_url(); ?>/asset/tinymce/tinymce.min.js"></script>
  <script>
  
    tinymce.init({
      forced_root_block : "",
      selector : '#mytextarea',
       // menubar: false,
       image: false,
       plugins: [
        "paste",
        "searchreplace wordcount visualblocks visualchars fullscreen insertdatetime nonbreaking lists"
        ],
        paste_as_text: true
    });
  </script>


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
                  <h2><a href="<?php echo base_url(); ?>administrator/list_rekomendasi/<?php echo $id_pmr ?>/<?php echo $id_temuan ?>"><button type="button" class="btn btn-default btn-xs"><i class="fa fa-mail-reply"></i></button></a>
                    Tambah Rekomendasi <small>(SPI)</small></h2>
                  <ul class="nav navbar-right panel_toolbox">&nbsp;                       
                    <li><a class="close-link"><i class=""></i></a>
                    </li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content"> 
                  <div class="table-responsive"> 
                      <table class="tile_info">
                        <tbody>
                      <?php foreach ($record as $row) { ?>
                      <tr>
                        <th scope="row" style="width: 150px">Jenis Audit</th>
                        <td>: <?php echo $row['pemeriksaan_jenis']; ?></td>
                      </tr>
                      <tr>
                        <th style="width: 150px">Judul</th>
                        <td>: <?php echo $row['pemeriksaan_judul']; ?></td>  
                      </tr>
                       <tr>
                        <th style="width: 150px">Bidang </th>
                        <td>: <?php 
                        $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $row['bidangtemuan_id']))->row_array();
                        echo $bidang['bidangtemuan_nama']; ?></td>  
                      </tr>
                      <tr>
                      <th style="width: 15%">Klasifikasi Temuan</th>
                      <td>: <?php  foreach($record as $value) { 
                        $bidang = $this->model_app->view_profile('tb_master_temuan', array('temu_id'=> $value['temu_id']))->row_array();
                        echo $bidang['klasifikasi_temuan'];} ?></td>
                    </tr>
                    <tr>
                      <th style="width: 15%">Klasifikasi Penyebab</th>
                      <td>: 
                        <?php  
                        foreach($record as $value) { 
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
                      <td>: <?php  foreach($record as $value) { 
                        $bidang = $this->model_app->view_profile('tb_master_coso', array('coso_id '=> $value['coso_id']))->row_array();
                        echo $bidang['klasifikasi_coso'];} ?></td>
                    </tr>
                      <!-- <tr>
                        <th style="width: 150px">Obyek Pemeriksaan</th>
                        <td>: </td>  
                      </tr>
                      <tr> -->
                        <th style="width: 150px">Tanggal Pemeriksaan</th>
                        <td>: <?php 
                              $mulai = explode("-", $row['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $row['pemeriksaan_tgl_akhir']);
                              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                         ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Nama Petugas SPI</th>
                        <td>:
                         <?php 
                          $select  = explode("/", $row['pemeriksaan_petugas']);
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
                      <!-- <tr>
                        <th style="width: 150px">Obyek Pemeriksaan</th>
                        <td>:</td>  
                      </tr>
                      <tr> -->
                        <th style="width: 150px">Temuan</th>
                        <td>: <?php echo $row['temuan_judul']; ?></td>  
                      </tr>
                      </tbody>
                    </table>
                  </div>
                  <br />
                   <?php 
                    $attributes = array('class'=>'form-horizontal','role'=>'form', 'id'=>'demo-form2');
                    echo form_open_multipart('administrator/input_rekomendasi/'.$id_pmr.'/'.$id_temuan,$attributes);
                  ?>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="select2">Klasifikasi Rekomendasi<span class="required ">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" id="select2" name="m_rekomendasi">
                            <option selected>Pilih</option>
                            <?php 
                              $m_rekomen = $this->db->query("SELECT * FROM tb_master_rekomendasi ORDER BY rekomen_id  ASC")->result_array(); 
                              foreach ($m_rekomen as $value) 
                              {
                            ?>
                              <option value="<?php echo $value['rekomen_id']?>"><?php echo $value['judul']; ?></option>
                            <?php } ?>
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="select2">Deadline Pengerjaan<span class="required ">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="input-prepend input-group">
                                <input type="text" name="deadline" id="deadline" class="form-control" />
                                <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              </div>
                      </div>
                    </div>
                      <div class="form-group" >
                          <label class="control-label col-md-2 col-sm-2 col-xs-12">Tujuan Rekomendasi<span class="required ">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-prepend input-group">
                                  <input class="form-check-input" style="width: 50px" type="radio" name="tujuan" checked id="reset" value=<?php echo $row['unit_id']; ?>>
                                  <label class="control-label"><?php echo $row['unit_nama']; ?></label>
                                  <input class="form-check-input" style="width: 50px" type="radio" name="tujuan" id="pihak_lain">
                                  <label class="control-label">Pihak lain</label>
                                </div>
                        </div>
                      </div>
                      <?php } ?>
                      <div class="form-group">
                          <div id="pihak_luar" style="display: none;">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="select2">Divisi<span class="required ">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12" >
                              <select class="form-control" id="select2" name="divisi">
                                <option value="0" selected>Pilih</option>
                                <?php 
                                  $m_rekomen = $this->db->query("SELECT * FROM tb_unit")->result_array(); 
                                  foreach ($m_rekomen as $value) 
                                  {
                                ?>
                                  <option value="<?php echo $value['unit_id']?>"><?php echo $value['unit_nama']; ?></option>
                                <?php } ?>
                              </select>
                            </div></br></br>
                        </div>
                    <div class="form-group">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12" >Rekomendasi <span class="required">*</span>
                      </label>
                      <div class="col-md-8 col-sm-8 col-xs-12">
                        <textarea id="mytextarea" class="resizable_textarea form-control" rows="10" placeholder="Masukkan Deskripsi Rekomendasi" name="a"></textarea>
                      </div>
                    </div>
                   <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-7">
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan Draft</button>
                        <!-- <button type="submit" name="kirim" class="btn btn-success">Kirim</button> -->
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- /page content -->

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
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/dropzone/dist/min/dropzone.min.js"></script>
  <!-- bootstrap-progressbar -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <!-- iCheck -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/iCheck/icheck.min.js"></script>
  <!-- jquery.inputmask -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/moment/min/moment.min.js"></script>
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap-datetimepicker -->    
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <!-- bootstrap-wysiwyg -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/google-code-prettify/src/prettify.js"></script>
  <!-- jQuery Tags Input -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
  <!-- Switchery -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/switchery/dist/switchery.min.js"></script>
  <!-- Select2 -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/select2/dist/js/select2.full.min.js"></script>
  <!-- Parsley -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/parsleyjs/dist/parsley.min.js"></script>
  <!-- Autosize -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/autosize/dist/autosize.min.js"></script>
  <!-- jQuery autocomplete -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
  <!-- starrr -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/starrr/dist/starrr.js"></script>
  <!-- Custom Theme Scripts -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/build/js/custom.min.js"></script> 
  <!-- Dropzone.js -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/dropzone/dist/min/dropzone.min.js"></script>
  <!-- Initialize datetimepicker -->
  
  <script type="text/javascript">
      $('#deadline').datetimepicker({
        format: 'DD-MM-YYYY' });
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
        <script>
        $(document).ready(function() {
    $('input[name="tujuan"]').change(function() {
        if ($('#pihak_lain').is(':checked')) {
            $('#pihak_luar').show();
        } else {
            $('#pihak_luar').hide();
        }
    });
})
    </script>
  </body>
  </html>
