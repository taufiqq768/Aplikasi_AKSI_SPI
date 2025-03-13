    <title>AKSI | Temuan dan Tindak Lanjut Pemeriksaan</title>
  
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Kelola Temuan <small>Regional</small></h3>
              </div>

            </div>

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <?php if ($this->session->flashdata('kirim_tnggp')!=null) {
                          echo "<div class='alert alert-success' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('kirim_tnggp')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                    }elseif ($this->session->flashdata('simpan_tnggp')!=null) {
                          echo "<div class='alert alert-info' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('simpan_tnggp')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                    }
                    if ($this->session->flashdata('berhasil')!=null) {
                          echo "<div class='alert alert-success' role='alert' id='forpesan'><em class='fa fa-lg fa-warning'>&nbsp;</em>".$this->session->flashdata('berhasil')."<a href='#'' style='color: #fcfcfc' class='pull-right'><em class='fa fa-lg fa-close' id='bt-remove'></em></a></div>";
                    } ?>
                    <?php $role = $this->model_app->view_where('tb_role','role_id',$this->session->role);?>
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
                        <td>:  
                          <?php 
                              $mulai = explode("-", $row['pemeriksaan_tgl_mulai']);
                              $akhir = explode("-", $row['pemeriksaan_tgl_akhir']);
                              echo $mulai[2]."-".$mulai[1]."-".$mulai[0]." s.d ".$akhir[2]."-".$akhir[1]."-".$akhir[0];
                          ?> 
                          </td>
                      </tr>
                      <tr>
                        <th style="width: 150px">Nama Petugas SPI</th>
                        <td> <?php 
                        $select  = explode("/", $row['pemeriksaan_petugas']);
                          // print_r($select);
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
                    $no= 1;  $r=1; $bintang = ''; $num = ''; $rowbaris=0; $back =10000; $tback = 30000; $rback = 50000; $hapustemuan = 0;
                    $id_pmr = $this->uri->segment(3); 
                    //setting disable untuk pemeriksaan sebelumnya jika ada data yang terbawa ke pemeriksaan baru
                     $disable = '';
                     $countpmr = [];
                     $ambilpmr = $this->db->query("SELECT pemeriksaan_sebelumnya FROM tb_pemeriksaan")->result_array();
                     foreach ($ambilpmr as $keya => $valuea) {
                        $explode = explode(" ", $valuea['pemeriksaan_sebelumnya']);
                        foreach ($explode as $ka => $vala) {
                          $countpmr[] = $vala;
                        }
                      } 
                      // print_r($countpmr);
                      if (in_array($id_pmr, $countpmr)) {
                        $disable = "disabled";
                      }
                    ?>
                    
                      
                    </div>
   <!-- --------------------------------BATAS UNTUK PEMERIKSAAN SEBELUMNYA-------------------------------------- -->                 
                    <?php
                    foreach ($record2 as $key => $value) {
                      $num.=$no." "; $ti = []; $hapustemuan++;
                      $tmn = $this->model_app->view_where2('tb_rekomendasi','temuan_id',$value['temuan_id'],'rekomendasi_publish_kabag','Y');
                      $target = array('Belum di Tindak Lanjut', 'Tidak dapat di Tindak Lanjuti');
                       $cek_t = $this->db->query("SELECT rekomendasi_status FROM tb_rekomendasi WHERE temuan_id = '$value[temuan_id]' AND rekomendasi_kirim='Y'")->result_array();
                          foreach ($cek_t as $to) {
                            $ti[] = $to['rekomendasi_status'];
                          }
                          $span2 ='';
                          foreach ($target as $key) {
                           if (in_array($key, $ti)) {
                              $span2 = "<span class='fa fa-asterisk'></span>";
                            }
                          }
                      ?>
                   <div class="accordion" id="accordion<?php echo $no ?>" role="tablist" aria-multiselectable="true">
                    <div class="panel">
                      <a class="panel-heading collapsed" role="tab" id="headingTwo<?php echo $no;?>" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo<?php echo $no;?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $no;?>">
                        <?php $kata = explode(" ", $value['temuan_judul']); $hitung = count($kata); ?>
                        <h5><span><i class="fa fa-plus">&nbsp;</i></span><strong>Temuan <?php echo $no; ?> : <?php 
                        if ($hitung < 9) {
                          echo $value['temuan_judul'];
                        }else{
                           for ($i=0; $i < 9; $i++) { 
                              echo $kata[$i]." ";
                            }
                            if ($hitung > 8) {
                              echo "...";
                            }
                        }
                         ?> </strong> <?php $tgl = explode('-', $value['temuan_tgl']); echo "(".$tgl[2]."-".$tgl[1]."-".$tgl[0].")"; ?>&nbsp;<?php echo $span2; ?> <!-- <i id="bintang<?php //echo $value['temuan_id']?>"></i> -->
                         <?php if ($this->session->level=="admin"): ?>
                            <button class="btn btn-xs btn-danger btn-round" id="buttonhapus<?php echo $value['temuan_id']?>" title="Hapus Temuan" <?php  echo strpos($role[0]['role_akses'],',6,')!==FALSE?"":"disabled"; ?>><i class="fa fa-trash-o"></i> Hapus</button> 
                         <?php endif ?>
                         
                       </h5> 
                      </a>
                    </div> 
                                     
                      <div id="collapseTwo<?php echo $no;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo<?php echo $no;?>" style="padding: 0px 0px 5px 20px">
                       
                        <?php if ($hitung > 10): ?>
                        <b>Obyek Pemeriksaan : </b> <?php echo $value['temuan_obyek']; ?><br>
                        <b>Detail Temuan : </b><br>
                        <?php echo $value['temuan_judul']; ?>    
                        <?php endif ?>
                        <?php
                        $rkm = 1;
                         foreach ($tmn as $key2 => $row){ 
                          $rowbaris++;
                          if ($row['rekomendasi_status']=='Belum di Tindak Lanjut' OR $row['rekomendasi_status']=='Tidak dapat di Tindak Lanjuti') {
                            $span = "red";
                          }else{
                            $span = "";
                          }
                        ?>
                        <div class="panel">
                          <a class="panel-heading collapsed" role="tab" id="headingThree<?php echo $r; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapseThree<?php echo $r; ?>" aria-expanded="false" aria-controls="collapseThree<?php echo $r; ?>">
                          <h5 class="<?php echo $span?>"><span><i class="fa fa-plus-circle">&nbsp;</i></span>
                          <strong><?php echo "Rekomendasi ".$rkm." : "; ?> &nbsp;&nbsp;
                            <?php $rekom = explode(" ", $row['rekomendasi_judul']); 
                            $htg = count($rekom);
                            if ($htg < 11) {
                              echo $row['rekomendasi_judul'];
                            }else{
                              for ($i=0; $i < 10; $i++) { 
                                echo $rekom[$i]." ";
                              }  
                              if ($htg > 10) { ?>
                                <button class="btn btn-xs btn-round btn-dark" href="#" id="ambilid<?php echo $rowbaris?>" data-toggle="modal" data-target="#readmore" data-id="<?php echo $row['rekomendasi_id']?>"><i style="color: white">. .Lihat Selengkapnya</i></button> 
                              <?php
                              }
                            }
                            ?>
                          </strong>
                          <?php if ($this->session->level=="admin"): ?>
                                <button class="btn btn-xs btn-round btn-danger" id="hapusrekom<?php echo $rowbaris ?>" title="Hapus Rekomendasi" data-id = "<?php echo $row['rekomendasi_id'] ?>" <?php  echo strpos($role[0]['role_akses'],',6,')!==FALSE?"":"disabled"; ?>><i class="fa fa-trash-o"></i> Hapus</button> 
                            <?php endif ?>
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
                            }elseif ($row['rekomendasi_status_cache']=="Tidak dapat di Tindak Lanjuti") {
                              $btn_class = 'btn btn-xs btn-round btn-info';
                            }else{
                              $btn_class = 'btn btn-xs btn-round btn-dark';
                            }
                            $btn_class2 = '';
                            if ($row['rekomendasi_status_terbaru']=="Sesuai") {
                              $btn_class2 = 'btn btn-xs btn-round btn-success';
                            }elseif($row['rekomendasi_status_terbaru']=="Belum Sesuai"){
                              $btn_class2 = 'btn btn-xs btn-round btn-warning';
                            }elseif ($row['rekomendasi_status_terbaru']=="Belum di Tindak Lanjut") {
                              $btn_class2 = 'btn btn-xs btn-round btn-danger';
                            }elseif ($row['rekomendasi_status_terbaru']=="Tidak dapat di Tindak Lanjuti") {
                              $btn_class2 = 'btn btn-xs btn-round btn-info';
                            }else{
                              $btn_class2 = 'btn btn-xs btn-round btn-dark';
                            }
                            
                           ?>
                           &nbsp; <strong>Deadline Rekomendasi : <span class="btn btn-sm btn-round btn-warning"><?php echo $row['rekomendasi_tgl_deadline']; ?></span></strong></br>
                           &nbsp; <strong>Status Rekomendasi : </strong>
                           <?php if ($row['rekomendasi_status']=="Sesuai" OR $row['rekomendasi_status']=="Belum Sesuai" OR $row['rekomendasi_status']=="Closed") {
                             $non = "disabled";
                           }else{
                            $non = '';
                           } ?>
                           <button type="button" class="<?php echo $btn_class?>" title="Ubah Status Rekomendasi" ><?php  echo $row['rekomendasi_status_cache'];?></button>
                           <?php if ($row['rekomendasi_status_terbaru']!=''): ?>
                            &nbsp; <strong>| Status Terbaru : </strong>
                             <button type="button" class="<?php echo $btn_class2 ?>"><?php  echo $row['rekomendasi_status_terbaru'];?></button>
                           <?php endif ?>
                         
                         <?php if ($this->session->level=="admin" AND ($row['rekomendasi_status']=="Belum di Tindak Lanjut" OR $row['rekomendasi_status']=="Tidak dapat di Tindak Lanjuti") AND ($row['rekomendasi_status_terbaru']=="Belum di Tindak Lanjut" OR $row['rekomendasi_status_terbaru']=="Tidak dapat di Tindak Lanjuti" OR $row['rekomendasi_status_terbaru']=="")): ?>
                           <a href="<?php echo base_url(); ?>administrator/close_rekomendasi/<?php echo $row['pemeriksaan_id']?>/<?php echo $row['temuan_id']?>/<?php echo $row['rekomendasi_id']?>"><button type="button" class="btn btn-xs btn-round btn-dark"><i class="fa fa-minus-circle"></i> Close Rekomendasi</button></a>
                         <?php endif ?>
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
                                           <option value="Sesuai" <?php if ($row['rekomendasi_status_cache']=="Sesuai") {echo "selected";}?>>Sesuai</option>
                                           <option value="Belum Sesuai" <?php if ($row['rekomendasi_status_cache']=="Belum Sesuai") {echo "selected";}?>>Sesuai (Belum Optimal)</option>
                                           <option value="Belum di Tindak Lanjut" <?php if ($row['rekomendasi_status_cache']=="Belum di Tindak Lanjut") {echo "selected";}?>>Belum di Tindak Lanjut</option>
                                           <option value="Tidak dapat di Tindak Lanjuti" <?php if ($row['rekomendasi_status_cache']=="Tidak dapat di Tindak Lanjuti") {echo "selected";}?>>Tidak dapat di Tindak Lanjuti</option>
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
                                <?php 
                                 $id_pmr = $this->uri->segment(3);
                                  $attributes = array('class'=>'form-horizontal','role'=>'form');
                                  echo form_open('data/multidelete_tl/'.$id_pmr,$attributes);
                                  if ($this->session->level=="admin") {
                                    $tl = $this->model_app->view_where('tb_tl','rekomendasi_id',$row['rekomendasi_id']);
                                  }else{
                                    $tl = $this->model_app->view_where2('tb_tl','rekomendasi_id',$row['rekomendasi_id'], 'tl_publish_spi', "Y");
                                    
                                    $tl = $this->db->query("SELECT * FROM `tb_tl` LEFT JOIN `tb_rekomendasi` ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id WHERE `tb_tl`.`rekomendasi_id` = $row[rekomendasi_id] AND `tl_publish_spi` = 'Y'")->result_array();
                                    //$tl = $this->model_app->view_join_where('rekomendasi_id',$row['rekomendasi_id'],'tb_tl','tb_rekomendasi','rekomendasi_id', 'tl_publish_spi', "Y");
                                    //public function view_join_where($attr,$data,$table1,$table2,$field,$order,$ordering){
                                  }
                                  
                                ?>
                                  <div class="table-responsive">
                                    <table class="table table-bordered">
                                      <thead>
                                      <?php if ($this->session->level=="admin"): ?>
                                        <?php if ($tl!=null): ?>
                                        <th><button class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus Tindak Lanjut ?')" type="submit" name="hapus"><i class="fa fa-trash-o"></i></button></th>
                                          
                                        <?php endif ?>
                                      <?php endif ?>
                                        <th style="width: 40%"><center>Tindak Lanjut</center></th>
                                        <th style="width: 10%"><center>Tgl. TL</center></th>
                                        <th style="width: 23%"><center>Tanggapan</center></th>
                                        <th style="width: 15%"><center>Keterangan</center></th>
                                        <!-- <th style="width: 17%"><center>Status</center></th> -->
                                        <th style="width: 12%"><center>Action</center></th>
                                      </thead>
                                      <tbody>
                                        <?php 
                                          
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
                                            if ($baris['tl_tanggapan']=="" AND ($row['rekomendasi_status']=="Belum di Tindak Lanjut" OR $row['rekomendasi_status']=="Tidak dapat di Tindak Lanjuti")) {
                                              $pasang = "<span class='fa fa-circle red'></span>";
                                            }
                                        ?>
                                        <tr>
                                          <?php if ($this->session->level=="admin"): ?>
                                            <td><input type="checkbox" name="hapustl[]" value="<?php echo $baris['tl_id'] ?>"></td>
                                          <?php endif ?>
                                          <td><?php echo "<b>Status TL : </b>".$status."<br>"; echo $baris['tl_deskripsi']."  ".$pasang; ?></td>
                                          <td>
                                      <?php 
                                      if (!empty($baris['tl_tgl']) && !empty($baris['rekomendasi_tgl_deadline'])) {
                                          // Ubah format tanggal
                                          $tl_tgl = date_create($baris['tl_tgl']);
                                          $deadline = date_create($baris['rekomendasi_tgl_deadline']);

                                          // Format tampilan tgl_tgl (DD-MM-YYYY)
                                          $formatted_tl_tgl = date_format($tl_tgl, "d-m-Y");
                                          
                                          // Hitung selisih tanggal
                                          $diff = date_diff($deadline, $tl_tgl);
                                          $tahun = $diff->y;
                                          $bulan = $diff->m;
                                          $hari = $diff->d;

                                          if ($tl_tgl > $deadline) {
                                            // Jika telat, tampilkan selisih keterlambatan
                                            $telat_str = "Telat ";
                                            if ($tahun > 0) $telat_str .= "$tahun tahun ";
                                            if ($bulan > 0) $telat_str .= "$bulan bulan ";
                                            if ($hari > 0) $telat_str .= "$hari hari";
                                
                                            $status = "<span class='btn btn-sm btn-warning text-white'>$telat_str</span>";
                                        } else {
                                            $status = "<span class='btn btn-sm btn-success'>Tepat Waktu</span>";
                                        }

                                          echo "$formatted_tl_tgl $status";
                                      } else {
                                          echo "-"; // Jika salah satu tanggal kosong
                                      }
                                      ?>
                                  </td>
                                          <td>
                                            <?php if ($baris['tl_tanggapan']==null) {
                                              echo "<center> - </center>";
                                            }else{
                                              echo $baris['tl_tanggapan'];
                                              if ($baris['tl_tanggapan_publish_kabag']=="N" AND $baris['tl_tanggapan_kirim']=="K") {
                                                echo " <i class='fa fa-circle' style='color: red'></i>";
                                              }
                                            } ?>
                                          </td>
                                          <!-- TD KETERANGAN NYAMPE MANA -->
                                          <td>
                                            <?php 
                                            if ($baris['tl_status_publish_kabag']=='Y' AND $baris['tl_status_kirim']=="N") {
                                              echo "Terkirim ke Kabag";
                                            }elseif ($baris['tl_status_kirim']=="Y") {
                                              echo "Telah disetujui Kabag dan terkirim ke Kebun";
                                            }
                                            ?>
                                          </td>
                                          <td>
                                            <center>
                                            <!-- ACTION / KONDISI UNTUK DISABLE TANGGAPAN -->
                                          <?php if (($row['rekomendasi_status']=="Sesuai" OR $row['rekomendasi_status']=="Belum Sesuai" OR $row['rekomendasi_status']=="Closed") OR $baris['tl_tanggapan_publish_kabag']=="Y" OR $baris['tl_status_publish_kabag']=='Y') {
                                             $yuhu = "disabled";
                                           }else{
                                            $yuhu = '';
                                           } ?>
                                           <?php 
                                           //cek petugas spi
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
                                          <?php if ($this->session->level=="spi"): ?>
                                            <button type="button" class="btn btn-default btn-xs pull-right" title="Tambah Tanggapan" data-toggle="modal" data-target="#editTL<?php echo $baris['tl_id']; echo $yuhu;?>" <?php  echo strpos($role[0]['role_akses'],'11')!==FALSE?"":"disabled"; ?><?php echo $dis; echo $disable; ?>><span class="fa fa-plus"></span> Tanggapan</button>
                                          <?php endif ?>
                                          <?php if ($this->session->level=="admin"): ?>
                                            <?php   echo "<a href='".base_url()."data/delete_tl/$baris[pemeriksaan_id]/$baris[temuan_id]/$baris[rekomendasi_id]/$baris[tl_id]'>" ?><button type="button" class="btn btn-xs btn-danger pull-right" onclick="return confirm('Apakah yakin data ini dihapus ?');" <?php  echo strpos($role[0]['role_akses'],',6,')!==FALSE?"":"disabled"; ?>><i class="fa fa-trash-o"></i> Hapus TL</button></a>&nbsp;
                                          <?php endif ?>
                                            <?php   echo "<a href='".base_url()."administrator/detail_tl/$id_pmr/$value[temuan_id]/$row[rekomendasi_id]/$baris[tl_id]'>" ?><button type="button" class="btn btn-primary btn-xs pull-right" title="Lihat Detail"><span class="fa fa-tags"></span> Detail TL &nbsp;</button></a>
                                          
                                        </center>
                                        </td>
                                      </tr>
                                      <?php echo form_close(); ?>
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
                                             echo form_open('administrator/status_tl_kirimkabag/'.$id_pmr,$attributes);
                                              echo "<div class='form-group'><input type='hidden' name='id' value='$baris[tl_id]'></div>";
                                              echo "<div class='form-group'><input type='hidden' name='id_rekom' value='$baris[rekomendasi_id]'></div>";
                                           ?>
                                              <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                                <div class="input-group col-md-8 col-sm-8 col-xs-12">
                                                <select name="status" id="status" class="form-control">
                                                 <!-- <option ><?php //echo $row['rekomendasi_status']; ?></option> -->
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
    <!-- sweetalert -->
    <script src="<?php echo base_url(); ?>/asset/sweetalert/sweetalert.min.js"></script>
    
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
    <!-- scroll collapse -->
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
    <script type="text/javascript">
      <?php if ($this->session->flashdata('done')!=null) { ?>
          swal("Berhasil!", "Tindak Lanjut berhasil dihapus", "success");
      <?php } ?>
    </script>
    <script type="text/javascript">
      <?php foreach ($record2 as $key => $value) {?>
        $('#buttonhapus<?php echo $value['temuan_id'] ?>').click(function(){
          swal({
              title: "Yakin ingin menghapus Temuan ini?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#52cc7a",
              confirmButtonText: "Ya!",
              closeOnConfirm: false
          }, function () {
              var idtemuan = <?php echo $value['temuan_id'] ?>;
              var BASE_URL1 = "<?php echo base_url('data/delete_temuan/') ?>";
              var url1 = BASE_URL1+idtemuan;
              $.ajax({
                    type  : 'ajax',
                    url   : url1,
                    async : true,
                    dataType : 'json',
                    success : function(data){
                      console.log(data);
                      if (data === "ada") {
                       swal("Gagal!", "Ada Rekomendasi pada Temuan!", "error");
                      }else if (data === "tidak ada") {
                          swal({
                              type: "success",
                              title: "Berhasil!",
                              text: "Temuan berhasil dihapus",
                              timer: 2000,
                              showConfirmButton: false
                          });
                        setTimeout(location.reload.bind(location), 2000);
                      }
                    }
                    //window.alert(urll);
                });
              });
          // 
        });
      <?php } ?>
    </script>
    <!-- hapus temuan di pemeriksaan sebelumnya -->
    <script type="text/javascript">
      <?php for ($i=1; $i <= $hapustemuan; $i++) { ?>
        $('#btnhapus<?php echo $i ?>').click(function(){
          var idtemuan = $(this).attr('data-id');
          swal({
              title: "Yakin ingin menghapus Temuan ini?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#52cc7a",
              confirmButtonText: "Ya!",
              closeOnConfirm: false
          }, function () {
              
              var BASE_URL1b = "<?php echo base_url('data/delete_temuan/') ?>";
              var url1b = BASE_URL1b+idtemuan;
              $.ajax({
                    type  : 'ajax',
                    url   : url1b,
                    async : true,
                    dataType : 'json',
                    success : function(data){
                      console.log(idtemuan);
                      if (data === "ada") {
                       swal("Gagal!", "Ada Rekomendasi pada Temuan!", "error");
                      }else if (data === "tidak ada") {
                          swal({
                              type: "success",
                              title: "Berhasil!",
                              text: "Temuan berhasil dihapus",
                              timer: 2000,
                              showConfirmButton: false
                          });
                        setTimeout(location.reload.bind(location), 2000);
                      }
                    }
                    //window.alert(urll);
                });
          });
          
        });
      <?php } ?>
    </script>
    <script type="text/javascript">
      console.log(<?php echo $rowbaris ?>);
      <?php for ($i=1; $i <= $rowbaris ; $i++) { ?>
        $('#hapusrekom<?php echo $i ?>').click(function(){
          var idrkm = $(this).attr('data-id');
          swal({
            title: "Yakin ingin menghapus Rekomendasi ini ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#52cc7a",
            confirmButtonText: "Ya!",
            closeOnConfirm: false
        }, function () {
            
            console.log(idrkm);
            var BASE_URL2 = "<?php echo base_url('data/delete_rekomendasi/');?>";
             var url2 = BASE_URL2+idrkm;
             console.log(url2);
              $.ajax({
                  type  : 'ajax',
                  url   : url2,
                  async : true,
                  dataType : 'json',
                  success : function(data){
                    console.log(data);
                    if (data === "ada") {
                     swal("Gagal!", "Ada Tindak Lanjut pada Rekomendasi!", "error");
                    }else if (data === "tidak ada") {
                        swal({
                            type: "success",
                            title: "Berhasil!",
                            text: "Rekomendasi berhasil dihapus",
                            timer: 2000,
                            showConfirmButton: false
                        });
                      setTimeout(location.reload.bind(location), 2000);
                    }
                  }
                  //window.alert(urll);
              });
        });
          
        });
      <?php } ?>
    </script>
  </body>
</html>