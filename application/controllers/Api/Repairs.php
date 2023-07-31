<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Repairs extends REST_Controller
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
        $this->methods['repairDel_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('admin/Repair_model');
        $this->allowed_img_types = $this->config->item('allowed_img_types');
    }

    /*
     * Get All Repairs
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
        $rowscount = $this->Repair_model->repairsCount($search_user, $status);
        $repairs = $this->Repair_model->getRepairs($this->num_rows, $page, $search_user, $orderby, $status);

        if ($repairs) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'count' => $rowscount,
                'result' => $repairs
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No repairs were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Get One Repair
     */

    public function one_get()
    {
        $id = 0;
        if ($this->input->get('id') !== NULL) {
            $id = (int) $this->input->get('id');
        }
        $repair = $this->Repair_model->getOneRepair($id);

        if ($repair) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'result' => $repair
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No repair were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Set Repair
     */

    public function create_post()
    {
        $errors = [];
        $_POST['image'] = $this->uploadImage();
        $_POST['status'] = 0;
        if (!isset($_POST['username']) || empty($_POST['username'])) {
            $errors[] = 'No username array or empty';
        }
        if (!isset($_POST['request_id']) || empty($_POST['request_id'])) {
            $errors[] = 'No request_id array or empty';
        }
        if (!isset($_POST['user_address']) || empty($_POST['user_address'])) {
            $errors[] = 'No user_address array or empty';
        }
        if (!isset($_POST['sellername']) || empty($_POST['sellername'])) {
            $errors[] = 'No sellername array or empty';
        }
        if (!isset($_POST['seller_address']) || empty($_POST['seller_address'])) {
            $errors[] = 'No seller_address array or empty';
        }
        if (!isset($_POST['description'])) {
            $errors[] = 'description not found';
        }
        if (!isset($_POST['sell_date'])) {
            $errors[] = 'sell_date not found';
        }
        if (!empty($errors)) {
            $error = implode(", ", $errors);
            $message = [
                'message' => $error
            ];
        } else {
            $this->Repair_model->createRepair($_POST);
            $message = [
                'status' => TRUE,
                'message' => 'Success add repair'
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function update_post($id)
    {
        $errors = [];
        $_POST['image'] = $this->uploadImage();
        $_POST['status'] = 0;
        if (!isset($_POST['username']) || empty($_POST['username'])) {
            $errors[] = 'No username array or empty';
        }
        if (!isset($_POST['request_id']) || empty($_POST['request_id'])) {
            $errors[] = 'No request_id array or empty';
        }
        if (!isset($_POST['user_address']) || empty($_POST['user_address'])) {
            $errors[] = 'No user_address array or empty';
        }
        if (!isset($_POST['sellername']) || empty($_POST['sellername'])) {
            $errors[] = 'No sellername array or empty';
        }
        if (!isset($_POST['seller_address']) || empty($_POST['seller_address'])) {
            $errors[] = 'No seller_address array or empty';
        }
        // if (!isset($_POST['status'])) {
        //     $errors[] = 'status not found';
        // }
        if (!isset($_POST['sell_date'])) {
            $errors[] = 'sell_date not found';
        }
        if (!empty($errors)) {
            $error = implode(", ", $errors);
            $message = [
                'message' => $error
            ];
        } else {
            $id = (int) $id;
            $this->Repair_model->updateRepair($_POST, $id);
            $message = [
                'status' => TRUE,
                'message' => 'Success update repair'
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

    public function repairDel_delete($id)
    {
        $id = (int) $id;
        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        $this->Repair_model->deleteRepair($id);
        $message = [
            'status' => TRUE,
            'id' => $id,
            'message' => 'Deleted the repair'
        ];
        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}
