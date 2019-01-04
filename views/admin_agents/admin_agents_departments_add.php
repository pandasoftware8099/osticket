<div id="content">
        <form class="form-horizontal" action="<?php echo site_url('admin_agents_controller/agents_departments_add_process');?>" method="post">

<h2>Add New Department    </h2>
<div class="tab">
    <ul class="clean tabs">
        <li class="active"><a href="#settings">
            <i class="icon-file"></i> Settings</a></li>
        <li><a href="#access">
          <i class="icon-user"></i> Access</a></li>
    </ul>
</div>
<div id="settings" class="tab_content">
    <div class="section-break" style="margin-bottom:10px;">
        <em>Department Information</em>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Parent :</label>
        <div class="col-lg-10">
            <select name="pid" class="form-control">
                <option value="">— Top-Level Department —</option>
                                <?php foreach ($department as $value) { ?>
                                    <option value="<?php echo $value['depart_id']?>"><?php echo $value['depart_name']?></option>


                                <?php } ?>
                            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Name <span class="error">*</span> :</label>
        <div class="col-lg-10">
            <input required="true" class="form-control" data-translate-tag="c3c9cc673671e9d2" type="text" size="30" name="name" value="" autofocus="">
            &nbsp;<span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#type"></i> Type :</label>
        <div class="col-lg-10">
            <label>
            <input type="radio" name="ispublic" value="1" checked="checked"><strong>Public</strong>
            </label>
            &nbsp;
            <label>
            <input type="radio" name="ispublic" value="0"><strong>Private</strong> (Internal)            </label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#sla"></i> SLA :</label>
        <div class="col-lg-10">
            <select name="sla_id" class="form-control">
                <option value="0">— System Default —</option>
                <?php foreach ($sla->result() as $value) { ?>
                    <option value="<?php echo $value->id?>"><?php echo $value->sla_name?></option>
                <?php } ?>            
            </select>
            &nbsp;<span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#manager"></i> Manager :</label>
        <div class="col-lg-10">
            <select name="manager_id" class="form-control">
                <option value="0">— None —</option>
                <?php foreach ($staff->result() as $value) { ?>
                    <option value="<?php echo $value->staff_id?>"><?php echo $value->firstname?> <?php echo $value->lastname?></option>
                <?php } ?>            
            </select>         
            </select>
            &nbsp;<span class="error"></span>
        </div>
    </div>
    <!-- <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#sandboxing"></i> Ticket Assignment :</label>
        <div class="col-lg-10">
            <label>
                <input type="checkbox" name="assign_members_only">
                Restrict ticket assignment to department members            </label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#disable_auto_claim"></i> Claim on Response :</label>
        <div class="col-lg-10">
            <label>
                <input type="checkbox" name="disable_auto_claim">
                <strong>Disable</strong> auto claim            </label>
        </div>
    </div> -->
    <!-- <div class="section-break" style="margin-bottom:10px;">
        <em><strong>Outgoing Email Settings</strong>:</em>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#email"></i> Outgoing Email :</label>
        <div class="col-lg-10">
            <select name="email_id" class="form-control">
                <option value="0">— System Default —</option>
                <?php foreach ($email->result() as $value) { ?>
                    <option value="<?php echo $value->email_id?>"><?php echo $value->name?> < <?php echo $value->email?> ></option>
                <?php } ?>              
            </select>
            &nbsp;<span class="error">&nbsp;</span>
        </div>
    </div> -->
    <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#template"></i> Template Set :</label>
        <div class="col-lg-10">
            <select name="tpl_id" class="form-control">
                <option value="0">— System Default —</option>
                <?php foreach ($emailtemplate->result() as $value) { ?>
                    <option value="<?php echo $value->tpl_id?>"><?php echo $value->name?></option>
                <?php } ?>              
            </select>
            &nbsp;<span class="error">&nbsp;        </span></div>
    </div>
    <div class="section-break" style="margin-bottom:10px;">
        <em><i class="help-tip icon-question-sign" href="#auto_response_settings"></i> <strong>Autoresponder Settings</strong> :</em>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#new_ticket"></i> New Ticket :</label>
        <div class="col-lg-10">
            <label>
                <input type="checkbox" name="ticket_auto_response" value="0">

                <strong>Disable</strong> for this department            </label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#new_message"></i> New Message :</label>
        <div class="col-lg-10">
            <label>
                <input type="checkbox" name="message_auto_response" value="0">
                <strong>Disable</strong> for this department            </label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#auto_response_email"></i> Auto-Response Email :</label>
        <div class="col-lg-10">
            <select name="autoresp_email_id" class="form-control">
                <option value="0" selected="selected">— Department Email —</option>
                <?php foreach ($email->result() as $value) { ?>
                    <option value="<?php echo $value->email_id?>"><?php echo $value->name?> < <?php echo $value->email?> ></option>
                <?php } ?>               
            </select>
            &nbsp;<span class="error"></span>
        </div>
    </div>
    <div class="section-break" style="margin-bottom:10px;">
        <em><strong><i class="help-tip icon-question-sign" href="#group_membership"></i> Alerts and Notices :</strong></em>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#group_membership"></i> Recipients :</label>
        <div class="col-lg-10">
            <select name="group_membership" class="form-control">
                <option value="2">No one (disable Alerts and Notices)</option>                    
                <option value="0">Department members only</option>                    
                <option value="1" selected="selected">Department and extended access members</option>            
            </select>
        </div>
    </div>
    <div class="section-break" style="margin-bottom:10px;">
        <em><i class="help-tip icon-question-sign" href="#department_signature"></i> <strong>Department Signature</strong> :
        <span class="error">&nbsp;</span>
        </em>
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
                
                <textarea name="deptsignature" class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
            
              
            </div>
          </div>
    </div>
