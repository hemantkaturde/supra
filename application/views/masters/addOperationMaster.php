<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-cogs"></i> Add Operation Master
        </h1>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Operation Details</h3>
                    </div>

                    <form id="addOperationForm" method="post">

                        <div class="box-body">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Operation Name <span style="color:red">*</span></label>

                                        <input type="text"
                                            name="operation_name"
                                            id="operation_name"
                                            class="form-control"
                                            placeholder="Enter Operation Name"
                                            maxlength="128">

                                        <span class="operation_name_error text-danger"></span>
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
                                id="saveOperation"
                                class="btn btn-primary">
                                <i class="fa fa-save"></i> Save
                            </button>

                            <a href="<?php echo base_url(); ?>operationmaster"
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