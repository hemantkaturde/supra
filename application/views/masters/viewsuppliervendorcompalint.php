<style>
    .select2-container--default{

       width: 287px !important;
}
    </style>
  <?php //print_r($getsuppliervendorcomplaintdata);exit; ?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> View Supplier Vendor Complaint Form
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Supplier Vendor Complaint Form</a></li>
                </ul>
            </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">View Supplier Vendor Complaint</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewsuppliervendorcomplaintform" action="<?php echo base_url() ?>addnewsuppliervendorcomplaint" method="post" role="form">
                            <div class="box-body">
                                <div class="row">

                                     <input readonly type="hidden" class="form-control" id="suppliervendor_compalint_id" name="suppliervendor_compalint_id" value="<?=$getsuppliervendorcomplaintdata['suppliervendor_compalint_id']?>" readonly>
                                     <input readonly type="hidden" class="form-control" id="supplier_po_id" name="supplier_po_id" value="<?=$getsuppliervendorcomplaintdata['supplier_po_id']?>" readonly>
                                     <input readonly type="hidden" class="form-control" id="vendor_po_id" name="vendor_po_id" value="<?=$getsuppliervendorcomplaintdata['vendor_po_id']?>" readonly>
                                     <input readonly type="hidden" class="form-control" id="supplier_part_number_id" name="supplier_part_number_id" value="<?=$getsuppliervendorcomplaintdata['supplier_part_number_id']?>" readonly>
                                     <input readonly type="hidden" class="form-control" id="vendor_part_number_id" name="vendor_part_number_id" value="<?=$getsuppliervendorcomplaintdata['vendor_part_number_id']?>" readonly>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="report_number">Report No <span class="required">*</span></label>
                                             <input readonly type="text" class="form-control" id="report_number" name="report_number" value="<?=$getsuppliervendorcomplaintdata['report_number']?>" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="stage">Stage <span class="required">*</span></label>
                                            <select disabled class="form-control" name="stage" id="stage">
                                                  <option value="NA">Select Stage</option>
                                                  <option value="Incoming" <?php if($getsuppliervendorcomplaintdata['stage']=='Incoming'){ echo 'selected'; } ?>>Incoming</option>
                                                  <option value="Inprogress" <?php if($getsuppliervendorcomplaintdata['stage']=='Inprogress'){ echo 'selected'; } ?>>Inprogress</option>
                                                  <option value="Final Inspection" <?php if($getsuppliervendorcomplaintdata['stage']=='Final Inspection'){ echo 'selected'; } ?>>Final Inspection</option>
                                                  <option value="At Vendor End" <?php if($getsuppliervendorcomplaintdata['stage']=='At Vendor End'){ echo 'selected'; } ?>>At Vendor End</option>
                                                  <option value="At Supplier End" <?php if($getsuppliervendorcomplaintdata['stage']=='At Supplier End'){ echo 'selected'; } ?>>At Supplier End</option>
                                            </select>
                                            <p class="error stage_error"></p>
                                        </div>
                                    </div>
                        
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="challan_no">Challan No</label>
                                                <input readonly type="text" class="form-control" id="challan_no" value="<?=$getsuppliervendorcomplaintdata['challan_number']?>" name="challan_no">
                                            <p class="error challan_no_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="challan_date">Challan Date</label>
                                                 <input readonly type="text" class="form-control datepicker" id="challan_date" value="<?=$getsuppliervendorcomplaintdata['challan_date']?>" name="challan_date">                                  
                                            <p class="error challan_date_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="invoice_no">Invoice No</label>
                                             <input readonly type="text" class="form-control" id="invoice_no" value="<?=$getsuppliervendorcomplaintdata['invoice_number']?>"  name="invoice_no">
                                            <p class="error invoice_no_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="invoice_date">Invoice Date</label>
                                             <input readonly type="text" class="form-control datepicker" id="invoice_date"  value="<?=$getsuppliervendorcomplaintdata['invoice_date']?>" name="invoice_date">
                                            <p class="error invoice_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="vendor_supplier">Select Supplier / Vendor</label>
                                            <select disabled class="form-control" name="vendor_supplier" id="vendor_supplier">
                                                  <option value="NA">Select Supplier / Vendor</option>
                                                  <option value="Supplier" <?php if($getsuppliervendorcomplaintdata['vendor_supplier']=='Supplier'){ echo 'selected'; } ?>>Supplier</option>
                                                  <option value="Vendor" <?php if($getsuppliervendorcomplaintdata['vendor_supplier']=='Vendor'){ echo 'selected'; } ?>>Vendor</option>
                                            </select>
                                            <p class="error vendor_supplier_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="supplier_div" style="display:none"> 
                                        <div class="form-group">
                                            <label for="supplier_name">Supplier Name</label>
                                                <select class="form-control" name="supplier_name" id="supplier_name">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                    <?php foreach ($supplierList as $key => $value) {?>
                                                    <option value="<?php echo $value['sup_id']; ?>" <?php if($getsuppliervendorcomplaintdata['supplier_id']==$value['sup_id']){ echo 'selected'; } ?>><?php echo $value['supplier_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error supplier_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="vendor_div" style="display:none">
                                        <div class="form-group">
                                            <label for="vendor_name">Vendor Name</label>
                                                    <select class="form-control" name="vendor_name" id="vendor_name">
                                                        <option st-id="" value="">Select Vendor Name</option>
                                                        <?php foreach ($vendorList as $key => $value) {?>
                                                        <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$getsuppliervendorcomplaintdata['vendor_id']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>
                                </div>

                              
                                <div class="row">
                                    <div class="col-md-3" id="supplier_po_number_div" style="display:none">
                                        <div class="form-group">
                                            <label for="supplier_po_number">Supplier PO</label>
                                            <select class="form-control" name="supplier_po_number" id="supplier_po_number">
                                            </select> 
                                            <p class="error supplier_po_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3" id="vendor_po_number_div"  style="display:none">
                                        <div class="form-group">
                                            <label for="vendor_po">Vendor PO</label>
                                            <select class="form-control" name="vendor_po_number" id="vendor_po_number">
                                            </select> 
                                            <p class="error vendor_po_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3" id="supplier_part_number_div"  style="display:none">
                                        <div class="form-group">
                                            <label for="supplier_part_number">Part Number / Drawing No / Rev No</label>
                                            <select class="form-control" name="supplier_part_number" id="supplier_part_number">
                                            </select> 
                                            <p class="error supplier_part_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3" id="vendor_part_number_div"  style="display:none">
                                        <div class="form-group">
                                            <label for="vendor_part_number">Part Number / Drawing No / Rev No</label>
                                            <select class="form-control" name="vendor_part_number" id="vendor_part_number">
                                            </select> 
                                            <p class="error vendor_part_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="part_description">Part Description / Component</label>
                                             <input readonly type="text" class="form-control" id="part_description" value="<?=$getsuppliervendorcomplaintdata['part_description']?>" name="part_description">
                                            <p class="error part_description_error"></p>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="problem_occurs">Problem Occurs</label>
                                             <input readonly type="text" class="form-control" id="problem_occurs" value="<?=$getsuppliervendorcomplaintdata['problem_occurs']?>"  name="problem_occurs">
                                            <p class="error problem_occurs_error"></p>
                                        </div>
                                    </div> -->
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="received_qty">Received Qty</label>
                                             <input readonly type="text" class="form-control" id="received_qty" value="<?=$getsuppliervendorcomplaintdata['received_qty']?>" name="received_qty">
                                            <p class="error received_qty_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="order_qty">Order Quantity</label>
                                             <input readonly type="text" class="form-control" id="order_qty" value="<?=$getsuppliervendorcomplaintdata['order_qty']?>" name="order_qty">
                                            <p class="error order_qty_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="total_failure_qty">Total Failure Quantity</label>
                                             <input readonly type="text" class="form-control" id="total_failure_qty" value="<?=$getsuppliervendorcomplaintdata['total_failure_qty']?>" name="total_failure_qty">
                                            <p class="error total_failure_qty_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="total_quantity_checked">Total Quantity Checked</label>
                                             <input readonly type="text" class="form-control" id="total_quantity_checked" value="<?=$getsuppliervendorcomplaintdata['total_quantity_checked']?>" name="total_quantity_checked">
                                            <p class="error total_quantity_checked_error"></p>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="problem_description">Problem Description</label>
                                             <input readonly type="text" class="form-control" id="problem_description" value="<?=$getsuppliervendorcomplaintdata['problem_description']?>" name="problem_description">
                                            <p class="error problem_description_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="root_case">Root Cause</label>
                                             <input readonly type="text" class="form-control" id="root_case" value="<?=$getsuppliervendorcomplaintdata['root_case']?>" name="root_case">
                                            <p class="error root_case_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="correction">Correction</label>
                                             <input readonly type="text" class="form-control" id="correction"  value="<?=$getsuppliervendorcomplaintdata['correction']?>" name="correction">
                                            <p class="error correction_error"></p>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="effective_action">Effective Action</label>
                                             <input readonly type="text" class="form-control" id="effective_action" value="<?=$getsuppliervendorcomplaintdata['effective_action']?>" name="effective_action">
                                            <p class="error effective_action_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="responsibility_1">Responsibility</label>
                                             <input readonly type="text" class="form-control" id="responsibility_1" value="<?=$getsuppliervendorcomplaintdata['responsibility_1']?>"  name="responsibility_1">
                                            <p class="error responsibility_1_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date_1">Date</label>
                                             <input readonly type="text" class="form-control datepicker" id="date_1" value="<?=$getsuppliervendorcomplaintdata['date_1']?>"  name="date_1">
                                            <p class="error date_1_error"></p>
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="corrective_action_taken">Corrective Action Taken</label>
                                             <input readonly type="text" class="form-control" id="corrective_action_taken"  value="<?=$getsuppliervendorcomplaintdata['corrective_action_taken']?>" name="corrective_action_taken">
                                            <p class="error corrective_action_taken_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="responsibility_2">Responsibility</label>
                                             <input readonly type="text" class="form-control" id="responsibility_2"  value="<?=$getsuppliervendorcomplaintdata['responsibility_2']?>" name="responsibility_2">
                                            <p class="error responsibility_2_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date_2">Date</label>
                                             <input readonly type="text" class="form-control datepicker" id="date_2" value="<?=$getsuppliervendorcomplaintdata['date_2']?>" name="date_2">
                                            <p class="error date_2_error"></p>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="prepared_by">Prepared  By</label>
                                             <input readonly type="text" class="form-control" id="prepared_by" value="<?=$getsuppliervendorcomplaintdata['prepared_by']?>" name="prepared_by">
                                            <p class="error prepared_by_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date_3">Date</label>
                                             <input readonly type="text" class="form-control datepicker" id="date_3" value="<?=$getsuppliervendorcomplaintdata['date_3']?>" name="date_3">
                                            <p class="error date_3_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="apprroved_by">Apprroved By</label>
                                             <input readonly type="text" class="form-control" id="apprroved_by" value="<?=$getsuppliervendorcomplaintdata['apprroved_by']?>" name="apprroved_by">
                                            <p class="error apprroved_by_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date_4">Date</label>
                                             <input readonly type="text" class="form-control datepicker" id="date_4" value="<?=$getsuppliervendorcomplaintdata['date_4']?>" name="date_4">
                                            <p class="error date_4_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="report_close_by">Report Close By</label>
                                             <input readonly type="text" class="form-control" id="report_close_by" value="<?=$getsuppliervendorcomplaintdata['report_close_by']?>" name="report_close_by">
                                            <p class="error report_close_by_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date_5">Date</label>
                                             <input readonly type="text" class="form-control datepicker" id="date_5" name="date_5" value="<?=$getsuppliervendorcomplaintdata['date_5']?>">
                                            <p class="error date_5_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="accept_with_deviation">Accept With Deviation</label>
                                             <input readonly type="text" class="form-control" id="accept_with_deviation" name="accept_with_deviation" value="<?=$getsuppliervendorcomplaintdata['accept_with_deviation']?>">
                                            <p class="error accept_with_deviation_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="do_not_accept_with_deviation">Do Not Accept / Qty Return</label>
                                             <input readonly type="text" class="form-control" id="do_not_accept_with_deviation" name="do_not_accept_with_deviation" value="<?=$getsuppliervendorcomplaintdata['do_not_accept_with_deviation']?>">
                                            <p class="error do_not_accept_with_deviation_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                             <input readonly type="text" class="form-control" id="remark" name="remark" value="<?=$getsuppliervendorcomplaintdata['remark']?>">
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                 <input readonly type="button" onclick="location.href = '<?php echo base_url() ?>suppliervendorcompliant'" class="btn btn-default" value="Back" />
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
   $(document).ready(function(){
			$("select").select2();
   });
   
   $(function() {
    $(".datepicker").datepicker({ 
        // minDate: 0,
        todayHighlight: true,
                     dateFormat: 'yy-mm-dd',
        startDate: new Date()
    });
   });
</script>
