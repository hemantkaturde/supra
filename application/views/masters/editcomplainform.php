<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Complaint form
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
                            <h3 class="box-title"> Edit Complaint form</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="savenewcompalinform" action="<?php echo base_url() ?>savenewcompalinform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="report_no">Report No <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="report_no"  value="<?=$getcompalinformdata['report_no']?>" name="report_no" required>

                                                <input type="hidden" class="form-control" id="complain_form_id"  value="<?=$getcompalinformdata['id']?>" name="complain_form_id" required>

                                                <p class="error report_no_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="stage">Stage <span class="required">*</span></label>
                                                    <select class="form-control" name="stage" id="stage">
                                                        <option st-id="" value="">Select Stage</option>
                                                        <option value="Incoming" <?php if($getcompalinformdata['stage']=='Incoming'){ echo 'selected';} ?>>Incoming</option>
                                                        <option value="Inprogress" <?php if($getcompalinformdata['stage']=='Inprogress'){ echo 'selected';} ?>>Inprogress</option>
                                                        <option value="Final Inspection" <?php if($getcompalinformdata['stage']=='Final Inspection'){ echo 'selected';} ?>>Final Inspection</option>
                                                        <option value="At Customer End" <?php if($getcompalinformdata['stage']=='At Customer End'){ echo 'selected';} ?>>At Customer End</option>
                                                        <option value="At Supplier End" <?php if($getcompalinformdata['stage']=='At Supplier End'){ echo 'selected';} ?>>At Supplier End</option>
                                                    </select> 
                                                    <p class="error stage_error"></p>
                                            </div>
                                        </div>


                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="challan_no">Challan NO</label>
                                                <input type="text" class="form-control" id="challan_no"  value="<?=$getcompalinformdata['challan_no']?>" name="challan_no">
                                                <p class="error challan_no_error"></p>
                                            </div>
                                        </div>




                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="total_failure_qty">Total Failure Qty</label>
                                                <input type="text" class="form-control" id="total_failure_qty" value="<?=$getcompalinformdata['total_failure_qty']?>" name="total_failure_qty">
                                                <p class="error total_failure_qty_error"></p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm">
                                      
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date_of_observation_rejection_found">Date of Observation/Rejection Found</label>
                                                <input type="text" class="form-control datepicker" id="date_of_observation_rejection_found"  value="<?=$getcompalinformdata['date_of_observation_rejection_found']?>"  name="date_of_observation_rejection_found" required>
                                                <p class="error date_of_observation_rejection_found_error"></p>
                                            </div>
                                        </div>

                                        


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="vendor_id">Vendor Name <span class="required">*</span></label>
                                                  <select class="form-control" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>"  <?php if($value['ven_id']==$getcompalinformdata['vendor_name']){ echo 'selected';} ?> ><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                 </select>
                                                <p class="error vendor_name_error"></p>
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="po_no_wo_no">PO NO / WO NO</label>
                                                <input type="text" class="form-control" id="po_no_wo_no" value="<?=$getcompalinformdata['po_no_wo_no']?>" name="po_no_wo_no">
                                                <p class="error po_no_wo_no_error"></p>
                                            </div>
                                        </div> -->

                                        <?php if($getcompalinformdata['vendor_po_number_id']){
                                             $value = $getcompalinformdata['po_number'];
                                             $selected = 'selected';
                                        }else{ 
                                             $value = '';
                                             $selected = '';

                                         } ?>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="po_no_wo_no">PO NO / WO NO <span class="required">*</span></label>
                                                    <select class="form-control po_no_wo_no"  name="po_no_wo_no" id="po_no_wo_no">
                                                        <option st-id="" value="" <?=$selected?>>Select PO NO / WO NO</option>
                                                        <option st-id="" value="<?=$getcompalinformdata['vendor_po_number_id']?>" <?=$selected?>><?=$value?></option>
                                                    </select>
                                            </div>
                                        </div>
                                        
                                        <!-- 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="component_description">Component Description</label>
                                                <input type="text" class="form-control" id="component_description" value="<?=$getcompalinformdata['component_description']?>"  name="component_description" required>
                                                <p class="error component_description_error"></p>
                                            </div>
                                        </div> -->

                                        
                                    


                                        <?php if($getcompalinformdata['drawing_no_rev_no']){
                                             $value_drwing = $getcompalinformdata['part_number'];
                                             $selected_drwing = 'selected';
                                        }else{ 
                                             $value_drwing = '';
                                             $selected_drwing = '';

                                         } ?>




                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="drawing_no_rev_no">Drawing No / REV NO <span class="required">*</span></label>
                                                <!-- <input type="text" class="form-control" id="drawing_no_rev_no" name="drawing_no_rev_no" required> -->
                                                    <select class="form-control drawing_no_rev_no" name="drawing_no_rev_no" id="drawing_no_rev_no">
                                                        <option st-id="" value="">Select Drawing No / REV NO</option>
                                                        <option st-id="" value="<?=$getcompalinformdata['drawing_no_rev_no']?>" <?=$selected_drwing?>><?=$value_drwing?></option>

                                                    </select>
                                                <p class="error drawing_no_rev_no_error"></p>
                                            </div>
                                        </div>


                                        <?php if($getcompalinformdata['part_number_id']){
                                             $value = $getcompalinformdata['name'];
                                             $selected = 'selected';
                                        }else{ 
                                             $value = '';
                                             $selected = '';

                                         } ?>



                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="component_description">Component Description <span class="required">*</span></label>
                                                    <select class="form-control" name="component_description" id="component_description" readonly>
                                                        <option st-id="" value="">Select Component Description</option>
                                                        <option st-id="" value="<?=$getcompalinformdata['part_number_id']?>" <?=$selected?>><?=$value?></option>

                                                    </select>
                                                    <p class="error component_description_error"></p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm">
                                       <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inword_no">Inword NO</label>
                                                <input type="text" class="form-control" id="inword_no"  value="<?=$getcompalinformdata['inword_no']?>"  name="inword_no" required>
                                                <p class="error inword_no_error"></p>
                                            </div>
                                        </div>

                                     
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="poac">Problem Occurs</label>
                                                   <select class="form-control" name="poac" id="poac">
                                                        <option st-id="" value="">Select Stage</option>
                                                        <option value="At Customer End" <?php if($getcompalinformdata['poac']=='At Customer End'){ echo 'selected';} ?>>At Customer End</option>
                                                        <option value="At Supplier End" <?php if($getcompalinformdata['poac']=='At Supplier End'){ echo 'selected';} ?>>At Supplier End</option>
                                                        <option value="At Supplier End" <?php if($getcompalinformdata['poac']=='At Supplier End'){ echo 'selected';} ?>>At Initial Stage</option>
                                                    </select> 
                                                <p class="error poac_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="total_qty_checked">Total Qty Checked</label>
                                                <input type="text" class="form-control" id="total_qty_checked"  value="<?=$getcompalinformdata['total_qty_checked']?>" name="total_qty_checked">
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
                                                <textarea id="problem_description" name="problem_description" rows="4" cols="58"><?=$getcompalinformdata['problem_description']?></textarea>
                                                <p class="error problem_description_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="intermidiate_disposal ">Intermidiate Disposal</label>
                                                <textarea id="intermidiate_disposal" name="intermidiate_disposal" rows="4" cols="58"><?=$getcompalinformdata['intermidiate_disposal']?></textarea>
                                                <p class="error intermidiate_disposal_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="root_cause">Root Cause(S)</label>
                                                <textarea id="root_cause" name="root_cause" rows="4" cols="58"><?=$getcompalinformdata['root_cause']?></textarea>
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
                                                <textarea id="coorection" name="coorection" rows="4" cols="58"><?=$getcompalinformdata['coorection']?></textarea>
                                                <p class="error coorection_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="coorection_responsibility ">Responsibility</label>
                                                <input type="text" class="form-control" id="coorection_responsibility" value="<?=$getcompalinformdata['coorection_responsibility']?>" name="coorection_responsibility" required >
                                                <p class="error coorection_responsibility_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="coorection_date">DATE</label>
                                                <input type="text" class="form-control datepicker" id="coorection_date" value="<?=$getcompalinformdata['coorection_date']?>" name="coorection_date" required >
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
                                                <textarea id="corrective_action_taken" name="corrective_action_taken" rows="4" cols="58"><?=$getcompalinformdata['corrective_action_taken']?></textarea>
                                                <p class="error corrective_action_taken_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="corrective_action_responsibility">Responsibility</label>
                                                <input type="text" class="form-control" id="corrective_action_responsibility" value="<?=$getcompalinformdata['corrective_action_responsibility']?>"  name="corrective_action_responsibility" required >
                                                <p class="error corrective_action_responsibility_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="corrective_action_date">DATE</label>
                                                <input type="text" class="form-control datepicker" id="corrective_action_date" name="corrective_action_date" value="<?=$getcompalinformdata['corrective_action_date']?>" required >
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
                                                <textarea id="effective_action" name="effective_action" rows="4" cols="58"><?=$getcompalinformdata['effective_action']?></textarea>
                                                <p class="error effective_action_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="effective_action_responsiblity ">Responsibility</label>
                                                <input type="text" class="form-control" id="effective_action_responsiblity" value="<?=$getcompalinformdata['effective_action_responsiblity']?>" name="effective_action_responsiblity" required >
                                                <p class="error effective_action_responsiblity_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="effective_action_date">DATE</label>
                                                <input type="text" class="form-control datepicker" id="effective_action_date" value="<?=$getcompalinformdata['effective_action_date']?>"  name="effective_action_date" required >
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
                                                <textarea id="team" name="team" rows="4" cols="58"><?=$getcompalinformdata['team']?></textarea>
                                                <p class="error team_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="prepared_by ">Prepared By</label>
                                                <input type="text" class="form-control" id="prepared_by" value="<?=$getcompalinformdata['prepared_by']?>" name="prepared_by" required >
                                                <p class="error prepared_by_error"></p>
                                            </div>
                                        </div>    
                                    </div>

                                    
                                    <div class="col-sm">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="prepared_by_date">Date</label>
                                                <input type="text" class="form-control datepicker" id="prepared_by_date" value="<?=$getcompalinformdata['prepared_by']?>" name="prepared_by_date" required >
                                                <p class="error prepared_by_date_error"></p>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="approved_by">Approved By</label>
                                                <input type="text" class="form-control" id="approved_by" name="approved_by" value="<?=$getcompalinformdata['approved_by']?>" required >
                                                <p class="error approved_by_error"></p>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-sm">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="approved_by_date">Date</label>
                                                <input type="text" class="form-control datepicker" id="approved_by_date"  value="<?=$getcompalinformdata['approved_by_date']?>" name="approved_by_date" required >
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
                                                <input type="text" class="form-control" id="report_closed_by" value="<?=$getcompalinformdata['report_closed_by']?>" name="report_closed_by" >
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
                                                <input type="text" class="form-control datepicker" id="report_close_date" value="<?=$getcompalinformdata['report_close_date']?>"  name="report_close_date" >
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

