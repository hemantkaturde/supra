<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add Complaint form
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
                            <h3 class="box-title"> Add Complaint form</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="savenewcompalinform" action="<?php echo base_url() ?>savenewcompalinform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm">

                                    <?php
                                        if($getPreviousCompalinformnumber['report_no']){
                                                // $arr = str_split($getPreviousSalesOrderNumber['sales_order_number']);
                                                // $i = end($arr);
                                                // $inrno= "SQBO2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                                // $sales_order_number = $inrno;


                                                $currentDate = new DateTime();

                                                // Check if the current date is on or after April 1st
                                                if ($currentDate >= new DateTime(date('Y') . '-04-01')) {
                                                    // If it is, the financial year has started in the current calendar year
                                                    //$startYear = date('Y');
                                                    $startYear = date('y');
                                                    $endYear = $startYear + 1;
                                                } else {
                                                    // If it is not, the financial year has started in the previous calendar year
                                                    //$endYear = date('Y');
                                                    $endYear = date('y');
                                                    $startYear = $endYear - 1;
                                                }

                                                // Display the financial year
                                                $financialYear = $startYear . '-' . $endYear;

                                               

                                                $string = $getPreviousCompalinformnumber['report_no'];

                                                $explod = explode("/",$string);

                                                $n = 4; // Number of characters to extract from the end
                                                $lastNCharacters = substr($explod[0], -$n);
                                                //$inrno= "SQBO2324".str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);

                                                $inrno= ($lastNCharacters+1)."/".$financialYear;
                                                $report_no = $inrno;

                                        }else{


                                            
                                            $currentDate = new DateTime();

                                            // Check if the current date is on or after April 1st
                                            if ($currentDate >= new DateTime(date('Y') . '-04-01')) {
                                                // If it is, the financial year has started in the current calendar year
                                                //$startYear = date('Y');
                                                $startYear = date('y');
                                                $endYear = $startYear + 1;
                                            } else {
                                                // If it is not, the financial year has started in the previous calendar year
                                                //$endYear = date('Y');
                                                $endYear = date('y');
                                                $startYear = $endYear - 1;
                                            }

                                            // Display the financial year
                                            $financialYear = $startYear . '-' . $endYear;

                                            $report_no = '1/'.$financialYear;
                                        }
                                    ?>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="report_no">Report No <span class="required">*</span></label>
                                                <input type="text" class="form-control" value="<?=$report_no?>" id="report_no" readonly name="report_no" required>
                                                <p class="error report_no_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="stage">Stage <span class="required">*</span></label>
                                                    <select class="form-control" name="stage" id="stage">
                                                        <option st-id="" value="">Select Stage</option>
                                                        <option value="Incoming">Incoming</option>
                                                        <option value="Inprogress">Inprogress</option>
                                                        <option value="Final Inspection">Final Inspection</option>
                                                        <option value="At Customer End">At Customer End</option>
                                                        <option value="At Supplier End">At Supplier End</option>
                                                    </select> 
                                                    <p class="error stage_error"></p>
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date_of_observation_rejection_found">Date of Observation/Rejection Found</label>
                                                <input type="text" class="form-control datepicker" id="date_of_observation_rejection_found" name="date_of_observation_rejection_found" required>
                                                <p class="error date_of_observation_rejection_found_error"></p>
                                            </div>
                                        </div> -->

                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="challan_no">Challan NO</label>
                                                <input type="text" class="form-control" id="challan_no" name="challan_no">
                                                <p class="error challan_no_error"></p>
                                            </div>
                                        </div>

                                     
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="total_failure_qty">Total Failure Qty</label>
                                                <input type="text" class="form-control" id="total_failure_qty" name="total_failure_qty">
                                                <p class="error total_failure_qty_error"></p>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="col-sm">
                                      
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date_of_observation_rejection_found">Date of Observation/Rejection Found</label>
                                                <input type="text" class="form-control datepicker" id="date_of_observation_rejection_found" name="date_of_observation_rejection_found" required>
                                                <p class="error date_of_observation_rejection_found_error"></p>
                                            </div>
                                        </div>


                                       



                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="vendor_id">Vendor Name <span class="required">*</span></label>
                                                  <select class="form-control" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>"><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                 </select>
                                                <p class="error vendor_name_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="po_no_wo_no">PO NO / WO NO <span class="required">*</span></label>
                                                    <select class="form-control po_no_wo_no"  name="po_no_wo_no" id="po_no_wo_no">
                                                        <option st-id="" value="">Select PO NO / WO NO</option>
                                                    </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="drawing_no_rev_no">Drawing No / REV NO <span class="required">*</span></label>
                                                <!-- <input type="text" class="form-control" id="drawing_no_rev_no" name="drawing_no_rev_no" required> -->
                                                    <select class="form-control drawing_no_rev_no" name="drawing_no_rev_no" id="drawing_no_rev_no">
                                                        <option st-id="" value="">Select Drawing No / REV NO</option>
                                                    </select>
                                                <p class="error drawing_no_rev_no_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="component_description">Component Description <span class="required">*</span></label>
                                                    <select class="form-control" name="component_description" id="component_description" readonly>
                                                        <option st-id="" value="">Select Component Description</option>
                                                    </select>
                                                    <p class="error component_description_error"></p>
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
                                                <label for="poac">Problem Occurs</label>
                                                   <select class="form-control" name="poac" id="poac">
                                                        <option st-id="" value="">Select Stage</option>
                                                        <option value="At Customer End">At Customer End</option>
                                                        <option value="At Supplier End">At Supplier End</option>
                                                        <option value="At Supplier End">At Initial Stage</option>
                                                    </select> 
                                                <p class="error poac_error"></p>
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
                                                <label for="problem_description">Problem Description</label>
                                                <textarea id="problem_description" name="problem_description" rows="4" cols="58"></textarea>
                                                <p class="error problem_description_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="intermidiate_disposal ">Intermidiate Disposal</label>
                                                <textarea id="intermidiate_disposal" name="intermidiate_disposal" rows="4" cols="58"></textarea>
                                                <p class="error intermidiate_disposal_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="root_cause">Root Cause(S)</label>
                                                <textarea id="root_cause" name="root_cause" rows="4" cols="58"></textarea>
                                                <p class="error root_cause_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="coorection">Correction</label>
                                                <textarea id="coorection" name="coorection" rows="4" cols="58"></textarea>
                                                <p class="error coorection_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="coorection_responsibility ">Responsibility</label>
                                                <input type="text" class="form-control" id="coorection_responsibility" name="coorection_responsibility" required >
                                                <p class="error coorection_responsibility_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="coorection_date">DATE</label>
                                                <input type="text" class="form-control datepicker" id="coorection_date" name="coorection_date" required >
                                                <p class="error coorection_date_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="corrective_action_taken">Corrective Action Taken</label>
                                                <textarea id="corrective_action_taken" name="corrective_action_taken" rows="4" cols="50"></textarea>
                                                <p class="error corrective_action_taken_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="corrective_action_responsibility">Responsibility</label>
                                                <input type="text" class="form-control" id="corrective_action_responsibility" name="corrective_action_responsibility" required >
                                                <p class="error corrective_action_responsibility_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="corrective_action_date">DATE</label>
                                                <input type="text" class="form-control datepicker" id="corrective_action_date" name="corrective_action_date" required >
                                                <p class="error corrective_action_date_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="effective_action">Effective Action</label>
                                                <textarea id="effective_action" name="effective_action" rows="4" cols="50"></textarea>
                                                <p class="error effective_action_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="effective_action_responsiblity ">Responsibility</label>
                                                <input type="text" class="form-control" id="effective_action_responsiblity" name="effective_action_responsiblity" required >
                                                <p class="error effective_action_responsiblity_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="effective_action_date">DATE</label>
                                                <input type="text" class="form-control datepicker" id="effective_action_date" name="effective_action_date" required >
                                                <p class="error effective_action_date_error"></p>
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
                                                <input type="text" class="form-control datepicker" id="prepared_by_date" name="prepared_by_date" required >
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
                                                <input type="text" class="form-control datepicker" id="approved_by_date" name="approved_by_date" required >
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
                                                <input type="text" class="form-control datepicker" id="report_close_date" name="report_close_date" >
                                                <p class="error root_cause_error"></p>
                                            </div>
                                        </div>    
                                </div>
                                </div>

                            </div>    
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewcompalinformdata" class="btn btn-primary" value="Submit" <?php echo $disabled;?> >
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>complaintform'" class="btn btn-default" value="Back" />
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

