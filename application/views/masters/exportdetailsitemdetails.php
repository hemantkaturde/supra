<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Pre Export Item Details
            <small>Add,Edit,Delete</small>
        </h1>

        <h4>
            <p><b>Pre Export Invoice Number :</b> <?=$getexportetails[0]['pre_export_invoice_no'] ?></p>
            <p><b>Pre Export Buyer Name :</b> <?=$getexportetails[0]['buyer_name'] ?></p>
            <!-- <p><b>Pre Export Buyer PO Number :</b> <?=$getexportetails[0]['sales_order_number'] ?></p> -->
            <input type="hidden" class="main_export_id" id="main_export_id" value=<?=$main_export_id?> name="main_export_id">
        </h4>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Pre Export Item Details</a></li>
                </ul>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>preexport">
                        <i class="fa fa-arrow-left"></i> Back</a>

                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addpreexportitemdetails/<?=$main_export_id?>">
                        <i class="fa fa-plus"></i> Add Pre Export Item Details</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_pre_export_item_details">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Part Number</th>
                                        <th>Part Description</th>
                                        <th>PO Number</th>
                                        <th>Total Gross Weight</th>
                                        <th>Total No of Cartoons</th>
                                        <!-- <th>Total Per Box PCS</th> -->
                                        <th>Total Qty</th>
                                        <th>Total Net Weight</th>
                                        <th>Remark</th>
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