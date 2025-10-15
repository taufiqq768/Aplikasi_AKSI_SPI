<script src="<?php echo base_url(); ?>/asset/chartjs/Chart.js"></script>
      
          <?php $unit = $this->session->unit;
          $namaunit = $this->db->query("SELECT * FROM tb_unit WHERE unit_id='$unit'")->row_array();
          ?>
          <!-- DATA UNTUK TOTAL PEMERIKSAAN -->
          <!-- data untuk kebun -->
            <?php if ($this->session->level=="operator" || $this->session->level=="verifikator") { 
              $query = $this->model_app->view_where2('tb_pemeriksaan','unit_id',$unit,'pemeriksaan_jenis','Rutin');
              $hasil =  count($query);
              ?>
             &nbsp;<h1><i class="fa fa-tags"></i><strong> Total Pemeriksaan : <?php echo $hasil; ?></strong></h1><br>
            <?php } ?>

            <!-- tamu -->
            <?php if ($this->session->level=="viewer") { 
              $query = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_jenis','Rutin');
              $hasil =  count($query);

              ?>
             &nbsp;<h1><i class="fa fa-tags"></i><strong> Total Pemeriksaan : <?php echo $hasil; ?></strong></h1><br>
            <?php } ?>

          <?php if ($this->session->level=='admin' || $this->session->level=='spi' || $this->session->level=='kabagspi' OR $this->session->level=="administrasi"): ?>
          <div class="row tile_count">
            <div class="col-md-3 col-sm- col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-edit"></i> Total Pemeriksaan</span>
              <?php 
                if ($this->session->level=="operator" || $this->session->level=="verifikator") {
                  $query = $this->model_app->view_where2('tb_pemeriksaan','unit_id',$unit,'pemeriksaan_jenis','Rutin');
                  $hasil =  count($query);
                }else{
                  $query = $this->db->query("SELECT * FROM tb_pemeriksaan");
                  $hasil =  $query->num_rows();
                }
               ?>
            <div class="count"><center><a <?php if ($this->session->level=="spi" OR $this->session->level=="admin" OR $this->session->level=="kabagspi") { ?> href="<?php echo base_url(); ?>administrator/list_pemeriksaan" <?php }else{ ?> href="#" <?php } ?>><?php echo $hasil; ?></a></center></div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-pencil"></i> Pemeriksaan Rutin</span>
              <div class="count"><center><a <?php if ($this->session->level=="spi" OR $this->session->level=="admin" OR $this->session->level=="kabagspi") { ?> href="<?php echo base_url(); ?>administrator/list_pemeriksaan/Rutin" <?php }else{ ?> href="#" <?php } ?>>
                <?php
                if ($this->session->level=="operator" OR $this->session->level=="verifikator") {
                  echo $this->db->where('pemeriksaan_jenis','Rutin')->where('unit_id',$this->session->unit)->from("tb_pemeriksaan")->count_all_results();
                }else{ 
                  echo $this->db->where('pemeriksaan_jenis','Rutin')->from("tb_pemeriksaan")->count_all_results(); 
                }
                ?>
              </a></center></div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-pencil"></i> Pemeriksaan Khusus</span>
              <div class="count"><center><a <?php if ($this->session->level=="spi" OR $this->session->level=="admin" OR $this->session->level=="kabagspi") { ?> href="<?php echo base_url(); ?>administrator/list_pemeriksaan/Khusus" <?php }else{ ?> href="#" <?php } ?>><?php
                if ($this->session->level=="operator" OR $this->session->level=="verifikator") {
                  echo "0";
                   // echo $this->db->where('pemeriksaan_jenis','Khusus')->where('unit_id',$this->session->unit)->from("tb_pemeriksaan")->count_all_results();
                }else{ 
                  echo $this->db->where('pemeriksaan_jenis','Khusus')->from("tb_pemeriksaan")->count_all_results(); 
                }
                ?>
                </a></center></div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-pencil"></i> Pemeriksaan Tematik</span>
              <div class="count"><center><a <?php if ($this->session->level=="spi" OR $this->session->level=="admin" OR $this->session->level=="kabagspi") { ?> href="<?php echo base_url(); ?>administrator/list_pemeriksaan/Penting" <?php }else{ ?> href="#" <?php } ?>>
                <?php
                  echo $this->db->where('pemeriksaan_jenis','Tematik')->from("tb_pemeriksaan")->count_all_results(); 
                ?>
                </a></center></div>
            </div>
          </div>

          <?php endif ?>
          <!-- /top tiles -->
          
          <div class="row">
            <div class="col-md-7 col-sm-7 col-xs-12">
              <div class="x_panel tile fixed_height_420 overflow_hidden">
                <div class="x_title">
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li><!-- 
                     <li><a class="close-link"><i class="fa fa-close"></i></a></li>  -->
                  </ul>
                  <h4>Presentase Tindak Lanjut Pemeriksaan</h4>
                  
                  <div class="clearfix"></div>
                  <!-- <hr style="height:2px;border:none;color:lightgrey;background-color:lightgrey;"/> -->
                </div>
                <div class="x_content">
                  <div class="table-responsive">
                  <table class="tile-info" style="width:100%">
                    <tr>
                      <th style="width:35%;">
                        <p><center>Status</center></p>
                      </th>
                      <th>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                          <p><center>Keterangan</center></p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                          <p><center>Progress</center></p>
                        </div>
                      </th>
                    </tr>
                    <tr>
          <?php 
          //AMBIL DATA UNTUK GRAFIK MASING - MASING LEVEL USER
          $pct_stl = 0; $pct_bo=0; $pct_btl=0; $pct_k=0; $pct_c=0;
            if ($this->session->level=="operator" || $this->session->level=="verifikator") {
              $query = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE tb_pemeriksaan.unit_id = '$unit'  AND pemeriksaan_jenis='Rutin'")->result_array();
              $total =  count($query);

              $stl =  $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE tb_pemeriksaan.unit_id = '$unit' AND pemeriksaan_jenis='Rutin' AND rekomendasi_status='Sesuai'")->result_array();
              $stl = count($stl);
              
              $stl_bo =  $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE tb_pemeriksaan.unit_id = '$unit' AND pemeriksaan_jenis='Rutin' AND rekomendasi_status='Belum Sesuai'")->result_array();
              $stl_bo = count($stl_bo);
              
              $stl_btl =  $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE tb_pemeriksaan.unit_id = '$unit' AND pemeriksaan_jenis='Rutin' AND rekomendasi_status='Belum di Tindak Lanjut'")->result_array();
              $stl_btl = count($stl_btl);
              
              $stl_k =  $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE tb_pemeriksaan.unit_id = '$unit' AND pemeriksaan_jenis='Rutin' AND rekomendasi_status='Tidak dapat di Tindak Lanjuti'")->result_array();
              $stl_k = count($stl_k);
              
              $stl_c =  $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE tb_pemeriksaan.unit_id = '$unit' AND pemeriksaan_jenis='Rutin' AND rekomendasi_status='Closed'")->result_array();
              $stl_c = count($stl_c);
            }elseif($this->session->level=="viewer" OR $this->session->level=="administrasi"){
              $query = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE pemeriksaan_jenis='Rutin'");
              $total =  $query->num_rows();
             
             $stl =  $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE pemeriksaan_jenis='Rutin' AND rekomendasi_status='Sesuai'")->result_array();
              $stl = count($stl);
              
              $stl_bo =  $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE pemeriksaan_jenis='Rutin' AND rekomendasi_status='Belum Sesuai'")->result_array();
              $stl_bo = count($stl_bo);
              
              $stl_btl =  $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE pemeriksaan_jenis='Rutin' AND rekomendasi_status='Belum di Tindak Lanjut'")->result_array();
              $stl_btl = count($stl_btl);
              
              $stl_k =  $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE pemeriksaan_jenis='Rutin' AND rekomendasi_status='Tidak dapat di Tindak Lanjuti'")->result_array();
              $stl_k = count($stl_k);
              
              $stl_c =  $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE pemeriksaan_jenis='Rutin' AND rekomendasi_status='Closed'")->result_array();
              $stl_c = count($stl_c);
              
            }elseif($this->session->level=="spi"){
              //UNTUK MENGAMBIL DATA USER SPI ITU SENDIRI
              $userspi= $this->db->query("SELECT pemeriksaan_petugas, pemeriksaan_id FROM tb_pemeriksaan ORDER BY pemeriksaan_id ASC")->result_array();
              $array_spi = [];
              $user = [];
              $id = 0;
              foreach ($userspi as $key => $value) {
                $array_spi[] = explode("/", $value['pemeriksaan_petugas']);
              }
              foreach ($array_spi as $a => $vala) {
                foreach ($vala as $b => $valb) {
                  $user[] = $valb;
                }
              }
              $aku = $this->session->username; $stl=0; $stl_c=0; $stl_bo=0; $stl_btl=0; $stl_k=0; $total = 0;
              $select = $this->db->query("SELECT pemeriksaan_id FROM tb_pemeriksaan WHERE pemeriksaan_petugas LIKE '%$aku%' ORDER BY pemeriksaan_id ASC")->result_array();
              foreach ($select as $key => $value) {
                $id = $value['pemeriksaan_id']; 
                $rekom = $this->db->query("SELECT * FROM tb_rekomendasi WHERE pemeriksaan_id='$id'")->result_array();
                $total = $total + count($rekom);
                $stla =  $this->db->query("SELECT * FROM tb_rekomendasi WHERE pemeriksaan_id = '$id' AND rekomendasi_status='Sesuai'")->result_array();
                $stl = $stl + count($stla);
                $stl_ca =  $this->db->query("SELECT * FROM tb_rekomendasi WHERE pemeriksaan_id = '$id' AND rekomendasi_status='Closed'")->result_array();
                $stl_c = $stl_c + count($stl_ca);
                $stl_ka =  $this->db->query("SELECT * FROM tb_rekomendasi WHERE pemeriksaan_id = '$id' AND rekomendasi_status='Tidak dapat di Tindak Lanjuti'")->result_array();
                $stl_k = $stl_k + count($stl_ka);
                $stl_btla =  $this->db->query("SELECT * FROM tb_rekomendasi WHERE pemeriksaan_id = '$id' AND rekomendasi_status='Belum di Tindak Lanjut'")->result_array();
                $stl_btl = $stl_btl + count($stl_btla);
                $stl_boa =  $this->db->query("SELECT * FROM tb_rekomendasi WHERE pemeriksaan_id = '$id' AND rekomendasi_status='Belum Sesuai'")->result_array();
                $stl_bo = $stl_bo + count($stl_boa);
              }
            }else{
              $query = $this->db->query("SELECT * FROM tb_rekomendasi");
              $total =  $query->num_rows();
              $stl =  $this->db->where('rekomendasi_status','Sesuai')->from("tb_rekomendasi")->count_all_results();
              $stl_bo =  $this->db->where('rekomendasi_status','Belum Sesuai')->from("tb_rekomendasi")->count_all_results();
              $stl_btl =  $this->db->where('rekomendasi_status','Belum di Tindak Lanjut')->from("tb_rekomendasi")->count_all_results(); 
              $stl_k =  $this->db->where('rekomendasi_status','Tidak dapat di Tindak Lanjuti')->from("tb_rekomendasi")->count_all_results(); 
              $stl_c =  $this->db->where('rekomendasi_status','Closed')->from("tb_rekomendasi")->count_all_results(); 
            }
            if ($stl!=null) {
              $pct_stl = ($stl/$total)*100;
            }
            if ($stl_bo!=null) {
              $pct_bo = ($stl_bo/$total)*100;
            }
            if ($stl_btl!=null) {
              $pct_btl = ($stl_btl/$total)*100;
            }
            if ($stl_k!=null) {
              $pct_k = ($stl_k/$total)*100;
            }
            if ($stl_c!=null) {
              $pct_c = ($stl_c/$total)*100;
            }
          ?>
                      <?php if (!empty($query)) { ?>
                            <td>
                              <canvas id="myChart" height="210px"></canvas>
                            </td>
                      <?php }else{ ?>
                            <td>
                              <center>No data to display</center>
                            </td>
                      <?php } ?>
                      
                      <td>
                        <!-- <div class="table-responsive"> -->
                        <table class="tile_info">
                          <tr>
                            <td>
                              <p><i class="fa fa-square green"></i>Sesuai </p>
                            </td>
                            <td style="text-align:center"><strong><?php echo round($pct_stl,1); ?>%</strong></td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square" style="color: #ffd754"></i>Belum Sesuai </p>
                            </td>
                            <td style="text-align:center"><strong><?php echo round($pct_bo,1); ?>%</strong></td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square" style="color: #ff3838"></i>Belum di Tindak Lanjut </p>
                            </td>
                            <td style="text-align:center"><strong><?php echo round($pct_btl, 1); ?>%</strong></td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square" style="color: #52c8ff"></i>Tidak dapat di Tindak Lanjuti </p>
                            </td>
                            <td style="text-align:center"><strong><?php echo round($pct_k,1); ?>%</strong></td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square" style="color: #484a54"></i>Closed </p>
                            </td>
                            <td style="text-align:center"><strong><?php echo round($pct_c,1); ?>%</strong></td>
                          </tr>
                        </table>
                        <!-- </div> -->
                      </td>
                    </tr>
                  </table>
                </div>
               </div>
              </div>
            </div>
            
            <!-- ------------------------- -->
            <!-- <div class="col-md-5 col-sm-5 col-xs-12">
              <div class="x_panel tile fixed_height_420 overflow_hidden">
                <div class="x_title">
                  <h2>Progress Jumlah Status</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                     <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <canvas id="myChart2" width="500px"></canvas>

               </div>
              </div>
            </div> -->

          </div>
          
      
        <!-- /page content -->

    <script>
    var ctx = document.getElementById("myChart").getContext('2d');
    ctx.height =200;
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["Sesuai","Belum di Tindak Lanjut","Tidak dapat di Tindak Lanjuti", "Belum Sesuai","Closed"],
        datasets: [{
          data: [<?php echo $stl ?>, <?php echo $stl_btl ?>, <?php echo $stl_k ?>, <?php echo $stl_bo ?>, <?php echo $stl_c ?>],
          backgroundColor: [
          'rgba(9, 198, 154, 1)', //ijo
          'rgba(255, 56, 56, 1)', //abang
          'rgba(82, 200, 255, 1)', //biru
          'rgba(255, 206, 86, 1)', //kuning
          'rgba(72, 74, 84, 1)' //dark
          
          ],
           borderWidth: 0,
           hoverBorderColor: ['#0af0ba', '#f7755b', '#96ceff','#f7f75b','#707380'],
           hoverBorderWidth: 5
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
          legend: {
            display: false
          },
          tooltips: {
            callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0]['index']];
                },
                label: function(tooltipItem, data) {
                  return data['datasets'][0]['data'][tooltipItem['index']] + ' (Rekomendasi)';
                }
                // ,
                // afterLabel: function(tooltipItem, data) {
                //   var dataset = data['datasets'][0];
                //   var percent = Math.round((dataset['data'][tooltipItem['index']] / dataset["_meta"][0]['total']) * 100)
                //   return '(' + percent + '%)';
                // }
              },
              backgroundColor: '#FFF',
              borderWidth: 1,
              borderColor: '#d6d6d6',
              titleFontSize: 12,
              titleFontColor: '#0066ff',
              bodyFontColor: '#000',
              bodyFontSize: 12,
              displayColors: false
          }
        }
    });
  </script>
   <!-- <script>
    var ctx = document.getElementById("myChart2").getContext('2d');
    ctx.height =200;
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ["Sudah di TL","Belum di TL","Tidak dapat di Tindak Lanjuti", "TL (Belum Optimal)"],
        datasets: [{
          data: [<?php //echo $stl ?>, <?php //echo $stl_btl ?>, <?php //echo $stl_k ?>, <?php //echo $stl_bo ?>],
          backgroundColor: [
          'rgba(9, 198, 154, 1)', //ijo
          'rgba(255, 56, 56, 1)', //abang
          'rgba(82, 200, 255, 1)', //biru
          'rgba(255, 206, 86, 1)' //kuning
          
          ],
           borderWidth: 0,
           hoverBorderColor: ['#0af0ba', '#f7755b', '#96ceff','#f7f75b'],
           hoverBorderWidth: 5
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
          legend: {
            fontSize: 8
          }
        }
    });
  </script> -->
   