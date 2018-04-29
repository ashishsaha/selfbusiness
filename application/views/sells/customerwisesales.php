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
                                onclick="javascript:add_sell_invoice();"><i
                                class="fa fa-plus-circle"></i>&nbsp;Add Invoice
                        </button>
                    </li>
                </ul>
            </h4>
            
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Customer</label>
                        <div class="col-md-9">
                            <select class="form-control required" name="data[payment_from_or_to]" id="payment_from_or_to" onchange="select_customer()" data-parsley-id="6">
                                <option value="">Select Customer</option>
                                <?php
                                foreach($customer_data as $customer){?>
                                    <option value="<?php echo  $customer->id; ?>"><?php echo  $customer->full_name; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group address_div">
                        <label class="col-md-3 control-label" title="Employee Address">Address</label>
                        <div class="col-md-9">
                            <input class="form-control required" placeholder="Employee Address"
                                   type="text"
                                   name="data[address]" id="address" parsley-trigger="change"
                                   value=""/>
                        </div>
                    </div>
                </div>
                
            </div>

            <table <?php if (count($sales_invoice_data) > 0){ ?>id="datatable-buttons"<?php } ?>
                   class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="width: 11%">Invoice No</th>
                    <th style="width: 30%" title="Customer Name">Customer Name</th>
                    <th style="width: 16%" title="Total Cost">Total Cost</th>
                    <th style="width: 12%" title="Selling Date">Selling Date</th>
                    <th style="width: 15%" >Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($sales_invoice_data) > 0) {
                    $count = 1;
                    foreach ($sales_invoice_data as $sale_invoice) {
                        if ($sale_invoice->status == '1') {
                            $status = '<div class="active-invoice">
														<a  onclick="invoice_status(' . $sale_invoice->id . ',' . $sale_invoice->status . ')" id="' . $sale_invoice->id . '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <span class="label label-success">Active</span> </a>
													 </div>';
                        } elseif ($sale_invoice->status == '0') {
                            $status = '<div class="deactive-invoice">
														<a  onclick="invoice_status(' . $sale_invoice->id . ',' . $sale_invoice->status . ')" id="' . $sale_invoice->id . '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <span class="label label-inverse">Inactive</span> </a>
													 </div>';
                        }
                        ?>
                        <tr>
                            <td><?php echo $sale_invoice->invoice_no; ?> </td>
                            <td><?php echo $sale_invoice->full_name; ?> </td>
                            <td><?php echo $sale_invoice->total_cost; ?> </td>
                            <td><?php echo date("Y-m-d", strtotime($sale_invoice->created)); ?> </td>
                            <!--<td><span id="status_<?php /*echo $sale_invoice->id; */?>"><?php /*echo $status; */?></span></td>-->
                            <td class="actions">
                                <button title="Update Sell Invoice" data-tooltip="true" type="button"
                                        class="on-default edit-row"
                                        onclick="javascript:edit_sell_invoice(<?php echo $sale_invoice->id; ?>);">
                                    <i class="fa fa-edit"></i></button>
                                &nbsp;
                                
                                <button title="View Invoice" data-tooltip="true" type="button"
                                        class="on-default view-row"
                                        onclick="javascript:details_sell_invoice(<?php echo $sale_invoice->id; ?>);">
                                    <i class="fa fa-eye"></i></button>
                                &nbsp;
                                
                                <button title="Print Invoice" data-tooltip="true" type="button"
                                        class="on-default print-row"
                                        onclick="javascript:print_invoice(<?php echo $sale_invoice->id; ?>);">
                                    <i class="fa fa-print"></i></button>
                                &nbsp;

                                <button title="Delete Sell Invoice" data-tooltip="true" type="button"
                                        class="on-default remove-row" data-toggle="modal"
                                        data-target=".bs-example-modal-sm<?php echo $sale_invoice->id; ?>">
                                    <i class="fa fa-trash"></i></button>
                                <div
                                    class="modal fade bs-example-modal-sm<?php echo $sale_invoice->id; ?>"
                                    tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Sell Invoice
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
                                                        onclick="delete_sell_invoice('<?php echo $sale_invoice->id; ?>')">
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
    function print_invoice(id) {
        window.location.href = '<?php echo base_url();?>sells/print_invoice/' + id;
    }
    
    function details_sell_invoice(id) {
        window.location.href = '<?php echo base_url();?>sells/details/' + id;
    }
    
    function edit_sell_invoice(id) {
        window.location.href = '<?php echo base_url();?>sells/edit/' + id;
    }

    function add_sell_invoice() {
        window.location.href = '<?php echo base_url();?>sells/add';
    }

    function delete_sell_invoice(id) {
        window.location.href = '<?php echo base_url();?>sells/delete/' + id;
    }

    $(document).ready(function () {
        $('[data-tooltip="true"]').tooltip();
        $(document).ready(function () {
            $('#datatable-buttons').DataTable({
                "order": [
                    [ 0, "desc" ]
                ]
            });
        });
    });

    function invoice_status(invoice_id, status) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>sells/status',
            dataType: 'json',
            data: {'id': invoice_id, 'status': status},
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.valid) {
                    if (data.success_message == 1) {
                        var status = 1;
                        $('#status_' + invoice_id).html('<div class="active-invoice"><a onclick="invoice_status(' + invoice_id + ',' + status + ')" id="' + invoice_id + '" title="Click to set inactive" data-tooltip="true" href="javascript:void(0)"> <span class="label label-success">Active</span> </a></div>');
                    }
                    else {
                        var status = 0;
                        $('#status_' + invoice_id).html('<div class="deactive-invoice"><a onclick="invoice_status(' + invoice_id + ',' + status + ')" id="' + invoice_id + '" title="Click to set active" data-tooltip="true" href="javascript:void(0)"> <span class="label label-inverse">Inactive</span> </a></div>');
                    }
                }
            }
        });
    }
</script>