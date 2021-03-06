<div id="content">
        <form class="form-horizontal" action="<?php echo site_url('admin_emails_controller/emails_diagnostic_process');?>" method="post">
 <input type="hidden" name="__CSRFToken__" value="be9cb08215f7fd058a6fce5651abce8e3371b62d"> <input type="hidden" name="do" value="">
 <h2>Test Outgoing Email</h2>
 <div class="section-break" style="margin-bottom:10px;">
    <em><i class="icon-question-sign"  onmouseenter="MouseOver(event,'tip_box');" onmouseleave="MouseOut('tip_box')"></i> Use the following form to test whether your <strong>Outgoing Email</strong> settings are properly established.</em>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label"><span class="error">*</span>From :</label>
    <div class="col-lg-10">
        <select name="email_guid" class="form-control" required="true">
                    <option value="">— Select FROM Email —</option>
                    <?php foreach($email_list->result() as $value){
                        echo '<option value="'.$value->email_guid.'">'.$value->email.'</option>';
                    }?>      </select>
                &nbsp;<span class="error"></span>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label"><span class="error">*&nbsp;</span>To :</label>
    <div class="col-lg-10">
        <input type="text" size="60" class="form-control" name="email" value="" autofocus="">
            &nbsp;<span class="error"></span>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label"><span class="error">*&nbsp;</span>Subject :</label>
    <div class="col-lg-10">
        <input type="text" size="60" class="form-control" name="subj" value="">
                &nbsp;<span class="error"></span>
    </div>
</div>
<div class="section-break" style="padding-top:0.5em;padding-bottom:0.5em">
                <em><strong>Message</strong>: email message to send.</em>&nbsp;<span class="error">*&nbsp;</span></div>
<div class="box">
            <div class="box-header">
                <!-- tools box -->
                <div class="pull-right box-tools">
            </div>
            <!-- /. tools -->
            </div>

            <!-- /.box-header -->
            <div class="box-body pad"> 
                <textarea name="message" placeholder="Details on the reason(s) for opening the ticket" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
            </div>
        </div>
<p style="text-align:center;">
    <br>
    <input type="submit" name="submit" value="Send Message">
    <input type="reset" name="reset" value="Reset">
    
</p>
<input type="hidden" name="draft_id"></form>
</div>

<div class="tip_box" id="tip_box" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>Test Outgoing Email</h1>The email’s delivery depends on your server settings (php.ini) and/or SMTP configuration.
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

</script>