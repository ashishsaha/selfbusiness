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
                    <th style="width: 12%" title="Brand Name">Bosta Per Kg</th>
                    <th style="width: 12%; text-align:right;" title="Total Sold">Total Sold</th>
                    <th style="width: 12%; text-align:right;" title="Bosta/KG">Total Purchased</th>
                    <th style="width: 16%; text-align:right;" title="Available Quantity">Available Quantity</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($stock_data) > 0) {
                    
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
                                    <td <?php echo ($product_rowspan>1)?'rowspan="'.$product_rowspan.'"':''; ?>><?php echo $product_name; ?></td>
                                    <?php } ?>
                                    <?php if($n==0){ ?>    
                                        <td <?php echo ($bosta_type_count>1)?'rowspan="'.$bosta_type_count.'"':''; ?> ><?php echo $val['brand_name']; ?></td>
                                    <?php } ?>
                                    <td><?php echo $row['bosta_per_kg']; ?></td>
                                    <td style="text-align:right;"><?php echo number_format($total_sold, 2); ?></td>
                                    <td style="text-align:right;"><?php echo number_format($total_purchased, 2); ?></td>
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
                        <td colspan="5" style="text-align:center;">Sorry! there is no available records.</td>
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
    });
</script>