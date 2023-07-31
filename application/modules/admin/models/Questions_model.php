<?php

class Questions_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function questionsCount($search_user = null, $status = null)
    {
        if ($search_user != null) {
            $search_user = trim($this->db->escape_like_str($search_user));
            $this->db->where("(question_chat_list.username LIKE '$search_user')");
        }
        if ($status != null) {
            $this->db->where('question_chat_list.status', $status);
        }
        return $this->db->count_all_results('question_chat_list');
    }

    public function getQuestions($limit, $page, $search_user = null, $orderby = null, $status = null)
    {
        if ($search_user != null) {
            $search_user = trim($this->db->escape_like_str($search_user));
            $this->db->where("(question_chat_list.username LIKE '$search_user')");
        }
        if ($orderby == 'desc') {
            $this->db->order_by('question_chat_list.date', ' desc');
        } else {
            $this->db->order_by('question_chat_list.date', 'asc');
        }
        if ($status != null) {
            $this->db->where('question_chat_list.status', $status);
        }

        $query = $this->db->get('question_chat_list', $limit, $page);
        return $query->result();
    }

    public function getOneQuestion($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('question_chat_list');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function deleteQuestion($id)
    {
        $this->db->where('id', $id);
        if (!$this->db->delete('question_chat_list')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function createQuestion($post)
    {
        $array = array(
            'user_id' => $post['user_id'],
            'username' => $post['username'],
            // 'user_email' => $post['user_email'],
            'status' => 0
        );
        $this->db->insert('question_chat_list', $array);
        $this->db->insert_id();
    }   

    public function updateQuestion($post,$id)
    {
        $array = array(
            'username' => $post['username'],
            'user_id' => $post['user_id'],
            'status' => $post['status']
        );
        $this->db->where('id', $id);
        $this->db->update('question_chat_list', $array);
    }

}
