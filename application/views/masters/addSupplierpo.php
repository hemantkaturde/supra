<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Supplier PO
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Supplier PO Master</a></li>
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
                            <h3 class="box-title">Add Supplier PO Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewSupplierform" action="<?php echo base_url() ?>addnewSupplierform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="po_number">PO Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="po_number" name="po_number" >
                                            <p class="error po_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker"  id="date" name="date" required>
                                            <p class="error date_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="supplier_name">Supplier Name <span class="required">*</span></label>
                                                <select class="form-control" name="supplier_name" id="supplier_name">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                    <?php foreach ($supplierList as $key => $value) {?>
                                                    <option value="<?php echo $value['sup_id']; ?>"><?php echo $value['supplier_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error supplier_name_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="type_of_row_material">Type Of Raw Materail <span class="required">*</span></label>
                                                <select class="form-control" name="type_of_row_material" id="type_of_row_material">
                                                    <option st-id="" value="">Select Type Of Raw Materail</option>
                                                    <?php foreach ($rowMaterialList as $key => $value) {?>
                                                    <option value="<?php echo $value['raw_id']; ?>"><?php echo $value['part_number']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error type_of_row_material_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                   <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="part_number">Part Number <span class="required">*</span></label>
                                                <select class="form-control" name="part_number" id="part_number">
                                                    <option st-id="" value="">Select Part Name</option>
                                                    <?php foreach ($rowMaterialList as $key => $value) {?>
                                                    <option value="<?php echo $value['raw_id']; ?>"><?php echo $value['part_number']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error part_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                                <select class="form-control" name="buyer_name" id="buyer_name">
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                    <?php foreach ($buyerList as $key => $value) {?>
                                                    <option value="<?php echo $value['buyer_id']; ?>"><?php echo $value['buyer_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>
                                </div>    

                                <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                                <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                                <select class="form-control" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>"><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="work_order">Total Amount <span class="required">*</span></label>
                                                <input type="text" class="form-control"  id="total_amount" name="total_amount">
                                                <p class="error total_amount_error"></p>
                                            </div>
                                        </div>
                                </div>

                                <div class="row">

                                       <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="work_order">Quatation Ref.No <span class="required">*</span></label>
                                                <input type="text" class="form-control"  id="qt_ref_number" name="qt_ref_number">
                                                <p class="error qt_ref_number_error"></p>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="quatation_date">Quatation Date <span class="required">*</span></label>
                                                <input type="text" class="form-control datepicker" id="quatation_date" name="quatation_date">
                                                <p class="error quatation_date_error"></p>
                                            </div>
                                        </div>
                                </div>

                                <div class="row">
                                  

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_quantity">Delivery Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" id="delivery_date" name="delivery_date">
                                            <p class="error delivery_date_error"></p>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="delivery">Delivery<span class="required">*</span></label>
                                                <input type="text" class="form-control"  id="delivery" name="delivery">
                                                <p class="error delivery_error"></p>
                                            </div>
                                        </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="work_order">Work Order<span class="required">*</span></label>
                                                <input type="text" class="form-control"  id="work_order" name="work_order">
                                                <p class="error work_order_error"></p>
                                            </div>
                                        </div>

                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                  <textarea type="text" class="form-control"  id="remark"  name="remark" required></textarea>
                                                <p class="error remark_error"></p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewsupplierpo" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>supplierpo'" class="btn btn-default" value="Back" />
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script>
   $(function() {
			$(".datepicker").datepicker({ 
				minDate: 0,
				todayHighlight: true,
                dateFormat: 'yy-mm-dd',
				startDate: new Date()
			});
		});
</script>

