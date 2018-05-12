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
                                <?php if(count($buy_invoice_data) > 0){ ?>
                                &nbsp;
                                <button title="Print Report" data-tooltip="true" type="button"
                                        class="btn btn-success waves-effect waves-light"
                                        onclick="javascript:print_report();"><i class="fa fa-print"></i>&nbsp;Print Report
                                </button>
                                <?php } ?>
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
                    
                    $total_sell = 0;
                    foreach ($buy_invoice_data as $buy_invoice) {
                        
                        $total_sell += $buy_invoice->total_cost;
                        ?>
                        <tr>
                            <td><?php echo $buy_invoice->invoice_no; ?> </td>
                            <td><?php echo $buy_invoice->full_name; ?> </td>
                            <td><?php echo date("d-m-Y", strtotime($buy_invoice->created)); ?> </td>
                            <td style="text-align: right;"><?php echo $buy_invoice->total_cost; ?> </td>
                        </tr>
                        <?php
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

<!--
*
*** Print Area Start
*
-->
<?php if(count($buy_invoice_data) > 0){ ?>
<div id="print_area" style="display: none;">
    <table style="">
        <tr>
            <td style="text-align: center;">
                <header style="line-height: .52857143;">
                	<h1><?php echo $company_info->company_name; ?></h1>
                    <h2>Phone : <?php echo $company_info->contact_no; ?></h2>
                    <h3><?php echo $company_info->address; ?></h3>
                </header>
                <hr />
            </td>
        </tr>
        
        <tr>
            <td style="width: 100%;">
                <table style="width: 1000px; padding-top: 10px;">
                    <tr>
                        <td style="width: 50%;">	
                            <address style="margin-bottom: 20px;font-style: normal;line-height: 1.42857143; font-size: 20px;">
            				<strong>Customer Name:</strong> <?php echo $buy_invoice_data[0]->full_name; ?>
            				</address>			            				
                        </td>
                        <td style="width: 50%; text-align: right;">
                            <address style="text-align: right; margin-bottom: 20px;font-style: normal;line-height: 1.42857143; font-size: 20px;">
                			<strong>Date: </strong> <?php echo date('d-m-Y', strtotime($start))." to ".date('d-m-Y', strtotime($end)); ?>
            				</address>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
            <td style="height: 40px; background-color: #f5f5f5; color: #797979; border: none !important; padding: 10px 20px; border-top-left-radius: 3px; border-top-right-radius: 3px; outline: none !important; box-sizing: border-box;">
                <h2 style="font-weight: 600; margin-bottom: 0; margin-top: 0; line-height: 30px;">
                    <strong>Customer Wise Sales Report</strong>
                </h2>
            </td>
        </tr>
        
        <tr>
            <td>
                <table style="width: 1000px; border: none; margin-bottom: 20px;box-shadow: 0 0px 8px 0 rgba(0, 0, 0, 0.06), 0 1px 0px 0 rgba(0, 0, 0, 0.02);">
                    
                    <tr>
                        <td>
                            <table style="width: 1000px; margin-bottom: 10px; padding: 120px; background-color: transparent;border-spacing: 0;border-collapse: collapse; box-sizing: border-box; font-size: 20px;">
                            	<thead>
                                    <tr>
                            			<td style="border-top: 0; padding: 5px 5px 5px 20px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"><strong>Invoice No</strong></td>
                            			<td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align:center;"><strong>Selling Date</strong></td>
                            			<td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><strong>Total Cost</strong></td>
                                    </tr>
                            	</thead>
                            	<tbody>
                                    <?php foreach($buy_invoice_data as $buy_invoice){ ?>
                				    <tr>
                            			<td style="border-top: 1px solid #ebeff2; padding: 5px 5px 5px 20px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"><?php echo $buy_invoice->invoice_no; ?></td>
                            			<td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;"><?php echo date("d-m-Y", strtotime($buy_invoice->created)); ?></td>
                            			<td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><?php echo $buy_invoice->total_cost; ?></td>
                            		</tr>
                                    <?php } ?>
                                     
                            		<tr>
                            			<td style="border-top: 2px solid; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"></td>
                            			<td style="border-top: 2px solid; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><strong>Accumulated Sales: </strong></td>
                            			<td style="border-top: 2px solid; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><?php echo number_format($total_sell,2);?></td>
                            		</tr>
                                    
                                    
                            	</tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
            <td style="text-align: right; width: 100%; padding-top: 100px;">
                <h2>Thank You!</h2>
            </td>
        </tr>

    </table>
</div>

<script type="text/javascript">
    
    function print_report() {
        var mywindow = window.open('', 'PRINT', 'height=600,width=800');
        var printContents = document.getElementById('print_area').innerHTML;
			//var originalContents = document.body.innerHTML;
			//document.body.innerHTML = printContents;
        mywindow.document.write(printContents);
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/
    
        mywindow.print();
        mywindow.close();
    
        return true;
    }
</script>
<?php }?>
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