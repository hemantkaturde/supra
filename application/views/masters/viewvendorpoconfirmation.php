

<?php //print_r($fetchALLpreVendorpoconfirmationitemList);exit;?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> View Vendor PO Confirmation
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Vendor PO Confirmation Master</a></li>
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
                            <h3 class="box-title">View Vendor PO Confirmation Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnnewvendorconfrimationpoform" action="<?php echo base_url() ?>addnnewvendorconfrimationpoform" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-4">
  
                                 <input readonly  type="hidden" class="form-control" id="venodr_po_confirmation_id" name="venodr_po_confirmation_id" value="<?=$venodr_po_confirmation_id?>" required readonly>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="po_number">PO Confirmation Number<span class="required">*</span></label>
                                             <input readonly  type="text" class="form-control" id="po_number" name="po_number" value="<?=$getVendorpoconfirmationdetails[0]['vendor_po_confimation']?>" required readonly>
                                            <p class="error po_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date">Date <span class="required">*</span></label>
                                             <input readonly  type="text" class="form-control datepicker"  value="<?=$getVendorpoconfirmationdetails[0]['date']?>" id="date" name="date" required>
                                            <p class="error date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                                 <select readonly  class="form-control " name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$getVendorpoconfirmationdetails[0]['vendor_name_id']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                
                                    <div class="col-md-12 vendor_po_number_div">
                                            <div class="form-group">
                                                    <label for="vendor_po_number">Select Vendor PO Number <span class="required">*</span></label>
                                                     <select readonly  class="form-control vendor_name_for_buyer_name vendor_po_for_item vendor_po_get_data" name="vendor_po_number" id="vendor_po_number">
                                                        <option value="">Select Vendor PO Number</option>
                                                        <option value="<?php echo $getVendorpoconfirmationdetails[0]['vendor_po_']; ?>" <?php if($getVendorpoconfirmationdetails[0]['vendor_po_master_no']){ echo 'selected';} ?> ><?php echo $getVendorpoconfirmationdetails[0]['vendor_po_master_no']; ?></option>
                                                    </select> 
                                                <p class="error vendor_po_number_error"></p>
                                            </div>
                                    </div>

                                     <input readonly  type="hidden" class="form-control"  id="supplier_po_number" name="supplier_po_number">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                                 <select readonly  class="form-control" name="buyer_name" id="buyer_name" readonly>
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                    <option st-id="" value="<?php echo $getVendorpoconfirmationdetails['0']['buyer_id']; ?>"  <?php if($getVendorpoconfirmationdetails['0']['buyer_name_master']){ echo 'selected';} ?> ><?php echo $getVendorpoconfirmationdetails['0']['buyer_name_master']; ?></option>
                                                </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>

                

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="po_confirmed">PO Confirmed<span class="required">*</span></label>
                                                 <select readonly  class="form-control" name="po_confirmed" id="po_confirmed">
                                                    <option st-id="" value="">Select PO Confirmed</option>
                                                    <option st-id="" value="YES" <?php if($getVendorpoconfirmationdetails[0]['po_confirmed']=='YES'){ echo 'selected';} ?>>YES</option>
                                                    <option st-id="" value="NO"  <?php if($getVendorpoconfirmationdetails[0]['po_confirmed']=='NO'){ echo 'selected';} ?>>NO</option>
                                                </select>
                                            <p class="error po_confirmed_error"></p>
                                        </div>
                                    </div>


                                    <?php if($getVendorpoconfirmationdetails[0]['confirmed_date']){
                                        $confirmed_date= $getVendorpoconfirmationdetails[0]['confirmed_date'];
                                     }else{
                                        $confirmed_date= date('Y-m-d');
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="confirmed_date">Confirmed Date <span class="required">*</span></label>
                                             <input readonly  type="text" class="form-control datepicker" value="<?=$confirmed_date?>" id="confirmed_date" name="confirmed_date" required>
                                            <p class="error confirmed_date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="confirmed_with">Confirmed With <span class="required">*</span></label>
                                             <input readonly  type="text" class="form-control" id="confirmed_with" value="<?=$getVendorpoconfirmationdetails[0]['confirmed_with']?>" name="confirmed_with">
                                            <p class="error confirmed_with_error"></p>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="mode_of_communication">Mode of Communication</label>
                                                <select class="form-control" name="mode_of_communication" id="mode_of_communication">
                                                    <option st-id="" value="">Select Mode of Communication</option>
                                                    <option st-id="" value="By Call" <?php if($getVendorpoconfirmationdetails[0]['mode_of_communication']=='By Call'){ echo 'selected';} ?>>By Call</option>
                                                    <option st-id="" value="By Email" <?php if($getVendorpoconfirmationdetails[0]['mode_of_communication']=='By Email'){ echo 'selected';} ?>>By Email</option>
                                                    <option st-id="" value="By WhatsApp" <?php if($getVendorpoconfirmationdetails[0]['mode_of_communication']=='By WhatsApp'){ echo 'selected';} ?>>By WhatsApp</option>                                        
                                                </select>
                                            <p class="error mode_of_communication_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                  <textarea type="text" class="form-control"  id="remark"  value="" name="remark" required><?=$getVendorpoconfirmationdetails[0]['remark_master']?></textarea>
                                                <p class="error remark_error"></p>
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="container">
                                        <!-- <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/> -->
                                            <table class="table table-bordered" style="width: 70% !important; max-width: 100%;margin-bottom: 20px;">
                                                <thead style="background-color:#3c8dbc;color:#fff">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Part Number</th>
                                                        <th>Description</th>
                                                        <th>Vendor  Qty</th>
                                                        <th>Order Qty</th>
                                                        <th>Raw Material Received Quantity</th>
                                                        <th>Finished Good Received Quantity</th>
                                                        <th>Gross Weight</th>
                                                        <th>Expected Quantity</th>
                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($fetchALLpreVendorpoconfirmationitemListedit as $key => $value) :
                                                           $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['description'];?></td>
                                                        <td><?php echo $value['vendor_qty'];?></td>
                                                        <td><?php echo $value['order_qty'];?></td>
                                                        <td><?php echo $value['row_material_recived_qty'];?></td>
                                                        <td><?php echo $value['finished_good_recived_qty'];?></td>
                                                        <td><?php echo $value['gross_weight'];?></td>
                                                        <td><?php echo $value['expected_qty'];?></td>
                                                        <!-- <td>
                                                           <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['vendoritemid'];?>' class='fa fa-pencil-square-o editvendorpoconfirmationitem'  aria-hidden='true'></i>
                                                           <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['vendoritemid'];?>' class='fa fa-trash-o deletevendorpoitem' aria-hidden='true'></i>
                                                        </td> -->
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                    </div>

                                    <div class="container">
                                         <div id="supplier_po_item_list">
                                         </div>

                                         <div id="customers-list">
                                         </div>
                                    </div>

                                      <!-- Add New Package Modal -->
                                    <?php $this->load->helper("form"); ?>
                                    <div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="additem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                      
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="additem">Add New Item</h3>
                                                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                                                <!-- <span aria-hidden="true">&times;</span> -->
                                                </button>
                                            </div>
                                            <form role="form" id="saveVendorconfromationpoitemform" action="<?php echo base_url() ?>saveVendorconfromationpoitemform" method="post" role="form">
                                             <input readonly  type="hidden" class="form-control"  id="vendor_po_confirmation_item_id" name="vendor_po_confirmation_item_id" required readonly>

                                                <div class="modal-body">
                                                        <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                        </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Part Number <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                             <select readonly  class="form-control" name="part_number" id="part_number">
                                                                <option st-id="" value="">Select Part Name</option>
                                                                <!-- <?php foreach ($rowMaterialList as $key => $value) {?>        
                                                                    <option value="<?php echo $value['raw_id']; ?>"><?php echo $value['part_number']; ?></option>
                                                                <?php } ?> -->
                                                            </select>
                                                            <p class="error part_number_error"></p>

                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Part Name <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                             <input readonly  type="type" class="form-control"  id="description" name="description" required readonly>
                                                            <p class="error description_error"></p>
                                                        </div>
                                                    </div>



                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Vendor Quantity</label>
                                                        <div class="col-sm-8">
                                                             <input readonly  type="number" class="form-control"  id="vendor_qty" name="vendor_qty" readonly>
                                                            <p class="error vendor_qty_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Raw Material Order Quantity (In Kgs / pcs)<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                             <input readonly  type="number" class="form-control"  id="qty" name="qty" readonly>
                                                            <p class="error qty_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Raw Material Received Quantity (In Kgs / pcs)<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                             <input readonly  type="number" class="form-control"  id="rmqty" name="rmqty"  readonly>
                                                            <p class="error rmqty_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Finished Good Received Quantity (In Kgs / pcs)</label>
                                                        <div class="col-sm-8">
                                                             <input readonly  type="number" class="form-control"  id="finishedgoodqty" value="0" name="finishedgoodqty">
                                                            <p class="error finishedgoodqty_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Gross Weight <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                             <input readonly  type="number" class="form-control"  id="gross_weight" name="gross_weight" readonly>
                                                            <p class="error gross_weight_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Expected Quantity (In pcs)<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                             <input readonly  type="number" class="form-control"  id="expected_qty" name="expected_qty" readonly>
                                                            <p class="error expected_qty_error"></p>
                                                        </div>
                                                    </div>
                                                

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Remark</label>
                                                        <div class="col-sm-8">
                                                           <textarea type="text" class="form-control"  id="item_remark"  name="item_remark"></textarea>
                                                           <p class="error item_remark_error"></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-xl closeVendorpoconfirmation" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="saveVendorconfromationpoitem" name="saveVendorconfromationpoitem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
                                                </div>

                                            </form>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>

                            </div>    
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-xs-8">
                                    <?php if($fetchALLpreVendorpoconfirmationitemListedit){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>
                                     <!-- <input readonly  type="submit" id="savenewvendorconfrimationpo" class="btn btn-primary" value="Submit" <?=$disabled?>> -->
                                     <input readonly  type="button" onclick="location.href = '<?php echo base_url() ?>vendorpoconfirmation'" class="btn btn-default" value="Back" />
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

