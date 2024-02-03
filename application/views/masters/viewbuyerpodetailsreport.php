<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Buyer PO Details
            <small>Add,Edit,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Buyer PO Details</a></li>
                </ul>
            </div>
            <!-- <div class="col-xs-6 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewPODdetails">
                        <i class="fa fa-plus"></i> Add POD Details</a>
                </div>
            </div> -->
        </div>

        <div class="row" style="background: #fff;margin-right: 1px;margin-left: 1px;margin-bottom: 12px;margin-top: 10px;">
            <div class="col-xs-3 text-left" style="margin-top: 10px;">
                <div class="form-group">
                    <label for="date">Buyer Name</label>
                        <select class="form-control" name="buyer_name" id="buyer_name">
                            <option st-id="" value="">Select Buyer Name</option>
                            <?php foreach ($buyerList as $key => $value) {?>
                                <option value="<?php echo $value['buyer_id']; ?>"><?php echo $value['buyer_name']; ?></option>
                            <?php } ?>
                        </select>
                </div>
            </div>
            <div class="col-xs-3 text-left" style="margin-top: 10px;">
                <div class="form-group">
                    <label for="date">Part Number</label>
                        <input type="text" class="form-control datepicker"  id="date" name="date">
                        <p class="error date_error"></p>
                </div>
            </div>
            <div class="col-xs-3 text-left" style="margin-top: 10px;">
                <div class="form-group">
                    <label for="date">From Date</label>
                        <input type="text" class="form-control datepicker" value="<?=date("1-m-Y")?>" id="from_date" name="from_date">
                        <p class="error date_error"></p>
                </div>
            </div>
            <div class="col-xs-3 text-left" style="margin-top: 10px;">
                <div class="form-group">
                    <label for="date">To Date</label>
                        <input type="text" class="form-control datepicker" value="<?=date("t-m-Y")?>"  id="to_date"  name="to_date">
                        <p class="error date_error"></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_buyer_PO_details_report">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Buyer Name</th>
                                        <th>Buyer PO</th>
                                        <th>Buyer PO Date</th>
                                        <th>Part No</th>
                                        <th>Part Description</th>
                                        <th>Order Qty</th>
                                        <th>Delivery Date</th>
                                        <th>Export Invoice No</th>
                                        <th>Export Qty</th>
                                        <th>Export Invoice Date</th>
                                        <th>Remarks</th>
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
