<?php
 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Guides extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Guides_model', 'Categories_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Guides';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Guides_model->deleteGuide($_GET['delete']);
            $this->session->set_flashdata('result_delete', '설치가이드가 삭제되었습니다!');
            $this->saveHistory('Delete guide id - ' . $_GET['delete']);
            redirect('admin/guides');
        }

        unset($_SESSION['filter']);
        $search_title = null;
        if ($this->input->get('search_title') !== NULL) {
            $search_title = $this->input->get('search_title');
            $_SESSION['filter']['search_title'] = $search_title;
            $this->saveHistory('Search for guide title - ' . $search_title);
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
            $this->saveHistory('Search for guide code - ' . $category);
        }
        $rowscount = $this->Guides_model->guidesCount($search_title, $category);
        $data['guides'] = $this->Guides_model->getGuides($this->num_rows, $page, $search_title, $orderby, $category);
        $data['links_pagination'] = pagination('admin/guides', $rowscount, $this->num_rows, 3);
        $data['categories'] = $this->Categories_model->getCategories(null, null, 2);
        $this->saveHistory('Go to Guides');
        $this->load->view('_parts/header', $head);
        $this->load->view('manage_guide/guides', $data);
        $this->load->view('_parts/footer');
    }
    
}
