<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sertifikat_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('file');
    }
    
    public function insert($data, $user_id)
    {
        $kode   = $this->_generate_kode();
        $insert = array_merge($data, [
            'kode_pengajuan' => $kode,
            'status'         => 'approved',
            'submitted_at'   => date('Y-m-d H:i:s'),
            'approved_at'    => date('Y-m-d H:i:s'),
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);

        $this->db->insert('pengajuan_sertifikat', $insert);
        $id = $this->db->insert_id();

        if ($id) {
            $this->_log($id, null, 'approved', 'Pengajuan otomatis disetujui', $user_id, 'mahasiswa');
            
            // Generate file export (CSV/Excel sederhana)
            $this->_export_to_csv($id, $insert);
            
            return $kode;
        }
        return false;
    }
    
    /**
     * Export ke CSV (tanpa library tambahan)
     */
    private function _export_to_csv($id, $data)
    {
        $filename = 'pengajuan_' . $data['kode_pengajuan'] . '_' . date('Ymd_His') . '.csv';
        $path = FCPATH . 'uploads/sertifikat/export/';
        
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        
        $filepath = $path . $filename;
        
        // Buka file untuk ditulis
        $fp = fopen($filepath, 'w');
        
        // Set header CSV (pakai delimiter titik koma untuk Excel Indonesia)
        fputcsv($fp, ['DATA PENGAJUAN SERTIFIKAT'], ';');
        fputcsv($fp, [], ';');
        
        // Data pengajuan
        $fields = [
            ['Kode Pengajuan', $data['kode_pengajuan']],
            ['Tanggal Pengajuan', date('d-m-Y H:i:s')],
            ['', ''],
            ['Judul Kegiatan', $data['judul_kegiatan']],
            ['Tanggal Kegiatan', $data['tanggal_kegiatan']],
            ['Lokasi Kegiatan', $data['lokasi_kegiatan']],
            ['Nama PIC', $data['nama_pic']],
            ['NIM', $data['nim']],
            ['Nama Mahasiswa', $data['nama_mahasiswa']],
            ['Program Studi', $data['prodi']],
            ['Deskripsi Kegiatan', $data['deskripsi_kegiatan'] ?? '-'],
            ['Catatan Tambahan', $data['catatan_tambahan'] ?? '-'],
        ];
        
        foreach ($fields as $field) {
            fputcsv($fp, $field, ';');
        }
        
        fclose($fp);
        
        // Simpan path file ke database
        $this->db->where('id', $id);
        $this->db->update('pengajuan_sertifikat', ['file_export' => 'uploads/sertifikat/export/' . $filename]);
        
        return $filepath;
    }
    
    /**
     * Export ke Excel (.xls) - Pakai HTML Table (cara sederhana)
     */
    private function _export_to_excel_simple($id, $data)
    {
        $filename = 'pengajuan_' . $data['kode_pengajuan'] . '_' . date('Ymd_His') . '.xls';
        $path = FCPATH . 'uploads/sertifikat/export/';
        
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        
        $filepath = $path . $filename;
        
        // Buat konten HTML untuk Excel
        $html = '<html>
        <head>
            <meta charset="UTF-8">
            <title>Pengajuan Sertifikat</title>
            <style>
                th { background: #f97316; color: white; padding: 10px; }
                td { padding: 8px; border: 1px solid #ddd; }
                .header { background: #f97316; color: white; font-size: 18px; font-weight: bold; }
            </style>
        </head>
        <body>
            <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">
                <tr><td colspan="2" class="header" style="text-align: center;">DATA PENGAJUAN SERTIFIKAT</td></tr>
                <tr><td style="width: 200px; font-weight: bold;">Kode Pengajuan</td><td>' . $data['kode_pengajuan'] . '</td></tr>
                <tr><td style="font-weight: bold;">Tanggal Pengajuan</td><td>' . date('d-m-Y H:i:s') . '</td></tr>
                <tr><td style="font-weight: bold;">&nbsp;</td><td>&nbsp;</td></tr>
                <tr><td style="font-weight: bold; background: #fff3e0;">Judul Kegiatan</td><td>' . htmlspecialchars($data['judul_kegiatan']) . '</td></tr>
                <tr><td style="font-weight: bold;">Tanggal Kegiatan</td><td>' . $data['tanggal_kegiatan'] . '</td></tr>
                <tr><td style="font-weight: bold;">Lokasi Kegiatan</td><td>' . htmlspecialchars($data['lokasi_kegiatan']) . '</td></tr>
                <tr><td style="font-weight: bold;">Nama PIC</td><td>' . htmlspecialchars($data['nama_pic']) . '</td></tr>
                <tr><td style="font-weight: bold;">NIM</td><td>' . $data['nim'] . '</td></tr>
                <tr><td style="font-weight: bold;">Nama Mahasiswa</td><td>' . htmlspecialchars($data['nama_mahasiswa']) . '</td></tr>
                <tr><td style="font-weight: bold;">Program Studi</td><td>' . htmlspecialchars($data['prodi']) . '</td></tr>
                <tr><td style="font-weight: bold;">Deskripsi Kegiatan</td><td>' . nl2br(htmlspecialchars($data['deskripsi_kegiatan'] ?? '-')) . '</td></tr>
                <tr><td style="font-weight: bold;">Catatan Tambahan</td><td>' . nl2br(htmlspecialchars($data['catatan_tambahan'] ?? '-')) . '</td></tr>
            </table>
        </body>
        </html>';
        
        file_put_contents($filepath, $html);
        
        // Simpan path file ke database
        $this->db->where('id', $id);
        $this->db->update('pengajuan_sertifikat', ['file_export' => 'uploads/sertifikat/export/' . $filename]);
        
        return $filepath;
    }
    
    // ==================== Method lain (tetap sama) ====================
    
    public function get_by_mahasiswa($mahasiswa_id)
    {
        return $this->db
            ->where('mahasiswa_id', $mahasiswa_id)
            ->order_by('created_at', 'DESC')
            ->get('pengajuan_sertifikat')
            ->result_array();
    }
    
    public function get_all($status = '', $search = '')
    {
        $this->db->select('*');
        $this->db->from('pengajuan_sertifikat');
        
        if ($status) {
            $this->db->where('status', $status);
        }
        if ($search) {
            $this->db->group_start();
            $this->db->like('nim', $search);
            $this->db->or_like('nama_mahasiswa', $search);
            $this->db->or_like('judul_kegiatan', $search);
            $this->db->or_like('kode_pengajuan', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function get_stats()
    {
        $statuses = ['submitted', 'approved', 'rejected'];
        $stats    = ['total' => $this->db->count_all('pengajuan_sertifikat')];
        foreach ($statuses as $s) {
            $stats[$s] = $this->db->where('status', $s)->count_all_results('pengajuan_sertifikat');
        }
        return $stats;
    }
    
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get('pengajuan_sertifikat')->row_array();
    }
    
    public function get_log($pengajuan_id)
    {
        return $this->db
            ->where('pengajuan_id', $pengajuan_id)
            ->order_by('changed_at', 'ASC')
            ->get('sertifikat_status_log')
            ->result_array();
    }
    
    public function update_status($id, $action, $catatan, $admin_id, $extra_data = [])
    {
        $pengajuan = $this->get_by_id($id);
        if (!$pengajuan || $pengajuan['status'] !== 'submitted') return false;

        $new_status = ($action === 'approve') ? 'approved' : 'rejected';
        $ts_col     = ($action === 'approve') ? 'approved_at' : 'rejected_at';

        $update = array_merge($extra_data, [
            'status'      => $new_status,
            $ts_col       => date('Y-m-d H:i:s'),
            'catatan_admin'=> $catatan,
            'reviewed_by' => $admin_id,
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);

        $this->db->where('id', $id);
        $this->db->update('pengajuan_sertifikat', $update);

        if ($this->db->affected_rows() > 0) {
            $label = ($action === 'approve') ? 'Pengajuan disetujui' : 'Pengajuan ditolak';
            $this->_log($id, 'submitted', $new_status, $catatan ?: $label, $admin_id, 'kemahasiswaan');
            return true;
        }
        return false;
    }
    
    private function _generate_kode()
    {
        $prefix = 'SERT-' . date('Ymd') . '-';
        $result = $this->db->query(
            "SELECT COUNT(*) as total FROM pengajuan_sertifikat WHERE kode_pengajuan LIKE ?",
            [$prefix . '%']
        )->row();
        $seq = str_pad(($result->total + 1), 4, '0', STR_PAD_LEFT);
        return $prefix . $seq;
    }
    
    private function _log($pengajuan_id, $status_lama, $status_baru, $catatan, $user_id, $role)
    {
        $this->db->insert('sertifikat_status_log', [
            'pengajuan_id'    => $pengajuan_id,
            'status_lama'     => $status_lama,
            'status_baru'     => $status_baru,
            'catatan'         => $catatan,
            'changed_by'      => $user_id,
            'changed_by_role' => $role,
            'changed_at'      => date('Y-m-d H:i:s'),
        ]);
    }
    /**
 * Ambil file export berdasarkan ID pengajuan
 */
public function get_file_export($pengajuan_id)
{
    $this->db->select('file_export, kode_pengajuan');
    $this->db->where('id', $pengajuan_id);
    $query = $this->db->get('pengajuan_sertifikat');
    
    if ($query->num_rows() > 0) {
        return $query->row();
    }
    return null;
}
/**
 * Regenerate file export (jika file hilang)
 */
public function regenerate_export($id, $data)
{
    $filename = 'pengajuan_' . $data['kode_pengajuan'] . '_' . date('Ymd_His') . '.xls';
    $path = FCPATH . 'uploads/sertifikat/export/';
    
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }
    
    $filepath = $path . $filename;
    
    // Buat konten HTML untuk Excel
    $html = '<html>
    <head>
        <meta charset="UTF-8">
        <title>Pengajuan Sertifikat</title>
        <style>
            th { background: #f97316; color: white; padding: 10px; }
            td { padding: 8px; border: 1px solid #ddd; }
            .header { background: #f97316; color: white; font-size: 18px; font-weight: bold; text-align: center; }
            .subheader { background: #fff3e0; font-weight: bold; }
        </style>
    </head>
    <body>
        <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">
            <tr><td colspan="2" class="header">DATA PENGAJUAN SERTIFIKAT</td></tr>
            <tr><td style="width: 200px; font-weight: bold;">Kode Pengajuan</td><td>' . $data['kode_pengajuan'] . '</td></tr>
            <tr><td style="font-weight: bold;">Tanggal Pengajuan</td><td>' . date('d-m-Y H:i:s') . '</td></tr>
            <tr><td colspan="2">&nbsp;</td></tr>
            <tr><td class="subheader" colspan="2">DETAIL KEGIATAN</td></tr>
            <tr><td style="font-weight: bold;">Judul Kegiatan</td><td>' . htmlspecialchars($data['judul_kegiatan']) . '</td></tr>
            <tr><td style="font-weight: bold;">Tanggal Kegiatan</td><td>' . $data['tanggal_kegiatan'] . '</td></tr>
            <tr><td style="font-weight: bold;">Lokasi Kegiatan</td><td>' . htmlspecialchars($data['lokasi_kegiatan']) . '</td></tr>
            <tr><td class="subheader" colspan="2">DATA PENGAJU</td></tr>
            <tr><td style="font-weight: bold;">Nama PIC</td><td>' . htmlspecialchars($data['nama_pic']) . '</td></tr>
            <tr><td style="font-weight: bold;">NIM</td><td>' . $data['nim'] . '</td></tr>
            <tr><td style="font-weight: bold;">Nama Mahasiswa</td><td>' . htmlspecialchars($data['nama_mahasiswa']) . '</td></tr>
            <tr><td style="font-weight: bold;">Program Studi</td><td>' . htmlspecialchars($data['prodi']) . '</td></tr>
            <tr><td class="subheader" colspan="2">INFORMASI TAMBAHAN</td></tr>
            <tr><td style="font-weight: bold;">Deskripsi Kegiatan</td><td>' . nl2br(htmlspecialchars($data['deskripsi_kegiatan'] ?? '-')) . '</td></tr>
            <tr><td style="font-weight: bold;">Catatan Tambahan</td><td>' . nl2br(htmlspecialchars($data['catatan_tambahan'] ?? '-')) . '</td></tr>
        </table>
    </body>
    </html>';
    
    file_put_contents($filepath, $html);
    
    // Update database dengan path file baru
    $this->db->where('id', $id);
    $this->db->update('pengajuan_sertifikat', ['file_export' => 'uploads/sertifikat/export/' . $filename]);
    
    return $filepath;
}
}