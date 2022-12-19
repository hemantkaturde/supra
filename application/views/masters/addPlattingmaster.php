<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Platting 
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Platting Master</a></li>
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
                            <h3 class="box-title">Add Platting Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewplattingform" action="<?php echo base_url() ?>addnewplattingform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type_of_raw_material">Type Of Raw Material <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="type_of_raw_material" name="type_of_raw_material">
                                            <p class="error type_of_raw_material_error"></p>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type_of_platting">Type Of Platting <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="type_of_platting" name="type_of_platting">
                                            <p class="error type_of_platting_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewPlatting" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>plattingmaster'" class="btn btn-default" value="Back" />
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