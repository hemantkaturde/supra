<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add Packing Instructions Details
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Add Packing Instructions Details</a></li>
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
                            <h3 class="box-title">Add Packing Instructions Details</h3>
                            <p> </p>
                            <p><b>Packing Number : </b> <?=$packinginstarctiondetailsfordispaly[0]['packing_instrauction_id']; ?></p>
                            <p><b>Buyer Name : </b> <?=$packinginstarctiondetailsfordispaly[0]['buyer_name_master']; ?></p>
                            <p><b>Buyer PO : </b> <?=$packinginstarctiondetailsfordispaly[0]['sales_order_number'].' - '.$packinginstarctiondetailsfordispaly[0]['buyer_po_number']?></p>
                           
                        </div>



                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addpackingdetailsform" action="<?php echo base_url() ?>addpackingdetailsform" method="post" role="form">
                            <div class="box-body">
                                <div class="col-md-8">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Part Number</th>
                                                    <th scope="col">Buyer PO Part Delivery Date</th>
                                                    <th scope="col">Part Number</th>
                                                    <th scope="col">Order Qty</th>
                                                    <!-- <th scope="col">Rate</th>
                                                    <th scope="col">Value</th> -->
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                            <?php
                                            $i=1;
                                            foreach ($getbuyeritemdetails as $key => $value) { 
                                                ?>
                                                    <tr>
                                                        <th scope="row"><?=$i++;?></th>
                                                        <td><?=$value['part_number'];?></td>
                                                        <td><?=$value['buyer_po_part_delivery_date'];?></td>
                                                        <td><?=$value['description'];?></td>
                                                        <td><?=$value['order_oty'];?></td>
                                                        <!-- <td><?=$value['rate'];?></td>
                                                        <td><?=$value['value'];?></td> -->
                                                    </tr>
                                            <?php } ?>  
                                            </tbody>
                                        </table> 
                                </div>


                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="part_number">Select Part Number<span class="required">*</span></label>
                                                <select class="form-control get_buyer_delivery_date get_all_records_for_this_buyer_po" name="part_number" id="part_number">
                                                    <option st-id="" value="">Select Part Number</option>
                                                        <?php foreach ($getbuyeritemdetails as $key => $value) {?>
                                                                <option value="<?php echo $value['item_details']; ?>"  data_id="<?php echo $value['poitemid']; ?>"><?php echo $value['part_number'].'&nbsp&nbsp&nbsp&nbsp-&nbsp&nbsp&nbsp&nbsp&nbsp'.$value['item_po_status'].'&nbsp&nbsp&nbsp&nbsp-&nbsp&nbsp&nbsp&nbsp&nbsp'.$value['current_stock']; ?>  </option>
                                                        <?php } ?>
                                                </select> 
                                            <p class="error part_number_error"></p>
                                        </div>
                                        <input type="hidden" class="form-control" id="buyer_po_number_id" name="buyer_po_number_id" value="<?=$buyer_po_number_id?>" >
                                        <input type="hidden" class="form-control" id="main_id" name="main_id" value="<?=$main_id?>" >
                                        <input type="hidden" class="form-control" id="packing_details_item_id" name="packing_details_item_id" >
                                        <input type="hidden" class="form-control" id="item_po_status" name="item_po_status" >


                                        <div class="form-group">
                                            <label for="buyer_item_delivery_date">Buyer Item Delivery Date </label>
                                            <input type="text" class="form-control" id="buyer_item_delivery_date" name="buyer_item_delivery_date" required readonly>
                                            <p class="error buyer_item_delivery_date_error"></p>
                                        </div>


                                        <div class="form-group">
                                            <label for="buyer_po_date">Buyer Invoice Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="buyer_invoice_number" name="buyer_invoice_number" required>
                                            <p class="error buyer_po_date_error"></p>
                                        </div>


                                        <div class="form-group">
                                            <label for="buyer_invoice_date">Buyer Invoice Date <span class="required">*</span></label>
                                            <input type="text" class="form-control datepicker" id="buyer_invoice_date" name="buyer_invoice_date" required>
                                            <p class="error buyer_invoice_date_error"></p>
                                        </div>

                                        <div class="form-group">
                                            <label for="buyer_invoice_date">Buyer Invoice Qty <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="buyer_invoice_qty" name="buyer_invoice_qty" required>
                                            <p class="error buyer_invoice_date_error"></p>
                                        </div>

                                        <div class="form-group">
                                            <label for="box_qty">Box Qty <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="box_qty" name="box_qty" required>
                                            <p class="error box_qty"></p>
                                        </div>

                                        <div class="form-group">
                                            <label for="fax">Remark</label>
                                               <textarea type="text" class="form-control"  id="remark"  name="remark"> </textarea><p class="error fax_error"></p>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                      <div class="container">
                                            <div id="packging_instraction-list">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>

                            </div>  
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-xs-8">
                                    <input type="submit" id="addpackinginstractiondetails" class="btn btn-primary" value="Submit" />
                                    <input type="button" onclick="location.href = '<?php echo base_url() ?>packinginstaruction'" class="btn btn-default" value="Back" />
                                </div>
                            </div>
                        </form>
                            
                                 <div class="col-md-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Part Number</th>
                                                    <th scope="col">Buyer Delivery Date </th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Buyer Invoice Number</th>
                                                    <th scope="col">Buyer Invoice Date</th>
                                                    <th scope="col">Buyer Invoice Qty </th>
                                                    <th scope="col">Box Qty</th>
                                                    <th scope="col">Remark</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                            <?php
                                            $i=1;
                                            foreach ($getpackingdetails_itemdetails as $key_details => $value_details) { 
                                                ?>
                                                    <tr>
                                                        <th scope="row"><?=$i++;?></th>
                                                        <td><?=$value_details['part_number'];?></td>
                                                        <td><?=$value_details['buyer_item_delivery_date'];?></td>
                                                        <td><?=$value_details['name'];?></td>
                                                        <td><?=$value_details['buyer_invoice_number'];?></td>
                                                        <td><?=$value_details['buyer_invoice_date'];?></td>
                                                        <td><?=$value_details['buyer_invoice_qty'];?></td>
                                                      
                                                        <td><?=$value_details['box_qty'];?></td>
                                                        <td><?=$value_details['remark'];?></td>
                                                        <td>
                                                           <?php if($value_details['item_po_status']=='from_stock'){ ?>
                                                            <a href='<?=ADMIN_PATH.'downloaddirectstock/'.$value_details['packing_instaction_details'];?>' ><i style='font-size: x-large;cursor: pointer;' class='fa fa-files-o' aria-hidden='true'></i></a>
                                                           <?php } ?> 
                                                            <a href='<?=ADMIN_PATH.'downloadpackinginstraction/'.$value_details['packing_instaction_details'];?>' ><i style='font-size: x-large;cursor: pointer;' class='fa fa-print' aria-hidden='true'></i></a>
                                                            <i style='font-size: x-large;cursor: pointer'  main-id='<?=$main_id; ?>'   data-id='<?=$value_details['packing_instaction_details'];?>' class='fa fa-pencil-square-o editpackinginstractionsubitem'  aria-hidden='true'></i>
                                                            <i style='font-size: x-large;cursor: pointer;' main-id='<?=$main_id; ?>' fin_id='<?=$value_details['fin_id'];?>'  data-id='<?=$value_details['packing_instaction_details'];?>' class='fa fa-trash-o deletepackinginstractionsubitem' aria-hidden='true'></i>
                                                        </td>
                                                    </tr>
                                            <?php } ?>  
                                            </tbody>
                                        </table> 
                                </div>
                            
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
