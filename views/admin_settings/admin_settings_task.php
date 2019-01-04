<div id="content">
    <h2>Task Settings and Options</h2>
<form class="form-horizontal" action="settings.php?t=tasks" method="post">
<input type="hidden" name="__CSRFToken__" value="90f6d24e10ae504160eb2be50461de3ff8cd5892"><input type="hidden" name="t" value="tasks">

<div class="tab">
    <ul class="tabs" id="tasks-tabs">
        <li class="active"><a href="#settings">
            <i class="icon-asterisk"></i> Settings</a></li>
        <li><a href="#alerts">
            <i class="icon-bell-alt"></i> Alerts &amp; Notices</a></li>
    </ul>
</div>
<div id="tasks-tabs_container">
   <div id="settings" class="tab_content">
        <div class="section-break" style="margin-bottom:10px;">
            <em>Global default task settings and options.</em>
        </div>
        <div class="form-group" style="overflow:auto;">
            <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#number_format"></i> Default Task Number Format :</label>
            <div class="col-lg-6">
                <input type="text" name="task_number_format" class="form-control" value="#">
                <div class="error"></div>
            </div>
            <div class="col-lg-2">
                <span class="faded">e.g. <span id="format-example">7</span></span>
            </div>
        </div>
        <!-- <div class="form-group" style="overflow:auto;">
            <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#sequence_id"></i> Default Task Number Sequence :</label>
            <div class="col-lg-6">
                <select name="task_sequence_id" class="form-control">
                    <option value="0">— Random —</option>
                        <option value="1" selected="">General Tickets</option>
                        <option value="2">Tasks Sequence</option>
                        </select>
            </div>
            <div class="col-lg-2">
                <button class="action-button pull-right" onclick="javascript:
                $.dialog('ajax.php/sequence/manage', 205);
                return false;
                "><i class="icon-gear"></i> Manage</button>
            </div>
        </div> -->
        <!-- <div class="form-group" style="overflow:auto;">
            <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#default_priority"></i> Default Priority <span class="error">*</span> :</label>
            <div class="col-lg-8">
                <select name="default_task_priority_id" class="form-control">
                    <option value="1" selected="">Low</option>
                    <option value="2">Normal</option>
                    <option value="3">High</option>
                    <option value="4">Emergency</option>
                </select>
                &nbsp;<span class="error"></span>
            </div>
        </div> -->
        <!-- <div class="section-break" style="margin-bottom:10px;">
            <em><b>Attachments</b> :</em>
        </div>
        <div class="form-group" style="overflow:auto;">
            <label class="col-lg-4 control-label"><i class="help-tip icon-question-sign" href="#task_attachment_settings"></i> Task Attachment Settings :</label>
            <div class="col-lg-8">
                <a class="action-button field-config" style="overflow:inherit" href="#ajax.php/form/field-config/33" onclick="javascript:
                    $.dialog($(this).attr('href').substr(1), [201]);
                    return false;
                "><i class="icon-edit"></i> Config</a>
            </div>
        </div> -->
   </div>
   <div id="alerts" class="tab_content" style="display:none;">
    <table class="form_table settings_table" width="100%" border="0" cellspacing="0" cellpadding="2">
        <tbody>
            <tr><th><em><b><i class="help-tip icon-question-sign" href="#task_alert"></i> New Task Alert</b> :
                </em></th></tr>
            <tr>
                <td><em><b>Status:</b></em> &nbsp;
                    <input type="radio" name="task_alert_active" value="1"> Enable                    <input type="radio" name="task_alert_active" value="0" checked="checked">
                    Disable                    &nbsp;&nbsp;<font class="error">&nbsp;</font>
                 </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" name="task_alert_admin">
                    Admin Email <em>(kelwin@pandasoftware.my)</em>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" name="task_alert_dept_manager">
                    Department Manager                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" name="task_alert_dept_members">
                    Department Members                </td>
            </tr>
            <tr><th><em><i class="help-tip icon-question-sign" href="#activity_alert"></i> <b>New Activity Alert</b> :
                </em></th></tr>
            <tr>
                <td><em><b>Status:</b></em> &nbsp;
                  <input type="radio" name="task_activity_alert_active" value="1">
                    Enable                  &nbsp;&nbsp;
                  <input type="radio" name="task_activity_alert_active" value="0" checked="checked">
                    Disable                  &nbsp;&nbsp;&nbsp;<font class="error">&nbsp;</font>
                </td>
            </tr>
            <tr>
                <td>
                  <input type="checkbox" name="task_activity_alert_laststaff">
                  Last Respondent                </td>
            </tr>
            <tr>
                <td>
                  <input type="checkbox" name="task_activity_alert_assigned">
                  Assigned Agent / Team                </td>
            </tr>
            <tr>
                <td>
                  <input type="checkbox" name="task_activity_alert_dept_manager">
                    Department Manager                </td>
            </tr>
            <tr><th><em><i class="help-tip icon-question-sign" href="#assignment_alert"></i> <b>Task Assignment Alert</b> :
                </em></th></tr>
            <tr>
                <td><em><b>Status: </b></em> &nbsp;
                  <input name="task_assignment_alert_active" value="1" type="radio">
                    Enable                    &nbsp;&nbsp;
                  <input name="task_assignment_alert_active" value="0" type="radio" checked="checked">
                    Disable                   &nbsp;&nbsp;&nbsp;<font class="error">&nbsp;</font>
                </td>
            </tr>
            <tr>
                <td>
                  <input type="checkbox" name="task_assignment_alert_staff">
                  Assigned Agent / Team                </td>
            </tr>
            <tr>
                <td>
                  <input type="checkbox" name="task_assignment_alert_team_lead">
                  Team Lead                </td>
            </tr>
            <tr>
                <td>
                  <input type="checkbox" name="task_assignment_alert_team_members">
                    Team Members                </td>
            </tr>
            <tr><th><em><i class="help-tip icon-question-sign" href="#transfer_alert"></i> <b>Task Transfer Alert</b> :
                </em></th></tr>
            <tr>
                <td><em><b>Status:</b></em> &nbsp;
                <input type="radio" name="task_transfer_alert_active" value="1">
                    Enable                <input type="radio" name="task_transfer_alert_active" value="0" checked="checked">
                    Disable                  &nbsp;&nbsp;&nbsp;<font class="error">&nbsp;</font>
                </td>
            </tr>
            <tr>
                <td>
                  <input type="checkbox" name="task_transfer_alert_assigned">
                    Assigned Agent / Team                </td>
            </tr>
            <tr>
                <td>
                  <input type="checkbox" name="task_transfer_alert_dept_manager">
                    Department Manager                </td>
            </tr>
            <tr>
                <td>
                  <input type="checkbox" name="task_transfer_alert_dept_members">
                    Department Members                </td>
            </tr>
            <tr><th><em><i class="help-tip icon-question-sign" href="#overdue_alert"></i> <b>Overdue Task Alert</b> :
                </em></th></tr>
            <tr>
                <td><em><b>Status:</b></em> &nbsp;
                  <input type="radio" name="task_overdue_alert_active" value="1"> Enable                  <input type="radio" name="task_overdue_alert_active" value="0" checked="checked"> Disable                  &nbsp;&nbsp;<font class="error">&nbsp;</font>
                </td>
            </tr>
            <tr>
                <td>
                  <input type="checkbox" name="task_overdue_alert_assigned">
                    Assigned Agent / Team                </td>
            </tr>
            <tr>
                <td>
                  <input type="checkbox" name="task_overdue_alert_dept_manager">
                    Department Manager                </td>
            </tr>
            <tr>
                <td>
                  <input type="checkbox" name="task_overdue_alert_dept_members">
                    Department Members                </td>
            </tr>
        </tbody>
    </table>
   </div>
</div>
<p style="text-align:center;">
    <input class="button" type="submit" name="submit" value="Save Changes">
    <input class="button" type="reset" name="reset" value="Reset Changes">
</p>
</form>
<script type="text/javascript">
$(function() {
    var request = null,
      update_example = function() {
      request && request.abort();
      request = $.get('ajax.php/sequence/'
        + $('[name=task_sequence_id] :selected').val(),
        {'format': $('[name=task_number_format]').val()},
        function(data) { $('#format-example').text(data); }
      );
    };
    $('[name=task_sequence_id]').on('change', update_example);
    $('[name=task_number_format]').on('keyup', update_example);
});
</script>
</div>

</div>