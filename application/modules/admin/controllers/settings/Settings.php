<?php

 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Settings extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Settings_model');
    }

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Settings';
        $head['description'] = '';
        $head['keywords'] = '';

        $this->postChecker();

        $value_stores = $this->getValueStores();
        if(!is_null($value_stores)) {
            // Map to data
            foreach($value_stores as $value_s) {
                if (!array_key_exists($value_s['thekey'], $data)) {
                    $data[$value_s['thekey']] = $value_s['value'];
                }
            }
            unset($value_stores);
        }
        
        $this->load->view('_parts/header', $head);
        $this->load->view('settings/settings', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Settings Page');
    }

    private function getValueStores()
    {
        $values = $this->Settings_model->getValueStores();
        if(is_array($values) && count($values) > 0) {
            return $values;
        }
        return null;
    }

    private function postChecker()
    {
        if (isset($_POST['paymentDone'])) {
            $this->Home_admin_model->setValueStore('paymentDone', $_POST['paymentDone']);
            $this->session->set_flashdata('paymentDone', '변경되엇습니다.');
            redirect('admin/settings');
        }
        if (isset($_POST['answerDone'])) {
            $this->Home_admin_model->setValueStore('answerDone', $_POST['answerDone']);
            $this->session->set_flashdata('answerDone', '변경되엇습니다.');
            redirect('admin/settings');
        }
        if (isset($_POST['paymentRequest'])) {
            $this->Home_admin_model->setValueStore('paymentRequest', $_POST['paymentRequest']);
            $this->session->set_flashdata('paymentRequest', '변경되엇습니다.');
            redirect('admin/settings');
        }
        if (isset($_POST['productUpdate'])) {
            $this->Home_admin_model->setValueStore('productUpdate', $_POST['productUpdate']);
            $this->session->set_flashdata('productUpdate', '변경되엇습니다.');
            redirect('admin/settings');
        }
        if (isset($_POST['productAdd'])) {
            $this->Home_admin_model->setValueStore('productAdd', $_POST['productAdd']);
            $this->session->set_flashdata('productAdd', '변경되엇습니다.');
            redirect('admin/settings');
        }
    }

}
