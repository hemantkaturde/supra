<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> Add New Qulity Record
         <small>
            <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
               <li class="completed"><a href="javascript:void(0);">Masters</a></li>
               <li class="active"><a href="javascript:void(0);"> POD Details</a></li>
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
                     <h3 class="box-title">Add New Qulity Record</h3>
                  </div>
                  <?php $this->load->helper("form"); ?>
                  <form role="form" id="addnewPODform" action="#" method="post" role="form">
                     <div class="box-body">
                        <div class="col-md-4">
                           <?php
                              if($getPreviousPODdetails_number[0]['pod_details_number']){
                                  $arr = str_split($getPreviousPODdetails_number[0]['pod_details_number']);
                                  $i = end($arr);
                                  $inrno= "SQPD2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                  $POD_details_number = $inrno;
                              }else{
                                  $POD_details_number = 'SQPD23240001';
                              }
                              ?>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="POD_details_number">POD Details Number<span class="required">*</span></label>
                                 <input type="text" class="form-control" id="c" value="<?=$POD_details_number?>" name="POD_details_number" readonly>
                                 <p class="error POD_details_number_error"></p>
                              </div>
                           </div>
                           <?php $date= date('Y-m-d'); ?>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="POD_details_date">POD Details Date <span class="required">*</span></label>
                                 <input type="text" class="form-control datepicker"  value="<?=$date?>" id="POD_details_date" name="POD_details_date" required>
                                 <p class="error POD_details_date_error"></p>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="select_with_po_without_po">Select With PO / Without PO <span class="required">*</span></label>
                                 <select class="form-control" name="select_with_po_without_po" id="select_with_po_without_po">
                                    <option st-id="" value="">Select With PO / Without PO</option>
                                    <option value="with_po" <?php if($getdebitnoteitemdetails[0]['pre_select_with_po_without_po']=='with_po'){ echo 'selected'; } ?>>With PO</option>
                                    <option value="without_po" <?php if($getdebitnoteitemdetails[0]['pre_select_with_po_without_po']=='without_po'){ echo 'selected'; } ?>>Without PO</option>
                                 </select>
                                 <p class="error select_with_po_without_po_error"></p>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="vendor_supplier_name">Select Vendor / Supplier <span class="required">*</span></label>
                                 <select class="form-control vendor_supplier_name" name="vendor_supplier_name" id="vendor_supplier_name">
                                    <option st-id="" value="">Select Vendor / Supplier</option>
                                    <option value="vendor" <?php if($getdebitnoteitemdetails[0]['pre_vendor_supplier_name']=='vendor'){ echo 'selected'; } ?>>Vendor</option>
                                    <option value="supplier" <?php if($getdebitnoteitemdetails[0]['pre_vendor_supplier_name']=='supplier'){ echo 'selected'; } ?>>Supplier</option>
                                 </select>
                                 <p class="error vendor_supplier_name_error"></p>
                              </div>
                           </div>
                           <div id="vendor_name_div_for_hide_show" style="display:none">
                              <div class="col-md-12" >
                                 <div class="form-group">
                                    <label for="vendor_name">Vendor Name</label>
                                    <select class="form-control vendor_name" name="vendor_name" id="vendor_name">
                                       <option st-id="" value="">Select Vendor Name</option>
                                       <?php foreach ($vendorList as $key => $value) {?>
                                       <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$getdebitnoteitemdetails[0]['pre_vendor_name']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                       <?php } ?>
                                    </select>
                                    <p class="error vendor_name_error"></p>
                                 </div>
                              </div>
                              <div class="col-md-12 vendor_po_number_div" id="vendor_po_number_div" style="display:none">
                                 <div class="form-group">
                                    <label for="vendor_po_number">Select Vendor PO Number</label>
                                    <select class="form-control vendor_po_number_itam" name="vendor_po_number" id="vendor_po_number">
                                       <!-- <option st-id="" value="">Select Vendor Name</option> -->
                                       <!-- <option st-id="" value="<?=$getdebitnoteitemdetails[0]['pre_vendor_po_number']?>" selected="selected"><?=$selected_value?></option> -->
                                    </select>
                                    <p class="error vendor_po_number_error"></p>
                                 </div>
                              </div>
                           </div>
                           <div id="supplier_name_div_for_hide_show" style="display:none">
                              <div class="col-md-12" >
                                 <div class="form-group">
                                    <label for="supplier_name">Supplier Name </label>
                                    <select class="form-control" name="supplier_name" id="supplier_name">
                                       <option st-id="" value="">Select Supplier Name</option>
                                       <?php foreach ($supplierList as $key => $value) {?>
                                       <option value="<?php echo $value['sup_id']; ?>" <?php if($value['sup_id']==$getdebitnoteitemdetails[0]['pre_supplier_name']){ echo 'selected';} ?> ><?php echo $value['supplier_name']; ?></option>
                                       <?php } ?>
                                    </select>
                                    <p class="error supplier_name_error"></p>
                                 </div>
                              </div>
                              <div class="col-md-12 supplier_po_number_div" id="supplier_po_number_div" style="display:none">
                                 <div class="form-group">
                                    <label for="supplier_po_number">Select Supplier PO Number</label>
                                    <select class="form-control supplier_po_number_item supplier_po_number_for_item" name="supplier_po_number" id="supplier_po_number">
                                       <!-- <option st-id="" value="">Select Vendor Name</option> -->
                                       <!-- <option st-id="" value="<?=$getdebitnoteitemdetails[0]['pre_supplier_po_number']?>" selected="selected"><?=$selected_value?></option> -->
                                    </select>
                                    <p class="error supplier_po_number_error"></p>
                                 </div>
                              </div>
                           </div>
                           <?php  $po_date= date('Y-m-d'); ?>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="po_date">PO Date <span class="required">*</span></label>
                                 <input type="text" class="form-control datepicker"  value="<?=$po_date?>" id="po_date" name="po_date" required>
                                 <p class="error po_date_error"></p>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="remark">Remark</label>
                                 <textarea type="text" class="form-control"  id="remark"  name="remark"></textarea>
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
                                                        <th>F.G Part Number</th>
                                                        <th>F.G Description</th>
                                                        <th>Inspection Report No</th>
                                                        <th>Inspection Report Date</th>
                                                        <th>LOT Qty</th>
                                                        <th>Inspected By</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($getdebitnoteitemdetails as $key => $value) :
                                                           $count++;
                                                           $debit_gst_value =  intval($value['SGST_value']) + intval($value['CGST_value']) + intval($value['IGST_value']);

                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['name'];?></td>
                                                        <td><?php echo $value['invoice_no'];?></td>
                                                        <td><?php echo $value['invoice_date'];?></td>
                                                        <td><?php echo $value['invoice_qty'];?></td>
                                                        <td><?php echo $value['ok_qty'];?></td>
                                                        <td>
                                                        <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['debit_note_id'];?>' class='fa fa-trash-o deleteDebitnoteitem' aria-hidden='true'></i>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                    </div>

                                    <!-- <div class="container">
                                         <div id="supplier_po_item_list">
                                         </div>

                                         <div id="customers-list">
                                         </div>
                                    </div> -->

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
                                            <form role="form" id="savePODitem_form" action="#" method="post" role="form">

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
                                                        <label class="col-sm-4 col-form-label">Part Name / Description <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="type" class="form-control"  id="description" name="description" required readonly>
                                                            <p class="error description_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Inspection Report No<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="order_qty" name="order_qty">
                                                            <p class="error order_qty_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Inspection Report Date<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="lot_no" name="lot_no">
                                                            <p class="error lot_no_error"></p>
                                                        </div>
                                                    </div>  

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">LOT Qty<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="qty_recived" name="qty_recived">
                                                            <p class="error qty_recived_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Inspected By<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="unit" name="unit">
                                                            <p class="error unit_error"></p>
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
                                                    <button type="button" class="btn btn-secondary btn-xl closedebitnotemodel" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="savedebitnoteitem" name="savedebitnoteitem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
                           <input type="submit" id="savenewpoddetails" class="btn btn-primary" value="Submit">
                           <input type="button" onclick="location.href = '<?php echo base_url() ?>poddetails'" class="btn btn-default" value="Back" />
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