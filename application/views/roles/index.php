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
                <ul class="service-status">
                    <li><i class="fa fa-check-circle text-success"></i> Active</li>
                    <li><i class="fa fa-check-circle text-unsuccess"></i> Inactive</li>
                    <li>
                        <button title="Add Role" data-tooltip="true" type="button"
                                class="btn btn-primary waves-effect waves-light"
                                onclick="javascript:add_role();"><i class="fa fa-plus-circle"></i>&nbsp;Add
                        </button>
                    </li>
                </ul>
            </h4>

            <table <?php if (count($roleInfo) > 0){ ?>id="datatable-buttons"<?php } ?> class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($roleInfo) > 0) {

                    $count = 1;

                    foreach ($roleInfo as $rInfos) {
                        if ($rInfos->status == '1') {
                            $status = '<div class="active-user">
														<a  onclick="role_status(' . $rInfos->id . ',' . $rInfos->status . ')" id="' . $rInfos->id . '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <i class="fa fa-check-circle text-success"></i> </a> 
													 </div>';
                        } elseif ($rInfos->status == '0') {
                            $status = '<div class="deactive-user">
														<a  onclick="role_status(' . $rInfos->id . ',' . $rInfos->status . ')" id="' . $rInfos->id . '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <i class="fa fa-check-circle text-unsuccess"></i> </a> 
													 </div>';
                        }
                        ?>
                        <tr>
                            <td>
                                <?php echo $rInfos->name; ?>
                            </td>

                            <td><span id="status_<?php echo $rInfos->id; ?>"><?php echo $status; ?></span></td>

                            <td class="actions">
                                <?php //if (in_array(4, explode(",", $session_user_data->service_manage))) { ?>
                                <button title="Edit Role" data-tooltip="true" type="button"
                                        class="on-default edit-row"
                                        onclick="javascript:edit_role(<?php echo $rInfos->id; ?>);">
                                    <i class="fa fa-edit"></i></button>&nbsp;
                                <?php //} ?>


                                <!--<button title="Delete Role" data-tooltip="true" type="button"
                                        class="on-default remove-row" data-toggle="modal"
                                        data-target=".bs-example-modal-sm<?php /*echo $rInfos->id; */?>">
                                    <i class="fa fa-trash"></i></button>-->
                                <div
                                    class="modal fade bs-example-modal-sm<?php echo $rInfos->id; ?>"
                                    tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Role
                                                    Delete</h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you confirm to delete this role?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal"><i
                                                        class="fa fa-times-circle"
                                                        aria-hidden="true"></i> Close
                                                </button>
                                                <button type="button"
                                                        class="btn btn-danger waves-effect waves-light"
                                                        onclick="delete_role('<?php echo $rInfos->id; ?>')">
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
    function edit_role(id) {
        window.location.href = '<?php echo base_url();?>roles/edit/' + id;
    }

    function add_role() {
        window.location.href = '<?php echo base_url();?>roles/add';
    }

    function delete_role(id) {
        window.location.href = '<?php echo base_url();?>roles/delete/' + id;
    }

    $(document).ready(function () {
        $('[data-tooltip="true"]').tooltip();
    });

    function role_status(id, s) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>roles/status',
            dataType: 'json',
            data: {'id': id, 's': s},
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.valid) {
                    //alert("111");
                    if (data.success_message == 1) {
                        var st = 1;
                        $('#status_' + id).html('<div class="active-user"><a onclick="role_status(' + id + ',' + st + ')" id="' + id + '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <i class="fa fa-check-circle text-success"></i> </a></div>');

                        $('#status_msg').fadeIn('slow', function () {
                            $('#status_msg').html(data.title + ' has been active');
                            $(this).delay(3000).fadeOut('slow');
                        });
                    }
                    else {
                        var st = 0;
                        $('#status_' + id).html('<div class="deactive-user"><a onclick="role_status(' + id + ',' + st + ')" id="' + id + '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <i class="fa fa-check-circle text-unsuccess"></i> </a></div>');

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