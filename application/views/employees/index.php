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
            <h4 class="header-title m-t-0 m-b-30" ><i class="fa fa-tree"></i> <?php echo $sidebar_menu; ?>&nbsp;
                &nbsp;<span id="status_msg" class="text-success"></span>
                <ul class="list-status">
                    <!--<li><i class="fa fa-check-circle text-success"></i> Active</li>
                    <li><i class="fa fa-check-circle text-unsuccess"></i> Inactive</li>-->
                    <li>
                        <button title="Add Employee/Labor" data-tooltip="true" type="button"
                                class="btn btn-success waves-effect waves-light"
                                onclick="javascript:add_employee();"><i
                                class="fa fa-plus-circle"></i>&nbsp;Add Employee&nbsp;/&nbsp;Labor
                        </button>
                    </li>
                </ul>
            </h4>

            <table <?php if (count($employee_data) > 0){ ?>id="datatable-buttons"<?php } ?>
                   class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th title="Full Name">Full Name</th>
                    <th title="Contact umber">Contact Number</th>
                    <th title="Employee Type">Type</th>
                    <th title="Address">Address</th>
                    <th title="Status">Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($employee_data) > 0) {
                    $count = 1;
                    foreach ($employee_data as $employees) {
                        if ($employees->status == '1') {
                            $status = '<div class="active-employee">
														<a  onclick="employee_status(' . $employees->id . ',' . $employees->status . ')" id="' . $employees->id . '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <span class="label label-success">Active</span> </a>
													 </div>';
                        } elseif ($employees->status == '0') {
                            $status = '<div class="deactive-employee">
														<a  onclick="employee_status(' . $employees->id . ',' . $employees->status . ')" id="' . $employees->id . '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <span class="label label-inverse">Inactive</span> </a>
													 </div>';
                        }

                        // Supplier - employee and both
                        if($employees->employee_type == 0){
                            $employee_type = '<span class="label label-success">Supplier/Customer</span>';
                        }else if($employees->employee_type == 1){
                            $employee_type = '<span class="label label-default">Casual Labor</span>';
                        }else if($employees->employee_type == 2){
                            $employee_type = '<span class="label label-default">Labor</span>';
                        }else{
                            $employee_type = '<span class="label label-info">Employee</span>';
                        }
                        ?>
                        <tr>
                            <td><?php echo $employees->full_name; ?> </td>
                            <td><?php echo $employees->contact_number; ?> </td>
                            <td><?php echo $employee_type; ?> </td>
                            <td><?php echo $employees->address; ?> </td>
                            <td><span id="status_<?php echo $employees->id; ?>"><?php echo $status; ?></span></td>

                            <td class="actions">
                                <button title="Update Employee/Labor" data-tooltip="true" type="button"
                                        class="on-default edit-row"
                                        onclick="javascript:edit_employee(<?php echo $employees->id; ?>);">
                                    <i class="fa fa-edit"></i></button>
                                &nbsp;

                                <button title="Delete Employee/Labor" data-tooltip="true" type="button"
                                        class="on-default remove-row" data-toggle="modal"
                                        data-target=".bs-example-modal-sm<?php echo $employees->id; ?>">
                                    <i class="fa fa-trash"></i></button>
                                <div
                                    class="modal fade bs-example-modal-sm<?php echo $employees->id; ?>"
                                    tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Employee/Labor
                                                    Delete</h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you confirm to delete this Employee/Labor?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal"><i
                                                        class="fa fa-times-circle"
                                                        aria-hidden="true"></i> Close
                                                </button>
                                                <button type="button"
                                                        class="btn btn-danger waves-effect waves-light"
                                                        onclick="delete_employee('<?php echo $employees->id; ?>')">
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
    function edit_employee(id) {
        window.location.href = '<?php echo base_url();?>employees/edit/' + id;
    }

    function add_employee() {
        window.location.href = '<?php echo base_url();?>employees/add';
    }

    function delete_employee(id) {
        window.location.href = '<?php echo base_url();?>employees/delete/' + id;
    }

    $(document).ready(function () {
        $('[data-tooltip="true"]').tooltip();

        $(document).ready(function () {
            $('#datatable-buttons').DataTable({
                "order": [
                    [ 1, "desc" ]
                ]
            });
        });
    });

    function employee_status(employee_id, status) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>employees/status',
            dataType: 'json',
            data: {'id': employee_id, 'status': status},
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.valid) {
                    if (data.success_message == 1) {
                        var status = 1;
                        $('#status_' + employee_id).html('<div class="active-employee"><a onclick="employee_status(' + employee_id + ',' + status + ')" id="' + employee_id + '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <span class="label label-success">Active</span> </a></div>');
                    }
                    else {
                        var status = 0;
                        $('#status_' + employee_id).html('<div class="deactive-employee"><a onclick="employee_status(' + employee_id + ',' + status + ')" id="' + employee_id + '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <span class="label label-inverse">Inactive</span> </a></div>');
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