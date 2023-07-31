<?php
 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Orders extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_orders_model');
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Orders';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Product_orders_model->deleteOrder($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Order is deleted!');
            $this->saveHistory('Delete order id - ' . $_GET['delete']);
            redirect('admin/orders');
        }

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
        $data['orders'] = $this->Product_orders_model->getOrders($this->num_rows, $page, $search_user, $orderby, $status, $onlyNew);
        $data['links_pagination'] = pagination('admin/orders', $rowscount, $this->num_rows, 3);
        $this->saveHistory('Go to Orders');
        $this->load->view('_parts/header', $head);
        $this->load->view('manage_order/orders', $data);
        $this->load->view('_parts/footer');
    }

//     public function paypalPayment()
//     {
//         $data = array();
//         $head = array();
//         $arrSeo = $this->Public_model->getSeo('checkout');
//         $head['title'] = @$arrSeo['title'];
//         $head['description'] = @$arrSeo['description'];
//         $head['keywords'] = str_replace(" ", ",", $head['title']);
//         $data['paypal_sandbox'] = $this->Home_admin_model->getValueStore('paypal_sandbox');
//         $data['paypal_email'] = $this->Home_admin_model->getValueStore('paypal_email');
//         $this->render('checkout_parts/paypal_payment', $head, $data);
//     }

//     public function successPaymentCashOnD()
//     {
//         if ($this->session->flashdata('success_order')) {
//             $data = array();
//             $head = array();
//             $arrSeo = $this->Public_model->getSeo('checkout');
//             $head['title'] = @$arrSeo['title'];
//             $head['description'] = @$arrSeo['description'];
//             $head['keywords'] = str_replace(" ", ",", $head['title']);
//             $this->render('checkout_parts/payment_success_cash', $head, $data);
//         } else {
//             redirect(LANG_URL . '/checkout');
//         }
//     }

//     public function successPaymentBank()
//     {
//         if ($this->session->flashdata('success_order')) {
//             $data = array();
//             $head = array();
//             $arrSeo = $this->Public_model->getSeo('checkout');
//             $head['title'] = @$arrSeo['title'];
//             $head['description'] = @$arrSeo['description'];
//             $head['keywords'] = str_replace(" ", ",", $head['title']);
//             $data['bank_account'] = $this->Orders_model->getBankAccountSettings();
//             $this->render('checkout_parts/payment_success_bank', $head, $data);
//         } else {
//             redirect(LANG_URL . '/checkout');
//         }
//     }

//     public function paypal_cancel()
//     {
//         if (get_cookie('paypal') == null) {
//             redirect(base_url());
//         }
//         @delete_cookie('paypal');
//         $orderId = get_cookie('paypal');
//         $this->Public_model->changePaypalOrderStatus($orderId, 'canceled');
//         $data = array();
//         $head = array();
//         $head['title'] = '';
//         $head['description'] = '';
//         $head['keywords'] = '';
//         $this->render('checkout_parts/paypal_cancel', $head, $data);
//     }

//     public function paypal_success()
//     {
//         if (get_cookie('paypal') == null) {
//             redirect(base_url());
//         }
//         @delete_cookie('paypal');
//         $this->shoppingcart->clearShoppingCart();
//         $orderId = get_cookie('paypal');
//         $this->Public_model->changePaypalOrderStatus($orderId, 'payed');
//         $data = array();
//         $head = array();
//         $head['title'] = '';
//         $head['description'] = '';
//         $head['keywords'] = '';
//         $this->render('checkout_parts/paypal_success', $head, $data);
//     }
    // private function sendEmail()
    // {
    //     $myEmail = $this->Home_admin_model->getValueStore('contactsEmailTo');
    //     if (filter_var($myEmail, FILTER_VALIDATE_EMAIL) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    //         $this->load->library('email');

    //         $this->email->from($_POST['email'], $_POST['name']);
    //         $this->email->to($myEmail);

    //         $this->email->subject($_POST['subject']);
    //         $this->email->message($_POST['message']);

    //         $this->email->send();
    //         return true;
    //     }
    //     return false;
    // }
}
