<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
	function index(){
		$data['cari'] = '';
		$data['record2'] = '';
		$data['record'] = $this->model_app->view_where_ordering('pemeriksaan_aktif','tb_pemeriksaan','Y','pemeriksaan_id','ASC');
		$this->template->load('template','kelola-dataadmin/kelola-data', $data);
	}
	function cari_data(){
		if (isset($_POST['submit'])) {
			$id_pmr = $this->input->post('judul_pmr');
			$cari = $this->input->post('data');
			$data['record'] = $this->model_app->view_where_ordering('pemeriksaan_aktif','tb_pemeriksaan','Y','pemeriksaan_id','ASC');
			if ($cari=="temuan") {
				$data['cari'] = $cari;
				$data['record2'] = $this->model_app->view_where_ordering('pemeriksaan_id','tb_temuan',$id_pmr,'temuan_id','ASC');
				$this->template->load('template','kelola-dataadmin/kelola-data',$data);
			}
			if ($cari=="rekomendasi") {
				$data['cari'] = $cari;
				$data['record2'] = $this->model_app->view_where_ordering('pemeriksaan_id','tb_rekomendasi',$id_pmr,'rekomendasi_id','ASC');
				$this->template->load('template','kelola-dataadmin/kelola-data',$data);
			}
			if ($cari=="tl") {
				$data['cari'] = $cari;
				$data['record2'] = $this->model_app->view_where_ordering('pemeriksaan_id','tb_tl',$id_pmr,'tl_id','ASC');
				$this->template->load('template','kelola-dataadmin/kelola-data',$data);
			}
		}
	}
	function delete_temuan(){
		$id_temuan = array('temuan_id' => $this->uri->segment(3));
		$id = $this->uri->segment(3);
		$cek = $this->model_app->view_where('tb_rekomendasi','temuan_id', $id);
		if (!empty($cek)) {
			// $this->session->set_flashdata('gagal', "Gagal menghapus Temuan, ada Rekomendasi pada Temuan");
			// redirect('data');
			$data = "ada";
		}else{
			$this->model_app->delete('tb_temuan', $id_temuan);
			// $this->session->set_flashdata('berhasil', "Temuan berhasil di Hapus");
			// redirect('data');
			$data = "tidak ada";
		}
		echo json_encode($data);
	}
	function delete_rekomendasi(){
		$id_rekom = array('rekomendasi_id' => $this->uri->segment(3));
		$id = $this->uri->segment(3);
		$cek = $this->model_app->view_where('tb_tl','rekomendasi_id', $id);
		if (!empty($cek)) {
			$this->session->set_flashdata('gagal', "Gagal menghapus Rekomendasi, ada Tindak Lanjut pada Rekomendasi");
			// redirect('data');
			$data = 'ada';
		}else{
			$this->model_app->delete('tb_rekomendasi', $id_rekom);
			$this->session->set_flashdata('berhasil', "Rekomendasi berhasil di Hapus");
			// redirect('data');
			$data = 'tidak ada';
		}
		echo json_encode($data);
	}
	function delete_rekomendasi2(){
		$id_rekom = array('rekomendasi_id' => $this->uri->segment(3));
		$id = $this->uri->segment(3);
		$cek = $this->model_app->view_where('tb_tanggapan','rekomendasi_id', $id);
		if (!empty($cek)) {
			$this->session->set_flashdata('gagal', "Gagal menghapus Rekomendasi, ada Tanggapan Manajer pada Rekomendasi");
			// redirect('data');
			$data = 'ada';
		}else{
			$this->model_app->delete('tb_rekomendasi', $id_rekom);
			$this->session->set_flashdata('berhasil', "Rekomendasi berhasil di Hapus");
			// redirect('data');
			$data = 'tidak ada';
		}
		echo json_encode($data);
	}
	function delete_tl(){
		$id_pmr = $this->uri->segment(3); $id_temuan = $this->uri->segment(4); $id_rekom = $this->uri->segment(5);
		$id_tl = array('tl_id' => $this->uri->segment(6));
		$this->model_app->delete('tb_tl', $id_tl);
		$this->session->set_flashdata('done', "Tindak Lanjut berhasil di Hapus");
		redirect('administrator/view_temuan/'.$id_pmr);
	}

	function multidelete_tl(){
		$id_pmr = $this->uri->segment(3);
		if (isset($_POST['hapus'])) {
			$id_tl = $this->input->post('hapustl');
			foreach ($id_tl as $key => $value) {
				$this->db->query("DELETE FROM tb_tl WHERE tl_id = '$value'");
			}
			$this->session->set_flashdata('done', "Tindak Lanjut berhasil di Hapus");
		}
		redirect('administrator/view_temuan/'.$id_pmr);
	}
	
	function delete_tanggapan(){
		$id_rekom = array('rekomendasi_id' => $this->uri->segment(3));
		$id = $this->uri->segment(3);
		$cek = $this->model_app->view_where('tb_tl','rekomendasi_id',$id);
		if (!empty($cek)) {
			// $this->session->set_flashdata('gagal', "Gagal menghapus Rekomendasi, ada Tanggapan Manajer pada Rekomendasi");
			// redirect('data');
			$data = 'ada';
		}else{
			$this->model_app->delete('tb_tanggapan', $id_rekom);
			// $this->session->set_flashdata('berhasil', "Rekomendasi berhasil di Hapus");
			// redirect('data');
			$data = 'tidak ada';	
		}
		echo json_encode($data);
	}
}
?>