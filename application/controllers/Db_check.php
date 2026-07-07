<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db_check extends CI_Controller {
    public function index() {
        $this->load->database();
        $this->load->model('Sertifikat_model');
        
        echo "Testing get_by_id on ID 1...\n";
        try {
            $res = $this->db->where('id >', 0)->limit(1)->get('pengajuan_sertifikat')->row_array();
            if ($res) {
                $id = $res['id'];
                echo "Found pengajuan ID: $id\n";
                $pengajuan = $this->Sertifikat_model->get_by_id($id);
                echo "get_by_id succeeded: " . json_encode($pengajuan) . "\n";
                
                echo "Testing get_log...\n";
                $log = $this->Sertifikat_model->get_log($id);
                echo "get_log succeeded: " . json_encode($log) . "\n";
            } else {
                echo "No pengajuan_sertifikat found.\n";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}
