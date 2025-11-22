<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Inspection Report
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Inspection Report</a></li>
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
                            <h3 class="box-title">Add Inspection Report</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addTDIRform" action="#" method="post" role="form">
                            <div class="box-body">

                               <?php 

                                //print_r($getPreviousReportnumber[0]['report_number']);


                                    
                                        $current_month = date("n"); // Get the current month without leading zeros

                                        if ($current_month >= 4) {
                                                // If the current month is April or later, the financial year is from April (current year) to March (next year)
                                                $financial_year_indian = date("y") . "" . (date("y") + 1);
                                        } else {
                                                // If the current month is before April, the financial year is from April (last year) to March (current year)
                                                $financial_year_indian = (date("y") - 1) . "" . date("y");
                                        }

                                        if($getPreviousReportnumber[0]['report_number']){
                                            // $arr = str_split($getPreviousCreditnotenumber['credit_note_number']);
                                            // $i = end($arr);
                                            // $inrno= "SQCN2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            // $po_number = $inrno;

                                            // OLD LOGIC START HERE Commited ON 19-04-2024
                                            // $string = $getPreviousPreexport['pre_export_invoice_no'];
                                            // $n = 4; // Number of characters to extract from the end
                                            // $lastNCharacters = substr($string, -$n);
                                            // $inrno= "MG2324/".str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                            // $invoice_number = $inrno;

                                              // New Logic Start Here 
                                              $getfinancial_year = substr($getPreviousReportnumber[0]['report_number'], -9);

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
                                                 
                                                  $string = $getPreviousReportnumber[0]['report_number'];
                                                  $n = 4; // Number of characters to extract from the end
                                                  $lastNCharacters = substr($string, -$n);
                                                  $inrno= $financial_year_indian.'/'.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                  $report_number = $inrno;
  
                                              } else {

                                                $getfinancial_year = substr($getPreviousReportnumber[0]['report_number'], -9);

                                                $first_part_of_string = substr($getfinancial_year,0,4);
                                              
                                                 if($first_part_of_string==$financial_year_indian){

                                                    $string = $getPreviousReportnumber[0]['report_number'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters = substr($string, -$n);
                                                    $inrno= $financial_year_indian.'/'.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $report_number = $inrno;

                                                 }else{

                                                    $string = $getPreviousReportnumber[0]['report_number'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters1 = substr($string, -$n);
                                                    
                                                    if($lastNCharacters1  > 0){

                                                        if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {

                                                            $string1 =$getPreviousReportnumber[0]['report_number'];
                                                        }else{
                                                            $string1 =0;
                                                        }

                                                    }else{
                                                        $string1 =0;
                                                    }

                                                    $lastNCharacters = substr($string1, -$n);
                                                    $inrno= $financial_year_indian.'/'.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $report_number = $inrno;
                                                }
                                                  //$po_number = 'SQPO24250001';
                                              }  
                                            /* New Logic End Here */

                                        }else{
                                            //$invoice_number = 'MG-001/2324';
                                            $report_number = $financial_year_indian.'/0001';
                                        }



                                ?>

                            
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="report_number">Inspection Report Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" value="<?=$report_number;?>" id="report_number" name="report_number">
                                        </div>
                                    </div>

                                    
                                    
                                    <div class="col-md-3">
                                          <div class="form-group">
                                            <label for="vendor_name">Vendor Name</label>
                                                    <select class="form-control" name="vendor_name" id="vendor_name">
                                                        <option st-id="" value="">Select Vendor Name</option>
                                                        <?php foreach ($vendorList as $key => $value) {?>
                                                        <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$fetchALLprescrapreturndetails[0]['pre_vendor_name']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="vendor_po">Vendor PO</label>
                                            <select class="form-control vendor_po_number_for_buyer_details vendor_po_number_for_vendor_po_date" name="vendor_po_number" id="vendor_po_number">
                                            </select> 
                                            <p class="error vendor_po_number_error"></p>
                                        </div>
                                    </div>

                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="vendor_po_date">Vendor PO Date</label>
                                              <input type="text" class="form-control" id="vendor_po_date" name="vendor_po_date">
                                            <p class="error vendor_po_date_error"></p>
                                        </div>
                                    </div>
                                   
                                </div>

                                <div class="row">


                                 <div class="col-md-3">
                                       <div class="form-group">
                                            <label for="vendor_part_number">Part Number</label>
                                            <select class="form-control vendor_part_number_get_data" name="vendor_part_number" id="vendor_part_number">
                                            </select> 
                                            <p class="error vendor_part_number_error"></p>
                                        </div>
                                    </div>

                                   
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="part_name">Part Name</label>
                                            <input type="text" class="form-control" id="part_name" name="part_name">
                                            <p class="error part_name_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="vendor_order_qty">Vendor Order Qty</label>
                                            <input type="text" class="form-control" id="vendor_order_qty" name="vendor_order_qty">
                                            <p class="error vendor_order_qty_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="buyer_name">Buyer Name</label>
                                            <input type="text" class="form-control" id="buyer_name" name="buyer_name">
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="buyer_po_date">Buyer PO Date</label>
                                            <input type="text" class="form-control" id="buyer_po_date" name="buyer_po_date">
                                            <p class="error buyer_po_date_error"></p>
                                        </div>
                                    </div>
                                    
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="order_qty">Order Qty</label>
                                            <input type="text" class="form-control" id="order_qty" name="order_qty">
                                            <p class="error order_qty_error"></p>
                                        </div>
                                    </div> -->

                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="qty_in_pcs_for_export_purposr">Qty in PCS (For Export Purpose)</label>
                                            <input type="text" class="form-control" id="qty_in_pcs_for_export_purposr" name="qty_in_pcs_for_export_purposr">
                                            <p style="color:red">(Note: filed not to be entered by QC)</p>
                                            <p class="error qty_in_pcs_for_export_purposr_error"></p>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="remarks">Remarks</label>
                                            <input type="text" class="form-control" id="remarks" name="remarks">
                                            <p class="error remarks_error"></p>
                                        </div>
                                    </div> 
                                </div>

                                <!-- <div class="row">
                                 <div class="col-md-12">
                                   <h2>Incoming Lots</h2>

                                    <div class="lots-container">

                                    
                                    <div class="lot-box">
                                        <h3>Lot 1</h3>
                                        <div class="lot-details">
                                        <p><strong>Invoice Qty:</strong> 2636</p>
                                        <p><strong>Invoice Date:</strong> xx-yy-zz</p>
                                        </div>
                                        <div class="form-section">
                                        <label>Qty:</label>
                                        <input type="number" placeholder="Enter qty">
                                        
                                        <label>Checking:</label>
                                        <input type="checkbox"> Done
                                        
                                        <label>Checked By:</label>
                                        <input type="text" placeholder="Enter name">

                                        <button class="btn">Save</button>
                                        </div>
                                    </div>

                                   
                                    <div class="lot-box">
                                        <h3>Lot 2</h3>
                                        <div class="lot-details">
                                        <p><strong>Invoice Qty:</strong> --</p>
                                        <p><strong>Invoice Date:</strong> --</p>
                                        </div>
                                        <div class="form-section">
                                        <label>Qty:</label>
                                        <input type="number" placeholder="Enter qty">
                                        
                                        <label>Checking:</label>
                                        <input type="checkbox"> Done
                                        
                                        <label>Checked By:</label>
                                        <input type="text" placeholder="Enter name">

                                        <button class="btn">Save</button>
                                        </div>
                                    </div>

                                   
                                    <div class="lot-box">
                                        <h3>Lot 3</h3>
                                        <div class="lot-details">
                                        <p><strong>Invoice Qty:</strong> --</p>
                                        <p><strong>Invoice Date:</strong> --</p>
                                        </div>
                                        <div class="form-section">
                                        <label>Qty:</label>
                                        <input type="number" placeholder="Enter qty">
                                        
                                        <label>Checking:</label>
                                        <input type="checkbox"> Done
                                        
                                        <label>Checked By:</label>
                                        <input type="text" placeholder="Enter name">

                                        <button class="btn">Save</button>
                                        </div>
                                    </div>

                                    </div>

                                    </div>
                                </div> -->

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewTDIR" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>tdir'" class="btn btn-default" value="Back" />
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

<!-- <style>


  h2 {
    text-align: center;
    margin-bottom: 20px;
  }

  .lots-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
  }

  .lot-box {
    flex: 1 1 300px;
    background: #fff;
    border: 2px solid #333;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
  }

  .lot-box h3 {
    margin-top: 0;
    font-size: 18px;
    text-align: center;
    background: #eee;
    padding: 8px;
    border-radius: 6px;
  }

  .lot-details p {
    margin: 6px 0;
    font-size: 14px;
  }

  .form-section {
    margin-top: 15px;
    padding: 10px;
    background: #f1f1f1;
    border-radius: 6px;
  }

  .form-section label {
    display: block;
    font-size: 13px;
    margin: 5px 0 3px;
  }

  .form-section input[type="text"], 
  .form-section input[type="number"] {
    width: 100%;
    padding: 6px;
    border: 1px solid #aaa;
    border-radius: 4px;
  }

  .form-section input[type="checkbox"] {
    margin-right: 6px;
  }

  .btn {
    margin-top: 10px;
    padding: 8px 14px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .btn:hover {
    background: #0056b3;
  }
</style> -->