<div id="content">
        
<form action="<?php echo site_url('admin_agents_controller/agents_agents_info_process')?>?id=<?php echo $_REQUEST['id']?>" method="post" class="save" autocomplete="off">

  <h2>Manage Agent      <small>— <?php echo $staffinfo->firstname ?> <?php echo $staffinfo->lastname ?></small></h2>

  <div class="tab">
    <ul class="clean tabs">
      <li class="active"><a href="#account"><i class="icon-user"></i> Account</a></li>
      <li><a href="#access">Access</a></li>
      <li><a href="#permissions">Permissions</a></li>
      <li><a href="#teams">Teams</a></li>
    </ul>
  </div>

  <div class="tab_content" id="account">
    <div class="avatar" style="width: 100px; margin: 10px;">
        <img class="avatar" alt="Avatar" src="//www.gravatar.com/avatar/d41d8cd98f00b204e9800998ecf8427e?s=80&amp;d=identicon">    </div>
    <div class="form-group" style="overflow:auto;">
      <label class="col-lg-2 control-label">Name<span class="error"> * </span> :</label>
      <div class="col-lg-10">
        <input type="text" size="20" maxlength="64" style="width: 145px" name="firstname" class="auto first" autofocus="" value="<?php echo $staffinfo->firstname ?>" placeholder="First Name">
        <input type="text" size="20" maxlength="64" style="width: 145px" name="lastname" class="auto last" value="<?php echo $staffinfo->lastname ?>" placeholder="Last Name">
        <div class="error"></div>
        <div class="error"></div>
      </div>
    </div>
    <div class="form-group" style="overflow:auto;">
      <label class="col-lg-2 control-label">Email Address<span class="error"> * </span> :</label>
      <div class="col-lg-10">
        <input type="email" size="40" maxlength="64" name="email" class="auto email form-control" value="<?php echo $staffinfo->email ?>" placeholder="e.g. me@mycompany.com">
        <div class="error"></div>
      </div>
    </div>
    <div class="form-group" style="overflow:auto;">
      <label class="col-lg-2 control-label">Phone Number :</label>
      <div class="col-lg-10">
        <input type="tel" size="18" name="phone" class="auto phone" value="<?php echo $staffinfo->phone ?>">
        Ext        <input type="text" size="5" name="phone_ext" value="<?php echo $staffinfo->phone_ext ?>">
        <div class="error"></div>
        <div class="error"></div>
      </div>
    </div>
    <div class="form-group" style="overflow:auto;">
      <label class="col-lg-2 control-label">Mobile Number :</label>
      <div class="col-lg-10">
        <input type="tel" size="18" name="mobile" class="auto phone form-control" value="<?php echo $staffinfo->mobile ?>">
          <div class="error"></div>
      </div>
    </div>
    <div style="font-weight:400;font-size:1.3em;text-align:left;min-height:24px;padding:8px;line-height:1.4;vertical-align:top;border-top:1px solid #ddd;">
      Authentication    </div>
    <div class="form-group" style="overflow:auto;">
      <label class="col-lg-2 control-label"><i class="offset help-tip icon-question-sign" href="#username"></i> Username <span class="error">* </span> :</label>
      <div class="col-lg-10">
        <input type="text" size="40" class="staff-username typeahead form-control" name="username" value="<?php echo $staffinfo->username ?>">
                      
      </div>
    </div>


