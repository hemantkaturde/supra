<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-paper-plane"></i> Edit Store Ticket
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Store</a></li>
                    <li class="active"><a href="javascript:void(0);">Edit Ticket</a></li>
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
                            <h3 class="box-title">Store Ticket</h3>
                        </div>

                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addTicketForm" action="#" method="post">

                            <div class="box-body">

                                <!-- Hidden IDs -->
                                <input type="hidden" class="form-control" value="<?php echo $getTicketData[0]['ticket_id']; ?>" id="ticket_id" name="ticket_id">

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="ticket_no">Ticket No<span class="required">*</span></label>
                                            <input type="text" class="form-control" value="<?php echo $getTicketData[0]['ticket_no']; ?>" id="ticket_no" name="ticket_no" readonly>
                                            <p class="error ticket_no_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="ticket_date">Date<span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" value="<?php echo date('d-m-Y', strtotime($getTicketData[0]['ticket_date'])); ?>" id="ticket_date" name="ticket_date">
                                            <p class="error ticket_date_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="parts_no">Part No<span class="required">*</span></label>
                                            <select class="form-control" name="parts_no" id="parts_no">
                                                <option value="">Select Part No</option>
                                                <?php foreach ($parts_no_list as $p) { ?>
                                                    <option value="<?php echo $p['fin_id']; ?>" 
                                                        <?php if ($p['fin_id'] == $getTicketData[0]['parts_id']) echo "selected"; ?>>
                                                        <?php echo $p['part_number']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <p class="error parts_no_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="team">Team<span class="required">*</span></label>
                                            <select class="form-control" name="team" id="teamTicket">
                                                <option value="">Select Team</option>
                                                <?php foreach ($team_list as $t) { ?>
                                                    <option value="<?php echo $t['id']; ?>" 
                                                        <?php if ($t['id'] == $getTicketData[0]['team_id']) echo "selected"; ?>>
                                                        <?php echo $t['team_name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <p class="error team_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="team_member">Team Member<span class="required">*</span></label>
                                            <select class="form-control" id="team_member" name="team_member">
                                                <option value="">Select Team Member</option>
                                                <?php foreach ($team_members as $tm) { ?>
                                                    <option value="<?php echo $tm['id']; ?>" 
                                                        <?php if ($tm['id'] == $getTicketData[0]['team_member_id']) echo "selected"; ?>>
                                                        <?php echo $tm['team_member_name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <p class="error team_member_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status<span class="required">*</span></label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="Open" <?php if ($getTicketData[0]['status'] == "Open") echo "selected"; ?>>Open</option>
                                                <option value="Close" <?php if ($getTicketData[0]['status'] == "Close") echo "selected"; ?>>Close</option>
                                            </select>
                                            <p class="error status_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="remarks">Remarks</label>
                                            <textarea class="form-control" id="remarks" name="remarks" rows="2"><?php echo $getTicketData[0]['remarks']; ?></textarea>
                                            <p class="error remarks_error"></p>
                                        </div>
                                    </div>

                                </div>

                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <input type="submit" id="savenewTicket" class="btn btn-primary" value="Save" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>storeform'" class="btn btn-default" value="Back" />
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(function(){
    $(".datepicker").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true
    });
});
</script>
