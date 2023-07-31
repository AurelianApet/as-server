<?php

class Guides_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function guidesCount($search_title = null, $category = null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(guide_list.title LIKE '%$search_title%')");
        }
        if ($category != null) {
            $this->db->where('categorie', $category);
        }
        return $this->db->count_all_results('guide_list');
    }

    public function getGuides($limit, $page, $search_title = null, $orderby = null, $category = null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(guide_list.title LIKE '%$search_title%')");
        }
        if ($orderby == 'desc') {
            $this->db->order_by('guide_list.date', ' desc');
        } else {
            $this->db->order_by('guide_list.date', 'asc');
        }
        if ($category != null) {
            $this->db->where('categorie', $category);
        }

        $query = $this->db->get('guide_list', $limit, $page);
        return $query->result();
    }

    public function getOneGuide($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('guide_list');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function deleteGuide($id)
    {
        $this->db->where('id', $id);
        if (!$this->db->delete('guide_list')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function createGuide($post)
    {
        $array = array(
            'image' => $post['image'],
            'title' => null,
            'setup_guide' => $post['setup_guide'],
            'categorie' => 1
        );
        $this->db->insert('guide_list', $array);
        $this->db->insert_id();
    }   

    public function updateGuide($post,$id)
    {
        $array = array(
            'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
            'title' => null,
            'setup_guide' => $post['setup_guide'],
            'categorie' => 1
        );
        $this->db->where('id', $id);
        $this->db->update('guide_list', $array);
    }

}
