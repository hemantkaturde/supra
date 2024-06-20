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
                        <label for="part_number">Part Number</label>
                        <select class="form-control" name="part_number" id="part_number">
                            <option st-id="" value="NA">Select Part Number</option>
                            <?php foreach ($finishgoodList as $key => $value) {?>
                            <option value="<?php echo $value['fin_id']; ?>">
                                <?php echo $value['part_number']; ?></option>
                            <?php } ?>
                        </select>
                        <p class="error part_number_error"></p>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label for="vendor_po">Vendor PO</label>
                        <select class="form-control" name="vendor_po" id="vendor_po">
                            <option st-id="" value="NA">Select Vendor PO</option>
                            <?php foreach ($vendorpoList as $key => $value) {?>
                            <option value="<?php echo $value['id']; ?>">
                                <?php echo $value['po_number']; ?></option>
                            <?php } ?>
                        </select>
                        <p class="error vendor_po_error"></p>
                    </div>
                </div>



                <div class="col-md-3">
                    <div class="form-group">
                        <label for="vendor_name">Vendor Name</label>
                        <select class="form-control" name="vendor_name" id="vendor_name">
                            <option st-id="" value="NA">Select Vendor Name</option>
                            <?php foreach ($vendorList as $key => $value) {?>
                            <option value="<?php echo $value['ven_id']; ?>"
                                <?php if($value['ven_id']==$fetchALLpresupplieritemList[0]['pre_vendor_name']){ echo 'selected';} ?>>
                                <?php echo $value['vendor_name']; ?></option>
                            <?php } ?>
                        </select>
                        <p class="error vendor_name_error"></p>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="email">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option st-id="" value="NA">Select Status</option>
                            <option st-id="" value="NA">ALL</option>
                            <option value="OPEN">Open </option>
                            <option value="CLOSE">Close</option>
                        </select>
                        <p class="error status_error"></p>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <div style="margin-top:22px">
                            <!-- <input type="button"  class="btn btn-primary" value="Search" id="search" name="search" /> -->
                            <input type="button" class="btn btn-primary" value="Export To Excel" id="export_to_excel"
                                name="export_to_excel" />
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover"
                                id="view_payment_details">
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
                                        <th>Action</th>
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