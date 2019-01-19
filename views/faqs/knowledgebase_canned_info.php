<div id="content">
        <form id="mass-actions" action="<?php echo site_url('staff_faqs_controller/canned_response_info_process?id=');echo $_REQUEST['id']?>" method="POST" name="staff" enctype="multipart/form-data">

 <h2><i class="help-tip icon-question-sign" href="#canned_response"></i> Add New Canned Response         </h2>
<div style="background:#eee;padding:5px;border:1px solid #ccc;">
    <em>Canned response settings</em>
</div>
<div class="form-group" style="overflow:auto;">
    <label class="col-lg-3 control-label">Status <span class="error">*</span></label>
    <div class="col-lg-9">
        <label><input type="radio" name="isenabled" value="1" <?php if ($canned_info->row('isenabled') == 1) { echo 'checked="" '; } ?> >&nbsp;Active&nbsp;</label>
        <label><input type="radio" name="isenabled" value="0" <?php if ($canned_info->row('isenabled') == 0) { echo 'checked="" '; } ?> >&nbsp;Disabled&nbsp;</label>
        &nbsp;<span class="error">&nbsp;</span>
    </div>
</div>
<div class="form-group" style="overflow:auto;">
    <label class="col-lg-3 control-label">Department <span class=""></span></label>
    <div class="col-lg-9">
        <select name="dept_guid" class="form-control">
            <option value="0">— All Departments —</option>
            <?php foreach ($department->result() as $value) { ?>
                <option <?php if ($canned_info->row('dept_id') == $value->department_guid) { echo 'selected="" '; } ?> value="<?php echo $value->department_guid ?>"><?php echo $value->name ?></option>  
            <?php } ?>
             
        </select>
        &nbsp;<span class="error"></span>
    </div>
</div>
<div style="background:#eee;padding:5px;border:1px solid #ccc;margin-bottom:10px;">
    <em><strong>Canned Response</strong>: Make the title short and clear.&nbsp;</em>
</div>
<div class="form-group" style="overflow:auto;">
    <label class="col-lg-3 control-label">Title <span class="error">*</span></label>
    <div class="col-lg-9">
        <input type="text" size="70" class="form-control" name="title" value="<?php echo $canned_info->row('title') ?>">
        <span class="error"></span>
    </div>
</div>
<div class="form-group" style="overflow:auto;">
    <p style="padding-left:15px;">
        <b>Canned Response</b>
        <font class="error">*&nbsp;</font>
         &nbsp;&nbsp;&nbsp;(<a class="tip" href="#ticket_variables" rel="tip-1">Supported Variables</a>)
    </p>
    <div class="col-lg-12">
        <textarea required="true" name="canned_response" id="ticket-response" class="textarea" placeholder="Start writing your message here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $canned_info->row('response') ?></textarea>
    </div>
</div>
<!-- <div>
    <h3><i class="help-tip icon-question-sign" href="#canned_attachments"></i> Canned Attachments (optional)    </h3>
    <div class="error"></div>
</div>
<div>
    <div id="588246935de4008779bc9f" class="filedrop"><div class="files"></div>
            <div class="dropzone"><i class="icon-upload"></i>
            Drop files here or <a href="#" class="manual"> choose them </a>        <input type="file" multiple="multiple" id="file-588246935de4008779bc9f" style="display: none; width: 0px; height: 0px;" accept="">
        </div></div>
        <script type="text/javascript">
        $(function(){$('#588246935de4008779bc9f .dropzone').filedropbox({
          url: 'ajax.php/form/upload/attach',
          link: $('#588246935de4008779bc9f').find('a.manual'),
          paramname: 'upload[]',
          fallback_id: 'file-588246935de4008779bc9f',
          allowedfileextensions: [],
          allowedfiletypes: [],
          maxfiles: 20,
          maxfilesize: 2,
          name: 'attachments[]',
          files: []        });});
        </script>
</div> -->
<div style="background:#eee;padding:5px;border:1px solid #ccc;margin-bottom:10px;">
    <em><strong>Internal Notes</strong>: Notes about the canned response.&nbsp;</em>
</div>
<div class="col-lg-12">
    <textarea required="true" name="notes" id="ticket-response" class="textarea" placeholder="Start writing your message here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $canned_info->row('notes') ?></textarea>
</div>
 <p style="text-align:center;">
    <input type="submit" name="submit" value="Add Response">
    <input type="reset" name="reset" value="Reset" onclick="javascript:
        $(this.form).find('textarea.richtext')
            .redactor('deleteDraft');
        location.reload();">
    <input type="button" name="cancel" value="Cancel" onclick="window.location.href=&quot;canned.php&quot;">
</p>
<input type="hidden" name="draft_id"></form>        <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css"></div>
</div>
 