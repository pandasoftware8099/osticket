<div id="content">

<div style="margin-bottom:20px; padding-top:5px;">
    <div class="sticky placeholder"></div><div class="sticky bar opaque">
        <div class="content" style="width: 908px;">
            <div class="pull-left flush-left">
                <h2>Agents</h2>
            </div>
            <div class="pull-right">
                <a class="green button action-button" href="<?php echo site_url('admin_agents_controller/agents_agents_add')?>">
                    <i class="icon-plus-sign"></i>
                    Add New Agent                </a>
                <span class="action-button" data-dropdown="#action-dropdown-more">
                <i class="icon-caret-down pull-right"></i>
                <span><i class="icon-cog"></i> More</span>
                </span>
                <div id="action-dropdown-more" class="action-dropdown anchor-right" style="display: none;">
                    <ul>
                        <li>
                            <a id="enable" class="confirm" data-form-id="mass-actions" data-name="enable"  data-toggle="modal" data-target="#more-modal">
                                <i class="icon-ok-sign icon-fixed-width"></i>
                                Enable                            </a>
                        </li>
                        <li>
                            <a id="disable" class="confirm" data-form-id="mass-actions" data-name="disable"  data-toggle="modal" data-target="#more-modal">
                                <i class="icon-ban-circle icon-fixed-width"></i>
                                Disable                            </a>
                        </li>
                        <li>
                            <a id="permissions" class="dialog-first" data-action="permissions" data-toggle="modal" data-target="#more-modal">
                                <i class="icon-sitemap icon-fixed-width"></i>
                                Reset Permissions                            </a>
                        </li>
                        <li>
                            <a id="department" class="dialog-first" data-action="department" data-toggle="modal" data-target="#more-modal"">
                                <i class="icon-truck icon-fixed-width"></i>
                                Change Department                            </a>
                        </li>
                        <!-- TODO: Implement "Reset Access" mass action
                    <li><a class="dialog-first" href="#staff/reset-access">
                    <i class="icon-puzzle-piece icon-fixed-width"></i>
                        Reset Access</a></li>
                    -->
                        <li id="delete" class="danger">
                            <a class="confirm" data-form-id="mass-actions" data-name="delete"  data-toggle="modal" data-target="#more-modal">
                                <i class="icon-trash icon-fixed-width"></i>
                                Delete                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        <a class="only sticky scroll-up" href="#" data-stop="136"><i class="icon-chevron-up icon-large"></i></a></div>
    </div>
</div>
<div class="clear"></div>

<form id="mass-actions" action="<?php echo site_url('admin_agents_controller/agents_agents_process')?>" method="POST" name="staff">

 <input type="hidden" name="__CSRFToken__" value="1b0c67e29fe9504bd47ef8ae0cb4d3f8a89a20f2"> <input type="hidden" name="do" value="mass_process">
 <input type="hidden" id="action" name="a" value="">
 <div style="overflow:auto;">
