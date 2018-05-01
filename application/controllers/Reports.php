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
            'assets/pages/datatables.init.js',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css',
            'assets/plugins/bootstrap-daterangepicker/daterangepicker.css'
        );

        $sales_invoice_data = null;

        if (isset($_POST['OkSaveData'])) {
            // SELECT ALL Sales Invoice list
            $sales_invoice_data = $this->invoice_mod->get_customer_wise_sales();
        }
        $data['sales_invoice_data'] = $sales_invoice_data;

        // SELECT ALL Customer list
        $condition = array('is_customer' => 1);
        $data['customer_data'] = $this->customer_mod->get_all_customers($condition);

        // Send $data array() to index page
        $data['content'] = $this->load->view('reports/customerwisesales', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

}