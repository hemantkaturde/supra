<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Scrap Return
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Scrap Return Master</a></li>
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
                            <h3 class="box-title">Edit Scrap Return Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewScrapreturnform" action="<?php echo base_url() ?>addnewScrapreturnform" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-4">

                                    <input type="hidden" class="form-control" id="challan_table_id" name="challan_table_id" value="<?=$getScrapreturndetails[0]['id']?>" required readonly>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="challan_id">Challan Id<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="challan_id" name="challan_id" value="<?=$getScrapreturndetails[0]['challan_id']?>" required readonly>
                                            <p class="error challan_id_error"></p>
                                        </div>
                                    </div>

                                    
                                    <?php if($getScrapreturndetails[0]['challan_date']){
                                        $date= $getScrapreturndetails[0]['challan_date'];
                                     }else{
                                        $date= date('Y-m-d');
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="challan_date">Challan Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker"  value="<?=$date?>" id="challan_date" name="challan_date" required>
                                            <p class="error challan_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                            <div class="form-group">
                                                    <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                                    <select class="form-control" name="vendor_name" id="vendor_name">
                                                        <option st-id="" value="">Select Vendor Name</option>
                                                        <?php foreach ($vendorList as $key => $value) {?>
                                                        <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$getScrapreturndetails[0]['vendor_id']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                <p class="error vendor_name_error"></p>
                                            </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="supplier_name">Supplier Name </label>
                                                <select class="form-control" name="supplier_name" id="supplier_name">
                                                    <option st-id="" value="">Select Supplier Name</option>
                                                    <?php foreach ($supplierList as $key => $value) {?>
                                                    <option value="<?php echo $value['sup_id']; ?>" <?php if($value['sup_id']==$getScrapreturndetails[0]['supplier_id']){ echo 'selected';} ?> ><?php echo $value['supplier_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error supplier_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                  <textarea type="text" class="form-control"  id="remark"  name="remark" required> <?=$getScrapreturndetails[0]['remarks'];?></textarea>
                                                <p class="error remark_error"></p>
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="container">
                                        <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/>
                                            <table class="table table-bordered" style="width: 70% !important; max-width: 100%;margin-bottom: 20px;">
                                                <thead style="background-color:#3c8dbc;color:#fff">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Description</th>
                                                        <th>Gross Weight (In Kgs)</th>
                                                        <th>Net Weight (In Kgs)</th>
                                                        <th>Quantity/th>
                                                        <th>Number Of Bags</th>
                                                        <th>HSN Code</th>
                                                        <th>Estimated Value</th>
                                                        <th>Nature of Processing</th>
                                                        <th>Remark</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                          $count=0;
                                                           foreach ($fetchALLprescrapreturndetailsforview as $key => $value) :
                                                           $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['description'];?></td>
                                                        <td><?php echo $value['gross_weight'];?></td>
                                                        <td><?php echo $value['net_weight'];?></td>
                                                        <td><?php echo $value['quantity'];?></td>
                                                        <td><?php echo $value['number_of_bags'];?></td>
                                                        <td><?php echo $value['hsn_code'];?></td>
                                                        <td><?php echo $value['estimated_value'];?></td>
                                                        <td><?php echo $value['number_of_processing'];?></td>
                                                        <td><?php echo $value['remarks'];?></td>
                                                        <td>
                                                        <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['scrapreturnid'];?>' class='fa fa-pencil-square-o editScrpareturnid'  aria-hidden='true'></i>

                                                        <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['scrapreturnid'];?>' class='fa fa-trash-o deleteScrpareturnid' aria-hidden='true'></i>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                    </div>

                                

                                      <!-- Add New Package Modal -->
                                    <?php $this->load->helper("form"); ?>
                                    <div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="additem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                      
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="additem">Add New Item</h3>
                                                </button>
                                            </div>
                                            <form role="form" id="addscrapreturnform" action="<?php echo base_url() ?>addscrapreturnform" method="post" role="form">
                                            <input type="hidden" class="form-control"  id="scrap_item_id" name="scrap_item_id" required readonly>
    
                                            <div class="modal-body">
                                                    <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Description <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="description" id="description">
                                                                <option st-id="" value="">Select Description</option>
                                                                    <option value="Brass Generated Scrap">Brass Generated Scrap</option>
                                                                    <option value="Brass REjection PCS">Brass Rejection PCS</option>
                                                            </select>
                                                            <p class="error description_error"></p>
                                                        </div>
                                                    </div>
                    
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Gross Weight (In Kgs)</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="gross_weight" name="gross_weight" required>
                                                            <p class="error gross_weight_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Net Weight (In Kgs)</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="net_weight" name="net_weight" required>
                                                            <p class="error  net_weight_error"></p>
                                                        </div>
                                                    </div>
                                                   

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Quantity</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="quantity" name="quantity" required>
                                                            <p class="error  quantity_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Number Of Bags</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="number_of_bags" name="number_of_bags" required>
                                                            <p class="error number_of_bags_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">HSN Code</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="hsn_code" id="hsn_code">
                                                                <option st-id="" value="">Select HSN Code</option>
                                                                    <option value="74040029" selected>74040029</option>
                                                            </select>
                                                            <p class="error description_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Estimated Value</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="estimated_value" name="estimated_value" required>
                                                            <p class="error estimated_value_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Nature of Processing </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="number_of_processing" id="number_of_processing">
                                                                <option st-id="" value="">Select Nature of Processing</option>
                                                                    <option value="Convert Into Brass" selected>Convert Into Brass</option>
                                                            </select>
                                                            <p class="error number_of_processing_error"></p>
                                                        </div>
                                                    </div>
                    

                                                    
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Remark</label>
                                                        <div class="col-sm-8">
                                                           <textarea type="text" class="form-control"  id="item_remark"  name="item_remark"></textarea>
                                                           <p class="error item_remark_error"></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-xl closeScrapreturn" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="savescrapreturnitem" name="savescrapreturnitem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
                                                </div>

                                            </form>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>

                               

                            </div>    
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-xs-8">
                                <?php if($fetchALLprescrapreturndetailsforview){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>
                                    <input type="submit" id="saveScrapreturn" class="btn btn-primary" value="Submit"  <?=$disabled?> />
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>scrapreturn'" class="btn btn-default" value="Back" />
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