<table id="ttable" class="list" border="0" cellspacing="1" cellpadding="0" width="100%" style="    white-space: nowrap;">
    <thead>

        <tr>
            <th nowrap="" width="4%" style="text-align: center;"><input type="checkbox" id="tidsall" onclick="checkedAll ();"></th>
            <th style="padding-left:4px;vertical-align:middle" width="36%">Name</th>
            <th style="padding-left:4px;vertical-align:middle" width="8%">Username</th>
            
            <!-- <th style="padding-left:4px;vertical-align:middle" width="14%">Department</th> -->
            <th style="padding-left:4px;vertical-align:middle" width="20%" nowrap="">Status</th>
            <th style="padding-left:4px;vertical-align:middle" width="8%">Department</th>
            <th style="padding-left:4px;vertical-align:middle" width="8%">Created</th>
            <th style="padding-left:4px;vertical-align:middle" width="8%">Last Login</th>
        </tr>
    </thead>
     <tbody class="" data-sort="sort-">
      <?php foreach ($agent->result() as $value) { ?>
                <tr>
                  <td align="center">
                    <input id="tids" type="checkbox" class="ckb" name="tids[]" value="<?php echo $value->staff_guid;?>">
                  </td>
                  <td>
                  <a href="<?php echo site_url('admin_agents_controller/agents_agents_info');?>?id=<?php echo $value->staff_guid;?>"><?php echo $value->firstname;?>&nbsp; <?php echo $value->lastname;?></a>&nbsp;
                  </td>
                  <td>
                  <?php echo $value->username;?>
                  </td>
                  <td><?php if ($value->isactive == 1){ ?>

                      Active

                      <?php } else if ($value->isactive == 0) { ?>

                      Disabled

                      <?php } ?>
                  
                  </td>
                  <td><?php echo $value->name;?></td>
                  
                
                  <td><?php echo $value->user_created;?></td>
                  <td><?php echo $value->lastlogin;?></td>
                </tr>
      <?php } ?>
                </tbody>
                <tfoot>

    </tfoot>
</table>
</div>

<!-- more popup modal -->
<div class="modal fade" id="more-modal" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3>Please Confirm</h3>
              </div>
              <div class="modal-body">

                <div class="quick-add" id="department-confirm">
          <table class="grid form">
          <caption>                  <div><small>Change the primary department and primary role of the selected agents</small></div>
          </caption>
          <tbody><tr><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td></tr></tbody>
