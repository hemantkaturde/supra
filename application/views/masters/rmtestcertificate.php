<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> RM Test Certificate Report
            <small>Add,Edit,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> RM Test Certificate Report</a></li>
                </ul>
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
                            <select class="form-control getvendorpobasedonvendorname" name="vendor_name" id="vendor_name">
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

                <div id="vendor_po_number_div" style="display:none">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="vendor_po">Vendor PO</label>
                            <select class="form-control" name="vendor_po_number" id="vendor_po_number">
                            </select> 
                            <p class="error vendor_po_number_error"></p>
                        </div>
                    </div>
                </div>

               
                <div id="supplier_name_div" style="display:none">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="supplier_name">Supplier Name</label>
                            <select class="form-control getsupplierpobysupplieridforRMcetificate" name="supplier_name" id="supplier_name">
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

                 <div id="supplier_po_number_div" style="display:none">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="supplier_po">Supplier PO</label>
                            <select class="form-control" name="supplier_po_number" id="supplier_po_number">
                            </select> 
                            <p class="error supplier_po_number_error"></p>
                        </div>
                    </div>
                </div>


                <div class="col-md-2">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option st-id="" value="NA">Select Status</option>
                            <option value="Uploaded">Uploaded</option>
                            <option value="Reviewed">Reviewed</option>
                        </select>
                        <p class="error status_error"></p>
                    </div>
                </div>
            </div>


            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover"
                                id="view_rm_certificate_report">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Part no</th>
                                        <th>Part Description</th>
                                        <th>RM Type</th>
                                        <th>Order Qty</th>
                                        <th>Vendor Name</th>
                                        <th>Vendor po</th>
                                        <th>Supplier name</th>
                                        <th>Supplier PO</th>
                                        <th>Status</th>
                                        <th>Uploaded Date</th>
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


<!-- Modal -->
<div class="modal fade" id="rmcertirmcertificatemodelficate" tabindex="-1" role="dialog" data-dismiss="modal" data-backdrop="static" data-keyboard="false"  aria-labelledby="rmcertirmcertificatemodelficateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addnotesLabel">RM Certificate Status</h5>
                <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" id="rmcertirmcertificatemodelficate_form" action="<?php echo base_url() ?>rmcertirmcertificatemodelficate_form" method="post" role="form">

                <div class="modal-body">
                    <input type="hidden" class="form-control" id="item_id" name="item_id">
                    <input type="hidden" class="form-control" id="flag" name="flag">

                <div class="col-md-12">
                        <div class="form-group">
                            <label for="reviewdate">Review Date <span class="required">*</span></label>
                            <input class="form-control datepicker" id="reviewdate" name="reviewdate"></input>
                            <p class="error reviewdate_error"></p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="rm_certificate_status">Status <span class="required">*</span></label>
                            <div>
                                <select class="form-control serachfilternotrequired searchfilter" name="rm_certificate_status" id="rm_certificate_status">
                                    <option value="NA">Select Status</option>
                                    <option value="Uploaded">Uploaded</option>
                                    <option value="Reviewed">Reviewed</option>
                                </select>
                            <p class="error rm_certificate_status_error"></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="notes">Notes </label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            <p class="error notes_error"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
                    <button type="button" id="savermcertificatestatuspopup" class="btn btn-primary">Save Status</button>
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


<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
