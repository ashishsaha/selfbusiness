<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller
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
    }

    public function index()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'customers');

        // SELECT ALL Customer list
        $condition = array('employee_type' => 0);
        $customer_data = $this->customer_mod->get_all_customers($condition);

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Customer List',
            'sidebar_menu_title' => 'Customer Management',
            'sidebar_menu' => 'Customer List',
            'customer_data' => $customer_data
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
        $data['content'] = $this->load->view('customers/index', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* ADD customer */
    public function add()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'customers');

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - Add Customer/Supplier',
            'sidebar_menu_title' => 'Customer Management',
            'sidebar_menu' => 'Add Customer/Supplier'
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

											// Enable max_price after filling the min_price
											$("#max_price").prop("disabled", true);
                                            $("#min_price").blur(function(){
                                                if($(this).val().length != 0){
                                                    $("#max_price").prop("disabled", false);
                                                    $("#max_price").attr("data-parsley-min", $(this).val());
                                                }
                                            });
										});



                                        $(".dropify").dropify({
                                            messages: {
                                                "default": "Drag and drop a file here or click",
                                                "replace": "Drag and drop or click to replace",
                                                "remove": "Remove",
                                                "error": "Ooops, something wrong appended."
                                            },
                                            error: {
                                                "fileSize": "The file size is too big (1M max)."
                                            }
                                        });
									</script>';

        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[full_name]', 'Customer/Supplier Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                /*echo  '<pre>';
                print_r($_POST); exit;*/
                $_POST['data']['is_customer'] = (!empty($_POST['data']['is_customer'])) ? 1 : 0;
                $_POST['data']['is_supplier'] = (!empty($_POST['data']['is_supplier'])) ? 1 : 0;
                $_POST['data']['bank_account_name'] = json_encode($_POST['bank_account_name']);
                $_POST['data']['bank_account_number'] = json_encode($_POST['bank_account_number']);
                $_POST['data']['bank_name'] = json_encode($_POST['bank_name']);
                $_POST['data']['bank_branch'] = json_encode($_POST['bank_branch']);
                $_POST['data']['bank_location'] = json_encode($_POST['bank_location']);
                $_POST['data']['created'] = date("Y-m-d h:i:s");
                $add_rate = $this->customer_mod->add_customer($_POST['data']);
                $flash_msgs = array('flash_msgs' => 'Customer has been added successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'customers', 'location', '301'); // 301 redirected
            }
        }

        // Send $data array() to index page
        $data['content'] = $this->load->view('customers/add', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* Customer Status*/
    public function status()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'customers');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $customer_id = $this->input->post('id');

            if ($this->input->post('status') == 1) {
                $status = 0;
                $_POST['data']['status'] = $status;
                $status_result = 0;
            } else {
                $status = 1;
                $_POST['data']['status'] = $status;
                $status_result = 1;
            }

            $update = $this->customer_mod->update_customer($_POST['data'], $customer_id);

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

    /* Edit Customer */
    public function edit()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'customers');

        // Define Data array
        $data = array(
            'page_title' => 'Update Customer/Supplier',
            'sidebar_menu_title' => 'Customer Management',
            'sidebar_menu' => 'Update Customer/Supplier'
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

											// Enable max_price after filling the min_price
											$("#max_price").prop("disabled", true);
                                            $("#min_price").blur(function(){
                                                if($(this).val().length != 0){
                                                    $("#max_price").prop("disabled", false);
                                                    $("#max_price").attr("data-parsley-min", $(this).val());
                                                }
                                            });
										});

                                        $(".dropify").dropify({
                                            messages: {
                                                "default": "Drag and drop a file here or click",
                                                "replace": "Drag and drop or click to replace",
                                                "remove": "Remove",
                                                "error": "Ooops, something wrong appended."
                                            },
                                            error: {
                                                "fileSize": "The file size is too big (1M max)."
                                            }
                                        });
									</script>';


        $customer_id = $this->uri->segment(3);

        if (!empty($customer_id)) {
            $customer_data = $this->customer_mod->get_customer_by_id($customer_id);
        }

        if (isset($_POST['OkSaveData'])) {
            $data['customer_id'] = $customer_id;

            $this->form_validation->set_rules('data[full_name]', 'Customer/Supplier Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                $_POST['data']['is_customer'] = (!empty($_POST['data']['is_customer'])) ? 1 : 0;
                $_POST['data']['is_supplier'] = (!empty($_POST['data']['is_supplier'])) ? 1 : 0;
                $_POST['data']['bank_account_name'] = json_encode($_POST['bank_account_name']);
                $_POST['data']['bank_account_number'] = json_encode($_POST['bank_account_number']);
                $_POST['data']['bank_name'] = json_encode($_POST['bank_name']);
                $_POST['data']['bank_branch'] = json_encode($_POST['bank_branch']);
                $_POST['data']['bank_location'] = json_encode($_POST['bank_location']);
                $_POST['data']['updated'] = date("Y-m-d h:i:s");
                $this->customer_mod->update_customer($_POST['data'], $customer_id);

                $flash_msgs = array('flash_msgs' => 'Customer has been updated successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'customers', 'location', '301'); // 301 redirected

            }
        }

        $data['customer_data'] = $customer_data;
        $data['customer_id'] = $customer_id;

        // Send $data array() to index page
        $data['content'] = $this->load->view('customers/edit', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /*
     * Delete customer info
     * */
    public function delete(){
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $customer_id = $this->uri->segment(3);
        $this->customer_mod->delete_customer($customer_id);

        $flash_msgs = array('flash_msgs' => 'The selected customer/supplier has been deleted successfully', 'alerts' => 'success');
        $this->session->set_userdata($flash_msgs);
        redirect(base_url() . 'customers', 'location', '301'); // 301 redirected
    }



    // Service details show
    public function service_details()
    {
        $corporate_account_id = $this->session->userdata['userData']['session_corporate_account_id'];

        // Is show service description
        $is_show_service_description = $this->customer_mod->is_service_show($corporate_account_id);
        $is_price_range_show = $this->customer_mod->is_price_range_show($corporate_account_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $service_id = $this->input->post('service_id');

            $service_data = $this->service_mod->get_service_by_id($service_id);

            // Show service description value
            $service_description = '';
            if (!empty($service_data->description)) {
                $service_description .= $service_data->description;
            } else {
                $service_description .= 'N.A';
            }

            //image path
            $img_path = base_url().'uploads/iconimages/'.($service_data->service_image ? $service_data->service_image : 'default-icon.png');

            // Show service price range
            $show_price_range = '';
            if($service_data->min_price <= 0.00 ){
                $show_price_range .= 'Varies';
            }else if($service_data->min_price > 0.00 && $service_data->max_price > 0.00){
                $show_price_range .= $service_data->min_price.' - '. $service_data->max_price;
            }else{
                $show_price_range .= $service_data->min_price;
            }

            // Total duration
            $total_duration = $service_data->duration;


            $service_detail = '';

            $service_detail .= '<tr class="'.$service_data->id .'">';
            $service_detail .= '<td>' . $service_data->name;
            $service_detail .= '<input type="hidden" value="'.$service_data->duration.'" id="service_duration'.$service_data->id.'" /></td>';
            if ($is_show_service_description == 1) {
                $service_detail .= '<td>' . $service_description . '</td>';
            }
            $service_detail .= '<td><img src="'.$img_path.'" title="' . $service_data->name . '" width="50" height="50"></td>';
            if ($is_price_range_show == 1) {
                $service_detail .= '<td>' . $show_price_range . '</td>';
            }
            $service_detail .= '<td>' . $service_data->duration;
            $service_detail .= '<input type="hidden" value="'.$service_data->id.'" name="service_ids[]" /></td>';
            $service_detail .= '</tr>';

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: ' . date('r', time() + (86400 * 365)));
            header('Content-type: application/json');

            echo json_encode(array(
                'valid' => true,
                'success_message' => $service_detail,
                'total_duration' => $total_duration
            ));
            exit();
        }
    }

    // Show Staff details
    public function staff_selection(){

        $corporate_account_id = $this->session->userdata['userData']['session_corporate_account_id'];
        if (!$corporate_account_id) {
            redirect('users/login');
        }
        // Define Data array
        $data = array(
            'page_title' => 'Staff Selection - Booking System',
            'sidebar_menu_title' => 'Staff Selection'
        );

        // Staff Selection Type
        $staff_selection_type = $this->customer_mod->get_staff_selection_type($corporate_account_id);
        $data['staff_selection_type'] = $staff_selection_type;

        //echo '<pre>';
        //print_r($_POST['service_ids']);

        /*foreach ($_POST['service_ids'] as $service_id){

        }*/

        $data['content'] = $this->load->view('customers/staff_selection', $data, true);
        // Use Layout
        $this->load->view('layout/customer_layout', $data);

    }
}