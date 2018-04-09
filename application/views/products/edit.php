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

        <form action="<?php echo base_url(); ?>products/edit/<?php echo $product_id;?>" class="form-horizontal row-border" method="post"
              name="form1" id="form1" enctype="multipart/form-data">
            <input type="hidden" name="action" id="action" value="">
            <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
            <input type="hidden" name="option_upload" id="option_upload" value="0">

            <div class="card-box">
                <div class="row">
                    <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-arrows"></i> Update Product
                    </h4>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-6">
                        <div class="form-group name_div">
                            <label class="col-md-3 control-label">Product Name</label>
                            <div class="col-md-9">
                                <input class="form-control required" placeholder="Product Name" type="text"
                                       name="data[name]" id="name" parsley-trigger="change"
                                       value="<?php echo $product_data->name;?>"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-6">
                        <div class="form-group address_div">
                            <label class="col-md-3 control-label" title="Customer Address">Description</label>
                            <div class="col-md-9">
                                <input class="form-control required" placeholder="Parent Description"
                                       type="text"
                                       name="data[description]" id="description" parsley-trigger="change"
                                       value="<?php echo $product_data->description;?>"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is Customer?">Is Customer?</label>
                            <div class="col-md-9">
                                <div class="checkbox checkbox-success checkbox-single" style="margin-top: 6px;">
                                    <input id="status" <?php if($product_data->status == 1){?>checked="checked"<?php } ?> title="Status" name="data[status]" aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
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
                                <button class="btn btn-primary waves-effect waves-light" type="submit"> Update Info
                                </button>
                                <button type="button" class="btn" onclick="javascript:product_cancel();">Cancel
                                </button>
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
    function product_cancel(){
        window.location.href = '<?php echo base_url();?>products';
    }
</script>