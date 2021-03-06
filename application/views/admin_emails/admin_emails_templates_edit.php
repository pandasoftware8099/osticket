<div id="content">
    <form method="get" action="<?php echo site_url('admin_emails_controller/emails_templates_edit');?>?id=<?php echo $_REQUEST['code_name'];?>">
<h2>
    <div class="col-lg-6">
        <span>Email Template Set</span>
        <small> — <a href="<?php echo site_url('admin_emails_controller/emails_templates_info');?>?id=<?php echo $email_template_info->row('tpl_guid');?>">osTicket Default Template (HTML)</a></small>
    </div>
    <div class="col-lg-6">
        <div class="pull-right" style="overflow:auto;">
        <span style="font-size:10pt">Viewing:</span>
        <select id="tpl_options" name="id" style="width:250px;">
            <optgroup label="Ticket End-User Email Templates">
                <?php foreach ($ticket_end_user_templates->result() as $ticket_end_user) { ?>
                <option value="<?php echo $ticket_end_user->email_tpl_guid;?>" <?php echo $ticket_end_user->email_tpl_guid == $_REQUEST['code_name']?"selected":"";?>><?php echo $ticket_end_user->title;?></option>
                <?php } ?>
            </optgroup>
            <optgroup label="Ticket Agent Email Templates">
                <?php foreach ($ticket_agent_templates->result() as $ticket_agent) { ?>
                <option value="<?php echo $ticket_agent->email_tpl_guid;?>" <?php echo $ticket_agent->email_tpl_guid == $_REQUEST['code_name']?"selected":"";?>><?php echo $ticket_agent->title;?></option>
                <?php } ?>
            </optgroup>
            <optgroup label="Task Email Templates">
                <?php foreach ($task_templates->result() as $task) { ?>
                <option value="<?php echo $task->email_tpl_guid;?>" <?php echo $task->email_tpl_guid == $_REQUEST['code_name']?"selected":"";?>><?php echo $task->title;?></option>
                <?php } ?>
            </optgroup>
        </select>
        </div>
    </div>
</h2>
</form>

<br><br><hr><form action="<?php echo site_url('admin_emails_controller/emails_templates_edit_process');?>?id=<?php echo $_REQUEST['code_name'];?>" method="post" class="save">
<div style="border:1px solid #ccc;background:#f0f0f0;padding:5px 10px;
    margin:10px 0;">
<h3 style="font-size:12pt;margin:0"><?php echo $email_template_info->row('title');?></h3>
</div>

<div style="padding-bottom:3px;" class="faded"><strong>Email Subject and Body:</strong></div>
<div id="save" style="padding-top:5px;">
    <input type="text" name="subject" size="65" value="<?php echo $email_template_info->row('subject');?>" style="font-size:14pt;width:100%;box-sizing:border-box">
    <div style="margin-bottom:0.5em;margin-top:0.5em">
    </div>
    <div class="box">
        <div class="box-header">
        <!-- tools box -->
            <div class="pull-right box-tools"></div>
            <!-- /. tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body pad">
            <textarea name="body" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $email_template_info->row('body');?></textarea>
        </div>
    </div>
</div>

<p>**Please do not modify <b>%variable%</b></p>
<p style="text-align:center">
    <input class="button" type="submit" name="submit" value="Save Changes">
    <input class="button" type="reset" name="reset" value="Reset Changes">
</p>
<input type="hidden" name="draft_id">
</form>
</div>

</div>