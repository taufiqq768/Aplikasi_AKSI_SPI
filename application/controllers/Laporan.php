<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
	public function laporan_tabular(){
		$data['bidang'] = "Semua Bidang";
		$data['rentang'] = "semua";
		$data['bidang_tmn'] = 'semuabidang';
		$data['tgl_mulai'] = '';
		if ($this->session->level=="operator" OR $this->session->level=="verifikator") {
            $unit = $this->session->unit;
            $data['record'] = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id WHERE pemeriksaan_jenis = 'Rutin' AND pemeriksaan_aktif = 'Y' AND kebun_id = '$unit' AND `rekomendasi_kirim` = 'Y' ORDER BY pemeriksaan_tgl ASC")->result_array(); 
        }else{
			$data['record'] = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id ORDER BY tb_rekomendasi.temuan_id ASC")->result_array();
        }
		// print_r($data); die();
		$this->template->load('template','kelola-laporan/laporan_tabular', $data);
	}
	public function cari_laporan()
	{
		$unit = $this->session->unit;
		if (isset($_POST['submit'])) 
		{
			// $id_bidang = $this->input->post('bidang');
			// $data['bidang_tmn'] = $id_bidang;
			// $data['id_judul'] = $this->input->post('judul_pmr');
			// $data['status_tamu'] = $this->input->post('status');
			// $bun = $this->input->post('kebun');
			// if ($bun=="all") 
			// {
			// 	$data['bun'] = 'semua';
			// }elseif ($bun=="cekbox") {
			// 	$bun1 = implode("','", $this->input->post('pilihkebun'));
			// 	$data['bun'] = "IN ('".$bun1."')";
			// }else{
			// 	$data['bun'] = $this->input->post('kebun');
			// }

			// $waktu = $this->input->post('waktu');
			// $bidang = $this->model_app->view_profile('tb_bidangtemuan', array('bidangtemuan_id'=> $id_bidang))->row_array();
			// $bidang = $bidang['bidangtemuan_nama'];
			// $rentangwaktu = $this->input->post('rentang'); 
			// $rentang = explode(" - ", $rentangwaktu);

			// 	$mulai = $rentang[0]; $mulai = explode("/", $mulai); $mulai = $mulai[2]."-".$mulai[0]."-".$mulai[1];
			// 	$akhir = $rentang[1]; $akhir = explode("/", $akhir); $akhir = $akhir[2]."-".$akhir[0]."-".$akhir[1];
			// 		$mulai1 = explode("-", $mulai); $mulai1 = $mulai1[2]."-".$mulai1[1]."-".$mulai1[0];
			// 		$akhir1 = explode("-", $akhir); $akhir1 = $akhir1[2]."-".$akhir1[1]."-".$akhir1[0];
			// if ($waktu == "Y") {
			// 	$data['rentang'] = $mulai1." s/d ".$akhir1;
			// 	$data['tgl_mulai'] = $mulai;
			// 	$data['tgl_akhir'] = $akhir;
			// }else{
			// 	$data['tgl_mulai'] = '';
			// 	$data['tgl_akhir'] = '';
			// 	$data['rentang'] = "semua";
			// }

			// SEMUA PEMERIKSAAN DIDOWNLOAD
				$jenis = $this->input->post('jenis');
				if($jenis == "semua")
				{
					$data['record'] = $this->db->query("SELECT COUNT(DISTINCT tb_temuan.temuan_id) AS jumlah_temuan,tb_unit.unit_nama, COUNT(DISTINCT tb_rekomendasi.rekomendasi_id) AS jumlah_rekomendasi, tb_lha.no_lha, SUM(CASE WHEN tb_rekomendasi.rekomendasi_status = 'Sesuai' THEN 1 ELSE 0 END) AS jumlah_s, SUM(CASE WHEN tb_rekomendasi.rekomendasi_status = 'Belum di Tindak Lanjut' THEN 1 ELSE 0 END) AS jumlah_bd, SUM(CASE WHEN tb_rekomendasi.rekomendasi_status = 'Belum Sesuai' THEN 1 ELSE 0 END) AS jumlah_bs, SUM(CASE WHEN tb_rekomendasi.rekomendasi_status = 'Tidak dapat di Tindak Lanjuti' THEN 1 ELSE 0 END) AS jumlah_tdd 
					FROM 
					tb_pemeriksaan 
					LEFT JOIN tb_unit ON tb_pemeriksaan.unit_id = tb_unit.unit_id 
					LEFT JOIN tb_temuan ON tb_pemeriksaan.pemeriksaan_id = tb_temuan.pemeriksaan_id 
					LEFT JOIN tb_rekomendasi ON tb_pemeriksaan.pemeriksaan_id = tb_rekomendasi.pemeriksaan_id
					LEFT JOIN tb_lha ON tb_lha.id_pemeriksaan = tb_pemeriksaan.pemeriksaan_id
					GROUP BY tb_unit.unit_nama, tb_lha.no_lha")->result_array();
					$this->load->view('kelola-laporan/excel_laporan_all', $data);
				}
				if($jenis == "lha")
				{
					$nomor_lha = $this->input->post('nomor_lha');
					$data['record'] = $this->db->query("SELECT tb_temuan.temuan_judul, tb_temuan.nominal, tb_unit.unit_nama, tb_lha.no_lha,tb_rekomendasi.rekomendasi_judul,tb_tl.tl_deskripsi, COUNT(CASE WHEN tb_rekomendasi.rekomendasi_status = 'Sesuai' THEN 1 END) AS sesuai_count, COUNT(CASE WHEN tb_rekomendasi.rekomendasi_status = 'Belum Sesuai' THEN 1 END) AS belum_sesuai_count, COUNT(CASE WHEN tb_rekomendasi.rekomendasi_status = 'Belum Tindak Lanjut' THEN 1 END) AS belum_tindaklanjut_count, COUNT(CASE WHEN tb_rekomendasi.rekomendasi_status = 'Tidak Dapat Ditindaklanjuti' THEN 1 END) AS tidak_dapat_tindaklanjuti_count FROM tb_tl LEFT JOIN tb_rekomendasi 
					ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id 
					LEFT JOIN tb_temuan ON tb_tl.temuan_id = tb_temuan.temuan_id 
					LEFT JOIN tb_pemeriksaan ON tb_tl.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id 
					LEFT JOIN tb_unit ON tb_pemeriksaan.unit_id = tb_unit.unit_id
					LEFT JOIN tb_lha ON tb_pemeriksaan.pemeriksaan_id = tb_lha.id_pemeriksaan
					WHERE tb_lha.no_lha =$nomor_lha GROUP BY tb_temuan.temuan_judul, tb_temuan.nominal, tb_unit.unit_nama, tb_lha.no_lha,tb_rekomendasi.rekomendasi_judul,tb_tl.tl_deskripsi;")->result_array();
					$this->load->view('kelola-laporan/excel_laporan_lha', $data);
				}
		}
	}
}