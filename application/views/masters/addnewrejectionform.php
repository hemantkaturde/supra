<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> Add New Rejection Form
         <small>
            <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
               <li class="completed"><a href="javascript:void(0);">Masters</a></li>
               <li class="active"><a href="javascript:void(0);"> OMS Challan Details</a></li>
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
                     <h3 class="box-title">Add New Rejection Form</h3>
                  </div>
                  <?php $this->load->helper("form"); ?>
                  <form role="form" id="addnewrejectionformdata" action="#" method="post" role="form">
                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="rejection_number">Rejection Id<span class="required">*</span></label>
                                        <?php


                                            $current_month = date("n"); // Get the current month without leading zeros

                                            if ($current_month >= 4) {
                                                    // If the current month is April or later, the financial year is from April (current year) to March (next year)
                                                    $financial_year_indian = date("y") . "" . (date("y") + 1);
                                            } else {
                                                    // If the current month is before April, the financial year is from April (last year) to March (current year)
                                                    $financial_year_indian = (date("y") - 1) . "" . date("y");
                                            }

                                            if($getPreviousrejectionformnumber['rejection_number']){
                                                // $arr = str_split($getPreviousrejectionformnumber['rejection_number']);
                                                // $i = end($arr);
                                                // $inrno= "SQRC2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                                // $rejection_number = $inrno;

                                                // OLD LOGIC END Here Commited 18-04-2024
                                                // $string = $getPreviousrejectionformnumber['rejection_number'];
                                                // $n = 4; // Number of characters to extract from the end
                                                // $lastNCharacters = substr($string, -$n);
                                                // $inrno= "SQRC2324".str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                // $rejection_number = $inrno;


                                                $getfinancial_year = substr($getPreviousrejectionformnumber['rejection_number'], -8);

                                                $first_part_of_string = substr($getfinancial_year,0,4);
                                                $year = substr($getfinancial_year,0,2);
    
                                                // Current date
                                                $currentDate = new DateTime();
                                                
                                                // Financial year in India starts from April 1st
                                                $financialYearStart = new DateTime("$year-04-01");
                                                
                                                // Financial year in India ends on March 31st of the following year
                                                $financialYearEnd = new DateTime(($year + 1) . "-03-31");
                                                
                                                // Check if the current date falls within the financial year
                                                if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {
                                                   
                                                    $string = $getPreviousrejectionformnumber['rejection_number'];
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters = substr($string, -$n);
                                                    $inrno= "SQID".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $rejection_number = $inrno;
    
                                                } else {

                                                    $getfinancial_year = substr($getPreviousrejectionformnumber['rejection_number'], -8);

                                                    $first_part_of_string = substr($getfinancial_year,0,4);
        
                                                    if($first_part_of_string == $financial_year_indian){

                                                        $string = $getPreviousrejectionformnumber['rejection_number'];
                                                        $n = 4; // Number of characters to extract from the end
                                                        $lastNCharacters = substr($string, -$n);
                                                        $inrno= "SQID".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                        $rejection_number = $inrno;
        
                                                    }else{
                                                        $string = 0;
                                                        $n = 4; // Number of characters to extract from the end
                                                        $lastNCharacters = substr($string, -$n);
                                                        $inrno= "SQID".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                        $rejection_number = $inrno;
        

                                                    }
    
                                                  
                                                    //$po_number = 'SQPO24250001';
                                                }  
                                              /* New Logic End Here */

                                            }else{
                                                $rejection_number = 'SQRC'.$financial_year_indian.'0001';
                                            }
                                        ?>
                                            <input type="text" class="form-control" id="rejection_number" name="rejection_number" value="<?=$rejection_number;?>" required readonly>
                                            <p class="error rejection_number_error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="rejection_form_date">Date <span class="required">*</span></label>
                                            <?php  $date= date('Y-m-d');  ?>
                                            <input type="text" class="form-control datepicker" id="rejection_form_date" name="rejection_form_date" value="<?=$date?>"  required >
                                            <p class="error rejection_form_date_error"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                                <select class="form-control" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                        <?php foreach ($vendorList as $key => $value) {?>
                                                            <option value="<?php echo $value['ven_id']; ?>" <?php if($getomschallanitems[0]['pre_vendor_name']==$value['ven_id']){ echo 'selected'; }?> ><?php echo $value['vendor_name']; ?></option>
                                                        <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12 vendor_po_number_div" id="vendor_po_number_div">
                                    <div class="form-group">
                                        <label for="vendor_po_number">Select Vendor PO Number</label>
                                            <select class="form-control" name="vendor_po_number" id="vendor_po_number">
                                            </select>
                                        <p class="error vendor_po_number_error"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">Remark</label>
                                        <input type="remark" class="form-control" id="remark" name="remark" value="<?=$getomschallanitems[0]['pre_remark'] ?>">
                                        <p class="error remark_error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>  
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <div class="col-xs-8">
                           <input type="submit" id="addnewrejectionform" class="btn btn-primary" value="Submit">
                           <input type="button" onclick="location.href = '<?php echo base_url() ?>stockrejectionform'" class="btn btn-default" value="Back" />
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