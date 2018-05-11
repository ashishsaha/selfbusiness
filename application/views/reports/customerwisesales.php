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
                <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-tree"></i> Customer Wise Sales Report
                </h4>
            </div>
            <form action="<?php echo base_url(); ?>reports/customer_wise_sales" class="form-horizontal row-border" method="post"
                  name="form1" id="form1" enctype="multipart/form-data">
                <input type="hidden" name="action" id="action" value="">
                <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Customer</label>

                            <div class="col-md-9">
                                <select class="form-control required" name="payment_from_or_to"
                                        id="payment_from_or_to" data-parsley-id="6">
                                    <option value="" <?php if($customer_id == ''){?>selected="selected" <?php } ?>>Select Customer</option>
                                    <?php
                                    foreach ($customer_data as $customer) {
                                        ?>
                                        <option
                                            value="<?php echo $customer->id; ?>" <?php if($customer_id == $customer->id){?>selected="selected" <?php } ?>><?php echo $customer->full_name; ?></option>
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



            <table <?php if (count($buy_invoice_data) > 0){ ?>id="datatable-buttons" <?php } ?>
                   class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="width: 11%">Invoice No</th>
                    <th style="width: 30%" title="Customer Name">Customer Name</th>
                    <th style="width: 12%" title="Selling Date">Selling Date</th>
                    <th style="width: 16%; text-align: right;" title="Total Cost">Total Cost</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($buy_invoice_data) > 0) {
                    $count = 1;
                    $total_sell = 0;
                    foreach ($buy_invoice_data as $buy_invoice) {
                        if ($buy_invoice->status == '1') {
                            $status = '<div class="active-invoice">
														<a  onclick="invoice_status(' . $buy_invoice->id . ',' . $buy_invoice->status . ')" id="' . $buy_invoice->id . '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <span class="label label-success">Active</span> </a>
													 </div>';
                        } elseif ($buy_invoice->status == '0') {
                            $status = '<div class="deactive-invoice">
														<a  onclick="invoice_status(' . $buy_invoice->id . ',' . $buy_invoice->status . ')" id="' . $buy_invoice->id . '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <span class="label label-inverse">Inactive</span> </a>
													 </div>';
                        }
                        $total_sell += $buy_invoice->total_cost;
                        ?>
                        <tr>
                            <td><?php echo $buy_invoice->invoice_no; ?> </td>
                            <td><?php echo $buy_invoice->full_name; ?> </td>
                            <td><?php echo date("Y-m-d", strtotime($buy_invoice->created)); ?> </td>
                            <td style="text-align: right;"><?php echo $buy_invoice->total_cost; ?> </td>
                        </tr>
                        <?php $count++;
                    }
                    ?>

                    <tr>
                        <td colspan="3" style="text-align:right; margin-right: 80px"><b>Accumulated Sales</b></td>
                        <td style="text-align: right;"><b><?php echo number_format($total_sell,2);?></b></td>
                    </tr>
                    <?php
                } else { ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">Sorry! there is no available records.</td>
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