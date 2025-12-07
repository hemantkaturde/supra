<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Rework Record Reason Details
            <small>Add,Edit,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);"> Rework Record Reason Details</a></li>
                    <input readonly  type="hidden" class="form-control" id="incoming_details_item_id" value="<?=$incoming_details_item_id?>" name="incoming_details_item_id" readonly>

                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover rework_record_reason_details" id="rework_record_reason_details">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Reason</th>
                                        <th>Rework Qty (in pcs)</th>
                                        <th>After Rework OK Qty (in pcs)</th>
                                        <th>After Rework Rej Qty (in pcs)</th>
                                        <th>Rework Done By</th>   
                                        <th>Rework Checked By</th>   
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
