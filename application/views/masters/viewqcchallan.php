<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-users"></i> View QC Challan
         <small>
            <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
               <li class="completed"><a href="javascript:void(0);">Masters</a></li>
               <li class="active"><a href="javascript:void(0);"> View QC Challan Details</a></li>
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
                     <h3 class="box-title"> View QC Challan Details</h3>
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
                                        <input type="text" class="form-control datepicker" id="challan_date" name="challan_date" value="<?=$date?>"  required readonly>
                                        <p class="error challan_date_error"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                            <select class="form-control" name="vendor_name" id="vendor_name" readonly>
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
                                        <input type="remark" class="form-control" id="remark" value="<?=$getqcdetailsforedit[0]['remark']?>" name="remark" readonly>
                                        <p class="error remark_error"></p>
                                </div>
                            </div>
                          </div>
                        </div>  
                        
                        <div class="col-md-12">
                           <!-- <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/> -->
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
                          <!-- <input type="submit" id="addqcchallanform" class="btn btn-primary" value="Submit" <?=$button?>> -->
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


  