<div id="content">
        <h2>Email Settings and Options</h2>
<form class="form-horizontal" action="<?php echo site_url('admin_emails_controller/emails_settings_process');?>" method="post">
<input type="hidden" name="__CSRFToken__" value="a59bfe8f55febfde7b97c2d84d2f1c325d135d68"><input type="hidden" name="t" value="emails">
<div class="section-break" style="margin-bottom:10px;">
    <em>Note that some of the global settings can be overridden at department/email level.</em>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#default_email_templates"></i> Default Template Set <font class="error">*</font> :</label>
    <div class="col-lg-8">
        <select name="default_template_id" class="form-control">
            <option value="">— Select Default Email Template Set —</option>
            <?php foreach($templategroup->result() as $template){
                if($template->isactive == $default_template){
            echo '<option value="'.$template->tpl_id.'" selected="selected">'.$template->name.'</option>';
            }else{
                echo '<option value="'.$template->tpl_id.'">'.$template->name.'</option>';
            }}?>
        </select>&nbsp;<font class="error"></font>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#default_system_email"></i> Default System Email <font class="error">*</font> :</label>
    <div class="col-lg-8">
        <select name="default_email_id" class="form-control">
            <option value="0" disabled="">Select One</option>
            <?php foreach($email_list->result() as $email){
                if($email->email_id == $default_email){
                    echo '<option value="'.$email->email_id.'" selected="selected">'.$email->name.' ('.$email->email.') </option>';
                }else{
                     echo '<option value="'.$email->email_id.'">'.$email->name.' ('.$email->email.') </option>';
                }
            } ?>
                         </select>
         &nbsp;<font class="error"></font>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#default_alert_email"></i> Default Alert Email <font class="error">*</font> :</label>
    <div class="col-lg-8">
        <select name="alert_email_id" class="form-control">
            <option value="<?php echo $default_email?>" selected="selected">Use Default System Email (above)</option>
            <?php foreach($email_list->result() as $email){
                if($email->id != $default_email){
                     echo '<option value="'.$email->id.'">'.$email->name.' ('.$email->email.') </option>';
                 }}?>
                         </select>
         &nbsp;<font class="error"></font>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#admins_email_address"></i> Admin's Email Address <font class="error">*</font> :</label>
    <div class="col-lg-8">
        <input type="text" size="40" name="admin_email" class="form-control" value="<?php echo $admin_email?>">
                    &nbsp;<font class="error"></font>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#verify_email_addrs"></i> Verify Email Addresses :</label>
    <div class="col-lg-8">
        <input type="hidden" name="verify_email_addrs" value=0>
        <input type="checkbox" name="verify_email_addrs" value="1" <?php if($verify_email==1){
                                                            echo 'checked';}?>>
                Verify email address domain    </div>
</div>
<div class="section-break" style="margin-bottom:10px;">
    <em><strong>Incoming Emails:</strong>&nbsp;</em>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#strip_quoted_reply"></i> Strip Quoted Reply :</label>
    <div class="col-lg-8">
        <input type="hidden" name="strip_quoted_reply" value="0">
        <input type="checkbox" name="strip_quoted_reply" value ="1" <?php if($strip_quote_reply==1){
                                                            echo 'checked';}?>>
                Enable<font class="error">&nbsp;</font>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#reply_separator_tag"></i> Reply Separator Tag :</label>
    <div class="col-lg-8">
        <input type="text" class="form-control" name="reply_separator" value="<?php echo $reply_separator?>">
                &nbsp;<font class="error">&nbsp;</font>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#emailed_tickets_priority"></i> Emailed Tickets Priority :</label>
    <div class="col-lg-8">
        <input type="hidden" name="use_email_priority" value="0">
        <input type="checkbox" name="use_email_priority" value="1" <?php if($email_priority==1){
                                                            echo 'checked';}?>>
        Enable</div>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#accept_all_emails"></i> Accept All Emails :</label>
    <div class="col-lg-8">
        <input type="hidden" name="accept_unregistered_email" value="0">
        <input type="checkbox" name="accept_unregistered_email" value="1" <?php if($accept_unregistered==1){
                                                            echo 'checked';}?>>
            Accept email from unknown Users</div>
</div>
<div class="section-break" style="margin-bottom:10px;">
    <em><strong>Outgoing Email</strong>: Default email only applies to outgoing emails without SMTP setting.</em>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#default_mta"></i> Default MTA :</label>
    <div class="col-lg-8">
        <select name="default_smtp_id">
            <option value="0" selected="selected">None: Use PHP mail function</option>
            <?php foreach($default_MTA->result() as $value){
                echo '<option value="1" selected>'.$value->name.' ('.$value->email.')</option>';
            }?>
                         </select>&nbsp;<font class="error">&nbsp;</font>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#ticket_response_files"></i> Attachments :</label>
    <div class="col-lg-8">
        <input type="hidden" name="email_attachments" value="0">
        <input type="checkbox" name="email_attachments" value="1" <?php if($email_attach==1){
                                                            echo 'checked';}?>>
        Email attachments to the user    </div>
</div>
<p style="text-align:center;">
    <input class="button" type="submit" name="submit" value="Save Changes">
    <input class="button" type="reset" name="reset" value="Reset Changes">
</p>
</form>
</div>
</div>
    <div id="footer" style="margin-bottom:10px;">
        Copyright © 2006-2019&nbsp;Panda Ticketing System&nbsp;All Rights Reserved.
    </div>
    <div>
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
        <img src="/helpdesk/scp/autocron.php" alt="" width="1" height="1" border="0">
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
    </div>
</div>
<div id="overlay"></div>
<div id="loading" style="top: 251.333px; left: 609.5px;">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>
<div class="container dialog draggable ui-draggable" style="display: none; top: 62.8333px; left: 459.5px;" id="popup">
    <div id="popup-loading">
        <h1 style="margin-bottom: 20px;"><i class="icon-spinner icon-spin icon-large"></i>
        Loading ...</h1>
    </div>
    <div class="body"></div>
</div>
<div style="display: none; top: 62.8333px; left: 703.5px;" class="dialog" id="alert">
    <h3><i class="icon-warning-sign"></i> <span id="title"></span></h3>
    <a class="close" href=""><i class="icon-remove-circle"></i></a>
    <hr>
    <div id="body" style="min-height: 20px;"></div>
    <hr style="margin-top:3em">
    <p class="full-width">
        <span class="buttons pull-right">
            <input type="button" value="OK" class="close ok">
        </span>
     </p>
    <div class="clear"></div>
</div>

<script type="text/javascript" src="/helpdesk/js/jquery.pjax.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/bootstrap-typeahead.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/scp.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/jquery-ui-1.10.3.custom.min.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/filedrop.field.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/select2.min.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/tips.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor.min.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor-osticket.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor-plugins.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/jquery.translatable.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/jquery.dropdown.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/bootstrap-tooltip.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/fabric.min.js?9ae093d"></script>
<link type="text/css" rel="stylesheet" href="/helpdesk/scp/css/tooltip.css?9ae093d">
<script type="text/javascript">
    getConfig().resolve({"lock_time":3600,"html_thread":true,"date_format":"Y-MM-dd","lang":"en_US","short_lang":"en","has_rtl":false,"lang_flag":"us","primary_lang_flag":"us","primary_language":"en-US","secondary_languages":[],"page_size":25});
</script>


</body></html>