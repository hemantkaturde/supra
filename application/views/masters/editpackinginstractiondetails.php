<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i>Edit Packing Instructions
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Packing Instructions Master</a></li>
                </ul>
            </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-8">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Edit Packing Instructions</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="editnewpackinginstructionform" action="<?php echo base_url() ?>editnewpackinginstructionform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <input type="hidden" class="form-control" id="packinginstarctionid" name="packinginstarctionid"  value="<?php echo $getdetailsofpackinginsraction[0]['packinginstarctionid']; ?>" required>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="packing_id_number">Packing Id Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="packing_id_number" name="packing_id_number"  value="<?php echo $getdetailsofpackinginsraction[0]['packing_instrauction_id']; ?>" required readonly>
                                            <p class="error packing_id_number_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_name">Select Buyer Name <span class="required">*</span></label>
                                                <select class="form-control buyer_po_number_for_itam_mapping" name="buyer_name" id="buyer_name">
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                        <?php foreach ($buyerList as $key => $value) {?>
                                                                <option value="<?php echo $value['buyer_id']; ?>"  <?php if($value['buyer_id']==$getdetailsofpackinginsraction[0]['buyer_id']){ echo 'selected'; } ?> ><?php echo $value['buyer_name']; ?></option>
                                                        <?php } ?>
                                                </select> 
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                   <?php  
                                
                                    if($getdetailsofpackinginsraction[0]['sales_order_number']){
                                        $buyer_po_number = $getdetailsofpackinginsraction[0]['sales_order_number'].' - '. $getdetailsofpackinginsraction[0]['buyerponumber'];
                                    }else{
                                        $buyer_po_number = '';
                                    }


                                    if($getdetailsofpackinginsraction[0]['buyer_po_date']){
                                        $buyer_po_date = $getdetailsofpackinginsraction[0]['buyer_po_date'];
                                    }else{
                                        $buyer_po_date = '';
                                    }
                                                                      
                                   ?>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="buyer_po_number_existing">Selected PO</label>
                                                 <input type="text" class="form-control" id="buyer_po_number_existing" value="<?=$buyer_po_number;?>" name="buyer_po_number_existing" readonly>
                                                 <input type="hidden" class="form-control" id="buyer_po_number_existing_id" value="<?=$getdetailsofpackinginsraction[0]['buyer_po_number'];?>" name="buyer_po_number_existing_id" readonly>

                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="buyer_po_date_existing">Selected PO Date</label>
                                                <input type="text" class="form-control" id="buyer_po_date_existing" value="<?=$buyer_po_date;?>" name="buyer_po_date_existing" readonly>
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="buyer_po_number">Select Buyer PO Number</label>
                                                    <select class="form-control" name="buyer_po_number" id="buyer_po_number">
                                                    </select>
                                            <p class="error buyer_po_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_po_date">Buyer PO Date</label>
                                            <input type="text" class="form-control datepicker" id="buyer_po_date" name="buyer_po_date" required readonly>
                                            <p class="error buyer_po_date_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fax">Remarks</label>
                                               <textarea type="text" class="form-control"  id="remark"  name="remark"><?=$getdetailsofpackinginsraction[0]['remark'] ?> </textarea><p class="error fax_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="editpackinginstarction" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>packinginstaruction'" class="btn btn-default" value="Back" />
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
