<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> View Supplier PO Confirmation
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">View Supplier PO Confirmation</a></li>
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
                            <h3 class="box-title">View PO Confirmation Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnnewsupplierconfrimationpoform" action="<?php echo base_url() ?>addnnewsupplierconfrimationpoform" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-4">

                                     <input readonly  type="hidden" class="form-control" id="supplierpoconfirmation_id" name="supplierpoconfirmation_id" value="<?=$supplierpoconfirmationid?>" required readonly>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="po_number">PO Number<span class="required">*</span></label>
                                             <input readonly  type="text" class="form-control" id="po_number" name="po_number" value="<?=$getSupplierpoconfirmationdetails['confirmation_po']?>" required readonly>
                                            <p class="error po_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date">Date <span class="required">*</span></label>
                                             <input readonly  type="text" class="form-control"  value="<?=$getSupplierpoconfirmationdetails['date']?>" id="date" name="date" required>
                                            <p class="error date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="supplier_name">Supplier Name <span class="required">*</span></label>
                                                 <select readonly  class="form-control" name="supplier_name" id="supplier_name">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                    <?php foreach ($supplierList as $key => $value) {?>
                                                    <option value="<?php echo $value['sup_id']; ?>" <?php if($getSupplierpoconfirmationdetails['supplier_name']==$value['sup_id']){ echo 'selected';} ?> ><?php echo $value['supplier_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error supplier_name_error"></p>
                                        </div>
                                    </div>


                                    <?php  
                                    if($getSupplierpoconfirmationdetails['supplier_po_number']){
                                        $display='block';
                                        $selected_value = $getSupplierpoconfirmationdetails['supplier_po'];

                                    }else{
                                        $display='none';
                                        $selected_value = 'Select Supplier PO Number';
                                    } ?>

                                    <div class="col-md-12 supplier_po_number_div">
                                            <div class="form-group">
                                                    <label for="supplier_po_number">Select Supplier PO Number <span class="required">*</span></label>
                                                     <select readonly  class="form-control supplier_po_number_for_item supplier_po_number_for_buyer_details" name="supplier_po_number" id="supplier_po_number">
                                                        <option st-id="" value="<?=$getSupplierpoconfirmationdetails['supplier_po_number']?>" selected ><?=$selected_value;?></option>
                                                    </select> 
                                                <p class="error supplier_po_number_error"></p>
                                            </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                                 <select readonly  class="form-control" name="buyer_name" id="buyer_name">
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                    <?php foreach ($buyerList as $key => $value) {?>
                                                       <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$getSupplierpoconfirmationdetails['buyerpoid']){ echo 'selected';} ?> ><?php echo $value['buyer_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>


                                    <!-- <div class="col-md-12 buyer_po_number_div" style="display:<?=$display;?>">
                                            <div class="form-group">
                                                    <label for="buyer_po_number">Buyer PO Number <span class="required">*</span></label>
                                                     <select readonly  class="form-control" name="buyer_po_number" id="buyer_po_number">
                                                    <option st-id="" value="<?=$fetchALLpresupplierpoconfirmationitemList[0]['buyer_po_number']?>" selected ><?=$selected_value;?></option>
                                                        <option st-id="" value="">Select Buyer Name</option>
                                                        <?php foreach ($buyerList as $key => $value) {?>
                                                        <option value="<?php echo $value['buyer_id']; ?>" <?php if($getSupplierpoconfirmationdetails['buyer_id']==$getSupplierpoconfirmationdetails[0]['buyer_po_number']){ echo 'selected';} ?> ><?php echo $value['buyer_name']; ?></option>
                                                        <?php } ?>
                                                    </select> 
                                                <p class="error buyer_po_number_error"></p>
                                            </div>
                                    </div> -->

                                
                                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="po_confirmed">PO Confirmed<span class="required">*</span></label>
                                                 <select readonly  class="form-control" name="po_confirmed" id="po_confirmed">
                                                    <option st-id="" value="">Select PO Confirmed</option>
                                                    <option st-id="" value="YES" <?php if($getSupplierpoconfirmationdetails['po_confirmed']=='YES'){ echo 'selected'; }  ?>>YES</option>
                                                    <option st-id="" value="NO" <?php if($getSupplierpoconfirmationdetails['po_confirmed']=='NO'){ echo 'selected'; }  ?>>NO</option>
                                                </select>
                                            <p class="error po_confirmed_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="confirmed_date">Confirmed Date <span class="required">*</span></label>
                                             <input readonly  type="text" class="form-control" value="<?=$getSupplierpoconfirmationdetails['confirmed_date'];?>" id="confirmed_date" name="confirmed_date" required>
                                            <p class="error confirmed_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="confirmed_with">Confirmed With <span class="required">*</span></label>
                                             <input readonly  type="text" class="form-control" id="confirmed_with" value="<?=$getSupplierpoconfirmationdetails['confirmed_with'];?>" name="confirmed_with">
                                            <p class="error confirmed_with_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="material_sent">Material Sent (Material Dispatch or Not)</label>
                                                 <select readonly  class="form-control" name="material_sent" id="material_sent">
                                                    <option st-id="" value="">Select Material Sent</option>
                                                    <option st-id="" value="Yes" <?php if($getSupplierpoconfirmationdetails['material_sent']=='Yes'){ echo 'selected';} ?>>Yes</option>
                                                    <option st-id="" value="No"  <?php if($getSupplierpoconfirmationdetails['material_sent']=='No'){ echo 'selected';} ?>>No</option>
                                                </select>
                                            <p class="error material_sent_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="material_receipt_confirmation">Material Receipt Confirmation </label>
                                                 <select readonly  class="form-control" name="material_receipt_confirmation" id="material_receipt_confirmation">
                                                    <option st-id="" value="">Select Material Receipt Confirmation</option>
                                                    <option st-id="" value="Pending" <?php if($getSupplierpoconfirmationdetails['material_receipt_confirmation']=='Pending'){ echo 'selected';} ?>>Pending</option>
                                                    <option st-id="" value="Done" <?php if($getSupplierpoconfirmationdetails['material_receipt_confirmation']=='Done'){ echo 'selected';} ?>>Done</option>
                                        
                                                </select>
                                            <p class="error material_receipt_confirmation_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="mode_of_communication">Mode of Communication</label>
                                                <select class="form-control" name="mode_of_communication" id="mode_of_communication">
                                                    <option st-id="" value="">Select Mode of Communication</option>
                                                    <option st-id="" value="By Call" <?php if($getSupplierpoconfirmationdetails['mode_of_communication']=='By Call'){ echo 'selected';} ?>>By Call</option>
                                                    <option st-id="" value="By Email" <?php if($getSupplierpoconfirmationdetails['mode_of_communication']=='By Email'){ echo 'selected';} ?>>By Email</option>
                                                    <option st-id="" value="By WhatsApp" <?php if($getSupplierpoconfirmationdetails['mode_of_communication']=='By WhatsApp'){ echo 'selected';} ?>>By WhatsApp</option>                                        
                                                </select>
                                            <p class="error mode_of_communication_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                  <textarea readonly type="text" class="form-control"  id="remark"  name="remark" required> <?=$getSupplierpoconfirmationdetails['rm'];?></textarea>
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
                                                        <th>Order Qty</th>
                                                        <th>Sent Qty</th>
                                                        <th>Short / Excess</th>
                                                        <th>Vendor  Qty</th>
                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($fetchALLSupplierPOitemsforview as $key => $value) :
                                                           $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['type_of_raw_material'];?></td>
                                                        <td><?php echo $value['order_oty'];?></td>
                                                        <td><?php echo $value['sent_qty'];?></td>
                                                        <td><?php echo $value['short_excess'];?></td>
                                                        <td><?php echo $value['vendor_qty'];?></td>
                                                        <!-- <td><?php echo $value['unit'];?></td>
                                                        <td><?php echo $value['rate'];?></td>
                                                        <td><?php echo $value['value'];?></td> -->
                                                        <!-- <td>
                                                            <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['supplier_po_itemid'];?>' class='fa fa-pencil-square-o editSupplierpoconfimationitem'  aria-hidden='true'></i>
                                                            <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['supplier_po_itemid'];?>' class='fa fa-trash-o deleteSupplierpoitem' aria-hidden='true'></i>
                                                        </td> -->
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
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
                                            <form role="form" id="saveSupplierconfromationpoitemform" action="<?php echo base_url() ?>saveSupplierconfromationpoitemform" method="post" role="form">
                                             <input readonly  type="hidden" class="form-control"  id="supplier_confirmation_po_item_id" name="supplier_confirmation_po_item_id" required readonly>

                                                <div class="modal-body">
                                                        <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                        </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Part Number <span class="required">*</span> (<small>Row Material Goods Master</small>)</label>
                                                        <div class="col-sm-9">
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
                                                        <label class="col-sm-3 col-form-label">Part Name <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                             <input readonly  type="type" class="form-control"  id="description" name="description" required readonly>
                                                            <p class="error description_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Order Quantity <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                             <input readonly  type="number" class="form-control"  id="qty" name="qty" readonly>
                                                            <p class="error qty_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Sent Quantity (In kgs)<span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                             <input readonly  type="number" class="form-control"  id="sent_qty" name="sent_qty">
                                                            <p class="error sent_qty_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Unit</label>
                                                        <div class="col-sm-9">
                                                              <select readonly  class="form-control" name="unit" id="unit">
                                                                <option value="">Select Part Name</option>
                                                                <option value="kgs">Kgs</option>
                                                                <option value="Pcs">Pcs</option>
                                                                <option value="Nos">Nos</option>
                                                                <option value="Sheet">Sheet</option>
                                                               <option value="Set">Set</option>
<option value="Mtr">Mtr</option>
<option value="Ltr">Ltr</option>
                                                             </select>
                                                            <p class="error unit_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Short / Excess <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                             <input readonly  type="number" class="form-control"  id="short_excess" name="short_excess" readonly>
                                                            <p class="error short_excess_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Sent Quantity (In Pcs)</label>
                                                        <div class="col-sm-9">
                                                             <input readonly  type="number" class="form-control"  id="sent_qty_pcs" name="sent_qty_pcs">
                                                            <p class="error sent_qty_pcs_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Vendor Name <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                             <input readonly  type="text" class="form-control"  id="vendor_name" name="vendor_name" readonly>

                                                             <input readonly  type="hidden" class="form-control"  id="vendor_id" name="vendor_id" readonly>
                                                            
                                                            <p class="error vendor_name_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Vendor Quantity <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                             <input readonly  type="number" class="form-control"  id="vendor_qty" name="vendor_qty" readonly>
                                                            <p class="error vendor_qty_error"></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-xl closeSupplierpoconfirmation" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="saveSupplierconfromationpoitem" name="saveSupplierconfromationpoitem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
                                     <!-- <input readonly  type="submit" id="savenewsupplierconfrimationpo" class="btn btn-primary" value="Submit" <?=$disabled;?> /> -->
                                     <input readonly  type="button" onclick="location.href = '<?php echo base_url() ?>supplierpoconfirmation'" class="btn btn-default" value="Back" />
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

