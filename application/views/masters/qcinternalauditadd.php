<div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header">
        <h1>
            <i class="fa fa-check-square-o"></i>
            QC Internal Audit
            <small>Add, Edit, Delete</small>
        </h1>
    </section>

    <section class="content">

        <!-- Breadcrumb -->
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed">
                        <a href="javascript:void(0);">
                            Masters
                        </a>
                    </li>

                    <li class="active">
                        <a href="javascript:void(0);">
                            QC Internal Audit
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        <!-- Main Box -->
        <div class="row">
            <div class="col-xs-12">

                <div class="box">

                    <div class="box-body">

                        <div class="panel-body">

                            <style>
                                .qc-table {
                                    width: 100%;
                                    border-collapse: collapse;
                                    table-layout: fixed;
                                    font-size: 12px;
                                    color: #000;
                                }

                                .qc-table th,
                                .qc-table td {
                                    border: 1px solid #000 !important;
                                    padding: 3px 5px;
                                    vertical-align: middle;
                                    overflow: hidden;
                                }

                                .qc-table input,
                                .qc-table select,
                                .qc-table textarea {
                                    width: 100% !important;
                                    max-width: 100% !important;
                                    min-width: 0 !important;
                                    box-sizing: border-box !important;
                                    border: 0;
                                    outline: none;
                                    background: transparent;
                                    color: #000;
                                    font-size: 12px;
                                    padding: 2px 3px;
                                    box-shadow: none;
                                }

                                .qc-table input,
                                .qc-table select {
                                    height: 25px;
                                }

                                .qc-table textarea {
                                    min-height: 30px;
                                    resize: vertical;
                                }

                                .qc-label {
                                    width: 125px;
                                }

                                .qc-title {
                                    text-align: center;
                                    font-weight: bold;
                                    font-size: 13px;
                                    padding: 7px !important;
                                }

                                .qc-center {
                                    text-align: center;
                                }

                                .qc-tall td {
                                    height: 42px;
                                }

                                .qc-large td {
                                    height: 55px;
                                }

                                .qc-footer td {
                                    height: 40px;
                                    font-weight: bold;
                                }

                                /* LOT ROW */
                                .lot-col-1 {
                                    width: 28%;
                                }

                                .lot-col-2 {
                                    width: 25%;
                                }

                                .lot-col-3 {
                                    width: 47%;
                                }

                                .lot-field {
                                    display: flex;
                                    align-items: center;
                                    gap: 8px;
                                    width: 100%;
                                }

                                .lot-field label {
                                    margin: 0;
                                    white-space: nowrap;
                                    font-weight: normal;
                                }

                                .lot-field input {
                                    flex: 1 !important;
                                    width: auto !important;
                                    max-width: 100% !important;
                                    min-width: 0 !important;
                                    border: 1px solid #000 !important;
                                    height: 27px;
                                    box-sizing: border-box !important;
                                }

                                .footer-field {
                                    display: flex;
                                    align-items: center;
                                    gap: 8px;
                                    width: 100%;
                                }

                                .footer-field label {
                                    margin: 0;
                                    white-space: nowrap;
                                    font-weight: bold;
                                }

                                .footer-input {
                                    flex: 1 !important;
                                    width: auto !important;
                                    max-width: 100% !important;
                                    min-width: 0 !important;
                                    height: 27px !important;
                                    border: 1px solid #000 !important;
                                    background: #fff !important;
                                    padding: 2px 5px !important;
                                    box-sizing: border-box !important;
                                }

                                .qc-actions {
                                    margin-bottom: 10px;
                                }

                                @media print {

                                    .qc-actions,
                                    .qc-save-area,
                                    .content-header,
                                    .breadcrumb {
                                        display: none !important;
                                    }

                                    .content-wrapper {
                                        margin-left: 0 !important;
                                    }

                                    .qc-table {
                                        font-size: 10px;
                                    }

                                    .qc-table input,
                                    .qc-table select,
                                    .qc-table textarea {
                                        font-size: 10px;
                                    }

                                    .footer-input {
                                        border: 1px solid #000 !important;
                                    }
                                }
                            </style>


                            <!-- ACTIONS -->
                            <div class="qc-actions">

                                <!-- <span style="margin-right:30px;">
                                    add edit del
                                </span>

                                <button type="button"
                                        class="btn btn-default btn-xs"
                                        onclick="window.print();">
                                    <i class="fa fa-print"></i>
                                    Print
                                </button> -->

                            </div>


                            <form id="qcInternalAuditForm"
                                  method="post"
                                  action="">


                                <!-- =========================================
                                     BASIC DETAILS
                                ========================================== -->

                                <table class="qc-table">

                                    <tr>
                                        <td class="qc-label">
                                            ID No.
                                        </td>

                                        <td style="width:180px;">
                                            <input type="text"
                                                   name="id_no"
                                                   value="SQPCA2526001">
                                        </td>

                                        <td></td>
                                    </tr>


                                    <tr>
                                        <td class="qc-label">
                                            Date
                                        </td>

                                        <td>
                                            <input type="date"
                                                   name="date">
                                        </td>

                                        <td></td>
                                    </tr>


                                    <tr>
                                        <td class="qc-label">
                                            Buyer Name
                                        </td>

                                        <td>
                                            <select name="buyer_name" class="form-control input-sm">

                                                <option value="">
                                                    Drop Down
                                                </option>

                                                <option value="Buyer 1">
                                                    Buyer 1
                                                </option>

                                                <option value="Buyer 2">
                                                    Buyer 2
                                                </option>

                                            </select>
                                        </td>

                                        <td></td>
                                    </tr>


                                    <tr>
                                        <td class="qc-label">
                                            Buyer P.O. No.
                                        </td>

                                        <td>

                                            <select name="buyer_po_no" class="form-control input-sm">

                                                <option value="">
                                                    Drop Down - Listing
                                                </option>

                                            </select>

                                        </td>

                                        <td></td>
                                    </tr>


                                    <tr>
                                        <td class="qc-label">
                                            FG Part No.
                                        </td>

                                        <td>

                                            <select name="fg_part_no" class="form-control input-sm">

                                                <option value="">
                                                    Drop Down - Listing
                                                </option>

                                            </select>

                                        </td>

                                        <td></td>
                                    </tr>


                                    <tr>
                                        <td class="qc-label">
                                            FG Part Description
                                        </td>

                                        <td>

                                            <input type="text"
                                                   name="fg_part_description">

                                        </td>

                                        <td></td>
                                    </tr>


                                    <tr>
                                        <td class="qc-label">
                                            Buyer P.O. Qty
                                        </td>

                                        <td>

                                            <input type="number"
                                                   name="buyer_po_qty">

                                        </td>

                                        <td></td>
                                    </tr>


                                    <tr>
                                        <td class="qc-label">
                                            Vendor Name
                                        </td>

                                        <td>

                                            <input type="text"
                                                   name="vendor_name">

                                        </td>

                                        <td></td>
                                    </tr>


                                    <tr>
                                        <td class="qc-label">
                                            Vendor P.O. No.
                                        </td>

                                        <td>

                                            <input type="text"
                                                   name="vendor_po_no">

                                        </td>

                                        <td></td>
                                    </tr>


                                    <tr>
                                        <td class="qc-label">
                                            Vendor P.O. Qty
                                        </td>

                                        <td>

                                            <input type="number"
                                                   name="vendor_po_qty">

                                        </td>

                                        <td></td>
                                    </tr>


                                    <tr>
                                        <td class="qc-label">
                                            FG Received Qty
                                        </td>

                                        <td>

                                            <input type="number"
                                                   name="fg_received_qty">

                                        </td>

                                        <td></td>
                                    </tr>


                                    <!-- =====================================
                                         LOT DETAILS
                                    ====================================== -->

                                    <tr>

                                        <td class="lot-col-1">

                                            <div class="lot-field">

                                                <label>
                                                    Lot No.
                                                </label>

                                                <input type="text"
                                                       name="lot_no">

                                            </div>

                                        </td>


                                        <td class="lot-col-2">

                                            <div class="lot-field">

                                                <label>
                                                    Lot Qty
                                                </label>

                                                <input type="number"
                                                       name="lot_qty">

                                            </div>

                                        </td>


                                        <td class="lot-col-3">

                                            <div class="lot-field">

                                                <label>
                                                    Invoice. No.
                                                </label>

                                                <input type="text"
                                                       name="invoice_no">

                                            </div>

                                        </td>

                                    </tr>

                                </table>


                                <br>


                                <!-- =========================================
                                     DISPATCH
                                ========================================== -->

                                <table class="qc-table">

                                    <tr>

                                        <td style="width:125px;">
                                            <b>
                                                Dispatch Qty (in Pcs)
                                            </b>
                                        </td>

                                        <td>

                                            <input type="number"
                                                   name="dispatch_qty"
                                                   placeholder="Buyer Invoice qty from packaging with invoice no">

                                        </td>

                                    </tr>

                                </table>


                                <br><br>


                                <!-- =========================================
                                     CHECK POINTS
                                ========================================== -->

                                <table class="qc-table">

                                    <colgroup>

                                        <col style="width:57%;">

                                        <col style="width:20%;">

                                        <col style="width:23%;">

                                    </colgroup>


                                    <tr>

                                        <th colspan="3"
                                            class="qc-title">

                                            Check points
                                            (This will be Hard Code)

                                        </th>

                                    </tr>


                                    <!-- 1 -->

                                    <tr>

                                        <td>
                                            Verify the received material
                                        </td>

                                        <td></td>

                                        <td>

                                            <input type="text"
                                                   name="observation_received_material">

                                        </td>

                                    </tr>


                                    <!-- 2 -->

                                    <tr class="qc-tall">

                                        <td>
                                            Enter the incoming details
                                            from the invoice details
                                        </td>

                                        <td></td>

                                        <td>

                                            <input type="text"
                                                   name="observation_invoice">

                                        </td>

                                    </tr>


                                    <!-- 3 -->

                                    <tr class="qc-tall">

                                        <td>
                                            Visual checking of material
                                            as per the invoice declaration
                                            &amp; check if it is matching
                                        </td>

                                        <td></td>

                                        <td>

                                            <input type="text"
                                                   name="observation_visual">

                                        </td>

                                    </tr>


                                    <!-- 4 -->

                                    <tr>

                                        <td>
                                            Additional Process
                                        </td>

                                        <td class="qc-center">
                                            Inspection Report
                                        </td>

                                        <td>

                                            <input type="text"
                                                   name="observation_additional">

                                        </td>

                                    </tr>


                                    <!-- 5 -->

                                    <tr class="qc-tall">

                                        <td>
                                            Dimensions report
                                            Doc. No.SID/RI34 Rev. 13
                                        </td>

                                        <td></td>

                                        <td>

                                            <input type="text"
                                                   name="observation_dimensions">

                                        </td>

                                    </tr>


                                    <!-- 6 -->

                                    <tr class="qc-tall">

                                        <td>
                                            Visual 100% checking
                                        </td>

                                        <td class="qc-center">

                                            <select name="visual_team" class="form-control input-sm">

                                                <option value="">
                                                    Team Drop Down
                                                </option>

                                                <option value="Team 1">
                                                    Team 1
                                                </option>

                                                <option value="Team 2">
                                                    Team 2
                                                </option>

                                            </select>

                                        </td>

                                        <td>

                                            <input type="text"
                                                   name="observation_visual_100">

                                        </td>

                                    </tr>


                                    <!-- 7 -->

                                    <tr class="qc-large">

                                        <td>
                                            Sampling as per the
                                            sampling plan
                                            Doc. No. SIS/R Rev.02
                                        </td>

                                        <td class="qc-center">

                                            <select name="sampling_team_member" class="form-control input-sm">

                                                <option value="">
                                                    Team member drop down
                                                    of the above selected team
                                                </option>

                                            </select>

                                        </td>

                                        <td>

                                            <input type="text"
                                                   name="observation_sampling">

                                        </td>

                                    </tr>


                                    <!-- 8 -->

                                    <tr>

                                        <td>
                                            Rework material -
                                            (Yes or No) &amp; if Yes
                                            Rework Challan No. should
                                            prefill in the
                                        </td>

                                        <td class="qc-center">

                                            <select name="rework_material" class="form-control input-sm">

                                                <option value="">
                                                    Yes / No
                                                </option>

                                                <option value="Yes">
                                                    Yes
                                                </option>

                                                <option value="No">
                                                    No
                                                </option>

                                            </select>

                                        </td>

                                        <td>

                                            <input type="text"
                                                   name="observation_rework">

                                        </td>

                                    </tr>


                                    <!-- REWORK CHALLAN -->

                                    <tr>

                                        <td></td>

                                        <td class="qc-center">

                                            Rework<br>
                                            challan no

                                        </td>

                                        <td>

                                            <input type="text"
                                                   name="rework_challan_no">

                                        </td>

                                    </tr>


                                    <!-- REJECTION -->

                                    <tr>

                                        <td>
                                            Rejection Material
                                        </td>

                                        <td class="qc-center">
                                            Text Box
                                        </td>

                                        <td>

                                            <textarea
                                                name="rejection_material"></textarea>

                                        </td>

                                    </tr>


                                    <!-- PACKING -->

                                    <tr>

                                        <td>
                                            Packing
                                        </td>

                                        <td class="qc-center">

                                            <select name="packing_team" class="form-control input-sm">

                                                <option value="">
                                                    Team Drop Down
                                                </option>

                                                <option value="Team 1">
                                                    Team 1
                                                </option>

                                                <option value="Team 2">
                                                    Team 2
                                                </option>

                                            </select>

                                        </td>

                                        <td>

                                            <input type="text"
                                                   name="observation_packing">

                                        </td>

                                    </tr>


                                    <!-- REVIEW -->

                                    <tr>

                                        <td>
                                            Review &amp; verify check list
                                        </td>

                                        <td class="qc-center">

                                            <input type="text"
                                                   name="review_type"
                                                   placeholder="Text Box">

                                        </td>

                                        <td>

                                            <input type="text"
                                                   name="observation_review">

                                        </td>

                                    </tr>


                                    <!-- PRE EXPORT -->

                                    <tr>

                                        <td>
                                            Pre Exports details
                                        </td>

                                        <td></td>

                                        <td>

                                            <textarea
                                                name="pre_export_details"></textarea>

                                        </td>

                                    </tr>


                                    <!-- SEA / AIR -->

                                    <tr>

                                        <td>
                                            By Sea/By Air
                                        </td>

                                        <td></td>

                                        <td>

                                            <select name="transport_mode" class="form-control input-sm">

                                                <option value="">
                                                    Select
                                                </option>

                                                <option value="Sea">
                                                    By Sea
                                                </option>

                                                <option value="Air">
                                                    By Air
                                                </option>

                                            </select>

                                        </td>

                                    </tr>


                                    <!-- VERIFIED -->

                                    <tr>

                                        <td>
                                            Verified By
                                        </td>

                                        <td></td>

                                        <td>

                                            <input type="text"
                                                   name="verified_by">

                                        </td>

                                    </tr>


                                    <!-- FOOTER -->

                                    <tr class="qc-footer">

                                        <td>
                                            <div class="footer-field">
                                                <label>Verified by :-</label>
                                                <input type="text"
                                                       name="verified_by_footer"
                                                       class="footer-input">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="footer-field">
                                                <label>Name from form or print</label>
                                                <input type="text"
                                                       name="verified_name"
                                                       class="footer-input">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="footer-field">
                                                <label>Doc. No.</label>
                                                <input type="text"
                                                       name="doc_no"
                                                       value="SQ/PR/055 Rev. 00"
                                                       class="footer-input">
                                            </div>
                                        </td>

                                    </tr>

                                </table>


                                <br>


                                <!-- BUTTONS -->

                                <div class="text-right qc-save-area">

                                    <button type="submit"
                                            class="btn btn-primary">

                                        <i class="fa fa-save"></i>
                                        Save

                                    </button>


                                    <button type="reset"
                                            class="btn btn-default">

                                        Reset

                                    </button>

                                </div>


                            </form>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </section>

</div>


<script type="text/javascript"
        src="<?php echo base_url(); ?>assets/js/common.js"
        charset="utf-8">
</script>