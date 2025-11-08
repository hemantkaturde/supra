<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-cog"></i> Instrument Master
            <small>Add, Edit, Delete</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-left">
                <ul class="breadcrumb" style="background-color:#ecf0f5 !important">
                    <li class="completed"><a href="javascript:void(0);">Masters</a></li>
                    <li class="active"><a href="javascript:void(0);">Instrument Master</a></li>
                </ul>
            </div>
            <div class="col-xs-6 text-right">
                <div class="form-group">
                    <button class="btn btn-primary" onclick="openModal()">
                        <i class="fa fa-plus"></i> Add Instrument
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="view_instrument">
                                <thead>
                                    <tr style="background-color:#3c8dbc !important;color:#fff">
                                        <th>Instrument Name</th>
                                        <th>Grade</th>
                                        <th>Measuring Size</th>
                                        <th>Unit</th>
                                        <th>Class</th>
                                        <th>Type</th>
                                        <th>Qty</th>
                                        <th>Remark</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Instrument Modal -->
<div class="modal fade" id="instrumentModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="instrumentForm">
        <div class="modal-header" style="background-color:#3c8dbc;color:#fff">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Instrument</h4>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id" id="id">

          <!-- Row 1 -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Instrument Name <span class="text-danger">*</span></label>
                <select name="instrument_name" id="instrument_name" class="form-control serachfilternotrequired" required>
                  <option value="">Select</option>
                  <option>TRG</option>
                  <option>TPG</option>
                  <option>Measuring Pin</option>
                  <option>Plain Ring Gauge</option>
                  <option>Plain Plug Gauge</option>
                  <option>Slip Gauge</option>
                  <option>Radius Gauge</option>
                  <option>Micrometer</option>
                  <option>REJECTED VERNIER</option>
                  <option>PROFILE GAUGE</option>
                  <option>DIGITAL MICROMETER</option>
                  <option>BLADE MICROMETER</option>
                  <option>TUBE MICROMETER</option>
                  <option>DEPTH MICROMETER</option>
                  <option>DIGITAL VERNIER CALIPER</option>
                  <option>VERNIER CALIPER</option>
                  <option>DIAL VERNIER CALIPER</option>
                  <option>DIGITAL INSIDE GROOVE CALIPER</option>
                  <option>INSIDE GROOVE CALIPER</option>
                  <option>DIGITAL HEIGHT GAUGE</option>
                  <option>VERNIER HEIGHT GAUGE</option>
                  <option>DIGITAL PITCH MICROMETER</option>
                  <option>BEVEL PROTECTOR</option>
                  <option>BORE GAUGE</option>
                  <option>LEVER DIAL</option>
                  <option>PLUNGER DIAL</option>
                  <option>OHMS METER</option>
                  <option>PRESSURE GAUGE</option>
                  <option>RUBBER HARDNESS TESTER</option>
                  <option>TORQUE WRENCH</option>
                  <option>SURFACE PLATE</option>
                  <option>SURFACE ROUGHNESS COMPARATOR</option>
                  <option>SURFACE ROUGHNESS TESTER</option>
                  <option>HARDNESS TESTER</option>
                  <option>ROUND FILE (SMALL)</option>
                  <option>ROUND FILE (BIG)</option>
                  <option>FLAT FILE (SMALL)</option>
                  <option>FLAT FILE (BIG)</option>
                  <option>TRIANGLE FILE (SMALL)</option>
                  <option>TRIANGLE FILE (BIG)</option>
                  <option>DIAMOND FILE</option>
                  <option>THREAD TAPP</option>
                  <option>V BLOCK</option>
                  <option>TAPP WRENCH</option>
                  <option>RIMMER</option>
                  <option>DRILL</option>
                  <option>SAW BLADES</option>
                  <option>SCREWDRIVER</option>
                  <option>VISE</option>
                  <option>C-CLAMP</option>
                  <option>MANDRELS</option>
                  <option>CHUCKS</option>
                  <option>GRINDING BELT</option>
                  <option>BUFFING WHEEL</option>
                  <option>GLOVES</option>
                  <option>SPANNER</option>
                  <option>PIPE SPANNER</option>
                  <option>ALLEN KEY SET</option>
                  <option>ALLEN BOLT</option>
                  <option>POLISH PAPER</option>
                  <option>PLIER</option>
                  <option>SCRUBBER</option>
                  <option>YELLOW DEBBURING CUTTER</option>
                  <option>ENGRAVER TOOL</option>
                  <option>ENGRAVER MACHINE</option>
                  <option>ADVANCE MICRO TEST MACHINE</option>
                  <option>METAL BRUSH</option>
                  <option>BRUSH</option>
                  <option>PAINTING ROLLER</option>
                  <option>MASKS</option>
                  <option>THINNER / ACETONE</option>
                  <option>COTTON WASTE</option>
                  <option>SAFETY GLASSES</option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Grade</label>
                <select name="grade" id="grade" class="form-control serachfilternotrequired">
                  <option value="">Select</option>
                  <option>M</option>
                  <option>G</option>
                  <option>R</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Row 2 -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Measuring Size</label>
                <input type="text" name="measuring_size" id="measuring_size" class="form-control">
                <!-- <select name="measuring_size" id="measuring_size" class="form-control serachfilternotrequired">
                  <option value="">Select Measuring Size</option>
                  <option>1-10</option>
                  <option>10-20</option>
                  <option>20-30</option>
                  <option>30-40</option>
                  <option>40-50</option>
                  <option>50-60</option>
                  <option>60-70</option>
                  <option>70-80</option>
                  <option>80-90</option>
                  <option>90-100</option>
                </select> -->
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Unit</label>
                <select name="unit" id="unit" class="form-control serachfilternotrequired">
                  <option value="">Select Unit</option>
                  <option>MM</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Row 3 -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Class</label>
                <select name="class" id="class" class="form-control serachfilternotrequired">
                  <option value="">Select Class</option>
                  <option>6g</option><option>6h</option><option>6G</option><option>6H</option>
                  <option>DIN</option><option>A</option><option>B</option><option>BSPT</option>
                  <option>NPT</option><option>BSW</option><option>UNF</option><option>UNJF</option>
                  <option>UNC</option><option>BSB</option><option>BBA</option><option>BSF</option>
                  <option>PG</option><option>WHIT MEDIUM</option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Type</label>
                <select name="type" id="type" class="form-control serachfilternotrequired">
                  <option value="">Select Type</option>
                  <option>Go</option>
                  <option>NoGo</option>
                  <option>Go/NoGo</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Row 4 -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Qty</label>
                <input type="number" name="qty" id="qty" class="form-control">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Remark</label>
                <input type="text" name="remark" id="remark" class="form-control">
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
