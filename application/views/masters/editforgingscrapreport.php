<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Forging Scarp Working
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Packing Forging Scarp Working</a></li>
                </ul>
            </small>
        </h1>
    </section>


    <?php  //print_r($getforgindataforedit[0]['vendor_po_number_master']);exit; ?>


    <section class="content">
        <div class="row">
            <div class="col-xs-8">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Edit Forging Scarp Working</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewforgingscarpworkingform" action="<?php echo base_url() ?>addnewforgingscarpworkingform" method="post" role="form">
                            <div class="box-body">
                               <div class="col-md-6">    
                                    <div class="col-md-12">

                                        <input type="hidden" class="form-control" id="forgin_id" value="<?=$getforgindataforedit[0]['forgin_id'];?>" name="forgin_id">

                                        <div class="form-group">
                                                <label for="vendor_id">Vendor Name <span class="required">*</span></label>
                                                <select class="form-control " name="vendor_id" id="vendor_id">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id'];?>" <?php if($getforgindataforedit[0]['vendor_master_id']==$value['ven_id']){ echo 'selected'; } ?>><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error vendor_id_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                            <div class="form-group">
                                                    <label for="vendor_po_id">Select Vendor PO Number <span class="required">*</span></label>
                                                    <select class="form-control" name="vendor_po_id" id="vendor_po_id">
                                                        <option st-id="" value="<?=$getforgindataforedit[0]['bom_id'];?>"><?=$getforgindataforedit[0]['vendor_po_number_master'];?></option>
                                                        <option st-id="" value="">Select Vendor PO</option>
                                                    </select> 
                                                <p class="error vendor_po_id_error"></p>
                                            </div>
                                    </div>



                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="supplier_name">Supplier Name</label>
                                            <input type="text" class="form-control" id="supplier_name" value="<?=$getforgindataforedit[0]['supplier_master_name'];?>" name="supplier_name">
                                            <input type="hidden" class="form-control" id="supplier_id" value="<?=$getforgindataforedit[0]['supplier_master_id'];?>" name="supplier_id">

                                            <p class="error supplier_name_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="supplier_po">Supplier PO</label>
                                            <input type="text" class="form-control" id="supplier_po" value="<?=$getforgindataforedit[0]['supplier_po_master'];?>" name="supplier_po">
                                            <input type="hidden" class="form-control" id="supplier_po_id" value="<?=$getforgindataforedit[0]['supplier_po_id_master'];?>" name="supplier_po_id">
                                            <p class="error supplier_po_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <textarea type="text" class="form-control" id="remark"
                                                name="remark"><?=$getforgindataforedit[0]['forgin_scrap_remark'] ?></textarea>
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="addnewforgingscarpworking" class="btn btn-primary" value="Update" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>forgingscarpworkingreport'" class="btn btn-default" value="Back" />
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