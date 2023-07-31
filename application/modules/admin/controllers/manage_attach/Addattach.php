<?php

 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Addattach extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Attachs_model',
            'Languages_model',
            'AttachCategories_model'
        ));
    }

    public function index($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Attachs_model->getOneAttach($id);
            $trans_load = $this->Attachs_model->getTranslations($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $_POST['image'] = $this->uploadImage();
            $this->Attachs_model->setAttach($_POST, $id);
            if ($id == 0) {
                $this->session->set_flashdata('result_publish', '부품이 추가되었습니다!');
                $this->saveHistory('Success published Attach');
            } else {
                $this->session->set_flashdata('result_publish', '부품이 업데이트 되었습니다!');
                $this->saveHistory('Success updated Attach');
            }
            if (isset($_SESSION['filter']) && $id > 0) {
                $get = '';
                foreach ($_SESSION['filter'] as $key => $value) {
                    $get .= trim($key) . '=' . trim($value) . '&';
                }
                redirect(base_url('admin/attachs?' . $get));
            } else {
                redirect('admin/attachs');
            }
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Publish Attach';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['categories'] = $this->AttachCategories_model->getCategories();
        $data['allowedTypes'] = $this->allowed_img_types;
        $this->load->view('_parts/header', $head);
        $this->load->view('manage_attach/addattach', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish attach');
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

}
