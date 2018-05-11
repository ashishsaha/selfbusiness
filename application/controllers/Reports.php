<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller
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
        $this->load->model('customer_mod');
        $this->load->model('report_mod');
        $this->load->model('product_mod');
        $this->load->model('account_mod');
    }

    /*
     * This report is using for generating
     * Customer wise sales
     *
     **/
    public function customer_wise_sales(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'customerwisesales');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Sales Invoice List',
            'sidebar_menu_title' => 'Report Management',
            'sidebar_menu' => 'Customer Wise Sales Report'
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
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/moment/moment.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        $data['customer_id'] ='';
        $data['start'] = date("m/d/Y");
        $data['end'] = date("m/d/Y", strtotime(' +1 day'));
        if (isset($_POST['OkSaveData'])) {
            // SELECT ALL Sales Invoice list
            $customer_id = $_POST['payment_from_or_to'];
            $star_date = $_POST['start'];
            $end_date = $_POST['end'];
            $invoice_type = 1; // for sell
            $buy_invoice_data = $this->report_mod->get_all_sell_or_purchase_invoices($customer_id, $invoice_type, $star_date, $end_date);

            $data['customer_id'] =$customer_id;
            $data['start'] = $star_date;
            $data['end'] = $end_date;
        }else{
            $buy_invoice_data = array();
        }
        $data['buy_invoice_data'] = $buy_invoice_data;

        // SELECT ALL Customer list
        $condition = array('is_customer' => 1);
        $data['customer_data'] = $this->customer_mod->get_all_customers($condition);

        // Send $data array() to index page
        $data['content'] = $this->load->view('reports/customerwisesales', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }
    
    
    /*
     * This report is using for generating
     * Supplier wise purchase
     *
     **/
    public function supplier_wise_purchase(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'supplierwisepurchase');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Sales Invoice List',
            'sidebar_menu_title' => 'Report Management',
            'sidebar_menu' => 'Supplier Wise Purchase Report'
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
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/moment/moment.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        $data['supplier_id'] ='';
        $data['start'] = date("m/d/Y");
        $data['end'] = date("m/d/Y", strtotime(' +1 day'));
        if (isset($_POST['OkSaveData'])) {
            // SELECT ALL Sales Invoice list
            $supplier_id = $_POST['payment_from_or_to'];
            $star_date = $_POST['start'];
            $end_date = $_POST['end'];
            $invoice_type = 0; // for purchase
            $buy_invoice_data = $this->report_mod->get_all_sell_or_purchase_invoices($supplier_id, $invoice_type, $star_date, $end_date);

            $data['supplier_id'] =$supplier_id;
            $data['start'] = $star_date;
            $data['end'] = $end_date;
        }else{
            $buy_invoice_data = array();
        }
        $data['buy_invoice_data'] = $buy_invoice_data;

        // SELECT ALL supplier list
        $condition = array('is_supplier' => 1);
        $data['supplier_data'] = $this->customer_mod->get_all_supplier_customer($condition);
