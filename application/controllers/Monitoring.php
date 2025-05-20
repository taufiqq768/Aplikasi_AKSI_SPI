<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {
    public function tindak_lanjut ()
    {
        if ($this->session->level=="admin" OR $this->session->level=="spi" OR $this->session->level=="verifikator" OR $this->session->level=="operator" OR $this->session->level=="kabagspi" OR $this->session->level=="viewer"  OR $this->session->level=="administrasi")  
        {
                //Audit Rutin
                $data['rutin'] = $this->db->query("SELECT 
                COALESCE(t.jumlah_temuan, 0) AS jumlah_temuan,
                l.tahun,
                l.no_lha,
                COALESCE(r.jumlah_rekomendasi, 0) AS jumlah_rekomendasi,
                COALESCE(r.jumlah_s, 0) AS jumlah_s,
                COALESCE(r.jumlah_bd, 0) AS jumlah_bd,
                COALESCE(r.jumlah_bs, 0) AS jumlah_bs,
                COALESCE(r.jumlah_tdd, 0) AS jumlah_tdd,
                COALESCE(r.rekomendasi_status_tanggal, '-') AS rekomendasi_status_tanggal,
                p.pemeriksaan_jenis
                FROM tb_lha l
                LEFT JOIN (
                    SELECT 
                        pemeriksaan_id, 
                        COUNT(DISTINCT temuan_id) AS jumlah_temuan 
                    FROM tb_temuan 
                    GROUP BY pemeriksaan_id
                ) t ON t.pemeriksaan_id = l.id_pemeriksaan
                LEFT JOIN (
                    SELECT 
                        pemeriksaan_id, 
                        COUNT(DISTINCT rekomendasi_id) AS jumlah_rekomendasi,
                        SUM(CASE WHEN rekomendasi_status = 'Sesuai' THEN 1 ELSE 0 END) AS jumlah_s,
                        SUM(CASE WHEN rekomendasi_status = 'Belum di Tindak Lanjut' THEN 1 ELSE 0 END) AS jumlah_bd,
                        SUM(CASE WHEN rekomendasi_status = 'Belum Sesuai' THEN 1 ELSE 0 END) AS jumlah_bs,
                        SUM(CASE WHEN rekomendasi_status = 'Tidak dapat di Tindak Lanjuti' THEN 1 ELSE 0 END) AS jumlah_tdd,
                        MAX(rekomendasi_status_tanggal) AS rekomendasi_status_tanggal
                    FROM tb_rekomendasi 
                    GROUP BY pemeriksaan_id
                ) r ON r.pemeriksaan_id = l.id_pemeriksaan
                LEFT JOIN tb_pemeriksaan p ON p.pemeriksaan_id = l.id_pemeriksaan
                WHERE p.pemeriksaan_jenis = 'Rutin'
                GROUP BY 
                    l.tahun, 
                    l.no_lha, 
                    t.jumlah_temuan, 
                    r.jumlah_rekomendasi, 
                    r.jumlah_s, 
                    r.jumlah_bd, 
                    r.jumlah_bs, 
                    r.jumlah_tdd, 
                    r.rekomendasi_status_tanggal,
                    p.pemeriksaan_jenis")->result_array();

                //Audit khusus
                $data['khusus'] = $this->db->query("SELECT 
                COALESCE(t.jumlah_temuan, 0) AS jumlah_temuan,
                l.tahun,
                l.no_lha,
                COALESCE(r.jumlah_rekomendasi, 0) AS jumlah_rekomendasi,
                COALESCE(r.jumlah_s, 0) AS jumlah_s,
                COALESCE(r.jumlah_bd, 0) AS jumlah_bd,
                COALESCE(r.jumlah_bs, 0) AS jumlah_bs,
                COALESCE(r.jumlah_tdd, 0) AS jumlah_tdd,
                COALESCE(r.rekomendasi_status_tanggal, '-') AS rekomendasi_status_tanggal,
                p.pemeriksaan_jenis
                FROM tb_lha l
                LEFT JOIN (
                    SELECT 
                        pemeriksaan_id, 
                        COUNT(DISTINCT temuan_id) AS jumlah_temuan 
                    FROM tb_temuan 
                    GROUP BY pemeriksaan_id
                ) t ON t.pemeriksaan_id = l.id_pemeriksaan
                LEFT JOIN (
                    SELECT 
                        pemeriksaan_id, 
                        COUNT(DISTINCT rekomendasi_id) AS jumlah_rekomendasi,
                        SUM(CASE WHEN rekomendasi_status = 'Sesuai' THEN 1 ELSE 0 END) AS jumlah_s,
                        SUM(CASE WHEN rekomendasi_status = 'Belum di Tindak Lanjut' THEN 1 ELSE 0 END) AS jumlah_bd,
                        SUM(CASE WHEN rekomendasi_status = 'Belum Sesuai' THEN 1 ELSE 0 END) AS jumlah_bs,
                        SUM(CASE WHEN rekomendasi_status = 'Tidak dapat di Tindak Lanjuti' THEN 1 ELSE 0 END) AS jumlah_tdd,
                        MAX(rekomendasi_status_tanggal) AS rekomendasi_status_tanggal
                    FROM tb_rekomendasi 
                    GROUP BY pemeriksaan_id
                ) r ON r.pemeriksaan_id = l.id_pemeriksaan
                LEFT JOIN tb_pemeriksaan p ON p.pemeriksaan_id = l.id_pemeriksaan
                WHERE p.pemeriksaan_jenis = 'Khusus'
                GROUP BY 
                    l.tahun, 
                    l.no_lha, 
                    t.jumlah_temuan, 
                    r.jumlah_rekomendasi, 
                    r.jumlah_s, 
                    r.jumlah_bd, 
                    r.jumlah_bs, 
                    r.jumlah_tdd, 
                    r.rekomendasi_status_tanggal,
                    p.pemeriksaan_jenis")->result_array();

                //Audit tematik
                $data['tematik'] = $this->db->query("SELECT 
                COALESCE(t.jumlah_temuan, 0) AS jumlah_temuan,
                l.tahun,
                l.no_lha,
                COALESCE(r.jumlah_rekomendasi, 0) AS jumlah_rekomendasi,
                COALESCE(r.jumlah_s, 0) AS jumlah_s,
                COALESCE(r.jumlah_bd, 0) AS jumlah_bd,
                COALESCE(r.jumlah_bs, 0) AS jumlah_bs,
                COALESCE(r.jumlah_tdd, 0) AS jumlah_tdd,
                COALESCE(r.rekomendasi_status_tanggal, '-') AS rekomendasi_status_tanggal,
                p.pemeriksaan_jenis
                FROM tb_lha l
                LEFT JOIN (
                    SELECT 
                        pemeriksaan_id, 
                        COUNT(DISTINCT temuan_id) AS jumlah_temuan 
                    FROM tb_temuan 
                    GROUP BY pemeriksaan_id
                ) t ON t.pemeriksaan_id = l.id_pemeriksaan
                LEFT JOIN (
                    SELECT 
                        pemeriksaan_id, 
                        COUNT(DISTINCT rekomendasi_id) AS jumlah_rekomendasi,
                        SUM(CASE WHEN rekomendasi_status = 'Sesuai' THEN 1 ELSE 0 END) AS jumlah_s,
                        SUM(CASE WHEN rekomendasi_status = 'Belum di Tindak Lanjut' THEN 1 ELSE 0 END) AS jumlah_bd,
                        SUM(CASE WHEN rekomendasi_status = 'Belum Sesuai' THEN 1 ELSE 0 END) AS jumlah_bs,
                        SUM(CASE WHEN rekomendasi_status = 'Tidak dapat di Tindak Lanjuti' THEN 1 ELSE 0 END) AS jumlah_tdd,
                        MAX(rekomendasi_status_tanggal) AS rekomendasi_status_tanggal
                    FROM tb_rekomendasi 
                    GROUP BY pemeriksaan_id
                ) r ON r.pemeriksaan_id = l.id_pemeriksaan
                LEFT JOIN tb_pemeriksaan p ON p.pemeriksaan_id = l.id_pemeriksaan
                WHERE p.pemeriksaan_jenis = 'Tematik'
                GROUP BY 
                    l.tahun, 
                    l.no_lha, 
                    t.jumlah_temuan, 
                    r.jumlah_rekomendasi, 
                    r.jumlah_s, 
                    r.jumlah_bd, 
                    r.jumlah_bs, 
                    r.jumlah_tdd, 
                    r.rekomendasi_status_tanggal,
                    p.pemeriksaan_jenis")->result_array();

                    $this->template->load('template','kelola-monitoring-tl/monitoring_tl',$data);
        }
        else
        {
            redirect('monitoring');
        }
    }

    public function rincian_tl($jenis_audit,$tahun){
        if ($this->session->level=="admin" OR $this->session->level=="spi" OR $this->session->level=="verifikator" OR $this->session->level=="operator" OR $this->session->level=="kabagspi" OR $this->session->level=="viewer"  OR $this->session->level=="administrasi")  
        {
            $this->db->select("
            COALESCE(t.jumlah_temuan, 0) AS jumlah_temuan,
            l.tahun,
            l.no_lha,
            COALESCE(r.jumlah_rekomendasi, 0) AS jumlah_rekomendasi,
            COALESCE(r.jumlah_s, 0) AS jumlah_s,
            COALESCE(r.jumlah_bd, 0) AS jumlah_bd,
            COALESCE(r.jumlah_bs, 0) AS jumlah_bs,
            COALESCE(r.jumlah_tdd, 0) AS jumlah_tdd,
            COALESCE(r.rekomendasi_status_tanggal, '-') AS rekomendasi_status_tanggal,
            p.pemeriksaan_judul,
            p.pemeriksaan_jenis,
            p.pemeriksaan_id
        ");
    
        $this->db->from('tb_lha l');
    
        $this->db->join(
            "(SELECT 
                pemeriksaan_id, 
                COUNT(DISTINCT temuan_id) AS jumlah_temuan 
              FROM tb_temuan 
              GROUP BY pemeriksaan_id) t",
            't.pemeriksaan_id = l.id_pemeriksaan',
            'left'
        );
    
        $this->db->join(
            "(SELECT 
                pemeriksaan_id,
                COUNT(DISTINCT rekomendasi_id) AS jumlah_rekomendasi,
                SUM(CASE WHEN rekomendasi_status = 'Sesuai' THEN 1 ELSE 0 END) AS jumlah_s,
                SUM(CASE WHEN rekomendasi_status = 'Belum di Tindak Lanjut' THEN 1 ELSE 0 END) AS jumlah_bd,
                SUM(CASE WHEN rekomendasi_status = 'Belum Sesuai' THEN 1 ELSE 0 END) AS jumlah_bs,
                SUM(CASE WHEN rekomendasi_status = 'Tidak dapat di Tindak Lanjuti' THEN 1 ELSE 0 END) AS jumlah_tdd,
                MAX(rekomendasi_status_tanggal) AS rekomendasi_status_tanggal
              FROM tb_rekomendasi 
              GROUP BY pemeriksaan_id) r",
            'r.pemeriksaan_id = l.id_pemeriksaan',
            'left'
        );
    
        $this->db->join('tb_pemeriksaan p', 'p.pemeriksaan_id = l.id_pemeriksaan', 'left');
    
        $this->db->where('p.pemeriksaan_jenis', $jenis_audit);
        $this->db->where('l.tahun', $tahun);
    
        $this->db->group_by([
            'l.tahun',
            'l.no_lha',
            't.jumlah_temuan',
            'r.jumlah_rekomendasi',
            'r.jumlah_s',
            'r.jumlah_bd',
            'r.jumlah_bs',
            'r.jumlah_tdd',
            'r.rekomendasi_status_tanggal',
            'p.pemeriksaan_judul',
            'p.pemeriksaan_jenis',
            'p.pemeriksaan_id'
        ]);
    
        $query = $this->db->get();
        $data['rincian_tl'] = $query->result_array();
                
        $this->template->load('template','kelola-monitoring-tl/rincian_tl',$data);
        
        }
        else
        {
            redirect('monitoring');
        }

    }

    public function detail_tl(){
        if ($this->session->level=="admin" OR $this->session->level=="spi" OR $this->session->level=="verifikator" OR $this->session->level=="operator" OR $this->session->level=="kabagspi" OR $this->session->level=="viewer"  OR $this->session->level=="administrasi")  
        {
            $data['bidang'] = "Semua Bidang";
            $data['rentang'] = "semua";
            $data['bidang_tmn'] = 'semuabidang';
            $data['tgl_mulai'] = '';
            $pemeriksaan_id= $this->uri->segment(3);
            $status_rekomendasi = $this->input->post('status_rekomendasi');
            if ($this->session->level=="operator" OR $this->session->level=="verifikator") {
                $unit = $this->session->unit;
                $data['record'] = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id WHERE pemeriksaan_jenis = 'Rutin' AND pemeriksaan_aktif = 'Y' AND kebun_id = '$unit' AND `rekomendasi_kirim` = 'Y' AND pemeriksaan_id = '$pemeriksaan_id' ORDER BY pemeriksaan_tgl ASC")->result_array(); 
            }else if($pemeriksaan_id != null){
                 $data['record'] = $this->db->query("SELECT * FROM tb_rekomendasi JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id WHERE tb_pemeriksaan.pemeriksaan_id = '$pemeriksaan_id' ORDER BY tb_rekomendasi.temuan_id ASC")->result_array();
            }
            else{
                $status_rekomendasi = $this->input->post('status_rekomendasi');
                $pemeriksaan_id = $this->input->post('pemeriksaan_id');
                $allowed_status = ['Sesuai', 'Belum Sesuai', 'Belum di Tindak Lanjut', 'Tidak Dapat Ditindaklanjuti'];
                if (in_array($status_rekomendasi, $allowed_status)) {
                    $data['record'] = $this->db->query("
                        SELECT * FROM tb_rekomendasi 
                        JOIN tb_pemeriksaan ON tb_rekomendasi.pemeriksaan_id = tb_pemeriksaan.pemeriksaan_id 
                        JOIN tb_temuan ON tb_rekomendasi.temuan_id = tb_temuan.temuan_id 
                        WHERE tb_pemeriksaan.pemeriksaan_id = '$pemeriksaan_id' 
                        AND tb_rekomendasi.status_rekomendasi = '$status_rekomendasi'
                        ORDER BY tb_rekomendasi.temuan_id ASC
                    ")->result_array();
                } else {
                    $data['record'] = [];
                }
            }
            // print_r($data); die();
            $this->template->load('template','kelola-monitoring-tl/detail_tl', $data);
        
        }
        else
        {
            redirect('monitoring');
        }
    }
}