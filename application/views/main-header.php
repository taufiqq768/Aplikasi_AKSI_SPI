        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <?php $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $this->session->username))->row_array(); ?>
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo base_url() ?>/asset/images/user.png" alt=""><?php echo $usr['user_nama']; //$this->session->userdata('user_nama'); ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?php echo base_url(); ?>administrator/edit_profile/<?php echo $usr['user_nik']?>"> Profile</a></li>
                    <li><a href="<?php echo base_url(); ?>administrator/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
                <?php 
                $unit = $this->session->unit;
                $level = $this->session->level;
                $date = date('Y-m-d');
                $query = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE NOT (rekomendasi_status = 'Sudah di Tindak Lanjut' OR rekomendasi_status = 'Sudah TL (Belum Optimal)') AND unit_id = '$unit' ORDER BY rekomendasi_tgl ASC")->result_array(); 
                $query2 = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE NOT (rekomendasi_status = 'Sudah di Tindak Lanjut' OR rekomendasi_status = 'Sudah TL (Belum Optimal)') AND unit_id = '$unit' ORDER BY rekomendasi_tgl ASC LIMIT 4")->result_array();
                
                // var_dump($query3); 
                if ($this->session->level=="operator" or $this->session->level=="verifikator") { ?>
                
                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-exclamation-circle"></i>
                    <?php if ($query!=null): 
                          $hitung = count($query);
                    ?>
                      <span class="badge bg-red" title="Deadline" id="show"><small><?php //echo $hitung; ?></small></span>  
                    <?php endif ?>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    
                     <?php  
                     $no = 0; $hitung = 0; $count_op = 0;
                     foreach ($query2 as $key => $value) {
                      $expired = ''; $op = [];
                      $exp = '';
                      $exp = explode("-", $value['rekomendasi_tgl']);
                      $tgl = $exp[2];
                      $thn = $exp[0];
                      $bln = (int)$exp[1] + 4;
                      if ($bln<=9) {
                        $bln = "0".$bln;
                      }
                      
                      if ($exp[1]=="09" OR "10" OR "11" OR "12") {
                        if ($exp[1]=="09") {
                          $thn = (int)$thn + 1;
                          $bln = "01";  
                        }
                        if ($exp[1]=="10") {
                          $thn = (int)$thn + 1;
                          $bln = "02";  
                        }
                        if ($exp[1]=="11") {
                          $thn = (int)$thn + 1;
                          $bln = "03";  
                        }
                        if ($exp[1]=="12") {
                          $thn = (int)$thn + 1;
                          $bln = "04";  
                        }
                      }
                      
                      foreach ($query as $key ) {
                        $rekomtgl = $key['rekomendasi_tgl'];
                        $rekomtgl = date('Y-m-d', strtotime("+4 months", strtotime($rekomtgl)));
                        // echo $rekomtgl."<br>";
                        if (date('Y-m-d')<= $rekomtgl ) {
                          $op[] = $key['rekomendasi_tgl'];
                        }
                      }
                      // echo count($op);
                      // date_add($rekomtgl,);
                      // echo date_format($rekomtgl, 'Y-m-d');
                      $expired = $thn."-".$bln."-".$tgl;
                       // echo $expired;
                       if ($expired >= date('Y-m-d')) {
                        $no++;
                        ?>
                          <li>
                            <?php if ($this->session->level=="admin" OR $this->session->level=="spi"){ ?>
                              <?php   echo "<a href='".base_url()."administrator/view_temuan/$value[pemeriksaan_id]'>" ?>
                            <?php }elseif ($this->session->level == "operator") { ?>
                              <?php   echo "<a href='".base_url()."administrator/list_tl/$value[pemeriksaan_id]/$value[temuan_id]/$value[rekomendasi_id]'>" ?>
                              <!-- <a href="<?php //echo base_url(); ?>/administrator/list_pmr_operator"> -->
                            <?php }elseif($this->session->level == "verifikator"){ ?>
                              <?php   echo "<a href='".base_url()."administrator/list_tl_verifikator/$value[pemeriksaan_id]/$value[temuan_id]/$value[rekomendasi_id]'>" ?>
                              <!-- <a href="<?php //echo base_url(); ?>/administrator/list_pmr_verifikator"> -->
                                
                              
                            <?php } ?>
                              <span>
                                  <span><b>Deadline !</b></span>
                                   <b><i class="fa fa-time"></i><?php  echo $tgl."-".$bln."-".$thn; ?></b>
                                </span>
                                  <span class="message">
                                   <?php echo "<b>Pemeriksaan : </b> ".$value['pemeriksaan_judul']."<br><b>Rekomendasi : </b><br>";
                                   //substr($value['rekomendasi_judul'], 0, 75)."..."; 
                                    
                                    $kata = explode(" ", $value['rekomendasi_judul']);
                                    // print_r($kata);
                                    $hitung1 = count($kata);
                                    if ($hitung1 < 6) {
                                      echo $value['rekomendasi_judul'];
                                    }else{
                                      for ($i=0; $i < 6; $i++) { 
                                        echo $kata[$i]." ";
                                      }
                                      if ($hitung1 > 5) {
                                        echo "...";
                                      }  
                                    }
                                    
                                   ?> 
                                  </span>
                                </a>
                          </li>   
                       <?php 
                       }
                       // $no++;
                      }
                      if ($query!=null) {
                        $count_op = count($op);
                      }
                      
                      if ($hitung > 4) {
                     ?>
                    <li>
                      <div class="text-center">
                        <?php   echo "<a href='".base_url()."notifikasi/all_notifdeadline/$level/$unit'"?>
                          <b>See (<?php echo $count_op ?>) All Deadline Alerts</b>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  <?php } ?>
                  </ul>
                </li>
                <?php }
                ?>

                <?php 
                if ($this->session->level=="spi" OR $this->session->level=="operator" OR $this->session->level=="verifikator") { ?>
                
                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <?php 
                    if ($this->session->level=="spi") {
                      $kueri = $this->db->query("SELECT * FROM tb_tl JOIN tb_rekomendasi ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id JOIN tb_pemeriksaan ON tb_tl.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE tl_publish_spi = 'Y' AND tl_status_from_spi='N' AND tl_tanggapan_publish_kabag='N' AND NOT(rekomendasi_status = 'Sudah di Tindak Lanjut' OR rekomendasi_status ='Sudah TL (Belum Optimal)') ORDER BY tl_tgl ASC LIMIT 3")->result_array();
                      $kueri2 = $this->db->query("SELECT * FROM tb_tl JOIN tb_rekomendasi ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id JOIN tb_pemeriksaan ON tb_tl.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE tl_tanggapan_publish_kabag ='N' AND tl_catatan_publish_spi='Y' AND NOT(rekomendasi_status = 'Sudah di Tindak Lanjut' OR rekomendasi_status ='Sudah TL (Belum Optimal)') LIMIT 3")->result_array();
                      $kueri3 = $this->db->query("SELECT * FROM tb_tl JOIN tb_rekomendasi ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id JOIN tb_pemeriksaan ON tb_tl.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE tl_tanggapan_publish_kabag ='N' AND tl_catatan_publish_spi='Y' AND NOT(rekomendasi_status = 'Sudah di Tindak Lanjut' OR rekomendasi_status ='Sudah TL (Belum Optimal)') LIMIT 2")->result_array();
                      $kueri4 = $this->db->query("SELECT * FROM tb_temuan JOIN tb_pemeriksaan ON tb_temuan.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE temuan_kirim = 'K' ORDER BY temuan_tgl ASC")->result_array();
                      $kueri42 = $this->db->query("SELECT * FROM tb_temuan JOIN tb_pemeriksaan ON tb_temuan.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE temuan_kirim = 'K' ORDER BY temuan_tgl ASC LIMIT 2")->result_array();
                    }elseif ($this->session->level=="operator") {
                      $kueri = $this->db->query("SELECT * FROM tb_tl JOIN tb_rekomendasi ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id JOIN tb_pemeriksaan ON tb_tl.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE unit_id = '$unit' AND (tl_status_from_spi = 'Y' OR tl_status_from_vrf='Y') AND NOT(rekomendasi_status = 'Sudah di Tindak Lanjut' OR rekomendasi_status ='Sudah TL (Belum Optimal)') ORDER BY tl_tgl ASC")->result_array();
                      $kueri2 = $this->db->query("SELECT * FROM tb_tl JOIN tb_rekomendasi ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id JOIN tb_pemeriksaan ON tb_tl.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE tl_tanggapan_kirim ='Y' AND tl_catatan_publish_vrf='N' AND unit_id='$unit' AND NOT(rekomendasi_status ='Sudah di Tindak Lanjut' OR rekomendasi_status ='Sudah TL (Belum Optimal)')")->result_array();
                      $kueri3 = $this->db->query("SELECT * FROM tb_tl JOIN tb_rekomendasi ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id JOIN tb_pemeriksaan ON tb_tl.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE tl_tanggapan_kirim ='Y' AND tl_catatan_publish_vrf='N' AND unit_id='$unit'  AND NOT(rekomendasi_status ='Sudah di Tindak Lanjut' OR rekomendasi_status ='Sudah TL (Belum Optimal)') LIMIT 2")->result_array();

                    }elseif ($this->session->level=="verifikator") {
                      $kueri = $this->db->query("SELECT * FROM tb_tl JOIN tb_rekomendasi ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id JOIN tb_pemeriksaan ON tb_tl.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE unit_id = '$unit' AND (tl_publish_verif = 'Y' OR 'tl_status_from_spi'='Y') AND tl_publish_spi='N' AND NOT(rekomendasi_status = 'Sudah di Tindak Lanjut') ORDER BY tl_tgl ASC")->result_array();
                      $kueri2 = $this->db->query("SELECT * FROM tb_tl JOIN tb_rekomendasi ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id JOIN tb_pemeriksaan ON tb_tl.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE tl_tanggapan_kirim ='Y' AND tl_catatan_publish_spi='N' AND tl_catatan_publish_vrf='Y' AND unit_id='$unit'")->result_array();
                      $kueri3 = $this->db->query("SELECT * FROM tb_tl JOIN tb_rekomendasi ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id JOIN tb_pemeriksaan ON tb_tl.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE tl_tanggapan_kirim ='Y' AND tl_catatan_publish_spi='N' AND tl_catatan_publish_vrf='Y' AND unit_id='$unit' LIMIT 2")->result_array();
                    }
                    $count = 0;
                    $tung = 0;
                    if ($kueri!=null){ 
                          $count = count($kueri);

                    }
                    if ($kueri2!=null) {
                      $tung = count($kueri2);
                    }
                    $count = $count + $tung;
                    if ($this->session->level=="spi") {  $tung_spi = count($kueri4); $count = $count + $tung_spi; }
                    // echo $count;
                    ?>
                      <span class="badge bg-green" id="show_data2"><small><?php //echo $count; ?></small></span>  
                    
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                     <?php  
                     $no = 1;
                     foreach ($kueri as $key => $value) { ?>
                          <li>
                            <?php if ($this->session->level=="admin" OR $this->session->level=="spi"){ ?>
                              <?php   echo "<a href='".base_url()."administrator/view_temuan/$value[pemeriksaan_id]'>" ?>
                            <?php }elseif ($this->session->level == "operator") { ?>
                              <?php  if ($value['tl_status_from_vrf']=='Y') {
                                      echo "<a href='".base_url()."administrator/list_tl/$value[pemeriksaan_id]/$value[temuan_id]/$value[rekomendasi_id]'>";
                                     }else{ echo "<a href='".base_url()."administrator/riwayat_tl/$value[pemeriksaan_id]/$value[temuan_id]/$value[rekomendasi_id]'>"; } ?>
                              <!-- <a href="<?php //echo base_url(); ?>/administrator/list_pmr_operator"> -->
                            <?php }elseif($this->session->level == "verifikator"){ ?>
                              <?php   echo "<a href='".base_url()."administrator/list_tl_verifikator/$value[pemeriksaan_id]/$value[temuan_id]/$value[rekomendasi_id]'>" ?>
                              <!-- <a href="<?php //echo base_url(); ?>/administrator/list_pmr_verifikator"> -->
                                
                              
                            <?php } ?>
                              <span>
                                <?php if ($this->session->level=="spi") { ?>
                                        <span><b>Rekomendasi : </b></span>
                                        <i class="fa fa-time"></i>
                                        <?php //echo substr($row['faq_jawaban'], 0, 100)."..."; 
                                              $kata = explode(" ", $value['rekomendasi_judul']);
                                              // print_r($kata);
                                              $hitung = count($kata);
                                              if ($hitung < 6) {
                                                echo $value['rekomendasi_judul'];
                                              }else{
                                                for ($i=0; $i < 6; $i++) { 
                                                  echo $kata[$i]." ";
                                                }
                                                if ($hitung > 5) {
                                                  echo "...";
                                                }  
                                              }
                                              
                                        ?>
                                <?php }else{ ?>
                                        <span><b>Status : </b></span>
                                        <i class="fa fa-time"></i><b><?php echo $value['rekomendasi_status']; ?></b>
                                <?php } ?>
                                  
                                </span>
                                  <span class="message">
                                   <?php echo "<b>Tindak Lanjut : </b><br>"; ?> 
                                   <?php //echo substr($row['faq_jawaban'], 0, 100)."..."; 
                                        $kata = explode(" ", $value['tl_deskripsi']);
                                        // print_r($kata);
                                        $hitung = count($kata);
                                        if ($hitung < 6) {
                                          echo $value['tl_deskripsi'];
                                        }else{
                                          for ($i=0; $i < 6; $i++) { 
                                            echo $kata[$i]." ";
                                          }
                                          if ($hitung > 5) {
                                            echo "...";
                                          }  
                                        }
                                        
                                  ?>
                                  </span>
                                </a>
                          </li>   
                       <?php 
                       
                       $no++;
                      }
                      foreach ($kueri3 as $baris) { ?>
                        <li>
                            <?php 
                            if ($this->session->level=="spi") {
                              echo "<a href='".base_url()."administrator/detail_tl/$baris[pemeriksaan_id]/$baris[temuan_id]/$baris[rekomendasi_id]/$baris[tl_id]'>";
                            }elseif ($this->session->level=="operator") {
                              echo "<a href='".base_url()."administrator/riwayat_tl/$baris[pemeriksaan_id]/$baris[temuan_id]/$baris[rekomendasi_id]/$baris[tl_id]'>";
                            }elseif ($this->session->level=="verifikator") {
                              echo "<a href='".base_url()."administrator/riwayat_tl_vrf/$baris[pemeriksaan_id]/$baris[temuan_id]/$baris[rekomendasi_id]/$baris[tl_id]'>";
                            }
                             
                            ?>
                              <span>
                                <span><b>Tindak Lanjut : </b>
                                  <?php echo substr($baris['tl_deskripsi'], 0, 75)."..."; ?>
                                </span>
                              </span>
                              <span class="message">
                                <?php if ($this->session->level=="spi" || $this->session->level=="verifikator"): ?>
                                    <span><b>Respon : </b><br>
                                      <?php echo substr($baris['tl_catatan'], 0, 75)."..."; ?>
                                    </span>   
                                <?php endif ?>
                                 <?php if ($this->session->level=="operator"): ?>
                                    <span><b>Tanggapan : </b><br>
                                      <?php echo substr($baris['tl_tanggapan'], 0, 75)."..."; ?>
                                    </span>   
                                <?php endif ?>
                               
                              </span>
                            </a>
                          </li>
               <?php  }
                      if ($this->session->level=="spi") {
                        for ($i=0; $i < count($kueri42); $i++) { ?> 
                        <li><a href="<?php echo base_url()."administrator/input_spi/".$kueri42[$i]['pemeriksaan_id']; ?>">  <span><b>Keterangan : Dikembalikan oleh Kabag</b><br></span>
                          <span class="message">
                             <span><b>Temuan : </b><br>
                              <?php  echo $kueri42[$i]['temuan_judul']; ?>
                             </span>
                          </span>
                          </a>
                    <?php 
                        }
                      }
                      if ($count > 3) {

                     ?>
                    
                    <li>
                      <div class="text-center">
                        <?php
                          if ($this->session->level=="spi") {
                              echo "<a href='".base_url()."notifikasi/all_notifspi/$level/$unit'";
                          }elseif ($this->session->level=="operator") {
                              echo "<a href='".base_url()."notifikasi/all_notifoperator/$level/$unit'";
                          }elseif ($this->session->level=="verifikator") {
                              echo "<a href='".base_url()."notifikasi/all_notifverifikator/$level/$unit'";
                          }   
                            
                        ?>
                          <b>See (<?php echo $count ?>) All Alerts</b>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  <?php } ?>
                  </ul>
                </li>
                <?php }
                ?>

                <?php if ($this->session->level=="kabagspi"): 
                  $result = $this->db->query("SELECT * FROM tb_temuan JOIN tb_pemeriksaan ON tb_temuan.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE temuan_publish_kabag='Y' AND temuan_kirim='N' ORDER BY temuan_id ASC LIMIT 2")->result_array();
                  $result2 = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id WHERE rekomendasi_publish_kabag='Y' AND rekomendasi_kirim='N' ORDER BY rekomendasi_id ASC LIMIT 2")->result_array();
                  $result3 = $this->db->query("SELECT * FROM tb_tl JOIN tb_rekomendasi ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id WHERE rekomendasi_status_publish_kabag = 'Y' AND rekomendasi_status_kirim='N' LIMIT 2")->result_array();

                  $resultb = $this->db->query("SELECT * FROM tb_temuan JOIN tb_pemeriksaan ON tb_temuan.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE temuan_publish_kabag='Y' AND temuan_kirim='N' ORDER BY temuan_id ASC")->result_array();
                  $result2b = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id WHERE rekomendasi_publish_kabag='Y' AND rekomendasi_kirim='N' ORDER BY rekomendasi_id ASC")->result_array();
                  $result3b = $this->db->query("SELECT * FROM tb_tl JOIN tb_rekomendasi ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id WHERE rekomendasi_status_publish_kabag = 'Y' AND rekomendasi_status_kirim='N' LIMIT 2")->result_array();
                  $count1 = 0;
                  $count2 = 0;
                  $count3 = 0;
                  if ($resultb!=null) {
                    $count1 = count($resultb);
                  }
                  if ($result2b!=null) {
                    $count2 = count($result2b);
                  }
                  if ($result3b!=null) {
                    $count3 = count($result3b);
                  }
                  $htg = $count1 + $count2 + $count3;
                   // echo count($result3);
                  ?>
                  <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell-o"></i>
                    <span class="badge bg-green" id="show_data3"><?php //echo $htg; ?></span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <?php foreach ($result as $key => $value): ?>
                          <li>
                            <?php echo "<a href='".base_url()."administrator/input_spi/$value[pemeriksaan_id]'>" ?>
                              <span>
                                <b>Temuan : </b><br>
                                  <?php echo substr($value['temuan_judul'], 0, 75)."..."; ?>
                                
                              </span>
                              <span class="message">
                               <b><?php echo "Pesan : Temuan perlu di Approve"; ?></b>
                              </span>
                            </a>
                          </li>
                    <?php endforeach ?>
                    <?php foreach ($result2 as $key => $value2): ?>
                          <li>
                             <?php echo "<a href='".base_url()."administrator/list_rekomendasi/$value2[pemeriksaan_id]/$value2[temuan_id]'>" ?>
                              <span>
                                <span><b>Rekomendasi : </b><br>
                                   <?php //echo substr($value2['rekomendasi_judul'], 0, 75)."..."; 
                                       $kata = explode(" ", $value2['rekomendasi_judul']);
                                        // print_r($kata);
                                        $hitung = count($kata);
                                        if ($hitung < 6) {
                                          echo $value2['rekomendasi_judul'];
                                        }else{
                                          for ($i=0; $i < 6; $i++) { 
                                            echo $kata[$i]." ";
                                          }
                                          if ($hitung > 5) {
                                            echo "...";
                                          }  
                                        }
                                   ?>
                                </span>
                              </span>
                              <span class="message">
                               <b><?php echo "Pesan : Rekomendasi perlu di Approve"; ?></b>
                              </span>
                            </a>
                          </li>
                    <?php endforeach ?>
                  <?php foreach ($result3 as $key => $value3): ?>
                          <li>
                             <?php echo "<a href='".base_url()."administrator/view_temuan/$value3[pemeriksaan_id]'>" ?>
                              <span>
                                <span><b>Status : <?php echo $value3['rekomendasi_status_cache']; ?></b><br>
                                   
                                </span>
                              </span>
                              <span class="message">
                                <b>Tindak Lanjut : </b>
                               <?php //echo substr($value2['rekomendasi_judul'], 0, 75)."..."; 
                                       $kata = explode(" ", $value3['tl_deskripsi']);
                                        // print_r($kata);
                                        $hitung = count($kata);
                                        if ($hitung < 6) {
                                          echo $value3['tl_deskripsi'];
                                        }else{
                                          for ($i=0; $i < 6; $i++) { 
                                            echo $kata[$i]." ";
                                          }
                                          if ($hitung > 5) {
                                            echo "...";
                                          }  
                                        }
                                   ?>
                               <br><b>Tanggapan : </b>
                               <?php //echo substr($value2['rekomendasi_judul'], 0, 75)."..."; 
                                       $kata = explode(" ", $value3['tl_tanggapan']);
                                        // print_r($kata);
                                        $hitung = count($kata);
                                        if ($hitung < 6) {
                                          echo $value3['tl_tanggapan'];
                                        }else{
                                          for ($i=0; $i < 6; $i++) { 
                                            echo $kata[$i]." ";
                                          }
                                          if ($hitung > 5) {
                                            echo "...";
                                          }  
                                        }
                                   ?>
                              </span>
                            </a>
                          </li>
                    <?php endforeach ?>
                  <?php if ($htg > 3) { ?>
                      <li>
                      <div class="text-center">
                       <?php echo "<a href='".base_url()."notifikasi/all_notifkabag/$level/$unit'"; ?>
                          <strong>See (<?php echo $htg ?>) All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  <?php } ?>
                    
                  </ul>
                </li>
                <?php endif ?>
              </ul>
            </nav>
          </div>
        </div>
        <!-- jQuery -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jquery/dist/jquery.min.js"></script>
        <!-- /top navigation -->
        <script>
          $(document).ready(function(){
            setInterval(function(){
              load_last_notification();

            }, 2000);
            function load_last_notification(){
               // console.log('masuk');
          var unit = <?php echo json_encode($unit) ?>;
          var level = <?php echo json_encode($level) ?>;
           var BASE_URL = "<?php echo base_url('notifikasi/notif_deadline/');?>";
           var urll = BASE_URL+level+"/"+unit;
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
                $('#show').html(html);
                }
                //window.alert(urll);
            });

            }
          });
        </script>

        <script>
          $(document).ready(function(){
            setInterval(function(){
              load_notification_spi();

            }, 2000);
            function load_notification_spi(){
               // console.log('masuk');
          var unit = <?php echo json_encode($unit) ?>;
          var level = <?php echo json_encode($level) ?>;
           var BASE_URL = "<?php echo base_url('notifikasi/notifikasi_all/');?>";
           var urll = BASE_URL+level+"/"+unit;
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
                $('#show_data2').html(html);
                }
                //window.alert(urll);
            });

            }
          });
        </script>

        <script>
          $(document).ready(function(){
            setInterval(function(){
              load_notification_kabag();

            }, 2000);
            function load_notification_kabag(){
               // console.log('masuk');
          var unit = <?php echo json_encode($unit) ?>;
          var level = <?php echo json_encode($level) ?>;
           var BASE_URL = "<?php echo base_url('notifikasi/notifikasi_kabag/');?>";
           var urll = BASE_URL+level+"/"+unit;
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
                $('#show_data3').html(html);
                }
                //window.alert(urll);
            });

            }
          });
        </script>
