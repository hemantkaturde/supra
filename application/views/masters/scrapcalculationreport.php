<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Scrap Calculation Report
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Scrap Calculation Report</a></li>
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
                            <h3 class="box-title">Scrap Calculation Report</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                            <div class="box-body">
                                <div class="row" style="margin-left:4px">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email">Type of Raw Material</label>
                                            <select class="form-control" name="status" id="status">
                                                    <option st-id="" value="NA">Select Status</option>
                                                    <option value="NA">All</option>
                                                    <option value="Brass">Brass</option>
                                                    <option value="Copper">Copper</option>
                                                    <option value="Aluminium">Aluminium</option>
                                                    <option value="SS 304">SS 304</option>
                                                    <option value="SS 316">SS 316</option>
                                                    <option value="SS 303">SS 303</option>
                                                    <option value="SS 316 L">SS 316 L</option>
                                                    <option value="SS 304 L">SS 304 L</option>
                                                    <option value="SS 316 Ti">SS 316 Ti</option>
                                                    <option value="Duplex">Duplex</option>
                                                    <option value="Inconnel">Inconnel</option>
                                                    <option value="PFTE- Teflon Sheet">PFTE- Teflon Sheet</option>
                                                    <option value="EN1A Leaded">EN1A Leaded</option>
                                                    <option value="EN1A Non – Leaded">EN1A Non – Leaded</option>
                                                    <option value="MS">MS</option>
                                                </select>
                                                <p class="error status_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email">Vendor Name</label>
                                              <select class="form-control" name="vendor_name" id="vendor_name">
                                                  <option value="NA">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                        <option value="<?php echo $value['ven_id']; ?>"><?php echo $value['vendor_name']; ?></option>
                                                  <?php } ?>
                                              </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="from_date">From Date</label>
                                            <input type="text" class="form-control datepicker" id="from_date" name="from_date" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="to_date">
                                            <label for="to_date">To Date</label>
                                            <input type="text" class="form-control datepicker" id="to_date" name="to_date" autocomplete="off" >
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
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="view_scrap_calculation_report">
                                            <thead>
                                                <tr style="background-color:#3c8dbc !important;color:#fff">
                                                    <th>Vendor Name</th>
                                                    <th>Vendor PO NUmber</th>
                                                    <th>Vendor PO Date</th>
                                                    <th>FG Part No</th>
                                                    <th>RM Type</th>
                                                    <th>Raw Material Actual Qty</th>
                                                    <th>Raw Material In pcs</th>
                                                    <th>Vendor Actual Received Qty</th>
                                                    <th>Scrap In Kgs</th>
                                                    <th>Supra's Total Net weight</th>
                                                    <th>Net Weight Per pcs</th>
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