<div class="form-group" style="overflow:auto;">
      <label class="col-lg-2 control-label" style="padding-top:9px"><i class="offset help-tip icon-question-sign" href="#username"></i> Password <span class="error">* </span> :</label>
      <div class="col-lg-10">

  <div class="quick-add">
          <table class="grid form">
          <caption>                  <div><small></small></div>
          </caption>
          <tbody><tr><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td></tr></tbody>
    <tbody>
      <tr>
          <td class="cell" colspan="12" rowspan="1" style="" data-field-id="1">
              <fieldset class="field " id="field_67c3468a5b7b8e08" data-field-id="1">
              <label class="checkbox">
                  <input id="_changepass" type="checkbox" name="_field-checkboxes" value="1">
                  Send the agent a password reset email    
                  <small>(Leave blank if you dont want to reset password)</small>  
              </label>
              </fieldset>
          </td>
      </tr>
      <tr>
          <td class="cell" colspan="12" rowspan="1" style="" data-field-id="2">
              <fieldset class="field " id="field_b83f52c50b053a90" data-field-id="2">
                  <input type="password" class="form-control" id="_b83f52c50b053a90" size="16" maxlength="30" placeholder="New Password" name="password1" value="">
              </fieldset>
          </td>
      </tr>
      <tr>
          <td class="cell" colspan="12" rowspan="1" style="" data-field-id="3">
              <fieldset class="field " id="field_4710deaa31acbbd2" data-field-id="3">
                  <input type="password" class="form-control" id="_4710deaa31acbbd2" size="16" maxlength="30" placeholder="Confirm Password" name="password2" value="">
              </fieldset>
          </td>
      </tr>
      <tr>
          <td class="cell" colspan="12" rowspan="1" style="" data-field-id="4">
              <fieldset class="field">
              <label class="checkbox">
                  <input id="_25aab4ced655a467" type="checkbox" name="change_passwd" value="4">
                  Require password change at next login
              </label>
              </fieldset>
          </td>
      </tr>
    </tbody>
  </table>
