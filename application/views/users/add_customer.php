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

        <form action="<?php echo base_url(); ?>users/add_customer" class="form-horizontal row-border" method="post"
              name="form1" id="form1" enctype="multipart/form-data">
            <input type="hidden" name="action" id="action" value="">
            <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
            <input type="hidden" name="data[corporate_account_id]" id="store_id"
                   value="<?php echo $this->session->userdata['userData']['session_corporate_account_id']; ?>">
            <input type="hidden" name="data[role_id]" id="role_id" value="5">

            <div class="card-box">
                <div class="row">
                    <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-info-circle"></i> Create User
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
                                <input class="form-control" placeholder="First Name" type="text"
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
                                <input class="form-control" placeholder="Last Name" type="text"
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
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">&nbsp;</label>
                            <div class="col-md-9">
                                <button class="btn btn-primary waves-effect waves-light" type="submit"><i
                                        class="fa fa-check" aria-hidden="true"></i> Submit
                                </button>
                                <button type="button" class="btn" onclick="javascript:users_cancel();"><i
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
    function users_cancel() {
        window.location.href = '<?php echo base_url();?>users/customers';
    }
</script>