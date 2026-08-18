<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Checklist Report Part Incoming Lot Data
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Checklist Report</a></li>
                </ul>
            </small>
        </h1>
    </section>

    <section class="content">

    <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Checklist Report Part Incoming Lot Data</a></li>
                </ul>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                   <a class="btn btn-primary" data-toggle="modal" data-target="#backModal"> Add Lot Number </a>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box box-primary"> 
                        <?php $this->load->helper("form"); ?>
                        <div class="box-body">
                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered table-hover"
                                    id="view_checklist_incoming_lotno_data">
                                    <thead>
                                        <tr style="background-color:#3c8dbc !important;color:#fff">
                                            <th>Lot No</th>
                                            <th>Received Qty</th>
                                            <th>Received Date</th>                                 
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
<div class="modal fade" id="backModal" tabindex="-1" role="dialog" aria-labelledby="backModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="backModalLabel">Add New Lot Number</h4>
            </div>
            <form id="addincominglotdataform">
            <div class="modal-body">
                <!-- Vendor Name -->
                <input type="hidden" name="checklist_incoming_part_id" id="checklist_incoming_part_id" value="<?= $checklist_part_incoming_id; ?>">
                <div class="form-group">
                    <label for="lot_no">Lot Number <span class="required">*</span></label>
                    <select class="form-control" name="lot_no" id="lot_no">
                        <option value="">Select Vendor Name</option>
                        <?php foreach ($getIncomindlotforchecklistlastreport as $key => $value) { ?>
                            <option value="<?php echo $value['incoming_details_item_id']; ?>">
                                <?php echo $value['lot_no']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <span class="text-danger lot_no_error"></span>
                </div>

                <!-- Received Date -->
                <div class="form-group">
                    <label for="received_date">Received Date <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control" name="received_date" id="received_date">
                    <span class="text-danger received_date_error"></span>
                </div>

                <!-- Received Quantity -->
                <div class="form-group">
                    <label for="received_qty"> Received Qty <span class="required">*</span></label>
                    <input type="number"  class="form-control" name="received_qty" id="received_qty" placeholder="Enter Received Quantity">
                    <span class="text-danger received_qty_error"></span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitLotNumber">Submit</button>
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

