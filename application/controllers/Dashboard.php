<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('kalender_helper');
    }

	public function status_rekomendasi ()
    {
        if ($this->session->level=="admin" OR $this->session->level=="spi" OR $this->session->level=="verifikator" OR $this->session->level=="operator" OR $this->session->level=="kabagspi" OR $this->session->level=="viewer"  OR $this->session->level=="administrasi")  
        {
                //Record
                $data['record'] = $this->db->query("SELECT 
                    CONCAT('LHA Terbit ', DATE_FORMAT(MAX(r.rekomendasi_status_tanggal), '%Y')) AS uraian,
                    DATE_FORMAT(r.rekomendasi_status_tanggal, '%Y-%m') AS bulan,
                    COUNT(DISTINCT l.no_lha) AS jumlah_lha,
                    SUM(COALESCE(t.jumlah_temuan, 0)) AS jumlah_temuan,
                    SUM(COALESCE(r.jumlah_rekomendasi, 0)) AS jumlah_rekomendasi
                FROM 
                    tb_lha l
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
                        MAX(rekomendasi_status_tanggal) AS rekomendasi_status_tanggal
                    FROM tb_rekomendasi 
                    GROUP BY pemeriksaan_id
                ) r ON r.pemeriksaan_id = l.id_pemeriksaan
                WHERE 
                    r.rekomendasi_status_tanggal IS NOT NULL
                GROUP BY 
                    DATE_FORMAT(r.rekomendasi_status_tanggal, '%Y-%m')
                ORDER BY 
                    bulan ASC")->result_array();
            
             // DATA BULAN BERJALAN SAJA RECORD 2
            $data['bulan_berjalan'] = $this->db->query("
            SELECT 
                t.tanggal, 
                mt.kode_temuan, 
                mt.klasifikasi_temuan, 
                COALESCE(COUNT(tt.temu_id), 0) AS jumlah_kemunculan
            FROM (
                SELECT DISTINCT temuan_tgl AS tanggal 
                FROM tb_temuan 
                WHERE MONTH(temuan_tgl) = MONTH(CURDATE()) 
                AND YEAR(temuan_tgl) = YEAR(CURDATE())
            ) t
            CROSS JOIN tb_master_temuan mt
            LEFT JOIN tb_temuan tt 
                ON mt.temu_id = tt.temu_id 
            AND t.tanggal = tt.temuan_tgl
            GROUP BY t.tanggal, mt.klasifikasi_temuan, mt.kode_temuan
            ORDER BY t.tanggal, mt.kode_temuan")->result_array();

        // -------------------------------
        // DATA DARI JANUARI S/D BULAN SEKARANG RECORD 2
        $data['kumulatif'] = $this->db->query("
            SELECT 
                t.tanggal, 
                mt.kode_temuan, 
                mt.klasifikasi_temuan, 
                COALESCE(COUNT(tt.temu_id), 0) AS jumlah_kemunculan
            FROM (
                SELECT DISTINCT temuan_tgl AS tanggal 
                FROM tb_temuan 
                WHERE MONTH(temuan_tgl) <= MONTH(CURDATE()) 
                AND YEAR(temuan_tgl) = YEAR(CURDATE())
            ) t
            CROSS JOIN tb_master_temuan mt
            LEFT JOIN tb_temuan tt 
                ON mt.temu_id = tt.temu_id 
            AND t.tanggal = tt.temuan_tgl
            GROUP BY t.tanggal, mt.klasifikasi_temuan, mt.kode_temuan
            ORDER BY t.tanggal, mt.kode_temuan")->result_array();
            
            //Record3
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
                // Data dari query
                $record3 = $data['record3'];

                // Ambil bulan dan tahun saat ini
                $bulanSekarang = date('n');
                $tahunSekarang = date('Y');

                // Siapkan array data
                $bulan_berjalan = [];
                $kumulatif = [];

                foreach ($record3 as $row) {
                    $tanggal = date('Y-m-d', strtotime($row['tanggal']));
                    $bulan = (int)date('n', strtotime($row['tanggal']));
                    $tahun = (int)date('Y', strtotime($row['tanggal']));

                    if ($bulan == $bulanSekarang && $tahun == $tahunSekarang) {
                        $bulan_berjalan[] = $row;
                    }

                    if ($bulan <= $bulanSekarang && $tahun == $tahunSekarang) {
                        $kumulatif[] = $row;
                    }
                }

                $data['record_bidang_bulan'] = $bulan_berjalan;
                $data['record_bidang_kumulatif'] = $kumulatif;

            //Record4    
            $data['record4'] = $this->db->query("WITH Bulan AS (
            SELECT DISTINCT DATE_FORMAT(pemeriksaan_tgl_mulai, '%Y-%m') AS periode
            FROM tb_pemeriksaan
            WHERE YEAR(pemeriksaan_tgl_mulai) = YEAR(CURDATE())
        ),
        JenisAudit AS (
            SELECT 'Rutin' AS jenis_audit
            UNION ALL SELECT 'Khusus'
            UNION ALL SELECT 'Tematik'
        ),
        PemeriksaanFix AS (
            SELECT 
                pemeriksaan_id,
                pemeriksaan_jenis,
                DATE_FORMAT(pemeriksaan_tgl_mulai, '%Y-%m') AS periode
            FROM tb_pemeriksaan
            WHERE YEAR(pemeriksaan_tgl_mulai) = YEAR(CURDATE())
        ),
        PKPT_Sum AS (
            SELECT 
                jenis_audit,
                SUM(jumlah) AS jumlah_pkpt
            FROM tb_pkpt
            GROUP BY jenis_audit
        )
        SELECT 
            b.periode AS bulan,
            j.jenis_audit,
            COALESCE(pks.jumlah_pkpt, 0) AS jumlah_pkpt,
            COALESCE(COUNT(DISTINCT pf.pemeriksaan_id), 0) AS jumlah_pemeriksaan
        FROM Bulan b
        CROSS JOIN JenisAudit j
        LEFT JOIN PKPT_Sum pks 
            ON j.jenis_audit = pks.jenis_audit
        LEFT JOIN PemeriksaanFix pf 
            ON j.jenis_audit = pf.pemeriksaan_jenis
            AND pf.periode = b.periode
        GROUP BY b.periode, j.jenis_audit, pks.jumlah_pkpt
        ORDER BY b.periode, FIELD(j.jenis_audit, 'Rutin', 'Khusus', 'Tematik');
        ")->result_array();
           
            $this->template->load('template','dashboard',$data);
        }
        else
        {
            redirect('administrator');
        }
    }

}