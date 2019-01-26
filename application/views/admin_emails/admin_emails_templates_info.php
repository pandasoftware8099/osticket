<div id="content">
    <form class="form-horizontal" action="<?php echo site_url('admin_emails_controller/emails_templates_info_process');?>?id=<?php echo $_REQUEST['id'];?>" method="post">
 <h2>Update Template    <small>
    — osTicket Default Template (HTML)</small>
     </h2>
<div class="section-break" style="margin-bottom:10px;">
    <em>Template information</em>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">Name <span class="error">*</span> :</label>
    <div class="col-lg-9">
        <input type="text" class="form-control" size="30" name="name" value="<?php echo $emails_templates_group_info->row('name');?>" required>
        &nbsp;<span class="error"></span>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label" style="padding-top:0px">Status <span class="error">*</span> :</label>
    <div class="col-lg-9">
        <label><input type="radio" name="isactive" value="1" <?php echo $emails_templates_group_info->row('isactive') == 1?"checked":"";?> <?php echo $default_template_id->row('value') == $_REQUEST['id']?"disabled":"";?>><strong>&nbsp;Enabled</strong></label>
        &nbsp;
        <label><input type="radio" name="isactive" value="0" <?php echo $emails_templates_group_info->row('isactive') == 0?"checked":"";?> <?php echo $default_template_id->row('value') == $_REQUEST['id']?"disabled":"";?>>&nbsp;Disabled</label>
        &nbsp;<span class="error"></span>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label" style="padding-top:0px">Language :</label>
    <div class="col-lg-9">
        English - US (English)
    </div>
</div>
<div class="section-break" style="margin-bottom:10px;">
    <em><strong>Ticket End-User Email Templates</strong>
        :: Click on the title to edit.</em>
</div>
<?php foreach ($ticket_end_user_templates->result() as $ticket_end_user) { ?>
    <strong><a href="<?php echo site_url('admin_emails_controller/emails_templates_edit')?>?id=<?php echo $ticket_end_user->email_tpl_guid?>"><?php echo $ticket_end_user->title;?></a></strong><br>
    <p><?php echo $ticket_end_user->notes;?></p>
<?php } ?>
<div class="section-break" style="margin-bottom:10px;">
    <em><strong>Ticket Agent Email Templates</strong>
        :: Click on the title to edit.</em>
</div>
<?php foreach ($ticket_agent_templates->result() as $ticket_agent) { ?>
    <strong><a href="<?php echo site_url('admin_emails_controller/emails_templates_edit')?>?id=<?php echo $ticket_agent->email_tpl_guid?>"><?php echo $ticket_agent->title;?></a></strong><br>
    <p><?php echo $ticket_agent->notes;?></p>
<?php } ?>
<div class="section-break" style="margin-bottom:10px;">
    <em><strong>Task Email Templates</strong>
        :: Click on the title to edit.</em>
</div>
<?php foreach ($task_templates->result() as $task) { ?>
    <strong><a href="<?php echo site_url('admin_emails_controller/emails_templates_edit')?>?id=<?php echo $task->email_tpl_guid?>"><?php echo $task->title;?></a></strong><br>
    <p><?php echo $task->notes;?></p>
<?php } ?>
<br><div class="section-break" style="margin-bottom:10px;">
    <em><strong>Internal Notes</strong>: Be liberal, they're internal</em>
</div>
<div class="col-lg-12">
    <div class="box">
        <div class="box-header">
        <!-- tools box -->
            <div class="pull-right box-tools"></div>
            <!-- /. tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body pad">
            <textarea name="notes" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
        </div>
    </div>
</div>
<br><p style="text-align:center">
    <input type="submit" name="submit" value="Save Changes">
    <input type="reset" name="reset" value="Reset">
</p>
</form>
</div>
</div>