</div> 
  

  <div class="clear"></div>

                      
      </div>
    </div>

        <div style="font-weight:400;font-size:1.3em;text-align:left;min-height:24px;padding:8px;line-height:1.4;vertical-align:top;border-top:1px solid #ddd;">
      Status and Settings    </div>
    <div class="form-group" style="padding:15px 25px;overflow:auto;">
      <div class="error"></div>
      <div class="error"></div>
      <label class="checkbox">
      <input type="checkbox" name="islocked" value="1" <?php echo ($staffinfo->isactive == 0)?"checked":""; ?>>
        Locked      </label>
      <label class="checkbox">
      <input type="checkbox" name="isadmin" value="1" <?php echo ($staffinfo->isadmin == 1)?"checked":""; ?>>
        Administrator      </label>
      <label class="checkbox">
      <input type="checkbox" name="assigned_only"  value="1" <?php echo ($staffinfo->assigned_only == 1)?"checked":""; ?>>
        Limit ticket access to ONLY assigned tickets      </label>
      <label class="checkbox">
      <input type="checkbox" name="onvacation"  value="1" <?php echo ($staffinfo->onvacation == 1)?"checked":""; ?>>
        Vacation Mode      </label>
      <br>
    </div>

    <div style="padding:8px 3px; margin-top: 1.6em">
        <strong class="big">Internal Notes: </strong>
        Be liberal, they're internal    </div>

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
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $staffinfo->notes ?></textarea>
                
              
            </div>
          </div>
  </div>

  <!-- ============== DEPARTMENT ACCESS =================== -->

  <div class="hiddens tab_content" id="access">
    <div class="col-lg-12" style="font-size:1.3em;">
      Access            <div><small>Select the departments the agent is allowed to access and the corresponding effective role.            </small></div><br>
    </div>
    <div style="font-size:1.3em;">
      <span class="error">*</span> Primary Department    </div>
    <div style="overflow:auto;">
    <table class="table two-column" width="940" border="0" cellspacing="0" cellpadding="2">
      <tbody>
        <tr>
          <td style="vertical-align:top">
            <select name="dept_guid" id="department">
              <option value="" selected="">— Select Department—</option>
              <?php foreach ($department as $depart) { ?>   
                  <option value="<?php echo $depart['depart_id']?>" <?php echo ($depart['depart_id'] == $staffinfo->dept_guid )?"selected":""; ?>><?php echo $depart['depart_name']?></option>
              <?php }?>
              <option value="0">— Add New —</option>
            </select>
            <i class="offset help-tip icon-question-sign" href="#primary_department"></i>
            <div class="error"></div>
          </td>
          <td style="vertical-align:top">
            <select name="role_guid" data-quick-add="role">
              <option value="0">— Select Role —</option>
              <?php foreach ($role->result() as $role1) { ?>   
                <option value="<?php echo $role1->role_guid?>" <?php echo ($role1->role_guid == $staffinfo->role_guid )?"selected":""; ?>><?php echo $role1->name?></option>
              <?php } ?>
            </select>
            <i class="offset help-tip icon-question-sign" href="#primary_role"></i>
          </td>
          <!--<td>
            <label class="inline">
            <input type="checkbox" name="assign_use_pri_role" checked="checked">
                Fall back to primary role on assignments                <i class="icon-question-sign help-tip" href="#primary_role_on_assign"></i>
            </label>

            <div class="error"></div>
          </td>-->
        </tr>
      </tbody>
      <tbody>
        <tr id="extended_access_template" class="hidden">
          <td>
          <input type="hidden" data-name="ext_dept_guid[]" value="">
        </td>

          <td>
            <select data-name="ext_role_guid" data-quick-add="role" name="ext_role_guid[]">
              <option value="0">— Select Role —</option>
              <?php foreach ($role->result() as $role2) { ?>   
                        <option value="<?php echo $role2->id?>"><?php echo $role2->name?></option>
                    <?php } ?>
            </select>
          </td>
          <td>
           <!-- <label class="inline">
              <input type="checkbox" data-name="dept_access_alerts" value="1">
              Alerts            </label> -->
            <a href="#" class="pull-right drop-access" title="Delete"><i class="icon-trash"></i></a>
          </td>
        </tr>
      </tbody>

      <tbody>
        <tr class="header">
          <th colspan="3">
            Extended Access
          </th>
        </tr>

        <tr id="add_extended_access">
          <td colspan="2">
            <i class="icon-plus-sign"></i>
            <select id="add_access" data-quick-add="department">
              <option value="">— Select Department —</option>
              <?php foreach ($department as $depart) { ?>
              <?php if ($depart['depart_id'] != $staffextdept->row('id')) { ?>
              <option value="<?php echo $depart['depart_id']?>"><?php echo $depart['depart_name']?></option>
              <?php }?>
              <?php }?>
              <option value="0">— Add New —</option>
            </select>
            <button type="button" class="green button">
              Add            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  </div>

  <!-- ================= PERMISSIONS ====================== -->

