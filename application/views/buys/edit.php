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

        <?php if ($this->session->userdata('flash_msgs')) { ?>
            <div class="alert alert-<?php echo $this->session->userdata('alerts'); ?> alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $this->session->userdata('flash_msgs');
                $this->session->unset_userdata('flash_msgs'); ?>
            </div>
        <?php } ?>

        <form action="<?php echo base_url(); ?>buys/edit/<?php echo $invoice_id;?>" class="form-horizontal row-border" method="post"
              name="form1" id="form1" enctype="multipart/form-data">
            <input type="hidden" name="action" id="action" value="">
            <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
            <input type="hidden" name="option_upload" id="option_upload" value="0">
            <div class="card-box">
                <div class="row">
                    <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-arrows"></i> Update Purchase Invoice
                    </h4>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Supplier Name</label>
                            <div class="col-md-9">
                                <select class="form-control required" name="data[customer_id]" id="customer_id"">
                                <?php
                                foreach ($suppliers as $supplier) {
                                    ?>
                                    <option
                                        value="<?php echo $supplier->id; ?>" <?php if($invoice_data->customer_id == $supplier->id){?> selected="selected" <?php } ?>><?php echo $supplier->full_name; ?></option>
                                <?php
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-6">
                        <div class="form-group address_div">
                            <label class="col-md-3 control-label" title="Product Description">Note</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="Product Description"
                                       type="text"
                                       name="data[description]" id="description" parsley-trigger="change"
                                       value="<?php echo $invoice_data->description;?>"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12 column">
                        <div id="info"></div>
                        <table class="table table-bordered table-hover" id="whole_purchase">
                            <thead>
                            <tr>
                                <th class="text-center" width="3%">#</th>
                                <th width="23%">Product Name</th>
                                <th width="21%">Brand Name</th>
                                <th width="10%">Total Bosta</th>
                                <th width="10%">Bosta/KG</th>
                                <th width="14%">Price/Bosta</th>
                                <th width="17%">Sub total</th>
                                <th width="5%" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $count_invoice_details_data  = count($invoice_details_data);
                            ?>
                            <input type="hidden" id="total_row" value="<?php echo $count_invoice_details_data;?>" />
                            <?php
                            if($count_invoice_details_data > 0){
                                $i=0;
                                foreach($invoice_details_data as $data){ ?>
                                    <tr id='row<?php echo $i;?>'>
                                <td><?php echo ($i+1);?></td>
                                <td>
                                    <select class="form-control required" name="product_id[]" id="product_id">
                                        <?php foreach ($products as $product) { ?>
                                            <option value="<?php echo $product->id; ?>" <?php if($data->product_id == $product->id){?> selected="selected" <?php } ?>><?php echo $product->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control required" name="brand_id[]" id="brand_id">
                                        <?php foreach ($brands as $brand) { ?>
                                            <option value="<?php echo $brand->id; ?>" <?php if($data->brand_id == $brand->id){?> selected="selected" <?php } ?>><?php echo $brand->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" id='total_bosta<?php echo $i;?>' name='total_bosta[]' placeholder='Total Bosta' value="<?php echo intval($data->total_bosta);?>" min="0"  class="form-control num_val required" onkeyup="totalBosta(<?php echo $i;?>)" />
                                </td>
                                <td>
                                    <input type="number" id='bosta_per_kg<?php echo $i;?>' name='bosta_per_kg[]' placeholder='Bosta/KG' min="0.00" value="<?php echo $data->bosta_per_kg;?>" placeholder='0.00' step="0.01" class="form-control num_val required" />
                                </td>
                                <td>
                                    <input type="number" id='price_per_bosta<?php echo $i;?>' name='price_per_bosta[]' placeholder='0.00' value="<?php echo $data->price_per_bosta;?>" step="0.01" class="form-control required" onkeyup="pricePerBosta(<?php echo $i;?>)" />
                                </td>
                                <td>
                                    <input type="number" readonly id='sub_total_price<?php echo $i;?>' name='sub_total_price[]' placeholder='0.00' value="<?php echo $data->sub_total_price;?>" step="0.01" class="form-control" required/>
                                </td>
                                <td><a onclick="deleteRow('<?php echo $i;?>')" id="delete_row<?php echo $i;?>" class="pull-right btn btn-default cross_row">X</a></td>
                            </tr>
                                <?php
                                    $i++;
                                }
                            }?>
                            <tr id='row<?php echo $count_invoice_details_data;?>'></tr>
                            </tbody>
                        </table>
                        <a id="add_row" class="btn btn-success pull-right btn-xs">Add more [+]</a>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-md-6"></div>
                            <div class="col-sm-6">
                                <table class=" table mrg20T table-hover table-style" style="margin-top: 6px">
                                    <tbody class="tbody-style">
                                    <input type="hidden" name="total_purchase_cost" id="total_purchase_cost" value="<?php echo $invoice_data->total_purchase_cost;?>" />
                                    <tr class="font-bold font-black tr-style" style="text-align: right">
                                        <td align="right"> <b>Grand Total :</b></td>
                                        <td ><b>$<span id="total_purchase_cost_text"><?php echo number_format($invoice_data->total_purchase_cost,2);?></span></b></td>
                                    </tr>
                                    <tr class="font-bold font-black tr-style">
                                        <td colspan="5" align="right"> </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">&nbsp;</label>
                                    <div class="col-md-7">
                                        <button type="button" class="btn" onclick="javascript:invoice_cancel();"><i
                                                class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
                                        </button>
                                        <button class="btn btn-info waves-effect waves-light" type="button" onclick="javascript:invoice_reset(<?php echo $invoice_id;?>);"><i
                                                class="fa fa-refresh" aria-hidden="true"></i> Reset
                                        </button>
                                        <button class="btn btn-success waves-effect waves-light" type="submit"><i
                                                class="fa fa-save" aria-hidden="true"></i> Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>
</div>


<?php
/*echo '<pre>';
print_r($invoice_details_data);
print_r($invoice_data);*/
?>
<style type="text/css">
    .form-horizontal .checkbox {
        padding-top: 0 !important;
    }
    .name_div .col-md-3, .address_div .col-md-3{
        width: 12.5%;
    }
    .name_div .col-md-9, .address_div .col-md-9{
        width: 87.5%;
    }
</style>
<script type="text/javascript">

    /** ADD ROW **/
    var i = parseInt('<?php echo $count_invoice_details_data;?>');
    $("#add_row").click(function () {
        var current_total_row = $("#total_row").val();
        $('#row' + i).html("<td>" + (i + 1) + "</td>" +
            "<td>"+
            "<select class='form-control required' name='product_id[]' id='product_id'>"+
            <?php foreach ($products as $product) { ?>
            "<option value='<?php echo $product->id; ?>'><?php echo $product->name; ?></option>"+
            <?php } ?>
            "</select>"+
            "</td>"+
            "<td>"+
            "<select class='form-control required' name='brand_id[]' id='brand_id'>"+
            <?php foreach ($brands as $brand) { ?>
            "<option value='<?php echo $brand->id; ?>'><?php echo $brand->name; ?></option>"+
            <?php } ?>
            "</select>"+
            "</td>"+
            "<td><input type='number' id='total_bosta"+ i +"' name='total_bosta[]' placeholder='Total Bosta' value='0' min='0'  class='form-control num_val required' onkeyup='totalBosta(" + i + ")' /></td>" +
            "<td><input type='number' id='bosta_per_kg"+i+"' name='bosta_per_kg[]' placeholder='Bosta/KG' min='0.00' value='0.00' placeholder='0.00' step='0.01' class='form-control required'  /></td>" +
            "<td><input type='number' id='price_per_bosta"+i+"' name='price_per_bosta[]' placeholder='0.00' value='0.00' step='0.01' class='form-control required' onkeyup='pricePerBosta(" + i + ")' /></td>" +
            "<td><input type='number' readonly id='sub_total_price"+i+"' name='sub_total_price[]' placeholder='0.00' value='0.00' step='0.01' class='form-control' required/></td>" +
            "<td><a onClick='deleteRow(" + i + ")' id='delete_row" + i + "' class='pull-right btn btn-default cross_row' >X</a></td>");
        $('#whole_purchase').append('<tr id="row' + (i + 1) + '"></tr>');
        if((parseInt(current_total_row) + 1)>1){
            $(".cross_row").show();
        }
        $("#total_row").val((parseInt(current_total_row) + 1));
        i++;
    });

    function deleteRow(i){
        var current_row_sub_total = $("#sub_total_price"+i).val();
        var total_purchase_cost = $("#total_purchase_cost").val();
        var total_purchase_cost_cal = parseFloat(total_purchase_cost) - parseFloat(current_row_sub_total);
        $('#total_purchase_cost_text').text(total_purchase_cost_cal.toFixed(2)); // Write
        $('#total_purchase_cost').val(total_purchase_cost_cal.toFixed(2)); // Write

        var current_total_row = $("#total_row").val();
        if((parseInt(current_total_row) - 1)<2){
            $(".cross_row").hide();
        }
        $("#total_row").val((parseInt(current_total_row) - 1));
        $("#row"+i).remove();
    }

    /* on keyup total bosta Change */
    function totalBosta(i) {
        var prev_sub_total = $("#sub_total_price"+i).val();

        var total_bosta = $('#total_bosta'+i).val();
        total_bosta = parseInt(total_bosta) || 0;

        var price_per_bosta = $('#price_per_bosta'+i).val();
        if( price_per_bosta.length === 0 ) { price_per_bosta = 0.00; }

        var  subTotalCal =  parseFloat(total_bosta * price_per_bosta);
        $('#sub_total_price'+i).val(subTotalCal.toFixed(2));

        var calculated_sub_total = subTotalCal - parseFloat(prev_sub_total);
        calPurchaseTotal(calculated_sub_total);
    }

    /* on keyup total bosta Change */
    function pricePerBosta(i) {
        var prev_sub_total = $("#sub_total_price"+i).val();

        var total_bosta = $('#total_bosta'+i).val();
        total_bosta = parseInt(total_bosta) || 0;

        var price_per_bosta = $('#price_per_bosta'+i).val();
        if( price_per_bosta.length === 0 ) { price_per_bosta = 0.00; }

        var  subTotalCal =  parseFloat(total_bosta * price_per_bosta);
        $('#sub_total_price'+i).val(subTotalCal.toFixed(2));

        var calculated_sub_total = subTotalCal - parseFloat(prev_sub_total);
        calPurchaseTotal(calculated_sub_total);
    }


    /** Total purchase cost Calculation **/
    function calPurchaseTotal(sub_total){
        var total_purchase_cost = $("#total_purchase_cost").val();
        var total_purchase_cost_cal = sub_total + parseFloat(total_purchase_cost);
        $('#total_purchase_cost_text').text(total_purchase_cost_cal.toFixed(2)); // Write
        $('#total_purchase_cost').val(total_purchase_cost_cal.toFixed(2)); // Write
    }

    function invoice_reset(id){
        window.location.href = '<?php echo base_url();?>buys/edit/'+id;
    }

    function invoice_cancel(){
        window.location.href = '<?php echo base_url();?>buys';
    }
</script>

<style type="text/css">
    .cross_row{
        color: red;
    }
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance:textfield;
    }
</style>
<script type="text/javascript">
</script>