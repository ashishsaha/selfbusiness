<div class="row">
    <div class="col-sm-12">

        <div class="card-box">
            <div class="row">
                <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-arrows"></i> Purchase Invoice Details&nbsp;
                &nbsp;<span id="status_msg" class="text-success"></span>
                <ul class="list-status" style="margin-right: 5px;">
                    <!--<li><i class="fa fa-check-circle text-success"></i> Active</li>
                    <li><i class="fa fa-check-circle text-unsuccess"></i> Inactive</li>-->
                    <li>
                        <button title="Print Invoice" data-tooltip="true" type="button"
                                class="btn btn-success waves-effect waves-light"
                                onclick="javascript:print_invoice(<?php echo $invoice_id; ?>);"><i class="fa fa-print"></i>&nbsp;Print Invoice
                        </button>
                    </li>
                </ul>
                </h4>
            </div>
            
            <div class="row">
                <div class="col-xs-12">
            		<div class="invoice-title text-center">
            			<h2><?php echo $company_info->company_name; ?></h2>
                        <h4>Phone : <?php echo $company_info->contact_no; ?></h4>
                        <h5><?php echo $company_info->address; ?></h5>
            		</div>
            		<hr>
            		<div class="row">
            			<div class="col-xs-6">
            				<address>
            				<strong>Billed To:</strong><br>
            					<?php echo $invoice_data->full_name; ?><br>
            					Phone : <?php echo $invoice_data->contact_number; ?><br>
            					<?php echo $invoice_data->address; ?>
            				</address>
            			</div>
            			<div class="col-xs-6 text-right">
            				<address>
                			<strong>Invoice:</strong><br>
            					Number : <?php echo $invoice_data->invoice_no; ?><br>
            					Date : <?php echo date("Y-m-d", strtotime($invoice_data->created)); ?>
            				</address>
            			</div>
            		</div>
            	</div>
            </div>
            
            
            <div class="row">
            	<div class="col-md-12">
            		<div class="panel panel-default">
            			<div class="panel-heading">
            				<h3 class="panel-title"><strong>Order summary</strong></h3>
            			</div>
            			<div class="panel-body">
            				<div class="table-responsive">
            					<table class="table table-condensed">
            						<thead>
                                        <tr>
                							<td><strong>Product Name</strong></td>
                							<td class="text-center"><strong>Brand Name</strong></td>
                							<td class="text-center"><strong>Total Bosta</strong></td>
                                            <td class="text-center"><strong>Bosta/KG</strong></td>
                                            <td class="text-center"><strong>Price/Bosta</strong></td>
                							<td class="text-right"><strong>Sub total</strong></td>
                                        </tr>
            						</thead>
            						<tbody>
            							<?php
                                        $count_invoice_details_data  = count($invoice_details_data);
                                        if($count_invoice_details_data > 0){
                                            foreach($invoice_details_data as $data){ ?>
            							<tr>
            								<td><?php echo $data->name; ?></td>
            								<td class="text-center"><?php echo $data->brand_name; ?></td>
            								<td class="text-center"><?php echo $data->total_bosta; ?></td>
                                            <td class="text-center"><?php echo $data->bosta_per_kg; ?></td>
                                            <td class="text-center"><?php echo $data->price_per_bosta; ?></td>
            								<td class="text-right"><?php echo $data->sub_total_price; ?></td>
            							</tr>
                                        <?php } ?>
                                        
            							<tr>
            								<td class="thick-line"></td>
            								<td class="thick-line"></td>
                                            <td class="thick-line"></td>
            								<td class="thick-line"></td>
            								<td class="thick-line text-right"><strong>Total: </strong></td>
            								<td class="thick-line text-right"><?php echo $invoice_data->total_cost;?></td>
            							</tr>
            							<?php /*<tr>
            								<td class="no-line"></td>
            								<td class="no-line"></td>
            								<td class="no-line text-center"><strong>Shipping</strong></td>
            								<td class="no-line text-right">$15</td>
            							</tr>*/?>
                                        <?php 
                                        $paid_amount = "0.00";
                                        if($paid_amount_data){
                                            $paid_amount = $paid_amount_data->amount;
                                        }
                                        ?>
            							<tr>
            								<td class="no-line"></td>
            								<td class="no-line"></td>
                                            <td class="no-line"></td>
            								<td class="no-line"></td>
            								<td class="no-line text-right"><strong>Paid Amount: </strong></td>
            								<td class="no-line text-right"><?php echo $paid_amount;?></td>
            							</tr>
                                        <?php }?>
            						</tbody>
            					</table>
            				</div>
            			</div>
            		</div>
            	</div>
            </div>
            <div class="row">
                <div class="col-xs-12">
            		<div class="invoice-title text-right">
            			<h3>Thank You!</h3>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    function print_invoice(id) {
        window.location.href = '<?php echo base_url();?>buys/print_invoice/' + id;
    }
</script>

<style>
.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
</style>


