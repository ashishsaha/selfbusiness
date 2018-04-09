<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buys extends CI_Controller
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
    }

    public function index()
    {
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'buys');

        // SELECT ALL Purchase Invoice list
        $buy_invoice_data = $this->invoice_mod->get_all_buy_invoices();

        // Define Data array
        $data = array(
            'page_title' => 'bsDMM System - All Purchase Invoice List',
            'sidebar_menu_title' => 'Purchase/Sell Management',
            'sidebar_menu' => 'Purchase Invoice List',
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
        $data['content'] = $this->load->view('buys/index', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* ADD Buy Info */
    public function add()
    {
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'buys');

        // Define Data array
        $data = array(
            'page_title' => 'bsDMM System - Add Purchase Info',
            'sidebar_menu_title' => 'Buy / Sell Management',
            'sidebar_menu' => 'Add Purchase Info'
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

											$("#total_bosta").keyup(function() {
                                                var current_val = $(this).val();
                                                var bosta_per_kg = parseFloat($("#bosta_per_kg").val());
                                                // Calculation Mann
                                                var total_mann = (current_val * bosta_per_kg)/40;
                                                $("#total_mann").val(total_mann.toFixed(2));
                                                // Calculation KG
                                                var total_kg = (current_val * bosta_per_kg);
                                                $("#total_kg").val(total_kg.toFixed(2));

                                                // Calculate product cost
                                                var price_per_mann = $("#price_per_mann").val();
                                                var product_cost = parseFloat(price_per_mann) * total_mann;
                                                $("#product_cost").val(product_cost.toFixed(2));

                                                // Bosta price
                                                var price_per_bosta = $("#price_per_bosta").val();
                                                var total_bosta = Math.ceil(current_val);
                                                var bosta_cost = parseFloat(price_per_bosta * total_bosta);
                                                $("#bosta_cost").val(bosta_cost.toFixed(2));

                                                // Total cost
                                                calculation_total_cost();
                                            });

											$("#bosta_per_kg").keyup(function() {
                                                var current_val = $(this).val();
                                                var total_bosta = parseFloat($("#total_bosta").val());
                                                // Calculation Mann
                                                var total_mann = (current_val * total_bosta)/40;
                                                $("#total_mann").val(total_mann.toFixed(2));
                                                // Calculation KG
                                                var total_kg = (current_val * total_bosta);
                                                $("#total_kg").val(total_kg.toFixed(2));

                                                // Calculate product cost
                                                var price_per_mann = $("#price_per_mann").val();
                                                var total_product_cost = parseFloat(price_per_mann * total_mann);
                                                $("#product_cost").val(total_product_cost.toFixed(2));
                                                calculation_total_cost();
                                            });

											$("#price_per_mann").keyup(function() {
                                                var current_val = $(this).val();
                                                var total_mann = parseFloat($("#total_mann").val());
                                                // Calculation Mann
                                                var total_product_cost = parseFloat(current_val * total_mann);
                                                $("#product_cost").val(total_product_cost.toFixed(2));
                                                calculation_total_cost();
                                            });

											$("#price_per_bosta").keyup(function() {
                                                var current_val = $(this).val();
                                                var total_bosta = Math.ceil($("#total_bosta").val());
                                                // Calculation Mann
                                                var bosta_cost = parseFloat(current_val * total_bosta);
                                                $("#bosta_cost").val(bosta_cost.toFixed(2));
                                                calculation_total_cost();
                                            });

                                            $("#transportation_cost").keyup(function() {
                                                var current_val = $(this).val();
                                                calculation_total_cost();
                                            });

											$("#casual_labor_cost").keyup(function() {
                                                var current_val = $(this).val();
                                                calculation_total_cost();
                                            });
										});

										function calculation_total_cost(){
										        var product_cost = $("#product_cost").val();
										        var bosta_cost = $("#bosta_cost").val();
										        var transportation_cost = $("#transportation_cost").val();
										        var casual_labor_cost = $("#casual_labor_cost").val();
										        var total_kg = $("#total_kg").val();
										        var total_purchase_cost = parseFloat(product_cost)+parseFloat(bosta_cost)+parseFloat(transportation_cost)+parseFloat(casual_labor_cost);
										        var per_kg_purchase_price = total_purchase_cost/parseFloat(total_kg);
										        $("#total_purchase_cost").val(total_purchase_cost.toFixed(2));
										        $("#per_kg_purchase_price").val(per_kg_purchase_price.toFixed(2));
										}
									</script>';

        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[total_bosta]', 'Total Bosta', 'trim|required');
            $this->form_validation->set_rules('data[bosta_per_kg]', 'Bosta Per KG', 'trim|required');
            $this->form_validation->set_rules('data[total_mann]', 'Total Mann', 'trim|required');
            $this->form_validation->set_rules('data[total_kg]', 'Total KG', 'trim|required');
            $this->form_validation->set_rules('data[price_per_mann]', 'Price per Mann', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                $_POST['data']['status'] = 1;
                $_POST['data']['created_by'] = $this->session->userdata['userData']['session_user_id'];
                $_POST['data']['invoice_type'] = 0;
                $_POST['data']['created'] = date("Y-m-d h:i:s");
                $add_buy_invoice = $this->invoice_mod->add_invoice($_POST['data']);
                $flash_msgs = array('flash_msgs' => 'Purchase invoice has been saved successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'buys', 'location', '301'); // 301 redirected
            }
        }

        // get all supplier name
        $data['suppliers']  = $this->customer_mod->get_all_supplier_customer(array("is_supplier" => 1));

        // get all product name
        $data['products']  = $this->product_mod->get_all_products();

        // Send $data array() to index page
        $data['content'] = $this->load->view('buys/add', $data, true);
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
        $this->session->set_userdata('active_menu', 'products');

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

    /* Edit Product */
    public function edit()
    {
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'buys');

        // Define Data array
        $data = array(
            'page_title' => 'Update Purchase Invoice',
            'sidebar_menu_title' => 'Buy / Sell Management',
            'sidebar_menu' => 'Update Purchase Invoice'
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

                                            $("#total_bosta").keyup(function() {
                                                var current_val = $(this).val();
                                                var bosta_per_kg = parseFloat($("#bosta_per_kg").val());

                                                // Calculation Mann
                                                var total_mann = (current_val * bosta_per_kg)/40;
                                                $("#total_mann").val(total_mann.toFixed(2));

                                                // Calculation KG
                                                var total_kg = (current_val * bosta_per_kg);
                                                $("#total_kg").val(total_kg.toFixed(2));

                                                // Calculate product cost
                                                var price_per_mann = $("#price_per_mann").val();
                                                var product_cost = parseFloat(price_per_mann) * total_mann;

                                                // Calculate product cost
                                                var price_per_mann = $("#price_per_mann").val();
                                                var product_cost = parseFloat(price_per_mann) * total_mann;
                                                $("#product_cost").val(product_cost.toFixed(2));

                                                // Bosta price
                                                var price_per_bosta = $("#price_per_bosta").val();
                                                var total_bosta = Math.ceil(current_val);
                                                var bosta_cost = parseFloat(price_per_bosta * total_bosta);
                                                $("#bosta_cost").val(bosta_cost.toFixed(2));

                                                // Total cost
                                                calculation_total_cost();
                                            });

                                            $("#bosta_per_kg").keyup(function() {
                                                var current_val = $(this).val();
                                                var total_bosta = parseFloat($("#total_bosta").val());
                                                // Calculation Mann
                                                var total_mann = (current_val * total_bosta)/40;
                                                $("#total_mann").val(total_mann.toFixed(2));
                                                // Calculation KG
                                                var total_kg = (current_val * total_bosta);
                                                $("#total_kg").val(total_kg.toFixed(2));

                                                // Calculate product cost
                                                var price_per_mann = $("#price_per_mann").val();
                                                var total_product_cost = parseFloat(price_per_mann * total_mann);
                                                $("#product_cost").val(total_product_cost.toFixed(2));
                                                calculation_total_cost();
                                            });

                                            $("#price_per_mann").keyup(function() {
                                                var current_val = $(this).val();
                                                var total_mann = parseFloat($("#total_mann").val());
                                                // Calculation Mann
                                                var total_product_cost = parseFloat(current_val * total_mann);
                                                $("#product_cost").val(total_product_cost.toFixed(2));
                                                calculation_total_cost();
                                            });

                                            $("#price_per_bosta").keyup(function() {
                                                var current_val = $(this).val();
                                                var total_bosta = Math.ceil($("#total_bosta").val());
                                                // Calculation Mann
                                                var bosta_cost = parseFloat(current_val * total_bosta);
                                                $("#bosta_cost").val(bosta_cost.toFixed(2));
                                                calculation_total_cost();
                                            });

                                            $("#transportation_cost").keyup(function() {
                                                var current_val = $(this).val();
                                                calculation_total_cost();
                                            });

                                            $("#casual_labor_cost").keyup(function() {
                                                var current_val = $(this).val();
                                                calculation_total_cost();
                                            });

										});
                                        function calculation_total_cost(){
                                                var product_cost = $("#product_cost").val();
                                                var bosta_cost = $("#bosta_cost").val();
                                                var transportation_cost = $("#transportation_cost").val();
                                                var casual_labor_cost = $("#casual_labor_cost").val();
                                                var total_kg = $("#total_kg").val();
                                                var total_purchase_cost = parseFloat(product_cost)+parseFloat(bosta_cost)+parseFloat(transportation_cost)+parseFloat(casual_labor_cost);
                                                var per_kg_purchase_price = total_purchase_cost/parseFloat(total_kg);
                                                $("#total_purchase_cost").val(total_purchase_cost.toFixed(2));
                                                $("#per_kg_purchase_price").val(per_kg_purchase_price.toFixed(2));
                                        }
									</script>';

        $invoice_id = $this->uri->segment(3);

        if (!empty($invoice_id)) {
            $invoice_data = $this->invoice_mod->get_invoice_by_id($invoice_id);
        }

        if (isset($_POST['OkSaveData'])) {
            $data['invoice_id'] = $invoice_id;

            $this->form_validation->set_rules('data[total_bosta]', 'Total Bosta', 'trim|required');
            $this->form_validation->set_rules('data[bosta_per_kg]', 'Bosta Per KG', 'trim|required');
            $this->form_validation->set_rules('data[total_mann]', 'Total Mann', 'trim|required');
            $this->form_validation->set_rules('data[total_kg]', 'Total KG', 'trim|required');
            $this->form_validation->set_rules('data[price_per_mann]', 'Price per Mann', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                $_POST['data']['updated_by'] = $this->session->userdata['userData']['session_user_id'];
                $_POST['data']['updated'] = date("Y-m-d h:i:s");
                $this->invoice_mod->update_invoice($_POST['data'], $invoice_id);

                $flash_msgs = array('flash_msgs' => 'Purchase invoice has been updated successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'buys', 'location', '301'); // 301 redirected
            }
        }

        $data['invoice_data'] = $invoice_data;
        $data['invoice_id'] = $invoice_id;

        // get all supplier name
        $data['suppliers']  = $this->customer_mod->get_all_supplier_customer(array("is_supplier" => 1));

        // get all product name
        $data['products']  = $this->product_mod->get_all_products();

        // Send $data array() to index page
        $data['content'] = $this->load->view('buys/edit', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /*
     * Delete Product
     * */
    public function delete(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }
        $product_id = $this->uri->segment(3);
        $this->product_mod->delete_product($product_id);

        $flash_msgs = array('flash_msgs' => 'The selected product has been deleted successfully', 'alerts' => 'success');
        $this->session->set_userdata($flash_msgs);
        redirect(base_url() . 'products', 'location', '301'); // 301 redirected
    }

}