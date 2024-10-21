<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> View OMS Challan
         <small>
            <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
               <li class="completed"><a href="javascript:void(0);">Masters</a></li>
               <li class="active"><a href="javascript:void(0);"> View OMS Challan Details</a></li>
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
                     <h3 class="box-title">View  OMS Challan Details</h3>
                  </div>
                  <?php $this->load->helper("form"); ?>
                  <form role="form" id="addnewomschallanform" action="#" method="post" role="form">
                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="blasting_id">Blasting Id<span class="required">*</span></label>
                                        <input type="hidden" class="form-control" id="oms_challan_id" name="oms_challan_id" value="<?=$getomsChllanData['challan_main_id'];?>" required readonly>
                                            <input readonly type="text" class="form-control" id="blasting_id" name="blasting_id" value="<?=$getomsChllanData['blasting_id'];?>" required readonly>
                                            <p class="error blasting_id_error"></p>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="oms_challan_date">OMS Challan Date <span class="required">*</span></label>
                                            <input readonly type="text" class="form-control datepicker" id="oms_challan_date" name="oms_challan_date" value="<?=$getomsChllanData['omsdate'];?>"  required >
                                            <p class="error oms_challan_date_error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                                <select readonly class="form-control" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                        <?php foreach ($vendorList as $key => $value) {?>
                                                            <option value="<?php echo $value['ven_id']; ?>" <?php if($getomsChllanData['vendor_name']==$value['ven_id']){ echo 'selected'; }?> ><?php echo $value['vendor_name']; ?></option>
                                                        <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-12 vendor_po_number_div" id="vendor_po_number_div">
                                    <div class="form-group">
                                        <?php 
                                            if($getomsChllanData['vendor_po_id']){
                                                $po_number=  '<option st-id="" value="'.$getomsChllanData['vendor_po_id'].'">'.$getomsChllanData['po_number'].'</option>';
                                            }else{
                                                $po_number= '<option st-id="" value="">Select Vendor Name</option>'; 
                                            }
                                        ?>
                                        <label for="vendor_po_number">Select Vendor PO Number</label>
                                            <select readonly class="form-control vendor_po_for_item vendor_po_get_data" name="vendor_po_number" id="vendor_po_number">
                                                <?php echo $po_number;?>
                                            </select>
                                        <p class="error vendor_po_number_error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">

                                           <?php 
                                            if($getomsChllanData['vendor_podate']){
                                                $vendor_po_date= $getomsChllanData['vendor_podate'];
                                            }else{
                                                $vendor_po_date= date('Y-m-d'); 
                                            }
                                            ?>

                                    <div class="form-group">
                                        <label for="buyer_po">Vendor PO Date</label>
                                            <input readonly type="text" class="form-control" id="vendor_po_date" name="vendor_po_date" value="<?=$vendor_po_date ?>" required readonly>
                                            <p class="error vendor_po_date_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">Remark</label>
                                        <input readonly type="remark" class="form-control" id="remark" name="remark" value="<?=$getomsChllanData['omsremark'] ?>">
                                        <p class="error remark_error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        
                        <div class="col-md-12">
                             <table class="table  table-bordered">
                                <thead style="background-color: #3c8dbc;">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Part Number</th>
                                        <th scope="col">F.G Description</th>
                                        <th scope="col">R.M Description</th>
                                        <th scope="col">Gross Weight</th>
                                        <th scope="col">Net Weight</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">No of Bags</th>
                                        <th scope="col">HSN No</th>
                                        <th scope="col">Remark</th>
                                    </tr>
                                    </thead>   

                                         <?php 
                                           if($getomsitemlistforedit){
                                               $i=1;
                                            foreach ($getomsitemlistforedit as $key => $value) { ?>
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
                                        
                                            <tr>   

                                          <?php  } }else{ ?>
                                            <tr>
                                               <td colspan="14"><p> <i>No OMS Challan Items Found</i></p></td>
                                            </tr>
                                         <?php } ?>

                                    <tbody>
                                </tbody>
                             </table> 
                        </div>
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <div class="col-xs-8">
                            <?php if($getomsitemlistforedit){ 
                            $button ="";
                            }else{
                            $button ="disabled";
                            } ?>
                           <input type="button" onclick="location.href = '<?php echo base_url() ?>omschallan'" class="btn btn-default" value="Back" />
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
                                               <input type="hidden" class="form-control"  id="oms_challan_item_id" name="oms_challan_item_id" required readonly>
    
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
                                                            <label for="unit">Unit</label>
            
                                                                    <select class="form-control" name="unit" id="unit">
                                                                        <option value="">Select Unit</option>
                                                                        <option value="kgs">Kgs</option>
                                                                        <option value="Pcs">Pcs</option>
                                                                        <option value="Nos">Nos</option>
                                                                        <option value="Sheet">Sheet</option>
                                                                       <option value="Set">Set</option>
<option value="Mtr">Mtr</option>
<option value="Ltr">Ltr</option>
                                                                    </select>
                                                                    <p class="error unit_error"></p>
                                                                
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="calculation">Calculation</label>
                                                                <input type="text" class="form-control" id="calculation" name="calculation">
                                                                <p class="error calculation_error"></p>
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
