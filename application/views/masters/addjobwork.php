<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Job Work
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Job Work Master</a></li>
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
                            <h3 class="box-title">Add Job Work Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnnewjobworkform" action="<?php echo base_url() ?>addnnewjobworkform" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-4">

                                    <?php
                                        if($getPreviousjobworkponumber['po_number']){
                                            $arr = str_split($getPreviousjobworkponumber['po_number']);
                                            $i = end($arr);
                                            $inrno= "SQJW2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            $po_number = $inrno;
                                        }else{
                                            $po_number = 'SQJW23240001';
                                        }
                                    ?>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="job_work_no">JoB Work No<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="job_work_no" name="job_work_no" value="<?=$po_number?>" required readonly>
                                            <p class="error job_work_no_error"></p>
                                        </div>
                                    </div>


                                    <?php if($fetchALLprejobworkitemList[0]['pre_date']){
                                        $date= $fetchALLprejobworkitemList[0]['pre_date'];
                                     }else{
                                        $date= date('Y-m-d');
                                     } ?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date">Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker"  value="<?=$date?>" id="date" name="date" required>
                                            <p class="error date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_name">Vendor Name <span class="required">*</span></label>
                                                <select class="form-control vendor_name" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>" <?php if($value['ven_id']==$fetchALLprejobworkitemList[0]['pre_vendor_name']){ echo 'selected';} ?>><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="vendor_po_number">Select Vendor PO Number <span class="required">*</span></label>
                                                    <select class="form-control vendor_po_number_itam" name="vendor_po_number" id="vendor_po_number" readonly>
                                                        <option st-id="" value="">Select Vendor Name</option>
                                                    </select>
                                            <p class="error vendor_po_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="raw_material_supplier_name">Raw Material Supplier Name<span class="required">*</span></label>
                                                    <select class="form-control " name="raw_material_supplier_name" id="raw_material_supplier_name" readonly>
                                                        <option st-id="" value="">Raw Material Supplier Name</option>
                                                    </select>
                                            <p class="error raw_material_supplier_name_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="text" class="form-control" id="remark" name="remark" value="<?=$fetchALLprejobworkitemList[0]['pre_remark'] ?>">
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
                                                        <th>Part Number</th>
                                                        <th>Description</th>
                                                        <th>Vendor  Qty</th>
                                                        <th>Rm Actual Qty</th>
                                                        <th>Rm Rate</th>
                                                        <th>Value</th>
                                                        <th>Packing & Forwarding</th>
                                                        <th>Total </th>
                                                        <th>GST</th>
                                                        <th>Grand Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($fetchALLprejobworkitemList as $key => $value) :
                                                           $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['description'];?></td>
                                                        <td><?php echo $value['vendor_qty'];?></td>
                                                        <td><?php echo $value['order_qty'];?></td>
                                                        <td><?php echo $value['row_material_recived_qty'];?></td>
                                                        <td><?php echo $value['finished_good_recived_qty'];?></td>
                                                        <td><?php echo $value['gross_weight'];?></td>
                                                        <td><?php echo $value['expected_qty'];?></td>
                                                        <td>
                                                        <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['id'];?>' class='fa fa-trash-o deleteSupplierpoitem' aria-hidden='true'></i>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                    </div>

                                    <!-- <div class="container">
                                         <div id="supplier_po_item_list">
                                         </div>

                                         <div id="customers-list">
                                         </div>
                                    </div> -->

                                      <!-- Add New Package Modal -->
                                    <?php $this->load->helper("form"); ?>
                                    <div class="modal fade" id="addNewModal" role="dialog" aria-labelledby="additem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                      
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="additem">Add New Item</h3>
                                                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                                                <!-- <span aria-hidden="true">&times;</span> -->
                                                </button>
                                            </div>
                                            <form role="form" id="savejobworkitemform" action="<?php echo base_url() ?>savejobworkitemform" method="post" role="form">

                                                <div class="modal-body">
                                                        <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                        </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Part Number <span class="required">*</span> (<small>Row Material Goods Master</small>)</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name="part_number" id="part_number">
                                                                <option st-id="" value="">Select Part Name</option>
                                                                <!-- <?php foreach ($rowMaterialList as $key => $value) {?>        
                                                                    <option value="<?php echo $value['raw_id']; ?>"><?php echo $value['part_number']; ?></option>
                                                                <?php } ?> -->
                                                            </select>
                                                            <p class="error part_number_error"></p>

                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Part Name <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="type" class="form-control"  id="description" name="description" required readonly>
                                                            <p class="error description_error"></p>
                                                        </div>
                                                    </div>



                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">SAC Code</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="SAC" name="SAC" readonly>
                                                            <p class="error SAC_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">HSN Code</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="HSN_Code" name="HSN_Code" readonly>
                                                            <p class="error HSN_Code_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Raw Material Size</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="raw_material_size" name="raw_material_size" readonly>
                                                            <p class="error raw_material_size_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Vendor Order Qty</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="vendor_order_qty" name="vendor_order_qty" readonly>
                                                            <p class="error vendor_order_qty_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">RM Actual Qty <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="rm_actual_aty" name="rm_actual_aty">
                                                            <p class="error rm_actual_aty_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Unit <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                             <select class="form-control" name="unit" id="unit">
                                                                <option value="">Select Unit</option>
                                                                <option value="kgs">Kgs</option>
                                                                <option value="Pcs">Pcs</option>
                                                                <option value="Nos">Nos</option>
                                                                <option value="Sheet">Sheet</option>
                                                                <option value="Set">Set</option>
                                                             </select>
                                                            <p class="error unit_error"></p>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">R.M Rate<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="rm_rate" name="rm_rate" readonly>
                                                            <p class="error rm_rate_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Value<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="value" name="value" readonly>
                                                            <p class="error value_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Packing & Forwording<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="packing_and_forwarding" name="packing_and_forwarding">
                                                            <p class="error packing_and_forwarding_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Total<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="total" name="total" readonly>
                                                            <p class="error total_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">GST<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="gst" name="gst">
                                                            <p class="error gst_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Grand Total<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="grand_total" name="grand_total">
                                                            <p class="error grand_total_error"></p>
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
                                                    <button type="button" class="btn btn-secondary btn-xl closejobworkmodal" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="saveJobworktem" name="saveJobworktem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
                                    <?php if($fetchALLprejobworkitemList){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>
                                    <input type="submit" id="savenewjobwork" class="btn btn-primary" value="Submit">
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>jobWork'" class="btn btn-default" value="Back" />
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

