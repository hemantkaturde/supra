<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-cogs"></i> Machine Master
            <small>Add, Edit, Delete</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed">
                        <a href="javascript:void(0);">Masters</a>
                    </li>

                    <li class="active">
                        <a href="javascript:void(0);">Machine Master</a>
                    </li>
                </ul>
            </div>

            <div class="col-xs-6 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addnewMachine">
                        <i class="fa fa-plus"></i> Add Machine
                    </a>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-xs-12">

                <div class="box">

                    <div class="box-body">

                        <div class="panel-body">

                            <table width="100%"
                                class="table table-striped table-bordered table-hover"
                                id="view_Machine">

                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">

                                        <th>Machine No</th>

                                        <th>Remark</th>

                                        <th>Action</th>

                                    </tr>
                                </thead>

                                <tbody></tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/js/common.js"
    charset="utf-8"></script>