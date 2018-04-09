<?php
// Constant data will be
/*
  1. Corporate account one
  2. User one 
 *
 * */
/*
// Define Data array
$data = array(
    'page_title' => 'Dashboard - Booking System',
    'sidebar_menu_title' => 'DASHBOARD'
);

// Send $data array() to index page
$data['content'] = $this->load->view('dashboard', $data, true);
// Use Layout
$this->load->view('layout/admin_layout', $data);

*/

/*
  [userData] => Array
        (
            [session_logged_in] => 1
            [session_user_id] => 4
            [session_user_full_name] => Mr. Anuran
            [session_username] => corporate@abc.com
            [session_corporate_account_name] => Booking System abd
            [session_corporate_account_email] => a@a.com
            [session_role_name] => Corporate Super Admin
            [session_role_id] => 2
            [session_corporate_account_id] => 4
        )

if(!$this->session->userdata['userData']['session_corporate_account_id']){
            redirect('users/login');
        }


 * */

/* call a model method into view
$CI =& get_instance();
$CI->load->model('MyModel');
$result= $CI->MyModel->MyMethod($parameter)->result_array();
foreach($result as $row){
    echo $row['column_name'];
}
 * */


/*function __construct()
{
    parent::__construct();

    $this->load->model('user_mod');
    $this->load->model('rate_mod');
    $this->load->model('general_mod');
    $this->load->model('setting_mod');
    $this->load->library('email');
    $this->load->library('pagination'); // pagination class
    $this->load->helper(array('form', 'url'));

    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<p>', '</p>');

    //login accesscheck
    $this->user_mod->check_loggedin();
}*/

//$role_id = $this->uri->segment(3)

// fa-info-circle
// fa-check-circle
// fa-tree

/*

<?php /* if (isset($validation_error)) { ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php  echo $validation_error; ?>
            </div>
        <?php } ?>
<?php if ($this->session->userdata('flash_msgs')) { ?>
    <div class="alert alert-info alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo $this->session->userdata('flash_msgs');
        $this->session->unset_userdata('flash_msgs'); ?>
    </div>
<?php }

        echo $this->base_url();
        echo $this->uri->segment(1);
        echo $this->router->fetch_class();

 */ ?>


<!-- $data['var_account_name'] = $this->set_account_name_var(); -->

