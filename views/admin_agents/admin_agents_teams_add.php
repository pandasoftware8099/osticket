<div id="content">
        <form class="form-horizontal" action="<?php echo site_url('admin_agents_controller/agents_teams_add_process')?>" method="post">
 <input type="hidden" name="__CSRFToken__" value="5d068236e90dacfe040b83f9cae3370b3bc8a621"> <input type="hidden" name="do" value="create">
 <input type="hidden" name="a" value="add">
 <input type="hidden" name="id" value="">
 <h2><i class="help-tip icon-question-sign" href="#teams"></i> Add New Team    </h2>
<br>
<div class="tab">
  <ul class="clean tabs">
      <li class="active"><a href="#team">
          <i class="icon-file"></i> Team</a></li>
      <li class=""><a href="#members">
          <i class="icon-group"></i> Members</a></li>
  </ul>
</div>

<div id="team" class="tab_content" style="display: block;">
  <div class="section-break" style="margin-bottom:10px;">
      <em><strong>Team Information</strong> :</em>
  </div>
  <div class="form-group">
    <label class="col-lg-2 control-label">Name <span class="error">*</span> :</label>
    <div class="col-lg-10">
      <input required="true" type="text" size="30" class="form-control" name="name" value="" autofocus="" data-translate-tag="">
         &nbsp;<span class="error"></span>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#status"></i> Status <span class="error">*</span> :</label>
    <div class="col-lg-10">
      <input type="radio" name="isenabled" value="1" checked="checked"><strong>Active</strong>
      &nbsp;<input type="radio" name="isenabled" value="0">Disabled    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#lead"></i> Team Lead :</label>
    <div class="col-lg-10">
      <select id="team-lead-select" class="form-control" name="lead_id" data-quick-add="staff">
        <option value="0">— None —</option>
                          <?php foreach ($staff->result() as $value) { ?>
                            <option value="<?php echo $value->staff_id;?>"><?php echo $value->firstname;?> <?php echo $value->lastname;?></option>
                          <?php } ?>
       </select>
       &nbsp;<span class="error"></span>
    </div>
  </div>
  <!-- <div class="form-group">
    <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#assignment_alert"></i> Assignment Alert :</label>
    <div class="col-lg-10">
      <input type="checkbox" name="noalerts" value="1">
      <strong>Disable</strong> for this team    </div>
  </div> -->
  <div class="section-break" style="margin-bottom:10px;">
      <em><strong>Admin Notes</strong>: Internal notes viewable by all admins.&nbsp;</em>
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
</div>


<div id="members" class="tab_content" style="display: none;">
   <table class="two-column table" width="100%">
    <tbody>
        <tr class="header">
            <td colspan="2">
                <i class="help-tip icon-question-sign" href="#members"></i>
                Team Members                <div><small>
                Agents who are members of this team                </small></div>
            </td>
        </tr>
      <tr id="add_member">
        <td colspan="2">
          <i class="icon-plus-sign"></i>
          <select id="add_access" data-quick-add="staff">
            <option value="0">— Select Agent —</option>
            <?php foreach ($staff->result() as $value) { ?>
                            <option value="<?php echo $value->staff_id;?>"><?php echo $value->firstname;?> <?php echo $value->lastname;?></option>
                          <?php } ?>
          </select>
          <button type="button" class="action-button">
            Add          </button>
        </td>
      </tr>
    </tbody>
    <tbody>
      <tr id="member_template" class="hidden">
        <td>
          <input type="hidden" data-name="members[]" value="">
        </td>
        <td>
          <label>
            <input type="checkbox" data-name="member_alerts" value="1">
            Alerts          </label>
          <a href="#" class="pull-right drop-membership" title="Delete"><i class="icon-trash"></i></a>
        </td>
      </tr>
    </tbody>
   </table>
</div>

<p style="text-align:center">
    <input type="submit" name="submit" value="Create Team">
    <input type="reset" name="reset" value="Reset">
    <input type="button" name="cancel" value="Cancel" onclick="window.location.href=&quot;?&quot;">
</p>
</form>

<script type="text/javascript">
var addMember = function(staffid, name, alerts, error) {
  if (!staffid) return;
  var copy = $('#member_template').clone();

  copy.find('[data-name=members\\[\\]]')
    .attr('name', 'members[]')
    .val(staffid);
  copy.find('[data-name^=member_alerts]')
    .attr('name', 'member_alerts['+staffid+']')
    .prop('checked', alerts);
  copy.find('td:first').append(document.createTextNode(name));
  copy.attr('id', '').show().insertBefore($('#add_member'));
  copy.removeClass('hidden')
  if (error)
      $('<div class="error">').text(error).appendTo(copy.find('td:last'));
};

$('#add_member').find('button').on('click', function() {
  var selected = $('#add_access').find(':selected'),
      id = parseInt(selected.val());
  if (!id)
    return;
  addMember(id, selected.text(), true);
  if ($('#team-lead-select option[value='+id+']').length === 0) {
    $('#team-lead-select').find('option[data-quick-add]')
    .before(
      $('<option>').val(selected.val()).text(selected.text())
    );
  }
  selected.remove();
  return false;
});

$(document).on('click', 'a.drop-membership', function() {
  var tr = $(this).closest('tr'),
      id = tr.find('input[name^=members][type=hidden]').val();
  $('#add_access').append(
    $('<option>')
    .attr('value', id)
    .text(tr.find('td:first').text())
  );
  $('#team-lead-select option[value='+id+']').remove();
  tr.fadeOut(function() { $(this).remove(); });
  return false;
});

</script>
</div>

</div>