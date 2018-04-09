<div class="text-center"><!--
    <a href="index.html" class="logo"><span>Admin<span>to</span></span></a>
    <h5 class="text-muted m-t-0 font-600">Responsive Admin Dashboard</h5>-->
    <a href="javascript:void(0);" class="logo" style="cursor:default;"><span>Booking System</span></a>
</div>
<div class="m-t-40 card-box">
    <div class="text-center">
        <h4 class="text-uppercase font-bold m-b-0">Register</h4>
    </div>
    <div class="panel-body">
        <?php
        echo $err_message;
        ?>

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

        <span id="error_status" style="text-align:center; color:#F00"><?php echo validation_errors();?></span>
        <form name="form1" id="form1" class="form-horizontal row-border" method="post" action="<?php echo base_url(); ?><?php echo $var_account_name;?>users/registration">
            <input type="hidden" name="a" id="a" value="send">
            <input type="hidden" name="data[role_id]" id="role_id" value="5">
            <?php
            // Check if a redirect page has been forwarded
            if (isset($_REQUEST['redirect']))
            {
                ?>
                <input type="hidden" name="redirect" id="redirect" value="<?php echo htmlspecialchars($_REQUEST['redirect']); ?>">
                <?php
            }
            ?>
            <span id="error_status" style="text-align:center; color:#F00"><?php echo $err_message;?></span>

            <div class="form-group ">
                <div class="col-xs-12">
                    <select class="form-control" name="salutation" id="salutation"">
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

            <div class="form-group ">
                <div class="col-xs-12">
                    <input class="form-control" name="first_name" type="text" required="" placeholder="First Name">
                </div>
            </div>

            <div class="form-group ">
                <div class="col-xs-12">
                    <input class="form-control" name="last_name" type="text" required="" placeholder="Last Name">
                </div>
            </div>

            <div class="form-group ">
                <div class="col-xs-12">
                    <input class="form-control" name="username" type="email" required="" placeholder="User Name (email)">
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control" name="password" type="password" required="" placeholder="Password">
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control" name="text" type="text" <?php if($is_customer_number_required ==1){?> required="" <?php } ?> placeholder="Contact No">
                </div>
            </div>

            <div class="form-group text-center m-t-40">
                <div class="col-xs-12">

                    <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">
                        Register
                    </button>
                </div>
            </div>

        </form>

    </div>
</div>
<!-- end card-box -->

<div class="row">
    <div class="col-sm-12 text-center">
        <p class="text-muted">Already have account?<a
                href="<?php echo base_url() ?><?php echo $var_account_name; ?>users/login"
                class="text-primary m-l-5"><b>Sign In</b></a></p>
    </div>
</div>