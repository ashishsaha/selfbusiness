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
                        <button title="Add General Setting" data-tooltip="true" type="button"
                                class="btn btn-primary waves-effect waves-light"
                                onclick="javascript:add_setting();"><i
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
                    <th title="TimeIncrement Value">Increment Time</th>
                    <th title="Appointment Duration">Appointment Duration</th>
                    <th title="Staff Selection Type">Staff Selection Type</th>
                    <th title="Is show staff mobile no?">Show Staff Mobile No</th>
                    <th title="Service Selection Type">Service Selection Type</th>
                    <th title="Is show price range?">Show price range</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($setting_data) > 0) {
                    $count = 1;
                    foreach ($setting_data as $settings) {
                        ?>
                        <tr>
                            <td><?php echo $settings->name; ?> </td>
                            <td><?php echo $settings->time_increment_val; ?> </td>
                            <td><?php echo $settings->appointment_duration; ?> </td>
                            <td><?php echo ($settings->staff_selection_type == 0) ? '<span class="label label-default">None</span>' : '<span class="label label-primary">Single</span>'; ?>


                            </td>
                            <td> <?php echo ($settings->is_show_staff_mobile_no == 0)? '<span class="label label-danger">No</span>': '<span class="label label-success">Yes</span>'; ?> </td>
                            <td>
                                <?php
                                if($settings->service_selection_type == 0){
                                    echo '<span class="label label-default">None</span>';
                                }elseif($settings->service_selection_type == 1){
                                    echo '<span class="label label-primary">Single</span>';
                                }else{
                                    echo '<span class="label label-info">Multiple</span>';
                                }
                                ?>
                            </td>
                            <td> <?php echo ($settings->is_show_price_range == 0)? '<span class="label label-danger">No</span>': '<span class="label label-success">Yes</span>'; ?> </td>

                            <td class="actions">
                                <?php //if (in_array(4, explode(",", $session_user_data->service_manage))) { ?>
                                <button title="Edit General Setting" data-tooltip="true" type="button"
                                        class="on-default edit-row"
                                        onclick="javascript:edit_setting(<?php echo $settings->id; ?>);">
                                    <i class="fa fa-edit"></i></button>
                                &nbsp;
                                <?php //} ?>


                                <!--<button title="Delete General" data-tooltip="true" type="button"
                                        class="on-default remove-row" data-toggle="modal"
                                        data-target=".bs-example-modal-sm<?php /*echo $settings->id; */?>">
                                    <i class="fa fa-trash"></i></button>-->
                                <div
                                    class="modal fade bs-example-modal-sm<?php echo $settings->id; ?>"
                                    tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Customer Interface Setting
                                                    Delete</h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you confirm to delete this General Setting?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal"><i
                                                        class="fa fa-times-circle"
                                                        aria-hidden="true"></i> Close
                                                </button>
                                                <button type="button"
                                                        class="btn btn-danger waves-effect waves-light"
                                                        onclick="delete_setting('<?php echo $settings->id; ?>')">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                    Confirm Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php $count++;
                    }
                } else { ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">No record found!</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div><!-- end col -->
</div>

<script type="text/javascript">
    function edit_setting(id) {
        window.location.href = '<?php echo base_url();?>settings/edit/' + id;
    }

    function add_setting() {
        window.location.href = '<?php echo base_url();?>settings/add';
    }

    function delete_customer_interface_setting(id) {
        window.location.href = '<?php echo base_url();?>settings/delete/' + id;
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