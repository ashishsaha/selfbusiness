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
                <?php  echo $validation_error; ?>
            </div>
        <?php } ?>

        <?php if ($this->session->userdata('flash_msgs')) { ?>
            <div class="alert alert-info alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $this->session->userdata('flash_msgs');
                $this->session->unset_userdata('flash_msgs'); ?>
            </div>
        <?php } ?>

        <div class="card-box">
            <?php //echo '<pre>'; print_r($data); ?>
            <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-info-circle"></i> <?php echo $sidebar_menu; ?></h4>
            <form action="<?php echo base_url(); ?>settings/edit_corporate_general_setting/<?php echo $setting_id; ?>" class="form-horizontal row-border"
                  method="post"
                  name="form1" id="form1" enctype="multipart/form-data">
                <?php //echo form_open_multipart('iconimages/add');?>
                <input type="hidden" name="action" id="action" value="">
                <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
                <input type="hidden" name="data[corporate_account_id]" id="data[corporate_account_id]" value="<?php echo $this->session->userdata['userData']['session_corporate_account_id'];?>">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Time Increment Val
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <input type="number" class="form-control required" parsley-trigger="change"
                                       placeholder="Time Increment Val (Minutes: Ex: 30, 40)" name="data[time_increment_val]" id="text_color"
                                       value="<?php echo $data[0]->time_increment_val; ?>">
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Appointment Duration
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <input type="number" class="form-control required" parsley-trigger="change"
                                       placeholder="Appointment Duration (Minutes: Ex: 30, 40)" name="data[appointment_duration]" id="box_bg_color"
                                       value="<?php echo $data[0]->appointment_duration; ?>">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is Corporate Superadmin able to create Customer?">Create Cutomer By CSA
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="singleCheckbox2" title="Is Corporate Superadmin able to create Customer?" name="data[is_corp_super_create_cutomer]" <?php if($data[0]->is_corp_super_create_cutomer){?> checked="" <?php }?> aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is customer mobile number required?">Customer Mobile# Required
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_customer_mobile_no_required" title="Is customer mobile number required?" name="data[is_customer_mobile_no_required]" <?php if($data[0]->is_customer_mobile_no_required){?> checked="" <?php }?> aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Staff Selection Type
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <select class="form-control" name="data[staff_selection_type]" id="staff_selection_type"">
                                <option value="0" <?php if ($data[0]->staff_selection_type == 0) { ?> selected="selected" <?php } ?>>None</option>
                                <option value="1" <?php if ($data[0]->staff_selection_type == 1) { ?> selected="selected" <?php } ?>>Single</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is show staff mobile number during booking?">Show Staff Mobile#
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_show_staff_mobile_no" title="Is show staff mobile number during booking?" name="data[is_show_staff_mobile_no]" <?php if($data[0]->is_show_staff_mobile_no){?> checked="" <?php }?> aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is show staff profile image?">Show Staff Profile Image
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_show_staff_profile_img" title="Is show staff profile image?" name="data[is_show_staff_profile_img]" <?php if($data[0]->is_show_staff_profile_img){?> checked="" <?php }?> aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Service Selection Type
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <select class="form-control" name="data[service_selection_type]" id="staff_selection_type"">
                                <option value="0" <?php if ($data[0]->service_selection_type == 0) { ?> selected="selected" <?php } ?>>None</option>
                                <option value="1" <?php if ($data[0]->service_selection_type == 1) { ?> selected="selected" <?php } ?>>Single</option>
                                <option value="2" <?php if ($data[0]->service_selection_type == 2) { ?> selected="selected" <?php } ?>>Multiple</option>
                                </select>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="row">

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is show service description?">Show Service Description
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_show_service_description" title="Is show service description?" name="data[is_show_service_description]" <?php if($data[0]->is_show_service_description){?> checked="" <?php }?> aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is show price range?">Show Price Range
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_show_price_range" title="Is show price range?" name="data[is_show_price_range]" <?php if($data[0]->is_show_price_range){?> checked="" <?php }?> aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="is automatic Booking status change from pending to completed?">Change Booking Status
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_automatic_booking_status_change" title="is automatic Booking status change from pending to completed?" name="data[is_automatic_booking_status_change]" <?php if($data[0]->is_automatic_booking_status_change){?> checked="" <?php }?> aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is show Background color on Customer Interface?">Show BG on CI
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_show_bg_on_customer_panel" title="Is show Background color on Customer Interface?" name="data[is_show_bg_on_customer_panel]" <?php if($data[0]->is_show_bg_on_customer_panel){?> checked="" <?php }?> aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is show text color on customer Interface?">Show Text Color
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_show_text_color_on_customer_panel" title="Is show text color on customer Interface?" name="data[is_show_text_color_on_customer_panel]" <?php if($data[0]->is_show_text_color_on_customer_panel){?> checked="" <?php }?> aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is show logo on Cusomer Interface?">Show logo on CI
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_show_logo_on_cutomer_panel" title="Is show logo on Cusomer Interface?" name="data[is_show_logo_on_cutomer_panel]" <?php if($data[0]->is_show_logo_on_cutomer_panel){?> checked="" <?php }?> aria-label="Single checkbox Two" type="checkbox">
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