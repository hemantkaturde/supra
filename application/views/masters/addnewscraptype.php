<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Scrap Type
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Scrap Type</a></li>
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
                            <h3 class="box-title">Add New Scrap Type</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewscraptypeform" action="<?php echo base_url() ?>addnewscraptypeform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="scrap_type">Scrap Type <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="scrap_type" name="scrap_type">
                                            <p class="error scrap_type_error"></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">HSN Code <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="hsn_code" name="hsn_code">
                                                <p class="error hsn_code_error"></p>
                                            </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                             <textarea id="remark" name="remark" rows="4" cols="57"> </textarea>
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewscraptype" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>scraptype'" class="btn btn-default" value="Back" />
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