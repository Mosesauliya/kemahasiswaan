<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ForumAlumniModel extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }
    
    // Get all posts with user info
    public function get_posts($limit = 10, $offset = 0) {
        $this->db->select('p.*, u.nama, u.foto as user_foto, u.email');
        $this->db->from('forum_alumni_posts p');
        $this->db->join('users u', 'u.id = p.user_id');
        $this->db->order_by('p.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $posts = $query->result_array();
        
        // Get likes and comments for each post
        foreach ($posts as &$post) {
            $post['likes'] = $this->get_post_likes($post['id']);
            $post['user_has_liked'] = $this->user_has_liked($post['id']);
            $post['comments'] = $this->get_post_comments($post['id'], 3);
        }
        
        return $posts;
    }
    
    // Get single post
    public function get_post($post_id) {
        $this->db->select('p.*, u.nama, u.foto as user_foto, u.email');
        $this->db->from('forum_alumni_posts p');
        $this->db->join('users u', 'u.id = p.user_id');
        $this->db->where('p.id', $post_id);
        $query = $this->db->get();
        $post = $query->row_array();
        
        if ($post) {
            $post['likes'] = $this->get_post_likes($post_id);
            $post['user_has_liked'] = $this->user_has_liked($post_id);
            $post['comments'] = $this->get_post_comments($post_id);
        }
        
        return $post;
    }
    
    // Get post likes
    public function get_post_likes($post_id) {
        $this->db->select('l.*, u.nama, u.foto');
        $this->db->from('forum_alumni_likes l');
        $this->db->join('users u', 'u.id = l.user_id');
        $this->db->where('l.post_id', $post_id);
        $this->db->order_by('l.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Check if user has liked post
    public function user_has_liked($post_id, $user_id = null) {
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        if (!$user_id) return false;
        
        $this->db->where('post_id', $post_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('forum_alumni_likes');
        return $query->num_rows() > 0;
    }
    
    // Get post comments
    public function get_post_comments($post_id, $limit = null) {
        $this->db->select('c.*, u.nama, u.foto as user_foto');
        $this->db->from('forum_alumni_comments c');
        $this->db->join('users u', 'u.id = c.user_id');
        $this->db->where('c.post_id', $post_id);
        $this->db->order_by('c.created_at', 'ASC');
        if ($limit) {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Create post
    public function create_post($data) {
        $post_data = array(
            'user_id' => $data['user_id'],
            'content' => $data['content'],
            'image' => $data['image'] ?? null,
            'video' => $data['video'] ?? null,
            'created_at' => date('Y-m-d H:i:s')
        );
        
        $this->db->insert('forum_alumni_posts', $post_data);
        return $this->db->insert_id();
    }
    
    // Update post
    public function update_post($post_id, $data) {
        $this->db->where('id', $post_id);
        return $this->db->update('forum_alumni_posts', $data);
    }
    
    // Delete post
    public function delete_post($post_id, $user_id) {
        // Check if user owns the post
        $this->db->where('id', $post_id);
        $this->db->where('user_id', $user_id);
        return $this->db->delete('forum_alumni_posts');
    }
    
    // Toggle like
    public function toggle_like($post_id, $user_id) {
        $this->db->where('post_id', $post_id);
        $this->db->where('user_id', $user_id);
        $exists = $this->db->get('forum_alumni_likes')->num_rows() > 0;
        
        if ($exists) {
            // Unlike
            $this->db->where('post_id', $post_id);
            $this->db->where('user_id', $user_id);
            $this->db->delete('forum_alumni_likes');
            $this->db->set('likes_count', 'likes_count-1', FALSE);
            $this->db->where('id', $post_id);
            $this->db->update('forum_alumni_posts');
            return array('liked' => false, 'count' => $this->get_like_count($post_id));
        } else {
            // Like
            $this->db->insert('forum_alumni_likes', array(
                'post_id' => $post_id,
                'user_id' => $user_id,
                'created_at' => date('Y-m-d H:i:s')
            ));
            $this->db->set('likes_count', 'likes_count+1', FALSE);
            $this->db->where('id', $post_id);
            $this->db->update('forum_alumni_posts');
            return array('liked' => true, 'count' => $this->get_like_count($post_id));
        }
    }
    
    // Get like count
    public function get_like_count($post_id) {
        $this->db->where('post_id', $post_id);
        return $this->db->count_all_results('forum_alumni_likes');
    }
    
    // Add comment - REVISED VERSION with better error handling
    public function add_comment($post_id, $user_id, $comment) {
        // Validate inputs
        if (empty($post_id) || empty($user_id) || empty($comment)) {
            log_message('error', 'add_comment: Invalid parameters - post_id=' . $post_id . ', user_id=' . $user_id . ', comment=' . $comment);
            return false;
        }
        
        // Check if post exists
        $this->db->where('id', $post_id);
        $post_exists = $this->db->get('forum_alumni_posts')->num_rows();
        
        if ($post_exists == 0) {
            log_message('error', 'add_comment: Post not found with ID: ' . $post_id);
            return false;
        }
        
        // Prepare comment data
        $comment_data = array(
            'post_id' => $post_id,
            'user_id' => $user_id,
            'comment' => $comment,
            'created_at' => date('Y-m-d H:i:s')
        );
        
        // Insert comment
        $insert = $this->db->insert('forum_alumni_comments', $comment_data);
        
        if (!$insert) {
            log_message('error', 'add_comment: Failed to insert comment - ' . $this->db->last_query());
            return false;
        }
        
        $comment_id = $this->db->insert_id();
        
        // Update comment count in post
        $this->db->set('comments_count', 'comments_count+1', FALSE);
        $this->db->where('id', $post_id);
        $update = $this->db->update('forum_alumni_posts');
        
        if (!$update) {
            log_message('error', 'add_comment: Failed to update comment count for post_id: ' . $post_id);
        }
        
        log_message('debug', 'add_comment: Successfully added comment ID: ' . $comment_id . ' for post_id: ' . $post_id);
        
        return $comment_id;
    }
    
    // Delete comment
    public function delete_comment($comment_id, $user_id) {
        // Validate inputs
        if (empty($comment_id) || empty($user_id)) {
            log_message('error', 'delete_comment: Invalid parameters - comment_id=' . $comment_id . ', user_id=' . $user_id);
            return false;
        }
        
        // Get post_id and verify ownership first
        $this->db->where('id', $comment_id);
        $comment = $this->db->get('forum_alumni_comments')->row();
        
        if (!$comment) {
            log_message('error', 'delete_comment: Comment not found with ID: ' . $comment_id);
            return false;
        }
        
        // Check if user owns the comment
        if ($comment->user_id != $user_id) {
            log_message('error', 'delete_comment: User ' . $user_id . ' does not own comment ' . $comment_id);
            return false;
        }
        
        // Delete comment
        $this->db->where('id', $comment_id);
        $deleted = $this->db->delete('forum_alumni_comments');
        
        if ($deleted) {
            // Update comment count in post
            $this->db->set('comments_count', 'comments_count-1', FALSE);
            $this->db->where('id', $comment->post_id);
            $this->db->update('forum_alumni_posts');
            log_message('debug', 'delete_comment: Successfully deleted comment ID: ' . $comment_id);
        } else {
            log_message('error', 'delete_comment: Failed to delete comment ID: ' . $comment_id);
        }
        
        return $deleted;
    }
    
    // Get total posts count
    public function get_total_posts() {
        return $this->db->count_all('forum_alumni_posts');
    }
    
    // Get user posts
    public function get_user_posts($user_id, $limit = 10, $offset = 0) {
        $this->db->select('p.*, u.nama, u.foto as user_foto');
        $this->db->from('forum_alumni_posts p');
        $this->db->join('users u', 'u.id = p.user_id');
        $this->db->where('p.user_id', $user_id);
        $this->db->order_by('p.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Get comments by post with full details
    public function get_comments_by_post($post_id, $limit = null, $offset = 0) {
        $this->db->select('c.*, u.nama, u.foto as user_foto');
        $this->db->from('forum_alumni_comments c');
        $this->db->join('users u', 'u.id = c.user_id');
        $this->db->where('c.post_id', $post_id);
        $this->db->order_by('c.created_at', 'ASC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Get comment count for a post
    public function get_comment_count($post_id) {
        $this->db->where('post_id', $post_id);
        return $this->db->count_all_results('forum_alumni_comments');
    }
    
    // Check if post exists
    public function post_exists($post_id) {
        $this->db->where('id', $post_id);
        return $this->db->get('forum_alumni_posts')->num_rows() > 0;
    }
    
    // Get recent posts with pagination
    public function get_recent_posts($limit = 10, $offset = 0) {
        $this->db->select('p.*, u.nama, u.foto as user_foto');
        $this->db->from('forum_alumni_posts p');
        $this->db->join('users u', 'u.id = p.user_id');
        $this->db->order_by('p.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $posts = $query->result_array();
        
        foreach ($posts as &$post) {
            $post['likes_count'] = $this->get_like_count($post['id']);
            $post['comments_count'] = $this->get_comment_count($post['id']);
            $post['user_has_liked'] = $this->user_has_liked($post['id']);
        }
        
        return $posts;
    }
}