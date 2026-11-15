
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-calculator"></i> Edit Count Master
            <small>Update Count Details</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">Count Details</h3>
                    </div>

                    <form id="editCountForm" method="post">

                        <input type="hidden"
                            name="count_id"
                            id="count_id"
                            value="<?php echo $countData['count_id']; ?>">

                        <div class="box-body">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>
                                            Finished Goods (FG)
                                            <span style="color:red">*</span>
                                        </label>

                                        <select name="fin_id"
                                            id="fin_id"
                                            class="form-control">

                                            <option value="">Select Finished Goods</option>

                                            <?php foreach($fgList as $fg) { ?>

                                                <option value="<?php echo $fg['fin_id']; ?>"
                                                    <?php echo ($countData['fin_id'] == $fg['fin_id']) ? 'selected' : ''; ?>>

                                                    <?php echo htmlspecialchars($fg['name'], ENT_QUOTES, 'UTF-8'); ?>

                                                </option>

                                            <?php } ?>

                                        </select>

                                        <span class="fin_id_error text-danger"></span>

                                    </div>

                                </div>

                            </div>

                            <hr>

                            <div class="row">

                                <?php for($i=1; $i<=4; $i++) { ?>

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Setup <?php echo $i; ?>
                                                <small>(Value in Minutes)</small>
                                            </label>

                                            <input type="number"
                                                name="setup_<?php echo $i; ?>"
                                                id="setup_<?php echo $i; ?>"
                                                class="form-control"
                                                value="<?php echo htmlspecialchars((string)($countData['setup_'.$i] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                                placeholder="Enter Setup <?php echo $i; ?> in Minutes"
                                                min="0"
                                                step="1">

                                        </div>

                                    </div>

                                <?php } ?>

                            </div>

                            <hr>

                            <p class="text-muted">
                                <i class="fa fa-info-circle"></i>
                                No. of pieces / day production per 16 hours shift.
                            </p>

                        </div>

                        <div class="box-footer">

                            <button type="button"
                                id="updateCount"
                                class="btn btn-primary">

                                <i class="fa fa-save"></i> Update

                            </button>

                            <a href="<?php echo base_url(); ?>countmaster"
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
