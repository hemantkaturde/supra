<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> Add New Stock Form
         <small>
            <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
               <li class="completed"><a href="javascript:void(0);">Masters</a></li>
               <li class="active"><a href="javascript:void(0);"> Stock Form Details</a></li>
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
                     <h3 class="box-title">Add New Stock Form Details</h3>
                  </div>
                  <?php $this->load->helper("form"); ?>
                  <form role="form" id="addstockform" action="#" method="post" role="form">
                     <div class="box-body">
                        <div class="col-md-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="stock_id">Stock Id <span class="required">*</span></label>
                                    <?php
                                        if($getPriviousstockid[0]['stock_id_number']){
                                            $arr = str_split($getPriviousstockid[0]['stock_id_number']);
                                            $i = end($arr);
                                            $inrno= "SQSD2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            $stock_form_id = $inrno;
                                        }else{
                                            $stock_form_id = 'SQSD23240001';
                                        }
                                    ?>
                                        <input type="text" class="form-control" id="stock_id" name="stock_id" value="<?=$stock_form_id;?>" required readonly>
                                        <p class="error stock_id_error"></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="stock_date">Stock Date <span class="required">*</span></label>
                                        <?php $date= date('Y-m-d'); ?>
                                        <input type="text" class="form-control datepicker" id="stock_date" name="stock_date" value="<?=$date?>"  required >
                                        <p class="error stock_date_error"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                            <select class="form-control" name="vendor_name" id="vendor_name">
                                                <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                        <option value="<?php echo $value['ven_id']; ?>"><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                            </select>
                                        <p class="error vendor_name_error"></p>
                                </div>
                            </div>

                            <div class="col-md-12 vendor_po_number_div" id="vendor_po_number_div">
                                <div class="form-group">
                                    <label for="vendor_po_number">Select Vendor PO Number</label>
                                        <select class="form-control vendor_po_for_item vendor_name_for_buyer_name  vendor_po_for_buyer_details_ vendor_po_get_data" name="vendor_po_number" id="vendor_po_number">
                                            <!-- <option st-id="" value="">Select Vendor Name</option> -->
                                        </select>
                                    <p class="error vendor_po_number_error"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="buyer_po">Vendor PO Date</label>
                                        <input type="text" class="form-control" id="vendor_po_date" name="vendor_po_date"  required readonly>
                                        <p class="error vendor_po_date_error"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="buyer_name">Buyer Name</label>
                                            <select class="form-control" name="buyer_name" id="buyer_name" readonly>
                                                    <option st-id="" value="<?php echo $fetchALLpreVendorpoconfirmationitemList['0']['buyer_name']; ?>" ><?php echo $fetchALLpreVendorpoconfirmationitemList['0']['buyer_name_master']; ?></option>

                                                    <option st-id="" value="">Select Buyer Name</option>
                                                    <!-- <?php foreach ($buyerList as $key => $value) {?>
                                                    <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$fetchALLpresupplierpoconfirmationitemList[0]['pre_buyer_name']){ echo 'selected';} ?> ><?php echo $value['buyer_name']; ?></option>
                                                    <?php } ?> -->
                                                </select>
                                        <p class="error buyer_name_error"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="buyer_po_number">Buyer PO Number</label>
                                    <input type="hidden" class="form-control" id="buyer_po_id" name="buyer_po_id" required readonly>
                                     <input type="text" class="form-control" id="buyer_po_number" name="buyer_po_number" required readonly>
                                    <p class="error buyer_po_number_error"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="buyer_po_date">Buyer PO Date</label>
                                     <input type="text" class="form-control" id="buyer_po_date" name="buyer_po_date" required readonly>
                                    <p class="error buyer_po_date_error"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="buyer_delivery_date">Buyer Delivery Date</label>
                                        <input type="text" class="form-control" id="buyer_delivery_date"  name="buyer_delivery_date" required readonly>
                                    <p class="error buyer_delivery_date_error"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Invoice_qty_in_pcs">Invoice Qty (In pcs)</label>
                                        <input type="text" class="form-control" id="Invoice_qty_in_pcs" name="Invoice_qty_in_pcs"  required readonly>
                                        <p class="error Invoice_qty_in_pcs_error"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Invoice_qty_in_kgs">Invoice Qty (In Kgs)</label>
                                        <input type="text" class="form-control" id="Invoice_qty_in_kgs" name="Invoice_qty_in_kgs"  required readonly>
                                        <p class="error Invoice_qty_in_kgs_error"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="actual_received_qty_in_pcs">Actual received Qty (In Pcs)</label>
                                        <input type="text" class="form-control" id="actual_received_qty_in_pcs" name="actual_received_qty_in_pcs"  readonly>
                                        <p class="error actual_received_qty_in_pcs_error"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="actual_received_qty_in_kgs">Actual received Qty (In Kgs)</label>
                                        <input type="text" class="form-control" id="actual_received_qty_in_kgs" name="actual_received_qty_in_kgs"  required readonly>
                                        <p class="error actual_received_qty_in_kgs_error"></p>
                                </div>
                            </div>

                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="balance_qty_in_kgs">Remark</label>
                                        <textarea class="form-control" name="remark" id="remark" rows="8"></textarea>
                                        <p class="error remark_error"></p>
                                </div>
                            </div>
                            
                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                    <label for="total_rejected_in_pcs">Total Rejected Qty (In Pcs)</label>
                                        <input type="text" class="form-control" id="total_rejected_in_pcs" name="total_rejected_in_pcs"  required readonly>
                                        <p class="error total_rejected_in_pcs_error"></p>
                                </div>
                            </div> -->
