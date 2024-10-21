<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Job Work
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Edit Job Work</a></li>
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
                            <h3 class="box-title">Edit Job Work Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnnewjobworkform" action="<?php echo base_url() ?>addnnewjobworkform" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-4">

                                    <input type="hidden" class="form-control" id="job_work_id" name="job_work_id" value="<?=$jobworkid?>" required readonly>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="job_work_no">JoB Work No<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="job_work_no" name="job_work_no" value="<?=$getalljobworkdetails[0]['job_work_po']?>" required readonly>
                                            <p class="error job_work_no_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date">Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker"  value="<?=$getalljobworkdetails[0]['job_work_date']?>" id="date" name="date" required>
                                            <p class="error date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                                <select class="form-control vendor_name" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$getalljobworkdetails[0]['vendor_name']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                <?php
                                 
                                 if($getalljobworkdetails[0]['vendor_po']){
                                     $display='block';
                                     $selected_value = $getalljobworkdetails[0]['vendor_po'];

                                 }else{
                                     $display='none';
                                     $selected_value = 'Select Buyer PO Number';
                                 }
                                 
                                             
                                 ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_po_number">Select Vendor PO Number <span class="required">*</span></label>
                                                    <select class="form-control vendor_po_number_itam" name="vendor_po_number" id="vendor_po_number" readonly>
                                                        <!-- <option st-id="" value="">Select Vendor Name</option> -->
                                                        <option st-id="" value="<?=$getalljobworkdetails[0]['pre_vendor_po']?>" selected="selected"><?=$selected_value?></option>
                                                    </select>
                                            <p class="error vendor_po_number_error"></p>
                                        </div>
                                    </div>

                                    

                                    <?php
                                 
                                    if($getalljobworkdetails[0]['supplier_name_sup']){
                                        $display='block';
                                        $selected_value_supplier_name_sup = $getalljobworkdetails[0]['supplier_name_sup'];

                                    }else{
                                        $display='none';
                                        $selected_value_supplier_name_sup = 'Select Buyer PO Number';
                                    }
                                    
                                                
                                    ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="raw_material_supplier_name">Raw Material Supplier Name <span class="required">*</span></label>
                                                    <select class="form-control " name="raw_material_supplier_name" id="raw_material_supplier_name" readonly>
                                                        <option st-id="" value="<?=$getalljobworkdetails[0]['raw_material_supplier']?>"><?=$selected_value_supplier_name_sup?></option>
                                                    </select>
                                            <p class="error raw_material_supplier_name_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="text" class="form-control" id="remark" name="remark" value="<?=$getalljobworkdetails[0]['jobwork_remark'] ?>">
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="container">
                                        <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/>
                                            <table class="table table-bordered" style="max-width: 68%;display: block;overflow-x: auto; white-space: nowrap;">
                                                <thead style="background-color:#3c8dbc;color:#fff">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Part Number</th>
                                                        <th>Description</th>
                                                        <th>Vendor  Qty</th>
                                                        <th>Rm Actual Qty</th>
                                                        <th>Rm Rate</th>
                                                        <th>Value</th>
                                                        <th>Packing & Forwarding</th>
                                                        <th>Total </th>
                                                        <th>GST</th>
                                                        <th>Grand Total</th>
                                                        <th>Remark</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($fetchALLprejobworkitemList as $key => $value) :
                                                           $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['description'];?></td>
                                                        <td><?php echo $value['vendor_qty'];?></td>
                                                        <td><?php echo $value['rm_actual_qty'];?></td>
                                                        <td><?php echo $value['ram_rate'];?></td>
                                                        <td><?php echo $value['value'];?></td>
                                                        <td><?php echo $value['packing_forwarding'];?></td>
                                                        <td><?php echo $value['total'];?></td>
                                                        <td><?php echo $value['gst'];?></td>
                                                        <td><?php echo $value['grand_total'];?></td>
                                                        <td><?php echo $value['item_remark'];?></td>
                                                        <td>
                                                          <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['jobworkid'];?>' class='fa fa-pencil-square-o editjobworkitem'  aria-hidden='true'></i>
                                                          <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['jobworkid'];?>' class='fa fa-trash-o deletejobworkitem' aria-hidden='true'></i>
                                                        </td>
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
                                            <form role="form" id="savejobworkitemform" action="<?php echo base_url() ?>savejobworkitemform" method="post" role="form">
                                            <input type="hidden" class="form-control"  id="jobwork_item_id" name="jobwork_item_id" required readonly>

                                                <div class="modal-body">
                                                        <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                        </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Part Number <span class="required">*</span> (<small>Row Material Goods Master</small>)</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="part_number" id="part_number">
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
                                                            <input type="type" class="form-control"  id="description" name="description" required readonly>
                                                            <p class="error description_error"></p>
                                                        </div>
                                                    </div>



                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">SAC Code</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="SAC" name="SAC" readonly>
                                                            <p class="error SAC_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">HSN Code</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="HSN_Code" name="HSN_Code" readonly>
                                                            <p class="error HSN_Code_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Raw Material Size</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="raw_material_size" name="raw_material_size" readonly>
                                                            <p class="error raw_material_size_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Vendor Order Qty</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="vendor_order_qty" name="vendor_order_qty" readonly>
                                                            <p class="error vendor_order_qty_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">RM Actual Qty <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="rm_actual_aty" name="rm_actual_aty">
                                                            <p class="error rm_actual_aty_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Unit <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                             <select class="form-control" name="unit" id="unit">
                                                                <option value="">Select Unit</option>
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
                                                        <label class="col-sm-4 col-form-label">R.M Rate<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="rm_rate" name="rm_rate" readonly>
                                                            <p class="error rm_rate_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Value<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="value" name="value" readonly>
                                                            <p class="error value_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Packing & Forwarding<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="packing_and_forwarding"  value="0" name="packing_and_forwarding">
                                                            <p class="error packing_and_forwarding_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Total<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="total" name="total" readonly>
                                                            <p class="error total_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Select GST Rate<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                                <select class="form-control" name="gst_rate" id="gst_rate">
                                                                    <option value="">Select GST Rate</option>
                                                                    <option value="CGST_SGST">CGST + SGST ( 9% + 9% )</option>
                                                                    <option value="IGST">IGST ( 18% )</option>
                                                                </select>
                                                            <p class="error gst_rate_error"></p>
                                                        </div>
                                                    </div>



                                                    <div class="form-group row cgst_sgst_div" style="display:none">
                                                        <label class="col-sm-2 col-form-label">SGST 9 %<span class="required">*</span></label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control"  id="SGST_rate" name="SGST_rate" readonly>
                                                            <p class="error SGST_rate_error"></p>
                                                        </div>

                                                        <label class="col-sm-2 col-form-label">CGST 9 %<span class="required">*</span></label>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control"  id="CGST_rate" name="CGST_rate" readonly>
                                                            <p class="error CGST_rate_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row igst_div" style="display:none">
                                                        <label class="col-sm-4 col-form-label">IGST 18 %<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="igst_rate" name="igst_rate" readonly>
                                                            <p class="error igst_rate_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">GST (9 + 9 or 18)<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="gst" name="gst" readonly>
                                                            <p class="error gst_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Grand Total<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="grand_total" name="grand_total" readonly>
                                                            <p class="error grand_total_error"></p>
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
                                                    <button type="button" class="btn btn-secondary btn-xl closejobworkmodal" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="saveJobworktem" name="saveJobworktem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
                                    <?php if($fetchALLprejobworkitemList){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>
                                    <input type="submit" id="savenewjobwork" class="btn btn-primary" value="Submit">
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>jobWork'" class="btn btn-default" value="Back" />
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

