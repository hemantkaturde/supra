<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Vendor PO Confirmation
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Vendor PO Confirmation Master</a></li>
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
                            <h3 class="box-title">Add Vendor PO Confirmation Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnnewsupplierconfrimationpoform" action="<?php echo base_url() ?>addnnewsupplierconfrimationpoform" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-4">

                                    <?php
                                        if($getPreviousSupplierPoconfirmationNumber['po_number']){
                                            $arr = str_split($getPreviousSupplierPoconfirmationNumber['po_number']);
                                            $i = end($arr);
                                            $inrno= "SQPC2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            $po_number = $inrno;
                                        }else{
                                            $po_number = 'SQPC23240001';
                                        }
                                    ?>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="po_number">PO Confirmation Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="po_number" name="po_number" value="<?=$po_number?>" required readonly>
                                            <p class="error po_number_error"></p>
                                        </div>
                                    </div>


                                    <?php if($fetchALLpresupplierpoconfirmationitemList[0]['pre_date']){
                                        $date= $fetchALLpresupplierpoconfirmationitemList[0]['pre_date'];
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
                                                <select class="form-control" name="vendor_name" id="vendor_name">
                                                    <option st-id="" value="">Select Vendor Name</option>
                                                    <?php foreach ($vendorList as $key => $value) {?>
                                                    <option value="<?php echo $value['ven_id']; ?>"><?php echo $value['vendor_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error vendor_name_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12 buyer_po_number_div" style="display:<?=$display;?>">
                                            <div class="form-group">
                                                    <label for="buyer_po_number">Select Buyer PO Number <span class="required">*</span></label>
                                                    <select class="form-control" name="buyer_po_number" id="buyer_po_number">
                                                    <option st-id="" value="<?=$fetchALLpresupplierpoconfirmationitemList[0]['pre_buyer_po_number']?>" selected ><?=$selected_value;?></option>
                                                        <!-- <option st-id="" value="">Select Buyer Name</option>
                                                        <?php foreach ($buyerList as $key => $value) {?>
                                                        <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$fetchALLpresupplierpoconfirmationitemList[0]['pre_buyer_name']){ echo 'selected';} ?> ><?php echo $value['buyer_name']; ?></option>
                                                        <?php } ?> -->
                                                    </select> 
                                                <p class="error buyer_po_number_error"></p>
                                            </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                                <select class="form-control" name="buyer_name" id="buyer_name">
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                    <?php foreach ($buyerList as $key => $value) {?>
                                                    <option value="<?php echo $value['buyer_id']; ?>" <?php if($value['buyer_id']==$fetchALLpresupplierpoconfirmationitemList[0]['pre_buyer_name']){ echo 'selected';} ?> ><?php echo $value['buyer_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>

                

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="po_confirmed">PO Confirmed<span class="required">*</span></label>
                                                <select class="form-control" name="po_confirmed" id="po_confirmed">
                                                    <option st-id="" value="">Select PO Confirmed</option>
                                                    <option st-id="" value="YES">YES</option>
                                                    <option st-id="" value="NO">NO</option>
                                                </select>
                                            <p class="error po_confirmed_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="confirmed_date">Confirmed Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" value="" id="confirmed_date" name="confirmed_date" required>
                                            <p class="error confirmed_date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="confirmed_with">Confirmed With <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="confirmed_with" value="" name="confirmed_with">
                                            <p class="error confirmed_with_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                  <textarea type="text" class="form-control"  id="remark"  name="remark" required></textarea>
                                                <p class="error remark_error"></p>
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="container">
                                        <!-- <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/> -->
                                            <table class="table table-bordered" style="width: 70% !important; max-width: 100%;margin-bottom: 20px;">
                                                <thead style="background-color:#3c8dbc;color:#fff">
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Part Number</th>
                                                        <th>Description</th>
                                                        <th>Vendor  Qty</th>
                                                        <th>Order Qty</th>
                                                        <th>Unit</th>
                                                        <th>Rate</th>
                                                        <th>Value</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $count=0;
                                                           foreach ($fetchALLpresupplierpoconfirmationitemList as $key => $value) :
                                                           $count++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count;?></td>
                                                        <td><?php echo $value['part_number'];?></td>
                                                        <td><?php echo $value['description'];?></td>
                                                        <td><?php echo $value['vendor_qty'];?></td>
                                                        <td><?php echo $value['order_oty'];?></td>
                                                        <td><?php echo $value['unit'];?></td>
                                                        <td><?php echo $value['rate'];?></td>
                                                        <td><?php echo $value['value'];?></td>
                                                        <td>
                                                        <i style='font-size: x-large;cursor: pointer' data-id='<?php echo $value['id'];?>' class='fa fa-trash-o deleteSupplierpoitem' aria-hidden='true'></i>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                    </div>

                                    <div class="container">
                                         <div id="supplier_po_item_list">
                                         </div>

                                         <div id="customers-list">
                                         </div>
                                    </div>

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
                                            <form role="form" id="saveSupplierconfromationpoitemform" action="<?php echo base_url() ?>saveSupplierconfromationpoitemform" method="post" role="form">

                                                <div class="modal-body">
                                                        <div class="loader_ajax" style="display:none;">
                                                            <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
                                                        </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Part Number <span class="required">*</span> (<small>Row Material Goods Master</small>)</label>
                                                        <div class="col-sm-9">
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
                                                        <label class="col-sm-3 col-form-label">Part Name <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input type="type" class="form-control"  id="description" name="description" required readonly>
                                                            <p class="error description_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Diameter </label>
                                                        <div class="col-sm-9">
                                                            <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                            <input type="type" class="form-control"  id="diameter" name="diameter" required readonly>
                                                            <p class="error diameter_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Slitting Size</label>
                                                        <div class="col-sm-9">
                                                            <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                            <input type="type" class="form-control"  id="slitting_size" name="slitting_size" required readonly>
                                                            <p class="error slitting_size_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Thickness</label>
                                                        <div class="col-sm-9">
                                                            <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                            <input type="type" class="form-control"  id="thickness" name="thickness" required readonly>
                                                            <p class="error thickness_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Hex A/F</label>
                                                        <div class="col-sm-9">
                                                            <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                            <input type="type" class="form-control"  id="hex_af" name="hex_af" required readonly>
                                                            <p class="error hex_af_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">HSN Code</label>
                                                        <div class="col-sm-9">
                                                            <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                            <input type="type" class="form-control"  id="hsn_code" name="hsn_code" required readonly>
                                                            <p class="error hsn_code_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Length</label>
                                                        <div class="col-sm-9">
                                                            <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                            <input type="type" class="form-control"  id="length" name="length" required readonly>
                                                            <p class="error length_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Gross Weight</label>
                                                        <div class="col-sm-9">
                                                            <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                            <input type="type" class="form-control"  id="gross_weight" name="gross_weight" required readonly>
                                                            <p class="error gross_weight_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Net Weight</label>
                                                        <div class="col-sm-9">
                                                            <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                            <input type="type" class="form-control"  id="net_weight" name="net_weight" required readonly>
                                                            <p class="error net_weight_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">SAC</label>
                                                        <div class="col-sm-9">
                                                            <!-- <textarea type="text" class="form-control"  id="description"  name="description" required></textarea> -->
                                                            <input type="type" class="form-control"  id="sac" name="sac" required readonly>
                                                            <p class="error sac_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Vendor Quantity</label>
                                                        <div class="col-sm-9">
                                                            <input type="number" class="form-control"  id="vendor_qty" name="vendor_qty" readonly>
                                                            <p class="error vendor_qty_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Order Quantity <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input type="number" class="form-control"  id="qty" name="qty" readonly>
                                                            <p class="error qty_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Unit</label>
                                                        <div class="col-sm-9">
                                                             <select class="form-control" name="unit" id="unit" readonly>
                                                                <option value="">Select Part Name</option>
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
                                                        <label class="col-sm-3 col-form-label">Rate <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input type="number" class="form-control"  id="rate" name="rate">
                                                            <p class="error rate"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Value <span class="required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input type="number" class="form-control"  id="value" name="value">
                                                            <p class="error value"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Remark</label>
                                                        <div class="col-sm-9">
                                                           <textarea type="text" class="form-control"  id="item_remark"  name="item_remark"></textarea>
                                                           <p class="error item_remark_error"></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-xl closeSupplierpoconfirmation" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="saveSupplierconfromationpoitem" name="saveSupplierconfromationpoitem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
                                    <?php if($fetchALLpresupplierpoconfirmationitemList){
                                        $disabled= '';
                                    }else{ 
                                        $disabled= 'disabled';
                                     } ?>
                                    <input type="submit" id="savenewsupplierconfrimationpo" class="btn btn-primary" value="Submit" <?=$disabled;?> />
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>supplierpoconfirmation'" class="btn btn-default" value="Back" />
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

