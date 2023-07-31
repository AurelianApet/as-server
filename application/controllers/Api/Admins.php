<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Admins extends REST_Controller
{

    private $num_rows = 100;

    function __construct()
    {
        parent::__construct();
        $this->methods['login_post']['limit'] = 500; // 500 requests per hour per user/key
        $this->load->model(array('admin/Products_model','admin/Attachs_model', 'admin/Repair_model','admin/Questions_model','admin/Admin_users_model'));
    }

    public function login_post()
    {
        $result = $this->Admin_users_model->checkUserIsValid($this->request->body);
        if ($result !== false) {
            $_SESSION['logged_user'] = $result; //id of user
            $data['attachsCount'] = $this->Attachs_model->attachsCount();
            $data['products_count'] = $this->Products_model->productsCount();
            $data['repair_count'] = $this->Repair_model->repairsCount();
            $data['question_count'] = $this->Questions_model->questionsCount();
            $data['id'] = $result;
            $message = [
                'status' => TRUE,
                'message' => 'Login Success',
                'result' => $data
            ];
        } else {
            $message = [
                'status' => FALSE,
                'message' => 'Wrong Username or Password'
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

}
