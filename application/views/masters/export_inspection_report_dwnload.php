<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Export Hourly Inspection Report
            <small>Add,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Export Hourly Inspection Report</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                               <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="problem_description">Select Team </label>
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
                                            <label for="problem_description">Select Timings </label>
                                            <select class="form-control" name="assign_team" id="assign_team">
                                                    <option st-id="" value="">Select Team </option>
                                                        <?php foreach ($getAllteammaster as $key => $value) {?>
                                                        <option value="<?php echo $value['id']; ?>">
                                                        <?php echo $value['team_name']; ?></option>
                                                        <?php } ?> 
                                                </select>
                                                <p class="error assign_team_error"></p>
                                        </div>

                                        <div class="">
                                                <button type="submit" id="export_inspection_report_downlaod" name="export_inspection_report_downlaod" class="btn btn-primary" class="btn btn-success btn-xl">Export to pdf</button>
                                                <button type="button" class="btn btn-secondary btn-xl" data-dismiss="modal">Close</button>
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