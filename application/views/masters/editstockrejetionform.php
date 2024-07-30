<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> Edit Rejection Form
         <small>
            <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
               <li class="completed"><a href="javascript:void(0);">Masters</a></li>
               <li class="active"><a href="javascript:void(0);"> OMS Challan Details</a></li>
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
                     <h3 class="box-title">Edit Rejection Form</h3>
                  </div>
                  <?php $this->load->helper("form"); ?>
                  <form role="form" id="addnewrejectionformdata" action="#" method="post" role="form">
                        <div class="box-body">
                            <input type="hidden" class="form-control" id="rejection_form_id" name="rejection_form_id" value="<?=$getalldataofeditrejectionform['rejection_form_id'];?>" required readonly>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="rejection_number">Rejection Id<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="rejection_number" name="rejection_number" value="<?=$getalldataofeditrejectionform['rejection_number'];?>" required readonly>
                                            <p class="error rejection_number_error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="rejection_form_date">Date <span class="required">*</span></label>
                                            <?php  $date= date('Y-m-d');  ?>
                                            <input type="text" class="form-control datepicker" id="rejection_form_date" name="rejection_form_date" value="<?=$getalldataofeditrejectionform['rejection_form_date']?>"  required >
                                            <p class="error rejection_form_date_error"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                                <select class="form-control" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                        <?php foreach ($vendorList as $key => $value) {?>
                                                            <option value="<?php echo $value['ven_id']; ?>" <?php if($getalldataofeditrejectionform['vendor_id']==$value['ven_id']){ echo 'selected'; }?> ><?php echo $value['vendor_name']; ?></option>
                                                        <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12 vendor_po_number_div" id="vendor_po_number_div">
                                    <div class="form-group">
                                        <label for="vendor_po_number">Select Vendor PO Number</label>
                                            <select class="form-control" name="vendor_po_number" id="vendor_po_number">
                                                 <option value="<?php echo $getalldataofeditrejectionform['vpn']; ?>"><?php echo $getalldataofeditrejectionform['po_number']; ?></option>
                                            </select>
                                        <p class="error vendor_po_number_error"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">Remark</label>
                                        <input type="remark" class="form-control" id="remark" name="remark" value="<?=$getalldataofeditrejectionform['rejection_form_remark'] ?>">
                                        <p class="error remark_error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>  
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <div class="col-xs-8">
                           <input type="submit" id="addnewrejectionform" class="btn btn-primary" value="Submit">
                           <input type="button" onclick="location.href = '<?php echo base_url() ?>stockrejectionform'" class="btn btn-default" value="Back" />
                        </div>
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