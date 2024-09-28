<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Debit Note
            <small>Add,Edit,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Debit Note</a></li>
                </ul>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                    <?php if($this->session->userdata('roleText')=='Superadmin' || $this->session->userdata('roleText')=='Purchase' || $this->session->userdata('roleText')=='Stock' ){ ?>
                        <a class="btn btn-primary" href="<?php echo base_url(); ?>addnewdebitnote">
                            <i class="fa fa-plus"></i> Add Debit Note</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_debit_note">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Debit Note No</th>
                                        <th>Debit Note Date</th>
                                        <th>Vendor Name</th>
                                        <th>Vendor PO</th>
                                        <th>Supplier Name</th>
                                        <th>Supplier PO</th>
                                        <th>PO Date</th>
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