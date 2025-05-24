<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Pre Export Item Attributes
            <small>Add,Edit,Delete</small>
        </h1>

        <h4>
            <p><b>Pre Export Invoice Number :</b> <?=$getexportetails[0]['pre_export_invoice_no'] ?></p>
            <p><b>Pre Export Buyer Name :</b> <?=$getexportetails[0]['buyer_name'] ?></p>
            <p><b>Pre Export Buyer PO Number :</b> <?=$getexportetails[0]['sales_order_number'].' - '.$getexportetails[0]['buyer_po_number'] ?></p>
            <p><b>Part Number :</b> <?=$getexportetails[0]['part_number'] ?></p>
            <input type="hidden" class="main_export_id" id="main_export_id" value=<?=$main_export_id?> name="main_export_id">
            <input type="hidden" class="preexportitemdetailsid" id="preexportitemdetailsid" value="<?=$preexportitemdetailsid?>" name="preexportitemdetailsid">
        </h4>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Pre Export Item Attributes</a></li>
                </ul>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                   <a class="btn btn-primary" href="<?php echo base_url(); ?>exportdetailsitemdetails/<?=$main_export_id?>">
                        <i class="fa fa-arrow-left"></i> Back</a>

                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addexportitemdetailswithattributesvalues/<?=$preexportitemdetailsid?>">
                        <i class="fa fa-plus"></i> Add Pre Export Item Attributes</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_pre_export_item_details_attribute">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Gross Per Box Weight</th>
                                        <th>No of Cartoons</th>
                                        <th>No Of Packets </th>
                                        <th>Total Gross Weight</th>
                                        <th>Per Box PCS</th>
                                        <th>Total Qty</th>
                                        <th>Total Net Weight</th>
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