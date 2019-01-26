<div id="content">
    <form class="form-horizontal" action="<?php echo site_url('admin_emails_controller/emails_templates_add_process')?>" method="post">
<h2>Add New Template    </h2>
<div class="section-break" style="margin-bottom:10px;">
    <em>Template information</em>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">Name <span class="error">*</span> :</label>
    <div class="col-lg-9">
        <input type="text" class="form-control" size="30" name="name" value="" required>
        &nbsp;<span class="error"></span>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label" style="padding-top:0px">Status <span class="error">*</span> :</label>
    <div class="col-lg-9">
        <label><input type="radio" name="isactive" value="1" checked><strong>&nbsp;Enabled</strong></label>
        &nbsp;
        <label><input type="radio" name="isactive" value="0">&nbsp;Disabled</label>
        &nbsp;<span class="error"></span>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label">Template Set To Clone <span class="error">*</span> :</label>
    <div class="col-lg-9">
        <select class="form-control" name="tpl_guid" required>
            <option value="">— Select Email Template Set to Clone —</option>
            <?php foreach ($email_template_group->result() as $template_group) { ?>
            <option value="<?php echo $template_group->tpl_guid;?>"><?php echo $template_group->name;?></option>
            <?php } ?>
        </select>
        &nbsp;<span class="error"></span>
    </div>
</div>
<!-- <div class="form-group" id="language">
    <label class="col-lg-3 control-label">Language <span class="error">*</span> :</label>
    <div class="col-lg-9">
        <select name="lang_id" class="form-control">
            <option value="en_US" selected="selected">English - US (English)</option>
        </select>
        &nbsp;<span class="error"></span>
    </div>
</div> -->
<div class="section-break" style="margin-bottom:10px;">
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
    <input type="submit" name="submit" value="Add Template">
    <input type="reset" name="reset" value="Reset">
</p>
</form>
</div>