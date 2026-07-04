<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Upload path settings
$config['upload_path'] = FCPATH . 'uploads/';
$config['upload_path_surat'] = FCPATH . 'uploads/surat_pengajuan/';
$config['upload_path_excel'] = FCPATH . 'uploads/excel_peserta/';
$config['upload_path'] = './uploads/forum/';
$config['allowed_types'] = 'jpg|jpeg|png|gif|webp|mp4|mov|avi|mkv|webm';
$config['max_size'] = 10240; // 10MB
$config['max_width'] = 0;
$config['max_height'] = 0;
$config['encrypt_name'] = true;
$config['remove_spaces'] = true;
$config['detect_mime'] = true;

?>