<!-- 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="total_rejected_in_pcs_kgs">Total Rejected Qty (In Kgs)</label>
                                        <input type="text" class="form-control" id="total_rejected_in_pcs_kgs" name="total_rejected_in_pcs_kgs"  required readonly>
                                        <p class="error total_rejected_in_pcs_kgs_error"></p>
                                </div>
                            </div> -->
<!-- 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="reday_for_export_pcs">Ready For Export (In Pcs)</label>
                                        <input type="text" class="form-control" id="reday_for_export_pcs" name="reday_for_export_pcs"  required readonly>
                                        <p class="error reday_for_export_pcs_error"></p>
                                </div>
                            </div> -->

                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                    <label for="reday_for_export_kgs">Ready For Export (In Kgs)</label>
                                        <input type="text" class="form-control" id="reday_for_export_kgs" name="reday_for_export_kgs"  required readonly>
                                        <p class="error reday_for_export_kgs_error"></p>
                                </div>
                            </div> -->
                        </div>

                        <!-- <div class="col-md-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="total_rejection_qty_kgs">Total Rejection Qty (In Kgs)</label>
                                        <input type="text" class="form-control" id="total_rejection_qty_kgs" name="total_rejection_qty_kgs"  required readonly>
                                        <p class="error total_rejection_qty_kgs_error"></p>
                                </div>
                            </div> -->

                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                    <label for="total_export_qty_pcs">Total Export Qty (In Pcs)</label>
                                        <input type="text" class="form-control" id="total_export_qty_pcs" name="total_export_qty_pcs"  required readonly>
                                        <p class="error total_export_qty_pcs_error"></p>
                                </div>
                            </div> -->

                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                    <label for="total_export_qty_kgs">Total Export Qty (In Kgs)</label>
                                        <input type="text" class="form-control" id="total_export_qty_kgs" name="total_export_qty_kgs"  required readonly>
                                        <p class="error total_export_qty_kgs_error"></p>
                                </div>
                            </div> -->

                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                    <label for="balance_qty_in_pics">Balance Qty (In Pics)</label>
                                        <input type="text" class="form-control" id="balance_qty_in_pics" name="balance_qty_in_pics"  required readonly>
                                        <p class="error balance_qty_in_pics_error"></p>
                                </div>
                            </div> -->

                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                    <label for="balance_qty_in_kgs">Balance Qty (In Kgs)</label>
                                        <input type="text" class="form-control" id="balance_qty_in_kgs" name="balance_qty_in_kgs"  required readonly>
                                        <p class="error balance_qty_in_kgs_error"></p>
                                </div>
                            </div> -->
