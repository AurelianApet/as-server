<?php

class Chat_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function chatCount($id = null)
    {
        if ($id != null) {
            $this->db->where('user_id', $id);
        }
        return $this->db->count_all_results('chat_history');
    }

    public function getChatHistories($limit, $page, $id = null)
    {
        if ($id != null) {
            $this->db->where('user_id', $id);
        }
        $query = $this->db->get('chat_history', $limit, $page);
        return $query->result();
    }

    public function getOneChat($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('chat_history');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function deleteChat($id)
    {
        $this->db->where('id', $id);
        if (!$this->db->delete('chat_history')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function createChat($post)
    {
        $array = array(
            'user_id' => $post['user_id'],
            'from_id' => $post['from_id'],
            'from_name' => $post['from_name'],
            'to_id' => $post['to_id'],
            'to_name' => $post['to_name'],
            'text' => $post['text'],
            'is_file' => $post['is_file'],
            'viewed' => 0
        );
        $this->db->insert('chat_history', $array);
        $this->db->insert_id();
    }   

    public function updateChat($post,$id)
    {
        $array = array(
            'user_id' => $post['user_id'],
            'from_id' => $post['from_id'],
            'from_name' => $post['from_name'],
            'to_id' => $post['to_id'],
            'to_name' => $post['to_name'],
            'text' => $post['text'],
            'is_file' => $post['is_file'],
            'viewed' => 1
        );
        $this->db->where('id', $id);
        $this->db->update('chat_history', $array);
    }

}
