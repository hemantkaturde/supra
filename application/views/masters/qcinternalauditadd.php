  <style>
                            .qc-form-table {
                                width: 100%;
                                border-collapse: collapse;
                                font-size: 12px;
                                color: #000;
                            }

                            .qc-form-table th,
                            .qc-form-table td {
                                border: 1px solid #000 !important;
                                padding: 3px 5px;
                                vertical-align: middle;
                            }

                            .qc-form-table input,
                            .qc-form-table select,
                            .qc-form-table textarea {
                                width: 100%;
                                border: 0;
                                outline: none;
                                background: transparent;
                                font-size: 12px;
                                color: #000;
                                padding: 2px;
                            }

                            .qc-form-table input,
                            .qc-form-table select {
                                height: 24px;
                            }

                            .qc-form-table textarea {
                                min-height: 28px;
                                resize: vertical;
                            }

                            .qc-label {
                                width: 125px;
                                font-weight: normal;
                            }

                            .qc-center {
                                text-align: center;
                            }

                            .qc-section-title {
                                text-align: center;
                                font-weight: bold;
                                font-size: 13px;
                                padding: 6px !important;
                            }

                            .qc-checkpoint {
                                width: 57%;
                            }

                            .qc-responsible {
                                width: 20%;
                            }

                            .qc-observation {
                                width: 23%;
                            }

                            .qc-tall td {
                                height: 40px;
                            }

                            .qc-large td {
                                height: 52px;
                            }

                            .qc-verified td {
                                height: 40px;
                                font-weight: bold;
                            }

                            .qc-print-btn {
                                margin-bottom: 10px;
                            }

                            @media print {
                                .qc-print-btn {
                                    display: none;
                                }

                                .qc-form-table {
                                    font-size: 11px;
                                }

                                .qc-form-table input,
                                .qc-form-table select,
                                .qc-form-table textarea {
                                    font-size: 11px;
                                }
                            }
                            </style>



