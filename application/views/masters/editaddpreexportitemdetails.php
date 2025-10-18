<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit New Pre Export Item
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Add New Pre Export Item</a></li>
                </ul>
            </small>
        </h1>

        <h4>
            <p><b>Pre Export Invoice Number :</b> <?=$getexportetails[0]['pre_export_invoice_no'] ?></p>
            <p><b>Pre Export Buyer Name :</b> <?=$getexportetails[0]['buyer_name'] ?></p>
            <p><b>Pre Export Buyer PO Number :</b> <?=$getexportetails[0]['sales_order_number'] ?></p>
        </h4>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-8">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Pre-Export Item Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="savenewpreexportitemdetailsform" action="<?php echo base_url() ?>savenewpreexportitemdetailsform" method="post" role="form">
                            
                        <input type="hidden" class="main_export_id" id="main_export_id" value=<?=$main_export_id?> name="main_export_id">
                        <input type="hidden" class="buyer_po_id" id="buyer_po_id" value=<?=$buyer_po_id?> name="buyer_po_id">
                        <input type="hidden" class="preexportitemdetailsid" id="preexportitemdetailsid" value=<?=$preexportitemdetailsid?> name="preexportitemdetailsid">

                        <input type="hidden" class="buyer_name_id" id="buyer_name_id" value=<?=$buyer_name_id?>>

                        
                        <div class="box-body">
                                <!-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="part_number">Part Number <span class="required">*</span></label>
                                                <select class="form-control part_number" name="part_number" id="part_number">
                                                    <option st-id="" value="">Select Part Number</option>
                                                    <?php foreach ($getbuyerpoitemdetails as $key => $value) {?>
                                                    <option value="<?php echo $value['fin_id']; ?>" <?php if($getexportetails[0]['part_number_id']==$value['fin_id']){ echo 'selected';} ?> ><?php echo $value['part_number']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error part_number_error"></p>
                                        </div>
                                    </div>
                                </div>     -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="part_number">Part Number <span class="required">*</span></label>
                                                <select class="form-control part_number" name="part_number" id="part_number">
                                                    <option st-id="" value="">Select Part Number</option>
                                                    <?php foreach ($getbuyerpoitemdetails as $key => $value) {
                                                        
                                                        if($value['buyer_po_part_delivery_date']=='0000-00-00'){
                                                            $buyer_po_part_delivery_date ="";
                                                        }else{
                                                             $buyer_po_part_delivery_date = ' - '.date("d-m-Y", strtotime($value['buyer_po_part_delivery_date']));
                                                        }   
                                                        
                                                        ?>
                                                    <option <?php if($getexportetails[0]['part_number_id']==$value['fin_id']){ echo 'selected';} ?> value="<?php echo $value['fin_id']; ?>" data_buyer_po_number="<?php echo $value['buyer_po_number'];?>" data_buyer_po_date="<?php echo $value['buyer_po_part_delivery_date'];?>" ><?php echo $value['part_number'].' - '.$value['buyer_po_number']. $buyer_po_part_delivery_date; ?> </option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error part_number_error"></p>
                                        </div>
                                    </div>
                                </div>   

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="part_description">Part Description</label>
                                               <input type="text" class="form-control" id="part_description" value="<?=$getexportetails[0]['name']?>" name="part_description" readonly>
                                            <p class="error part_description_error"></p>
                                        </div>
                                    </div>
                                </div>    

                                      
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="buyer_po_number">Buyer PO Number</label>
                                               <input type="hidden" class="form-control" id="buyer_po_number_id" name="buyer_po_number_id" readonly>
                                               <input type="text" class="form-control" id="buyer_po_number" name="buyer_po_number" readonly>
                                            <p class="error buyer_po_number_error"></p>
                                        </div>
                                    </div>
                                </div>    


                                <!-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                               <label for="total_item_net_weight">Total Item Net Weight</label>
                                               <input type="number" class="form-control" id="total_item_net_weight" value="<?=$getexportetails[0]['total_item_net_weight']?>" name="total_item_net_weight">
                                            <p class="error total_item_net_weight_error"></p>
                                        </div>
                                    </div>
                                </div>     -->

                            
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fax">Remark </label>
                                            <textarea type="text" class="form-control"  id="remark"  name="remark"><?=$getexportetails[0]['preexportremark']?></textarea>
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewpreexportitemdetails" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>exportdetailsitemdetails/<?=$main_export_id?>'" class="btn btn-default" value="Back" />
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