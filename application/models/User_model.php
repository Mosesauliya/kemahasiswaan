<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }

    /**
     * Get user by ID
     * @param int $user_id
     * @return object|null
     */
    public function get_user_by_id($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row();
    }

    /**
     * Get user by username
     * @param string $username
     * @return object|null
     */
    public function get_user_by_username($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->row();
    }

    /**
     * Get user by email
     * @param string $email
     * @return object|null
     */
    public function get_user_by_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }

    /**
     * Get user by NIM/NID
     * @param string $nim
     * @return object|null
     */
    public function get_user_by_nim($nim) {
        $this->db->where('nim', $nim);
        $query = $this->db->get('users');
        return $query->row();
    }

    /**
     * Update user data
     * @param int $user_id
     * @param array $data
     * @return bool
     */
    public function update_user($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    /**
     * Update user password
     * @param int $user_id
     * @param string $new_password
     * @return bool
     */
    public function update_password($user_id, $new_password) {
        $data = array(
            'password' => $new_password,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    /**
     * Delete user account
     * @param int $user_id
     * @return bool
     */
    public function delete_user($user_id) {
        // Hapus semua aktivitas user terlebih dahulu
        $this->db->where('user_id', $user_id);
        $this->db->delete('user_activities');
        
        // Hapus user
        $this->db->where('id', $user_id);
        return $this->db->delete('users');
    }

    /**
     * Create new user
     * @param array $data
     * @return int|bool
     */
    public function create_user($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    /**
     * Check if username exists
     * @param string $username
     * @param int $exclude_id (optional) ID to exclude from check
     * @return bool
     */
    public function check_username_exists($username, $exclude_id = null) {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }

    /**
     * Check if email exists
     * @param string $email
     * @param int $exclude_id (optional) ID to exclude from check
     * @return bool
     */
    public function check_email_exists($email, $exclude_id = null) {
        $this->db->where('email', $email);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }

    /**
     * Check if NIM exists
     * @param string $nim
     * @param int $exclude_id (optional) ID to exclude from check
     * @return bool
     */
    public function check_nim_exists($nim, $exclude_id = null) {
        $this->db->where('nim', $nim);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }

    /**
     * Get all users with pagination
     * @param int $limit
     * @param int $offset
     * @param array $filters
     * @return array
     */
    public function get_all_users($limit = null, $offset = 0, $filters = array()) {
        if (!empty($filters)) {
            if (isset($filters['role']) && !empty($filters['role'])) {
                $this->db->where('role', $filters['role']);
            }
            if (isset($filters['prodi']) && !empty($filters['prodi'])) {
                $this->db->where('prodi', $filters['prodi']);
            }
            if (isset($filters['search']) && !empty($filters['search'])) {
                $this->db->group_start();
                $this->db->like('nama', $filters['search']);
                $this->db->or_like('nim', $filters['search']);
                $this->db->or_like('email', $filters['search']);
                $this->db->group_end();
            }
        }
        
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get('users');
        return $query->result();
    }

    /**
     * Count total users
     * @param array $filters
     * @return int
     */
    public function count_users($filters = array()) {
        if (!empty($filters)) {
            if (isset($filters['role']) && !empty($filters['role'])) {
                $this->db->where('role', $filters['role']);
            }
            if (isset($filters['prodi']) && !empty($filters['prodi'])) {
                $this->db->where('prodi', $filters['prodi']);
            }
            if (isset($filters['search']) && !empty($filters['search'])) {
                $this->db->group_start();
                $this->db->like('nama', $filters['search']);
                $this->db->or_like('nim', $filters['search']);
                $this->db->or_like('email', $filters['search']);
                $this->db->group_end();
            }
        }
        
        return $this->db->count_all_results('users');
    }

    /**
     * Get user activities
     * @param int $user_id
     * @param int $limit
     * @return array
     */
    public function get_user_activities($user_id, $limit = 10) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('user_activities');
        return $query->result();
    }

    /**
     * Log user activity
     * @param int $user_id
     * @param string $activity
     * @param string|null $details
     * @return bool
     */
    public function log_activity($user_id, $activity, $details = null) {
        $data = array(
            'user_id' => $user_id,
            'activity' => $activity,
            'details' => $details,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'created_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('user_activities', $data);
    }

    /**
     * Delete old activities (older than specified days)
     * @param int $days
     * @return bool
     */
    public function delete_old_activities($days = 30) {
        $date = date('Y-m-d H:i:s', strtotime("-$days days"));
        $this->db->where('created_at <', $date);
        return $this->db->delete('user_activities');
    }

    /**
     * Get user statistics
     * @return object
     */
    public function get_user_statistics() {
        $stats = new stdClass();
        
        // Total users
        $stats->total_users = $this->db->count_all('users');
        
        // Users by role
        $roles = ['mahasiswa', 'pembina', 'bemdpm', 'kaprodi', 'kemahasiswaan'];
        foreach ($roles as $role) {
            $this->db->where('role', $role);
            $stats->{$role . '_count'} = $this->db->count_all_results('users');
        }
        
        // Users by prodi
        $prodis = ['dkv', 'despro', 'interior', 'kriya', 'senirupa', 'film'];
        foreach ($prodis as $prodi) {
            $this->db->where('prodi', $prodi);
            $stats->{$prodi . '_count'} = $this->db->count_all_results('users');
        }
        
        // New users this month
        $this->db->where('MONTH(created_at)', date('m'));
        $this->db->where('YEAR(created_at)', date('Y'));
        $stats->new_users_this_month = $this->db->count_all_results('users');
        
        // Active users (logged in in last 7 days)
        $this->db->where('updated_at >', date('Y-m-d H:i:s', strtotime('-7 days')));
        $stats->active_users = $this->db->count_all_results('users');
        
        return $stats;
    }

    /**
     * Update last login timestamp
     * @param int $user_id
     * @return bool
     */
    public function update_last_login($user_id) {
        $data = array(
            'last_login' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    /**
     * Get users by role
     * @param string $role
     * @param int $limit
     * @return array
     */
    public function get_users_by_role($role, $limit = null) {
        $this->db->where('role', $role);
        $this->db->order_by('nama', 'ASC');
        if ($limit) {
            $this->db->limit($limit);
        }
        $query = $this->db->get('users');
        return $query->result();
    }

    /**
     * Search users by keyword
     * @param string $keyword
     * @param int $limit
     * @return array
     */
    public function search_users($keyword, $limit = 20) {
        $this->db->group_start();
        $this->db->like('nama', $keyword);
        $this->db->or_like('nim', $keyword);
        $this->db->or_like('email', $keyword);
        $this->db->or_like('username', $keyword);
        $this->db->group_end();
        $this->db->order_by('nama', 'ASC');
        $this->db->limit($limit);
        $query = $this->db->get('users');
        return $query->result();
    }

    /**
     * Get recent activities for all users (admin)
     * @param int $limit
     * @return array
     */
    public function get_recent_activities($limit = 20) {
        $this->db->select('user_activities.*, users.nama, users.foto, users.role');
        $this->db->from('user_activities');
        $this->db->join('users', 'users.id = user_activities.user_id', 'left');
        $this->db->order_by('user_activities.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Update user role
     * @param int $user_id
     * @param string $role
     * @return bool
     */
    public function update_user_role($user_id, $role) {
        $data = array(
            'role' => $role,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    /**
     * Bulk delete users
     * @param array $user_ids
     * @return bool
     */
    public function bulk_delete_users($user_ids) {
        if (empty($user_ids)) return false;
        
        // Hapus foto-foto user
        $this->db->where_in('id', $user_ids);
        $users = $this->db->get('users')->result();
        foreach ($users as $user) {
            if (!empty($user->foto) && file_exists('./uploads/users/' . $user->foto)) {
                unlink('./uploads/users/' . $user->foto);
            }
        }
        
        // Hapus aktivitas user
        $this->db->where_in('user_id', $user_ids);
        $this->db->delete('user_activities');
        
        // Hapus user
        $this->db->where_in('id', $user_ids);
        return $this->db->delete('users');
    }

    /**
     * Toggle user status (aktif/nonaktif)
     * @param int $user_id
     * @param int $status
     * @return bool
     */
    public function toggle_user_status($user_id, $status) {
        $data = array(
            'is_active' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    /**
     * Get dashboard statistics for user
     * @param int $user_id
     * @return object
     */
    public function get_user_dashboard_stats($user_id) {
        $stats = new stdClass();
        
        // Total proposals
        $this->db->where('user_id', $user_id);
        $stats->total_proposals = $this->db->count_all_results('proposals');
        
        // Pending proposals
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'pending');
        $stats->pending_proposals = $this->db->count_all_results('proposals');
        
        // Approved proposals
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'approved');
        $stats->approved_proposals = $this->db->count_all_results('proposals');
        
        // Rejected proposals
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'rejected');
        $stats->rejected_proposals = $this->db->count_all_results('proposals');
        
        return $stats;
    }
}
?>