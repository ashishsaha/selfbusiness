<div class="row">
    <div class="col-sm-12">
        <?php if (isset($validation_error)) { ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php if ($validation_error != '') {
                    echo $validation_error;
                } ?>
            </div>
        <?php } ?>

        <?php if ($this->session->userdata('flash_msgs')) { ?>
            <div class="alert alert-<?php echo $this->session->userdata('alerts'); ?> alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $this->session->userdata('flash_msgs');
                $this->session->unset_userdata('flash_msgs'); ?>
            </div>
        <?php } ?>

        <form action="<?php echo base_url(); ?>transaction/add_pay_to_employee" class="form-horizontal row-border" method="post"
              name="form1" id="form1" enctype="multipart/form-data">
            <input type="hidden" name="action" id="action" value="">
            <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
            <input type="hidden" name="option_upload" id="option_upload" value="0">

            <div class="card-box">
                <div class="row">
                    <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-arrows"></i> <?php echo $sidebar_menu;?>
                    </h4>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Employee</label>
                            <div class="col-md-9">
                                <select class="form-control required" name="data[payment_from_or_to]" id="payment_from_or_to" onchange="select_employee()" data-parsley-id="6">
                                    <option value="">Select Employee</option>
                                    <?php
                                    foreach($employee_data as $employee){?>
                                        <option value="<?php echo  $employee->id; ?>"><?php echo  $employee->full_name; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Trans Type</label>
                            <div class="col-md-9">
                                <select class="form-control required" name="data[trans_type]" id="trans_type" onchange="select_trans_type()"  data-parsley-id="6" disabled>
                                    <option value="0">Hand Cash</option>
                                    <option value="1">Bank Transaction</option>
                                    <option value="2">Cheque</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Child Account Description">Trans Date</label>
                            <div class="col-md-9">

                                <div class="input-group">
                                    <input type="text" class="form-control required" name="data[trans_date]"  value="<?php echo date("m/d/Y");?>" placeholder="mm/dd/yyyy" id="trans_date">
                                    <span class="input-group-addon bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                </div><!-- input-group -->
                                <!--<input class="form-control required" placeholder="Child Account Description" type="text" name="data[trans_date]" id="trans_date" parsley-trigger="change" value="" data-parsley-id="8">-->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Amount</label>
                            <div class="col-md-9">
                                <input class="form-control required" placeholder="Transaction Amount" type="text" name="data[amount]" id="amount" parsley-trigger="change" value="" data-parsley-id="8">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="ajaxShowDiv">

                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Child Account Description">Note</label>
                            <div class="col-md-9">
                                <textarea name="data[note]" id="note" class="form-control" style="min-height: 40px" cols="60" rows="1"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group ">
                            <label class="col-md-3 control-label" title="Child Account Description">Salary Month</label>
                            <div class="col-md-9">
                                <select class="form-control required" name="data[salary_month]" id="salary_month" data-parsley-id="6">
                                    <option value="">Select Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">&nbsp;</label>
                            <div class="col-md-9">
                                <button class="btn btn-primary waves-effect waves-light" type="submit"> Save Info
                                </button>
                                <button type="button" class="btn" onclick="javascript:pay_to_employee_cancel();">Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>


<style type="text/css">
    .form-horizontal .checkbox {
        padding-top: 0 !important;
    }
    .address_div .col-md-3{
        width: 12.5%;
    }
    .address_div .col-md-9{
        width: 87.5%;
    }
</style>


<script type="text/javascript">
    function pay_to_employee_cancel(){
        window.location.href = '<?php echo base_url();?>transaction/pay_to_employee';
    }

    function select_employee() {
        var employee_id = $('#payment_from_or_to').val();
        if (employee_id != '') {
            $('#trans_type').attr('disabled', false);
        }
        else {
            $('#trans_type').attr('disabled', true);
        }
    }

    function select_trans_type() {
        var employee_id = $('#payment_from_or_to').val();
        var trans_type = $('#trans_type').val();
        if (trans_type == 1 || trans_type == 2) {
            $.ajax({
                type: "post",
                url: "<?php echo base_url() ?>transaction/supplierbankinfo",
                data: {supplier_id: employee_id, trans_type: trans_type},
                success: function (data) {
                    $("#ajaxShowDiv").html(data);
                }
            });
        }
        else{
            $("#ajaxShowDiv").children().remove();
        }
    }

    $(document).ready(function () {
        // Date Picker
        $('#trans_date').datepicker();
        $('#trans_date').datepicker({
            autoclose: true,
            todayHighlight: true
        });
    });
</script>