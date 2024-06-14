<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Supplier PO Report
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Supplier PO Report</a></li>
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
                            <h3 class="box-title">Supplier PO Report</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <div class="box-body">
                            <div class="row" style="margin-left:4px">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="vendor_po">Supplier PO</label>
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

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="email">Status</label>
                                        <select class="form-control" name="status" id="status">
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
                                            <input type="button" class="btn btn-primary" value="Export To Excel"
                                                id="export_to_excel" name="export_to_excel" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered table-hover"
                                    id="view_production_status_report">
                                    <thead>
                                        <tr style="background-color:#3c8dbc !important;color:#fff">
                                            <th>PO Number</th>
                                            <th>PO Date</th>
                                            <th>Supplier Name</th>
                                            <th>Materail Description</th>
                                            <th>Vendor Name</th>
                                            <th>Part No</th>
                                            <th>Ordered Qty</th>
                                            <th>Sent Qty</th>
                                            <th>Ordered Qty In Pcs</th>
                                            <th>Est Del Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer">

                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
    </section>
</div>



<!-- Modal -->
<div class="modal fade" id="addnotes" tabindex="-1" role="dialog" data-dismiss="modal" data-backdrop="static" data-keyboard="false"  aria-labelledby="addnotesLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addnotesLabel">Production Status Report Item Notes</h5>
                <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <input type="hidden" class="form-control" id="notes_id" name="notes_id">

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="notes">Notes <span class="required">*</span></label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        <p class="error notes_error"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
                <button type="button" id="savebillofmaterialnotes" class="btn btn-primary">Save Notes</button>
            </div>
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