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

        <div class="card-box">

            <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-info-circle"></i> <?php echo $sidebar_menu; ?></h4>
            <form action="<?php echo base_url(); ?>roles/add" class="form-horizontal row-border" method="post"
                  name="form1" id="form1">
                <input type="hidden" name="action" id="action" value="">
                <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Role Name
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control required" parsley-trigger="change"
                                       placeholder="Role Name" name="data[name]" id="name"
                                       value="<?php echo set_value('data[name]'); ?>">
                            </div>
                        </div>
                    </div><!-- end col -->

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">&nbsp;</label>
                            <div class="col-md-9">
                                <button class="btn btn-primary waves-effect waves-light" type="submit"><i
                                        class="fa fa-check" aria-hidden="true"></i> Submit
                                </button>
                                <button type="button" class="btn" onclick="javascript:role_cancel();"><i
                                        class="fa fa-ban" aria-hidden="true"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function role_cancel() {
        window.location.href = '<?php echo base_url();?>roles';
    }
</script>