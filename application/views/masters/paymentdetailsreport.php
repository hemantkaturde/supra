<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Payment Details Report
            <small>Add,Edit,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> Payment Details Report</a></li>
                </ul>
            </div>
        </div>
        <div class="row">

            <div class="row" style="margin-left:4px">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="vendor_supplier_name">Vendor / Supplier</label>
                            <select class="form-control" name="vendor_supplier_name" id="vendor_supplier_name">
                                <option st-id="" value="NA">Select Vendor Supplier</option>
                                <option st-id="" value="Vendor">Vendor</option>
                                <option st-id="" value="Supplier">Supplier</option>
                            </select>
                        <p class="error vendor_supplier_name_error"></p>
                    </div>
                </div>


                 <div id="vendor_name_div" style="display:none">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="vendor_name ">Vendor Name</label>
                            <select class="form-control" name="vendor_name" id="vendor_name_id">
                                <option st-id="" value="NA">Select Vendor Name</option>
                                <?php foreach ($vendorList as $key => $value) {?>
                                <option value="<?php echo $value['ven_id']; ?>">
                                    <?php echo $value['vendor_name']; ?></option>
                                <?php } ?>
                            </select>
                            <p class="error vendor_name_error"></p>
                        </div>
                    </div>
                 </div>

                 <div id="supplier_name_div" style="display:none">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="supplier_name">Supplier Name</label>
                            <select class="form-control" name="supplier_name" id="supplier_name_id">
                                <option st-id="" value="NA">Select Supplier Name</option>
                                <?php foreach ($supplierList as $key => $value) {?>
                                <option value="<?php echo $value['sup_id']; ?>">
                                    <?php echo $value['supplier_name']; ?></option>
                                <?php } ?>
                            </select>
                            <p class="error supplier_name_error"></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="payment_details_no">Payment Details No</label>
                        <select class="form-control" name="payment_details_no" id="payment_details_no">
                            <option st-id="" value="NA">Select Payment Details PO</option>
                            <?php foreach ($paymentdetailsnumberList as $key => $value) {?>
                            <option value="<?php echo $value['payment_details_id']; ?>">
                                <?php echo $value['payment_details_number']; ?></option>
                            <?php } ?>
                        </select>
                        <p class="error payment_details_no_error"></p>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option st-id="" value="NA">Select Status</option>
                            <option value="NA">ALL </option>
                            <option value="paid">Paid </option>
                            <option value="unpaid">Unpaid</option>
                        </select>
                        <p class="error status_error"></p>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <div style="margin-top:22px">
                            <!-- <input type="button"  class="btn btn-primary" value="Search" id="search" name="search" /> -->
                            <input type="button" class="btn btn-primary" value="Export To Excel" id="export_to_excel_payment_details"
                                name="export_to_excel_payment_details" />
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover"
                                id="view_payment_details_report">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Payment Details No</th>
                                        <th>Payment Date</th>
                                        <th>Bill No</th>
                                        <th>Vendor Name</th>
                                        <th>Vendor PO</th>
                                        <th>Supplier Name</th>
                                        <th>Supplier PO</th>
                                        <th>PO Date</th>
                                        <th>Payment Status</th>
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
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>

