<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <?php $active_menu =  $this->session->userdata['active_menu'];?>
        <!-- User -->
        <div class="user-box">
            <div class="user-img"><?php
                $profile_img_path = '';
                if (!empty($this->session->userdata['userData']['session_profile_image'])) {
                    $profile_img_path .= base_url() . 'uploads/userprofiles/' . $this->session->userdata['userData']['session_profile_image'];
                } else {
                    $profile_img_path .= base_url() . 'assets/images/users/avatar-1.jpg';
                }
                ?>
                <img src="<?php echo $profile_img_path; ?>" alt="user-img" class="img-circle img-thumbnail img-responsive"
                     width="72" height="72">
                <!--<div class="user-status offline"><i class="zmdi zmdi-dot-circle"></i></div>-->
            </div>
            <h5 id='company_logo_left'><span
                    class="user_name"><?php echo $this->session->userdata['userData']['session_user_full_name'];?> </span><br><span
                    class="role_type">(&nbsp;<?php echo $this->session->userdata['userData']['session_role_name']; ?>&nbsp;)</span></h5>
            <ul class="list-inline action-user">
                <li>

                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Logout" href="<?php echo base_url() ?>users/logout" class="text-custom logout-user">
                        <i class="zmdi zmdi-power"></i>
                    </a> &nbsp;

                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit profile" href="<?php echo base_url() ?>users/edit_profile/<?php echo $this->session->userdata['userData']['session_user_id']; ?>" class="text-custom profile-user" title="Edit Profile">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>  &nbsp;

                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Change password" href="<?php echo base_url() ?>users/change_password/<?php echo $this->session->userdata['userData']['session_user_id']; ?>" class="text-custom  change-password-user" title="Change Password">
                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                    </a>

                </li>
            </ul>
        </div>
        <!-- End User -->
        <div id="sidebar-menu">
            <ul class="left-sidebar-menu">
                <li>
                    <a href="<?php echo base_url()?>dashboard" class="waves-effect <?php if($active_menu == 'dashboard'){?> active <?php } ?>"><i class="zmdi zmdi-view-dashboard"></i> <span> Dashboard </span> </a>
                </li>
                <li>
                    <a href="<?php echo base_url()?>users/customers" class="waves-effect <?php if($active_menu == 'customers'){?> active <?php } ?>" ><i class="fa fa-user-plus"></i> <span> Customer Management </span> </a>
                </li>
                <li>
                    <a href="<?php echo base_url()?>settings/edit_staff_general_setting/<?php echo $this->session->userdata['userData']['session_user_id'];?>" class="waves-effect <?php if($active_menu == 'settings'){?> active <?php } ?>" ><i class="zmdi zmdi-collection-item"></i> <span> General Settings </span> </a>
                </li>
                <!--<li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-invert-colors"></i> <span> User Management </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php /*echo base_url()*/?>users" <?php /*if($active_menu == 'users'){*/?> class="active"<?php /*} */?>>Users</a></li>
                        <li><a href="<?php /*echo base_url()*/?>roles" <?php /*if($active_menu == 'roles'){*/?> class="active"<?php /*} */?>>Roles</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-collection-item"></i> <span> Settings </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?php /*echo base_url()*/?>settings/index" <?php /*if($active_menu == 'settings'){*/?> class="active"<?php /*} */?>>General Settings</a></li>
                        <li><a href="<?php /*echo base_url()*/?>settings/customerinterfacesetting" <?php /*if($active_menu == 'customerinterface'){*/?> class="active"<?php /*} */?>>Customer Interface</a></li>
                        <li><a href="<?php /*echo base_url()*/?>iconimages" <?php /*if($active_menu == 'iconimages'){*/?> class="active"<?php /*} */?>>Icon Image</a></li>
                    </ul>
                </li>-->
                <?php
                //print_r($data);
                ?>
            </ul>
        </div>
    </div>
</div>