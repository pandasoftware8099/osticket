<div id="content">
        <form class="form-horizontal" action="<?php echo site_url('admin_manage_controller/manage_api_info_process')?>?id=<?php echo $_REQUEST['id'] ?>" method="post">

 <h2><i class="help-tip icon-question-sign" href="#api_key"></i> Update API Key <small>
    — <?php echo $api->apikey;?></small>        </h2>
    <div class="section-break" style="margin-bottom:10px;">
        <em>API Key is auto-generated. Delete and re-add to change the key.</em>
    </div>
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-2 control-label">Status <span class="error">*</span> :</label>
        <div class="col-lg-10">
            <input type="radio" name="isactive" value="1" <?php echo ($api->isactive == 1)?"checked":""; ?>><strong>Active</strong>
            <input type="radio" name="isactive" value="0" <?php echo ($api->isactive == 0)?"checked":""; ?>>Disabled        </div>
    </div>
        <div class="form-group" style="overflow:auto;">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#ip_addr"></i> IP Address <span class="error">*&nbsp;</span> :</label>
        <div class="col-lg-10">
            <span>
                <?php echo $api->ipaddr;?>
            </span>
        </div>
    </div>
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#ip_addr"></i> API Key <span class="error">*&nbsp;</span> :</label>
        <div class="col-lg-10">
            <span>
                <?php echo $api->apikey;?>
            </span>
        </div>
    </div>
        <div class="section-break" style="margin-bottom:10px;">
        <em><strong>Services:</strong> Check applicable API services enabled for the key.</em>
    </div>
    <div class="form-group" style="overflow:auto;">
        <label style="margin-left:15px;margin-right:15px;">
            <input type="checkbox" name="can_create_tickets" value="1" <?php echo ($api->can_create_tickets == 1)?"checked":""; ?>>
            Can Create Tickets <em>(XML/JSON/EMAIL)</em>        </label>
    </div>
    <div class="form-group" style="overflow:auto;">
        <label style="margin-left:15px;margin-right:15px;" >
            <input type="checkbox" name="can_exec_cron" value="1" <?php echo ($api->can_exec_cron == 1)?"checked":""; ?>>
            Can Execute Cron        </label>
    </div>
    <div class="section-break" style="margin-bottom:10px;">
        <em><strong>Internal Notes</strong>: Be liberal, they're internal</em>
    </div>
    <div class="col-lg-12">
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
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $api->notes?></textarea>
                
              
            </div>
          </div>
    </div>
<p style="text-align:center">
    <input type="submit" name="submit" value="Add Key">
    <input type="reset" name="reset" value="Reset">
    <input type="button" name="cancel" value="Cancel" onclick="window.location.href=&quot;apikeys.php&quot;">
</p>
</form>
</div>
</div>