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
                                        <label for="supplier_name">Supplier Name</label>
                                        <select class="form-control" name="supplier_name" id="supplier_name">
                                            <option st-id="" value="NA">Select Supplier Name</option>
                                            <?php foreach ($supplierlist as $key => $value) {?>
                                            <option value="<?php echo $value['sup_id']; ?>">
                                                <?php echo $value['supplier_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <p class="error supplier_name_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="supplier_po">Supplier PO</label>
                                        <select class="form-control" name="supplier_po" id="supplier_po">
                                            <option st-id="" value="NA">Select Supplier PO</option>
                                            <?php foreach ($supplierpoList as $key => $value) {?>
                                            <option value="<?php echo $value['id']; ?>">
                                                <?php echo $value['po_number']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <p class="error supplier_po_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="email">Material sent</label>
                                        <select class="form-control" name="material_sent" id="material_sent">
                                            <option value="NA">Select  Material sent</option>
                                            <option value="Yes">Yes </option>
                                            <option value="No">No</option>
                                        </select>
                                        <p class="error material_sent_error"></p>
                                    </div>
                                </div>


                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="email">Receipt Confirmation</label>
                                        <select class="form-control" name="materila_recipt_confirmation" id="materila_recipt_confirmation">
                                            <option value="NA">Receipt Confirmation </option>
                                            <option value="done">Done </option>
                                            <option value="Pending">Pending</option>
                                        </select>
                                        <p class="error materila_recipt_confirmation_error"></p>
                                    </div>
                                </div>

                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div style="margin-top:22px">
                                            <!-- <input type="button"  class="btn btn-primary" value="Search" id="search" name="search" /> -->
                                            <input type="button" class="btn btn-primary" value="Export To Excel"
                                                id="export_to_excel_supplier_po" name="export_to_excel_supplier_po" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered table-hover"
                                    id="view_supplier_po_report">
                                    <thead>
                                        <tr style="background-color:#3c8dbc !important;color:#fff">
                                            <th>PO Number</th>
                                            <th>PO Date</th>
                                            <th>Supplier Name</th>
                                            <th>Material Description</th>
                                            <th>Vendor Name</th>
                                            <th>Part No</th>
                                            <th>Ordered Qty kgs</th>
                                            <th>Sent Qty kgs</th>
                                            <th>Ordered Qty In Pcs</th>
                                            <th>Sent Qty In Pcs</th>
                                            <th>Material Sent</th>
                                            <th>Material Receipt Confirmation</th>
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