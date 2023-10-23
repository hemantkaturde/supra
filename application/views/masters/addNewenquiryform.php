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
                  <form role="form" id="addnewomschallanform" action="#" method="post" role="form">
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
                                        <label for="remark">Buyer Enquiry No <span class="required">*</span></label>
                                        <input type="remark" class="form-control" id="remark" name="remark" value="<?=$getomschallanitems[0]['pre_remark'] ?>">
                                        <p class="error remark_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">Buyer Enquiry Date <span class="required">*</span></label>
                                        <input type="remark" class="form-control" id="remark" name="remark" value="<?=$getomschallanitems[0]['pre_remark'] ?>">
                                        <p class="error remark_error"></p>
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
                                                <td><?=$value['omsnet_weight']?></td>
                                                <td><?=$value['omsqty']?></td>
                                                <td><?=$value['no_of_bags']?></td>
                                                <td><?=$value['hsn_no']?></td>
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
                           <input type="submit" id="addnewomschallan" class="btn btn-primary" value="Submit" <?=$button?>>
                           <input type="button" onclick="location.href = '<?php echo base_url() ?>addNewOMSChallan'" class="btn btn-default" value="Back" />
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
                                                </button>
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

                                                        </div>
                                                        <div class="col-md-6">

                                                            <div class="form-group">
                                                                <label for="net_weight">Net Weight</label>
                                                                <input type="text" class="form-control" id="net_weight" name="net_weight">
                                                                <p class="error net_weight_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="qty">Qty</label>
                                                                <input type="number" class="form-control" id="qty" name="qty" >
                                                                <p class="error qty_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="no_of_bags">No Of Bags</label>
                                                                <input type="number" class="form-control" id="no_of_bags" name="no_of_bags" >
                                                                <p class="error no_of_bags_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="hsn_no">HSN No</label>
                                                                <input type="text" class="form-control" id="hsn_no" name="hsn_no" readonly>
                                                                <p class="error hsn_no_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="itemremark">Remark</label>
                                                                <input type="text" class="form-control" id="itemremark" name="itemremark">
                                                                <p class="error itemremark_error"></p>
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
