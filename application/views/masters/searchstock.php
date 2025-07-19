<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Search Stock
            <small>Search</small>
        </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> Search Stock</a></li>
                </ul>
            </div>
            <div class="col-xs-6" style="display:flex">
                <!-- <div style="margin-top: 10px;margin-left: 500px;"><a href=<?=ADMIN_PATH.'printstock/'.$getsearchstockvendordeatils[0]['stock_id_form']?> style='cursor: pointer;' target='_blank'><button type="button" id="print_stock" class="btn btn-primary print_stock">Print Stock</button></a></div> -->
                <div style="margin-top: 10px;margin-left: 500px;"><button type="button" id="print_stock" class="btn btn-primary print_stock">Print Stock</button></div>

            </div>
        </div>
        <!-- <div><h2> <b>Previous Balance :</b> <?=$getpreviousstock['previous_stock'];?> </h2></div> -->

        <input type="hidden" class="form-control" id="vendor_po_id" name="vendor_po_id"  value="<?=$getsearchstockvendordeatils[0]['vendor_po_id'];?>" readonly>
        <input type="hidden" class="form-control" id="vendor_po_item_id" name="vendor_po_item_id"  value="<?=$getsearchstockvendordeatils[0]['vendor_po_item_id'];?>" readonly>
        <input type="hidden" class="form-control" id="stock_id" name="stock_id"  value="<?=$getsearchstockvendordeatils[0]['stock_id_form'];?>" readonly>
        <input type="hidden" class="form-control" id="part_number_id" name="part_number_id"  value="<?=$getsearchstockvendordeatils[0]['search_stock_item_id'];?>" readonly>
        <input type="hidden" class="form-control" id="buyer_po_number_id" name="buyer_po_number_id"  value="<?=$getsearchstockvendordeatils[0]['buyer_po_id'];?>" readonly>
        <input type="hidden" class="form-control" id="finishgood_id" name="finishgood_id"  value="<?=$getsearchstockvendordeatils[0]['finishgood_id'];?>" readonly>
        <input type="hidden" class="form-control" id="previous_stock_bal" name="previous_stock_bal"  value="<?=$getpreviousstock['previous_stock'];?>" readonly>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="vendor_po_number">Part Number</label>
                        <input type="text" class="form-control" id="part_number" name="part_number" value="<?=$getsearchstockvendordeatils[0]['fg_part_number'];?>" style="background: #FFF;" readonly>
                    <p class="error part_number_error"></p>
                </div>
            </div> 


            <div class="col-md-2">
                <div class="form-group">
                    <label for="buyer_name">Stock Id</label>
                    <input type="text" class="form-control" id="stock_id" name="stock_id"  value="<?=$getsearchstockvendordeatils[0]['stock_id_number'];?>"  style="background: #FFF;" readonly>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="vendor_name">Vendor Name </label>
                        <input type="text" class="form-control" id="vendor_name" name="vendor_name" value="<?=$getsearchstockvendordeatils[0]['vendor_name'];?>" style="background: #FFF;" readonly>
                    <p class="error vendor_name_error"></p>
                </div>
            </div>  

            <div class="col-md-3">
                <div class="form-group">
                    <label for="vendor_po_number">Vendor PO Number</label>
                        <input type="text" class="form-control" id="vpo_number" name="vpo_number" value="<?=$getsearchstockvendordeatils[0]['vpo_number'];?>" style="background: #FFF;" readonly>
                    <p class="error vpo_number_error"></p>
                </div>
            </div>  

            <div class="col-md-2">
                <div class="form-group">
                    <label for="stock_date">Stock Date</label>
                    <input type="text" class="form-control" id="stock_date" name="stock_date" value="<?=$getsearchstockvendordeatils[0]['stock_date'];?>"  style="background: #FFF;" readonly>
                </div>
            </div>  

        </div>   

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="buyer_name">Buyer Name </label>
                    <input type="text" class="form-control" id="buyer_name" name="buyer_name" value="<?=$getsearchstockvendordeatils[0]['by_name'];?>" style="background: #FFF;" readonly>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="buyer_po_number">Buyer PO Number</label>
                    <input type="text" class="form-control" id="buyer_po_number" name="buyer_po_number" value="<?=$getsearchstockvendordeatils[0]['sales_order_number'].' - '.$getsearchstockvendordeatils[0]['original_po'];?>" style="background: #FFF;" readonly>
                </div>
            </div>  

            <div class="col-md-2">
                <div class="form-group">
                    <label for="buyer_delivery_date">Buyer Part Delivery Date</label>
                    <input type="text" class="form-control" id="buyer_delivery_date" name="buyer_delivery_date" value="<?=$getsearchstockvendordeatils[0]['buyer_po_part_delivery_date'];?>" style="background: #FFF;" readonly>
                </div>
            </div>  

            <div class="col-md-2">
                <div class="form-group">
                    <label for="buyer_po_date">Buyer PO Date</label>
                    <input type="text" class="form-control" id="buyer_po_date" name="buyer_po_date" value="<?=$getsearchstockvendordeatils[0]['buyer_po_date'];?>" style="background: #FFF;" readonly>
                </div>
            </div> 

            <div class="col-md-2">
                <div class="form-group">
                    <label for="buyer_order_qty">Buyer Order Qty</label>
                    <input type="text" class="form-control" id="buyer_order_qty" name="buyer_order_qty" value="<?=$getsearchstockvendordeatils[0]['buyer_order_qty_buyeritem'];?>"  style="background: #FFF;" readonly>
                </div>
            </div>  
        </div>


          <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="supplier_name">Raw Material supplier name</label>
                    <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="<?=$getsearchstockvendordeatils[0]['supplier_name_actual'];?>" style="background: #FFF;" readonly>
                </div>
            </div>

    
            <div class="col-md-3">
                <div class="form-group">
                    <label for="supplier_po_number">Supplier PO </label>
                    <input type="text" class="form-control" id="supplier_po_number" name="supplier_po_number" value="<?=$getsearchstockvendordeatils[0]['supplier_po_number_actual'];?>" style="background: #FFF;" readonly>
                </div>
            </div>


             <div class="col-md-3">
                <div class="form-group">
                    <label for="row_material_rm_type">RM Type</label>
                    <input type="text" class="form-control" id="row_material_rm_type" name="row_material_rm_type" value="<?=$getsearchstockvendordeatils[0]['row_material_rm_type'];?>" style="background: #FFF;" readonly>
                </div>
            </div>
        </div>


        
        <div class="row ">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_stock_search_record">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Item Number</th>
                                        <th>Description</th>
                                        <th>Order Qty</th>
                                        <th>Invoice Number</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Qty In Pcs</th>
                                        <th>Invoice Qty In Kgs</th>
                                        <th>Lot No</th>
                                        <th>Actual Received Qty In Pcs</th>
                                        <th>Actual Received Qty In Kgs</th>
                                        <th>Previous Balance</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            <div class ="total_values" style="border-top: 1px solid black">
                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="invoice_qty_in_pcs">Invoice Qty (In Pcs)</label>
                                    <input type="text" class="form-control" id="invoice_qty_in_pcs" name="invoice_qty_in_pcs" readonly>
                                    </div>
                                </div>  


                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="invoice_qty_in_kgs">Invoice Qty (In Kgs)</label>
                                    <input type="text" class="form-control" id="invoice_qty_in_kgs" name="invoice_qty_in_kgs" readonly>
                                    </div>
                                </div>  

                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="actual_received_qty_in_pcs">Actual Received Qty (In Pcs)</label>
                                    <input type="text" class="form-control" id="actual_received_qty_in_pcs" name="actual_received_qty_in_pcs" readonly>
                                    </div>
                                </div>  

                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="actual_received_qty_in_kgs">Actual Received Qty (In Kgs)</label>
                                    <input type="text" class="form-control" id="actual_received_qty_in_kgs" name="actual_received_qty_in_kgs" readonly>
                                    </div>
                                </div>  
                            </div>    
           
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>  
    </section>

    <section class="content">
        <div class="row ">
            <div class="col-xs-6">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <H3>Exports Items</H3>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_export_items">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Export Invoice No</th>
                                        <th>Invoice Date</th>
                                        <th>Export Qty In Pcs</th>
                                        <th>Export Qty In Kgs</th>
                                        <th>Export Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>


                            <div class ="total_values" style="border-top: 1px solid black">
                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="ready_for_exp_pcs">Ready for Exp Pcs</label>
                                    <input type="text" class="form-control" id="ready_for_exp_pcs" name="ready_for_exp_pcs" readonly>
                                    </div>
                                </div>  


                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="ready_for_exp_kgs">Ready for Exp Kgs</label>
                                    <input type="text" class="form-control" id="ready_for_exp_kgs" name="ready_for_exp_kgs" readonly>
                                    </div>
                                </div>  
                            </div>  


                            <div class ="total_values" style="border-top: 1px solid black">
                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="total_exp_qty_in_pcs">Total Exp Qty Pcs</label>
                                    <input type="text" class="form-control" id="total_exp_qty_in_pcs" name="total_exp_qty_in_pcs" readonly>
                                    </div>
                                </div>  


                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="total_exp_qty_in_kgs">Total Exp Qty Kgs</label>
                                    <input type="text" class="form-control" id="total_exp_qty_in_kgs" name="total_exp_qty_in_kgs" readonly>
                                    </div>
                                </div>  
                            </div>  

                            <div class ="total_values" style="border-top: 1px solid black">
                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="balence_qty_in_pcs">Balance Qty Pcs</label>
                                    <input type="text" class="form-control" id="balence_qty_in_pcs" name="balence_qty_in_pcs" readonly>
                                    </div>
                                </div>  


                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="balence_qty_in_kgs">Balance Qty Kgs</label>
                                    <input type="text" class="form-control" id="balence_qty_in_kgs" name="balence_qty_in_kgs" readonly>
                                    </div>
                                </div>  
                            </div>  

                 
                            <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <button type="button" id="update_stock"  class="btn btn-primary update_stock">Update Stock</button>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

            <div class="col-xs-6">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <H3>Rejected Items</H3>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_rejected_items">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Rejection Number</th>
                                        <th>Rejection Reason</th>
                                        <th>Rejection Qty in Pcs</th>
                                        <th>Rejection Qty in Kgs</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>


                            <div class ="total_values" style="border-top: 1px solid black">
                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="total_rejected_qty_in_pcs">Total Rejected Qty Pcs</label>
                                    <input type="text" class="form-control" id="total_rejected_qty_in_pcs" name="total_rejected_qty_in_pcs" readonly>
                                    </div>
                                </div>  


                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="total_rejected_qty_in_kgs">Total Rejected Qty Kgs</label>
                                    <input type="text" class="form-control" id="total_rejected_qty_in_kgs" name="total_rejected_qty_in_kgs" readonly>
                                    </div>
                                </div>  
                            </div>  

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="stock_remark">Stock Remark</label>
                                    <input type="text" class="form-control" id="stock_remark" name="stock_remark"  value="<?=$getsearchstockvendordeatils[0]['stock_remark'];?>"  readonly>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>

</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>