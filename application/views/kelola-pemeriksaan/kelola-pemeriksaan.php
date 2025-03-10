    <title>AKSI | Temuan dan Tindak Lanjut Pemeriksaan</title>
  
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3> Pemeriksaaan <small>Kebun</small></h3>
              </div>
            </div>

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <?php if ($this->session->flashdata('kirimtanggapan')!=null) {
                          echo "<div class='alert alert-success' role='alert' id='forpesan'><em class='fa fa-lg fa-check-circle-o'>&nbsp;</em>".$this->session->flashdata('kirimtanggapan')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                    }elseif ($this->session->flashdata('simpan_tnggp')!=null) {
                      echo "<div class='alert alert-info' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('simpan_tnggp')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                    } ?>
                    <div class="table-responsive">
                    <table class="tile_info">
                      <thead>
                        <center><b>Data Pemeriksaan (Temuan)</b></center>
                        <br>
                      </thead>
                      <?php   foreach ($record as $row) { ?>
                     
                     
                      <tr>
                        <th scope="row" style="width: 150px">Jenis Audit</th>
                        <td>: <?php echo $row['pemeriksaan_jenis']; ?></td>
                      </tr>
                      <tr>
                        <th style="width: 150px">Judul</th>
                        <td>: <?php echo $row['pemeriksaan_judul']; ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Unit </th>
                        <td>: <?php echo $row['unit_nama']; ?></td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Tanggal Pemeriksaan</th>
                        <td>: <?php 
                              $mulai = explode("-", $row['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $row['pemeriksaan_tgl_akhir']);
                              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                         ?></td>
                      </tr>
                      <tr>
                        <th style="width: 150px">Nama Petugas SPI</th>
                        <td> <?php 
                        $select  = explode("/", $row['pemeriksaan_petugas']);
                          if (count($select)==1) {
                            $no = "";
                          }else{
                            $no = 1;
                          }
                          foreach ($select as $nik) {
                            $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $nik))->row_array();
                            echo $no.". ".$usr['user_nama']."<br>";
                            $no++;
                          } ?> </td>  
                      </tr>
                      <tr>
                        <th style="width: 150px">Dokumen Pemeriksaan</th>
                        <td>: <?php if ($row['pemeriksaan_doc']!=null) { ?>
                          <a target="_BLANK" title="Lihat Data" href="<?php echo base_url(); ?>asset/file_pemeriksaan/<?php echo $row['pemeriksaan_doc']?>"><?php  echo $row['pemeriksaan_doc'];  ?></a></td>  
                          <?php }else{
                            echo "-";
                          } ?>
                      </tr>
                      <?php } ?>
                    </table>

                    </div>
                    <br>
                    <!-- accrodion start -->
                    <?php 
                    $no= 1;  $r=1; $bintang = ''; $num = ''; $back =10000; $tback = 30000; $rback = 50000; $rowbaris = 0;
                    $id_pmr = $this->uri->segment(3); 
                    $target = array('Belum di Tindak Lanjut','Tidak dapat di Tindak Lanjuti');
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
                    <div class="accordion" id="accordion<?php echo $no ?>" role="tablist" aria-multiselectable="true">
                      <div class="panel">
                    <?php
                    if ($record[0]['pemeriksaan_sebelumnya']!=null) { ?>
                          <a class="panel-heading collapsed" role="tab" id="headingTwo<?php echo $back?>" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo<?php echo $back?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $back?>">
                                <h4 class="panel-title"><span class="fa fa-caret-down"></span> Pemeriksaan Sebelumnya yang belum Close</h4>
                              </a>
                      </div>
                          <div id="collapseTwo<?php echo $back?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo<?php echo $back?>"  style="padding: 5px 0px 0px 20px" >
                            <?php 
                            $huhu = $row['pemeriksaan_sebelumnya'];
                            $huhu = explode(" ", $huhu);
                            foreach ($huhu as $hmm) {
                              $pmr_back = $this->db->query("SELECT * FROM tb_temuan JOIN tb_pemeriksaan ON tb_temuan.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE NOT(temuan_pmr_sebelumnya = '0') AND temuan_pmr_sebelumnya = '$hmm' AND tb_pemeriksaan.pemeriksaan_id = '$row[pemeriksaan_id]' ORDER BY temuan_id ASC")->result_array();
                             ?>
                             <?php if ($pmr_back!=null): ?>
                            <strong><font size="3"><i class="fa fa-caret-right"></i> <?php $judulpmr = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$pmr_back[0]['temuan_pmr_sebelumnya']);
                                  echo "Pemeriksaan : ".$judulpmr[0]['pemeriksaan_judul']; ?></font></strong>
                               
                             <?php endif ?>
                            <?php if ($pmr_back!=null) {
                                    $htg_temuan = 1;
                                    foreach ($pmr_back as $nilai) { 
                                      $cek_ta = $this->db->query("SELECT rekomendasi_status FROM tb_rekomendasi WHERE temuan_id = '$nilai[temuan_id]' AND rekomendasi_kirim='Y'")->result_array();
                                      // print_r($cek_t);
                                      foreach ($cek_ta as $toa) {
                                        $tia[] = $toa['rekomendasi_status'];
                                      }
                                      $span1a ='';
                                      foreach ($target as $keya) {
                                       if (in_array($keya, $tia)) {
                                          $span1a = " <span class='fa fa-asterisk red'></span>";
                                        }
                                      }
                                      ?>
                                  <div class="panel">
                                  <a class="panel-heading collapsed" role="tab" id="headingTwo<?php echo $tback; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo<?php echo $tback; ?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $tback; ?>"<?php echo $back; ?>>
                                    <h5><span><i class="fa fa-plus">&nbsp;</i></span>
                                      <strong>
                                        <?php 
                                        echo "Temuan ".$htg_temuan.": </strong>";
                                        $temuan = explode(" ", $nilai['temuan_judul']);
                                        $count = count($temuan);
                                        if ($count < 10) {
                                          echo $nilai['temuan_judul'];
                                        }else{
                                          for ($i=0; $i < 10; $i++) { 
                                            echo $temuan[$i]." ";
                                          }
                                          if ($count > 10) {
                                            echo "...";
                                          }
                                        } 
                                        echo $span1a;
                                        ?> 
                                      </h5>
                                  </a>
                                  </div>
                                  <div id="collapseTwo<?php echo $tback; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo<?php echo $tback; ?>" style="padding: 0px 0px 0px 10px">
                                    <div class="panel-body">
                                      <?php  
                                      $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $nilai['bidangtemuan_id']))->row_array();
                                      echo "<b>Bidang : </b>".$bidang['bidangtemuan_nama']."<br>";
                                      echo "<b>Obyek Pemeriksaan : </b>".$nilai['temuan_obyek']."<br>";
                                      echo "<b>Detail Temuan : </b><br>".$nilai['temuan_judul'];
                                      $tmn_id = $nilai['temuan_id'];
                                      $rekomendasi = $this->db->query("SELECT * FROM tb_rekomendasi WHERE temuan_id='$tmn_id' AND rekomendasi_publish_kabag = 'Y'")->result_array();
                                      $htg_rekom = 1;
                                      foreach ($rekomendasi as $kunci => $val) { 
                                       $rowbaris++;  
                                       $span2a = '';
                                       if (in_array($val['rekomendasi_status'], $target)) {
                                         $span2a = " <span class='fa fa-asterisk red'></span>";
                                       }
                                       ?>
                                      <div class="panel">
                                        <a class="panel-heading collapsed" role="tab" id="headingTwo<?php echo $rback; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapseThree<?php echo $rback; ?>" aria-expanded="false" aria-controls="collapseThree<?php echo $rback; ?>">
                                          <h5><span class="fa fa-plus-circle"></span>
                                            <strong>
                                              <?php echo "Rekomendasi ".$htg_rekom.": </strong>"; 
                                              $rekom_back = explode(" ", $val['rekomendasi_judul']);
                                              $count_r = count($rekom_back);
                                              if ($count_r < 10) {
                                                echo $val['rekomendasi_judul'];
                                              }else{
                                                for ($i=0; $i < 9; $i++) { 
                                                  echo $rekom_back[$i]." ";
                                                }
                                                if ($count_r > 10) {?>
                                                  <button class="btn btn-xs btn-round btn-dark" href="#" id="ambilid<?php echo $rowbaris?>" data-toggle="modal" data-target="#readmore" data-id="<?php echo $val['rekomendasi_id']?>"><i style="color: white">. .Lihat Selengkapnya</i></button>
                                            <?php
                                                }
                                              }
                                              echo $span2a;
                                              ?>
                                            
                                          </h5>
                                        </a>
                                        </div>
                                        <div id="collapseThree<?php echo $rback; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree<?php echo $rback; ?>">
                                          <!-- STATUS REKOMENDASI -->
                                          <?php  
                                          if ($val['rekomendasi_status_cache']=="Sesuai") {
                                            $btn_class = 'btn btn-xs btn-round btn-success';
                                          }elseif($val['rekomendasi_status_cache']=="Belum Sesuai"){
                                            $btn_class = 'btn btn-xs btn-round btn-warning';
                                          }elseif ($val['rekomendasi_status_cache']=="Belum di Tindak Lanjut") {
                                            $btn_class = 'btn btn-xs btn-round btn-danger';
                                          }elseif ($val['rekomendasi_status_cache']=="Tidak dapat di Tindak Lanjuti") {
                                            $btn_class = 'btn btn-xs btn-round btn-info';
                                          }else{
                                            $btn_class = 'btn btn-xs btn-round btn-dark';
                                          }
                                          ?>
                                          &nbsp;
                                          <strong>Status Rekomendasi : </strong>
                                          <span class="<?php echo $btn_class ?>"><?= $val['rekomendasi_status_cache'] ?></span>
                                          <!-- <div class="panel-body"> -->
                                    <div class="table-responsive">
                                    <table class="table table-bordered">
                                      <thead>
                                      <th style="width: 45%"><center>Tindak Lanjut</center></th>
                                        <th style="width: 10%"><center>Tgl. TL</center></th>
                                        <th style="width: 30%"><center>Tanggapan</center></th>
                                        <th style="width: 15%"><center>Action</center></th>
                                      </thead>
                                      <tbody>
                                        <?php 
                                          $ambiltl = $this->model_app->view_where2('tb_tl','rekomendasi_id',$val['rekomendasi_id'], 'tl_status_publish_kabag', "Y");
                                          foreach ($ambiltl as $val2) { 
                                             if ($val2['tl_status_cache']=="Sesuai") {
                                              $status = '<span class="btn-round btn-xs btn-success">'.$val2['tl_status_cache'].'</span>';
                                            }elseif($val2['tl_status_cache']=="Belum Sesuai"){
                                              $status = '<span class="btn-round btn-xs btn-warning">'.$val2['tl_status_cache'].'</span>';
                                            }elseif($val2['tl_status_cache']==null){
                                              $status = ' - ';
                                            }elseif($val2['tl_status_cache']=="Tidak dapat di Tindak Lanjuti"){
                                              $status = '<span class="btn-round btn-xs btn-info">'.$val2['tl_status_cache'].'</span>';
                                            }elseif($val2['tl_status_cache']=="Belum di Tindak Lanjut"){
                                              $status = '<span class="btn-round btn-xs btn-danger">'.$val2['tl_status_cache'].'</span>';
                                            }
                                            $pasang= '';
                                            if ($val2['tl_tanggapan']=="" AND ($val['rekomendasi_status']=="Tidak dapat di Tindak Lanjuti" || $val['rekomendasi_status']=="Belum di Tindak Lanjut")) {
                                              $pasang = "<span class='fa fa-circle red'></span>";
                                            }
                                        ?>
                                        <tr>
                                          <td><?php echo "<b>Status TL : </b>".$status."<br>"; echo $val2['tl_deskripsi']."  ".$pasang; ?></td>
                                          <td><center><?php $tgl = explode("-", $val2['tl_tgl']); echo $tgl[2]."-".$tgl[1]."-".$tgl[0]; ?></center></td>
                                          <td>
                                            <?php if ($val2['tl_tanggapan']==null OR $val2['tl_tanggapan_publish_kabag']=='N') {
                                              echo "<center> - </center>";
                                            }else{
                                              if ($val2['tl_tanggapan_publish_kabag']=="Y") {
                                                echo $val2['tl_tanggapan'];
                                              }
                                              
                                            } ?>
                                          </td>
                                          <td>
                                          <?php if ($val['rekomendasi_status']=="Sesuai" OR $val2['tl_tanggapan_publish_kabag']=="Y" OR $val2['tl_status_from_spi']=='Y') {
                                             $yuhu = "disabled";
                                           }else{
                                            $yuhu = '';
                                           } ?>
                                           <?php 
                                            $select  = explode("/", $record[0]['pemeriksaan_petugas']);
                                            $nama = [];
                                              foreach ($select as $nik) {
                                                $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $nik))->row_array();
                                                $nama[] = $usr['user_nama'];
                                              }
                                              if ($this->session->level=="spi") {
                                                if (in_array($this->session->username, $select)) {
                                                  $dis = "";
                                                }else{
                                                  $dis = "disabled";
                                                }
                                              }else{
                                               $dis = "";
                                              }
                                            ?>
                                          <?php if ($val2['tl_tanggapan_publish_kabag']=="Y" AND $val2['tl_tanggapan_kirim']=="N"): ?>
                                                <?php echo "<a href='".base_url()."administrator/kembalikan_tanggapan/$id_pmr/$val2[temuan_id]/$val2[rekomendasi_id]/$val2[tl_id]'>" ?><button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-placement="top" title="Kembalikan Tanggapan ke SPI" <?php echo $disable; ?>><span class="fa fa-mail-reply"></span></button></a>
                                                <?php echo "<a href='".base_url()."administrator/kirim_tanggapan/$id_pmr/$val2[temuan_id]/$val2[rekomendasi_id]/$val2[tl_id]'>" ?><button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-placement="top" title="Kirim Tanggapan ke Kebun" <?php echo $disable; ?>><span class="fa fa-send-o"></span></button></a>
                                                <button class="btn btn-xs btn-default" data-toggle="modal" data-target="#editTL<?php echo $val2['tl_id'] ?>" data-placement="top" title="Edit tanggapan SPI" type="button"><i class="fa fa-edit"></i> Edit</button>
                                          <?php endif ?>
                                            <?php   echo "<a href='".base_url()."administrator/detail_tl/$id_pmr/$val2[temuan_id]/$val2[rekomendasi_id]/$val2[tl_id]'>" ?><button type="button" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail Tindak Lanjut"><i class="fa fa-tags"></i> Detail TL</button></a>
                                        </td>
                                      </tr>
                                      <!-- MODAL EDIT STATUS DAN TANGGAPAN -->
                                      <div class="modal fade" id="editTL<?php echo $val2['tl_id']?>" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                         <div class="modal-header">
                                          <div class="row">
                                            <h4 class="modal-title"><strong>Kelola Tanggapan Tindak Lanjut</strong>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button></h4>
                                          </div>
                                          </div>
                                          <div class="modal-body">
                                          <?php 
                                            $id_pmr = $this->uri->segment(3);
                                             $attributes = array('class'=>'form-horizontal','role'=>'form');
                                             echo form_open('administrator/edit_statustl_kabag/'.$id_pmr,$attributes);
                                              echo "<div class='form-group'><input type='hidden' name='id' value='$val2[tl_id]'></div>";
                                              echo "<div class='form-group'><input type='hidden' name='id_rekom' value='$val2[rekomendasi_id]'></div>";
                                              echo "<div class='form-group'><input type='hidden' name='id_temuan' value='$val2[temuan_id]'></div>";
                                           ?>
                                              <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                                <div class="input-group col-md-8 col-sm-8 col-xs-12">
                                                <select name="status" id="status" class="form-control">\
                                                 <option value="Sesuai" <?php if ($val['rekomendasi_status_cache']=="Sesuai") {echo "selected";}?>>Sesuai</option>
                                                 <option value="Belum Sesuai" <?php if ($val['rekomendasi_status_cache']=="Belum Sesuai") {echo "selected";}?>>Sesuai (Belum Optimal)</option>
                                                 <option value="Belum di Tindak Lanjut" <?php if ($val['rekomendasi_status_cache']=="Belum di Tindak Lanjut") {echo "selected";}?>>Belum di Tindak Lanjut</option>
                                                 <option value="Tidak dapat di Tindak Lanjuti" <?php if ($val['rekomendasi_status_cache']=="Tidak dapat di Tindak Lanjuti") {echo "selected";}?>>Tidak dapat di Tindak Lanjuti</option>
                                                </select>
                                                </div>
                                              </div>
                                               <div class="form-group" id="tanggap">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggapan</label>
                                                  <div class="input-group col-md-8 col-sm-8 col-xs-12">
                                                  <textarea class="form-control" rows="5" placeholder="Masukkan Deskripsi Tanggapan" name="tanggapan"><?php echo $val2['tl_tanggapan']; ?></textarea>
                                                  </div>
                                               </div>
                                          </div><div class="modal-footer">
                                            <div class="form-group">
                                              <div class="col-md-12 col-sm-12 col-xs-12">
                                              <button type="submit" name="simpan" class="btn btn-sm btn-primary pull-right">Simpan Draft</button>
                                              <button type="submit" name="kirim" class="btn btn-sm btn-success pull-right">Kirim</button>
                                              </div>
                                            </div>
                                            </div>
                                          <?php echo form_close(); ?>
                                        </div>
                                      </div>
                                    </div>
                                      <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                                          </div>
                                        <!-- </div> -->
                                        
                                <?php $htg_rekom++; $rback++;
                                      }
                                      ?>
                                      
                                    </div>
                                  </div>
                                  <?php $htg_temuan++; $back++; $tback++; }?>
                                    <!-- ---batas if--- -->
                                  <?php  }
                                }
                                  ?>
                          </div>
                    <?php  
                    } ?>
                      
                    </div>

