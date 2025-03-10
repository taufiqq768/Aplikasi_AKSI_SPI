<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends CI_Controller {

	public function notifpesan(){
		$data = $this->db->where('status','N')->where('user_link', $this->session->username)->from("tb_notifpesan")->count_all_results();
		echo json_encode($data);
	}
	//NOTIFIKASI SEMUA USER
	public function notif_spi(){
		$level = $this->uri->segment(3);
		$aku = $this->uri->segment(4);
		$unit = $this->uri->segment(5);
		if ($this->session->level=="spi") {
          $data['notifikasi'] = $this->db->query("SELECT * FROM tb_notifikasi WHERE notifikasi_level='$level' AND notifikasi_user = '$aku' AND notifikasi_dibaca='N' ORDER BY notifikasi_id DESC")->result_array();
        }
        if ($this->session->level=="kabagspi") {
          $data['notifikasi'] = $this->db->query("SELECT * FROM tb_notifikasi WHERE notifikasi_level='$level' AND notifikasi_dibaca='N' ORDER BY notifikasi_id DESC")->result_array();
        }
        if ($this->session->level=="operator" OR $this->session->level=="verifikator") {
          $data['notifikasi'] = $this->db->query("SELECT * FROM tb_notifikasi WHERE notifikasi_level = '$level' AND notifikasi_unit = '$unit' AND notifikasi_dibaca='N' ORDER BY notifikasi_id DESC")->result_array();
        }
        $data['hitung'] = count($data['notifikasi']);
        // $data = $hitung;
        echo json_encode($data);
	}
	
	 public function unset_notif(){
	 	$level = $this->input->post('level');
	 	$aku = $this->input->post('aku');
	 	$unit = $this->input->post('unit');
	 	if ($level == "kabagspi") {
	 		$this->db->query("UPDATE tb_notifikasi SET notifikasi_dibaca='Y' WHERE notifikasi_level='kabagspi'");
	 	}elseif ($level == "spi") {
	 		$this->db->query("UPDATE tb_notifikasi SET notifikasi_dibaca='Y' WHERE notifikasi_level='$level' AND notifikasi_user='$aku'");
	 	}elseif ($level == "operator" OR $level =="verifikator"){
	 		$this->db->query("UPDATE tb_notifikasi SET notifikasi_dibaca='Y' WHERE notifikasi_level='$level' AND notifikasi_unit='$unit'");
	 	}
	 }
	// public function notif_deadline(){
	// 	$level = $this->uri->segment(3);
	// 	$unit = $this->uri->segment(4);
	// 	$data = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id WHERE NOT (rekomendasi_status = 'Sudah di Tindak Lanjut' OR rekomendasi_status = 'Sudah TL (Belum Optimal)') AND unit_id = '$unit'")->result_array();
	// 	 foreach ($data as $key ) {
 //           $rekomtgl = $key['rekomendasi_tgl'];
 //           $rekomtgl = date('Y-m-d', strtotime("+4 months", strtotime($rekomtgl)));
 //           // echo $rekomtgl."<br>";
 //           if (date('Y-m-d')<= $rekomtgl ) {
 //             $op[] = $key['rekomendasi_tgl'];
 //           }
 //         }
	// 	$data = count($op); 
	// 	echo json_encode($data);
	// }
	// public function notif_all(){
	// 	$level = $this->session->level;
	// 	$unit = $this->session->unit;
	// 	$user = $this->session->username;
	// 	if ($level == "spi") {
	// 		$data['notifikasi'] = $this->db->query("SELECT * FROM tb_notifikasi WHERE notifikasi_level = '$level' AND notifikasi_user='$user' AND notifikasi_dibaca='N' ORDER BY notifikasi_id ASC")->result_array();
	// 	}elseif ($level == "operator" OR $level == "verifikator") {
	// 		$data['notifikasi'] = $this->db->query("SELECT * FROM tb_notifikasi WHERE notifikasi_unit = '$unit' AND notifikasi_level = '$level' AND notifikasi_dibaca='N' ORDER BY notifikasi_id ASC")->result_array();
	// 	}elseif($level == "kabagspi" ){
	// 		$data['notifikasi'] = $this->db->query("SELECT * FROM tb_notifikasi WHERE notifikasi_level = '$level' AND notifikasi_dibaca='N' ORDER BY notifikasi_id ASC")->result_array();
	// 	}
	// 	$this->template->load('template','kelola-pemeriksaan/all-notifikasi', $data);
	// }
	// public function notif_kebun(){
	// 	$level = $this->uri->segment(3);
	// 	$unit = $this->uri->segment(4);
	// 	if ($this->session->level=="operator" OR $this->session->level=="verifikator") {
 //          $notifikasi = $this->db->query("SELECT * FROM tb_notifikasi WHERE notifikasi_level = '$level' AND notifikasi_unit = '$unit' AND notifikasi_dibaca='N' ORDER BY notifikasi_tgl ASC")->result_array();
 //        }
 //        $hitung = count($notifikasi);
 //        $data = $hitung;
 //        echo json_encode($data);
	// }

}