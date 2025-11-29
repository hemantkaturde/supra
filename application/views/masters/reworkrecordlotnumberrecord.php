<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i>Rework Record Incoming Details
            <small>Add,Delete</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Stock </a></li>
                    <li class="active"><a href="javascript:void(0);">Rework Record Incoming Details</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">  
                        <div class="panel-body">
                            <h4>
                                <input type="hidden" class="form-control" value="<?php echo $getreworkrecorddatabyid[0]['rework_id']; ?>" id="tdir_id" name="tdir_id">

                                <p><b>Rework Record No :</b> <?=$getreworkrecorddatabyid[0]['rework_record_no'] ?></p>
                                <p><b>Vendor Name :</b> <?=$getreworkrecorddatabyid[0]['actual_vendor_name'] ?></p>
                                <p><b>Vendor PO Number :</b> <?=$getreworkrecorddatabyid[0]['po_number'] ?></p>
                                <p><b>FG. Part Number :</b> <?=$getreworkrecorddatabyid[0]['part_number'] ?></p>
                                <p><b>FG. Part Description :</b> <?=$getreworkrecorddatabyid[0]['name'] ?></p>
                                <p><b>Team :</b> <?=$getreworkrecorddatabyid[0]['team_name'] ?></p>
                            </h4>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="rework_record_incoming_item_list">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Lot Number</th>
                                        <th>Invoice (In pcs)</th>
                                        <th>Invoice Date</th>
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