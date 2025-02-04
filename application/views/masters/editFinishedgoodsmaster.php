<?php $data=$getFinishedgoodsdata[0];?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Finished Goods
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Edit Finished Goods Master</a></li>
                </ul>
            </small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-8">
                <div class="box">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Edit Finished Goods Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="editnewfinishedgoodsform" action="<?php echo base_url() ?>editnewfinishedgoodsform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="part_number">Part Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" value="<?=$data['part_number']?>" id="part_number" name="part_number">
                                            <input type="hidden" class="form-control" value="<?=$data['fin_id']?>" id="finished_goods_id" name="finished_goods_id">
                                            <p class="error part_number_error"></p>

                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Part Name <span class="required">*</span></label>
                                            <input type="text" class="form-control"  value="<?=$data['name']?>" id="name" name="name">
                                            <p class="error name_error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                   

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hsn_code">HSN Code</label>
                                            <input type="text" class="form-control" value="<?=$data['hsn_code']?>" id="hsn_code" name="hsn_code" >
                                            <p class="error hsn_code_error"></p>
                                        </div>
                                    </div>

                                 
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="current_stock">Current Stock </label>
                                            <input type="number" class="form-control" id="current_stock" value="<?=$data['current_stock']?>" name="current_stock">
                                            <p class="error current_stock_error"></p>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="target_qty">Target Qty</label>
                                            <input type="text" class="form-control" id="target_qty" value="<?=$data['target_qty']?>" name="target_qty">
                                            <p class="error target_qty_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gross_weight">Gross Weight </label>
                                            <input type="text" class="form-control" value="<?=$data['groass_weight']?>" id="gross_weight" name="gross_weight">
                                            <p class="error groass_weight_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="net_weight">Net Weight </label>
                                            <input type="text" class="form-control" value="<?=$data['net_weight']?>" id="net_weight" id="net_weight"  name="net_weight">
                                            <p class="error net_weight_error"></p>
                                        </div>
                                    </div>
                                </div>    

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sac">SAC</label>
                                            <input type="text" class="form-control" value="<?=$data['sac']?>" id="sac" name="sac">
                                            <p class="error sac_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="drawing_number">Drawing Number</label>
                                            <input type="text" class="form-control"  value="<?=$data['drawing_number']?>"   id="drawing_number" name="drawing_number">
                                            <p class="error drawing_number_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="description_1">Description 1 </label>
                                                <textarea type="text" class="form-control"  id="description_1"  name="description_1"><?=$data['description_1']?></textarea>
                                                <p class="error description_1_error"></p>
                                            </div>
                                    </div>

                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="description_2">Description 2 </label>
                                                <textarea type="text" class="form-control" id="description_2"  name="description_2"><?=$data['description_2']?></textarea>
                                                <p class="error description_2_error"></p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="updatefinishedgoods" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>finishedgoodsmaster'" class="btn btn-default" value="Back" />
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