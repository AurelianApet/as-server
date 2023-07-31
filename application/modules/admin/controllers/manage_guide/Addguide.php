<?php
 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Addguide extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Guides_model',
            'Categories_model'
        ));
    }

    public function index($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $load_data = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Guides_model->getOneGuide($id);
            $load_data = $this->Guides_model->getOneGuide($id);
        }
        if (isset($_POST['submit'])) {
            $_POST['image'] = $this->uploadImage();
            if ($id == 0) {
                $this->Guides_model->createGuide($_POST);
                $this->session->set_flashdata('result_publish', '설치가이드가 추가되었습니다.');
                $this->saveHistory('Success Added Guide');
            } else {
                $this->Guides_model->updateGuide($_POST, $id);
                $this->session->set_flashdata('result_publish', '설치가이드가 업데이트 되었습니다.');
                $this->saveHistory('Success updated Guide');
            }
            if (isset($_SESSION['filter']) && $id > 0) {
                $get = '';
                foreach ($_SESSION['filter'] as $key => $value) {
                    $get .= trim($key) . '=' . trim($value) . '&';
                }
                redirect(base_url('admin/guides?' . $get));
            } else {
                redirect('admin/guides');
            }
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Publish Guide';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['load_data'] = $load_data;
        $data['categories'] = $this->Categories_model->getCategories();
        $data['allowedTypes'] = $this->allowed_img_types;
        $this->load->view('_parts/header', $head);
        $this->load->view('manage_guide/addguide', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to add guide');
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

    private function uploadfile()
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
    
}
