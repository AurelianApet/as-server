<?php

 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Users extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
    }

    public function index()
    {
        $this->login_check();
        if (isset($_GET['delete'])) {
            $this->Users_model->deleteUser($_GET['delete']);
            $this->session->set_flashdata('result_delete', '유저가 삭제되었습니다!');
            redirect('admin/users');
        }
        if (isset($_GET['edit']) && !isset($_POST['username'])) {
            $_POST = $this->Users_model->getUsers($_GET['edit']);
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Users';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['users'] = $this->Users_model->getUsers();
        $this->form_validation->set_rules('username', 'User', 'trim|required');
        if (isset($_POST['edit']) && $_POST['edit'] == 0) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
        }
        if ($this->form_validation->run($this)) {
            $this->Users_model->setUser($_POST);
            $this->saveHistory('Create user - ' . $_POST['username']);
            redirect('admin/users');
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('manage_user/users', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Users');
    }

}
