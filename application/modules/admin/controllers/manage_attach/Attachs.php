<?php

 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Attachs extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Attachs_model', 'Languages_model', 'AttachCategories_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Attachs';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Attachs_model->deleteAttach($_GET['delete']);
            $this->session->set_flashdata('result_delete', '부품이 삭제되었습니다!');
            $this->saveHistory('Delete attach id - ' . $_GET['delete']);
            redirect('admin/attachs');
        }

        unset($_SESSION['filter']);
        $search_title = null;
        if ($this->input->get('search_title') !== NULL) {
            $search_title = $this->input->get('search_title');
            $_SESSION['filter']['search_title'] = $search_title;
            $this->saveHistory('Search for attach title - ' . $search_title);
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
            $this->saveHistory('Search for attach code - ' . $category);
        }
        $vendor = null;
        if ($this->input->get('show_vendor') !== NULL) {
            $vendor = $this->input->get('show_vendor');
        }
        $data['attachs_lang'] = $attachs_lang = $this->session->userdata('admin_lang_attachs');
        $rowscount = $this->Attachs_model->attachsCount($search_title, $category);
        $data['attachs'] = $this->Attachs_model->getAttachs($this->num_rows, $page, $search_title, $orderby, $category);
        $data['links_pagination'] = pagination('admin/attachs', $rowscount, $this->num_rows, 3);
        $data['num_shop_art'] = $this->Attachs_model->numShopAttachs();
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['categories'] = $this->AttachCategories_model->getCategories(null, null, 2);
        $this->saveHistory('Go to attachs');
        $this->load->view('_parts/header', $head);
        $this->load->view('manage_attach/attachs', $data);
        $this->load->view('_parts/footer');
    }

    public function getAttachInfo($id, $noLoginCheck = false)
    {
        /* 
         * if method is called from public(template) page
         */
        if ($noLoginCheck == false) {
            $this->login_check();
        }
        return $this->Attachs_model->getOneAttach($id);
    }

    /*
     * called from ajax
     */

    public function attachStatusChange()
    {
        $this->login_check();
        $result = $this->Attachs_model->attachStatusChange($_POST['id'], $_POST['to_status']);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Change attach id ' . $_POST['id'] . ' to status ' . $_POST['to_status']);
    }

}
