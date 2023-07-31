<?php

class Product_orders_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function ordersCount($search_user = null, $status = null, $onlyNew = false)
    {
        if ($search_user != null) {
            $search_user = trim($this->db->escape_like_str($search_user));
            $this->db->where("(product_order.username LIKE '%$search_user%')");
        }
        if ($status != null) {
            $this->db->where('status', $status);
        }
        if ($onlyNew != true) {
            $this->db->where('viewed', 0);
        }
        return $this->db->count_all_results('product_order');
    }

    public function getUserOrdersHistoryCount($userId)
    {
        $this->db->where('user_id', $userId);
        return $this->db->count_all_results('product_order');
    }

    public function getUserOrdersHistory($userId, $limit, $page)
    {
        $this->db->where('user_id', $userId);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('product_order', $limit, $page);
        return $query->result();
        // return $result->result_array();
    }

    public function getOrders($limit, $page, $search_user = null, $orderby = null, $status = null, $onlyNew = false)
    {
        if ($search_user != null) {
            $search_user = trim($this->db->escape_like_str($search_user));
            $this->db->where("(product_order.username LIKE '%$search_user%')");
        }
        if ($orderby == 'desc') {
            $this->db->order_by('product_order.date', ' desc');
        } else {
            $this->db->order_by('product_order.date', 'asc');
        }
        if ($status != null) {
            $this->db->where('status', $status);
        }
        if ($onlyNew != true) {
            $this->db->where('viewed', 0);
        }

        $query = $this->db->get('product_order', $limit, $page);
        return $query->result();
    }

    public function getOneOrder($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('product_order');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function createOrder($post)
    {
        $array = array(
            'user_id' => $post['user_id'],
            'username' => $post['username'],
            'address' => $post['address'],
            'user_email' => $post['user_email'],
            'product_name' => $post['product_name'],
            'product_id' => $post['product_id'],
            'pay_type' => $post['pay_type'],
            'pay_status' => $post['pay_status'],
            'viewed' => 0 ,
            'status' => 0,
        );
        $this->db->insert('product_order', $array);
        $this->db->insert_id();
        $this->manageProcurement($post['product_id']);
    }
    public function changeOrderStatus($id, $to_status)
    {
        $this->db->where('id', $id);
        // $this->db->select('status');
        $result1 = $this->db->get('product_order');
        $res = $result1->row_array();

        $result = true;
        if ($res['status'] != $to_status) {
            $this->db->where('id', $id);
            $result = $this->db->update('product_order', array('status' => $to_status, 'viewed' => '1'));
            // if ($result == true) {
            //     $this->manageProcurement($res['product_id']);
            // }
        }
        // return $result->result();
        return $result;
    }

    private function manageProcurement($id)
    {
        if (!$this->db->query('UPDATE products SET procurement=procurement' . '+' . 1 . ' WHERE id = ' . $id)) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        } 
    }

    public function deleteOrder($id)
    {
        $this->db->where('id', $id);
        if (!$this->db->delete('product_order')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }
    
}
