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
                                    <input type="hidden" class="form-control" id="checklistreportid" name="checklistreportid" value="<?php echo $checklistreportid; ?>">
                                    <input type="hidden" class="form-control" id="buyer_id" name="buyer_id" value="<?php echo $buyer_id; ?>">
                                    <input type="hidden" class="form-control" id="checklistreportid" name="checklistreportid" value="<?php echo $checklistreportid; ?>">
                                    <input type="hidden" class="form-control" id="buyer_id" name="buyer_id" value="<?php echo $buyer_id; ?>">


                                    <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="buyer_po_number">Vendor Name <span class="required">*</span></label>
                                                    <select class="form-control" name="buyer_po_number" id="buyer_po_number">
                                                        <option st-id="" value="">Select Vendor Name</option>
                                                        <?php foreach ($getbuyerponumbersbyid as $key => $value) {?>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['sales_order_number'].' - '.$value['buyer_po_number']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                            <p class="error buyer_po_number_error"></p>
                                        </div>

                                        <div class="form-group">
                                            <label for="buyer_part_number">Vendor PO Number<span class="required">*</span></label>
                                                    <select class="form-control" name="buyer_part_number" id="buyer_part_number">
                                                        <option st-id="" value="">Select Vendor PO Number</option>
                                                    </select>
                                            <p class="error buyer_part_number_error"></p>
                                        </div>
                                    </div>
                                </div>

                                 <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="buyer_part_number">Vendor Part Number<span class="required">*</span></label>
                                                    <select class="form-control" name="buyer_part_number" id="buyer_part_number">
                                                        <option st-id="" value="">Select Vendor Part Number</option>
                                                    </select>
                                            <p class="error buyer_part_number_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                         <div class="form-group">
                                            <label for="buyer_part_number">Report Number<span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" id="buyer_part_po_qty"  name="buyer_part_po_qty">
                                            
                                            <p class="error buyer_part_po_qty_number_error"></p>
                                            <p class="error buyer_part_number_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="buyer_part_po_qty">Inspection Repot Date</label>
                                            <input type="text" class="form-control datepicker" id="buyer_part_po_qty"  name="buyer_part_po_qty">
                                            <p class="error buyer_part_po_qty_number_error"></p>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dispatch_qty">Sampling Qty</label>
                                            <input type="text" class="form-control" id="dispatch_qty"  name="dispatch_qty">
                                            <p class="error dispatch_qty_number_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dispatch_qty">Team Name</label>
                                            <input type="text" class="form-control" id="dispatch_qty"  name="dispatch_qty">
                                            <p class="error dispatch_qty_number_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dispatch_qty">Varified By</label>
                                            <input type="text" class="form-control" id="dispatch_qty"  name="dispatch_qty">
                                            <p class="error dispatch_qty_number_error"></p>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dispatch_qty">Approved  By</label>
                                            <input type="text" class="form-control" id="dispatch_qty"  name="dispatch_qty">
                                            <p class="error dispatch_qty_number_error"></p>
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