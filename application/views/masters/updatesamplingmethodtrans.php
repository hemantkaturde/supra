
<?php $data = $getsamplingmasterdataforedit[0];?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Edit Sampling Method
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
                            <h3 class="box-title">Edit Sampling Method Details</h3>
                        </div>
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addnewsamplingmethodfrom" action="<?php echo base_url() ?>addnewsamplingmethod" method="post" role="form">
                            <div class="box-body">

                            <input type="hidden" class="form-control" id="sampling_master_id" value="<?=$data['sampling_master_id'];?>" name="sampling_master_id" required>
                            <input type="hidden" class="form-control" id="sampling_method_id" value="<?=$data['id'];?>" name="sampling_method_id" required>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="instrument_name">Instrument Name <span class="required">*</span></label>
                                            <!-- <input type="text" class="form-control" id="instrument_name" value="<?=$data['instrument_name'];?>" name="instrument_name" required> -->

                                            <select name="instrument_name" id="instrument_name" class="form-control serachfilternotrequired" required>
                                                <option value="">Select</option>
                                                <option value="TRG" <?= ($data['instrument_name'] == 'TRG') ? 'selected' : '' ?>>TRG</option>
                                                <option value="TPG" <?= ($data['instrument_name'] == 'TPG') ? 'selected' : '' ?>>TPG</option>
                                                <option value="Measuring Pin" <?= ($data['instrument_name'] == 'Measuring Pin') ? 'selected' : '' ?>>Measuring Pin</option>
                                                <option value="Plain Ring Gauge" <?= ($data['instrument_name'] == 'Plain Ring Gauge') ? 'selected' : '' ?>>Plain Ring Gauge</option>
                                                <option value="Plain Plug Gauge" <?= ($data['instrument_name'] == 'Plain Plug Gauge') ? 'selected' : '' ?>>Plain Plug Gauge</option>
                                                <option value="Slip Gauge" <?= ($data['instrument_name'] == 'Slip Gauge') ? 'selected' : '' ?>>Slip Gauge</option>
                                                <option value="Radius Gauge" <?= ($data['instrument_name'] == 'Radius Gauge') ? 'selected' : '' ?>>Radius Gauge</option>
                                                <option value="Micrometer" <?= ($data['instrument_name'] == 'Micrometer') ? 'selected' : '' ?>>Micrometer</option>
                                                <option value="REJECTED VERNIER" <?= ($data['instrument_name'] == 'REJECTED VERNIER') ? 'selected' : '' ?>>REJECTED VERNIER</option>
                                                <option value="PROFILE GAUGE" <?= ($data['instrument_name'] == 'PROFILE GAUGE') ? 'selected' : '' ?>>PROFILE GAUGE</option>
                                                <option value="DIGITAL MICROMETER" <?= ($data['instrument_name'] == 'DIGITAL MICROMETER') ? 'selected' : '' ?>>DIGITAL MICROMETER</option>
                                                <option value="BLADE MICROMETER" <?= ($data['instrument_name'] == 'BLADE MICROMETER') ? 'selected' : '' ?>>BLADE MICROMETER</option>
                                                <option value="TUBE MICROMETER" <?= ($data['instrument_name'] == 'TUBE MICROMETER') ? 'selected' : '' ?>>TUBE MICROMETER</option>
                                                <option value="DEPTH MICROMETER" <?= ($data['instrument_name'] == 'DEPTH MICROMETER') ? 'selected' : '' ?>>DEPTH MICROMETER</option>
                                                <option value="DIGITAL VERNIER CALIPER" <?= ($data['instrument_name'] == 'DIGITAL VERNIER CALIPER') ? 'selected' : '' ?>>DIGITAL VERNIER CALIPER</option>
                                                <option value="VERNIER CALIPER" <?= ($data['instrument_name'] == 'VERNIER CALIPER') ? 'selected' : '' ?>>VERNIER CALIPER</option>
                                                <option value="DIAL VERNIER CALIPER" <?= ($data['instrument_name'] == 'DIAL VERNIER CALIPER') ? 'selected' : '' ?>>DIAL VERNIER CALIPER</option>
                                                <option value="DIGITAL INSIDE GROOVE CALIPER" <?= ($data['instrument_name'] == 'DIGITAL INSIDE GROOVE CALIPER') ? 'selected' : '' ?>>DIGITAL INSIDE GROOVE CALIPER</option>
                                                <option value="INSIDE GROOVE CALIPER" <?= ($data['instrument_name'] == 'INSIDE GROOVE CALIPER') ? 'selected' : '' ?>>INSIDE GROOVE CALIPER</option>
                                                <option value="DIGITAL HEIGHT GAUGE" <?= ($data['instrument_name'] == 'DIGITAL HEIGHT GAUGE') ? 'selected' : '' ?>>DIGITAL HEIGHT GAUGE</option>
                                                <option value="VERNIER HEIGHT GAUGE" <?= ($data['instrument_name'] == 'VERNIER HEIGHT GAUGE') ? 'selected' : '' ?>>VERNIER HEIGHT GAUGE</option>
                                                <option value="DIGITAL PITCH MICROMETER" <?= ($data['instrument_name'] == 'DIGITAL PITCH MICROMETER') ? 'selected' : '' ?>>DIGITAL PITCH MICROMETER</option>
                                                <option value="BEVEL PROTECTOR" <?= ($data['instrument_name'] == 'BEVEL PROTECTOR') ? 'selected' : '' ?>>BEVEL PROTECTOR</option>
                                                <option value="BORE GAUGE" <?= ($data['instrument_name'] == 'BORE GAUGE') ? 'selected' : '' ?>>BORE GAUGE</option>
                                                <option value="LEVER DIAL" <?= ($data['instrument_name'] == 'LEVER DIAL') ? 'selected' : '' ?>>LEVER DIAL</option>
                                                <option value="PLUNGER DIAL" <?= ($data['instrument_name'] == 'PLUNGER DIAL') ? 'selected' : '' ?>>PLUNGER DIAL</option>
                                                <option value="OHMS METER" <?= ($data['instrument_name'] == 'OHMS METER') ? 'selected' : '' ?>>OHMS METER</option>
                                                <option value="PRESSURE GAUGE" <?= ($data['instrument_name'] == 'PRESSURE GAUGE') ? 'selected' : '' ?>>PRESSURE GAUGE</option>
                                                <option value="RUBBER HARDNESS TESTER" <?= ($data['instrument_name'] == 'RUBBER HARDNESS TESTER') ? 'selected' : '' ?>>RUBBER HARDNESS TESTER</option>
                                                <option value="TORQUE WRENCH" <?= ($data['instrument_name'] == 'TORQUE WRENCH') ? 'selected' : '' ?>>TORQUE WRENCH</option>
                                                <option value="SURFACE PLATE" <?= ($data['instrument_name'] == 'SURFACE PLATE') ? 'selected' : '' ?>>SURFACE PLATE</option>
                                                <option value="SURFACE ROUGHNESS COMPARATOR" <?= ($data['instrument_name'] == 'SURFACE ROUGHNESS COMPARATOR') ? 'selected' : '' ?>>SURFACE ROUGHNESS COMPARATOR</option>
                                                <option value="SURFACE ROUGHNESS TESTER" <?= ($data['instrument_name'] == 'SURFACE ROUGHNESS TESTER') ? 'selected' : '' ?>>SURFACE ROUGHNESS TESTER</option>
                                                <option value="HARDNESS TESTER" <?= ($data['instrument_name'] == 'HARDNESS TESTER') ? 'selected' : '' ?>>HARDNESS TESTER</option>
                                                <option value="ROUND FILE (SMALL)" <?= ($data['instrument_name'] == 'ROUND FILE (SMALL)') ? 'selected' : '' ?>>ROUND FILE (SMALL)</option>
                                                <option value="ROUND FILE (BIG)" <?= ($data['instrument_name'] == 'ROUND FILE (BIG)') ? 'selected' : '' ?>>ROUND FILE (BIG)</option>
                                                <option value="FLAT FILE (SMALL)" <?= ($data['instrument_name'] == 'FLAT FILE (SMALL)') ? 'selected' : '' ?>>FLAT FILE (SMALL)</option>
                                                <option value="FLAT FILE (BIG)" <?= ($data['instrument_name'] == 'FLAT FILE (BIG)') ? 'selected' : '' ?>>FLAT FILE (BIG)</option>
                                                <option value="TRIANGLE FILE (SMALL)" <?= ($data['instrument_name'] == 'TRIANGLE FILE (SMALL)') ? 'selected' : '' ?>>TRIANGLE FILE (SMALL)</option>
                                                <option value="TRIANGLE FILE (BIG)" <?= ($data['instrument_name'] == 'TRIANGLE FILE (BIG)') ? 'selected' : '' ?>>TRIANGLE FILE (BIG)</option>
                                                <option value="DIAMOND FILE" <?= ($data['instrument_name'] == 'DIAMOND FILE') ? 'selected' : '' ?>>DIAMOND FILE</option>
                                                <option value="THREAD TAPP" <?= ($data['instrument_name'] == 'THREAD TAPP') ? 'selected' : '' ?>>THREAD TAPP</option>
                                                <option value="V BLOCK" <?= ($data['instrument_name'] == 'V BLOCK') ? 'selected' : '' ?>>V BLOCK</option>
                                                <option value="TAPP WRENCH" <?= ($data['instrument_name'] == 'TAPP WRENCH') ? 'selected' : '' ?>>TAPP WRENCH</option>
                                                <option value="RIMMER" <?= ($data['instrument_name'] == 'RIMMER') ? 'selected' : '' ?>>RIMMER</option>
                                                <option value="DRILL" <?= ($data['instrument_name'] == 'DRILL') ? 'selected' : '' ?>>DRILL</option>
                                                <option value="SAW BLADES" <?= ($data['instrument_name'] == 'SAW BLADES') ? 'selected' : '' ?>>SAW BLADES</option>
                                                <option value="SCREWDRIVER" <?= ($data['instrument_name'] == 'SCREWDRIVER') ? 'selected' : '' ?>>SCREWDRIVER</option>
                                                <option value="VISE" <?= ($data['instrument_name'] == 'VISE') ? 'selected' : '' ?>>VISE</option>
                                                <option value="C-CLAMP" <?= ($data['instrument_name'] == 'C-CLAMP') ? 'selected' : '' ?>>C-CLAMP</option>
                                                <option value="MANDRELS" <?= ($data['instrument_name'] == 'MANDRELS') ? 'selected' : '' ?>>MANDRELS</option>
                                                <option value="CHUCKS" <?= ($data['instrument_name'] == 'CHUCKS') ? 'selected' : '' ?>>CHUCKS</option>
                                                <option value="GRINDING BELT" <?= ($data['instrument_name'] == 'GRINDING BELT') ? 'selected' : '' ?>>GRINDING BELT</option>
                                                <option value="BUFFING WHEEL" <?= ($data['instrument_name'] == 'BUFFING WHEEL') ? 'selected' : '' ?>>BUFFING WHEEL</option>
                                                <option value="GLOVES" <?= ($data['instrument_name'] == 'GLOVES') ? 'selected' : '' ?>>GLOVES</option>
                                                <option value="SPANNER" <?= ($data['instrument_name'] == 'SPANNER') ? 'selected' : '' ?>>SPANNER</option>
                                                <option value="PIPE SPANNER" <?= ($data['instrument_name'] == 'PIPE SPANNER') ? 'selected' : '' ?>>PIPE SPANNER</option>
                                                <option value="ALLEN KEY SET" <?= ($data['instrument_name'] == 'ALLEN KEY SET') ? 'selected' : '' ?>>ALLEN KEY SET</option>
                                                <option value="ALLEN BOLT" <?= ($data['instrument_name'] == 'ALLEN BOLT') ? 'selected' : '' ?>>ALLEN BOLT</option>
                                                <option value="POLISH PAPER" <?= ($data['instrument_name'] == 'POLISH PAPER') ? 'selected' : '' ?>>POLISH PAPER</option>
                                                <option value="PLIER" <?= ($data['instrument_name'] == 'PLIER') ? 'selected' : '' ?>>PLIER</option>
                                                <option value="SCRUBBER" <?= ($data['instrument_name'] == 'SCRUBBER') ? 'selected' : '' ?>>SCRUBBER</option>
                                                <option value="YELLOW DEBBURING CUTTER" <?= ($data['instrument_name'] == 'YELLOW DEBBURING CUTTER') ? 'selected' : '' ?>>YELLOW DEBBURING CUTTER</option>
                                                <option value="ENGRAVER TOOL" <?= ($data['instrument_name'] == 'ENGRAVER TOOL') ? 'selected' : '' ?>>ENGRAVER TOOL</option>
                                                <option value="ENGRAVER MACHINE" <?= ($data['instrument_name'] == 'ENGRAVER MACHINE') ? 'selected' : '' ?>>ENGRAVER MACHINE</option>
                                                <option value="ADVANCE MICRO TEST MACHINE" <?= ($data['instrument_name'] == 'ADVANCE MICRO TEST MACHINE') ? 'selected' : '' ?>>ADVANCE MICRO TEST MACHINE</option>
                                                <option value="METAL BRUSH" <?= ($data['instrument_name'] == 'METAL BRUSH') ? 'selected' : '' ?>>METAL BRUSH</option>
                                                <option value="BRUSH" <?= ($data['instrument_name'] == 'BRUSH') ? 'selected' : '' ?>>BRUSH</option>
                                                <option value="PAINTING ROLLER" <?= ($data['instrument_name'] == 'PAINTING ROLLER') ? 'selected' : '' ?>>PAINTING ROLLER</option>
                                                <option value="MASKS" <?= ($data['instrument_name'] == 'MASKS') ? 'selected' : '' ?>>MASKS</option>
                                                <option value="THINNER / ACETONE" <?= ($data['instrument_name'] == 'THINNER / ACETONE') ? 'selected' : '' ?>>THINNER / ACETONE</option>
                                                <option value="COTTON WASTE" <?= ($data['instrument_name'] == 'COTTON WASTE') ? 'selected' : '' ?>>COTTON WASTE</option>
                                                <option value="SAFETY GLASSES" <?= ($data['instrument_name'] == 'SAFETY GLASSES') ? 'selected' : '' ?>>SAFETY GLASSES</option>
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
                                                <option value="M" <?= ($data['grade'] == 'M') ? 'selected' : '' ?>>M</option>
                                                <option value="G" <?= ($data['grade'] == 'G') ? 'selected' : '' ?>>G</option>
                                                <option value="R" <?= ($data['grade'] == 'R') ? 'selected' : '' ?>>R</option>
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
                                                 <option value="MM" <?= ($data['unit'] == 'MM') ? 'selected' : '' ?>>MM</option>
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
                                                <option value="6g" <?= ($data['class'] == '6g') ? 'selected' : '' ?>>6g</option>
                                                <option value="6h" <?= ($data['class'] == '6h') ? 'selected' : '' ?>>6h</option>
                                                <option value="6G" <?= ($data['class'] == '6G') ? 'selected' : '' ?>>6G</option>
                                                <option value="6H" <?= ($data['class'] == '6H') ? 'selected' : '' ?>>6H</option>
                                                <option value="DIN" <?= ($data['class'] == 'DIN') ? 'selected' : '' ?>>DIN</option>
                                                <option value="A" <?= ($data['class'] == 'A') ? 'selected' : '' ?>>A</option>
                                                <option value="B" <?= ($data['class'] == 'B') ? 'selected' : '' ?>>B</option>
                                                <option value="BSPT" <?= ($data['class'] == 'BSPT') ? 'selected' : '' ?>>BSPT</option>
                                                <option value="NPT" <?= ($data['class'] == 'NPT') ? 'selected' : '' ?>>NPT</option>
                                                <option value="BSW" <?= ($data['class'] == 'BSW') ? 'selected' : '' ?>>BSW</option>
                                                <option value="UNF" <?= ($data['class'] == 'UNF') ? 'selected' : '' ?>>UNF</option>
                                                <option value="UNJF" <?= ($data['class'] == 'UNJF') ? 'selected' : '' ?>>UNJF</option>
                                                <option value="UNC" <?= ($data['class'] == 'UNC') ? 'selected' : '' ?>>UNC</option>
                                                <option value="BSB" <?= ($data['class'] == 'BSB') ? 'selected' : '' ?>>BSB</option>
                                                <option value="BBA" <?= ($data['class'] == 'BBA') ? 'selected' : '' ?>>BBA</option>
                                                <option value="BSF" <?= ($data['class'] == 'BSF') ? 'selected' : '' ?>>BSF</option>
                                                <option value="PG" <?= ($data['class'] == 'PG') ? 'selected' : '' ?>>PG</option>
                                                <option value="WHIT MEDIUM" <?= ($data['class'] == 'WHIT MEDIUM') ? 'selected' : '' ?>>WHIT MEDIUM</option>
                                            </select>                      
                                            <p class="error unit_error"></p>
                                        </div>
                                    </div>
                                </div>

                               <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="measuring_size">Measuring Size</label>
                                            <input type="text" class="form-control" id="measuring_size"  value="<?=$data['measuring_size'];?>" name="measuring_size">
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
                                                        <option value="GO" <?php if($data['type']=='GO'){ echo 'Selected';} ?>>GO</option>
                                                        <option value="NOGO" <?php if($data['type']=='NOGO'){ echo 'Selected';} ?>>NOGO</option>
                                                        <option value="GO/NOGO" <?php if($data['type']=='GO/NOGO'){ echo 'Selected';} ?>>GO/NOGO</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="remark">Remark</label>
                                                <textarea type="text" class="form-control"  id="remark"  name="remark" required><?=$data['remark'];?></textarea>
                                                <p class="error remark_error"></p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" id="updatenewsamplingmethodsubmit" class="btn btn-primary" value="Submit" />
                                <input type="button" onclick="location.href = '<?php echo base_url() ?>addsamplingmethod/<?=$data['sampling_master_id']?>'" class="btn btn-default" value="Back" />
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
