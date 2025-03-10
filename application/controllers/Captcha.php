<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends CI_Controller {

		public function reset_password(){
		$nik = $this->uri->segment(3);
		if (isset($_POST['submit'])) {
			$cek =  $this->model_app->view_select_where('user_password', 'tb_users', 'user_nik', $nik);
			if ($cek[0]->user_password == md5($this->input->post('pass_lama'))) {
				$this->form_validation->set_rules('password', 'Password', 'required');
				$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
					$this->form_validation->set_rules('kode_captcha', 'Kode Captcha', 'required|callback_cek_captcha');
        			$this->form_validation->set_error_delimiters('<div style="border: 1px solid: #999999; background-color: #ffff99;">', '</div>');
				if ($this->form_validation->run()==FALSE) {
					$data['main_content'] = 'captcha/reset_password';
	            	$this->session->set_flashdata('gagal', 'Password atau Kode Captcha tidak cocok!');
				         $cap = $this->buat_captcha();
			            $data['cap_img'] = $cap['image'];
			            $this->session->set_userdata('kode_captcha', $cap['word']);
	            		redirect('captcha/reset_password/'.$nik, $data);				
				}else{
					$data = array(
							  'user_password'	=> md5($this->input->post('password'))
					);
					$where = array('user_nik' => $this->input->post('id'));
					$this->model_app->update('tb_users', $data, $where);
					$this->session->unset_userdata('kode_captcha');
					$this->session->set_flashdata('berhasil','Anda berhasil mereset dan mengubah password !');
					redirect('captcha/reset_password/'.$nik);
				}	
			}else{
				$this->session->set_flashdata('lama', 'Anda salah memasukkan password lama!');
				redirect('captcha/reset_password/'.$nik);
			}
		 }else{
		$cap = $this->buat_captcha();
        $data['cap_img'] = $cap['image'];
        $this->session->set_userdata('kode_captcha', $cap['word']);	
		$data['record'] = $this->model_app->view_where('tb_users','user_nik',$nik);
		$this->template->load('template','kelola-user/resetpassword_user', $data);
		}
	}
	  public function buat_captcha(){
        $vals = array(
		        'img_path' => './captcha/',
		        'img_url' => base_url().'captcha/',
		        'font_path' =>  FCPATH . 'captcha/font/captcha4.ttf',
		        'img_width' => '120',
		        'img_height' => 55,
		        'word_length' => 5,
		        'pool'          => '0123456789',
		        'expiration' => 60,
		        'colors'        => array(
		                'background' => array(255, 255, 255),
		                'border' => array(255, 255, 255),
		                'text' => array(89, 89, 89),
		                'grid' => array(255, 142, 142)
		        		)
        		);
        $cap = create_captcha($vals);
        return $cap;
    }
    public function post(){
        $this->form_validation->set_rules('kode_captcha', 'Kode Captcha', 'required|callback_cek_captcha');
        $this->form_validation->set_error_delimiters('<div style="border: 1px solid: #999999; background-color: #ffff99;">', '</div>');
        
        if ($this->form_validation->run() === FALSE) 
        {
            $data['title'] = 'Form Captcha';    
            $cap = $this->buat_captcha();
            $data['cap_img'] = $cap['image'];
            $this->session->set_userdata('kode_captcha', $cap['word']);
            
            $this->load->view('form_captcha', $data);
        } else  {
            $data['title'] = 'Captcha Benar!';
            $this->session->unset_userdata('kode_captcha');
            $this->load->view('captcha_sukses', $data);
        }
    }
    
    public function cek_captcha($input)
    {
        if($input === $this->session->userdata('kode_captcha')){
            return TRUE;
        } else {
            $this->form_validation->set_message('cek_captcha', '%s yang anda input salah!');
            return FALSE;
        }
    }
}