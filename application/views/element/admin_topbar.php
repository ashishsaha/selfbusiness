<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <a href="<?php echo base_url() ?>dashboard" class="logo"><span>bsDMM System</span><i
                class="zmdi zmdi-layers"></i></a>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">

            <!-- Page title -->
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <button class="button-menu-mobile open-left">
                        <i class="zmdi zmdi-menu"></i>
                    </button>
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
            <!--<ul class="nav navbar-nav navbar-right">
                <li class=""><a href="javascript:;" class="user-profile dropdown-toggle user-profile-dropdown" data-toggle="dropdown" aria-expanded="false"> <img src="/appbookingnew/img/img.jpg" alt="" class="img-circle" width="12"> <?php /*echo $this->session->userdata['userData']['session_user_full_name'];*/?> <span class=" fa fa-angle-down"></span> </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
                            <a href="<?php /*echo base_url() */?>users/edit_profile/<?php /*echo $this->session->userdata['userData']['session_user_id']; */?>">Edit Profile</a>
                        </li>
                        <li><a href="<?php /*echo base_url() */?>users/change_password/<?php /*echo $this->session->userdata['userData']['session_user_id']; */?>"><i class="fa faa-passing-reverse pull-right"></i> Change Password</a></li>
                        <li><a href="<?php /*echo base_url()*/?>users/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>-->

        </div><!-- end container -->
    </div><!-- end navbar -->
</div>

