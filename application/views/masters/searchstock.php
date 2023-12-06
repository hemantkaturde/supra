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
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="vendor_name">Vendor Name </label>
                        <select class="form-control" name="vendor_name" id="vendor_name">
                            <option st-id="" value="">Select Vendor Name</option>
                                <?php foreach ($vendorList as $key => $value) {?>
                                    <option value="<?php echo $value['ven_id']; ?>" ><?php echo $value['vendor_name']; ?></option>
                                <?php } ?>
                        </select>
                    <p class="error vendor_name_error"></p>
                </div>
            </div>  

            <div class="col-md-3">
                <div class="form-group">
                    <label for="vendor_po_number">Vendor PO Number</label>
                        <select class="form-control vendor_po_for_buyer_details_ vendor_po_number_itam_mapping" name="vendor_po_number" id="vendor_po_number">
                            <option st-id="" value="">Select Vendor PO Number</option>
                        </select>
                    <p class="error vendor_po_number_error"></p>
                </div>
            </div>  

            <div class="col-md-2">
                <div class="form-group">
                    <label for="item_number">Part Number </label>
                        <select class="form-control" name="item_number" id="item_number">
                            <option st-id="" value="">Select Part Name</option>
                                <!-- <?php foreach ($getallitemsfromfgorrawmaterial as $key => $value) {?>
                                    <option value="<?php echo $value['find_id']; ?>" ><?php echo $value['part_number']; ?></option>
                                <?php } ?> -->
                        </select>
                    <p class="error item_number_error"></p>
                </div>
            </div>  

            <div class="col-md-2">
                <div class="form-group">
                    <label for="buyer_name">Stock Id</label>
                    <input type="text" class="form-control" id="stock_id" name="stock_id" readonly>
                </div>
            </div>  

            <div class="col-md-2">
                <div class="form-group">
                    <label for="stock_id_number">Stock Date</label>
                    <input type="text" class="form-control" id="stock_id_number" name="stock_id_number" readonly>
                </div>
            </div>  

        </div>   

        <div class="row">

            <div class="col-md-3">
                <div class="form-group">
                    <label for="buyer_name">Buyer Name </label>
                    <input type="text" class="form-control" id="buyer_name" name="buyer_name" readonly>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="buyer_po_number">Buyer PO Number</label>
                    <input type="text" class="form-control" id="buyer_po_number" name="buyer_po_number" readonly>
                </div>
            </div>  

            <div class="col-md-2">
                <div class="form-group">
                    <label for="buyer_delivery_date">Buyer Delivery Date</label>
                    <input type="text" class="form-control" id="buyer_delivery_date" name="buyer_delivery_date" readonly>
                </div>
            </div>  

            <div class="col-md-2">
                <div class="form-group">
                    <label for="buyer_po_date">Buyer PO Date</label>
                    <input type="text" class="form-control" id="buyer_po_date" name="buyer_po_date" readonly>
                </div>
            </div> 

            <div class="col-md-2">
                <div class="form-group">
                    <label for="buyer_order_qty">Buyer Order Qty</label>
                    <input type="text" class="form-control" id="buyer_order_qty" name="buyer_order_qty" readonly>
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
                                    <label for="invoice_qty_in_pcs">Ready for Exp Pcs</label>
                                    <input type="text" class="form-control" id="invoice_qty_in_pcs" name="invoice_qty_in_pcs" readonly>
                                    </div>
                                </div>  


                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="invoice_qty_in_kgs">Ready for Exp Kgs</label>
                                    <input type="text" class="form-control" id="invoice_qty_in_kgs" name="invoice_qty_in_kgs" readonly>
                                    </div>
                                </div>  
                            </div>  


                            <div class ="total_values" style="border-top: 1px solid black">
                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="invoice_qty_in_pcs">Total Exp Qty Pcs</label>
                                    <input type="text" class="form-control" id="invoice_qty_in_pcs" name="invoice_qty_in_pcs" readonly>
                                    </div>
                                </div>  


                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="invoice_qty_in_kgs">Total Exp Qty Kgs</label>
                                    <input type="text" class="form-control" id="invoice_qty_in_kgs" name="invoice_qty_in_kgs" readonly>
                                    </div>
                                </div>  
                            </div>  

                            <div class ="total_values" style="border-top: 1px solid black">
                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="invoice_qty_in_pcs">Balance Qty Pcs</label>
                                    <input type="text" class="form-control" id="invoice_qty_in_pcs" name="invoice_qty_in_pcs" readonly>
                                    </div>
                                </div>  


                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="invoice_qty_in_kgs">Balance Qty Kgs</label>
                                    <input type="text" class="form-control" id="invoice_qty_in_kgs" name="invoice_qty_in_kgs" readonly>
                                    </div>
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
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>


                            <div class ="total_values" style="border-top: 1px solid black">
                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="invoice_qty_in_pcs">Total Rejected Qty Pcs</label>
                                    <input type="text" class="form-control" id="invoice_qty_in_pcs" name="invoice_qty_in_pcs" readonly>
                                    </div>
                                </div>  


                                <div class="col-md-6" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="invoice_qty_in_kgs">Total Rejected Qty Kgs</label>
                                    <input type="text" class="form-control" id="invoice_qty_in_kgs" name="invoice_qty_in_kgs" readonly>
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

</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>