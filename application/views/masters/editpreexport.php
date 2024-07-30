<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i>Edit Export 
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> Edit Pre-Export</a></li>
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
                            <h3 class="box-title">Pre-Export Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="savenewpreexportform" action="<?php echo base_url() ?>savenewpreexportform" method="post" role="form">
                            <div class="box-body">


                            <input type="hidden" class="form-control datepicker" id="preexport_id" value="<?=trim($getexportdetailsforedit[0]['export_id'])?>" name="preexport_id" required>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="invoice_number">Invoice Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="invoice_number" value="<?=trim($getexportdetailsforedit[0]['pre_export_invoice_no'])?>" name="invoice_number" required readonly>
                                            <p class="error invoice_number_error"></p>
                                        </div>
                                    </div>
                                </div>

                                     <?php if($getexportdetailsforedit[0]['date']){
                                        $date= $getexportdetailsforedit[0]['date'];
                                     }else{
                                        $date= date('Y-m-d');
                                     } ?>




                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="preexport_invoice_number">Invoice Number</label>
                                            <input type="text" class="form-control" id="preexport_invoice_number" value="<?=trim($getexportdetailsforedit[0]['invoice_number'])?>" name="preexport_invoice_number">
                                            <p class="error preexport_invoice_number_error"></p>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date<span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" id="date" value="<?=$date?>" name="date" required>
                                            <p class="error date_error"></p>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                                <select class="form-control buyer_name_for_currency" name="buyer_name" id="buyer_name">
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                    <?php foreach ($buyerList as $key => $value) {?>
                                                    <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$getexportdetailsforedit[0]['buyer_id']){ echo 'selected';} ?> ><?php echo $value['buyer_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>
                                </div>    


                                <!-- <?php if($getexportdetailsforedit[0]['buyer_po']){
                                        $display='block';
                                        $selected_value = $getexportdetailsforedit[0]['sales_order_number'].'-'.$getexportdetailsforedit[0]['buyer_po_number'];

                                    }else{
                                        $display='none';
                                        $selected_value = 'Select Buyer PO Number';
                                    } ?> 


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_po">Buyer PO<span class="required">*</span></label>
                                                <select class="form-control buyer_po_number_for_item" name="buyer_po_number" id="buyer_po_number">
                                                    <option st-id="" value="">Select Buyer PO</option>
                                                    <option st-id="" value="<?=$getexportdetailsforedit[0]['buyer_po']?>" selected ><?=$selected_value;?></option>

                                                </select> 
                                        </div>
                                    </div>
                                </div> -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="total_no_of_pallets">Total No of Pallets </label>
                                                <input type="text" class="form-control" value="<?=$getexportdetailsforedit[0]['total_no_of_pallets']?>" id="total_no_of_pallets" name="total_no_of_pallets">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="total_weight_of_pallets">Total Weight of Pallets </label>
                                                <input type="text" class="form-control" value="<?=$getexportdetailsforedit[0]['total_weight_of_pallets']?>" id="total_weight_of_pallets" name="total_weight_of_pallets">
                                        </div>
                                    </div>
                                </div>



                                <!-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="pallet_1">Pallet 1 </label>
                                                <input type="text" class="form-control" value="<?=$getexportdetailsforedit[0]['pallet_1']?>"  id="pallet_1" name="pallet_1">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="pallet_2">Pallet 2 </label>
                                                <input type="text" class="form-control" value="<?=$getexportdetailsforedit[0]['pallet_2']?>"  id="pallet_2" name="pallet_2">
                                        </div>
                                    </div>
                                </div> -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="mode_of_shipment">Mode of Shipment <span class="required">*</span></label>
                                                <select class="form-control mode_of_shipment" name="mode_of_shipment" id="mode_of_shipment">
                                                    <option st-id="" value="">Select Mode of Shipment</option>
                                                    <option st-id="" value="Air" <?php if($getexportdetailsforedit[0]['mode_of_shipment']=='Air'){  echo 'selected'; } ?> >Air</option>
                                                    <option st-id="" value="Sea" <?php if($getexportdetailsforedit[0]['mode_of_shipment']=='Sea'){  echo 'selected'; }   ?>>Sea</option>
                                                </select>
                                            <p class="error mode_of_shipment_error"></p>
                                        </div>
                                    </div>
                                </div>  


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="fax">Remark </label>
                                                <textarea type="text" class="form-control"  id="remark"  name="remark"><?=$getexportdetailsforedit[0]['preexportremark']?></textarea>
                                                <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewpreexport" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>preexport'" class="btn btn-default" value="Back" />
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