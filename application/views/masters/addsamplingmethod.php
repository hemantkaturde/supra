<?php $id = $sampling_id; ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add Sampling Method
            <small>Add,Edit,Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Sampling Master</a></li>
                    <li class="active"><a href="javascript:void(0);"> Sampling Method</a></li>
                </ul>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                    <input type="hidden" class="form-control" id="sampling_master_id" value="<?=$id?>" name="sampling_master_id">
                    <a class="btn btn-primary" href="<?php echo base_url() ?>samplingmaster">
                       <i class="fa fa-arrow-left"></i> Back</a>

                    <a class="btn btn-primary" href="<?php echo base_url() ?>addnewSamplingmethod/<?php echo $id ?>">
                        <i class="fa fa-plus"></i> Add Sampling Method</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 text-left">
              <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                <h4><b>Part Number :</b> <?=$getSamplingdetails[0]['part_number'] ?></h4>
              </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">   
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_smapling_method">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Instrument Name</th>
                                        <th>Grade</th>
                                        <th>Unit</th>
                                        <th>Class</th>
                                        <th>Measuring Size</th>
                                        <th>Type</th>
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