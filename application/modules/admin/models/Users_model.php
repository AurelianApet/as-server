<?php

class Users_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function usersCount()
    {
        return $this->db->count_all_results('users_public');
    }

    public function deleteUser($id)
    {
        $this->db->where('id', $id);
        if (!$this->db->delete('users_public')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function getUsers($user = null)
    {
        if ($user != null && is_numeric($user)) {
            $this->db->where('id', $user);
        } else if ($user != null && is_string($user)) {
            $this->db->where('username', $user);
        }
        $query = $this->db->get('users_public');
        if ($user != null) {
            return $query->row_array();
        } else {
            return $query->result();
        }
    }

    public function setUser($post)
    {
        if ($post['edit'] > 0) {
            $array = array(
                'name' => $post['username'],
                'address' => $post['address'],
                'email' => $post['email']
            );
            if (trim($post['password']) != '') {
                $array['password'] = md5($post['password']);
            }
            $this->db->where('id', $post['edit']);
            $this->db->update('users_public', $array);
        }
    }

    public function registerUser($post)
    {
        $this->db->insert('users_public', array(
            'name' => $post['name'],
            'address' => $post['address'],
            'email' => $post['email'],
            'password' => md5($post['password'])
        ));
        return $this->db->insert_id();
    }

    public function updateUser($post)
    {
        $array = array(
            'name' => $post['name'],
            'address' => $post['address'],
            'email' => $post['email']
        );
        if (trim($post['password']) != '') {
            $array['password'] = md5($post['password']);
        }
        $this->db->where('id', $post['edit']);
        $this->db->update('users_public', $array);
    }

    public function checkPublicUserIsValid($post)
    {
        $this->db->where('email', $post['email']);
        $this->db->where('password', md5($post['password']));
        $query = $this->db->get('users_public');
        $result = $query->row_array();
        if (empty($result)) {
            return false;
        } else {
            return $result['id'];
        }
    }

    public function checkUserExsists($post)
    {
        $this->db->where('name', $post['name']);
        return $this->db->count_all_results('users_public');
    }

    public function updateUserPassword($email)
    {
        $newPass = str_shuffle(bin2hex(openssl_random_pseudo_bytes(4)));
        $this->db->where('email', $email);
        if (!$this->db->update('users_public', ['password' => password_hash($newPass, PASSWORD_DEFAULT)])) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
        return $newPass;
    }
}
