<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller
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
        $this->load->model('setting_mod');
        $this->load->library('pagination'); // pagination class
        $this->load->helper(array('form', 'url'));
        $this->load->helper('file');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p>', '</p>');

        //login accesscheck
        //$this->user_mod->check_loggedin();

        // upload data image file
        $config['upload_path'] = document_url . 'uploads/settings/';
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

    /* Update */
    function companysettings()
    {
        if (!$this->session->userdata['userData']['session_user_id']) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'settings');

        // Define Data array
        $data = array(
            'page_title' => 'Update Company Settings',
            'sidebar_menu_title' => 'Setting Management',
            'sidebar_menu' => 'Update Company Setting'
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

        //$setting_id = $this->uri->segment(3);
        $setting_id = 1;

        if (isset($_POST['OkSaveData'])) {

            $upload_validation_error = '';
            $data['setting_id'] = $setting_id;

            $this->form_validation->set_rules('data[company_name]', 'The company name value', 'trim|required');
            $this->form_validation->set_rules('data[contact_no]', 'Contact number value', 'trim|required');
            $this->form_validation->set_rules('data[address]', 'Address value', 'trim|required');
            $this->form_validation->set_rules('data[proprietor]', 'Proprietor value', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {

                $data_setting = array(
                    'company_name' => $_POST['data']['company_name'],
                    'contact_no' => $_POST['data']['contact_no'],
                    'address' => $_POST['data']['address'],
                    'proprietor' => $_POST['data']['proprietor'],
                    'bank_account_name' => json_encode($_POST['bank_account_name']),
                    'bank_account_number' =>  json_encode($_POST['bank_account_number']),
                    'bank_name' =>  json_encode($_POST['bank_name']),
                    'bank_branch' =>  json_encode($_POST['bank_branch']),
                    'bank_location' =>  json_encode($_POST['bank_location']),
                    'updated' => date('Y-m-d H:i:s')
                );

                $this->setting_mod->update_companysetup($data_setting, $setting_id);
                $flash_msgs = array('flash_msgs' => 'Company Setup updated successfully', 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'settings/companysettings', 'location', '301'); // 301 redirected
            }
        }

        if (!empty($setting_id)) {
            $setting_data = $this->setting_mod->get_setting_by_id($setting_id);
        }


        $data['data'] = $setting_data;
        $data['setting_id'] = $setting_id;

        // Send $data array() to add
        $data['content'] = $this->load->view('settings/companysettings', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

}
