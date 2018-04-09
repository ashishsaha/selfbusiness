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
        <?php //echo '<pre>'; print_r($invoice_data);?>
        <form action="<?php echo base_url(); ?>sells/edit/<?php echo $invoice_id;?>" class="form-horizontal row-border" method="post"
              name="form1" id="form1" enctype="multipart/form-data">
            <input type="hidden" name="action" id="action" value="">
            <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
            <input type="hidden" name="option_upload" id="option_upload" value="0">

            <div class="card-box">
                <div class="row">
                    <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-arrows"></i> Update Sell Invoice
                    </h4>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Customer Name</label>
                            <div class="col-md-9">
                                <select class="form-control required" name="data[customer_id]" id="customer_id"">
                                <?php
                                foreach ($customers as $customer) {
                                    ?>
                                    <option
                                        value="<?php echo $customer->id; ?>" <?php if($invoice_data->customer_id == $customer->id){?> selected="selected" <?php } ?>><?php echo $customer->full_name; ?></option>
                                <?php
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Item Name</label>
                            <div class="col-md-9">
                                <select class="form-control required" name="data[product_id]" id="product_id">
                                    <?php
                                    foreach ($products as $product) {
                                        ?>
                                        <option
                                            value="<?php echo $product->id; ?>" <?php if($invoice_data->product_id == $product->id){?> selected="selected" <?php } ?>><?php echo $product->name; ?></option>
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
                            <label class="col-md-3 control-label" title="Product Description">Description</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="Product Description"
                                       type="text"
                                       name="data[description]" id="description" parsley-trigger="change"
                                       value="<?php echo $invoice_data->description; ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">

                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Total KG</label>
                            <div class="col-md-7">
                                <input class="form-control required" placeholder="Total KG"
                                       type="number"  min="1" step="0.01"
                                       name="data[total_kg]" id="total_kg" parsley-trigger="change"
                                       value="<?php echo $invoice_data->total_kg; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Total Mann</label>
                            <div class="col-md-7">
                                <input class="form-control required" placeholder="Total Mann"
                                       type="number" min="0.01" step="0.01"
                                       name="data[total_mann]" id="total_mann" parsley-trigger="change"
                                       value="<?php echo $invoice_data->total_mann; ?>" readonly/>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Bosta/KG</label>
                            <div class="col-md-7">
                                <input class="form-control required" placeholder="Bosta Per KG"
                                       type="number" min="1" step="0.01"
                                       name="data[bosta_per_kg]" id="bosta_per_kg" value="<?php echo $invoice_data->bosta_per_kg; ?>"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Total Bosta</label>
                            <div class="col-md-7">
                                <input class="form-control required" type="number" value="<?php echo $invoice_data->total_bosta; ?>"  min="1" step="0.01" name="data[total_bosta]" id="total_bosta" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">

                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Sell Price/KG</label>
                            <div class="col-md-7">
                                <input class="form-control required"
                                       type="number"  min="0" step="0.01"
                                       name="data[per_kg_selling_price]" id="per_kg_selling_price" parsley-trigger="change"
                                       value="<?php echo $invoice_data->per_kg_selling_price; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Price/Mann</label>
                            <div class="col-md-7">
                                <input class="form-control required" type="number" value="<?php echo $invoice_data->price_per_mann; ?>"  min="0.01" step="0.01" name="data[price_per_mann]" id="price_per_mann" readonly/>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Price/Bosta</label>
                            <div class="col-md-7">
                                <input class="form-control required" placeholder="Per Bosta Price"
                                       type="number" min="0" step="0.01"
                                       name="data[price_per_bosta]" id="price_per_bosta" parsley-trigger="change"
                                       value="<?php echo $invoice_data->price_per_bosta; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Bosta Price</label>
                            <div class="col-md-7">
                                <input class="form-control required"
                                       type="number"  min="0" step="0.01"
                                       name="data[bosta_cost]" id="bosta_cost" parsley-trigger="change"
                                       value="<?php echo $invoice_data->bosta_cost; ?>" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Product Cost</label>
                            <div class="col-md-7">
                                <input class="form-control required" placeholder="Product Cost"
                                       type="number"  min="0" step="0.01"
                                       name="data[product_cost]" id="product_cost" value="<?php echo $invoice_data->product_cost; ?>" readonly/>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Total Cost</label>
                            <div class="col-md-7">
                                <input class="form-control required" placeholder="Per Bosta Price"
                                       type="number" min="0" step="0.01"
                                       name="data[total_selling_cost]" id="total_selling_cost" parsley-trigger="change"
                                       value="<?php echo $invoice_data->total_selling_cost; ?>" readonly/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-6" style="text-align: right">
                        <div class="form-group">
                            <label class="col-md-3 control-label">&nbsp;</label>
                            <div class="col-md-9">
                                <button type="button" class="btn" onclick="javascript:sell_cancel();">Cancel</button>
                                <button class="btn btn-primary waves-effect waves-light" type="submit"> Update Info</button>
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
    function sell_cancel(){
        window.location.href = '<?php echo base_url();?>sells';
    }
</script>