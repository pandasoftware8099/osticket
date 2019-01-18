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
        <br>
        <p style="text-align:center">
            <input class="button" type="submit" name="submit" value="Save Changes">
            <input class="button" type="reset" name="reset" value="Reset Changes">
        </p>
   </div>
    <div id="templates" class="tab_content hiddens">
    <table class="form_table settings_table" width="100%" border="0" cellspacing="0" cellpadding="2">
    <tbody>
        <tr>
            <th colspan="2">
                <em><b>Authentication and Registration Templates &amp; Pages</b></em>
            </th>
        </tr>
        <?php foreach($user_template->result() as $usertemplate) { ?>
        <tr>
            <td colspan="2">
                <div style="padding:2px 5px">
                    <a data-toggle="modal" data-target="#<?php echo $usertemplate->type;?>">
                        <i class="icon-file-text icon-2x" style="color:#bbb;"></i>
                    </a>
                    <span style="display:inline-block;width:90%;width:calc(100% - 32px);padding-left:10px;line-height:1.2em">
                        <a data-toggle="modal" data-target="#<?php echo $usertemplate->type;?>"><?php echo $usertemplate->title;?></a><br>
                    </span>
                    <span class="faded"><?php echo $usertemplate->notes;?></span><br><br>
                </div>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
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

<?php foreach ($user_template->result() as $usertemplate) { ?>
<div class="modal fade" id="<?php echo $usertemplate->type;?>" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h3 class="modal-title">Manage Content — <?php echo $usertemplate->name;?></h3>
            </div>
            <div class="modal-body form">
                <!-- <div class="col-md-12"> -->
                <form action="<?php echo site_url('admin_settings_controller/templates_update');?>?id=<?php echo $usertemplate->content_guid;?>&direct=user" method="POST" id="form" class="form-horizontal">
                    <input name="topic" class="form-control" type="text" style="width:100%;font-size: 20px"  value="<?php echo $usertemplate->name;?>">
                    <div>
                        <span class="help-block"></span>
                    </div>
                    <!-- tools box -->
                    <div class="box-tools"></div>
                    <!-- /. tools -->
                    <div class="pad">
                        <textarea name="body" class="textarea" placeholder="Start writing your note here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $usertemplate->body;?></textarea>
                        <span class="help-block"></span>
                    </div>
                    <div class="info-banner" style="line-height: 20px">
                        <?php echo $usertemplate->notes;?>
                        <!-- </div> -->
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-default">Save</button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" >Cancel</button>
            </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php } ?>

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