<div id="permissions" class="hiddens">
<div style="overflow:auto;">
  <div class="tab_1">
    <ul class="alt tabs_1" style="height:auto;">
      <li class="active">
        <a href="#users">Users</a>
      </li>
      <li>
        <a href="#organizations">Organizations</a>
      </li>
      <li>
        <a href="#knowledgebase">Knowledgebase</a>
      </li>
      <li>
        <a href="#miscellaneous">Miscellaneous</a>
      </li>
    </ul>
  </div>
    <div class="tab_content_1 " id="users">
            <label class="col-lg-12">
            <input type="checkbox" name="perms[]" value="user.add" <?php echo ($adduserallow != 0)?"checked":""; ?>>            &nbsp;
            Create            —
            <em>Ability to add new users</em>
           </label>
            <label class="col-lg-12">
            <input type="checkbox" name="perms[]" value="user.edit" <?php echo ($edituserallow != 0)?"checked":""; ?>>            &nbsp;
            Edit            —
            <em>Ability to manage user information</em>
           </label>
            <label class="col-lg-12">
            <input type="checkbox" name="perms[]" value="user.delete" <?php echo ($deleteuserallow != 0)?"checked":""; ?>>            &nbsp;
            Delete            —
            <em>Ability to delete users</em>
           </label>
            <label class="col-lg-12">
            <input type="checkbox" name="perms[]" value="user.manage" <?php echo ($activeallow != 0)?"checked":""; ?>>            &nbsp;
            Manage Account            —
            <em>Ability to manage user status </em>
           </label>
            <label class="col-lg-12">
            <input type="checkbox" name="perms[]" value="user.dir" <?php echo ($dirallow != 0)?"checked":""; ?>>            &nbsp;
            User Directory            —
            <em>Ability to access the user directory</em>
           </label>
    </div>
    <div class="tab_content_1 hiddens" id="organizations">
            <label class="col-lg-12">
            <input type="checkbox" name="perms[]" value="org.create" <?php echo ($addorgallow != 0)?"checked":""; ?>>            &nbsp;
            Create            —
            <em>Ability to create new organizations</em>
           </label>
            <label class="col-lg-12">
            <input type="checkbox" name="perms[]" value="org.edit" <?php echo ($editorgallow != 0)?"checked":""; ?>>            &nbsp;
            Edit            —
            <em>Ability to manage organizations</em>
           </label>
            <label class="col-lg-12">
            <input type="checkbox" name="perms[]" value="org.delete" <?php echo ($deleteorgallow != 0)?"checked":""; ?>>            &nbsp;
            Delete            —
            <em>Ability to delete organizations</em>
           </label>
    </div>
    <div class="tab_content_1 hiddens" id="knowledgebase">
            <label class="col-lg-12">
            <input type="checkbox" name="perms[]" value="faq.manage" <?php echo ($managefaqallow != 0)?"checked":""; ?>>            &nbsp;
            FAQ            —
            <em>Ability to add/update/disable/delete knowledgebase categories and FAQs</em>
           </label>
    </div>
    <div class="tab_content_1 hiddens" id="miscellaneous">
            <!-- <label class="col-lg-12">
            <input type="checkbox" name="perms[]" value="emails.banlist">            &nbsp;
            Banlist            —
            <em>Ability to add/remove emails from banlist via ticket interface</em>
           </label>
            <label class="col-lg-12">
            <input type="checkbox" name="perms[]" value="search.all">            &nbsp;
            Search            —
            <em>See all tickets in search results, regardless of access</em>
           </label>
            <label class="col-lg-12">
            <input type="checkbox" name="perms[]" value="stats.agents">            &nbsp;
            Stats            —
            <em>Ability to view stats of other agents in allowed departments</em>
           </label> -->
    </div>
  </div>
</div>

  <!-- ============== TEAM MEMBERSHIP =================== -->

  <div class="hiddens tab_content" id="teams">
    <table class="table two-column" width="100%">
      <tbody>
        <tr class="header">
          <th colspan="2">
            Assigned Teams            <div><small>Agent will have access to tickets assigned to a team they belong to regardless of the ticket's department. Alerts can be enabled for each associated team.            </small></div>
          </th>
        </tr>
        <tr id="join_team">
          <td colspan="2">
            <i class="icon-plus-sign"></i>
            <select id="add_team" data-quick-add="team">
              <option value="0">— Select Team —</option>
              <?php foreach ($team1->result() as $team) { ?> 
              <option value="<?php echo $team->team_guid ?>"><?php echo $team->name ?></option>              
              <?php } ?> 
            </select>
            <button type="button" class="green button">
              Add            </button>
          </td>
        </tr>
      </tbody>
      <tbody>
        <tr id="team_member_template" class="hidden">
          <td>
            <input type="hidden" data-name="teams[]" value="">
          </td>
          <td>
           <!-- <label>
              <input type="checkbox" data-name="team_alerts" value="1">
              Alerts            </label>-->
            <a href="#" class="pull-right drop-membership" title="Delete"><i class="icon-trash"></i></a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <p style="text-align:center;">
      <input type="submit" name="submit" value="Edit">
      <input type="reset" name="reset" value="Reset">
      <input type="button" name="cancel" value="Cancel" onclick="window.history.go(-1);">
  </p>
