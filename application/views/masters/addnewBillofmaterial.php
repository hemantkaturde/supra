<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Bill of Material
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Bill of Material</a></li>
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
                            <h3 class="box-title">Add New Bill of Material Work</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnnewbillofmaterialform" action="<?php echo base_url() ?>addnnewbillofmaterialform" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-4">

                                    <?php
                                        if($getPreviousBomnumber['bom_number']){
                                            $arr = str_split($getPreviousBomnumber['bom_number']);
                                            $i = end($arr);
                                            $inrno= "SQBM2324".str_pad((int)$i+1, 4, 0, STR_PAD_LEFT);
                                            $po_number = $inrno;
                                        }else{
                                            $po_number = 'SQBM23240001';
                                        }
                                    ?>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="bom_number">BOM Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="bom_number" name="bom_number" value="<?=$po_number?>" required readonly>
                                            <p class="error bom_number_error"></p>
                                        </div>
                                    </div>


                                    <?php if($fetchALLpresupplieritemList[0]['pre_date']){
                                        $date= $fetchALLpresupplieritemList[0]['pre_date'];
                                     }else{
                                        $date= date('Y-m-d');
                                     } ?>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date">BOM Date <span class="required">*</span></label>
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
                                                    <select class="form-control vendor_po_number_itam" name="vendor_po_number" id="vendor_po_number">
                                                        <option st-id="" value="">Select Vendor Name</option>
                                                    </select>
                                            <p class="error vendor_po_number_error"></p>
                                        </div>
                                    </div>


                                    
                                  <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_name">Buyer Name <span class="required">*</span></label>
                                                <select class="form-control" name="buyer_name" id="buyer_name">
                                                    <option st-id="" value="">Select Buyer Name</option>
                                                    <?php foreach ($buyerList as $key => $value) {?>
                                                    <option value="<?php echo $value['buyer_id']; ?>"><?php echo $value['buyer_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <p class="error buyer_name_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_po_number">Select Buyer PO <span class="required">*</span></label>
                                                    <select class="form-control buyer_po_number  buyer_po_number_for_itam_mapping" name="buyer_po_number" id="buyer_po_number">
                                                        <option st-id="" value="">Select Buyer PO</option>
                                                    </select>
                                            <p class="error buyer_po_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_po_date">Buyer PO Date<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="buyer_po_date" value="<?=$pre_buyer_po_date?>" name="buyer_po_date" required readonly>
                                            <p class="error buyer_po_date_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="buyer_delivery_date">Buyer Delivery Date<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="buyer_delivery_date" value="<?=$pre_buyer_delivery_date?>"  name="buyer_delivery_date" required readonly>
                                            <p class="error buyer_delivery_date_error"></p>
                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="supplier_name">Supplier Name<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="supplier_name" value=""  name="supplier_name" required readonly>
                                            <p class="error supplier_name_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="supplier_po_number">Supplier Name<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="supplier_po_number" value=""  name="supplier_po_number" required readonly>
                                            <p class="error supplier_po_number_error"></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="supplier_po_date">Supplier PO Date<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="supplier_po_date" value=""  name="supplier_po_date" required readonly>
                                            <p class="error supplier_po_date_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="bom_status">Status <span class="required">*</span></label>
                                                <select class="form-control bom_status" name="bom_status" id="bom_status">
                                                    <option st-id="" value="">Select Status Name</option>
                                                    <option value="OPEN">OPEN</option>
                                                    <option value="CLOSE">CLOSE</option>
                                                </select>
                                            <p class="error bom_status_error"></p>
                                        </div>
                                    </div>
        

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="text" class="form-control" id="remark" name="remark" value="">
                                            <p class="error remark_error"></p>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="container">
                                        <button type="button" class="btn btn-success btn-xl" data-toggle="modal" data-target="#addNewModal">Add New Items</button><br/><br/>
                                            <table class="table table-bordered" style="width: 80% !important; max-width: 80%;margin-bottom: 20px;">
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
                                                        <th>Remark</th>
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
                                                        <td><?php echo $value['rm_actual_qty'];?></td>
                                                        <td><?php echo $value['ram_rate'];?></td>
                                                        <td><?php echo $value['value'];?></td>
                                                        <td><?php echo $value['packing_forwarding'];?></td>
                                                        <td><?php echo $value['total'];?></td>
                                                        <td><?php echo $value['gst'];?></td>
                                                        <td><?php echo $value['grand_total'];?></td>
                                                        <td><?php echo $value['item_remark'];?></td>
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
                                            <form role="form" id="saveBillofmaterialform" action="<?php echo base_url() ?>saveBillofmaterialform" method="post" role="form">

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
                                                        <label class="col-sm-4 col-form-label">RM Order Qty</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"  id="rm_order_qty" name="rm_order_qty" readonly>
                                                            <p class="error rm_order_qty_error"></p>
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
                                                        <label class="col-sm-4 col-form-label">RM Type <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="rm_type" name="rm_type">
                                                            <p class="error rm_type_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Slitting Size<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="slitting_size" name="slitting_size">
                                                            <p class="error slitting_size_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Diameter<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="diameter" name="diameter">
                                                            <p class="error diameter_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Thickness<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="thickness" name="thickness">
                                                            <p class="error thickness_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Hex A/F <span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="hex_af" name="hex_af">
                                                            <p class="error hex_af_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Gross Weight<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="gross_weight" name="gross_weight">
                                                            <p class="error gross_weight_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Expected Qty<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="expected_qty" name="expected_qty">
                                                            <p class="error expected_qty_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Vendor Actual Received Qty<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="vendor_actual_received_Qty" name="vendor_actual_received_Qty">
                                                            <p class="error vendor_actual_received_Qty_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Net Weight Per Pcs<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="net_weight_per_pcs" name="net_weight_per_pcs">
                                                            <p class="error net_weight_per_pcs_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Total Net Weight<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="total_net_weight" name="total_net_weight">
                                                            <p class="error total_net_weight_error"></p>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Short Sccess<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="short_access" name="short_access">
                                                            <p class="error short_access_error"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Scrap<span class="required">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"  id="scrap" name="scrap">
                                                            <p class="error scrap_error"></p>
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
                                                    <button type="button" class="btn btn-secondary btn-xl closebillofmaterialmodal" data-dismiss="modal">Close</button>
                                                    <button type="submit" id="saveBillofmaterialtem" name="saveBillofmaterialtem" class="btn btn-primary" class="btn btn-success btn-xl">Save</button>
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
                                    <input type="submit" id="savenewBillofmaterail" class="btn btn-primary" value="Submit">
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>billofmaterial'" class="btn btn-default" value="Back" />
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


        $(document).ready(function () {
    $('.table').DataTable({
        scrollX: true,
    });
});
</script>