<!-- --------------------------batas pemeriksaan sebelumnya------------------------- -->
                    <?php
                    foreach ($record2 as $key => $value) {
                      $num.=$no." "; $ti = [];
                      $tmn = $this->model_app->view_where2('tb_rekomendasi','temuan_id',$value['temuan_id'],'rekomendasi_publish_kabag','Y');
                      $target = array('Belum di Tindak Lanjut', 'Tidak dapat di Tindak Lanjuti');
                       $cek_t = $this->db->query("SELECT rekomendasi_status FROM tb_rekomendasi WHERE temuan_id = '$value[temuan_id]' AND rekomendasi_kirim='Y'")->result_array();
                          // print_r($cek_t);
                          foreach ($cek_t as $to) {
                            $ti[] = $to['rekomendasi_status'];
                          }
                          // print_r($ti);
                          $span2 ='';
                          foreach ($target as $key) {
                           if (in_array($key, $ti)) {
                              $span2 = "<span class='fa fa-asterisk'></span>";
                            }
                          }
                      ?>
                       <?php $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);?>
                   <div class="accordion" id="accordion<?php echo $no ?>" role="tablist" aria-multiselectable="true">
                    <div class="panel">
                      <a class="panel-heading collapsed" role="tab" id="headingTwo<?php echo $no;?>" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo<?php echo $no;?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $no;?>">
                        <?php $kata = explode(" ", $value['temuan_judul']); $hitung = count($kata); ?>
                        <h5><span><i class="fa fa-plus">&nbsp;</i></span><strong>Temuan <?php echo $no; ?> : <?php 
                        if ($hitung < 10) {
                          echo $value['temuan_judul'];
                        }else{
                           for ($i=0; $i < 10; $i++) { 
                              echo $kata[$i]." ";
                            }
                            if ($hitung > 10) {
                              echo "...";
                            }
                        }
                         ?> </strong> <?php $tgl = explode('-', $value['temuan_tgl']); echo "(".$tgl[2]."-".$tgl[1]."-".$tgl[0].")"; ?>&nbsp;<?php echo $span2; ?> <!-- <i id="bintang<?php //echo $value['temuan_id']?>"></i> --></h5>
                        
                      </a>
                    </div>                    
                      <div id="collapseTwo<?php echo $no;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo<?php echo $no;?>" style="padding: 0px 0px 5px 20px">
                        <?php if ($hitung > 10): ?>
                        <b>Detail Temuan : </b><br>
                        <?php echo $value['temuan_judul']; ?>    
                        <?php endif ?>
                      
                        <?php
                        $rkm = 1;
                         foreach ($tmn as $row){ 
                          $rowbaris++;
                          if ($row['rekomendasi_status']=='Belum di Tindak Lanjut' OR $row['rekomendasi_status']=='Tidak dapat di Tindak Lanjuti') {
                            $span = "red";
                          }else{
                            $span = "";
                          }
                          
                        ?>
                        <div class="panel">
                          <a class="panel-heading collapsed" role="tab" id="headingThree<?php echo $r; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapseThree<?php echo $r; ?>" aria-expanded="false" aria-controls="collapseThree<?php echo $r; ?>">
                          <h5 class="<?php echo $span?>"><span><i class="fa fa-plus">&nbsp;</i></span><strong><?php echo "Rekomendasi ".$rkm." : "; ?></strong>
                            <?php $rekom = explode(" ", $row['rekomendasi_judul']); 
                            $count_r = count($rekom);
                              if ($count_r < 10) {
                                echo $row['rekomendasi_judul'];
                              }else{
                                for ($i=0; $i < 9; $i++) { 
                                  echo $rekom[$i]." ";
                                }
                                if ($count_r > 10) {?>
                                  <button class="btn btn-xs btn-round btn-dark" href="#" id="ambilid<?php echo $rowbaris?>" data-toggle="modal" data-target="#readmore" data-id="<?php echo $row['rekomendasi_id']?>"><i style="color: white">. .Lihat Selengkapnya</i></button>
                            <?php
                                }
                              }
                              ?>
                            </h5> 
                          </a>
                        </div>
                          <div id="collapseThree<?php echo $r; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree<?php echo $r; ?>">
                            <div class="panel-body">
                            <!-- <p><strong>Rekomendasi</strong></p> -->
                            <?php 
                             if ($row['rekomendasi_status_cache']=="Sesuai") {
                              $btn_class = 'btn btn-xs btn-round btn-success';
                            }elseif($row['rekomendasi_status_cache']=="Belum Sesuai"){
                              $btn_class = 'btn btn-xs btn-round btn-warning';
                            }elseif ($row['rekomendasi_status_cache']=="Belum di Tindak Lanjut") {
                              $btn_class = 'btn btn-xs btn-round btn-danger';
                            }elseif ($row['rekomendasi_status_cache']=="Tidak dapat di Tindak Lanjuti"){
                              $btn_class = 'btn btn-xs btn-round btn-info';
                            }else{
                              $btn_class = 'btn btn-xs btn-round btn-dark';
                            }
                            
                           ?>
                           &nbsp; <strong>Status Rekomendasi : </strong>
                           <?php if ($row['rekomendasi_status']=="Sesuai") {
                             $non = "disabled";
                           }else{
                            $non = '';
                           } ?>
                        
                         <?php if ($row['rekomendasi_status_publish_kabag']=='N'){ ?>
                                <button type="button" class="<?php echo $btn_class?>"><?php  echo $row['rekomendasi_status'];?></button>       
                         <?php }elseif($row['rekomendasi_status_publish_kabag']=='Y'){ ?>
                                <button type="button" class="<?php echo $btn_class?>"><?php  echo $row['rekomendasi_status_cache'];?></button>
                         <?php } ?>
                         
                          <div class="modal fade" id="editRekom<?php echo $row['rekomendasi_id']?>" tabindex="-1" role="dialog" aria-hidden="true">
                           <div class="modal-dialog" role="document">
                             <div class="modal-content">
                              <div class="modal-header">
                               <div class="row">
                                 <h4 class="modal-title"><strong>Kelola Status Rekomendasi</strong>
                                 <button type="button" class="close" data-dismiss="modal">&times;</button></h4>
                               </div>
                               </div>
                               <div class="modal-body">
                               <?php 
                                 $id_pmr = $this->uri->segment(3);
                                  $attributes = array('class'=>'form-horizontal','role'=>'form');
                                  echo form_open('administrator/edit_status_rekom/'.$id_pmr,$attributes);
                                   echo "<div class='form-group'><input type='hidden' name='id' value='$row[rekomendasi_id]'></div>";
                                ?>
                                      <div class="form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status</label>
                                         <div class="input-group col-md-6 col-sm-6 col-xs-12">
                                         <select name="status" id="status" class="form-control">
                                           <!-- <option ><?php //echo $row['rekomendasi_status']; ?></option> -->
                                           <option value="Sesuai" <?php if ($row['rekomendasi_status']=="Sesuai") {echo "selected";}?>>Sesuai</option>
                                           <option value="Belum Sesuai" <?php if ($row['rekomendasi_status']=="Belum Sesuai") {echo "selected";}?>>Sesuai (Belum Optimal)</option>
                                           <option value="Belum di Tindak Lanjut" <?php if ($row['rekomendasi_status']=="Belum di Tindak Lanjut") {echo "selected";}?>>Belum di Tindak Lanjut</option>
                                           <option value="Tidak dapat di Tindak Lanjuti" <?php if ($row['rekomendasi_status']=="Tidak dapat di Tindak Lanjuti") {echo "selected";}?>>Tidak dapat di Tindak Lanjuti</option>
                                         </select>
                                       </div>
                                       </div>
                               </div><div class="modal-footer">
                                 <div class="form-group">
                                   <div class="col-md-12 col-sm-12 col-xs-12">
                                   <button type="submit" name="kirim" class="btn btn-sm btn-primary pull-right">Simpan</button>
                                   </div>
                                 </div>
                                 </div>
                               <?php echo form_close(); ?>
                             </div>
                                      </div>
                                    </div>
                                  <div class="table-responsive">
                                    <table class="table table-bordered">
                                      <thead>
                                      <th style="width: 40%"><center>Tindak Lanjut</center></th>
                                        <th style="width: 15%"><center>Tgl. Tindak Lanjut</center></th>
                                        <th style="width: 30%"><center>Tanggapan</center></th>
                                        <th style="width: 15%"><center>Action</center></th>
                                      </thead>
                                      <tbody>
                                        <?php 
                                          $tl = $this->model_app->view_where2('tb_tl','rekomendasi_id',$row['rekomendasi_id'], 'tl_status_publish_kabag', "Y");
                                          foreach ($tl as $baris) { 
                                             if ($baris['tl_status_cache']=="Sesuai") {
                                              $status = '<span class="btn-round btn-xs btn-success">'.$baris['tl_status_cache'].'</span>';
                                            }elseif($baris['tl_status_cache']=="Belum Sesuai"){
                                              $status = '<span class="btn-round btn-xs btn-warning">'.$baris['tl_status_cache'].'</span>';
                                            }elseif($baris['tl_status_cache']==null){
                                              $status = ' - ';
                                            }elseif($baris['tl_status_cache']=="Tidak dapat di Tindak Lanjuti"){
                                              $status = '<span class="btn-round btn-xs btn-info">'.$baris['tl_status_cache'].'</span>';
                                            }elseif($baris['tl_status_cache']=="Belum di Tindak Lanjut"){
                                              $status = '<span class="btn-round btn-xs btn-danger">'.$baris['tl_status_cache'].'</span>';
                                            }
                                            $pasang= '';
                                            if ($baris['tl_tanggapan']=="" AND ($row['rekomendasi_status']=="Tidak dapat di Tindak Lanjuti" || $row['rekomendasi_status']=="Belum di Tindak Lanjut")) {
                                              $pasang = "<span class='fa fa-circle red'></span>";
                                            }
                                        ?>
                                        <tr>
                                          <td><?php echo "<b>Status TL : </b>".$status."<br>"; echo $baris['tl_deskripsi']."  ".$pasang; ?></td>
                                          <td><center><?php $tgl = explode("-", $baris['tl_tgl']); echo $tgl[2]."-".$tgl[1]."-".$tgl[0]; ?></center></td>
                                          <td>
                                            <?php if ($baris['tl_tanggapan']==null OR $baris['tl_tanggapan_publish_kabag']=='N') {
                                              echo "<center> - </center>";
                                            }else{
                                              if ($baris['tl_tanggapan_publish_kabag']=="Y") {
                                                echo $baris['tl_tanggapan'];
                                              }
                                            } ?>
                                          </td>
                                          <td>
                                          <?php if ($row['rekomendasi_status']=="Sesuai" OR $baris['tl_tanggapan_publish_kabag']=="Y" OR $baris['tl_status_from_spi']=='Y') {
                                             $yuhu = "disabled";
                                           }else{
                                            $yuhu = '';
                                           } ?>
                                           <?php 
                                            $select  = explode("/", $record[0]['pemeriksaan_petugas']);
                                            $nama = [];
                                              foreach ($select as $nik) {
                                                $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $nik))->row_array();
                                                $nama[] = $usr['user_nama'];
                                              }
                                              // $petugas = implode(", ", $nama);
                                              if ($this->session->level=="spi") {
                                                if (in_array($this->session->username, $select)) {
                                                  $dis = "";
                                                }else{
                                                  $dis = "disabled";
                                                }
                                              }else{
                                               $dis = "";
                                              }
                                            ?>
                                        <?php if ($baris['tl_tanggapan_publish_kabag']=="Y" AND $baris['tl_tanggapan_kirim']=="N"): ?>
                                                <?php echo "<a href='".base_url()."administrator/kembalikan_tanggapan/$id_pmr/$value[temuan_id]/$row[rekomendasi_id]/$baris[tl_id]'>" ?><button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Kembalikan Tanggapan ke SPI" <?php echo $disable; ?>><span class="fa fa-mail-reply"></span></button></a>
                                                <?php echo "<a href='".base_url()."administrator/kirim_tanggapan/$id_pmr/$value[temuan_id]/$row[rekomendasi_id]/$baris[tl_id]'>" ?><button type="button" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Kirim Tanggapan ke Kebun" <?php echo $disable; ?>><i class="fa fa-send-o"></i></button></a>
                                                <button class="btn btn-xs btn-default" data-toggle="modal" data-target="#editTL<?php echo $baris['tl_id'] ?>" data-placement="top" title="Edit tanggapan SPI" type="button"><i class="fa fa-edit"></i> Edit</button>
                                          <?php endif ?>
                                            <?php   echo "<a href='".base_url()."administrator/detail_tl/$id_pmr/$value[temuan_id]/$row[rekomendasi_id]/$baris[tl_id]'>" ?><button type="button" class="btn btn-primary btn-xs"data-toggle="tooltip" data-placement="bottom"  title="Lihat Detail Tindak Lanjut"><span class="fa fa-tags"></span> Detail TL</button></a>
                                        </td>
                                      </tr>
                                      <div class="modal fade" id="editTL<?php echo $baris['tl_id']?>" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                         <div class="modal-header">
                                          <div class="row">
                                            <h4 class="modal-title"><strong>Kelola Tanggapan Tindak Lanjut</strong>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button></h4>
                                          </div>
                                          </div>
                                          <div class="modal-body">
                                          <?php 
                                            $id_pmr = $this->uri->segment(3);
                                             $attributes = array('class'=>'form-horizontal','role'=>'form');
                                             echo form_open('administrator/edit_statustl_kabag/'.$id_pmr,$attributes);
                                              echo "<div class='form-group'><input type='hidden' name='id' value='$baris[tl_id]'></div>";
                                              echo "<div class='form-group'><input type='hidden' name='id_rekom' value='$baris[rekomendasi_id]'></div>";
                                              echo "<div class='form-group'><input type='hidden' name='id_temuan' value='$baris[temuan_id]'></div>";
                                           ?>
                                              <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                                <div class="input-group col-md-8 col-sm-8 col-xs-12">
                                                <select name="status" id="status" class="form-control">\
                                                 <option value="Sesuai" <?php if ($row['rekomendasi_status_cache']=="Sesuai") {echo "selected";}?>>Sesuai</option>
                                                 <option value="Belum Sesuai" <?php if ($row['rekomendasi_status_cache']=="Belum Sesuai") {echo "selected";}?>>Sesuai (Belum Optimal)</option>
                                                 <option value="Belum di Tindak Lanjut" <?php if ($row['rekomendasi_status_cache']=="Belum di Tindak Lanjut") {echo "selected";}?>>Belum di Tindak Lanjut</option>
                                                 <option value="Tidak dapat di Tindak Lanjuti" <?php if ($row['rekomendasi_status_cache']=="Tidak dapat di Tindak Lanjuti") {echo "selected";}?>>Tidak dapat di Tindak Lanjuti</option>
                                                </select>
                                                </div>
                                              </div>
                                               <div class="form-group" id="tanggap">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggapan</label>
                                                  <div class="input-group col-md-8 col-sm-8 col-xs-12">
                                                  <textarea class="form-control" rows="5" placeholder="Masukkan Deskripsi Tanggapan" name="tanggapan"><?php echo $baris['tl_tanggapan']; ?></textarea>
                                                  </div>
                                               </div>
                                          </div><div class="modal-footer">
                                            <div class="form-group">
                                              <div class="col-md-12 col-sm-12 col-xs-12">
                                              <button type="submit" name="simpan" class="btn btn-sm btn-primary pull-right">Simpan Draft</button>
                                              <button type="submit" name="kirim" class="btn btn-sm btn-success pull-right">Kirim</button>
                                              </div>
                                            </div>
                                            </div>
                                          <?php echo form_close(); ?>
                                        </div>
                                      </div>
                                    </div>
                                      <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          <?php $r++; $rkm++;} ?>
                      </div>
                      <!-- -------------------------------------- -->
                      <br>
                    </div>
                      <?php $no++; } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
