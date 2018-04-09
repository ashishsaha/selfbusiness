<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <button onclick="receive_from_customer()" title="Please click here for paying to your supplier" class="btn btn-block btn-primary waves-effect waves-light btn-lg m-b-5">Receive from Customer</button>
                </div>
                <!--<div class="col-md-6 col-sm-6">
                    <button onclick="pay_to_labour()" title="Please click here for paying to your labour" class="btn btn-block btn-info waves-effect waves-light btn-lg m-b-5">Labor Bill</button>
                </div>-->
            </div>
            <!--<div class="row">
                <div class="col-md-6 col-sm-6">
                    <button onclick="pay_to_employee()" title="Please click here for paying to your employee" class="btn btn-block btn-warning waves-effect waves-light btn-lg m-b-5">Employee Bill</button>
                </div>
                <div class="col-md-6 col-sm-6">
                    <button onclick="daily_cost()" title="Please click here for daily cost" class="btn btn-block btn-success waves-effect waves-light btn-lg m-b-5">Other/Daily Cost</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <button onclick="mill_cost()" title="Please click here for mill cost" class="btn btn-block btn-purple waves-effect waves-light btn-lg m-b-5">Mill Cost</button>
                </div>
                <div class="col-md-6 col-sm-6">
                    <button onclick="home_cost()" title="Please click here for home cost" class="btn btn-block btn-inverse waves-effect waves-light btn-lg m-b-5">Home Cost</button>
                </div>
            </div>-->
        </div>
    </div><!-- end col -->
</div>
<style type="text/css">
    .col-md-6 .btn{
        line-height: 100px;
        font-size: 34px;
    }
</style>
<script type="text/javascript">
    function  receive_from_customer() {
        window.location.href = '<?php echo base_url();?>transaction/receive_from_customer/';
    }

    function pay_to_labour() {
        window.location.href = '<?php echo base_url();?>transaction/labor_cost/';
    }

    function pay_to_employee() {
        window.location.href = '<?php echo base_url();?>transaction/pay_to_employee/';
    }

    function daily_cost() {
        window.location.href = '<?php echo base_url();?>transaction/daily_cost/';
    }

    function mill_cost() {
        window.location.href = '<?php echo base_url();?>transaction/mill_cost/';
    }

    function home_cost() {
        window.location.href = '<?php echo base_url();?>transaction/home_cost/';
    }

    $(document).ready(function () {
        $('[data-tooltip="true"]').tooltip();
    });
</script>