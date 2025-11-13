
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Add Sampling Method
            <small>
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Sampling Method</a></li>
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
                            <h3 class="box-title">Add Sampling Method Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewsamplingmethodfrom" action="<?php echo base_url() ?>addnewsamplingmethod" method="post" role="form">
                            <div class="box-body">

                            <input type="hidden" class="form-control" id="sampling_master_id" value="<?=$sampling_master_id?>" name="sampling_master_id" required>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="instrument_name">Instrument Name <span class="required">*</span></label>
                                            <!-- <input type="text" class="form-control" id="instrument_name" name="instrument_name" required> -->
                                            <select name="instrument_name" id="instrument_name" class="form-control serachfilternotrequired" required>
                                                <option value="">Select</option>
                                                <option value="TRG">TRG</option>
                                                <option value="TPG">TPG</option>
                                                <option value="Measuring Pin">Measuring Pin</option>
                                                <option value="Plain Ring Gauge">Plain Ring Gauge</option>
                                                <option value="Plain Plug Gauge">Plain Plug Gauge</option>
                                                <option value="Slip Gauge">Slip Gauge</option>
                                                <option value="Radius Gauge">Radius Gauge</option>
                                                <option value="Micrometer">Micrometer</option>
                                                <option value="REJECTED VERNIER">REJECTED VERNIER</option>
                                                <option value="PROFILE GAUGE">PROFILE GAUGE</option>
                                                <option value="DIGITAL MICROMETER">DIGITAL MICROMETER</option>
                                                <option value="BLADE MICROMETER">BLADE MICROMETER</option>
                                                <option value="TUBE MICROMETER">TUBE MICROMETER</option>
                                                <option value="DEPTH MICROMETER">DEPTH MICROMETER</option>
                                                <option value="DIGITAL VERNIER CALIPER">DIGITAL VERNIER CALIPER</option>
                                                <option value="VERNIER CALIPER">VERNIER CALIPER</option>
                                                <option value="DIAL VERNIER CALIPER">DIAL VERNIER CALIPER</option>
                                                <option value="DIGITAL INSIDE GROOVE CALIPER">DIGITAL INSIDE GROOVE CALIPER</option>
                                                <option value="INSIDE GROOVE CALIPER">INSIDE GROOVE CALIPER</option>
                                                <option value="DIGITAL HEIGHT GAUGE">DIGITAL HEIGHT GAUGE</option>
                                                <option value="VERNIER HEIGHT GAUGE">VERNIER HEIGHT GAUGE</option>
                                                <option value="DIGITAL PITCH MICROMETER">DIGITAL PITCH MICROMETER</option>
                                                <option value="BEVEL PROTECTOR">BEVEL PROTECTOR</option>
                                                <option value="BORE GAUGE">BORE GAUGE</option>
                                                <option value="LEVER DIAL">LEVER DIAL</option>
                                                <option value="PLUNGER DIAL">PLUNGER DIAL</option>
                                                <option value="OHMS METER">OHMS METER</option>
                                                <option value="PRESSURE GAUGE">PRESSURE GAUGE</option>
                                                <option value="RUBBER HARDNESS TESTER">RUBBER HARDNESS TESTER</option>
                                                <option value="TORQUE WRENCH">TORQUE WRENCH</option>
                                                <option value="SURFACE PLATE">SURFACE PLATE</option>
                                                <option value="SURFACE ROUGHNESS COMPARATOR">SURFACE ROUGHNESS COMPARATOR</option>
                                                <option value="SURFACE ROUGHNESS TESTER">SURFACE ROUGHNESS TESTER</option>
                                                <option value="HARDNESS TESTER">HARDNESS TESTER</option>
                                                <option value="ROUND FILE (SMALL)">ROUND FILE (SMALL)</option>
                                                <option value="ROUND FILE (BIG)">ROUND FILE (BIG)</option>
                                                <option value="FLAT FILE (SMALL)">FLAT FILE (SMALL)</option>
                                                <option value="FLAT FILE (BIG)">FLAT FILE (BIG)</option>
                                                <option value="TRIANGLE FILE (SMALL)">TRIANGLE FILE (SMALL)</option>
                                                <option value="TRIANGLE FILE (BIG)">TRIANGLE FILE (BIG)</option>
                                                <option value="DIAMOND FILE">DIAMOND FILE</option>
                                                <option value="THREAD TAPP">THREAD TAPP</option>
                                                <option value="V BLOCK">V BLOCK</option>
                                                <option value="TAPP WRENCH">TAPP WRENCH</option>
                                                <option value="RIMMER">RIMMER</option>
                                                <option value="DRILL">DRILL</option>
                                                <option value="SAW BLADES">SAW BLADES</option>
                                                <option value="SCREWDRIVER">SCREWDRIVER</option>
                                                <option value="VISE">VISE</option>
                                                <option value="C-CLAMP">C-CLAMP</option>
                                                <option value="MANDRELS">MANDRELS</option>
                                                <option value="CHUCKS">CHUCKS</option>
                                                <option value="GRINDING BELT">GRINDING BELT</option>
                                                <option value="BUFFING WHEEL">BUFFING WHEEL</option>
                                                <option value="GLOVES">GLOVES</option>
                                                <option value="SPANNER">SPANNER</option>
                                                <option value="PIPE SPANNER">PIPE SPANNER</option>
                                                <option value="ALLEN KEY SET">ALLEN KEY SET</option>
                                                <option value="ALLEN BOLT">ALLEN BOLT</option>
                                                <option value="POLISH PAPER">POLISH PAPER</option>
                                                <option value="PLIER">PLIER</option>
                                                <option value="SCRUBBER">SCRUBBER</option>
                                                <option value="YELLOW DEBBURING CUTTER">YELLOW DEBBURING CUTTER</option>
                                                <option value="ENGRAVER TOOL">ENGRAVER TOOL</option>
                                                <option value="ENGRAVER MACHINE">ENGRAVER MACHINE</option>
                                                <option value="ADVANCE MICRO TEST MACHINE">ADVANCE MICRO TEST MACHINE</option>
                                                <option value="METAL BRUSH">METAL BRUSH</option>
                                                <option value="BRUSH">BRUSH</option>
                                                <option value="PAINTING ROLLER">PAINTING ROLLER</option>
                                                <option value="MASKS">MASKS</option>
                                                <option value="THINNER / ACETONE">THINNER / ACETONE</option>
                                                <option value="COTTON WASTE">COTTON WASTE</option>
                                                <option value="SAFETY GLASSES">SAFETY GLASSES</option>
                                            </select>
                                            <p class="error instrument_name_error"></p>
                                        </div>
                                    </div>
                                </div>


                                 <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="grade">Grade</label>
                                             <select name="grade" id="grade" class="form-control serachfilternotrequired">
                                                <option value="">Select</option>
                                                <option value="M">M</option>
                                                <option value="G">G</option>
                                                <option value="R">R</option>
                                            </select>                      
                                            <p class="error grade_error"></p>
                                        </div>
                                    </div>
                                 </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="unit">Unit</label>
                                             <select name="unit" id="unit" class="form-control serachfilternotrequired">
                                                 <option value="">Select Unit</option>
                                                 <option value="MM">MM</option>
                                            </select>                      
                                            <p class="error unit_error"></p>
                                        </div>
                                    </div>
                                 </div>


                                 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="class">Class</label>
                                             <select name="class" id="class" class="form-control serachfilternotrequired">
                                                <option value="">Select Class</option>
                                                <option value="6g">6g</option>
                                                <option value="6h">6h</option>
                                                <option value="6G">6G</option>
                                                <option value="6H">6H</option>
                                                <option value="DIN">DIN</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="BSPT">BSPT</option>
                                                <option value="NPT">NPT</option>
                                                <option value="BSW">BSW</option>
                                                <option value="UNF">UNF</option>
                                                <option value="UNJF">UNJF</option>
                                                <option value="UNC">UNC</option>
                                                <option value="BSB">BSB</option>
                                                <option value="BBA">BBA</option>
                                                <option value="BSF">BSF</option>
                                                <option value="PG">PG</option>
                                                <option value="WHIT MEDIUM">WHIT MEDIUM</option>
                                            </select>                      
                                            <p class="error unit_error"></p>
                                        </div>
                                    </div>
                                </div>


                               
                                 <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="measuring_size">Measuring Size</label>
                                            <input type="text" class="form-control" id="measuring_size " name="measuring_size">
                                            <p class="error measuring_size_error"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sampling_method_name">Type</label>
                                                <select class="form-control" name="type" id="type">
                                                    <option st-id="" value="">Select Part Name</option>
                                                        <option value="GO">GO</option>
                                                        <option value="NOGO">NOGO</option>
                                                        <option value="GO/NOGO">GO/NOGO</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                <textarea type="text" class="form-control"  id="remark"  name="remark" required></textarea>
                                                <p class="error remark_error"></p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="savenewsamplingmethodsubmit" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>addsamplingmethod/<?=$sampling_master_id?>'" class="btn btn-default" value="Back" />
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
