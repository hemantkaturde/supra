<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Inspection Excel Report
            <small>
            </small>
        </h1>
    </section>

    <section class="content">
    <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Inspection Excel Report</a></li>
                </ul>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box box-primary"> 
                        <?php $this->load->helper("form"); ?>

                         <div class="row" style="margin-left:4px;margin-top:10px">

                            

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
                                            <input type="button" class="btn btn-primary exporttoexcelinspectionreport" value="Export To Excel"
                                                id="exporttoexcelinspectionreport" name="exporttoexcelinspectionreport" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                        <div class="box-body">
                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered table-hover"
                                    id="export_tdir_report">
                                    <thead>
                                        <tr style="background-color:#3c8dbc !important;color:#fff">
                                            <th>Inspection Report no.</th>
                                            <th>Inspection Report Date</th>
                                            <th>Vendor name</th>
                                            <th>Vendor po. no.</th>
                                            <th>Part no.</th>
                                            <th>Part name</th>
                                            <th>Buyer name</th>
                                            <th>Vendor Order Qty</th>
                                            <th>Remarks</th>
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

