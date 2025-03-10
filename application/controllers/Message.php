<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {

public function kotakmasuk(){
		$data['record'] = $this->model_app->view_join_where('user_link',$this->session->username,'tb_roompesan','tb_notifpesan','roompesan_id','tb_notifpesan'.".".'notifpesan_date','DESC');
		$data['record2'] = $this->model_app->view_ordering('tb_users','user_nama','ASC');
		$this->template->load('template','kelola-pesan/list_kotakmasuk', $data);
	}
	public function detail_forum(){
		$room_id = $this->uri->segment(3);
		$user = $this->session->username;
		$this->db->query("UPDATE tb_notifpesan SET status='Y' where roompesan_id='$room_id' AND user_link='$user'");
		$data['record'] = $this->model_app->view_where_ordering('roompesan_id','tb_pesan',$room_id,'pesan_id','ASC');
		$this->template->load('template','kelola-pesan/detail_pesan',$data);
	}
	public function input_pesan(){
		$id = array('roompesan_id' => $this->uri->segment(3));
		if (isset($_POST['kirim'])) {
			$data = array('roompesan_user_a' => $this->session->username,
						  'roompesan_user_b' => $this->input->post('penerima'),
						  'roompesan_judul' => $this->input->post('judul')
						);
			$this->model_app->insert('tb_roompesan', $data);
			$id_room = $this->db->insert_id();

			$data1 = array('roompesan_id' => $id_room, 'status' => 'N', 'user_link'=> $this->input->post('penerima'));
			$this->model_app->insert('tb_notifpesan', $data1);
			$data1b = array('roompesan_id' => $id_room, 'status' => 'Y', 'user_link'=> $this->session->username);
			$this->model_app->insert('tb_notifpesan', $data1b);
			$data2 = array(
				'roompesan_id' => $id_room,
				'pesan_judul' => $this->input->post('judul'),
				'pesan_deskripsi' => $this->input->post('pesan'),
				'pesan_penerima' => $this->input->post('penerima'),
				'pesan_tgl' => date('Ymd'),
				'pesan_waktu' => date('H:i:s'),
				'pesan_pengirim' => $this->session->username,
				'user_nik' => $this->session->username
			);
			$this->model_app->insert('tb_pesan', $data2);
			$id_pesan = $this->db->insert_id();
			$files = $this->input->post('files');
			foreach ($files as $key => $value) {
				$values[] = explode("/", $value);
				$this->db->select_max('uploadpesan_id');
	    		$res1 = $this->db->get('tb_upload_pesan');
	    		$res2 = $res1->result_array();
	    		$index = $res2[0]['uploadpesan_id']+1;
				$this->db->insert('tb_upload_pesan',array('uploadpesan_nama'=>$values[$key][1].$index,'token'=>$values[$key][0], 'uploadpesan_tgl'=> date('Ymd'), 'pesan_id' => $id_pesan));
			}
			redirect('message/kotakmasuk');
		}elseif (isset($_POST['balas'])) {
			$room_id = $this->input->post('id');
			$inputuser = $this->input->post('pengirim');
			$data3 = array(
						'roompesan_id' => $room_id,
						'pesan_deskripsi' => $this->input->post('reply'),
						'pesan_pengirim' => $this->session->username,
						'pesan_waktu' => date('H:i:s'),
						'pesan_tgl' => date('Ymd')
					);
			// $this->model_app->insert('tb_pesan', $data3);
			$pengirim = $this->input->post('pengirim');
			$whereee = "'roompesan_id'=".$room_id." AND user_link='$pengirim'";
			// echo $whereee; die();
			$this->db->set('status','N');
			$this->db->set('notifpesan_date', date('Y-m-d H:i:s'));
	        $this->db->where($whereee);
	        $this->db->update('tb_notifpesan');
		}else{
			$config['upload_path'] = 'asset/file_pesan/';
			$config['allowed_types'] = 'jpg|png|jpeg|JPG|JPEG|pdf|doc|docx|xls|xlsx|odt|';
			$config['max_size'] = '50000'; // kb
			// $config['file_name'] = $_FILES[0]['userfile']['name'];
			$this->load->library('upload', $config);
			
			if($this->upload->do_upload('userfile')){
				$token=$this->input->post('token_foto');
				$nama=$this->upload->data('file_name');
			}
			$data['record'] = $this->model_app->view_ordering('tb_users','user_nama','ASC');
			$this->template->load('template','kelola-pesan/input_pesan',$data);	
		}
		
	}
	public function input_room(){
			$user = implode(" ", $this->input->post('penerima'));
			if (in_array("semua", $this->input->post('penerima'))) {
			    $user = $this->model_app->view_ordering('tb_users','user_nik','ASC');
			    $usr = [];
			    foreach ($user as $key => $value) {
			      $usr[] = $value['user_nik'];
			    }
			    $user = implode(" ", $usr);
		  	}
			$data = array(
				'pesan_judul' => $this->input->post('judul'),
				'pesan_deskripsi' => $this->input->post('pesan'),
				// 'pesan_penerima' => $this->input->post('penerima'),
				'pesan_tgl' => date('Ymd'),
				'pesan_waktu' => date('H:i:s'),
				'pesan_hapus' => $user,
				'pesan_pengirim' => $this->session->username,
				'user_nik' => $this->session->username
			);
			$this->model_app->insert('tb_pesan', $data);
			$id_pesan = $this->db->insert_id();
			$data['files'] = $this->input->post('files');
			$data['count'] = $this->input->post('count');
			$data['user'] = $user;
			$files = $this->input->post('files');
			$f = explode(" ", $files);
			foreach ($f as $key => $value) {
				$token = $value;
				// $query = $this->db->query("SELECT uploadpesan_id FROM tb_upload_pesan WHERE token='$token'");
				// $result = $query->result_array();
				// $id = $result[0]['uploadpesan_id'];
				$this->db->query("UPDATE tb_upload_pesan SET pesan_id='$id_pesan' WHERE token='$value'");
			}
			// tb_roompesan
			
			$data2 = array(	'roompesan_user' => $user,
							'roompesan_hapus' => $user,
						  // 'roompesan_user_a' => $this->session->username,
						  // 'roompesan_user_b' => $this->input->post('penerima'),
						  'roompesan_judul' => $this->input->post('judul')
						);
			$this->model_app->insert('tb_roompesan', $data2);
			$id_room = $this->db->insert_id();
			$this->db->query("UPDATE tb_pesan SET roompesan_id='$id_room' WHERE pesan_id='$id_pesan'");
			// TB_NOTIFPESAN
			$pnr = explode(" ", $user);
			foreach ($pnr as $row) {
				if ($row==$this->session->username) {
					$data1a = array('roompesan_id' => $id_room, 'status' => 'Y', 'user_link'=> $row);
					$this->model_app->insert('tb_notifpesan', $data1a);
				}else{
					$data1 = array('roompesan_id' => $id_room, 'status' => 'N', 'user_link'=> $row);
					$this->model_app->insert('tb_notifpesan', $data1);
				}
			}
			
			echo json_encode($data);
	}
	public function edit_pesan(){
		$id_room = $this->uri->segment(3);
		$data = array('roompesan_judul' => $this->input->post('judul'));
		$where = array('roompesan_id' => $id_room);
		$this->model_app->update('tb_roompesan', $data, $where);
		redirect('message/detail_forum/'.$id_room);
	}
	public function balas_pesan(){
		$id_room = $this->uri->segment(3);
		// $yuhu = $this->db->query("SELECT * FROM tb_roompesan WHERE roompesan_id='$id_room'")->result_array();
		// $users = $yuhu[0]['roompesan_user'];
		$data = array(
				'roompesan_id' => $this->input->post('room'),
				'pesan_deskripsi' => $this->input->post('pesan'),
				'pesan_pengirim' => $this->session->username,
				// 'pesan_hapus' => $users,
				'pesan_waktu' => date('H:i:s'),
				'pesan_tgl' => date('Y-m-d')
		);
		$user = $this->input->post('pengirim');
		$date =  date('Y-m-d H:i:s');
		$this->model_app->insert('tb_pesan', $data);
		$idpesan = $this->db->insert_id();
		$data['files'] = $this->input->post('files');
		$data['count'] = $this->input->post('count');
		$data['pengirim'] = $this->input->post('pengirim');
			$pengirim = $this->input->post('pengirim');
			$userr = explode(" ", $this->input->post('pengirim'));
			foreach ($userr as $key => $value) {
				if ($value!=$this->session->username) {
					$this->db->query("UPDATE tb_notifpesan SET notifpesan_date='$date', status = 'N' WHERE user_link='$value' AND roompesan_id = '$id_room'");
				}
			}
			
		$files = $this->input->post('files');
		$f = explode(" ", $files);

		foreach ($f as $key => $value) {
			$token = $value;
			// $query = $this->db->query("SELECT uploadpesan_id FROM tb_upload_pesan WHERE token='$token'");
			// $result = $query->result_array();
			// $id = $result[0]['uploadpesan_id'];
			$this->db->query("UPDATE tb_upload_pesan SET pesan_id='$idpesan' WHERE token='$value'");
		}
		echo json_encode($data);
		redirect('message/detail_forum/'.$id_room);
	}
	public function detail_pesan(){
		$id_pesan = $this->uri->segment(3);
		$user = $this->session->username;
		$this->db->query("UPDATE tb_pesan SET pesan_dibaca='Y' where pesan_id='$id_pesan'");
		if (isset($_POST['kirim'])) {
			$data = array('pesan_balasan' => $this->input->post('balasan'),
						// 'pesan_penerima_balasan' => $this->input->post('penerimabls'),
						  'pesan_balasan_waktu' => date('H:i:s'),
						  'pesan_balasan_tgl' =>date('Ymd'),
						  'pesan_dibaca' => 'N'
						);
			// $this->db->query("UPDATE tb_pesanmasuk SET balasan='$message' where id_pesan='$id'");
            $where = array('pesan_id' => $id_pesan);
			$this->model_app->update('tb_pesan', $data , $where);
			$data2 = array(
						'pesan_judul' => $this->input->post('judulbls'),
						'pesan_deskripsi' => $this->input->post('pesanbls'),
						'pesan_penerima' => $this->input->post('penerimabls'),
						'pesan_tgl' => date('Ymd'),
						'pesan_waktu' => date('H:i:s'),
						'pesan_pengirim' => $this->session->username,
						'user_nik' => $this->session->username,
						'pesan_balasan' => $this->input->post('balasan'),
						'pesan_balasan_waktu' => date('H:i:s'),
						'pesan_balasan_tgl' =>date('Ymd')
					);
			$this->model_app->insert('tb_pesan', $data2);
			$id = $this->db->insert_id();
			$files = $this->input->post('files');
			foreach ($files as $key => $value) {
				$values[] = explode("/", $value);
				// var_dump($values); die();
				$this->db->insert('tb_upload_pesan',array('uploadpesan_nama'=>$values[$key][1],'token'=>$values[$key][0], 'uploadpesan_tgl'=> date('Ymd'), 'pesan_id' => $id));
			}
			$this->session->set_flashdata('berhasil','Success! Pesan berhasil terkirim ke '.$this->input->post('penerimabls').'!');
            $proses = $this->model_app->edit('tb_pesan', array('pesan_id' => $id_pesan))->row_array();
            $data = array('rows' => $proses);
            redirect('message/detail_pesan/'.$id_pesan,$data);
		}else{
		$config['upload_path'] = 'asset/file_pesan/';
		$config['allowed_types'] = 'jpg|png|jpeg|JPG|JPEG|pdf|doc|docx|xls|xlsx|odt|';
		$config['max_size'] = '50000'; // kb
		$this->load->library('upload', $config);
			if($this->upload->do_upload('userfile')){
				$token=$this->input->post('token_foto');
				$nama=$this->upload->data('file_name');
			}
		}
		$proses = $this->model_app->edit('tb_pesan', array('pesan_id' => $id_pesan))->row_array();
        $data = array('rows' => $proses);
		$this->template->load('template','kelola-pesan/detail_pesanmasuk',$data);
	}
	// public function delete_pesan(){
	// 	$id_pesan = array('roompesan_id' => $this->uri->segment(3));
	// 	$this->model_app->delete('tb_roompesan', $id_pesan);
	// 	redirect('administrator/kotakmasuk');
	// }
	public function delete_pesan(){
		$id_room = $this->uri->segment(3);
		$id_pesan = array('pesan_id' => $this->uri->segment(4));
		$this->model_app->delete('tb_pesan',$id_pesan);
		redirect('message/detail_forum/'.$id_room);
	}
	public function delete_forum(){
		$id_room = $this->uri->segment(3);
		$select = $this->db->query("SELECT * FROM tb_roompesan WHERE roompesan_id='$id_room'")->result_array();
		// print_r($select);
		$users = $select[0]['roompesan_hapus'];
		$users  = explode(" ", $users);
		print_r($users);
		$key = array_search($this->session->username, $users);
			$hapus = $users[$key];
			$this->db->query("DELETE FROM tb_notifpesan WHERE roompesan_id = '$id_room' AND user_link = '$hapus'");
			unset($users[$key]);
		
		// print_r($users);
		$user = implode(" ", $users);
		$this->db->query("UPDATE tb_roompesan SET roompesan_hapus = '$user' WHERE roompesan_id='$id_room'");
		redirect('message/kotakmasuk');
	}
	public function status_dibaca(){
		if ($this->uri->segment(4)=='N'){
            $data = array('status'=>'Y');
        }else{
            $data = array('status'=>'N');
        }
        $where = array('roompesan_id' => $this->uri->segment(3), 'user_link' => $this->session->username);
        $this->model_app->update('tb_notifpesan', $data, $where);
        redirect('message/kotakmasuk');
	}
	public function remove_file_pesan(){
		$token=$this->input->post('token');
		$cek = $this->model_app->view_where('tb_upload_pesan','token',$token);
		$namafile = $cek[0]['uploadpesan_nama'];
		$path = 'asset/file_pesan/'.$namafile;
		unlink($path);
		$this->db->delete('tb_upload_pesan',array('token'=>$token));
		
		echo "{}";
	}
	public function uploadfile_pesan(){
		$config['upload_path'] = 'asset/file_pesan/';
		$config['allowed_types'] = 'jpg|png|jpeg|JPG|JPEG|pdf|doc|docx|xls|xlsx|odt|';
		$config['max_size'] = '50000'; // kb
		$this->load->library('upload', $config);
		if($this->upload->do_upload('userfile')){
			$token=$this->input->post('token_foto');
			$nama=$this->upload->data('file_name');
			$this->db->insert('tb_upload_pesan',array('uploadpesan_nama'=>$nama,'token'=>$token, 'uploadpesan_tgl'=> date('Ymd')));
		}
		// redirect('administrator/list_tl/'.$id_pmr.'/'.$id_temuan.'/'.$id_rekom);
	}
	public function multidelete_pesan(){
		if (isset($_POST['submit'])) {
			$pilih = $this->input->post('select');
			$jumlah = count($pilih);
			for($x=0;$x<$jumlah;$x++){
				$this->db->query("DELETE FROM tb_pesan WHERE pesan_id='$pilih[$x]'");
			}
			$this->session->set_flashdata('berhasil',$jumlah.' pesan berhasil terhapus !');
			 redirect('message/kotakmasuk');
		}
	}
}