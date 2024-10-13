
<?php $data=$getsamplingdata[0];?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Sampling 
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Edit Sampling Master</a></li>
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
                            <h3 class="box-title">Edit Sampling Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="editsamplingform" action="<?php echo base_url() ?>editsamplingform" method="post" role="form">
                            <div class="box-body">
                            <input type="hidden" class="form-control" id="sampling_method_id" value="<?=$data['id']?>" name="sampling_method_id" required>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="part_number">Part Number<span class="required">*</span></label>
                                                <select class="form-control" name="part_number_id" id="part_number_id" style="width: 390px !important;">
                                                    <option st-id="" value="">Select Part Name</option>
                                                        <?php foreach ($finishgoodList as $key => $value) {
        
                                                                if($value['fin_id']==$data['part_number_id']){
                                                                    $selected = 'Selected';
                                                                }else{
                                                                    $selected ='';
                                                                }
                                                        
                                                            ?>        
                                                            <option value="<?php echo $value['fin_id']; ?>" <?=$selected?>><?php echo $value['part_number']; ?></option>
                                                        <?php } ?>
                                                </select>
                                                <p class="error part_number_id_error"></p>

                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sampling_method_name">Sampling Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="sampling_method_name" value="<?=$data['sampling_method_name']?>" name="sampling_method_name" required>
                                            <p class="error sampling_method_name_error"></p>

                                        </div>
                                    </div>
                                </div> -->
<!-- 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="measuring_size">Measuring Size <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="measuring_size" value="<?=$data['measuring_size']?>" name="measuring_size" required>
                                            <p class="error measuring_size_error"></p>

                                        </div>
                                    </div>
                                </div> -->


                                <!-- <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sampling_method_name">Type<span class="required">*</span></label>
                                                <select class="form-control" name="type" id="type">
                                                    <option st-id="" value="">Select Part Name</option>
                                                        <option value="GO" <?php if($data['type']=='GO'){ echo 'selected';} ?>>GO</option>
                                                        <option value="NOGO" <?php if($data['type']=='NOGO'){ echo 'selected';} ?>>NOGO</option>
                                                </select>
                                        </div>
                                    </div>
                                </div> -->
                                
                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                <textarea type="text" class="form-control"  id="remark"  name="remark"><?=$data['remark']?></textarea>
                                                <p class="error remark_error"></p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="editsampling" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>samplingmaster'" class="btn btn-default" value="Back" />
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