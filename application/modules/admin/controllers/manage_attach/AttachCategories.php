<?php

 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class AttachCategories extends ADMIN_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('AttachCategories_model', 'Languages_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Attach Categories';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['categories'] = $this->AttachCategories_model->getCategories($this->num_rows, $page);
        $data['languages'] = $this->Languages_model->getLanguages();
        $rowscount = $this->AttachCategories_model->categoriesCount();
        $data['links_pagination'] = pagination('admin/attachCategories', $rowscount, $this->num_rows, 3);
        if (isset($_GET['delete'])) {
            $this->saveHistory('Delete a attachCategorie');
            $this->AttachCategories_model->deleteCategorie($_GET['delete']);
            $this->session->set_flashdata('result_delete', '카테고리가 삭제되었습니다!');
            redirect('admin/attachCategories');
        }
        if (isset($_POST['submit'])) {
            $this->AttachCategories_model->setCategorie($_POST);
            $this->session->set_flashdata('result_add', '카테고리가 추가되었습니다!');
            redirect('admin/attachCategories');
        }
        $this->load->view('_parts/header', $head);
        $this->load->view('manage_attach/attachCategories', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to attachCategories');
    }

}
