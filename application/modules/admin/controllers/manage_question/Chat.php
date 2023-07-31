<?php
 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Chat extends ADMIN_Controller
{

    private $num_rows = 100;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Chat_model', 'Users_model']);
    }

    public function index($user_id = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Chat';
        $head['description'] = '!';
        $head['keywords'] = '';

        $rowscount = $this->Chat_model->chatCount($user_id);
        $data['chat_histories'] = $this->Chat_model->getChatHistories($this->num_rows, 0, $user_id);
        $data['admin'] = $this->session->userdata('logged_in');
        $data['user'] = $this->Users_model->getUsers($user_id);
        $this->saveHistory('Go to Chat');
        $this->load->view('_parts/header', $head);
        $this->load->view('manage_question/chat', $data);
    }

    /*
     * Called from ajax
     */
    public function insertNewMessage()
    {
        $this->login_check();
        $result = $this->Chat_model->createChat($_POST);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
    }
    
}
