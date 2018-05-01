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
                            <?php /*
                            <address style="text-align: right; margin-bottom: 20px;font-style: normal;line-height: 1.42857143;">
                			<strong>Transaction Information:</strong><br>
                                <?php if($transaction_data->ref_invoice_no){?>
                                Invoice No : <?php echo $invoice_data->invoice_no; ?><br>
                                <?php } ?>
            					Date : <?php echo date("Y-m-d", strtotime($transaction_data->trans_date)); ?>
            				</address>
                            */ ?>
                        </td>
                    </tr>
                    <?php 
                    
                    ?>
                </table>
            </td>
        </tr>
        
        <tr>
            <td style="height: 40px; background-color: #f5f5f5; color: #797979; border: none !important; padding: 10px 20px; border-top-left-radius: 3px; border-top-right-radius: 3px; outline: none !important; box-sizing: border-box;">
                <h3 style="font-weight: 600; margin-bottom: 0; margin-top: 0;font-size: 16px; color: inherit; line-height: 30px;">
                <strong>Transaction Summary</strong>
                </h3>
            </td>
        </tr>
        
        <tr>
            <td>
                <table style="width: 1000px; border: none; margin-bottom: 20px;box-shadow: 0 0px 8px 0 rgba(0, 0, 0, 0.06), 0 1px 0px 0 rgba(0, 0, 0, 0.02);">
                    
                    <tr>
                        <td>
                            <?php 
                            $trans_type = null;
                            if($transaction_data->trans_type == 1){
                                $trans_type = 'Bank Transaction';
                            }else if($transaction_data->trans_type == 2){
                                $trans_type = 'Cheque';
                            }else{
                                $trans_type = 'Hand Cash';
                            }
                            
                            $bank_account_from = explode(',', $transaction_data->bank_account_from);
                            $checque_no = $transaction_data->checque_no;
                            ?>
                            <table style="width: 1000px; margin-bottom: 10px; padding: 120px; background-color: transparent;border-spacing: 0;border-collapse: collapse; box-sizing: border-box;">
                                <thead>
                                    <tr>
                            			<?php if($transaction_data->ref_invoice_no){ ?>
                                        <td style="border-top: 0; padding: 5px 5px 5px 20px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"><strong>Invoice No</strong></td>
                                        <?php } ?>
                                        <td style="border-top: 0; padding: 5px 5px 5px 20px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"><strong>Transaction Type</strong></td>
                            			<td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align:center;"><strong>Transaction Date</strong></td>
                                        <?php if($transaction_data->trans_type != 0){ ?>
                                        <td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align:center;"><strong>Account Name</strong></td>
                            			<td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align:center;"><strong>Account No</strong></td>
                                        <td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align:center;"><strong>Bank Name</strong></td>
                                        <?php /*<td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align:center;"><strong>Branch Name</strong></td>
                                        <td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align:center;"><strong>Bank Location</strong></td>*/ ?>
                                        <?php if($transaction_data->trans_type == 2){ ?>
                                        <td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align:center;"><strong>Checque No</strong></td>
                                        <?php }} ?>
                                        <td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><strong>Sub total</strong></td>
                                    </tr>
                            	</thead>
                            	<tbody>
                				    <tr>
                            			<?php if($transaction_data->ref_invoice_no){ ?>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px 5px 5px 20px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"><?php echo $invoice_data->invoice_no; ?></td>
                                        <?php } ?>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px 5px 5px 20px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"><?php echo $trans_type; ?></td>
                            			<td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;"><?php echo date("Y-m-d", strtotime($transaction_data->trans_date)); ?></td>
                            			<?php if($transaction_data->trans_type != 0){ ?>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;"><?php echo $bank_account_from[0]; ?></td>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;"><?php echo $bank_account_from[1]; ?></td>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;"><?php echo $bank_account_from[2]; ?></td>
                                        <?php /*<td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;"><?php echo $bank_account_from[3]; ?></td>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;"><?php echo $bank_account_from[4]; ?></td>*/?>
                                        <?php if($transaction_data->trans_type == 2){ ?>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;"><?php echo $checque_no; ?></td>
                                        <?php }} ?>
                            			<td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><?php echo $transaction_data->amount; ?></td>
                            		</tr>
                                    
                            	</tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        
        <tr>
            <td style="text-align: right; width: 100%; margin-top: 100px;">
                <h3>Thank You!</h3>
            </td>
        </tr>

    </table>