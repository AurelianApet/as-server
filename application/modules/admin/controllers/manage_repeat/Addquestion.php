<?php
 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Addquestion extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Repeat_model',
            'Categories_model'
        ));
    }

    public function index($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $load_data = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Repeat_model->getOneRepeat($id);
            $load_data = $this->Repeat_model->getOneRepeat($id);
        }
        if (isset($_POST['submit'])) {
            if ($id == 0) {
                $this->Repeat_model->createRepeat($_POST);
                $this->session->set_flashdata('result_publish', '질문이 추가되었습니다!');
                $this->saveHistory('Success Added Question');
            } else {
                $this->Repeat_model->updateRepeat($_POST, $id);
                $this->session->set_flashdata('result_publish', '질문이 업데이트 되었습니다!');
                $this->saveHistory('Success updated Question');
            }
            if (isset($_SESSION['filter']) && $id > 0) {
                $get = '';
                foreach ($_SESSION['filter'] as $key => $value) {
                    $get .= trim($key) . '=' . trim($value) . '&';
                }
                redirect(base_url('admin/questions?' . $get));
            } else {
                redirect('admin/questions');
            }
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Publish Question';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['load_data'] = $load_data;
        $data['categories'] = $this->Categories_model->getCategories();
        $this->load->view('_parts/header', $head);
        $this->load->view('manage_repeat/addquestion', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to add question');
    }
   
}
