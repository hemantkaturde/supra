<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <h1>
            <i class="fa fa-check-square-o"></i> QC Internal Audit
            <small>Add, Edit, Delete</small>
        </h1>
    </section>

    <section class="content">
        <!-- Breadcrumb + Add Button -->
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed">
                        <a href="javascript:void(0);">
                            Masters
                        </a>
                    </li>

                    <li class="active">
                        <a href="javascript:void(0);">
                            QC Internal Audit
                        </a>
                    </li>
                </ul>
            </div>


            <div class="col-xs-6 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>qcinternalauditadd">
                        <i class="fa fa-plus"></i>
                        Add QC Internal Audit
                    </a>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_qc_internal_audit">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Audit No</th>
                                        <th>Audit Date</th>
                                        <th>Vendor Name</th>
                                        <th>Vendor PO</th>
                                        <th>Buyer Name</th>
                                        <th>Buyer PO</th>
                                        <th>FG Part No</th>
                                        <th>FG Received Qty</th>
                                        <th>Verified By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will load through AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8">
</script>