<div class="modal fade" id="readmore" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
        <h5 class="modal-title" id="exampleModalLabel"><h5><strong>Detail Rekomendasi</strong></h5></h5>
      </div>
      <div class="modal-body">
       <p id="tampildata">
         
       </p>
      </div>
      <div class="modal-footer">
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
      $("#bt-remove").on("click", function(){
        $("#forpesan").remove();
      });
    </script>
    <script type="text/javascript">
       $("#status").change(function(){
          if($("#status").val()=="Sesuai"){
              $("#tanggap").hide();
              console.log('ganti');
          }else{
              $("#tanggap").show();
          }
       });
    </script>
    <script type="text/javascript">
      var test = '<?php echo $bintang ?>';
      console.log(test);
      <?php $b = explode(" ", $bintang);
        foreach ($b as $key => $value) {

          ?>
            // $("#bintang<?php echo $value ?>").append("<i class='fa fa-asterisk'></i>");
            // $("#yuhu<?php echo $value ?>").append(" <i class='fa fa-asterisk' style='color: #ff3f3f'></i>");
          <?php
        }
       ?>
    </script>
    <script type="text/javascript">
      // var num = '<?php //echo $num ?>';
      // console.log(num);
      // <?php //$c = explode(" ", $num); 
      // foreach ($c as $key => $value) { ?>
      // var no = '<?php //echo $value ?>';
      // console.log(no);
      // $('#accordion' + no).on('shown.bs.collapse', function () {
        
      //   var panel = $(this).find('.in');
        
      //   $('html, body').animate({
      //         scrollTop: panel.offset().top
      //   }, 500);
        
      // });
      // <?php //} ?>
    </script>
    <script type="text/javascript">
      <?php for ($i=1; $i <= $rowbaris ; $i++) { ?>
        $('#ambilid<?php echo $i ?>').click(function(){
          var idrekom = $(this).attr('data-id');
          var BASE_URL = "<?php echo base_url('administrator/tampil_readmore_rekom/');?>";
           var urll = BASE_URL+idrekom;
           console.log(urll);
            $.ajax({
                type  : 'ajax',
                url   : urll,
                async : true,
                dataType : 'json',
                success : function(data){
                console.log(data);
                $('#tampildata').html(data);
                }
                //window.alert(urll);
            });
        });
      <?php } ?>
      
    </script>
  </body>
</html>