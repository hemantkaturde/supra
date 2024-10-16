
<?php $data = $getsamplingmasterdataforedit[0];?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Sampling Method
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Sampling Method</a></li>
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
                            <h3 class="box-title">Edit Sampling Method Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewsamplingmethodfrom" action="<?php echo base_url() ?>addnewsamplingmethod" method="post" role="form">
                            <div class="box-body">

                            <input type="hidden" class="form-control" id="sampling_master_id" value="<?=$data['sampling_master_id'];?>" name="sampling_master_id" required>
                            <input type="hidden" class="form-control" id="sampling_method_id" value="<?=$data['id'];?>" name="sampling_method_id" required>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="instrument_name">Instrument Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="instrument_name" value="<?=$data['instrument_name'];?>" name="instrument_name" required>
                                            <p class="error instrument_name_error"></p>
                                        </div>
                                    </div>
                                </div>

                               <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="measuring_size">Measuring Size <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="measuring_size"  value="<?=$data['measuring_size'];?>" name="measuring_size" required>
                                            <p class="error measuring_size_error"></p>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sampling_method_name">Type<span class="required">*</span></label>
                                                <select class="form-control" name="type" id="type">
                                                    <option st-id="" value="">Select Part Name</option>
                                                        <option value="GO" <?php if($data['type']=='GO'){ echo 'Selected';} ?>>GO</option>
                                                        <option value="NOGO" <?php if($data['type']=='NOGO'){ echo 'Selected';} ?>>NOGO</option>
                                                        <option value="GO/NOGO" <?php if($data['type']=='GO/NOGO'){ echo 'Selected';} ?>>GO/NOGO</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                <textarea type="text" class="form-control"  id="remark"  name="remark" required><?=$data['remark'];?></textarea>
                                                <p class="error remark_error"></p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="updatenewsamplingmethodsubmit" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>addsamplingmethod/<?=$data['sampling_master_id']?>'" class="btn btn-default" value="Back" />
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
