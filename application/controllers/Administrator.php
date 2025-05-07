<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	function index(){		
		if (isset($_POST['submit'])) {
			$username = $this->input->post('username');
            $password = md5($this->input->post('password'));
            $cek = $this->model_app->cek_login($username,$password,'tb_users');
            $row = $cek->row_array();
            $total = $cek->num_rows();
            if ($total > 0) 
			{
				
            	$this->session->set_userdata(array('username'=>$row['user_nik'],
            					'user_nama'=>$row['user_nama'],
                                'level'=>$row['user_level'],
                            	'role'=>$row['role_id'],
								'nik'=>$row['user_nik'],
                            	'unit'=>$row['unit_id']));
								
            	if ($row['user_count']=='0') 
				{
            		redirect('administrator/login_satu/'.$row['user_nik']);
            	}
				else
				{
                	redirect('administrator/home');
            	}
            }else{
                $data['pesan'] = 'Username atau Password salah!';
              	$this->load->view('view_login', $data);            }
        }
		else{
            $data['title'] = 'Administrator &rsaquo; Log In';
            $this->load->view('view_login',$data);
        	
		}
	}
	public function login_satu(){
		$nik = $this->uri->segment(3);
		if (isset($_POST['simpan'])) {
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
			if ($this->form_validation->run()==FALSE) {
				$data['main_content'] = 'administrator/login_satu';
	         	$this->session->set_flashdata('gagal', 'Password tidak cocok!');
	         	redirect('administrator/login_satu/'.$nik, $data);				
			}else{
				$data = array('user_password' => md5($this->input->post('password')),
							'user_count'  => '1'
						);
				$where = array('user_nik' => $this->input->post('id'));
				$this->model_app->update('tb_users', $data, $where);
				redirect('administrator/home');	
			}	
		}
		$this->load->view('login1');
	}
	public function home(){
		if ($this->session->level=="admin" OR $this->session->level=="spi" OR $this->session->level=="verifikator" OR $this->session->level=="operator" OR $this->session->level=="kabagspi" OR $this->session->level=="viewer"  OR $this->session->level=="administrasi")  {
		$this->template->load('template','home');
		}else{
			redirect('administrator');
		}
		
	}
	public function get_data()
    {
        // Pastikan ini adalah permintaan AJAX
        if ($this->input->is_ajax_request()) {
            $objek = $this->input->post('objek');
			$tableName = "";
			$columns = [];

            // Tentukan tabel dan kolom yang sesuai
			if ($objek === "divisi") {
				$tableName = "tb_unit";
				$columns = ["id" => "unit_id", "name" => "unit_nama"];
			} elseif ($objek === "regional") {
				$tableName = "tb_unit";
				$columns = ["id" => "unit_id", "name" => "unit_nama"];
			} elseif ($objek === "anper") {
				$tableName = "tb_unit";
				$columns = ["id" => "unit_id", "name" => "unit_nama"];
			}

            if ($tableName) {        
				$data = $this->model_app->get_data_custom($tableName, $columns);
                echo json_encode($data);
            } else {
                echo json_encode([]);
            }
        } else {
            show_404();
        }
    }
	public function daftar_pmr(){
		if ($this->session->level=="admin" or $this->session->level=="spi" OR $this->session->level=="administrasi") {
			if (isset($_POST['submit'])) 
			{
				$config['upload_path'] = 'asset/file_pemeriksaan/';
	            $config['allowed_types'] = 'jpg|png|JPG|JPEG|pdf|doc|docx|xls|xlsx|odt|';
	            $config['max_size'] = '25000'; // kb
	            $this->load->library('upload', $config);
	            $this->upload->do_upload('file_pmr');
            	$hasil=$this->upload->data();
				$pengawas = $this->input->post('pengawas');
				$ketua = $this->input->post('ketua');
				$petugas = $this->input->post('d');
				$pemeriksa = implode("/", $petugas);
				$tanggal = $this->input->post('e');
            	$tgl = explode(" - ", $tanggal); 
                $awal = explode("/", $tgl[0]);
                $akhir = explode("/", $tgl[1]);
                $start = $awal[2]."-".$awal[0]."-".$awal[1];
                $end = $akhir[2]."-".$akhir[0]."-".$akhir[1];
				$tgl_st = $this->input->post('tgl_st');
				$date_st = explode("-", $tgl_st);
				$fix_tgl_st = $date_st[2]."-".$date_st[1]."-".$date_st[0];
				$data = array('pemeriksaan_jenis'=>$this->input->post('a'),
							'pemeriksaan_judul'=>$this->input->post('b'),
							// 'pemeriksaan_tgl'=>$this->input->post('e'),
							'pemeriksaan_pkpt'=>$this->input->post('pkpt'),
							'pemeriksaan_objek'=>$this->input->post('objek'),
							'pemeriksaan_nomor_st'=>$this->input->post('no_st'),
							'pemeriksaan_tanggal_st'=>$fix_tgl_st,
							'pemeriksaan_tgl_mulai'=> $start,
							'pemeriksaan_tgl_akhir'=> $end,
							'kebun_id'=>$this->db->escape_str($this->input->post('c')),
							'unit_id' => $this->db->escape_str($this->input->post('c')),
							'pemeriksaan_pengawas'=>$pengawas,
							'pemeriksaan_ketua'=>$ketua,
							'pemeriksaan_petugas'=>$pemeriksa,
							'pemeriksaan_doc' => $hasil['file_name'],
							'user_nik' => $this->session->username
						);
				$jenis = $this->input->post('a');
				$kebun = $this->input->post('c');
				$this->model_app->insert('tb_pemeriksaan',$data);
				$id_pmr = $this->db->insert_id();
						
				// Siapkan data untuk tb_kka berdasarkan jumlah pemeriksa
				$petugas_list = explode("/", $pemeriksa); // Pisahkan petugas menjadi array

				foreach ($petugas_list as $petugas) {
					$data_kka = array(
						'pemeriksaan_id' => $id_pmr, // Relasi ke tabel tb_pemeriksaan
						'pembuat_kka' => trim($petugas) // Simpan nama atau ID petugas
					);

					// Insert ke tb_kka
					$this->model_app->insert('tb_kka', $data_kka);
				}

				//insert notifikasi
				foreach ($petugas as $userspi) {
					$datanotif = array(
						'notifikasi_judul' => 'Pemeriksaan '.$this->input->post('a'),
						'notifikasi_pesan' => '<b>Tanggal : '.$this->input->post('e')."</b><br>".$this->input->post('b'),
						'notifikasi_level' => 'spi',
						'notifikasi_link' => 'administrator/input_spi/'.$id_pmr,
						'notifikasi_user' => $userspi
					);
					$this->model_app->insert('tb_notifikasi', $datanotif);
				}

				// $select_id = $this->db->query("SELECT DISTINCT tb_pemeriksaan.pemeriksaan_id FROM `tb_pemeriksaan` INNER JOIN tb_temuan ON tb_pemeriksaan.pemeriksaan_id = tb_temuan.pemeriksaan_id INNER JOIN tb_rekomendasi ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id  WHERE (rekomendasi_status = 'Belum di Tindak Lanjut' OR rekomendasi_status='Dikembalikan') AND pemeriksaan_jenis = '$jenis' AND tb_pemeriksaan.unit_id='$kebun' ")->result_array();				
				// if ($select_id!=null) 
				// {
				// 	foreach ($select_id as $idid) {
				// 		$od[] = $idid['pemeriksaan_id'];
				// 	}
				// 	$sebelumnya = implode(" ", $od);
				// 	$this->db->query("UPDATE tb_pemeriksaan SET pemeriksaan_sebelumnya = '$sebelumnya' WHERE pemeriksaan_id = '$id_pmr'");
				// 	foreach ($od as $k1 => $nilai) {
				// 		//ambil temuan di pemeriksaan sebelumnya
				// 		$ambiltemuan = $this->db->query("SELECT * FROM tb_temuan WHERE pemeriksaan_id = '$nilai'")->result_array();
				// 		foreach ($ambiltemuan as $k2 => $value) {
				// 			$temuanid = $value['temuan_id'];
				// 			//ambil rekomendasi di pemeriksaan sebelumnya
				// 			$ambilrekom = $this->db->query("SELECT * FROM tb_rekomendasi WHERE temuan_id='$temuanid' AND (rekomendasi_status='Dikembalikan' OR rekomendasi_status='Belum di Tindak Lanjut')")->result_array();
				// 			if ($ambilrekom!=null) {
				// 				$data_tm = array(
				// 						'pemeriksaan_id' => $id_pmr,
				// 						'bidangtemuan_id' => $value['bidangtemuan_id'],
				// 						'temuan_judul' => $value['temuan_judul'],
				// 						'temuan_obyek' => $value['temuan_obyek'],
				// 						'temuan_tgl' => $value['temuan_tgl'],
				// 						'temuan_kirim' => $value['temuan_kirim'],
				// 						'temuan_publish_kabag' => $value['temuan_publish_kabag'],
				// 						'temuan_pmr_sebelumnya' => $value['pemeriksaan_id'],
				// 						'user_nik' => $value['user_nik']
				// 				);
				// 				$this->model_app->insert('tb_temuan', $data_tm);
				// 				$id_temuan = $this->db->insert_id();
				// 				foreach ($ambilrekom as $k3 => $value2) {
				// 					$data_rekom = array(
				// 						'pemeriksaan_id' => $id_pmr,
				// 						'temuan_id' => $id_temuan,
				// 						'rekomendasi_judul'=> $value2['rekomendasi_judul'],
				//                         'rekomendasi_tgl'=> $value2['rekomendasi_tgl'],
				//                         'rekomendasi_status'=> $value2['rekomendasi_status'],
				//                         'rekomendasi_status_cache' => $value2['rekomendasi_status_cache'],
				//                         'rekomendasi_status_publish_kabag' => $value2['rekomendasi_status_publish_kabag'],
				//                         'rekomendasi_status_kirim' => $value2['rekomendasi_status_kirim'],
				//                         'rekomendasi_aktif'=> $value2['rekomendasi_aktif'],
				//                         'rekomendasi_kirim' => $value2['rekomendasi_kirim'],
				//                         'rekomendasi_publish_kabag' => $value2['rekomendasi_publish_kabag'],
				//                         'rekomendasi_pmr_sebelumnya' => $value2['rekomendasi_id'],
				//                         'user_nik'=> $value2['user_nik']
				// 					);
				// 					$this->model_app->insert('tb_rekomendasi',$data_rekom);
				// 					$id_rekom = $this->db->insert_id();
				// 					if ($jenis!="Rutin") {
				// 						$ambil_tanggapan = $this->db->query("SELECT * FROM tb_tanggapan WHERE rekomendasi_id = '$value2[rekomendasi_id]'")->result_array();
				// 						foreach ($ambil_tanggapan as $k5 => $value4) {
				// 							$data_tng = array(
				// 										'rekomendasi_id' => $id_rekom,
				// 										'tanggapan_deskripsi' => $value4['tanggapan_deskripsi'],
				// 										'tanggapan_tgl' => $value4['tanggapan_tgl'],
				// 										'tanggapan_publish_kabag' => $value4['tanggapan_publish_kabag'],
				// 										'tanggapan_kirim' => $value4['tanggapan_kirim'],
				// 										'user_nik' => $value4['user_nik']
				// 									);
				// 							$this->model_app->insert('tb_tanggapan', $data_tng);
				// 						}
				// 					}
				// 					//input_file rekom
				// 					$file_r = $this->model_app->view_where('tb_upload_rekom','rekomendasi_id',$value2['rekomendasi_id']);
				// 					foreach ($file_r as $ku1 => $row) {
				// 					$dataa = array('rekomendasi_id' => $id_rekom,
				// 									'uploadrekom_nama' => $row['uploadrekom_nama'],
				// 									'uploadrekom_tgl' => $row['uploadrekom_tgl'],
				// 									'token' => $row['token']
				// 					);
				// 					$this->model_app->insert('tb_upload_rekom', $dataa);
				// 					}
				// 					//ambil tindak lanjut
				// 					$ambiltl = $this->model_app->view_where('tb_tl','rekomendasi_id',$value2['rekomendasi_id']);
				// 					$data_tl = 0;
				// 					if ($ambiltl!=null) 
				// 					{
				// 						foreach ($ambiltl as $k4 => $value3) {
				// 							$data_tl = array(
				// 							'pemeriksaan_id' => $id_pmr,
				// 							'temuan_id' => $id_temuan,
				// 							'rekomendasi_id' => $id_rekom,
				// 							'tl_deskripsi'=> $value3['tl_deskripsi'],
				// 	                        'tl_tgl'=> $value3['tl_tgl'],
				// 	                        'tl_tanggapan'=> $value3['tl_tanggapan'],
				// 	                        'tl_tanggapan_publish_kabag' => $value3['tl_tanggapan_publish_kabag'],
				// 	                        'tl_tanggapan_kirim' => $value3['tl_tanggapan_kirim'],
				// 	                        'tl_status'=> $value3['tl_status'],
				// 	                        'tl_status_cache' => $value3['tl_status_cache'],
				// 	                        'tl_status_tgl' => $value3['tl_status_tgl'],
				// 	                        'tl_status_publish_kabag'=> $value3['tl_status_publish_kabag'],
				// 	                        'tl_status_kirim' => $value3['tl_status_kirim'],
				// 	                        'tl_tanggapan_tgl' => $value3['tl_tanggapan_tgl'],
				// 	                        'tl_publish_verif'=> $value3['tl_publish_verif'],
				// 	                        'tl_publish_spi'=> $value3['tl_publish_spi'],
				// 	                        'tl_publish_kabag' => $value3['tl_publish_kabag'],
				// 	                        'tl_status_from_vrf'=> $value3['tl_status_from_vrf'],
				// 	                        'tl_status_from_spi'=> $value3['tl_status_from_spi'],
				// 	                        'tl_pmr_sebelumnya' => $value3['tl_id'],
				// 	                        'user_opr'=> $value3['user_opr'],
				// 	                        'user_vrf'=> $value3['user_vrf']
				// 							);
				// 							$this->model_app->insert('tb_tl', $data_tl);
				// 							$id_tl = $this->db->insert_id();
				// 							$file_tl = $this->model_app->view_where('tb_upload_tl','tl_id',$value3['tl_id']);
				// 							foreach ($file_tl as $ku2 => $row2) {
				// 							$dataa = array('tl_id' => $id_tl,
				// 											'uploadtl_nama' => $row2['uploadtl_nama'],
				// 											'uploadtl_tgl' => $row2['uploadtl_tgl'],
				// 											'token' => $row2['token']
				// 							);
				// 							$this->model_app->insert('tb_upload_tl', $dataa);
				// 							}
				// 						}
				// 					}
				// 				}
				// 			}
				// 		}
				// 	}
				// 	redirect('administrator/list_pemeriksaan', $data);
				// }
				//else
				//{
					redirect('administrator/list_pemeriksaan', $data);
				//}

			}else{
				$data['spi'] = $this->model_app->view_where2('tb_users','user_level','spi','user_aktif','Y');
	            $this->template->load('template','kelola-pemeriksaan/daftar_pmr', $data);
			}
		}else{
			redirect('administrator/home');
		}
	}
	public function edit_pemeriksaan(){
		$id_pmr = $this->uri->segment(3);
		if (isset($_POST['edit'])) {
			$data = array(	'pemeriksaan_aktif' => $this->input->post('aktif'));
			$where = array('pemeriksaan_id' => $this->input->post('id'));
			$this->model_app->update('tb_pemeriksaan', $data , $where);
			redirect('administrator/list_pemeriksaan');
		}
	}
	public function list_pemeriksaan(){
		if ($this->session->level=="admin" OR $this->session->level=="spi" OR $this->session->level=="kabagspi" OR $this->session->level=="viewer" OR $this->session->level=="administrasi") {
			if ($this->uri->segment(3)!=null) {
				$jenis = $this->uri->segment(3);
				$data['record'] = $this->model_app->view_join_where('pemeriksaan_jenis',$jenis,'tb_pemeriksaan','tb_unit','unit_id','pemeriksaan_id','DESC');
				$data['unit'] = $this->model_app->view_ordering('tb_unit','unit_id','ASC');

				if ($this->session->level=="viewer") {
				//AMBIL DATA UNTUK USER VIEWER
                $data['record'] = $this->db->query("SELECT * FROM tb_pemeriksaan JOIN tb_kebun ON tb_pemeriksaan.kebun_id = tb_kebun.kebun_id JOIN tb_unit ON tb_pemeriksaan.unit_id = tb_unit.unit_id WHERE pemeriksaan_jenis = 'Rutin' AND pemeriksaan_aktif = 'Y' ORDER BY pemeriksaan_id DESC")->result_array();
                }
				$this->template->load('template','kelola-pemeriksaan/list_pemeriksaan',$data);
			}else{
				$nik=$this->session->nik;
				$niks = explode('/', $nik);
				foreach ($niks as $n) {
					$data['unit'] = $this->model_app->view_ordering('tb_unit','unit_id','ASC');
					$data['record'] = $this->db->query("SELECT * FROM `tb_pemeriksaan` JOIN `tb_unit` ON `tb_pemeriksaan`.`unit_id`=`tb_unit`.`unit_id` WHERE `pemeriksaan_petugas` LIKE '%$n%' ORDER BY `pemeriksaan_id` DESC")->result_array();
					$this->template->load('template','kelola-pemeriksaan/list_pemeriksaan',$data);
				}
			}
		}else{
			redirect('administrator');
		}
		
	}
	public function list_kka(){
		if ($this->session->level=="admin" OR $this->session->level=="spi" OR $this->session->level=="kabagspi" OR $this->session->level=="viewer" OR $this->session->level=="administrasi") {
			if ($this->session->level == "kabagspi" OR $this->session->level=="admin") {
				$data['record'] = $this->model_app->view_join('tb_pemeriksaan','tb_unit','unit_id','tb_pemeriksaan.pemeriksaan_id','DESC');
				$data['unit'] = $this->model_app->view_ordering('tb_unit','unit_id','ASC');
				$this->template->load('template','kelola-kka/list_kka_kadiv_group',$data);

				// if ($this->session->level=="viewer") {
				// //AMBIL DATA UNTUK USER VIEWER
                // $data['record'] = $this->model_app->view_join_two('pemeriksaan_petugas','20634','tb_pemeriksaan','tb_unit','tb_kka','unit_id','pemeriksaan_id','tb_pemeriksaan.pemeriksaan_id','DESC');
                // }
				// $this->template->load('template','kelola-kka/list_kka',$data);
			}
			else{
					$nik=$this->session->username;
					$data= $this->db->query("SELECT * FROM `tb_pemeriksaan` JOIN `tb_unit` ON `tb_pemeriksaan`.`unit_id`=`tb_unit`.`unit_id` ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` DESC")->result_array();
				if($data[0]['pemeriksaan_ketua'] == $nik ){
					$data['unit'] = $this->model_app->view_ordering('tb_unit','unit_id','ASC');
					$data['record'] = $this->db->query("SELECT * FROM `tb_pemeriksaan` JOIN `tb_unit` ON `tb_pemeriksaan`.`unit_id`=`tb_unit`.`unit_id` WHERE `tb_pemeriksaan`.`pemeriksaan_ketua`=$nik ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` DESC;")->result_array();
					$this->template->load('template','kelola-kka/list_kka_group',$data);
				}
				else if($data[0]['pemeriksaan_pengawas'] == $nik){
					$data['unit'] = $this->model_app->view_ordering('tb_unit','unit_id','ASC');
					$data['record'] = $this->db->query("SELECT * FROM `tb_pemeriksaan` JOIN `tb_unit` ON `tb_pemeriksaan`.`unit_id`=`tb_unit`.`unit_id` WHERE `tb_pemeriksaan`.`pemeriksaan_pengawas`=$nik ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` DESC;")->result_array();
					$this->template->load('template','kelola-kka/list_kka_group',$data);
				}
				else{
					$data['unit'] = $this->model_app->view_ordering('tb_unit','unit_id','ASC');
					$data['record'] = $this->db->query("SELECT * FROM `tb_pemeriksaan` JOIN `tb_unit` ON `tb_pemeriksaan`.`unit_id`=`tb_unit`.`unit_id` JOIN `tb_kka` ON `tb_pemeriksaan`.`pemeriksaan_id`=`tb_kka`.`pemeriksaan_id` WHERE `tb_kka`.`pembuat_kka`=$nik ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` DESC")->result_array();
					$this->template->load('template','kelola-kka/list_kka_group',$data);
				}

				//$data['record'] = $this->model_app->view_join_two('pemeriksaan_petugas LIKE','%'.$nik.'%','tb_pemeriksaan','tb_unit','tb_kka','unit_id','pemeriksaan_id','tb_pemeriksaan.pemeriksaan_id','DESC');
			}
		}else{
			redirect('administrator');
		}
		
	}
	public function detail_kka(){
		$id_pmr = $this->uri->segment(3);
		$nik=$this->session->username;
		$data = $this->db->query("SELECT * FROM `tb_pemeriksaan` JOIN `tb_unit` ON `tb_pemeriksaan`.`unit_id`=`tb_unit`.`unit_id` JOIN `tb_kka` ON `tb_pemeriksaan`.`pemeriksaan_id`=`tb_kka`.`pemeriksaan_id` WHERE `tb_pemeriksaan`.`pemeriksaan_id`=$id_pmr ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` DESC")->result_array();
		$found = false; // Untuk menandai apakah ada pembuat_kka yang sesuai

		// Looping untuk mengecek setiap baris dalam $data
		foreach ($data as $row) {
			if ($row['pembuat_kka'] == $nik) {
				$found = true;
				break; // Jika sudah ketemu, tidak perlu lanjut looping
			}
		}
		if($found){
			//anggota
			$data['record'] = $this->db->query("SELECT * FROM `tb_pemeriksaan` JOIN `tb_unit` ON `tb_pemeriksaan`.`unit_id`=`tb_unit`.`unit_id` JOIN `tb_kka` ON `tb_pemeriksaan`.`pemeriksaan_id`=`tb_kka`.`pemeriksaan_id` WHERE `tb_kka`.`pembuat_kka`= $nik AND `tb_pemeriksaan`.`pemeriksaan_id`=$id_pmr ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` DESC")->result_array();
			$this->template->load('template','kelola-kka/list_kka',$data);
		}
		else{
			//ketua dan pengawas dan kadiv
			$data['record'] = $this->db->query("SELECT * FROM `tb_pemeriksaan` JOIN `tb_unit` ON `tb_pemeriksaan`.`unit_id`=`tb_unit`.`unit_id` JOIN `tb_kka` ON `tb_pemeriksaan`.`pemeriksaan_id`=`tb_kka`.`pemeriksaan_id` WHERE `tb_pemeriksaan`.`pemeriksaan_id`=$id_pmr AND (`tb_kka`.`kka_kirim_kadiv_dspi` IN (1,2,3,4)) ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` DESC")->result_array();
			
			$this->template->load('template','kelola-kka/list_kka',$data);
		}
	}
	public function reject_kka(){
		$level=$this->session->level;
		$nik=$this->session->nik;
		$id_pmr=$this->input->post('id_pmr');
		$idpmr = $this->uri->segment(3);
		
		if($id_pmr != null){
			$pmrid= $id_pmr;
		}
		else{
			$pmrid = $idpmr;
		}
		
		$alasan=$this->input->post('alasan');
		$pemeriksaan = $this->db->query("SELECT * FROM `tb_pemeriksaan` JOIN `tb_kka` ON `tb_pemeriksaan`.`pemeriksaan_id`=`tb_kka`.`pemeriksaan_id` WHERE `tb_pemeriksaan`.`pemeriksaan_id` = $pmrid ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` ASC")->result_array();
		
		if($level == "kabagspi"){
			
			$data = array(
				'kka_kirim_kadiv_dspi' => '0',
				'kka_alasan'=>$alasan
			);
			$where = array('id_kka' => $pemeriksaan[0]['id_kka']);
			$update=$this->model_app->update('tb_kka', $data, $where);

			if ($update) {
				$history_data = array(
					'pemeriksaan_id' => $pemeriksaan[0]['pemeriksaan_id'],
					'pembuat_kka' => $nik, // Sesuaikan dengan user yang melakukan perubahan
					'revisi' => 1, // Sesuaikan dengan status perubahan
					'waktu_kirim' => date('Y-m-d H:i:s') // Timestamp perubahan
				);
				$this->model_app->insert('tb_history', $history_data);
				// Jika update berhasil, jalankan query berikutnya
				$data['record'] = $this->model_app->view_join('tb_pemeriksaan', 'tb_unit', 'unit_id', 'tb_pemeriksaan.pemeriksaan_id', 'DESC');
				$data['unit'] = $this->model_app->view_ordering('tb_unit', 'unit_id', 'ASC');
				
				// Load template dengan data terbaru
				$this->template->load('template', 'kelola-kka/list_kka_kadiv_group', $data);
			} else {
				// Jika update gagal, tampilkan pesan error atau redirect ke halaman sebelumnya
				echo "<script>alert('Update gagal, silakan coba lagi!'); window.history.back();</script>";
			}

		}elseif($pemeriksaan[0]['pemeriksaan_pengawas'] == $nik){
			$data = array(
				'kka_kirim_kadiv_dspi' => '0'
			);
			$where = array('id_kka' => $pemeriksaan[0]['id_kka']);
			$update=$this->model_app->update('tb_kka', $data, $where);
			
			if ($update) {
				$history_data = array(
					'pemeriksaan_id' => $pemeriksaan[0]['pemeriksaan_id'],
					'pembuat_kka' => $nik, // Sesuaikan dengan user yang melakukan perubahan
					'revisi' => 1, // Sesuaikan dengan status perubahan
					'waktu_kirim' => date('Y-m-d H:i:s') // Timestamp perubahan
				);
				$this->model_app->insert('tb_history', $history_data);

				// Jika update berhasil, jalankan query berikutnya
				$data['unit'] = $this->model_app->view_ordering('tb_unit','unit_id','ASC');
				$data['record'] = $this->db->query("SELECT * FROM `tb_pemeriksaan` JOIN `tb_unit` ON `tb_pemeriksaan`.`unit_id`=`tb_unit`.`unit_id` WHERE `tb_pemeriksaan`.`pemeriksaan_pengawas`=$nik ORDER BY  `tb_pemeriksaan`.`pemeriksaan_id` DESC")->result_array();
				$this->template->load('template','kelola-kka/list_kka_group',$data);
				// Load template dengan data terbaru
				$this->template->load('template', 'kelola-kka/list_kka_kadiv_group', $data);
			} else {
				// Jika update gagal, tampilkan pesan error atau redirect ke halaman sebelumnya
				echo "<script>alert('Update gagal, silakan coba lagi!'); window.history.back();</script>";
			}
		}
		else{
			$data = array(
				'kka_kirim_kadiv_dspi' => '0',
			);
			$where = array('id_kka' => $pemeriksaan[0]['id_kka']);
			$update=$this->model_app->update('tb_kka', $data, $where);

			if ($update) {
				// Tambahkan insert ke history
				$history_data = array(
					'pemeriksaan_id' => $pemeriksaan[0]['pemeriksaan_id'],
					'pembuat_kka' => $nik, // Sesuaikan dengan user yang melakukan perubahan
					'revisi' => 1, // Sesuaikan dengan status perubahan
					'waktu_kirim' => date('Y-m-d H:i:s') // Timestamp perubahan
				);
				$this->model_app->insert('tb_history', $history_data);

				// Jika update berhasil, jalankan query berikutnya
				$data['unit'] = $this->model_app->view_ordering('tb_unit','unit_id','ASC');
				$data['record'] = $this->db->query("SELECT * FROM `tb_pemeriksaan` JOIN `tb_unit` ON `tb_pemeriksaan`.`unit_id`=`tb_unit`.`unit_id` JOIN `tb_kka` ON `tb_pemeriksaan`.`pemeriksaan_id`=`tb_kka`.`pemeriksaan_id` WHERE `tb_kka`.`pembuat_kka`=$nik ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` DESC")->result_array();
				$this->template->load('template','kelola-kka/list_kka_group',$data);
				
				// Load template dengan data terbaru
				$this->template->load('template', 'kelola-kka/list_kka_kadiv_group', $data);
			} else {
				// Jika update gagal, tampilkan pesan error atau redirect ke halaman sebelumnya
				echo "<script>alert('Update gagal, silakan coba lagi!'); window.history.back();</script>";
			}
		}
	}
	public function tambah_kka(){
		if ($this->session->level=="spi") {
			//$cek = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
			//$jenis =  $cek[0]['pemeriksaan_jenis'];
			if (isset($_POST['simpan'])) {
				//simpan sebagai draft
				$data = array(
					'kka_kondisi' => $this->input->post('kondisi'),
					'kka_penyebab' => $this->input->post('penyebab'),
					'pembuat_kka' => $this->input->post('nik'),
					'kka_kirim_kadiv_dspi' => '0'
				);
				$where = array('id_kka' => $this->uri->segment(3));
				$this->model_app->update('tb_kka', $data, $where);
				redirect('administrator/list_kka/');
			}elseif (isset($_POST['kirim'])) {
				//kirim ke kabag spi
				$data = array(
					'kka_kondisi' => $this->input->post('kondisi'),
					'kka_penyebab' => $this->input->post('penyebab'),
					'kka_kirim_kadiv_dspi' => '1'
				);
				$where = array('id_kka' => $this->uri->segment(3));
				$this->model_app->update('tb_kka', $data, $where);
			
				// //insert notifikasi
				// $pmr = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
				// $pmr = $pmr[0]['pemeriksaan_judul'];
				// $data2 = array(
				// 	'notifikasi_judul' => 'Temuan baru Perlu di Approve',
				// 	'notifikasi_pesan' => '<b>Pada Pemeriksaan : </b><br>'.$pmr,
				// 	'notifikasi_link' => 'administrator/input_spi/'.$id_pmr,
				// 	'notifikasi_level' => 'kabagspi'
				// );
				// $this->model_app->insert('tb_notifikasi',$data2);
				redirect('administrator/list_kka/');
			}else{
				$this->template->load('template','kelola-kka/tambah_kka');
			}
		}else{
			redirect('administrator/list_kka_group');
		}
	}
	public function image_tinymce(){
		$config['upload_path'] = './asset/kka/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size'] = '25000'; // kb
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('file')) {
			$data = $this->upload->data();
			$url = base_url('asset/kka/' . $data['file_name']);

			// Ini HARUS JSON murni
			header('Content-Type: application/json');
			echo json_encode(['location' => $url]);
		} else {
			header('Content-Type: application/json');
			echo json_encode(['error' => $this->upload->display_errors()]);
		}
	}
	public function edit_kka(){
		$id_kka = $this->uri->segment(3);
		if (isset($_POST['edit'])) {
			$data = array(
				'kka_kondisi' => $this->input->post('kondisi'),
				'kka_penyebab' => $this->input->post('penyebab'),
				'kka_kirim_kadiv_dspi' => '0'
			);
			$where = array('id_kka' => $this->input->post('id'));
			$this->model_app->update('tb_kka', $data, $where);
			redirect('administrator/list_kka/');
		}else{
			$data['record'] = $this->model_app->view_where('tb_kka','id_kka',$id_kka);
			$this->template->load('template','kelola-kka/edit_kka',$data);
		}
	}
	public function kirim_kka_kadiv_spi(){
		$id_kka = $this->uri->segment(3);
		$id_pmr = $this->uri->segment(4);
		$nik=$this->session->username;
		$q = $this->db->query("SELECT * FROM `tb_pemeriksaan` JOIN `tb_unit` ON `tb_pemeriksaan`.`unit_id`=`tb_unit`.`unit_id` JOIN `tb_kka` ON `tb_pemeriksaan`.`pemeriksaan_id`=`tb_kka`.`pemeriksaan_id` WHERE `tb_kka`.`id_kka`=$id_kka ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` DESC")->result_array();
		
		if($q[0]['kka_kirim_kadiv_dspi'] == 1){
			$data = array('kka_kirim_kadiv_dspi' => '2');
			$where = array('id_kka' => $id_kka);
			$this->model_app->update('tb_kka', $data, $where);
			// Data untuk insert ke tabel history
			$data_history = array(
				'pemeriksaan_id' => $id_pmr,
				'pembuat_kka' => $nik ,
				'waktu_kirim' => date('Y-m-d H:i:s')
			);
		
			// Mulai transaksi database
			$this->db->trans_start();
		
			// Update tb_kka
			$this->model_app->update('tb_kka', $data, array('id_kka' => $id_kka));
		
			// Insert ke tabel history
			$this->model_app->insert('tb_history', $data_history);
		
			// Selesaikan transaksi
			$this->db->trans_complete();
		
			if ($this->db->trans_status() === FALSE) {
				// Jika gagal, rollback perubahan
				$this->db->trans_rollback();
				$this->session->set_flashdata('error', 'Gagal mengupdate data.');
			} else {
				// Jika sukses, commit perubahan
				$this->db->trans_commit();
				$this->session->set_flashdata('success', 'Data berhasil diperbarui.');
			}
			redirect('administrator/list_kka');	

		}elseif($q[0]['kka_kirim_kadiv_dspi'] == 2){
			$data = array('kka_kirim_kadiv_dspi' => '3');
			$where = array('id_kka' => $id_kka);
			$this->model_app->update('tb_kka', $data, $where);
			// Data untuk insert ke tabel history
			$data_history = array(
				'pemeriksaan_id' => $id_pmr,
				'pembuat_kka' => $nik ,
				'waktu_kirim' => date('Y-m-d H:i:s')
			);
		
			// Mulai transaksi database
			$this->db->trans_start();
		
			// Update tb_kka
			$this->model_app->update('tb_kka', $data, array('id_kka' => $id_kka));
		
			// Insert ke tabel history
			$this->model_app->insert('tb_history', $data_history);
		
			// Selesaikan transaksi
			$this->db->trans_complete();
		
			if ($this->db->trans_status() === FALSE) {
				// Jika gagal, rollback perubahan
				$this->db->trans_rollback();
				$this->session->set_flashdata('error', 'Gagal mengupdate data.');
			} else {
				// Jika sukses, commit perubahan
				$this->db->trans_commit();
				$this->session->set_flashdata('success', 'Data berhasil diperbarui.');
			}
			redirect('administrator/list_kka');
			
		}elseif($q[0]['kka_kirim_kadiv_dspi'] == 3){
			$data = array('kka_kirim_kadiv_dspi' => '4');
			$where = array('id_kka' => $id_kka);
			$this->model_app->update('tb_kka', $data, $where);

			// Data untuk insert ke tabel history
			$data_history = array(
				'pemeriksaan_id' => $id_pmr,
				'pembuat_kka' => $nik ,
				'waktu_kirim' => date('Y-m-d H:i:s')
			);
		
			// Mulai transaksi database
			$this->db->trans_start();
		
			// Update tb_kka
			$this->model_app->update('tb_kka', $data, array('id_kka' => $id_kka));
		
			// Insert ke tabel history
			$this->model_app->insert('tb_history', $data_history);
		
			// Selesaikan transaksi
			$this->db->trans_complete();
		
			if ($this->db->trans_status() === FALSE) {
				// Jika gagal, rollback perubahan
				$this->db->trans_rollback();
				$this->session->set_flashdata('error', 'Gagal mengupdate data.');
			} else {
				// Jika sukses, commit perubahan
				$this->db->trans_commit();
				$this->session->set_flashdata('success', 'Data berhasil diperbarui.');
			}
			redirect('administrator/list_kka');	
		}
		else{
			$data = array('kka_kirim_kadiv_dspi' => '1');
			$where = array('id_kka' => $id_kka);
			$this->model_app->update('tb_kka', $data, $where);

			// Data untuk insert ke tabel history
			$data_history = array(
				'pemeriksaan_id' => $id_pmr,
				'pembuat_kka' => $nik ,
				'waktu_kirim' => date('Y-m-d H:i:s')
			);
		
			// Mulai transaksi database
			$this->db->trans_start();
		
			// Update tb_kka
			$this->model_app->update('tb_kka', $data, array('id_kka' => $id_kka));
		
			// Insert ke tabel history
			$this->model_app->insert('tb_history', $data_history);
		
			// Selesaikan transaksi
			$this->db->trans_complete();
		
			if ($this->db->trans_status() === FALSE) {
				// Jika gagal, rollback perubahan
				$this->db->trans_rollback();
				$this->session->set_flashdata('error', 'Gagal mengupdate data.');
			} else {
				// Jika sukses, commit perubahan
				$this->db->trans_commit();
				$this->session->set_flashdata('success', 'Data berhasil diperbarui.');
			}
			redirect('administrator/list_kka');	
		}
		
		// //insert notifikasi
		// 	$pmr = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
		// 	$jdl_pmr = $pmr[0]['pemeriksaan_judul'];
		// 	$unit = $pmr[0]['unit_id'];
		// 	$data2 = array(
		// 		'notifikasi_judul' => 'Temuan baru',
		// 		'notifikasi_pesan' => '<b>Pada Pemeriksaan : </b><br>'.$jdl_pmr,
		// 		'notifikasi_link' => 'administrator/list_pmr_operator',
		// 		'notifikasi_level' => 'operator',
		// 		'notifikasi_unit' => $unit
		// 	);
		// 	$this->model_app->insert('tb_notifikasi',$data2);
		// 	$data3 = array(
		// 		'notifikasi_judul' => 'Temuan baru',
		// 		'notifikasi_pesan' => '<b>Pada Pemeriksaan : </b><br>'.$jdl_pmr,
		// 		'notifikasi_link' => 'administrator/list_pmr_verifikator',
		// 		'notifikasi_level' => 'verifikator',
		// 		'notifikasi_unit' => $unit
		// 	);
		// 	$this->model_app->insert('tb_notifikasi',$data3);
		// $this->session->set_flashdata('kirimtemuan', 'Temuan berhasil dikirim ke Kadiv DSPI');
		// redirect('administrator/input_spi/'.$id_pmr);
	}
	public function history_kka(){
		$id_pmr = $this->uri->segment(3);
		$q = $this->model_app->view_join_where_field2('pemeriksaan_id',$id_pmr,'tb_history','tb_users','pembuat_kka','user_nik','history_id','ASC');

		// Set response ke JSON di CodeIgniter 3
		header('Content-Type: application/json');

		if (!empty($q)) {
			echo json_encode([
				'success' => true,
				'data' => $q
			]);
		} else {
			echo json_encode([
				'success' => false,
				'message' => 'Data tidak ditemukan'
			]);
		}
		//redirect('administrator/list_kka',$history);
	}
	public function cari_pemeriksaan(){
		if(isset($_POST['submit'])){
			$where = [];
			$jenis = $this->input->post('jenis');
			$unit = $this->input->post('unit');
			$status = $this->input->post('status');
			$rentang = $this->input->post('rentang');
			if ($this->input->post('waktu')=="N") {
				$rentang = "";
			}else{
				$rentang = explode(" - ", $rentang);

				$mulai = $rentang[0]; $mulai = explode("/", $mulai); $mulai = $mulai[2]."-".$mulai[0]."-".$mulai[1];
				$akhir = $rentang[1]; $akhir = explode("/", $akhir); $akhir = $akhir[2]."-".$akhir[0]."-".$akhir[1];
				$mulai1 = explode("-", $mulai); $mulai1 = $mulai1[2]."-".$mulai1[1]."-".$mulai1[0];
				$akhir1 = explode("-", $akhir); $akhir1 = $akhir1[2]."-".$akhir1[1]."-".$akhir1[0];
			}
			if ($jenis!='0') {
				$where[] = " tb_pemeriksaan.pemeriksaan_jenis = '".$jenis."'";
			}
			if ($status!='0') {
				$where[] = " tb_pemeriksaan.pemeriksaan_aktif = '".$status."'";
			}
			if ($rentang!="") {
				$where[] = " pemeriksaan_tgl_mulai BETWEEN '$mulai' AND '$akhir' OR pemeriksaan_tgl_akhir BETWEEN '$mulai' AND '$akhir'";
			}
			if ($unit!="") {
				$where[] = " tb_pemeriksaan.unit_id = '".$unit."'";
			}
			$build = "";
			for ($i=0; $i < sizeof($where) ; $i++) { 
				# code...
				if($i == sizeof($where)-1 ) $build .=$where[$i];
				else  $build .=$where[$i]." AND";
			}
			$data['unit'] = $this->model_app->view_ordering('tb_unit','unit_id','ASC');
			if ($this->session->level=="viewer") {
				if ($build=="") {
					$data['record'] = $this->db->query("SELECT * FROM tb_pemeriksaan JOIN tb_kebun ON tb_pemeriksaan.kebun_id = tb_kebun.kebun_id JOIN tb_unit ON tb_pemeriksaan.unit_id = tb_unit.unit_id WHERE pemeriksaan_jenis = 'Rutin' AND pemeriksaan_aktif = 'Y' ORDER BY pemeriksaan_id DESC")->result_array();
				}else{
					$data['record'] = $this->db->query("SELECT * FROM tb_pemeriksaan JOIN tb_unit ON tb_pemeriksaan.unit_id = tb_unit.unit_id  WHERE ".$build."  AND pemeriksaan_jenis='Rutin' ORDER BY pemeriksaan_id DESC")->result_array();
				}
            }else{
            	$data['record'] = $this->db->query("SELECT * FROM tb_pemeriksaan JOIN tb_unit ON tb_pemeriksaan.unit_id = tb_unit.unit_id  WHERE ".$build." ORDER BY pemeriksaan_id DESC")->result_array();
            }
			$this->template->load('template','kelola-pemeriksaan/list_pemeriksaan', $data);
		}
	}
	public function delete_pemeriksaan(){
		$id_pmr = array('pemeriksaan_id' => $this->uri->segment(3));
		$id = $this->uri->segment(3);
		$cek = $this->model_app->view_select_where('pemeriksaan_id','tb_tl','pemeriksaan_id',$id);
		$stt = $this->model_app->view_select_where('pemeriksaan_aktif','tb_pemeriksaan','pemeriksaan_id',$id);
		if (!empty($cek)) {
			$this->session->set_flashdata('gagal','Gagal Menghapus, Ada Tindak Lanjut pada Pemeriksaan ini!');
			redirect('administrator/list_pemeriksaan');
		}else{
			$file = $this->db->where('pemeriksaan_id',$id)->get('tb_pemeriksaan')->row();
			$namafile = $file->pemeriksaan_doc;
			$path = 'asset/file_pemeriksaan/'.$namafile;
			unlink($path);
			$this->session->set_flashdata('berhasil', 'Pemeriksaan berhasil dihapus !');
			$this->model_app->delete('tb_pemeriksaan', $id_pmr);
			$this->model_app->delete('tb_temuan', $id_pmr);
			$this->model_app->delete('tb_rekomendasi', $id_pmr);
			redirect('administrator/list_pemeriksaan');
		}
		
	}
	public function status_pemeriksaan(){
		if ($this->session->level=="spi" or $this->session->level=="admin") {
			$id_pmr = $this->uri->segment(3);
	        if ($this->uri->segment(4)=='Y'){
	            $data = array('pemeriksaan_aktif'=>'N');
	        }else{
	            $data = array('pemeriksaan_aktif'=>'Y');
	        }
	        $where = array('pemeriksaan_id' => $this->uri->segment(3));
	        $this->model_app->update('tb_pemeriksaan', $data, $where);
	        redirect('administrator/list_pemeriksaan');
		}else{
			redirect('administrator/list_pemeriksaan');
		}        
	}
	public function input_spi(){
		$id_pmr = $this->uri->segment(3);
		//UNTUK MENGECEK APAKAH USER KLIK DARI NOTIFIKASI
		if ($this->uri->segment(4)!=null) {
			$id_notif = $this->uri->segment(4);
			$this->db->query("UPDATE tb_notifikasi SET notifikasi_dibaca='Y' WHERE notifikasi_id='$id_notif'");
		}
		$cek = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
		$jenis =  $cek[0]['pemeriksaan_jenis'];

		if ($this->session->level=="admin" OR $this->session->level=="spi") {	
			$data['record'] = $this->model_app->view_join_where('pemeriksaan_id',$id_pmr,'tb_pemeriksaan','tb_unit','unit_id','pemeriksaan_id','DESC');
			$data['record2'] = $this->model_app->view_where_ordering('pemeriksaan_id','tb_temuan',$id_pmr,'bidangtemuan_id','ASC');
			$data['record3'] = $this->model_app->view_join_five_table('tb_temuan','tb_bidangtemuan','tb_master_temuan','tb_master_coso','tb_master_ab','pemeriksaan_id','DESC','pemeriksaan_id',$id_pmr,'bidangtemuan_id','bidangtemuan_id','temu_id','coso_id','temu_id','coso_id','id_klasifikasi_ab','id_ab');
			$data['record4'] = $this->model_app->view_where('tb_lha','id_pemeriksaan',$id_pmr);
			//$data['record5'] = $this->model_app->view_where('tb_temuan','pemeriksaan_id',$id_pmr);
				//if ($jenis!="Rutin") {
					//$this->template->load('template','kelola-pemeriksaan/kelola-temuanspi',$data);
				//}else{
					$this->template->load('template','kelola-pemeriksaan/input_spi2',$data);
				//}
		}elseif ($this->session->level=="kabagspi") {
			$id_pmr = $this->uri->segment(3);
				$dataa['record'] = $this->model_app->view_join_where('pemeriksaan_id',$id_pmr,'tb_pemeriksaan','tb_unit','unit_id','pemeriksaan_id','DESC');
				$dataa['record2'] = $this->model_app->view_where2_ordering('tb_temuan','pemeriksaan_id',$id_pmr,'temuan_publish_kabag','Y','bidangtemuan_id','ASC');
				$dataa['record3'] = $this->model_app->view_join_five_table('tb_temuan','tb_bidangtemuan','tb_master_temuan','tb_master_coso','tb_master_ab','pemeriksaan_id','DESC','pemeriksaan_id',$id_pmr,'bidangtemuan_id','bidangtemuan_id','temu_id','coso_id','temu_id','coso_id','id_klasifikasi_ab','id_ab');
				$dataa['record4'] = $this->model_app->view_where('tb_lha','id_pemeriksaan',$id_pmr);
				//$dataa['record5'] = $this->model_app->view_where('tb_rekomendasi','pemeriksaan_id',$id_pmr);
				//if ($jenis!="Rutin") {
					//$this->template->load('template','kelola-pemeriksaan/kelola-kabagspi',$dataa);
				//}else{
					$this->template->load('template','kelola-pemeriksaan/kelola-temuan-kadiv',$dataa);	
				//}
		}else{
			redirect('administrator');
		}
		
	}

	public function upload_lha(){
		if (isset($_POST['upload'])) {
			$id_pmr = $this->uri->segment(3);
			$no_lha = $this->input->post('no_lha');
			$tahun=date('Y');
			$config['upload_path'] = 'asset/file_lha/';
			$config['allowed_types'] = 'pdf';
			$config['max_size'] = '25000'; // kb
			$this->load->library('upload', $config);
			if($this->upload->do_upload('file_lha')){
				$file_lha=$this->upload->data();
				$this->db->insert('tb_lha',array('file_lha'=>$file_lha['file_name'],'no_lha'=>$no_lha,'tahun'=>$tahun,'id_pemeriksaan'=> $id_pmr));
			}
			redirect('administrator/input_spi/'.$id_pmr.'/');
		}
		else{
			redirect('administrator/input_spi/'.$id_pmr.'/');
		}
		
	}
	public function user(){
		$this->load->view('user.php');
	}
	public function view_temuan(){
		if ($this->session->level=="admin" OR $this->session->level=="spi" OR $this->session->level=="kabagspi" OR $this->session->level=="viewer") {
			$id = $this->uri->segment(3);
			if ($this->uri->segment(4)!=null) {
				$id_notif = $this->uri->segment(4);
				$this->db->query("UPDATE tb_notifikasi SET notifikasi_dibaca = 'Y' WHERE notifikasi_id='$id_notif'");
			}
			$cek = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id);
			$jenis =  $cek[0]['pemeriksaan_jenis'];
			$data['record'] = $this->model_app->view_join_where('pemeriksaan_id',$id,'tb_pemeriksaan','tb_unit','unit_id','pemeriksaan_id','DESC');
			$data['record2'] = $this->model_app->view_where3_ordering('tb_temuan','pemeriksaan_id',$id,'temuan_publish_kabag','Y','temuan_pmr_sebelumnya',0,'temuan_id','ASC');
			
			if ($this->session->level=="kabagspi") {
				//if ($jenis!="Rutin") {
				//	$this->template->load('template','kelola-pemeriksaan/view_temuan', $data);
				//}else{
					$this->template->load('template','kelola-pemeriksaan/kelola-pemeriksaan', $data);
				//}
			}else{
				//if ($jenis!="Rutin") {
					//$this->template->load('template','kelola-pemeriksaan/view_temuan', $data);
				//}else{
					$this->template->load('template','kelola-pemeriksaan/view_temuan2', $data);
			//	}
			}
		}else{
			redirect('administrator/home');
		}
		
	}
	public function tambah_temuan(){
		if ($this->session->level=="spi") {
			$id_pmr = $this->uri->segment(3);
			$cek = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
			$jenis =  $cek[0]['pemeriksaan_jenis'];
			if (isset($_POST['simpan'])) {
				//simpan sebagai draft
				$config['upload_path'] = 'asset/file_pendukung/';
	            $config['allowed_types'] = 'jpg|png|JPG|JPEG|pdf|doc|docx|xls|xlsx|odt|';
	            $config['max_size'] = '25000'; // kb
	            $this->load->library('upload', $config);
	            $this->upload->do_upload('upload');
            	$hasil=$this->upload->data();
				$sebab = $this->input->post('sebab');
				$penyebab = implode("/", $sebab);
				$data = array(  'pemeriksaan_id' => $id_pmr,
								'bidangtemuan_id' => $this->input->post('bidang'),
								'temuan_judul' => $this->input->post('temuan'),
								'temu_id' => $this->input->post('m_temuan'),
								'sebab_id' => $penyebab,
								'coso_id' => $this->input->post('coso'),
								'nominal' => $this->input->post('nominal'),
								'penyebab' => $this->input->post('penyebab'),
								'id_klasifikasi_ab' => $this->input->post('a_b'),
								'temuan_tgl' => date('Ymd'),
								'temuan_publish_kabag' => 'N',
                           		'user_nik' => $this->session->username,
								'temuan_doc_pendukung' => $hasil['file_name'],
								'temuan_kriteria' => $this->input->post('kriteria')
				);
				$this->model_app->insert('tb_temuan', $data);
				redirect('administrator/input_spi/'.$id_pmr);
			}elseif (isset($_POST['kirim'])) {
				//kirim ke kabag spi
				$sebab = $this->input->post('sebab');
				$penyebab = implode("/", $sebab);
				$data = array('pemeriksaan_id' => $id_pmr,
								'bidangtemuan_id' => $this->input->post('bidang'),
								'temuan_judul' => $this->input->post('temuan'),
								'temu_id' => $this->input->post('m_temuan'),
								'sebab_id' => $penyebab,
								'coso_id' => $this->input->post('coso'),
								'nominal' => $this->input->post('nominal'),
								'penyebab' => $this->input->post('penyebab'),
								'id_klasifikasi_ab' => $this->input->post('a_b'),
								'temuan_tgl' => date('Ymd'),
								'temuan_publish_kabag' => 'Y',
                           		'user_nik' => $this->session->username
				);
				$this->model_app->insert('tb_temuan', $data);
				//insert notifikasi
				$pmr = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
				$pmr = $pmr[0]['pemeriksaan_judul'];
				$data2 = array(
					'notifikasi_judul' => 'Temuan baru Perlu di Approve',
					'notifikasi_pesan' => '<b>Pada Pemeriksaan : </b><br>'.$pmr,
					'notifikasi_link' => 'administrator/input_spi/'.$id_pmr,
					'notifikasi_level' => 'kabagspi'
				);
				$this->model_app->insert('tb_notifikasi',$data2);
				redirect('administrator/input_spi/'.$id_pmr);
			}else{
				$data['record2'] = $this->model_app->view_where_ordering('pemeriksaan_id','tb_temuan',$id_pmr,'bidangtemuan_id','ASC');
				//if ($jenis!="Rutin") {
				//	$this->template->load('template','kelola-temuan/tambah_temuanspi', $data);
				//}else{
					$this->template->load('template','kelola-temuan/tambah_temuan', $data);
				//}
			}
		}else{
			redirect('administrator/list_pemeriksaan');
		}
	}
	public function tambah_temuanspi(){
		$id_pmr = $this->uri->segment(3);
		if (isset($_POST['simpan'])) {
			$data1 = array(
				'pemeriksaan_id' => $id_pmr,
				'bidangtemuan_id' => $this->input->post('bidang'),
				'temuan_obyek' => $this->input->post('obyek'),
				'temuan_judul' => $this->input->post('temuan'),
				'temuan_tgl' => date('Y-m-d'),
				'temuan_publish_kabag' => 'Y',
				'temuan_kirim' => 'Y'
			);
			$this->model_app->insert('tb_temuan', $data1);
			$id_temuan = $this->db->insert_id();
			$data2 = array(
				'pemeriksaan_id' => $id_pmr,
				'temuan_id' => $id_temuan,
				'rekomendasi_judul' => $this->input->post('rekomendasi'),
				'rekomendasi_tgl' => date('Y-m-d'),
				'rekomendasi_status' => 'Belum di Tindak Lanjut',
				'rekomendasi_publish_kabag' => 'N',
				'user_nik' => $this->session->username
			);
			$this->model_app->insert('tb_rekomendasi', $data2);
			$this->session->set_flashdata('simpan','Temuan Rekomendasi Anda berhasil disimpan dalam Draft');
			redirect('administrator/input_spi/'.$id_pmr);
		}elseif (isset($_POST['kirim'])) {
			$data1 = array(
				'pemeriksaan_id' => $id_pmr,
				'bidangtemuan_id' => $this->input->post('bidang'),
				'temuan_obyek' => $this->input->post('obyek'),
				'temuan_judul' => $this->input->post('temuan'),
				'temuan_tgl' => date('Y-m-d'),
				'temuan_publish_kabag' => 'Y',
				'temuan_kirim' => 'Y'
			);
			$this->model_app->insert('tb_temuan', $data1);
			$id_temuan = $this->db->insert_id();
			$data2 = array(
				'pemeriksaan_id' => $id_pmr,
				'temuan_id' => $id_temuan,
				'rekomendasi_judul' => $this->input->post('rekomendasi'),
				'rekomendasi_tgl' => date('Y-m-d'),
				'rekomendasi_status' => 'Belum di Tindak Lanjut',
				'rekomendasi_publish_kabag' => 'Y',
				'user_nik' => $this->session->username
			);
			$this->model_app->insert('tb_rekomendasi', $data2);
			//insert notifikasi
				$pmr = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
				$pmr = $pmr[0]['pemeriksaan_judul'];
				$datanotif = array(
					'notifikasi_judul' => 'Temuan baru Perlu di Approve',
					'notifikasi_pesan' => '<b>Pada Pemeriksaan : </b><br>'.$pmr,
					'notifikasi_link' => 'administrator/input_spi/'.$id_pmr,
					'notifikasi_level' => 'kabagspi'
				);
				$this->model_app->insert('tb_notifikasi',$datanotif);
				$this->session->set_flashdata('kirim','Temuan Rekomendasi berhasil dikirim ke Kadiv DSPI');
				redirect('administrator/input_spi/'.$id_pmr);
		}
		redirect('administrator/input_spi/'.$id_pmr);
	}
	public function edit_temuan(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		if (isset($_POST['simpan'])) {
			$sebab = $this->input->post('sebab');
				$penyebab = implode("/", $sebab);
				$data = array(  'pemeriksaan_id' => $id_pmr,
								'bidangtemuan_id' => $this->input->post('bidang'),
								'temuan_judul' => $this->input->post('temuan'),
								'temu_id' => $this->input->post('m_temuan'),
								'sebab_id' => $penyebab,
								'coso_id' => $this->input->post('coso'),
								'nominal' => $this->input->post('nominal'),
								'penyebab' => $this->input->post('sebab'),
								'id_klasifikasi_ab' => $this->input->post('a_b'),
								'temuan_tgl' => date('Ymd'),
								'temuan_publish_kabag' => 'N',
                           		'user_nik' => $this->session->username
				);
			$where = array('temuan_id' => $this->input->post('id'));
			$this->model_app->update('tb_temuan', $data , $where);
			redirect('administrator/input_spi/'.$id_pmr);
		}else{
			//$data['record'] = $this->model_app->view_where('tb_temuan','temuan_id',$id_temuan);
			//$data['record'] = $this->model_app->view_join_five_table('tb_temuan','tb_bidangtemuan','tb_master_temuan','tb_master_coso','tb_master_ab','pemeriksaan_id','DESC','temuan_id',$id_temuan,'bidangtemuan_id','bidangtemuan_id','temu_id','coso_id','coso_id','temu_id','id_klasifikasi_ab','id_ab');
			$data['record'] = $this->model_app->view_where('tb_temuan','temuan_id',$id_temuan);
			// $str = $this->db->last_query();
			// echo $str;
			// exit;
			$this->template->load('template', 'kelola-temuan/edit_temuan', $data);
		}
	}
	public function edit_temuanspi(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);
		if (isset($_POST['simpan'])) {
			$data =array(
				'temuan_judul' => $this->input->post('temuan'),
				'temuan_tgl' => date('Y-m-d'),
				'temuan_obyek' => $this->input->post('obyek'),
				'bidangtemuan_id' => $this->input->post('bidang'),
			);
			$where = array('temuan_id' => $this->input->post('id_temuan'));
			$data2 = array(
				'rekomendasi_judul' => $this->input->post('rekomendasi'),
				'rekomendasi_kirim' => 'N'
			);
			$where2 = array('rekomendasi_id' => $this->input->post('id_rekom'));
			$this->model_app->update('tb_temuan', $data, $where);
			$this->model_app->update('tb_rekomendasi', $data2, $where2);
			redirect('administrator/input_spi/'.$id_pmr);
		}else{
			$data['record'] = $this->model_app->view_join_where('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_temuan','temuan_id','rekomendasi_id','ASC');
			$this->template->load('template','kelola-temuan/edit_temuanspi', $data);
		}
	}
	public function delete_temuan(){
		$id_pmr = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$id_temuan = array('temuan_id' => $this->uri->segment(4));
		$cek = $this->model_app->view_select_where('temuan_id','tb_tl','temuan_id',$id);
		// $stt = $this->model_app->view_select_where('pemeriksaan_aktif','tb_pemeriksaan','pemeriksaan_id',$id);
		if (!empty($cek)) {
			$this->session->set_flashdata('gagal','Gagal Menghapus, Ada Tindak Lanjut pada Temuan ini!');
			redirect('administrator/input_spi/'.$id_pmr);
		}else{
			$this->model_app->delete('tb_temuan', $id_temuan);
			$this->model_app->delete('tb_rekomendasi', $id_temuan);
			// $this->model_app->delete('tb_tl', $id_temuan);
			redirect('administrator/input_spi/'.$id_pmr);
		}
	}
	public function delete_temuanspi(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);

		$cek = $this->model_app->view_select_where('temuan_id','tb_tl','temuan_id', $id_temuan);
		if (!empty($cek)) {
			$this->session->set_flashdata('gagal','Gagal Menghapus, Ada Tindak Lanjut pada Temuan dan Rekomendasi ini!');
			redirect('administrator/input_spi/'.$id_pmr);
		}else{
			$this->model_app->delete('tb_rekomendasi', array('rekomendasi_id'=> $id_rekom));
			$this->model_app->delete('tb_temuan', array('temuan_id'=>$id_temuan));
			redirect('administrator/input_spi/'.$id_pmr);
		}
	}

	public function kirim_temuan(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		$data = array('temuan_kirim' => 'Y');
		$where = array('temuan_id' => $id_temuan);
		$this->model_app->update('tb_temuan', $data, $where);
		//insert notifikasi
			$pmr = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
			$jdl_pmr = $pmr[0]['pemeriksaan_judul'];
			$unit = $pmr[0]['unit_id'];
			$data2 = array(
				'notifikasi_judul' => 'Temuan baru',
				'notifikasi_pesan' => '<b>Pada Pemeriksaan : </b><br>'.$jdl_pmr,
				'notifikasi_link' => 'administrator/list_pmr_operator',
				'notifikasi_level' => 'operator',
				'notifikasi_unit' => $unit
			);
			$this->model_app->insert('tb_notifikasi',$data2);
			$data3 = array(
				'notifikasi_judul' => 'Temuan baru',
				'notifikasi_pesan' => '<b>Pada Pemeriksaan : </b><br>'.$jdl_pmr,
				'notifikasi_link' => 'administrator/list_pmr_verifikator',
				'notifikasi_level' => 'verifikator',
				'notifikasi_unit' => $unit
			);
			$this->model_app->insert('tb_notifikasi',$data3);
		$this->session->set_flashdata('kirimtemuan', 'Temuan berhasil disetujui dan dikirim ke Divisi/Regional/Anak Perusahaan');
		redirect('administrator/input_spi/'.$id_pmr);
	}
	public function kirim_temuan_kadiv_spi(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		$data = array('temuan_publish_kabag' => 'Y');
		$where = array('temuan_id' => $id_temuan);
		$this->model_app->update('tb_temuan', $data, $where);
		//insert notifikasi
			$pmr = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
			$jdl_pmr = $pmr[0]['pemeriksaan_judul'];
			$unit = $pmr[0]['unit_id'];
			$data2 = array(
				'notifikasi_judul' => 'Temuan baru',
				'notifikasi_pesan' => '<b>Pada Pemeriksaan : </b><br>'.$jdl_pmr,
				'notifikasi_link' => 'administrator/list_pmr_operator',
				'notifikasi_level' => 'operator',
				'notifikasi_unit' => $unit
			);
			$this->model_app->insert('tb_notifikasi',$data2);
			$data3 = array(
				'notifikasi_judul' => 'Temuan baru',
				'notifikasi_pesan' => '<b>Pada Pemeriksaan : </b><br>'.$jdl_pmr,
				'notifikasi_link' => 'administrator/list_pmr_verifikator',
				'notifikasi_level' => 'verifikator',
				'notifikasi_unit' => $unit
			);
			$this->model_app->insert('tb_notifikasi',$data3);
		$this->session->set_flashdata('kirimtemuan', 'Temuan berhasil dikirim ke Kadiv DSPI');
		redirect('administrator/input_spi/'.$id_pmr);
	}

	public function multikirimtemuan_tokebun(){
		$id_pmr = $this->uri->segment(3);
		if (isset($_POST['kirim'])) {
			$pilih = $this->input->post('select');
			$jumlah = count($pilih);
			if ($pilih == null) {
				redirect('administrator/input_spi/'.$id_pmr);
			}
			for($x=0;$x<$jumlah;$x++){
				$this->db->query("UPDATE tb_temuan SET temuan_kirim = 'Y' WHERE temuan_id ='$pilih[$x]'");
			}
				//insert notifikasi
				$pmr = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
				$jdl_pmr = $pmr[0]['pemeriksaan_judul'];
				$unit = $pmr[0]['unit_id'];
				$data2 = array(
					'notifikasi_judul' => 'Temuan baru',
					'notifikasi_pesan' => '<b>Pada Pemeriksaan : </b><br>'.$jdl_pmr,
					'notifikasi_link' => 'administrator/list_pmr_operator',
					'notifikasi_level' => 'operator',
					'notifikasi_unit' => $unit
				);
				$this->model_app->insert('tb_notifikasi',$data2);
				$data3 = array(
					'notifikasi_judul' => 'Temuan baru',
					'notifikasi_pesan' => '<b>Pada Pemeriksaan : </b><br>'.$jdl_pmr,
					'notifikasi_link' => 'administrator/list_pmr_verifikator',
					'notifikasi_level' => 'verifikator',
					'notifikasi_unit' => $unit
				);
				$this->model_app->insert('tb_notifikasi',$data3);
			$this->session->set_flashdata('kirimtemuan', 'Temuan berhasil disetujui dan dikirim ke Divisi/Regional/Anak Perusahaan');
			redirect('administrator/input_spi/'.$id_pmr);
		}
	}
	public function kembalikan_temuan(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		$data = array('temuan_kirim' => 'K', 'temuan_publish_kabag'=>'N');
		$where = array('temuan_id' => $id_temuan);
		$this->model_app->update('tb_temuan', $data, $where);
		//insert notifikasi
			$temuan = $this->model_app->view_where('tb_temuan','temuan_id',$id_temuan);
			$jdl_temuan = $temuan[0]['temuan_judul'];
			$bidang = $this->model_app->view_where('tb_bidangtemuan','bidangtemuan_id',$temuan[0]['bidangtemuan_id']);
			$bidang = $bidang[0]['bidangtemuan_nama'];
			$pmr = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id', $id_pmr);
			$userspi = explode("/", $pmr[0]['pemeriksaan_petugas']);
			foreach ($userspi as $key => $value) {
				$data2 = array(
					'notifikasi_judul' => 'Temuan Dikembalikan oleh Kabag',
					'notifikasi_pesan' => '<b>Bidang : '.$bidang.'<br>Temuan : </b><br>'.$jdl_temuan,
					'notifikasi_level' => 'spi',
					'notifikasi_user' => $value,
					'notifikasi_link' => 'administrator/input_spi/'.$id_pmr
				);
				$this->model_app->insert('tb_notifikasi', $data2);
			}
		$this->session->set_flashdata('kembalikan','Temuan berhasil dikembalikan ke SPI');
		redirect('administrator/input_spi/'.$id_pmr);
	}
	public function kirimtemuan_tokabag(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		$data = array('temuan_kirim'=>'N','temuan_publish_kabag' => 'Y');
		$where = array('temuan_id' => $id_temuan);
		$this->model_app->update('tb_temuan', $data, $where);
		//insert notifikasi
			$pmr = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
			$pmr = $pmr[0]['pemeriksaan_judul'];
			$data2 = array(
				'notifikasi_judul' => 'Temuan baru Perlu di Approve',
				'notifikasi_pesan' => '<b>Pada Pemeriksaan : </b><br>'.$pmr,
				'notifikasi_link' => 'administrator/input_spi/'.$id_pmr,
				'notifikasi_level' => 'kabagspi'
			);
			$this->model_app->insert('tb_notifikasi',$data2);
		$this->session->set_flashdata('kirimtemuan_tokabag', 'Temuan berhasil dikirim ke Kadiv DSPI');
		redirect('administrator/input_spi/'.$id_pmr);
	}
	public function multikirimtemuan_tokabag(){
		$id_pmr = $this->uri->segment(3);
		if (isset($_POST['kirim'])) {
			$pilih = $this->input->post('select');
			$jumlah = count($pilih);
			if ($pilih == null) {
				redirect('administrator/input_spi/'.$id_pmr);
			}
			for($x=0;$x<$jumlah;$x++){
				$this->db->query("UPDATE tb_rekomendasi SET rekomendasi_publish_kabag = 'Y' WHERE temuan_id ='$pilih[$x]'");
			}
			//insert notifikasi
			$pmr = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
			$pmr = $pmr[0]['pemeriksaan_judul'];
			$data2 = array(
				'notifikasi_judul' => 'Temuan baru Perlu di Approve',
				'notifikasi_pesan' => '<b>Pada Pemeriksaan : </b><br>'.$pmr,
				'notifikasi_link' => 'administrator/input_spi/'.$id_pmr,
				'notifikasi_level' => 'kabagspi'
			);
			$this->model_app->insert('tb_notifikasi',$data2);
			$this->session->set_flashdata('kirimtemuan_tokabag', 'Temuan berhasil dikirim ke Kadiv DSPI');
			redirect('administrator/input_spi/'.$id_pmr);
		}
	}

	public function send_temuan_rekomendasi() {
		$id_temuan = $this->uri->segment(3);
		$id_pmr = $this->uri->segment(4);
	
		if (empty($id_temuan)) {
			echo json_encode(['status' => 'error', 'message' => 'ID Temuan tidak ditemukan']);
			return;
		}

		$cek_temuand_id = $this->model_app->view_where('tb_rekomendasi', 'temuan_id', $id_temuan);
		if (empty($cek_temuand_id)) {
			//echo json_encode(['status' => 'error', 'message' => 'ID Temuan tidak ditemukan']);
			echo "<script>alert('Belum Mengisi Rekomendasi'); window.history.back();</script>";
			return;
		}
	
		try {
			// Update tabel tb_temuan
			$data1 = ['temuan_publish_kabag' => 'Y'];
			$where1 = ['temuan_id' => $id_temuan];
			$update1 = $this->model_app->update('tb_temuan', $data1, $where1);
	
			if (!$update1) {
				throw new Exception('Gagal mengupdate tb_temuan');
			}
	
			// Update semua rekomendasi terkait dengan temuan_id
			$data2 = [
				'rekomendasi_publish_kabag' => 'Y',
				'rekomendasi_status_kirim' => 'N'
			];
	
			$this->db->where('temuan_id', $id_temuan);
			$update2 = $this->db->update('tb_rekomendasi', $data2);
	
			if (!$update2) {
				throw new Exception('Gagal mengupdate tb_rekomendasi');
			}
	
			// Cek apakah request berasal dari AJAX atau tidak
			if ($this->input->is_ajax_request()) {
				echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
			} else {
				redirect('administrator/input_spi/'.$id_pmr);
			}
		} catch (Exception $e) {
			if ($this->input->is_ajax_request()) {
				echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
			} else {
				redirect('administrator/input_spi/'.$id_pmr);
			}
		}
	}
	
	public function send_temuan_rekomendasi_unit() {
		$id_temuan = $this->uri->segment(3);
		$id_pmr = $this->uri->segment(4);
	
		if (empty($id_temuan)) {
			echo json_encode(['status' => 'error', 'message' => 'ID Temuan tidak ditemukan']);
			return;
		}
	
		try {
			// Update tabel tb_temuan
			$data1 = ['temuan_kirim' => 'Y'];
			$where1 = ['temuan_id' => $id_temuan];
			$update1 = $this->model_app->update('tb_temuan', $data1, $where1);
	
			if (!$update1) {
				throw new Exception('Gagal mengupdate tb_temuan');
			}
	
			// Update semua rekomendasi yang berhubungan dengan temuan_id
			$data2 = ['rekomendasi_kirim' => 'Y'];
			$this->db->where('temuan_id', $id_temuan);
			$update2 = $this->db->update('tb_rekomendasi', $data2);
	
			if (!$update2) {
				throw new Exception('Gagal mengupdate tb_rekomendasi');
			}
	
			// Cek apakah request berasal dari AJAX atau tidak
			if ($this->input->is_ajax_request()) {
				echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
			} else {
				redirect('administrator/input_spi/'.$id_pmr);
			}
		} catch (Exception $e) {
			if ($this->input->is_ajax_request()) {
				echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
			} else {
				redirect('administrator/input_spi/'.$id_pmr);
			}
		}
	}

	public function send_lha_reg(){
		
		$id_pmr = $this->input->post('id_pmr');
		$status = $this->input->post('status'); // Ambil status dari AJAX

		// Cek di database apakah dokumen sudah di-upload
		$cek = $this->db->get_where('tb_lha', ['id_pemeriksaan' => $id_pmr])->row();

		if (!$cek || empty($cek->file_lha)) {
			echo json_encode(['status' => 'error']);
			return;
		}
	
		// Update status di database
		$this->db->where('id_pemeriksaan', $id_pmr);
		$this->db->update('tb_lha', ['status' => $status]);
	
		echo json_encode(['status' => 'success']);
		
	}
	
	public function tambah_tanggapan(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);
		if (isset($_POST['simpan'])) {
			if ($this->input->post('tgl')==null) {
				$tanggal = date('Y-m-d');
			}else{
				$tanggal = $this->input->post('tgl');
			}
			$data = array(
				'rekomendasi_id' => $id_rekom,
				'tanggapan_deskripsi' => $this->input->post('tanggapan'),
				'tanggapan_tgl' => $tanggal,
				'tanggapan_publish_kabag' => 'N',
				'user_nik' => $this->session->username
			);
			$this->model_app->insert('tb_tanggapan',$data);
			$id_tanggapan = $this->db->insert_id();
			redirect('administrator/upload_tanggapan'.'/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom.'/'.$id_tanggapan);
		}elseif (isset($_POST['kirim'])) {
			if ($this->input->post('tgl')==null) {
				$tanggal = date('Y-m-d');
			}else{
				$tanggal = $this->input->post('tgl');
			}
			$data = array(
				'rekomendasi_id' => $id_rekom,
				'tanggapan_deskripsi' => $this->input->post('tanggapan'),
				'tanggapan_tgl' => $tanggal,
				'tanggapan_publish_kabag' => 'Y',
				'tanggapan_kirim' => 'N',
				'user_nik' => $this->session->username
			);
			$this->model_app->insert('tb_tanggapan',$data);
			$id_tanggapan = $this->db->insert_id();
			//insert notifikasi
			$ambil = $this->model_app->view_join_where('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','pemeriksaan_id','rekomendasi_id','ASC');
			$pmr = $ambil[0]['pemeriksaan_judul'];
			$rekom = $ambil[0]['rekomendasi_judul'];
			$data2 = array(
				'notifikasi_judul' => 'Tanggapan Manajer',
				'notifikasi_pesan' => '<b>Pemeriksaan : </b>'.$pmr.'<br><b>Rekomendasi : </b>'.$rekom,
				'notifikasi_level' => 'kabagspi',
				'notifikasi_link' => 'administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom
			);
			$this->model_app->insert('tb_notifikasi', $data2);

			redirect('administrator/upload_tanggapan'.'/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom.'/'.$id_tanggapan);
		}else{
			$data['record'] = $this->model_app->view_join_two_limit('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC','1');
			$this->template->load('template','kelola-rekomendasi/input_tanggapanmanajer', $data);
		}
	}
	public function edit_tanggapan(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);
		$id_tanggapan = $this->uri->segment(6);
		if (isset($_POST['simpan'])) {
			$data = array(
				'tanggapan_id' => $this->input->post('id'),
				'tanggapan_deskripsi' => $this->input->post('tanggapan'),
				'tanggapan_tgl' => date('Ymd'),
				'tanggapan_publish_kabag' => 'N'
			);
			$where = array('tanggapan_id' => $this->input->post('id'));
			$this->model_app->update('tb_tanggapan',$data,$where);
			redirect('administrator/list_tanggapantl/'.'/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
		}elseif (isset($_POST['kirim'])) {
			$data = array(
				'tanggapan_id' => $this->input->post('id'),
				'tanggapan_deskripsi' => $this->input->post('tanggapan'),
				'tanggapan_tgl' => date('Y-m-d'),
				'tanggapan_publish_kabag' => 'Y',
				'tanggapan_kirim' => 'N'
			);
			$where = array('tanggapan_id' => $this->input->post('id'));
			$this->model_app->update('tb_tanggapan',$data,$where);
			//insert notifikasi
			$ambil = $this->model_app->view_join_where('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','pemeriksaan_id','rekomendasi_id','ASC');
			$pmr = $ambil[0]['pemeriksaan_judul'];
			$rekom = $ambil[0]['rekomendasi_judul'];
			$data2 = array(
				'notifikasi_judul' => 'Tanggapan Manajer',
				'notifikasi_pesan' => '<b>Pemeriksaan : </b>'.$pmr.'<br><b>Rekomendasi : </b>'.$rekom,
				'notifikasi_level' => 'kabagspi',
				'notifikasi_link' => 'administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom
			);
			$this->model_app->insert('tb_notifikasi', $data2);
			redirect('administrator/list_tanggapantl/'.'/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
		}else{
			$dataa['record'] = $this->model_app->view_where('tb_tanggapan','tanggapan_id',$id_tanggapan);
			$dataa['record2'] = $this->model_app->view_join_two_limit('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC','1');
			$data = $this->model_app->view_where('tb_upload_tanggapan','tanggapan_id',$id_tanggapan);
			json_encode($data);
			$this->template->load('template','kelola-rekomendasi/edit_tanggapanmanajer',$dataa);
		}
	}
	public function kirim_tanggapanmanajer(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);
		$id_tanggapan = $this->uri->segment(6);
		$cek = $this->model_app->view_where('tb_rekomendasi','rekomendasi_id', $id_rekom);
		if ($cek[0]['rekomendasi_kirim']=="N") {
			$this->session->set_flashdata('gagal','Temuan Rekomendasi untuk Tanggapan ini belum dikirim');
		}else{
			$data = array('tanggapan_kirim' => 'Y');
			$where = array('tanggapan_id' => $id_tanggapan);
			$this->model_app->update('tb_tanggapan', $data, $where);
			//insert notifikasi
			$ambil = $this->model_app->view_where('tb_tanggapan','tanggapan_id', $id_tanggapan);
			$tanggapan = $ambil[0]['tanggapan_deskripsi'];
			$pmr = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
			$userspi = explode("/", $pmr[0]['pemeriksaan_petugas']);
			foreach ($userspi as $key => $value) {
				$data2 = array(
					'notifikasi_judul' => 'Tanggapan Manajer telah di Approve',
					'notifikasi_pesan' => '<b>Tanggapan : </b><br>'.$tanggapan,
					'notifikasi_level' => 'spi',
					'notifikasi_link' => 'administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,
					'notifikasi_user' => $value
				);
				$this->model_app->insert('tb_notifikasi', $data2);
			}
			$this->session->set_flashdata('berhasil','Tanggapan Manajer berhasil disetujui');
		}
		redirect('administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom); 
	}
	public function upload_tanggapan(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5); $id_tanggapan = $this->uri->segment(6);
		$data['record'] = $this->model_app->view_join_two_limit('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC','1');
		$this->template->load('template','kelola-rekomendasi/upload_tanggapanmanajer', $data);
	}
	public function uploadfile_tanggapan(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5); $id_tanggapan = $this->uri->segment(6);
		$config['upload_path'] = 'asset/file_tanggapan/';
		$config['allowed_types'] = 'jpg|png|jpeg|JPG|JPEG|pdf|doc|docx|xls|xlsx|odt|';
		$config['max_size'] = '25000'; // kb
		$this->load->library('upload', $config);
		if($this->upload->do_upload('userfile')){
			$token=$this->input->post('token_foto');
			$nama=$this->upload->data('file_name');
			$this->db->insert('tb_upload_tanggapan',array('uploadtanggapan_nama'=>$nama,'token'=>$token, 'uploadtanggapan_tgl'=> date('Ymd'), 'tanggapan_id' => $id_tanggapan));
		}
		redirect('administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
	}
	public function remove_file_tanggapan(){
		$token=$this->input->post('token');
		$cek = $this->model_app->view_where('tb_upload_tanggapan','token',$token);
		$namafile = $cek[0]['uploadtanggapan_nama'];
		$path = 'asset/file_tanggapan/'.$namafile;
		unlink($path);
		$this->db->delete('tb_upload_tanggapan',array('token'=>$token));
		
		echo "{}";
	}
	public function hapus_file_tanggapan(){
		$id=$this->input->post('kode');
		$cek = $this->model_app->view_where('tb_upload_tanggapan','uploadtanggapan_id',$id);
		$namafile = $cek[0]['uploadtanggapan_nama'];
		$path = 'asset/file_tanggapan/'.$namafile;
		unlink($path);
		$data=$this->model_app->hapus_file_tanggapan($id);
		echo json_encode($data);
	}
	public function tampil_filetanggapan(){
		$id_tanggapan = $this->uri->segment(3);
		$data = $this->model_app->view_where('tb_upload_tanggapan','tanggapan_id',$id_tanggapan);
		echo json_encode($data);
	}

	public function list_pmr_operator(){
		if ($this->session->level=="admin" OR $this->session->level=="operator") {
			$unit=$this->session->unit;
			//$query = $this->model_app->view_where2_ordering('tb_pemeriksaan','pemeriksaan_aktif','Y','unit_mention',$this->session->unit,'pemeriksaan_id','ASC');
			$q = $this->db->query("SELECT * FROM `tb_pemeriksaan` WHERE `pemeriksaan_aktif` = 'Y' ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` ASC")->result_array();
			$found = false;
			foreach ($q as $row) {
				$units = explode('/', $row['mention_unit']); // ubah string jadi array
				if (in_array($unit, $units)) { // cek apakah $unit ada di dalam array
					$found = true;
					break;
				}
			}

			if($found){
				$data['record'] = $this->db->query("SELECT * FROM `tb_pemeriksaan` WHERE `pemeriksaan_aktif` = 'Y' AND mention_unit REGEXP '(^|/)$unit(/|$)' ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` ASC")->result_array();
				$this->template->load('template','kelola-tl/list_pmr_operator', $data);
			}
			else{
				$data['record'] = $this->db->query("SELECT * FROM `tb_pemeriksaan` WHERE `pemeriksaan_aktif` = 'Y' AND unit_id = $unit ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` ASC")->result_array();
				$this->template->load('template','kelola-tl/list_pmr_operator', $data);
			}
			//CEK NOTIFIKASI
			// if ($this->uri->segment(3)!=null) {
			// 	$id_notif = $this->uri->segment(3);
			// 	$this->db->query("UPDATE tb_notifikasi SET notifikasi_dibaca='Y' WHERE notifikasi_id = '$id_notif'");
			// }else{
			// 	$data['record'] = $this->db->query("SELECT tb_pemeriksaan.*,tb_rekomendasi.unit_id as unit_mention FROM `tb_pemeriksaan` LEFT JOIN `tb_rekomendasi` ON `tb_pemeriksaan`.`pemeriksaan_id` = `tb_rekomendasi`.`pemeriksaan_id` WHERE `pemeriksaan_aktif` = 'Y' AND `tb_rekomendasi.`unit_id` = $unit ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` ASC")->result_array();
			// }				
		
		}else{
			redirect('administrator');
		}
		
	}
	public function list_pmr_verifikator(){
		if ($this->uri->segment(3)!=null) {
			$id_notif = $this->uri->segment(3);
			$this->db->query("UPDATE tb_notifikasi SET notifikasi_dibaca='Y' WHERE notifikasi_id = '$id_notif'");
		}
		$unit=$this->session->unit;
		//$data['record'] = $this->db->query("SELECT * FROM `tb_pemeriksaan`  WHERE `pemeriksaan_aktif` = 'Y' AND unit_id = $unit ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` ASC")->result_array();
		$q = $this->db->query("SELECT * FROM `tb_pemeriksaan` WHERE `pemeriksaan_aktif` = 'Y' ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` ASC")->result_array();	
		$found = false;
		foreach ($q as $row) {
			$units = explode('/', $row['mention_unit']); // ubah string jadi array
			if (in_array($unit, $units)) { // cek apakah $unit ada di dalam array
				$found = true;
				break;
			}
		}
			if($found){
				$data['record'] = $this->db->query("SELECT * FROM `tb_pemeriksaan` WHERE `pemeriksaan_aktif` = 'Y' AND mention_unit REGEXP '(^|/)$unit(/|$)' ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` ASC")->result_array();
				$this->template->load('template','kelola-tl/list_pmr_verifikator', $data);
			}
			else{
				$data['record'] = $this->db->query("SELECT * FROM `tb_pemeriksaan` WHERE `pemeriksaan_aktif` = 'Y' AND unit_id = $unit ORDER BY `tb_pemeriksaan`.`pemeriksaan_id` ASC")->result_array();
				$this->template->load('template','kelola-tl/list_pmr_verifikator', $data);
			}
		
	}
	public function list_tanggapantl(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);
		if ($this->uri->segment(6)!=null) {
			$id_notif = $this->uri->segment(6);
			$this->db->query("UPDATE tb_notifikasi SET notifikasi_dibaca='Y' WHERE notifikasi_id='$id_notif'");
		}
		$data['record'] = $this->model_app->view_join_two('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC');
		if ($this->session->level=="kabagspi") {
			$this->template->load('template','kelola-rekomendasi/kelola-tanggapantl', $data);
		}else{
			$this->template->load('template','kelola-rekomendasi/kelola-rekomendasispi', $data);
		}
	}
	public function list_rekomendasi(){
		$id_temuan = $this->uri->segment(4);
		if ($this->uri->segment(5)!=null) {
			$id_notif = $this->uri->segment(5);
			$this->db->query("UPDATE tb_notifikasi SET notifikasi_dibaca='Y' WHERE notifikasi_id='$id_notif'");
		}
		$data['record2'] = $this->model_app->view_where('tb_temuan','temuan_id',$id_temuan);
		if ($this->session->level=="kabagspi") {
			$data['record'] = $this->model_app->view_where2('tb_rekomendasi','temuan_id',$id_temuan,'rekomendasi_publish_kabag','Y');
			$this->template->load('template','kelola-rekomendasi/kelola-rekomendasi-kadiv', $data);
		}else{
			$data['record'] = $this->model_app->view_rekom($id_temuan,'tb_rekomendasi','tb_temuan','temuan_id');
			$this->template->load('template','kelola-rekomendasi/list_rekom', $data);	
		}
		
	}
	public function input_rekomendasi(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		
		if (isset($_POST['simpan'])) {
			$divisi=$this->input->post('divisi');
			if($divisi != '0' ){
				$tanggal=$this->input->post('deadline');
				$date = explode("-", $tanggal);
				$deadline = $date[2]."-".$date[1]."-".$date[0];
					$data = array('pemeriksaan_id' => $id_pmr,
								'temuan_id' => $id_temuan,
								'rekomendasi_judul' => $this->input->post('a'),
								'rekomendasi_tgl' => date('Ymd'),
								'rekomendasi_tgl_deadline' => $deadline,
								'rekomendasi_status' => 'Belum di Tindak Lanjut',
								'rekomendasi_status_tanggal' => date('Ymd')	,
								'rekomendasi_status_cache' => 'Belum di Tindak Lanjut',
								'rekomendasi_publish_kabag' => 'N',
								'rekomen_id' => $this->input->post('m_rekomendasi'),
								'user_nik' => $this->session->username,
								'unit_id' => $divisi
					);					
					$insert=$this->model_app->insert('tb_rekomendasi', $data);
					
					//redirect('administrator/upload_rekomendasi/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);

				if ($insert) {
					// Jika insert berhasil, ambil ID yang baru dimasukkan
					$id_rekom = $this->db->insert_id();
				
					// Ambil mention_unit lama
					$old = $this->db->select('mention_unit')
					->where('pemeriksaan_id', $id_pmr)
					->get('tb_pemeriksaan')
					->row();
					
					$mention_unit_lama = $old ? $old->mention_unit : '';

					$arr_unit = array_filter(explode('/', $mention_unit_lama)); // ubah ke array dan hapus kosong
					if (!in_array($divisi, $arr_unit)) {
					$arr_unit[] = $divisi; // tambahkan divisi baru jika belum ada
					}
					$mention_baru = implode('/', $arr_unit);

					// Simpan kembali ke DB
					$this->db->set('mention_unit', $mention_baru);
					$this->db->where('pemeriksaan_id', $id_pmr);
					$update = $this->db->update('tb_pemeriksaan');
				
					if ($update) {
						// Jika update juga berhasil, lanjutkan redirect
						redirect('administrator/upload_rekomendasi/' . $id_pmr . '/' . $id_temuan . '/' . $id_rekom);
					} else {
						echo "<script>alert('Update mention_unit gagal!'); window.history.back();</script>";
					}
				} else {
					echo "<script>alert('Insert ke tb_rekomendasi gagal!'); window.history.back();</script>";
				}

			}
			else{
				$audity=$this->input->post('tujuan');
				$tanggal=$this->input->post('deadline');
				$date = explode("-", $tanggal);
				$deadline = $date[2]."-".$date[1]."-".$date[0];
					$data = array('pemeriksaan_id' => $id_pmr,
								'temuan_id' => $id_temuan,
								'rekomendasi_judul' => $this->input->post('a'),
								'rekomendasi_tgl' => date('Ymd'),
								'rekomendasi_tgl_deadline' => $deadline,
								'rekomendasi_status' => 'Belum di Tindak Lanjut',
								'rekomendasi_status_tanggal' => date('Ymd')	,
								'rekomendasi_status_cache' => 'Belum di Tindak Lanjut',
								'rekomendasi_publish_kabag' => 'N',
								'rekomen_id' => $this->input->post('m_rekomendasi'),
								'user_nik' => $this->session->username,
								'unit_id' => $audity,
					);
					$this->model_app->insert('tb_rekomendasi', $data);
					$id_rekom = $this->db->insert_id();
					redirect('administrator/upload_rekomendasi/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
			}
			//redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
		}elseif (isset($_POST['kirim'])) {
			$data = array('pemeriksaan_id' => $id_pmr,
						  'temuan_id' => $id_temuan,
						  'rekomendasi_judul' => $this->input->post('a'),
						  'rekomendasi_tgl' => date('Ymd'),
						  'rekomendasi_status' => 'Belum di Tindak Lanjut',
						  'rekomendasi_status_cache' => 'Belum di Tindak Lanjut',
						  'rekomendasi_publish_kabag' => 'N',
						  'rekomen_id' => $this->input->post('m_rekomendasi'),
                          'user_nik' => $this->session->username
			);
			$this->model_app->insert('tb_rekomendasi', $data);
			$id_rekom = $this->db->insert_id();
				//insert notifikasi
				$ambil = $this->model_app->view_join_where('temuan_id',$id_temuan,'tb_temuan','tb_pemeriksaan','pemeriksaan_id','temuan_id','ASC');
				$temuan = $ambil[0]['temuan_judul'];
				$pmr = $ambil[0]['pemeriksaan_judul'];
				$unit = $ambil[0]['unit_id'];
				$data2 = array(
					'notifikasi_judul' => 'Rekomendasi Perlu di Approve',
					'notifikasi_pesan' => '<b>Rekomendasi pada Temuan :</b><br>'.$temuan,
					'notifikasi_level' => 'kabagspi',
					'notifikasi_link' => 'administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan
				);
				$this->model_app->insert('tb_notifikasi', $data2);
			redirect('administrator/upload_rekomendasi/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
		}else{
			$data['record'] =  $this->db->query("SELECT * FROM tb_temuan JOIN tb_pemeriksaan ON tb_temuan.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id LEFT JOIN tb_unit ON tb_unit.unit_id = tb_pemeriksaan.unit_id WHERE temuan_id = '$id_temuan'")->result_array();
            $this->template->load('template','kelola-rekomendasi/input_rekom', $data);
		}
	}
	public function edit_rekomendasi(){
		$id_pmr = $this->uri->segment(3);
		$id_rekom = $this->uri->segment(5);
		$id_temuan = $this->uri->segment(4);
		if (isset($_POST['edit'])) {
			if (isset($_FILES['file_lha']['name']) && !empty($_FILES['file_lha']['name'])) 
			{
				$data = array('rekomendasi_judul' => $this->input->post('rekomendasi'),
							'rekomendasi_tgl' => date('Ymd'),
							'user_nik' => $this->session->username,
							'rekomen_id' => $this->input->post('m_rekomendasi')
				);
			}
			else
			{
				$data = array('rekomendasi_judul' => $this->input->post('rekomendasi'),
							'rekomendasi_tgl' => date('Ymd'),
							'user_nik' => $this->session->username
				);
			}
			$where = array('rekomendasi_id' => $this->input->post('id'));
			$this->model_app->update('tb_rekomendasi', $data , $where);
			redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
		}
		$data['record'] = $this->model_app->view_where('tb_rekomendasi','rekomendasi_id',$id_rekom);
		$data['record2'] = $this->model_app->view_join_two_limit('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC','1');
		$this->template->load('template','kelola-rekomendasi/edit_rekom', $data);
	}
	public function delete_rekomendasi(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = array('rekomendasi_id' => $this->uri->segment(5));
		$id = $this->uri->segment(5);
		$cek = $this->model_app->view_select_where('rekomendasi_id','tb_tl','rekomendasi_id',$id);
		if (!empty($cek)) {
			$this->session->set_flashdata('gagal','Gagal Menghapus, Ada Tindak Lanjut pada Rekomendasi ini!');
			redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
		}else{
		$files = $this->db->query("SELECT uploadrekom_nama FROM tb_upload_rekom WHERE rekomendasi_id = '$id'")->result_array();
		foreach ($files as $nama) {
			$namafile =  $nama['uploadrekom_nama'];
			$path = 'asset/file_rekomendasi/'.$namafile;
			unlink($path);
		}
		$this->model_app->delete('tb_rekomendasi', $id_rekom);	
		$this->model_app->delete('tb_upload_rekom', $id_rekom);
		redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
		}
	}
	public function status_rekomendasi(){
		$id_temuan = $this->uri->segment(4);
		$id_pmr = $this->uri->segment(3);
		if ($this->uri->segment(6)=='Y'){
            $data = array('rekomendasi_aktif'=>'N');
        }else{
            $data = array('rekomendasi_aktif'=>'Y');
        }
        $where = array('rekomendasi_id' => $this->uri->segment(5));
        $this->model_app->update('tb_rekomendasi', $data, $where);
        redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
	}
	public function kirim_rekomendasi(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);
		$cek = $this->model_app->view_where('tb_temuan', 'temuan_id', $id_temuan);
		// echo $cek[0]['temuan_kirim']; 
		$cek2 = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
		$jenis =  $cek2[0]['pemeriksaan_jenis'];
		if ($cek[0]['temuan_kirim']=="Y") 
		{
			$data = array('rekomendasi_kirim' => 'Y');
			$where = array('rekomendasi_id' => $id_rekom);
			$this->model_app->update('tb_rekomendasi', $data, $where);
			// $this->session->set_flashdata('kirimrekom', 'Rekomendasi berhasil disetujui dan dikirim ke Kebun');
			// if ($jenis!="Rutin") {
			// 	//insert notifikasi
			// 		$ambil = $this->model_app->view_join_where('temuan_id',$id_temuan,'tb_temuan','tb_pemeriksaan','pemeriksaan_id','temuan_id','ASC');
			// 		$temuan = $ambil[0]['temuan_judul'];
			// 		$pmr = $ambil[0]['pemeriksaan_judul'];
			// 		$userspi = explode("/", $ambil[0]['pemeriksaan_petugas']);
			// 		foreach ($userspi as $key => $value) {
			// 			$data2 = array(
			// 				'notifikasi_judul' => 'Temuan Rekomendasi Telah di Approve',
			// 				'notifikasi_pesan' => '<b>Rekomendasi pada Pemeriksaan :</b><br>'.$pmr,
			// 				'notifikasi_level' => 'spi',
			// 				'notifikasi_link' => 'administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,
			// 				'notifikasi_user' => $value
			// 			);
			// 			$this->model_app->insert('tb_notifikasi', $data2);
			// 		}
					
			// 	$this->session->set_flashdata('kirimrekom', 'Temuan Rekomendasi berhasil disetujui');
			// 	redirect('administrator/input_spi/'.$id_pmr);
			// }
			//else{
				$cektgl = $this->model_app->view_where('tb_rekomendasi','rekomendasi_id',$id_rekom);
				$cektgl = $cektgl[0]['rekomendasi_tgl'];
					  $exp = explode("-", $cektgl);
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
                      $expired = $tgl."-".$bln."-".$thn;
					//insert notifikasi
					$ambil = $this->model_app->view_join_where('temuan_id',$id_temuan,'tb_temuan','tb_pemeriksaan','pemeriksaan_id','temuan_id','ASC');
					$temuan = $ambil[0]['temuan_judul'];
					$pmr = $ambil[0]['pemeriksaan_judul'];
					$unit = $ambil[0]['unit_id'];
					$data2 = array(
						'notifikasi_judul' => 'Rekomendasi Baru',
						'notifikasi_pesan' => '<b>Rekomendasi pada Temuan :</b><br>'.$temuan."<br><b>Deadline : ".$expired."</b>",
						'notifikasi_level' => 'operator',
						'notifikasi_unit' => $unit,
						'notifikasi_link' => 'administrator/list_pmr_operator'
					);
					$this->model_app->insert('tb_notifikasi', $data2);
					$data3 = array(
						'notifikasi_judul' => 'Rekomendasi Baru',
						'notifikasi_pesan' => '<b>Rekomendasi pada Temuan :</b><br>'.$temuan."<br><b>Deadline : ".$expired."</b>",
						'notifikasi_level' => 'verifikator',
						'notifikasi_unit' => $unit,
						'notifikasi_link' => 'administrator/list_pmr_verifikator'
					);
					$this->model_app->insert('tb_notifikasi', $data3);
				$this->session->set_flashdata('kirimrekom', 'Rekomendasi berhasil disetujui dan dikirim ke Divisi/Regional/Anper');
				redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
			//}
		}else{
			$this->session->set_flashdata('failedkirim', 'Gagal, Temuan untuk Rekomendasi ini belum dikirim ke Kebun');
			redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan,'refresh');
		}
		
	}
	public function multikirimrekom_tokebun(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		if (isset($_POST['kirim'])) {
			$cek = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
			$jenis =  $cek[0]['pemeriksaan_jenis'];
			$pilih = $this->input->post('select');
			if ($pilih==null) {
				//if ($jenis!="Rutin") {
				//	redirect('administrator/input_spi/'.$id_pmr);
				//}
				//else{
					redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
				//}
			}
			//if ($jenis!="Rutin") {
				// $jumlah = count($pilih);
				// for($x=0;$x<$jumlah;$x++){
				// 	$this->db->query("UPDATE tb_rekomendasi SET rekomendasi_kirim = 'Y' WHERE rekomendasi_id ='$pilih[$x]'");
				// }
				// //insert notifikasi
				// $ambil = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
				// $pmr = $ambil[0]['pemeriksaan_judul'];
				// $userspi = explode('/', $ambil[0]['pemeriksaan_petugas']);
				// foreach ($userspi as $key => $value) {
				// 	$data2 = array(
				// 		'notifikasi_judul' => 'Temuan Rekomendasi telah di Approve',
				// 		'notifikasi_pesan' => '<b>Temuan Rekomendasi pada Pemeriksaan : </b><br>'.$pmr,
				// 		'notifikasi_link' => 'administrator/input_spi/'.$id_pmr,
				// 		'notifikasi_level' => 'spi',
				// 		'notifikasi_user' => $value
				// 	);
				// 	$this->model_app->insert('tb_notifikasi', $data2);
				// }
				// $this->session->set_flashdata('kirimrekom', 'Temuan Rekomendasi berhasil disetujui');
				// redirect('administrator/input_spi/'.$id_pmr);
			//}else
			//{
				$cek = $this->db->query("SELECT * FROM tb_temuan WHERE temuan_id = '$id_temuan'")->result_array();
				if ($cek[0]['temuan_kirim'] == "N") {
				 	//if ($jenis!="Rutin") {
					//	redirect('administrator/input_spi/'.$id_pmr);
					//}else{
						$this->session->set_flashdata('failedkirim', 'Gagal, Temuan untuk Rekomendasi ini belum dikirim ke Kebun');
						redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
					//}
				}else{
					$jumlah = count($pilih);
					for($x=0;$x<$jumlah;$x++){
						$cek_rkm = $this->model_app->view_where('tb_rekomendasi','rekomendasi_id',$pilih[$x]);
						$cektgl = $cek_rkm[0]['rekomendasi_tgl'];
						$rekom = $cek_rkm[0]['rekomendasi_judul'];
							  $exp = explode("-", $cektgl);
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
		                      $expired = $tgl."-".$bln."-".$thn;
						$ambil = $this->model_app->view_join_where('temuan_id',$id_temuan,'tb_temuan','tb_pemeriksaan','pemeriksaan_id','temuan_id','ASC');
						$temuan = $ambil[0]['temuan_judul'];
						$pmr = $ambil[0]['pemeriksaan_judul'];
						$unit = $ambil[0]['unit_id'];
						$data2 = array(
							'notifikasi_judul' => 'Rekomendasi Baru',
							'notifikasi_pesan' => '<b>Rekomendasi :</b><br>'.$rekom."<br><b>Deadline : ".$expired."</b>",
							'notifikasi_level' => 'operator',
							'notifikasi_unit' => $unit,
							'notifikasi_link' => 'administrator/list_pmr_operator'
						);
						$this->model_app->insert('tb_notifikasi', $data2);
						$data3 = array(
							'notifikasi_judul' => 'Rekomendasi Baru',
							'notifikasi_pesan' => '<b>Rekomendasi :</b><br>'.$rekom."<br><b>Deadline : ".$expired."</b>",
							'notifikasi_level' => 'verifikator',
							'notifikasi_unit' => $unit,
							'notifikasi_link' => 'administrator/list_pmr_verifikator'
						);
						$this->model_app->insert('tb_notifikasi', $data3);
						$this->db->query("UPDATE tb_rekomendasi SET rekomendasi_kirim = 'Y' WHERE rekomendasi_id ='$pilih[$x]'");
					}
					$this->session->set_flashdata('kirimrekom', 'Rekomendasi berhasil disetujui dan dikirim ke Divisi/Regional/Anper');
					redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
				}
			//}
		}
	}
	public function kembalikan_rekomendasi(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);
		$cek = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
		$jenis =  $cek[0]['pemeriksaan_jenis'];
		$data = array('rekomendasi_kirim' => 'K', 'rekomendasi_publish_kabag'=>'N');
		$where = array('rekomendasi_id' => $id_rekom);
		$this->model_app->update('tb_rekomendasi', $data, $where);
		//insert notifikasi
		$ambil = $this->model_app->view_join_where('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','pemeriksaan_id', 'rekomendasi_id','ASC');
		$rekom = $ambil[0]['rekomendasi_judul'];
		$userspi = explode("/", $ambil[0]['pemeriksaan_petugas']);
		//if ($jenis!="Rutin") {
		//	$link = 'administrator/input_spi/'.$id_pmr;
		//}else{
			$link = 'administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan;
		//}
		foreach ($userspi as $key => $value) {
			$data2 = array(
				'notifikasi_judul' => 'Rekomendasi Dikembalikan oleh Kabag',
				'notifikasi_pesan' => '<b>Rekomendasi : </b><br>'.$rekom,
				'notifikasi_level' => 'spi',
				'notifikasi_link' => $link,
				'notifikasi_user' => $value
			);
			$this->model_app->insert('tb_notifikasi', $data2);
		}
		$this->session->set_flashdata('kirimrekom','Rekomendasi berhasil dikembalikan ke SPI');
		//if ($jenis!="Rutin") {
		//	redirect('administrator/input_spi/'.$id_pmr);
		//}else{
			redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
		//}
	}
	public function kirimrekom_tokabag(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);
		$cek = $this->model_app->view_where('tb_temuan','temuan_id',$id_temuan);
		// CEK TEMUAN PADA REKOMENDASI SUDAH DIKIRIM/BELUM
		if ($cek[0]['temuan_publish_kabag']=="N") {
			$this->session->set_flashdata('gagalkirim', 'Gagal, Temuan untuk Rekomendasi ini belum dikirim ke Kabag');
			redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
		}else{
			$data = array('rekomendasi_publish_kabag' => 'Y', 'rekomendasi_kirim' => 'N');
			$where = array('rekomendasi_id' => $id_rekom);
			$this->model_app->update('tb_rekomendasi', $data, $where);
			//insert notifikasi
				$ambil = $this->model_app->view_join_where('temuan_id',$id_temuan,'tb_temuan','tb_pemeriksaan','pemeriksaan_id','temuan_id','ASC');
				$temuan = $ambil[0]['temuan_judul'];
				$pmr = $ambil[0]['pemeriksaan_judul'];
				$unit = $ambil[0]['unit_id'];
				$jenis = $ambil[0]['pemeriksaan_jenis'];
				//if ($jenis!="Rutin") {
					//$link = 'administrator/input_spi/'.$id_pmr;
				//}else{
					$link = 'administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan;
				//}
				$data2 = array(
					'notifikasi_judul' => 'Rekomendasi Perlu di Approve',
					'notifikasi_pesan' => '<b>Rekomendasi pada Temuan :</b><br>'.$temuan,
					'notifikasi_level' => 'kabagspi',
					'notifikasi_link' => $link
				);
				$this->model_app->insert('tb_notifikasi', $data2);
			
			//if ($jenis!="Rutin") {
				//$this->session->set_flashdata('kirimrekom_tokabag', 'Temuan Rekomendasi berhasil dikirim ke Kabag');
			//	redirect('administrator/input_spi/'.$id_pmr);
			//}else{
				$this->session->set_flashdata('kirimrekom_tokabag', 'Rekomendasi berhasil dikirim ke Kadiv DSPI');
				redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
			//}
		}
	}
	public function multikirimrekom_tokabag(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		if (isset($_POST['kirim'])) {
			$pilih = $this->input->post('select');
			if ($pilih==null) {
				redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
			}
			$cek = $this->db->query("SELECT * FROM tb_temuan WHERE temuan_id = '$id_temuan'")->result_array();
			// echo $cek[0]['temuan_publish_kabag']; die();
			if ($cek[0]['temuan_publish_kabag'] == "N") {
			 	$this->session->set_flashdata('gagalkirim', 'Gagal, Temuan untuk Rekomendasi ini belum dikirim ke Kabag');
			 	redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
			 }else{
				$jumlah = count($pilih);
				for($x=0;$x<$jumlah;$x++){
					$this->db->query("UPDATE tb_rekomendasi SET rekomendasi_publish_kabag = 'Y', rekomendasi_kirim = 'N' WHERE rekomendasi_id ='$pilih[$x]'");
				}
				//insert notifikasi
				$ambil = $this->model_app->view_join_where('temuan_id',$id_temuan,'tb_temuan','tb_pemeriksaan','pemeriksaan_id','temuan_id','ASC');
				$temuan = $ambil[0]['temuan_judul'];
				$pmr = $ambil[0]['pemeriksaan_judul'];
				$unit = $ambil[0]['unit_id'];
				$data2 = array(
					'notifikasi_judul' => 'Rekomendasi Perlu di Approve',
					'notifikasi_pesan' => '<b>Rekomendasi pada Temuan :</b><br>'.$temuan,
					'notifikasi_level' => 'kabagspi',
					'notifikasi_link' => 'administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan
				);
				$this->model_app->insert('tb_notifikasi', $data2);
				$this->session->set_flashdata('kirimrekom_tokabag', 'Rekomendasi berhasil dikirim ke Kadiv DSPI');
				redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
			}
		}
	}
	public function multikirim_temuanrekom_tokabag(){
		$id_pmr = $this->uri->segment(3);
		if (isset($_POST['kirim'])) {
			$pilih = $this->input->post('select');
			if ($pilih==null) {
				redirect('administrator/input_spi/'.$id_pmr);
			}
			$jumlah = count($pilih);
			for ($i=0; $i < $jumlah; $i++) { 
				$this->db->query("UPDATE tb_rekomendasi SET rekomendasi_publish_kabag = 'Y', rekomendasi_kirim = 'N' WHERE rekomendasi_id ='$pilih[$i]'");
			}
			//insert notifikasi
			$ambil = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
			$pmr = $ambil[0]['pemeriksaan_judul']; 
			$data2 = array(
				'notifikasi_judul' => 'Rekomendasi dan Temuan Perlu di Approve',
				'notifikasi_pesan' => '<b>Temuan Rekomendasi pada Pemeriksaan :</b><br>'.$pmr,
				'notifikasi_level' => 'kabagspi',
				'notifikasi_link' => 'administrator/input_spi/'.$id_pmr
			);
			$this->model_app->insert('tb_notifikasi', $data2);
			$this->session->set_flashdata('kirimrekom_tokabag', 'Rekomendasi berhasil dikirim ke Kadiv DSPI');
			redirect('administrator/input_spi/'.$id_pmr);
		}	
	}

	public function edit_status_rekom(){
		$id_pmr = $this->uri->segment(3);
		if (isset($_POST['kirim'])) {
			$data = array('rekomendasi_status'=> $this->input->post('status'));
			$status = $this->input->post('status');
			if ($status=='Dikembalikan' OR $status=="Sudah TL (Belum Optimal)") {
				$id_rekom = $this->input->post('id');
				$this->db->query("UPDATE tb_tl SET tl_status_from_spi='Y' WHERE rekomendasi_id='$id_rekom'");
			}
			$where = array('rekomendasi_id' => $this->input->post('id'));
			$this->model_app->update('tb_rekomendasi', $data , $where);
			redirect('administrator/view_temuan/'.$id_pmr);
		}
	}

	//CLOSE REKOMENDASI
	public function close_rekomendasi(){
		$id_pmr = $this->uri->segment(3);
		$id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);
		$data = array(	'rekomendasi_status' => 'Closed',
						'rekomendasi_status_cache' => 'Closed'
		);
		$this->model_app->update('tb_rekomendasi',$data, array('rekomendasi_id'=>$id_rekom));
		$ambil = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
		$rekom = $this->model_app->view_where('tb_rekomendasi','rekomendasi_id',$id_rekom);
		$rekom = $rekom[0]['rekomendasi_judul'];
		$userspi = explode("/", $ambil[0]['pemeriksaan_petugas']);
		foreach ($userspi as $key => $value) {
			$data2 = array(
				'notifikasi_judul' => 'Rekomendasi di Close',
				'notifikasi_pesan' => '<b>Rekomendasi : </b><br>'.$rekom,
				'notifikasi_link' => 'administrator/view_temuan/'.$id_pmr,
				'notifikasi_level' => 'spi',
				'notifikasi_user' => $value
			);
			$this->model_app->insert('tb_notifikasi', $data2);
		}
		$this->session->set_flashdata('berhasil', 'Rekomendasi berhasil di Close');
		redirect('administrator/view_temuan/'.$id_pmr);
	}

	public function upload_rekomendasi(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);
		$data['record'] = $this->model_app->view_join_two_limit('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC','1');
		$this->template->load('template','kelola-rekomendasi/upload_rekomendasi', $data);
	}
	public function uploadfile_rekom(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);
		$config['upload_path'] = 'asset/file_rekomendasi/';
		$config['allowed_types'] = 'jpg|png|jpeg|JPG|JPEG|pdf|doc|docx|xls|xlsx|odt|';
		$config['max_size'] = '25000'; // kb
		$this->load->library('upload', $config);
		if($this->upload->do_upload('userfile')){
			$token=$this->input->post('token_foto');
			$nama=$this->upload->data('file_name');
			$this->db->insert('tb_upload_rekom',array('uploadrekom_nama'=>$nama,'token'=>$token, 'uploadrekom_tgl'=> date('Ymd'), 'rekomendasi_id' => $id_rekom));
		}
		redirect('administrator/list_rekomendasi/'.$id_pmr.'/'.$id_temuan);
	}
	public function remove_file_rekom(){
		$token=$this->input->post('token');
		$cek = $this->model_app->view_where('tb_upload_rekom','token',$token);
		$namafile = $cek[0]['uploadrekom_nama'];
		$path = 'asset/file_rekomendasi/'.$namafile;
		unlink($path);
		$this->db->delete('tb_upload_rekom',array('token'=>$token));
		
		echo "{}";
	}
	public function hapus_file_rekom(){
		$id=$this->input->post('kode');
		$cek = $this->model_app->view_where('tb_upload_rekom','uploadrekom_id',$id);
		$namafile = $cek[0]['uploadrekom_nama'];
		$path = 'asset/file_rekomendasi/'.$namafile;
		unlink($path);
		$data=$this->model_app->hapus_file_rekom($id);
		echo json_encode($data);
	}
	function get_file_rekom(){
		$id=$this->input->get('id');
		$data=$this->model_app->get_file_by_id($id);
		echo json_encode($data);
	}
	public function edit_file_rekom(){
		$id = $this->input->post('file_id');
		$filee = $this->input->post('filee');
		$tgl = date('Ymd');
		$config['upload_path'] = 'asset/file_rekomendasi/';
        $config['allowed_types'] = 'jpg|png|JPG|JPEG|pdf|doc|docx|xls|xlsx|odt|';
        $config['max_size'] = '25000'; // kb
        $this->load->library('upload', $config);
        $filename="";
        if($this->upload->do_upload('userfile')){
             $k = $this->upload->data();
             $filename = $k['file_name'];
        }
		$data=$this->model_app->edit_file($id,$filee,$tgl);
		echo json_encode($data);
	}
	public function tampil_file_rekom(){
		$id_rekom = $this->uri->segment(3);
		$data = $this->model_app->view_where('tb_upload_rekom','rekomendasi_id',$id_rekom);
		echo json_encode($data);
	}
	public function tampil_readmore_rekom(){
		$id_rekom = $this->uri->segment(3);
		$data = $this->model_app->view_where('tb_rekomendasi','rekomendasi_id', $id_rekom);
		$data = $data[0]['rekomendasi_judul'];
		echo json_encode($data);
	}


	public function list_tl(){
		if ($this->uri->segment(6)!=null) {
			$id = $this->uri->segment(6);
			$this->db->query("UPDATE tb_notifikasi SET notifikasi_dibaca='Y' WHERE notifikasi_id='$id'");
		}
		$id_rekom = $this->uri->segment(5);
		$id_temuan = $this->uri->segment(4);
		$data['record'] = $this->model_app->view_join_three('rekomendasi_id',$id_rekom,'tb_tl','tb_pemeriksaan','tb_temuan','tb_rekomendasi','pemeriksaan_id','temuan_id','rekomendasi_id','tl_id','ASC');
		$data['record2'] = $this->model_app->view_join_two_limit('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC','1');
		$this->template->load('template','kelola-tl/list_tl', $data);
	}
	public function list_tl_verifikator(){
		$id_rekom = $this->uri->segment(5);
		$id_temuan = $this->uri->segment(4);
		if ($this->uri->segment(6)!=null) {
			$id_notif = $this->uri->segment(6);
			$this->db->query("UPDATE tb_notifikasi SET notifikasi_dibaca='Y' WHERE notifikasi_id='$id_notif'");
		}
		$con = 'Y';
		$data['record'] = $this->model_app->view_join_three_where2('rekomendasi_id',$id_rekom,'tl_publish_verif',$con,'tb_tl','tb_pemeriksaan','tb_temuan','tb_rekomendasi','pemeriksaan_id','temuan_id','rekomendasi_id','tl_id','ASC');
		$data['record2'] = $this->model_app->view_join_two_limit('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC','1');
		$this->template->load('template','kelola-tl/list_tl_verifikator', $data);	
	}
	public function riwayat_tl(){
		$id_rekom = $this->uri->segment(5);
		$id_temuan = $this->uri->segment(4);
		if ($this->uri->segment(6)!=null) {
			$id_notif = $this->uri->segment(6);
			$this->db->query("UPDATE tb_notifikasi SET notifikasi_dibaca='Y' WHERE notifikasi_id = '$id_notif'");
		}
		$data['record'] = $this->model_app->view_join_three('rekomendasi_id',$id_rekom,'tb_tl','tb_pemeriksaan','tb_temuan','tb_rekomendasi','pemeriksaan_id','temuan_id','rekomendasi_id','tl_id','ASC');
		$data['record2'] = $this->model_app->view_join_two_limit('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC','1');
		$this->template->load('template','kelola-tl/riwayat_tl', $data);
	}
	public function riwayat_tl_vrf(){
		$id_rekom = $this->uri->segment(5);
		$id_temuan = $this->uri->segment(4);
		if ($this->uri->segment(6)!=null) {
			$id_notif = $this->uri->segment(6);
			$this->db->query("UPDATE tb_notifikasi SET notifikasi_dibaca='Y' WHERE notifikasi_id = '$id_notif'");
		}
		$data['record'] = $this->model_app->view_join_three('rekomendasi_id',$id_rekom,'tb_tl','tb_pemeriksaan','tb_temuan','tb_rekomendasi','pemeriksaan_id','temuan_id','rekomendasi_id','tl_id','ASC');
		$data['record2'] = $this->model_app->view_join_two_limit('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC','1');
		$this->template->load('template','kelola-tl/riwayat_tl_vrf', $data);
	}
	public function input_tl(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);
		if ($this->session->level=="operator") {
		$opr = $this->session->username; }else{ $opr = ''; }
		if ($this->session->level=="verifikator") {
		$vrf = $this->session->username; }else{ $vrf = ''; }
		
		if (isset($_POST['submit'])) { //simpan
			if ($this->input->post('tgl')==null) {
				$tanggal = date('Y-m-d');
			}else{
				$tanggal = $this->input->post('tgl');
			}
			$data = array(	'pemeriksaan_id' => $id_pmr,
							'temuan_id' => $id_temuan,
							'rekomendasi_id' => $id_rekom,
							'tl_deskripsi' => $this->input->post('tl'),
							'tl_tgl' => $tanggal,
							'tl_status' => 'Belum di Tindak Lanjut',
							'tl_publish_verif' => 'N',
                            'user_opr' => $opr,
                            'user_vrf' => $vrf,
							'tl_link' =>$this->input->post('link')
			);
			$this->model_app->insert('tb_tl', $data);
			$id_tl = $this->db->insert_id();
			redirect('administrator/upload_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom.'/'.$id_tl);
		}elseif (isset($_POST['kirim'])) { //kirim
			if ($this->input->post('tgl')==null) {
				$tanggal = date('Y-m-d');
			}else{
				$tanggal = $this->input->post('tgl');
			}
			$data = array(	'pemeriksaan_id' => $id_pmr,
							'temuan_id' => $id_temuan,
							'rekomendasi_id' => $id_rekom,
							'tl_deskripsi' => $this->input->post('tl'),
							'tl_tgl' => $tanggal,
							'tl_status' => 'Belum di Tindak Lanjut',
							'tl_publish_verif' => 'Y',
							'user_opr' => $opr,
                            'user_vrf' => $vrf 
			);
			$this->model_app->insert('tb_tl', $data);
			$id_tl = $this->db->insert_id();
			$rekom = $this->model_app->view_where('tb_rekomendasi','rekomendasi_id', $id_rekom);
			$rekom = $rekom[0]['rekomendasi_judul'];
			$data2 = array(
				'notifikasi_judul' => 'Tindak Lanjut',
				'notifikasi_pesan' => $rekom,
				'notifikasi_link' => 'administrator/list_tl_verifikator/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,
				'notifikasi_unit' => $this->session->unit,
				'notifikasi_level' => "verifikator"
			);
			$this->model_app->insert('tb_notifikasi',$data2);
			redirect('administrator/upload_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom.'/'.$id_tl);
		}
		$data['record'] = $this->model_app->view_join_two_limit('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC','1');
		$this->template->load('template','kelola-tl/input_tl', $data);
	}
	public function input_tl_spi(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);
		if (isset($_POST['simpan'])) {
			if ($this->input->post('tgl')==null) {
				$tanggal = date('Y-m-d');
			}else{
				$tanggal = $this->input->post('tgl');
			}
			$data = array(	'pemeriksaan_id' => $id_pmr,
							'temuan_id' => $id_temuan,
							'rekomendasi_id' => $id_rekom,
							'tl_deskripsi' => $this->input->post('tl'),
							'tl_tgl' => $tanggal,
							'tl_status' => $this->input->post('status'),
							'tl_publish_kabag' => 'N'
			);
			$this->model_app->insert('tb_tl', $data);
			$id_tl = $this->db->insert_id();
			$this->model_app->update('tb_rekomendasi',array('rekomendasi_status_cache'=>$this->input->post('status')), array('rekomendasi_id' => $id_rekom));
			redirect('administrator/upload_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom.'/'.$id_tl);
		}elseif (isset($_POST['kirim'])) {
			if ($this->input->post('tgl')==null) {
				$tanggal = date('Y-m-d');
			}else{
				$tanggal = $this->input->post('tgl');
			}
			$data = array(	'pemeriksaan_id' => $id_pmr,
							'temuan_id' => $id_temuan,
							'rekomendasi_id' => $id_rekom,
							'tl_deskripsi' => $this->input->post('tl'),
							'tl_tgl' => $tanggal,
							'tl_status' => $this->input->post('status'),
							'tl_publish_kabag' => 'Y',
							'tl_status_publish_kabag' => 'Y'
			);
			$this->model_app->insert('tb_tl', $data);
			$id_tl = $this->db->insert_id();
			$this->model_app->update('tb_rekomendasi',array('rekomendasi_status_cache'=>$this->input->post('status')), array('rekomendasi_id' => $id_rekom));
			//insert notifikasi 
			$tanggapan = $this->model_app->view_where('tb_tanggapan','rekomendasi_id',$id_rekom);
			$tanggapan = $tanggapan[0]['tanggapan_deskripsi'];
				$data2 = array(
					'notifikasi_judul' => 'Tindak Lanjut terhadap Tanggapan',
					'notifikasi_pesan' => '<b>Tanggapan : </b><br>'.$tanggapan,
					'notifikasi_link'  => 'administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,
					'notifikasi_level' => 'kabagspi'
				);
				$this->model_app->insert('tb_notifikasi',$data2);
			
			redirect('administrator/upload_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom.'/'.$id_tl);
		}
		$data['record'] = $this->model_app->view_join_two_limit('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC','1');
		$this->template->load('template','kelola-tl/input_tl_spi', $data);
	}
	public function tl_sendto_vrf(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5); $id_tl = $this->uri->segment(6);
		$data = array('tl_publish_verif' => 'Y','tl_status_from_vrf' => 'N');
		$where = array('tl_id' => $id_tl);
		$this->model_app->update('tb_tl', $data, $where);
			$rekom = $this->model_app->view_where('tb_rekomendasi','rekomendasi_id', $id_rekom);
			$rekom = $rekom[0]['rekomendasi_judul'];
			$data2 = array(
				'notifikasi_judul' => 'Tindak Lanjut',
				'notifikasi_pesan' => $rekom,
				'notifikasi_link' => 'administrator/list_tl_verifikator/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,
				'notifikasi_unit' => $this->session->unit,
				'notifikasi_level' => "verifikator"
			);
			$this->model_app->insert('tb_notifikasi',$data2);
		$this->session->set_flashdata('berhasil','Tindak Lanjut telah dikirim ke Verifikator');
		redirect('administrator/list_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
	}
	public function tl_sendto_spi(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5); $id_tl = $this->uri->segment(6);
		$data = array('tl_publish_spi' => 'Y', 'user_vrf' => $this->session->username);
		$where = array('tl_id' => $id_tl);
		$this->model_app->update('tb_tl', $data, $where);
			$rekom = $this->model_app->view_where('tb_rekomendasi','rekomendasi_id', $id_rekom);
			$rekom = $rekom[0]['rekomendasi_judul'];
			$user_spi = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
			$user_spi = explode("/", $user_spi[0]['pemeriksaan_petugas']);
			foreach ($user_spi as $key => $value) {
				$data2 = array(
				'notifikasi_judul' => 'Laporan Tindak Lanjut',
				'notifikasi_pesan' => $rekom,
				'notifikasi_link' => 'administrator/detail_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom.'/'.$id_tl,
				'notifikasi_level' => "spi",
				'notifikasi_user' => $value
				);
				$this->model_app->insert('tb_notifikasi',$data2);
			}
		$this->session->set_flashdata('berhasil','Tindak Lanjut telah dikirim ke Petugas SPI');
		redirect('administrator/list_tl_verifikator/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);

	}

	public function upload_tl(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5); $id_tl = $this->uri->segment(6);
		$data['record'] = $this->model_app->view_join_three('tl_id',$id_tl,'tb_tl','tb_pemeriksaan','tb_rekomendasi','tb_temuan','pemeriksaan_id','rekomendasi_id','temuan_id','tl_id','ASC');
		$this->template->load('template','kelola-tl/upload_tl', $data);
	}
	public function uploadfile_tl(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5); $id_tl = $this->uri->segment(6);
		$config['upload_path'] = 'asset/file_tl/';
		$config['allowed_types'] = 'jpg|png|jpeg|JPG|JPEG|pdf|doc|docx|xls|xlsx|odt|';
		$config['max_size'] = '25000'; // kb
		$this->load->library('upload', $config);
		if($this->upload->do_upload('userfile')){
			$token=$this->input->post('token_foto');
			$nama=$this->upload->data('file_name');
			$this->db->insert('tb_upload_tl',array('uploadtl_nama'=>$nama,'token'=>$token, 'uploadtl_tgl'=> date('Ymd'), 'tl_id' => $id_tl));
		}
		redirect('administrator/list_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
	}
	public function remove_file_tl(){
		$token=$this->input->post('token');
		$cek = $this->model_app->view_where('tb_upload_tl','token',$token);
		$namafile = $cek[0]['uploadtl_nama'];
		$path = 'asset/file_tl/'.$namafile;
		unlink($path);
		$this->db->delete('tb_upload_tl',array('token'=>$token));
		
		echo "{}";
	}
	public function hapus_file(){
		$id=$this->input->post('kode');
		$cek = $this->model_app->view_where('tb_upload_tl','uploadtl_id',$id);
		$namafile = $cek[0]['uploadtl_nama'];
		$path = 'asset/file_tl/'.$namafile;
		unlink($path);
		$data=$this->model_app->hapus_file($id);
		echo json_encode($data);
	}
	function get_file(){
		$id=$this->input->get('id');
		$data=$this->model_app->get_file_by_id($id);
		echo json_encode($data);
	}
	public function edit_file(){
		$id = $this->input->post('file_id');
		$filee = $this->input->post('filee');
		$tgl = date('Ymd');
		$config['upload_path'] = 'asset/file_tl/';
        $config['allowed_types'] = 'jpg|png|JPG|JPEG|pdf|doc|docx|xls|xlsx|odt|';
        $config['max_size'] = '25000'; // kb
        $this->load->library('upload', $config);
        $filename="";
        if($this->upload->do_upload('userfile')){
             $k = $this->upload->data();
             $filename = $k['file_name'];
        }
		$data=$this->model_app->edit_file($id,$filee,$tgl);
		echo json_encode($data);
	}
	
	public function edit_tl(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5); $id_tl = $this->uri->segment(6);
		if ($this->session->level=="operator") {
		$opr = $this->session->username; }else{ $opr = ''; }
		if ($this->session->level=="verifikator") {
		$vrf = $this->session->username; }else{ $vrf = ''; }
		if (isset($_POST['edit'])) {
			$data = array('tl_deskripsi' => $this->input->post('tl'),
						  'tl_tgl' => date('Ymd'),
                          'user_opr' => $opr,
                          'user_vrf' => $vrf,
                          'tl_status_from_vrf' => 'N' 
			);
			$where = array('tl_id' => $this->input->post('id'));
			$this->model_app->update('tb_tl', $data , $where);
			redirect('administrator/list_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
		}elseif(isset($_POST['kirim'])){
			$data = array('tl_deskripsi' => $this->input->post('tl'),
						  'tl_tgl' => date('Ymd'),
						  'tl_publish_verif' => 'Y',
						  'tl_status_from_vrf' => 'N',
                          'user_opr' => $opr,
                          'user_vrf' => $vrf 
			);
			$where = array('tl_id' => $this->input->post('id'));
			$this->model_app->update('tb_tl', $data , $where);
			$rekom = $this->model_app->view_where('tb_rekomendasi','rekomendasi_id', $id_rekom);
			$rekom = $rekom[0]['rekomendasi_judul'];
			$data2 = array(
				'notifikasi_judul' => 'Tindak Lanjut',
				'notifikasi_pesan' => $rekom,
				'notifikasi_link' => 'administrator/list_tl_verifikator/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,
				'notifikasi_unit' => $this->session->unit,
				'notifikasi_level' => "verifikator"
			);
			$this->model_app->insert('tb_notifikasi',$data2);
			redirect('administrator/list_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
		}
		$dataa['record'] = $this->model_app->view_where('tb_tl','tl_id',$id_tl);
		$dataa['record2'] = $this->model_app->view_join_two_limit('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC','1');
		$data = $this->model_app->view_where('tb_upload_tl','tl_id',$id_tl);
		json_encode($data);
		$this->template->load('template','kelola-tl/edit_tl',$dataa);
	}
	public function edit_tl_spi(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5); $id_tl = $this->uri->segment(6);
		if (isset($_POST['edit'])) {
			$data = array('tl_deskripsi' => $this->input->post('tl'),
						  'tl_tgl' => date('Ymd'),
						  'tl_status' => $this->input->post('status')
			);
			$where = array('tl_id' => $this->input->post('id'));
			$this->model_app->update('tb_tl', $data , $where);
			$this->model_app->update('tb_rekomendasi',array('rekomendasi_status_cache'=>$this->input->post('status')), array('rekomendasi_id' => $id_rekom));
			redirect('administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
		}elseif(isset($_POST['kirim'])){
			$data = array('tl_deskripsi' => $this->input->post('tl'),
						  'tl_tgl' => date('Ymd'),
						  'tl_publish_kabag' => 'Y',
						  'tl_status_kirim' => 'N',
						  'tl_status' => $this->input->post('status')
			);
			$where = array('tl_id' => $this->input->post('id'));
			$this->model_app->update('tb_tl', $data , $where);
			$this->model_app->update('tb_rekomendasi',array('rekomendasi_status_cache'=>$this->input->post('status')), array('rekomendasi_id' => $id_rekom));
			//insert notifikasi
			$tanggapan = $this->model_app->view_where('tb_tanggapan','rekomendasi_id',$id_rekom);
			$tanggapan = $tanggapan[0]['tanggapan_deskripsi'];
				$data2 = array(
					'notifikasi_judul' => 'Tindak Lanjut terhadap Tanggapan',
					'notifikasi_pesan' => '<b>Tanggapan Manajer: </b><br>'.$tanggapan,
					'notifikasi_link'  => 'administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,
					'notifikasi_level' => 'kabagspi'
				);
				$this->model_app->insert('tb_notifikasi',$data2);
			redirect('administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
		}
		$dataa['record'] = $this->model_app->view_where('tb_tl','tl_id',$id_tl);
		$dataa['record2'] = $this->model_app->view_join_two_limit('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC','1');
		$data = $this->model_app->view_where('tb_upload_tl','tl_id',$id_tl);
		json_encode($data);
		$this->template->load('template','kelola-tl/edit_tl_spi',$dataa);
	}
	public function kirim_tl_tokabag(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5); $id_tl = $this->uri->segment(6);
		$data = array(
			'tl_status_publish_kabag' => 'Y',
			'tl_status_tgl' => date('Y-m-d'),
			'tl_publish_kabag' => 'Y',
			'tl_status_kirim' => 'N'
		);
		$where = array('tl_id' => $id_tl);
		$this->model_app->update('tb_tl', $data, $where);
		$cek = $this->model_app->view_where('tb_tl', 'tl_id', $id_tl);
		$status = $cek[0]['tl_status'];
		$cek2 = $this->model_app->view_where('tb_rekomendasi', 'rekomendasi_id',$id_rekom);
		if ($cek2[0]['rekomendasi_publish_kabag']=="Y") {
			$data2 = array('rekomendasi_status_cache' => $status);
			$where2 = array('rekomendasi_id' => $id_rekom);
			$this->model_app->update('tb_rekomendasi', $data2, $where2);

			//insert notifikasi 
			$tanggapan = $this->model_app->view_where('tb_tanggapan','rekomendasi_id',$id_rekom);
			$tanggapan = $tanggapan[0]['tanggapan_deskripsi'];
				$data3 = array(
					'notifikasi_judul' => 'Tindak Lanjut terhadap Tanggapan',
					'notifikasi_pesan' => '<b>Tanggapan Manajer: </b><br>'.$tanggapan,
					'notifikasi_link'  => 'administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,
					'notifikasi_level' => 'kabagspi'
				);
				$this->model_app->insert('tb_notifikasi',$data3);
			$this->session->set_flashdata('berhasil','Tindak Lanjut berhasil dikirim ke Kabag');
		}else{
			$this->session->set_flashdata('gagal','Temuan Rekomendasi belum dikirim ke Kabag untuk Tindak Lanjut ini');
		}
		redirect('administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
	}
	public function kirim_tl_kabag(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5); $id_tl = $this->uri->segment(6);
		$data = array('tl_status_kirim' => 'Y');
		$where = array('tl_id' => $id_tl);
		$this->model_app->update('tb_tl', $data, $where);
		$cek = $this->model_app->view_where('tb_tl', 'tl_id', $id_tl);
		$status = $cek[0]['tl_status'];
		$data2 = array('rekomendasi_status' => $status);
		$where2 = array('rekomendasi_id' => $id_rekom);
		$this->model_app->update('tb_rekomendasi',$data2,$where2);
		$cek2 = $this->db->query("SELECT * FROM tb_rekomendasi WHERE rekomendasi_id ='$id_rekom'")->result_array();
		while ($cek2[0]['rekomendasi_pmr_sebelumnya']!=0) {
			$cek2 = $this->db->query("SELECT * FROM tb_rekomendasi WHERE rekomendasi_id ='".$cek2[0]['rekomendasi_pmr_sebelumnya']."'")->result_array();
			$datab = array( 'rekomendasi_status_kirim' => 'Y', 'rekomendasi_status_terbaru' => $status);
			$whereb = array('rekomendasi_id' => $cek2[0]['rekomendasi_id']);
			$this->model_app->update('tb_rekomendasi', $datab, $whereb);

		}
		//insert notifikasi 
		$ambil = $this->model_app->view_where('tb_tl','tl_id',$id_tl);
		$tl = $ambil[0]['tl_deskripsi'];
		$userspi = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
		$userspi = explode("/", $userspi[0]['pemeriksaan_petugas']);
		foreach ($userspi as $key => $value) {
			$data3 = array(
				'notifikasi_judul' => 'Tindak Lanjut telah di Approve',
				'notifikasi_pesan' => '<b>Tindak Lanjut : </b>'.$tl,
				'notifikasi_level' => 'spi',
				'notifikasi_link' => 'administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,
				'notifikasi_user' => $value
			);
			$this->model_app->insert('tb_notifikasi', $data3);
		}
		$this->session->set_flashdata('berhasil','Tindak Lanjut dan Status telah disetujui');
		redirect('administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
	}
	public function kembalikan_tl(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5); $id_tl = $this->uri->segment(6);
		$cek = $this->model_app->view_where('tb_rekomendasi', 'rekomendasi_id', $id_rekom);
		$status = $cek[0]['rekomendasi_status'];
		$data = array(
				'tl_status_kirim' => 'K', 
				'tl_publish_kabag' => 'N',
				'tl_status_publish_kabag' => 'N',
				'tl_status'=>$status);
		$where = array('tl_id' => $id_tl);
		$this->model_app->update('tb_tl', $data, $where);
		$data2 = array('rekomendasi_status_cache' => $status);
		$where2 = array('rekomendasi_id' => $id_rekom);
		$this->model_app->update('tb_rekomendasi', $data2, $where2);
		//insert notifikasi 
		$ambil = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
		$userspi = explode("/", $ambil[0]['pemeriksaan_petugas']);
		$tl = $this->model_app->view_where('tb_tl','tl_id',$id_tl); $tl = $tl[0]['tl_deskripsi'];
		foreach ($userspi as $key => $value) {
			$data3 = array(
				'notifikasi_judul' => 'Tindak Lanjut Dikembalikan Kabag',
				'notifikasi_pesan' => '<b>Tindak Lanjut : </b>'.$tl,
				'notifikasi_level' => 'spi',
				'notifikasi_link' => 'administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,
				'notifikasi_user' => $value
			);
			$this->model_app->insert('tb_notifikasi', $data3);
		}
		$this->session->set_flashdata('berhasil','Tindak Lanjut berhasil dikembalikan ke SPI');
		redirect('administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
	}
	public function tampil_data(){
		$id_tl = $this->uri->segment(3);
		$data = $this->model_app->view_where('tb_upload_tl','tl_id',$id_tl);
		echo json_encode($data);
	}
	public function edit_tl_verifikator(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5); $id_tl = $this->uri->segment(6);

		if ($this->session->level=="operator") {
		$opr = $this->session->username; }else{ $opr = ''; }
		if ($this->session->level=="verifikator") {
		$vrf = $this->session->username; }else{ $vrf = ''; }
		if (isset($_POST['edit'])) {
			$id_tl = $this->input->post('id'); 
			$data = array('tl_deskripsi' => $this->input->post('tl'),
						  'tl_tgl' => date('Ymd'),
						  'tl_publish_spi' => 'Y',
                          'user_vrf' => $vrf
			);
			$where = array('tl_id' => $this->input->post('id'));
			$this->model_app->update('tb_tl', $data , $where);
			$rekom = $this->model_app->view_where('tb_rekomendasi','rekomendasi_id', $id_rekom);
			$rekom = $rekom[0]['rekomendasi_judul'];
			$user_spi = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr);
			$user_spi = explode("/", $user_spi[0]['pemeriksaan_petugas']);
			foreach ($user_spi as $key => $value) {
				$data2 = array(
				'notifikasi_judul' => 'Laporan Tindak Lanjut',
				'notifikasi_pesan' => $rekom,
				'notifikasi_link' => 'administrator/detail_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom.'/'.$id_tl,
				'notifikasi_level' => "spi",
				'notifikasi_user' => $value
				);
				$this->model_app->insert('tb_notifikasi',$data2);
			}
			$this->session->set_flashdata('berhasil','Tindak Lanjut berhasil dikirim ke SPI');
			redirect('administrator/list_tl_verifikator/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
		}elseif (isset($_POST['back'])){
			$id_tl = $this->input->post('id');
			$data = array('tl_publish_verif' => 'N','tl_status_from_vrf' => 'Y', 'user_vrf' => $this->session->username);
			$where = array('tl_id' => $this->input->post('id'));
			$this->model_app->update('tb_tl', $data , $where);
			//insert notifikasi
			$ambil = $this->model_app->view_where('tb_tl','tl_id',$id_tl);
			$tl = $ambil[0]['tl_deskripsi'];
			$data2 = array(
						'notifikasi_judul' => 'Tindak Lanjut Dikembalikan Verifikator',
						'notifikasi_pesan' => '<b>Tindak Lanjut : </b>'.$tl,
						'notifikasi_unit' => $this->session->unit,
						'notifikasi_level' => 'operator',
						'notifikasi_link' => 'administrator/list_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom
				);
			$this->model_app->insert('tb_notifikasi',$data2);
			$this->session->set_flashdata('kembalikan_tl','Tindak Lanjut berhasil dikembalikan ke Operator');
			redirect('administrator/list_tl_verifikator/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
		}elseif(isset($_POST['simpan'])){
			$data = array('tl_deskripsi' => $this->input->post('tl'), 'user_vrf' => $this->session->username
			);
			$where = array('tl_id' => $this->input->post('id'));
			$this->model_app->update('tb_tl', $data , $where);
			redirect('administrator/list_tl_verifikator/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
		}
		$data['record'] = $this->model_app->view_where('tb_tl','tl_id',$id_tl);
		$data['record2'] = $this->model_app->view_join_two_limit('rekomendasi_id',$id_rekom,'tb_rekomendasi','tb_pemeriksaan','tb_temuan','pemeriksaan_id','temuan_id','rekomendasi_id','ASC','1');
		$data['record3'] = $this->model_app->view_where('tb_upload_tl','tl_id',$id_tl);
		$this->template->load('template','kelola-tl/edit_tl_verifikator', $data);
	}
	public function delete_tl(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5);
		$id_tl = array('tl_id' => $this->uri->segment(6));
		$id = $this->uri->segment(6);
		$files = $this->db->query("SELECT uploadtl_nama FROM tb_upload_tl WHERE tl_id = '$id'")->result_array();
		foreach ($files as $nama) {
			$namafile =  $nama['uploadtl_nama'];
			echo $namafile."<br>";
			$path = 'asset/file_tl/'.$namafile;
			unlink($path);
		}
		$this->model_app->delete('tb_tl', $id_tl);
		$this->model_app->delete('tb_upload_tl', $id_tl);
		if ($this->session->level=="operator") {
			redirect('administrator/list_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
		}elseif ($this->session->level=="verifikator") {
			redirect('administrator/list_tl_verifikator/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
		}else{
			redirect('administrator/list_tanggapantl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
		}
		
	}
	public function status_tl(){
		$id_pmr = $this->uri->segment(3);
		if (isset($_POST['kirim'])) {
			$data = array('tl_status'=> $this->input->post('status'),
						  'tl_tanggapan'=> $this->input->post('tanggapan'),
						  'tl_status_publish' => 'Y'
			);
			$status = $this->input->post('status');
			if ($status=='Dikembalikan' OR $status=="Sudah TL (Belum Optimal)") {
				$id_rekom = $this->input->post('id_rekom');
				$this->db->query("UPDATE tb_tl SET tl_status_from_spi='Y' WHERE rekomendasi_id='$id_rekom'");
			}
			$data2 = array('rekomendasi_status' => $status);
			$where2 = array('rekomendasi_id' => $this->input->post('id_rekom'));
			$this->model_app->update('tb_rekomendasi', $data2 , $where2);
			$where = array('tl_id' => $this->input->post('id'));
			$this->model_app->update('tb_tl', $data , $where);
			$this->session->set_flashdata('kirim_tnggp','Tanggapan Anda berhasil dikirim ke Kebun');
			redirect('administrator/view_temuan/'.$id_pmr);
		}elseif (isset($_POST['simpan'])) {
			$data = array('tl_status'=> $this->input->post('status'),
						  'tl_tanggapan'=> $this->input->post('tanggapan'),
						  'tl_status_publish' => 'N'
			);
			$where = array('tl_id' => $this->input->post('id'));
			$this->model_app->update('tb_tl', $data , $where);
			$this->session->set_flashdata('simpan_tnggp','Tanggapan Anda berhasil disimpan dalam Draft');
			redirect('administrator/view_temuan/'.$id_pmr);
		}
	}
	public function status_tl_kirimkabag(){
		$id_pmr = $this->uri->segment(3);
		if (isset($_POST['simpan'])) {
			$data = array( 	'tl_tanggapan' => $this->input->post('tanggapan'), 
							'tl_tanggapan_publish_kabag' => 'N',
							'tl_status_cache' => $this->input->post('status')
						);
			$where = array('tl_id' => $this->input->post('id'));
			$this->model_app->update('tb_tl', $data, $where);
			$data2 = array( 'rekomendasi_status_cache' => $this->input->post('status'), 
							'rekomendasi_status_publish_kabag' => 'N');
			$where2 = array('rekomendasi_id' => $this->input->post('id_rekom'));
			$this->model_app->update('tb_rekomendasi', $data2, $where2);
			$this->session->set_flashdata('simpan_tnggp','Status dan Tanggapan Anda berhasil disimpan');

		}elseif (isset($_POST['kirim'])) {
			$data = array( 	'tl_tanggapan' => $this->input->post('tanggapan'), 
							'tl_tanggapan_publish_kabag' => 'Y', 
							'tl_tanggapan_kirim' => "N",
							'tl_status_publish_kabag' => 'Y',
							'tl_status_kirim' => 'N',
							'tl_status_cache' => $this->input->post('status')
						);
			$where = array('tl_id' => $this->input->post('id'));
			$this->model_app->update('tb_tl', $data, $where);
			$data2 = array( 'rekomendasi_status_cache' => $this->input->post('status'), 
							'rekomendasi_status_publish_kabag' => 'Y');
			$where2 = array('rekomendasi_id' => $this->input->post('id_rekom'));
			$this->model_app->update('tb_rekomendasi', $data2, $where2);

			$tl = $this->model_app->view_where('tb_tl','tl_id',$this->input->post('id'));
			$tl = $tl[0]['tl_deskripsi'];
			$data3 = array(
					'notifikasi_judul' => 'Persetujuan Status dan Tanggapan TL',
					'notifikasi_pesan' => '<b>Status : '.$this->input->post('status').'</b><br>'.$tl,
					'notifikasi_level' => 'kabagspi',
					'notifikasi_link' => 'administrator/view_temuan/'.$id_pmr
				);
			$this->model_app->insert('tb_notifikasi',$data3);
			$this->session->set_flashdata('kirim_tnggp','Tanggapan Anda berhasil dikirim ke Kadiv');
		}
		redirect('administrator/view_temuan/'.$id_pmr);
	}
	public function edit_statustl_kabag(){
		$id_pmr = $this->uri->segment(3); 
		if (isset($_POST['simpan'])) {
			$id_rekom = $this->input->post('id_rekom');
			$id_tl = $this->input->post('id');
			$data= array(
				'tl_status_cache' => $this->input->post('status'),
				'tl_tanggapan' => $this->input->post('tanggapan')
			);
			$where = array('tl_id' => $id_tl);
			$this->model_app->update('tb_tl', $data, $where);
			$data2 = array('rekomendasi_status_cache' => $this->input->post('status'));
			$where2 = array('rekomendasi_id' => $id_rekom);
			$this->model_app->update('tb_rekomendasi', $data2, $where2);
			$this->session->set_flashdata('simpan_tnggp','Status dan Tanggapan berhasil disimpan');
			redirect('administrator/view_temuan/'.$id_pmr);
		}elseif (isset($_POST['kirim'])) {
			$id_temuan = $this->input->post('id_temuan');
			$id_rekom = $this->input->post('id_rekom');
			$id_tl = $this->input->post('id');
			$cek_tl = $this->db->query("SELECT * FROM tb_tl WHERE tl_id ='$id_tl'")->result_array();
			$status_tl = $cek_tl[0]['tl_status_cache'];

			$data = array('tl_tanggapan_kirim' => 'Y' ,'tl_status_kirim' => 'Y' ,'tl_status' => $status_tl, 'tl_status_tgl' => date('Y-m-d'));
			$where = array('tl_id' => $id_tl);
			$this->model_app->update('tb_tl', $data, $where);
			$cek = $this->db->query("SELECT * FROM tb_rekomendasi WHERE rekomendasi_id ='$id_rekom'")->result_array();
			$status = $cek[0]['rekomendasi_status_cache'];
				$data2 = array( 'rekomendasi_status_kirim' => 'Y', 'rekomendasi_status' => $status);
				$where2 = array('rekomendasi_id' => $id_rekom);
				$this->model_app->update('tb_rekomendasi', $data2, $where2);
				while ($cek[0]['rekomendasi_pmr_sebelumnya']!=0) {
					$cek = $this->db->query("SELECT * FROM tb_rekomendasi WHERE rekomendasi_id ='".$cek[0]['rekomendasi_pmr_sebelumnya']."'")->result_array();
					$data2 = array( 'rekomendasi_status_kirim' => 'Y', 'rekomendasi_status_terbaru' => $status);
					$where2 = array('rekomendasi_id' => $cek[0]['rekomendasi_id']);
					$this->model_app->update('tb_rekomendasi', $data2, $where2);

				}
			//insert notifikasi
			$tanggapan = $this->model_app->view_where('tb_tl','tl_id',$id_tl);
			$tanggapan = $tanggapan[0]['tl_tanggapan'];
			if ($tanggapan==null) {
				$tanggapan = "-";
			}
			$unit = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr); $unit = $unit[0]['unit_id'];
			$data3 = array(
				'notifikasi_judul' => 'Status dan Tanggapan untuk TL',
				'notifikasi_pesan' => '<b>Status : '.$status.'<br>Tanggapan : </b><br>'.$tanggapan,
				'notifikasi_link' => 'administrator/riwayat_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,
				'notifikasi_level' => 'operator',
				'notifikasi_unit' => $unit
			);
			$this->model_app->insert('tb_notifikasi',$data3);
			$data4 = array(
				'notifikasi_judul' => 'Status dan Tanggapan untuk TL',
				'notifikasi_pesan' => '<b>Status : '.$status.'<br>Tanggapan : </b><br>'.$tanggapan,
				'notifikasi_link' => 'administrator/riwayat_tl_vrf/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,
				'notifikasi_level' => 'verifikator',
				'notifikasi_unit' => $unit
			);
			$this->model_app->insert('tb_notifikasi',$data4);
			$this->session->set_flashdata('kirimtanggapan','Status dan Tanggapan berhasil dikirim ke Kebun');
			redirect('administrator/view_temuan/'.$id_pmr);
		}
	} 
	public function kirim_tanggapan(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5); $id_tl = $this->uri->segment(6);
		$cek_tl = $this->db->query("SELECT * FROM tb_tl WHERE tl_id ='$id_tl'")->result_array();
		$status_tl = $cek_tl[0]['tl_status_cache'];

		$data = array('tl_tanggapan_kirim' => 'Y' ,'tl_status_kirim' => 'Y' ,'tl_status' => $status_tl, 'tl_status_tgl' => date('Y-m-d'));
		$where = array('tl_id' => $id_tl);
		$this->model_app->update('tb_tl', $data, $where);
		$cek = $this->db->query("SELECT * FROM tb_rekomendasi WHERE rekomendasi_id ='$id_rekom'")->result_array();
		$status = $cek[0]['rekomendasi_status_cache'];

		// $pmr_sebelumnya = $cek['rekomendasi_pmr_sebelumnya'];
			$data2 = array( 'rekomendasi_status_kirim' => 'Y', 'rekomendasi_status' => $status);
			$where2 = array('rekomendasi_id' => $id_rekom);
			$this->model_app->update('tb_rekomendasi', $data2, $where2);
		while ($cek[0]['rekomendasi_pmr_sebelumnya']!=0) {
			$cek = $this->db->query("SELECT * FROM tb_rekomendasi WHERE rekomendasi_id ='".$cek[0]['rekomendasi_pmr_sebelumnya']."'")->result_array();
			$data2 = array( 'rekomendasi_status_kirim' => 'Y', 'rekomendasi_status_terbaru' => $status);
			$where2 = array('rekomendasi_id' => $cek[0]['rekomendasi_id']);
			$this->model_app->update('tb_rekomendasi', $data2, $where2);

		}
			//insert notifikasi
			$tanggapan = $this->model_app->view_where('tb_tl','tl_id',$id_tl);
			$tanggapan = $tanggapan[0]['tl_tanggapan'];
			if ($tanggapan==null) {
				$tanggapan = "-";
			}
			$unit = $this->model_app->view_where('tb_pemeriksaan','pemeriksaan_id',$id_pmr); $unit = $unit[0]['unit_id'];
			$data3 = array(
				'notifikasi_judul' => 'Status dan Tanggapan untuk TL',
				'notifikasi_pesan' => '<b>Status : '.$status.'<br>Tanggapan : </b><br>'.$tanggapan,
				'notifikasi_link' => 'administrator/riwayat_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,
				'notifikasi_level' => 'operator',
				'notifikasi_unit' => $unit
			);
			$this->model_app->insert('tb_notifikasi',$data3);
			$data4 = array(
				'notifikasi_judul' => 'Status dan Tanggapan untuk TL',
				'notifikasi_pesan' => '<b>Status : '.$status.'<br>Tanggapan : </b><br>'.$tanggapan,
				'notifikasi_link' => 'administrator/riwayat_tl_vrf/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom,
				'notifikasi_level' => 'verifikator',
				'notifikasi_unit' => $unit
			);
			$this->model_app->insert('tb_notifikasi',$data4);
		$this->session->set_flashdata('kirimtanggapan','Tanggapan SPI berhasil dikirim ke Regional/Divisi');
		redirect('administrator/view_temuan/'.$id_pmr);
	}
	public function kembalikan_tanggapan(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4);
		$id_rekom = $this->uri->segment(5); $id_tl = $this->uri->segment(6);
		$cek_tl = $this->db->query("SELECT * FROM tb_tl WHERE tl_id ='$id_tl'")->result_array();
		$status_tl = $cek_tl[0]['tl_status'];
		$data = array('tl_tanggapan_publish_kabag' => 'N', 'tl_tanggapan_kirim'=>'K', 'tl_status_publish_kabag' => 'N','tl_status_kirim' => 'K','tl_status_cache' => $status_tl);
		$where = array('tl_id' => $id_tl);
		$this->model_app->update('tb_tl', $data, $where);
		$cek = $this->db->query("SELECT * FROM tb_rekomendasi WHERE rekomendasi_id ='$id_rekom'")->result_array();
		// print_r($cek); 
		$status = $cek[0]['rekomendasi_status'];			
		$data2 = array( 'rekomendasi_status_kirim' => 'N', 'rekomendasi_status_publish_kabag' => 'N','rekomendasi_status_cache' => $status);
			$where2 = array('rekomendasi_id' => $id_rekom);
			$this->model_app->update('tb_rekomendasi', $data2, $where2);
			//insert notifikasi
			$tl = $this->model_app->view_where('tb_tl','tl_id',$id_tl);
			$tl = $tl[0]['tl_deskripsi'];
			$user_spi = $this->model_app->view_where('tb_pemeriksaan', 'pemeriksaan_id', $id_pmr);
			$user_spi = explode("/", $user_spi[0]['pemeriksaan_petugas']);
			foreach ($user_spi as $key => $value) {
				$data3 = array(
					'notifikasi_judul' => 'Status dan Tanggapan Dikembalikan',
					'notifikasi_pesan' => '<b>Status : '.$this->input->post('status').'</b><br>'.$tl,
					'notifikasi_level' => 'spi',
					'notifikasi_user' => $value,
					'notifikasi_link' => 'administrator/view_temuan/'.$id_pmr
				);
				$this->model_app->insert('tb_notifikasi',$data3);
			}
			
		$this->session->set_flashdata('kembalikantanggapan','Tanggapan SPI dikembalikan');
		redirect('administrator/view_temuan/'.$id_pmr);	
	}
	public function detail_tl(){
		$id_pmr = $this->uri->segment(3);
		$id_tl = $this->uri->segment(6);
		if ($this->uri->segment(7)!=null) {
			$id_notif = $this->uri->segment(7);
			$this->db->query("UPDATE tb_notifikasi SET notifikasi_dibaca='Y' WHERE notifikasi_id = '$id_notif'");
		}
		$data['record'] = $this->model_app->view_join_three('tl_id',$id_tl,'tb_tl','tb_pemeriksaan','tb_temuan','tb_rekomendasi','pemeriksaan_id','temuan_id','rekomendasi_id','tl_id','ASC');
		$data['record2'] = $this->model_app->view_where('tb_upload_tl','tl_id',$id_tl);
		$cek = $this->model_app->view_where('tb_pemeriksaan', 'pemeriksaan_id', $id_pmr);
		$jenis = $cek[0]['pemeriksaan_jenis'];
		//if ($jenis!="Rutin") {
		//	$this->template->load('template','kelola-pemeriksaan/detail_tlspi', $data);
		//}else{
			$this->template->load('template','kelola-pemeriksaan/detail_tl', $data);
		//}
	}

	public function pesan(){
		$this->load->view('pesan');
	}
	
	function search_nama(){
            $search_nama = $this->input->get('user_nama');
            $data = $this->model_app->get_nama($search_nama, 'user_nik');
            echo json_encode($data);
    }
	public function list_user(){
		$nik = $this->uri->segment(3);
		$data['record'] = $this->model_app->view_join('tb_users','tb_role','role_id','user_nik','ASC');
		$data['record2'] = $this->model_app->view_where_ordering('user_nik','tb_users',$nik,'user_nik','ASC');
		$this->template->load('template','kelola-user/list_user', $data);
	}
	public function input_user(){
		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('nik','NIK','trim|required');
			$this->form_validation->set_rules('nama','Nama','trim|required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
			$cek = $this->model_app->vieW_where('tb_users','user_nik',$this->input->post('nik'));
			if ($this->form_validation->run()==FALSE) {
				$data['main_content'] = 'administrator/input_user';
            	$this->session->set_flashdata('gagal', 'Password tidak cocok!');
            	$data['record'] = $this->model_app->view_ordering('tb_role', 'role_id', 'ASC'); 
            	$data['record2'] = $this->model_app->view_ordering('tb_unit','unit_id','ASC');
            	$this->template->load('template','kelola-user/tambah_user', $data);				
			}elseif (!empty($cek)) {
				$data['main_content'] = 'administrator/input_user';
            	$this->session->set_flashdata('x', 'NIK telah terdaftar sebagai akun!');
            	$data['record'] = $this->model_app->view_ordering('tb_role', 'role_id', 'ASC');
            	$data['record2'] = $this->model_app->view_ordering('tb_unit','unit_id','ASC'); 
            	$this->template->load('template','kelola-user/tambah_user', $data);		
			}else{
				$data = array('user_nik' 	=> $this->input->post('nik'),
						  'user_nama'	=> $this->input->post('nama'),
						  'user_email'	=> $this->input->post('email'),
						  'user_password'	=> md5($this->input->post('password')),
						  'user_level'  => $this->input->post('level'),
						  'unit_id'	=> $this->input->post('unit'),
						  'role_id' => $this->input->post('role')
				);
				$this->model_app->insert('tb_users', $data);
				redirect('administrator/list_user');
			}
		}else{
			$dataa['record2'] = $this->model_app->view_ordering('tb_unit','unit_id','ASC');
			$dataa['record'] = $this->model_app->view_ordering('tb_role', 'role_id', 'ASC'); 
			$this->template->load('template','kelola-user/tambah_user', $dataa);	
		}
		
	}
	public function edit_user(){
		$nik = $this->uri->segment(3);
		if (isset($_POST['edit'])) {
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');		
			if ($this->input->post('password')!=null) {
				if ($this->form_validation->run()==FALSE) {
				$data['main_content'] = 'administrator/edit_user';
            	$this->session->set_flashdata('gagal', 'Password tidak cocok!');
            	redirect('administrator/edit_user/'.$nik, $data);				
				}
				$data = array(
						  'user_nik' => $this->input->post('nik'),
						  'user_nama'	=> $this->input->post('nama'),
						  'user_email'	=> $this->input->post('email'),
						  'user_password'	=> md5($this->input->post('password')),
						  'user_level'  => $this->input->post('level'),
						  'user_count' => $this->input->post('ganti'),
						  'unit_id'	=> $this->input->post('unit'),
						  'role_id'  => $this->input->post('role')
				);
				$where = array('user_nik' => $this->input->post('id'));
				$this->model_app->update('tb_users', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi User berhasil di Update!');
				redirect('administrator/list_user');
			}else{
				$data = array(
						  'user_nik' => $this->input->post('nik'),
						  'user_nama'	=> $this->input->post('nama'),
						  'user_email'	=> $this->input->post('email'),
						  'user_level'  => $this->input->post('level'),
						  'unit_id'	=> $this->input->post('unit'),
						  'role_id'  => $this->input->post('role')
				);
				$where = array('user_nik' => $this->input->post('id'));
				$this->model_app->update('tb_users', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi User berhasil di Update!');
				redirect('administrator/list_user');
			}
				
		}else{
		$data['record'] = $this->model_app->view_join_where('user_nik',$nik,'tb_users','tb_role','role_id','user_nik','ASC');;
		$data['record2'] = $this->db->query('SELECT * FROM tb_role ORDER BY role_id')->result_array();
		$data['record3'] = $this->model_app->view_ordering('tb_unit','unit_id','ASC');
		$this->template->load('template','kelola-user/edit_user', $data);
		}
	}
	public function delete_user(){
		$id_user = $this->uri->segment(3);
		$user_id = array('user_nik' => $this->uri->segment(3));
		$user = $this->model_app->view_ordering('tb_pemeriksaan','pemeriksaan_id','ASC');
		$spi = []; $userspi = [];
		foreach ($user as $key => $value) {
			$spi[] = explode("/", $value['pemeriksaan_petugas']);
		}
		foreach ($spi as $key => $value) {
			foreach ($value as $k => $v) {
				$userspi[] = $v;
			}
		}
		if (in_array($id_user, $userspi)) {
			$user = 1;
		}else{
			$user = 0;
		}
		$user1 = $this->model_app->view_select_where('user_opr','tb_tl','user_opr',$id_user);
		$user2 = $this->model_app->view_select_where('user_vrf','tb_tl','user_vrf',$id_user);
		$user3 = $this->model_app->view_select_where('user_nik','tb_rekomendasi','user_nik',$id_user);
		$user4 = $this->model_app->view_select_where('user_nik','tb_temuan','user_nik',$id_user);
		$user5 = $this->model_app->view_select_where('user_nik','tb_pemeriksaan','user_nik',$id_user);
		$user6 = $this->model_app->view_select_where('user_nik','tb_tanggapan','user_nik',$id_user);
		if ($user!=0 OR !empty($user1) OR !empty($user2 ) OR !empty($user3) OR !empty($user4) OR !empty($user5) OR !empty($user6)) {
			$this->session->set_flashdata('gagal','Gagal Menghapus, User pernah melakukan pemeriksaan!');
			redirect('administrator/list_user');
		}else{
			$this->session->set_flashdata('berhasil', '1 User Berhasil dihapus');
			$this->model_app->delete('tb_users', $user_id);
			redirect('administrator/list_user');
		}
	}
	public function role_user(){
		$data['record'] = $this->model_app->view_ordering('tb_role','role_id','DESC');
		$data['record2'] = $this->model_app->view_ordering('tb_hakakses','hakakses_id','ASC');
		$this->template->load('template','kelola-user/role_user', $data);
	}
	public function input_role(){
		if (isset($_POST['submit'])) {
			$cek = $this->model_app->view_where('tb_role','role_nama',$this->input->post('nama'));
			if (!empty($cek)) {
				$this->session->set_flashdata('gagal','Nama Role telah digunakan ! Coba dengan nama lain');
				redirect('administrator/role_user');
			}
			$cekbox = $this->input->post('akses');
			$hakakses = ",".implode(",", $cekbox).",";
			$data = array(
					'role_nama' => $this->input->post('nama'),
					'role_tgl' => date('Ymd'),
					'role_akses' => $hakakses
			);
			$this->model_app->insert('tb_role', $data);
			redirect('administrator/role_user');
		}
	}
	public function edit_role(){
		if (isset($_POST['edit'])) {
			$cekbox = $this->input->post('p');
			$hakakses = ",".implode(",", $cekbox).",";
			$data = array(
					'role_nama' => $this->input->post('nama'),
					'role_tgl' => date('Ymd'),
					'role_akses' => $hakakses
			);
			$where = array('role_id' => $this->input->post('id'));
			$this->model_app->update('tb_role', $data , $where);
			redirect('administrator/role_user');
		}
	}
	public function delete_role(){
		$id_role = $this->uri->segment(3);
		$role_id = array('role_id' => $this->uri->segment(3));
		$user = $this->model_app->view_select_where('user_nik','tb_users','role_id',$id_role);
		if (!empty($user)) {
			$this->session->set_flashdata('gagal','Gagal Menghapus, Ada user yang menggunakan role ini!');
			redirect('administrator/role_user');
		}else{
			$this->session->set_flashdata('berhasil','Role berhasil dihapus!');
			$this->model_app->delete('tb_role', $role_id);
			redirect('administrator/role_user');
			
		}
	}
	public function status_user(){
        if ($this->uri->segment(4)=='Y'){
            $data = array('user_aktif'=>'N');
        }else{
            $data = array('user_aktif'=>'Y');
        }
        $where = array('user_nik' => $this->uri->segment(3));
        $this->model_app->update('tb_users', $data, $where);
        redirect('administrator/list_user');
    }
	public function list_pkpt(){
		if(isset($_REQUEST['tahun'])){
			$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Ambil tahun dari select
			$query = $this->db->query("
				SELECT pkpt_id, jenis_audit, bulan, jumlah 
				FROM tb_pkpt  
				WHERE tahun = $tahun
				ORDER BY FIELD(jenis_audit, 'Rutin', 'Khusus', 'Tematik')
			");
			$data['bulan'] = [
				'Januari', 'Februari', 'Maret', 'April', 'Mei', 
				'Juni', 'Juli', 'Agustus', 'September', 
				'Oktober', 'November', 'Desember'
			];
			$data['pkpt'] = $query->result_array();
			$data['tahun'] = $tahun; // Kirim tahun ke view
			$this->template->load('template','kelola-pkpt/list_pkpt', $data);
		}else{
			// Buat array bulan dalam urutan yang benar
			$data['bulan'] = [
				'Januari', 'Februari', 'Maret', 'April', 'Mei', 
				'Juni', 'Juli', 'Agustus', 'September', 
				'Oktober', 'November', 'Desember'
			];
			$data['pkpt'] = $this->model_app->get_data_pivot('tb_pkpt');

			$this->template->load('template','kelola-pkpt/list_pkpt', $data);
		}
	}
	public function input_pkpt(){
		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('audit','audit','trim|required');
			$this->form_validation->set_rules('bulan','bulan','trim|required');
			$this->form_validation->set_rules('jumlah','jumlah','trim|required');
			$data = array('jenis_audit' => $this->input->post('audit'),
						'bulan'			=> $this->input->post('bulan'),
						'jumlah'		=> $this->input->post('jumlah'),
						'tahun'			=> $this->input->post('tahun')
			);
				$this->model_app->insert('tb_pkpt', $data);
				redirect('administrator/list_pkpt');
		}else{
			$this->template->load('template','kelola-pkpt/tambah_pkpt');	
		}
		
	}
	public function edit_pkpt(){
		$id_pkpt = $this->uri->segment(3);
		if (isset($_POST['edit'])) {
			$this->form_validation->set_rules('audit','audit','trim|required');
			$this->form_validation->set_rules('bulan','bulan','trim|required');
			$this->form_validation->set_rules('jumlah','jumlah','trim|required');

			$data = array('jenis_audit' => $this->input->post('audit'),
						'bulan'			=> $this->input->post('bulan'),
						'jumlah'		=> $this->input->post('jumlah')
			);
			$where = array('pkpt_id' => $this->input->post('id_pkpt'));
				$this->model_app->update('tb_pkpt', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi User berhasil di Update!');
				redirect('administrator/list_pkpt');
				
		}
		else{
		$data['pkpt'] = $this->db->query('SELECT * FROM tb_pkpt WHERE pkpt_id = ? ORDER BY jenis_audit', array($id_pkpt))->result_array();
		$this->template->load('template','kelola-pkpt/edit_pkpt', $data);
		}
	}
	
	public function edit_profile(){
		$nik = $this->uri->segment(3);
		if (isset($_POST['edit'])) {
			$config['upload_path'] = 'asset/foto_user/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '25000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('file');
            $hasil=$this->upload->data();
            if ($hasil['file_name']=="") {
            	$data = array ( 'user_nama' => $this->input->post('nama_user'),
							'user_email' => $this->input->post('email_user'),
							'user_tlp' =>$this->input->post('tlp_user')
				);
            }else{
            	$ambil = $this->model_app->view_where('tb_users','user_nik',$nik);
            	$namafile = $ambil[0]['user_foto'];
            	$data = array ( 'user_nama' => $this->input->post('nama_user'),
							'user_email' => $this->input->post('email_user'),
							'user_tlp' =>$this->input->post('tlp_user'),
							'user_foto' => $hasil['file_name']
				);
				$path = 'asset/foto_user/'.$namafile;
				unlink($path);
            }
			$where = array('user_nik' => $this->input->post('id'));
			$this->model_app->update('tb_users', $data, $where);
			$this->session->set_flashdata('berhasil', 'Informasi Anda telah berhasil diubah');
			redirect('administrator/edit_profile/'.$nik);
		}
		$data['record'] = $this->model_app->view_where('tb_users','user_nik',$nik);
		$this->template->load('template','kelola-user/edit_profile', $data);
	}

    public function logout(){
		$this->session->sess_destroy();
        redirect(base_url('administrator'));
    }

	public function list_bidang(){
		$data['record'] = $this->model_app->view('tb_bidangtemuan');
		$this->template->load('template','kelola-bidang/list_bidang', $data);
	}
	public function input_bidang(){
		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('bidang','bidang','trim|required');
			if ($this->form_validation->run()==FALSE) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	$this->template->load('template','kelola-bidang/tambah_bidang');				
			}elseif (!empty($cek)) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
				$this->template->load('template','kelola-bidang/tambah_bidang');		
			}else{
				$data = array('bidangtemuan_nama'=> $this->input->post('bidang'));
				$this->model_app->insert('tb_bidangtemuan', $data);
				redirect('administrator/list_bidang');
			}
		}else{
			$this->template->load('template','kelola-bidang/tambah_bidang');	
		}
	}
	public function edit_bidang(){
		$id = $this->uri->segment(3);
		if (isset($_POST['edit'])) {
			$this->form_validation->set_rules('bidang', 'bidang', 'required');	
			if ($this->input->post('bidang')!=null) {
				if ($this->form_validation->run()==FALSE) {
            	$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	redirect('administrator/edit_bidang/'.$id);				
				}
				$data = array('bidangtemuan_nama' => $this->input->post('bidang'));
				$where = array('bidangtemuan_id' => $this->input->post('id'));
				$this->model_app->update('tb_bidangtemuan', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Bidang berhasil di Update!');
				redirect('administrator/list_bidang');
			}else{
				$data = array('bidangtemuan_nama' => $this->input->post('bidang'));
				$where = array('bidangtemuan_id' => $this->input->post('id'));
				$this->model_app->update('tb_bidangtemuan', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Bidang berhasil di Update!');
				redirect('administrator/list_bidang');
			}
				
		}else{
		$data['record'] = $this->model_app->view_where('tb_bidangtemuan','bidangtemuan_id',$id);
		$this->template->load('template','kelola-bidang/edit_bidang', $data);
		}
	}
	public function list_sebab(){
		$data['record'] = $this->model_app->view('tb_master_penyebab');
		$this->template->load('template','kelola-penyebab/list_sebab', $data);
	}
	public function input_sebab(){
		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('kode','kode','trim|required');
			$this->form_validation->set_rules('sebab','sebab','trim|required');
			if ($this->form_validation->run()==FALSE) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	$this->template->load('template','kelola-penyebab/tambah_sebab');				
			}elseif (!empty($cek)) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
				$this->template->load('template','kelola-penyebab/tambah_sebab');		
			}else{
				$data = array(
				'sebab_kode'=> $this->input->post('kode'),
				'klasifikasi_sebab'=> $this->input->post('sebab')
				);
				$this->model_app->insert('tb_master_penyebab', $data);
				redirect('administrator/list_sebab');
			}
		}else{
			$this->template->load('template','kelola-penyebab/tambah_sebab');	
		}
	}
	public function edit_sebab(){
		$id = $this->uri->segment(3);
		if (isset($_POST['edit'])) {
			$this->form_validation->set_rules('kode','kode','trim|required');
			$this->form_validation->set_rules('sebab','sebab','trim|required');	
			if ($this->input->post('kode')!=null) {
				if ($this->form_validation->run()==FALSE) {
            	$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	redirect('administrator/edit_sebab/'.$id);				
				}
				$data = array(
					'sebab_kode'=> $this->input->post('kode'),
					'klasifikasi_sebab'=> $this->input->post('sebab')
					);
				$where = array('sebab_id' => $this->input->post('id'));
				$this->model_app->update('tb_master_penyebab', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Penyebab berhasil di Update!');
				redirect('administrator/list_sebab');
			}else{
				$data = array(
					'sebab_kode'=> $this->input->post('kode'),
					'klasifikasi_sebab'=> $this->input->post('sebab')
					);
				$where = array('sebab_id' => $this->input->post('id'));
				$this->model_app->update('tb_master_penyebab', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Penyebab berhasil di Update!');
				redirect('administrator/list_sebab');
			}
				
		}else{
		$data['record'] = $this->model_app->view_where('tb_master_penyebab','sebab_id',$id);
		$this->template->load('template','kelola-penyebab/edit_sebab', $data);
		}
	}
	public function list_m_temuan(){
		$data['record'] = $this->model_app->view('tb_master_temuan');
		$this->template->load('template','kelola-master-temuan/list_temuan', $data);
	}
	public function input_m_temuan(){
		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('kode','kode','trim|required');
			$this->form_validation->set_rules('m_temuan','m_temuan','trim|required');
			if ($this->form_validation->run()==FALSE) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	$this->template->load('template','kelola-master-temuan/tambah_temuan');				
			}elseif (!empty($cek)) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
				$this->template->load('template','kelola-master-temuan/tambah_temuan');		
			}else{
				$data = array(
				'kode_temuan'=> $this->input->post('kode'),
				'klasifikasi_temuan'=> $this->input->post('m_temuan')
				);
				$this->model_app->insert('tb_master_temuan', $data);
				redirect('administrator/list_m_temuan');
			}
		}else{
			$this->template->load('template','kelola-master-temuan/tambah_temuan');	
		}
	}
	public function edit_m_temuan(){
		$id = $this->uri->segment(3);
		if (isset($_POST['edit'])) {
			$this->form_validation->set_rules('kode','kode','trim|required');
			$this->form_validation->set_rules('m_temuan','m_temuan','trim|required');
			if ($this->input->post('kode')!=null) {
				if ($this->form_validation->run()==FALSE) {
            	$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	redirect('administrator/edit_m_temuan/'.$id);				
				}
				$data = array(
					'kode_temuan'=> $this->input->post('kode'),
					'klasifikasi_temuan'=> $this->input->post('m_temuan')
					);
				$where = array('temu_id' => $this->input->post('id'));
				$this->model_app->update('tb_master_temuan', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Klasifikasi Temuan berhasil di Update!');
				redirect('administrator/list_m_temuan');
			}else{
				$data = array(
					'kode_temuan'=> $this->input->post('kode'),
					'klasifikasi_temuan'=> $this->input->post('m_temuan')
					);
				$where = array('temu_id' => $this->input->post('id'));
				$this->model_app->update('tb_master_temuan', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Klasifikasi Temuan berhasil di Update!');
				redirect('administrator/list_m_temuan');
			}
				
		}else{
		$data['record'] = $this->model_app->view_where('tb_master_temuan','temu_id',$id);
		$this->template->load('template','kelola-master-temuan/edit_temuan', $data);
		}
	}
	public function list_coso(){
		$data['record'] = $this->model_app->view('tb_master_coso');
		$this->template->load('template','kelola-master-coso/list_coso', $data);
	}
	public function input_coso(){
		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('kode','kode','trim|required');
			$this->form_validation->set_rules('coso','coso','trim|required');
			if ($this->form_validation->run()==FALSE) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	$this->template->load('template','kelola-master-coso/tambah_coso');				
			}elseif (!empty($cek)) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
				$this->template->load('template','kelola-master-coso/tambah_coso');		
			}else{
				$data = array(
				'kode_coso'=> $this->input->post('kode'),
				'klasifikasi_coso'=> $this->input->post('coso')
				);
				$this->model_app->insert('tb_master_coso', $data);
				redirect('administrator/list_coso');
			}
		}else{
			$this->template->load('template','kelola-master-coso/tambah_coso');	
		}
	}
	public function edit_coso(){
		$id = $this->uri->segment(3);
		if (isset($_POST['edit'])) {
			$this->form_validation->set_rules('kode','kode','trim|required');
			$this->form_validation->set_rules('coso','coso','trim|required');
			if ($this->input->post('kode')!=null) {
				if ($this->form_validation->run()==FALSE) {
            	$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	redirect('administrator/edit_coso/'.$id);				
				}
				$data = array(
					'kode_coso'=> $this->input->post('kode'),
					'klasifikasi_coso'=> $this->input->post('coso')
					);
				$where = array('coso_id ' => $this->input->post('id'));
				$this->model_app->update('tb_master_coso', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Klasifikasi COSO berhasil di Update!');
				redirect('administrator/list_coso');
			}else{
				$data = array(
					'kode_coso'=> $this->input->post('kode'),
					'klasifikasi_coso'=> $this->input->post('coso')
					);
				$where = array('coso_id' => $this->input->post('id'));
				$this->model_app->update('tb_master_coso', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Klasifikasi COSO berhasil di Update!');
				redirect('administrator/list_coso');
			}
				
		}else{
		$data['record'] = $this->model_app->view_where('tb_master_coso','coso_id',$id);
		$this->template->load('template','kelola-master-coso/edit_coso', $data);
		}
	}
	public function list_m_rekomendasi(){
		$data['record'] = $this->model_app->view('tb_master_rekomendasi');
		$this->template->load('template','kelola-master-rekomendasi/list_rekomen', $data);
	}
	public function input_m_rekomendasi(){
		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('rekomen','rekomen','trim|required');
			if ($this->form_validation->run()==FALSE) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	$this->template->load('template','kelola-master-rekomendasi/tambah_rekomen');				
			}elseif (!empty($cek)) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
				$this->template->load('template','kelola-master-rekomendasi/tambah_rekomen');		
			}else{
				$data = array('judul'=> $this->input->post('rekomen'));
				$this->model_app->insert('tb_master_rekomendasi', $data);
				redirect('administrator/list_m_rekomendasi');
			}
		}else{
			$this->template->load('template','kelola-master-rekomendasi/tambah_rekomen');	
		}
	}
	public function edit_m_rekomendasi(){
		$id = $this->uri->segment(3);
		if (isset($_POST['edit'])) {
			$this->form_validation->set_rules('rekomen','rekomen','trim|required');
			if ($this->input->post('rekomen')!=null) {
				if ($this->form_validation->run()==FALSE) {
            	$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	redirect('administrator/edit_m_rekomendasi/'.$id);				
				}
				$data = array('judul'=> $this->input->post('rekomen'));
				$where = array('rekomen_id  ' => $this->input->post('id'));
				$this->model_app->update('tb_master_rekomendasi', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Klasifikasi Rekomendasi berhasil di Update!');
				redirect('administrator/list_m_rekomendasi');
			}else{
				$data = array('judul'=> $this->input->post('rekomen'));
				$where = array('rekomen_id' => $this->input->post('id'));
				$this->model_app->update('tb_master_rekomendasi', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Klasifikasi Rekomendasi berhasil di Update!');
				redirect('administrator/list_m_rekomendasi');
			}
				
		}else{
		$data['record'] = $this->model_app->view_where('tb_master_rekomendasi','rekomen_id',$id);
		$this->template->load('template','kelola-master-rekomendasi/edit_rekomen', $data);
		}
	}
	public function list_divisi(){
		$data['record'] = $this->model_app->view('tb_divisi');
		$this->template->load('template','kelola-master-divisi/list_divisi', $data);
	}
	public function input_divisi(){
		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('divisi','divisi','trim|required');
			$this->form_validation->set_rules('kode_div','kode_div','trim|required');
			if ($this->form_validation->run()==FALSE) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	$this->template->load('template','kelola-master-divisi/tambah_divisi');				
			}elseif (!empty($cek)) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
				$this->template->load('template','kelola-master-divisi/tambah_divisi');		
			}else{
				$data = array(
					'master_bagian_nama'=> $this->input->post('divisi'),
					'master_bagian_kode'=> $this->input->post('kode_div')
			);
				$this->model_app->insert('tb_divisi', $data);
				redirect('administrator/list_divisi');
			}
		}else{
			$this->template->load('template','kelola-master-divisi/tambah_divisi');	
		}
	}
	public function edit_divisi(){
		$id = $this->uri->segment(3);
		if (isset($_POST['edit'])) {
			$this->form_validation->set_rules('divisi','divisi','trim|required');
			$this->form_validation->set_rules('kode_div','kode_div','trim|required');
			if ($this->input->post('rekomen')!=null) {
				if ($this->form_validation->run()==FALSE) {
            	$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	redirect('administrator/edit_m_rekomendasi/'.$id);				
				}
				$data = array(
					'master_bagian_nama'=> $this->input->post('divisi'),
					'master_bagian_kode'=> $this->input->post('kode_div')
				);
				$where = array('master_bagian_id' => $this->input->post('id'));
				$this->model_app->update('tb_divisi', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Divisi berhasil di Update!');
				redirect('administrator/list_divisi');
			}else{
				$data = array(
					'master_bagian_nama'=> $this->input->post('divisi'),
					'master_bagian_kode'=> $this->input->post('kode_div')
				);
				$where = array('master_bagian_id' => $this->input->post('id'));
				$this->model_app->update('tb_divisi', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Divisi berhasil di Update!');
				redirect('administrator/list_divisi');
			}
				
		}else{
		$data['record'] = $this->model_app->view_where('tb_divisi','master_bagian_id',$id);
		$this->template->load('template','kelola-master-divisi/edit_divisi', $data);
		}
	}
	public function list_reg(){
		$data['record'] = $this->model_app->view('tb_unit');
		$this->template->load('template','kelola-master-regional/list_reg', $data);
	}
	public function input_reg(){
		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('regional','regional','trim|required');
			if ($this->form_validation->run()==FALSE) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	$this->template->load('template','kelola-master-regional/tambah_reg');				
			}elseif (!empty($cek)) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
				$this->template->load('template','kelola-master-regional/tambah_reg');		
			}else{
				$data = array('unit_nama'=> $this->input->post('regional'));
				$this->model_app->insert('tb_unit', $data);
				redirect('administrator/list_reg');
			}
		}else{
			$this->template->load('template','kelola-master-regional/tambah_reg');	
		}
	}
	public function edit_reg(){
		$id = $this->uri->segment(3);
		if (isset($_POST['edit'])) {
			$this->form_validation->set_rules('regional','regional','trim|required');
			if ($this->input->post('regional')!=null) {
				if ($this->form_validation->run()==FALSE) {
            	$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	redirect('administrator/edit_reg/'.$id);				
				}
				$data = array('unit_nama'=> $this->input->post('regional'));
				$where = array('unit_id' => $this->input->post('id'));
				$this->model_app->update('tb_unit', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Regional berhasil di Update!');
				redirect('administrator/list_reg');
			}else{
				$data = array('unit_nama'=> $this->input->post('regional'));
				$where = array('unit_id' => $this->input->post('id'));
				$this->model_app->update('tb_unit', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Regional berhasil di Update!');
				redirect('administrator/list_reg');
			}
				
		}else{
		$data['record'] = $this->model_app->view_where('tb_unit','unit_id',$id);
		$this->template->load('template','kelola-master-regional/edit_reg', $data);
		}
	}
	public function list_anper(){
		$data['record'] = $this->model_app->view('tb_anper');
		$this->template->load('template','kelola-master-anper/list_anper', $data);
	}
	public function input_anper(){
		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('anper','anper','trim|required');
			if ($this->form_validation->run()==FALSE) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	$this->template->load('template','kelola-master-anper/tambah_anper');				
			}elseif (!empty($cek)) {
				$this->session->set_flashdata('gagal', 'Kendala Validasi');
				$this->template->load('template','kelola-master-anper/tambah_anper');		
			}else{
				$data = array('anper_nama'=> $this->input->post('anper'));
				$this->model_app->insert('tb_anper', $data);
				redirect('administrator/list_anper');
			}
		}else{
			$this->template->load('template','kelola-master-anper/tambah_anper');	
		}
	}
	public function edit_anper(){
		$id = $this->uri->segment(3);
		if (isset($_POST['edit'])) {
			$this->form_validation->set_rules('anper','anper','trim|required');
			if ($this->input->post('anper')!=null) {
				if ($this->form_validation->run()==FALSE) {
            	$this->session->set_flashdata('gagal', 'Kendala Validasi');
            	redirect('administrator/edit_anper/'.$id);				
				}
				$data = array('anper_nama'=> $this->input->post('anper'));
				$where = array('anper_id' => $this->input->post('id'));
				$this->model_app->update('tb_anper', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Anak Perusahaaan berhasil di Update!');
				redirect('administrator/list_anper');
			}else{
				$data = array('anper_nama'=> $this->input->post('anper'));
				$where = array('anper_id' => $this->input->post('id'));
				$this->model_app->update('tb_anper', $data , $where);
				$this->session->set_flashdata('berhasil', 'Informasi Master Anak Perusahaan berhasil di Update!');
				redirect('administrator/list_anper');
			}
				
		}else{
		$data['record'] = $this->model_app->view_where('tb_anper','anper_id',$id);
		$this->template->load('template','kelola-master-anper/edit_anper', $data);
		}
	}
}
