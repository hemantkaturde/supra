<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Rework Record
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Rework Record Master</a></li>
                </ul>
            </small>
        </h1>
    </section>


    <section class="content">
        <div class="row">
            <div class="col-xs-8">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Edit Rework Record Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                       <form role="form" id="addnewpackingchallanform" action="<?php echo base_url() ?>addreworkrecord" method="post">
                            <div class="box-body">
                                <input type="hidden" class="form-control" name="rework_id"  value="<?=$getreworkrecorddatabyid[0]['rework_id']?>" required>

                                <!-- ROW 1 -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Rework Record No <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="rework_record_no" value="<?=$getreworkrecorddatabyid[0]['rework_record_no']?>" readonly>
                                            <p class="error rework_record_no_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" name="date"  value="<?=$getreworkrecorddatabyid[0]['reword_record_date']?>" required>
                                            <p class="error date_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- ROW 2 -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div>
                                               <label>Vendor Name <span class="required">*</span></label>
                                            </div>
                                             <select class="form-control" name="vendor_name" id="vendor_name">
                                                <option st-id="" value="">Select Vendor Name</option>
                                                <?php foreach ($vendorList as $key => $value) {?>
                                                <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$getreworkrecorddatabyid[0]['vendor_name']){ echo 'selected';} ?>>
                                                    <?php echo $value['vendor_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                             <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div>
                                               <label>Team</label>
                                            </div>
                                            <select class="form-control" name="team" id="team">
                                                <option value="">Select Team</option>
                                                <?php foreach ($team as $key => $teammaster) { ?>
                                                    <option value="<?php echo $teammaster['id']; ?>" <?php if($teammaster['id']==$getreworkrecorddatabyid[0]['team']){ echo 'selected';} ?>><?php echo $teammaster['team_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                             <p class="error team_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- ROW 3 -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div>
                                              <label>Vendor PO</label>
                                            </div>
                                             <select class="form-control" name="vendor_po_number" id="vendor_po_number">
                                                 <option value="">Select Vendor PO</option>
                                                 <option value="<?=$getreworkrecorddatabyid[0]['vendor_po']; ?>" selected><?php echo $getreworkrecorddatabyid[0]['po_number']; ?></option>
                                            </select>
                                             <p class="error vendor_po_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div>
                                              <label>Status <span class="required">*</span></label>
                                            </div>
                                            <select class="form-control" name="status">
                                                <option value="Open" <?php if("Open"==$getreworkrecorddatabyid[0]['rework_record_status']){ echo 'selected';} ?>>Open</option>
                                                <option value="Closed" <?php if("Closed"==$getreworkrecorddatabyid[0]['rework_record_status']){ echo 'selected';} ?>>Closed</option>
                                            </select>
                                             <p class="error status_error"></p>
                                        </div>
                                    </div>
                                </div>



                                <!-- ROW 4 -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div>
                                                <label>FG Part Number <span class="required">*</span></label>
                                            </div>
                                             <select class="form-control vendor_part_number_get_data_reword_record" name="vendor_part_number" id="vendor_part_number">
                                                <option value="">Select Part Number</option>
                                                 <option value="<?=$getreworkrecorddatabyid[0]['part_no']; ?>" selected><?php echo $getreworkrecorddatabyid[0]['part_number']; ?></option>
                                            </select>
                                            <p class="error part_no_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Remark</label>
                                            <textarea class="form-control" name="remark"><?php echo $getreworkrecorddatabyid[0]['remarksas_rework']; ?></textarea>
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- ROW 5 (single column) -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Part Description</label>
                                            <input type="text" class="form-control" name="part_description" id="part_description" value="<?php echo $getreworkrecorddatabyid[0]['part_description'];?>" readonly>
                                             <p class="error part_description_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- ROW 6 (single column) -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Inspection Report No</label>
                                            <input type="text" class="form-control" name="inspection_report_no" id="inspection_report_no" value="<?php echo $getreworkrecorddatabyid[0]['inspection_report_no'];?>">
                                            <p class="error inspection_report_no_error"></p>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- FOOTER -->
                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" id="savereworkrecordform"  value="Submit">
                                <input type="button" onclick="location.href='<?php echo base_url() ?>reworkrecordform'" class="btn btn-default" value="Back">
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
