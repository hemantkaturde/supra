<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Payment Details
            <small>Add,Edit,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> Payment Details</a></li>
                </ul>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                    <?php if($this->session->userdata('roleText')=='Superadmin' || $this->session->userdata('roleText')=='Purchase' ){ ?>
                        <a class="btn btn-primary" href="<?php echo base_url(); ?>addnewpaymentdetails">
                            <i class="fa fa-plus"></i> Add Payment Details</a>
                    <?php } ?>
                </div>
            </div>
        </div>


        <div class="row">

        <div class="row" style="margin-left:4px">

        <div class="col-md-3">
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

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="from_date">From Date </label>
                            <input type="text" class="form-control datepicker" placeholder="Select From Date" id="from_date" name="from_date">
                            <p class="error from_date_error"></p>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="to_date">To Date </label>
                                <input type="text" class="form-control datepicker" placeholder="Select To Date" id="to_date" name="to_date">
                                 <p class="error to_date_error"></p>
                            </div>
                     </div>



                <div class="col-md-2">
                    <div class="form-group">
                        <div style="margin-top:22px">
                            <!-- <input type="button"  class="btn btn-primary" value="Search" id="search" name="search" /> -->
                            <input type="button" class="btn btn-primary" value="Email Payment Details" id="email_payment_details"
                                name="email_payment_details" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_payment_details">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Select</th>
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