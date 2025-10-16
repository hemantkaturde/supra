<?php $data=$getVendordata[0];?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Vendor
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Edit Vendor Master</a></li>
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
                            <h3 class="box-title">Edit Vendor Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="updatevendorform" action="<?php echo base_url() ?>updatevendorform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="vendor_name" value="<?=$data['vendor_name']?>" name="vendor_name">
                                            <input type="hidden" class="form-control" id="vendor_id" value="<?=$data['ven_id']?>" name="vendor_id">
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="landline">Landline</label>
                                            <input type="text" class="form-control" maxlength="12" id="landline" value="<?=$data['landline']?>" name="landline" required>
                                            <p class="error landline_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Address <span class="required">*</span></label>
                                                <textarea type="text" class="form-control" id="address"  name="address" required><?=$data['address']?></textarea>
                                                <p class="error address_error"></p>
                                            </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_1">Phone 1 (10 Digit Number)</label>
                                            <input type="text" class="form-control" value="<?=$data['phone1']?>"  maxlength="10" id="phone_1" name="phone_1" >
                                            <p class="error phone_1_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_person">Contact Person</label>
                                            <input type="text" class="form-control" value="<?=$data['contact_person']?>" id="contact_person" name="contact_person" required>
                                            <p class="error contact_person_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile">Mobile <span class="required">*</span></label>
                                            <input type="text" class="form-control" value="<?=$data['mobile']?>" maxlength="10" id="mobile" id="mobile"  name="mobile">
                                            <p class="error mobile_error"></p>
                                        </div>
                                    </div>
                                </div>    

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email <span class="required">*</span></label>
                                            <input type="text" class="form-control" value="<?=$data['email']?>" id="email" name="email">
                                            <p class="error email_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile_2">Mobile 2 (10 Digit Number)</label>
                                            <input type="text" class="form-control" value="<?=$data['mobile2']?>" maxlength="10" id="mobile_2" name="mobile_2">
                                            <p class="error mobile_2_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fax">FAX </label>
                                            <input type="text" class="form-control" value="<?=$data['fax']?>" id="fax" name="fax">
                                            <p class="error fax_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="GSTIN">GSTIN</label>
                                            <input type="text" class="form-control" value="<?=$data['GSTIN']?>" id="GSTIN" name="GSTIN">
                                            <p class="error GSTIN_error"></p>
                                        </div>
                                    </div>
                                </div>

                                  <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                             <label for="city">City</label>
                                                <select class="form-control city" name="city" id="city">
                                                    <option st-id="" value="">Select City</option>
                                                    <option value="Mumbai" <?= ($data['city'] == 'Mumbai') ? 'selected' : '' ?>>Mumbai</option>
                                                    <option value="Rajkot" <?= ($data['city'] == 'Rajkot') ? 'selected' : '' ?>>Rajkot</option>
                                                    <option value="Jamnagar" <?= ($data['city'] == 'Jamnagar') ? 'selected' : '' ?>>Jamnagar</option>


                                                </select>
                                            <p class="error fax_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rate">Rate</label>
                                            <input type="text" class="form-control" id="rate" value="<?=$data['rate']?>"  name="rate">
                                            <p class="error rate_error"></p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="updatevendor" class="btn btn-primary" value="Update" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>vendormaster'" class="btn btn-default" value="Back" />
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