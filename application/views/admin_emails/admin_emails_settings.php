<div id="content">
        <h2>Email Settings and Options</h2>
<form class="form-horizontal" action="<?php echo site_url('admin_emails_controller/emails_settings_process');?>" method="post">
<input type="hidden" name="__CSRFToken__" value="a59bfe8f55febfde7b97c2d84d2f1c325d135d68"><input type="hidden" name="t" value="emails">
<div class="section-break" style="margin-bottom:10px;">
    <em>Note that some of the global settings can be overridden at department/email level.</em>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box');" onmouseleave="MouseOut('tip_box')"></i> Default Template Set <font class="error">*</font> :</label>
    <div class="col-lg-8">
        <select name="default_template_id" class="form-control" required>
            <option value="">— Select Default Email Template Set —</option>
            <?php foreach($templategroup->result() as $template){
                if($template->tpl_guid == $default_template){
                    echo '<option value="'.$template->tpl_guid.'" selected="selected">'.$template->name.'</option>';
                }else{
                    echo '<option value="'.$template->tpl_guid.'">'.$template->name.'</option>';
            }}?>
        </select>&nbsp;<font class="error"></font>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box1');" onmouseleave="MouseOut('tip_box1')"></i> Default System Email <font class="error">*</font> :</label>
    <div class="col-lg-8">
        <select name="default_email_guid" class="form-control" required>
            <option value="0" disabled="">Select One</option>
            <?php foreach($email_list->result() as $email){
                if($email->email_guid == $default_email){
                    echo '<option value="'.$email->email_guid.'" selected="selected">'.$email->name.' ('.$email->email.') </option>';
                }else{
                     echo '<option value="'.$email->email_guid.'">'.$email->name.' ('.$email->email.') </option>';
                }
            } ?>
                         </select>
         &nbsp;<font class="error"></font>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box2');" onmouseleave="MouseOut('tip_box2')"></i> Default Alert Email <font class="error">*</font> :</label>
    <div class="col-lg-8">
        <select name="alert_email_guid" class="form-control" required>
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
    <label class="col-lg-4 control-label"><i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box3');" onmouseleave="MouseOut('tip_box3')"></i> Admin's Email Address <font class="error">*</font> :</label>
    <div class="col-lg-8">
        <input type="text" size="40" name="admin_email" class="form-control" value="<?php echo $admin_email?>" required>
                    &nbsp;<font class="error"></font>
    </div>
</div>
<!-- <div class="form-group">
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
</div> -->
<div class="section-break" style="margin-bottom:10px;">
    <em><strong>Outgoing Email</strong>: Default email only applies to outgoing emails without SMTP setting.</em>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label"><i class="icon-question-sign"  onmouseenter="MouseOver(event,'tip_box4');" onmouseleave="MouseOut('tip_box4')"></i> Default MTA :</label>
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
    <label class="col-lg-4 control-label"><i class="icon-question-sign"  onmouseenter="MouseOver(event,'tip_box5');" onmouseleave="MouseOut('tip_box5')"></i> Attachments :</label>
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

<div id="tip_box" class="tip_box" style="display:none;">
    <div class="tip_content">
        <a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow">
        <h1><i class="icon-info-sign faded"> </i>Default Email Template Set</h1>
        Select <span class="doc-desc-title">Email Template Set</span> used to send <span class="doc-desc-title">Auto-Responses</span> and <span class="doc-desc-title">Alerts</span> for various actions that can take place during a  Ticket’s lifetime. <br><br> Departments can be assigned a specific Email Template Set.
    </div>
</div>

<div id="tip_box1" class="tip_box" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>Default Outgoing Email</h1>Choose an email address from which outgoing emails are sent. <br><br> <span class="doc-desc-title">Department</span> can set its own <span class="doc-desc-title">email address</span> which will override what is set here.
    </div>
</div>

<div id="tip_box2" class="tip_box" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>Default Alert Email</h1>Choose an email address from which <span class="doc-desc-title">Alerts &amp; Notices</span> are sent to Agents.
    </div>
</div>

<div class="tip_box" id="tip_box3" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>Admin’s Email Address</h1>Enter an adminstrator's email address to which <span class="doc-desc-title">System Errors</span> and <span class="doc-desc-title">New Ticket Alerts</span> (if enabled) are sent.
    </div>
</div>

<div class="tip_box" id="tip_box4" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>Default MTA</h1><span class="doc-desc-title">Default MTA</span> takes care of email delivery process for outgoing emails without SMTP setting.
    </div>
</div>

<div class="tip_box"  id="tip_box5" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>Ticket Response Files</h1>If enabled, any attachments an Agent may attach to a ticket response will be also included in the email to the User.
    </div>
</div>

<script type="text/javascript">
    function MouseOver(e,divid) {
        var left  = e.clientX  + "px";
        var top  = e.clientY  + "px";

        var div = document.getElementById(divid);

        div.style.display = 'block';
        div.style.left = left;
        div.style.top = top;
        $("#" + divid).stop();    
    }

    function MouseOut(divid) {
        document.getElementById(divid).style.display = 'none';
        $("#" + divid).stop();
    }

    // $(document).ready(function() {
    //     var $img = $("#tip_box");
    //     $img.hide();
    //     $('#tipbox').mouseenter(function(e) {
    //         $img.stop(1, 1).fadeIn();
    //         $img.offset({
    //              top: e.pageY - $img.outerHeight(),
    //            left: e.pageX - ($img.outerWidth()/2)
    //         });
    //     }).mouseleave(function() {
    //         $img.stop(1,1).fadeOut();
    //     });
    // });
</script>