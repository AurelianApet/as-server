<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Questions extends REST_Controller
{

    private $num_rows = 1000;

    function __construct()
    {
        parent::__construct();
        $this->methods['all_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['one_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['create_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['update_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['questionDel_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('admin/Questions_model');
    }

    /*
     * Get All Questions
     */

    public function all_get($page = 0)
    {
        unset($_SESSION['filter']);
        $search_user = null;
        if ($this->input->get('search_user') !== NULL) {
            $search_user = $this->input->get('search_user');
            $_SESSION['filter']['search_user'] = $search_user;
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
        }
        $rowscount = $this->Questions_model->questionsCount($search_user, $status);
        $questions = $this->Questions_model->getQuestions($this->num_rows, $page, $search_user, $orderby, $status);

        if ($questions) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'count' => $rowscount,
                'result' => $questions
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No questions were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Get One Question
     */

    public function one_get()
    {
        $id = 0;
        if ($this->input->get('id') !== NULL) {
            $id = (int) $this->input->get('id');
        }
        $question = $this->Questions_model->getOneQuestion($id);

        if ($question) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'result' => $question
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No question were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Set Question
     */

    public function create_post()
    {
        $errors = [];
        if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
            $errors[] = 'No user_id array or empty';
        }
        if (!isset($_POST['username']) || empty($_POST['username'])) {
            $errors[] = 'No username array or empty';
        }
        // if (!isset($_POST['user_email']) || empty($_POST['user_email'])) {
        //     $errors[] = 'No user_email array or empty';
        // }
        //if (!isset($_POST['status']) || empty($_POST['status'])) {
        //    $errors[] = 'No status array or empty';
        //}
        if (!empty($errors)) {
            $error = implode(", ", $errors);
            $message = [
            	'status' => FALSE,
                'message' => $error
            ];
        } else {
            $this->Questions_model->createQuestion($_POST);
            $message = [
                'status' => TRUE,
                'message' => 'Success add question'
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function update_post($id)
    {
        $errors = [];
        if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
            $errors[] = 'No user_id array or empty';
        }
        if (!isset($_POST['username']) || empty($_POST['username'])) {
            $errors[] = 'No username array or empty';
        }
        // if (!isset($_POST['user_email']) || empty($_POST['user_email'])) {
        //     $errors[] = 'No user_email array or empty';
        // }
        if (!isset($_POST['status']) || empty($_POST['status'])) {
            $errors[] = 'No status array or empty';
        }
        if (!empty($errors)) {
            $error = implode(", ", $errors);
            $message = [
                'message' => $error
            ];
        } else {
            $id = (int) $id;
            $this->Questions_model->updateQuestion($_POST, $id);
            $message = [
                'status' => TRUE,
                'message' => 'Success update question'
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function questionDel_delete($id)
    {
        $id = (int) $id;
        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        $this->Questions_model->deleteQuestion($id);
        $message = [
            'status' => TRUE,
            'id' => $id,
            'message' => 'Deleted the question'
        ];
        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}
