<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Guides extends REST_Controller
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
        $this->methods['guideDel_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('admin/Guides_model');
        $this->allowed_img_types = $this->config->item('allowed_img_types');
    }

    /*
     * Get All Guides
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
        $rowscount = $this->Guides_model->guidesCount($search_title, $category);
        $guides = $this->Guides_model->getGuides($this->num_rows, $page, $search_title, $orderby, $category);

        if ($guides) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'count' => $rowscount,
                'result' => $guides
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No guides were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Get One Guide
     */

    public function one_get()
    {
        $id = 0;
        if ($this->input->get('id') !== NULL) {
            $id = (int) $this->input->get('id');
        }
        $guide = $this->Guides_model->getOneGuide($id);

        if ($guide) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'result' => $guide
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No guide were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Set Guide
     */

    public function create_post()
    {
        $errors = [];
        $_POST['image'] = $this->uploadImage();
        if (!isset($_POST['setup_guide']) || empty($_POST['setup_guide'])) {
            $errors[] = 'No setup_guide array or empty';
        }
        if (!empty($errors)) {
            $error = implode(", ", $errors);
            $message = [
                'message' => $error
            ];
        } else {
            $this->Guides_model->createGuide($_POST);
            $message = [
                'status' => TRUE,
                'message' => 'Success add guide'
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function update_post($id)
    {
        $errors = [];
        $_POST['image'] = $this->uploadImage();
        if (!isset($_POST['title']) || empty($_POST['title'])) {
            $errors[] = 'No title array or empty';
        }
        if (!isset($_POST['setup_guide']) || empty($_POST['setup_guide'])) {
            $errors[] = 'No setup_guide array or empty';
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
            $this->Guides_model->updateGuide($_POST, $id);
            $message = [
                'status' => TRUE,
                'message' => 'Success update guide'
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
        $u_path = 'attachments/shop_images/';
        $result = base_url($u_path . $row->image);
        return $result;
    }

    public function uploadfile_post()
    {
        $config['upload_path'] = './attachments/shop_images/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        $u_path = 'attachments/shop_images/';
        $image = base_url($u_path . $img['file_name']);
        $message = [
                'status' => TRUE,
                'message' => 'Success upload file',
                'result' => $image
        ];
        // return $image;
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

    public function guideDel_delete($id)
    {
        $id = (int) $id;
        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        $this->Guides_model->deleteGuide($id);
        $message = [
            'status' => TRUE,
            'id' => $id,
            'message' => 'Deleted the guide'
        ];
        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}
