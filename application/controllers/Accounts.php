<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller
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
        $this->load->model('account_mod');
    }

    public function index()
    {
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'parentaccounts');

        // SELECT ALL parent account list
        $parent_account_data = $this->account_mod->get_all_parent_accounts();

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Parent Account List',
            'sidebar_menu_title' => 'Setting Management',
            'sidebar_menu' => 'Parent Account List',
            'parent_account_data' => $parent_account_data
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
										});
									</script>';

        if (isset($_POST['OkSaveData'])) {
            $parent_account_id = $_POST['data']['id'];
            unset($_POST['data']['id']);
            
            $this->form_validation->set_rules('data[name]', 'Parent Account Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                $_POST['data']['status'] = (!empty($_POST['data']['status'])) ? 1 : 0;
                if($parent_account_id){
                    $this->account_mod->update_parent_account($_POST['data'], $parent_account_id);
                    $msgs = 'Parent account has been updated successfully';
                    
                }else{
                    $add_rate = $this->account_mod->add_parent_account($_POST['data']);
                    $msgs = 'Parent Account has been added successfully';
                }
                $flash_msgs = array('flash_msgs' => $msgs, 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'accounts', 'location', '301'); // 301 redirected
            }
        }

        // Send $data array() to index page
        $data['content'] = $this->load->view('accounts/index', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* Parent Account Status*/
    public function status()
    {
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'parentaccounts');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $parent_account_id = $this->input->post('id');

            if ($this->input->post('status') == 1) {
                $status = 0;
                $_POST['data']['status'] = $status;
                $status_result = 0;
            } else {
                $status = 1;
                $_POST['data']['status'] = $status;
                $status_result = 1;
            }

            $update = $this->account_mod->update_parent_account($_POST['data'], $parent_account_id);

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
     * Delete Parent Account
     * */
    public function delete(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }
        $parent_account_id = $this->uri->segment(3);
        $this->account_mod->delete_parent_account($parent_account_id);

        $flash_msgs = array('flash_msgs' => 'The selected parent account has been deleted successfully', 'alerts' => 'success');
        $this->session->set_userdata($flash_msgs);
        redirect(base_url() . 'accounts', 'location', '301'); // 301 redirected
    }

    /*
     * Child account list
     * */
    public function child_accounts()
    {
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'childaccounts');

        // SELECT ALL child account list
        $child_account_data = $this->account_mod->get_all_child_accounts();

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All Child Account List',
            'sidebar_menu_title' => 'Setting Management',
            'sidebar_menu' => 'Child Account List',
            'child_account_data' => $child_account_data
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
										});
									</script>';

        if (isset($_POST['OkSaveData'])) {
            $child_account_id = $_POST['data']['id'];
            unset($_POST['data']['id']);

            $this->form_validation->set_rules('data[name]', 'Child Account Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                $_POST['data']['status'] = (!empty($_POST['data']['status'])) ? 1 : 0;
                if($child_account_id){
                    $this->account_mod->update_child_account($_POST['data'], $child_account_id);
                    $msgs = 'Child account has been updated successfully';
                    
                }else{
                    $add_rate = $this->account_mod->add_child_account($_POST['data']);
                    $msgs = 'Child account has been added successfully';
                }
                
                $flash_msgs = array('flash_msgs' => $msgs, 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'accounts/child_accounts', 'location', '301'); // 301 redirected
            }
        }
        
        // SELECT ALL parent account list
        $data['parent_account_data'] = $this->account_mod->get_all_parent_accounts();
        
        // Send $data array() to index page
        $data['content'] = $this->load->view('accounts/childaccounts', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /*
     * Delete Child Account
     * */
    public function delete_child_account(){
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }
        $child_account_id = $this->uri->segment(3);
        $this->account_mod->delete_child_account($child_account_id);

        $flash_msgs = array('flash_msgs' => 'The selected child account has been deleted successfully', 'alerts' => 'success');
        $this->session->set_userdata($flash_msgs);
        redirect(base_url() . 'accounts/child_accounts', 'location', '301'); // 301 redirected
    }

    /* Child Account Status*/
    public function status_child_account()
    {
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'childaccounts');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $child_account_id = $this->input->post('id');

            if ($this->input->post('status') == 1) {
                $status = 0;
                $_POST['data']['status'] = $status;
                $status_result = 0;
            } else {
                $status = 1;
                $_POST['data']['status'] = $status;
                $status_result = 1;
            }

            $update = $this->account_mod->update_child_account($_POST['data'], $child_account_id);

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
     * Select Parent account info by ajax
     * */
    public function getparentaccountinfo(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $parent_account_id = $this->input->post('id');

            $account_arr = $this->account_mod->get_parent_account_by_id($parent_account_id);
            //print_r($transaction_arr); exit();

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: ' . date('r', time() + (86400 * 365)));
            header('Content-type: application/json');

            echo json_encode(array(
                'id' => $account_arr->id,
                'name' => $account_arr->name,
                'description' => $account_arr->description,
                'status' => $account_arr->status
            ));
            exit();
        }
    }
    
    /*
     * Select Child account info by ajax
     * */
    public function getchildaccountinfo(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $child_account_id = $this->input->post('id');

            $account_arr = $this->account_mod->get_child_account_by_id($child_account_id);
            //print_r($transaction_arr); exit();

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: ' . date('r', time() + (86400 * 365)));
            header('Content-type: application/json');

            echo json_encode(array(
                'id' => $account_arr->id,
                'name' => $account_arr->name,
                'parent_account_id' => $account_arr->parent_account_id,
                'description' => $account_arr->description,
                'status' => $account_arr->status
            ));
            exit();
        }
    }


}