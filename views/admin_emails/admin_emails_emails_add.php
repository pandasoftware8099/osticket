<div id="content">
        <h2>Add New Email Address    </h2>
<form class="form-horizontal" action="<?php echo site_url('admin_emails_controller/emails_emails_add_process')?>" method="post">

    <div class="section-break" style="margin-bottom:10px;">
        <em><strong>Email Information and Settings</strong></em>
    </div>
    <div class="form-group" style="overflow:auto;margin-bottom:0px;">
        <label class="col-lg-3 control-label">Email Address <span class="error">*</span></label>
        <div class="col-lg-9">
            <input required="true" type="text" class="form-control" size="35" name="email" value="" autofocus="">
                &nbsp;<span class="error"></span>
        </div>
    </div>
    <div class="form-group" style="overflow:auto;margin-bottom:0px;">
        <label class="col-lg-3 control-label">Email Name <span class="error">*</span></label>
        <div class="col-lg-9">
            <input required="true" type="text" class="form-control" size="35" name="name" value="">
                &nbsp;<span class="error">&nbsp;</span>
        </div>
    </div>
    <div class="section-break" style="margin-bottom:10px;">
        <em><strong>New Ticket Settings</strong></em>
    </div>
    <div class="form-group" style="overflow:auto;margin-bottom:0px;">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#new_ticket_department"></i> Department</label>
        <div class="col-lg-9">
            <select required="true" name="dept_id" class="form-control">
                <option value="0" selected="selected">— System Default —</option>
                <?php foreach ($department->result() as $value) { ?>
                <option value="<?php echo $value->id?>"><?php echo $value->name?></option>
                <?php } ?>

            </select>
            &nbsp;<span class="error"></span>
        </div>
    </div>
    <div class="form-group" style="overflow:auto;margin-bottom:0px;">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#new_ticket_priority"></i> Priority </label>
        <div class="col-lg-9">
            <span>
                <select required="true" name="priority_id" class="form-control">
                    <option value="0" selected="selected">— System Default —</option>
                    <?php foreach ($priority->result() as $value) { ?>
                <option value="<?php echo $value->priority_id?>"><?php echo $value->priority_desc?></option>
                <?php } ?></select>
            </span>
            &nbsp;<span class="error"></span>
        </div>
    </div>
    <div class="form-group" style="overflow:auto;margin-bottom:0px;">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#new_ticket_help_topic"></i> Help Topic</label>
        <div class="col-lg-9">
            <select name="topic_id" class="form-control">
                <option value="0" selected="selected">— System Default —</option>
                                        <?php foreach ($topic->result() as $value) { ?>
                <option value="<?php echo $value->topic_id?>"><?php echo $value->topic?></option>
                <?php } ?></select>
                                </select>
            <span class="error">
                            </span>
        </div>
    </div>
    <div class="form-group" style="overflow:auto;margin-bottom:0px;">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#auto_response"></i> Auto-Response</label>
        <div class="col-lg-9">
            <label><input type="checkbox" name="noautoresp" value="1">
                <strong>Disable</strong> for this email            </label>
        </div>
    </div>
    <div class="section-break" style="margin-bottom:10px;">
        <em><i class="help-tip icon-question-sign" href="#login_information"></i> <strong>Email Login Information</strong></em>
    </div>
    <div class="form-group" style="overflow:auto;margin-bottom:0px;">
        <label class="col-lg-3 control-label">Username <span class="error">*</span></label>
        <div class="col-lg-9">
            <input required type="text" class="form-control" size="35" name="userid" value="" autocomplete="off" autocorrect="off">
                &nbsp;<span class="error">&nbsp;&nbsp;</span>
        </div>
    </div>
    <div class="form-group" style="overflow:auto;margin-bottom:0px;">
        <label class="col-lg-3 control-label">Password <span class="error">*</span></label>
        <div class="col-lg-9">
            <input required type="password" class="form-control" size="35" name="passwd" value="" autocomplete="off">
                &nbsp;<span class="error">&nbsp;&nbsp;</span>
                <br><em></em>
        </div>
    </div>
    <div class="section-break" style="margin-bottom:10px;">
        <em><i class="help-tip icon-question-sign" href="#mail_account"></i> <strong>Fetching Email via IMAP or POP</strong>
        &nbsp;<font class="error">&nbsp;</font></em>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Status</label>
        <div class="col-lg-9">
            <label><input type="radio" name="mail_active" value="1">&nbsp;Enable</label>
                &nbsp;&nbsp;
                <label><input type="radio" name="mail_active" value="0" checked="checked">&nbsp;Disable</label>
                &nbsp;<font class="error">&nbsp;</font>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#host_and_port"></i> Hostname <span class="error">*</span></label>
        <div class="col-lg-9">
            <input required type="text" name="mail_host" class="form-control" size="35" value="">
            &nbsp;<font class="error">&nbsp;</font>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#host_and_port"></i> Port Number <span class="error">*</span></label>
        <div class="col-lg-9">
            <input required type="text" class="form-control" name="mail_port" size="6" value="">
            <span>
                &nbsp;<font class="error">&nbsp;</font>
            </span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#protocol"></i> Mail Box Protocol </label>
        <div class="col-lg-9">
            <select name="mail_proto" class="form-control">
                <option value="">— Select protocol —</option>
                                                <option value="IMAP/SSL">IMAP + SSL</option>
                                                <option value="IMAP">IMAP</option>
                                                <option value="POP/SSL">POP + SSL</option>
                                                <option value="POP">POP</option>
                            </select>
            <font class="error">&nbsp;</font>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#fetch_frequency"></i> Fetch Frequency</label>
        <div class="col-lg-9">
            <input type="text" name="mail_fetchfreq" size="4" value="5"> minutes            &nbsp;<font class="error">&nbsp;</font>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#emails_per_fetch"></i> Emails Per Fetch</label>
        <div class="col-lg-9">
            <input type="text" name="mail_fetchmax" size="4" value="10">
            &nbsp;<font class="error">&nbsp;</font>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Fetched Emails</label>
        <div class="col-lg-9">
            <!-- <label><input type="radio" name="postfetch" value="archive">
            Move to folder:
            <input type="text" name="mail_archivefolder" size="20" value=""></label>
                &nbsp;<font class="error"></font>
                <i class="help-tip icon-question-sign" href="#fetched_emails"></i>
            <br> -->
            <label><input type="radio" name="postfetch" value="1">
            Delete emails</label>
            <br>
            <label><input type="radio" name="postfetch" value="0">
            Do nothing <em>(not recommended)</em></label>
          <br><font class="error"></font>
        </div>
    </div>
    <div class="section-break" style="margin-bottom:10px;">
        <em><i class="help-tip icon-question-sign" href="#smtp_settings"></i><strong>Sending Email via SMTP</strong>
        &nbsp;<font class="error">&nbsp;</font></em>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Status</label>
        <div class="col-lg-9">
            <label><input type="radio" name="smtp_active" value="1">&nbsp;Enable</label>
            &nbsp;
            <label><input type="radio" name="smtp_active" value="0" checked="">&nbsp;Disable</label>
            &nbsp;<font class="error">&nbsp;</font>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#host_and_port"></i> Hostname </label>
        <div class="col-lg-9">
            <input type="text" class="form-control" name="smtp_host" size="35" value="">
                &nbsp;<font class="error"></font>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#host_and_port"></i> Port Number </label>
        <div class="col-lg-9">
            <input type="text" name="smtp_port" class="form-control" size="6" value="">
            &nbsp;<font class="error"></font>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Authentication Required</label>
        <div class="col-lg-9">
            <label><input type="radio" name="smtp_auth" value="1" checked=""> Yes</label>
             &nbsp;
             <label><input type="radio" name="smtp_auth" value="0"> No</label>
            <font class="error">&nbsp;</font>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#header_spoofing"></i> Header Spoofing</label>
        <div class="col-lg-9">
            <label><input type="checkbox" name="smtp_spoofing" value="1">
                Allow for this email</label>
        </div>
    </div>
    <div class="section-break" style="margin-bottom:10px;">
        <em><strong>Internal Notes</strong>: Be liberal, they're internal &nbsp;<span class="error">&nbsp;</span></em>
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
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                
              
            </div>
            </div>
    </div>
<p style="text-align:center;">
    <input type="submit" name="submit" value="Submit">
    <input type="reset" name="reset" value="Reset">
    <input type="button" name="cancel" value="Cancel" onclick="window.location.href=&quot;emails.php&quot;">
</p>
</form>
</div>

</div>