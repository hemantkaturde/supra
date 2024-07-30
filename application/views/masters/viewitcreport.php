<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> ITC Report
            <small>Download</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">ITC Report</a></li>
                </ul>
            </div>
            <!-- <div class="col-xs-6 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addnewUSP">
                        <i class="fa fa-plus"></i> Add USP</a>
                </div>
            </div> -->
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                           <div class="row" style="background: #fff;margin-right: 1px;margin-left: 1px;margin-bottom: 12px;margin-top: 10px;">
                                <div class="col-xs-3 text-left" style="margin-top: 10px;">
                                    <div class="form-group">
                                        <label for="ITC_report">ITC Report Type</label>
                                            <select class="form-control" name="ITC_report" id="ITC_report">
                                                    <option value="itc_4">ITC 4</option>
                                                    <option value="itc_5">ITC 5</option>
                                            </select>
                                            <p class="error ITC_report_error"></p>
                                    </div>
                                </div>
                                <div class="col-xs-3 text-left" style="margin-top: 10px;">
                                    <div class="form-group">
                                        <label for="job_work_no">JoB Work No</label>
                                             <select class="form-control" name="job_work_no" id="job_work_no">
                                                    <option value="">Select Job Work Number</option>
                                                    <?php foreach ($jobworkdetails as $key => $value) {?>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['po_number']; ?></option>
                                                    <?php } ?>
                                            </select>
                                            <p class="error job_work_no_error"></p>
                                    </div>
                                </div>
                                <div class="col-xs-2 text-left" style="margin-top: 10px;">
                                    <div class="form-group">
                                        <label for="date">From Date</label>
                                            <input type="text" class="form-control datepicker" placeholder="Select From date Here" id="from_date" name="from_date">
                                            <p class="error date_error"></p>
                                    </div>
                                </div>
                                <div class="col-xs-2 text-left" style="margin-top: 10px;">
                                    <div class="form-group">
                                        <label for="date">To Date</label>
                                            <input type="text" class="form-control datepicker" placeholder="Select To date Here" id="to_date"  name="to_date">
                                            <p class="error date_error"></p>
                                    </div>
                                </div>
                                <div class="col-xs-2 text-left" style="margin-top: 10px;">
                                    <div class="form-group">
                                        <label for="date">Download Report</label>
                                        <p><input type="button" id="ITC_export_to_excel"  class="btn btn-primary" value="Downlaod Report"/></p>
                                    </div>
                                </div>
                            </div>
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
