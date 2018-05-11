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
                <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-tree"></i> Product Wise Purchase Report
                </h4>
            </div>
            <form action="<?php echo base_url(); ?>reports/product_wise_purchase" class="form-horizontal row-border" method="post"
                  name="form1" id="form1" enctype="multipart/form-data">
                <input type="hidden" name="action" id="action" value="">
                <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product</label>

                            <div class="col-md-9">
                                <select class="form-control required" name="product_id" id="product_id" data-parsley-id="6">
                                    <option value="" <?php if($product_id == ''){?>selected="selected" <?php } ?>>Select Product</option>
                                    <?php
                                    foreach ($product_data as $product) {
                                        ?>
                                        <option value="<?php echo $product->id; ?>" <?php if($product_id == $product->id){?>selected="selected" <?php } ?>><?php echo $product->name; ?></option>
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



            <table <?php if (count($invoice_product_data) > 0){ ?>id="datatable-buttons" <?php } ?>
                   class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="width: 30%" title="Supplier Name">Invoice No.</th>
                    <th style="width: 12%" title="Date">Date</th>
                    <th style="width: 12%; text-align: right;" title="Total Bosta">Total Bosta</th>
                    <th style="width: 12%; text-align: right;" title="Bosta/KG">Bosta/KG</th>
                    <th style="width: 12%; text-align: right;" title="Price/Bosta">Price/Bosta</th>
                    <th style="width: 16%; text-align: right;" title="Sub total">Sub total</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($invoice_product_data) > 0) {
                    $count = 1;
                    $total_amount = 0;
                    foreach ($invoice_product_data as $data) {
                        
                        $total_amount += $data->sub_total_price;
                        ?>
                        <tr>
                            <td><?php echo $data->invoice_no; ?> </td>
                            <td><span class="label label-info"><?php echo date("Y-m-d", strtotime($data->created)); ?></span></td>
                            <td style="text-align:right;"><?php echo $data->total_bosta; ?> </td>
                            <td style="text-align:right;"><?php echo $data->bosta_per_kg; ?></td>
                            <td style="text-align:right;"><?php echo $data->price_per_bosta; ?></td>
                            <td style="text-align:right;"><?php echo number_format($data->sub_total_price,2); ?></td>
                        </tr>
                        <?php $count++;
                    }
                    ?>

                    <tr>
                        <td colspan="5" style="text-align:right; margin-right: 80px"><b>Accumulated Purchase</b></td>
                        <td style="text-align:right;"><b><?php echo number_format($total_amount,2);?></b></td>
                    </tr>
                    <?php
                } else { ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">Sorry! there is no available records.</td>
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