<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> View Enquiry Form
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
                     <h3 class="box-title">Edit Enquiry Form</h3>
                  </div>
                  <?php $this->load->helper("form"); ?>
                  <form role="form" id="addnewenauiryform" action="#" method="post" role="form">

                   <input readonly  type="hidden" class="form-control" id="enquiry_form_id" name="enquiry_form_id" value="<?=$getenquirydetailsforedit['enquiry_form_id'];?>" required readonly>

                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                            <label for="enquiry_number">Enquiry Number<span class="required">*</span></label>
                                             <input readonly  type="text" class="form-control" id="enquiry_number" name="enquiry_number" value="<?=$getenquirydetailsforedit['enquiry_number'];?>" required readonly>
                                            <p class="error enquiry_number_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="enquiry_date">Enquiry Date <span class="required">*</span></label>
                                            <?php 
                                            if($getenquirydetailsforedit['date']){
                                                $date= $getenquirydetailsforedit['date'];
                                            }else{
                                                $date= date('Y-m-d'); 
                                            }
                                            ?>
                                             <input readonly  type="text" class="form-control datepicker" id="enquiry_date" name="enquiry_date" value="<?=$date?>"  required >
                                            <p class="error enquiry_date_error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="buyer_enquiry_no">Buyer Name<span class="required">*</span></label>
                                         <input readonly  type="buyer_enquiry_no" class="form-control" id="buyer_enquiry_no" name="buyer_enquiry_no" value="<?=$getenquirydetailsforedit['buyer_name'] ?>">
                                        <p class="error buyer_enquiry_no_error"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="buyer_enquiry_date">Buyer Enquiry Date <span class="required">*</span></label>
                                         <?php 
                                            if($getenquirydetailsforedit['buyer_enquiry_date']){
                                                $buyer_enquiry_date= $getenquirydetailsforedit['buyer_enquiry_date'];
                                            }else{
                                                $buyer_enquiry_date= date('Y-m-d'); 
                                            }
                                            ?>
                                         <input readonly  type="buyer_enquiry_date" class="form-control datepicker" id="buyer_enquiry_date" name="buyer_enquiry_date" value="<?=$buyer_enquiry_date; ?>">
                                        <p class="error buyer_enquiry_date_error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                            <select readonly  class="form-control" name="status" id="status">
                                                <option value="">Select Status</option>
                                                <option value="Open"  <?php if($getenquirydetailsforedit['enquiry_status']=='Open'){ echo 'selected';} ?>>Open</option>
                                                <option value="Close" <?php if($getenquirydetailsforedit['enquiry_status']=='Close'){ echo 'selected';} ?>>Close</option>
                                            </select>
                                        <p class="error status_error"></p>
                                    </div>
                                </div>
                            </div>    

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">Remark</label>
                                         <input readonly  type="remark" class="form-control" id="remark" name="remark" value="<?=$getenquirydetailsforedit['remark'] ?>">
                                        <p class="error remark_error"></p>
                                    </div>
                                </div>
                            </div>    

                        </div>  
                        
                        <div class="col-md-12">
                             <table class="table  table-bordered" style="max-width: 100%;display: block;overflow-x: auto; white-space: nowrap;">
                                <thead style="background-color: #3c8dbc;">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">F.G Part Number</th>
                                        <th scope="col">F.G. Description</th>
                                        <th scope="col">R.M Description</th>
                                        <th scope="col">Gross Weight</th>
                                        <th scope="col">Raw material grade</th>
                                        <th scope="col">Supplier Qty (in kgs)</th>
                                        <th scope="col">Vendor Qty (in pcs)</th>
                                        <th scope="col">Supplier Name</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Supplier Name</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Supplier Name</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Supplier Name</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Supplier Name</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Vendor Name</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Vendor Name</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Vendor Name</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Vendor Name</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Vendor Name</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>   

                                         <?php 
                                           if($getallenquiryformitemedit){
                                               $i=1;
                                            foreach ($getallenquiryformitemedit as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo  $i++; ?></td>
                                                <td><?=$value['part_number']?></td>
                                                <td><?=$value['name']?></td>
                                                <td><?=$value['rm_description']?></td>
                                                <td><?=$value['engroass_weight']?></td>
                                                <td><?=$value['rm_size']?></td>
                                                <td><?=$value['supplier_qty_in_kgs']?></td>
                                                <td><?=$value['venodr_qty_in_pcs']?></td>
                                               
                                                <td><?=$value['suplier_id_name_1']?></td>
                                                <td><?=$value['suplier_rate_1']?></td>
                                                <td><?=$value['suplier_id_name_2']?></td>
                                                <td><?=$value['suplier_rate_2']?></td>
                                                <td><?=$value['suplier_id_name_3']?></td>
                                                <td><?=$value['suplier_rate_3']?></td>
                                                <td><?=$value['suplier_id_name_4']?></td>
                                                <td><?=$value['suplier_rate_4']?></td>
                                                <td><?=$value['suplier_id_name_5']?></td>
                                                <td><?=$value['suplier_rate_5']?></td>


                                                <td><?=$value['vendor_name_1']?></td>
                                                <td><?=$value['vendor_rate_1']?></td>
                                                <td><?=$value['vendor_name_2']?></td>
                                                <td><?=$value['vendor_rate_2']?></td>
                                                <td><?=$value['vendor_name_3']?></td>
                                                <td><?=$value['vendor_rate_3']?></td>
                                                <td><?=$value['vendor_name_4']?></td>
                                                <td><?=$value['vendor_rate_4']?></td>
                                                <td><?=$value['vendor_name_5']?></td>
                                                <td><?=$value['vendor_rate_5']?></td>

                                               
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
                           <!--  <input readonly  type="submit" id="savenewenauiryform" class="btn btn-primary" value="Submit"> -->
                            <input readonly  type="button" onclick="location.href = '<?php echo base_url() ?>enquiryform'" class="btn btn-default" value="Back" />
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
                 <input readonly  type="hidden" class="form-control"  id="enquiry_form_item_id" name="enquiry_form_item_id" required readonly>

                    <div class="modal-body">
                        <div class="loader_ajax" style="display:none;">
                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="part_number">F.G Part Number <span class="required">*</span></label>
                                        <select readonly  class="form-control" name="part_number" id="part_number">
                                            <option st-id="" value="">Select F.G Part Number</option>
                                            <?php foreach ($partNumberlistforenquirylist as $key => $value) {?>
                                                <option st-id="" value="<?=$value['fin_id']?>"><?=$value['part_number']?></option>
                                            <?php } ?>
                                         </select>
                                        <p class="error part_number_error"></p>
                                </div>                   
                                <div class="form-group">
                                    <label for="fg_description">F.G. Description</label>
                                     <input readonly  type="text" class="form-control" id="fg_description" name="fg_description" readonly>
                                    <p class="error fg_description_error"></p>
                                </div>
                                <div class="form-group">
                                    <label for="rm_description">R.M Description</label>
                                     <input readonly  type="text" class="form-control" id="rm_description" name="rm_description">
                                    <p class="error rm_description_error"></p>
                                </div>               
                                <div class="form-group">
                                    <label for="gross_weight">Gross Weight</label>
                                     <input readonly  type="text" class="form-control" id="gross_weight" name="gross_weight">
                                    <p class="error gross_weight_error"></p>
                                </div>
                                <div class="form-group">
                                    <label for="rm_size">Raw material grade</label>
                                     <input readonly  type="text" class="form-control" id="rm_size" name="rm_size">
                                    <p class="error rm_size_error"></p>
                                </div>
                                <div class="form-group">
                                    <label for="supplier_qty_in_kgs">Supplier Qty (in kgs)</label>
                                     <input readonly  type="number" class="form-control" id="supplier_qty_in_kgs" name="supplier_qty_in_kgs" >
                                    <p class="error supplier_qty_in_kgs_error"></p>
                                </div>

                                <div class="form-group">
                                    <label for="venodr_qty_in_pcs">Vendor Qty (in pcs)</label>
                                     <input readonly  type="number" class="form-control" id="venodr_qty_in_pcs" name="venodr_qty_in_pcs" >
                                    <p class="error venodr_qty_in_pcs_error"></p>
                                </div>
                            </div>

                                 <div class="col-md-6">
                                       <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="supplier_name_1">Supplier Name</label>
                                                <select readonly  class="form-control" name="supplier_name_1" id="supplier_name_1" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                    <?php foreach ($supplierList as $key => $value) {?>
                                                        <option st-id="" value="<?=$value['sup_id']?>"><?=$value['supplier_name']?></option>
                                                    <?php }?>
                                                </select>
                                                <p class="error supplier_name_1_error"></p>
                                            </div>
                                            <div>
                                                <label for="rate_1">Rate</label>
                                                 <input readonly  type="text" class="form-control" id="rate_1" name="rate_1">
                                                <p class="error rate_1_error"></p>
                                            </div>
                                        </div>
                           
                                        <div class="row">
                                            <div>
                                                <label for="remark_10">Remark </label>
                                                 <input readonly  type="text" class="form-control" id="remark_1" name="remark_1" style="width:95%;">
                                                <p class="error remark_1_error"></p>
                                            </div>
                                        </div>
                               
                                       <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="supplier_name_2">Supplier Name</label>
                                                <select readonly  class="form-control" name="supplier_name_2" id="supplier_name_2" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                    <?php foreach ($supplierList as $key => $value) {?>
                                                        <option st-id="" value="<?=$value['sup_id']?>"><?=$value['supplier_name']?></option>
                                                    <?php }?>
                                                </select>
                                                <p class="error supplier_name_2_error"></p>
                                            </div>
                                            <div>
                                                <label for="rate_2">Rate</label>
                                                 <input readonly  type="text" class="form-control" id="rate_2" name="rate_2">
                                                <p class="error rate_2_error"></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div>
                                                <label for="remark_2">Remark </label>
                                                 <input readonly  type="text" class="form-control" id="remark_2" name="remark_2" style="width:95%;">
                                                <p class="error remark_2_error"></p>
                                            </div>
                                        </div>
                        
                              
                                       <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="supplier_name_3">Supplier Name</label>
                                                <select readonly  class="form-control" name="supplier_name_3" id="supplier_name_3" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                    <?php foreach ($supplierList as $key => $value) {?>
                                                        <option st-id="" value="<?=$value['sup_id']?>"><?=$value['supplier_name']?></option>
                                                    <?php }?>
                                                </select>
                                                <p class="error supplier_name_3_error"></p>
                                            </div>
                                            <div>
                                                <label for="rate_3">Rate</label>
                                                 <input readonly  type="text" class="form-control" id="rate_3" name="rate_3">
                                                <p class="error rate_3_error"></p>
                                            </div>
                                        </div>
                               
                                        <div class="row">
                                            <div>
                                                <label for="remark_3">Remark </label>
                                                 <input readonly  type="text" class="form-control" id="remark_3" name="remark_3" style="width:95%;">
                                                <p class="error remark_3_error"></p>
                                            </div>
                                        </div>
                            
                                       <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="supplier_name_4">Supplier Name</label>
                                                <select readonly  class="form-control" name="supplier_name_4" id="supplier_name_4" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                    <?php foreach ($supplierList as $key => $value) {?>
                                                        <option st-id="" value="<?=$value['sup_id']?>"><?=$value['supplier_name']?></option>
                                                    <?php }?>
                                                </select>
                                                <p class="error supplier_name_4_error"></p>
                                            </div>
                                            <div>
                                                <label for="rate_4">Rate</label>
                                                 <input readonly  type="text" class="form-control" id="rate_4" name="rate_4">
                                                <p class="error rate_4_error"></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div>
                                                <label for="remark_4">Remark </label>
                                                 <input readonly  type="text" class="form-control" id="remark_4" name="remark_4" style="width:95%;">
                                                <p class="error remark_4_error"></p>
                                            </div>
                                        </div>

                                        <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="supplier_name_5">Supplier Name</label>
                                                <select readonly  class="form-control" name="supplier_name_5" id="supplier_name_5" style="width: 240px">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                    <?php foreach ($supplierList as $key => $value) {?>
                                                        <option st-id="" value="<?=$value['sup_id']?>"><?=$value['supplier_name']?></option>
                                                    <?php }?>
                                                </select>
                                                <p class="error supplier_name_5_error"></p>
                                            </div>
                                            <div>
                                                <label for="rate_5">Rate</label>
                                                 <input readonly  type="text" class="form-control" id="rate_5" name="rate_5">
                                                <p class="error rate_5_error"></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div>
                                                <label for="remark_5">Remark </label>
                                                 <input readonly  type="text" class="form-control" id="remark_5" name="remark_5" style="width:95%;">
                                                <p class="error remark_5_error"></p>
                                            </div>
                                        </div>

                                        <!-- Vendor Data -->
                                        <hr>

                                        <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="vendor_name_1">Vendor Name</label>
                                                <select readonly  class="form-control" name="vendor_name_1" id="vendor_name_1" style="width: 240px">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                        <option st-id="" value="<?=$value['ven_id']?>"><?=$value['vendor_name']?></option>
                                                    <?php }?>
                                                </select>
                                                <p class="error vendor_name_1_error"></p>
                                            </div>
                                            <div>
                                                <label for="venodr_rate_1">Rate</label>
                                                 <input readonly  type="text" class="form-control" id="venodr_rate_1" name="venodr_rate_1">
                                                <p class="error venodr_rate_1_error"></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div>
                                                <label for="remark_6">Remark </label>
                                                 <input readonly  type="text" class="form-control" id="remark_6" name="remark_6" style="width:95%;">
                                                <p class="error remark_6_error"></p>
                                            </div>
                                        </div>
                           
                               
                                       <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="vendor_name_2">Vendor Name</label>
                                                <select readonly  class="form-control" name="vendor_name_2" id="vendor_name_2" style="width: 240px">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                        <option st-id="" value="<?=$value['ven_id']?>"><?=$value['vendor_name']?></option>
                                                    <?php }?>
                                                </select>
                                                <p class="error vendor_name_2_error"></p>
                                            </div>
                                            <div>
                                                <label for="venodr_rate_2">Rate</label>
                                                 <input readonly  type="text" class="form-control" id="venodr_rate_2" name="venodr_rate_2">
                                                <p class="error venodr_rate_2_error"></p>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div>
                                                <label for="remark_7">Remark </label>
                                                 <input readonly  type="text" class="form-control" id="remark_7" name="remark_7" style="width:95%;">
                                                <p class="error remark_7_error"></p>
                                            </div>
                                        </div>
                              
                                       <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="vendor_name_3">Vendor Name</label>
                                                <select readonly  class="form-control" name="vendor_name_3" id="vendor_name_3" style="width: 240px">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                        <option st-id="" value="<?=$value['ven_id']?>"><?=$value['vendor_name']?></option>
                                                    <?php }?>
                                                </select>
                                                <p class="error vendor_name_3_error"></p>
                                            </div>
                                            <div>
                                                <label for="venodr_rate_3">Rate</label>
                                                 <input readonly  type="text" class="form-control" id="venodr_rate_3" name="venodr_rate_3">
                                                <p class="error venodr_rate_3_error"></p>
                                            </div>
                                        </div>
                               
                                        <div class="row">
                                            <div>
                                                <label for="remark_8">Remark </label>
                                                 <input readonly  type="text" class="form-control" id="remark_8" name="remark_8" style="width:95%;">
                                                <p class="error remark_8_error"></p>
                                            </div>
                                        </div>
                            
                                       <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="vendor_name_4">Vendor Name</label>
                                                <select readonly  class="form-control" name="vendor_name_4" id="vendor_name_4" style="width: 240px">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                        <option st-id="" value="<?=$value['ven_id']?>"><?=$value['vendor_name']?></option>
                                                    <?php }?>
                                                </select>
                                                <p class="error vendor_name_4_error"></p>
                                            </div>
                                            <div>
                                                <label for="venodr_rate_4">Rate</label>
                                                 <input readonly  type="text" class="form-control" id="venodr_rate_4" name="venodr_rate_4">
                                                <p class="error venodr_rate_4_error"></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div>
                                                <label for="remark_9">Remark </label>
                                                 <input readonly  type="text" class="form-control" id="remark_9" name="remark_9" style="width:95%;">
                                                <p class="error remark_9_error"></p>
                                            </div>
                                        </div>

                                        <div class="row" style="display: inline-flex;">
                                            <div style="padding-right: 10px">
                                                <label for="vendor_name_5">Vendor Name</label>
                                                <select readonly  class="form-control" name="vendor_name_5" id="vendor_name_5" style="width: 240px">
                                                   <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                        <option st-id="" value="<?=$value['ven_id']?>"><?=$value['vendor_name']?></option>
                                                    <?php }?>
                                                </select>
                                                <p class="error vendor_name_5_error"></p>
                                            </div>
                                            <div>
                                                <label for="venodr_rate_5">Rate</label>
                                                 <input readonly  type="text" class="form-control" id="venodr_rate_5" name="venodr_rate_5">
                                                <p class="error venodr_rate_5_error"></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div>
                                                <label for="remark_10">Remark </label>
                                                 <input readonly  type="text" class="form-control" id="remark_10" name="remark_10" style="width:95%;">
                                                <p class="error remark_10_error"></p>
                                            </div>
                                        </div>
                            
                               
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="saveenquiryform_item" name="saveenquiryform_item" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
