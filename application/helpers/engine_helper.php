<?php 
    function cek_session_akses($link,$id){
    	$ci = & get_instance();
    	$session = $ci->db->query("SELECT * FROM tb_modul,tb_usersmodul WHERE tb_modul.id_modul=tb_usersmodul.id_modul AND tb_usersmodul.id_session='$id' AND tb_modul.link='$link'")->num_rows();
    	// if ($session == '0' AND $ci->session->userdata('level') != 'admin'){
    	// 	redirect(base_url().'administrator/home');
    	// }
    }

    function background(){
        $ci = & get_instance();
        $bg = $ci->db->query("SELECT gambar FROM background ORDER BY id_background DESC LIMIT 1")->row_array();
        return $bg['gambar'];
    }

    function title(){
        $ci = & get_instance();
        $title = $ci->db->query("SELECT nama_website FROM tb_identitas ORDER BY id_identitas DESC LIMIT 1")->row_array();
        return $title['nama_website'];
    }

    function description(){
        $ci = & get_instance();
        $title = $ci->db->query("SELECT meta_deskripsi FROM tb_identitas ORDER BY id_identitas DESC LIMIT 1")->row_array();
        return $title['meta_deskripsi'];
    }

    function keywords(){
        $ci = & get_instance();
        $title = $ci->db->query("SELECT meta_keyword FROM tb_identitas ORDER BY id_identitas DESC LIMIT 1")->row_array();
        return $title['meta_keyword'];
    }

    function favicon(){
        $ci = & get_instance();
        $fav = $ci->db->query("SELECT favicon FROM tb_identitas ORDER BY id_identitas DESC LIMIT 1")->row_array();
        return $fav['favicon'];
    }

    function cek_session_admin(){
        $ci = & get_instance();
        $session = $ci->session->userdata('level');
        if ($session != 'admin'){
            redirect(base_url());
        }
    }