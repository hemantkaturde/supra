<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Daily Production Summary
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_hourly_inspection_report">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>FG Part No</th>
                                        <th>Team Name</th>
                                        <th>Lot Number</th>
                                        <th>Invoice Qty (in Pcs)</th>
                                        <!-- <th>P.O.Qty (in Pcs)</th> -->
                                        <th>Vendor Name</th>
                                        <!-- <th>Invoice Qty (in Pcs)</th>
                                        <th>Balance Qty in Pcs</th>
                                        <th>Invoice Qty (in Kgs)</th>
                                        <th>Net weight (in Kgs)	</th> -->
                                        <th>Vendor PO No</th>
                                        <th>Invoice No</th>
                                        <th>Invoice Date</th>
                                        <th>Challan No</th>
                                        <th>Challan Date</th>
                                        <th>Received Date</th>
                                        <!-- <th>FG Material Gross Weight</th> -->
                                        <th>Units</th>
                                        <th>No. of Boxes / Goni / Bundle</th>
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



<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="registerModalLabel">Assign Team</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Registration form -->
          <form id="assign_team_form" name="assign_team_form">
          <input type="hidden" id="selected_item_id" name="selected_item_id">

          <div class="form-group">
          <label class="col-sm-4 col-form-label">Team Name :</label>
               <label id="previous_team_name" name="previous_team_name"></label>
          </div>

          <div class="form-group">
              <label class="col-sm-4 col-form-label">Change Team <span class="required">*</span></label>
                <select class="form-control" name="assign_team" id="assign_team">
                     <option st-id="" value="">Select Team </option>
                        <?php foreach ($getAllteammaster as $key => $value) {?>
                         <option value="<?php echo $value['id']; ?>">
                         <?php echo $value['team_name']; ?></option>
                        <?php } ?> 
                </select>
                <p class="error assign_team_error"></p>
            </div>

            <div class="form-group">
              <label class="col-sm-4 col-form-label">Working Hrs Status <span class="required">*</span></label>
                <select class="form-control" name="working_hrs_status" id="working_hrs_status">
                    <option st-id="" value="Open">Open</option>
                    <option st-id="" value="Close">Close</option>
                </select>
                <p class="error working_hrs_status_error"></p>
            </div>

            <?php $current_date = date('d-m-Y');  ?>

            <div class="form-group">
              <label class="col-sm-4 col-form-label">Date <span class="required">*</span></label>
              <input  style="width:283px !important" type="text" class="form-control datepicker" value="<?=$current_date;?>" id="assign_date" name="assign_date">
            </div>

            <button type="button" class="btn btn-primary" id="submit_assign_item">Update</button>
            <button type="button" class="btn btn-secondary" id="close_assign_item" data-dismiss="modal">Close</button>

          </form>
        </div>
      </div>
    </div>
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
