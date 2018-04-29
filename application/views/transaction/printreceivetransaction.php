    <table style="width: 100%; font-family: sans-serif; box-shadow: 0 0 5px rgba(0, 0, 0, 0.2) !important; padding: 20px; background-color: #fff; border-radius: 5px;
background-clip: padding-box;">
        <tr>
            <td style="text-align: center;">
                <header style="line-height: .52857143;">
                	<h2><?php echo $company_data->company_name; ?></h2>
                    <h4>Phone : <?php echo $company_data->contact_no; ?></h4>
                    <h5><?php echo $company_data->address; ?></h5>
                </header>
                <hr />
            </td>
        </tr>
        <tr>
            <td style="width: 100%;">
                <table style="width: 1000px; padding-top: 10px;">
                    <tr>
                        <td style="width: 50%;">	
                            <address style="margin-bottom: 20px;font-style: normal;line-height: 1.42857143;">
            				<strong>Billed From:</strong><br>
            					<?php echo $customer_data->full_name; ?><br>
            					Phone : <?php echo $customer_data->contact_number; ?><br>
            					<?php echo $customer_data->address; ?>
            				</address>			            				
                        </td>
                        <td style="width: 50%; text-align: right;">
                            <address style="text-align: right; margin-bottom: 20px;font-style: normal;line-height: 1.42857143;">
                			<strong>Transaction Information:</strong><br>
            					<?php 
                                $trans_type = null;
                                if($transaction_data->trans_type == 1){
                                    $trans_type = 'Bank Transaction';
                                }else if($transaction_data->trans_type == 2){
                                    $trans_type = 'Cheque';
                                }else{
                                    $trans_type = 'Hand Cash';
                                }
                                ?>
                                Transaction Type : <?php echo $trans_type; ?><br>
                                <?php if($transaction_data->ref_invoice_no){?>
                                Invoice No : <?php echo $invoice_data->invoice_no; ?><br>
                                <?php } ?>
            					Date : <?php echo date("Y-m-d", strtotime($transaction_data->trans_date)); ?>
            				</address>
                        </td>
                    </tr>
                    <?php 
                    $bank_account_from = explode(',', $transaction_data->bank_account_from);
                    $bank_account_to = explode(',', $transaction_data->bank_account_to);
                    $checque_no = $transaction_data->checque_no;
                    if($transaction_data->trans_type != 0){
                    ?>
                    
                    <tr>
                        <td style="width: 50%;">	
                            <address style="margin-bottom: 20px;font-style: normal;line-height: 1.42857143;">
            				<strong>Bank Account From:</strong><br>
            					Account Name: <?php echo $bank_account_from[0]; ?><br>
           					    Account Number: <?php echo $bank_account_from[1]; ?><br>
            					Bank Name: <?php echo $bank_account_from[2]; ?><br>
                                Branch Name: <?php echo $bank_account_from[3]; ?><br>
                                Bank Location: <?php echo $bank_account_from[4]; ?>
                                <?php if($transaction_data->trans_type == 2){ ?>
                                <br>
                                Checque No: <?php echo $checque_no; ?>
                                <?php } ?>
            				</address>			            				
                        </td>
                        <td style="width: 50%; text-align: right;">
                            <address style="text-align: right; margin-bottom: 20px;font-style: normal;line-height: 1.42857143;">
                			<?php if($transaction_data->trans_type == 1){ ?>
                            <strong>Bank Account To:</strong><br>
            					Account Name: <?php echo $bank_account_to[0]; ?><br>
           					    Account Number: <?php echo $bank_account_to[1]; ?><br>
            					Bank Name: <?php echo $bank_account_to[2]; ?><br>
                                Branch Name: <?php echo $bank_account_to[3]; ?><br>
                                Bank Location: <?php echo $bank_account_to[4]; ?>
                            <?php } ?>
            				</address>
                        </td>
                    </tr>
                    <?php }?>
                </table>
            </td>
        </tr>
        
        <?php 
        if(!empty($invoice_data)){ 
            $head_title = "Order summary";
        }else{
            $head_title = "Receive Information";
        }
            
        ?>
        <tr>
            <td style="height: 40px; background-color: #f5f5f5; color: #797979; border: none !important; padding: 10px 20px; border-top-left-radius: 3px; border-top-right-radius: 3px; outline: none !important; box-sizing: border-box;">
                <h3 style="font-weight: 600;
    margin-bottom: 0;
    margin-top: 0;font-size: 16px;
    color: inherit; line-height: 30px;">
                <strong><?php echo $head_title; ?></strong>
                </h3>
            </td>
        </tr>
        
        <tr>
            <td>
                <table style="width: 1000px; border: none; margin-bottom: 20px;box-shadow: 0 0px 8px 0 rgba(0, 0, 0, 0.06), 0 1px 0px 0 rgba(0, 0, 0, 0.02);">
                    
                    <tr>
                        <td>
                            <table style="width: 1000px; margin-bottom: 10px; padding: 120px; background-color: transparent;border-spacing: 0;border-collapse: collapse; box-sizing: border-box;">
                            	<?php if(!empty($invoice_data)){ ?>
                                <thead>
                                    <tr>
                            			<td style="border-top: 0; padding: 5px 5px 5px 20px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"><strong>Product Name</strong></td>
                            			<td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align:center;"><strong>Brand Name</strong></td>
                            			<td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align:center;"><strong>Total Bosta</strong></td>
                                        <td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align:center;"><strong>Bosta/KG</strong></td>
                                        <td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align:center;"><strong>Price/Bosta</strong></td>
                            			<td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><strong>Sub total</strong></td>
                                    </tr>
                            	</thead>
                            	<tbody>
                                    <?php
                                    $count_invoice_details_data  = count($invoice_details_data);
                                    if($count_invoice_details_data > 0){
                                        foreach($invoice_details_data as $data){ ?>
                				    <tr>
                            			<td style="border-top: 1px solid #ebeff2; padding: 5px 5px 5px 20px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"><?php echo $data->name; ?></td>
                            			<td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;"><?php echo $data->brand_name; ?></td>
                            			<td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;"><?php echo $data->total_bosta; ?></td>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;"><?php echo $data->bosta_per_kg; ?></td>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;"><?php echo $data->price_per_bosta; ?></td>
                            			<td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><?php echo $data->sub_total_price; ?></td>
                            		</tr>
                                    <?php } ?>
                                    <?php /*
                                    <tr>
                            			<td style="border-top: 1px solid #ebeff2; padding: 5px 5px 5px 20px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;">Mug</td>
                            			<td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;">Ifaz</td>
                            			<td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;">20.00</td>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;">50.00</td>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;">1750.00</td>
                            			<td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;">35000.00</td>
                            		</tr>
                                    */?>                                      
                            		<tr>
                            			<td style="border-top: 2px solid; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"></td>
                            			<td style="border-top: 2px solid; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"></td>
                                        <td style="border-top: 2px solid; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"></td>
                            			<td style="border-top: 2px solid; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"></td>
                            			<td style="border-top: 2px solid; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><strong>Total: </strong></td>
                            			<td style="border-top: 2px solid; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><?php echo $invoice_data->total_cost;?></td>
                            		</tr>
                                    
         							<tr>
                            			<td style="padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"></td>
                            			<td style="padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"></td>
                                        <td style="padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"></td>
                            			<td style="padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"></td>
                            			<td style="padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><strong>Received Amount: </strong></td>
                            			<td style="padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><?php echo $transaction_data->amount;?></td>
                            		</tr>
                                    <?php } ?>
                            	</tbody>
                                <?php }else{ ?>
                                <tbody>
                                    <tr>
                            			<td style="padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"></td>
                            			<td style="padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"></td>
                                        <td style="padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"></td>
                            			<td style="padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"></td>
                            			<td style="padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><strong>Received Amount: </strong></td>
                            			<td style="padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><?php echo $transaction_data->amount;?></td>
                            		</tr>
                                </tbody>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        
        <tr>
            <td style="text-align: right; width: 100%;">
                <h3>Thank You!</h3>
            </td>
        </tr>

    </table>