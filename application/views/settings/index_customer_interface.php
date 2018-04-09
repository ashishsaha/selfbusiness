<div class="row">
    <div class="col-sm-12">
        <?php if ($this->session->userdata('flash_msgs')) { ?>
            <div class="alert alert-info alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $this->session->userdata('flash_msgs');
                $this->session->unset_userdata('flash_msgs'); ?>
            </div>
        <?php } ?>
        <div class="card-box table-responsive">

            <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-tree"></i> <?php echo $sidebar_menu; ?>&nbsp;
                &nbsp;<span id="status_msg" class="text-success"></span>
                <ul class="list-status">
                    <!--<li><i class="fa fa-check-circle text-success"></i> Active</li>
                    <li><i class="fa fa-check-circle text-unsuccess"></i> Inactive</li>-->
                    <li>
                        <button title="Add Customer Interface Setting" data-tooltip="true" type="button"
                                class="btn btn-primary waves-effect waves-light" onclick="javascript:add_customerinteracesetting();"><i
                                class="fa fa-plus-circle"></i>&nbsp;Add
                        </button>
                    </li>
                </ul>
            </h4>

            <table <?php if (count($setting_data) > 0){ ?>id="datatable-buttons"<?php } ?>
                   class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Corporate Account</th>
                    <th>BG Image</th>
                    <th>Profile Image</th>
                    <th>Logo Image</th>
                    <th>Text Color</th>
                    <th>Box Outline Color</th>
                    <th>Box BG Color</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($setting_data) > 0) {
                    $count = 1;
                    foreach ($setting_data as $customerinterfacesetting) {
                    ?>
                        <tr>
                            <td><?php echo $customerinterfacesetting->name; ?> </td>
                            <td><img src="<?php echo base_url().'uploads/settings/'.$customerinterfacesetting->default_bg_img;?>" title="" width="50" height="50"/></td>
                            <td><img src="<?php echo base_url().'uploads/settings/'.$customerinterfacesetting->default_profile_img;?>" title="" width="50" height="50"/></td>
                            <td><img src="<?php echo base_url().'uploads/settings/'.$customerinterfacesetting->default_logo_img;?>" title="" width="50" height="50"/></td>
                            <td><input type="color" value="<?php echo $customerinterfacesetting->text_color; ?>" disabled></td>
                            <td><input type="color" value="<?php echo $customerinterfacesetting->box_outline_color; ?>" disabled></td>
                            <td><input type="color" value="<?php echo $customerinterfacesetting->box_bg_color; ?>" disabled> </td>
                            <td class="actions">
                                <?php //if (in_array(4, explode(",", $session_user_data->service_manage))) { ?>
                                <button title="Edit Account" data-tooltip="true" type="button"
                                        class="on-default edit-row"
                                        onclick="javascript:edit_customer_interface_setting(<?php echo $customerinterfacesetting->id; ?>);">
                                    <i class="fa fa-edit"></i></button>&nbsp;
                                <?php //} ?>


                                
                            </td>
                        </tr>
                        <?php $count++;
                    }
                } else { ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No record found!</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div><!-- end col -->
</div>

<script type="text/javascript">
    function edit_customer_interface_setting(id) {
        window.location.href = '<?php echo base_url();?>settings/edit_customer_interface/' + id;
    }

    function add_customerinteracesetting() {
        window.location.href = '<?php echo base_url();?>settings/add_customer_interface';
    }

    function delete_customer_interface_setting(id) {
        window.location.href = '<?php echo base_url();?>settings/delete_customer_interface/' + id;
    }

    $(document).ready(function () {
        $('[data-tooltip="true"]').tooltip();
    });

    function customer_interface_setting_status(id, s) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>settings/status_customer_interface',
            dataType: 'json',
            data: {'id': id, 's': s},
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.valid) {
                    //alert("111");
                    if (data.success_message == 1) {
                        var st = 1;
                        $('#status_' + id).html('<div class="active-corporateaccount"><a onclick="customer_interface_setting_status(' + id + ',' + st + ')" id="' + id + '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <i class="fa fa-check-circle text-success"></i> </a></div>');

                        $('#status_msg').fadeIn('slow', function () {
                            $('#status_msg').html(data.title + ' has been active');
                            $(this).delay(3000).fadeOut('slow');
                        });
                    }
                    else {
                        var st = 0;
                        $('#status_' + id).html('<div class="deactive-corporateaccount"><a onclick="customer_interface_setting_status(' + id + ',' + st + ')" id="' + id + '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <i class="fa fa-check-circle text-unsuccess"></i> </a></div>');

                        $('#status_msg').fadeIn('slow', function () {
                            $('#status_msg').html(data.title + ' has been inactive');
                            $(this).delay(3000).fadeOut('slow');
                        });
                    }
                }
                else {
                    //alert("333");
                    // Message
                    //$('#grid_12').removeBlockMessages().blockMessage(data.error || 'An unexpected error occured, please try again', {type: 'error'});
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                //alert("444");
                //alert("error"+textStatus);
                // Message
                //$('#grid_12').removeBlockMessages().blockMessage('Error while contacting server, please try again', {type: 'error'});
            }
        });
    }
</script>