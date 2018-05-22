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
                    <li>
                        <button title="Add User" data-tooltip="true" type="button"
                                class="btn btn-success waves-effect waves-light" onclick="javascript:add_user();"><i
                                class="fa fa-plus-circle"></i>&nbsp;Add User
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
                    <th>Role Type</th>
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
                            $status = '<div class="active-brand">
														<a  onclick="user_status(' . $user->id . ',' . $user->status . ')" id="' . $user->id . '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <span class="label label-success">Active</span> </a>
													 </div>';
                        } elseif ($user->status == '0') {
                            $status = '<div class="deactive-brand">
														<a  onclick="user_status(' . $user->id . ',' . $user->status . ')" id="' . $user->id . '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <span class="label label-inverse">Inactive</span> </a>
													 </div>';
                        }
                        ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url(); ?>users/edit/<?php echo $user->id; ?>"><?php echo $user->first_name . ' ' . $user->last_name; ?></a>

                            </td>
                            <td><a href="mailto:<?php echo $user->username; ?>"><?php echo $user->username; ?></a></td>
                            
                            <td><?php echo $user->role_type; ?></td>
                            <td><?php echo $user->contact_no; ?></td>

                            <td><span id="status_<?php echo $user->id; ?>"><?php echo $status; ?></span></td>
                            <td class="actions">
                                <?php //if (in_array(4, explode(",", $session_user_data->service_manage))) { ?>
                                <button title="Edit User" data-tooltip="true" type="button"
                                        class="on-default edit-row"
                                        onclick="javascript:edit_user(<?php echo $user->id; ?>);">
                                    <i class="fa fa-edit"></i></button>&nbsp;
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
                                                <h4 class="modal-title" id="myModalLabel">User
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
    function edit_user(id) {
        window.location.href = '<?php echo base_url();?>users/edit/' + id;
    }

    function add_user() {
        window.location.href = '<?php echo base_url();?>users/add';
    }

    function delete_user(id) {
        window.location.href = '<?php echo base_url();?>users/delete/' + id;
    }

    $(document).ready(function () {
        $('[data-tooltip="true"]').tooltip();
    });

    function user_status(id, status) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>users/status',
            dataType: 'json',
            data: {'id': id, 'status': status},
            success: function (data, textStatus, XMLHttpRequest) {
                //console.log(data);
                if (data.valid) {
                    if (data.success_message == 1) {
                        var status = 1;
                        $('#status_' + id).html('<div class="active-user"><a onclick="user_status(' + id + ',' + status + ')" id="' + id + '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <span class="label label-success">Active</span> </a></div>');
                    }
                    else {
                        var status = 0;
                        $('#status_' + id).html('<div class="deactive-user"><a onclick="user_status(' + id + ',' + status + ')" id="' + id + '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <span class="label label-inverse">Inactive</span> </a></div>');
                    }
                }
                else {
                    //alert("333");
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                // Message
                //$('#grid_12').removeBlockMessages().blockMessage('Error while contacting server, please try again', {type: 'error'});
            }
        });
    }
</script>