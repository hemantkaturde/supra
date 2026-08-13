<style>
    .select2-container--default{

       width: 287px !important;
}
    </style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add Checklist Report Part Incoming Data
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Checklist Report Part Incoming Data</a></li>
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
                            <h3 class="box-title">Add New Checklist Report Part Incoming Data</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addchecklistreportpartform" action="<?php echo base_url() ?>addchecklistreportpartform" method="post" role="form">
                            <div class="box-body">
                                    <input type="hidden" class="form-control" id="checklist_part_id" name="checklist_part_id" value="<?php echo $checklist_part_id; ?>">
                                    <input type="hidden" class="form-control" id="og_buyer_id" name="og_buyer_id" value="<?php echo $og_buyer_id; ?>">
                                    <input type="hidden" class="form-control" id="checklist_report_id" name="checklist_report_id" value="<?php echo $checklist_report_id; ?>">
                                    <input type="hidden" class="form-control" id="part_numner_id_og" name="part_numner_id_og" value="<?php echo $checklist_part_buyer_data[0]['part_number_id_finish_good']; ?>">



                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="buyer_part_number">Part Number<span class="required">*</span></label>
                                                    <input type="text" class="form-control" id="buyer_part_number" value="<?php echo $checklist_part_buyer_data[0]['part_number']; ?>" name="buyer_part_number">
                                                <p class="error buyer_part_number_error"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="vendor_id">Vendor Name <span class="required">*</span></label>
                                                    <select class="form-control" name="vendor_id" id="vendor_id">
                                                        <option st-id="" value="">Select Vendor Name</option>
                                                        <?php foreach ($vendorList as $key => $value) {?>
                                                        <option value="<?php echo $value['ven_id']; ?>"><?=$value['vendor_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                            <p class="error vendor_id_error"></p>
                                        </div>

                                        <div class="form-group">
                                            <label for="vendor_po_id">Vendor PO Number<span class="required">*</span></label>
                                                    <select class="form-control" name="vendor_po_id" id="vendor_po_id">
                                                        <option st-id="" value="">Select Vendor PO Number</option>
                                                    </select>
                                            <p class="error vendor_po_id_error"></p>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-3">
                                         <div class="form-group">
                                            <label for="report_number">Report Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="report_number"  name="report_number">
                                            <p class="error report_number_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inspection_report_date">Inspection Repot Date</label>
                                            <input type="text" class="form-control datepicker" id="inspection_report_date"  name="inspection_report_date">
                                            <p class="error inspection_report_date_error"></p>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sampling_qty">Sampling By</label>
                                            <input type="text" class="form-control" id="sampling_qty"  name="sampling_qty">
                                            <p class="error sampling_qty_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="team_name">Team Name</label>
                                            <input type="text" class="form-control" id="team_name"  name="team_name">
                                            <p class="error team_name_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="verified_by">Verified By</label>
                                            <input type="text" class="form-control" id="verified_by"  name="verified_by">
                                            <p class="error verified_by_error"></p>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="approved_by">Approved  By</label>
                                            <input type="text" class="form-control" id="approved_by"  name="approved_by">
                                            <p class="error approved_by_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="text" class="form-control" id="remark"  name="remark">
                                            </select> 
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="addchecklistreportpartformsubmit" class="btn btn-primary" value="Submit" />
                                <input type="button" 
                                onclick="location.href='<?php echo base_url() . 'checklistpartitemdatavendorincoming/' . $checklist_part_id . '/' . $og_buyer_id. '/' . $checklist_report_id; ?>'" 
                                class="btn btn-default" 
                                value="Back" />
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
 $(function () {
    $(".datetimepicker").datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss",
        controlType: "select",
        oneLine: true,
        minDate: 0
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">