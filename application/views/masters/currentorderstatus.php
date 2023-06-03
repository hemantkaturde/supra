<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Current Order Status
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Current Order Status</a></li>
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
                            <h3 class="box-title">Current Order Status</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewScrapreturnform" action="<?php echo base_url() ?>addnewScrapreturnform" method="post" role="form">
                            <div class="box-body">

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fname">Report Type <span class="required">*</span></label>
                                                <select class="form-control" name="report_type" id="report_type">
                                                    <option st-id="" value="">Select Report Type</option>
                                                    <option value="bill_of_material">Bill Of Material </option>
                                                    <option value="vendor_bill_of_material">Vendor Bill Of Material</option>
                                                </select>
                                                <p class="error report_type_error"></p>
                                        </div>
                                    </div>

                                    <?php  $form_date= date('Y-m-01');?>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="email">From Date</label>
                                                <input type="text" class="form-control datepicker"  value="<?=$form_date?>" id="from_date" name="from_date">
                                                <p class="error status_error"></p>
                                        </div>
                                    </div>

                                    <?php  $to_date= date('Y-m-t');?>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="email">To Date</label>
                                            <input type="text" class="form-control datepicker"  value="<?=$to_date?>" id="to_date" name="challan_date">
                                            <p class="error status_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="email">Status</label>
                                            <select class="form-control" name="status" id="status">
                                                    <option st-id="" value="NA">Select Status</option>
                                                    <option value="open">Open </option>
                                                    <option value="close">Close</option>
                                                </select>
                                                <p class="error status_error"></p>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div style="margin-top:22px">
                                                <input type="button"  class="btn btn-default" value="Export To Excel" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div id="vendor_bill_of_material" style="display:none">
                                    <h5>Vendor Bill Of Material</h5>
                                    <div class="panel-body">
                                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_vendorbillofmaterialVendor">
                                            <thead>
                                                <tr style="background-color:#3c8dbc !important;color:#fff">
                                                    <th>BOM No</th>
                                                    <th>BOM Date</th>
                                                    <th>Vendor PO No</th>
                                                    <th>Vendor Name</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div id="bill_of_material" style="display:none">
                                    <h5> Bill Of Material</h5>
                                    <div class="panel-body">
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="view_billofmaterial">
                                            <thead>
                                                <tr style="background-color:#3c8dbc !important;color:#fff">
                                                    <th>BOM No</th>
                                                    <th>Date</th>
                                                    <th>Vendor PO No</th>
                                                    <th>Vendor Name</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>    
                            <!-- /.box-body -->
                            <div class="box-footer">

                            </div>
                        </form>
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

