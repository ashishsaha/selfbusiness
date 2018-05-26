<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
	function __construct()
	{
		parent::__construct();
		$this->load->model('invoice_mod');
		$this->load->model('transaction_mod');
	}

	public function index() /*Super admin, admin and staff dashboard*/
	{
		if(!$this->session->userdata['userData']['session_user_id']){
			redirect('users/login');
		}
		$this->session->unset_userdata('active_menu');
		$this->session->set_userdata('active_menu', 'dashboard');


        $total_today_purchase_arr = $this->invoice_mod->today_total_invoice(1); // today total purchase
        $total_today_purchase = empty($total_today_purchase_arr[0]->total_cost)?0.00:$total_today_purchase_arr[0]->total_cost;
        $total_today_sales_arr = $this->invoice_mod->today_total_invoice(0); // today total sales
        $total_today_sales = empty($total_today_sales_arr[0]->total_cost)?0.00:$total_today_sales_arr[0]->total_cost;
        $all_type_of_expense_arr = $this->transaction_mod->get_all_type_of_expense(); // today total sales
        //print_r($all_type_of_expense_arr); exit;

        $raised_purchase_amount_info = $this->invoice_mod->raised_amount_info(1); // purchase
        $raised_sales_amount_info = $this->invoice_mod->raised_amount_info(0); // Sales
        $raised_json_purchase_amount_info = json_encode($raised_purchase_amount_info);
        $raised_json_sales_amount_info = json_encode($raised_sales_amount_info);

		// Define Data array
		$data = array(
			'page_title' => 'Dashboard - bsSelfBusiness System',
			'sidebar_menu_title' => 'DASHBOARD'
		);

        $data['css'] = array(
            'assets/plugins/morris/morris.css'
        );
        $data['js'] = array(
            'assets/plugins/morris/morris.min.js',
            'assets/plugins/raphael/raphael-min.js'
            //'assets/pages/jquery.dashboard.js'
        );


        $data['form_validation'] = '<script type="text/javascript">
											!function($) {
											    "use strict";
												var Dashboard1 = function() {
                                                    this.$realData = []
                                                };

                                                //creates line chart
                                                Dashboard1.prototype.createLineChart = function(element, data, xkey, ykeys, labels, opacity, Pfillcolor, Pstockcolor, lineColors) {
                                                    Morris.Line({
                                                        element: element,
                                                        data: data,
                                                        xkey: xkey,
                                                        ykeys: ykeys,
                                                        labels: labels,
                                                        fillOpacity: opacity,
                                                        pointFillColors: Pfillcolor,
                                                        pointStrokeColors: Pstockcolor,
                                                        behaveLikeLine: true,
                                                        gridLineColor: "#eef0f2",
                                                        hideHover: "auto",
                                                        resize: true, //defaulted to true
                                                        pointSize: 0,
                                                        lineColors: lineColors
                                                    });
                                                },

                                                //creates Donut chart
                                                Dashboard1.prototype.createDonutChart = function(element, data, colors) {
                                                    Morris.Donut({
                                                        element: element,
                                                        data: data,
                                                        resize: true, //defaulted to true
                                                        colors: colors
                                                    });
                                                },

                                                Dashboard1.prototype.init = function() {
                                                //create line chart


                                                //var $data = '.$raised_json_purchase_amount_info.';
                                                //this.createLineChart("morris-line-example", $data, "calender_month", ["raised_purchase_cost"], ["Raised Purchase Cost"],["0.9"],["#999999"], ["#188ae2"]);

                                                    //creating donut chart
                                                    var  total_today_purchase = parseInt("'.$total_today_purchase.'");
                                                    var  total_today_sales = parseInt("'.$total_today_sales.'");
                                                    var $donutData = [
                                                        {label: "Total Today Purchase", value: total_today_purchase },
                                                        {label: "Total Today Sales", value: total_today_sales}
                                                    ];
                                                    this.createDonutChart("morris-donut-example", $donutData, ["#ff8acc", "#5b69bc"]);
                                                },
                                                //init
                                                $.Dashboard1 = new Dashboard1, $.Dashboard1.Constructor = Dashboard1
											}(window.jQuery),
											//initializing
                                            function($) {
                                                "use strict";
                                                $.Dashboard1.init();
                                            }(window.jQuery);
										</script>';

		// Send $data array() to index page
		$data['content'] = $this->load->view('dashboard/index', $data, true);
		// Use Layout
		$this->load->view('layout/admin_layout', $data);

	}

}