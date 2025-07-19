<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> View Sales Tracking Report
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">View Sales Tracking Report</a></li>
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
                            <h3 class="box-title">View Tracking Report Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addsalestrackingreport" action="<?php echo base_url() ?>addsalestrackingreport" method="post" role="form">
                            <div class="box-body">
                            
                                <!-------------------------------------------------------------------------------------->
                                <input  readonly type="hidden" class="form-control" id="salestracking_id"  value="<?=$getsalestrackingdetailsforedit['id'];?>" name="salestracking_id" readonly>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="invoice_number">INV NO <span class="required">*</span></label>
                                                <select  readonly class="form-control get_numberofcartoons" name="invoice_number" id="invoice_number">
                                                            <option st-id="" value="">Select Part Number</option>
                                                                <?php foreach ($invoicenumberfromPackaging as $key => $value) {?>
                                                                    <option value="<?php echo $value['id']; ?>" <?php if($getsalestrackingdetailsforedit['invoice_number']==$value['id']){ echo 'selected';} ?>><?php echo $value['buyer_invoice_number']; ?></option>
                                                        <?php } ?>
                                                    <p class="error invoice_number_error"></p>
                                                </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="invoice_date">INV DATE</label>
                                            <input  readonly type="text" class="form-control" id="invoice_date" name="invoice_date" readonly>
                                            <p class="error invoice_date_error"></p>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="buyer_PO">BUYER PO</label>
                                            <input  readonly type="text" class="form-control" id="buyer_PO" name="buyer_PO">
                                            <p class="error buyer_PO_error"></p>
                                        </div>
                                    </div> -->
                        
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="buyer_name">BUYER NAME</label>
                                            <input  readonly type="text" class="form-control" id="buyer_name" name="buyer_name" readonly>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="buyer_address">Buyer Address</label>
                                            <input  readonly type="text" class="form-control" id="buyer_address" name="buyer_address" readonly>
                                            <p class="error buyer_address_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="invoice_currency">INV. CURRENCY</label>
                                            <input  readonly type="text" class="form-control" id="invoice_currency" name="invoice_currency" readonly >
                                            <p class="error invoice_currency_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cha_forworder">CHA Forwarder<span class="required">*</span></label>
                                                 <select  readonly class="form-control" name="cha_forworder" id="cha_forworder">
                                                            <option st-id="" value="">Select CHA Forwarder</option>
                                                                <?php foreach ($getchamaster as $key => $value) {?>
                                                            <option value="<?php echo $value['cha_id']; ?>"  <?php if($getsalestrackingdetailsforedit['CHA_forwarder']==$value['cha_id']){ echo 'selected';} ?>><?php echo $value['cha_name']; ?></option>
                                                        <?php } ?>
                                                    <p class="error cha_forworder_error"></p>
                                                </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="clearance_done_by">Clearance Done By</label>
                                            <input  readonly type="text" class="form-control" id="clearance_done_by" value="<?=$getsalestrackingdetailsforedit['clearance_done_by'] ?>" name="clearance_done_by">
                                            <p class="error clearance_done_by_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                                <label for="mode_of_Shipment">Mode of Shipment</label>
                                                <select  readonly class="form-control" name="mode_of_Shipment" id="mode_of_Shipment">
                                                    <option st-id="" value="">select Mode of Shipment</option>
                                                    <option st-id="" value="Sea" <?php if($getsalestrackingdetailsforedit['mode_of_shipment']=='Sea'){ echo 'selected';} ?>>Sea</option>
                                                    <option st-id="" value="Air" <?php if($getsalestrackingdetailsforedit['mode_of_shipment']=='Air'){ echo 'selected';} ?>>Air</option>
                                                </select>
                                            <p class="error mode_of_Shipment_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="payment_terms">Payment Terms</label>
                                            <input  readonly type="text" class="form-control" id="payment_terms" value="<?=$getsalestrackingdetailsforedit['payment_terms']?>" name="payment_terms">
                                            <p class="error payment_terms_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inv_amount">Inv.Amount</label>
                                              <input  readonly type="text" class="form-control" id="inv_amount" value="<?=$getsalestrackingdetailsforedit['inv_amount']?>"  name="inv_amount">
                                            <p class="error inv_amount_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="igst_value">Igst Value</label>
                                            <input  readonly type="text" class="form-control" id="igst_value"  value="<?=$getsalestrackingdetailsforedit['igst_value']?>" name="igst_value">
                                            <p class="error igst_value_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="igst_rcved_amt">Igst Rcved Amt</label>
                                            <input  readonly type="text" class="form-control" id="igst_rcved_amt"  value="<?=$getsalestrackingdetailsforedit['igst_rcved_amt']?>" name="igst_rcved_amt">
                                            <p class="error igst_rcved_amt_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="igst_rcved_date">Igst Rcved Date</label>
                                            <input  readonly type="text" class="form-control datepicker" id="igst_rcved_date"  value="<?=$getsalestrackingdetailsforedit['igst_rcved_date']?>"  name="igst_rcved_date">
                                            <p class="error igst_rcved_date_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="no_of_ctns">No. Of Ctns</label>
                                            <input  readonly type="text" class="form-control" id="no_of_ctns" name="no_of_ctns"  required readonly>
                                            <p class="error no_of_ctns_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="port_code">Port Code</label>
                                                <select  readonly class="form-control" name="port_code" id="port_code">
                                                    <option st-id="" value="">select Port Code</option>
                                                    <option st-id="" value="INNSA1" <?php if($getsalestrackingdetailsforedit['port_code']=='INNSA1'){ echo 'selected';} ?>>INNSA1</option>
                                                    <option st-id="" value="INBOM4" <?php if($getsalestrackingdetailsforedit['port_code']=='INBOM4'){ echo 'selected';} ?>>INBOM4</option>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="port_of_discharge">Port Of Discharge</label>
                                            <input  readonly type="text" class="form-control"  id="port_of_discharge" value="<?=$getsalestrackingdetailsforedit['port_of_discharge']?>" name="port_of_discharge">
                                            <p class="error port_of_discharge_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sb_no">Sb.No</label>
                                            <input  readonly type="text" class="form-control" id="sb_no" value="<?=$getsalestrackingdetailsforedit['sb_no']?>" name="sb_no">
                                            <p class="error sb_no_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sb_date">Sb. Date</label>
                                            <input  readonly type="text" class="form-control datepicker" id="sb_date" value="<?=$getsalestrackingdetailsforedit['sb_date']?>" name="sb_date">
                                            <p class="error sb_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fob_amount_rs">Fob Amount (Rs)</label>
                                            <input  readonly type="text" class="form-control" id="fob_amount_rs"  value="<?=$getsalestrackingdetailsforedit['fob_amount_rs']?>" name="fob_amount_rs">
                                            <p class="error fob_amount_rs_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="drawback">Drawback (Rs)</label>
                                            <input  readonly type="text" class="form-control" id="drawback" value="<?=$getsalestrackingdetailsforedit['drawback']?>" name="drawback">
                                            <p class="error drawback_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bl_awb_no">BL/Awb No</label>
                                            <input  readonly type="text" class="form-control" id="bl_awb_no" value="<?=$getsalestrackingdetailsforedit['bl_awb_no']?>" name="bl_awb_no">
                                            <p class="error bl_awb_no_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bl_awb_date">BL/Awb Date</label>
                                            <input  readonly type="text" class="form-control datepicker" id="bl_awb_date" value="<?=$getsalestrackingdetailsforedit['bl_awb_date']?>" name="bl_awb_date">
                                            <p class="error bl_awb_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="brc_number_and_dt">Brc Number & Date</label>
                                            <input  readonly type="text" class="form-control" id="brc_number_and_dt" value="<?=$getsalestrackingdetailsforedit['brc_number_and_dt']?>" name="brc_number_and_dt">
                                            <p class="error brc_number_and_dt_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="transaction_id">Transaction Id</label>
                                            <input  readonly type="text" class="form-control" id="transaction_id" value="<?=$getsalestrackingdetailsforedit['transaction_id']?>" name="transaction_id" required>
                                            <p class="error transaction_id_error"></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="brc_value">Brc Value</label>
                                            <input  readonly type="text" class="form-control" id="brc_value" value="<?=$getsalestrackingdetailsforedit['brc_value']?>" name="brc_value">
                                            <p class="error brc_value_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="foreign_bank_charges">Foreign Bank Charges</label>
                                            <input  readonly type="text" class="form-control" id="foreign_bank_charges" value="<?=$getsalestrackingdetailsforedit['foreign_bank_charges']?>" name="foreign_bank_charges">
                                            <p class="error foreign_bank_charges_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="foreign_bank_charges_in_inr">Foreign Bank Charges In Inr</label>
                                            <input  readonly type="text" class="form-control" id="foreign_bank_charges_in_inr" value="<?=$getsalestrackingdetailsforedit['foreign_bank_charges_in_inr']?>" name="foreign_bank_charges_in_inr">
                                            <p class="error foreign_bank_charges_in_inr_error"></p>
                                        </div>
                                    </div>
                                </div>




                                <!-------------------------------------------------------------------------------------->
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="EGM_status">EGM Status</label>
                                            <input  readonly type="text" class="form-control" id="EGM_status" value="<?=$getsalestrackingdetailsforedit['EGM_status']?>" name="EGM_status">
                                            <p class="error EGM_status_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="carrier_bill_number ">CHA Bill Number</label>
                                            <input  readonly type="text" class="form-control" id="carrier_bill_number" value="<?=$getsalestrackingdetailsforedit['carrier_bill_number']?>" name="carrier_bill_number">
                                            <p class="error carrier_bill_number_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="carrier_bill_date">CHA Bill Date</label>
                                            <input  readonly type="text" class="form-control datepicker" id="carrier_bill_date"  value="<?=$getsalestrackingdetailsforedit['carrier_bill_date']?>" name="carrier_bill_date">
                                            <p class="error carrier_bill_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bill_amt">Bill Amt</label>
                                            <input  readonly type="text" class="form-control" id="bill_amt" name="bill_amt" value="<?=$getsalestrackingdetailsforedit['bill_amt']?>">
                                            <p class="error bill_amt_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bill_paid_amount">Bill Paid Amount</label>
                                            <input  readonly type="text" class="form-control" id="bill_paid_amount" name="bill_paid_amount" value="<?=$getsalestrackingdetailsforedit['bill_paid_amount']?>">
                                            <p class="error bill_paid_amount_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tds_amt">Tds Amt </label>
                                            <input  readonly type="text" class="form-control" id="tds_amt" name="tds_amt" value="<?=$getsalestrackingdetailsforedit['tds_amt']?>">
                                            <p class="error tds_amt_error"></p>
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cheque_no">Cheque No</label>
                                            <input  readonly type="text" class="form-control" id="cheque_no" name="cheque_no" value="<?=$getsalestrackingdetailsforedit['cheque_no']?>">
                                            <p class="error cheque_no_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bill_paid_date">Bill Paid Date</label>
                                            <input  readonly type="text" class="form-control datepicker" id="bill_paid_date" name="bill_paid_date" value="<?=$getsalestrackingdetailsforedit['bill_paid_date']?>">
                                            <p class="error bill_paid_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dbk_recd_amount">Dbk Recd Amount</label>
                                            <input  readonly type="text" class="form-control" id="dbk_recd_amount" name="dbk_recd_amount" value="<?=$getsalestrackingdetailsforedit['dbk_recd_amount']?>">
                                            <p class="error dbk_recd_amount_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dbk_recd_date">Dbk Recd Date</label>
                                            <input  readonly type="text" class="form-control datepicker" id="dbk_recd_date" name="dbk_recd_date" value="<?=$getsalestrackingdetailsforedit['dbk_recd_date']?>">
                                            <p class="error dbk_recd_date_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="rodtep">Rodtep</label>
                                            <input  readonly type="text" class="form-control" id="rodtep" name="rodtep" value="<?=$getsalestrackingdetailsforedit['rodtep']?>">
                                            <p class="error Rodtep_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="escript_number_license_no">Escript Number (License No)</label>
                                            <input  readonly type="text" class="form-control" id="escript_number_license_no" name="escript_number_license_no" value="<?=$getsalestrackingdetailsforedit['escript_number_license_no']?>">
                                            <p class="error escript_number_license_no_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="payment_recvd_date">Payment Recvd Date</label>
                                            <input  readonly type="text" class="form-control datepicker" id="payment_recvd_date" name="payment_recvd_date" value="<?=$getsalestrackingdetailsforedit['payment_recvd_date']?>" required>
                                            <p class="error payment_recvd_date_error"></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="payment_rcivd_amt">Payment Rcivd Amt</label>
                                            <input  readonly type="text" class="form-control" id="payment_rcivd_amt" value="<?=$getsalestrackingdetailsforedit['payment_rcivd_amt']?>" name="payment_rcivd_amt">
                                            <p class="error payment_rcivd_amt_error"></p>
                                        </div>
                                    </div>

                                     
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="payment_exchange_amt">Payment Exchange Rate</label>
                                            <input  readonly type="text" class="form-control" id="payment_exchange_amt" value="<?=$getsalestrackingdetailsforedit['payment_exchange_amt']?>" name="payment_exchange_amt">
                                            <p class="error payment_exchange_amt_error"></p>
                                        </div>
                                    </div>
                                    
                               
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="realised_amt_in_inr">Realised Amt In Inr</label>
                                            <input  readonly type="text" class="form-control" id="realised_amt_in_inr"  value="<?=$getsalestrackingdetailsforedit['realised_amt_in_inr']?>"  name="realised_amt_in_inr">
                                            <p class="error realised_amt_in_inr_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bank_charges_inr">Bank Charges Inr</label>
                                            <input  readonly type="text" class="form-control" id="bank_charges_inr"  value="<?=$getsalestrackingdetailsforedit['bank_charges_inr']?>" name="bank_charges_inr">
                                            <p class="error bank_charges_inr_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-------------------------------------------------------------------------------------->
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="credit_note_number">Credit Note Number</label>
                                                <select  readonly class="form-control" name="credit_note_number" id="credit_note_number">
                                                            <option st-id="" value="">Select Credit Note Number</option>
                                                                <?php foreach ($getcreditnotenumber as $key => $value) {?>
                                                            <option value="<?php echo $value['id']; ?>" <?php if($getsalestrackingdetailsforedit['credit_note_number']==$value['id']){ echo 'selected';} ?>><?php echo $value['credit_note_number']; ?></option>
                                                        <?php } ?>
                                                    <p class="error credit_note_number_error"></p>
                                                </select>
                                                <p class="error credit_note_number_error"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="credit_note_date">Credit Note Date</label>
                                             <input  readonly type="text" class="form-control datepicker" id="credit_note_date"  name="credit_note_date" readonly>
                                            <p class="error credit_note_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="receivable_amt">Receivable Amt (Credit Note)</label>
                                            <input  readonly type="text" class="form-control"  id="receivable_amt" name="receivable_amt" readonly>
                                            <p class="error receivable_amt_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="difference">Difference</label>
                                            <input  readonly type="text" class="form-control" id="difference" name="difference" readonly>
                                            <p class="error difference_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="credit_note_reason">Credit Note Reason</label>
                                            <input  readonly type="text" class="form-control" id="credit_note_reason" name="credit_note_reason" readonly>
                                            <p class="error credit_note_reason_error"></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="debit_note_number">Debit Note Number</label>
                                                <select  readonly class="form-control" name="debit_note_number" id="debit_note_number">
                                                            <option st-id="" value="">Select Debit Note Number</option>
                                                                <?php foreach ($getchadebitenotenumber as $key => $value) {?>
                                                            <option value="<?php echo $value['id']; ?>" <?php if($getsalestrackingdetailsforedit['debit_note_number']==$value['id']){ echo 'selected';} ?> ><?php echo $value['cha_debit_number']; ?></option>
                                                        <?php } ?>
                                                    <p class="error debit_note_number_error"></p>
                                                </select>
                                                <!-- <input  readonly type="text" class="form-control" id="debit_note_number" name="debit_note_number">
                                                <p class="error debit_note_number_error"></p> -->
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="debit_note_date">Debit Note Date</label>
                                            <input  readonly type="text" class="form-control datepicker" id="debit_note_date" value="<?=$getsalestrackingdetailsforedit['debit_note_date']?>"  name="debit_note_date">
                                            <p class="error debit_note_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="receivable_amt_debit">Receivable Amt (Debit Note)</label>
                                            <input  readonly type="text" class="form-control"  id="receivable_amt_debit" value="<?=$getsalestrackingdetailsforedit['receivable_amt_debit']?>" name="receivable_amt_debit">
                                            <p class="error receivable_amt_debit_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="difference_debit_note_amt">Difference / Debit Note Amt</label>
                                            <input  readonly type="text" class="form-control" id="difference_debit_note_amt" value="<?=$getsalestrackingdetailsforedit['difference_debit_note_amt']?>" name="difference_debit_note_amt">
                                            <p class="error difference_debit_note_amt_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="debit_amount_reason">Debit Amount Reason</label>
                                            <input  readonly type="text" class="form-control" id="debit_amount_reason" value="<?=$getsalestrackingdetailsforedit['debit_amount_reason']?>" name="debit_amount_reason">
                                            <p class="error debit_amount_reason_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="rod_tep_amount_as_per_sb">Rod Tep (Amount) As Per Sb</label>
                                            <input type="text" class="form-control" id="rod_tep_amount_as_per_sb"  value="<?=$getsalestrackingdetailsforedit['rod_tep_amount_as_per_sb']?>"  name="rod_tep_amount_as_per_sb">
                                            <p class="error rod_tep_amount_as_per_sb_error"></p>
                                        </div>
                                    </div>


                                <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exchange_rate_as_per_sb">Exchange Rate As Per Sb</label>
                                            <input  readonly type="text" class="form-control" id="exchange_rate_as_per_sb" value="<?=$getsalestrackingdetailsforedit['exchange_rate_as_per_sb']?>" name="exchange_rate_as_per_sb">
                                            <p class="error exchange_rate_as_per_sb_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="payment_status">Payment Status</label>
                                                 <select  readonly class="form-control" name="payment_status" id="payment_status">
                                                        <option st-id="" value="">Select Payment Status</option>
                                                        <option value="Open" <?php if($getsalestrackingdetailsforedit['payment_status']=='Open'){ echo 'selected';} ?>>Open</option>
                                                        <option value="Close" <?php if($getsalestrackingdetailsforedit['payment_status']=='Close'){ echo 'selected';} ?>>Close</option>
                                                </select>
                                            <p class="error payment_status_error"></p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <!-- <input  readonly type="submit" id="savenewsalestracking" class="btn btn-primary" value="Submit" /> -->
                                <input  readonly type="button" onclick="location.href = '<?php echo base_url() ?>salestrackingreport'" class="btn btn-default" value="Back" />
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script>
   $(function() {
    $(".datepicker").datepicker({ 
        // minDate: 0,
        todayHighlight: true,
                     dateFormat: 'yy-mm-dd',
        startDate: new Date()
    });
   });
</script>
