<style>
    .select2-container--default{

       width: 287px !important;
}
    </style>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Cleaning Form
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Cleaning Form</a></li>
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
                            <h3 class="box-title">Add New Cleaning Form</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewcleaningform" action="<?php echo base_url() ?>addnewcleaningform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">

                                <?php
                                        // $current_month = date("n"); // Get the current month without leading zeros

                                        // if ($current_month >= 4) {
                                        //     // If the current month is April or later, the financial year is from April (current year) to March (next year)
                                        //     $financial_year_indian = date("y") . "-" . (date("y") + 1);
                                        // } else {
                                        //     // If the current month is before April, the financial year is from April (last year) to March (current year)
                                        //     $financial_year_indian = (date("y") - 1) . "-" . date("y");
                                        // }


                                        // if($getPreviouscleaningforpreviousnumber[0]['cleaning_no']){
                                        //         // $arr = str_split($getPreviousSalesOrderNumber['sales_order_number']);
                                        //         // $i = end($arr);
                                        //         // $inrno= "SQBO2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                        //         // $sales_order_number = $inrno;

                                        //         $currentDate = new DateTime();

                                        //         // Check if the current date is on or after April 1st
                                        //         if ($currentDate >= new DateTime(date('Y') . '-04-01')) {
                                        //             // If it is, the financial year has started in the current calendar year
                                        //             //$startYear = date('Y');
                                        //             $startYear = date('y');
                                        //             $endYear = $startYear + 1;
                                        //         } else {
                                        //             // If it is not, the financial year has started in the previous calendar year
                                        //             //$endYear = date('Y');
                                        //             $endYear = date('y');
                                        //             $startYear = $endYear - 1;
                                        //         }

                                        //         // Display the financial year
                                        //         $financialYear = $startYear.$endYear;

                                        //         $string = $getPreviouscleaningforpreviousnumber[0]['cleaning_no'];

                                        //         $explod = explode("/",$string);
                                            
                                        //         if($explod[2]== $financial_year_indian ){
                                        //             $n = 4; // Number of characters to extract from the end
                                        //             $lastNCharacters = substr($explod[1], -$n);
                                        //             //$inrno= "SQBO2324".str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
    
                                        //             // $inrno= 'SVC/'.($lastNCharacters+1)."/".$financialYear;
                                        //             $inrno= 'SQCL'.$financialYear.$lastNCharacters+1;
                                        //             $report_no = $inrno;
                                        //         }else{

                                        //             $n = 4; // Number of characters to extract from the end
                                        //             $lastNCharacters = 0;
                                        //             //$inrno= "SQBO2324".str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
    
                                        //             $inrno= 'SQCL'.$financialYear.$lastNCharacters+1;
                                        //             $report_no = $inrno;
                                        //         }

                                              

                                        // }else{

                                        //     $currentDate = new DateTime();

                                        //     // Check if the current date is on or after April 1st
                                        //     if ($currentDate >= new DateTime(date('Y') . '-04-01')) {
                                        //         // If it is, the financial year has started in the current calendar year
                                        //         //$startYear = date('Y');
                                        //         $startYear = date('y');
                                        //         $endYear = $startYear + 1;
                                        //     } else {
                                        //         // If it is not, the financial year has started in the previous calendar year
                                        //         //$endYear = date('Y');
                                        //         $endYear = date('y');
                                        //         $startYear = $endYear - 1;
                                        //     }

                                        //     // Display the financial year
                                        //     $financialYear = $startYear. $endYear;

                                        //     $report_no = 'SQCL'.$financialYear.'0001';
                                        // }



                                        
                                        $current_month = date("n"); // Get the current month without leading zeros

                                        if ($current_month >= 4) {
                                            // If the current month is April or later, the financial year is from April (current year) to March (next year)
                                            $financial_year_indian = date("y") . "" . (date("y") + 1);
                                        } else {
                                            // If the current month is before April, the financial year is from April (last year) to March (current year)
                                            $financial_year_indian = (date("y") - 1) . "" . date("y");
                                        }

                                        if($getPreviouscleaningforpreviousnumber[0]['cleaning_no']){
                                            // $arr = str_split($getPreviousPODdetails_number[0]['pod_details_number']);
                                            // $i = end($arr);
                                            // $inrno= "SQPD2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            // $POD_details_number = $inrno;

                                            if($first_part_of_string == $financial_year_indian){

                                            }else{}
                                            
                                              // New Logic Start Here 
                                              $getfinancial_year = substr($getPreviouscleaningforpreviousnumber[0]['cleaning_no'], -8);

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
                                                 
                                                  $string = $getPreviouscleaningforpreviousnumber[0]['cleaning_no'];
                                                  $n = 4; // Number of characters to extract from the end
                                                  $lastNCharacters = substr($string, -$n);
                                                  $inrno= "SQCL".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                  $report_no = $inrno;
  
                                              } else {


                                                if($first_part_of_string == $financial_year_indian){
                                                    $string = $getPreviouscleaningforpreviousnumber[0]['cleaning_no'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters = substr($string, -$n);
                                                    $inrno= "SQCL".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $report_no = $inrno;

                                                }else{
  
                                                    $string = $getPreviouscleaningforpreviousnumber[0]['cleaning_no'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters1 = substr($string, -$n);
                                                    
                                                    if($lastNCharacters1  > 0){

                                                        if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {

                                                            $string1 =$getPreviouscleaningforpreviousnumber[0]['cleaning_no'];
                                                        }else{
                                                            $string1 =0;
                                                        }

                                                    }else{
                                                        $string1 =0;
                                                    }

                                                    $lastNCharacters = substr($string1, -$n);
                                                    $inrno= "SQCL".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $report_no = $inrno;
  
                                                  //$po_number = 'SQPO24250001';
                                                }
                                              }  
                                            /* New Logic End Here */

                                        }else{
                                            $report_no = 'SQCL'.$financial_year_indian.'0001';
                                        }


                                        


                                    ?>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cleaning_no">Cleaning No. <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="cleaning_no" name="cleaning_no" value="<?=$report_no?>" readonly>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cleaning_date">Cleaning Date</label>
                                               <input type="text" class="form-control datepicker" id="cleaning_date" value="<?php echo date('Y-m-d'); ?>" name="cleaning_date">
                                            <p class="error cleaning_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="vendor_div">
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
                                </div>

                                <div class="row">
                                    <div class="col-md-3" id="vendor_po_number_div"  style="display:none">
                                        <div class="form-group">
                                            <label for="vendor_po">Vendor PO</label>
                                            <select class="form-control" name="vendor_po_number" id="vendor_po_number">
                                            </select> 
                                            <p class="error vendor_po_number_error"></p>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-3" id="supplier_part_number_div"  style="display:none">
                                        <div class="form-group">
                                            <label for="supplier_part_number">Part Number / Drawing No / Rev No</label>
                                            <select class="form-control" name="supplier_part_number" id="supplier_part_number">
                                            </select> 
                                            <p class="error supplier_part_number_error"></p>
                                        </div>
                                    </div> -->


                                    <div class="col-md-3" id="vendor_part_number_div"  style="display:none">
                                        <div class="form-group">
                                            <label for="vendor_part_number">Part Number / Drawing No / Rev No</label>
                                            <select class="form-control vendor_part_number_for_incoimg_lot_number" name="vendor_part_number" id="vendor_part_number">
                                            </select> 
                                            <p class="error vendor_part_number_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="part_description">Part Description / Component</label>
                                            <input type="text" class="form-control" id="part_description" name="part_description">
                                            <p class="error part_description_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="incoming_lot_number_div"  style="display:none">
                                        <div class="form-group">
                                            <label for="incoming_lot_number">Lot Number</label>
                                            <select class="form-control" name="incoming_lot_number" id="incoming_lot_number">
                                            </select> 
                                            <p class="error incoming_lot_number_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="received_qty">Lot Qty</label>
                                            <input type="text" class="form-control" id="received_qty" name="received_qty">
                                            <p class="error received_qty_error"></p>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="no_of_boxes">No .Of Boxes</label>
                                            <input type="text" class="form-control" id="no_of_boxes" name="no_of_boxes">
                                            <p class="error no_of_boxes_error"></p>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cleaning_status">Status</label>
                                                   <select class="form-control" name="cleaning_status" id="cleaning_status">
                                                        <option st-id="" value="">Select Status</option>
                                                        <option value="In Process" selected>In Process</option>
                                                        <option value="Completed">Completed</option>
                                                    </select>
                                            <p class="error cleaning_status_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="no_of_boxes_after_cleaning">No of Boxes after cleaning</label>
                                            <input type="text" class="form-control" id="no_of_boxes_after_cleaning" name="no_of_boxes_after_cleaning">
                                            <p class="error no_of_boxes_after_cleaning_error"></p>
                                        </div>
                                    </div>


                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="start_date_time">Start Date and Time</label>
                                        <input type="text"
                                            class="form-control datepicker"
                                            id="start_date_time"
                                            name="start_date_time"
                                            value="<?php echo date('Y-m-d H:i:s'); ?>">
                                        <p class="error start_date_time_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="end_date_time">End Date and Time</label>
                                        <input type="text"
                                            class="form-control datepicker"
                                            id="end_date_time"
                                            name="end_date_time"
                                            value="">
                                        <p class="error end_date_time_error"></p>
                                    </div>
                                </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="text" class="form-control" id="remark" name="remark">
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="addnewcleaningformsubmit" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>cleaningform'" class="btn btn-default" value="Back" />
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
   $(document).ready(function(){
			$("select").select2();
   });
   
   $(function() {
    $(".datepicker").datepicker({ 
        // minDate: 0,
        todayHighlight: true,
                     dateFormat: 'yy-mm-dd',
        startDate: new Date()
    });
   });
</script>
