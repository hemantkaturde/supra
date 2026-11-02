<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-cogs"></i> Add Machine Master
            <small>Add Machine Details</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Machine Details</h3>
                    </div>

                    <form id="addMachineForm" method="post">

                        <div class="box-body">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>
                                            Machine No <span style="color:red">*</span>
                                        </label>

                                        <input type="text"
                                            name="machine_no"
                                            id="machine_no"
                                            class="form-control"
                                            placeholder="Enter Machine No"
                                            maxlength="128">

                                        <span class="machine_no_error text-danger"></span>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>Remark</label>

                                        <input type="text"
                                            name="remark"
                                            id="remark"
                                            class="form-control"
                                            placeholder="Enter Remark"
                                            maxlength="500">

                                        <span class="remark_error text-danger"></span>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="box-footer">

                            <button type="button"
                                id="saveMachine"
                                class="btn btn-primary">

                                <i class="fa fa-save"></i> Save

                            </button>

                            <a href="<?php echo base_url(); ?>machinemaster"
                                class="btn btn-default">

                                Cancel

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </section>

</div>