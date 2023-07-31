<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Categories extends REST_Controller
{

    private $num_rows = 1000;

    function __construct()
    {
        parent::__construct();
        $this->methods['all_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['create_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['categoryDel_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('admin/Categories_model');
    }

    /*
     * Get All Products
     */

    public function all_get($page = 0)
    {
        $rowscount = $this->Categories_model->categoriesCount();
        $categories = $this->Categories_model->getCategories($this->num_rows, $page);

        if ($categories) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'count' => $rowscount,
                'result' => $categories
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No categories were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Set Category
     */

    public function create_post()
    {
        $errors = [];
        $post = $this->request->body;
        $post['position'] = 0;
        $post['translations'] = ['en'];
        if (!isset($post['categorie'])) {
            $errors[] = 'categorie not found';
        }
        // if (!isset($_POST['position'])) {
        //     $errors[] = 'position not found';
        // }
        if (!empty($errors)) {
            $error = implode(", ", $errors);
            $message = [
                'status' => FALSE,
                'message' => $error
            ];
        } else {
            $this->Categories_model->setCategorie($post);
            $message = [
                'status' => TRUE,
                'message' => 'Success add category'
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function categoryDel_delete($id)
    {
        $id = (int) $id;
        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        $this->Categories_model->deleteCategorie($id);
        $message = [
            'status' => TRUE,
            'id' => $id,
            'message' => 'Deleted the category'
        ];
        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}
