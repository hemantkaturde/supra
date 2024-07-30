<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> View Export Details
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">View Export Details</a></li>
                </ul>
            </small>
        </h1>

        <p> Buyer Name : <?=$packingintractiondetails_data[0]['buyer_name']?></p>

        <p> Buyer PO Number : <?=$packingintractiondetails_data[0]['sales_order_number'].'-'.$packingintractiondetails_data[0]['buyer_po_number']?></p>

        <input type="button" onclick="location.href = '<?php echo base_url() ?>exportdetails'" class="btn btn-primary" value="Back" />
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">View Export Details</h3>
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
                                                    <th scope="col">Description</th>
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
                                                        <td><?=$value['description'];?></td>
                                                        <td><?=$value['order_oty'];?></td>
                                                        <!-- <td><?=$value['rate'];?></td>
                                                        <td><?=$value['value'];?></td> -->
                                                    </tr>
                                            <?php } ?>  
                                            </tbody>
                                        </table> 
                                </div>
                            </div>  
                            <!-- /.box-body -->
                        </form>
                        <div class="col-md-8">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Part Number</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Buyer Invoice Number</th>
                                                    <th scope="col">Buyer Invoice Date</th>
                                                    <th scope="col">Buyer Invoice Qty </th>
                                                    <th scope="col">Box Qty</th>
                                                    <th scope="col">Remark</th>
                                                    <!-- <th scope="col">Action</th> -->
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                            <?php
                                            $ii=1;
                                            foreach ($getpackingdetails_itemdetails as $key_details => $value_details) { 
                                                ?>
                                                    <tr>
                                                        <th scope="row"><?=$ii++;?></th>
                                                        <td><?=$value_details['part_number'];?></td>
                                                        <td><?=$value_details['name'];?></td>
                                                        <td><?=$value_details['buyer_invoice_number'];?></td>
                                                        <td><?=$value_details['buyer_invoice_date'];?></td>
                                                        <td><?=$value_details['buyer_invoice_qty'];?></td>
                                                        <td><?=$value_details['box_qty'];?></td>
                                                        <td><?=$value_details['remark'];?></td>
                                                        <!-- <td><i style='font-size: x-large;cursor: pointer;' main-id='<?=$main_id; ?>'   data-id='<?=$value_details['packing_instaction_details'];?>' class='fa fa-trash-o deletepackinginstractionsubitem' aria-hidden='true'></i></td> -->
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
