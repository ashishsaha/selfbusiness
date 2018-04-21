<div class="row">
    <div class="col-sm-12">
        <?php if ($this->session->userdata('flash_msgs')) { ?>
            <div class="alert alert-success alert-dismissable">
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
                        <button title="Add Parent Account" data-tooltip="true" type="button"
                                class="btn btn-success waves-effect waves-light"
                                onclick="javascript:add_parent_account();"><i
                                class="fa fa-plus-circle"></i>&nbsp;Add Parent Account
                        </button>
                    </li>
                </ul>
            </h4>
            
            <div id="adding_form" class="row">
                <div class="col-sm-12">
                    <form action="<?php echo base_url(); ?>accounts/index" class="form-horizontal row-border" method="post" name="form1" id="form1" enctype="multipart/form-data" novalidate="">
                        <input type="hidden" name="action" id="action" value="">
                        <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
                        <input type="hidden" name="option_upload" id="option_upload" value="0">
                        <input type="hidden" name="data[id]" id="id" value="">
                        <input id="selected_id" value="1" type="hidden" />
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Account Name</label>
                                        <div class="col-md-9">
                                            <input class="form-control required" placeholder="Parent Account Name" type="text"
                                       name="data[name]" id="name" parsley-trigger="change"
                                       value=""/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" title="Parent Account Description">Description</label>
                                        <div class="col-md-9">
                                            <?php /*<input class="form-control required" placeholder="Parent Account Description"
                                       type="text"
                                       name="data[description]" id="description" parsley-trigger="change"
                                       value=""/>*/?>
                                       <textarea name="data[description]" id="description" class="form-control required" placeholder="Parent Account Description" style="min-height: 40px" cols="60" rows="1" parsley-trigger="change"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" title="Status">Status</label>
                                        <div class="col-md-9">
                                            <div class="checkbox checkbox-success checkbox-single">
                                                <input id="status" title="Status" name="data[status]" aria-label="Single checkbox Two" type="checkbox">
                                                <label></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6" style="text-align: right">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">&nbsp;</label>
                                        <div class="col-md-9">
                                            <button type="button" class="btn" onclick="javascript:parent_account_cancel();"><i class="fa fa-ban" aria-hidden="true"></i> Cancel
                                            </button>
                                            <button class="btn btn-success waves-effect waves-light" id="submitButton" type="submit"> Save Info
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <table <?php if (count($parent_account_data) > 0){ ?>id="datatable-buttons"<?php } ?>
                   class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="width: 5%">ID</th>
                    <th title="Parent Account Name">Parent Account Name</th>
                    <th title="Status">Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($parent_account_data) > 0) {
                    $count = 1;
                    foreach ($parent_account_data as $parent_account) {
                        if ($parent_account->status == '1') {
                            $status = '<div class="active-parent-account">
														<a  onclick="parent_account_status(' . $parent_account->id . ',' . $parent_account->status . ')" id="' . $parent_account->id . '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <span class="label label-success">Active</span> </a>
													 </div>';
                        } elseif ($parent_account->status == '0') {
                            $status = '<div class="deactive-parent-account">
														<a  onclick="parent_account_status(' . $parent_account->id . ',' . $parent_account->status . ')" id="' . $parent_account->id . '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <span class="label label-inverse">Inactive</span> </a>
													 </div>';
                        }
                        ?>
                        <tr id="parent_account_<?php echo $parent_account->id; ?>">
                            <td><?php echo $parent_account->id; ?> </td>
                            <td><?php echo $parent_account->name; ?> </td>
                            <td><span id="status_<?php echo $parent_account->id; ?>"><?php echo $status; ?></span></td>

                            <td class="actions">
                                <button title="Update Parent Account" data-tooltip="true" type="button"
                                        class="on-default edit-row"
                                        onclick="javascript:edit_parent_account(<?php echo $parent_account->id; ?>);">
                                    <i class="fa fa-edit"></i></button>
                                &nbsp;

                                <button title="Delete Parent Account" data-tooltip="true" type="button"
                                        class="on-default remove-row" data-toggle="modal"
                                        data-target=".bs-example-modal-sm<?php echo $parent_account->id; ?>">
                                    <i class="fa fa-trash"></i></button>
                                <div
                                    class="modal fade bs-example-modal-sm<?php echo $parent_account->id; ?>"
                                    tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Parent Account
                                                    Delete</h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you confirm to delete this parent account?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal"><i
                                                        class="fa fa-times-circle"
                                                        aria-hidden="true"></i> Close
                                                </button>
                                                <button type="button"
                                                        class="btn btn-danger waves-effect waves-light"
                                                        onclick="delete_parent_account('<?php echo $parent_account->id; ?>')">
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
    function edit_parent_account(id) {
        $("#id").val('');
        $("#name").val('');
        $("#description").val('');
        $("#status").prop('checked', false);
        var selected_id = $("#selected_id").val();
        $("#parent_account_"+selected_id).css("background","none");
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>accounts/getparentaccountinfo',
            dataType: 'json',
            data: {'id': id},
            success: function (data, textStatus, XMLHttpRequest) {
                $("#adding_form").show(400);
                
                $("#id").val(data.id);
                $("#name").val(data.name);
                $("#description").val(data.description);
                var status_val = parseInt(data.status);
                $("#status").prop('checked', status_val);
                
                
                $('#form1').attr('action', '<?php echo base_url(); ?>accounts/index');
                //$('#form1').append("<input type='hidden' name='edit' value='"+id+"'/>");
                $("#submitButton").html('<i class="fa fa-save" aria-hidden="true"></i> Update');
                $("#parent_account_"+id).addClass("rowBg").css("background","#EAF1FB");
                $("#selected_id").val(id);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                //$('#grid_12').removeBlockMessages().blockMessage('Error while contacting server, please try again', {type: 'error'});
            }
        });
    }
    
    function add_parent_account() {
        $("#adding_form").show(400);
        $("#id").val('');
        $("#name").val('');
        $("#description").val('');
        $("#status").prop('checked', false);
        $('#form1').attr('action', '<?php echo base_url(); ?>accounts/index');
        $("#submitButton").html('<i class="fa fa-save" aria-hidden="true"></i> Save');
    }

    function parent_account_cancel() {
        $("#adding_form").hide(400);
    }
    
    

    function delete_parent_account(id) {
        window.location.href = '<?php echo base_url();?>accounts/delete/' + id;
    }

    $(document).ready(function () {
        $("#adding_form").hide();
        $('[data-tooltip="true"]').tooltip();
    });

    function parent_account_status(parent_account_id, status) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>accounts/status',
            dataType: 'json',
            data: {'id': parent_account_id, 'status': status},
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.valid) {
                    if (data.success_message == 1) {
                        var status = 1;
                        $('#status_' + parent_account_id).html('<div class="active-parent-account"><a onclick="parent_account_status(' + parent_account_id + ',' + status + ')" id="' + parent_account_id + '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <span class="label label-success">Active</span> </a></div>');
                    }
                    else {
                        var status = 0;
                        $('#status_' + parent_account_id).html('<div class="deactive-parent-account"><a onclick="parent_account_status(' + parent_account_id + ',' + status + ')" id="' + parent_account_id + '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <span class="label label-inverse">Inactive</span> </a></div>');
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