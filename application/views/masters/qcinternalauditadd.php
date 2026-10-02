                            <style>
                              .qc-table {
                                /* width: 100%; */
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
                                /* border: 0; */
                                /* outline: none; */
                                /* background: transparent; */
                                /* color: #000; */
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
                            <div class="content-wrapper">
                              <!-- Content Header -->
                              <section class="content-header">
                                <h1>
                                  <i class="fa fa-check-square-o"></i> QC Internal Audit <small> Add, Edit, Delete </small>
                                </h1>
                              </section>
                              <section class="content">
                                <!-- Breadcrumb -->
                                <div class="row">
                                  <div class="col-xs-6 text-left">
                                    <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                                      <li class="completed">
                                        <a href="javascript:void(0);"> Masters </a>
                                      </li>
                                      <li class="active">
                                        <a href="javascript:void(0);"> QC Internal Audit </a>
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
                                         <form role="form" id="qcinternalauditaddform" action="<?php echo base_url() ?>qcinternalauditaddform" method="post" role="form">
                                            <div class="row">
                                              <div class="col-md-6">
                                                <table class="qc-table">
                                                  <tr>
                                                    <td class="qc-label"> ID No.<span class="required">*</span></td>
                                                    <td style="width:180px;">
                                                      <input type="text" name="qc_internal_audit_no" id="qc_internal_audit_no" value="<?=$audit_auto_no;?>">
                                                    </td>
                                                  </tr>
                                                  <tr> <?php $current_date = date('Y-m-d');?> <td class="qc-label"> Date </td>
                                                    <td>
                                                      <input type="date" name="qc_internal_audit_date" id="qc_internal_audit_date" value="<?php echo $current_date;?>">
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class="qc-label">Buyer Name <span class="required">*</span></td>
                                                    <td>
                                                      <select name="buyer_name_qc_audit" id="buyer_name_qc_audit" class="form-control input-sm">
                                                        <option st-id="" value="">Select Buyer Name</option> <?php foreach ($buyerList as $key => $value) {?> 
                                                        <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$fetchALLitemList[0]['pre_buyer_name']){ echo 'selected';} ?>> <?php echo $value['buyer_name']; ?> </option> <?php } ?>
                                                      </select>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class="qc-label">Buyer P.O. No.<span class="required">*</span></td>
                                                    <td>
                                                      <select name="buyer_po_number_qc_audit" id="buyer_po_number_qc_audit" class="form-control input-sm">
                                                        <option value="">Select Buyer PO Number</option>
                                                      </select>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class="qc-label">FG Part No.<span class="required">*</span></td>
                                                    <td>
                                                      <select class="fg_part_no_qc_audit_getincoming" name="fg_part_no_qc_audit" id="fg_part_no_qc_audit" class="form-control input-sm">
                                                        <option value="">Select FG Part No </option>
                                                      </select>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class="qc-label"> FG Part Description </td>
                                                    <td>
                                                      <input type="text" name="og_part_id" id="og_part_id">
                                                      <input type="text" name="fg_part_description_qc_audit" id="fg_part_description_qc_audit">
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class="qc-label"> Buyer P.O. Qty </td>
                                                    <td>
                                                      <input type="number" name="buyer_po_qty_qc_audit" id="buyer_po_qty_qc_audit">
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class="qc-label"> Vendor Name </td>
                                                    <td>
                                                      <input type="text" name="vendor_name_qc_audit" id="vendor_name_qc_audit">
                                                      <input type="text" name="vendor_id_qc_audit" id="vendor_id_qc_audit">
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class="qc-label"> Vendor P.O. No.</td>
                                                    <td>
                                                      <input type="text" name="vendor_po_no_qc_audit" id="vendor_po_no_qc_audit">
                                                      <input type="text" name="vendor_po_id_qc_audit" id="vendor_po_id_qc_audit">
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td class="qc-label">Vendor P.O. Qty</td>
                                                    <td>
                                                      <input type="number" id="vendor_po_qty_qc_audit" name="vendor_po_qty_qc_audit">
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
                                                      <b> Dispatch Qty (in Pcs) </b>
                                                    </td>
                                                    <td style="width:292px;">
                                                      <input type="text" id="dispatch_qty_qc_adit" name="dispatch_qty_qc_adit" placeholder="Buyer Invoice qty from packaging with invoice no">
                                                    </td>
                                                  </tr>
                                                </table>
                                                <br>
                                                <br>
                                              </div>
                                              <div class="col-md-6">
                                                <div id="incoming_data_qc_audit"></div>
                                              </div>
                                            </div>
                                            <!-- =========================================
                                                    CHECK POINTS
                                                ========================================== -->
                                            <table class="qc-table" style="width: 100%">
                                              <tr>
                                                <th> Check points </th>
                                                <th> Resposible person </th>
                                                <th> Observation </th>
                                              </tr>
                                              <!-- 1 -->
                                              <tr>
                                                <td> Verify the received material </td>
                                                <td>
                                                  <input type="text" name="input_1">
                                                </td>
                                                <td>
                                                  <input type="text" name="input_2">
                                                </td>
                                              </tr>
                                              <!-- 2 -->
                                              <tr class="qc-tall">
                                                <td> Enter the incoming details from the invoice details </td>
                                                <td>
                                                  <input type="text" name="input_3">
                                                </td>
                                                <td>
                                                  <input type="text" name="input_4">
                                                </td>
                                              </tr>
                                              <!-- 3 -->
                                              <tr class="qc-tall">
                                                <td> Visual checking of material as per the invoice declaration &amp; check if it is matching </td>
                                                <td>
                                                  <input type="text" name="input_5">
                                                </td>
                                                <td>
                                                  <input type="text" name="input_6">
                                                </td>
                                              </tr>
                                              <!-- 4 -->
                                              <tr>
                                                <td> Additional Process </td>
                                                <td class="qc-center">
                                                  <input type="text" name="input_7">
                                                </td>
                                                <td>
                                                  <input type="text" name="input_8">
                                                </td>
                                              </tr>
                                              <!-- 5 -->
                                              <tr class="qc-tall">
                                                <td> Dimensions report Doc. No.SID/RI34 Rev. 13 </td>
                                                <td>
                                                  <input type="text" name="input_9">
                                                </td>
                                                <td>
                                                  <input type="text" name="input_10">
                                                </td>
                                              </tr>
                                              <!-- 6 -->
                                              <tr class="qc-tall">
                                                <td> Visual 100% checking </td>
                                                <td class="qc-center">
                                                 <input type="text" name="input_11">
                                                </td>
                                                <td>
                                                  <input type="text" name="input_12">
                                                </td>
                                              </tr>
                                              <!-- 7 -->
                                              <tr class="qc-large">
                                                <td> Sampling as per the sampling plan Doc. No. SIS/R Rev.02 </td>
                                                <td class="qc-center">
                                                 <input type="text" name="input_13">
                                                </td>
                                                <td>
                                                  <input type="text" name="input_14">
                                                </td>
                                              </tr>
                                              <!-- 8 -->
                                              <tr>
                                                <td> Rework material - (Yes or No) &amp; if Yes Rework Challan No.</td>
                                                <td class="qc-center">
                                                  <select name="input_15" class="form-control input-sm">
                                                    <option value=""> Yes / No </option>
                                                    <option value="Yes"> Yes </option>
                                                    <option value="No"> No </option>
                                                  </select>
                                                </td>
                                                <td>
                                                  <input type="text" name="input_16">
                                                </td>
                                              </tr>
                                              <!-- REWORK CHALLAN -->
                                              <tr>
                                                <td>Dispatch Invoice Generated By</td>
                                                <td class="qc-center">
                                                  <input type="text" name="input_17">
                                                </td>
                                                <td>
                                                  <input type="text" name="input_18">
                                                </td>
                                              </tr>
                                              <!-- REJECTION -->
                                              <tr>
                                                <td> Rejection Material </td>
                                                <td class="qc-center">
                                                  <textarea name="input_19"></textarea>
                                                </td>
                                                <td>
                                                  <textarea name="input_20"></textarea>
                                                </td>
                                              </tr>
                                              <!-- PACKING -->
                                              <tr>
                                                <td> Packing </td>
                                                <td class="qc-center">
                                                 <input type="text" name="input_21">
                                                </td>
                                                <td>
                                                  <input type="text" name="input_22">
                                                </td>
                                              </tr>
                                              <!-- REVIEW -->
                                              <tr>
                                                <td> Review &amp; verify check list </td>
                                                <td class="qc-center">
                                                  <input type="text" name="input_23">
                                                </td>
                                                <td>
                                                  <input type="text" name="input_24">
                                                </td>
                                              </tr>
                                              <!-- PRE EXPORT -->
                                              <tr>
                                                <td> Pre Exports details </td>
                                                <td>
                                                  <textarea name="input_25"></textarea>
                                                </td>
                                                <td>
                                                  <textarea name="input_26"></textarea>
                                                </td>
                                              </tr>
                                              <!-- SEA / AIR -->
                                              <tr>
                                                <td> By Sea/By Air </td>
                                                <td>
                                                  <input type="text" name="input_27">
                                                </td>
                                                <td>
                                                  <select name="input_28" class="form-control input-sm">
                                                    <option value=""> Select </option>
                                                    <option value="Sea"> By Sea </option>
                                                    <option value="Air"> By Air </option>
                                                  </select>
                                                </td>
                                              </tr>
                                              <!-- FOOTER -->
                                              <tr class="qc-footer">
                                                <td>
                                                  <div class="footer-field">
                                                    <label> Verified by :- </label>
                                                    
                                                  </div>
                                                </td>
                                                <td>
                                                  <div class="footer-field">
                                                   <input type="text" name="input_29" class="footer-input">
                                                  </div>
                                                </td>
                                                <td>
                                                  <div class="footer-field">
                                                    <label> Doc. No. </label>
                                                    <input type="text" name="input_30" value="SQ/PR/O55 Rev. 00" class="footer-input">
                                                  </div>
                                                </td>
                                              </tr>
                                            </table>
                                            <br>
                                            <!-- BUTTONS -->
                                            <div class="text-right qc-save-area">
                                              <button type="submit" id="saveqcinternalaudit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
                                              <input type="button" onclick="location.href = '<?php echo base_url() ?>qcinternalaudit'" class="btn btn-default" value="Back" />
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </section>
                            </div>
                            <script type="text/javascript" src="assets/js/common.js" charset="utf-8">
                            </script>