<tbody><tr>          <td class="cell" colspan="12" rowspan="1" style="" data-field-id="1">
              <fieldset class="field " id="field_7f5b0818de930711" data-field-id="1">
              <label class="required" for="_7f5b0818de930711">
                  Primary Department:
                                <span class="error">*</span>
                              </label>
        <select class="form-control" name="dept_guid" id="dept_guid" data-placeholder="Select">
                        <option value="">— Primary Department —</option>
                    <?php foreach ($department as $depart) { ?>   
                        <option value="<?php echo $depart['depart_id']?>"><?php echo $depart['depart_name']?></option>
                    <?php }?>
                </select>
                      </fieldset>
          </td>
      </tr><tr>          <td class="cell" colspan="12" rowspan="1" style="" data-field-id="2">
              <fieldset class="field " id="field_2df1031a98e2be9b" data-field-id="2">
              <label class="required" for="_2df1031a98e2be9b">
                  Primary Role:
                                <span class="error">*</span>
                              </label>
        <select class="form-control" name="role_guid" id="role_guid" data-placeholder="Select">
                        <option value="">— Corresponding Role —</option>
                    <?php foreach ($role->result() as $role) { ?>   
                        <option value="<?php echo $role->role_guid?>"><?php echo $role->name?></option>
                    <?php }?>
                </select>
                      </fieldset>
          </td>
      </tr><tr>          <td class="cell" colspan="12" rowspan="1" style="" data-field-id="3">
              <fieldset class="field " id="field_ef6ab044b3b55543" data-field-id="3">
        <label class="checkbox form footer">
        <input id="_ef6ab044b3b55543" type="checkbox" name="maintaindept" value="1">
        Maintain access to current primary department        </label>
              </fieldset>
          </td>
      </tr></tbody></table>  </div>

                <div class="quick-add" id="permissions-confirm">
                  <table class="grid form">
                  <caption>                  <div><small></small></div>
                  </caption>
                  <tbody><tr><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td></tr></tbody>
        <tbody><tr>          <td class="cell" colspan="12" rowspan="1" style="" data-field-id="2">
                      <fieldset class="field " id="field_2df1031a98e2be9b" data-field-id="2">
                    <div>
                    <ul class="alt tabs" style="    width: inherit;">
                        <li class="active"><a href="#2df1031a98e2be9b-users">Users</a></li>
                        <li><a href="#2df1031a98e2be9b-organizations">Organizations</a></li>
                        <li><a href="#2df1031a98e2be9b-knowledgebase">Knowledgebase</a></li>
                        <li><a href="#2df1031a98e2be9b-miscellaneous">Miscellaneous</a></li>
                    </ul>
                <div class="tab_content " id="2df1031a98e2be9b-users">
                <label class="checkbox" for="_2df1031a98e2be9b-1">
                <input id="_2df1031a98e2be9b-1" type="checkbox" name="perms[]" checked="checked" value="user.create">
                Create — Ability to add new users        </label>
                <label class="checkbox" for="_2df1031a98e2be9b-2">
                <input id="_2df1031a98e2be9b-2" type="checkbox" name="perms[]" checked="checked" value="user.edit">
                Edit — Ability to manage user information        </label>
                <label class="checkbox" for="_2df1031a98e2be9b-3">
                <input id="_2df1031a98e2be9b-3" type="checkbox" name="perms[]" checked="checked" value="user.delete">
                Delete — Ability to delete users        </label>
                <label class="checkbox" for="_2df1031a98e2be9b-4">
                <input id="_2df1031a98e2be9b-4" type="checkbox" name="perms[]" checked="checked" value="user.manage">
                Manage Account — Ability to manage user status        </label>
                <label class="checkbox" for="_2df1031a98e2be9b-5">
                <input id="_2df1031a98e2be9b-5" type="checkbox" name="perms[]" checked="checked" value="user.dir">
                User Directory — Ability to access the user directory        </label>
                        </div>
                        <div class="tab_content" id="2df1031a98e2be9b-organizations" style="display: none;">
                <label class="checkbox" for="_2df1031a98e2be9b-6">
                <input id="_2df1031a98e2be9b-6" type="checkbox" name="perms[]" checked="checked" value="org.create">
                Create — Ability to create new organizations        </label>
                <label class="checkbox" for="_2df1031a98e2be9b-7">
                <input id="_2df1031a98e2be9b-7" type="checkbox" name="perms[]" checked="checked" value="org.edit">
                Edit — Ability to manage organizations        </label>
                <label class="checkbox" for="_2df1031a98e2be9b-8">
                <input id="_2df1031a98e2be9b-8" type="checkbox" name="perms[]" checked="checked" value="org.delete">
                Delete — Ability to delete organizations        </label>
                        </div>
                        <div class="tab_content" id="2df1031a98e2be9b-knowledgebase" style="display: none;">
                <label class="checkbox" for="_2df1031a98e2be9b-9">
                <input id="_2df1031a98e2be9b-9" type="checkbox" name="perms[]" checked="checked" value="faq.manage">
                FAQ — Ability to add/update/disable/delete knowledgebase categories and FAQs        </label>
                        </div>
                        <div class="tab_content" id="2df1031a98e2be9b-miscellaneous" style="display: none;">
                <label class="checkbox" for="_2df1031a98e2be9b-10">
                <input id="_2df1031a98e2be9b-10" type="checkbox" name="perms[]" value="emails.banlist">
                Banlist — Ability to add/remove emails from banlist via ticket interface        </label>
                <label class="checkbox" for="_2df1031a98e2be9b-11">
                <input id="_2df1031a98e2be9b-11" type="checkbox" name="perms[]" value="search.all">
                Search — See all tickets in search results, regardless of access        </label>
                <label class="checkbox" for="_2df1031a98e2be9b-11">
                <input id="_2df1031a98e2be9b-11" type="checkbox" name="perms[]" value="stats.agents">
                Stats — Ability to view stats of other agents in allowed departments        </label>
                        </div>
                    </div>
                      </fieldset>
                  </td>
              </tr></tbody></table>  </div>

               <p class="confirm-action" style="display: block;" id="enable-confirm">
                Are you sure you want to <b>Activate</b> selected agent(s)?   </p>

              <p class="confirm-action" style="display: none;" id="disable-confirm">
                Are you sure you want to <b>Deactive</b> selected agent(s)?    </p>

              <p class="confirm-action" style="display: none;" id="delete-confirm">
                <font color="red"><strong>Are you sure you want to DELETE selected agent(s)?</strong></font>
              </p>

              <div>Please confirm to continue.</div>

              </div>
              <div class="modal-footer">
              <p class="full-width">
                <span class="buttons pull-left">
                    <input type="button" value="No, Cancel" class="close">
                </span>
                <span class="buttons pull-right">
                    <input type="submit" value="Yes, Do it!" class="confirm">
                </span>
              </p>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
          <input type="hidden" name="status">
