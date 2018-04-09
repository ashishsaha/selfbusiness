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

        <form action="<?php echo base_url(); ?>users/add_staff" class="form-horizontal row-border" method="post"
              name="form1" id="form1" enctype="multipart/form-data">
            <input type="hidden" name="action" id="action" value="">
            <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
            <input type="hidden" name="data[corporate_account_id]" id="corporate_account_id"
                   value="<?php echo $this->session->userdata['userData']['session_corporate_account_id']; ?>">
            <input type="hidden" name="data[role_id]" id="role_id" value="4">

            <div class="card-box">

                <div class="row">
                    <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-info-circle"></i> Create Staff
                    </h4>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Your Title
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <select class="form-control" name="data[salutation]" id="salutation"">
                                <option value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Miss">Miss</option>
                                <option value="Ms.">Ms.</option>
                                <option value="Dr.">Dr.</option>
                                <option value="Prof.">Prof.</option>
                                <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">First Name</label>
                            <div class="col-md-9">
                                <input class="form-control required" placeholder="First Name" type="text"
                                       name="data[first_name]" id="first_name" parsley-trigger="change"
                                       value=""/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Last Name
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <input class="form-control required" placeholder="Last Name" type="text"
                                       name="data[last_name]" id="last_name" parsley-trigger="change"
                                       value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">User Name</label>
                            <div class="col-md-9">
                                <input class="form-control required" placeholder="User Name (email)" type="email"
                                       name="data[username]" id="username" parsley-trigger="change"
                                       value=""/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Password
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <input class="form-control required" placeholder="Password" type="password"
                                       name="data[password]" id="password" parsley-trigger="change"
                                       value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Contact No</label>
                            <div class="col-md-9">
                                <input
                                    class="form-control <?php if ($is_customer_number_required == 1) { ?> required <?php } ?>"
                                    placeholder="Contact No" type="number"
                                    name="data[contact_no]" id="contact_no" parsley-trigger="change"
                                    value=""/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Profile Image</label>
                            <div class="col-md-9">
                                <div class="card-box">
                                    <input type="file" class="dropify form-control" id="profile_image"
                                           name="profile_image" data-default-file=""/>
                                </div>
                                <!--<div class="card-box"></div>-->
                            </div>
                        </div>
                    </div>
                    <?php
                    if($is_any_service_under_this_account == 1){ ?>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Services</label>
                                <div class="col-md-9">
                                    <div class="value" id="controller_list">
                                        <!--<label for="action_to_all">
                                            <input type="checkbox" name="action_to_all" value="" id="action_to_all"/><strong>
                                                &nbsp; All</strong>
                                        </label>-->
                                        <div class="checkbox checkbox-info checkbox-single">
                                            <input id="action_to_all" value=""
                                                   title="Is Corporate Superadmin able to create Customer?"
                                                   name="action_to_all" aria-label="Single checkbox Two"
                                                   type="checkbox">
                                            <label>All</label>
                                        </div>

                                        <div class="clear"
                                             style="border-bottom: 1px solid #DDDDDD; margin-bottom: 5px;"></div>

                                        <?php
                                        foreach ($service_list as $serviceList) { ?>
                                            <div class="checkbox checkbox-success checkbox-single">
                                                <input id="singleCheckbox2" value="<?php echo $serviceList->id;?>" class="checkbox"
                                                       title="Is Corporate Superadmin able to create Customer?"
                                                       name="serviceArr[]"
                                                       aria-label="Single checkbox Two" type="checkbox">
                                                <label><?php echo $serviceList->name; ?></label>
                                            </div>
                                            <?php
                                            //echo ' <label id="' . $serviceList->name . '" style="font-weight:500"> <input  class="checkbox"  type="checkbox" name="servoceArr[]" value="' . $serviceList->id . '" style="float:left" aria-label="Single checkbox Two"  /> &nbsp;' . $serviceList->name . ' </label>&nbsp;&nbsp;&nbsp;';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="clear" style="border-bottom: 1px solid #DDDDDD; margin-bottom: 5px;"></div>
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
                                <option value="0">None</option>
                                <option value="1">Single</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Name Presentation
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <select class="form-control" name="data[name_presentation_style]" id="name_presentation_style"">
                                <option value="0">Name/First Name, Surname/Last Name</option>
                                <option value="1">Surname/Last Name, Name/First Name</option>
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
                                           name="data[is_show_staff_mobile_no]"  aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is show staff profile image during booking?">Show Profile
                                Image
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_show_staff_profile_img" value="1" title="Is show staff profile image?"
                                           name="data[is_show_staff_profile_img]"
                                           aria-label="Single checkbox Two" type="checkbox">
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
                                           name="data[is_email_notification_active]"
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
        window.location.href = '<?php echo base_url();?>users/staffs';
    }

</script>