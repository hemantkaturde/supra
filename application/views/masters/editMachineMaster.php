<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-cogs"></i> Edit Machine Master
            <small>Update Machine Details</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Machine Details</h3>
                    </div>

                    <form id="editMachineForm" method="post">

                        <input type="hidden"
                            name="machine_id"
                            id="machine_id"
                            value="<?php echo $getMachinedata['machine_id']; ?>">

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
                                            value="<?php echo htmlspecialchars($getMachinedata['machine_no'], ENT_QUOTES, 'UTF-8'); ?>"
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
                                            value="<?php echo htmlspecialchars($getMachinedata['remark'], ENT_QUOTES, 'UTF-8'); ?>"
                                            placeholder="Enter Remark"
                                            maxlength="500">

                                        <span class="remark_error text-danger"></span>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="box-footer">

                            <button type="button"
                                id="updateMachine"
                                class="btn btn-primary">

                                <i class="fa fa-save"></i> Update

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