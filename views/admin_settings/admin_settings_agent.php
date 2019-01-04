<style>
.test {
    padding-top: 7px;
}
</style>
<div id="content">
        <h2>Agents Settings</h2>
<form class="form-horizontal" action="<?php echo site_url('admin_settings_controller/agent_update');?>" method="post">
    <input type="hidden" name="__CSRFToken__" value="bc3dbd5b6181e5eceb2b593e461e1ce5381e9aaa">    <input type="hidden" name="t" value="agents">
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
                <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#staff_identity_masking"></i> Agent Identity Masking :</label>
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
                        <option value="100" <?php if($pw_expire_period == ''){
                                                echo 'selected';
                                            }?>
                        > --No Expiration-- </option> 
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

                       }?>
                        </select> failed login attempt(s) allowed before a lock-out is enforced                    <br>
                    <select name="staff_login_timeout">
                       <?php for($i=1;$i<11;$i++){
                        if($staff_login_timeout->value == $i){
                            echo "<option value='$i' selected>$i</option>";
                        }else{
                            echo "<option value='$i'>$i</option>";
                        }

                       }?></select> minutes locked out                </div>
            </div>
            <div class="form-group" style="overflow:auto;">
                <label class="col-lg-3 control-label"><i class="help-tip icon-question-sign" href="#staff_session_timeout"></i> Agent Session Timeout :</label>
                <div class="col-lg-9 test">
                    <input type="text" name="staff_session_timeout" size="3" value="<?php echo $staff_sess_timeout->value?>">
                        minutes <em>(0 to disable)</em>.
                </div>
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
                                        <tr>
                        <td colspan="2">
                            <div style="padding:2px 5px">
                                <a onclick="add_awe()">
                                    <i class="icon-file-text icon-2x" style="color:#bbb;"></i>
                                </a>
                                <span style="display:inline-block;width:90%;width:calc(100% - 32px);padding-left:10px;line-height:1.2em">
                                <a onclick="add_awe()">Agent Welcome Email                                    </a>
                                </span>
                                <span class="faded">This template defines the initial email (optional) sent to Agents when an account is created on their behalf.                                    <br>
                                    <em>Last Updated </em>
                                </span>
                            </div>
                        </td>
                    </tr>
                                                                <tr>
                        <td colspan="2">
                            <div style="padding:2px 5px">
                                <a onclick="add_slb()">
                                    <i class="icon-file-text icon-2x" style="color:#bbb;"></i>
                                </a>
                                <span style="display:inline-block;width:90%;width:calc(100% - 32px);padding-left:10px;line-height:1.2em">
                                <a onclick="add_slb()">Sign-in Login Banner</a>
                                </span>
                                <span class="faded">This is the initial message and banner shown on the Staff Log In page                                    <br>
                                    <em>Last Updated </em>
                                </span>
                            </div>
                        </td>
                    </tr>
                                                                <tr>
                        <td colspan="2">
                            <div style="padding:2px 5px">
                                <a onclick="add_opr()">
                                    <i class="icon-file-text icon-2x" style="color:#bbb;"></i>
                                </a>
                                <span style="display:inline-block;width:90%;width:calc(100% - 32px);padding-left:10px;line-height:1.2em">
                                <a onclick="add_opr()">Password Reset Email</a>
                                </span>
                                <span class="faded">This template defines the email sent to Staff who select the <strong>Forgot My Password</strong> link on the Staff Control Panel Log In page.                                    <br>
                                    <em>Last Updated </em>
                                </span>
                            </div>
                        </td>
                    </tr>
                                        </tbody>
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

<script type="text/javascript">
    
        function add_awe()
        {
          save_method = 'add';
          $('#awe').modal('show'); // show bootstrap modal
          $('.modal-title').text('Manage Content -- <?php echo $awe->name;?>'); // Set Title to Bootstrap modal title
        }

        function add_slb()
        {
          save_method = 'add';
          $('#slb').modal('show'); // show bootstrap modal
          $('.modal-title').text('Manage Content -- <?php echo $slb->name;?>'); // Set Title to Bootstrap modal title
        }

          function add_opr()
        {
          save_method = 'add';
          $('#opr').modal('show'); // show bootstrap modal
          $('.modal-title').text('Manage Content -- <?php echo $opr->name;?>'); // Set Title to Bootstrap modal title
        }
</script>

<div class="modal fade" id="awe" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>

                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <!-- <div class="col-md-12"> -->
                     <form action="<?php echo site_url('admin_settings_controller/templates_update');?>" method="POST" id="form" class="form-horizontal">
                        <input type="hidden" name="id" value="<?php echo $awe->id?>">
                    <input name="topic" class="form-control" type="text" style="width:100%;font-size: 20px"  value="<?php echo $awe->name;?>">
                    <div><span class="help-block"></span></div>
                              <!-- tools box -->
                              <div class="box-tools">
                              </div>
                              <!-- /. tools -->
                            <div class="pad">
                                <textarea name="body" id="task-note" class="textarea" placeholder="Start writing your note here"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $awe->body?></textarea>
                    <span class="help-block"></span>
                    </div>
                     <div class="info-banner" style="line-height: 20px">
                            <?php echo $awe->notes?>
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

<div class="modal fade" id="slb" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>

                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body">
                <!-- <div class="col-md-12"> -->
                    <form action="<?php echo site_url('admin_settings_controller/templates_update');?>" method="POST" id="form" class="form-horizontal">
                        <input type="hidden" name="id" value="<?php echo $slb->id?>">
                        <input name="topic" class="form-control" type="text" style="width:100%;font-size: 20px"  value="<?php echo $slb->name;?>">
                        <span class="help-block"></span>   
                        <!-- tools box -->
                        <div class="box-tools"></div>
                        <!-- /. tools -->
                        <div class="pad">
                            <textarea name="body" id="task-note" class="textarea" placeholder="Start writing your note here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $slb->body?></textarea>
                            <span class="help-block"></span>
                        </div>
                        <div class="info-banner" style="line-height: 20px">
                            <?php echo $slb->notes?>
                        </div>
                <!-- </div> -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-default">Save</button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" >Cancel</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="opr" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>

                <h3 class="modal-title">User Form</h3>
            </div>
            <div class="modal-body form">
                <!-- <div class="col-md-12"> -->
                     <form action="<?php echo site_url('admin_settings_controller/templates_update');?>" method="POST" id="form" class="form-horizontal">
                        <input type="hidden" name="id" value="<?php echo $opr->id?>">
                    <input name="topic" class="form-control" type="text" style="width:100%;font-size: 20px"  value="<?php echo $opr->name;?>">
                    <span class="help-block"></span>   
                    <!-- tools box -->
                              <div class="box-tools">
                              </div>
                              <!-- /. tools -->
                            <div class="pad">
                                <textarea name="body" id="task-note" class="textarea" placeholder="Start writing your note here"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $opr->body?></textarea>
                    <span class="help-block"></span>
                    </div>
                     <div class="info-banner" style="line-height: 20px">
                            <?php echo $opr->notes?>
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