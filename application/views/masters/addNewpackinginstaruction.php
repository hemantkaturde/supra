<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Packing Instructions
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Packing Instructions Master</a></li>
                </ul>
            </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-8">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Add New Packing Instructions</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewpackinginstructionform" action="<?php echo base_url() ?>addnewpackinginstructionform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">

                                    <?php

                                        $current_month = date("n"); // Get the current month without leading zeros

                                        if ($current_month >= 4) {
                                                // If the current month is April or later, the financial year is from April (current year) to March (next year)
                                                $financial_year_indian = date("y") . "" . (date("y") + 1);
                                        } else {
                                                // If the current month is before April, the financial year is from April (last year) to March (current year)
                                                $financial_year_indian = (date("y") - 1) . "" . date("y");
                                        }

                                        if($getpreviouspackinginstarction[0]['packing_instrauction_id']){
                                            // $arr = str_split($getpreviouspackinginstarction[0]['packing_instrauction_id']);
                                            // $i = end($arr);
                                            // $inrno= "PI2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            // $packing_instrauction_id = $inrno;

                                            // OLD Logic Start Here Commit 18-04-2024
                                            // $string =$getpreviouspackinginstarction[0]['packing_instrauction_id'];
                                            // $n = 4; // Number of characters to extract from the end
                                            // $lastNCharacters = substr($string, -$n);
                                            // $inrno= "PI2324".str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                            // $packing_instrauction_id = $inrno;


                                            // New Logic Start Here 
                                            $getfinancial_year = substr($getpreviouspackinginstarction[0]['packing_instrauction_id'], -8);

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
                                                
                                                $string = $getpreviouspackinginstarction[0]['packing_instrauction_id'];
                                                $n = 4; // Number of characters to extract from the end
                                                $lastNCharacters = substr($string, -$n);
                                                $inrno= "PI".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                $packing_instrauction_id = $inrno;

                                            } else {


                                                $numericPart = substr($getpreviouspackinginstarction[0]['packing_instrauction_id'], 2);

                                                $firstFourDigits = substr($numericPart, 0, 4);

                                               

                                                $string = $getpreviouspackinginstarction[0]['packing_instrauction_id'];
                                                $n = 4; // Number of characters to extract from the end
                                                $lastNCharacters1 = substr($string, -$n);

                                                if($lastNCharacters1  > 0){
                                                    $string1 =$getpreviouspackinginstarction[0]['packing_instrauction_id'];
                                                }else{
                                                    $string1 =0;
                                                }

                                                if($firstFourDigits== $financial_year_indian){
                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters = substr($string1, -$n);
                                                    $inrno= "PI".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $packing_instrauction_id = $inrno;

                                                }else{

                                                    $n = 4; // Number of characters to extract from the end
                                                    $lastNCharacters = 0;
                                                    $inrno= "PI".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                    $packing_instrauction_id = $inrno;
                                                }

                                              

                                                //$po_number = 'SQPO24250001';
                                            }  
                                            /* New Logic End Here */


                                        }else{
                                            $packing_instrauction_id = 'PI'.$financial_year_indian.'0001';
                                        }







                                        if($getpreviouspackinginstarction[0]['export_id']){
                                            // $arr = str_split($getpreviouspackinginstarction[0]['packing_instrauction_id']);
                                            // $i = end($arr);
                                            // $inrno= "PI2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            // $packing_instrauction_id = $inrno;

                                            // OLD Logic Start Here Commit 18-04-2024
                                            // $string =$getpreviouspackinginstarction[0]['export_id'];
                                            // $n = 4; // Number of characters to extract from the end
                                            // $lastNCharacters = substr($string, -$n);
                                            // $inrno= "SQID2324".str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                            // $export_id = $inrno;


                                               // New Logic Start Here 
                                               $getfinancial_year = substr($getpreviouspackinginstarction[0]['export_id'], -8);

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
                                                  
                                                   $string = $getpreviouspackinginstarction[0]['export_id'];
                                                   $n = 4; // Number of characters to extract from the end
                                                   $lastNCharacters = substr($string, -$n);
                                                   $inrno= "SQID".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                   $export_id = $inrno;
   
                                               } else {
   
                                                   $string = $getpreviouspackinginstarction[0]['export_id'];
                                                   $n = 4; // Number of characters to extract from the end
                                                   $lastNCharacters = substr($string, -$n);
                                                   $inrno= "SQID".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                                   $export_id = $inrno;
   
                                                   //$po_number = 'SQPO24250001';
                                               }  
                                             /* New Logic End Here */



                                        }else{
                                            $export_id = 'SQID'.$financial_year_indian.'0001';
                                        }


                                    ?>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="packing_id_number">Packing Id Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="packing_id_number" name="packing_id_number"  value="<?php echo $packing_instrauction_id; ?>" required readonly>
                                            <p class="error packing_id_number_error"></p>
                                        </div>
                                    </div>

                                  
                                    <input type="hidden" class="form-control" id="export_id" name="export_id"  value="<?php echo $export_id; ?>">
                                    
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_name">Select Buyer Name <span class="required">*</span></label>
                                                <select class="form-control buyer_po_number_for_itam_mapping" name="buyer_name" id="buyer_name">
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                        <?php foreach ($buyerList as $key => $value) {?>
                                                                <option value="<?php echo $value['buyer_id']; ?>"><?php echo $value['buyer_name']; ?></option>
                                                        <?php } ?>
                                                </select> 
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                       <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="buyer_po_number">Select Buyer Po Number<span class="required">*</span></label>
                                                    <select class="form-control" name="buyer_po_number" id="buyer_po_number">
                                                    </select>
                                            <p class="error buyer_po_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="buyer_po_date">Buyer PO Date <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="buyer_po_date" name="buyer_po_date" required readonly>
                                            <p class="error buyer_po_date_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fax">Remarks</label>
                                               <textarea type="text" class="form-control"  id="remark"  name="remark"> </textarea><p class="error fax_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savepackinginstarction" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>packinginstaruction'" class="btn btn-default" value="Back" />
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