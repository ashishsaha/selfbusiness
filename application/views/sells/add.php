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
        <?php //echo '<pre>'; print_r($customers); ?>
        <form action="<?php echo base_url(); ?>sells/add" class="form-horizontal row-border" method="post" name="form1" id="form1" enctype="multipart/form-data">
            <input type="hidden" name="action" id="action" value="">
            <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
            <input type="hidden" name="option_upload" id="option_upload" value="0">

            <div class="card-box">
                <div class="row">
                    <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-arrows"></i> <?php echo $sidebar_menu; ?>
                    </h4>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Supplier Name</label>
                            <div class="col-md-9">
                                <select class="form-control required" name="data[customer_id]" id="customer_id"">
                                <?php
                                foreach ($customers as $customer) {
                                    ?>
                                    <option
                                        value="<?php echo $customer->id; ?>"><?php echo $customer->full_name; ?></option>
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
                                       value=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                <div class="col-md-12 column">
                    <div id="info"></div>
                    <table class="table table-bordered table-hover" id="whole_sell">
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
                        <input type="hidden" id="total_row" value="1" />
                        <tr id='row0'>
                            <td>1</td>
                            <td>
                                <select class="form-control required" name="product_id[]" id="product_id">
                                    <?php foreach ($products as $product) { ?>
                                        <option value="<?php echo $product->id; ?>"><?php echo $product->name; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <select class="form-control required" name="brand_id[]" id="brand_id">
                                    <?php foreach ($brands as $brand) { ?>
                                        <option value="<?php echo $brand->id; ?>"><?php echo $brand->name; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" id='total_bosta0' name='total_bosta[]' placeholder='Total Bosta' value="0" min="0"  class="form-control num_val required" onkeyup="totalBosta(0)" />
                            </td>
                            <td>
                                <input type="number" id='bosta_per_kg0' name='bosta_per_kg[]' placeholder='Bosta/KG' min="0.00" value="0.00" placeholder='0.00' step="0.01" class="form-control num_val required" />
                            </td>
                            <td>
                                <input type="number" id='price_per_bosta0' name='price_per_bosta[]' placeholder='0.00' value="0.00" step="0.01" class="form-control required" onkeyup="pricePerBosta(0)" />
                            </td>
                            <td>
                                <input type="number" readonly id='sub_total_price0' name='sub_total_price[]' placeholder='0.00' value="0.00" step="0.01" class="form-control" required/>
                            </td>
                            <td><a style="display: none" onclick="deleteRow(0)" id="delete_row0" class="pull-right btn btn-default cross_row">X</a></td>
                        </tr>
                        <tr id='row1'></tr>
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
                                <input type="hidden" name="total_selling_cost" id="total_selling_cost" value="0" />
                                <tr class="font-bold font-black tr-style" style="text-align: right">
                                    <td align="right"> <b>Grand Total :</b></td>
                                    <td ><b>$<span id="total_selling_cost_text">0.00</span></b></td>
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
                                <button type="button" class="btn" onclick="javascript:product_cancel();"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
                                </button>
                                <button class="btn btn-success waves-effect waves-light" type="submit"><i
                                            class="fa fa-save" aria-hidden="true"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>


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
    var i = 1;
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
        $('#whole_sell').append('<tr id="row' + (i + 1) + '"></tr>');
        if((parseInt(current_total_row) + 1)>1){
            $(".cross_row").show();
        }
        $("#total_row").val((parseInt(current_total_row) + 1));
        i++;
    });
    
    function deleteRow(i){
        var current_row_sub_total = $("#sub_total_price"+i).val();
        var total_selling_cost = $("#total_selling_cost").val();
        var total_selling_cost_cal = parseFloat(total_selling_cost) - parseFloat(current_row_sub_total);
        $('#total_selling_cost_text').text(total_selling_cost_cal.toFixed(2)); // Write
        $('#total_selling_cost').val(total_selling_cost_cal.toFixed(2)); // Write

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
        calSellTotal(calculated_sub_total);
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
        calSellTotal(calculated_sub_total);
    }


    /** Total purchase cost Calculation **/
    function calSellTotal(sub_total){
        var total_selling_cost = $("#total_selling_cost").val();
        var total_selling_cost_cal = sub_total + parseFloat(total_selling_cost);
        $('#total_selling_cost_text').text(total_selling_cost_cal.toFixed(2)); // Write
        $('#total_selling_cost').val(total_selling_cost_cal.toFixed(2)); // Write
    }


    function product_cancel(){
        window.location.href = '<?php echo base_url();?>sells';
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