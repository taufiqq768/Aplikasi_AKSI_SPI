<!--Starrt sidebar menu -->
<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="#" class="site_title">
      <?php 
        $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);
        $usr = $this->model_app->view('tb_identitas');
        foreach ($usr->result_array() as $row) {
           echo "<img src='".base_url()."asset/images/$row[identitas_logo]' style='width: 50px'>";
        ?>&nbsp;<span><?= $row['identitas_namaweb']?></span></a>
      <?php } ?>
    </div>

    <div class="clearfix"></div>
    <br />
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>Menu <?php print_r($this->session->level); ?></h3>
        <ul class="nav side-menu">
          <li>
            <a href="<?php echo base_url(); ?>dashboard/status_rekomendasi"><i class="fa fa-home"></i> Dashboard</a>
          </li>
          <li>
            <a href="<?php echo base_url(); ?>tabulasi/status_rekomendasi"><i class="fa fa-home"></i> Dashboard Tabulasi</a>
          </li>
          <?php if($this->session->level=="admin" OR $this->session->level=="spi" OR $this->session->level=="kabagspi" OR $this->session->level=="administrasi") {?>
          <li><a><i class="fa fa-edit"></i>Pemeriksaan <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <?php if($this->session->level=="admin" OR $this->session->level=="administrasi") {?>
              <li><a href="<?php echo base_url().'administrator/daftar_pmr'; ?>">Daftarkan Pemeriksaan</a></li>
              <?php }?>
              <?php if($this->session->level=="admin" OR $this->session->level=="spi" OR $this->session->level=="kabagspi") {?>
              <li><a href="<?php echo base_url().'administrator/list_kka'; ?>">Kertas Kerja Audit</a></li>
              <?php }?>
              <?php if($this->session->level=="admin" OR $this->session->level=="spi" OR $this->session->level=="kabagspi" OR $this->session->level=="administrasi") {?>
              <li><a href="<?php echo base_url().'administrator/list_pemeriksaan'; ?>">Data Hasil Audit</a></li>
              <?php }?>
               <?php //if($this->session->level=="admin") {?>
              <!-- <li><a href="<?php // echo base_url().'data'; ?>"></i> Hapus Data Pemeriksaan</a></li> -->
              <?php //}?>
            </ul>
          </li>
         <?php }  ?>
         <?php if ($this->session->level=="viewer"): ?>
           <li>
             <a href="<?php echo base_url().'administrator/list_pemeriksaan'; ?>"><i class="fa fa-edit"></i>List Pemeriksaan &nbsp;</a>
           </li>
         <?php endif ?>

         <?php if($this->session->level == "operator" OR $this->session->level=="verifikator"){ ?>
          <li><a><i class="fa fa-desktop"></i> Tindak Lanjut <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <?php if($this->session->level=="operator"){?>
             <li><a href="<?php echo base_url().'administrator/list_pmr_operator'; ?>">Data Pemeriksaan</a></li>
                <?php } ?>
                <?php if($this->session->level=="verifikator"){?>
             <li><a href="<?php echo base_url().'administrator/list_pmr_verifikator'; ?>">Verifikasi Tindak Lanjut</a></li>
                <?php } ?>
           </ul>
         </li>
         <?php } ?>
         <?php if ($this->session->level==("spi" OR "operator" OR "kabagspi")): ?>
          <li>
            <a href="<?php echo base_url().'laporan/laporan_tabular'; ?>"><i class="fa fa-file-text"></i> Laporan</a>
          </li>           
         <?php endif ?>
        
        <?php if ($this->session->level!="viewer"): ?>
         <!-- <li>
          <a href="<?php echo base_url().'message/kotakmasuk'; ?>"><i class="fa fa-envelope"></i>Kotak Masuk &nbsp;<span class="badge bg-blue" id="shownotifpesan"><?php //echo $inbox; ?></span> </a>
        </li>   -->
         <?php endif ?> 
         
        <?php if ($this->session->level=="admin") { ?>
        <li><a><i class="fa fa-users"></i> Manajemen User <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="<?php echo base_url().'administrator/list_user'; ?>">List User</a></li>
            <li><a href="<?php echo base_url().'administrator/role_user'; ?>">Atur Role User</a></li>
          </ul>
        </li>
        <li><a><i class="fa fa-users"></i> Master Data Klasifikasi <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="<?php echo base_url().'administrator/list_sebab'; ?>">Klasifikasi Penyebab</a></li>
            <li><a href="<?php echo base_url().'administrator/list_bidang'; ?>">Klasifikasi Bidang</a></li>
            <li><a href="<?php echo base_url().'administrator/list_m_temuan'; ?>">Klasifikasi Temuan</a></li>
            <li><a href="<?php echo base_url().'administrator/list_coso'; ?>">Klasifikasi COSO</a></li>
            <li><a href="<?php echo base_url().'administrator/list_m_rekomendasi'; ?>">Klasifikasi Rekomendasi</a></li>
          </ul>
        </li>
        <li><a><i class="fa fa-users"></i> Master Data Sistem <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="<?php echo base_url().'administrator/list_divisi'; ?>">Divisi</a></li>
            <li><a href="<?php echo base_url().'administrator/list_reg'; ?>">Regional</a></li>
            <li><a href="<?php echo base_url().'administrator/list_anper'; ?>">Anak Perusahaan PTPN I</a></li>
          </ul>
        </li>
        <li>
            <a href="<?php echo base_url().'administrator/list_pkpt'; ?>"><i class="fa fa-file-text"></i> Manajemen PKPT</a>
        </li> 
        <?php } ?>
        <?php if($this->session->level=="admin" OR $this->session->level=="administrasi") {?>
        <!-- <li><a><i class="fa fa-gears"></i> FAQ <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="<?php echo base_url().'faq/list_faq'; ?>">Kelola FAQ</a></li>
            <li><a href="<?php echo base_url().'faq/view_faq'; ?>">FAQ</a></li>
          </ul>
        </li> -->
        <?php } ?>

        <?php if ($this->session->level=="operator" OR $this->session->level=="verifikator" OR $this->session->level=="spi" OR $this->session->level=="kabagspi" or $this->session->level=="viewer"){ ?>
              <li>
              <!-- <a href="<?php echo base_url().'faq/view_faq'; ?>"><i class="fa fa-gears"></i>FAQ</a> -->
            </li>
        <?php } ?>
          <?php if (strpos($role[0]['role_akses'],'30')): ?>
          <li>
            <a href="<?php echo base_url().'backup_dbase/backup_db'; ?>"><i class="fa fa-cloud-upload"></i> Backup Data</a>
          </li>   
          <?php endif ?>
         
      <?php //} ?>
      </ul>
    </div>
  </div>
</div>
</div>

<!-- /sidebar menu-->
<script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jquery/dist/jquery.min.js"></script>
        <!-- /top navigation -->
        <script>
          $(document).ready(function(){
            setInterval(function(){
              load_notifpesan();

            }, 1000);
            function load_notifpesan(){
               // console.log('masuk');
           var BASE_URL = "<?php echo base_url('notifikasi/notifpesan/');?>";
           var urll = BASE_URL;
           // console.log(urll);
            $.ajax({
                type  : 'ajax',
                url   : urll,
                async : true,
                dataType : 'json',
                success : function(data){
                  // console.log(data);
                var html = '';
                var i;
                var no=1;
                html = data;
                $('#shownotifpesan').html(html);
                }
                //window.alert(urll);
            });

            }
          });
        </script>