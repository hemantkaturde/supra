<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Operator Master
            <small>Update Operator Details</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Operator Details</h3>
                    </div>

                    <form id="editOperatorForm" method="post">

                        <input type="hidden"
                            name="operator_id"
                            id="operator_id"
                            value="<?php echo $getOperatordata['operator_id']; ?>">

                        <div class="box-body">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>
                                            Operator Name <span style="color:red">*</span>
                                        </label>

                                        <input type="text"
                                            name="operator_name"
                                            id="operator_name"
                                            class="form-control"
                                            value="<?php echo htmlspecialchars($getOperatordata['operator_name'], ENT_QUOTES, 'UTF-8'); ?>"
                                            placeholder="Enter Operator Name"
                                            maxlength="128">

                                        <span class="operator_name_error text-danger"></span>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>Remark</label>

                                        <input type="text"
                                            name="remark"
                                            id="remark"
                                            class="form-control"
                                            value="<?php echo htmlspecialchars($getOperatordata['remark'], ENT_QUOTES, 'UTF-8'); ?>"
                                            placeholder="Enter Remark"
                                            maxlength="500">

                                        <span class="remark_error text-danger"></span>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="box-footer">

                            <button type="button"
                                id="updateOperator"
                                class="btn btn-primary">

                                <i class="fa fa-save"></i> Update

                            </button>

                            <a href="<?php echo base_url(); ?>operatormaster"
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