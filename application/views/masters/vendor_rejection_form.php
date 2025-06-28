<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Vendor Rejection Report
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Vendor Rejection Report</a></li>
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
                            <h3 class="box-title">Vendor History Report</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <div class="box-body">
                            <div class="row" style="margin-left:4px">

                               <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="part_number">Part Number</label>
                                        <select class="form-control part_number_for_current_stock" name="part_number" id="part_number">
                                            <option value="NA">Select Part Number</option>
                                            <?php foreach ($finishgoodList as $key => $value) {?>
                                            <option value="<?php echo $value['fin_id']; ?>">
                                                <?php echo $value['part_number']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="vendor_name">Vendor Name</label>
                                        <select class="form-control" name="vendor_name" id="vendor_name">
                                            <option value="NA">Select Vendor Name</option>
                                            <?php foreach ($vendorList as $key => $value) {?>
                                            <option value="<?php echo $value['ven_id']; ?>">
                                                <?php echo $value['vendor_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="from_date">From Date</label>
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
                                            <input type="button" class="btn btn-primary" value="Export To Excel"
                                                id="export_to_excel_vendor_rejection_report" name="export_to_excel_vendor_rejection_report" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered table-hover"
                                    id="view_vendor_rejection_report">
                                    <thead>
                                        <tr style="background-color:#3c8dbc !important;color:#fff">
                                            <th>Part No</th>
                                            <th>Vendor Name</th>    
                                            <th>Vendor PO No</th>
                                            <th>Vendor PO Date</th>
                                            <th>Vendor PO Qty</th>
                                            <th>Received Qty</th>
                                            <th>Rejected Qty</th>
                                            <th>Rejected Reasons</th>
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