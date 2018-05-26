<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends CI_Controller
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
        $this->load->model('employee_mod');
    }

    public function index()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'employees');

        // SELECT ALL employee list
        //$employee_data = $this->employee_mod->get_all_employees();
        $condition = array('employee_type !=' => 0);
        $employee_data = $this->customer_mod->get_all_customers($condition);

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Employee List',
            'sidebar_menu_title' => 'Employee Management',
            'sidebar_menu' => 'Employee List',
            'employee_data' => $employee_data
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
            'assets/plugins/parsleyjs/dist/parsley.min.js'
        );

        $data['css'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.css',
            'assets/plugins/datatables/buttons.bootstrap.min.css',
            'assets/plugins/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugins/datatables/responsive.bootstrap.min.css',
            'assets/plugins/datatables/scroller.bootstrap.min.css'
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
            $employee_id = $_POST['data']['id'];
            unset($_POST['data']['id']);

            $this->form_validation->set_rules('data[full_name]', 'Employee/Labor Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                
                //$add_rate = $this->employee_mod->add_employee($_POST['data']);
                
                
                if($_POST['data']['employee_type'] == 1){
                    $employee_type_name = "Labor";
                }else{
                    $employee_type_name = "Employee";
                }
                
                if($employee_id){
                    $_POST['data']['updated'] = date("Y-m-d h:i:s");
                    //$this->employee_mod->update_employee($_POST['data'], $employee_id);
                    $this->customer_mod->update_customer($_POST['data'], $employee_id);
                    $msgs = $employee_type_name.' has been updated successfully';
                    
                }else{
                    $_POST['data']['created'] = date("Y-m-d h:i:s");
                    $save_data = $this->customer_mod->add_customer($_POST['data']);
                    $msgs = $employee_type_name.' has been added successfully';
                }
                

                
                $flash_msgs = array('flash_msgs' => $msgs, 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'employees', 'location', '301'); // 301 redirected
            }
        }

        // Send $data array() to index page
        $data['content'] = $this->load->view('employees/index', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* employee Status*/
    public function status()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'employees');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $employee_id = $this->input->post('id');

            if ($this->input->post('status') == 1) {
                $status = 0;
                $_POST['data']['status'] = $status;
                $status_result = 0;
            } else {
                $status = 1;
                $_POST['data']['status'] = $status;
                $status_result = 1;
            }

            //$update = $this->employee_mod->update_employee($_POST['data'], $employee_id);
            $update = $this->customer_mod->update_customer($_POST['data'], $employee_id);

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

    /*
     * Delete employee info
     * */
    public function delete(){
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $employee_id = $this->uri->segment(3);
        //$this->employee_mod->delete_employee($employee_id);
        $this->customer_mod->delete_customer($employee_id);

        $flash_msgs = array('flash_msgs' => 'The selected employee/labor has been deleted successfully', 'alerts' => 'success');
        $this->session->set_userdata($flash_msgs);
        redirect(base_url() . 'employees', 'location', '301'); // 301 redirected
    }
    
    /*
     * Select info by ajax
     * */
    public function getinfo(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $employee_id = $this->input->post('id');

            $employee_data = $this->customer_mod->get_customer_by_id($employee_id);
            //print_r($transaction_arr); exit();

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: ' . date('r', time() + (86400 * 365)));
            header('Content-type: application/json');

            echo json_encode(array(
                'id' => $employee_data->id,
                'full_name' => $employee_data->full_name,
                'contact_number' => $employee_data->contact_number,
                'address' => $employee_data->address,
                'employee_type' => $employee_data->employee_type
            ));
            exit();
        }
    }
}