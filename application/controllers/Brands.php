<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brands extends CI_Controller
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
        $this->load->model('brand_mod');
    }

    public function index()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'brands');

        // SELECT ALL brand list
        $brand_data = $this->brand_mod->get_all_brands();

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All brand List',
            'sidebar_menu_title' => 'Setting Management',
            'sidebar_menu' => 'Brand List',
            'brand_data' => $brand_data
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
            $brand_id = $_POST['data']['id'];
            unset($_POST['data']['id']);
            
            $this->form_validation->set_rules('data[name]', 'Brand Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                $_POST['data']['status'] = 1;
                if($brand_id){
                    $this->brand_mod->update_brand($_POST['data'], $brand_id);
                    $msgs = 'Brand has been updated successfully';
                    
                }else{
                    $add_rate = $this->brand_mod->add_brand($_POST['data']);
                    $msgs = 'Brand has been added successfully';
                }
                
                $flash_msgs = array('flash_msgs' => $msgs, 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'brands', 'location', '301'); // 301 redirected
            }
        }

        // Send $data array() to index page
        $data['content'] = $this->load->view('brands/index', $data, true);
        // Use Layout
        $this->load->view('layout/admin_layout', $data);
    }

    /* Brand Status*/
    public function status()
    {
        if (!$this->session->userdata['userData']['session_user_id'] ) {
            redirect('users/login');
        }

        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'brands');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $brand_id = $this->input->post('id');

            if ($this->input->post('status') == 1) {
                $status = 0;
                $_POST['data']['status'] = $status;
                $status_result = 0;
            } else {
                $status = 1;
                $_POST['data']['status'] = $status;
                $status_result = 1;
            }

            $update = $this->brand_mod->update_brand($_POST['data'], $brand_id);

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
     * Delete Brand
     * */
    public function delete(){
        if (!$this->session->userdata['userData']['session_user_id']) {
            redirect('users/login');
        }
        $brand_id = $this->uri->segment(3);
        $this->brand_mod->delete_brand($brand_id);

        $flash_msgs = array('flash_msgs' => 'The selected brand has been deleted successfully', 'alerts' => 'success');
        $this->session->set_userdata($flash_msgs);
        redirect(base_url() . 'brands', 'location', '301'); // 301 redirected
    }
    
    /*
     * Select info by ajax
     * */
    public function getinfo(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $brand_id = $this->input->post('id');

            $brand_arr = $this->brand_mod->get_brand_by_id($brand_id);
            //print_r($transaction_arr); exit();

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: ' . date('r', time() + (86400 * 365)));
            header('Content-type: application/json');

            echo json_encode(array(
                'id' => $brand_arr->id,
                'name' => $brand_arr->name,
                'status' => $brand_arr->status
            ));
            exit();
        }
    }

    /*
     * Select info by ajax
     * */
    public function getbrandinfo(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $product_id = $this->input->post('id');

            $transaction_arr = $this->transaction_mod->get_transaction_info_by_id($product_id);
            //print_r($transaction_arr); exit();

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: ' . date('r', time() + (86400 * 365)));
            header('Content-type: application/json');

            echo json_encode(array(
                'id' => $transaction_arr->id,
                'payment_from_or_to' => $transaction_arr->payment_from_or_to,
                'ref_invoice_no' => $transaction_arr->ref_invoice_no,
                'trans_type' => $transaction_arr->trans_type,
                'trans_date' => date("m/d/Y", strtotime($transaction_arr->trans_date)),
                'bank_account_from' => $transaction_arr->bank_account_from,
                'bank_account_to' => $transaction_arr->bank_account_to,
                'checque_no' => $transaction_arr->checque_no,
                'salary_month' => $transaction_arr->salary_month,
                'amount' => $transaction_arr->amount,
                'note' => $transaction_arr->note
            ));
            exit();
        }
    }

}