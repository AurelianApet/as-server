<?php

class Repeat_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function repeatsCount($search_title = null, $category = null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(repeat_questions_list.question LIKE '%$search_title%')");
        }
        if ($category != null) {
            $this->db->where('categorie', $category);
        }
        return $this->db->count_all_results('repeat_questions_list');
    }

    public function getRepeats($limit, $page, $search_title = null, $orderby = null, $category = null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(repeat_questions_list.question LIKE '%$search_title%')");
        }
        if ($orderby == 'desc') {
            $this->db->order_by('repeat_questions_list.date', ' desc');
        } else {
            $this->db->order_by('repeat_questions_list.date', 'asc');
        }
        if ($category != null) {
            $this->db->where('categorie', $category);
        }

        $query = $this->db->get('repeat_questions_list', $limit, $page);
        return $query->result();
    }

    public function getOneRepeat($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('repeat_questions_list');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function deleteRepeat($id)
    {
        $this->db->where('id', $id);
        if (!$this->db->delete('repeat_questions_list')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function createRepeat($post)
    {
        $array = array(
            'question' => $post['question'],
            'answer' => $post['answer'],
            'categorie' => $post['categorie']
        );
        $this->db->insert('repeat_questions_list', $array);
        $this->db->insert_id();
    }   

    public function updateRepeat($post,$id)
    {
        $array = array(
            'question' => $post['question'],
            'answer' => $post['answer'],
            'categorie' => $post['categorie']
        );
        $this->db->where('id', $id);
        $this->db->update('repeat_questions_list', $array);
    }

}
