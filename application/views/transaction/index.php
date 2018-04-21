<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <button onclick="pay_to_supplier()" title="Please click here for paying to your supplier" class="btn btn-block btn-success waves-effect waves-light btn-lg m-b-5"><i class="zmdi zmdi-local-atm"></i>&nbsp;Supplier payment</button>
                </div>
                <div class="col-md-6 col-sm-6">
                    <button onclick="pay_to_labour()" title="Please click here for paying to your labour" class="btn btn-block btn-success waves-effect waves-light btn-lg m-b-5"><i class="zmdi zmdi-local-atm"></i>&nbsp;Labor bill</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <button onclick="pay_to_employee()" title="Please click here for paying to your employee" class="btn btn-block btn-success waves-effect waves-light btn-lg m-b-5"><i class="zmdi zmdi-local-atm"></i>&nbsp;Employee salary</button>
                </div>
                <div class="col-md-6 col-sm-6">
                    <button onclick="daily_cost()" title="Please click here for daily (ex: tea bill) cost" class="btn btn-block btn-success waves-effect waves-light btn-lg m-b-5"><i class="zmdi zmdi-local-atm"></i>&nbsp;Daily cost</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <button onclick="mill_cost()" title="Please click here for shop related cost" class="btn btn-block btn-success waves-effect waves-light btn-lg m-b-5"><i class="zmdi zmdi-local-atm"></i>&nbsp;Shop related cost</button>
                </div>
                <div class="col-md-6 col-sm-6">
                    <button onclick="home_cost()" title="Please click here for home cost" class="btn btn-block btn-success waves-effect waves-light btn-lg m-b-5"><i class="zmdi zmdi-local-atm"></i>&nbsp;Home cost</button>
                </div>
            </div>
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
    function  pay_to_supplier() {
        window.location.href = '<?php echo base_url();?>transaction/pay_to_supplier/';
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