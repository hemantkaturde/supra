<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-cogs"></i> Edit CNC Master
            <small>Update CNC Details</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title">CNC Details</h3>
                    </div>

                    <form id="editCNCForm" method="post">

                        <input type="hidden"
                            name="cnc_id"
                            id="cnc_id"
                            value="<?php echo $cncData['cnc_id']; ?>">

                        <div class="box-body">

                            <!-- Job Details -->
                            <h4><i class="fa fa-file-text-o"></i> Job Details</h4>
                            <hr>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Job No.</label>

                                        <input type="text"
                                            class="form-control"
                                            value="<?php echo htmlspecialchars($cncData['job_no'], ENT_QUOTES, 'UTF-8'); ?>"
                                            readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            Date <span style="color:red">*</span>
                                        </label>

                                        <input type="date"
                                            name="job_date"
                                            id="job_date"
                                            class="form-control"
                                            value="<?php echo htmlspecialchars($cncData['job_date'], ENT_QUOTES, 'UTF-8'); ?>">

                                        <span class="job_date_error text-danger"></span>
                                    </div>
                                </div>

                            </div>

                            <!-- Vendor Details -->
                            <h4><i class="fa fa-truck"></i> Vendor Details</h4>
                            <hr>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            Vendor Name <span style="color:red">*</span>
                                        </label>

                                        <select name="vendor_id"
                                            id="vendor_id"
                                            class="form-control">

                                            <option value="">Select Vendor</option>

                                            <?php foreach($vendorList as $vendor) { ?>

                                                <option value="<?php echo $vendor['ven_id']; ?>"
                                                    <?php echo ($cncData['vendor_id'] == $vendor['ven_id']) ? 'selected' : ''; ?>>

                                                    <?php echo htmlspecialchars($vendor['vendor_name'], ENT_QUOTES, 'UTF-8'); ?>

                                                </option>

                                            <?php } ?>

                                        </select>

                                        <span class="vendor_id_error text-danger"></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            Vendor PO <span style="color:red">*</span>
                                        </label>

                                        <select name="vendor_po_id"
                                            id="vendor_po_id"
                                            class="form-control">

                                            <option value="">Select Vendor PO</option>

                                            <?php foreach($vendorPOList as $po) { ?>

                                                <option value="<?php echo $po['id']; ?>"
                                                    <?php echo ($cncData['vendor_po_id'] == $po['id']) ? 'selected' : ''; ?>>

                                                    <?php echo htmlspecialchars($po['po_number'], ENT_QUOTES, 'UTF-8'); ?>

                                                </option>

                                            <?php } ?>

                                        </select>

                                        <span class="vendor_po_id_error text-danger"></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            Part Number <span style="color:red">*</span>
                                        </label>

                                        <select name="part_number_id"
                                            id="part_number_id"
                                            class="form-control">

                                            <option value="">Select Part Number</option>

                                            <?php foreach($vendorPartList as $part) { ?>

                                                <option value="<?php echo $part['part_number_id']; ?>"
                                                    <?php echo ($cncData['part_number_id'] == $part['part_number_id']) ? 'selected' : ''; ?>>

                                                    <?php echo htmlspecialchars($part['part_number'], ENT_QUOTES, 'UTF-8'); ?>

                                                </option>

                                            <?php } ?>

                                        </select>

                                        <span class="part_number_id_error text-danger"></span>
                                    </div>
                                </div>

                            </div>

                            <!-- Part Details -->
                            <h4><i class="fa fa-cube"></i> Part Details</h4>
                            <hr>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Part Description</label>

                                        <textarea name="part_description"
                                            id="part_description"
                                            class="form-control"
                                            rows="3"
                                            placeholder="Enter Part Description"><?php echo htmlspecialchars($cncData['part_description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>

                                        <span class="part_description_error text-danger"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Material Grade</label>

                                        <input type="text"
                                            name="material_grade"
                                            id="material_grade"
                                            class="form-control"
                                            value="<?php echo htmlspecialchars($cncData['material_grade'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                            placeholder="Enter Material Grade">

                                        <span class="material_grade_error text-danger"></span>
                                    </div>
                                </div>

                            </div>

                            <!-- Quantity and Remark -->
                            <h4><i class="fa fa-list-alt"></i> Quantity & Remark</h4>
                            <hr>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Vendor PO Qty</label>

                                        <input type="number"
                                            name="vendor_po_qty"
                                            id="vendor_po_qty"
                                            class="form-control"
                                            value="<?php echo htmlspecialchars((string)($cncData['vendor_po_qty'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                                            placeholder="Enter Vendor PO Quantity"
                                            min="0"
                                            step="0.01">

                                        <span class="vendor_po_qty_error text-danger"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Remark</label>

                                        <textarea name="remark"
                                            id="remark"
                                            class="form-control"
                                            rows="3"
                                            placeholder="Enter Remark"><?php echo htmlspecialchars($cncData['remark'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>

                                        <span class="remark_error text-danger"></span>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="box-footer">

                            <button type="button"
                                id="updateCNC"
                                class="btn btn-primary">
                                <i class="fa fa-save"></i> Update
                            </button>

                            <a href="<?php echo base_url(); ?>cncmaster"
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