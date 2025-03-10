<div class="col-md-8 col-xs-12 col-lg-4">
   <?php $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);?>
    <div class="form-group">
      <label><b>Laporan : </b></label>
      <select class="form-control" id="jenis" name="jenis">
         <!-- <select class="select2_single form-control" multiple="multiple" id="jenis" name="jenis[]"> -->
        <option value="0">-Pilih Jenis Laporan-</option>
        <option value="semua">Rekap Pemeriksaan Berdasarkan Status</option>  
        <option value="lha">Laporan Pemeriksaan Berdasarkan LHA </option>  
        <!-- <option value="status">Status</option> -->
        <?php //if ($this->session->level=="spi" OR $this->session->level=="kabagspi" OR $this->session->level=="viewer" OR $this->session->level=="admin"  OR $this->session->level=="administrasi"): ?>
        <!-- <option value="perkebun">Total Kebun / per Kebun</option>   -->
        <?php //endif ?>
      </select>  
    </div>
  <div id="status">
      <div class="form-group">
      <label><b>Status : </b></label>
      <select name="status" id="status" class="form-control">
        <option value="Sudah di Tindak Lanjut">Sudah di Tindak Lanjut</option>
        <option value="Sudah TL (Belum Optimal)">Sudah di Tindak Lanjut (Belum Optimal)</option>
        <option value="Belum di Tindak Lanjut">Belum di Tindak Lanjut</option>
        <option value="Dikembalikan">Dikembalikan</option>
        <option value="Closed">Closed</option>
      </select>  
      </div>   
  </div>
<div id="lha">
  <div class="form-group">
    <label><b>Nomor LHA: </b></label>
    <input type="text" name="nomor_lha" class="form-control"/> 
  </div>  
</div>
  <div id="pemeriksaan">
      <div class="form-group">
      <label><b>Pemeriksaan : </b></label>
      <?php 
      $unit = $this->session->unit;
      if ($this->session->level=="operator" OR $this->session->level=="verifikator") {
        $pmr = $this->model_app->view_where2_ordering('tb_pemeriksaan','pemeriksaan_jenis','Rutin','unit_id',$unit,'pemeriksaan_tgl_mulai','ASC');
      }elseif($this->session->level=="viewer" OR $this->session->level=="administrasi"){
        $pmr = $this->model_app->view_where_ordering('pemeriksaan_jenis','tb_pemeriksaan','Rutin','pemeriksaan_tgl_mulai','ASC');
      }else{
        $pmr = $this->model_app->view_ordering('tb_pemeriksaan', 'pemeriksaan_id', 'ASC');
      }
      ?>
      <select class="select2_single form-control" name="judul_pmr" id="judul_pmr" style="width: 315px">
        <option></option>
        <?php foreach ($pmr as $key => $value) { ?>
              <option value="<?php echo $value['pemeriksaan_id']?>"><?php echo $value['pemeriksaan_judul']; ?></option> 
        <?php } ?>
      </select>
      </div>
  </div>
  <div id="form-kebun">
    <div class="form-group">
      <label>Kebun :</label>
      <select class="form-control" name="kebun" id="kebun">
        <option value="all">- Semua Kebun -</option>
        <option value="cekbox">- Pilih beberapa kebun -</option>
        <?php $kebun = $this->db->query("SELECT * FROM tb_kebun ORDER BY kebun_id ASC")->result_array(); 
        foreach ($kebun as $row) { ?>
         <option value="<?php echo $row['kebun_id'] ?>"><?php echo $row['kebun_nama']; ?></option>
        <?php } ?>

      </select>
    </div>
  </div>
  <div id="form-pilihkebun">
    <div class="form-group">
      <?php foreach ($kebun as $value) { ?>
        <div class="col-lg-6">
          <input type="checkbox" name="pilihkebun[]" value="<?php echo $value['kebun_id'] ?>"/> <?php echo $value['kebun_nama']; ?>
        </div>
      <?php } ?>
    </div>
  </div>
  <div id="bidang">
    <div class="form-group">
      <label>Bidang :</label>
      <select class="form-control" name="bidang" id="bidang">
        <option value="semuabidang">Semua Bidang</option>
        <?php $bidang = $this->db->query("SELECT * FROM tb_bidangtemuan ORDER BY bidangtemuan_id ASC")->result_array(); 
        foreach ($bidang as $row) { ?>
         <option value="<?php echo $row['bidangtemuan_id'] ?>"><?php echo $row['bidangtemuan_nama']; ?></option>
        <?php } ?>

      </select>
    </div>
  </div>
  <div id="pakerentang" class="col-lg-12"> 
    <div class="form-group">
      <label>Rentang Waktu Pemeriksaan :</label>
        <div class="radio">
          <label>
            <input type="radio" class="" checked value='Y' name='waktu'> Rentang Waktu &nbsp; &nbsp; &nbsp; &nbsp;
            <input type="radio" class="" value='N' name='waktu'> Semua
          </label>
        </div>
    </div>
  </div>
  <div id="rentang">
    <div class="form-group">
      <!-- <label><b>Rentang Tgl. Pemeriksaan : </b></label> -->
          <div class="control-group">
            <div class="controls">
              <div class="input-prepend input-group">
                <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                <input type="text" style="width: 280px" name="rentang" id="reservation" class="form-control" value="" />
              </div>
            </div>
          </div>
    </div> 
  </div>
  <div id="exportexcel" class="col-lg-6"> 
    <div class="form-group">
      <label>Export ke Excel :</label>
        <div class="radio">
          <label>
            <input type="radio" class="" checked value='N' name='ekspor'> Tidak &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            <input type="radio" class="" value='Y' name='ekspor'> Ya
          </label>
        </div>
    </div>
  </div><br>  
  <div class="form-group">
  <button type="submit" class="btn btn-primary pull-right" name="submit" <?php  echo strpos($role[0]['role_akses'],'28')!==FALSE?"":"disabled"; ?>>Submit</button>
  </div>
</div>
