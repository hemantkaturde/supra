<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Production Status Report
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Production Status Report</a></li>
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
                            <h3 class="box-title">Production Status Report</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                            <div class="box-body">
                                <div class="row" style="margin-left:4px">

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="vendor_name">Part Number</label>
                                                <select class="form-control" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="NA">Select Part Number</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>"  <?php if($value['ven_id']==$fetchALLpresupplieritemList[0]['pre_vendor_name']){ echo 'selected';} ?> ><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="vendor_name">Vendor PO</label>
                                                <select class="form-control" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="NA">Select Vendor PO</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>"  <?php if($value['ven_id']==$fetchALLpresupplieritemList[0]['pre_vendor_name']){ echo 'selected';} ?> ><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>



                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="vendor_name">Vendor Name</label>
                                                <select class="form-control" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="NA">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>"  <?php if($value['ven_id']==$fetchALLpresupplieritemList[0]['pre_vendor_name']){ echo 'selected';} ?> ><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="email">Status</label>
                                            <select class="form-control" name="status" id="status">
                                                    <option st-id="" value="NA">Select Status</option>
                                                    <option st-id="" value="NA">ALL</option>
                                                    <option value="OPEN">Open </option>
                                                    <option value="CLOSE">Close</option>
                                                </select>
                                                <p class="error status_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div style="margin-top:22px">
                                                <!-- <input type="button"  class="btn btn-primary" value="Search" id="search" name="search" /> -->
                                                <input type="button"  class="btn btn-primary" value="Export To Excel"  id="export_to_excel" name="export_to_excel" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            

                                    <div class="panel-body">
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="view_production_status_report">
                                            <thead>
                                                <tr style="background-color:#3c8dbc !important;color:#fff">
                                                    <th>Vendor Name</th>
                                                    <th>Vendor PO Number</th>
                                                    <th>Vendor PO Date</th>
                                                    <th>FG Part No</th>
                                                    <th>FG Part Description</th>
                                                    <th>FG Part Order Qty</th>
                                                    <th>FG Part Expected Qty</th>
                                                    <th>FG Part Received Qty</th>
                                                    <th>Vendor Delivery Date</th>
                                                    <th>Buyer Name</th>
                                                    <th>Buyer PO No</th>
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

