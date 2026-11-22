
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o"></i> Job Number Wise Insert Details
            <small>Insert Consumption Details</small>
        </h1>
    </section>

    <section class="content">

        <div class="box box-primary">

            <div class="box-header with-border">
                <h3 class="box-title">Job Number Wise Insert Details</h3>

                <div class="box-tools pull-right">
                    <button type="button" id="printInsertDetails"
                        class="btn btn-default">
                        <i class="fa fa-print"></i> Print
                    </button>
                </div>
            </div>

            <form id="insertDetailsForm">

                <input type="hidden" name="cnc_id"
                    id="cnc_id"
                    value="<?php echo $cncData['cnc_id']; ?>">

                <div class="box-body">

                    <div id="printArea">

                        <div class="text-center">
                            <h3><strong>SUPRA QUALITY EXPORTS (I) PVT. LTD.</strong></h3>
                            <h4><strong>JOB NUMBER-WISE INSERT DETAILS</strong></h4>
                        </div>

                        <div class="row">
                            <div class="col-xs-4">
                                <strong>JOB NO.:
                                    <?php echo htmlspecialchars($cncData['job_no'], ENT_QUOTES, 'UTF-8'); ?>
                                </strong>
                            </div>

                            <div class="col-xs-4 text-center">
                                <strong>PART NO.:
                                    <?php echo htmlspecialchars($cncData['part_number'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                </strong>
                            </div>

                            <div class="col-xs-4 text-right">
                                <strong>Doc. No. SQ/PR/058 Rev. 00</strong>
                            </div>
                        </div>

                        <hr>

                        <div class="table-responsive">
                            <table class="table table-bordered"
                                id="insertDetailsTable">

                                <thead>
                                    <tr class="text-center">
                                        <th>DATE</th>
                                        <th>TNMG<br>R1.2 QTY.</th>
                                        <th>DATE</th>
                                        <th>TNMG<br>R0.8 QTY.</th>
                                        <th>DATE</th>
                                        <th>VNMG<br>R0.4 QTY.</th>
                                        <th>TNMG<br>R0.4 QTY.</th>
                                        <th>DATE</th>
                                        <th>THREAD 11<br>TPI QTY.</th>
                                        <th>REC. BY</th>
                                    </tr>
                                </thead>

                                <tbody id="insertDetailsBody">

                                    <?php
                                    // $rows = !empty($insertDetails)
                                    //     ? $insertDetails
                                    //     : array(array());

                                    $rows = !empty($insertDetails) ? $insertDetails : array();

                                    // Minimum 15 rows maintain karo
                                    while (count($rows) < 15) {
                                        $rows[] = array();
                                    }
                                    ?>

                                   

                                    <?php foreach($rows as $i => $row) { ?>

                                    <tr class="insert-row">

                                        <td>
                                            <input type="date"
                                                name="rows[<?php echo $i; ?>][date_1]"
                                                class="form-control date-field"
                                                value="<?php echo htmlspecialchars($row['date_1'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                        </td>

                                        <td>
                                            <input type="number"
                                                step="0.01" min="0"
                                                name="rows[<?php echo $i; ?>][tnmg_r12_qty]"
                                                class="form-control qty-field qty-r12"
                                                value="<?php echo htmlspecialchars((string)($row['tnmg_r12_qty'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                                        </td>

                                        <td>
                                            <input type="date"
                                                name="rows[<?php echo $i; ?>][date_2]"
                                                class="form-control date-field"
                                                value="<?php echo htmlspecialchars($row['date_2'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                        </td>

                                        <td>
                                            <input type="text"
                                                name="rows[<?php echo $i; ?>][tnmg_r08_qty]"
                                                class="form-control qty-field qty-r08"
                                                value="<?php echo htmlspecialchars((string)($row['tnmg_r08_qty'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                                        </td>

                                        <td>
                                            <input type="date"
                                                name="rows[<?php echo $i; ?>][date_3]"
                                                class="form-control date-field"
                                                value="<?php echo htmlspecialchars($row['date_3'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                        </td>

                                        <td>
                                            <input type="number"
                                                step="0.01" min="0"
                                                name="rows[<?php echo $i; ?>][vnmg_r04_qty]"
                                                class="form-control qty-field qty-vnmg"
                                                value="<?php echo htmlspecialchars((string)($row['vnmg_r04_qty'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                                        </td>

                                        <td>
                                            <input type="number"
                                                step="0.01" min="0"
                                                name="rows[<?php echo $i; ?>][tnmg_r04_qty]"
                                                class="form-control qty-field qty-tnmg"
                                                value="<?php echo htmlspecialchars((string)($row['tnmg_r04_qty'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                                        </td>

                                        <td>
                                            <input type="date"
                                                name="rows[<?php echo $i; ?>][date_4]"
                                                class="form-control date-field"
                                                value="<?php echo htmlspecialchars($row['date_4'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                        </td>

                                        <td>
                                            <input type="number"
                                                step="0.01" min="0"
                                                name="rows[<?php echo $i; ?>][thread_11_tpi_qty]"
                                                class="form-control qty-field qty-thread"
                                                value="<?php echo htmlspecialchars((string)($row['thread_11_tpi_qty'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                                        </td>

                                        <td>
                                            <input type="text"
                                                name="rows[<?php echo $i; ?>][rec_by]"
                                                class="form-control"
                                                value="<?php echo htmlspecialchars($row['rec_by'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                        </td>

                                    </tr>

                                    <?php } ?>

                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>TOTAL =</th>
                                        <th id="totalR12">0</th>
                                        <th>TOTAL =</th>
                                        <th id="totalR08">0</th>
                                        <th>TOTAL =</th>
                                        <th id="totalVnmg">0</th>
                                        <th id="totalTnmg">0</th>
                                        <th>TOTAL =</th>
                                        <th id="totalThread">0</th>
                                        <th></th>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <strong>ISSUED BY:</strong>

                                <input type="text"
                                    name="issued_by"
                                    id="issued_by"
                                    class="form-control"
                                    value="<?php echo htmlspecialchars($insertDetails[0]['issued_by'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                        </div>

                    </div>

                    <br>

                    <!-- <button type="button" id="addInsertRow"
                        class="btn btn-success">
                        <i class="fa fa-plus"></i> Add Row
                    </button> -->

                </div>

                <div class="box-footer">

                    <button type="button" id="saveInsertDetails"
                        class="btn btn-primary">
                        <i class="fa fa-save"></i> Save Details
                    </button>

                    <a href="<?php echo base_url(); ?>cncmaster"
                        class="btn btn-default">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </section>

</div>

<script type="text/javascript">
$(document).ready(function() {

    function calculateTotals() {

        var totals = {
            r12: 0,
            r08: 0,
            vnmg: 0,
            tnmg: 0,
            thread: 0
        };

        $('.qty-r12').each(function() {
            totals.r12 += parseFloat($(this).val()) || 0;
        });

        $('.qty-r08').each(function() {
            totals.r08 += parseFloat($(this).val()) || 0;
        });

        $('.qty-vnmg').each(function() {
            totals.vnmg += parseFloat($(this).val()) || 0;
        });

        $('.qty-tnmg').each(function() {
            totals.tnmg += parseFloat($(this).val()) || 0;
        });

        $('.qty-thread').each(function() {
            totals.thread += parseFloat($(this).val()) || 0;
        });

        $('#totalR12').text(totals.r12);
        $('#totalR08').text(totals.r08);
        $('#totalVnmg').text(totals.vnmg);
        $('#totalTnmg').text(totals.tnmg);
        $('#totalThread').text(totals.thread);
    }

    $(document).on('input', '.qty-field', calculateTotals);

    $('#addInsertRow').click(function() {

        var index = $('#insertDetailsBody tr').length;

        var row = `
        <tr class="insert-row">
            <td><input type="date" name="rows[${index}][date_1]" class="form-control date-field"></td>
            <td><input type="number" step="0.01" min="0" name="rows[${index}][tnmg_r12_qty]" class="form-control qty-field qty-r12"></td>
            <td><input type="date" name="rows[${index}][date_2]" class="form-control date-field"></td>
            <td><input type="text" name="rows[${index}][tnmg_r08_qty]" class="form-control qty-field qty-r08"></td>
            <td><input type="date" name="rows[${index}][date_3]" class="form-control date-field"></td>
            <td><input type="number" step="0.01" min="0" name="rows[${index}][vnmg_r04_qty]" class="form-control qty-field qty-vnmg"></td>
            <td><input type="number" step="0.01" min="0" name="rows[${index}][tnmg_r04_qty]" class="form-control qty-field qty-tnmg"></td>
            <td><input type="date" name="rows[${index}][date_4]" class="form-control date-field"></td>
            <td><input type="number" step="0.01" min="0" name="rows[${index}][thread_11_tpi_qty]" class="form-control qty-field qty-thread"></td>
            <td><input type="text" name="rows[${index}][rec_by]" class="form-control"></td>
        </tr>`;

        $('#insertDetailsBody').append(row);
    });

    calculateTotals();

});
</script>

<style>
#insertDetailsTable {
    width: 100%;
    table-layout: fixed;
    font-size: 12px;
}

#insertDetailsTable th,
#insertDetailsTable td {
    border: 1px solid #333 !important;
    text-align: center;
    vertical-align: middle !important;
    padding: 4px;
}

#insertDetailsTable input {
    min-width: 0;
    width: 100%;
    padding: 3px;
    font-size: 11px;
    border: 1px solid #ccc;
}

#insertDetailsTable thead th {
    height: 75px;
    background: #f5f5f5;
}

@media print {
    @page {
        size: A4 landscape;
        margin: 8mm;
    }

    body * {
        visibility: hidden;
    }

    #printArea, #printArea * {
        visibility: visible;
    }

    #printArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    #insertDetailsTable input {
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }

    .date-field {
        appearance: none;
    }
}
</style>
