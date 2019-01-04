<div id="content">
        <form class="form-horizontal" action="<?php echo site_url('admin_emails_controller/emails_diagnostic_process');?>" method="post">
 <input type="hidden" name="__CSRFToken__" value="be9cb08215f7fd058a6fce5651abce8e3371b62d"> <input type="hidden" name="do" value="">
 <h2>Test Outgoing Email</h2>
 <div class="section-break" style="margin-bottom:10px;">
    <em><i class="help-tip icon-question-sign" href="#test_outgoing_email"></i> Use the following form to test whether your <strong>Outgoing Email</strong> settings are properly established.</em>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label"><span class="error">*</span>From :</label>
    <div class="col-lg-10">
        <select name="email_id" class="form-control">
                    <option value="0">— Select FROM Email —</option>
                    <?php foreach($email_list->result() as $value){
                        echo '<option value="'.$value->email_id.'">'.$value->email.'</option>';
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