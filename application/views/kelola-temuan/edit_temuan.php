  <title>AKSI | Edit Temuan </title>
  <script src="<?php echo base_url(); ?>/asset/tinymce/tinymce.min.js"></script>
  <script>
    tinymce.init({
      forced_root_block : "",
      selector : '#mytextarea',
       menubar: true,
       image: false,
      plugins: [
        "paste",
        "searchreplace wordcount visualblocks visualchars fullscreen insertdatetime nonbreaking lists"
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
                  <h2>
                    <?php 
                      $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
                      $id_pmr = $this->uri->segment(3);
                    ?>
                    <a href="<?php echo base_url(); ?>administrator/input_spi/<?php echo $id_pmr ?>">
                      <button class="btn btn-xs btn-default"><i class="fa fa-mail-reply"></i></button>
                    </a>
                    Form Edit Temuan
                  </h2>
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
                  foreach ($record as $row) {
                    $attributes = array('class'=>'form-horizontal','role'=>'form', 'id'=>'demo-form2');
                    echo form_open_multipart('administrator/edit_temuan/'.$id_pmr,$attributes);
                     echo "<input type='hidden' name='id' value='$row[temuan_id]'>";
                     $select  = explode("/", $row['sebab_id']);
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
                                <option value="<?php echo $value['bidangtemuan_id']?>"<?php if ($row['bidangtemuan_id'] == $value['bidangtemuan_id']) {echo "selected";}?>><?php echo $value['bidangtemuan_nama']; ?></option>
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
                                <option value="<?php echo $value['temu_id']?>"<?php if ($row['temu_id'] == $value['temu_id']) {echo "selected";}?>><?php echo $value['kode_temuan']."-".$value['klasifikasi_temuan']; ?></option>
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
                                <option value="<?php echo $value['id_ab']?>"<?php if ($row['id_klasifikasi_ab'] == $value['id_ab']) {echo "selected";}?>><?php echo $value['kode_ab']."-".$value['judul_ab']; ?></option>
                              <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                     <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Nominal <span class="required ">*</span></label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                       <input type="text" id="nominal" required="required" name="nominal" class="form-control col-md-9 col-xs-12" value="<?php echo $row['nominal']; ?>">
                     </div>
                   </div>
                    <div class="form-group">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Temuan
                      </label>
                      <div class="col-md-10 col-sm-9 col-xs-12">
                        <textarea id="mytextarea" type="text" name="temuan" rows="5" class="form-control col-md-7 col-xs-12"><?php echo $row['temuan_judul']; ?></textarea>
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
                        <option value="<?php echo $value['sebab_id']?>" <?php if (in_array($value['sebab_id'], $select)) {echo "selected";}?>><?php echo $value['sebab_kode']."-".$value['klasifikasi_sebab']; ?></option>
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
                        <option value="<?php echo $value['coso_id']?>"<?php if ($row['coso_id'] == $value['coso_id']) {echo "selected";}?>><?php echo $value['kode_coso']."-".$value['klasifikasi_coso']; ?></option>
                      <?php } ?>
                      </select>
                    </div></br>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Penyebab
                      </label>
                      <div class="col-md-10 col-sm-9 col-xs-12">
                        <textarea id="mytextarea2" type="text" name="sebab" rows="5" class="form-control col-md-7 col-xs-12"><?php echo $row['penyebab']; ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Kriteria
                      </label>
                      <div class="col-md-10 col-sm-9 col-xs-12">
                        <textarea id="mytextarea3" type="text" name="kriteria" rows="5" class="form-control col-md-7 col-xs-12"><?php echo $row['temuan_kriteria']; ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Upload Dokumen Pendukung
                      </label>
                      <div class="col-md-10 col-sm-9 col-xs-12">
                      <?php 
                            $filependukung = $row['temuan_doc_pendukung'];
                            if ($filependukung === '0' || empty($filependukung)) { 
                          ?>
                      <input type="file" name="upload" accept=".pdf">
                              <p><strong>(Accepted : .pdf)</strong></p>
                              <p><strong>Max. size 20MB</strong></p></br>
                        <?php }else{ 
                            echo "<a href='".base_url("asset/file_pendukung/").$filependukung."' target='_blank'><button type=button class='btn btn-warning btn-sm' data-toggle=tooltip data-placement=top title=Download Dokumen Pendukung style='margin-left: 10px'>Download Dokumen Pendukung</button></a>";
                          }
                        ?>
                      </div>
                    </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-8">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <button type="submit" name="simpan" class="btn btn-success">Simpan Perubahan</button>
                  </div>
                </div>
              <?php } echo form_close(); ?>
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
    </script>