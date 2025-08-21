<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Tracking of Dimenstional Inspection Report
            <small>
                <!-- <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Tracking of Dimenstional Inspection Report</a></li>
                </ul> -->
            </small>
        </h1>
    </section>

    <section class="content">

    <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Tracking of Dimenstional Inspection Report</a></li>
                </ul>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                <?php if($this->session->userdata('roleText')=='Superadmin' || $this->session->userdata('roleText')=='Purchase' || $this->session->userdata('roleText')=='QC'){ ?>
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addTDIR">
                        <i class="fa fa-plus"></i> Add TDIR</a>
                <?php } ?>
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
                                    id="view_production_status_report">
                                    <thead>
                                        <tr style="background-color:#3c8dbc !important;color:#fff">
                                           <th>Report No</th>
                                            <th>Vendor Name</th>
                                            <th>Vendor PO No</th>
                                            <th>Vendor PO Date</th>
                                            <th>Part No</th>
                                            <th>Part Name</th>
                                            <th>Material Type</th>
                                            <th>Additional Process</th>
                                            <th>Vendor Order Qty</th>
                                            <th>Buyer Name</th>
                                            <th>Buyer PO No</th>
                                            <th>Buyer PO Date</th>
                                            <th>Order Qty</th>
                                            <th>Vendor Delivery Date</th>
                                            <th>Invoice Qty</th>
                                            <th>Invoice Date</th>
                                            <th>Lot No</th>
                                            <th>Lot Qty</th>
                                            <th>Checking Status</th>
                                            <th>Checked By</th>
                                            <th>Remarks</th>
                                            <th>Status</th>
                                            <th>Notes</th>
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

