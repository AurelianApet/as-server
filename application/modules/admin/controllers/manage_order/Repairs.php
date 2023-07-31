<?php
 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Repairs extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Repair_model');
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Repairs';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Repair_model->deleteRepair($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Repair is deleted!');
            $this->saveHistory('Delete repair id - ' . $_GET['delete']);
            redirect('admin/repairs');
        }

        unset($_SESSION['filter']);
        $search_user = null;
        if ($this->input->get('search_user') !== NULL) {
            $search_user = $this->input->get('search_user');
            $_SESSION['filter']['search_user'] = $search_user;
            $this->saveHistory('Search for requested user - ' . $search_user);
        }
        $orderby = null;
        if ($this->input->get('order_by') !== NULL) {
            $orderby = $this->input->get('order_by');
            $_SESSION['filter']['order_by '] = $orderby;
        }
        $status = null;
        if ($this->input->get('status') !== NULL) {
            $status = $this->input->get('status');
            $_SESSION['filter']['status '] = $status;
            $this->saveHistory('Search for repair code - ' . $status);
        }
        $rowscount = $this->Repair_model->repairsCount($search_user, $status);
        $data['repairs'] = $this->Repair_model->getRepairs($this->num_rows, $page, $search_user, $orderby, $status);
        $data['links_pagination'] = pagination('admin/repairs', $rowscount, $this->num_rows, 3);
        $this->saveHistory('Go to Repairs');
        $this->load->view('_parts/header', $head);
        $this->load->view('manage_order/repairs', $data);
        $this->load->view('_parts/footer');
    }
    
}
