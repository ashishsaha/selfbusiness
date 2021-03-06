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
            <div class="alert alert-info alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $this->session->userdata('flash_msgs');
                $this->session->unset_userdata('flash_msgs'); ?>
            </div>
        <?php } ?>

        <form
            action="<?php echo base_url(); ?>users/change_password/<?php echo $this->session->userdata['userData']['session_user_id']; ?>"
            class="form-horizontal row-border" method="post" name="form1" id="form1"
            enctype="multipart/form-data">

            <input type="hidden" name="action" id="action" value="">
            <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
            <input type="hidden" name="page_location" id="page_location"
                   value="<?php //echo $_SERVER['HTTP_REFERER']; ?>">

            <div class="card-box">
                <div class="row">
                    <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-arrows"></i>&nbsp;Change Password</h4>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Current Password*
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-8">
                                <input id="password"  class="form-control required" placeholder="Current Password" type="password"
                                       name="data[password]"
                                       value=""/>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">New Password*
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-8">
                                <input id="newpassword1"  class="form-control required" placeholder="New password" type="password"
                                       name="data[newpassword1]"
                                       value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Confirm Password *</label>
                            <div class="col-md-8">
                                <input id="newpassword2" data-parsley-equalto="#newpassword1"  class="form-control required" placeholder="Confirm new password" type="password"
                                       name="data[newpassword2]"  value="" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">&nbsp;</label>
                            <div class="col-md-8">
                                <button class="btn btn-success waves-effect waves-light" type="submit"><i
                                        class="fa fa-save" aria-hidden="true"></i>&nbsp;Update
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


<!--<form action="#" data-parsley-validate="" novalidate="">

    <div class="form-group">
        <label for="emailAddress">Email address*</label>
        <input name="email" parsley-trigger="change" required="" placeholder="Enter email" class="form-control"
               id="emailAddress" data-parsley-id="6" type="email">
    </div>
    <div class="form-group">
        <label for="pass1">Password*</label>
        <input id="pass1" placeholder="Password" required="" class="form-control" data-parsley-id="8" type="password">
    </div>
    <div class="form-group">
        <label for="passWord2">Confirm Password *</label>
        <input data-parsley-equalto="#pass1" required="" placeholder="Password" class="form-control" id="passWord2"
               data-parsley-id="10" type="password">
    </div>
    <div class="form-group">
        <div class="checkbox">
            <input id="remember-1" data-parsley-multiple="remember-1" data-parsley-id="13" type="checkbox">
            <label for="remember-1"> Remember me </label>
        </div>
    </div>

    <div class="form-group text-right m-b-0">
        <button class="btn btn-primary waves-effect waves-light" type="submit">
            Submit
        </button>
        <button type="reset" class="btn btn-default waves-effect waves-light m-l-5">
            Cancel
        </button>
    </div>

</form>-->