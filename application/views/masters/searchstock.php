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
            <div class="col-md-2">
                <div class="form-group">
                    <label for="item_number">Itam Number </label>
                        <select class="form-control" name="item_number" id="item_number">
                            <option st-id="" value="">Select Item Name</option>
                                <?php foreach ($getallitemsfromfgorrawmaterial as $key => $value) {?>
                                    <option value="<?php echo $value['find_id']; ?>" ><?php echo $value['part_number']; ?></option>
                                <?php } ?>
                        </select>
                    <p class="error item_number_error"></p>
                </div>
            </div>  

            <div class="col-md-2">
                <div class="form-group">
                    <label for="vendor_name">Vendor Name </label>
                        <select class="form-control" name="vendor_name" id="vendor_name">
                            <option st-id="" value="">Select Item Name</option>
                                <?php foreach ($vendorList as $key => $value) {?>
                                    <option value="<?php echo $value['ven_id']; ?>" ><?php echo $value['vendor_name']; ?></option>
                                <?php } ?>
                        </select>
                    <p class="error vendor_name_error"></p>
                </div>
            </div>  

            <div class="col-md-3">
                <div class="form-group">
                    <label for="vendor_po_number">Vendor PO </label>
                        <select class="form-control" name="vendor_po_number" id="vendor_po_number">
                            <option st-id="" value="">Select Vendor PO Number</option>
                        </select>
                    <p class="error vendor_po_number_error"></p>
                </div>
            </div>  

            <div class="col-md-2">
                <div class="form-group">
                    <label for="buyer_name">Buyer Name </label>
                        <select class="form-control" name="buyer_name" id="buyer_name">
                            <option st-id="" value="">Select Buyer Name</option>
                                <?php foreach ($buyerList as $key => $value) {?>
                                    <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$fetchALLpresupplieritemList[0]['pre_buyer_name']){ echo 'selected';} ?> ><?php echo $value['buyer_name']; ?></option>
                                <?php } ?>
                            </select>
                        <p class="error buyer_name_error"></p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="buyer_po_number">Buyer PO </label>
                        <select class="form-control" name="buyer_po_number" id="buyer_po_number">
                            <option st-id="" value="">Select Buyer PO Number</option>
                        </select>
                    <p class="error buyer_po_number_error"></p>
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
                                    <label for="item_number">Invoice Qty (In Pcs)</label>
                                    <input type="text" class="form-control" id="debit_note_number" name="debit_note_number">
                                    </div>
                                </div>  


                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="item_number">Invoice Qty (In Kgs)</label>
                                    <input type="text" class="form-control" id="debit_note_number" name="debit_note_number">
                                    </div>
                                </div>  

                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="item_number">Actual Received Qty (In Pcs)</label>
                                    <input type="text" class="form-control" id="debit_note_number" name="debit_note_number">
                                    </div>
                                </div>  

                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="item_number">Actual Received Qty (In Kgs)</label>
                                    <input type="text" class="form-control" id="debit_note_number" name="debit_note_number">
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
                            <H3>Rejected Items</H3>
                            <table width="50%" class="table table-striped table-bordered table-hover" id="view_rejected_items">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Item Number</th>
                                        <th>Description</th>
                                        <th>Order Qty</th>
                                        <th>Invoice Number</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Qty In Pcs</th>
                                        <th>Invoice Qty In Kgs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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
                            <H3>Exports Items</H3>
                            <table width="50%" class="table table-striped table-bordered table-hover" id="view_export_items">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Item Number</th>
                                        <th>Description</th>
                                        <th>Order Qty</th>
                                        <th>Invoice Number</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Qty In Pcs</th>
                                        <th>Invoice Qty In Kgs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

            
                            <div class ="total_values" style="border-top: 1px solid black">
                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="item_number">Ready for Export (In Pcs)</label>
                                    <input type="text" class="form-control" id="debit_note_number" name="debit_note_number">
                                    </div>
                                </div>  


                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="item_number">Ready for Export (In Kgs)</label>
                                    <input type="text" class="form-control" id="debit_note_number" name="debit_note_number">
                                    </div>
                                </div>  

                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="item_number">Total Rejected Qty (In Pcs)</label>
                                    <input type="text" class="form-control" id="debit_note_number" name="debit_note_number">
                                    </div>
                                </div>  

                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="item_number">Total Rejected Qty (In Kgs)</label>
                                    <input type="text" class="form-control" id="debit_note_number" name="debit_note_number">
                                    </div>
                                </div>  
                            </div>   


                            <div class ="total_values" style="border-top: 1px solid black">
                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="item_number">Total Export Qty(In Pcs)</label>
                                    <input type="text" class="form-control" id="debit_note_number" name="debit_note_number">
                                    </div>
                                </div>  

                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="item_number">Total Export Qty (In Kgs)</label>
                                    <input type="text" class="form-control" id="debit_note_number" name="debit_note_number">
                                    </div>
                                </div>  
                            </div>   


                            <div class ="total_values" style="border-top: 1px solid black">
                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="item_number">Balance Qty(In Pcs)</label>
                                    <input type="text" class="form-control" id="debit_note_number" name="debit_note_number">
                                    </div>
                                </div>  

                                <div class="col-md-3" style="margin-top: 20px;">
                                <div class="form-group">
                                    <label for="item_number">Balance Export Qty (In Kgs)</label>
                                    <input type="text" class="form-control" id="debit_note_number" name="debit_note_number">
                                    </div>
                                </div>  
                            </div>   




        </div>
    </section>

</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>