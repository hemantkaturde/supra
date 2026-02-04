<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-cog"></i> Instrument Master Details
            <small>Add, Edit, Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Instrument Master Details</a></li>
                </ul>

                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                   <b>Instrument Name</b> : <?php echo $getinstrumentdetailsdata[0]['instrument_name']; ?> ||  <b>Measuring Size</b> : <?php echo $getinstrumentdetailsdata[0]['measuring_size']; ?>
                </ul>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                    <button class="btn btn-primary" onclick="openModalinstrumentdetails()">
                        <i class="fa fa-plus"></i> Add Instrument Details
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_instrument_details">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Instrument Id</th>
                                        <th>Calibration Date</th>
                                        <th>Due Date</th>
                                        <th>Certificate</th>
                                        <th>Status</th>                                        
                                        <th>Remark</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Instrument Modal -->
<div class="modal fade" id="instrumentdetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="instrumentForm">
        <div class="modal-header" style="background-color:#3c8dbc;color:#fff">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Instrument Master Details</h4>
        </div>

        <div class="modal-body">
          <input type="hidden" name="instrument_details_id" id="instrument_details_id" value="<?php echo $getinstrumentdetailsdata[0]['id']; ?>">
          <input type="hidden" name="instrument_master_details_id" id="instrument_master_details_id">

          <!-- Row 1 -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Instrument Id <span class="text-danger">*</span></label>
                  <input type="text" name="instrument_id" id="instrument_id" class="form-control">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Calibration Date <span class="text-danger">*</span></label>
                 <input type="text" name="calibration_date" id="calibration_date" class="form-control datepicker">
              </div>
            </div>
          </div>

          <!-- Row 2 -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Due Date <span class="text-danger">*</span></label>
                <input type="text"  name="due_date" id="due_date" class="form-control datepicker">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Certificate No</label>
                 <input type="text" name="certificate_no" id="certificate_no" class="form-control">
              </div>
            </div>
          </div>

          <!-- Row 4 -->
          <div class="row">
             <div class="col-md-6">
              <div class="form-group">
                <label>Status</label>
                <select name="status" id="status" class="form-control serachfilternotrequired">
                  <option value="">Select Status</option>
                  <option value="Ok">Ok</option>
                  <option value="Reject">Reject</option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Remark</label>
                <input type="text" name="remark" id="remark" class="form-control">
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
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