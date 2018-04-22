<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sells extends CI_Controller
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
        $this->load->model('brand_mod');
        $this->load->model('customer_mod');
        $this->load->model('invoice_mod');
        $this->load->model('setting_mod');
    }

    public function index()
    {
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'sells');

        // SELECT ALL Purchase Invoice list
        $buy_invoice_data = $this->invoice_mod->get_all_sell_invoices();

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Sales Invoice List',
            'sidebar_menu_title' => 'Purchase/Sell Management',
            'sidebar_menu' => 'Sales Invoice List',
            'buy_invoice_data' => $buy_invoice_data
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
        $data['content'] = $this->load->view('sells/index', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }
    
    /* ADD Sell Info */
    public function add()
    {
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'sells');

        // Define Data array
        $data = array(
            'page_title' => 'bsDMM System - Add Purchase Info',
            'sidebar_menu_title' => 'Buy / Sell Management',
            'sidebar_menu' => 'Add Sell Info'
        );

        $data['js'] = array(
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/plugins/fileuploads/js/dropify.min.js'
        );
        $data['css'] = array(
            'assets/plugins/fileuploads/css/dropify.min.css',
            'assets/plugins/custombox/dist/custombox.min.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';

        if (isset($_POST['OkSaveData'])) {
            
            $this->form_validation->set_rules('data[customer_id]', 'Customer Name', 'trim|required');
            $this->form_validation->set_rules('product_id[]', 'Product ID', 'trim|required');
            $this->form_validation->set_rules('brand_id[]', 'Brand ID', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                // Adding invoice
                $invoice_no_generator = $this->invoice_mod->invoice_no_generator(1);
                $_POST['data']['invoice_no'] = $invoice_no_generator;
                $_POST['data']['customer_id'] = $_POST['data']['customer_id'] ;
                $_POST['data']['description'] = $_POST['data']['description'] ;
                $_POST['data']['total_cost'] = $_POST['total_selling_cost'];
                $_POST['data']['invoice_type'] = 1; //sell
                $_POST['data']['created_by'] = $this->session->userdata['userData']['session_user_id'];
                $_POST['data']['created'] = date("Y-m-d h:i:s");
                $last_insert_id = $this->invoice_mod->add_invoice($_POST['data']);

                // Add invoice details
                $product_id_arr         =  $_POST['product_id'];
                $brand_id_arr           =  $_POST['brand_id'];
                $total_bosta_arr        =  $_POST['total_bosta'];
                $bosta_per_kg_arr       =  $_POST['bosta_per_kg'];
                $price_per_bosta_arr    =  $_POST['price_per_bosta'];
                $sub_total_price_arr    =  $_POST['sub_total_price'];

                if(count($product_id_arr)>0){
                    foreach($product_id_arr as $key=>$product_id){
                        $total_maan = ($total_bosta_arr[$key] * $bosta_per_kg_arr[$key])/40;
                        $total_kg = ($total_bosta_arr[$key] * $bosta_per_kg_arr[$key]);
                        $detail_data_arr = array(
                            'invoice_id' => $last_insert_id,
                            'product_id' => $product_id,
                            'brand_id' => $brand_id_arr[$key],
                            'total_bosta' => $total_bosta_arr[$key],
                            'bosta_per_kg' => $bosta_per_kg_arr[$key],
                            'total_maan' => $total_maan,
                            'total_kg' => $total_kg,
                            'price_per_bosta' => $price_per_bosta_arr[$key],
                            'sub_total_price' => $sub_total_price_arr[$key],
                        );
                        $this->invoice_mod->add_invoice_detail($detail_data_arr);
                    }
                }
                // Redirect
                $flash_msgs = array('flash_msgs' => 'Sell invoice has been saved successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'sells', 'location', '301'); // 301 redirected
            }
        }

        // get all customer info
        $data['customers']  = $this->customer_mod->get_all_supplier_customer(array("is_customer" => 1));

        // get all product name
        $data['products']  = $this->product_mod->get_all_products();
        $data['brands']  = $this->brand_mod->get_all_brands();

        // Send $data array() to index page
        $data['content'] = $this->load->view('sells/add', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    

    /* Product Status*/
    public function status()
    {
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'sells');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $product_id = $this->input->post('id');

            if ($this->input->post('status') == 1) {
                $status = 0;
                $_POST['data']['status'] = $status;
                $status_result = 0;
            } else {
                $status = 1;
                $_POST['data']['status'] = $status;
                $status_result = 1;
            }

            $update = $this->product_mod->update_product($_POST['data'], $product_id);

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: ' . date('r', time() + (86400 * 365)));
            header('Content-type: application/json');

            echo json_encode(array(
                'valid' => true,
                'success_message' => $status_result
            ));
            exit();
        }
    }
    
    /* Edit Sell */
    public function edit()
    {
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'sells');

        // Define Data array
        $data = array(
            'page_title' => 'Update Sell Invoice',
            'sidebar_menu_title' => 'Buy / Sell Management',
            'sidebar_menu' => 'Update Sell Invoice'
        );

        $data['js'] = array(
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/plugins/fileuploads/js/dropify.min.js'
        );
        $data['css'] = array(
            'assets/plugins/fileuploads/css/dropify.min.css'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';

        $invoice_id = $this->uri->segment(3);

        if (!empty($invoice_id)) {
            $invoice_data = $this->invoice_mod->get_invoice_by_id($invoice_id);
            $invoice_details_data = $this->invoice_mod->get_invoice_details_by_invoice_id($invoice_id);
        }

        if (isset($_POST['OkSaveData'])) {
            $data['invoice_id'] = $invoice_id;

            $this->form_validation->set_rules('data[customer_id]', 'Customer Name', 'trim|required');
            $this->form_validation->set_rules('product_id[]', 'Product ID', 'trim|required');
            $this->form_validation->set_rules('brand_id[]', 'Brand ID', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                // Update invoice
                $_POST['data']['customer_id'] = $_POST['data']['customer_id'] ;
                $_POST['data']['description'] = $_POST['data']['description'] ;
                $_POST['data']['total_cost'] = $_POST['total_cost'];
                $_POST['data']['updated_by'] = $this->session->userdata['userData']['session_user_id'];
                $_POST['data']['updated'] = date("Y-m-d h:i:s");
                $this->invoice_mod->update_invoice($_POST['data'], $invoice_id);

                // Remove existing invoice details by invoice_id
                $this->invoice_mod->delete_invoice_details($invoice_id);

                // Update invoice details
                $product_id_arr         =  $_POST['product_id'];
                $brand_id_arr           =  $_POST['brand_id'];
                $total_bosta_arr        =  $_POST['total_bosta'];
                $bosta_per_kg_arr       =  $_POST['bosta_per_kg'];
                $price_per_bosta_arr    =  $_POST['price_per_bosta'];
                $sub_total_price_arr    =  $_POST['sub_total_price'];

                if(count($product_id_arr)>0){
                    foreach($product_id_arr as $key=>$product_id){
                        $total_maan = ($total_bosta_arr[$key] * $bosta_per_kg_arr[$key])/40;
                        $total_kg = ($total_bosta_arr[$key] * $bosta_per_kg_arr[$key]);
                        $detail_data_arr = array(
                            'invoice_id' => $invoice_id,
                            'product_id' => $product_id,
                            'brand_id' => $brand_id_arr[$key],
                            'total_bosta' => $total_bosta_arr[$key],
                            'bosta_per_kg' => $bosta_per_kg_arr[$key],
                            'total_maan' => $total_maan,
                            'total_kg' => $total_kg,
                            'price_per_bosta' => $price_per_bosta_arr[$key],
                            'sub_total_price' => $sub_total_price_arr[$key],
                        );
                        $this->invoice_mod->add_invoice_detail($detail_data_arr);
                    }
                }

                $flash_msgs = array('flash_msgs' => 'Sell invoice has been updated successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'sells', 'location', '301'); // 301 redirected
            }
        }

        $data['invoice_data'] = $invoice_data;
        $data['invoice_details_data'] = $invoice_details_data;
        $data['invoice_id'] = $invoice_id;

        // get all customer name
        $data['customers']  = $this->customer_mod->get_all_supplier_customer(array("is_customer" => 1));

        // get all product name
        $data['products']  = $this->product_mod->get_all_products();
        $data['brands']  = $this->brand_mod->get_all_brands();

        // Send $data array() to index page
        $data['content'] = $this->load->view('sells/edit', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* Sell Details */
    public function details()
    {
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'sells');

        // Define Data array
        $data = array(
            'page_title' => 'Sell Invoice Details',
            'sidebar_menu_title' => 'Buy / Sell Management',
            'sidebar_menu' => 'Sell Invoice Details'
        );

        $data['js'] = array(
            'assets/plugins/parsleyjs/dist/parsley.min.js',
            'assets/plugins/fileuploads/js/dropify.min.js'
        );
        $data['css'] = array(
            'assets/plugins/fileuploads/css/dropify.min.css'
        );

        $invoice_id = $this->uri->segment(3);

        if (!empty($invoice_id)) {
            $invoice_data = $this->invoice_mod->get_invoice($invoice_id);
            $invoice_details_data = $this->invoice_mod->get_invoice_details($invoice_id);
            //echo '<pre>'; print_r($invoice_details_data);die();
        }
        $company_info = $this->setting_mod->get_setting_by_id(1);
        //echo '<pre>'; print_r($company_info[0]);die();

        $data['invoice_data'] = $invoice_data;
        $data['invoice_details_data'] = $invoice_details_data;
        $data['invoice_id'] = $invoice_id;
        $data['company_info'] = $company_info[0];


        // Send $data array() to index page
        $data['content'] = $this->load->view('sells/details', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /*
     * Delete Invoice
     * */
    public function delete(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }
        $invoice_id = $this->uri->segment(3);
        $this->invoice_mod->delete_invoice($invoice_id);

        $flash_msgs = array('flash_msgs' => 'The selected invoice has been deleted successfully', 'alerts' => 'success');
        $this->session->set_userdata($flash_msgs);
        redirect(base_url() . 'sells', 'location', '301'); // 301 redirected
    }

}