<!-- 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="balance_qty_in_kgs">Remark</label>
                                        <textarea class="form-control" name="remark" id="remark" rows="8"></textarea>
                                        <p class="error remark_error"></p>
                                </div>
                            </div> -->
                        </div>  
                        
                        <div class="col-md-12">
                           <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/>
                             <table class="table  table-bordered">
                                <thead style="background-color: #3c8dbc;">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Part Number</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Buyer Order Qty</th>
                                        <th scope="col">F.G Order Qty</th>
                                        <th scope="col">Invoice No.</th>
                                        <th scope="col">Invoice Date</th>
                                        <th scope="col">Invoice Qty (In Pcs)</th>
                                        <th scope="col">Invoice Qty (In Kgs)</th>
                                        <th scope="col">Lot No.</th>
                                        <th scope="col">Actual Received Qty (In Pcs)</th>
                                        <th scope="col">Actual Received Qty (In Kgs)</th>
                                        <th scope="col">Previous Balance</th>
                                        <th scope="col">Remark</th>
                                    </tr>
                                    </thead>   

                                         <?php 
                                           if($getItemlistStockform){
                                               $i=1;
                                            foreach ($getItemlistStockform as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo  $i++; ?></td>
                                                <td><?=$value['part_number']?></td>
                                                <td><?=$value['name']?></td>
                                                <td><?=$value['buyer_order_qty']?></td>
                                                <td><?=$value['f_g_order_qty']?></td>
                                                <td><?=$value['invoice_number']?></td>
                                                <td><?=$value['invoice_date']?></td>
                                                <td><?=$value['invoice_qty_In_pcs']?></td>
                                                <td><?=$value['invoice_qty_In_kgs']?></td>
                                                <td><?=$value['lot_number']?></td>
                                                <td><?=$value['actual_received_qty_in_pcs']?></td>
                                                <td><?=$value['actual_received_qty_in_kgs']?></td>
                                                <td><?=$value['previous_balence']?></td>
                                                <td><?=$value['item_remark']?></td>
                                            <tr>   

                                          <?php  } }else{ ?>
                                            <tr>
                                               <td colspan="14"><p> <i>No Stock Form Items Found</i></p></td>
                                            </tr>
                                         <?php } ?>

                                    <tbody>
                                </tbody>
                             </table> 
                        </div>
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <div class="col-xs-8">
                           <input type="submit" id="addnewstockform" class="btn btn-primary" value="Submit">
                           <input type="button" onclick="location.href = '<?php echo base_url() ?>stockform'" class="btn btn-default" value="Back" />
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


                                <!-- Add New Package Modal -->
                                <?php $this->load->helper("form"); ?>
                                    <div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="additem" aria-hidden="true" data-backdrop="static" data-keyboard="false">

                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="additem">Add New Item</h3>
                                                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                                                <!-- <span aria-hidden="true">&times;</span> -->
                                                </button>
                                            </div>
                                            <form role="form" id="saveBillofmaterialform" action="<?php echo base_url() ?>saveBillofmaterialform" method="post" role="form">
                                                <div class="modal-body">
                                                    <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="part_number">F.G Part Number <span class="required">*</span></label>
                                                                    <select class="form-control" name="part_number" id="part_number">
                                                                        <option st-id="" value="">Select F.G Part Number</option>
                                                                    </select>
                                                                   <p class="error part_number_error"></p>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for="description">Description</label>
                                                                <input type="text" class="form-control" id="description" name="description" readonly>
                                                                <p class="error description_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="part_number">Buyer Order Qty</label>
                                                                <input type="text" class="form-control" id="buyre_order_qty" name="buyre_order_qty" readonly>
                                                                <p class="error buyre_order_qty_error"></p>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for="fg_order_qty">F.G Order Qty</label>
                                                                <input type="text" class="form-control" id="fg_order_qty" name="fg_order_qty" readonly>
                                                                <p class="error tfg_order_qty_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="invoice_number">Invoice Number</label>
                                                                <input type="text" class="form-control" id="invoice_number" name="invoice_number">
                                                                <p class="error invoice_number_error"></p>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                            <?php $Invoice_date= date('Y-m-d'); ?>
                                                                <label for="invoice_date">Invoice Date</label>
                                                                <input type="text" class="form-control datepicker" id="invoice_date" value="<?=$Invoice_date?>" name="invoice_date">
                                                                <p class="error invoice_date_error"></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="invoice_qty_in_pcs">Invoice Qty (In Pcs) </label>
                                                                <input type="text" class="form-control" id="invoice_qty_in_pcs" name="invoice_qty_in_pcs">
                                                                <p class="error invoice_qty_in_pcs_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="invoice_qty_in_kgs">Invoice Qty (In Kgs) </label>
                                                                <input type="text" class="form-control" id="invoice_qty_in_kgs" name="invoice_qty_in_kgs">
                                                                <p class="error invoice_qty_in_kgs_error"></p>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for="lot_number">Lot No. </label>
                                                                <input type="text" class="form-control" id="lot_number" name="lot_number">
                                                                <p class="error lot_number_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="actaul_recived_qty_in_pics">Actual Received Qty (In Pcs) </label>
                                                                <input type="text" class="form-control" id="actaul_recived_qty_in_pics" name="actaul_recived_qty_in_pics">
                                                                <p class="error actaul_recived_qty_in_pics_error"></p>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for="actaul_recived_qty_in_kgs">Actual Received Qty (In kgs) </label>
                                                                <input type="text" class="form-control" id="actaul_recived_qty_in_kgs" name="actaul_recived_qty_in_kgs">
                                                                <p class="error tactaul_recived_qty_in_kgs_error"></p>
                                                            </div>


                                                            <div class="form-group">
                                                                <label for="privious_balenace">Previous Balenced</label>
                                                                <input type="text" class="form-control" id="privious_balenace" name="privious_balenace">
                                                                <p class="error privious_balenace_error"></p>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for="itemremark">Remark</label>
                                                                <input type="text" class="form-control" id="itemremark" name="itemremark">
                                                                <p class="error itemremark_error"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-xl closebillofmaterialmodal" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="saveStockform_item" name="saveStockform_item" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
                                                </div>
                                            </form>    
                                            </div>
                                        </div>
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
