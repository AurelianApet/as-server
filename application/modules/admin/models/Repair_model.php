<?php

class Repair_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function repairsCount($search_user = null, $status = null)
    {
        if ($search_user != null) {
            $search_user = trim($this->db->escape_like_str($search_user));
            $this->db->where("(repair_list.username LIKE '$search_user')");
        }
        if ($status != null) {
            $this->db->where('status', $status);
        }
        return $this->db->count_all_results('repair_list');
    }

    public function getRepairs($limit, $page, $search_user = null, $orderby = null, $status = null)
    {
        if ($search_user != null) {
            $search_user = trim($this->db->escape_like_str($search_user));
            $this->db->where("(repair_list.username LIKE '$search_user')");
        }
        if ($orderby == 'desc') {
            $this->db->order_by('repair_list.date', ' desc');
        } else {
            $this->db->order_by('repair_list.date', 'asc');
        }
        if ($status != null) {
            $this->db->where('status', $status);
        }

        $query = $this->db->get('repair_list', $limit, $page);
        return $query->result();
    }

    public function getOneRepair($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('repair_list');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function deleteRepair($id)
    {
        $this->db->where('id', $id);
        if (!$this->db->delete('repair_list')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function createRepair($post)
    {
        $array = array(
            'request_id' => $post['request_id'],
            'username' => $post['username'],
            'user_address' => $post['user_address'],
            'sellername' => $post['sellername'],
            'seller_address' => $post['seller_address'],
            'description' => $post['description'],
            'image' => $post['image'] ,
            'status' => $post['status'],
            // 'status' => 0,
            'sell_date' => $post['sell_date']
        );
        $this->db->insert('repair_list', $array);
        $this->db->insert_id();
    }   

    public function updateRepair($post,$id)
    {
        $array = array(
            'request_id' => $post['request_id'],
            'username' => $post['username'],
            'user_address' => $post['user_address'],
            'sellername' => $post['sellername'],
            'seller_address' => $post['seller_address'],
            'description' => $post['description'],
            'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
            'status' => $post['status'],
            // 'status' => 0,
            'sell_date' => $post['sell_date']
        );
        $this->db->where('id', $id);
        $this->db->update('repair_list', $array);
    }

}
