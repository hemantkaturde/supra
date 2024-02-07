<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add Analysis and Corrective Action Report
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Add,Edit,Delete</a></li>
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
                            <h3 class="box-title"> Add Analysis and Corrective Action Report</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="" action="<?php echo base_url() ?>" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="report_no">Report No <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="report_no" name="report_no" required readonly>
                                                <p class="error report_no_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="packing_id_number">Stage <span class="required">*</span></label>
                                                    <select class="form-control buyer_po_number_for_itam_mapping" name="buyer_name" id="buyer_name">
                                                        <option st-id="" value="">Select Stage</option>
                                                        <option value="Incoming">Incoming</option>
                                                        <option value="Inprogress">Inprogress</option>
                                                        <option value="Final Inspection">Final Inspection</option>
                                                        <option value="At Customer End">At Customer End</option>
                                                        <option value="At Supplier End">At Supplier End</option>
                                                    </select> 
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date_of_observation_rejection_found">Date of Observation/Rejection Found<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="date_of_observation_rejection_found" name="date_of_observation_rejection_found" required>
                                                <p class="error date_of_observation_rejection_found_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date_of_observation_rejection_found">Date of Observation/Rejection Found<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="date_of_observation_rejection_found" name="date_of_observation_rejection_found" required>
                                                <p class="error date_of_observation_rejection_found_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tfq">Total Failure Qty</label>
                                                <input type="text" class="form-control" id="tfq" name="tfq">
                                                <p class="error tfq_error"></p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm">
                                       <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="drawing_no_rev_no">Drawing No / REV NO <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="drawing_no_rev_no" name="drawing_no_rev_no" required>
                                                <p class="error drawing_no_rev_no_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="challan_no">Challan NO</label>
                                                <input type="text" class="form-control" id="challan_no" name="challan_no">
                                                <p class="error challan_no_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="po_no_wo_no">PO NO / WO NO</label>
                                                <input type="text" class="form-control" id="po_no_wo_no" name="po_no_wo_no">
                                                <p class="error po_no_wo_no_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="poac">Problem Occurs At Customer End / Supplier End/initial Stage</label>
                                                <input type="text" class="form-control" id="poac" name="poac">
                                                <p class="error poac_error"></p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-sm">
                                       <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inword_no">Inword NO</label>
                                                <input type="text" class="form-control" id="inword_no" name="inword_no" required>
                                                <p class="error inword_no_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="component_description">Component Description<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="component_description" name="component_description" required>
                                                <p class="error component_description_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="total_qty_checked">Total Qty Checked</label>
                                                <input type="text" class="form-control" id="total_qty_checked" name="total_qty_checked">
                                                <p class="error total_qty_checked_error"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="problem_description">Problem Description<span class="required">*</span></label>
                                                <textarea id="problem_description" name="problem_description" rows="4" cols="50"></textarea>
                                                <p class="error problem_description_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="intermidiate_disposal ">Intermidiate Disposal<span class="required">*</span></label>
                                                <textarea id="intermidiate_disposal" name="intermidiate_disposal" rows="4" cols="50"></textarea>
                                                <p class="error intermidiate_disposal_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="root_cause">Root Cause(S)<span class="required">*</span></label>
                                                <textarea id="root_cause" name="root_cause" rows="4" cols="50"></textarea>
                                                <p class="error root_cause_error"></p>
                                            </div>
                                        </div>    

                                      
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="problem_description">Correction<span class="required">*</span></label>
                                                <textarea id="problem_description" name="problem_description" rows="4" cols="50"></textarea>
                                                <p class="error problem_description_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="intermidiate_disposal ">Responsibility<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="report_no" name="report_no" required >
                                                <p class="error intermidiate_disposal_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="root_cause">DATE</label>
                                                <input type="text" class="form-control" id="report_no" name="report_no" required >
                                                <p class="error root_cause_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="problem_description">Correction<span class="required">*</span></label>
                                                <textarea id="problem_description" name="problem_description" rows="4" cols="50"></textarea>
                                                <p class="error problem_description_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="intermidiate_disposal ">Responsibility<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="report_no" name="report_no" required >
                                                <p class="error intermidiate_disposal_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="root_cause">DATE</label>
                                                <input type="text" class="form-control" id="report_no" name="report_no" required >
                                                <p class="error root_cause_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="problem_description">Effective Action</label>
                                                <textarea id="problem_description" name="problem_description" rows="4" cols="50"></textarea>
                                                <p class="error problem_description_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="intermidiate_disposal ">Responsibility<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="report_no" name="report_no" required >
                                                <p class="error intermidiate_disposal_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="root_cause">DATE</label>
                                                <input type="text" class="form-control" id="report_no" name="report_no" required >
                                                <p class="error root_cause_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="team">  Team -Members </label>
                                                <textarea id="team" name="team" rows="4" cols="50"></textarea>
                                                <p class="error team_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="prepared_by ">Prepared By</label>
                                                <input type="text" class="form-control" id="prepared_by" name="prepared_by" required >
                                                <p class="error prepared_by_error"></p>
                                            </div>
                                        </div>    
                                    </div>

                                    
                                    <div class="col-sm">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="prepared_by_date">Date</label>
                                                <input type="text" class="form-control" id="prepared_by_date" name="prepared_by_date" required >
                                                <p class="error prepared_by_date_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="approved_by">Approved By</label>
                                                <input type="text" class="form-control" id="approved_by" name="approved_by" required >
                                                <p class="error approved_by_error"></p>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="approved_by_date">Date</label>
                                                <input type="text" class="form-control" id="approved_by_date" name="approved_by_date" required >
                                                <p class="error approved_by_date_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="report_closed_by">Report Closed By</label>
                                                <input type="text" class="form-control" id="report_closed_by" name="report_closed_by" >
                                                <p class="error report_closed_by_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="root_cause">DATE</label>
                                                <input type="text" class="form-control" id="report_close_date" name="report_close_date" >
                                                <p class="error root_cause_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                </div>



                            </div>    
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewvendorBillofmaterial" class="btn btn-primary" value="Submit" <?php echo $disabled;?> >
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>vendorbillofmaterial'" class="btn btn-default" value="Back" />
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
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
				// minDate: 0,
				todayHighlight: true,
                dateFormat: 'yy-mm-dd',
				startDate: new Date()
			});
		});
</script>

