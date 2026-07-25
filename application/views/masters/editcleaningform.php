<style>
    .select2-container--default{

       width: 287px !important;
}
    </style>


<?php  //print_r($getcleaningformdetailsbyid);exit; ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Cleaning Form
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Cleaning Form</a></li>
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
                            <h3 class="box-title">Edit Cleaning Form</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewcleaningform" action="<?php echo base_url() ?>addnewcleaningform" method="post" role="form">
                            <div class="box-body">


                                <input type="hidden" class="form-control" id="cleaningformid" name="cleaningformid" value="<?=$getcleaningformdetailsbyid[0]['cleaningformid'];?>" readonly>


                                <input type="hidden" class="form-control" id="vendor_po_number_cleanind_form_id" name="vendor_po_number_cleanind_form_id" value="<?=$getcleaningformdetailsbyid[0]['vendor_po_number_cleanind_form_id'];?>" readonly>
                                <input type="hidden" class="form-control" id="vendor_po_number_master" name="vendor_po_number_master" value="<?=$getcleaningformdetailsbyid[0]['vendor_po_number_master'];?>" readonly>
                                <input type="hidden" class="form-control" id="vendor_part_number_original" name="vendor_part_number_original" value="<?=$getcleaningformdetailsbyid[0]['vendor_part_number'];?>" readonly>
                                <input type="hidden" class="form-control" id="fn_part_number" name="fn_part_number" value="<?=$getcleaningformdetailsbyid[0]['fn_part_number'];?>" readonly>

                                <input type="hidden" class="form-control" id="incoming_lot_number_og" name="incoming_lot_number_og" value="<?=$getcleaningformdetailsbyid[0]['incoming_lot_number'];?>" readonly>


                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cleaning_no">Cleaning No. <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="cleaning_no" name="cleaning_no" value="<?=$getcleaningformdetailsbyid[0]['cleaning_no'];?>" readonly>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cleaning_date">Cleaning Date</label>
                                               <input type="text" class="form-control datepicker" id="cleaning_date" value="<?=$getcleaningformdetailsbyid[0]['cleaning_date'];?>" name="cleaning_date">
                                            <p class="error cleaning_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="vendor_div">
                                        <div class="form-group">
                                            <label for="vendor_name">Vendor Name</label>
                                                    <select class="form-control" name="vendor_name" id="vendor_name">
                                                        <option st-id="" value="">Select Vendor Name</option>
                                                        <?php foreach ($vendorList as $key => $value) {?>
                                                        <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$getcleaningformdetailsbyid[0]['vendor_name']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3" id="vendor_po_number_div"  style="display:none">
                                        <div class="form-group">
                                            <label for="vendor_po">Vendor PO</label>
                                            <select class="form-control" name="vendor_po_number" id="vendor_po_number">                                            
                                            </select> 
                                            <p class="error vendor_po_number_error"></p>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-3" id="supplier_part_number_div"  style="display:none">
                                        <div class="form-group">
                                            <label for="supplier_part_number">Part Number / Drawing No / Rev No</label>
                                            <select class="form-control" name="supplier_part_number" id="supplier_part_number">
                                            </select> 
                                            <p class="error supplier_part_number_error"></p>
                                        </div>
                                    </div> -->


                                    <div class="col-md-3" id="vendor_part_number_div"  style="display:none">
                                        <div class="form-group">
                                            <label for="vendor_part_number">Part Number / Drawing No / Rev No</label>
                                            <select class="form-control vendor_part_number_for_incoimg_lot_number" name="vendor_part_number" id="vendor_part_number">
                                            </select> 
                                            <p class="error vendor_part_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="part_description">Part Description / Component</label>
                                            <input type="text" class="form-control" id="part_description" value="<?=$getcleaningformdetailsbyid[0]['part_description'];?>" name="part_description">
                                            <p class="error part_description_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="incoming_lot_number_div"  style="display:none">
                                        <div class="form-group">
                                            <label for="incoming_lot_number">Lot Number</label>
                                            <select class="form-control" name="incoming_lot_number" value="<?=$getcleaningformdetailsbyid[0]['incoming_lot_number'];?>" id="incoming_lot_number">
                                            </select> 
                                            <p class="error incoming_lot_number_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="received_qty">Lot Qty</label>
                                            <input type="text" class="form-control" id="received_qty"  value="<?=$getcleaningformdetailsbyid[0]['received_qty'];?>" name="received_qty">
                                            <p class="error received_qty_error"></p>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="no_of_boxes">No .Of Boxes</label>
                                            <input type="text" class="form-control" id="no_of_boxes"  value="<?=$getcleaningformdetailsbyid[0]['no_of_boxes'];?>" name="no_of_boxes">
                                            <p class="error no_of_boxes_error"></p>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cleaning_status">Status</label>
                                                   <select class="form-control" name="cleaning_status" id="cleaning_status">
                                                        <option st-id="" value="">Select Status</option>
                                                        <option value="In Process" <?php if($getcleaningformdetailsbyid[0]['cleaning_status']=='In Process'){ echo 'Selected'; } ?> >In Process</option>
                                                        <option value="Completed" <?php if($getcleaningformdetailsbyid[0]['cleaning_status']=='Completed'){ echo 'Selected'; } ?>>Completed</option>
                                                    </select>
                                            <p class="error cleaning_status_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="no_of_boxes_after_cleaning">No of Boxes after cleaning</label>
                                            <input type="text" class="form-control" id="no_of_boxes_after_cleaning"  value="<?=$getcleaningformdetailsbyid[0]['no_of_boxes_after_cleaning'];?>"  name="no_of_boxes_after_cleaning">
                                            <p class="error no_of_boxes_after_cleaning_error"></p>
                                        </div>
                                    </div>


                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="start_date_time">Start Date and Time</label>
                                        <input type="text"
                                            class="form-control datetimepicker"
                                            id="start_date_time"
                                            value="<?=$getcleaningformdetailsbyid[0]['start_date_time'];?>" 
                                            name="start_date_time"
                                            >
                                        <p class="error start_date_time_error"></p>
                                    </div>
                                </div>
                                

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="end_date_time">End Date and Time</label>
                                        <input type="text"
                                            class="form-control datetimepicker"
                                            id="end_date_time"
                                            value="<?=$getcleaningformdetailsbyid[0]['end_date_time'];?>" 
                                            name="end_date_time">
                                        <p class="error end_date_time_error"></p>
                                    </div>
                                </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="text" class="form-control" id="remark" value="<?=$getcleaningformdetailsbyid[0]['remark'];?>" name="remark">
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="addnewcleaningformsubmit" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>cleaningform'"  class="btn btn-default" value="Back" />
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