<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <h1>
            <i class="fa fa-check-square-o"></i> QC Internal Audit
            <small>Add, Edit, Delete</small>
        </h1>
    </section>

    <section class="content">
        <!-- Breadcrumb + Add Button -->
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

        <!-- Table -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="panel-body">

                          

                            <!-- TOP ACTION -->
                            <div class="row qc-print-btn">
                                <div class="col-sm-12">
                                    <!-- <span style="margin-right:30px;">add edit del</span> -->

                                    <!-- <button type="button" class="btn btn-default btn-xs" onclick="window.print();">
                                        <i class="fa fa-print"></i> Print
                                    </button> -->
                                </div>
                            </div>


                            <!-- MAIN FORM -->
                            <form id="qcIncomingMaterialForm" method="post" action="">

                                <!-- =========================
             HEADER DETAILS
        ========================== -->

                                <table class="qc-form-table">

                                    <tr>
                                        <td class="qc-label">ID No.</td>
                                        <td style="width:170px;">
                                            <input type="text" name="id_no" value="SQPCA2526001">
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td class="qc-label">Date</td>
                                        <td>
                                            <input type="date" name="date">
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td class="qc-label">Buyer Name</td>
                                        <td>
                                            <select name="buyer_name">
                                                <option value="">Drop Down</option>
                                                <option value="Buyer 1">Buyer 1</option>
                                                <option value="Buyer 2">Buyer 2</option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td class="qc-label">Buyer P.O. No.</td>
                                        <td>
                                            <select name="buyer_po_no">
                                                <option value="">Drop Down - Listing</option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td class="qc-label">FG Part No.</td>
                                        <td>
                                            <select name="fg_part_no">
                                                <option value="">Drop Down - Listing</option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td class="qc-label">FG Part Description</td>
                                        <td>
                                            <input type="text" name="fg_part_description">
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td class="qc-label">Buyer P.O. Qty</td>
                                        <td>
                                            <input type="number" name="buyer_po_qty">
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td class="qc-label">Vendor Name</td>
                                        <td>
                                            <input type="text" name="vendor_name">
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td class="qc-label">Vendor P.O. No.</td>
                                        <td>
                                            <input type="text" name="vendor_po_no">
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td class="qc-label">Vendor P.O. Qty</td>
                                        <td>
                                            <input type="number" name="vendor_po_qty">
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td class="qc-label">FG Received Qty</td>
                                        <td>
                                            <input type="number" name="fg_received_qty">
                                        </td>
                                        <td></td>
                                    </tr>


                                    <!-- LOT -->
                                    <tr>
                                        <td class="qc-label">Lot No.</td>
                                        <td>Lot Qty</td>
                                        <td>Invoice. No.</td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <input type="text" name="lot_no">
                                        </td>

                                        <td>
                                            <input type="number" name="lot_qty">
                                        </td>

                                        <td>
                                            <input type="text" name="invoice_no">
                                        </td>
                                    </tr>

                                </table>


                                <br>


                                <!-- DISPATCH QTY -->

                                <table class="qc-form-table">

                                    <tr>
                                        <td style="width:125px;">
                                            <b>Dispatch Qty (in Pcs)</b>
                                        </td>

                                        <td>
                                            <input type="number" name="dispatch_qty"
                                                placeholder="Buyer Invoice qty from packaging with invoice no">
                                        </td>
                                    </tr>

                                </table>


                                <br><br>


                                <!-- =========================
             CHECK POINTS
        ========================== -->

                                <table class="qc-form-table">

                                    <colgroup>
                                        <col class="qc-checkpoint">
                                        <col class="qc-responsible">
                                        <col class="qc-observation">
                                    </colgroup>


                                    <tr>
                                        <th colspan="3" class="qc-section-title">

                                            Check points (This will be Hard Code)

                                        </th>
                                    </tr>


                                    <!-- 1 -->

                                    <tr>
                                        <td>
                                            Verify the received material
                                        </td>

                                        <td></td>

                                        <td>
                                            <input type="text" name="observation_received_material">
                                        </td>
                                    </tr>


                                    <!-- 2 -->

                                    <tr class="qc-tall">

                                        <td>
                                            Enter the incoming details from the invoice details
                                        </td>

                                        <td></td>

                                        <td>
                                            <input type="text" name="observation_invoice_details">
                                        </td>

                                    </tr>


                                    <!-- 3 -->

                                    <tr class="qc-tall">

                                        <td>
                                            Visual checking of material as per the invoice declaration
                                            &amp; check if it is matching
                                        </td>

                                        <td></td>

                                        <td>
                                            <input type="text" name="observation_visual_check">
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
                                            <input type="text" name="observation_additional_process">
                                        </td>

                                    </tr>


                                    <!-- 5 -->

                                    <tr class="qc-tall">

                                        <td>
                                            Dimensions report Doc. No.SID/RI34 Rev. 13
                                        </td>

                                        <td></td>

                                        <td>
                                            <input type="text" name="observation_dimensions">
                                        </td>

                                    </tr>


                                    <!-- 6 -->

                                    <tr class="qc-tall">

                                        <td>
                                            Visual 100% checking
                                        </td>

                                        <td class="qc-center">

                                            <select name="visual_team">
                                                <option value="">Team Drop Down</option>
                                                <option value="Team 1">Team 1</option>
                                                <option value="Team 2">Team 2</option>
                                            </select>

                                        </td>

                                        <td>
                                            <input type="text" name="observation_visual_100">
                                        </td>

                                    </tr>


                                    <!-- 7 -->

                                    <tr class="qc-large">

                                        <td>
                                            Sampling as per the sampling plan
                                            Doc. No. SIS/R Rev.02
                                        </td>

                                        <td class="qc-center">

                                            <select name="sampling_team_member">

                                                <option value="">
                                                    Team member drop down of the above selected team
                                                </option>

                                            </select>

                                        </td>

                                        <td>
                                            <input type="text" name="observation_sampling">
                                        </td>

                                    </tr>


                                    <!-- 8 REWORK -->

                                    <tr>

                                        <td>
                                            Rework material - (Yes or No) &amp; if Yes
                                            Rework Challan No. should prefill in the
                                        </td>

                                        <td class="qc-center">

                                            <select name="rework_material">

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
                                            <input type="text" name="observation_rework">
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

                                            <input type="text" name="rework_challan_no">

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
                                            <textarea name="rejection_material"></textarea>
                                        </td>

                                    </tr>


                                    <!-- PACKING -->

                                    <tr>

                                        <td>
                                            Packing
                                        </td>

                                        <td class="qc-center">

                                            <select name="packing_team">

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

                                            <input type="text" name="observation_packing">

                                        </td>

                                    </tr>


                                    <!-- REVIEW -->

                                    <tr>

                                        <td>
                                            Review &amp; verify check list
                                        </td>

                                        <td class="qc-center">

                                            <input type="text" name="review_checklist_type" placeholder="Text Box">

                                        </td>

                                        <td>

                                            <input type="text" name="observation_review">

                                        </td>

                                    </tr>


                                    <!-- PRE EXPORT -->

                                    <tr>

                                        <td>
                                            Pre Exports details
                                        </td>

                                        <td></td>

                                        <td>

                                            <textarea name="pre_export_details"></textarea>

                                        </td>

                                    </tr>


                                    <!-- SEA AIR -->

                                    <tr>

                                        <td>
                                            By Sea/By Air
                                        </td>

                                        <td></td>

                                        <td>

                                            <select name="transport_mode">

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


                                    <!-- VERIFIED BY -->

                                    <tr>

                                        <td>
                                            Verified By
                                        </td>

                                        <td></td>

                                        <td>

                                            <input type="text" name="verified_by">

                                        </td>

                                    </tr>


                                    <!-- FOOTER -->

                                    <tr class="qc-verified">

                                        <td>
                                            Verified by : –
                                        </td>

                                        <td class="qc-center">
                                            name from form or print
                                        </td>

                                        <td class="qc-center">
                                            Doc. No. SQ/PR/055 Rev. 00
                                        </td>

                                    </tr>

                                </table>


                                <br>

                                <div class="text-right">

                                    <button type="submit" class="btn btn-primary">

                                        <i class="fa fa-save"></i>
                                        Save

                                    </button>

                                    <button type="reset" class="btn btn-default">

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

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8">
</script>