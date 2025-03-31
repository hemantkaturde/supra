<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> Add New Payment Details
         <small>
            <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
               <li class="completed"><a href="javascript:void(0);">Masters</a></li>
               <li class="active"><a href="javascript:void(0);"> Payment Details</a></li>
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
                     <h3 class="box-title">Add Payment Details</h3>
                  </div>
                  <?php $this->load->helper("form"); ?>
                  <form role="form" id="addnewpaymentdetailsform" action="#" method="post" role="form">
                     <div class="box-body">
                        <div class="row">
                           <div class="col-md-6 col-sm-6 col-xs-6">
                              <div class="col-md-8 col-sm-8 col-xs-8">
                                 <?php

                                    $current_month = date("n"); // Get the current month without leading zeros

                                    if ($current_month >= 4) {
                                          // If the current month is April or later, the financial year is from April (current year) to March (next year)
                                          $financial_year_indian = date("y") . "" . (date("y") + 1);
                                    } else {
                                          // If the current month is before April, the financial year is from April (last year) to March (current year)
                                          $financial_year_indian = (date("y") - 1) . "" . date("y");
                                    }

                                    if($getPreviousPaymentdetails_number[0]['payment_details_number']){
                                       //  $arr = str_split($getPreviousPaymentdetails_number[0]['payment_details_number']);
                                       //  $i = end($arr);
                                       //  $inrno= "SQPN2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                       //  $payment_details_number = $inrno;

                                            
                                              // New Logic Start Here 
                                              $getfinancial_year = substr($getPreviousPaymentdetails_number[0]['payment_details_number'], -8);

                                              $first_part_of_string = substr($getfinancial_year,0,4);
                                              $year = substr($first_part_of_string,0,2);

                                              // Current date
                                              $currentDate = new DateTime();
                                              
                                              // Financial year in India starts from April 1st
                                              $financialYearStart = new DateTime("$year-04-01");
                                              
                                              // Financial year in India ends on March 31st of the following year
                                              $financialYearEnd = new DateTime(($year + 1) . "-03-31");
                                              
                                              // Check if the current date falls within the financial year
                                              if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {
                                                 
                                                  $string = $getPreviousPaymentdetails_number[0]['payment_details_number'];
                                                  $n = 4; // Number of characters to extract from the end
                                                  $lastNCharacters = substr($string, -$n);
                                                  $inrno= "SQPN".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                  $payment_details_number = $inrno;
  
                                              } else {


                                                   $getfinancial_year = substr($getPreviousPaymentdetails_number[0]['payment_details_number'], -8);

                                                   $first_part_of_string = substr($getfinancial_year,0,4);

                                                   if($first_part_of_string == $financial_year_indian){

                                                      $string = $getPreviousPaymentdetails_number[0]['payment_details_number'];
                                                      $n = 4; // Number of characters to extract from the end
                                                      $lastNCharacters = substr($string, -$n);
                                                      $inrno= "SQPN".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                      $payment_details_number = $inrno;

                                                   }else{

                                                    $string = $getPreviousPaymentdetails_number[0]['payment_details_number'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters1 = substr($string, -$n);
                                                    
                                                    if($lastNCharacters1  > 0){

                                                        if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {

                                                            $string1 =$getPreviousPaymentdetails_number[0]['payment_details_number'];
                                                        }else{
                                                            $string1 =0;
                                                        }

                                                    }else{
                                                        $string1 =0;
                                                    }

                                                    $lastNCharacters = substr($string1, -$n);
                                                    $inrno= "SQPN".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $payment_details_number = $inrno;
                                                   }
                                                  //$po_number = 'SQPO24250001';
                                              }  
                                            /* New Logic End Here */



                                    }else{
                                        $payment_details_number = 'SQPN'.$financial_year_indian.'0001';
                                    }
                                    ?>
                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="payment_details_number">Payment Details Number<span class="required">*</span></label>
                                       <input type="text" class="form-control" id="payment_details_number" value="<?=$payment_details_number?>" name="payment_details_number" readonly>
                                       <p class="error payment_details_number_error"></p>
                                    </div>
                                 </div>
                                 <?php $date= date('Y-m-d'); ?>
                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="payment_details_date">Payment Details Date <span class="required">*</span></label>
                                       <input type="text" class="form-control datepicker"  value="<?=$date?>" id="payment_details_date" name="payment_details_date" required>
                                       <p class="error payment_details_date_error"></p>
                                    </div>
                                 </div>
                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="vendor_supplier_name">Select Vendor / Supplier <span class="required">*</span></label>
                                       <select class="form-control vendor_supplier_name" name="vendor_supplier_name" id="vendor_supplier_name">
                                          <option st-id="" value="">Select Vendor / Supplier</option>
                                          <option value="vendor">Vendor</option>
                                          <option value="supplier">Supplier</option>
                                       </select>
                                       <p class="error vendor_supplier_name_error"></p>
                                    </div>
                                 </div>
                                 <div id="vendor_name_div_for_hide_show" style="display:none">
                                    <div class="col-md-12" >
                                       <div class="form-group">
                                          <label for="vendor_name">Vendor Name</label>
                                          <select class="form-control vendor_name" name="vendor_name" id="vendor_name">
                                             <option st-id="" value="">Select Vendor Name</option>
                                             <?php foreach ($vendorList as $key => $value) {?>
                                             <option value="<?php echo $value['ven_id']; ?>"><?php echo $value['vendor_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <p class="error vendor_name_error"></p>
                                       </div>
                                    </div>
                                    <div class="col-md-12 vendor_po_number_div" id="vendor_po_number_div" style="display:none">
                                       <div class="form-group">
                                          <label for="vendor_po_number">Select Vendor PO Number</label>
                                          <select class="form-control vendor_po_number_itam vendor_po_get_data get_vendorpodata_with_debit_data" name="vendor_po_number" id="vendor_po_number">
                                             <!-- <option st-id="" value="">Select Vendor Name</option> -->
                                             <!-- <option st-id="" value="<?=$getdebitnoteitemdetails[0]['pre_vendor_po_number']?>" selected="selected"><?=$selected_value?></option> -->
                                          </select>
                                          <p class="error vendor_po_number_error"></p>
                                       </div>
                                    </div>
                                 </div>
                                 <div id="supplier_name_div_for_hide_show" style="display:none">
                                    <div class="col-md-12" >
                                       <div class="form-group">
                                          <label for="supplier_name">Supplier Name </label>
                                          <select class="form-control" name="supplier_name" id="supplier_name">
                                             <option st-id="" value="">Select Supplier Name</option>
                                             <?php foreach ($supplierList as $key => $value) {?>
                                             <option value="<?php echo $value['sup_id']; ?>" <?php if($value['sup_id']==$getdebitnoteitemdetails[0]['pre_supplier_name']){ echo 'selected';} ?> ><?php echo $value['supplier_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <p class="error supplier_name_error"></p>
                                       </div>
                                    </div>
                                    <div class="col-md-12 supplier_po_number_div" id="supplier_po_number_div" style="display:none">
                                       <div class="form-group">
                                          <label for="supplier_po_number">Select Supplier PO Number</label>
                                          <select class="form-control supplier_po_number_item supplier_po_number_for_item supplier_po_get_data get_supplierpodata_debit_data" name="supplier_po_number" id="supplier_po_number">
                                             <!-- <option st-id="" value="">Select Vendor Name</option> -->
                                             <!-- <option st-id="" value="<?=$getdebitnoteitemdetails[0]['pre_supplier_po_number']?>" selected="selected"><?=$selected_value?></option> -->
                                          </select>
                                          <p class="error supplier_po_number_error"></p>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="po_date">PO Date</label>
                                       <input type="text" class="form-control datepicker" id="po_date" name="po_date" required>
                                       <p class="error po_date_error"></p>
                                    </div>
                                 </div>

                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="tds">TDS<span class="required">*</span></label>
                                       <input type="text" class="form-control" id="tds" name="tds">
                                       <p class="error tds_error"></p>
                                    </div>
                                 </div>

                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="debit_note_amount">Debit Note Amount<span class="required">*</span></label>
                                       <input type="text" class="form-control" id="debit_note_amount" name="debit_note_amount">
                                       <p class="error debit_note_amount_error"></p>
                                    </div>
                                 </div>

                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="debit_note_no">Debit Note No<span class="required">*</span></label>
                                       <input type="text" class="form-control" id="debit_note_no" name="debit_note_no">
                                       <p class="error debit_note_no_error"></p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6 col-sm-6 col-xs-6">
                             <div class="col-md-8 col-sm-8 col-xs-8">
                                <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="bill_number">Bill Number</label>
                                       <input type="text" class="form-control" id="bill_number" name="bill_number">
                                       <p class="error bill_number_error"></p>
                                    </div>
                                 </div>

                                 <?php  $bill_date= date('Y-m-d'); ?>

                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="bill_date">Bill Date</label>
                                       <input type="text" class="form-control datepicker"  value="<?=$bill_date?>" id="bill_date" name="bill_date">
                                       <p class="error bill_date_error"></p>
                                    </div>
                                 </div>

                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="bill_amount">Bill Amount</label>
                                       <input type="text" class="form-control" id="bill_amount"  name="bill_amount">
                                       <p class="error bill_amount_error"></p>
                                    </div>
                                 </div>

                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="cheque_number">Cheque Number</label>
                                       <input type="text" class="form-control" id="cheque_number" name="cheque_number">
                                       <p class="error cheque_number_error"></p>
                                    </div>
                                 </div>

                                 <?php  $Cheque_date= date('Y-m-d'); ?>

                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="cheque_date">Cheque Date</label>
                                       <input type="text" class="form-control datepicker"  value="<?=$Cheque_date?>" id="cheque_date" name="cheque_date">
                                       <p class="error cheque_date_error"></p>
                                    </div>
                                 </div>

                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="amount_paid">Amount Paid</label>
                                       <input type="text" class="form-control" id="amount_paid" name="amount_paid">
                                       <p class="error amount_paid_error"></p>
                                    </div>
                                 </div>

                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="amount_paid">Payment Status<span class="required">*</span></label>
                                       <select class="form-control payment_status" name="payment_status" id="payment_status">
                                          <option st-id="" value="">Select Payment Status</option>
                                          <option value="Paid">Paid</option>
                                          <option value="Unpaid">Unpaid</option>
                                       </select>
                                       <p class="error payment_status_error"></p>
                                    </div>
                                 </div>

                              
                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="remark">Remark</label>
                                       <textarea type="text" class="form-control"  id="remark"  name="remark"></textarea>
                                       <p class="error remark_error"></p>
                                    </div>
                                 </div>
                                                
                             </div>
                           </div>
                        </div>
                     </div>
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <div class="col-xs-8">
                           <input type="submit" id="savenewpaymentdetails" class="btn btn-primary" value="Submit">
                           <input type="button" onclick="location.href = '<?php echo base_url() ?>paymentdetails'" class="btn btn-default" value="Back" />
                        </div>
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