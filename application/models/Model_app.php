<?php 
class Model_app extends CI_Model{

	function cek_login($username, $password, $table){
		return $this->db->query("SELECT * FROM $table WHERE user_nik='".$this->db->escape_str($username)."' AND user_password='".$this->db->escape_str($password)."' AND user_aktif='Y'");
	}
	public function view($table){
        return $this->db->get($table);
    }
    public function edit($table, $data){
        return $this->db->get_where($table, $data);
    }
    public function insert($table,$data){
        return $this->db->insert($table, $data);
    }
    public function update($table, $data, $where){
        return $this->db->update($table, $data, $where); 
    }
    public function delete($table, $where){
        return $this->db->delete($table, $where);
    }
     public function delete_where($table,$attr, $where){
        return $this->db->delete($table,$attr, $where);
    }
    public function insert_filepesan($data = array()){
        $insert = $this->db->insert_batch('tb_upload_pesan',$data);
        return $insert?true:false;
    }
    public function view_where($table,$attr,$data){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($attr,$data);
        return $this->db->get()->result_array();
    }
    public function view_where2($table,$attr,$data,$attr2,$data2){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($attr,$data)->where($attr2, $data2);
        return $this->db->get()->result_array();
    }
    public function view_profile($table,$data){
        $this->db->where($data);
        return $this->db->get($table);
    }
    public function view_ordering($table,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }
    public function view_where_or_ordering($attr,$attr2,$table,$data,$data2,$order,$ordering){
        $this->db->select('*');
        $this->db->where($attr, $data);
        $this->db->or_where($attr2, $data2);
        $this->db->order_by($order,$ordering);
        $query = $this->db->get($table);
        return $query->result_array();
    }
    public function view_join_where_or_ordering($attr,$attr2,$table1,$table2,$field,$data,$data2,$order,$ordering){
        $this->db->select('*');
        $this->db->where($attr, $data);
        $this->db->or_where($attr2, $data2);
        $this->db->order_by($order,$ordering);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $query = $this->db->get($table1);
        return $query->result_array();
    }
    public function view_where_ordering($attr,$table,$data,$order,$ordering){
        $this->db->select('*');
        $this->db->where($attr, $data);
        $this->db->order_by($order,$ordering);
        $query = $this->db->get($table);
        return $query->result_array();
    }
    public function view_where2_ordering($table,$attr,$data,$attr2,$data2,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($attr,$data)->where($attr2, $data2);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }
    public function view_where3_ordering($table,$attr,$data,$attr2,$data2,$attr3,$data3,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($attr,$data)->where($attr2, $data2)->where($attr3, $data3);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }
    public function view_join_where($attr,$data,$table1,$table2,$field,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->where($attr,$data);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->order_by($order, $ordering);
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function view_join_where_field2($attr,$data,$table1,$table2,$field,$field2,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->where($attr,$data);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field2);
        $this->db->order_by($order, $ordering);
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function join_where_ordering($attr,$data,$table1,$table2,$field){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->where($table1.'.'.$attr.'='. $data);
        $result = $this->db->get()->result_array();
        return $result;
    }
     public function view_join($table1,$table2,$field,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }
    public function view_rekom($id_temuan,$table1,$table2,$field){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->where('tb_rekomendasi'.'.'.'temuan_id'.'='. $id_temuan);
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function view_join_two($where,$data,$table1,$table2,$table3,$field,$field1,$order,$ordering){
    $this->db->select('*');
    $this->db->from($table1);
    $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
    $this->db->join($table3, $table1.'.'.$field1.'='.$table3.'.'.$field1);
    $this->db->order_by($order,$ordering);
    $this->db->where($table1.'.'.$where.'='. $data);
    //$this->db->limit($limit);
    $result = $this->db->get()->result_array();
    return $result;
   }
   public function view_join_two_not_where($table1,$table2,$table3,$field,$field1,$order,$ordering){
    $this->db->select('*');
    $this->db->from($table1);
    $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
    $this->db->join($table3, $table1.'.'.$field1.'='.$table3.'.'.$field1);
    $this->db->order_by($order,$ordering);
    //$this->db->limit($limit);
    $result = $this->db->get()->result_array();
    return $result;
   }
    public function view_join_two_limit($where,$data,$table1,$table2,$table3,$field,$field1,$order,$ordering,$limit){
    $this->db->select('*');
    $this->db->from($table1);
    $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
    $this->db->join($table3, $table1.'.'.$field1.'='.$table3.'.'.$field1);
    $this->db->order_by($order,$ordering);
    $this->db->where($table1.'.'.$where.'='. $data);
    $this->db->limit($limit);
    $result = $this->db->get()->result_array();
    return $result;
   }
    public function view_join_three($where,$data,$table1,$table2,$table3,$table4,$field,$field1,$field2,$order,$ordering){
    $this->db->select('*');
    $this->db->from($table1);
    $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
    $this->db->join($table3, $table1.'.'.$field1.'='.$table3.'.'.$field1);
    $this->db->join($table4, $table1.'.'.$field2.'='.$table4.'.'.$field2);
    $this->db->order_by($order,$ordering);
    $this->db->where($table1.'.'.$where.'='. $data);
    $result = $this->db->get()->result_array();
    return $result;
   }
   public function view_join_three_where2($where1,$data1,$where2,$data2,$table1,$table2,$table3,$table4,$field,$field1,$field2,$order,$ordering){
    $this->db->select('*');
    $this->db->from($table1);
    $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
    $this->db->join($table3, $table1.'.'.$field1.'='.$table3.'.'.$field1);
    $this->db->join($table4, $table1.'.'.$field2.'='.$table4.'.'.$field2);
    $this->db->order_by($order,$ordering);
    $this->db->where($table1.'.'.$where1.'='. $data1)->where($where2, $data2);
    $result = $this->db->get()->result_array();
    return $result;
   }
   public function view_join_three_limit($where,$data,$table1,$table2,$table3,$table4,$field,$field1,$field2,$order,$ordering,$limit){
    $this->db->select('*');
    $this->db->from($table1);
    $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
    $this->db->join($table3, $table1.'.'.$field1.'='.$table3.'.'.$field1);
    $this->db->join($table4, $table1.'.'.$field2.'='.$table4.'.'.$field2);
    $this->db->order_by($order,$ordering);
    $this->db->where($table1.'.'.$where.'='. $data);
    $this->db->limit($limit);
    $result = $this->db->get()->result_array();
    return $result;
   }
   public function view_select_where($select,$table,$attr,$data){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($attr,$data);
        return $this->db->get()->result();
    }
    function hapus_file($id){
        $hasil=$this->db->query("DELETE FROM tb_upload_tl WHERE uploadtl_id='$id'");
        return $hasil;
    }
    function hapus_file_rekom($id){
        $hasil=$this->db->query("DELETE FROM tb_upload_rekom WHERE uploadrekom_id='$id'");
        return $hasil;
    }
    function hapus_file_tanggapan($id){
        $hasil=$this->db->query("DELETE FROM tb_upload_tanggapan WHERE uploadtanggapan_id='$id'");
        return $hasil;
    }
    function hapus_file_faq($id){
        $hasil=$this->db->query("DELETE FROM tb_upload_faq WHERE uploadfaq_id='$id'");
        return $hasil;
    }
    function get_file_by_id($id){
        $hsl=$this->db->query("SELECT * FROM tb_upload_tl WHERE uploadtl_id='$id'");
        if($hsl->num_rows()>0){
            foreach ($hsl->result() as $data) {
                $hasil=array(
                    'uploadtl_id' => $data->uploadtl_id,
                    'uploadtl_nama' => $data->uploadtl_nama,
                    'uploadtl_tgl' => $data->uploadtl_tgl,
                    );
            }
        }
        return $hasil;
    }
    function edit_file($id,$filename,$tgl){
        $hasil=$this->db->query("UPDATE tb_upload_tl SET uploadtl_nama='$filename',uploadtl_tgl='$tgl' WHERE uploadtl_id='$id'");
        return $hasil;
    }

    // function select_tabel($jenis){
    //     $hasil = $this->db->query("SELECT * FROM `tb_pemeriksaan` INNER JOIN tb_temuan ON tb_pemeriksaan.pemeriksaan_id = tb_temuan.pemeriksaan_id INNER JOIN tb_rekomendasi ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id INNER JOIN tb_tl ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id WHERE NOT (rekomendasi_status = 'Sudah di Tindak Lanjut' OR 'Sudah TL (Belum Optimal)') AND pemeriksaan_jenis = '$jenis' ");
    //     return $hasil;
    // }
    // function select_tabel($jenis){
    //     $hasil = $this->db->query("SELECT * FROM `tb_pemeriksaan` INNER JOIN tb_temuan ON tb_pemeriksaan.pemeriksaan_id = tb_temuan.pemeriksaan_id INNER JOIN tb_rekomendasi ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id INNER JOIN tb_tl ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id WHERE NOT (rekomendasi_status = 'Sudah di Tindak Lanjut' OR rekomendasi_status='Sudah TL (Belum Optimal)') AND pemeriksaan_jenis = '$jenis' AND kebun_id='$kebun' ");
    //     return $hasil;
    // }
    function select_tabel($jenis, $kebun){
        $hasil = $this->db->query("SELECT * FROM `tb_pemeriksaan` INNER JOIN tb_temuan ON tb_pemeriksaan.pemeriksaan_id = tb_temuan.pemeriksaan_id INNER JOIN tb_rekomendasi ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id INNER JOIN tb_tl ON tb_tl.rekomendasi_id = tb_rekomendasi.rekomendasi_id WHERE NOT (rekomendasi_status = 'Sudah di Tindak Lanjut' OR rekomendasi_status = 'Closed') AND pemeriksaan_jenis = '$jenis' AND kebun_id='$kebun'");
        return $hasil;
    }
    function select_tabelb($jenis, $kebun){
        $hasil = $this->db->query("SELECT * FROM `tb_pemeriksaan` INNER JOIN tb_temuan ON tb_pemeriksaan.pemeriksaan_id = tb_temuan.pemeriksaan_id INNER JOIN tb_rekomendasi ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id WHERE NOT (rekomendasi_status = 'Sudah di Tindak Lanjut' OR 'rekomendasi_status' = 'Closed') AND rekomendasi_status = 'Belum di Tindak Lanjut'  AND pemeriksaan_jenis = '$jenis' AND kebun_id='$kebun'");
        return $hasil;
    }
    public function daftar_kotakmasuk($attr,$attr2,$table1,$table2,$field,$data,$data2,$order,$ordering,$limit){
        $this->db->select('*');
        $this->db->where($attr, $data);
        $this->db->or_where($attr2, $data2);
        $this->db->order_by($order,$ordering);
        $this->db->limit($limit);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $query = $this->db->get($table1);
        return $query->result_array();
    }
    function get_nama($search_nama, $column){
            $this->db->select($column);
            $this->db->from('tb_users');
            $this->db->like('user_nama', $search_nama);
            return $this->db->get()->result_array();
        }
    public function lupapassword_key($email, $nik, $reset_key){
        $this->db->where('user_email', $email);
        $data = array('reset_password' => $reset_key);
        $this->db->update('tb_users', $data);
        if ($this->db->affected_rows()>0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    public function get_data_pivot($table)
    {
        $query = $this->db->query("
            SELECT pkpt_id, jenis_audit, bulan, jumlah 
            FROM $table  
            WHERE tahun = YEAR(CURDATE()) 
            ORDER BY FIELD(jenis_audit, 'Rutin', 'Khusus', 'Tematik')
        ");

        return $query->result_array();
    }
    public function get_data_custom($table, $columns)
    {
        $this->db->select("{$columns['id']} as key, {$columns['name']} as value");
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function view_join_four_table($table1,$table2,$table3,$table4,$order,$ordering,$attr,$data,$field1,$field2,$field3,$field4,$field5,$field6){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->where($attr, $data);
        $this->db->join($table2, $table1.'.'.$field1.'='.$table2.'.'.$field2);
        $this->db->join($table3, $table1.'.'.$field5.'='.$table3.'.'.$field3);
        $this->db->join($table4, $table1.'.'.$field6.'='.$table4.'.'.$field4);
        $this->db->order_by($order,$ordering);
        $result =$this->db->get()->result_array();
        return $result;
    }
    public function view_join_five_table($table1,$table2,$table3,$table4,$table5,$order,$ordering,$attr,$data,$field1,$field2,$field3,$field4,$field5,$field6,$field7,$field8){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->where($attr, $data);
        $this->db->join($table2, $table1.'.'.$field1.'='.$table2.'.'.$field2);
        $this->db->join($table3, $table1.'.'.$field5.'='.$table3.'.'.$field3);
        $this->db->join($table4, $table1.'.'.$field6.'='.$table4.'.'.$field4);
        $this->db->join($table5, $table1.'.'.$field7.'='.$table5.'.'.$field8);
        $this->db->order_by($order,$ordering);
        $result =$this->db->get()->result_array();
        return $result;
    }
    public function view_join_where3($table1,$attr,$data,$attr2,$data2,$table2,$field1,$field2,$attr3,$data3){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->where($attr,$data);
        $this->db->where($attr2, $data2);
        $this->db->where($attr3, $data3);
        $this->db->join($table2, $table1.'.'.$field1.'='.$table2.'.'.$field2, 'left');
        return $this->db->get()->result_array();
    }
}

 ?>