<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> Edit QC Challan
         <small>
            <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
               <li class="completed"><a href="javascript:void(0);">Masters</a></li>
               <li class="active"><a href="javascript:void(0);"> Edit QC Challan Details</a></li>
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
                     <h3 class="box-title"> Edit QC Challan Details</h3>
                  </div>
                  <?php $this->load->helper("form"); ?>
                  <form role="form" id="addqchallanformid" action="#" method="post" role="form">
                     <div class="box-body">
                        <div class="col-md-4">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <input type="hidden" class="form-control" id="qc_challan_id" name="qc_challan_id" value="<?=$getqcdetailsforedit[0]['qc_challan_id'];?>" required readonly>


                                    <label for="challan_number">Challan Number <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="challan_number" name="challan_number" value="<?=$getqcdetailsforedit[0]['challan_number'];?>" required readonly>
                                        <p class="error challan_number_error"></p>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="challan_date">Challan Date <span class="required">*</span></label>
                                        <?php 
                                        if($getqcdetailsforedit[0]['challan_date']){
                                            $date= $getqcdetailsforedit[0]['challan_date'];
                                        }else{
                                            $date= date('Y-m-d'); 
                                        }
                                       ?>
                                        <input type="text" class="form-control datepicker" id="challan_date" name="challan_date" value="<?=$date?>"  required >
                                        <p class="error challan_date_error"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                            <select class="form-control" name="vendor_name" id="vendor_name">
                                                <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) { ?>
                                                        <option value="<?php echo $value['ven_id']; ?>" <?php if($getqcdetailsforedit[0]['vendor_id']==$value['ven_id']){ echo 'selected'; }?> ><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                            </select>
                                        <p class="error vendor_name_error"></p>
                                </div>
                            </div>
                    
                            <div class="col-md-12">
                                <div class="form-group">
                                        <label for="remark">Remark</label>
                                        <input type="remark" class="form-control" id="remark" value="<?=$getqcdetailsforedit[0]['remark']?>" name="remark">
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
                                        <th scope="col">Field 1</th>
                                        <th scope="col">Field 2</th>
                                        <th scope="col">Field 3</th>
                                        <th scope="col">Field 4</th>
                                        <th scope="col">Field 5</th>
                                        <th scope="col">Field 6</th>
                                        <th scope="col">Remark</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>   

                                         <?php 
                                           if($getqcitemdetailsedit){
                                               $i=1;
                                            foreach ($getqcitemdetailsedit as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo  $i++; ?></td>
                                                <td><?=$value['field_1']?></td>
                                                <td><?=$value['field_2']?></td>
                                                <td><?=$value['field_3']?></td>
                                                <td><?=$value['field_4']?></td>
                                                <td><?=$value['field_5']?></td>
                                                <td><?=$value['field_6']?></td>
                                                <td><?=$value['remark']?></td>
                                                <td>
                                                   <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['id'];?>' class='fa fa-pencil-square-o editQcchllanitem'  aria-hidden='true'></i>
                                                   <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['id'];?>' class='fa fa-trash-o deleteQcchllanitem' aria-hidden='true'></i>
                                                </td>
                                            <tr>   

                                          <?php  } }else{ ?>
                                            <tr>
                                               <td colspan="14"><p> <i>No QC Items Found</i></p></td>
                                            </tr>
                                         <?php } ?>

                                    <tbody>
                                </tbody>
                             </table> 
                        </div>
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <div class="col-xs-8">

                            <?php if($getqcitemdetailsedit){ 
                            $button ="";
                            }else{
                            $button ="disabled";
                            } ?>

                           <input type="submit" id="addqcchallanform" class="btn btn-primary" value="Submit" <?=$button?>>
                           <input type="button" onclick="location.href = '<?php echo base_url() ?>qcchallan'" class="btn btn-default" value="Back" />
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

                                        <div class="modal-dialog modal-xm" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="additem">Add New Item</h3>
                                                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                                                <!-- <span aria-hidden="true">&times;</span> -->
                                                </button>
                                            </div>
                                            <form role="form" id="saveQcchallanitemform" action="<?php echo base_url() ?>saveQcchallanitemform" method="post" role="form">
                                            <input type="hidden" class="form-control"  id="qc_challan_item_id" name="qc_challan_item_id" required readonly>

                                             <div class="modal-body">
                                                    <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="field_1">Field 1 <span class="required">*</span></label>
                                                                <input type="text" class="form-control" id="field_1" name="field_1" required>
                                                                <p class="error field_1_error"></p>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for="field_2">Field 2</label>
                                                                <input type="text" class="form-control" id="field_2" name="field_2">
                                                                <p class="error field_2_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="field_3">Field 3</label>
                                                                <input type="text" class="form-control" id="field_3" name="field_3">
                                                                <p class="error field_3_error"></p>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for="field_4">Field 4</label>
                                                                <input type="text" class="form-control" id="field_4" name="field_4">
                                                                <p class="error field_4_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="field_5">Field 5</label>
                                                                <input type="text" class="form-control" id="field_5" name="field_5">
                                                                <p class="error field_5_error"></p>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="field_6">Field 6</label>
                                                                <input type="text" class="form-control" id="field_6" name="field_6">
                                                                <p class="error field_6_error"></p>
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for="item_remark">Remark</label>
                                                                <input type="text" class="form-control" id="item_remark" name="item_remark">
                                                                <p class="error item_remark_error"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-xl closeQcchallanform" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="saveQcchallan_item" name="saveQcchallan_item" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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