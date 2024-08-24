<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Log History
            <small>
Users Log History</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            <?= $userInfo->name." : ".$userInfo->email ?>
                        </h3>
                        <div class="box-tools">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>UserName</th>
                                            <th>Process</th>
                                            <th>Process Function</th>
                                            <th>UserRol ID</th>
                                            <th>UserRol</th>
                                            <th>UserIP</th>
                                            <th>Scanner</th>
                                            <th>ScannerAllInformation</th>
                                            <th>Platform</th>
                                            <th>Tarih ve Zaman</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                      if(!empty($userRecords))
                      {
                          foreach($userRecords as $record)
                          {
                      ?>
                                            <tr>
                                                <td>
                                                    <?php echo $record->id ?>
                                                </td>
                                                <td>
                                                    <?php echo $record->userName ?>
                                                </td>
                                                <td>
                                                    <?php echo $record->process ?>
                                                </td>
                                                <td>
                                                    <?php echo $record->processFunction ?>
                                                </td>
                                                <td>
                                                    <?php echo $record->userRoleId ?>
                                                </td>
                                                <td>
                                                    <?php echo $record->userRoleText ?>
                                                </td>
                                                <td>
                                                    <?php echo $record->userIp ?>
                                                </td>
                                                <td>
                                                    <?php echo $record->userAgent ?>
                                                </td>
                                                <td>
                                                    <?php echo $record->agentString ?>
                                                </td>
                                                <td>
                                                    <?php echo $record->platform ?>
                                                </td>
                                                <td>
                                                    <?php echo $record->createdDtm ?>
                                                </td>
                                            </tr>
                                            <?php
                          }
                      }
                      ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>