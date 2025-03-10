<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_dbase extends CI_Controller {

	public function list_backup(){
		$data['record'] = $this->model_app->view_ordering('tb_backupdb', 'backup_id', 'DESC');
		$this->template->load('template', 'kelola-db/list_backupdb', $data);
	}

	public function backup_db(){

		// $this->template->load('template','kelola-db/list_backupdb');
		$this->load->dbutil();
		$prefs = array(     
		    'format'      => 'zip',             
		    'filename'    => 'simon.sql'
		    );
		$date = date('Y-m-d H:i');
		// $usr = $this->model_app->view_profile('tb_users', array('user_nik'=> $this->session->username))->row_array();
		// $data = array ('backup_date' => $date, 'backup_user' => $usr['user_nama'] );
		// $this->model_app->insert('tb_backupdb', $data);
		$backup =& $this->dbutil->backup($prefs); 

		$db_name = 'simonTL_backup-on-'. $date .'.zip';
		//$save = 'asset/'.$db_name;

		$this->load->helper('file');
		write_file($save, $backup); 

		$this->load->helper('download');
		force_download($db_name, $backup);
	}
	
}