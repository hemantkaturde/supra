<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> Add New Enquiry Form
         <small>
            <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
               <li class="completed"><a href="javascript:void(0);">Masters</a></li>
               <li class="active"><a href="javascript:void(0);"> Enquiry Form</a></li>
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
                     <h3 class="box-title">Add New Enquiry Form</h3>
                  </div>
                  <?php $this->load->helper("form"); ?>
                  <form role="form" id="addnewenauiryform" action="#" method="post" role="form">
                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="enquiry_number">Enquiry Number<span class="required">*</span></label>
                                        <?php
                                            if($getpreviuousblasterId['enquiry_number']){
                                                $arr = str_split($getpreviuousblasterId['enquiry_number']);
                                                $i = end($arr);
                                                $inrno= str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                                $enquiry_number = $inrno;
                                            }else{
                                                $enquiry_number = '0001';
                                            }
                                        ?>
                                            <input type="text" class="form-control" id="enquiry_number" name="enquiry_number" value="<?=$enquiry_number;?>" required readonly>
                                            <p class="error enquiry_number_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="enquiry_date">Enquiry Date <span class="required">*</span></label>
                                            <?php 
                                            if($getomschallanitems[0]['pre_oms_challan_date']){
                                                $date= $getomschallanitems[0]['pre_oms_challan_date'];
                                            }else{
                                                $date= date('Y-m-d'); 
                                            }
                                            ?>
                                            <input type="text" class="form-control datepicker" id="enquiry_date" name="enquiry_date" value="<?=$date?>"  required >
                                            <p class="error enquiry_date_error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="buyer_enquiry_no">Buyer Enquiry No <span class="required">*</span></label>
                                        <input type="buyer_enquiry_no" class="form-control" id="buyer_enquiry_no" name="buyer_enquiry_no" value="<?=$getomschallanitems[0]['pre_remark'] ?>">
                                        <p class="error buyer_enquiry_no_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="buyer_enquiry_date">Buyer Enquiry Date <span class="required">*</span></label>
                                         <?php 
                                            if($getomschallanitems[0]['pre_enquiry_date']){
                                                $buyer_enquiry_date= $getomschallanitems[0]['pre_enquiry_date'];
                                            }else{
                                                $buyer_enquiry_date= date('Y-m-d'); 
                                            }
                                            ?>
                                        <input type="buyer_enquiry_date" class="form-control datepicker" id="buyer_enquiry_date" name="buyer_enquiry_date" value="<?=$buyer_enquiry_date; ?>">
                                        <p class="error buyer_enquiry_date_error"></p>
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
                        
                        <div class="col-md-12">
                           <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/>
                             <table class="table  table-bordered">
                                <thead style="background-color: #3c8dbc;">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Enquiry Number</th>
                                        <th scope="col">Enquiry Date</th>
                                        <th scope="col">Buyer Enquiry No</th>
                                        <th scope="col">Buyer Enquiry Date</th>
                                        <th scope="col">Remark</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>   

                                         <?php 
                                           if($getomschallanitems){
                                               $i=1;
                                            foreach ($getomschallanitems as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo  $i++; ?></td>
                                                <td><?=$value['part_number']?></td>
                                                <td><?=$value['fgdiscription']?></td>
                                                <td><?=$value['type_of_raw_material']?></td>
                                                <td><?=$value['omsgross_weight']?></td>
                                                <td><?=$value['omsremark']?></td>
                                                <td>
                                                   <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['omsid'];?>' class='fa fa-trash-o deleteOmschallnitem' aria-hidden='true'></i>
                                                </td>
                                            <tr>   

                                          <?php  } }else{ ?>
                                            <tr>
                                               <td colspan="14"><p> <i>No Enquiry Form Items Found</i></p></td>
                                            </tr>
                                         <?php } ?>

                                    <tbody>
                                </tbody>
                             </table> 
                        </div>
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <div class="col-xs-8">
                            <?php if($getomschallanitems){ 
                            $button ="";
                            }else{
                            $button ="disabled";
                            } ?>
                           <input type="submit" id="savenewenauiryform" class="btn btn-primary" value="Submit" <?=$button?>>
                           <input type="button" onclick="location.href = '<?php echo base_url() ?>enquiryform'" class="btn btn-default" value="Back" />
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

    <!-- Add New Package Modal -->
    <?php $this->load->helper("form"); ?>
    <div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="additem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="additem">Add New Item</h3>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                        <!-- <span aria-hidden="true">&times;</span> -->
                        <!-- </button> -->                        
                </div>                                     
                <form role="form" id="saveomschallanform" action="<?php echo base_url() ?>saveomschallanform" method="post" role="form">
                    <div class="modal-body">
                        <div class="loader_ajax" style="display:none;">
                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="part_number">F.G Part Number <span class="required">*</span></label>
                                        <select class="form-control" name="part_number" id="part_number">
                                            <option st-id="" value="">Select F.G Part Number</option>
                                         </select>
                                        <p class="error part_number_error"></p>
                                </div>                   
                                <div class="form-group">
                                    <label for="fg_description">F.G. Description</label>
                                    <input type="text" class="form-control" id="fg_description" name="fg_description" readonly>
                                    <p class="error fg_description_error"></p>
                                </div>
                                <div class="form-group">
                                    <label for="rm_description">R.M Description</label>
                                    <input type="text" class="form-control" id="rm_description" name="rm_description" readonly>
                                    <p class="error rm_description_error"></p>
                                </div>               
                                <div class="form-group">
                                    <label for="gross_weight">Gross Weight</label>
                                    <input type="text" class="form-control" id="gross_weight" name="gross_weight">
                                    <p class="error gross_weight_error"></p>
                                </div>
                                <div class="form-group">
                                    <label for="net_weight">RM Size</label>
                                    <input type="text" class="form-control" id="net_weight" name="net_weight">
                                    <p class="error net_weight_error"></p>
                                </div>
                                <div class="form-group">
                                    <label for="qty">Qty</label>
                                    <input type="number" class="form-control" id="qty" name="qty" >
                                    <p class="error qty_error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                               
                                       <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="supplier_name_1">Supplier Name</label>
                                                <select class="form-control" name="supplier_name_1" id="supplier_name_1" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                </select>
                                                <p class="error supplier_name_1_error"></p>
                                            </div>
                                            <div>
                                                <label for="rate_1">Rate</label>
                                                <input type="text" class="form-control" id="rate_1" name="rate_1" readonly>
                                                <p class="error rate_1_error"></p>
                                            </div>
                                        </div>
                           
                               
                                       <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="supplier_name_2">Supplier Name</label>
                                                <select class="form-control" name="supplier_name_2" id="supplier_name_2" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                </select>
                                                <p class="error supplier_name_2_error"></p>
                                            </div>
                                            <div>
                                                <label for="rate_2">Rate</label>
                                                <input type="text" class="form-control" id="rate_2" name="rate_2" readonly>
                                                <p class="error rate_2_error"></p>
                                            </div>
                                        </div>
                        
                              
                                       <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="supplier_name_3">Supplier Name</label>
                                                <select class="form-control" name="supplier_name_3" id="supplier_name_3" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                </select>
                                                <p class="error supplier_name_3_error"></p>
                                            </div>
                                            <div>
                                                <label for="rate_3">Rate</label>
                                                <input type="text" class="form-control" id="rate_3" name="rate_3" readonly>
                                                <p class="error rate_3_error"></p>
                                            </div>
                                        </div>
                               
                            
                                       <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="supplier_name_4">Supplier Name</label>
                                                <select class="form-control" name="supplier_name_4" id="supplier_name_4" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                </select>
                                                <p class="error supplier_name_4_error"></p>
                                            </div>
                                            <div>
                                                <label for="rate_4">Rate</label>
                                                <input type="text" class="form-control" id="rate_4" name="rate_4" readonly>
                                                <p class="error rate_4_error"></p>
                                            </div>
                                        </div>

                                        <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="supplier_name_5">Supplier Name</label>
                                                <select class="form-control" name="supplier_name_5" id="supplier_name_5" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                </select>
                                                <p class="error supplier_name_5_error"></p>
                                            </div>
                                            <div>
                                                <label for="rate_5">Rate</label>
                                                <input type="text" class="form-control" id="rate_5" name="rate_5" readonly>
                                                <p class="error rate_5_error"></p>
                                            </div>
                                        </div>

                                        <!-- Vendor Data -->
                                        <hr>

                                        <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="vendor_name_1">Vendor Name</label>
                                                <select class="form-control" name="vendor_name_1" id="vendor_name_1" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                </select>
                                                <p class="error vendor_name_1_error"></p>
                                            </div>
                                            <div>
                                                <label for="venodr_rate_1">Rate</label>
                                                <input type="text" class="form-control" id="venodr_rate_1" name="venodr_rate_1" readonly>
                                                <p class="error venodr_rate_1_error"></p>
                                            </div>
                                        </div>
                           
                               
                                       <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="supplier_name_2">Vendor Name</label>
                                                <select class="form-control" name="supplier_name_2" id="supplier_name_2" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                </select>
                                                <p class="error supplier_name_2_error"></p>
                                            </div>
                                            <div>
                                                <label for="venodr_rate_2">Rate</label>
                                                <input type="text" class="form-control" id="venodr_rate_2" name="venodr_rate_2" readonly>
                                                <p class="error venodr_rate_2_error"></p>
                                            </div>
                                        </div>
                        
                              
                                       <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="supplier_name_3">Vendor Name</label>
                                                <select class="form-control" name="supplier_name_3" id="supplier_name_3" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                </select>
                                                <p class="error supplier_name_3_error"></p>
                                            </div>
                                            <div>
                                                <label for="venodr_rate_3">Rate</label>
                                                <input type="text" class="form-control" id="venodr_rate_3" name="venodr_rate_3" readonly>
                                                <p class="error venodr_rate_3_error"></p>
                                            </div>
                                        </div>
                               
                            
                                       <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="supplier_name_4">Vendor Name</label>
                                                <select class="form-control" name="supplier_name_4" id="supplier_name_4" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                </select>
                                                <p class="error supplier_name_4_error"></p>
                                            </div>
                                            <div>
                                                <label for="venodr_rate_4">Rate</label>
                                                <input type="text" class="form-control" id="venodr_rate_4" name="venodr_rate_4" readonly>
                                                <p class="error venodr_rate_4_error"></p>
                                            </div>
                                        </div>

                                        <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="supplier_name_5">Vendor Name</label>
                                                <select class="form-control" name="supplier_name_5" id="supplier_name_5" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                </select>
                                                <p class="error supplier_name_5_error"></p>
                                            </div>
                                            <div>
                                                <label for="venodr_rate_5">Rate</label>
                                                <input type="text" class="form-control" id="venodr_rate_5" name="venodr_rate_5" readonly>
                                                <p class="error venodr_rate_5_error"></p>
                                            </div>
                                        </div>
                            
                               
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-xl closebillofmaterialmodal" data-dismiss="modal">Close</button>
                        <button type="submit" id="saveomschallan_item" name="saveomschallan_item" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
                    </div>
                </form>    
                </div>
            </div>
        </div>      
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
