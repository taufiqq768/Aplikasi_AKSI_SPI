  <title>AKSI | Tambah Temuan</title>
  <head>tambah temuan</head>
  <style>
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
  <script src="<?php echo base_url(); ?>/asset/tinymce/tinymce.min.js"></script>
  <script>
    tinymce.init({
      forced_root_block : "",
      selector : '#mytextarea',
       // menubar: false,
       plugins: [
        "paste",
        // "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars fullscreen insertdatetime nonbreaking lists",
        // "save table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker",
        // 'advlist autolink image lists charmap print preview'
        ],
        paste_as_text: true
    });
    tinymce.init({
      forced_root_block : "",
      selector : '#mytextarea2',
       // menubar: false,
       plugins: [
        "paste",
        // "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars fullscreen insertdatetime nonbreaking lists",
        // "save table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker",
        // 'advlist autolink image lists charmap print preview'
        ],
        paste_as_text: true
    });
    tinymce.init({
      forced_root_block : "",
      selector : '#mytextarea3',
       // menubar: false,
       plugins: [
        "paste",
        // "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars fullscreen insertdatetime nonbreaking lists",
        // "save table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker",
        // 'advlist autolink image lists charmap print preview'
        ],
        paste_as_text: true
    });
  </script>
      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <!-- <div class="page-title">
            <div class="title_left">
              <h3>Tambah Temuan</h3>
            </div>
          </div> -->
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <?php 
                  $id_pmr = $this->uri->segment(3); ?>
                  <h2>
                  <?php   echo "<a href='".base_url()."administrator/input_spi/$id_pmr'"?><button class="btn btn-xs btn-default" type="button"><i class="fa fa-mail-reply"></i> </button></a>
                  Form Tambah Temuan<small></small></h2>
                  <ul class="nav navbar-right panel_toolbox">&nbsp;                       
                    <li><a class="close-link"><i class=""></i></a>
                    </li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                  <?php 
                  $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
                  $id_pmr = $this->uri->segment(3);
                  ?>
                  <?php 
                    $attributes = array('class'=>'form-horizontal','role'=>'form', 'id'=>'demo-form2');
                    echo form_open_multipart('administrator/tambah_temuan/'.$id_pmr,$attributes);
                  ?>
                      <div class="form-group" style="padding-left: 184px;">
                        <div class="container">
                          <!-- Baris tunggal dengan semua elemen select -->
                          <div class="row d-flex justify-content-between align-items-center">
                            <div class="col-md-3 text-center">
                              <label for="select1">Bidang</label>
                              <select class="form-control" id="select1" name="bidang">
                              <option selected>Pilih</option>
                              <?php 
                                $bidang = $this->db->query("SELECT * FROM tb_bidangtemuan ORDER BY bidangtemuan_id ASC")->result_array(); 
                                foreach ($bidang as $value) 
                                {
                              ?>
                                <option value="<?php echo $value['bidangtemuan_id']?>"><?php echo $value['bidangtemuan_nama']; ?></option>
                              <?php } ?>
                              </select>
                            </div>
                            <div class="col-md-3 text-center">
                              <label for="select2">Klasifikasi Temuan</label>
                              <select class="form-control" id="select2" name="m_temuan">
                                <option selected>Pilih</option>
                              <?php 
                                $m_temuan = $this->db->query("SELECT * FROM tb_master_temuan ORDER BY temu_id ASC")->result_array(); 
                                foreach ($m_temuan as $value) 
                                {
                              ?>
                                <option value="<?php echo $value['temu_id']?>"><?php echo $value['kode_temuan']."-".$value['klasifikasi_temuan']; ?></option>
                              <?php } ?>
                              </select>
                            </div>
                            <div class="col-md-3 text-center">
                              <label for="select2">Klasifikasi A & B</label>
                              <select class="form-control" name="a_b">
                                <option selected>Pilih</option>
                              <?php 
                                $m_a_b = $this->db->query("SELECT * FROM tb_master_ab ORDER BY id_ab  ASC")->result_array(); 
                                foreach ($m_a_b as $value) 
                                {
                              ?>
                                <option value="<?php echo $value['id_ab']?>"><?php echo $value['kode_ab']."-".$value['judul_ab']; ?></option>
                              <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                     <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Nominal<span class="required ">*</span></label>
                     <div class="col-md-3  ">
                       <input type="text" id="nominal" required="required" name="nominal" class="form-control col-md-9 col-xs-12" value="<?php echo set_value('nominal'); ?>">
                     </div>
                   </div>
                    <div class="form-group">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Kondisi
                      </label>
                      <div class="col-md-10 col-sm-9 col-xs-12">
                        <textarea id="mytextarea" type="text" name="temuan" rows="5" class="form-control col-md-7 col-xs-12"></textarea>
                      </div>
                    </div>
                    <div class="form-group" style="padding-left: 174px;">
                      <div class="col-md-3 text-center">
                        <label for="select3">Klasifikasi Penyebab</label>
                        <select class="select2_single form-control" multiple="multiple" id="sebab" name="sebab[]">
                        <?php 
                          $m_sebab = $this->db->query("SELECT * FROM tb_master_penyebab ORDER BY sebab_id ASC")->result_array(); 
                          foreach ($m_sebab as $value) 
                          {
                        ?>
                          <option value="<?php echo $value['sebab_id']?>"><?php echo $value['sebab_kode']."-".$value['klasifikasi_sebab']; ?></option>
                        <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-3 text-center" style="padding-right: 20px;">
                        <label for="select4">Klasifikasi COSO</label>
                        <select class="form-control" id="select4" name="coso">
                          <option selected>Pilih</option>
                        <?php 
                          $m_coso = $this->db->query("SELECT * FROM tb_master_coso ORDER BY coso_id ASC")->result_array(); 
                          foreach ($m_coso as $value) 
                          {
                        ?>
                          <option value="<?php echo $value['coso_id']?>"><?php echo $value['kode_coso']."-".$value['klasifikasi_coso']; ?></option>
                        <?php } ?>
                        </select>
                      </div></br>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Penyebab
                      </label>
                      <div class="col-md-10 col-sm-9 col-xs-12">
                        <textarea id="mytextarea2" type="text" name="penyebab" rows="5" class="form-control col-md-7 col-xs-12"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Kriteria
                      </label>
                      <div class="col-md-10 col-sm-9 col-xs-12">
                        <textarea id="mytextarea3" type="text" name="kriteria" rows="5" class="form-control col-md-7 col-xs-12"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Upload Dokumen Pendukung
                      </label>
                      <div class="col-md-10 col-sm-9 col-xs-12">
                      <input type="file" name="upload" accept=".pdf" onchange="validateFileSize(this)">
                      <div id="popupSizeError" class="popup-error">Ukuran file terlalu besar! Maksimal 25MB.</div>
                              <p><strong>(Accepted : .pdf)</strong></p>
                              <p><strong>Max. size 25MB</strong></p></br>
                      </div>
                    </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-6">
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan Draft</button>
                    <!-- <button type="submit" name="kirim" class="btn btn-success">Kirim ke Kadiv SPI</button> -->
                  </div>
                </div>
                <br/><br> 
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
    <!-- Select2 -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/select2/dist/js/select2.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
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
     <script>
      $(document).ready(function () {
        $('#sebab').select2({
          placeholder: "Pilih"
        });
      });
    </script>
    <script type="text/javascript">
      $('#myDatepicker').datetimepicker({
        format: 'YYYY-MM-DD' });
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