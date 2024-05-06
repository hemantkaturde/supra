<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Sales Tracking Report
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Sales Tracking Report</a></li>
                </ul>
            </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Add Sales Tracking Report Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewchaform" action="<?php echo base_url() ?>addnewchaform" method="post" role="form">
                            <div class="box-body">

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cha_forworder">INV NO.<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="cha_forworder" name="cha_forworder" required>
                                            <p class="error cha_forworder_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="clearance_done_by">INV.DATE</label>
                                            <input type="text" class="form-control" id="clearance_done_by" name="clearance_done_by">
                                            <p class="error clearance_done_by_error"></p>
                                        </div>
                                    </div>

                        
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="payment_terms">BUYER NAME</label>
                                            <input type="text" class="form-control" id="payment_terms" name="payment_terms">
                                            <p class="error payment_terms_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cha_forworder">Buyer Address<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="cha_forworder" name="cha_forworder" required>
                                            <p class="error cha_forworder_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="clearance_done_by">INV. CURRENCY</label>
                                            <input type="text" class="form-control" id="clearance_done_by" name="clearance_done_by">
                                            <p class="error clearance_done_by_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cha_forworder">Cha Forwarder<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="cha_forworder" name="cha_forworder" required>
                                            <p class="error cha_forworder_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="clearance_done_by">Clearance Done By</label>
                                            <input type="text" class="form-control" id="clearance_done_by" name="clearance_done_by">
                                            <p class="error clearance_done_by_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                                <label for="mode_of_Shipment">Mode of Shipment</label>
                                                <select class="form-control" name="mode_of_Shipment" id="mode_of_Shipment">
                                                    <option st-id="" value="">select Mode of Shipment</option>
                                                    <option st-id="" value="Sea">Sea</option>
                                                    <option st-id="" value="Air">Air</option>
                                                </select>
                                            <p class="error mode_of_Shipment_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="payment_terms">Payment Terms</label>
                                            <input type="text" class="form-control" id="payment_terms" name="payment_terms">
                                            <p class="error payment_terms_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inv_amount">Inv.Amount</label>
                                              <input type="text" class="form-control" id="inv_amount" name="inv_amount">
                                            <p class="error inv_amount_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="igst_value">Igst Value</label>
                                            <input type="text" class="form-control" id="igst_value" name="igst_value">
                                            <p class="error igst_value_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="igst_rcved_amt">Igst Rcved Amt</label>
                                            <input type="text" class="form-control" id="igst_rcved_amt" name="igst_rcved_amt">
                                            <p class="error igst_rcved_amt_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="igst_rcved_date">Igst Rcved Date</label>
                                            <input type="text" class="form-control" id="igst_rcved_date" name="igst_rcved_date">
                                            <p class="error igst_rcved_date_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="no_of_ctns">No. Of Ctns</label>
                                            <input type="text" class="form-control" id="no_of_ctns" name="no_of_ctns" required>
                                            <p class="error no_of_ctns_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="port_code">Port Code</label>
                                            <input type="text" class="form-control" maxlength="12"  id="port_code" name="port_code">
                                            <p class="error port_code_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="port_of_discharge">Port Of Discharge</label>
                                            <input type="text" class="form-control"  id="port_of_discharge" name="port_of_discharge">
                                            <p class="error port_of_discharge_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sb_no">Sb.No</label>
                                            <input type="text" class="form-control" id="sb_no" name="sb_no">
                                            <p class="error sb_no_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sb_date">Sb. Date</label>
                                            <input type="text" class="form-control" id="sb_date" name="sb_date">
                                            <p class="error sb_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fob_amount_rs">Fob Amount (Rs)</label>
                                            <input type="text" class="form-control" id="fob_amount_rs" name="fob_amount_rs">
                                            <p class="error fob_amount_rs_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="drawback">Drawback (Rs)</label>
                                            <input type="text" class="form-control" id="drawback" name="drawback">
                                            <p class="error drawback_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bl_awb_no">BL/Awb No</label>
                                            <input type="text" class="form-control" id="bl_awb_no" name="bl_awb_no">
                                            <p class="error bl_awb_no_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bl_awb_date">BL/Awb Date</label>
                                            <input type="text" class="form-control" id="bl_awb_date" name="bl_awb_date">
                                            <p class="error bl_awb_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="brc_number_and_dt">Brc Number & Date</label>
                                            <input type="text" class="form-control" id="brc_number_and_dt" name="brc_number_and_dt">
                                            <p class="error brc_number_and_dt_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="transaction_id">Transaction Id</label>
                                            <input type="text" class="form-control" id="transaction_id" name="transaction_id" required>
                                            <p class="error transaction_id_error"></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="brc_value">Brc Value</label>
                                            <input type="text" class="form-control" id="brc_value" name="brc_value">
                                            <p class="error brc_value_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="foreign_bank_charges">Foreign Bank Charges</label>
                                            <input type="text" class="form-control" id="foreign_bank_charges" name="foreign_bank_charges">
                                            <p class="error foreign_bank_charges_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="foreign_bank_charges_in_inr">Foreign Bank Charges In Inr</label>
                                            <input type="text" class="form-control" id="foreign_bank_charges_in_inr" name="foreign_bank_charges_in_inr">
                                            <p class="error foreign_bank_charges_in_inr_error"></p>
                                        </div>
                                    </div>

                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="carrier_bill_number ">Carrier Bill Number</label>
                                            <input type="text" class="form-control" id="carrier_bill_number" name="carrier_bill_number">
                                            <p class="error carrier_bill_number_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="carrier_bill_date">Carrier Bill Date</label>
                                            <input type="text" class="form-control" id="carrier_bill_date" name="carrier_bill_date">
                                            <p class="error carrier_bill_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bill_amt">Bill Amt</label>
                                            <input type="text" class="form-control" id="bill_amt" name="bill_amt">
                                            <p class="error bill_amt_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bill_paid_amount">Bill Paid Amount</label>
                                            <input type="text" class="form-control" id="bill_paid_amount" name="bill_paid_amount">
                                            <p class="error bill_paid_amount_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tds_amt">Tds Amt </label>
                                            <input type="text" class="form-control" id="tds_amt" name="tds_amt">
                                            <p class="error tds_amt_error"></p>
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cheque_no">Cheque No</label>
                                            <input type="text" class="form-control" id="cheque_no" name="cheque_no">
                                            <p class="error cheque_no_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bill_paid_date">Bill Paid Date</label>
                                            <input type="text" class="form-control" id="bill_paid_date" name="bill_paid_date">
                                            <p class="error bill_paid_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dbk_recd_amount">Dbk Recd Amount</label>
                                            <input type="text" class="form-control" id="dbk_recd_amount" name="dbk_recd_amount">
                                            <p class="error dbk_recd_amount_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dbk_recd_date">Dbk Recd Date</label>
                                            <input type="text" class="form-control" id="dbk_recd_date" name="dbk_recd_date">
                                            <p class="error dbk_recd_date_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="rodtep">Rodtep</label>
                                            <input type="text" class="form-control" id="rodtep" name="rodtep">
                                            <p class="error Rodtep_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="escript_number_license_no">Escript Number (License No)</label>
                                            <input type="text" class="form-control" id="escript_number_license_no" name="escript_number_license_no">
                                            <p class="error escript_number_license_no_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="payment_recvd_date">Payment Recvd Date</label>
                                            <input type="text" class="form-control" id="payment_recvd_date" name="payment_recvd_date" required>
                                            <p class="error payment_recvd_date_error"></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="payment_rcivd_amt">Payment Rcivd Amt</label>
                                            <input type="text" class="form-control" id="payment_rcivd_amt" name="payment_rcivd_amt">
                                            <p class="error payment_rcivd_amt_error"></p>
                                        </div>
                                    </div>
                                    
                               
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="realised_amt_in_inr">Realised Amt In Inr</label>
                                            <input type="text" class="form-control" id="realised_amt_in_inr" name="realised_amt_in_inr">
                                            <p class="error realised_amt_in_inr_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bank_charges_inr">Bank Charges Inr</label>
                                            <input type="text" class="form-control" id="bank_charges_inr" name="bank_charges_inr">
                                            <p class="error bank_charges_inr_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="credit_note_number">Credit Note Number</label>
                                             <input type="text" class="form-control" id="credit_note_number" name="credit_note_number">
                                            <p class="error credit_note_number_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="credit_note_date">Credit Note Date</label>
                                             <input type="text" class="form-control" id="credit_note_date" name="credit_note_date">
                                            <p class="error credit_note_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="receivable_amt">Receivable Amt</label>
                                            <input type="text" class="form-control"  id="receivable_amt" name="receivable_amt">
                                            <p class="error receivable_amt_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="difference">Difference</label>
                                            <input type="text" class="form-control" id="difference" name="difference">
                                            <p class="error difference_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="credit_note_reason">Credit Note Reason</label>
                                            <input type="text" class="form-control" id="credit_note_reason" name="credit_note_reason">
                                            <p class="error credit_note_reason_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="debit_note_number">Debit Note Number</label>
                                            <input type="text" class="form-control" id="debit_note_number" name="debit_note_number">
                                            <p class="error debit_note_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="debit_note_date">Debit Note Date</label>
                                            <input type="text" class="form-control" id="debit_note_date" name="debit_note_date">
                                            <p class="error debit_note_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="difference_debit_note_amt">Difference / Debit Note Amt</label>
                                            <input type="text" class="form-control" id="difference_debit_note_amt" name="difference_debit_note_amt">
                                            <p class="error difference_debit_note_amt_error"></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="debit_amount_reason">Debit Amount Reason</label>
                                            <input type="text" class="form-control" id="debit_amount_reason" name="debit_amount_reason">
                                            <p class="error debit_amount_reason_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exchange_rate_as_per_sb">Exchange Rate As Per Sb</label>
                                            <input type="text" class="form-control" id="exchange_rate_as_per_sb" name="exchange_rate_as_per_sb">
                                            <p class="error exchange_rate_as_per_sb_error"></p>
                                        </div>
                                    </div>
                                </div>

                              
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewsalestracking" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>salestrackingreport'" class="btn btn-default" value="Back" />
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>