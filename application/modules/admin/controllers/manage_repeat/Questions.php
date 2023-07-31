<?php

 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Questions extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Categories_model', 'Repeat_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Repeat Questions';
        $head['description'] = '!';
        $head['keywords'] = '';
        
        unset($_SESSION['filter']);
        $search_title = null;
        if ($this->input->get('search_title') !== NULL) {
            $search_title = $this->input->get('search_title');
            $_SESSION['filter']['search_title'] = $search_title;
            $this->saveHistory('Search for question title - ' . $search_title);
        }
        $orderby = null;
        if ($this->input->get('order_by') !== NULL) {
            $orderby = $this->input->get('order_by');
            $_SESSION['filter']['order_by '] = $orderby;
        }
        $category = null;
        if ($this->input->get('category') !== NULL) {
            $category = $this->input->get('category');
            $_SESSION['filter']['category '] = $category;
            $this->saveHistory('Search for question code - ' . $category);
        }
        if (isset($_GET['delete'])) {
            $this->saveHistory('Delete a repeat question');
            $this->Repeat_model->deleteRepeat($_GET['delete']);
            $this->session->set_flashdata('result_delete', '질문이 삭제되엇습니다!');
            redirect('admin/questions');
        }
        $rowscount = $this->Repeat_model->repeatsCount($search_title, $category);
        $data['repeat_questions'] = $this->Repeat_model->getRepeats($this->num_rows, $page, $search_title, $orderby, $category);
        $data['links_pagination'] = pagination('admin/questions', $rowscount, $this->num_rows, 3);
        $data['categories'] = $this->Categories_model->getCategories(null, null, 2);
        $this->load->view('_parts/header', $head);
        $this->load->view('manage_repeat/questions', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to repeat questions');
    }

}
