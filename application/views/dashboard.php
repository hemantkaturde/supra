<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Management panel
   </h1>
</section>
<section class="content">
   <div class="row">
      <div class="col-lg-3 col-xs-6">
       
         <div class="small-box bg-aqua">
            <div class="inner">
               <h3>
                  <?php if(isset($tasksCount)) { echo $tasksCount; } else { echo '0'; } ?>
               </h3>
               <p>Tasks</p>
            </div>
            <div class="icon">
               <i class="fa fa-tasks"></i>
            </div>
            <a href="<?php echo base_url(); ?><?php  if($role != ROLE_EMPLOYEE) {echo 'tasks';}else{echo 'etasks';} ?>"
               class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
            </a>
         </div>
      </div>
      <div class="col-lg-3 col-xs-6">

         <div class="small-box bg-green">
            <div class="inner">
               <h3>
                  <?php if(isset($finishedTasksCount)) { echo $finishedTasksCount; } else { echo '0'; } ?>
               </h3>
               <p>More information</p>
            </div>
            <div class="icon">
               <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?php echo base_url(); ?><?php  if($role != ROLE_EMPLOYEE) {echo 'tasks';}else{echo 'etasks';} ?>"
               class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
            </a>
         </div>
      </div>
    
      <div class="col-lg-3 col-xs-6">
        
         <div class="small-box bg-yellow">
            <div class="inner">
               <h3>
                  <?php if(isset($usersCount)) { echo $usersCount; } else { echo '0'; } ?>
               </h3>
               <p>User</p>
            </div>
            <div class="icon">
               <i class="ion ion-person"></i>
            </div>
            <a href="<?php echo base_url(); ?>userListing" class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
            </a>
         </div>
      </div>
     
      <div class="col-lg-3 col-xs-6">
         
         <div class="small-box bg-red">
            <div class="inner">
               <h3>
                  <?php if(isset($logsCount)) { echo $logsCount; } else { echo '0'; } ?>
               </h3>
               <p>Log</p>
            </div>
            <div class="icon">
               <i class="fa fa-archive"></i>
            </div>
            <a href="<?php echo base_url(); ?>log-history" class="small-box-footer">More information
            <i class="fa fa-arrow-circle-right"></i>
            </a>
         </div>
      </div>
   </div>
    

   <div class="row" style="margin-right: 0px; margin-left: 0px;background:#fff">
      <div class="col-lg-12 col-xs-12">
        
         <div class="col-md-3">
            <h3> Search By Part Number</h3>
            <div class="form-group">
               <label for="part_number">Part Number</label>
               <select class="form-control" name="part_number" id="part_number">
                  <option st-id="" value="NA">Select Part Number</option>
                  <?php foreach ($finishgoodList as $key => $value) {?>
                  <option value="<?php echo $value['fin_id']; ?>"><?php echo $value['part_number']; ?>
                  </option>
                  <?php } ?>
               </select>
            </div>
         </div>
      </div>

      <div class="col-lg-12 col-xs-12">
         <div class="col-md-12">
            <div class="panel-body">
              <table width="100%" class="table table-striped table-bordered table-hover"
                id="seachbypartnumberreport">
                <thead>
                    <tr style="background-color:#3c8dbc !important;color:#fff">
                      <th>Part Number</th>
                      <th>PO Number</th>
                      <th>Form Name</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
          </div>
      </div>
</section>
</div>