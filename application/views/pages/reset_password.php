<div class="text-center">
    <!--<a href="index.html" class="logo"><span>Admin<span>to</span></span></a>
    <h5 class="text-muted m-t-0 font-600">Responsive Admin Dashboard</h5>-->
    <a href="javascript:void(0);" class="logo" style="cursor:default;"><span>Booking System</span></a>
</div>
<div class="m-t-40 card-box">
    <div class="text-center">
        <h4 class="text-uppercase font-bold m-b-0">Reset Password</h4>
    </div>
    <div class="panel-body">

        <?php if ($this->session->userdata('flash_msgs')) { ?>
            <div class="alert alert-info alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $this->session->userdata('flash_msgs');
                $this->session->unset_userdata('flash_msgs'); ?>
            </div>
        <?php } ?>

        <?php if ($this->session->userdata('flash_err_msgs')) { ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $this->session->userdata('flash_err_msgs');
                $this->session->unset_userdata('flash_err_msgs'); ?>
            </div>
        <?php } ?>

        <form name="form1" id="form1" class="form-horizontal row-border" method="post" action="<?php echo base_url(); ?><?php echo $var_account_name;?>users/reset_password">
            <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
            <div class="form-group">
                <div class="col-xs-12">
<!--                    <input name="username" type="email" required="" placeholder="Provide your username">-->
                    <input class="form-control" id="newpassword1" name="newpassword1" placeholder="New password" type="password" required="" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
<!--                    <input name="username" type="email" required="" placeholder="Provide your username">-->
                    <input class="form-control" id="newpassword2" data-parsley-equalto="#newpassword1"   name="newpassword2" placeholder="Confirm new password" type="password" required="" />

                </div>
            </div>

            <div class="form-group text-center m-t-20 m-b-0">
                <div class="col-xs-12">
                    <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">Send Email</button>
                </div>
            </div>

        </form>

    </div>
</div>
<!-- end card-box -->