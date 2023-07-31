<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Users extends REST_Controller
{
    private $num_rows = 1000;

    function __construct()
    {
        parent::__construct();
        $this->methods['all_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['one_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['create_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['update_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['userDel_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model(array('admin/Products_model','admin/Attachs_model','admin/Users_model'));
    }

    /*
     * Get All Users
     */

    public function all_get($page = 0)
    {
        $rowscount = $this->Users_model->usersCount();
        $users = $this->Users_model->getUsers();

        if ($users) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'count' => $rowscount,
                'result' => $users
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Get One User
     */

    public function one_get()
    {
        $id = 0;
        if ($this->input->get('id') !== NULL) {
            $id = (int) $this->input->get('id');
        }
        $user = $this->Users_model->getUsers($id);

        if ($user) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'result' => $user
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Set User
     */

    public function create_post()
    {
        $errors = [];
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $errors[] = 'No name array or empty';
        }
        if (!isset($_POST['address']) || empty($_POST['address'])) {
            $errors[] = 'No address array or empty';
        }
        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $errors[] = 'No email array or empty';
        }
        if (!isset($_POST['password'])) {
            $errors[] = 'password not found';
        }
        if (!empty($errors)) {
            $error = implode(", ", $errors);
            $message = [
                'message' => $error
            ];
        } else {
            $this->Users_model->registerUser($_POST);
            $message = [
                'status' => TRUE,
                'message' => 'Success add user'
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function update_post($id)
    {
        $errors = [];
        $post = $this->request->body;
        if (!isset($post['name']) || empty($post['name'])) {
            $errors[] = 'No name array or empty';
        }
        if (!isset($post['address']) || empty($post['address'])) {
            $errors[] = 'No address array or empty';
        }
        if (!isset($post['email']) || empty($post['email'])) {
            $errors[] = 'No email array or empty';
        }
        if (!isset($post['password'])) {
            $errors[] = 'password not found';
        }
        if (!empty($errors)) {
            $error = implode(", ", $errors);
            $message = [
                'message' => $error
            ];
        } else {
            $post['edit'] = (int) $id;
            $this->Users_model->updateUser($post);
            $message = [
                'status' => TRUE,
                'message' => 'Success update user'
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function userDel_delete($id)
    {
        $id = (int) $id;
        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        $this->Users_model->deleteUser($id);
        $message = [
            'status' => TRUE,
            'id' => $id,
            'message' => 'Deleted the user'
        ];
        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

    public function login_post()
    {
        $result = $this->Users_model->checkPublicUserIsValid($_POST);
        if ($result !== false) {
            $_SESSION['logged_user'] = $result; //id of user
            $data['attachsCount'] = $this->Attachs_model->attachsCount();
            $data['products_count'] = $this->Products_model->productsCount();
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

    public function register_post()
    {
        $errors = [];
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $errors[] = 'No name array or empty';
        }
        if (!isset($_POST['address']) || empty($_POST['address'])) {
            $errors[] = 'No address array or empty';
        }
        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $errors[] = 'No email array or empty';
        }
        if (!isset($_POST['password'])) {
            $errors[] = 'password not found';
        }
        $count_emails = $this->Users_model->checkUserExsists($_POST['email']);
        if ($count_emails > 0) {
            $errors[] = 'Email is already using';
        }
        if (!empty($errors)) {
            $error = implode(", ", $errors);
            $message = [
                'status' => FALSE,
                'message' => $error
            ];
        } else {
            $this->Users_model->registerUser($_POST);
            $data['attachsCount'] = $this->Attachs_model->attachsCount();
            $data['products_count'] = $this->Products_model->productsCount();
            $message = [
                'status' => TRUE,
                'message' => 'Register Success',
                'result' => $data
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK);
    }

}
