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

        <form action="<?php echo base_url(); ?>users/edit/<?php echo $user_id; ?>"
              class="form-horizontal row-border" method="post" name="form1" id="form1"
              enctype="multipart/form-data">

            <input type="hidden" name="action" id="action" value="">
            <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
            <input type="hidden" name="page_location" id="page_location"
                   value="<?php //echo $_SERVER['HTTP_REFERER']; ?>">
            <?php //echo '<pre>'; print_r($data);?>
            <div class="card-box">
                <div class="row">
                    <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-info-circle"></i>&nbsp;Update User</h4>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Role Type</label>
                            <div class="col-md-9">
                                <select class="form-control" name="data[role_id]" id="role_id"">
                                <?php
                                foreach ($role_list as $roleList) {
                                    if ($roleList->id != 1) {
                                        ?>
                                        <option
                                            value="<?php echo $roleList->id; ?>" <?php if ($role_id == $roleList->id) { ?> selected="selected" <?php } ?> ><?php echo $roleList->name; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Your Title
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <select class="form-control" name="data[salutation]" id="salutation"">
                                <option
                                    value="Mr." <?php if ($data->salutation == "Mr.") { ?> selected="selected" <?php } ?>>
                                    Mr.
                                </option>
                                <option
                                    value="Mrs." <?php if ($data->salutation == "Mrs.") { ?> selected="selected" <?php } ?>>
                                    Mrs.
                                </option>
                                <option
                                    value="Miss" <?php if ($data->salutation == "Miss") { ?> selected="selected" <?php } ?>>
                                    Miss
                                </option>
                                <option
                                    value="Ms." <?php if ($data->salutation == "Ms.") { ?> selected="selected" <?php } ?>>
                                    Ms.
                                </option>
                                <option
                                    value="Dr." <?php if ($data->salutation == "Dr.") { ?> selected="selected" <?php } ?>>
                                    Dr.
                                </option>
                                <option
                                    value="Prof." <?php if ($data->salutation == "Prof.") { ?> selected="selected" <?php } ?>>
                                    Prof.
                                </option>
                                <option
                                    value="Other" <?php if ($data->salutation == "Other") { ?> selected="selected" <?php } ?>>
                                    Other
                                </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">First Name</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="First Name" type="text"
                                       name="data[first_name]" id="first_name" parsley-trigger="change"
                                       value="<?php echo $data->first_name; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Last Name
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="Last Name" type="text"
                                       name="data[last_name]" id="last_name" parsley-trigger="change"
                                       value="<?php echo $data->last_name; ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">User Name</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="User Name (email)" type="email"
                                       name="data[username]" id="username" parsley-trigger="change"
                                       value="<?php echo $data->username; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Contact No</label>
                            <div class="col-md-9">
                                <input class="form-control" placeholder="Contact No" type="text"
                                       name="data[contact_no]" id="contact_no" parsley-trigger="change"
                                       value="<?php echo $data->contact_no; ?>"/>
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
                                               name="profile_image"
                                               data-default-file="<?php echo base_url() . 'uploads/userprofiles/' . $data->profile_image; ?>"/>
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
                                <button type="button" class="btn" onclick="javascript:users_cancel();"><i
                                        class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
                                </button>
                                <button class="btn btn-info waves-effect waves-light" type="button" onclick="javascript:users_reset(<?php echo $user_id;?>);"><i
                                        class="fa fa-refresh" aria-hidden="true"></i> Reset
                                </button>
                                <button class="btn btn-success waves-effect waves-light" type="submit"><i
                                        class="fa fa-save" aria-hidden="true"></i> Update
                                </button>
                                
                                <?php /*
                                <button class="btn btn-primary waves-effect waves-light" type="submit"><i
                                        class="fa fa-check" aria-hidden="true"></i> Submit
                                </button>
                                <button type="button" class="btn" onclick="javascript:users_cancel();"><i
                                        class="fa fa-ban" aria-hidden="true"></i> Cancel
                                </button>*/?>
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
        var page_location = $('#page_location').val();
        window.location.href = '<?php echo base_url();?>users';
    }
    
    function users_reset(id){
        window.location.href = '<?php echo base_url();?>users/edit/'+id;
    }
</script>