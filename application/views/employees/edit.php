<div class="row">
    <div class="col-sm-12">
        <?php if (isset($validation_error)) { ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php if ($validation_error != '') {
                    echo $validation_error;
                } ?>
            </div>
        <?php } ?>

        <?php if ($this->session->userdata('flash_msgs')) { ?>
            <div class="alert alert-<?php echo $this->session->userdata('alerts'); ?> alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $this->session->userdata('flash_msgs');
                $this->session->unset_userdata('flash_msgs'); ?>
            </div>
        <?php } ?>

        <form action="<?php echo base_url(); ?>employees/edit/<?php echo $employee_id;?>" class="form-horizontal row-border" method="post"
              name="form1" id="form1" enctype="multipart/form-data">
            <input type="hidden" name="action" id="action" value="">
            <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
            <input type="hidden" name="option_upload" id="option_upload" value="0">

            <div class="card-box">
                <div class="row">
                    <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-arrows"></i> Update Employee/Labor
                    </h4>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Full Name</label>
                            <div class="col-md-9">
                                <input class="form-control required" placeholder="Employee/Labor Name" type="text"
                                       name="data[full_name]" id="full_name" parsley-trigger="change"
                                       value="<?php echo $employee_data->full_name;?>"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Contact No</label>
                            <div class="col-md-9">
                                <input class="form-control required" placeholder="Contact Number"
                                       type="text"
                                       name="data[contact_number]" id="contact_number" parsley-trigger="change"
                                       value="<?php echo $employee_data->contact_number;?>"/>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-6">
                        <div class="form-group address_div">
                            <label class="col-md-3 control-label" title="Employee Address">Address</label>
                            <div class="col-md-9">
                                <input class="form-control required" placeholder="Employee Address"
                                       type="text"
                                       name="data[address]" id="address" parsley-trigger="change"
                                       value="<?php echo $employee_data->address;?>"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is Employee?">Employee Type</label>
                            <div class="col-md-9">
                                <select class="form-control required" name="data[employee_type]" id="employee_type">
                                    <option value="1" <?php if($employee_data->employee_type == 1){?>selected="selected"<?php } ?>>Casual Labor</option>
                                    <option value="2" <?php if($employee_data->employee_type == 2){?>selected="selected"<?php } ?>>Labor</option>
                                    <option value="3" <?php if($employee_data->employee_type == 3){?>selected="selected"<?php } ?>>Employee</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">&nbsp;</label>
                            <div class="col-md-9">
                                <button class="btn btn-primary waves-effect waves-light" type="submit"> Update Info
                                </button>
                                <button type="button" class="btn" onclick="javascript:employee_cancel();">Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>


<style type="text/css">
    .form-horizontal .checkbox {
        padding-top: 0 !important;
    }
    .address_div .col-md-3{
        width: 12.5%;
    }
    .address_div .col-md-9{
        width: 87.5%;
    }
</style>
<script type="text/javascript">
    function employee_cancel(){
        window.location.href = '<?php echo base_url();?>employees';
    }
</script>