<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-eye"></i> Open Tickets List
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"> Open Tickets List</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="view_all_open_tickets">
                            <thead>
                                <tr style="background-color:#3c8dbc;color:#fff">
                                    <th>Ticket No</th>
                                    <th>Date</th>
                                    <th>Instruments Name</th>
                                    <th>Instrument Id</th>
                                    <th>Measuring Size</th>
                                    <th>Qty Assigned</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody></tbody> <!-- DATA WILL COME FROM DATATABLE AJAX -->
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>