</form>

<!-- add new department popup modal -->
<div class="modal fade" id="new_department"">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

                <h3 class="drag-handle">Add New Department</h3>
            </div>

            <form action="<?php echo site_url('admin_settings_controller/add_new_department');?>?id=<?php echo $_REQUEST['id'];?>&direct=admin_agents_agents_info" method="POST">
            <div class="modal-body">
                <table class="grid form">
                    <tbody>
                        <tr>
                            <td class="cell" colspan="12" rowspan="1">
                                <fieldset class="field">
                                    <select class="form-control" name="main_department">
                                        <option value="0">— Top-Level Department —</option>
                                        <?php foreach ($department as $value) { ?>
                                        <option value="<?php echo $value['depart_id'];?>"><?php echo $value['depart_name'];?></option>
                                        <?php } ?>
                                    </select>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td class="cell" colspan="12" rowspan="1">
                                <fieldset class="field">
                                    <input type="text" class="form-control" size="16" maxlength="128" placeholder="Name" name="department_name" required>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td class="cell" colspan="12" rowspan="1">
                                <fieldset class="field">
                                    <br><label>Email Mailbox:</label>

                                    <select class="form-control" name="department_email">
                                        <option value="0">— System Default —</option>
                                        <?php foreach ($department_email->result() as $email) {?>
                                        <option value="<?php echo $email->email_guid;?>"><?php echo $email->email;?></option>
                                        <?php }?>
                                    </select>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td class="cell" colspan="12" rowspan="1">
                                <fieldset class="field">
                                    <br><label class="checkbox" style="padding-left:43px">
                                        <input type="hidden" name="department_internal" value="1">
                                        <input type="checkbox" name="department_internal" value="0">
                                        This department is for internal use
                                    </label>
                                </fieldset>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <p class="full-width">
                    <span class="buttons pull-left">
                        <input type="button" data-dismiss="modal" value ="Cancel">
                        <input type="reset" value="Reset">
                    </span>
                    <span class="buttons pull-right">
                        <input type="submit" value="Create">
                    </span>
                </p>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- add new department popup modal -->

<script type="text/javascript">
var addAccess = function(daid, name, role, alerts, error) {
  if (!daid) return;
  var copy = $('#extended_access_template').clone();

  copy.find('[data-name=ext_dept_guid\\[\\]]')
    .attr('name', 'ext_dept_guid[]')
    .val(daid);
  copy.find('[data-name^=ext_role_guid]')
    .attr('name', 'ext_role_guid['+daid+']')
    .val(role || 0);
  copy.find('[data-name^=ext_dept_guid_alerts]')
    .attr('name', 'ext_dept_guid_alerts['+daid+']')
    .prop('checked', alerts);
  copy.find('td:first').append(document.createTextNode(name));
  copy.attr('id', '').show().insertBefore($('#add_extended_access'));
  copy.removeClass('hidden')
  if (error)
      $('<div class="error">').text(error).appendTo(copy.find('td:last'));
  copy.find('a.drop-access').click(function() {
    $('#add_access').append(
      $('<option>')
        .attr('value', copy.find('input[name^=ext_dept_guid][type=hidden]').val())
        .text(copy.find('td:first').text())
    );
    copy.fadeOut(function() { $(this).remove(); });
    return false;
  });
};

$('#add_extended_access').find('button').on('click', function() {
  var selected = $('#add_access').find(':selected'),
      id = parseInt(selected.val());
  if (!id)
      return;
  addAccess(id, selected.text(), 0, true);
  selected.remove();
  return false;
});

