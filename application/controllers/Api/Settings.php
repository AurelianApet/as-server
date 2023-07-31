<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Settings extends REST_Controller
{

    private $num_rows = 1000;

    function __construct()
    {
        parent::__construct();
        $this->methods['all_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['update_post']['limit'] = 500; // 100 requests per hour per user/key
        $this->load->model(array('admin/Home_admin_model', 'admin/Settings_model'));
    }

    /*
     * Get All Settings
     */

    public function all_get()
    {
        $settings = $this->Settings_model->getValueStores();

        if ($settings) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'result' => $settings
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No settings were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Update Settings
     */

    public function update_post()
    {
        $post = $this->request->body;
        $message = [
            'status' => FALSE,
            'message' => 'Failed update settings'
        ];
        if (isset($post['paymentDone'])) {
            $this->Home_admin_model->setValueStore('paymentDone', $post['paymentDone']);
            $message = [
                'status' => TRUE,
                'message' => 'Success update setting'
            ];
        }
        if (isset($post['answerDone'])) {
            $this->Home_admin_model->setValueStore('answerDone', $post['answerDone']);
            $message = [
                'status' => TRUE,
                'message' => 'Success update setting'
            ];
        }
        if (isset($post['paymentRequest'])) {
            $this->Home_admin_model->setValueStore('paymentRequest', $post['paymentRequest']);
            $message = [
                'status' => TRUE,
                'message' => 'Success update setting'
            ];
        }
        if (isset($post['productUpdate'])) {
            $this->Home_admin_model->setValueStore('productUpdate', $post['productUpdate']);
            $message = [
                'status' => TRUE,
                'message' => 'Success update setting'
            ];
        }
        if (isset($post['productAdd'])) {
            $this->Home_admin_model->setValueStore('productAdd', $post['productAdd']);
            $message = [
                'status' => TRUE,
                'message' => 'Success update setting'
            ];
        }
        $this->set_response($message, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }

}
