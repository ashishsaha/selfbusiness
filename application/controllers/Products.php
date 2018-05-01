<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller
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
    }

    public function index()
    {
        if (!$this->session->userdata['userData']['session_user_id'] || $this->session->userdata['userData']['session_user_id'] != 1) {
            redirect('users/login');
        }
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', 'products');

        // SELECT ALL product list
        $product_data = $this->product_mod->get_all_products();

        // Define Data array
        $data = array(
            'page_title' => 'bsSelfBusiness System - All product List',
            'sidebar_menu_title' => 'Setting Management',
            'sidebar_menu' => 'Product List',
            'product_data' => $product_data
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
            $product_id = $_POST['data']['id'];
            unset($_POST['data']['id']);
            
            $this->form_validation->set_rules('data[name]', 'Product Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $validation_error = validation_errors();
                $data['validation_error'] = $validation_error;
            } else {
                $_POST['data']['status'] = 1;
                $brands = json_encode($_POST['data']['brand_id']);
                $_POST['data']['brand_id'] = $brands;
                //echo '<pre>';print_r($_POST);die();
                if($product_id){
                    $this->product_mod->update_product($_POST['data'], $product_id);
                    $msgs = 'Product has been updated successfully';
                    
                }else{
                    $add_rate = $this->product_mod->add_product($_POST['data']);
                    $msgs = 'Product has been added successfully';
                }
                
                $flash_msgs = array('flash_msgs' => $msgs, 'alerts' => 'success');
                $this->session->set_userdata($flash_msgs);
                redirect(base_url() . 'products', 'location', '301'); // 301 redirected
            }
        }
        
        $data['brands']  = $this->brand_mod->get_all_brands();
        //echo '<pre>'; print_r($data['brands']); die();
        
        // Send $data array() to index page
        $data['content'] = $this->load->view('products/index', $data, true);
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
    
    /*
     * Select info by ajax
     * */
    public function getinfo(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $product_id = $this->input->post('id');

            $product_arr = $this->product_mod->get_product_by_id($product_id);
            //print_r($transaction_arr); exit();

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: ' . date('r', time() + (86400 * 365)));
            header('Content-type: application/json');

            echo json_encode(array(
                'id' => $product_arr->id,
                'name' => $product_arr->name,
                'brand_id' => json_decode($product_arr->brand_id),
                'status' => $product_arr->status
            ));
            exit();
        }
    }

}