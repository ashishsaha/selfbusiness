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
                <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-tree"></i> Income Report
                </h4>
            </div>
            <form action="<?php echo base_url(); ?>reports/income" class="form-horizontal row-border" method="post"
                  name="form1" id="form1" enctype="multipart/form-data">
                <input type="hidden" name="action" id="action" value="">
                <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Income Type</label>

                            <div class="col-md-9">
                                <select class="form-control required" name="child_account_id" id="child_account_id" data-parsley-id="6">
                                    <option value="" <?php if($child_account_id == ''){?>selected="selected" <?php } ?>>Select Income Type</option>
                                    <option value="all" <?php if($child_account_id == 'all'){?>selected="selected" <?php } ?>>All</option>
                                    <?php
                                    foreach ($childs_data as $child) {
                                        ?>
                                        <option value="<?php echo $child->id; ?>" <?php if($child_account_id == $child->id){?>selected="selected" <?php } ?>><?php echo $child->name; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

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



            <table <?php if (count($income_data) > 0){ ?>id="datatable-buttons" <?php } ?>
                   class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="width: 30%" title="Transaction Type">Transaction Type</th>
                    <th title="Transaction Date">Transaction Date</th>
                    <th title="Created">Date</th>
                    <th style="width: 16%" title="Transaction Amount">Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($income_data) > 0) {
                    $count = 1;
                    $total_amount = 0;
                    foreach ($income_data as $data) {
                        
                        if($data->trans_type == 0){
                            $trans_type = '<span class="label label-success">Hand Cash</span>';
                        }elseif($data->trans_type == 1){
                            $trans_type = '<span class="label label-info">Bank Transaction</span>';
                        }else{
                            $trans_type = '<span class="label label-info">Cheque</span>';
                        }
                        
                        $total_amount += $data->amount;
                        ?>
                        <tr>
                            <td><?php echo $trans_type; ?> </td>
                            <td><span class="label label-info"><?php echo date("Y-m-d", strtotime($data->trans_date)); ?></span></td>
                            <td><span class="label label-info"><?php echo date("Y-m-d", strtotime($data->created)); ?></span></td>
                            <td><?php echo number_format($data->amount,2); ?></td>
                        </tr>
                        <?php $count++;
                    }
                    ?>

                    <tr>
                        <td colspan="3" style="text-align:right; margin-right: 80px"><b>Total Amount</b></td>
                        <td><b><?php echo number_format($total_amount,2);?></b></td>
                    </tr>
                    <?php
                } else { ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">Sorry! there is no transaction for this selected Expense Type.</td>
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
    jQuery(document).ready(function ($) {
        $('#date-range').datepicker({
            toggleActive: true,
            zIndexOffset: 999999
        });
    });
</script>