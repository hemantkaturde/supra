
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-list"></i> Add Parameter Master
            <small>Add Parameter Details</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Parameter Details</h3>
                    </div>

                    <form id="addParameterForm" method="post">

                        <div class="box-body">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>
                                           Part Number
                                            <span style="color:red">*</span>
                                        </label>

                                        <select name="fc_id"
                                            id="fc_id"
                                            class="form-control">

                                            <option value="">Select Part Number</option>

                                            <?php foreach($fcList as $fc) { ?>

                                                <option value="<?php echo $fc['fin_id']; ?>">

                                                    <?php echo htmlspecialchars($fc['part_number'], ENT_QUOTES, 'UTF-8'); ?>

                                                </option>

                                            <?php } ?>

                                        </select>

                                        <span class="fc_id_error text-danger"></span>

                                    </div>

                                </div>

                            </div>

                            <hr>

                            <div class="row">

                                <?php for($i=1; $i<=12; $i++) { ?>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Parameter <?php echo $i; ?>
                                            </label>

                                            <input type="text"
                                                name="parameter_<?php echo $i; ?>"
                                                id="parameter_<?php echo $i; ?>"
                                                class="form-control"
                                                placeholder="Enter Parameter <?php echo $i; ?>"
                                                maxlength="255">

                                            <span class="parameter_<?php echo $i; ?>_error text-danger"></span>

                                        </div>

                                    </div>

                                <?php } ?>

                            </div>

                            <span class="parameters_error text-danger"></span>

                        </div>

                        <div class="box-footer">

                            <button type="button"
                                id="saveParameter"
                                class="btn btn-primary">

                                <i class="fa fa-save"></i> Save

                            </button>

                            <a href="<?php echo base_url(); ?>parametermaster"
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