var joinTeam = function(teamid, name, alerts, error) {
  if (!teamid) return;
  var copy = $('#team_member_template').clone();

  copy.find('[data-name=teams\\[\\]]')
    .attr('name', 'teams[]')
    .val(teamid);
  copy.find('[data-name^=team_alerts]')
    .attr('name', 'team_alerts['+teamid+']')
    .prop('checked', alerts);
  copy.find('td:first').append(document.createTextNode(name));
  copy.attr('id', '').show().insertBefore($('#join_team'));
  copy.removeClass('hidden');
  if (error)
      $('<div class="error">').text(error).appendTo(copy.find('td:last'));
  copy.find('a.drop-membership').click(function() {
    $('#add_team').append(
      $('<option>')
        .attr('value', copy.find('input[name^=teams][type=hidden]').val())
        .text(copy.find('td:first').text())
    );
    copy.fadeOut(function() { $(this).remove(); });
    return false;
  });
};

$('#join_team').find('button').on('click', function() {
  var selected = $('#add_team').find(':selected'),
      id = parseInt(selected.val());
  if (!id)
      return;
  joinTeam(id, selected.text(), true);
  selected.remove();
  return false;
});

$('#department').change(function() {
    var depart_id = $(this).val();
    if(depart_id == '0')
    {
        $('#new_department').modal("show");
    }
});

$('#add_access').change(function() {
    var depart_id = $(this).val();
    if(depart_id == '0')
    {
        $('#new_department').modal("show");
    }
});

</script>

<script type="text/javascript">
      !(function() {
        var recheck = function() {
          var target = $('#field_4710deaa31acbbd2');

var _changepass = $("#_changepass");          if ((_changepass.is(":visible") && _changepass.is(":checked") == false))
            target.slideDown('fast', function (){
                $(this).trigger('show');
                });
          else
            target.slideUp('fast', function (){
                $(this).trigger('hide');
                });
        };

        $('#_changepass').on('change', recheck);
        $('#field_67c3468a5b7b8e08').on('show hide', recheck);
      })();
    </script>

    <script type="text/javascript">
      !(function() {
        var recheck = function() {
          var target = $('#field_25aab4ced655a467');

var _changepass = $("#_changepass");          if ((_changepass.is(":visible") && _changepass.is(":checked") == false))
            target.slideDown('fast', function (){
                $(this).trigger('show');
                });
          else
            target.slideUp('fast', function (){
                $(this).trigger('hide');
                });
        };

        $('#_changepass').on('change', recheck);
        $('#field_67c3468a5b7b8e08').on('show hide', recheck);
      })();
    </script> 
    <script type="text/javascript">
      !(function() {
        var recheck = function() {
          var target = $('#field_b83f52c50b053a90');

var _changepass = $("#_changepass");          if ((_changepass.is(":visible") && _changepass.is(":checked") == false))
            target.slideDown('fast', function (){
                $(this).trigger('show');
                });
          else
            target.slideUp('fast', function (){
                $(this).trigger('hide');
                });
        };

        $('#_changepass').on('change', recheck);
        $('#field_67c3468a5b7b8e08').on('show hide', recheck);
      })();
    </script>

<script type="text/javascript">
var addAccess = function(daid, name, role, alerts, error) {
  if (!daid) return;
  var copy = $('#extended_access_template').clone();

  copy.find('[data-name=ext_dept_guid\\[\\]]')
    .attr('name', 'ext_dept_guid[]')
    .val(daid);
  copy.find('[data-name^=ext_role_guid]')
    .attr('name', 'ext_role_guid['+daid+']')
    .val(role || 0);
  copy.find('[data-name^=ext_dept_guid_alerts]')
    .attr('name', 'ext_dept_guid_alerts['+daid+']')
    .prop('checked', alerts);
  copy.find('td:first').append(document.createTextNode(name));
  copy.attr('id', '').show().insertBefore($('#add_extended_access'));
  copy.removeClass('hidden')
  if (error)
      $('<div class="error">').text(error).appendTo(copy.find('td:last'));
  copy.find('a.drop-access').click(function() {
    $('#add_access').append(
      $('<option>')
        .attr('value', copy.find('input[name^=ext_dept_guid][type=hidden]').val())
        .text(copy.find('td:first').text())
    );
    copy.fadeOut(function() { $(this).remove(); });
    return false;
  });
};

