<?php
$application_name = '<span>BOOKING SYSTEM</span>';
?>
<div class="topbar">
    <!-- LOGO -->
    <!--<div class="topbar-left">
        <a href="<?php /*echo base_url() */?>customers/index" class="logo"><img src="<?php /*echo base_url() */?>uploads/settings/<?php /*echo $this->session->userdata['userData']['session_default_logo_img'];*/?>" width="40" title="Booking System"><i
                class="zmdi zmdi-layers"></i></a>
    </div>
-->
    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Page title -->
            <ul class="nav navbar-nav navbar-left">
                <!--<li>
                    <button class="button-menu-mobile open-left">
                        <i class="zmdi zmdi-menu"></i>
                    </button>
                </li>-->
                <?php
                $default_img_path = '';
                if (!empty($this->session->userdata['userData']['session_default_logo_img'])) {
                    $default_img_path .= base_url() . 'uploads/settings/' . $this->session->userdata['userData']['session_default_logo_img'];
                } else {
                    $default_img_path .= base_url() . 'assets/images/logo.png';
                }
                ?>

                <li class="left-top-customer">
                    <a href="<?php echo base_url() ?>customers" class="logo">
                        <img src="<?php echo $default_img_path; ?>" width="40" title="Booking System"><i
                            class="zmdi zmdi-layers"></i>
                    </a>
                </li>
                <li>
                    <h4 class="page-title">
                        <?php echo $sidebar_menu_title; ?>
                        <?php if ($this->session->userdata('not_access_msgs')) { ?>
                            <span class="not_access_section" id="not_access">
						<?php echo $this->session->userdata('not_access_msgs');
                        $this->session->unset_userdata('not_access_msgs'); ?>
						</span>
                        <?php } ?>
                    </h4>
                </li>
            </ul>

            <!-- Right(Notification and Searchbox -->
            <span class="pull-right top-customer-list">
                <a data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit profile" href="<?php echo base_url() ?>users/customer_edit_profile/<?php echo $this->session->userdata['userData']['session_user_id']; ?>" class="text-custom profile-user" title="Edit Profile">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>  &nbsp;
                <a data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Change password" href="<?php echo base_url() ?>users/customer_change_password/<?php echo $this->session->userdata['userData']['session_user_id']; ?>" class="text-custom  change-password-user" title="Change Password">
                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                    </a>  &nbsp;
                <a data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Logout" href="<?php echo base_url() ?>users/logout" class="text-custom logout-user">
                        <i class="zmdi zmdi-power"></i>
                    </a>
            </span>

            <!--<ul class="nav navbar-nav navbar-right">

                <li class=""><a href="javascript:;" class="user-profile dropdown-toggle user-profile-dropdown" data-toggle="dropdown" aria-expanded="false"> <img src="/appbookingnew/img/img.jpg" alt="" class="img-circle" width="12"> <?php /*echo $this->session->userdata['userData']['session_user_full_name'];*/?> <span class=" fa fa-angle-down"></span> </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
                            <a href="<?php /*echo base_url() */?>users/customer_edit_profile/<?php /*echo $this->session->userdata['userData']['session_user_id']; */?>">Edit Profile</a>
                        </li>
                        <li><a href="<?php /*echo base_url() */?>users/customer_change_password/<?php /*echo $this->session->userdata['userData']['session_user_id']; */?>"><i class="fa faa-passing-reverse pull-right"></i> Change Password</a></li>
                        <li><a href="<?php /*echo base_url()*/?>users/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>-->

        </div><!-- end container -->
    </div><!-- end navbar -->
</div>