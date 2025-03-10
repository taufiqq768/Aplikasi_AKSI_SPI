<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function status_rekomendasi ()
    {
        if ($this->session->level=="admin" OR $this->session->level=="spi" OR $this->session->level=="verifikator" OR $this->session->level=="operator" OR $this->session->level=="kabagspi" OR $this->session->level=="viewer"  OR $this->session->level=="administrasi")  
        {
                $data['record'] = $this->db->query("SELECT 
                    COALESCE(t.jumlah_temuan, 0) AS jumlah_temuan,
                    l.tahun,
                    l.no_lha,
                    COALESCE(r.jumlah_rekomendasi, 0) AS jumlah_rekomendasi,
                    COALESCE(r.jumlah_s, 0) AS jumlah_s,
                    COALESCE(r.jumlah_bd, 0) AS jumlah_bd,
                    COALESCE(r.jumlah_bs, 0) AS jumlah_bs,
                    COALESCE(r.jumlah_tdd, 0) AS jumlah_tdd,
                    COALESCE(r.rekomendasi_status_tanggal, '-') AS rekomendasi_status_tanggal
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
                        MAX(rekomendasi_status_tanggal) AS rekomendasi_status_tanggal -- Menampilkan tanggal terbaru
                    FROM tb_rekomendasi
                    GROUP BY pemeriksaan_id
                ) r ON r.pemeriksaan_id = l.id_pemeriksaan

                GROUP BY l.tahun, l.no_lha, t.jumlah_temuan, r.jumlah_rekomendasi, r.jumlah_s, r.jumlah_bd, r.jumlah_bs, r.jumlah_tdd, r.rekomendasi_status_tanggal")->result_array();
            
            $data['record2'] = $this->db->query("SELECT t.tanggal, mt.kode_temuan, mt.klasifikasi_temuan, COALESCE(COUNT(tt.temu_id), 0) AS jumlah_kemunculan FROM (SELECT DISTINCT temuan_tgl AS tanggal FROM tb_temuan) t CROSS JOIN tb_master_temuan mt LEFT JOIN tb_temuan tt ON mt.temu_id = tt.temu_id AND t.tanggal = tt.temuan_tgl GROUP BY t.tanggal, mt.klasifikasi_temuan, mt.kode_temuan ORDER BY t.tanggal, mt.kode_temuan")->result_array();
            $data['record3'] = $this->db->query("SELECT 
                    t1.temuan_tgl AS tanggal,
                    bt.bidangtemuan_nama,
                    COALESCE(COUNT(t2.bidangtemuan_id), 0) AS jumlah_kemunculan
                FROM (SELECT DISTINCT DATE(temuan_tgl) AS temuan_tgl FROM tb_temuan) t1
                CROSS JOIN tb_bidangtemuan bt
                LEFT JOIN tb_temuan t2 
                    ON bt.bidangtemuan_id = t2.bidangtemuan_id 
                    AND DATE(t2.temuan_tgl) = t1.temuan_tgl
                GROUP BY t1.temuan_tgl, bt.bidangtemuan_nama
                ORDER BY t1.temuan_tgl, bt.bidangtemuan_nama")->result_array();
            $data['record4'] = $this->db->query("WITH Bulan AS (
                SELECT DISTINCT DATE_FORMAT(pemeriksaan_tgl_mulai, '%Y-%m') AS periode
                FROM tb_pemeriksaan
                WHERE YEAR(pemeriksaan_tgl_mulai) = YEAR(CURDATE()) -- Hanya ambil bulan yang ada di data
            ),
            JenisAudit AS (
                SELECT 'Rutin' AS jenis_audit UNION ALL
                SELECT 'Khusus' UNION ALL
                SELECT 'Tematik'
            )
            SELECT 
                b.periode AS bulan,
                j.jenis_audit,
                COALESCE(SUM(p.jumlah), 0) AS jumlah_pkpt,
                COALESCE(COUNT(DISTINCT pe.pemeriksaan_id), 0) AS jumlah_pemeriksaan
            FROM Bulan b
            CROSS JOIN JenisAudit j
            LEFT JOIN tb_pkpt p ON j.jenis_audit = p.jenis_audit
            LEFT JOIN tb_pemeriksaan pe 
                ON j.jenis_audit = pe.pemeriksaan_jenis 
                AND pe.pemeriksaan_pkpt = 'pkpt' 
                AND DATE_FORMAT(pe.pemeriksaan_tgl_mulai, '%Y-%m') = b.periode
            GROUP BY b.periode, j.jenis_audit
            ORDER BY b.periode, FIELD(j.jenis_audit, 'Rutin', 'Khusus', 'Tematik')")->result_array();
           

            $this->template->load('template','dashboard',$data);
        }
        else
        {
            redirect('administrator');
        }
    }

}