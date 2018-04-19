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

<form action="<?php echo base_url(); ?>customers/edit/<?php echo $customer_id; ?>" class="form-horizontal row-border"
      method="post"
      name="form1" id="form1" enctype="multipart/form-data">
<input type="hidden" name="action" id="action" value="">
<input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
<input type="hidden" name="option_upload" id="option_upload" value="0">

<div class="card-box">
<div class="row">
    <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-arrows"></i> Update Customer/Supplier
    </h4>
</div>


<div class="panel panel-default" id="promotion_items" style="margin-bottom: 0">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><i
                    class="fa fa-angle-double-right"></i>&nbsp;General Info</a>
        </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in">
        <div class="panel-body">

            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Full Name</label>

                        <div class="col-md-9">
                            <input class="form-control required" placeholder="Customer/Supplier Name"
                                   type="text"
                                   name="data[full_name]" id="full_name" parsley-trigger="change"
                                   value="<?php echo $customer_data->full_name; ?>"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Contact No</label>

                        <div class="col-md-9">
                            <input class="form-control required" placeholder="Contact Number"
                                   type="text"
                                   name="data[contact_number]" id="contact_number" parsley-trigger="change"
                                   value="<?php echo $customer_data->contact_number; ?>"/>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label class="col-md-3 control-label" title="Is Customer?">Is Customer?</label>

                        <div class="col-md-9">
                            <div class="checkbox checkbox-success checkbox-single" style="margin-top: 6px;">
                                <input id="is_customer"
                                       <?php if ($customer_data->is_customer == 1){ ?>checked="checked"<?php } ?>
                                       title="Is Customer?" name="data[is_customer]"
                                       aria-label="Single checkbox Two" type="checkbox">
                                <label></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label class="col-md-3 control-label" title="Is Customer?">Is Supplier?</label>

                        <div class="col-md-9">
                            <div class="checkbox checkbox-info checkbox-single" style="margin-top: 6px;">
                                <input id="is_supplier"
                                       <?php if ($customer_data->is_supplier == 1){ ?>checked="checked"<?php } ?>
                                       title="Is Supplier?" name="data[is_supplier]"
                                       aria-label="Single checkbox Two" type="checkbox">
                                <label></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-6">
                    <div class="form-group address_div">
                        <label class="col-md-3 control-label" title="Customer Address">Address</label>

                        <div class="col-md-9">
                            <input class="form-control required" placeholder="Customer Address"
                                   type="text"
                                   name="data[address]" id="address" parsley-trigger="change"
                                   value="<?php echo $customer_data->address; ?>"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default" id="promotion_rules" style="margin-bottom: 0">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i
                    class="fa fa-angle-double-right"></i>&nbsp;Bank Account Info</a>
        </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse in">
        <div class="panel-body" id="promotion_rules_two">
            <div id="promotion_rules1">
                <div id="promo_rule_two10">
                    <div class="row">
                        <div class="col-md-12 column">
                            <table class="table table-bordered table-hover"
                                   id="bank_account_whole">
                                <thead>
                                <tr>
                                    <th class="text-center" style="text-align: left; width: 19%">
                                        &nbsp;Account Name
                                    </th>
                                    <th class="text-center" style="text-align: left; width: 19%">
                                        &nbsp;Account Number
                                    </th>
                                    <th class="text-center" style="text-align: left; width: 19%">
                                        &nbsp;Bank Name
                                    </th>
                                    <th class="text-center" style="text-align: left; width: 19%">
                                        &nbsp;Bank Branch
                                    </th>
                                    <th class="text-center" style="text-align: left; width: 19%">
                                        &nbsp;Bank Location
                                    </th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $bank_account_name     = json_decode($customer_data->bank_account_name);
                                $bank_account_number   = json_decode($customer_data->bank_account_number);
                                $bank_name     = json_decode($customer_data->bank_name);
                                $bank_branch     = json_decode($customer_data->bank_branch);
                                $bank_location     = json_decode($customer_data->bank_location);
                                $count_bank_account_name = count($bank_account_name);

                                if($count_bank_account_name>0){
                                    $k = 0;
                                for($j=0; $j<$count_bank_account_name; $j++){
                                ?>
                                <tr id='bankInfo<?php echo $j; ?>'>
                                    <td>
                                        <input class="form-control required"
                                               placeholder="Bank account name" type="text"
                                               name="bank_account_name[]"
                                               id="bank_account_name" parsley-trigger="change"
                                               value="<?php echo $bank_account_name[$j]; ?>"/>
                                    </td>
                                    <td>
                                        <input class="form-control required"
                                               placeholder="Bank account number" type="text"
                                               name="bank_account_number[]"
                                               id="bank_account_number" parsley-trigger="change"
                                               value="<?php echo $bank_account_number[$j]; ?>"/>
                                    </td>
                                    <td>
                                        <input class="form-control required"
                                               placeholder="Bank name" type="text"
                                               name="bank_name[]"
                                               id="bank_name" parsley-trigger="change"
                                               value="<?php echo $bank_name[$j]; ?>"/>
                                    </td>
                                    <td>
                                        <input class="form-control required"
                                               placeholder="Bank branch" type="text"
                                               name="bank_branch[]"
                                               id="bank_branch" parsley-trigger="change"
                                               value="<?php echo $bank_branch[$j]; ?>"/>
                                    </td>
                                    <td>
                                        <input class="form-control required"
                                               placeholder="Bank location" type="text"
                                               name="bank_location[]"
                                               id="bank_location" parsley-trigger="change"
                                               value="<?php echo $bank_location[$j]; ?>"/>
                                    </td>
                                    <td>
                                        <?php if($k > 0){?>
                                            <a id="delete_sale_row_rule_three1" onclick="removeBankInfoFunction(<?php echo $k;?>)" class="pull-right btn btn-default" style="color: red;">X</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                                    $k++;
                                    }
                                }
                                ?>
                                <tr id='bankInfo<?php echo $k; ?>'></tr>
                                </tbody>
                            </table>
                            <a id="add_bank_info_row"
                               class="add_free_gift_rule1 btn-xs btn-success pull-right"
                               style="cursor: pointer;">Add more [+]</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--<a id="add_new_promo_rule1" class="btn-xs btn-purple pull-right" style="margin-top: 5px; cursor: pointer;">Add more rule [+]</a>-->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-6" style="text-align: right; margin-top: 10px;">
        <div class="form-group">
            <label class="col-md-3 control-label">&nbsp;</label>

            <div class="col-md-9">
                <button type="button" class="btn" onclick="javascript:customer_cancel();">Cancel
                </button>
                <button class="btn btn-success waves-effect waves-light" type="submit"> Update Info
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

    .address_div .col-md-3 {
        width: 12.5%;
    }

    .address_div .col-md-9 {
        width: 87.5%;
    }
</style>
<script type="text/javascript">
    function customer_cancel() {
        window.location.href = '<?php echo base_url();?>customers';
    }

    // For multiple inventory
    var n = parseInt('<?php echo $count_bank_account_name;?>');;
    $('#add_bank_info_row').click(function () {
        $('#bankInfo'+n).html("<td>"+
            "<input class='form-control required' placeholder='Bank account name' type='text' name='bank_account_name[]' id='bank_account_name' parsley-trigger='change' value=''/>"+
            "</td>"+
            "<td>"+
            "<input class='form-control required' placeholder='Bank account number' type='text' name='bank_account_number[]' id='bank_account_number' parsley-trigger='change' value=''/>"+
            "</td>"+
            "<td>"+
            "<input class='form-control required' placeholder='Bank name' type='text' name='bank_name[]' id='bank_name' parsley-trigger='change' value=''/>"+
            "</td>"+
            "<td>"+
            "<input class='form-control required' placeholder='Bank branch' type='text' name='bank_branch[]' id='bank_branch' parsley-trigger='change' value=''/>"+
            "</td>"+
            "<td>"+
            "<input class='form-control required' placeholder='Bank location' type='text' name='bank_location[]' id='bank_location' parsley-trigger='change' value=''/>"+
            "</td>"+
            "<td><div style='float: left;'><a id='delete_inv_row" + n + "' onClick='removeBankInfoFunction(" + n + ")' class='pull-right btn btn-default' style='color: red' >X</a></div></td>");
        $('#tab_product_inventory').append('<tr id="inventory' + (n + 1) + '"></tr>');
        $('#bank_account_whole').append('<tr id="bankInfo'+ (n + 1) +'"></tr>');
        n++;
    });

    /** Delete Row **/
    function removeBankInfoFunction(n) {
        // Delete
        $("#bankInfo" + n).remove();
    }
</script>