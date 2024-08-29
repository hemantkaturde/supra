<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> USP Incoming 
            <small>Add,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">USP Incoming</a></li>
                </ul>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                    <?php if($this->session->userdata('roleText')=='Superadmin' || $this->session->userdata('roleText')=='Stock' ){ ?>
                      <a class="btn btn-primary" href="<?php echo base_url(); ?>addnewuspincoming">
                        <i class="fa fa-plus"></i> Add USP Incoming</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_usp_incoming">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Id Number</th>
                                        <th>Date</th>
                                        <th>USP Name</th>
                                        <th>Challan No</th>
                                        <th>Challan Date</th>
                                        <th>Reported By</th>
                                        <th>USP Status</th>
                                        <th>Remark</th>
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