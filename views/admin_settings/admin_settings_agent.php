<style>
.test {
    padding-top: 7px;
}
</style>
<div id="content">
        <h2>Agents Settings</h2>
<form class="form-horizontal" action="<?php echo site_url('admin_settings_controller/agent_update');?>" method="post">
    <div class="tab">
        <ul class="tabs" id="agents-tabs">
            <li class="active"><a href="#settings">
                <i class="icon-asterisk"></i> Settings</a></li>
            <li><a href="#templates">
                <i class="icon-file-text"></i> Templates</a></li>
        </ul>
    </div>
    <div id="agents-tabs_container">
        <div id="settings" class="tab_content">
            <div class="section-break" style="margin-bottom:10px;">
                <em><b>General Settings</b></em>
            </div>
            <div class="form-group" style="overflow:auto;">
                <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#staff_guidentity_masking"></i> Agent Identity Masking :</label>
                <div class="col-lg-9 test" >
                    <input type="hidden" name="hide_staff_name" value="0">
                    <input type="checkbox" name="hide_staff_name" value="1" <?php if($hide_staff_name->value == '1'){
                        echo 'checked';
                        }?>>
                            Hide agent's name on responses.  (Will Show Department Name instead)</div>
            </div>
            <div class="form-group" style="overflow:auto;">
                <label class="col-lg-3 control-label" style="font-size:13px;"><i class="help-tip icon-question-sign" href="#password_expiration_policy"></i> Password Expiration Policy :</label>
                <div class="col-lg-9 test">
                    <select name="passwd_reset_period" class="form-control">
                        <option value="100" <?php if($pw_expire_period == ''){ echo 'selected'; }?>> --No Expiration-- </option> 
                        <?php for($j=3;$j<13;$j+=3){
                        if($pw_expire_period->value == $j){
                            echo "<option value='$j' selected>Every $j months</option>";
                        }else{
                            echo "<option value='$j'>Every $j months</option>";
                        }
                        }?>
                    </select>
                    <font class="error"></font>
                </div>
            </div>
            <div class="form-group" style="overflow:auto;">
                <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#allow_password_resets"></i> Allow Password Resets :</label>
                <div class="col-lg-9 test">
                    <input type="hidden" name="allow_pw_reset" value="0">
                    <input type="checkbox" name="allow_pw_reset" value="1" <?php if($pw_reset_status->value == '1'){
                        echo 'checked';
                        }?>>
                </div>
            </div>
            <div class="form-group" style="overflow:auto;">
                <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#reset_token_expiration"></i> Reset Token Expiration :</label>
                <div class="col-lg-9 test">
                    <input type="number" name="pw_reset_window" size="3" value="<?php echo $pw_reset_window->value?>"><em>minutes</em>&nbsp;<font class="error"></font>
                </div>
            </div>
            <div class="form-group" style="overflow:auto;">
                <label class="col-lg-3 control-label">Agent Excessive Logins :</label>
                <div class="col-lg-9 test">
                    <select name="staff_max_logins">
                        <?php for($i=1;$i<11;$i++){
                            if($staff_max_login->value == $i){
                                echo "<option value='$i' selected>$i</option>";
                            }else{
                                echo "<option value='$i'>$i</option>";
                            }
                        } ?>
                    </select> failed login attempt(s) allowed before a lock-out is enforced<br>
                    <select name="staff_login_timeout">
                        <?php for($i=1;$i<11;$i++){
                            if($staff_login_timeout->value == $i){
                                echo "<option value='$i' selected>$i</option>";
                            }else{
                                echo "<option value='$i'>$i</option>";
                            }
                        } ?>
                    </select> minutes locked out
                </div>
            </div>
            <div class="form-group" style="overflow:auto;">
                <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#staff_session_timeout"></i> Agent Session Timeout :</label>
                <div class="col-lg-9 test">
                    <input type="text" name="staff_session_timeout" size="3" value="<?php echo $staff_sess_timeout->value?>">
                        minutes <em>(0 to disable)</em>.
                </div>
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
                    <?php foreach ($agent_template->result() as $agenttemplate) { ?>
                    <tr>
                        <td colspan="2">
                            <div style="padding:2px 5px">
                                <a data-toggle="modal" data-target="#<?php echo $agenttemplate->type;?>">
                                    <i class="icon-file-text icon-2x" style="color:#bbb;"></i>
                                </a>
                                <span style="display:inline-block;width:90%;width:calc(100% - 32px);padding-left:10px;line-height:1.2em">
                                <a data-toggle="modal" data-target="#<?php echo $agenttemplate->type;?>"><?php echo $agenttemplate->title;?></a>
                                </span>
                                <span class="faded"><?php echo $agenttemplate->notes;?></span><br><br>
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

<?php foreach ($agent_template->result() as $agenttemplate) { ?>
<div class="modal fade" id="<?php echo $agenttemplate->type;?>" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h3 class="modal-title">Manage Content — <?php echo $agenttemplate->name;?></h3>
            </div>
            <div class="modal-body form">
                <!-- <div class="col-md-12"> -->
                <form action="<?php echo site_url('admin_settings_controller/templates_update');?>?id=<?php echo $agenttemplate->content_guid;?>&direct=agent" method="POST" id="form" class="form-horizontal">
                    <input name="topic" class="form-control" type="text" style="width:100%;font-size: 20px"  value="<?php echo $agenttemplate->name;?>">
                    <div>
                        <span class="help-block"></span>
                    </div>
                    <!-- tools box -->
                    <div class="box-tools"></div>
                    <!-- /. tools -->
                    <div class="pad">
                        <textarea name="body" class="textarea" placeholder="Start writing your note here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $agenttemplate->body;?></textarea>
                        <span class="help-block"></span>
                    </div>
                    <div class="info-banner" style="line-height: 20px">
                        <?php echo $agenttemplate->notes;?>
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