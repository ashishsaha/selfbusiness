<div class="text-center">
    <a href="javascript:void(0);" class="logo" style="cursor:default;"><span>bsSelfBusiness System</span></a>
</div>
<div class="m-t-40 card-box" style="background: #C3D87B">
    <div class="text-center">
        <h4 class="text-uppercase font-bold m-b-0" style="color: white">Sign In</h4>
        <br />
    </div>

    <div class="panel-body">
        <span id="error_status" style="text-align:center; color:#F00"><?php echo validation_errors();?></span>
        <form id="loginform" name="loginform" class="form-horizontal" method="post" action="<?php echo base_url();?>users/login">
            <input type="hidden" name="a" id="a" value="send">
            <?php
            // Check if a redirect page has been forwarded
            if (isset($_REQUEST['redirect']))
            {
                ?>
                <input type="hidden" name="redirect" id="redirect" value="<?php echo htmlspecialchars($_REQUEST['redirect']); ?>">
                <?php
            }
            ?>
            <?php if ($this->session->userdata('flash_err_msgs')) { ?>
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $this->session->userdata('flash_err_msgs');
                    $this->session->unset_userdata('flash_err_msgs'); ?>
                </div>
            <?php } ?>
            <div class="form-group ">
                <div class="col-xs-12">
                    <input type="email" placeholder="Email Address" class="form-control" required="" name="username" id="input-username" value="<?php if (isset($_POST['login'])) { echo htmlspecialchars($_POST['login']); } ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12">
                    <input type="password" placeholder="Password" class="form-control" required="" name="password" id="input-password" value="">
                </div>
            </div>

            <div class="form-group text-center m-t-30">
                <div class="col-xs-12">
                    <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">Log In</button>
                </div>
            </div>
        </form>
    </div>

    <!--<div class="row">
        <div class="col-sm-12 text-center">
            <p class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?<a href="<?php /*echo base_url()*/?><?php /*echo $var_account_name;*/?>users/forget_password" class="text-primary m-l-5"><b>Click Here</b></a></p>
        </div>
    </div>-->
</div>

<!--<div class="row">
    <div class="col-sm-12 text-center">
        <p class="text-muted">Don't have an account?<a href="<?php /*echo base_url()*/?><?php /*echo $var_account_name;*/?>users/registration" class="text-primary m-l-5"><b>Sign Up</b></a></p>
    </div>
</div>-->