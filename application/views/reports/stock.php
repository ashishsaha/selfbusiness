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
                <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-tree"></i> Stock Report
                </h4>
            </div>
            <form action="<?php echo base_url(); ?>reports/stock" class="form-horizontal row-border" method="post"
                  name="form1" id="form1" enctype="multipart/form-data">
                <input type="hidden" name="action" id="action" value="">
                <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product</label>

                            <div class="col-md-9">
                                <select class="form-control required" name="product_id" id="product_id" onchange="select_product()" data-parsley-id="6">
                                    <option value="" <?php if($product_id == ''){?>selected="selected" <?php } ?>>Select Product</option>
                                    <option value="all" <?php if($product_id == 'all'){?>selected="selected" <?php } ?>>All</option>
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
                            <label class="col-md-3 control-label">Brand</label>

                            <div class="col-md-9" id="ajaxShowDiv">
                                <select class="form-control required" name="brand_id" id="brand_id" data-parsley-id="6">
                                    <option value="all" <?php if($brand_id == 'all'){?>selected="selected" <?php } ?>>All</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Status">Is Current Stock</label>
                            <div class="col-md-9">
                                <div class="checkbox checkbox-success checkbox-single" style="top: 7px;">
                                    <input id="is_current_stock" title="Is Current Stock" name="is_current_stock" aria-label="Single checkbox Two" type="checkbox" <?php echo ($is_current_stock == 'on')?'checked':''; ?>>
                                    <label></label>
                                </div>
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
                                    <input style="position: relative; z-index: 100000;" type="text" class="form-control required" name="start" id="start" value="<?php echo $start;?>"  <?php echo ($is_current_stock == 'on')?'disabled':''; ?>/>
                                    <span class="input-group-addon bg-primary b-0 text-white">to</span>
                                    <input type="text" class="form-control required" name="end" id="end" value="<?php echo $end;?>"  <?php echo ($is_current_stock == 'on')?'disabled':''; ?>/>
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
                                <?php if(count($stock_data) > 0){ ?>
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



            <table <?php if (count($stock_data) > 0){ ?>id="datatable-buttons" <?php } ?>
                   class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="width: 30%" title="Product Name">Product Name</th>
                    <th style="width: 12%" title="Brand Name">Brand Name</th>
                    <th style="width: 12%" title="Bosta Per Kg">Bosta Per Kg</th>
                    <th style="width: 12%; text-align:right;" title="Total Purchased">Total Purchased</th>
                    <th style="width: 12%; text-align:right;" title="Total Sold">Total Sold</th>
                    <th style="width: 16%; text-align:right;" title="Available Quantity">Available Quantity</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($stock_data) > 0) {
                    
                    $product_name = '';
                    $i = 0;
                    foreach ($stock_data as $key=>$data) {
                        //echo '<pre>';print_r($data);die();
                        
                        $product_rowspan =  $data['product_rowspan'];
                        $brand_count = count($data['brands']);
                        
                        
                        
                        
                        foreach($data['brands'] as $val){ 
                            
                            $total_purchased = 0;
                            $total_sold = 0;
                            $bosta_type_count = count($val['bosta']);
                            $n = 0;
                            foreach($val['bosta'] as $row){
                                
                                if($product_name != $data['product_name']){
                                    $product_name = $data['product_name'];
                                    $i = 0;
                                }else{
                                    $i++;
                                }
                                
                                if(isset($row['total_purchased'])){
                                    $total_purchased = $row['total_purchased'];
                                }
                                if(isset($row['total_sold'])){
                                    $total_sold = $row['total_sold'];
                                }
                                $avaialbe_qty = $total_purchased - $total_sold;
                            
                            
                                ?>
                                <tr>
                                
                                    <?php if($i == 0){ ?>
                                    <td <?php echo ($product_rowspan>1)?'rowspan="'.$product_rowspan.'"':''; ?>><?php echo $product_name; ?></td>
                                    <?php } ?>
                                    <?php if($n==0){ ?>    
                                        <td <?php echo ($bosta_type_count>1)?'rowspan="'.$bosta_type_count.'"':''; ?> ><?php echo $val['brand_name']; ?></td>
                                    <?php } ?>
                                    <td><?php echo $row['bosta_per_kg']; ?></td>
                                    <td style="text-align:right;"><?php echo number_format($total_purchased, 2); ?></td>
                                    <td style="text-align:right;"><?php echo number_format($total_sold, 2); ?></td>
                                    <td style="text-align:right;"><?php echo number_format($avaialbe_qty, 2); ?></td>
                                </tr>
                                <?php 
                                $n++; 
                            } 
                        }  
                    }
                    ?>

                    <?php /*
                    <tr>
                        <td colspan="4" style="text-align:right; margin-right: 80px"><b>Accumulated Purchase</b></td>
                        <td style="text-align:right;"><b><?php //echo number_format($total_amount,2);?></b></td>
                    </tr><?php */ ?>
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


<!--
*
*** Print Area Start
*
-->
<?php if(count($stock_data) > 0){ ?>
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
            				<strong>Product Name:</strong> 
                            <?php 
                            if($product_id == 'all'){
                                echo "All";
                            }else{
                                if(isset($product_info->name)){
                                    echo $product_info->name;
                                }
                            }
                            ?><br />
                            <strong>Brand Name:</strong>
                            <?php 
                            if($brand_id == 'all'){
                                echo "All";
                            }else{
                                if(isset($brand_info->name)){
                                    echo $brand_info->name;
                                }
                            }
                            ?>
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
                    <strong>Stock Report</strong>
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
                            			<td style="border-top: 0; padding: 5px 5px 5px 20px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"><strong>Product Name</strong></td>
                            			<td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"><strong>Brand Name</strong></td>
                            			<td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><strong>Bosta Per Kg</strong></td>
                                        <td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><strong>Total Purchased</strong></td>
                            			<td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><strong>Total Sold</strong></td>
                                        <td style="border-top: 0; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><strong>Available Quantity</strong></td>
                                    </tr>
                            	</thead>
                            	<tbody>
                                    <?php
                                    $product_name = '';
                                    $i = 0; 
                                    foreach ($stock_data as $key=>$data) {
                                        //echo '<pre>';print_r($data);die();
                                        $product_id = $key;
                                        $product_rowspan =  $data['product_rowspan'];
                                        $brand_count = count($data['brands']);
                                        
                                        foreach($data['brands'] as $val){ 
                                            
                                            $total_purchased = 0;
                                            $total_sold = 0;
                                            $bosta_type_count = count($val['bosta']);
                                            $n = 0;
                                            foreach($val['bosta'] as $row){
                                                
                                                if($product_name != $data['product_name']){
                                                    $product_name = $data['product_name'];
                                                    $i = 0;
                                                }else{
                                                    $i++;
                                                }
                                                
                                                if(isset($row['total_purchased'])){
                                                    $total_purchased = $row['total_purchased'];
                                                }
                                                if(isset($row['total_sold'])){
                                                    $total_sold = $row['total_sold'];
                                                }
                                                $avaialbe_qty = $total_purchased - $total_sold;
                                    ?>
                				    <tr>
                            			<?php if($i == 0){ ?>
                                        <td <?php echo ($product_rowspan>1)?'rowspan="'.$product_rowspan.'"':''; ?> style="border-top: 1px solid #ebeff2; padding: 5px 5px 5px 20px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box;"><?php echo $product_name; ?></td>
                            			<?php } ?>
                                        <?php if($n==0){ ?>
                                        <td <?php echo ($bosta_type_count>1)?'rowspan="'.$bosta_type_count.'"':''; ?> style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: center;"><?php echo $val['brand_name']; ?></td>
                            			<?php } ?>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><?php echo $row['bosta_per_kg']; ?></td>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><?php echo number_format($total_purchased, 2); ?></td>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><?php echo number_format($total_sold, 2); ?></td>
                                        <td style="border-top: 1px solid #ebeff2; padding: 5px; line-height: 1.42857143; vertical-align: top; outline: none !important; box-sizing: border-box; text-align: right;"><?php echo number_format($avaialbe_qty, 2); ?></td>
                                    </tr>
                                    <?php 
                                            $n++; 
                                        } 
                                    }  
                                }
                                ?>
                                     
                            		
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
        top: 342px!important;
    }
</style>

<script type="text/javascript">
    
    function select_product() {
        var product_id = $('#product_id').val();
        var brand_id = '<?php echo $brand_id; ?>';
        $.ajax({
            type: "post",
            url: "<?php echo base_url() ?>reports/get_band_list_product",
            data: {product_id: product_id, brand_id: brand_id},
            success: function (data) {
                $("#ajaxShowDiv").html(data);
            }
        });
    }


    jQuery(document).ready(function ($) {
        $('#date-range').datepicker({
            toggleActive: true,
            zIndexOffset: 999999
        });
        
        $('#is_current_stock').change(function() {
            if($(this).is(":checked")) {
                $("#start").prop('disabled', true);
                $("#end").prop('disabled', true);
            }else{
                $("#start").prop('disabled', false);
                $("#end").prop('disabled', false);
            }       
        });
    });
</script>