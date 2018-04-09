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
                        <button title="Add Pay To Employee" data-tooltip="true" type="button"
                                class="btn btn-success waves-effect waves-light"
                                onclick="javascript:add_pay_to_employee();"><i
                                class="fa fa-plus-circle"></i>&nbsp;<?php echo $add_button;?>
                        </button>
                    </li>
                </ul>
            </h4>
            <?php
            //echo '<pre>';
            //print_r($home_cost_transaction_data);
            ?>
            <table <?php if (count($home_cost_transaction_data) > 0){ ?>id="datatable-buttons"<?php } ?>
                   class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th title="Employee Name">Employee Name</th>
                    <th title="Transaction through">Transaction Type</th>
                    <th title="Transaction Amount">Amount</th>
                    <th title="Salary Month">Month</th>
                    <th title="Transaction Date">Transaction Date</th>
                    <th style="width: 10%">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($home_cost_transaction_data) > 0) {
                    $count = 1;
                    foreach ($home_cost_transaction_data as $transaction_data) {

                        if($transaction_data->trans_type == 0){
                            $trans_type = '<span class="label label-success">Hand Cash</span>';
                        }elseif($transaction_data->trans_type == 1){
                            $trans_type = '<span class="label label-info">Bank Transaction</span>';
                        }else{
                            $trans_type = '<span class="label label-info">Cheque</span>';
                        }
                        ?>
                        <tr id="trans_<?php echo $transaction_data->id; ?>">
                            <td><?php echo $transaction_data->full_name; ?> </td>
                            <td><?php echo $trans_type; ?> </td>
                            <td><?php echo number_format($transaction_data->amount,2); ?></td>
                            <td><?php echo $transaction_data->salary_month; ?> </td>
                            <td><span class="label label-info"><?php echo date("Y-m-d", strtotime($transaction_data->trans_date)); ?></span></td>
                            <td class="actions">
                                <button title="Update" data-tooltip="true" type="button"
                                        class="on-default edit-row" onclick="javascript:edit_pay_to_employee(<?php echo $transaction_data->id; ?>);">
                                    <i class="fa fa-edit"></i></button>
                                &nbsp;

                                <button title="Delete Product" data-tooltip="true" type="button"
                                        class="on-default remove-row" data-toggle="modal"
                                        data-target=".bs-example-modal-sm<?php echo $transaction_data->id; ?>">
                                    <i class="fa fa-trash"></i></button>
                                <div
                                    class="modal fade bs-example-modal-sm<?php echo $transaction_data->id; ?>"
                                    tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Product
                                                    Delete</h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you confirm to delete this transaction?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal"><i
                                                        class="fa fa-times-circle"
                                                        aria-hidden="true"></i> Close
                                                </button>
                                                <button type="button"
                                                        class="btn btn-danger waves-effect waves-light"
                                                        onclick="delete_transaction('<?php echo $transaction_data->id; ?>')">
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

    function add_pay_to_employee() {
        window.location.href = '<?php echo base_url();?>transaction/add_pay_to_employee/';
    }

    function edit_pay_to_employee(id) {
        window.location.href = '<?php echo base_url();?>transaction/edit_pay_to_employee/' + id;
    }

    function home_cost_cancel() {
        $("#adding_form").hide(400);
    }

    function delete_transaction(id) {
        window.location.href = '<?php echo base_url();?>transaction/delete/paytoemployee/' + id;
    }

    $(document).ready(function () {
        $("#adding_form").hide();
        $('[data-tooltip="true"]').tooltip();
        $(document).ready(function () {
            $('#datatable-buttons').DataTable({
                "order": [
                    [ 1, "desc" ]
                ]
            });
        });

        // Date Picker
        $('#trans_date').datepicker();
        $('#trans_date').datepicker({
            autoclose: true,
            todayHighlight: true
        });
    });
</script>