<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Repeats extends REST_Controller
{
    private $num_rows = 1000;

    function __construct()
    {
        parent::__construct();
        $this->methods['all_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['one_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['create_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['update_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['repeatDel_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('admin/Repeat_model');
    }

    /*
     * Get All Repeats
     */

    public function all_get($page = 0)
    {
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
        }
        $rowscount = $this->Repeat_model->repeatsCount($search_title, $category);
        $repeats = $this->Repeat_model->getRepeats($this->num_rows, $page, $search_title, $orderby, $category);

        if ($repeats) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'count' => $rowscount,
                'result' => $repeats
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No repeats were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Get One Repeat
     */

    public function one_get()
    {
        $id = 0;
        if ($this->input->get('id') !== NULL) {
            $id = (int) $this->input->get('id');
        }
        $repeat = $this->Repeat_model->getOneRepeat($id);

        if ($repeat) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'result' => $repeat
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No repeat were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Set Repeat
     */

    public function create_post()
    {
        $errors = [];
        if (!isset($_POST['question']) || empty($_POST['question'])) {
            $errors[] = 'No question array or empty';
        }
        if (!isset($_POST['answer']) || empty($_POST['answer'])) {
            $errors[] = 'No answer array or empty';
        }
        if (!isset($_POST['categorie'])) {
            $errors[] = 'categorie not found';
        }
        if (!empty($errors)) {
            $error = implode(", ", $errors);
            $message = [
                'message' => $error
            ];
        } else {
            $this->Repeat_model->createRepeat($_POST);
            $message = [
                'status' => TRUE,
                'message' => 'Success add repeat'
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function update_post($id)
    {
        $errors = [];
        if (!isset($_POST['question']) || empty($_POST['question'])) {
            $errors[] = 'No question array or empty';
        }
        if (!isset($_POST['answer']) || empty($_POST['answer'])) {
            $errors[] = 'No answer array or empty';
        }
        if (!isset($_POST['categorie'])) {
            $errors[] = 'categorie not found';
        }
        if (!empty($errors)) {
            $error = implode(", ", $errors);
            $message = [
                'message' => $error
            ];
        } else {
            $id = (int) $id;
            $this->Repeat_model->updateRepeat($_POST, $id);
            $message = [
                'status' => TRUE,
                'message' => 'Success update repeat'
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function repeatDel_delete($id)
    {
        $id = (int) $id;
        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        $this->Repeat_model->deleteRepeat($id);
        $message = [
            'status' => TRUE,
            'id' => $id,
            'message' => 'Deleted the repeat'
        ];
        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}
