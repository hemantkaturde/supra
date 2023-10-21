<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> Add New OMS Challan
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
                     <h3 class="box-title">Add New OMS Challan Details</h3>
                  </div>
                  <?php $this->load->helper("form"); ?>
                  <form role="form" id="addstockform" action="#" method="post" role="form">
                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="blasting_id">Blasting Id<span class="required">*</span></label>
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
                                            <input type="text" class="form-control" id="blasting_id" name="blasting_id" value="<?=$stock_form_id;?>" required readonly>
                                            <p class="error blasting_id_error"></p>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="oms_challan_date">OMS Challan Date <span class="required">*</span></label>
                                            <?php 
                                            if($getStockforminformation[0]['pre_stock_date']){
                                                $date= $getStockforminformation[0]['pre_stock_date'];
                                            }else{
                                                $date= date('Y-m-d'); 
                                            }
                                        ?>
                                            <input type="text" class="form-control datepicker" id="oms_challan_date" name="oms_challan_date" value="<?=$date?>"  required >
                                            <p class="error oms_challan_date_error"></p>
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
                                                            <option value="<?php echo $value['ven_id']; ?>" <?php if($getStockforminformation[0]['pre_vendor_name']==$value['ven_id']){ echo 'selected'; }?> ><?php echo $value['vendor_name']; ?></option>
                                                        <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-12 vendor_po_number_div" id="vendor_po_number_div">
                                    <div class="form-group">
                                        <?php 
                                            if($getStockforminformation[0]['pre_vendor_po_number']){
                                                $po_number=  '<option st-id="" value="'.$getStockforminformation[0]['pre_vendor_po_number'].'">'.$getStockforminformation[0]['po_number'].'</option>';
                                            }else{
                                                $po_number= '<option st-id="" value="">Select Vendor Name</option>'; 
                                            }
                                        ?>

                                        <label for="vendor_po_number">Select Vendor PO Number</label>
                                            <select class="form-control vendor_po_for_item vendor_name_for_buyer_name  vendor_po_for_buyer_details_ vendor_po_get_data" name="vendor_po_number" id="vendor_po_number">
                                                <?php echo $po_number;?>
                                            </select>
                                        <p class="error vendor_po_number_error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="buyer_po">Vendor PO Date</label>
                                        <?php 
                                            if($getStockforminformation[0]['pre_vendor_po_date']){
                                                $pre_vendor_po_date= $getStockforminformation[0]['pre_vendor_po_date'];
                                            }else{
                                                $pre_vendor_po_date= date('Y-m-d'); 
                                            }
                                        ?>
                                            <input type="text" class="form-control" id="vendor_po_date" name="vendor_po_date" value="<?=$pre_vendor_po_date?>" required readonly>
                                            <p class="error vendor_po_date_error"></p>
                                    </div>
                                </div>

                    
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">Remark</label>
                                        <input type="remark" class="form-control" id="remark" value="<?=$getStockforminformation[0]['pre_remark_item']?>" name="remark">
                                        <p class="error remark_error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        
                        <div class="col-md-12">
                           <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/>
                             <table class="table  table-bordered">
                                <thead style="background-color: #3c8dbc;">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Part Number</th>
                                        <th scope="col">F.G Description</th>
                                        <th scope="col">R.M Description</th>
                                        <th scope="col">Gross Weight</th>
                                        <th scope="col">Net Weight</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">No of Bags</th>
                                        <th scope="col">HSN No</th>
                                        <th scope="col">Remark</th>
                                        <th scope="col">Action</th>
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
                                                <td><?=$value['item_remark']?></td>
                                                <td>
                                                   <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['stock_item_id'];?>' class='fa fa-trash-o deleteStockformitem' aria-hidden='true'></i>
                                                </td>
                                            <tr>   

                                          <?php  } }else{ ?>
                                            <tr>
                                               <td colspan="14"><p> <i>No OMS Challan Items Found</i></p></td>
                                            </tr>
                                         <?php } ?>

                                    <tbody>
                                </tbody>
                             </table> 
                        </div>
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <div class="col-xs-8">
                            <?php if($getItemlistStockform){ 
                            $button ="";
                            }else{
                            $button ="disabled";
                            } ?>
                           <input type="submit" id="addnewstockform" class="btn btn-primary" value="Submit" <?=$button?>>
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
                                                                    <select class="form-control part_number_for_incoming_details" name="part_number" id="part_number">
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
                                                                <label for="lot_number">Lot No. </label>
                                                                <select class="form-control lot_number get_invoice_qty_bylot_number" name="lot_number" id="lot_number">
                                                                   <option value="">Select Lot Number</option>
                                                                </select>
                                                                <p class="error lot_number_error"></p>
                                                            </div>


                                                            <div class="form-group">
                                                                <label for="invoice_qty_in_pcs">Invoice Qty (In Pcs) </label>
                                                                <input type="text" class="form-control" id="invoice_qty_in_pcs" name="invoice_qty_in_pcs">
                                                                <p class="error invoice_qty_in_pcs_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="invoice_qty_in_kgs">Invoice Qty (In Kgs) </label>
                                                                <input type="text" class="form-control" id="invoice_qty_in_kgs" name="invoice_qty_in_kgs" readonly>
                                                                <p class="error invoice_qty_in_kgs_error"></p>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for="actaul_recived_qty_in_pics">Actual Received Qty (In Pcs) </label>
                                                                <input type="text" class="form-control" id="actaul_recived_qty_in_pics" name="actaul_recived_qty_in_pics">
                                                                <p class="error actaul_recived_qty_in_pics_error"></p>
                                                            </div>

                                                            <input type="hidden" class="form-control" id="net_weight" name="net_weight">

                                                        
                                                            <div class="form-group">
                                                                <label for="actaul_recived_qty_in_kgs">Actual Received Qty (In kgs) </label>
                                                                <input type="text" class="form-control" id="actaul_recived_qty_in_kgs" name="actaul_recived_qty_in_kgs" readonly>
                                                                <p class="error tactaul_recived_qty_in_kgs_error"></p>
                                                            </div>


                                                            <div class="form-group">
                                                                <label for="privious_balenace">Previous Balenced</label>
                                                                <input type="text" class="form-control" id="privious_balenace" value="0" name="privious_balenace">
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