//echo '<pre>';print_r($data['supplier_data']);die();
        // Send $data array() to index page
        $data['content'] = $this->load->view('reports/supplierwisepurchase', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }
    
    
    /*
     * This report is using for generating
     * Sales Transaction Customer Wise
     *
     **/
    public function sale_transaction(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'saletransaction');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Sales Invoice List',
            'sidebar_menu_title' => 'Report Management',
            'sidebar_menu' => 'Customer Wise Sales Transaction Report'
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
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/moment/moment.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        $data['customer_id'] ='';
        $data['start'] = date("m/d/Y");
        $data['end'] = date("m/d/Y", strtotime(' +1 day'));
        if (isset($_POST['OkSaveData'])) {
            // SELECT ALL Sales Invoice list
            $customer_id = $_POST['payment_from_or_to'];
            $star_date = $_POST['start'];
            $end_date = $_POST['end'];
            $type = 1; // for sell
            $sell_transaction_data = $this->report_mod->get_customer_wise_transaction($customer_id, $type, $star_date, $end_date);

            $data['customer_id'] =$customer_id;
            $data['start'] = $star_date;
            $data['end'] = $end_date;
        }else{
            $sell_transaction_data = array();
        }
        $data['sell_transaction_data'] = $sell_transaction_data;

        // SELECT ALL Customer list
        $condition = array('is_customer' => 1);
        $data['customer_data'] = $this->customer_mod->get_all_supplier_customer($condition);

        // Send $data array() to index page
        $data['content'] = $this->load->view('reports/saletransaction', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }
    
    
    /*
     * This report is using for generating
     * Purchase Transaction Supplier Wise
     *
     **/
    public function purchase_transaction(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'purchasetransaction');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Sales Invoice List',
            'sidebar_menu_title' => 'Report Management',
            'sidebar_menu' => 'Supplier Wise Purchase Transaction Report'
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
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/moment/moment.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        $data['supplier_id'] ='';
        $data['start'] = date("m/d/Y");
        $data['end'] = date("m/d/Y", strtotime(' +1 day'));
        if (isset($_POST['OkSaveData'])) {
            // SELECT ALL Sales Invoice list
            $supplier_id = $_POST['payment_from_or_to'];
            $star_date = $_POST['start'];
            $end_date = $_POST['end'];
            $type = 0; // for purchase
            $purchase_transaction_data = $this->report_mod->get_customer_wise_transaction($supplier_id, $type, $star_date, $end_date);

            $data['supplier_id'] =$supplier_id;
            $data['start'] = $star_date;
            $data['end'] = $end_date;
        }else{
            $purchase_transaction_data = array();
        }
        $data['purchase_transaction_data'] = $purchase_transaction_data;

        // SELECT ALL Customer list
        $condition = array('is_supplier' => 1);
        $data['supplier_data'] = $this->customer_mod->get_all_supplier_customer($condition);

        // Send $data array() to index page
        $data['content'] = $this->load->view('reports/purchasetransaction', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }
    
    
    /*
     * This report is using for generating
     * Product Wise Purchase
     *
     **/
    public function product_wise_purchase(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'productwisepurchase');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Sales Invoice List',
            'sidebar_menu_title' => 'Report Management',
            'sidebar_menu' => 'Product Wise Purchase Report'
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
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/moment/moment.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        $data['product_id'] ='';
        $data['start'] = date("m/d/Y");
        $data['end'] = date("m/d/Y", strtotime(' +1 day'));
        if (isset($_POST['OkSaveData'])) {
            // SELECT ALL Sales Invoice list
            $product_id = $_POST['product_id'];
            $star_date = $_POST['start'];
            $end_date = $_POST['end'];
            $invoice_type = 0; // for purchase
            $invoice_product_data = $this->report_mod->get_product_wise_invoice($product_id, $invoice_type, $star_date, $end_date);

            $data['product_id'] =$product_id;
            $data['start'] = $star_date;
            $data['end'] = $end_date;
        }else{
            $invoice_product_data = array();
        }
        $data['invoice_product_data'] = $invoice_product_data;

        // get all product name
        $data['product_data']  = $this->product_mod->get_all_products();

        // Send $data array() to index page
        $data['content'] = $this->load->view('reports/productwisepurchase', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }
    
    /*
     * This report is using for generating
     * Product Wise Purchase
     *
     **/
    public function product_wise_sale(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'productwisesale');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Sales Invoice List',
            'sidebar_menu_title' => 'Report Management',
            'sidebar_menu' => 'Product Wise Sale Report'
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
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/moment/moment.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        $data['product_id'] ='';
        $data['start'] = date("m/d/Y");
        $data['end'] = date("m/d/Y", strtotime(' +1 day'));
        if (isset($_POST['OkSaveData'])) {
            // SELECT ALL Sales Invoice list
            $product_id = $_POST['product_id'];
            $star_date = $_POST['start'];
            $end_date = $_POST['end'];
            $invoice_type = 1; // for sale
            $invoice_product_data = $this->report_mod->get_product_wise_invoice($product_id, $invoice_type, $star_date, $end_date);

            $data['product_id'] =$product_id;
            $data['start'] = $star_date;
            $data['end'] = $end_date;
        }else{
            $invoice_product_data = array();
        }
        $data['invoice_product_data'] = $invoice_product_data;

        // get all product name
        $data['product_data']  = $this->product_mod->get_all_products();

        // Send $data array() to index page
        $data['content'] = $this->load->view('reports/productwisesale', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }
    
    /*
     * This report is using for generating
     * All Expense
     *
     **/
    public function expense(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'expense');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Sales Invoice List',
            'sidebar_menu_title' => 'Report Management',
            'sidebar_menu' => 'Expense Report'
        );
        
        // get all expense type child account
        $parent_account_id = 3;
        $childs = $this->account_mod->get_all_child_by_parent_id($parent_account_id);
        $data['childs_data']  = $childs;
        

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
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/moment/moment.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        $data['child_account_id'] ='';
        $data['start'] = date("m/d/Y");
        $data['end'] = date("m/d/Y", strtotime(' +1 day'));
        if (isset($_POST['OkSaveData'])) {
            // SELECT ALL Sales Invoice list
            $child_account_id = $_POST['child_account_id'];
            if($child_account_id == 'all'){
                $all_expense_ids = array();
                foreach($childs as $child){
                    $all_expense_ids[] = $child->id;
                }
                $child_account_id = $all_expense_ids;
            }
            
            $star_date = $_POST['start'];
            $end_date = $_POST['end'];
            $expense_data = $this->report_mod->get_expense_or_income($child_account_id, $star_date, $end_date);

            $data['child_account_id'] = $_POST['child_account_id'];
            $data['start'] = $star_date;
            $data['end'] = $end_date;
        }else{
            $expense_data = array();
        }
        $data['expense_data'] = $expense_data;

        
        
        //echo '<pre>';print_r($expense_data);die();
        // Send $data array() to index page
        $data['content'] = $this->load->view('reports/expense', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }
    
    
    /*
     * This report is using for generating
     * All Income
     *
     **/
    public function income(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'income');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Sales Invoice List',
            'sidebar_menu_title' => 'Report Management',
            'sidebar_menu' => 'Income Report'
        );
        
        // get all income type child account
        $parent_account_id = 1;
        $childs = $this->account_mod->get_all_child_by_parent_id($parent_account_id);
        $data['childs_data']  = $childs;
        

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
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/moment/moment.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        $data['child_account_id'] ='';
        $data['start'] = date("m/d/Y");
        $data['end'] = date("m/d/Y", strtotime(' +1 day'));
        if (isset($_POST['OkSaveData'])) {
            // SELECT ALL Sales Invoice list
            $child_account_id = $_POST['child_account_id'];
            if($child_account_id == 'all'){
                $all_income_ids = array();
                foreach($childs as $child){
                    $all_income_ids[] = $child->id;
                }
                $child_account_id = $all_income_ids;
            }
            
            $star_date = $_POST['start'];
            $end_date = $_POST['end'];
            $income_data = $this->report_mod->get_expense_or_income($child_account_id, $star_date, $end_date);

            $data['child_account_id'] = $_POST['child_account_id'];
            $data['start'] = $star_date;
            $data['end'] = $end_date;
        }else{
            $income_data = array();
        }
        $data['income_data'] = $income_data;

        
        
        //echo '<pre>';print_r($income_data);die();
        // Send $data array() to index page
        $data['content'] = $this->load->view('reports/income', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }
    
    /*
     * This report is using for generating
     * Single Customer Balance
     *
     **/
    public function customer_collection(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'customercollection');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Sales Invoice List',
            'sidebar_menu_title' => 'Report Management',
            'sidebar_menu' => 'Customer Collection Report'
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
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/moment/moment.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        $data['customer_id'] ='';
        $data['start'] = date("m/d/Y");
        $data['end'] = date("m/d/Y", strtotime(' +1 day'));
        if (isset($_POST['OkSaveData'])) {
            // SELECT ALL Sales Invoice list
            $customer_id = $_POST['customer_id'];
            $star_date = $_POST['start'];
            $end_date = $_POST['end'];
            $invoice_type = 1; // For sale
            $customer_collection_data = $this->report_mod->get_customer_collection($customer_id, $invoice_type, $star_date, $end_date);

            $data['customer_id'] = $customer_id;
            $data['start'] = $star_date;
            $data['end'] = $end_date;
        }else{
            $customer_collection_data = array();
        }
        $data['customer_collection_data'] = $customer_collection_data;

        // SELECT ALL Customer list
        $condition = array('is_customer' => 1);
        $data['customer_data'] = $this->customer_mod->get_all_supplier_customer($condition);
        
        //echo '<pre>';print_r($income_data);die();
        // Send $data array() to index page
        $data['content'] = $this->load->view('reports/customercollection', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }
    
    /*
     * This report is using for generating
     * Single Customer Balance
     *
     **/
    public function supplier_payment(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'supplierpayment');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Sales Invoice List',
            'sidebar_menu_title' => 'Report Management',
            'sidebar_menu' => 'Supplier Payment Report'
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
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/moment/moment.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        $data['supplier_id'] ='';
        $data['start'] = date("m/d/Y");
        $data['end'] = date("m/d/Y", strtotime(' +1 day'));
        if (isset($_POST['OkSaveData'])) {
            // SELECT ALL Purchase Invoice list
            $supplier_id = $_POST['supplier_id'];
            $star_date = $_POST['start'];
            $end_date = $_POST['end'];
            $invoice_type = 0; // For purchase
            $supplier_collection_data = $this->report_mod->get_customer_collection($supplier_id, $invoice_type, $star_date, $end_date);

            $data['supplier_id'] = $supplier_id;
            $data['start'] = $star_date;
            $data['end'] = $end_date;
        }else{
            $supplier_collection_data = array();
        }
        $data['supplier_collection_data'] = $supplier_collection_data;

        // SELECT ALL Customer list
        $condition = array('is_supplier' => 1);
        $data['supplier_data'] = $this->customer_mod->get_all_supplier_customer($condition);
        
        //echo '<pre>';print_r($income_data);die();
        // Send $data array() to index page
        $data['content'] = $this->load->view('reports/supplierpayment', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }
    
    /*
     * This report is using for generating
     * Profit Calculation
     *
     **/
    public function profit(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'profit');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Sales Invoice List',
            'sidebar_menu_title' => 'Report Management',
            'sidebar_menu' => 'Profit Report'
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
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/moment/moment.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        //$data['supplier_id'] ='';
        $data['start'] = date("m/d/Y");
        $data['end'] = date("m/d/Y", strtotime(' +1 day'));
        if (isset($_POST['OkSaveData'])) {
            // SELECT ALL Transaction list
            //$supplier_id = $_POST['supplier_id'];
            $star_date = $_POST['start'];
            $end_date = $_POST['end'];
            $transaction_data = $this->report_mod->get_profit($star_date, $end_date);
            //echo '<pre>';print_r($transaction_data);die();
            //$data['supplier_id'] = $supplier_id;
            $data['start'] = $star_date;
            $data['end'] = $end_date;
        }else{
            $transaction_data = array();
        }
        $data['transaction_data'] = $transaction_data;

        // SELECT ALL Customer list
        //$condition = array('is_supplier' => 1);
        //$data['supplier_data'] = $this->customer_mod->get_all_supplier_customer($condition);
        
        //echo '<pre>';print_r($income_data);die();
        // Send $data array() to index page
        $data['content'] = $this->load->view('reports/profit', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }
    
    /*
     * This report is using for generating
     * Stock Report
     *
     **/
    public function stock(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'stock');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Sales Invoice List',
            'sidebar_menu_title' => 'Report Management',
            'sidebar_menu' => 'Stock Report'
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
            'assets/plugins/datatables/dataTables.keyTable.min.js',
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/pages/datatables.init.js',
            'assets/plugins/moment/moment.js',
            'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';
        $data['product_id'] ='';
        $data['brand_id'] ='';
        $data['start'] = date("m/d/Y");
        $data['end'] = date("m/d/Y", strtotime(' +1 day'));
        if (isset($_POST['OkSaveData'])) {
            // SELECT ALL Sales Invoice list
            $product_id = $_POST['product_id'];
            $brand_id = $_POST['brand_id'];
            $star_date = $_POST['start'];
            $end_date = $_POST['end'];
            $stock_data = $this->report_mod->get_stock_info($product_id, $brand_id, $star_date, $end_date);
            //echo '<pre>'; print_r($stock_data);die();
            $data['product_id'] =$product_id;
            $data['brand_id'] =$brand_id;
            $data['start'] = $star_date;
            $data['end'] = $end_date;
        }else{
            $stock_data = array();
        }
        $data['stock_data'] = $stock_data;

        // get all product name
        $data['product_data']  = $this->product_mod->get_all_products();

        // Send $data array() to index page
        $data['content'] = $this->load->view('reports/stock', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }
    
    /*
     * 
     * Get Band List For a Product by Product_id
     *
     **/
    public function get_band_list_product(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $product_id    = $this->input->post('product_id');
            $brand_id = $this->input->post('brand_id');
            
            $brands = array();
            if($product_id != 'all' && $product_id != ''){
                $brands = $this->report_mod->get_all_brands($product_id);
            }
            
            
            $str = '<select class="form-control required" name="brand_id" id="brand_id" data-parsley-id="6">';
            $str .= '<option value="all"';
            if($brand_id == "all"){
                $str .= ' selected="selected" ';
            }
            $str .= '>All</option>';
            if(count($brands)>0){
                foreach($brands as $brand){
                    $str .= '<option value="'.$brand->id.'" ';
                    if($brand_id == $brand->id)
                    {
                        $str .= 'selected="selected" ';
                    }
                    $str .= '>'.$brand->name.'</option>';
                }
            }
            $str .= '</select>';

            echo $str;
            exit();
        }
    }

}