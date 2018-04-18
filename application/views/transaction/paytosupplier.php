<div class="row">
    <div class="col-sm-12">
        <?php if ($this->session->userdata('flash_msgs')) { ?>
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $this->session->userdata('flash_msgs');
                $this->session->unset_userdata('flash_msgs'); ?>
            </div>
        <?php } ?>

        <div class="card-box table-responsive">
            <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-tree"></i> <?php echo $sidebar_menu; ?>&nbsp;
                &nbsp;<span id="status_msg" class="text-success"></span>
                <ul class="list-status">
                    <!--<li><i class="fa fa-check-circle text-success"></i> Active</li>
                    <li><i class="fa fa-check-circle text-unsuccess"></i> Inactive</li>-->
                    <li>
                        <button title="Add Pay To Supplier" data-tooltip="true" type="button"
                                class="btn btn-success waves-effect waves-light"
                                onclick="javascript:add_pay_to_supplier();"><i
                                class="fa fa-plus-circle"></i>&nbsp;<?php echo $add_button;?>
                        </button>
                    </li>
                </ul>
            </h4>
            
            <div id="adding_form" class="row">
                <div class="col-sm-12">
                    <form action="<?php echo base_url(); ?>transaction/pay_to_supplier" class="form-horizontal row-border" method="post" name="form1" id="form1" enctype="multipart/form-data" novalidate="">
                        <input type="hidden" name="action" id="action" value="">
                        <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
                        <input type="hidden" name="option_upload" id="option_upload" value="0">
                        <input id="selected_id" value="1" type="hidden" />
                        <input type="hidden" name="data[id]" id="id" value="">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Supplier</label>
                                        <div class="col-md-9">
                                            <select class="form-control required" name="data[payment_from_or_to]" id="payment_from_or_to" onchange="select_supplier()" data-parsley-id="6">
                                                <option value="">Select Supplier</option>
                                                <?php
                                                foreach($supplier_data as $supplier){?>
                                                    <option value="<?php echo  $supplier->id; ?>"><?php echo  $supplier->full_name; ?></option>
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
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-6" style="text-align: right">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">&nbsp;</label>
                                        <div class="col-md-9">
                                            <button type="button" class="btn" onclick="javascript:add_pay_to_supplier_cancel();">Cancel
                                            </button>
                                            <button class="btn btn-primary waves-effect waves-light" id="submitButton" type="submit"> Save Info
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
                                                
            <?php
            //print_r($home_cost_transaction_data);
            ?>
            <table <?php if (count($home_cost_transaction_data) > 0){ ?>id="datatable-buttons"<?php } ?>
                   class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th title="Supplier Name">Supplier Name</th>
                    <th title="Transaction through">Transaction Type</th>
                    <th title="Transaction Amount">Amount</th>
                    <th title="Transaction Date">Transaction Date</th>
                    <th style="width: 10%">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($home_cost_transaction_data) > 0) {
                    $count = 1;
                    foreach ($home_cost_transaction_data as $transaction_data) {

                        if($transaction_data->trans_type == 0){
                            $trans_type = '<span class="label label-success">Hand Cash</span>';
                        }elseif($transaction_data->trans_type == 1){
                            $trans_type = '<span class="label label-info">Bank Transaction</span>';
                        }else{
                            $trans_type = '<span class="label label-info">Cheque</span>';
                        }
                        ?>
                        <tr id="trans_<?php echo $transaction_data->id; ?>">
                            <td><?php echo $transaction_data->full_name; ?> </td>
                            <td><?php echo $trans_type; ?> </td>
                            <td><?php echo number_format($transaction_data->amount,2); ?></td>
                            <td><span class="label label-info"><?php echo date("Y-m-d", strtotime($transaction_data->trans_date)); ?></span></td>
                            <td class="actions">
                                <button title="Update" data-tooltip="true" type="button"
                                        class="on-default edit-row" onclick="javascript:edit_pay_to_supplier(<?php echo $transaction_data->id; ?>);">
                                    <i class="fa fa-edit"></i></button>
                                &nbsp;

                                <button title="Delete Product" data-tooltip="true" type="button"
                                        class="on-default remove-row" data-toggle="modal"
                                        data-target=".bs-example-modal-sm<?php echo $transaction_data->id; ?>">
                                    <i class="fa fa-trash"></i></button>
                                <div
                                    class="modal fade bs-example-modal-sm<?php echo $transaction_data->id; ?>"
                                    tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Product
                                                    Delete</h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you confirm to delete this transaction?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal"><i
                                                        class="fa fa-times-circle"
                                                        aria-hidden="true"></i> Close
                                                </button>
                                                <button type="button"
                                                        class="btn btn-danger waves-effect waves-light"
                                                        onclick="delete_transaction('<?php echo $transaction_data->id; ?>')">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                    Confirm Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php $count++;
                    }
                } else { ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">No record found!</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div><!-- end col -->
</div>

<script type="text/javascript">
    
    function add_pay_to_supplier() {
        $("#adding_form").show(400);
        $("#ajaxShowDiv").html('');
        $("#id").val('');
        $("#note").val('');
        $("#amount").val('');
        var d = new Date();
        var trans_date = ("0" + (d.getMonth() + 1)).slice(-2) + "/" + ("0" + d.getDate()).slice(-2) + "/" + d.getFullYear();
        $("#trans_date").val(trans_date);
        $('#form1').attr('action', '<?php echo base_url(); ?>transaction/pay_to_supplier');
        $("#submitButton").text("Save Info");
    }

    function add_pay_to_supplier_cancel() {
        $("#adding_form").hide(400);
    }
    
    function select_supplier() {
        var supplier_id = $('#payment_from_or_to').val();
        if (supplier_id != '') {
            $('#trans_type').attr('disabled', false);
        }
        else {
            $('#trans_type').attr('disabled', true);
        }
    }

    function select_trans_type() {
        var supplier_id = $('#payment_from_or_to').val();
        var trans_type = $('#trans_type').val();
        if (trans_type == 1 || trans_type == 2) {
            $.ajax({
                type: "post",
                url: "<?php echo base_url() ?>transaction/supplierbankinfo",
                data: {supplier_id: supplier_id, trans_type: trans_type},
                success: function (data) {
                    $("#ajaxShowDiv").html(data);
                }
            });
        }
        else{
            $("#ajaxShowDiv").children().remove();
        }
    }
    
    function edit_pay_to_supplier(id) {
        $("#id").val('');
        $("#amount").val('');
        $("#note").val('');
        $("#trans_date").val('');
        $('#trans_type').attr('disabled', false);
        var selected_id = $("#selected_id").val();
        $("#trans_"+selected_id).css("background","none");
        $('select#trans_type option').removeAttr("selected");
        $('select#payment_from_or_to option').removeAttr("selected");
        
        $("#ajaxShowDiv").html('');
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>transaction/getinfo',
            dataType: 'json',
            data: {'id': id},
            success: function (data, textStatus, XMLHttpRequest) {
                var bank_account_from_val = data.bank_account_from;
                var bank_account_to_val = data.bank_account_to;
                var checque_no_val = data.checque_no;
                
                $("#adding_form").show(400);
                var payment_from_or_to = data.payment_from_or_to;
                $("#payment_from_or_to option[value='" + payment_from_or_to + "']").attr('selected', true);
                var trans_type_val = data.trans_type;
                $("#trans_type option[value='" + trans_type_val + "']").attr('selected', true);
                
                if(bank_account_from_val || bank_account_to_val){
                    var selected_val = '';
                    if(bank_account_from_val){
                        selected_val = 'selected="selected"';
                    }
                    var str = '<div class="col-md-6 col-sm-6">';
                    str += '<div class="form-group">';
                    str += '<label class="col-md-3 control-label">Company Account</label>';
                    str += '<div class="col-md-9">';
                    str += '<select class="form-control" name="data[bank_account_from]" id="bank_account_from" data-parsley-id="6">';
                    str += '<option value="">N/A</option>';
                    str += '<option value="'+bank_account_from_val+'" '+selected_val+'>'+bank_account_from_val+'</option>';
                    str += '</select>';
                    str += '</div>';
                    str += '</div>';
                    str += '</div>';
                    
                    str += '<div class="col-md-6 col-sm-6">';
                    str += '<div class="form-group">';
                    
                    if(parseInt(trans_type_val) == 2){
                        str += '<label class="col-md-3 control-label">Check No</label>';
                        str += '<div class="col-md-9">';
                        str += '<input class="form-control" placeholder="Check Number" type="text" name="data[checque_no]" id="checque_no" parsley-trigger="change" value="'+checque_no_val+'" data-parsley-id="10">';;
                        str += '</div>';
                    }else{
                        var selected_val = '';
                        if(bank_account_to_val){
                            selected_val = 'selected="selected"';
                        }
                        str += '<label class="col-md-3 control-label">Supplier Account</label>';
                        str += '<div class="col-md-9">';
                        str += '<select class="form-control" name="data[bank_account_to]" id="bank_account_to" data-parsley-id="6">';
                        str += '<option value="">N/A</option>';
                        str += '<option value="'+bank_account_to_val+'" '+selected_val+'>'+bank_account_to_val+'</option>';
                        str += '</select>';
                        str += '</div>';
                          
                    }
                    str += '</div>';
                    str += '</div>';
                    
                    $("#ajaxShowDiv").html(str);
                }
                
                $("#id").val(data.id);
                $("#amount").val(data.amount);
                $("#note").val(data.note);
                var trans_date= data.trans_date;
                $("#trans_date").val(trans_date);
                $('#form1').attr('action', '<?php echo base_url(); ?>transaction/pay_to_supplier');
                //$('#form1').append("<input type='hidden' name='edit' value='"+id+"'/>");
                $("#submitButton").text("Update Info");
                $("#trans_"+id).addClass("rowBg").css("background","#EAF1FB");
                $("#selected_id").val(id);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                //$('#grid_12').removeBlockMessages().blockMessage('Error while contacting server, please try again', {type: 'error'});
            }
        });
    }    
    /*
    function add_pay_to_supplier() {
        window.location.href = '<?php echo base_url();?>transaction/add_pay_to_supplier/';
    }
    
    function edit_pay_to_supplier(id) {
        window.location.href = '<?php echo base_url();?>transaction/edit_pay_to_supplier/' + id;
    }
    */

    function delete_transaction(id) {
        window.location.href = '<?php echo base_url();?>transaction/delete/paytosupplier/' + id;
    }

    $(document).ready(function () {
        $("#adding_form").hide();
        $('[data-tooltip="true"]').tooltip();
        $(document).ready(function () {
            $('#datatable-buttons').DataTable({
                "order": [
                    [ 3, "desc" ]
                ]
            });
        });

        // Date Picker
        $('#trans_date').datepicker();
        $('#trans_date').datepicker({
            autoclose: true,
            todayHighlight: true
        });
    });
</script>