<div class="row">
    <div class="col-sm-12">
        <?php if (isset($validation_error)) { ?>
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

        <form
            action="<?php echo base_url(); ?>settings/edit_staff_general_setting/<?php echo $this->session->userdata['userData']['session_user_id']; ?>"
            class="form-horizontal row-border" method="post" name="form1" id="form1"
            enctype="multipart/form-data">

            <input type="hidden" name="action" id="action" value="">
            <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
            <input type="hidden" name="page_location" id="page_location"
                   value="<?php //echo $_SERVER['HTTP_REFERER']; ?>">
            <div class="card-box">

                <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-info-circle"></i> <?php echo $sidebar_menu; ?>
                </h4>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Staff Selection Type
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <select class="form-control" name="data[staff_selection_type]" id="staff_selection_type"">
                                <option
                                    value="0" <?php if ($staff_setting_data->staff_selection_type == 0) { ?> selected="selected" <?php } ?>>
                                    None
                                </option>
                                <option
                                    value="1" <?php if ($staff_setting_data->staff_selection_type == 1) { ?> selected="selected" <?php } ?>>
                                    Single
                                </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Name Presentation
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <select class="form-control" name="data[name_presentation_style]"
                                        id="name_presentation_style"">
                                <option
                                    value="0" <?php if ($staff_setting_data->name_presentation_style == 0) { ?> selected="selected" <?php } ?>>
                                    Name/First Name, Surname/Last Name
                                </option>
                                <option
                                    value="1" <?php if ($staff_setting_data->name_presentation_style == 1) { ?> selected="selected" <?php } ?>>
                                    Surname/Last Name, Name/First Name
                                </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is show staff mobile number during booking?">Show
                                Mobile#
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_show_staff_mobile_no" value="1"
                                           title="Is show staff mobile number during booking?"
                                           name="data[is_show_staff_mobile_no]"
                                           aria-label="Single checkbox Two" <?php if ($staff_setting_data->is_show_staff_mobile_no) { ?> checked="" <?php } ?>
                                           type="checkbox">
                                    <label></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is show staff profile image during booking?">Show
                                Profile
                                Image
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">

                                    <input id="is_show_staff_profile_img" value="1" title="Is show staff profile image?"
                                           name="data[is_show_staff_profile_img]"
                                           aria-label="Single checkbox Two" <?php if ($staff_setting_data->is_show_staff_profile_img) { ?> checked="" <?php } ?>
                                           type="checkbox">
                                    <label></label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is Email Notification Active?">Email
                                Notification
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_email_notification_active" value="1"
                                           title="Is email notification Active?"
                                           name="data[is_email_notification_active]" <?php if ($staff_setting_data->is_email_notification_active) { ?> checked="" <?php } ?>
                                           aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
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
                                <button type="button" class="btn" onclick="javascript:staffs_cancel();"><i
                                        class="fa fa-ban" aria-hidden="true"></i> Cancel
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
</style>
<script type="text/javascript">
    function staffs_cancel() {
        var page_location = $('#page_location').val();
        window.location.href = '<?php echo base_url();?>users/staffs';
    }
</script>