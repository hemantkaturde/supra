<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Pre Export
            <small>Add,Edit,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Pre Export</a></li>
                </ul>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                <?php if($this->session->userdata('roleText')=='Superadmin' || $this->session->userdata('roleText')=='Stock' ){ ?>
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addnewfreexport">
                        <i class="fa fa-plus"></i> Add Pre Export</a>
                <?php } ?>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_pre_export">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Pre Export Number - Invoice Number</th>
                                        <th>Date</th>
                                        <th>Buyer Name</th>
                                        <!-- <th>Buyer PO</th> -->
                                        <th>Total Net Weight Of Shipment (in Kgs)</th>
                                        <th>Total Gross Weight (in Kgs)</th>
                                        <th>Total Gross Weight + Total Weight of Pallets (in Kgs)</th>
                                        <th>Total No of cartoons</th>
                                        <th>Total No of Pallets</th>
                                        <th>Mode Of Shipment</th>
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