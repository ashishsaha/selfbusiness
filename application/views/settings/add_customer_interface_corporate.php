<div class="row">
    <div class="col-sm-12">
        <?php if (isset($validation_error)) { ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php  echo $validation_error; ?>
            </div>
        <?php } ?>
        
        <?php if (isset($upload_validation_error)) { ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php  echo $upload_validation_error; ?>
            </div>
        <?php } ?>

        <div class="card-box">
            <script type="text/javascript">
                function cor() {
                    return "rgb(" + "#FF0000".match(/[A-Za-z0-9]{2}/g).map(function(v) { return parseInt(v, 16) }).join(",") + ")";
                    //-> "rgb(255,0,0)"
                }
            </script>
            <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-info-circle"></i> <?php echo $sidebar_menu; ?></h4>
            <form action="<?php echo base_url(); ?>settings/add_customer_interface_corporate" class="form-horizontal row-border"
                  method="post"
                  name="form1" id="form1" enctype="multipart/form-data">
                <?php //echo form_open_multipart('iconimages/add');?>
                <input type="hidden" name="action" id="action" value="">
                <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
                <input type="hidden" name="data[corporate_account_id]" id="store_id" value="<?php echo $this->session->userdata['userData']['session_corporate_account_id'];?>">
                <div class="row">
                    <!--<div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Account Name</label>
                            <div class="col-md-9">
                                <select class="form-control required" name="data[corporate_account_id]" id="store_id"">
                                <?php
/*                                foreach ($account_list as $accountList) {
                                    */?>
                                    <option
                                        value="<?php /*echo $accountList->id; */?>"><?php /*echo $accountList->name; */?></option>
                                    <?php
/*                                }
                                */?>
                                </select>
                            </div>
                        </div>
                    </div>-->

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Text Color
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <input type="color" class="form-control required" parsley-trigger="change"
                                       placeholder="Text Color" name="data[text_color]" id="text_color"
                                       value="<?php echo set_value('data[text_color]'); ?>">
                            </div>
                        </div>
                    </div><!-- end col -->

                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Box BG Color
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <input type="color" class="form-control required" parsley-trigger="change"
                                       placeholder="Box Background Color" name="data[box_bg_color]" id="box_bg_color"
                                       value="<?php echo set_value('data[box_bg_color]'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Box Outline Color
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <input type="color" class="form-control required" parsley-trigger="change"
                                       placeholder="Box Outline Color" name="data[box_outline_color]"
                                       id="box_outline_color"
                                       value="<?php echo set_value('data[box_outline_color]'); ?>">
                            </div>
                        </div>
                    </div><!-- end col -->

                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Default BG Image</label>
                            <div class="col-md-9">
                                <div class="card-box">
                                    <!--<input type="file" class="dropify"  id="images" name="images" data-default-file="<?php /*echo base_url() . 'uploads/iconimages/' . $data->icon_image; */ ?>"  />-->
                                    <input type="file" title="Default Background Image" class="dropify required"
                                           id="default_bg_img" name="default_bg_img" data-default-file=""/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Default Logo Image</label>
                            <div class="col-md-9">
                                <div class="card-box">
                                    <!--<input type="file" class="dropify"  id="images" name="images" data-default-file="<?php /*echo base_url() . 'uploads/iconimages/' . $data->icon_image; */ ?>"  />-->
                                    <input type="file" title="Default Logo Image" class="dropify required"
                                           id="default_logo_img" name="default_logo_img" data-default-file=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Default Profile Image</label>
                            <div class="col-md-9">
                                <div class="card-box">
                                    <!--<input type="file" class="dropify"  id="images" name="images" data-default-file="<?php /*echo base_url() . 'uploads/iconimages/' . $data->icon_image; */ ?>"  />-->
                                    <input type="file" title="Default Profile Image" class="dropify required"
                                           id="default_profile_img" name="default_profile_img" data-default-file=""/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">&nbsp;</label>
                            <div class="col-md-9">
                                <button class="btn btn-primary waves-effect waves-light" type="submit"><i
                                        class="fa fa-check" aria-hidden="true"></i> Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>