</div>
<!-- more popup modal -->
</form>
</div>




     <script type="text/javascript">
  
var checked=false;
function checkedAll () {
    var aa =  document.getElementsByName("tids[]");
    checked = document.getElementById('tidsall').checked;
     
    for (var i =0; i < aa.length; i++) 
    {
        aa[i].checked = checked;
    }
 }


</script>


<script>
  $(document).ready(function () {    
    $('#ttable').DataTable({
      "columnDefs": [{ "orderable": false, "targets": 0 }],
      'paging'      : true,
      'pageLength'  : <?php echo $max_page_size;?>,
      'searching'   : true,
      'ordering'    : true,
      'order'       : [ [1 , 'asc'] ],
      'info'        : true,
      'autoWidth'   : true,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    })
  })
</script>

<script type="text/javascript">
$(document).ready(function () {
    $('#enable').click(function() {
      checked = $("input[id=tids]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }
      document.getElementById("disable-confirm").style.display = "none";
      document.getElementById("delete-confirm").style.display = "none";
      document.getElementById("permissions-confirm").style.display = "none";
      document.getElementById("department-confirm").style.display = "none";
      document.getElementById("enable-confirm").style.display = "block";
      $("#dept_guid").attr('required', false);
      $("#role_guid").attr('required', false);
      $('#more-modal').find("[name=status]").val(1);
      

    });

    $('#disable').click(function() {
      checked = $("input[id=tids]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }
      document.getElementById("enable-confirm").style.display = "none";
      document.getElementById("delete-confirm").style.display = "none";
      document.getElementById("permissions-confirm").style.display = "none";
      document.getElementById("department-confirm").style.display = "none";
      document.getElementById("disable-confirm").style.display = "block";
      $("#dept_guid").attr('required', false);
      $("#role_guid").attr('required', false);
      $('#more-modal').find("[name=status]").val(0);

    });

    $('#delete').click(function() {
      checked = $("input[id=tids]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }
      document.getElementById("enable-confirm").style.display = "none";
      document.getElementById("disable-confirm").style.display = "none";
      document.getElementById("permissions-confirm").style.display = "none";
      document.getElementById("department-confirm").style.display = "none";
      document.getElementById("delete-confirm").style.display = "block";
      $("#dept_guid").attr('required', false);
      $("#role_guid").attr('required', false);
      $('#more-modal').find("[name=status]").val(2);

    });

    $('#permissions').click(function() {
      checked = $("input[id=tids]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }
      document.getElementById("enable-confirm").style.display = "none";
      document.getElementById("disable-confirm").style.display = "none";
      document.getElementById("permissions-confirm").style.display = "block";
      document.getElementById("delete-confirm").style.display = "none";
      document.getElementById("department-confirm").style.display = "none";
      $("#dept_guid").attr('required', false);
      $("#role_guid").attr('required', false);
      $('#more-modal').find("[name=status]").val(3);

    });

    $('#department').click(function() {
      checked = $("input[id=tids]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }
      document.getElementById("enable-confirm").style.display = "none";
      document.getElementById("disable-confirm").style.display = "none";
      document.getElementById("permissions-confirm").style.display = "none";
      document.getElementById("delete-confirm").style.display = "none";
      document.getElementById("department-confirm").style.display = "block";
      $("#dept_guid").attr('required', true);
      $("#role_guid").attr('required', true);
      $('#more-modal').find("[name=status]").val(4);

    });

    

});

</script>
  