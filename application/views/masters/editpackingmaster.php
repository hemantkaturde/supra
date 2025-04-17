<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Packing Master
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Packing Master</a></li>
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
                            <h3 class="box-title">Edit Packing Master</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewpackingmasterform" action="<?php echo base_url() ?>addnewpackingmasterform" method="post" role="form">
                            <div class="box-body">

                            <input type="hidden" class="form-control" id="packing_master_id" value="<?php echo $getpreviouspackingmasterdata[0]['id'] ?>" name="packing_master_id">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description">Description <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="description" value="<?php echo $getpreviouspackingmasterdata[0]['description'] ?>" name="description">
                                            <p class="error description_error"></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">HSN Code</label>
                                                <input type="text" class="form-control" id="hsn_code" name="hsn_code" value="<?php echo $getpreviouspackingmasterdata[0]['HSN'] ?>">
                                                <p class="error hsn_code_error"></p>
                                            </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                             <textarea id="remark" name="remark" rows="4" cols="57"><?php echo $getpreviouspackingmasterdata[0]['remark'] ?> </textarea>
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewpackingmaster" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>packingmaster'" class="btn btn-default" value="Back" />
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