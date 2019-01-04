<div id="content">
        <form class="form-horizontal" action="<?php echo site_url('admin_manage_controller/manage_sla_info_process')?>?id=<?php echo $_REQUEST['id'] ?>" method="post">

 <h2>Update SLA Plan    <small>
    — <?php echo $sla->sla_name;?></small></h2> 
    <div class="section-break" style="margin-bottom:10px;">
        <em>Tickets are marked overdue on grace period violation.</em>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#name"></i> Name <span class="error">*</span> :</label>
        <div class="col-lg-9">
            <input type="text" class="form-control" size="30" name="name" value="<?php echo $sla->sla_name?>" autofocus="" data-translate-tag="">
                &nbsp;<span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#grace_period"></i> Grace Period <span class="error">*</span> :</label>
        <div class="col-lg-7">
            <input type="text" class="form-control" size="10" name="grace_period" value="<?php echo $sla->grace_period?>">
                &nbsp;<span class="error"></span>
        </div>
        <div class="col-lg-2">
            <em>( in hours )</em>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Status <span class="error">*</span> :</label>
        <div class="col-lg-9">
            <input type="radio" name="isactive" value="1" <?php echo ($sla->isactive == 1)?"checked":""; ?>><strong>Active</strong>
            <input type="radio" name="isactive" value="0" <?php echo ($sla->isactive == 0)?"checked":""; ?>>Disabled            &nbsp;<span class="error"></span>
        </div>
    </div>
    <!-- <div class="form-group">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#transient"></i> Transient :</label>
        <div class="col-lg-9">
            <input type="checkbox" name="transient" value="1">
            SLA can be overridden on ticket transfer or help topic change        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Ticket Overdue Alerts :</label>
        <div class="col-lg-9">
            <input type="checkbox" name="disable_overdue_alerts" value="1">
            <strong>Disable</strong> overdue alerts notices.            <em>(Override global setting)</em>
        </div>
    </div> -->
    <div class="section-break" style="margin-bottom:10px;">
        <em><strong>Internal Notes</strong>: Be liberal, they're internal                </em>
    </div>
    <div class="box">
            <div class="box-header">

              <!-- tools box -->
              <div class="pull-right box-tools">

              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
                
                <textarea name="notes" class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $sla->notes?></textarea>
                
              
            </div>
          </div>
<p style="text-align:center;">
    <input type="submit" name="submit" value="Add Plan">
    <input type="reset" name="reset" value="Reset">
    <input type="button" name="cancel" value="Cancel" onclick="window.location.href=&quot;slas.php&quot;">
</p>
</form>
</div>

</div>
