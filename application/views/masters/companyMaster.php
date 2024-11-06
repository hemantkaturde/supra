<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Company Management
            <small>Update </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-8">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Update Company Infromation</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="updateCompanyInfoform" action="<?php echo base_url() ?>UpdateCompanyInfo" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_name">Comapny Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" value="<?=$getCompanyInfo->company_name?>" id="company_name" name="company_name" required>
                                            <input type="hidden" class="form-control" value="<?=$getCompanyInfo->id?>" id="company_id" name="company_id">
                                            <p class="error company_name_error"></p>

                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_1">Phone 1 (10 Digit Number)<span class="required">*</span></label>
                                            <input type="text" class="form-control" maxlength="100" id="phone_1" value="<?=$getCompanyInfo->phone_1?>" name="phone_1" required>
                                            <p class="error phone_1_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="company_address">Comapny Address <span class="required">*</span></label>
                                                <textarea type="text" class="form-control"  id="company_address"  name="company_address" required> <?=$getCompanyInfo->company_address?></textarea>
                                                <p class="error company_address_error"></p>
                                            </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_2">Phone 2 (10 Digit Number)</label>
                                            <input type="text" class="form-control"  maxlength="100" id="phone_2" name="phone_2"  value="<?=$getCompanyInfo->phone_2?>">
                                            <p class="error phone_2_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Website">Website <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="Website" value="<?=$getCompanyInfo->Website?>" name="Website" required>
                                            <p class="error Website_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Email">Email <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="email" value="<?=$getCompanyInfo->email?>"  name="email" required>
                                            <p class="error email_error"></p>
                                        </div>
                                    </div>
                                </div>    

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="GSTIN">GSTIN <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="GSTIN" value="<?=$getCompanyInfo->GSTIN?>"   name="GSTIN" required>
                                            <p class="error GSTIN_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="updateCompanyInfo" class="btn btn-primary" value="Update" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>dashboard'" class="btn btn-default" value="Back" />
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