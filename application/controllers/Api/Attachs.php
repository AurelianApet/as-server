<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Attachs extends REST_Controller
{

    private $allowed_img_types;
    private $num_rows = 1000;

    function __construct()
    {
        parent::__construct();
        $this->methods['all_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['one_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['create_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['update_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['attachDel_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('admin/Attachs_model');
        $this->allowed_img_types = $this->config->item('allowed_img_types');
    }

    /*
     * Get All Attachs
     */

    public function all_get($page = 0)
    {
        unset($_SESSION['filter']);
        $search_title = null;
        if ($this->input->get('search_title') !== NULL) {
            $search_title = $this->input->get('search_title');
            $_SESSION['filter']['search_title'] = $search_title;
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
        $rowscount = $this->Attachs_model->attachsCount($search_title, $category);
        $attachs = $this->Attachs_model->getAttachs($this->num_rows, $page, $search_title, $orderby, $category);

        if ($attachs) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'count' => $rowscount,
                'result' => $attachs
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No attachs were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Get One Attach
     */

    public function one_get()
    {
        $id = 0;
        if ($this->input->get('id') !== NULL) {
            $id = (int) $this->input->get('id');
        }
        $attach = $this->Attachs_model->getOneAttach($id);

        if ($attach) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'result' => $attach
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No attach were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Set Attach
     */

    public function create_post()
    {
        $errors = [];
        $_POST['image'] = $this->uploadImage();
        $_POST['translations'] = ['en'];
        $_POST['position'] = 0;
        if (!isset($_POST['title']) || empty($_POST['title'])) {
            $errors[] = 'No title array or empty';
        }
        if (!isset($_POST['description']) || empty($_POST['description'])) {
            $errors[] = 'No description array or empty';
        }
        if (!isset($_POST['price']) || empty($_POST['price'])) {
            $errors[] = 'No price array or empty';
        }
        if (!isset($_POST['serial_number']) || empty($_POST['serial_number'])) {
            $errors[] = 'No serial_number array or empty';
        }
        if (!isset($_POST['categorie'])) {
            $errors[] = 'categorie not found';
        }
        if (!isset($_POST['quantity'])) {
            $errors[] = 'quantity not found';
        }
        if (!empty($errors)) {
            $error = implode(", ", $errors);
            $message = [
                'message' => $error
            ];
        } else {
            $id = 0;
            $this->Attachs_model->setAttach($_POST, $id);
            $message = [
                'status' => TRUE,
                'message' => 'Success add attach'
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function update_post($id)
    {
        $errors = [];
        $_POST['image'] = $this->uploadImage();
        $_POST['translations'] = ['en'];
        $_POST['position'] = 0;
        if (!isset($_POST['title']) || empty($_POST['title'])) {
            $errors[] = 'No title array or empty';
        }
        if (!isset($_POST['description']) || empty($_POST['description'])) {
            $errors[] = 'No description array or empty';
        }
        if (!isset($_POST['price']) || empty($_POST['price'])) {
            $errors[] = 'No price array or empty';
        }
        if (!isset($_POST['serial_number']) || empty($_POST['serial_number'])) {
            $errors[] = 'No serial_number array or empty';
        }
        if (!isset($_POST['categorie'])) {
            $errors[] = 'categorie not found';
        }
        if (!isset($_POST['quantity'])) {
            $errors[] = 'quantity not found';
        }
        if (!empty($errors)) {
            $error = implode(", ", $errors);
            $message = [
                'message' => $error
            ];
        } else {
            $id = (int) $id;
            $this->Attachs_model->setAttach($_POST, $id);
            $message = [
                'status' => TRUE,
                'message' => 'Success update attach'
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    private function uploadImage()
    {
        $config['upload_path'] = './attachments/shop_images/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }

    public function attachDel_delete($id)
    {
        $id = (int) $id;
        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        $this->Attachs_model->deleteAttach($id);
        $message = [
            'status' => TRUE,
            'id' => $id,
            'message' => 'Deleted the attach'
        ];
        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}
