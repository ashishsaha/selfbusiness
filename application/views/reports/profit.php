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


        <div class="card-box">
            <div class="row">
                <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-tree"></i> Profit Report
                </h4>
            </div>
            <form action="<?php echo base_url(); ?>reports/profit" class="form-horizontal row-border" method="post"
                  name="form1" id="form1" enctype="multipart/form-data">
                <input type="hidden" name="action" id="action" value="">
                <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">

                <?php /*<div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Supplier</label>

                            <div class="col-md-9">
                                <select class="form-control required" name="supplier_id" id="supplier_id" data-parsley-id="6">
                                    <option value="" <?php if($supplier_id == ''){?>selected="selected" <?php } ?>>Select Supplier</option>
                                    <?php
                                    foreach ($supplier_data as $supplier) {
                                        ?>
                                        <option
                                            value="<?php echo $supplier->id; ?>" <?php if($supplier_id == $supplier->id){?>selected="selected" <?php } ?>><?php echo $supplier->full_name; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>*/?>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date Range</label>

                            <div class="col-md-9">
                                <div class="input-daterange input-group" id="date-range">
                                    <input style="position: relative; z-index: 100000;" type="text" class="form-control required" name="start" value="<?php echo $start;?>"/>
                                    <span class="input-group-addon bg-primary b-0 text-white">to</span>
                                    <input type="text" class="form-control required" name="end" value="<?php echo $end;?>"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">&nbsp;</label>

                            <div class="col-md-9">
                                <button class="btn btn-success waves-effect waves-light" type="submit"><i
                                        class="fa fa-save" aria-hidden="true"></i> Report
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>



            <table <?php if (count($transaction_data) > 0){ ?>id="datatable-buttons" <?php } ?>
                   class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="width: 30%">Transaction Name</th>
                    <th style="width: 11%">Transaction Type</th>
                    <th style="width: 11%" title="Customer Name">Date</th>
                    
                    <th style="width: 12%; text-align:right;" title="Total Cost">Paid Amount</th>
                    <th style="width: 12%; text-align:right;" title="Selling Date">Received Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($transaction_data) > 0) {
                    $count = 1;
                    $total_paid_amount = 0;
                    $total_received_amount = 0;
                    
                    foreach ($transaction_data as $data) {
                       
                        if($data->parent_account_id == 3){
                            $total_paid_amount += $data->amount;
                        }else{
                            $total_received_amount += $data->amount;
                        }
                        
                        
                        if($data->trans_type == 0){
                            $trans_type = '<span class="label label-success">Hand Cash</span>';
                        }elseif($data->trans_type == 1){
                            $trans_type = '<span class="label label-info">Bank Transaction</span>';
                        }else{
                            $trans_type = '<span class="label label-info">Cheque</span>';
                        }
                        
                        
                        ?>
                        <tr>
                            <td><?php echo $data->name; ?> </td>
                            <td><?php echo $trans_type; ?> </td>
                            <td><?php echo date("Y-m-d", strtotime($data->created)); ?> </td>
                            <td style="text-align:right;"><?php echo ($data->parent_account_id == 3)?number_format($data->amount,2):"" ?> </td>
                            <td style="text-align:right;"><?php echo ($data->parent_account_id == 1)?number_format($data->amount,2):"" ?> </td>
                        </tr>
                        <?php $count++;
                    }
                    ?>

                    <tr>
                        <td colspan="3" style="text-align:right; margin-right: 80px"><b></b></td>
                        <td style="text-align:right;"><b><?php echo number_format($total_paid_amount,2);?></b></td>
                        <td style="text-align:right;"><b><?php echo number_format($total_received_amount,2);?></b></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:right; margin-right: 80px"><b>Total Profit</b></td>
                        <?php $profit = $total_received_amount - $total_paid_amount; ?>
                        <td><b><?php echo number_format($profit,2);?></b></td>
                    </tr>
                    <?php
                } else { ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">Sorry! there is no invoice transaction for this selected customer.</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>


    </div>
</div>

<style type="text/css">
    .form-horizontal .checkbox {
        padding-top: 0 !important;
    }
    .datepicker{
        top: 247px!important;
    }
</style>

<script type="text/javascript">
    function users_cancel() {
        window.location.href = '<?php echo base_url();?>users';
    }
</script>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#date-range').datepicker({
            toggleActive: true,
            zIndexOffset: 999999
        });
    });
</script>