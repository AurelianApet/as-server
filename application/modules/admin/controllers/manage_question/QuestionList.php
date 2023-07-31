<?php
 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class QuestionList extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Questions_model');
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View QuestionList';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Questions_model->deleteQuestion($_GET['delete']);
            $this->session->set_flashdata('result_delete', '질문이 삭제되었습니다!');
            $this->saveHistory('Delete question id - ' . $_GET['delete']);
            redirect('admin/questionlist');
        }

        unset($_SESSION['filter']);
        $search_user = null;
        if ($this->input->get('search_user') !== NULL) {
            $search_user = $this->input->get('search_user');
            $_SESSION['filter']['search_user'] = $search_user;
            $this->saveHistory('Search for asked user - ' . $search_user);
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
            $this->saveHistory('Search for question code - ' . $status);
        }
        $rowscount = $this->Questions_model->questionsCount($search_user, $status);
        $data['questionlist'] = $this->Questions_model->getQuestions($this->num_rows, $page, $search_user, $orderby, $status);
        $data['links_pagination'] = pagination('admin/questionlist', $rowscount, $this->num_rows, 3);
        $this->saveHistory('Go to Questions');
        $this->load->view('_parts/header', $head);
        $this->load->view('manage_question/questionlist', $data);
        $this->load->view('_parts/footer');
    }
    
}
