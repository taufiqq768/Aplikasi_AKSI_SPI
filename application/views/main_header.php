        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <?php 
              $level = $this->session->level;
              $unit= $this->session->unit;
              $aku = $this->session->username;
              $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $this->session->username))->row_array(); ?>
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img <?php if ($usr['user_foto']!=null) { ?>src="<?php echo base_url(); ?>asset/foto_user/<?php echo $usr['user_foto'] ?>"<?php }else{ ?>src="<?php echo base_url() ?>/asset/images/user.png"<?php } ?> alt=""><?php echo $usr['user_nama']; //$this->session->userdata('user_nama'); ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <?php if ($this->session->level!="viewer"): ?>
                    <li><a href="<?php echo base_url(); ?>administrator/edit_profile/<?php echo $usr['user_nik']?>"> Profile</a></li>
                    <?php endif ?>
                    <li><a href="<?php echo base_url(); ?>administrator/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
                <!-- -------------------------------------NOTIFIKASI-------------------------------------------- -->
                <?php  
                    if ($this->session->level=="operator" OR $this->session->level=="verifikator") {
                      $notifikasi2 = $this->db->query("SELECT * FROM tb_notifikasi WHERE notifikasi_level = '$level' AND notifikasi_unit = '$unit' AND notifikasi_dibaca='N' ORDER BY notifikasi_id DESC")->result_array();
                    }
                    if ($this->session->level=="spi") {
                      $notifikasi2 = $this->db->query("SELECT * FROM tb_notifikasi WHERE notifikasi_level='$level' AND notifikasi_user = '$aku' AND notifikasi_dibaca='N' ORDER BY notifikasi_id DESC ")->result_array();
                    }
                    if ($this->session->level=="kabagspi") {
                      $notifikasi2 = $this->db->query("SELECT * FROM tb_notifikasi WHERE notifikasi_level='$level' AND notifikasi_dibaca='N' ORDER BY notifikasi_id DESC ")->result_array();
                    }

                    ?>

                <?php if ($this->session->level=="kabagspi" OR $this->session->level=="spi" OR $this->session->level=="operator" OR $this->session->level=="verifikator"): ?>
                <li role="presentation" class="dropdown" id='bel'>
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell" ></i>
                    <?php if (count($notifikasi2)!=0): ?>
                     <span class="badge bg-green" id="show_data3"></span> 
                    <?php endif ?>
                  </a>

                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu"  style="max-height: 400px; overflow-y: auto; overflow-x: hidden;"> 
                    <?php endif ?>
                    
                  </ul>
                </li>    
              </ul>
            </nav>
          </div>
        </div>
        <!-- jQuery -->
  <script src="<?php echo base_url(); ?>/asset/gentelella/vendors/jquery/dist/jquery.min.js"></script>
  <script>
    // $(document).ready(function(){
    //   setInterval(function(){
    //     load_notifkebun();

    //   }, 2000);
    //   function load_notifkebun(){
    //      // console.log('masuk');
    // var unit = <?php //echo json_encode($unit) ?>;
    // var level = <?php //echo json_encode($level) ?>;
    //  var BASE_URL = "<?php //echo base_url('notifikasi/notif_kebun/');?>";
    //  var urll = BASE_URL+level+"/"+unit;
    //  // console.log(urll);
    //   $.ajax({
    //       type  : 'ajax',
    //       url   : urll,
    //       async : true,
    //       dataType : 'json',
    //       success : function(data){
    //         console.log(data);
    //       var html = '';
    //       var i;
    //       var no=1;
    //       html = data;
    //       $('#show_data3').html(html);
    //       }
    //       //window.alert(urll);
    //   });

    //   }
    // });
  </script>
  <script>
    $(document).ready(function(){
      setInterval(function(){
        load_notifspi();

      }, 2000);
      function load_notifspi(){
         // console.log('masuk');
    var unit = <?php echo json_encode($unit) ?>;
    var aku = <?php echo json_encode($aku) ?>;
    var level = <?php echo json_encode($level) ?>;
     var BASE_URL = "<?php echo base_url('notifikasi/notif_spi/');?>";
     var urll = BASE_URL+level+"/"+aku+"/"+unit;
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
          html = data['hitung'];
          $('#show_data3').html(html);
          }
          //window.alert(urll);
      });

      }
    });
  </script>
  <script type="text/javascript">
    $('#bel').on('click', function(){
      var aku = <?php echo json_encode($aku) ?>;
      var level = <?php echo json_encode($level) ?>;
      var unit = <?php echo json_encode($unit) ?>;
       var BASEURL = "<?php echo base_url('notifikasi/notif_spi/');?>";
       var urll2 = BASEURL+level+"/"+aku+"/"+unit;
       $.ajax({
           type  : 'ajax',
           url   : urll2,
           async : true,
           dataType : 'json',
           success : function(data){
           var hateml = '';
           var i;
           var no=1;
           for(o=0; o<data['notifikasi'].length; o++){
            var pesan = data['notifikasi'][o].notifikasi_pesan;
            var link_notif = data['notifikasi'][o].notifikasi_link+"/"+data['notifikasi'][o].notifikasi_id;
            console.log(link_notif);
            hateml+="<li>"+"<a href='<?php echo base_url() ?>"+link_notif+
            "'<span><span><b>"+data['notifikasi'][o].notifikasi_judul+"</b></span></span><span class='message'>"+ pesan.substr(0,75)+". .</span></a></li>";
           }
           $('#menu1').html(hateml);
           }
           
       });
       //INTERVAL PENGECEKAN NOTIFIKASI
      setTimeout(fungsi, 1500);
      function fungsi(){
        var _URL = "<?php echo base_url('notifikasi/unset_notif/');?>";
        var _url = _URL+level+"/"+aku+"/"+unit;
         $.ajax({
             type : "POST",
             url  : _URL,
             dataType : "JSON",
             data : {aku: aku, level: level, unit: unit},
             success: function(data){
                 console.log(data);
             }
         });
      }
      
    });
  </script>
  <script type="text/javascript">
    // $('#bel').on('click', function(){
    //   var aku = <?php //echo json_encode($aku) ?>;
    //   var level = <?php //echo json_encode($level) ?>;
    //   var unit = <?php //echo json_encode($unit) ?>;
    //    var BASE_URL = "<?php //echo base_url('notifikasi/unset_notif/');?>";
    //    var urll = BASE_URL+level+"/"+aku+"/"+unit;
    //    // console.log(urll);
    //     $.ajax({
    //         type  : 'ajax',
    //         url   : urll,
    //         async : true,
    //         dataType : 'json',
    //         success : function(data){
    //           console.log(data);
    //         var html = '';
    //         var i;
    //         var no=1;
    //         html = data;
    //         // $('#show_data3').html(html);
    //         }
    //         //window.alert(urll);
    //     });
    // });
  </script>
     