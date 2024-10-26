<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> CBAM Report
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">CBAM Report</a></li>
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
                            <h3 class="box-title">CBAM Report</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <div class="box-body">
                            <div class="row" style="margin-left:4px">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="from_date">From Date <span class="required">*</span></label>
                                        <input type="text" class="form-control datepicker" placeholder="Select From Date" id="from_date" name="from_date">
                                        <p class="error from_date_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="to_date">To Date <span class="required">*</span></label>
                                        <input type="text" class="form-control datepicker" placeholder="Select To Date" id="to_date" name="to_date">
                                        <p class="error to_date_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Vendor Name</label>
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
                                        <div style="margin-top:22px">
                                            <!-- <input type="button"  class="btn btn-primary" value="Search" id="search" name="search" /> -->
                                            <input type="button" class="btn btn-primary" value="Export To Excel"
                                                id="export_to_excel_cbam_report" name="export_to_excel_cbam_report" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered table-hover"
                                    id="view_CBAM_calculation_report">
                                    <thead>
                                        <tr style="background-color:#3c8dbc !important;color:#fff">
                                            <th>Supplier Name</th>
                                            <th>Supplier PO No</th>
                                            <th>Raw Material Type</th>
                                            <th>Raw Material HSN Code</th>
                                            <th>Raw Material sent Qty (in Kgs)</th>
                                            <th>Vendor PO NO.</th>
                                            <th>Vendor Name</th>
                                            <th>Vendor PO Date</th>
                                            <th>FG Part No.</th>
                                            <th>FG Received Qty (in Pcs)</th>
                                            <th>FG Net Weight (in Kgs)</th>
                                            <th>FG HSN Code</th>
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