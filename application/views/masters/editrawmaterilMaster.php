<?php $data=$getRawmateraildata[0];?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Raw Material
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Edit Raw Material Master</a></li>
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
                            <h3 class="box-title">Edit Raw Material</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="updaterawmaterialform" action="<?php echo base_url() ?>updaterawmaterialform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="part_number">Part Number <span class="required">*</span></label>
                                            <input type="text" class="form-control"  value="<?=$data['part_number']?>" id="part_number" name="part_number">
                                            <input type="hidden" class="form-control" value="<?=$data['raw_id']?>" id="rawmaetrial_id" name="rawmaetrial_id">
                                            <p class="error part_number_error"></p>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type_of_raw_material">Type Of Raw Material <span class="required">*</span></label>
                                            <input type="text" class="form-control" value="<?=$data['type_of_raw_material']?>" id="type_of_raw_material" name="type_of_raw_material">
                                            <p class="error type_of_raw_material_error"></p>

                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="daimeter">Diameter</label>
                                            <input type="text" class="form-control" value="<?=$data['diameter']?>" id="daimeter" name="daimeter">
                                            <p class="error daimeter_error"></p>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sitting_size">Sitting Size </label>
                                            <input type="text" class="form-control" value="<?=$data['sitting_size']?>" id="sitting_size" name="sitting_size">
                                            <p class="error sitting_size_error"></p>
                                        </div>
                                    </div>
                                   
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="thickness">Thickness </label>
                                            <input type="text" class="form-control" value="<?=$data['thickness']?>" id="thickness" name="thickness">
                                            <p class="error thickness_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hex_a_f">Hex A/F </label>
                                            <input type="text" class="form-control" value="<?=$data['hex_a_f']?>" id="hex_a_f" name="hex_a_f" >
                                            <p class="error hex_a_f_error"></p>
                                        </div>
                                    </div>
                                    
                                </div>  
                                
                           

                                  <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hsn_code">HSN Code </label>
                                            <input type="text" class="form-control" value="<?=$data['HSN_code']?>" id="hsn_code" id="hsn_code"  name="hsn_code">
                                            <p class="error hsn_code_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="length">Length </label>
                                            <input type="text" class="form-control" value="<?=$data['length']?>" id="length" name="length">
                                            <p class="error length_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gross_weight">Gross Weight </label>
                                            <input type="text" class="form-control" value="<?=$data['gross_weight']?>" id="gross_weight" name="gross_weight">
                                            <p class="error gross_weight_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="net_weight">Net Weight </label>
                                            <input type="text" class="form-control" value="<?=$data['net_weight']?>" id="net_weight" name="net_weight">
                                            <p class="error net_weight_error"></p>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sac">SAC </label>
                                            <input type="text" class="form-control" value="<?=$data['sac']?>" id="sac" name="sac">
                                            <p class="error sac_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="updateRawmaterial" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>rowmaterialmaster'" class="btn btn-default" value="Back" />
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