<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __construct()
    {
        parent::__construct();
        //$this->load->library('email');
        $this->load->model('product_mod');
        $this->load->model('customer_mod');
        $this->load->model('invoice_mod');
        $this->load->model('transaction_mod');
        $this->load->model('setting_mod');
    }

    public function pay(){

        if (!$this->session->userdata['userData']['session_user_id']) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'pay');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Account Pay Option',
            'sidebar_menu_title' => 'Payment Management',
            'sidebar_menu' => 'All Account Pay Option'
        );

        $data['js'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap.js',
            'assets/plugins/datatables/dataTables.buttons.min.js',
            'assets/plugins/datatables/buttons.bootstrap.min.js',
            'assets/plugins/datatables/jszip.min.js',
            'assets/plugins/datatables/pdfmake.min.js',
            'assets/plugins/datatables/vfs_fonts.js',
            'assets/plugins/datatables/buttons.html5.min.js',
            'assets/plugins/datatables/buttons.print.min.js',
            'assets/plugins/datatables/dataTables.fixedHeader.min.js',
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/pages/datatables.init.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css'
        );

        // Send $data array() to index page
        $data['content'] = $this->load->view('transaction/index', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    public function receive(){

        if (!$this->session->userdata['userData']['session_user_id']) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'receive');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Account Receive Option',
            'sidebar_menu_title' => 'Payment Management',
            'sidebar_menu' => 'All Account Receive Option'
        );

        $data['js'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap.js',
            'assets/plugins/datatables/dataTables.buttons.min.js',
            'assets/plugins/datatables/buttons.bootstrap.min.js',
            'assets/plugins/datatables/jszip.min.js',
            'assets/plugins/datatables/pdfmake.min.js',
            'assets/plugins/datatables/vfs_fonts.js',
            'assets/plugins/datatables/buttons.html5.min.js',
            'assets/plugins/datatables/buttons.print.min.js',
            'assets/plugins/datatables/dataTables.fixedHeader.min.js',
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/pages/datatables.init.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css'
        );

        // Send $data array() to index page
        $data['content'] = $this->load->view('transaction/receive', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }
    
    /*
     * Print receive_from_customer transtion
     * */
    public function print_receive_transaction(){
        $transaction_id = $this->uri->segment(3);

        if (!empty($transaction_id)) {
            $transaction_data = $this->transaction_mod->get_transaction_info_by_id($transaction_id);
            //echo '<pre>'; print_r($transaction_data);die();
            $invoice_id = $transaction_data->ref_invoice_no;
            $invoice_data = null;
            if($invoice_id){
                $invoice_data = $this->invoice_mod->get_invoice($invoice_id);
            }
        }
        $company_data = $this->setting_mod->get_setting_by_id(1);
        $customer_data = $this->customer_mod->get_customer_by_id($transaction_data->payment_from_or_to);
        //echo '<pre>'; print_r($company_info[0]);die();

        $data['transaction_data'] = $transaction_data;
        $data['invoice_data'] = $invoice_data;
        $data['company_data'] = $company_data[0];
        $data['customer_data'] = $customer_data;
        $html = $this->load->view('transaction/printreceivetransaction', $data, true);
        $pdfFilePath = "income_transaction_".$transaction_id.".pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    /*
     * Delete Product
     * */
    public function delete(){
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $transaction_for = $this->uri->segment(3);
        $transaction_id = $this->uri->segment(4);
        $this->transaction_mod->delete_transaction($transaction_id);

        $flash_msgs = array('flash_msgs' => 'The selected transaction has been deleted successfully', 'alerts' => 'success');
        $this->session->set_userdata($flash_msgs);

        if($transaction_for == "homecost"){
            redirect(base_url() . 'transaction/home_cost', 'location', '301'); // 301 redirected
        }elseif($transaction_for =='millcost'){
            redirect(base_url() . 'transaction/mill_cost', 'location', '301'); // 301 redirected
        }elseif($transaction_for =='dailycost'){
            redirect(base_url() . 'transaction/daily_cost', 'location', '301'); // 301 redirected
        }elseif($transaction_for =='paytoemployee'){
            redirect(base_url() . 'transaction/pay_to_employee', 'location', '301'); // 301 redirected
        }elseif($transaction_for =='paytosupplier'){
            redirect(base_url() . 'transaction/pay_to_supplier', 'location', '301'); // 301 redirected
        }elseif($transaction_for =='paytoemployee'){
            redirect(base_url() . 'transaction/pay_to_employee', 'location', '301'); // 301 redirected
        }elseif($transaction_for =='laborcost'){
            redirect(base_url() . 'transaction/labor_cost', 'location', '301'); // 301 redirected
        }elseif($transaction_for =='receive_from_customer'){
            redirect(base_url() . 'transaction/receive_from_customer', 'location', '301'); // 301 redirected
        }
    }

    /*
     * Select info by ajax
     * */
    public function getinfo(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $transaction_id = $this->input->post('id');

            $transaction_arr = $this->transaction_mod->get_transaction_info_by_id($transaction_id);
            //print_r($transaction_arr); exit();

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: ' . date('r', time() + (86400 * 365)));
            header('Content-type: application/json');

            echo json_encode(array(
                'id' => $transaction_arr->id,
                'payment_from_or_to' => $transaction_arr->payment_from_or_to,
                'ref_invoice_no' => $transaction_arr->ref_invoice_no,
                'trans_type' => $transaction_arr->trans_type,
                'trans_date' => date("m/d/Y", strtotime($transaction_arr->trans_date)),
                'bank_account_from' => $transaction_arr->bank_account_from,
                'bank_account_to' => $transaction_arr->bank_account_to,
                'checque_no' => $transaction_arr->checque_no,
                'salary_month' => $transaction_arr->salary_month,
                'amount' => $transaction_arr->amount,
                'note' => $transaction_arr->note
            ));
            exit();
        }
    }

    /****************Home COST**************/
    public function home_cost()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'pay');

        // SELECT ALL home cost transaction info
        $condition  = array("child_account_id"=>7);
        $home_cost_transaction_data = $this->transaction_mod->get_all_transaction($condition);

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - transaction info',
            'sidebar_menu_title' => 'Transaction Management',
            'sidebar_menu' => 'Home Cost Transaction Info',
            'add_button' => 'Add Home Expense',
            'home_cost_transaction_data' => $home_cost_transaction_data
        );

        $data['js'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap.js',
            'assets/plugins/datatables/dataTables.buttons.min.js',
            'assets/plugins/datatables/buttons.bootstrap.min.js',
            'assets/plugins/datatables/jszip.min.js',
            'assets/plugins/datatables/pdfmake.min.js',
            'assets/plugins/datatables/vfs_fonts.js',
            'assets/plugins/datatables/buttons.html5.min.js',
            'assets/plugins/datatables/buttons.print.min.js',
            'assets/plugins/datatables/dataTables.fixedHeader.min.js',
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        //print_r($_POST); exit;
        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[amount]', 'Transaction Amount', 'trim|required');
            $this->form_validation->set_rules('data[trans_date]', 'Transaction Date', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                //echo '<pre>';print_r($_POST['data']); exit;
                $_POST['data']['payment_from_or_to'] = 0;
                $_POST['data']['status'] = 1;
                $_POST['data']['child_account_id'] = 7;
                $_POST['data']['trans_date'] = date("Y-m-d", strtotime($_POST['data']['trans_date']));
                $_POST['data']['created'] =  date("Y-m-d H:i:s");
                $_POST['data']['created_by'] = $this->session->userdata['userData']['session_user_id'];
                //$add_rate = $this->employee_mod->add_employee($_POST['data']);
                $save_data = $this->transaction_mod->add_transaction($_POST['data']);

                $flash_msgs = array('flash_msgs' => 'Home cost has been added successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'transaction/home_cost', 'location', '301'); // 301 redirected
            }
        }

        // Send $data array() to index page
        $data['content'] = $this->load->view('transaction/homecost', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* Edit transaction */
    public function edit()
    {

        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'pay');

        // SELECT ALL home cost transaction info
        $condition  = array("child_account_id"=>7);
        $home_cost_transaction_data = $this->transaction_mod->get_all_transaction($condition);

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - transaction info',
            'sidebar_menu_title' => 'Transaction Management',
            'sidebar_menu' => 'Home Cost Transaction Info',
            'home_cost_transaction_data' => $home_cost_transaction_data
        );

        $data['js'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap.js',
            'assets/plugins/datatables/dataTables.buttons.min.js',
            'assets/plugins/datatables/buttons.bootstrap.min.js',
            'assets/plugins/datatables/jszip.min.js',
            'assets/plugins/datatables/pdfmake.min.js',
            'assets/plugins/datatables/vfs_fonts.js',
            'assets/plugins/datatables/buttons.html5.min.js',
            'assets/plugins/datatables/buttons.print.min.js',
            'assets/plugins/datatables/dataTables.fixedHeader.min.js',
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        //print_r($_POST); exit;
        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[amount]', 'Transaction Amount', 'trim|required');
            $this->form_validation->set_rules('data[trans_date]', 'Transaction Date', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                $transaction_id = $this->uri->segment(3);
                //echo '<pre>';print_r($_POST['data']); exit;
                $_POST['data']['payment_from_or_to'] = 0;
                $_POST['data']['status'] = 1;
                $_POST['data']['child_account_id'] = 7;
                $_POST['data']['trans_date'] = date("Y-m-d", strtotime($_POST['data']['trans_date']));
                $_POST['data']['created_by'] = $this->session->userdata['userData']['session_user_id'];
                $save_data = $this->transaction_mod->update_transaction($_POST['data'], $transaction_id);

                $flash_msgs = array('flash_msgs' => 'Your transaction has been updated successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'transaction/home_cost', 'location', '301'); // 301 redirected
            }
        }

        // Send $data array() to index page
        $data['content'] = $this->load->view('transaction/homecost', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /****************MILL COST**************/
    public function mill_cost()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'pay');

        // SELECT ALL home cost transaction info
        $condition  = array("child_account_id"=>2);
        $home_cost_transaction_data = $this->transaction_mod->get_all_transaction($condition);

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - transaction info',
            'sidebar_menu_title' => 'Transaction Management',
            'sidebar_menu' => 'Mill Cost Transaction Info',
            'add_button' => 'Add Mill Expense',
            'home_cost_transaction_data' => $home_cost_transaction_data
        );

        $data['js'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap.js',
            'assets/plugins/datatables/dataTables.buttons.min.js',
            'assets/plugins/datatables/buttons.bootstrap.min.js',
            'assets/plugins/datatables/jszip.min.js',
            'assets/plugins/datatables/pdfmake.min.js',
            'assets/plugins/datatables/vfs_fonts.js',
            'assets/plugins/datatables/buttons.html5.min.js',
            'assets/plugins/datatables/buttons.print.min.js',
            'assets/plugins/datatables/dataTables.fixedHeader.min.js',
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        //print_r($_POST); exit;
        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[amount]', 'Transaction Amount', 'trim|required');
            $this->form_validation->set_rules('data[trans_date]', 'Transaction Date', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                //echo '<pre>';print_r($_POST['data']); exit;
                $_POST['data']['payment_from_or_to'] = 0;
                $_POST['data']['status'] = 1;
                $_POST['data']['child_account_id'] = 2;
                $_POST['data']['trans_date'] = date("Y-m-d", strtotime($_POST['data']['trans_date']));
                $_POST['data']['created'] =  date("Y-m-d H:i:s");
                $_POST['data']['created_by'] = $this->session->userdata['userData']['session_user_id'];
                //$add_rate = $this->employee_mod->add_employee($_POST['data']);
                $save_data = $this->transaction_mod->add_transaction($_POST['data']);

                $flash_msgs = array('flash_msgs' => 'Mill cost has been added successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'transaction/mill_cost', 'location', '301'); // 301 redirected
            }
        }

        // Send $data array() to index page
        $data['content'] = $this->load->view('transaction/millcost', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* Edit transaction */
    public function editmillcost()
    {

        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'pay');

        // SELECT ALL home cost transaction info
        $condition  = array("child_account_id"=>2);
        $home_cost_transaction_data = $this->transaction_mod->get_all_transaction($condition);

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - transaction info',
            'sidebar_menu_title' => 'Transaction Management',
            'sidebar_menu' => 'Mill Cost Transaction Info',
            'home_cost_transaction_data' => $home_cost_transaction_data
        );

        $data['js'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap.js',
            'assets/plugins/datatables/dataTables.buttons.min.js',
            'assets/plugins/datatables/buttons.bootstrap.min.js',
            'assets/plugins/datatables/jszip.min.js',
            'assets/plugins/datatables/pdfmake.min.js',
            'assets/plugins/datatables/vfs_fonts.js',
            'assets/plugins/datatables/buttons.html5.min.js',
            'assets/plugins/datatables/buttons.print.min.js',
            'assets/plugins/datatables/dataTables.fixedHeader.min.js',
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        //print_r($_POST); exit;
        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[amount]', 'Transaction Amount', 'trim|required');
            $this->form_validation->set_rules('data[trans_date]', 'Transaction Date', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                $transaction_id = $this->uri->segment(3);
                //echo '<pre>';print_r($_POST['data']); exit;
                $_POST['data']['payment_from_or_to'] = 0;
                $_POST['data']['status'] = 1;
                $_POST['data']['child_account_id'] = 2;
                $_POST['data']['trans_date'] = date("Y-m-d", strtotime($_POST['data']['trans_date']));
                $_POST['data']['created_by'] = $this->session->userdata['userData']['session_user_id'];
                $save_data = $this->transaction_mod->update_transaction($_POST['data'], $transaction_id);

                $flash_msgs = array('flash_msgs' => 'Your transaction has been updated successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'transaction/mill_cost', 'location', '301'); // 301 redirected
            }
        }

        // Send $data array() to index page
        $data['content'] = $this->load->view('transaction/millcost', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /****************MILL COST**************/
    public function daily_cost()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'pay');

        // SELECT ALL home cost transaction info
        $condition  = array("child_account_id"=>8);
        $home_cost_transaction_data = $this->transaction_mod->get_all_transaction($condition);

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - transaction info',
            'sidebar_menu_title' => 'Transaction Management',
            'sidebar_menu' => 'Daily Cost Transaction Info',
            'add_button' => 'Add Daily Expense',
            'home_cost_transaction_data' => $home_cost_transaction_data
        );

        $data['js'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap.js',
            'assets/plugins/datatables/dataTables.buttons.min.js',
            'assets/plugins/datatables/buttons.bootstrap.min.js',
            'assets/plugins/datatables/jszip.min.js',
            'assets/plugins/datatables/pdfmake.min.js',
            'assets/plugins/datatables/vfs_fonts.js',
            'assets/plugins/datatables/buttons.html5.min.js',
            'assets/plugins/datatables/buttons.print.min.js',
            'assets/plugins/datatables/dataTables.fixedHeader.min.js',
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        //print_r($_POST); exit;
        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[amount]', 'Transaction Amount', 'trim|required');
            $this->form_validation->set_rules('data[trans_date]', 'Transaction Date', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                //echo '<pre>';print_r($_POST['data']); exit;
                $_POST['data']['payment_from_or_to'] = 0;
                $_POST['data']['status'] = 1;
                $_POST['data']['child_account_id'] = 8;
                $_POST['data']['trans_date'] = date("Y-m-d", strtotime($_POST['data']['trans_date']));
                $_POST['data']['created'] =  date("Y-m-d H:i:s");
                $_POST['data']['created_by'] = $this->session->userdata['userData']['session_user_id'];
                //$add_rate = $this->employee_mod->add_employee($_POST['data']);
                $save_data = $this->transaction_mod->add_transaction($_POST['data']);

                $flash_msgs = array('flash_msgs' => 'Daily cost has been added successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'transaction/daily_cost', 'location', '301'); // 301 redirected
            }
        }

        // Send $data array() to index page
        $data['content'] = $this->load->view('transaction/dailycost', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* Edit transaction */
    public function editdailycost()
    {

        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'pay');

        // SELECT ALL home cost transaction info
        $condition  = array("child_account_id"=>8);
        $home_cost_transaction_data = $this->transaction_mod->get_all_transaction($condition);

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - transaction info',
            'sidebar_menu_title' => 'Transaction Management',
            'sidebar_menu' => 'Mill Cost Transaction Info',
            'home_cost_transaction_data' => $home_cost_transaction_data
        );

        $data['js'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap.js',
            'assets/plugins/datatables/dataTables.buttons.min.js',
            'assets/plugins/datatables/buttons.bootstrap.min.js',
            'assets/plugins/datatables/jszip.min.js',
            'assets/plugins/datatables/pdfmake.min.js',
            'assets/plugins/datatables/vfs_fonts.js',
            'assets/plugins/datatables/buttons.html5.min.js',
            'assets/plugins/datatables/buttons.print.min.js',
            'assets/plugins/datatables/dataTables.fixedHeader.min.js',
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        //print_r($_POST); exit;
        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[amount]', 'Transaction Amount', 'trim|required');
            $this->form_validation->set_rules('data[trans_date]', 'Transaction Date', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                $transaction_id = $this->uri->segment(3);
                //echo '<pre>';print_r($_POST['data']); exit;
                $_POST['data']['payment_from_or_to'] = 0;
                $_POST['data']['status'] = 1;
                $_POST['data']['child_account_id'] = 8;
                $_POST['data']['trans_date'] = date("Y-m-d", strtotime($_POST['data']['trans_date']));
                $_POST['data']['created_by'] = $this->session->userdata['userData']['session_user_id'];
                $save_data = $this->transaction_mod->update_transaction($_POST['data'], $transaction_id);

                $flash_msgs = array('flash_msgs' => 'Your transaction has been updated successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'transaction/daily_cost', 'location', '301'); // 301 redirected
            }
        }

        // Send $data array() to index page
        $data['content'] = $this->load->view('transaction/dailycost', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }


    /***********PAY TO SUPPLIER************/
    public function pay_to_supplier()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'pay');

        // SELECT ALL home cost transaction info
        $condition  = array("child_account_id"=>3);
        $home_cost_transaction_data = $this->transaction_mod->get_all_transaction_for_employee($condition);

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - transaction info',
            'sidebar_menu_title' => 'Transaction Management',
            'sidebar_menu' => 'Pay to Supplier Transaction Info',
            'add_button' => 'Add Pay to Supplier Expense',
            'home_cost_transaction_data' => $home_cost_transaction_data
        );

        $data['js'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap.js',
            'assets/plugins/datatables/dataTables.buttons.min.js',
            'assets/plugins/datatables/buttons.bootstrap.min.js',
            'assets/plugins/datatables/jszip.min.js',
            'assets/plugins/datatables/pdfmake.min.js',
            'assets/plugins/datatables/vfs_fonts.js',
            'assets/plugins/datatables/buttons.html5.min.js',
            'assets/plugins/datatables/buttons.print.min.js',
            'assets/plugins/datatables/dataTables.fixedHeader.min.js',
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'
        );
        
        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';

        if (isset($_POST['OkSaveData'])) {
            
            $transaction_id = $_POST['data']['id'];
            unset($_POST['data']['id']);

            $this->form_validation->set_rules('data[payment_from_or_to]', 'Supplier Name', 'trim|required');
            $this->form_validation->set_rules('data[amount]', 'Transaction Amount', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                //echo '<pre>';print_r($_POST['data']); exit;
                $_POST['data']['status'] = 1;
                $_POST['data']['child_account_id'] = 3;
                
                $_POST['data']['trans_date'] = date("Y-m-d", strtotime($_POST['data']['trans_date']));
                $_POST['data']['updated_by'] = $this->session->userdata['userData']['session_user_id'];
                if($transaction_id){
                    $_POST['data']['updated'] = date("Y-m-d");//print_r($_POST);die();
                    $save_data = $this->transaction_mod->update_transaction($_POST['data'],$transaction_id);
                    $msgs = 'Pay to supplier has been updated successfully.';
                }else{
                    $_POST['data']['created'] =  date("Y-m-d H:i:s");
                    $_POST['data']['created_by'] = $this->session->userdata['userData']['session_user_id'];
                    $save_data = $this->transaction_mod->add_transaction($_POST['data']);
                    $msgs = 'Pay to supplier has been added successfully.';
                }
                

                $flash_msgs = array('flash_msgs' => $msgs, 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'transaction/pay_to_supplier', 'location', '301'); // 301 redirected
            }
        }
        
        // SELECT ALL supplier list
        $condition = array('is_supplier' => 1);
        $data['supplier_data'] = $this->customer_mod->get_all_customers($condition);

        // Send $data array() to index page
        $data['content'] = $this->load->view('transaction/paytosupplier', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    public function supplierbankinfo(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $supplier_id    = $this->input->post('supplier_id');
            $trans_type     = $this->input->post('trans_type');

            // Get Company Info
            $setting_id = 1;
            $setting_data = $this->setting_mod->get_setting_by_id($setting_id);
            $bank_account_name     = json_decode( $setting_data[0]->bank_account_name);
            $bank_account_number   = json_decode( $setting_data[0]->bank_account_number);
            $bank_name     = json_decode( $setting_data[0]->bank_name);
            $bank_branch     = json_decode( $setting_data[0]->bank_branch);
            $bank_location     = json_decode( $setting_data[0]->bank_location);
            $count_bank_account_name = count($bank_account_name);

            // Get Supplier Info
            $supplier_data              = $this->customer_mod->get_customer_by_id($supplier_id);
            $sup_bank_account_name      = json_decode( $supplier_data->bank_account_name);
            $sup_bank_account_number    = json_decode( $supplier_data->bank_account_number);
            $sup_bank_name              = json_decode( $supplier_data->bank_name);
            $sup_bank_branch            = json_decode( $supplier_data->bank_branch);
            $sup_bank_location          = json_decode( $supplier_data->bank_location);
            $count_sup_bank_account_name = count($sup_bank_account_name);


            $str = '';
            $str .= '<div class="col-md-6 col-sm-6">';
                $str .= '<div class="form-group">';
                    $str .= '<label class="col-md-3 control-label">Company Account</label>';
                    $str .= '<div class="col-md-9">';
                        $str .= '<select class="form-control" name="data[bank_account_from]" id="bank_account_from" data-parsley-id="6">';
                        $str .= '<option value="">N/A</option>';
                            for($j=0; $j<$count_bank_account_name; $j++){
                                $val = $bank_account_name[$j].','.$bank_account_number[$j].','.$bank_name[$j].','.$bank_branch[$j].','.$bank_location[$j];
                                $str .= '<option value="'.$val.'">'.$val.'</option>';
                            }
                        $str .= '</select>';
                    $str .= '</div>';
                $str .= '</div>';
            $str .= '</div>';
            $str .= '<div class="col-md-6 col-sm-6">';
                $str .= '<div class="form-group">';
                    if($trans_type == 2){
                        $str .= '<label class="col-md-3 control-label">Check No</label>';
                        $str .= '<div class="col-md-9">';
                        $str .= '<input class="form-control" placeholder="Check Number" type="text" name="data[checque_no]" id="checque_no" parsley-trigger="change" value="" data-parsley-id="10">';
                        $str .= '</div>';
                    }else{

                        $str .= '<label class="col-md-3 control-label">Supplier Account</label>';
                        $str .= '<div class="col-md-9">';
                        $str .= '<select class="form-control required" name="data[bank_account_to]" id="bank_account_to" data-parsley-id="6" >';
                        for($m=0; $m<$count_sup_bank_account_name; $m++){
                            $val1 = $sup_bank_account_name[$m].','.$sup_bank_account_number[$m].','.$sup_bank_name[$m].','.$sup_bank_branch[$m].','.$sup_bank_location[$m];
                            $str .= '<option value="'.$val1.'">'.$val1.'</option>';
                        }
                        $str .= '</select>';
                        $str .= '</div>';
                    }

                $str .= '</div>';
            $str .= '</div>';




            //$transaction_arr = $this->transaction_mod->get_transaction_info_by_id($transaction_id);
            //print_r($transaction_arr); exit();

            /*header('Cache-Control: no-cache, must-revalidate');
            header('Expires: ' . date('r', time() + (86400 * 365)));
            header('Content-type: application/json');

            echo json_encode(array(
                'trans_type' => $transaction_arr->trans_type,
                'trans_date' => date("m/d/Y", strtotime($transaction_arr->trans_date)),
                'amount' => $transaction_arr->amount,
                'note' => $transaction_arr->note
            ));*/
            echo $str;
            exit();
        }
    }


    /***********PAY TO Employee************/
    public function pay_to_employee()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'pay');

        // SELECT ALL home cost transaction info
        $condition  = array("child_account_id"=>5);
        $home_cost_transaction_data = $this->transaction_mod->get_all_transaction_for_employee($condition);

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - transaction info',
            'sidebar_menu_title' => 'Transaction Management',
            'sidebar_menu' => 'Pay to Employee Transaction Info',
            'add_button' => 'Add Pay to Employee Expense',
            'home_cost_transaction_data' => $home_cost_transaction_data
        );

        $data['js'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap.js',
            'assets/plugins/datatables/dataTables.buttons.min.js',
            'assets/plugins/datatables/buttons.bootstrap.min.js',
            'assets/plugins/datatables/jszip.min.js',
            'assets/plugins/datatables/pdfmake.min.js',
            'assets/plugins/datatables/vfs_fonts.js',
            'assets/plugins/datatables/buttons.html5.min.js',
            'assets/plugins/datatables/buttons.print.min.js',
            'assets/plugins/datatables/dataTables.fixedHeader.min.js',
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'

        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'
        );
        
        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';

        if (isset($_POST['OkSaveData'])) {
            $transaction_id = $_POST['data']['id'];
            unset($_POST['data']['id']);

            $this->form_validation->set_rules('data[payment_from_or_to]', 'Supplier Name', 'trim|required');
            $this->form_validation->set_rules('data[amount]', 'Transaction Amount', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                //echo '<pre>';print_r($_POST['data']); exit;
                $_POST['data']['status'] = 1;
                $_POST['data']['child_account_id'] = 5;
                $_POST['data']['trans_date'] = date("Y-m-d", strtotime($_POST['data']['trans_date']));
                $_POST['data']['updated_by'] = $this->session->userdata['userData']['session_user_id'];
                if($transaction_id){
                    $_POST['data']['updated'] = date("Y-m-d");
                    $save_data = $this->transaction_mod->update_transaction($_POST['data'],$transaction_id);
                    $msgs = 'Employee payment has been updated successfully.';
                }else{
                    $_POST['data']['created'] =  date("Y-m-d H:i:s");
                    $_POST['data']['created_by'] = $this->session->userdata['userData']['session_user_id'];
                    $save_data = $this->transaction_mod->add_transaction($_POST['data']);
                    $msgs = 'Employee payment has been added successfully';
                }

                $flash_msgs = array('flash_msgs' => $msgs, 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'transaction/pay_to_employee', 'location', '301'); // 301 redirected
            }
        }
        
        // SELECT ALL Customer list
        $condition = array('employee_type' => 3);
        $data['employee_data'] = $this->customer_mod->get_all_customers($condition);

        // Send $data array() to index page
        $data['content'] = $this->load->view('transaction/paytoemployee', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }


    /****************MILL COST**************/
    public function labor_cost()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'pay');

        // SELECT ALL home cost transaction info
        $condition  = array("child_account_id"=>4);
        $home_cost_transaction_data = $this->transaction_mod->get_all_transaction_for_employee($condition);

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - transaction info',
            'sidebar_menu_title' => 'Transaction Management',
            'sidebar_menu' => 'Labor Cost Transaction Info',
            'add_button' => 'Add Labor Expense',
            'home_cost_transaction_data' => $home_cost_transaction_data
        );

        $data['js'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap.js',
            'assets/plugins/datatables/dataTables.buttons.min.js',
            'assets/plugins/datatables/buttons.bootstrap.min.js',
            'assets/plugins/datatables/jszip.min.js',
            'assets/plugins/datatables/pdfmake.min.js',
            'assets/plugins/datatables/vfs_fonts.js',
            'assets/plugins/datatables/buttons.html5.min.js',
            'assets/plugins/datatables/buttons.print.min.js',
            'assets/plugins/datatables/dataTables.fixedHeader.min.js',
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        //print_r($_POST); exit;
        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[amount]', 'Transaction Amount', 'trim|required');
            $this->form_validation->set_rules('data[trans_date]', 'Transaction Date', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                //echo '<pre>';print_r($_POST['data']); exit;
                $_POST['data']['status'] = 1;
                $_POST['data']['child_account_id'] = 4;
                $_POST['data']['trans_date'] = date("Y-m-d", strtotime($_POST['data']['trans_date']));
                $_POST['data']['created'] =  date("Y-m-d H:i:s");
                $_POST['data']['created_by'] = $this->session->userdata['userData']['session_user_id'];
                //$add_rate = $this->employee_mod->add_employee($_POST['data']);
                $save_data = $this->transaction_mod->add_transaction($_POST['data']);

                $flash_msgs = array('flash_msgs' => 'Labor cost has been added successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'transaction/labor_cost', 'location', '301'); // 301 redirected
            }
        }

        // SELECT ALL Customer list
        $data['labor_list_data'] = $this->customer_mod->get_all_labors();
        
        // SELECT Last 10 Purchase Invoice list
        $data['invoice_list_data'] = $this->invoice_mod->get_invoice_list(0); // 0 for purchase invoice
        //echo '<pre>';print_r($data['invoice_list_data']);die();
        // Send $data array() to index page
        $data['content'] = $this->load->view('transaction/laborcost', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* Edit transaction */
    public function editlaborcost()
    {

        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'pay');

        // SELECT ALL home cost transaction info
        $condition  = array("child_account_id"=>4);
        $home_cost_transaction_data = $this->transaction_mod->get_all_transaction_for_employee($condition);

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - transaction info',
            'sidebar_menu_title' => 'Transaction Management',
            'sidebar_menu' => 'Labor Cost Transaction Info',
            'home_cost_transaction_data' => $home_cost_transaction_data
        );

        $data['js'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap.js',
            'assets/plugins/datatables/dataTables.buttons.min.js',
            'assets/plugins/datatables/buttons.bootstrap.min.js',
            'assets/plugins/datatables/jszip.min.js',
            'assets/plugins/datatables/pdfmake.min.js',
            'assets/plugins/datatables/vfs_fonts.js',
            'assets/plugins/datatables/buttons.html5.min.js',
            'assets/plugins/datatables/buttons.print.min.js',
            'assets/plugins/datatables/dataTables.fixedHeader.min.js',
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        //print_r($_POST); exit;
        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[amount]', 'Transaction Amount', 'trim|required');
            $this->form_validation->set_rules('data[trans_date]', 'Transaction Date', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                $transaction_id = $this->uri->segment(3);
                //echo '<pre>';print_r($_POST['data']); exit;
                $_POST['data']['status'] = 1;
                $_POST['data']['child_account_id'] = 4;
                $_POST['data']['trans_date'] = date("Y-m-d", strtotime($_POST['data']['trans_date']));
                $_POST['data']['created_by'] = $this->session->userdata['userData']['session_user_id'];
                $save_data = $this->transaction_mod->update_transaction($_POST['data'], $transaction_id);

                $flash_msgs = array('flash_msgs' => 'Your transaction has been updated successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'transaction/labor_cost', 'location', '301'); // 301 redirected
            }
        }

        // Send $data array() to index page
        $data['content'] = $this->load->view('transaction/laborcost', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /*************Receive from Customer *******/
    public function receive_from_customer()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'receive');

        // SELECT ALL home cost transaction info
        $condition  = array("child_account_id"=>6);
        $home_cost_transaction_data = $this->transaction_mod->get_all_transaction_for_employee($condition);

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - transaction info',
            'sidebar_menu_title' => 'Transaction Management',
            'sidebar_menu' => 'Receive from Customer Transaction Info',
            'add_button' => 'Add Receive from Customer Income',
            'home_cost_transaction_data' => $home_cost_transaction_data
        );

        $data['js'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap.js',
            'assets/plugins/datatables/dataTables.buttons.min.js',
            'assets/plugins/datatables/buttons.bootstrap.min.js',
            'assets/plugins/datatables/jszip.min.js',
            'assets/plugins/datatables/pdfmake.min.js',
            'assets/plugins/datatables/vfs_fonts.js',
            'assets/plugins/datatables/buttons.html5.min.js',
            'assets/plugins/datatables/buttons.print.min.js',
            'assets/plugins/datatables/dataTables.fixedHeader.min.js',
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'
        );
        
        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';

        if (isset($_POST['OkSaveData'])) {
            $transaction_id = $_POST['data']['id'];
            unset($_POST['data']['id']);
            
            $this->form_validation->set_rules('data[payment_from_or_to]', 'Customer Name', 'trim|required');
            $this->form_validation->set_rules('data[amount]', 'Transaction Amount', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                //echo '<pre>';print_r($_POST['data']); exit;
                
                $_POST['data']['status'] = 1;
                $_POST['data']['child_account_id'] = 6;
                $_POST['data']['trans_date'] = date("Y-m-d", strtotime($_POST['data']['trans_date']));
                $_POST['data']['updated_by'] = $this->session->userdata['userData']['session_user_id'];
                if($transaction_id){
                    $_POST['data']['updated'] = date("Y-m-d");
                    $save_data = $this->transaction_mod->update_transaction($_POST['data'],$transaction_id);
                    $msgs = 'Receive from customer transaction has been updated successfully.';
                }else{
                    $_POST['data']['created'] =  date("Y-m-d H:i:s");
                    $_POST['data']['created_by'] = $this->session->userdata['userData']['session_user_id'];
                    $save_data = $this->transaction_mod->add_transaction($_POST['data']);
                    $msgs = 'Add receive from customer has been added successfully';
                }
                
                
                
                

                $flash_msgs = array('flash_msgs' => $msgs, 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'transaction/receive_from_customer', 'location', '301'); // 301 redirected
            }
        }

        // SELECT ALL Customer list
        $condition = array('is_customer' => 1);
        $data['customer_data'] = $this->customer_mod->get_all_customers($condition);

        // Send $data array() to index page
        $data['content'] = $this->load->view('transaction/receivefromcustomer', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    public function customerbankinfo(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $customer_id    = $this->input->post('customer_id');
            $trans_type     = $this->input->post('trans_type');

            // Get Company Info
            $setting_id = 1;
            $setting_data = $this->setting_mod->get_setting_by_id($setting_id);
            $bank_account_name     = json_decode( $setting_data[0]->bank_account_name);
            $bank_account_number   = json_decode( $setting_data[0]->bank_account_number);
            $bank_name     = json_decode( $setting_data[0]->bank_name);
            $bank_branch     = json_decode( $setting_data[0]->bank_branch);
            $bank_location     = json_decode( $setting_data[0]->bank_location);
            $count_bank_account_name = count($bank_account_name);

            // Get Supplier Info
            $supplier_data              = $this->customer_mod->get_customer_by_id($customer_id);
            $sup_bank_account_name      = json_decode( $supplier_data->bank_account_name);
            $sup_bank_account_number    = json_decode( $supplier_data->bank_account_number);
            $sup_bank_name              = json_decode( $supplier_data->bank_name);
            $sup_bank_branch            = json_decode( $supplier_data->bank_branch);
            $sup_bank_location          = json_decode( $supplier_data->bank_location);
            $count_sup_bank_account_name = count($sup_bank_account_name);


            $str = '';
            $str .= '<div class="col-md-6 col-sm-6">';
            $str .= '<div class="form-group">';
            $str .= '<label class="col-md-3 control-label">Customer Account</label>';
            $str .= '<div class="col-md-9">';
            $str .= '<select class="form-control required" name="data[bank_account_from]" id="bank_account_from" data-parsley-id="6" >';
            for($m=0; $m<$count_sup_bank_account_name; $m++){
                $val1 = $sup_bank_account_name[$m].','.$sup_bank_account_number[$m].','.$sup_bank_name[$m].','.$sup_bank_branch[$m].','.$sup_bank_location[$m];
                $str .= '<option value="'.$val1.'">'.$val1.'</option>';
            }
            $str .= '</select>';
            $str .= '</div>';
            $str .= '</div>';
            $str .= '</div>';
            $str .= '<div class="col-md-6 col-sm-6">';
            $str .= '<div class="form-group">';
            if($trans_type == 2){
                $str .= '<label class="col-md-3 control-label">Check No</label>';
                $str .= '<div class="col-md-9">';
                $str .= '<input class="form-control" placeholder="Check Number" type="text" name="data[checque_no]" id="checque_no" parsley-trigger="change" value="" data-parsley-id="10">';
                $str .= '</div>';
            }else{
            $str .= '<label class="col-md-3 control-label">Company Account</label>';
            $str .= '<div class="col-md-9">';
            $str .= '<select class="form-control required" name="data[bank_account_to]" id="bank_account_to" data-parsley-id="6">';
            for($j=0; $j<$count_bank_account_name; $j++){
                $val = $bank_account_name[$j].','.$bank_account_number[$j].','.$bank_name[$j].','.$bank_branch[$j].','.$bank_location[$j];
                $str .= '<option value="'.$val.'">'.$val.'</option>';
            }
            $str .= '</select>';
            $str .= '</div>';
            }
            $str .= '</div>';
            $str .= '</div>';




            //$transaction_arr = $this->transaction_mod->get_transaction_info_by_id($transaction_id);
            //print_r($transaction_arr); exit();

            /*header('Cache-Control: no-cache, must-revalidate');
            header('Expires: ' . date('r', time() + (86400 * 365)));
            header('Content-type: application/json');

            echo json_encode(array(
                'trans_type' => $transaction_arr->trans_type,
                'trans_date' => date("m/d/Y", strtotime($transaction_arr->trans_date)),
                'amount' => $transaction_arr->amount,
                'note' => $transaction_arr->note
            ));*/
            echo $str;
            exit();
        }
    }

}