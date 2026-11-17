
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-calculator"></i> Count Master
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
                        <a href="javascript:void(0);">Count Master</a>
                    </li>

                </ul>

            </div>

            <div class="col-xs-6 text-right">

                <div class="form-group">

                    <a class="btn btn-primary"
                       href="<?php echo base_url(); ?>addnewCount">

                        <i class="fa fa-plus"></i> Add Count

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
                                id="view_Count">

                                <thead>

                                    <tr style="background-color:#3c8dbc !important;color:#fff">

                                        <th>Part Number</th>

                                        <th>Setup 1 (Min)</th>

                                        <th>Setup 2 (Min)</th>

                                        <th>Setup 3 (Min)</th>

                                        <th>Setup 4 (Min)</th>

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
