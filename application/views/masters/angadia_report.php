<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-file"></i> Sai Krupa Express Transport Report
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li><a href="javascript:void(0);">Reports</a></li>
                    <li class="active"><a href="javascript:void(0);">Sai Krupa Express Transport Report</a></li>
                </ul>
            </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Sai Krupa Express Transport Report</h3>
                    </div>
                    <div class="box-body">
                        <div class="row" style="margin-left:4px">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search_by_any">Search By Any</label>
                                   
                                    <input type="text" class="form-control" id="search_by_any" placeholder="Search By Vendor Name, City, Invoice No.">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="from_date">From Date</label>
                                    <input type="text" class="form-control datepicker" placeholder="Select From Date" id="from_date">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="to_date">To Date</label>
                                    <input type="text" class="form-control datepicker" placeholder="Select To Date" id="to_date">
                                </div>
                            </div>

                            <!-- <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label><br>
                                    <button type="button" class="btn btn-primary" id="search_btn">Search</button>
                                </div>
                            </div> -->

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label><br>
                                    <button type="button" class="btn btn-success" id="export_excel">Export to Excel</button>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="panel-body">
                            <table id="anagdia_report_table" class="table table-bordered table-striped">
                                <thead style="background-color:#3c8dbc; color:white;">
                                    <tr>
                                        <th>LR No</th>
                                        <th>Date</th>
                                        <th>Vendor Name</th>
                                        <th>City</th>
                                        <th>Invoice No</th>
                                        <th>Boxes No (No.of Boxes)</th>
                                        <th>Total (In Kgs)</th>
                                        <th>Rate</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will load via AJAX -->
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- jQuery UI for datepicker -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>

<script>
$(function() {
    $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd'
    });
});
</script>
