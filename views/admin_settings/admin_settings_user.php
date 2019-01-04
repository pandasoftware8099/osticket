<div id="content">
        <h2>Users Settings</h2>
<form class="form-horizontal" action="<?php echo site_url('admin_settings_controller/user_update');?>" method="post">
<div class="tab">
    <ul class="tabs" id="users-tabs">
        <li class="active"><a href="#settings">
            <i class="icon-asterisk"></i> Settings</a></li>
        <li><a href="#templates">
            <i class="icon-file-text"></i> Templates</a></li>
    </ul>
</div>
<div id="users-tabs_container">
   <div id="settings" class="tab_content">
        <div class="section-break" style="margin-bottom:10px;">
            <em><b>General Settings</b></em>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#registration_method"></i> Registration Method :</label>
            <div class="col-lg-8">
                <select name="client_registration" class="form-control">
                <option value="1"  <?php if($client_registration->value=='1')
                {
                    echo 'selected';
                }?>>Public — Anyone can register</option> 
                <option value="2"  <?php if($client_registration->value=='2')
                {
                    echo 'selected';
                }?>>Private — Only agents can register users</option>           </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">User Excessive Logins :</label>
            <div class="col-lg-8">
                <select name="client_max_logins">
                  <?php for($i=1;$i<11;$i++){
                        if($client_max_logins->value == $i){
                            echo "<option value='$i' selected>$i</option>";
                        }else{
                            echo "<option value='$i'>$i</option>";
                        }

                       }?>            
                </select> failed login attempt(s) allowed before a lock-out is enforced<br>
                <select name="client_login_timeout">
                   <?php for($i=1;$i<11;$i++){
                        if($client_login_timeout->value == $i){
                            echo "<option value='$i' selected>$i</option>";
                        }else{
                            echo "<option value='$i'>$i</option>";
                        }

                       }?>          
                </select> minutes locked out
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#client_session_timeout"></i> User Session Timeout :</label>
            <div class="col-lg-8">
                <input type="text" name="client_session_timeout" size="6" value="<?php echo $client_session_timeout->value?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#allow_auth_tokens"></i> Authentication Token :</label>
            <div class="col-lg-8">
                <input type="hidden" name="allow_auth_tokens" value="0">
                <input type="checkbox" name="allow_auth_tokens" value="1" 
                <?php if($allow_auth_tokens->value == '1')
                {
                    echo 'checked';
                }?>
                    > Enable use of authentication tokens to auto-login users            </div>
        </div>
   </div>
   <div id="templates" class="tab_content hiddens">
    <table class="form_table settings_table" width="100%" border="0" cellspacing="0" cellpadding="2">
    <tbody>
        <tr>
            <th colspan="2">
                <em><b>Authentication and Registration Templates &amp; Pages</b></em>
            </th>
        </tr>
        <tr><td colspan="2">
    <div style="padding:2px 5px">
    <a href="#ajax.php/content/12/manage" onclick="javascript:
        $.dialog($(this).attr('href').substr(1), 201);
    return false;" class="pull-left"><i class="icon-file-text icon-2x" style="color:#bbb;"></i> </a>
    <span style="display:inline-block;width:90%;width:calc(100% - 32px);padding-left:10px;line-height:1.2em">
    <a href="#ajax.php/content/12/manage" onclick="javascript:
        $.dialog($(this).attr('href').substr(1), 201, null, {size:'large'});
    return false;">Guest Ticket Access</a><br>
        <span class="faded">This template defines the notification for Clients that an access link was sent to their email        <br><em>Last Updated </em></span>
    </span></div></td></tr>        <tr><td colspan="2">
    <div style="padding:2px 5px">
    <a href="#ajax.php/content/9/manage" onclick="javascript:
        $.dialog($(this).attr('href').substr(1), 201);
    return false;" class="pull-left"><i class="icon-file-text icon-2x" style="color:#bbb;"></i> </a>
    <span style="display:inline-block;width:90%;width:calc(100% - 32px);padding-left:10px;line-height:1.2em">
    <a href="#ajax.php/content/9/manage" onclick="javascript:
        $.dialog($(this).attr('href').substr(1), 201, null, {size:'large'});
    return false;">Sign-In Page</a><br>
        <span class="faded">This composes the header on the Client Log In page        <br><em>Last Updated </em></span>
    </span></div></td></tr>        <tr><td colspan="2">
    <div style="padding:2px 5px">
    <a href="#ajax.php/content/8/manage" onclick="javascript:
        $.dialog($(this).attr('href').substr(1), 201);
    return false;" class="pull-left"><i class="icon-file-text icon-2x" style="color:#bbb;"></i> </a>
    <span style="display:inline-block;width:90%;width:calc(100% - 32px);padding-left:10px;line-height:1.2em">
    <a href="#ajax.php/content/8/manage" onclick="javascript:
        $.dialog($(this).attr('href').substr(1), 201, null, {size:'large'});
    return false;">Password Reset Email</a><br>
        <span class="faded">This template defines the email sent to Clients who select the <strong>Forgot My Password</strong> link on the Client Log In page.        <br><em>Last Updated </em></span>
    </span></div></td></tr>        <tr><td colspan="2">
    <div style="padding:2px 5px">
    <a href="#ajax.php/content/10/manage" onclick="javascript:
        $.dialog($(this).attr('href').substr(1), 201);
    return false;" class="pull-left"><i class="icon-file-text icon-2x" style="color:#bbb;"></i> </a>
    <span style="display:inline-block;width:90%;width:calc(100% - 32px);padding-left:10px;line-height:1.2em">
    <a href="#ajax.php/content/10/manage" onclick="javascript:
        $.dialog($(this).attr('href').substr(1), 201, null, {size:'large'});
    return false;">Please Confirm Email Address Page</a><br>
        <span class="faded">This templates defines the page shown to Clients after completing the registration form        <br><em>Last Updated </em></span>
    </span></div></td></tr>        <tr><td colspan="2">
    <div style="padding:2px 5px">
    <a href="#ajax.php/content/7/manage" onclick="javascript:
        $.dialog($(this).attr('href').substr(1), 201);
    return false;" class="pull-left"><i class="icon-file-text icon-2x" style="color:#bbb;"></i> </a>
    <span style="display:inline-block;width:90%;width:calc(100% - 32px);padding-left:10px;line-height:1.2em">
    <a href="#ajax.php/content/7/manage" onclick="javascript:
        $.dialog($(this).attr('href').substr(1), 201, null, {size:'large'});
    return false;">Account Confirmation Email</a><br>
        <span class="faded">This template defines the email sent to Clients when their account has been created in the Client Portal or by an Agent on their behalf        <br><em>Last Updated </em></span>
    </span></div></td></tr>        <tr><td colspan="2">
    <div style="padding:2px 5px">
    <a href="#ajax.php/content/11/manage" onclick="javascript:
        $.dialog($(this).attr('href').substr(1), 201);
    return false;" class="pull-left"><i class="icon-file-text icon-2x" style="color:#bbb;"></i> </a>
    <span style="display:inline-block;width:90%;width:calc(100% - 32px);padding-left:10px;line-height:1.2em">
    <a href="#ajax.php/content/11/manage" onclick="javascript:
        $.dialog($(this).attr('href').substr(1), 201, null, {size:'large'});
    return false;">Account Confirmed Page</a><br>
        <span class="faded">This template defines the content displayed after Clients successfully register by confirming their account        <br><em>Last Updated </em></span>
    </span></div></td></tr></tbody>
</table>
</div>
<p style="text-align:center">
    <input class="button" type="submit" name="submit" value="Save Changes">
    <input class="button" type="reset" name="reset" value="Reset Changes">
</p>
</div>
</form>
</div>

</div>
    <div>
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
        <img src="/helpdesk/scp/autocron.php" alt="" width="1" height="1" border="0">
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
    </div>
</div>
<div id="overlay" style="opacity: 0.5; display: none;"></div>
<div id="loading" style="top: 235.333px; left: 609.5px;">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>
<div class="container dialog draggable ui-draggable" style="display: none; top: 58.8333px; left: 459.5px;" id="popup">
    <div id="popup-loading">
        <h1 style="margin-bottom: 20px;"><i class="icon-spinner icon-spin icon-large"></i>
        Loading ...</h1>
    </div>
    <div class="body"></div>
</div>
<div style="display: none; top: 58.8333px; left: 703.5px;" class="dialog" id="alert">
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