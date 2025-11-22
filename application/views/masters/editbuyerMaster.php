<?php $data=$getBuyergmasterdata[0];?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i>  Edit Buyer
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Edit Buyer Master</a></li>
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
                            <h3 class="box-title">Edit Buyer Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="editebuyerform" action="<?php echo base_url() ?>editebuyerform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                            <input type="text" value="<?=$data['buyer_name']?>"  class="form-control" id="buyer_name" name="buyer_name">
                                            <input type="hidden" value="<?=$data['buyer_id']?>"  class="form-control" id="buyer_id" name="buyer_id">

                                            <p class="error buyer_name_error"></p>

                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="currency">Currency <span class="required">*</span></label>
                                            <input type="text" class="form-control" value="<?=$data['currency']?>"  id="currency" name="currency" required>
                                            <p class="error currency_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Address <span class="required">*</span></label>
                                                <textarea type="text" class="form-control"  id="address"  name="address"><?php echo $data['address']; ?></textarea>
                                                <p class="error address_error"></p>
                                            </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="landline">Landline</label>
                                            <input type="text" class="form-control" value="<?=$data['landline']?>"  id="landline" name="landline" >
                                            <p class="error landline_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                   <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile">Mobile</label>
                                            <input type="text" class="form-control" value="<?=$data['mobile']?>" maxlength="10" id="mobile" id="mobile"  name="mobile">
                                            <p class="error mobile_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_person">Contact Person </label>
                                            <input type="text" class="form-control" value="<?=$data['contact_person']?>" id="contact_person" name="contact_person" required>
                                            <p class="error contact_person_error"></p>
                                        </div>
                                    </div>
                                </div>    

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control"  value="<?=$data['email']?>"  id="email" name="email">
                                            <p class="error email_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="GSTIN">GSTIN</label>
                                            <input type="text" class="form-control"  value="<?=$data['GSTIN']?>"  id="GSTIN" name="GSTIN">
                                            <p class="error GSTIN_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country">Country<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="country"   value="<?=$data['country']?>" name="country">
                                            <p class="error country_error"></p>
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_short_name">Buyer Short Name</label>
                                            <input type="text" class="form-control" id="buyer_short_name"  value="<?=$data['buyer_short_name']?>" name="buyer_short_name">
                                            <p class="error buyer_short_name_error"></p>
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_country_short_name">Buyer Country Short Name</label>
                                            <input type="text" class="form-control" id="buyer_country_short_name" value="<?=$data['buyer_country_short_name']?>" name="buyer_country_short_name">
                                            <p class="error buyer_country_short_name_error"></p>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="updateBuyer" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>buyermaster'" class="btn btn-default" value="Back" />
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