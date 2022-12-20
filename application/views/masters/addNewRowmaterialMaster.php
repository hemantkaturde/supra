<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add New Raw Material
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Raw Material Master</a></li>
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
                            <h3 class="box-title">Add Raw Material</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewrawmaterialform" action="<?php echo base_url() ?>addnewrawmaterialform" method="post" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="part_number">Part Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="part_number" name="part_number">
                                            <p class="error part_number_error"></p>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type_of_raw_material">Type Of Raw Material <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="type_of_raw_material" name="type_of_raw_material">
                                            <p class="error type_of_raw_material_error"></p>

                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="daimeter">Diameter</label>
                                            <input type="text" class="form-control" id="daimeter" name="daimeter">
                                            <p class="error daimeter_error"></p>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sitting_size">Slitting Size</label>
                                            <input type="text" class="form-control" id="sitting_size" name="sitting_size">
                                            <p class="error sitting_size_error"></p>
                                        </div>
                                    </div>
                                   
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="thickness">Thickness </label>
                                            <input type="text" class="form-control" id="thickness" name="thickness">
                                            <p class="error thickness_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hex_a_f">Hex A/F </label>
                                            <input type="text" class="form-control" id="hex_a_f" name="hex_a_f" >
                                            <p class="error hex_a_f_error"></p>
                                        </div>
                                    </div>
                                    
                                </div>  
                                
                           

                                  <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hsn_code">HSN Code </label>
                                            <input type="text" class="form-control" id="hsn_code" id="hsn_code"  name="hsn_code">
                                            <p class="error hsn_code_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="length">Length </label>
                                            <input type="text" class="form-control" id="length" name="length">
                                            <p class="error length_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gross_weight">Gross Weight </label>
                                            <input type="text" class="form-control" id="gross_weight" name="gross_weight">
                                            <p class="error gross_weight_error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="net_weight">Net Weight </label>
                                            <input type="text" class="form-control" id="net_weight" name="net_weight">
                                            <p class="error net_weight_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sac">SAC </label>
                                            <input type="text" class="form-control" id="sac" name="sac">
                                            <p class="error sac_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewRawmaterial" class="btn btn-primary" value="Submit" />
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