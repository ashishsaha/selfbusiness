<div class="row">
    <div class="col-sm-12">
        <?php if (isset($validation_error)) { ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php  echo $validation_error; ?>
            </div>
        <?php } ?>

        <?php if (isset($upload_validation_error)) { ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php  echo $upload_validation_error; ?>
            </div>
        <?php } ?>

        <div class="card-box">
            <?php //echo '<pre>'; print_r($data); ?>
            <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-info-circle"></i> <?php echo $sidebar_menu; ?></h4>
            <form action="<?php echo base_url(); ?>settings/edit/<?php echo $setting_id; ?>" class="form-horizontal row-border"
                  method="post"
                  name="form1" id="form1" enctype="multipart/form-data">
                <?php //echo form_open_multipart('iconimages/add');?>
                <input type="hidden" name="action" id="action" value="">
                <input type="hidden" name="OkSaveData" id="OkSaveData" value="TRUE">

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Company Name
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <input type="number" class="form-control required" parsley-trigger="change"
                                       placeholder="Appointment Duration (Minutes: Ex: 30, 40)" name="data[appointment_duration]" id="box_bg_color"
                                       value="<?php echo $data[0]->name; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Contact Number
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">
                                <input type="number" class="form-control required" parsley-trigger="change"
                                       placeholder="Appointment Duration (Minutes: Ex: 30, 40)" name="data[appointment_duration]" id="box_bg_color"
                                       value="<?php echo $data[0]->contact_no; ?>">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is show Background color on Customer Interface?">Show BG on CI
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_show_bg_on_customer_panel" title="Is show Background color on Customer Interface?" name="data[is_show_bg_on_customer_panel]" <?php if($data[0]->is_show_bg_on_customer_panel){?> checked="" <?php }?> aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is show text color on customer Interface?">Show Text Color
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_show_text_color_on_customer_panel" title="Is show text color on customer Interface?" name="data[is_show_text_color_on_customer_panel]" <?php if($data[0]->is_show_text_color_on_customer_panel){?> checked="" <?php }?> aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" title="Is show logo on Cusomer Interface?">Show logo on CI
                                <!--&nbsp;<span class="red">*</span>--></label>
                            <div class="col-md-9">

                                <div class="checkbox checkbox-success checkbox-single">
                                    <input id="is_show_logo_on_cutomer_panel" title="Is show logo on Cusomer Interface?" name="data[is_show_logo_on_cutomer_panel]" <?php if($data[0]->is_show_logo_on_cutomer_panel){?> checked="" <?php }?> aria-label="Single checkbox Two" type="checkbox">
                                    <label></label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">&nbsp;</label>
                            <div class="col-md-9">
                                <button class="btn btn-primary waves-effect waves-light" type="submit"><i
                                        class="fa fa-check" aria-hidden="true"></i> Submit
                                </button>
                                <button type="button" class="btn"
                                        onclick="javascript:setting_cancel();"><i
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
    function setting_cancel() {
        window.location.href = '<?php echo base_url();?>settings';
    }
</script>