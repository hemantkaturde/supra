<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Search Stock
            <small>Search</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> Search Stock</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="item_name">Itam Name</label>
                        <select class="form-control" name="item_name" id="item_name">
                            <option st-id="" value="">Select Item Name</option>
                                <?php foreach ($getallitemsfromfgorrawmaterial as $key => $value) {?>
                                    <option value="<?php echo $value['find_id']; ?>" ><?php echo $value['part_number']; ?></option>
                                <?php } ?>
                        </select>
                    <p class="error item_name_error"></p>
                </div>
            </div>  
        </div>          

        <div class="row ">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_stock_search_record">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Item Number</th>
                                        <th>Description</th>
                                        <th>Order Qty</th>
                                        <th>Invoice Number</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Qty In Pcs</th>
                                        <th>Invoice Qty In Kgs</th>
                                        <th>Lot No</th>
                                        <th>Actual Received Qty In Pcs</th>
                                        <th>Actual Received Qty In Kgs</th>
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


    <section class="content">
        <div class="row ">
            <div class="col-xs-6">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <H3>Rejected Items</H3>
                            <table width="50%" class="table table-striped table-bordered table-hover" id="">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Item Number</th>
                                        <th>Description</th>
                                        <th>Order Qty</th>
                                        <th>Invoice Number</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Qty In Pcs</th>
                                        <th>Invoice Qty In Kgs</th>
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

            <div class="col-xs-6">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <H3>Exports Items</H3>
                            <table width="50%" class="table table-striped table-bordered table-hover" id="">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Item Number</th>
                                        <th>Description</th>
                                        <th>Order Qty</th>
                                        <th>Invoice Number</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Qty In Pcs</th>
                                        <th>Invoice Qty In Kgs</th>
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