<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-hdd-o"></i> Store Form
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li><a href="javascript:void(0);">Store form</a></li>
                    <li class="active">Store Form</li>
                </ul>
            </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Store Form</h3>
                    </div>
                    
                    <form role="form" id="addTicketForm" method="post" action="#">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ticket_no">Ticket No:</label>
                                        <input type="text" id="ticket_no" name="ticket_no" class="form-control" 
           value="<?= $ticket_no ?>" readonly>
                                    <p class="error ticket_no_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ticket_date">Date:<span class="required">*</span></label>
                                        <input type="text" class="form-control datepicker" id="ticket_date" name="ticket_date" value="<?= date('d-m-Y') ?>">
                                        <p class="error ticket_date_error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="parts_no">Part No:<span class="required">*</span></label>
                                        <select class="form-control" id="parts_no" name="parts_no">
                                            <option value="">Select Part No</option>
                                            <?php foreach($parts_no_list as $p): ?>
                                                <option value="<?= $p['fin_id']; ?>">
                                                    <?= $p['part_number']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p class="error parts_no_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="team">Team:<span class="required">*</span></label>
                                        <select class="form-control" id="teamTicket" name="team">
                                            <option value="">Select Team</option>
                                            <?php foreach($team_list as $t): ?>
                                                <option value="<?= $t['id']; ?>"><?= $t['team_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p class="error team_error"></p>
                                    </div>
                                </div>


                               <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="team_member">Team Members:<span class="required">*</span></label>
                                            <select id="team_member" name="team_member"  class="form-control">
                                                <option value="">Select Team Member</option>
                                            </select>
                                            <p class="error team_member_error"></p>
                                        </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="status">Status:<span class="required">*</span></label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="Open" selected>Open</option>
                                            <option value="Close">Close</option>
                                        </select>
                                         <p class="error status_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="remarks">Remarks:</label>
                                        <textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
                                        <p class="error remarks_error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <div class="box-footer">
                                <input type="submit" id="savenewTicket" class="btn btn-primary" value="Save" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>storeform'" class="btn btn-default" value="Back" />
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function() {
        $(".datepicker").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });
    });
</script>
