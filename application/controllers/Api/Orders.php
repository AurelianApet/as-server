<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Orders extends REST_Controller
{

    private $num_rows = 1000;

    function __construct()
    {
        parent::__construct();
        $this->methods['all_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['one_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['create_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['update_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['productDel_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('admin/Product_orders_model');
    }

    /*
     * Get All Orders
     */

    public function all_get($page = 0)
    {
        unset($_SESSION['filter']);
        $search_user = null;
        if ($this->input->get('search_user') !== NULL) {
            $search_user = $this->input->get('search_user');
            $_SESSION['filter']['search_user'] = $search_user;
            $this->saveHistory('Search for requested user - ' . $search_user);
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
            $this->saveHistory('Search for order code - ' . $status);
        }
        $onlyNew = null;
        if ($this->input->get('onlyNew') !== NULL) {
            $onlyNew = $this->input->get('onlyNew');
            $_SESSION['filter']['onlyNew '] = $onlyNew;
            $this->saveHistory('Search for viewed code - ' . $onlyNew);
        }
        $rowscount = $this->Product_orders_model->ordersCount($search_user, $status, $onlyNew);
        $orders = $this->Product_orders_model->getOrders($this->num_rows, $page, $search_user, $orderby, $status, $onlyNew);

        if ($orders) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'count' => $rowscount,
                'result' => $orders
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No orders were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Get One Order
     */

    public function one_get()
    {
        $id = 0;
        if ($this->input->get('id') !== NULL) {
            $id = (int) $this->input->get('id');
        }
        $order = $this->Product_orders_model->getOneOrder($id);

        if ($order) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'result' => $order
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No order were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Get User Order
     */

    public function user_get()
    {
        $user_id = 0;
        $page = 0;
        if ($this->input->get('user_id') !== NULL) {
            $user_id = (int) $this->input->get('user_id');
        }
        $rowscount = $this->Product_orders_model->getUserOrdersHistoryCount($user_id);
        $orders = $this->Product_orders_model->getUserOrdersHistory($user_id, $this->num_rows, $page);

        if ($orders) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'count' => $rowscount,
                'result' => $orders
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No orders were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Set Order
     */

    public function create_post()
    {
        $errors = [];
        if (!isset($_POST['pay_type']) || empty($_POST['pay_type'])) {
            $errors[] = 'No pay_type array or empty';
        }
        if (!isset($_POST['username']) || empty($_POST['username'])) {
            $errors[] = 'No username array or empty';
        }
        $_POST['address'] = 'user_address';
        if (!isset($_POST['user_email']) || empty($_POST['user_email'])) {
            $errors[] = 'No user_email array or empty';
        }
        if (!isset($_POST['product_name']) || empty($_POST['product_name'])) {
            $errors[] = 'No product_name array or empty';
        }
        if (!isset($_POST['product_id'])) {
            $errors[] = 'categorie not found';
        }
        if (!isset($_POST['user_id'])) {
            $errors[] = 'user_id not found';
        }
        if (!isset($_POST['pay_status'])) {
            $errors[] = 'pay_status not found';
        }
        if (!empty($errors)) {
            $error = implode(", ", $errors);
            $message = [
                'status' => FALSE,
                'message' => $error
            ];
        } else {
            $this->Product_orders_model->createOrder($_POST);
            $message = [
                'status' => TRUE,
                'message' => 'Success add order'
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function update_post($id)
    {
        $id = (int) $id;
        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        $this->Product_orders_model->changeOrderStatus($id, 1);
        $message = [
            'status' => TRUE,
            'message' => 'Success update order'
        ];
        $this->set_response($message, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }

    public function orderDel_delete($id)
    {
        $id = (int) $id;
        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        $this->Product_orders_model->deleteOrder($id);
        $message = [
            'status' => TRUE,
            'id' => $id,
            'message' => 'Deleted the order'
        ];
        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}
