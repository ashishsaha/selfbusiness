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
                        <button title="Add Invoice" data-tooltip="true" type="button"
                                class="btn btn-success waves-effect waves-light"
                                onclick="javascript:add_buy_invoice();"><i
                                class="fa fa-plus-circle"></i>&nbsp;Add Invoice
                        </button>
                    </li>
                </ul>
            </h4>

            <table <?php if (count($buy_invoice_data) > 0){ ?>id="datatable-buttons"<?php } ?>
                   class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="width: 5%">ID</th>
                    <th title="Supplier Name">Supplier Name</th>
                    <th title="Total Purchase Cost">Total Cost</th>
                    <th title="Purchase Date">Purchase Date</th>
                    <th style="width: 10%">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($buy_invoice_data) > 0) {
                    $count = 1;
                    foreach ($buy_invoice_data as $buy_invoice) {
                        if ($buy_invoice->status == '1') {
                            $status = '<div class="active-product">
														<a  onclick="product_status(' . $buy_invoice->id . ',' . $buy_invoice->status . ')" id="' . $buy_invoice->id . '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <span class="label label-success">Active</span> </a>
													 </div>';
                        } elseif ($buy_invoice->status == '0') {
                            $status = '<div class="deactive-product">
														<a  onclick="product_status(' . $buy_invoice->id . ',' . $buy_invoice->status . ')" id="' . $buy_invoice->id . '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <span class="label label-inverse">Inactive</span> </a>
													 </div>';
                        }
                        ?>
                        <tr>
                            <td><?php echo $buy_invoice->id; ?> </td>
                            <td><?php echo $buy_invoice->full_name; ?> </td>
                            <td><?php echo $buy_invoice->total_cost; ?> </td>
                            <td><?php echo date("Y-m-d", strtotime($buy_invoice->created)); ?> </td>
                            <!--<td><span id="status_<?php /*echo $buy_invoice->id; */?>"><?php /*echo $status; */?></span></td>-->
                            <td class="actions">
                                <button title="Update Invoice" data-tooltip="true" type="button"
                                        class="on-default edit-row"
                                        onclick="javascript:edit_buy_invoice(<?php echo $buy_invoice->id; ?>);">
                                    <i class="fa fa-edit"></i></button>
                                &nbsp;

                                <button title="Delete Invoice" data-tooltip="true" type="button"
                                        class="on-default remove-row" data-toggle="modal"
                                        data-target=".bs-example-modal-sm<?php echo $buy_invoice->id; ?>">
                                    <i class="fa fa-trash"></i></button>
                                <div
                                    class="modal fade bs-example-modal-sm<?php echo $buy_invoice->id; ?>"
                                    tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Invoice
                                                    Delete</h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you confirm to delete this invoice?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal"><i
                                                        class="fa fa-times-circle"
                                                        aria-hidden="true"></i> Close
                                                </button>
                                                <button type="button"
                                                        class="btn btn-danger waves-effect waves-light"
                                                        onclick="delete_buy_invoice('<?php echo $buy_invoice->id; ?>')">
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
    function edit_buy_invoice(id) {
        window.location.href = '<?php echo base_url();?>buys/edit/' + id;
    }

    function add_buy_invoice() {
        window.location.href = '<?php echo base_url();?>buys/add';
    }

    function delete_buy_invoice(id) {
        window.location.href = '<?php echo base_url();?>buys/delete/' + id;
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

    function product_status(product_id, status) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>products/status',
            dataType: 'json',
            data: {'id': product_id, 'status': status},
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.valid) {
                    if (data.success_message == 1) {
                        var status = 1;
                        $('#status_' + product_id).html('<div class="active-product"><a onclick="product_status(' + product_id + ',' + status + ')" id="' + product_id + '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <span class="label label-success">Active</span> </a></div>');
                    }
                    else {
                        var status = 0;
                        $('#status_' + product_id).html('<div class="deactive-product"><a onclick="product_status(' + product_id + ',' + status + ')" id="' + product_id + '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <span class="label label-inverse">Inactive</span> </a></div>');
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