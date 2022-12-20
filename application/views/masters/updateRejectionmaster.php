
<?php $data=$getRejectiongmasterdata[0];?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Update Rejection 
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Update Rejection Master</a></li>
                </ul>
            </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-8">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Update Rejection Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="updatenewRejectionform" action="<?php echo base_url() ?>updatenewRejectionform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rejection_reason">Rejection Reason <span class="required">*</span></label>
                                            <input type="text" class="form-control" value="<?=$data['rejection_reason'] ?>" id="rejection_reason" name="rejection_reason">
                                            <input type="hidden" class="form-control" value="<?=$data['rejec_id'] ?>" id="rejection_reason_id" name="rejection_reason_id">
                                            <p class="error rejection_reason_error"></p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="updateRejection" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>rejectionmaster'" class="btn btn-default" value="Back" />
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>