<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> View Customer Complaint
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Customer Complaint</a></li>
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
                            <h3 class="box-title">View Customer Complaint</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewcustomercomplaintform" action="<?php echo base_url() ?>addnewcustomercomplaint" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                 <input readonly  type="hidden" class="form-control" id="complaint_form_id" name="complaint_form_id" value="<?=$getcustomercompalindetailsdata[0]['Customer_Complaint_id']?>"  readonly>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="report_number">Report No <span class="required">*</span></label>
                                             <input readonly  type="text" class="form-control" id="report_number" value="<?=$getcustomercompalindetailsdata[0]['report_number']?>" name="report_number" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="customer_name">Customer Name</label>
                                              <select disabled disabled  class="form-control" name="customer_name" id="customer_name">
                                                  <option value="NA">Select Customer Name</option>
                                                    <?php foreach ($buyerList as $key => $value) {?>
                                                        <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$getcustomercompalindetailsdata[0]['buyer_id']){ echo 'selected'; }  ?> ><?php echo $value['buyer_name']; ?></option>
                                                    <?php } ?>
                                            </select>
                                            <p class="error customer_name_error"></p>
                                        </div>
                                    </div>

                                    <?php 
                                         if($getcustomercompalindetailsdata[0]['customer_po']){
                                            $selected = 'selected';
                                            $sales_order_number = '<option value='.$getcustomercompalindetailsdata[0]['customer_po'].'   '.$selected.'>'.$getcustomercompalindetailsdata[0]['sales_order_number'].'</option>';
                                         }else{
                                            $selected = '';
                                            $sales_order_number = '';
                                         }                                         
                                    ?>
                        
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="customer_po">Customer PO</label>
                                              <select disabled readonly  class="form-control" name="customer_po" id="customer_po">
                                               <?=$sales_order_number?>
                                               <option value="NA">Select Customer PO</option>
                                            </select>
                                            <p class="error customer_po_error"></p>
                                        </div>
                                    </div>


                                    <?php 
                                         if($getcustomercompalindetailsdata[0]['part_no']){
                                            $selected = 'selected';
                                            $part_number = '<option value='.$getcustomercompalindetailsdata[0]['part_no'].'   '.$selected.'>'.$getcustomercompalindetailsdata[0]['part_number'].'</option>';
                                         }else{
                                            $selected = '';
                                            $part_number = '';
                                         }                                         
                                    ?>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="part_no">Part No</label>
                                                  <select disabled readonly  class="form-control" name="part_no" id="part_no">
                                                <?=$part_number?>
                                                <option value="NA">Select Part No</option>
                                                </select>
                                            <p class="error part_no_error"></p>
                                        </div>
                                    </div>
                                </div>

                                    <?php 
                                         if($getcustomercompalindetailsdata[0]['component_part_description']){
                                            $selected = 'selected';
                                            $part_number = $getcustomercompalindetailsdata[0]['name'];
                                         }else{
                                            $selected = '';
                                            $part_number = '';
                                         }                                         
                                    ?>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="component_part_description">Component Part Description</label>
                                             <input readonly  type="text" class="form-control" id="component_part_description" value="<?=$getcustomercompalindetailsdata[0]['name']?>" name="component_part_description">
                                            <p class="error component_part_description_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="order_qty">Order Qty</label>
                                             <input readonly  type="text" class="form-control" id="order_qty" value="<?=$getcustomercompalindetailsdata[0]['order_qty']?>" name="order_qty">
                                            <p class="error order_qty_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dispatch_qty">Dispatch Qty</label>
                                             <input readonly  type="text" class="form-control" id="dispatch_qty" value="<?=$getcustomercompalindetailsdata[0]['dispatch_qty']?>" name="dispatch_qty">
                                            <p class="error dispatch_qty_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="toatal_failure_qty">Total Failure Qty</label>
                                             <input readonly  type="text" class="form-control" id="toatal_failure_qty"  value="<?=$getcustomercompalindetailsdata[0]['toatal_failure_qty']?>" name="toatal_failure_qty">
                                            <p class="error toatal_failure_qty_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                   
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="invoice_no">Invoice No.</label>
                                             <input readonly  type="text" class="form-control" id="invoice_no" value="<?=$getcustomercompalindetailsdata[0]['invoice_no']?>" name="invoice_no">
                                            <p class="error invoice_no_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="invoice_date">Invoice Date</label>
                                             <input readonly  type="text" class="form-control datepicker" id="invoice_date" value="<?=$getcustomercompalindetailsdata[0]['invoice_date']?>" name="invoice_date">
                                            <p class="error invoice_date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="doc_complaint_no">Doc / Complaint No.</label>
                                             <input readonly  type="text" class="form-control" id="doc_complaint_no"  value="<?=$getcustomercompalindetailsdata[0]['doc_complaint_no']?>" name="doc_complaint_no">
                                            <p class="error doc_complaint_no_error"></p>
                                        </div>
                                    </div>

                                  
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="doc_complaint_date">Doc / Complaint Date</label>
                                             <input readonly  type="text" class="form-control datepicker" id="doc_complaint_date" value="<?=$getcustomercompalindetailsdata[0]['doc_complaint_date']?>" name="doc_complaint_date">
                                            <p class="error doc_complaint_date_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="problem_description">Problem Description</label>
                                               <input readonly  type="text" class="form-control" id="problem_description" value="<?=$getcustomercompalindetailsdata[0]['problem_description']?>" name="problem_description">
                                            <p class="error problem_description_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="root_case">Root Case</label>
                                             <input readonly  type="text" class="form-control" id="root_case" value="<?=$getcustomercompalindetailsdata[0]['root_case']?>" name="root_case">
                                            <p class="error root_case_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="correction">Correction</label>
                                             <input readonly  type="text" class="form-control" id="correction"  value="<?=$getcustomercompalindetailsdata[0]['correction']?>" name="correction">
                                            <p class="error correction_error"></p>
                                        </div>
                                    </div>

                                </div>

                                  
                                <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="corrective_action_taken">Corrective Action Taken</label>
                                             <input readonly  type="text" class="form-control" id="corrective_action_taken" value="<?=$getcustomercompalindetailsdata[0]['corrective_action_taken']?>" name="corrective_action_taken">
                                            <p class="error corrective_action_taken_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="corrective_action_taken_responsibility">Responsibility</label>
                                             <input readonly  type="text" class="form-control" id="corrective_action_taken_responsibility" value="<?=$getcustomercompalindetailsdata[0]['corrective_action_taken_responsibility']?>" name="corrective_action_taken_responsibility">
                                            <p class="error corrective_action_taken_responsibility_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="corrective_action_taken_responsibility_date">Date</label>
                                             <input readonly  type="text" class="form-control datepicker"  id="corrective_action_taken_responsibility_date" value="<?=$getcustomercompalindetailsdata[0]['corrective_action_taken_responsibility_date']?>" name="corrective_action_taken_responsibility_date">
                                            <p class="error corrective_action_taken_responsibility_date_error"></p>
                                        </div>
                                    </div>
                                </div>


                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="effective_action">Effective Action</label>
                                             <input readonly  type="text" class="form-control" id="effective_action" value="<?=$getcustomercompalindetailsdata[0]['effective_action']?>" name="effective_action">
                                            <p class="error effective_action_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="responsibility">Responsibility</label>
                                             <input readonly  type="text" class="form-control" id="responsibility" value="<?=$getcustomercompalindetailsdata[0]['responsibility']?>" name="responsibility">
                                            <p class="error responsibility_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="effective_date">Date</label>
                                             <input readonly  type="text" class="form-control datepicker"  id="effective_date" value="<?=$getcustomercompalindetailsdata[0]['effective_date']?>" name="effective_date">
                                            <p class="error effective_date_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="prepared_by">Prepared By</label>
                                             <input readonly  type="text" class="form-control" id="prepared_by" value="<?=$getcustomercompalindetailsdata[0]['prepared_by']?>" name="prepared_by">
                                            <p class="error prepared_by_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="prepared_by_date">Date</label>
                                             <input readonly  type="text" class="form-control datepicker" id="prepared_by_date" value="<?=$getcustomercompalindetailsdata[0]['prepared_by_date']?>" name="prepared_by_date">
                                            <p class="error prepared_by_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="approved_by">Approved By</label>
                                             <input readonly  type="text" class="form-control" id="approved_by" value="<?=$getcustomercompalindetailsdata[0]['approved_by']?>" name="approved_by">
                                            <p class="error approved_by_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="approved_by_date">Date</label>
                                             <input readonly  type="text" class="form-control datepicker" id="approved_by_date" value="<?=$getcustomercompalindetailsdata[0]['approved_by_date']?>" name="approved_by_date">
                                            <p class="error approved_by_date_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="report_closed_by">Report CLose By</label>
                                             <input readonly  type="text" class="form-control" id="report_closed_by" value="<?=$getcustomercompalindetailsdata[0]['report_closed_by']?>" name="report_closed_by">
                                            <p class="error report_closed_by_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="report_closed_by_date">Date</label>
                                             <input readonly  type="text" class="form-control datepicker" id="report_closed_by_date" value="<?=$getcustomercompalindetailsdata[0]['report_closed_by_date']?>" name="report_closed_by_date">
                                            <p class="error report_closed_by_date_error"></p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                 <input readonly  type="button" onclick="location.href = '<?php echo base_url() ?>customercompliant'" class="btn btn-default" value="Back" />
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
