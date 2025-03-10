<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendemail extends CI_Controller {
	public function lupa_password(){
		if (isset($_POST['submit'])) {
			$cek = $this->model_app->view_select_where('user_nik','tb_users','user_nik',$this->input->post('nik'));
			if (empty($cek)) {
				$this->session->set_flashdata('unregistered','Maaf, username yang Anda masukkan tidak terdaftar sebagai akun !');
				redirect('sendemail/lupa_password');
			}
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
			if ($this->form_validation->run()==FALSE) {
				$this->load->view('form_lupapassword');
			}else{
				$nik = $this->input->post('nik');
				$email = $this->input->post('email');
				$message = 'Link';
					
				// $this->load->library('MyPHPMailer');
		            $fromEmail = "simontl@ptpn12.com";
		            $this->load->library('MyPHPMailer');
			        $isiEmail = "<a href='".base_url()."sendemail/lupapassword_validation/$nik'><button class='btn btn-xs btn-primary'>Klik Link Berikut untuk Verifikasi</button></a>";
			        $mail = new PHPMailer();
			        $mail->SMTPOptions = array(
		                'ssl' => array(
		                    'verify_peer' => false,
		                    'verify_peer_name' => false,
		                    'allow_self_signed' => true
		                )
	            	);
			       $mail->IsHTML(true);    // set email format to HTML
		            $mail->IsSMTP(); 
		            $mail->SMTPDebug  = 0;
		            $mail->SMTPAuth   = true; // enabled SMTP authentication
		            $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
		            //host name dari server email
		            $mail->Host       = "mail.ptpn12.com";      // setting GMail as our SMTP server
		            $mail->Port       = 465;                   // SMTP port to connect to eMail
		            $mail->Username   = $fromEmail;  // alamat email
		            $mail->Password   = "simontl12";            // password eMail
		            $mail->SetFrom('simontl@ptpn12.com', 'SIMONTL-PTPNXII');  //Siapa yg mengirim email
		            $mail->Subject    = "Link Verifikasi Lupa Password AKSI";
		            $mail->Body       = $isiEmail;
		            $mail->AddAddress($email);
		           
		            if(!$mail->Send()) {
		                echo "Eror: ".$mail->ErrorInfo;
		                echo "tidak terkirim";
		            }else{
		            	$this->session->set_flashdata('berhasil', 'Link Verifikasi Telah dikirimkan, Cek email Anda untuk memverifikasi');
		            	redirect('sendemail/lupa_password');
		            }
			}
		}
		$this->load->view('form_lupapassword');
	}
	public function lupapassword_validation(){
		$nik = $this->uri->segment(3);
		if (isset($_POST['simpan'])) {
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
			if ($this->form_validation->run()==FALSE) {
	         	$this->session->set_flashdata('gagal', 'Password tidak cocok!');
	         	redirect('sendemail/lupapassword_validation/'.$nik, $data);				
			}else{
				$data = array('user_password' => md5($this->input->post('password')),
							'user_count'  => '1'
						);
				$where = array('user_nik' => $this->input->post('id'));
				$this->model_app->update('tb_users', $data, $where);
				redirect('administrator');	
			}	
		}
		$this->load->view('verifikasi_lupapassword');
	}
}