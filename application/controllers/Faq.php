<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

public function list_faq(){
		$data['record'] = $this->model_app->view_ordering('tb_faq','faq_id','ASC');
		$this->template->load('template','kelola-faq/list_faq', $data);
	}
	public function view_faq(){
		$data['record'] = $this->model_app->view_ordering('tb_faq','faq_id','ASC');
		$this->template->load('template','kelola-faq/view_faq', $data);
	}
	public function input_faq(){
		if (isset($_POST['submit'])) {
			$data = array (	'faq_judul' => $this->input->post('pertanyaan'),
							'faq_jawaban' => $this->input->post('jawaban'),
							'faq_tgl' => date('Ymd'),
							// 'faq_petugas' => $this->input->post('nama_ptg'),
                            'user_nik' => $this->session->username
			);
			$this->model_app->insert('tb_faq',$data);
			$id_faq = $this->db->insert_id();
			$filesCount = count($_FILES['upload_Files']['name']);
			for($i = 0; $i < $filesCount; $i++){ 
              $_FILES['upload_File']['name'] = $_FILES['upload_Files']['name'][$i]; 
              $_FILES['upload_File']['type'] = $_FILES['upload_Files']['type'][$i]; 
              $_FILES['upload_File']['tmp_name'] = $_FILES['upload_Files']['tmp_name'][$i]; 
              $_FILES['upload_File']['error'] = $_FILES['upload_Files']['error'][$i]; 
              $_FILES['upload_File']['size'] = $_FILES['upload_Files']['size'][$i]; 
              $uploadPath = 'asset/file_faq/'; 
              $config['upload_path'] = $uploadPath; 
              $config['allowed_types'] = 'jpg|png|JPG|JPEG|pdf|doc|docx|xls|xlsx|odt|'; 
              $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('upload_File')){
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                    // $uploadData[$i]['created'] = date("Y-m-d H:i:s");
                    // $uploadData[$i]['modified'] = date("Y-m-d H:i:s");
                }
            }            
            if(!empty($uploadData)){
                //Insert file information into the database
                foreach ($uploadData as $key => $value) {
                  $data2 = array(
                  	'faq_id' => $id_faq,
                  	'uploadfaq_filename' => $value['file_name']
                  );
                  $this->db->insert('tb_upload_faq', $data2);
                }
            }
            redirect('faq/list_faq');
		}
		$this->template->load('template','kelola-faq/tambah_faq');
	}
	public function edit_faq(){
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])) {
			$data = array('faq_judul' => $this->input->post('pertanyaan'),
						  'faq_jawaban' => $this->input->post('jawaban'),
						  // 'faq_petugas' => $this->input->post('nama_ptg'),
						  'faq_tgl' => date('Ymd'),
                          'user_nik' => $this->session->username
			);
			$where = array('faq_id' => $this->input->post('id'));
			$this->session->set_flashdata('berhasil','Data FAQ berhasil di Update');
			$this->model_app->update('tb_faq', $data , $where);
			redirect('faq/list_faq');	
		}		
		$data['record'] = $this->model_app->view_where('tb_faq','faq_id',$id);
		$this->template->load('template','kelola-faq/edit_faq', $data);
	}
	public function delete_faq(){
		$id_faq = array('faq_id' => $this->uri->segment(3));
		$this->model_app->delete('tb_faq', $id_faq);
		$this->session->set_flashdata('berhasil','Data FAQ berhasil dihapus');
		redirect('faq/list_faq');
	}

	function tampil_data(){
		$id_faq = $this->uri->segment(3);
		$data = $this->model_app->view_where('tb_upload_faq','faq_id',$id_faq);
		echo json_encode($data);
	}
	function uploadfile_faq(){
		$id_faq = $this->uri->segment(3); 
		$config['upload_path'] = 'asset/file_faq/';
		$config['allowed_types'] = 'jpg|png|jpeg|JPG|JPEG|pdf|doc|docx|xls|xlsx|odt|';
		$config['max_size'] = '50000'; // kb
		$this->load->library('upload', $config);
		if($this->upload->do_upload('userfile')){
			$token=$this->input->post('token_foto');
			$nama=$this->upload->data('file_name');
			$this->db->insert('tb_upload_faq',array('uploadfaq_filename'=>$nama,'token'=>$token, 'uploadfaq_tgl'=> date('Ymd'), 'faq_id' => $id_faq));
		}
	}
	public function remove_file_tl(){
		$token=$this->input->post('token');
		$cek = $this->model_app->view_where('tb_upload_faq','token',$token);
		$namafile = $cek[0]['uploadfaq_filename'];
		$path = 'asset/file_faq/'.$namafile;
		unlink($path);
		$this->db->delete('tb_upload_faq',array('token'=>$token));
		
		echo "{}";
	}
	public function hapus_file(){
		$id=$this->input->post('kode');
		$cek = $this->model_app->view_where('tb_upload_faq','uploadfaq_id',$id);
		$namafile = $cek[0]['uploadfaq_filename'];
		$path = 'asset/file_faq/'.$namafile;
		unlink($path);
		$data=$this->model_app->hapus_file_faq($id);
		echo json_encode($data);
	}
}