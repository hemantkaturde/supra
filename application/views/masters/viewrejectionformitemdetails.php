<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Stock Rejection Form Item Details
            <small>Add,Edit,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> Stock Rejection Form Item Details</a></li>
                </ul>
            </div>

            <div class="col-xs-6 text-right">
                <div class="form-group">
                   <input type="button" onclick="location.href = '<?php echo base_url() ?>addrejectionformitemsdata/<?=$rejection_form_id?>'" class="btn  btn-primary" value="Back" />
                </div>
            </div>

        </div>

        <input type="hidden" class="form-control"  id="rejection_form_id" name="rejection_form_id"  value="<?=$rejection_form_id?>">   
        <input type="hidden" class="form-control"  id="vendor_po_item_id" name="vendor_po_item_id"  value="<?=$vendor_po_item_id?>">   
        <input type="hidden" class="form-control"  id="vendor_po_id" name="vendor_po_id"  value="<?=$vendor_po_id?>">   

        <div class="row">
            <div class="col-xs-10">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_stock_rejection_form_ttem_details">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Rejection Reason</th>
                                        <th>Qty (In Pcs)</th>
                                        <th>Qty (In Kgs)</th>
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