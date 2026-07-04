<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tak_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Tak_admin_model');
        $this->load->model('Tak_model');
        $this->load->model('Berita_model');
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman admin');
            redirect('login');
        }
    }

    public function index() {
        $data['title'] = 'Dashboard Admin TAK';
        $data['user_data'] = $this->_get_user_data();
        
        $data['total_mahasiswa'] = $this->Tak_admin_model->count_all_mahasiswa();
        $data['total_dosen'] = $this->Tak_admin_model->count_all_dosen();
        
        $data['total_pengajuan'] = $this->Tak_admin_model->count_all_pengajuan();
        $data['pending_count'] = $this->Tak_admin_model->count_pengajuan_by_status('pending');
        $data['diproses_count'] = $this->Tak_admin_model->count_pengajuan_by_status('diproses');
        $data['disetujui_count'] = $this->Tak_admin_model->count_pengajuan_by_status('disetujui');
        $data['ditolak_count'] = $this->Tak_admin_model->count_pengajuan_by_status('ditolak');
        
        // Data untuk chart
        $data['statistik_bulanan'] = $this->Tak_admin_model->get_statistik_bulanan();
        $data['pengajuan_terbaru'] = $this->Tak_admin_model->get_pengajuan_terbaru(5);
        
        // Data berita untuk ditampilkan di dashboard - MENGGUNAKAN METHOD YANG ADA
        $data['berita_terbaru'] = $this->Berita_model->get_latest_berita(5, 'berita');
        $data['pengumuman_terbaru'] = $this->Berita_model->get_latest_berita(3, 'pengumuman');
        $data['artikel_terbaru'] = $this->Berita_model->get_latest_berita(3, 'artikel');
        $data['pending_komentar'] = $this->Berita_model->get_pending_komentar_count();
        
        $this->load->view('tak_admin/dashboard', $data);
    }

    public function daftar_pengajuan($status = 'all') {
        $data['title'] = 'Daftar Pengajuan TAK';
        $data['user_data'] = $this->_get_user_data();
        $data['current_status'] = $status;
        
        // Data untuk hero section
        $data['total_mahasiswa'] = $this->Tak_admin_model->count_all_mahasiswa();
        $data['total_dosen'] = $this->Tak_admin_model->count_all_dosen();
        
        // Statistik TAK
        $data['total_pengajuan'] = $this->Tak_admin_model->count_all_pengajuan();
        $data['pending_count'] = $this->Tak_admin_model->count_pengajuan_by_status('pending');
        $data['diproses_count'] = $this->Tak_admin_model->count_pengajuan_by_status('diproses');
        $data['disetujui_count'] = $this->Tak_admin_model->count_pengajuan_by_status('disetujui');
        $data['ditolak_count'] = $this->Tak_admin_model->count_pengajuan_by_status('ditolak');
        
        // Filter berdasarkan status
        switch($status) {
            case 'pending':
                $data['pengajuan'] = $this->Tak_admin_model->get_pengajuan_by_status('pending');
                $data['subtitle'] = 'Menunggu Verifikasi';
                break;
            case 'diproses':
                $data['pengajuan'] = $this->Tak_admin_model->get_pengajuan_by_status('diproses');
                $data['subtitle'] = 'Sedang Diproses';
                break;
            case 'disetujui':
                $data['pengajuan'] = $this->Tak_admin_model->get_pengajuan_by_status('disetujui');
                $data['subtitle'] = 'Disetujui';
                break;
            case 'ditolak':
                $data['pengajuan'] = $this->Tak_admin_model->get_pengajuan_by_status('ditolak');
                $data['subtitle'] = 'Ditolak';
                break;
            default:
                $data['pengajuan'] = $this->Tak_admin_model->get_all_pengajuan();
                $data['subtitle'] = 'Semua Pengajuan';
        }
        
        // Data untuk berita di sidebar - MENGGUNAKAN METHOD YANG ADA
        $data['berita_terbaru'] = $this->Berita_model->get_latest_berita(5);
        $data['pending_komentar'] = $this->Berita_model->get_pending_komentar_count();
        
        $this->load->view('tak_admin/daftar_pengajuan', $data);
    }

    public function detail_pengajuan($id) {
        $data['title'] = 'Detail Pengajuan TAK';
        $data['user_data'] = $this->_get_user_data();
        
        // Data untuk hero section
        $data['total_mahasiswa'] = $this->Tak_admin_model->count_all_mahasiswa();
        $data['total_dosen'] = $this->Tak_admin_model->count_all_dosen();
        
        // Statistik TAK untuk sidebar
        $data['total_pengajuan'] = $this->Tak_admin_model->count_all_pengajuan();
        $data['pending_count'] = $this->Tak_admin_model->count_pengajuan_by_status('pending');
        $data['diproses_count'] = $this->Tak_admin_model->count_pengajuan_by_status('diproses');
        $data['disetujui_count'] = $this->Tak_admin_model->count_pengajuan_by_status('disetujui');
        $data['ditolak_count'] = $this->Tak_admin_model->count_pengajuan_by_status('ditolak');
        
        $data['pengajuan'] = $this->Tak_admin_model->get_pengajuan_detail($id);
        
        if (empty($data['pengajuan'])) {
            $this->session->set_flashdata('error', 'Data pengajuan tidak ditemukan');
            redirect('tak_admin/daftar_pengajuan');
        }
        
        // Ambil histori status
        $data['histori'] = $this->Tak_admin_model->get_histori_pengajuan($id);
        
        // Data berita untuk sidebar - MENGGUNAKAN METHOD YANG ADA
        $data['berita_terbaru'] = $this->Berita_model->get_latest_berita(5);
        $data['pending_komentar'] = $this->Berita_model->get_pending_komentar_count();
        
        $this->load->view('tak_admin/detail_pengajuan', $data);
    }

    public function proses_pengajuan($id) {
        $data['title'] = 'Proses Pengajuan TAK';
        $data['user_data'] = $this->_get_user_data();
        
        // Data untuk hero section
        $data['total_mahasiswa'] = $this->Tak_admin_model->count_all_mahasiswa();
        $data['total_dosen'] = $this->Tak_admin_model->count_all_dosen();
        
        // Statistik TAK untuk sidebar
        $data['total_pengajuan'] = $this->Tak_admin_model->count_all_pengajuan();
        $data['pending_count'] = $this->Tak_admin_model->count_pengajuan_by_status('pending');
        $data['diproses_count'] = $this->Tak_admin_model->count_pengajuan_by_status('diproses');
        $data['disetujui_count'] = $this->Tak_admin_model->count_pengajuan_by_status('disetujui');
        $data['ditolak_count'] = $this->Tak_admin_model->count_pengajuan_by_status('ditolak');
        
        $data['pengajuan'] = $this->Tak_admin_model->get_pengajuan_detail($id);
        
        if (empty($data['pengajuan'])) {
            $this->session->set_flashdata('error', 'Data pengajuan tidak ditemukan');
            redirect('tak_admin/daftar_pengajuan');
        }
        
        $this->load->view('tak_admin/proses_pengajuan', $data);
    }

    public function update_status() {
        $this->form_validation->set_rules('id', 'ID Pengajuan', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[pending,diproses,disetujui,ditolak]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $id = $this->input->post('id');
            $status = $this->input->post('status');
            $catatan = $this->input->post('catatan');
            
            $data = array(
                'status' => $status,
                'catatan' => $catatan,
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            // Jika status disetujui, tambahkan no_tak
            if ($status == 'disetujui') {
                $data['no_tak'] = $this->generate_no_tak();
                $data['tanggal_disetujui'] = date('Y-m-d H:i:s');
            }
            
            $update = $this->Tak_admin_model->update_pengajuan($id, $data);
            
            if ($update) {
                // Simpan histori
                $histori_data = array(
                    'pengajuan_id' => $id,
                    'status' => $status,
                    'catatan' => $catatan,
                    'created_by' => $this->session->userdata('user_id'),
                    'created_at' => date('Y-m-d H:i:s')
                );
                $this->Tak_admin_model->insert_histori($histori_data);
                
                $this->session->set_flashdata('success', 'Status pengajuan berhasil diperbarui');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui status');
            }
            
            redirect('tak_admin/detail_pengajuan/' . $id);
        }
    }

    public function search() {
        $keyword = $this->input->get('keyword');
        $data['title'] = 'Hasil Pencarian';
        $data['user_data'] = $this->_get_user_data();
        
        // Data untuk hero section
        $data['total_mahasiswa'] = $this->Tak_admin_model->count_all_mahasiswa();
        $data['total_dosen'] = $this->Tak_admin_model->count_all_dosen();
        
        // Statistik TAK
        $data['total_pengajuan'] = $this->Tak_admin_model->count_all_pengajuan();
        $data['pending_count'] = $this->Tak_admin_model->count_pengajuan_by_status('pending');
        $data['diproses_count'] = $this->Tak_admin_model->count_pengajuan_by_status('diproses');
        $data['disetujui_count'] = $this->Tak_admin_model->count_pengajuan_by_status('disetujui');
        $data['ditolak_count'] = $this->Tak_admin_model->count_pengajuan_by_status('ditolak');
        
        $data['pengajuan'] = $this->Tak_admin_model->search_pengajuan($keyword);
        $data['keyword'] = $keyword;
        $data['subtitle'] = 'Hasil Pencarian: "' . $keyword . '"';
        
        $this->load->view('tak_admin/daftar_pengajuan', $data);
    }

    public function filter_by_date($start_date, $end_date, $status = 'all') {
        $data['title'] = 'Filter Pengajuan';
        $data['user_data'] = $this->_get_user_data();
        $data['current_status'] = $status;
        
        // Data untuk hero section
        $data['total_mahasiswa'] = $this->Tak_admin_model->count_all_mahasiswa();
        $data['total_dosen'] = $this->Tak_admin_model->count_all_dosen();
        
        // Statistik TAK
        $data['total_pengajuan'] = $this->Tak_admin_model->count_all_pengajuan();
        $data['pending_count'] = $this->Tak_admin_model->count_pengajuan_by_status('pending');
        $data['diproses_count'] = $this->Tak_admin_model->count_pengajuan_by_status('diproses');
        $data['disetujui_count'] = $this->Tak_admin_model->count_pengajuan_by_status('disetujui');
        $data['ditolak_count'] = $this->Tak_admin_model->count_pengajuan_by_status('ditolak');
        
        $data['pengajuan'] = $this->Tak_admin_model->filter_by_date($start_date, $end_date, $status);
        $data['subtitle'] = 'Filter Tanggal: ' . date('d/m/Y', strtotime($start_date)) . ' - ' . date('d/m/Y', strtotime($end_date));
        
        $this->load->view('tak_admin/daftar_pengajuan', $data);
    }

    public function generate_no_tak() {
        $tahun = date('Y');
        $bulan = date('m');
        
        // Cari nomor urut terakhir
        $last = $this->Tak_admin_model->get_last_no_tak($tahun);
        
        if ($last) {
            $last_num = intval(substr($last->no_tak, -4));
            $new_num = str_pad($last_num + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $new_num = '0001';
        }
        
        return 'TAK/FIK/' . $tahun . '/' . $bulan . '/' . $new_num;
    }

    public function export_excel($status = 'all') {
        $this->load->library('excel');
        
        $data['pengajuan'] = $this->Tak_admin_model->get_pengajuan_for_export($status);
        
        // Load view untuk export
        $this->load->view('tak_admin/export_excel', $data);
    }

    public function cetak_laporan() {
        $data['title'] = 'Laporan Pengajuan TAK';
        $data['user_data'] = $this->_get_user_data();
        
        $data['pengajuan'] = $this->Tak_admin_model->get_all_pengajuan();
        $data['statistik'] = array(
            'total' => $this->Tak_admin_model->count_all_pengajuan(),
            'pending' => $this->Tak_admin_model->count_pengajuan_by_status('pending'),
            'diproses' => $this->Tak_admin_model->count_pengajuan_by_status('diproses'),
            'disetujui' => $this->Tak_admin_model->count_pengajuan_by_status('disetujui'),
            'ditolak' => $this->Tak_admin_model->count_pengajuan_by_status('ditolak')
        );
        
        $this->load->view('tak_admin/cetak_laporan', $data);
    }

    public function hapus_pengajuan($id) {
        $pengajuan = $this->Tak_admin_model->get_pengajuan_detail($id);
        
        if ($pengajuan) {
            // Hapus file fisik
            if (!empty($pengajuan->file_surat_pengajuan)) {
                $file_surat = FCPATH . 'uploads/surat_pengajuan/' . $pengajuan->file_surat_pengajuan;
                if (file_exists($file_surat)) {
                    unlink($file_surat);
                }
            }
            
            if (!empty($pengajuan->file_excel_peserta)) {
                $file_excel = FCPATH . 'uploads/excel_peserta/' . $pengajuan->file_excel_peserta;
                if (file_exists($file_excel)) {
                    unlink($file_excel);
                }
            }
            
            $delete = $this->Tak_admin_model->delete_pengajuan($id);
            
            if ($delete) {
                $this->session->set_flashdata('success', 'Data pengajuan berhasil dihapus');
            } else {
                $this->session->set_flashdata('error', 'Gagal menghapus data');
            }
        }
        
        redirect('tak_admin/daftar_pengajuan');
    }

    public function get_statistik_ajax() {
        $data = array(
            'total' => $this->Tak_admin_model->count_all_pengajuan(),
            'pending' => $this->Tak_admin_model->count_pengajuan_by_status('pending'),
            'diproses' => $this->Tak_admin_model->count_pengajuan_by_status('diproses'),
            'disetujui' => $this->Tak_admin_model->count_pengajuan_by_status('disetujui'),
            'ditolak' => $this->Tak_admin_model->count_pengajuan_by_status('ditolak'),
            'statistik_bulanan' => $this->Tak_admin_model->get_statistik_bulanan()
        );
        
        echo json_encode($data);
    }

    private function _get_user_data() {
        $role = $this->session->userdata('role');
        $role_display = '';

        switch ($role) {
            case 'admin':
                $role_display = 'Admin TAK';
                break;
            case 'kemahasiswaan':
                $role_display = 'Staff Kemahasiswaan';
                break;
            case 'kaprodi':
                $role_display = 'Kepala Program Studi';
                break;
            default:
                $role_display = ucfirst($role);
        }
        
        return array(
            'user_id' => $this->session->userdata('user_id'),
            'username' => $this->session->userdata('username'),
            'nama' => $this->session->userdata('nama'),
            'nim' => $this->session->userdata('nim'),
            'nidn' => $this->session->userdata('nidn'),
            'role' => $role,
            'prodi' => $this->session->userdata('prodi'),
            'foto' => $this->session->userdata('foto'),
            'role_display' => $role_display,
            'logged_in' => true
        );
    }
}