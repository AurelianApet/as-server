<?php

class Attachs_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteAttach($id)
    {
        $this->db->trans_begin();
        $this->db->where('for_id', $id);
        if (!$this->db->delete('attachs_translations')) {
            log_message('error', print_r($this->db->error(), true));
        }

        $this->db->where('id', $id);
        if (!$this->db->delete('attachs')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

    public function attachsCount($search_title = null, $category = null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(attachs_translations.title LIKE '%$search_title%')");
        }
        if ($category != null) {
            $this->db->where('categorie', $category);
        }
        $this->db->join('attachs_translations', 'attachs_translations.for_id = attachs.id', 'left');
        $this->db->where('attachs_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        return $this->db->count_all_results('attachs');
    }

    public function getAttachs($limit, $page, $search_title = null, $orderby = null, $category = null, $vendor = null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(attachs_translations.title LIKE '%$search_title%')");
        }
        if ($orderby !== null) {
            $ord = explode('=', $orderby);
            if (isset($ord[0]) && isset($ord[1])) {
                $this->db->order_by('attachs.' . $ord[0], $ord[1]);
            }
        } else {
            $this->db->order_by('attachs.position', 'asc');
        }
        if ($category != null) {
            $this->db->where('categorie', $category);
        }
        if ($vendor != null) {
            $this->db->where('vendor_id', $vendor);
        }
        $this->db->join('vendors', 'vendors.id = attachs.vendor_id', 'left');
        $this->db->join('attachs_translations', 'attachs_translations.for_id = attachs.id', 'left');
        $this->db->where('attachs_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, attachs.*, attachs_translations.title, attachs_translations.description, attachs_translations.price, attachs_translations.serial_number, attachs_translations.abbr, attachs.url, attachs_translations.for_id')->get('attachs', $limit, $page);
        return $query->result();
    }

    public function numShopAttachs()
    {
        return $this->db->count_all_results('attachs');
    }

    public function getOneAttach($id)
    {
        $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, attachs.*, attachs_translations.*');
        $this->db->where('attachs.id', $id);
        $this->db->join('vendors', 'vendors.id = attachs.vendor_id', 'left');
        $this->db->join('attachs_translations', 'attachs_translations.for_id = attachs.id', 'inner');
        $this->db->where('attachs_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->get('attachs');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function attachStatusChange($id, $to_status)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('attachs', array('visibility' => $to_status));
        return $result;
    }

    public function setAttach($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->update('attachs', array(
                        'image' => $post['image'] != null ? $post['image'] : $post['old_image'],
                        'categorie' => $post['categorie'],
                        'quantity' => $post['quantity'],
                        'position' => 0,
                        'time_update' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            /*
             * Lets get what is default tranlsation number
             * in titles and convert it to url
             * We want our plaform public ulrs to be in default 
             * language that we use
             */
            $i = 0;
            foreach ($post['translations'] as $translation) {
                if ($translation == MY_DEFAULT_LANGUAGE_ABBR) {
                    $myTranslationNum = $i;
                }
                $i++;
            }
            if (!$this->db->insert('attachs', array(
                        'image' => $post['image'],
                        'categorie' => $post['categorie'],
                        'quantity' => $post['quantity'],
                        'position' => 0,
                        'folder' => $post['folder'],
                        'time' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id();

            $post['title'] = str_replace('"', "'", $post['title']);
            $this->db->where('id', $id);
            if (!$this->db->update('attachs', array(
                        'url' => $post['title']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        }
        $this->setAttachTranslation($post, $id, $is_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

    private function setAttachTranslation($post, $id, $is_update)
    {
        $i = 0;
        $current_trans = $this->getTranslations($id);
        foreach ($post['translations'] as $abbr) {
            $arr = array();
            $emergency_insert = false;
            if (!isset($current_trans[$abbr])) {
                $emergency_insert = true;
            }
            $post['title'] = str_replace('"', "'", $post['title']);
            $post['price'] = str_replace(' ', '', $post['price']);
            $post['price'] = str_replace(',', '.', $post['price']);
            $post['price'] = preg_replace("/[^0-9,.]/", "", $post['price']);
            $post['serial_number'] = str_replace(' ', '', $post['serial_number']);
            $post['serial_number'] = str_replace(',', '.', $post['serial_number']);
            // $post['serial_number'] = preg_replace("/[^0-9,.]/", "", $post['serial_number']);
            $arr = array(
                'title' => $post['title'],
                'description' => $post['description'],
                'price' => $post['price'],
                'serial_number' => $post['serial_number'],
                'abbr' => $abbr,
                'for_id' => $id
            );
            if ($is_update === true && $emergency_insert === false) {
                $abbr = $arr['abbr'];
                unset($arr['for_id'], $arr['abbr'], $arr['url']);
                if (!$this->db->where('abbr', $abbr)->where('for_id', $id)->update('attachs_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            } else {
                if (!$this->db->insert('attachs_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            }
            $i++;
        }
    }

    public function getTranslations($id)
    {
        $this->db->where('for_id', $id);
        $query = $this->db->get('attachs_translations');
        $arr = array();
        foreach ($query->result() as $row) {
            $arr[$row->abbr]['title'] = $row->title;
            $arr[$row->abbr]['description'] = $row->description;
            $arr[$row->abbr]['price'] = $row->price;
            $arr[$row->abbr]['serial_number'] = $row->serial_number;
        }
        return $arr;
    }
}
