<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <?php $active_menu = $this->session->userdata['active_menu']; ?>
        <!-- User -->
        <div class="user-box">
            <h5 id='company_logo_left'><span
                     class="user_name" ><?php echo $this->session->userdata['userData']['session_user_full_name'];?> </span><br>
                <span class="role_type">(&nbsp;<?php echo $this->session->userdata['userData']['session_role_name']; ?>&nbsp;)</span>
            </h5>
            <ul class="list-inline action-user">
                <li>

                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Logout" href="<?php echo base_url() ?>users/logout" class="text-custom logout-user">
                        <i class="zmdi zmdi-power"></i>
                    </a> &nbsp;

                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit profile" href="<?php echo base_url() ?>users/edit_profile/<?php echo $this->session->userdata['userData']['session_user_id']; ?>" class="text-custom profile-user" title="Edit Profile">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>  &nbsp;

                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Change password" href="<?php echo base_url() ?>users/change_password/<?php echo $this->session->userdata['userData']['session_user_id']; ?>" class="text-custom  change-password-user <?php if ($active_menu == 'change_password') { ?> active <?php } ?>" title="Change Password">
                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                    </a>

                </li>
            </ul>
        </div>
        <!-- End User -->
        <div id="sidebar-menu">
            <ul class="left-sidebar-menu">

                <li>
                    <a href="<?php echo base_url() ?>dashboard"
                       class="waves-effect <?php if ($active_menu == 'dashboard') { ?> active <?php } ?>"><i
                            class="zmdi zmdi-view-dashboard"></i> <span> Dashboard </span> </a>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-layers"></i> <span> Invoice</span>
                        <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li>
                            <a href="<?php echo base_url() ?>sells" <?php if ($active_menu == 'sells') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Sales Invoice</a></li>
                        <li>
                            <a href="<?php echo base_url() ?>buys" <?php if ($active_menu == 'buys') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Purchase Invoice</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-money-box"></i> <span> Transaction </span>
                        <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li>
                            <a href="<?php echo base_url() ?>transaction/pay" <?php if ($active_menu == 'pay') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Expense Transaction</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>transaction/receive" <?php if ($active_menu == 'receive') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Income Transaction</a>
                        </li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-view-list"></i> <span> Store Management </span>
                        <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li>
                            <a href="<?php echo base_url() ?>products" <?php if ($active_menu == 'products') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Products/Items</a></li>
                        <li>
                            <a href="<?php echo base_url() ?>brands" <?php if ($active_menu == 'brands') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Brands</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-invert-colors"></i> <span> Customer Management</span>
                        <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li>
                            <a href="<?php echo base_url() ?>customers" <?php if ($active_menu == 'customers') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Customers/Suppliers</a></li>
                        <li>
                            <a href="<?php echo base_url() ?>employees" <?php if ($active_menu == 'employees') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Employee / Labor</a>
                        </li>
                    </ul>
                </li>
                
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-collection-text"></i> <span>General Reports </span>
                        <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li>
                            <a href="<?php echo base_url() ?>reports/customer_wise_sales" <?php if ($active_menu == 'customerwisesales') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Sales history</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>reports/supplier_wise_purchase" <?php if ($active_menu == 'supplierwisepurchase') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Purchase History</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>reports/product_wise_purchase" <?php if ($active_menu == 'productwisepurchase') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Product Purchase</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>reports/product_wise_sale" <?php if ($active_menu == 'productwisesale') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Product Sale</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>reports/stock" <?php if ($active_menu == 'stock') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Stock</a>
                        </li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-collection-plus"></i> <span> Transaction Reports </span>
                        <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li>
                            <a href="<?php echo base_url() ?>reports/sale_transaction" <?php if ($active_menu == 'saletransaction') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Sale Transaction</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>reports/customer_collection" <?php if ($active_menu == 'customercollection') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Customer Collection</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>reports/supplier_payment" <?php if ($active_menu == 'supplierpayment') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Supplier Payment</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>reports/purchase_transaction" <?php if ($active_menu == 'purchasetransaction') { ?> class="active"<?php } ?>><i class="fa fa-angle-double-right" aria-hidden="true"></i>Purchase Transaction</a>
                        </li>
                    </ul>
                </li>
                <?php
                //print_r($data);
                ?>
            </ul>
        </div>
    </div>
</div>

<style type="text/css">
    .navbar-default {
        background-color: #6e23b3;
    }
</style>