<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //$this->load->library('email');
        $this->load->model('user_mod');
        $this->load->model('setting_mod');
        $this->load->model('staff_mod');
        $this->load->library('session');
        $this->load->library('email');

        $this->load->library('pagination'); // pagination class
        $this->load->helper(array('form', 'url'));
        $this->load->helper('file');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p>', '</p>');

        //login accesscheck
        //$this->user_mod->check_loggedin();

        // upload data image file
        $config['upload_path'] = document_url . 'uploads/userprofiles/';
        $config['allowed_types'] = 'png|gif|jpeg|jpg|bmp|image/png|image/gif|image/jpeg|image/jpg|image/bmp';
        $config['overwrite'] = TRUE;
        $config['encrypt_name'] = FALSE;
        $config['remove_spaces'] = TRUE;
        $config['max_size'] = '100';
        $config['max_width'] = "350";
        $config['max_height'] = "350";
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
    }

    /*
     * LOGIN FUNCTION
     * */
    public function login()
    {
        $data['page_title'] = 'Login - bsSelfBusiness System';
        // Set required fields for validation
        $this->form_validation->set_rules('username', 'email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Form has not yet been posted, load the login form page
            $data['err_message'] = validation_errors();
        } else {
            // Get the email_id, password field
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));

            // Authenticate the user
            $userInfo = $this->user_mod->get_user($username, $password);

            if (!$userInfo) {
                $flash_err_msgs = array('flash_err_msgs' => 'Invalid email id or password.');
                $this->session->set_userdata($flash_err_msgs);
            } elseif ($userInfo->status == 0) {
                $flash_err_msgs = array('flash_err_msgs' => 'Your account is not active.');
                $this->session->set_userdata($flash_err_msgs);
            } elseif ($userInfo->status == -1) {
                $flash_err_msgs = array('flash_err_msgs' => 'You can not access the application.');
                $this->session->set_userdata($flash_err_msgs);
            } else {
                

                    $userId = $userInfo->id;
                    $userFullName = $userInfo->salutation . ' ' . $userInfo->first_name . ' ' . $userInfo->last_name;
                    $userName = $userInfo->username;


                    $userRoleInfo = $this->user_mod->get_role_by_user_id($userInfo->id);
                    $roleId = $userRoleInfo->id;
                    $roleName = $userRoleInfo->name;

                    //print_r($userRoleInfo); exit();
                    $userData = array(
                        'session_logged_in' => true,
                        'session_user_id' => $userId,
                        'session_user_full_name' => $userFullName,
                        'session_username' => $userName,
                        'session_role_name' => $roleName,
                        'session_role_id' => $roleId,
                        'session_profile_image' => $userInfo->profile_image
                    );
                    

                    // Set Session
                    $this->session->set_userdata('userData', $userData);
                    redirect('dashboard/index');
                
            }
        }
        //$data['var_account_name'] = $this->set_account_name_var();
        // Send $data array() to index page
        $data['content'] = $this->load->view("pages/login", $data, true);
        // Use Layout
        $this->load->view('layout/login_layout', $data);
    }

    /* Registration */
    function registration(){

        $data['page_title'] = 'Customer Registration - bsSelfBusiness System';

        $var_account_name = $this->set_account_name_var();
        $data['var_account_name'] = $var_account_name;
        // Set required fields for validation
        $this->form_validation->set_rules('username', 'email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if(empty($var_account_name)){
            $condition=array();
        }else{
            $condition=array("directory_url"=>substr($var_account_name,0,-1));
        }
        $corporate_info = $this->corporate_account_mod->get_corporate_account_id_by_directory_url($condition);
        $corporate_id = $corporate_info->id;

        $is_customer_number_required = $this->setting_mod->is_customer_number_required($corporate_id);
        $data['is_customer_number_required'] = $is_customer_number_required;

        if ($this->form_validation->run() == FALSE) {
            $data['err_message'] = validation_errors();
        } else {

            // Get the email_id, password field
            $username = $this->input->post('username');

            if(empty($var_account_name)){
                $condition=array("u.username" => $username);
            }else{
                $condition=array("u.username" => $username, "ca.directory_url"=>substr($var_account_name,0,-1));
            }

            $isAnyExistingUsername = $this->user_mod->unique_username($condition);

            if($isAnyExistingUsername == 1){
                $flash_err_msgs = array('flash_err_msgs' => 'Sorry! This username(email) has been exist.');
                $this->session->set_userdata($flash_err_msgs);
            }else{

                $data_user = array(
                    'corporate_account_id' => $corporate_id,
                    'salutation' => $_POST['salutation'],
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    'username' => $_POST['username'],
                    'password' => md5(trim($_POST['password'])),
                    'contact_no' => $_POST['contact_no'],
                    'status' => 1,
                    'created_by' => $this->session->userdata['userData']['session_user_id'],
                    'created_date' => date('Y-m-d H:i:s')
                );

                $user_id = $this->user_mod->add_user($data_user);

                $user_role_data = array(
                    'user_id' => $user_id,
                    'role_id' => $_POST['data']['role_id']
                );

                $this->user_mod->add_user_role($user_role_data);

                $flash_msgs = array('flash_msgs' => 'Customer added successfully');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . $var_account_name.'users/registration', 'location', '301'); // 301 redirected
            }
            redirect($var_account_name.'users/registration');
        }

        $data['content'] = $this->load->view('pages/registration', $data, true);
        // Use Layout
        $this->load->view('layout/login_layout', $data);
    }

    /* Forgot Password */
    function forget_password(){

        $data['page_title'] = 'Forget Password - bsSelfBusiness System';

        $var_account_name = $this->set_account_name_var();
        $data['var_account_name'] = $var_account_name;
        // Set required fields for validation
        $this->form_validation->set_rules('username', 'email', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data['err_message'] = validation_errors();
        } else {

            // Get the email_id, password field
            $username = $this->input->post('username');

            if(empty($var_account_name)){
                $condition=array("u.username" => $username);
            }else{
                $condition=array("u.username" => $username, "ca.directory_url"=>substr($var_account_name,0,-1));
            }

            $isAnyExistingUsername = $this->user_mod->unique_username($condition);

            if($isAnyExistingUsername == 0){
                $flash_err_msgs = array('flash_err_msgs' => 'Sorry! you are not existing user.');
                $this->session->set_userdata($flash_err_msgs);
            }else{

                $row = $this->user_mod->get_user_by_username($username);
                $user_id = $row->id;
                $full_name = $row->first_name.' '.$row->last_name;

                // Create activation_hash
                $user_data['activation_hash']= md5(date('Y-m-d H:i:s'));
                // Update user
                $this->user_mod->update($user_data, $user_id);

                /* Get corporate account info */
                $setting_data = $this->corporate_account_mod->get_corporate_account_by_id($row->corporate_account_id);
                $company_email = $setting_data->corporate_email;
                $company_name = ( $setting_data->name ) ? $setting_data->name : 'Booking System';
                $user_id_encrp = $user_id; //base64_encode($id_encrypt);
                $activate_text = "<a href='".site_url($var_account_name.'users/reset_password/'.$user_id_encrp.'/'.$user_data['activation_hash'])."'>click here</a>";

                /*Email Start*/
                $body             = file_get_contents('EmailTemplates/forgetPasswordEmail.html');
                $body			  = str_replace("#SITE_NAME", $company_name, $body);
                $body			  = str_replace("#ACTIVATE_URL", $activate_text, $body);
                $body			  = str_replace("#USER_NAME", $full_name, $body);
                $body			  = str_replace("#DATE", date('jS F, Y'), $body);

                $mail_config['charset'] = 'iso-8859-1';
                $mail_config['wordwrap'] = TRUE;
                $mail_config['mailtype'] = 'html';

                $this->email->initialize($mail_config);

                $this->email->from($company_email, $company_name);
                $this->email->to($username);
                $users_mail_subject = 'Reset your password';
                $this->email->subject($users_mail_subject);
                $this->email->message($body);
                $this->email->send();

                $flash_msgs = array('flash_msgs' => 'Please check your mail for changing password link.');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . $var_account_name.'users/forget_password', 'location', '301'); // 301 redirected
            }

            redirect($var_account_name.'users/forget_password');
        }

        $data['content'] = $this->load->view('pages/forget_password', $data, true);
        // Use Layout
        $this->load->view('layout/login_layout', $data);
    }

    /* Reset Password */
    function reset_password(){

        $data['page_title'] = 'Forget Password - bsSelfBusiness System';

        $var_account_name = $this->set_account_name_var();
        $data['var_account_name'] = $var_account_name;

        // check if it is valid url
        $user_id = $this->uri->segment(3);
        $auth_hash = $this->uri->segment(4);

        if(!empty($user_id) && !empty($auth_hash)){

            // Check user by using user_id && auth_hash
            $row = $this->user_mod->reset_password_activation_system($user_id, $auth_hash);

            if(!$row)
            {
                $flash_err_msgs = array('flash_err_msgs' => 'Sorry! This is invalid link');
                $this->session->set_userdata($flash_err_msgs);
                redirect(base_url() . $var_account_name.'users/forget_password', 'location', '301'); // 301 redirected
            }
            else
            {
                if (isset($_POST['OkSaveData'])) {
                    $newpassword1 = $this->input->post('newpassword1');
                    $newpassword2 = $this->input->post('newpassword2');

                    if($newpassword1 == $newpassword2){
                        $user_id = $row->id;
                        $user_data['activation_hash']= '';
                        $user_data['password']= md5($newpassword1);
                        // Update user
                        $this->user_mod->update($user_data, $user_id);
                        $login_link = '<a href="'.base_url() . $var_account_name.'users/login" >Now login</a>';
                        $flash_msgs = array('flash_msgs' => 'Your password reset successfully.'.$login_link);
                        $this->session->set_userdata($flash_msgs);

                    }else{
                        $flash_err_msgs = array('flash_err_msgs' => 'Sorry! New password and confirm password is not same.');
                        $this->session->set_userdata($flash_err_msgs);
                    }
                }
            }
        }

        $data['content'] = $this->load->view('pages/reset_password', $data, true);
        // Use Layout
        $this->load->view('layout/login_layout', $data);

    }

    /*
     * LOGOUT
     **/
    public function logout()
    {

        $userData = array(
            'session_logged_in' => '',
            'session_user_id' => '',
            'session_user_full_name' => '',
            'session_username' => '',
            'session_role_name' => '',
            'session_default_bg_img' => '',
            'session_default_profile_img' => '',
            'session_default_logo_img' => '',
            'session_text_color' => '',
            'session_box_outline_color' => '',
            'session_box_bg_color' => '',
        );
        $this->session->unset_userdata($userData);
        $this->session->sess_destroy();
        // redirect to this controller index function
        redirect('users/login');
    }

    /* SHOW ALL LIST*/
    public function index()
    {
        if (!$this->session->userdata['userData']['session_user_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'users');

        // SELECT ALL ROLES
        $user_data = $this->user_mod->get_all_user();

        // Define Data array
        $data = array(
            'page_title' => 'User List',
            'sidebar_menu_title' => 'USER MANAGEMENT',
            'sidebar_menu' => 'User List',
            'user_data' => $user_data
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
        $data['content'] = $this->load->view('users/index', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);

    }

    /*
     * ADD USER
     * */
    public function add()
    {
        if (!$this->session->userdata['userData']['session_user_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'users');

        // Define Data array
        $data = array(
            'page_title' => 'Add User - bsSelfBusiness System',
            'sidebar_menu_title' => 'User Management',
            'sidebar_menu' => 'Add User'
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

            $this->form_validation->set_rules('data[username]', 'User Name', 'trim|required');
            $this->form_validation->set_rules('data[password]', 'Password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
//echo 111;exit;
                $upload_validation_error = '';
                /*Icon Image Upload*/
                if (isset($_FILES["profile_image"]["tmp_name"]) && $_FILES["profile_image"]["name"] != '') {
                    if (!$this->upload->do_upload('profile_image')) {
                        $upload_validation_error = $this->upload->display_errors();
                        $data['upload_validation_error'] = $upload_validation_error;
                    } else {
                        // if file processed, get the uploaded data
                        $upload_data = $this->upload->data();
                        $_POST['data']['profile_image'] = $upload_data['file_name'];
                    }
                }

                if ($upload_validation_error == '') {

                    $data_user = array(
                        'salutation' => $_POST['data']['salutation'],
                        'first_name' => $_POST['data']['first_name'],
                        'last_name' => $_POST['data']['last_name'],
                        'username' => $_POST['data']['username'],
                        'password' => md5(trim($_POST['data']['password'])),
                        'contact_no' => $_POST['data']['contact_no'],
                        'profile_image' => $_POST['data']['profile_image'],
                        'status' => 1,
                        'created_by' => $this->session->userdata['userData']['session_user_id'],
                        'created_date' => date('Y-m-d H:i:s')
                    );

                    $user_info = $this->user_mod->add_user($data_user);

                    $user_role_data = array(
                        'user_id' => $this->db->insert_id(),
                        'role_id' => $_POST['data']['role_id']
                    );

                    $user_role_info = $this->user_mod->add_user_role($user_role_data);

                    $flash_msgs = array('flash_msgs' => 'User added successfully');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'users', 'location', '301'); // 301 redirected
                }
            }


        }

        // Select all corporate account
        //$data['account_list'] = $this->corporate_account_mod->get_all_corporate_account();

        // Select all role
        $data['role_list'] = $this->user_mod->get_all_role();

        // Send $data array() to add
        $data['content'] = $this->load->view('users/add', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);

    }

    /*
     * Update USER Info
     * */
    public function edit()
    {
        if (!$this->session->userdata['userData']['session_user_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'users');

        // Define Data array
        $data = array(
            'page_title' => 'Update User - bsSelfBusiness System',
            'sidebar_menu_title' => 'User Management',
            'sidebar_menu' => 'Update User'
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

        $user_id = $this->uri->segment(3);

        if (!empty($user_id)) {
            $user_data = $this->user_mod->get_user_by_id($user_id);
        }
        // Get user role id
        $role_data = $this->user_mod->get_role_id_by_user_id($user_id);
        $role_id = $role_data->role_id;

        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[username]', 'User Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                $upload_validation_error = '';
                $profile_image_check = '';

                /*Profile Image Upload*/
                if (isset($_FILES["profile_image"]["tmp_name"]) && $_FILES["profile_image"]["name"] != '') {
                    if (!$this->upload->do_upload('profile_image')) {
                        $upload_validation_error = $this->upload->display_errors();
                        $data['upload_validation_error'] = $upload_validation_error;
                    } else {
                        // if file processed, get the uploaded data
                        $upload_data = $this->upload->data();
                        $_POST['data']['profile_image'] = $upload_data['file_name'];
                        $profile_image_check = $upload_data['file_name'];
                    }
                } else {
                    if ($user_data->profile_image != '') { // If the image name exist
                        $profile_image_check = $user_data->profile_image;
                    }
                }

                if ($upload_validation_error == '') {

                    $data_user = array(
                        'salutation' => $_POST['data']['salutation'],
                        'first_name' => $_POST['data']['first_name'],
                        'last_name' => $_POST['data']['last_name'],
                        'username' => $_POST['data']['username'],
                        'contact_no' => $_POST['data']['contact_no'],
                        'profile_image' => $profile_image_check,
                        'status' => 1,
                        'updated_by' => $this->session->userdata['userData']['session_user_id'],
                        'updated_date' => date('Y-m-d H:i:s')
                    );

                    $user_role_data = array(
                        'user_id' => $user_id,
                        'role_id' => $_POST['data']['role_id']
                    );

                    $this->user_mod->update($data_user, $user_id);
                    $this->user_mod->update_user_role($user_role_data, $user_id);

                    $flash_msgs = array('flash_msgs' => 'User Update successfully');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'users', 'location', '301'); // 301 redirected

                }

            }
        }

        // Select all role
        $data['role_list'] = $this->user_mod->get_all_role();

        //$data['account_list'] = $account_list;
        $data['role_id'] = $role_id;
        $data['data'] = $user_data;
        $data['user_id'] = $user_id;

        // Send $data array() to edit
        $data['content'] = $this->load->view('users/edit', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);

    }

    /*Delete Users*/
    public function delete()
    {
        if (!$this->session->userdata['userData']['session_user_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'users');

        $user_id = $this->uri->segment(3);
        $this->user_mod->delete_user($user_id);

        $flash_msgs = array('flash_msgs' => 'User deleted successfully');
        $this->session->set_userdata($flash_msgs);
        redirect(base_url() . 'users', 'location', '301'); // 301 redirected
    }

    /* Show customer list*/
    public function customers()
    {
        if (!$this->session->userdata['userData']['session_corporate_account_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'customers');

        // SELECT ALL customer - customer role id 2
        $user_data = $this->user_mod->get_all_user($this->session->userdata['userData']['session_corporate_account_id'], 5);

        // Define Data array
        $data = array(
            'page_title' => 'Customer List',
            'sidebar_menu_title' => 'Customer MANAGEMENT',
            'sidebar_menu' => 'Customer List',
            'user_data' => $user_data
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
        $data['content'] = $this->load->view('users/customers', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* Add customer*/
    public function add_customer()
    {
        if (!$this->session->userdata['userData']['session_corporate_account_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'customers');

        // Define Data array
        $data = array(
            'page_title' => 'Add User - bsSelfBusiness System',
            'sidebar_menu_title' => 'User Management',
            'sidebar_menu' => 'Add User'
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

            $this->form_validation->set_rules('data[username]', 'User Name', 'trim|required');
            $this->form_validation->set_rules('data[password]', 'Password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                $upload_validation_error = '';
                /*Icon Image Upload*/
                if (isset($_FILES["profile_image"]["tmp_name"]) && $_FILES["profile_image"]["name"] != '') {
                    if (!$this->upload->do_upload('profile_image')) {
                        $upload_validation_error = $this->upload->display_errors();
                        $data['upload_validation_error'] = $upload_validation_error;
                    } else {
                        // if file processed, get the uploaded data
                        $upload_data = $this->upload->data();
                        $_POST['data']['profile_image'] = $upload_data['file_name'];
                    }
                }

                if ($upload_validation_error == '') {

                    $data_user = array(
                        'corporate_account_id' => $_POST['data']['corporate_account_id'],
                        'salutation' => $_POST['data']['salutation'],
                        'first_name' => $_POST['data']['first_name'],
                        'last_name' => $_POST['data']['last_name'],
                        'username' => $_POST['data']['username'],
                        'password' => md5(trim($_POST['data']['password'])),
                        'contact_no' => $_POST['data']['contact_no'],
                        'profile_image' => $_POST['data']['profile_image'],
                        'status' => 1,
                        'created_by' => $this->session->userdata['userData']['session_user_id'],
                        'created_date' => date('Y-m-d H:i:s')
                    );

                    $user_id = $this->user_mod->add_user($data_user);

                    $user_role_data = array(
                        'user_id' => $user_id,
                        'role_id' => $_POST['data']['role_id']
                    );

                    $this->user_mod->add_user_role($user_role_data);

                    $flash_msgs = array('flash_msgs' => 'User added successfully');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'users/customers', 'location', '301'); // 301 redirected
                }
            }
        }

        // Select all corporate account
        $data['account_list'] = $this->corporate_account_mod->get_all_corporate_account();
        $is_customer_number_required = $this->setting_mod->is_customer_number_required($this->session->userdata['userData']['session_corporate_account_id']);
        $data['is_customer_number_required'] = $is_customer_number_required;

        // Select all role
        $data['role_list'] = $this->user_mod->get_all_role();

        // Send $data array() to add
        $data['content'] = $this->load->view('users/add_customer', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /*
  * Update Customer Info
  * */
    public function edit_customer()
    {
        if (!$this->session->userdata['userData']['session_corporate_account_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'customers');

        // Define Data array
        $data = array(
            'page_title' => 'Update User - bsSelfBusiness System',
            'sidebar_menu_title' => 'User Management',
            'sidebar_menu' => 'Update User'
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

        $user_id = $this->uri->segment(3);

        if (!empty($user_id)) {
            $user_data = $this->user_mod->get_user_by_id($user_id);
        }

        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[username]', 'User Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                $upload_validation_error = '';
                $profile_image_check = '';
                if (!empty($_FILES["profile_image"]["tmp_name"])) {
                    /*Profile Image Upload*/
                    if (isset($_FILES["profile_image"]["tmp_name"]) && $_FILES["profile_image"]["name"] != '') {
                        if (!$this->upload->do_upload('profile_image')) {
                            $upload_validation_error = $this->upload->display_errors();
                            $data['upload_validation_error'] = $upload_validation_error;
                        } else {
                            // if file processed, get the uploaded data
                            $upload_data = $this->upload->data();
                            $profile_image_check = $upload_data['file_name'];
                        }
                    }
                } else {
                    if ($user_data->profile_image != '') { // If the image name exist
                        $profile_image_check = $user_data->profile_image;
                    }
                }

                if (empty($_POST['data']['password'])) {
                    $password_check = $user_data->password;
                } else {
                    $password_check = md5(trim($_POST['data']['password']));
                }
                if ($upload_validation_error == '') {

                    $data_user = array(
                        'corporate_account_id' => $_POST['data']['corporate_account_id'],
                        'salutation' => $_POST['data']['salutation'],
                        'first_name' => $_POST['data']['first_name'],
                        'last_name' => $_POST['data']['last_name'],
                        'username' => $_POST['data']['username'],
                        'password' => $password_check,
                        'contact_no' => $_POST['data']['contact_no'],
                        'profile_image' => $profile_image_check,
                        'status' => 1,
                        'updated_by' => $this->session->userdata['userData']['session_user_id'],
                        'updated_date' => date('Y-m-d H:i:s')
                    );

                    $user_role_data = array(
                        'user_id' => $user_id,
                        'role_id' => $_POST['data']['role_id']
                    );

                    $this->user_mod->update($data_user, $user_id);
                    $this->user_mod->update_user_role($user_role_data, $user_id);

                    $flash_msgs = array('flash_msgs' => 'User Update successfully');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'users/customers', 'location', '301'); // 301 redirected

                }
            }
        }

        $is_customer_number_required = $this->setting_mod->is_customer_number_required($this->session->userdata['userData']['session_corporate_account_id']);
        $data['is_customer_number_required'] = $is_customer_number_required;

        $data['data'] = $user_data;
        $data['user_id'] = $user_id;

        // Send $data array() to edit
        $data['content'] = $this->load->view('users/edit_customer', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);

    }

    /** Delete Customer */
    public function delete_customer()
    {
        if (!$this->session->userdata['userData']['session_corporate_account_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'customers');

        $user_id = $this->uri->segment(3);
        $this->user_mod->delete_user($user_id);

        $flash_msgs = array('flash_msgs' => 'Customer deleted successfully');
        $this->session->set_userdata($flash_msgs);
        redirect(base_url() . 'users/customers', 'location', '301'); // 301 redirected
    }

    /* Show Admins List*/
    public function admins()
    {
        if (!$this->session->userdata['userData']['session_corporate_account_id']) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'admins');

        // SELECT ALL customer - customer role id 2
        $user_data = $this->user_mod->get_all_user($this->session->userdata['userData']['session_corporate_account_id'], 3);

        // Define Data array
        $data = array(
            'page_title' => 'Admin List',
            'sidebar_menu_title' => 'Admin Management',
            'sidebar_menu' => 'Admin List',
            'user_data' => $user_data
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
        $data['content'] = $this->load->view('users/admins', $data, true);

        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* Add customer*/
    public function add_admin()
    {
        if (!$this->session->userdata['userData']['session_corporate_account_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'admins');

        // Define Data array
        $data = array(
            'page_title' => 'Add Admin - bsSelfBusiness System',
            'sidebar_menu_title' => 'Admin Management',
            'sidebar_menu' => 'Add Admin'
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

            $this->form_validation->set_rules('data[username]', 'User Name', 'trim|required');
            $this->form_validation->set_rules('data[password]', 'Password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                $upload_validation_error = '';
                /*Icon Image Upload*/
                if (isset($_FILES["profile_image"]["tmp_name"]) && $_FILES["profile_image"]["name"] != '') {
                    if (!$this->upload->do_upload('profile_image')) {
                        $upload_validation_error = $this->upload->display_errors();
                        $data['upload_validation_error'] = $upload_validation_error;
                    } else {
                        // if file processed, get the uploaded data
                        $upload_data = $this->upload->data();
                        $_POST['data']['profile_image'] = $upload_data['file_name'];
                    }
                }

                if ($upload_validation_error == '') {

                    $data_user = array(
                        'corporate_account_id' => $_POST['data']['corporate_account_id'],
                        'salutation' => $_POST['data']['salutation'],
                        'first_name' => $_POST['data']['first_name'],
                        'last_name' => $_POST['data']['last_name'],
                        'username' => $_POST['data']['username'],
                        'password' => md5(trim($_POST['data']['password'])),
                        'contact_no' => $_POST['data']['contact_no'],
                        'profile_image' => $_POST['data']['profile_image'],
                        'status' => 1,
                        'created_by' => $this->session->userdata['userData']['session_user_id'],
                        'created_date' => date('Y-m-d H:i:s')
                    );

                    $user_id = $this->user_mod->add_user($data_user);

                    $user_role_data = array(
                        'user_id' => $user_id,
                        'role_id' => $_POST['data']['role_id']
                    );

                    $this->user_mod->add_user_role($user_role_data);

                    $flash_msgs = array('flash_msgs' => 'Admin added successfully');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'users/admins', 'location', '301'); // 301 redirected
                }

            }


        }

        $is_customer_number_required = $this->setting_mod->is_customer_number_required($this->session->userdata['userData']['session_corporate_account_id']);
        $data['is_customer_number_required'] = $is_customer_number_required;

        // Send $data array() to add
        $data['content'] = $this->load->view('users/add_admin', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* Update Admin Info */
    public function edit_admin()
    {
        if (!$this->session->userdata['userData']['session_corporate_account_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'admins');

        // Define Data array
        $data = array(
            'page_title' => 'Update Admin - bsSelfBusiness System',
            'sidebar_menu_title' => 'Admin Management',
            'sidebar_menu' => 'Update Admin'
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

        $user_id = $this->uri->segment(3);

        if (!empty($user_id)) {
            $user_data = $this->user_mod->get_user_by_id($user_id);
        }

        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[username]', 'User Name', 'trim|required');
            $this->form_validation->set_rules('data[password]', 'Password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                $upload_validation_error = '';
                $profile_image_check = '';
                /*Profile Image Upload*/
                if (isset($_FILES["profile_image"]["tmp_name"]) && $_FILES["profile_image"]["name"] != '') {
                    if (!$this->upload->do_upload('profile_image')) {
                        $upload_validation_error = $this->upload->display_errors();
                        $data['upload_validation_error'] = $upload_validation_error;
                    } else {
                        // if file processed, get the uploaded data
                        $upload_data = $this->upload->data();
                        $_POST['data']['profile_image'] = $upload_data['file_name'];
                        $profile_image_check = $upload_data['file_name'];
                    }
                } else {
                    if ($user_data->profile_image != '') { // If the image name exist
                        $profile_image_check = $user_data->profile_image;
                    }
                }

                if (empty($_POST['data']['password'])) {
                    $password_check = $user_data->password;
                } else {
                    $password_check = md5(trim($_POST['data']['password']));
                }

                if ($upload_validation_error == '') {

                    $data_user = array(
                        'corporate_account_id' => $_POST['data']['corporate_account_id'],
                        'salutation' => $_POST['data']['salutation'],
                        'first_name' => $_POST['data']['first_name'],
                        'last_name' => $_POST['data']['last_name'],
                        'username' => $_POST['data']['username'],
                        'password' => $password_check,
                        'contact_no' => $_POST['data']['contact_no'],
                        'profile_image' => $profile_image_check,
                        'status' => 1,
                        'updated_by' => $this->session->userdata['userData']['session_user_id'],
                        'updated_date' => date('Y-m-d H:i:s')
                    );

                    $this->user_mod->update($data_user, $user_id);

                    $user_role_data = array(
                        'user_id' => $user_id,
                        'role_id' => $_POST['data']['role_id']
                    );

                    $this->user_mod->update_user_role($user_role_data, $user_id);

                    $flash_msgs = array('flash_msgs' => 'Admin update successfully');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'users/admins', 'location', '301'); // 301 redirected
                }
            }
        }

        $is_customer_number_required = $this->setting_mod->is_customer_number_required($this->session->userdata['userData']['session_corporate_account_id']);
        $data['is_customer_number_required'] = $is_customer_number_required;

        $data['data'] = $user_data;
        $data['user_id'] = $user_id;

        // Send $data array() to edit
        $data['content'] = $this->load->view('users/edit_admin', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);

    }

    /** Delete Admin */
    public function delete_admin()
    {
        if (!$this->session->userdata['userData']['session_corporate_account_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'admins');

        $user_id = $this->uri->segment(3);
        $this->user_mod->delete_user($user_id);

        $flash_msgs = array('flash_msgs' => 'Admin deleted successfully');
        $this->session->set_userdata($flash_msgs);
        redirect(base_url() . 'users/admins', 'location', '301'); // 301 redirected
    }

    /* Show Staffs List*/
    public function staffs()
    {
        if (!$this->session->userdata['userData']['session_corporate_account_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'staffs');

        // SELECT ALL customer - staff role id 4
        $user_data = $this->user_mod->get_all_user($this->session->userdata['userData']['session_corporate_account_id'], 4);

        // Define Data array
        $data = array(
            'page_title' => 'Staff List',
            'sidebar_menu_title' => 'Staff Management',
            'sidebar_menu' => 'Staff List',
            'user_data' => $user_data
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
        $data['content'] = $this->load->view('users/staffs', $data, true);

        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* Add Staff*/
    public function add_staff()
    {
        if (!$this->session->userdata['userData']['session_corporate_account_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'staffs');

        // Define Data array
        $data = array(
            'page_title' => 'Add Staff - bsSelfBusiness System',
            'sidebar_menu_title' => 'Staff Management',
            'sidebar_menu' => 'Add Staff'
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
											
                                            $("#action_to_all").click(function () {
                                                if ($(this).prop("checked")) {
                                                    $(".checkbox").prop("checked", true);
                                                } else {
                                                    $(".checkbox").prop("checked", false);
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

        $is_any_service_under_this_account = $this->service_mod->is_service_exit_by_corporate_account_id($this->session->userdata['userData']['session_corporate_account_id']);

        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[username]', 'User Name', 'trim|required');
            $this->form_validation->set_rules('data[password]', 'Password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                $upload_validation_error = '';

                /*User Image Upload*/
                if (isset($_FILES["profile_image"]["tmp_name"]) && $_FILES["profile_image"]["name"] != '') {
                    if (!$this->upload->do_upload('profile_image')) {
                        $upload_validation_error = $this->upload->display_errors();
                        $data['upload_validation_error'] = $upload_validation_error;
                    } else {
                        // if file processed, get the uploaded data
                        $upload_data = $this->upload->data();
                        $_POST['data']['profile_image'] = $upload_data['file_name'];
                    }
                }

                if ($upload_validation_error == '') {

                    $data_user = array(
                        'corporate_account_id' => $_POST['data']['corporate_account_id'],
                        'salutation' => $_POST['data']['salutation'],
                        'first_name' => $_POST['data']['first_name'],
                        'last_name' => $_POST['data']['last_name'],
                        'username' => $_POST['data']['username'],
                        'password' => md5(trim($_POST['data']['password'])),
                        'contact_no' => $_POST['data']['contact_no'],
                        'profile_image' => $_POST['data']['profile_image'],
                        'status' => 1,
                        'created_by' => $this->session->userdata['userData']['session_user_id'],
                        'created_date' => date('Y-m-d H:i:s')
                    );

                    $user_id = $this->user_mod->add_user($data_user);

                    $user_role_data = array(
                        'user_id' => $user_id,
                        'role_id' => $_POST['data']['role_id']
                    );

                    $user_role_info = $this->user_mod->add_user_role($user_role_data);

                    $staff_settings_data = array(
                        'user_id' => $user_id,
                        'staff_selection_type' => $_POST['data']['staff_selection_type'],
                        'is_show_staff_mobile_no' => (!empty($_POST['data']['is_show_staff_mobile_no'])) ? 1 : 0,
                        'is_show_staff_profile_img' => (!empty($_POST['data']['is_show_staff_profile_img'])) ? 1 : 0,
                        'is_email_notification_active' => (!empty($_POST['data']['is_email_notification_active'])) ? 1 : 0,
                        'name_presentation_style' => (!empty($_POST['data']['name_presentation_style'])) ? 1 : 0
                    );

                    $staff_setting_info = $this->staff_mod->add_staff_setting($staff_settings_data);

                    if ($is_any_service_under_this_account == 1) {

                        foreach ($_POST['serviceArr'] as $serviceArrs) {
                            $staff_service_data = array(
                                'user_id' => $user_id,
                                'service_id' => $serviceArrs
                            );
                            $staff_service_info = $this->staff_mod->add_staff_service($staff_service_data);
                        }

                    }

                    $flash_msgs = array('flash_msgs' => 'Staff added successfully');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'users/staffs', 'location', '301'); // 301 redirected
                }
            }
        }

        // Select all corporate account
        $data['account_list'] = $this->corporate_account_mod->get_all_corporate_account();

        $is_customer_number_required = $this->setting_mod->is_customer_number_required($this->session->userdata['userData']['session_corporate_account_id']);
        $data['is_customer_number_required'] = $is_customer_number_required;

        // Select all service
        $data['service_list'] = $this->service_mod->get_all_services($this->session->userdata['userData']['session_corporate_account_id']);

        // is any service has been added by using this corporate account
        $data['is_any_service_under_this_account'] = $is_any_service_under_this_account;

        // Send $data array() to add
        $data['content'] = $this->load->view('users/add_staff', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /** Delete Staff */
    public function delete_staff()
    {
        if (!$this->session->userdata['userData']['session_corporate_account_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'staffs');

        $user_id = $this->uri->segment(3);
        $this->user_mod->delete_user($user_id);

        $flash_msgs = array('flash_msgs' => 'Staff deleted successfully');
        $this->session->set_userdata($flash_msgs);
        redirect(base_url() . 'users/staffs', 'location', '301'); // 301 redirected
    }

    /* Update Staff Info */
    public function edit_staff()
    {
        if (!$this->session->userdata['userData']['session_corporate_account_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'staffs');

        // Define Data array
        $data = array(
            'page_title' => 'Update Staff - bsSelfBusiness System',
            'sidebar_menu_title' => 'Staff Management',
            'sidebar_menu' => 'Update Staff'
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
											
											$("#action_to_all").click(function () {
                                                if ($(this).prop("checked")) {
                                                    $(".checkbox").prop("checked", true);
                                                } else {
                                                    $(".checkbox").prop("checked", false);
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

        $user_id = $this->uri->segment(3);

        if (!empty($user_id)) {
            $user_data = $this->user_mod->get_user_by_id($user_id);
        }

        $is_any_service_under_this_account = $this->service_mod->is_service_exit_by_corporate_account_id($this->session->userdata['userData']['session_corporate_account_id']);

        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[username]', 'User Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                $upload_validation_error = '';
                $profile_image_check = '';

                /*Profile Image Upload*/
                if (isset($_FILES["profile_image"]["tmp_name"]) && $_FILES["profile_image"]["name"] != '') {
                    if (!$this->upload->do_upload('profile_image')) {
                        $upload_validation_error = $this->upload->display_errors();
                        $data['upload_validation_error'] = $upload_validation_error;
                    } else {
                        // if file processed, get the uploaded data
                        $upload_data = $this->upload->data();
                        $_POST['data']['profile_image'] = $upload_data['file_name'];
                        $profile_image_check = $upload_data['file_name'];
                    }
                } else {
                    if ($user_data->profile_image != '') { // If the image name exist
                        $profile_image_check = $user_data->profile_image;
                    }
                }

                if (empty($_POST['data']['password'])) {
                    $password_check = $user_data->password;
                } else {
                    $password_check = md5(trim($_POST['data']['password']));
                }


                if ($upload_validation_error == '') {

                    // Update user
                    $data_user = array(
                        'corporate_account_id' => $_POST['data']['corporate_account_id'],
                        'salutation' => $_POST['data']['salutation'],
                        'first_name' => $_POST['data']['first_name'],
                        'last_name' => $_POST['data']['last_name'],
                        'username' => $_POST['data']['username'],
                        'password' => $password_check,
                        'contact_no' => $_POST['data']['contact_no'],
                        'profile_image' => $profile_image_check,
                        'status' => 1,
                        'updated_by' => $this->session->userdata['userData']['session_user_id'],
                        'updated_date' => date('Y-m-d H:i:s')
                    );

                    $this->user_mod->update($data_user, $user_id);

                    // Update User role
                    $user_role_data = array(
                        'user_id' => $user_id,
                        'role_id' => $_POST['data']['role_id']
                    );

                    $this->user_mod->update_user_role($user_role_data, $user_id);

                    // Update Staff Settings
                    $staff_settings_data = array(
                        'user_id' => $user_id,
                        'staff_selection_type' => $_POST['data']['staff_selection_type'],
                        'is_show_staff_mobile_no' => (!empty($_POST['data']['is_show_staff_mobile_no'])) ? 1 : 0,
                        'is_show_staff_profile_img' => (!empty($_POST['data']['is_show_staff_profile_img'])) ? 1 : 0,
                        'is_email_notification_active' => (!empty($_POST['data']['is_email_notification_active'])) ? 1 : 0,
                        'name_presentation_style' => (!empty($_POST['data']['name_presentation_style'])) ? 1 : 0
                    );

                    $this->staff_mod->update_staff_setting($staff_settings_data, $user_id);


                    if ($is_any_service_under_this_account == 1) {
                        // Delete existing service of this user
                        $this->staff_mod->delete_staff_service($user_id);

                        // Then add Staff Service
                        foreach ($_POST['serviceArr'] as $serviceArrs) {
                            $staff_service_data = array(
                                'user_id' => $user_id,
                                'service_id' => $serviceArrs
                            );
                            $this->staff_mod->add_staff_service($staff_service_data);
                        }
                    }

                    $flash_msgs = array('flash_msgs' => 'Staff update successfully');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'users/staffs', 'location', '301'); // 301 redirected

                }
            }
        }

        $is_customer_number_required = $this->setting_mod->is_customer_number_required($this->session->userdata['userData']['session_corporate_account_id']);
        $data['is_customer_number_required'] = $is_customer_number_required;

        // Select all service
        $data['service_list'] = $this->service_mod->get_all_services($this->session->userdata['userData']['session_corporate_account_id']);

        // Select staff setting information
        $data['staff_setting_data'] = $this->staff_mod->get_staff_settings_by_user_id($user_id);

        // Selected service list
        $data['staff_service_data'] = $this->staff_mod->get_staff_services_by_user_id($user_id);

        // is any service has been added by using this corporate account
        $data['is_any_service_under_this_account'] = $is_any_service_under_this_account;

        $data['data'] = $user_data;
        $data['user_id'] = $user_id;

        // Send $data array() to edit
        $data['content'] = $this->load->view('users/edit_staff', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);

    }

    /*Change Staff Status*/
    function status()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $user_id = $this->input->post('id');

            $icon_data = $this->user_mod->get_user_by_id($user_id);


            if ($this->input->post('status') == 1) {
                $status = 0;
                $_POST['data']['status'] = $status;
                $status_result = 0;
            } else {
                $status = 1;
                $_POST['data']['status'] = $status;
                $status_result = 1;
            }

            $update = $this->user_mod->update($_POST['data'], $user_id);

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

    /* Edit staff profile */
    function edit_profile()
    {

        if (!$this->session->userdata['userData']['session_user_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '');

        // Define Data array
        $data = array(
            'page_title' => 'Update User Profile - bsSelfBusiness System',
            'sidebar_menu_title' => 'User Management',
            'sidebar_menu' => 'Update User Profile'
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

        $user_id = $this->uri->segment(3);

        if (!empty($user_id)) {
            $user_data = $this->user_mod->get_user_by_id($user_id);
        }

        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[username]', 'User Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                $upload_validation_error = '';
                $profile_image_check = '';
                if (!empty($_FILES["profile_image"]["tmp_name"])) {
                    /*Profile Image Upload*/
                    if (isset($_FILES["profile_image"]["tmp_name"]) && $_FILES["profile_image"]["name"] != '') {
                        if (!$this->upload->do_upload('profile_image')) {
                            $upload_validation_error = $this->upload->display_errors();
                            $data['upload_validation_error'] = $upload_validation_error;
                        } else {
                            // if file processed, get the uploaded data
                            $upload_data = $this->upload->data();
                            $profile_image_check = $upload_data['file_name'];
                        }
                    }
                } else {
                    if ($user_data->profile_image != '') { // If the image name exist
                        $profile_image_check = $user_data->profile_image;
                    }
                }

                if ($upload_validation_error == '') {

                    $data_user = array(
                        'corporate_account_id' => $_POST['data']['corporate_account_id'],
                        'salutation' => $_POST['data']['salutation'],
                        'first_name' => $_POST['data']['first_name'],
                        'last_name' => $_POST['data']['last_name'],
                        'username' => $_POST['data']['username'],
                        'contact_no' => $_POST['data']['contact_no'],
                        'profile_image' => $profile_image_check,
                        'status' => 1,
                        'updated_by' => $this->session->userdata['userData']['session_user_id'],
                        'updated_date' => date('Y-m-d H:i:s')
                    );

                    $user_role_data = array(
                        'user_id' => $user_id,
                        'role_id' => $_POST['data']['role_id']
                    );

                    $this->user_mod->update($data_user, $user_id);
                    $this->user_mod->update_user_role($user_role_data, $user_id);

                    $flash_msgs = array('flash_msgs' => 'Your profile has been update successfully');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'users/edit_profile/' . $this->session->userdata['userData']['session_user_id'], 'location', '301'); // 301 redirected

                }
            }
        }

        $data['data'] = $user_data;
        $data['user_id'] = $user_id;

        // Send $data array() to edit
        $data['content'] = $this->load->view('users/edit_profile', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /*Chanage Password*/
    function change_password()
    {
        if (!$this->session->userdata['userData']['session_user_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'change_password');

        // Define Data array
        $data = array(
            'page_title' => 'Change User Password - bsSelfBusiness System',
            'sidebar_menu_title' => 'User Management',
            'sidebar_menu' => 'Change User Password'
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


        $user_data = $this->user_mod->get_user_by_id($this->session->userdata['userData']['session_user_id']);


        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[password]', 'Password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                if (md5(trim($_POST['data']['password'])) == trim($user_data->password)) {
                    $data_user = array(
                        'password' => md5(trim($_POST['data']['newpassword1'])),
                        'status' => 1,
                        'updated_by' => $this->session->userdata['userData']['session_user_id'],
                        'updated_date' => date('Y-m-d H:i:s')
                    );

                    $this->user_mod->update($data_user, $this->session->userdata['userData']['session_user_id']);
                    $flash_msgs = array('flash_msgs' => 'Your password has been updated successfully');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'users/change_password/' . $this->session->userdata['userData']['session_user_id'], 'location', '301'); // 301 redirected

                } else {

                    $flash_msgs = array('flash_msgs' => 'Your Current password is not matching with our system. Please try again!');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'users/change_password/' . $this->session->userdata['userData']['session_user_id'], 'location', '301'); // 301 redirected

                }
            }
        }

        // Send $data array() to edit
        $data['content'] = $this->load->view('users/change_password', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* Customer Edit profile */
    function customer_edit_profile()
    {

        if (!$this->session->userdata['userData']['session_corporate_account_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '');

        // Define Data array
        $data = array(
            'page_title' => 'Update User Profile - bsSelfBusiness System',
            'sidebar_menu_title' => 'User Management',
            'sidebar_menu' => 'Update User Profile'
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

        $user_id = $this->uri->segment(3);

        if (!empty($user_id)) {
            $user_data = $this->user_mod->get_user_by_id($user_id);
        }

        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[username]', 'User Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                $upload_validation_error = '';
                $profile_image_check = '';
                if (!empty($_FILES["profile_image"]["tmp_name"])) {
                    /*Profile Image Upload*/
                    if (isset($_FILES["profile_image"]["tmp_name"]) && $_FILES["profile_image"]["name"] != '') {
                        if (!$this->upload->do_upload('profile_image')) {
                            $upload_validation_error = $this->upload->display_errors();
                            $data['upload_validation_error'] = $upload_validation_error;
                        } else {
                            // if file processed, get the uploaded data
                            $upload_data = $this->upload->data();
                            $profile_image_check = $upload_data['file_name'];
                        }
                    }
                } else {
                    if ($user_data->profile_image != '') { // If the image name exist
                        $profile_image_check = $user_data->profile_image;
                    }
                }


                if (empty($_POST['data']['password'])) {
                    $password_check = $user_data->password;
                } else {
                    $password_check = md5(trim($_POST['data']['password']));
                }

                if ($upload_validation_error == '') {

                    $data_user = array(
                        'corporate_account_id' => $_POST['data']['corporate_account_id'],
                        'salutation' => $_POST['data']['salutation'],
                        'first_name' => $_POST['data']['first_name'],
                        'last_name' => $_POST['data']['last_name'],
                        'username' => $_POST['data']['username'],
                        'password' => $password_check,
                        'contact_no' => $_POST['data']['contact_no'],
                        'profile_image' => $profile_image_check,
                        'status' => 1,
                        'updated_by' => $this->session->userdata['userData']['session_user_id'],
                        'updated_date' => date('Y-m-d H:i:s')
                    );

                    $user_role_data = array(
                        'user_id' => $user_id,
                        'role_id' => $_POST['data']['role_id']
                    );

                    $this->user_mod->update($data_user, $user_id);
                    $this->user_mod->update_user_role($user_role_data, $user_id);

                    $flash_msgs = array('flash_msgs' => 'Your profile has been update successfully');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'users/customer_edit_profile/' . $this->session->userdata['userData']['session_user_id'], 'location', '301'); // 301 redirected

                }
            }
        }

        $is_customer_number_required = $this->setting_mod->is_customer_number_required($this->session->userdata['userData']['session_corporate_account_id']);
        $data['is_customer_number_required'] = $is_customer_number_required;

        $data['data'] = $user_data;
        $data['user_id'] = $user_id;

        // Send $data array() to edit
        $data['content'] = $this->load->view('users/customer_edit_profile', $data, true);
        // Use Layout
        $this->load->view('layout/customer_layout', $data);
    }

    /* Customer Chanage Password*/
    function customer_change_password()
    {

        if (!$this->session->userdata['userData']['session_corporate_account_id']) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '');

        // Define Data array
        $data = array(
            'page_title' => 'Change User Password - bsSelfBusiness System',
            'sidebar_menu_title' => 'User Management',
            'sidebar_menu' => 'Change User Password'
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


        $user_data = $this->user_mod->get_user_by_id($this->session->userdata['userData']['session_user_id']);


        if (isset($_POST['OkSaveData'])) {

            $this->form_validation->set_rules('data[password]', 'Password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                if (md5(trim($_POST['data']['password'])) == trim($user_data->password)) {
                    $data_user = array(
                        'password' => md5(trim($_POST['data']['newpassword1'])),
                        'status' => 1,
                        'updated_by' => $this->session->userdata['userData']['session_user_id'],
                        'updated_date' => date('Y-m-d H:i:s')
                    );

                    $this->user_mod->update($data_user, $this->session->userdata['userData']['session_user_id']);
                    $flash_msgs = array('flash_msgs' => 'Your password has been updated successfully');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'users/customer_change_password/' . $this->session->userdata['userData']['session_user_id'], 'location', '301'); // 301 redirected

                } else {

                    $flash_msgs = array('flash_msgs' => 'Your Current password is not matching with our system. Please try again!');
                    $this->session->set_userdata($flash_msgs);
                    redirect(base_url() . 'users/customer_change_password/' . $this->session->userdata['userData']['session_user_id'], 'location', '301'); // 301 redirected

                }
            }
        }

        // Send $data array() to edit
        $data['content'] = $this->load->view('users/customer_change_password', $data, true);
        // Use Layout
        $this->load->view('layout/customer_layout', $data);
    }


}