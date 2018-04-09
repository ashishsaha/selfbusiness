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
                        <button title="Add Customer/Supplier" data-tooltip="true" type="button"
                                class="btn btn-success waves-effect waves-light"
                                onclick="javascript:add_customer();"><i
                                class="fa fa-plus-circle"></i>&nbsp;Add Customer/Supplier
                        </button>
                    </li>
                </ul>
            </h4>

            <table <?php if (count($customer_data) > 0){ ?>id="datatable-buttons"<?php } ?>
                   class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th title="Full Name">Full Name</th>
                    <th title="Contact umber">Contact Number</th>
                    <th title="Is Customer/Supplier ?">Type</th>
                    <th title="Address">Address</th>
                    <th title="Status">Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($customer_data) > 0) {
                    $count = 1;
                    foreach ($customer_data as $customers) {
                        if ($customers->status == '1') {
                            $status = '<div class="active-customer">
														<a  onclick="customer_status(' . $customers->id . ',' . $customers->status . ')" id="' . $customers->id . '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <span class="label label-success">Active</span> </a>
													 </div>';
                        } elseif ($customers->status == '0') {
                            $status = '<div class="deactive-customer">
														<a  onclick="customer_status(' . $customers->id . ',' . $customers->status . ')" id="' . $customers->id . '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <span class="label label-inverse">Inactive</span> </a>
													 </div>';
                        }

                        // Supplier - customer and both
                        if($customers->is_customer == 1 && $customers->is_supplier == 1){
                            $customer_type = '<span class="label label-success">Customer</span>&nbsp;<span class="label label-info">Supplier</span>';
                        }else if($customers->is_customer == 1 && $customers->is_supplier == 0){
                            $customer_type = '<span class="label label-success">Customer</span>';
                        }else if($customers->is_customer == 0 && $customers->is_supplier == 1){
                            $customer_type = '<span class="label label-info">Supplier</span>';
                        }else{
                            $customer_type = '';
                        }
                        ?>
                        <tr>
                            <td><?php echo $customers->full_name; ?> </td>
                            <td><?php echo $customers->contact_number; ?> </td>
                            <td><?php echo $customer_type; ?> </td>
                            <td><?php echo $customers->address; ?> </td>
                            <td><span id="status_<?php echo $customers->id; ?>"><?php echo $status; ?></span></td>

                            <td class="actions">
                                <button title="Update Customer/Supplier" data-tooltip="true" type="button"
                                        class="on-default edit-row"
                                        onclick="javascript:edit_customer(<?php echo $customers->id; ?>);">
                                    <i class="fa fa-edit"></i></button>
                                &nbsp;

                                <button title="Delete Customer/Supplier" data-tooltip="true" type="button"
                                        class="on-default remove-row" data-toggle="modal"
                                        data-target=".bs-example-modal-sm<?php echo $customers->id; ?>">
                                    <i class="fa fa-trash"></i></button>
                                <div
                                    class="modal fade bs-example-modal-sm<?php echo $customers->id; ?>"
                                    tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Customer/Supplier
                                                    Delete</h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you confirm to delete this customer/Supplier?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal"><i
                                                        class="fa fa-times-circle"
                                                        aria-hidden="true"></i> Close
                                                </button>
                                                <button type="button"
                                                        class="btn btn-danger waves-effect waves-light"
                                                        onclick="delete_customer('<?php echo $customers->id; ?>')">
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
    function edit_customer(id) {
        window.location.href = '<?php echo base_url();?>customers/edit/' + id;
    }

    function add_customer() {
        window.location.href = '<?php echo base_url();?>customers/add';
    }

    function delete_customer(id) {
        window.location.href = '<?php echo base_url();?>customers/delete/' + id;
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

    function customer_status(customer_id, status) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>customers/status',
            dataType: 'json',
            data: {'id': customer_id, 'status': status},
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.valid) {
                    if (data.success_message == 1) {
                        var status = 1;
                        $('#status_' + customer_id).html('<div class="active-customer"><a onclick="customer_status(' + customer_id + ',' + status + ')" id="' + customer_id + '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <span class="label label-success">Active</span> </a></div>');
                    }
                    else {
                        var status = 0;
                        $('#status_' + customer_id).html('<div class="deactive-customer"><a onclick="customer_status(' + customer_id + ',' + status + ')" id="' + customer_id + '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <span class="label label-inverse">Inactive</span> </a></div>');
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