$('#add_extended_access').find('button').on('click', function() {
  var selected = $('#add_access').find(':selected'),
      id = parseInt(selected.val());
  if (!id)
      return;
  addAccess(id, selected.text(), 0, true);
  selected.remove();
  return false;
});

var joinTeam = function(teamid, name, alerts, error) {
  if (!teamid) return;
  var copy = $('#team_member_template').clone();

  copy.find('[data-name=teams\\[\\]]')
    .attr('name', 'teams[]')
    .val(teamid);
  copy.find('[data-name^=team_alerts]')
    .attr('name', 'team_alerts['+teamid+']')
    .prop('checked', alerts);
  copy.find('td:first').append(document.createTextNode(name));
  copy.attr('id', '').show().insertBefore($('#join_team'));
  copy.removeClass('hidden');
  if (error)
      $('<div class="error">').text(error).appendTo(copy.find('td:last'));
  copy.find('a.drop-membership').click(function() {
    $('#add_team').append(
      $('<option>')
        .attr('value', copy.find('input[name^=teams][type=hidden]').val())
        .text(copy.find('td:first').text())
    );
    copy.fadeOut(function() { $(this).remove(); });
    return false;
  });
};

$('#join_team').find('button').on('click', function() {
  var selected = $('#add_team').find(':selected'),
      id = parseInt(selected.val());
  if (!id)
      return;
  joinTeam(id, selected.text(), true);
  selected.remove();
  return false;
});

<?php foreach ($staffextdept->result() as $value) { ?>
  addAccess(<?php echo $value->dept_guid?>, "<?php echo $value->name?>", <?php echo $value->role_guid?>, <?php echo $value->flags?>, null);
<?php } ?>

<?php foreach ($staffteam->result() as $value) { ?>
joinTeam(<?php echo $value->team_guid?>, "<?php echo $value->name?>", <?php echo $value->flags?>, null);
<?php } ?>





</script>

<script type="text/javascript">
      !(function() {
        var recheck = function() {
          var target = $('#field_4710deaa31acbbd2');

var _changepass = $("#_changepass");          if ((_changepass.is(":visible") && _changepass.is(":checked") == false))
            target.slideDown('fast', function (){
                $(this).trigger('show');
                });
          else
            target.slideUp('fast', function (){
                $(this).trigger('hide');
                });
        };

        $('#_changepass').on('change', recheck);
        $('#field_67c3468a5b7b8e08').on('show hide', recheck);
      })();
    </script>

    <script type="text/javascript">
      !(function() {
        var recheck = function() {
          var target = $('#field_25aab4ced655a467');

var _changepass = $("#_changepass");          if ((_changepass.is(":visible") && _changepass.is(":checked") == false))
            target.slideDown('fast', function (){
                $(this).trigger('show');
                });
          else
            target.slideUp('fast', function (){
                $(this).trigger('hide');
                });
        };

        $('#_changepass').on('change', recheck);
        $('#field_67c3468a5b7b8e08').on('show hide', recheck);
      })();
    </script> 
    <script type="text/javascript">
      !(function() {
        var recheck = function() {
          var target = $('#field_b83f52c50b053a90');

var _changepass = $("#_changepass");          if ((_changepass.is(":visible") && _changepass.is(":checked") == false))
            target.slideDown('fast', function (){
                $(this).trigger('show');
                });
          else
            target.slideUp('fast', function (){
                $(this).trigger('hide');
                });
        };

        $('#_changepass').on('change', recheck);
        $('#field_67c3468a5b7b8e08').on('show hide', recheck);
      })();
    </script>

</div>

</div>