</div>

<div id="access" class="hiddens tab_content">
  <table class="two-column table" width="100%">
    <tbody>
        <tr class="header" id="primary-members">
            <td colspan="2">
                Department Members                <div><small>
                Agents who are primary members of this department                </small></div>
            </td>
        </tr>
                <tr><td colspan="2"><em>Department does not have primary members           </em> </td>
        </tr>
             </tbody>
     <tbody>
        <tr class="header" id="extended-access-members">
            <td colspan="2">
                <div><small>
                Agents who have extended access to this department                </small></div>
            </td>
        </tr>
      <tr id="add_extended_access">
        <td colspan="2">
          <i class="icon-plus-sign"></i>
          <select id="add_access" data-quick-add="staff">
            <option value="0">— Select Agent —</option>
                        <?php foreach ($staff->result() as $value) { ?>
                        <option value="<?php echo $value->staff_id?>"><?php echo $value->firstname?> <?php echo $value->lastname?></option>
                        <?php } ?>   
          </select>
          <button type="button" class="action-button">
            Add          </button>
        </td>
      </tr>
      <?php $staff_dept_id = array();
        foreach($staff->result() as $staff_info)
        {
            $staff_dept_id[] = $staff_info->dept_id;
        };?>
      <tr id="add_extended_access_1">
        <td colspan="2">
            <i class="icon-plus-sign"></i>
            <select id="add_dep_access" data-quick-add="staff">
                <option value="0">— Select Department —</option>
                <?php foreach ($department as $value) { ?>
                <?php if (in_array($value['depart_id'], $staff_dept_id)) { ?>
                <option value="<?php echo $value['depart_id']?>" ><?php echo $value['depart_name']?></option>
                <?php } ?>
                <?php } ?>
            </select>
            <button type="button" class="action-button">
                Add              </button>
        </td>
      </tr>
    </tbody>
    <tbody class="hiddens">
      <tr id="member_template" >
        <td>
          <input type="hidden" data-name="members[]" value="">
        </td>
        <td>
          <select data-name="member_role" data-quick-add="role">
            <option value="0">— Select Role —</option>
            <?php foreach ($roles->result() as $value) { ?>
                        <option value="<?php echo $value->id?>"><?php echo $value->name?></option>
                        <?php } ?>  
          </select>
          <span style="display:inline-block;width:60px"> </span>
          <label class="inline checkbox">
            <input type="checkbox" data-name="member_alerts" value="1" style="margin-top:10px;">
            Alerts          </label>
          <a href="#" class="pull-right drop-membership" title="Delete"><i class="icon-trash"></i></a>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<p style="text-align:center">
    <input type="submit" name="submit" value="Create Dept">
    <input type="reset" name="reset" value="Reset">
    <input type="button" name="cancel" value="Cancel" onclick="window.location.href=&quot;?&quot;">
</p>
</form>

<script type="text/javascript">
var addAccess = function(staffid, name, role, alerts, primary, error) {

  if (!staffid) return;
  var copy = $('#member_template').clone();
  var target = (primary) ? 'extended-access-members' : 'add_extended_access';
  copy.find('td:first').append(document.createTextNode(name));
  if (primary) {
    copy.find('a.drop-membership').remove();
  }
    copy.find('[data-name^=member_alerts]')
      .attr('name', 'member_alerts[]')
      .prop('disabled', (primary))
      .prop('checked', primary || alerts);
    copy.find('[data-name^=member_role]')
      .attr('name', 'member_role[]')
      .val(role || 0);
    copy.find('[data-name=members\\[\\]]')
      .attr('name', 'members[]')
      .val(staffid);

  copy.attr('id', '').show().insertBefore($('#'+target));
  copy.removeClass('hidden')
  if (error)
      $('<div class="error">').text(error).appendTo(copy.find('td:last'));
  copy.find('.drop-membership').click(function() {
    $('#add_access').append(
      $('<option>')
      .attr('value', copy.find('input[name^=members][type=hidden]').val())
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

$('#add_extended_access_1').find('button').on('click', function(){
    var selected = $('#add_dep_access').find(':selected'),
        id = parseInt(selected.val());
    if(!id)
        return;

    $.ajax({
        url: "<?php echo site_url('insertdepartment_c/main');?>?id=&id1=" + selected.val(),
        dataType: "json",
        success: function(result){

            $.each(result['a'], function(key, val){
                addAccess(val.staff_id, val.firstname + " " + val.lastname, 0, true);
                $("#add_extended_access option[value = '" + val.staff_id + "']").remove();
            });
            selected.remove();
            return false;
    }});
});

</script>
</div>

</div>