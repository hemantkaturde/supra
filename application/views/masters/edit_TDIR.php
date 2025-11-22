<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Inspection Report
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Inspection Report</a></li>
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
                            <h3 class="box-title">Inspection Report</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addTDIRform" action="#" method="post" role="form">
                            <div class="box-body">

                                <input type="hidden" class="form-control" value="<?php echo $getTdirdata[0]['vendor_po']; ?>" id="vendor_po_id" name="vendor_po_id">
                                <input type="hidden" class="form-control" value="<?php echo $getTdirdata[0]['fin_id']; ?>" id="part_number_id" name="part_number_id">
                                <input type="hidden" class="form-control" value="<?php echo $getTdirdata[0]['tdir_id']; ?>" id="tdir_id" name="tdir_id">

                    
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="report_number">Inspection Report Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" value="<?php echo $getTdirdata[0]['report_number']; ?>" id="report_number" name="report_number">
                                        </div>
                                    </div> 
                                    
                                    <div class="col-md-3">
                                          <div class="form-group">
                                            <label for="vendor_name">Vendor Name</label>
                                                    <select class="form-control" name="vendor_name" id="vendor_name">
                                                        <option st-id="" value="">Select Vendor Name</option>
                                                        <?php foreach ($vendorList as $key => $value) {?>
                                                        <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$getTdirdata[0]['tdir_vendor_id']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="vendor_po">Vendor PO</label>
                                            <select class="form-control vendor_po_number_for_buyer_details vendor_po_number_for_vendor_po_date" name="vendor_po_number" id="vendor_po_number">
                                            </select> 
                                            <p class="error vendor_po_number_error"></p>
                                        </div>
                                    </div>

                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="vendor_po_date">Vendor PO Date</label>
                                              <input type="text" class="form-control"  value="<?php echo $getTdirdata[0]['vendor_po_date']; ?>" id="vendor_po_date"  name="vendor_po_date">
                                            <p class="error vendor_po_date_error"></p>
                                        </div>
                                    </div>
                                   
                                </div>

                                <div class="row">


                                 <div class="col-md-3">
                                       <div class="form-group">
                                            <label for="vendor_part_number">Part Number</label>
                                            <select class="form-control vendor_part_number_get_data" name="vendor_part_number" id="vendor_part_number">
                                            </select> 
                                            <p class="error vendor_part_number_error"></p>
                                        </div>
                                    </div>

                                   
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="part_name">Part Name</label>
                                            <input type="text" class="form-control"  value="<?php echo $getTdirdata[0]['name']; ?>" id="part_name" name="part_name">
                                            <p class="error part_name_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="vendor_order_qty">Vendor Order Qty</label>
                                            <input type="text" class="form-control" id="vendor_order_qty" value="<?php echo $getTdirdata[0]['vendor_order_qty']; ?>" name="vendor_order_qty">
                                            <p class="error vendor_order_qty_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="buyer_name">Buyer Name</label>
                                            <input type="text" class="form-control" value="<?php echo $getTdirdata[0]['buyer_name_label']; ?>" id="buyer_name" name="buyer_name">
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="buyer_po_date">Buyer PO Date</label>
                                            <input type="text" class="form-control" id="buyer_po_date"  value="<?php echo $getTdirdata[0]['buyer_po_date']; ?>" name="buyer_po_date">
                                            <p class="error buyer_po_date_error"></p>
                                        </div>
                                    </div>
                                    
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="order_qty">Order Qty</label>
                                            <input type="text" class="form-control" id="order_qty" name="order_qty">
                                            <p class="error order_qty_error"></p>
                                        </div>
                                    </div> -->

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="qty_in_pcs_for_export_purposr">Qty in PCS (For Export Purpose)</label>
                                            <input type="text" class="form-control" id="qty_in_pcs_for_export_purposr" name="qty_in_pcs_for_export_purposr" value="<?php echo $getTdirdata[0]['qty_in_pcs_for_export_purposr']; ?>">
                                            <p style="color:red">(Note: filed not to be entered by QC)</p>
                                            <p class="error qty_in_pcs_for_export_purposr_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="remarks">Remarks</label>
                                            <input type="text" class="form-control" id="remarks" value="<?php echo $getTdirdata[0]['remarks']; ?>" name="remarks">
                                            <p class="error remarks_error"></p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewTDIR" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>tdir'" class="btn btn-default" value="Back" />
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
        // minDate: 0,
        todayHighlight: true,
                     dateFormat: 'yy-mm-dd',
        startDate: new Date()
    });
   });
</script>