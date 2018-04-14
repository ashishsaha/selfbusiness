<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //$this->load->library('email');
        $this->load->model('user_mod');
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p>', '</p>');
    }

    /* SHOW ALL LIST*/
    public function index()
    {
        if(!$this->session->userdata['userData']['session_user_id']){
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'roles');
        // SELECT ALL ROLES
        $role_data = $this->user_mod->get_all_role();

        // Define Data array
        $data = array(
            'page_title' => 'Role List',
            'sidebar_menu_title' => 'USER MANAGEMENT',
            'sidebar_menu' => 'Role List',
            'roleInfo' => $role_data
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
        $data['content'] = $this->load->view('roles/index', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);

    }

    /* CHANGE THE STATUS */
    function status()
    {
        if(!$this->session->userdata['userData']['session_user_id']){
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'roles');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $role_id = $this->input->post('id');


            $role_data = $this->user_mod->get_role_by_id($role_id);
            $title = $role_data->name;

            if ($this->input->post('s') == 1) {
                $status = 0;
                $_POST['data']['status'] = $status;
                $status_result = 0;
            } else {
                $status = 1;
                $_POST['data']['status'] = $status;
                $status_result = 1;
            }

            $update = $this->user_mod->update_role($_POST['data'], $role_id);

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: ' . date('r', time() + (86400 * 365)));
            header('Content-type: application/json');

            echo json_encode(array(
                'valid' => true,
                'success_message' => $status_result,
                'title' => $title
            ));
            exit();
        }
    }

    /*
     * ADD ROLE INFO
     * */
    function add()
    {
        if(!$this->session->userdata['userData']['session_user_id']){
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'roles');

        // Define Data array
        $data = array(
            'page_title' => 'Add Role - bsSelfBusiness System',
            'sidebar_menu_title' => 'USER MANAGEMENT',
            'sidebar_menu' => 'Add Role'
        );

        $data['js'] = array(
            'assets/plugins/parsleyjs/dist/parsley.min.js'
        );


        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';

        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[name]', 'Role Name', 'trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            }
            else {
                $_POST['data']['status'] = 1;
                $add_rate = $this->user_mod->add_role($_POST['data']);
                $flash_msgs = array('flash_msgs' => 'Role added successfully');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'roles', 'location', '301'); // 301 redirected
            }

        }

        // Send $data array() to add
        $data['content'] = $this->load->view('roles/add', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /*
     * Update role
     * */
    public function edit()
    {
        if(!$this->session->userdata['userData']['session_user_id']){
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'roles');

        // Define Data array
        $data = array(
            'page_title' => 'Update Role - bsSelfBusiness System',
            'sidebar_menu_title' => 'USER MANAGEMENT',
            'sidebar_menu' => 'Update Role'
        );


        $data['js'] = array(
            'assets/plugins/parsleyjs/dist/parsley.min.js'
        );

        $data['form_validation'] = '<script type="text/javascript">
										$(document).ready(function() {
											$("#form1").parsley();
										});
									</script>';

        $role_id = $this->uri->segment(3);

        if (isset($_POST['OkSaveData'])) {

            $data['role_id'] = $role_id;

            $this->form_validation->set_rules('data[name]', 'Role Name', 'trim|required');
            if ($this->form_validation->run() == FALSE)
            {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            }else{

                if (empty($role_id)) {
                    $role_id = $this->user_mod->add_role($_POST['data']);

                    $flash_msgs = array('flash_msgs' => 'Role added successfully');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'roles', 'location', '301'); // 301 redirected
                } else {
                    $this->user_mod->update_role($_POST['data'], $role_id);

                    $flash_msgs = array('flash_msgs' => 'Role updated successfully');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'roles', 'location', '301'); // 301 redirected
                }
            }
        }

        if (!empty($role_id)) {
            $role_data = $this->user_mod->get_role_by_id($role_id);
        } elseif (isset($_POST['OkSaveData'])) {
            $role_data = array(
                'name' => $_POST['data'][name]
            );
            $role_data = (object)$role_data;
        } else {
            $role_data = array(
                'name' => ''
            );

            $role_data = (object)$role_data;
        }

        $data['data'] = $role_data;
        $data['role_id'] = $role_id;

        // Send $data array() to edit
        $data['content'] = $this->load->view('roles/edit', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);

    }

    /*Delete */
    public function delete()
    {
        if(!$this->session->userdata['userData']['session_user_id']){
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'roles');
        
        $role_id = $this->uri->segment(3);
        $this->user_mod->delete_role($role_id);
        $flash_msgs = array('flash_msgs' => 'Role deleted successfully');
        $this->session->set_userdata($flash_msgs);
        redirect(base_url() . 'roles', 'location', '301'); // 301 redirected
    }

}