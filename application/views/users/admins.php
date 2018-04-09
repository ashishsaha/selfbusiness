<div class="row">
    <div class="col-sm-12">
        <?php if ($this->session->userdata('flash_msgs')) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo '<span class="flash_message">' . $this->session->userdata('flash_msgs') . '</span>';
                    $this->session->unset_userdata('flash_msgs'); ?>
                </div>
            </div>
        <?php } ?>
        <div class="card-box table-responsive">

            <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-tree"></i> <?php echo $sidebar_menu; ?>&nbsp;
                &nbsp;<span id="status_msg" class="text-success"></span>
                <ul class="list-status">
                    <li><i class="fa fa-check-circle text-success"></i> Active</li>
                    <li><i class="fa fa-check-circle text-unsuccess"></i> Inactive</li>
                    <li>
                        <button title="Add Admin" data-tooltip="true" type="button"
                                class="btn btn-primary waves-effect waves-light" onclick="javascript:add_admin();"><i
                                class="fa fa-plus-circle"></i>&nbsp;Add
                        </button>
                    </li>
                </ul>
            </h4>

            <table <?php if (count($user_data) > 0){ ?>id="datatable-buttons"<?php } ?>
                   class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Contact Number</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                //print_r($user_data);
                if (count($user_data) > 0) {
                    $count = 1;
                    foreach ($user_data as $user) {
                        if ($user->status == '1') {
                            $status = '<div class="active-user">
														<a  onclick="user_status(' . $user->id . ',' . $user->status . ')" id="' . $user->id . '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <i class="fa fa-check-circle text-success"></i> </a> 
													 </div>';
                        } elseif ($user->status == '0') {
                            $status = '<div class="deactive-user">
														<a  onclick="user_status(' . $user->id . ',' . $user->status . ')" id="' . $user->id . '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <i class="fa fa-check-circle text-unsuccess"></i> </a> 
													 </div>';
                        }
                        ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url(); ?>users/edit/<?php echo $user->id; ?>"><?php echo $user->first_name . ' ' . $user->last_name; ?></a>

                            </td>
                            <td><a href="mailto:<?php echo $user->username; ?>"><?php echo $user->username; ?></a></td>
                            <td><?php echo $user->contact_no; ?></td>

                            <td><span id="status_<?php echo $user->id; ?>"><?php echo $status; ?></span></td>
                            <td class="actions">
                                <?php //if (in_array(4, explode(",", $session_user_data->service_manage))) { ?>
                                <button title="Edit Admin" data-tooltip="true" type="button"
                                        class="on-default edit-row"
                                        onclick="javascript:edit_admin(<?php echo $user->id; ?>);">
                                    <i class="fa fa-edit"></i></button>
                                &nbsp;
                                <?php //} ?>


                                <button title="Delete User" data-tooltip="true" type="button"
                                        class="on-default remove-row" data-toggle="modal"
                                        data-target=".bs-example-modal-sm<?php echo $user->id; ?>">
                                    <i class="fa fa-trash"></i></button>
                                <div
                                    class="modal fade bs-example-modal-sm<?php echo $user->id; ?>"
                                    tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Admin
                                                    Delete</h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you confirm to delete this user?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal"><i
                                                        class="fa fa-times-circle"
                                                        aria-hidden="true"></i> Close
                                                </button>
                                                <button type="button"
                                                        class="btn btn-danger waves-effect waves-light"
                                                        onclick="delete_user('<?php echo $user->id; ?>')">
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
                        <td colspan="5" style="text-align:center;">No record found!</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div><!-- end col -->
</div>

<script type="text/javascript">
    function edit_admin(id) {
        window.location.href = '<?php echo base_url();?>users/edit_admin/' + id;
    }

    function add_admin() {
        window.location.href = '<?php echo base_url();?>users/add_admin';
    }

    function delete_admin(id) {
        window.location.href = '<?php echo base_url();?>users/delete_admin/' + id;
    }

    $(document).ready(function () {
        $('[data-tooltip="true"]').tooltip();
    });

    function user_status(id, s) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>users/status',
            dataType: 'json',
            data: {'id': id, 's': s},
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.valid) {
                    //alert("111");
                    if (data.success_message == 1) {
                        var st = 1;
                        $('#status_' + id).html('<div class="active-user"><a onclick="user_status(' + id + ',' + st + ')" id="' + id + '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <i class="fa fa-circle text-success"></i> </a></div>');

                        $('#status_msg').fadeIn('slow', function () {
                            $('#status_msg').html(data.title + ' has been active');
                            $(this).delay(3000).fadeOut('slow');
                        });
                    }
                    else {
                        var st = 0;
                        $('#status_' + id).html('<div class="deactive-user"><a onclick="user_status(' + id + ',' + st + ')" id="' + id + '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <i class="fa fa-circle text-unsuccess"></i> </a></div>');

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