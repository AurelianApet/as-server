<?php

class AttachCategories_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function categoriesCount()
    {
        return $this->db->count_all_results('attach_categories');
    }

    public function getCategories($limit = null, $start = null)
    {
        $limit_sql = '';
        if ($limit !== null && $start !== null) {
            $limit_sql = ' LIMIT ' . $start . ',' . $limit;
        }

        $query = $this->db->query('SELECT translations_first.*, (SELECT name FROM attach_categories_translations WHERE for_id = sub_for AND abbr = translations_first.abbr) as sub_is, attach_categories.position FROM attach_categories_translations as translations_first INNER JOIN attach_categories ON attach_categories.id = translations_first.for_id ORDER BY id ASC ' . $limit_sql);
        $arr = array();
        foreach ($query->result() as $categorie) {
            $arr[$categorie->for_id]['info'][] = array(
                'abbr' => $categorie->abbr,
                'name' => $categorie->name
            );
            $arr[$categorie->for_id]['sub'][] = $categorie->sub_is;
            $arr[$categorie->for_id]['position'] = $categorie->position;
        }
        return $arr;
    }

    public function deleteCategorie($id)
    {
        $this->db->trans_begin();
        $this->db->where('for_id', $id);
        if (!$this->db->delete('attach_categories_translations')) {
            log_message('error', print_r($this->db->error(), true));
        }

        $this->db->where('id', $id);
        $this->db->or_where('sub_for', $id);
        if (!$this->db->delete('attach_categories')) {
            log_message('error', print_r($this->db->error(), true));
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

    public function setCategorie($post)
    {
        $this->db->trans_begin();
        if (!$this->db->insert('attach_categories', array('sub_for' =>0))) {
            log_message('error', print_r($this->db->error(), true));
        }
        $id = $this->db->insert_id();

        $i = 0;
        foreach ($post['translations'] as $abbr) {
            $arr = array();
            $arr['abbr'] = $abbr;
            $arr['name'] = $post['categorie'];
            $arr['for_id'] = $id;
            if (!$this->db->insert('attach_categories_translations', $arr)) {
                log_message('error', print_r($this->db->error(), true));
            }
            $i++;
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

}
