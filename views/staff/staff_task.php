<div id="content" style="height: fit-content;">
        
<div class="clear"></div>
<div style="margin-bottom:20px; padding-top:5px;">
    <div class="sticky placeholder"></div><div class="sticky bar opaque">
        <div class="content" style="width: 908px;">
            <div class="col-lg-12">
                <div class="pull-left">
                    <h2><a href="/helpdesk/scp/tickets.php?status=open&amp;_pjax=%23pjax-container" title="Refresh"><i class="icon-refresh"></i> <?php echo $_REQUEST["title"]; ?> Tasks</a></h2>
                </div>
                <div class="pull-right">
  
<a class="green button action-button popup-dialog" data-toggle="modal" data-target="#task-modal" href="#users/add">
                    <i class="icon-plus-sign"></i> Add Task
</a>

<div class="modal fade" id="task-modal" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" class="org" action="<?php echo site_url('staff_task_controller/createtask?direct=task');?>" enctype="multipart/form-data">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
              <h3 class="drag-handle">New Task</h3>
        </div>

        <div class="modal-body">
          <div id="new-task-form" style="display:block;">
                    
            <table class="grid form">                
                <tbody>
                  <tr>
                    <td class="cell" colspan="12" rowspan="1" style="" data-field-id="32">
                      <fieldset class="field " id="field_31e14e029d68ee1d" data-field-id="32">
                        <label class="required" for="_31e14e029d68ee1d">
                          Title:
                          <span class="error">*</span>
                        </label>
                        <input type="text" class="form-control" id="_31e14e029d68ee1d" size="40" maxlength="50" placeholder="" name="title" value="" required="true" autocomplete="off">
                      </fieldset>
                    </td>
                  </tr>

                  <tr>
                    <td class="cell" colspan="12" rowspan="1" style="padding-top: 8px" data-field-id="33">
                      <fieldset class="field " id="field_59f5e50392776c84" data-field-id="33">
                        <label class="required" for="_59f5e50392776c84">
                          Description:
                          <span class="error">*</span>
                        </label>

                        <textarea class="form-control" rows="8" cols="40" placeholder="Start writing your message here" id="_d8bf82dc954436ab" name="description" required="true"></textarea>

                          <div id="reply_form_attachments" class="attachments">

                          <div class="filedrop">
                              <div class="files"></div>
                              <div class="dropzone" style="color: black;">
                                  <input style="display:unset;border:0;padding:0;background-color:white;" type="file" name="file[]" id="file" class="file" multiple>
                              </div>
                          </div>
                          </div>
                          <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css">
                      </fieldset></td>
                  </tr>
                </tbody>
            </table>      

            <table class="grid form">
              <tbody>
                <tr>
                  <td class="cell" colspan="6" rowspan="1" style="" data-field-id="1">
                    <fieldset class="field " id="field_3b16f40dc83394b4" data-field-id="1">
                      <label class="required" for="_3b16f40dc83394b4">
                        Department:
                        <span class="error">*</span>
                      </label>

                      <select class="form-control" name="departmentid" id="_3b16f40dc83394b4" data-placeholder="Select" required="true">
                        <option value="">— Select —</option>
                        <?php foreach ($department->result() as $departmentt) { ?>
                          <option value="<?php echo $departmentt->department_guid;?>"><?php echo $departmentt->name;?></option>
                        <?php } ?>
                      </select>
                    </fieldset></td>
                                    
                  <td class="cell" colspan="6" rowspan="1" style="" data-field-id="2">
                    <fieldset class="field " id="field_61e261c0821e3b53" data-field-id="2">
                      <label class="" for="_61e261c0821e3b53">
                        Assignee:
                      </label>

                      <select class="form-control" name="assign" id="_61e261c0821e3b53" data-placeholder="Select">
                        <option value="">— Select —</option>
                        <optgroup label="Agents (<?php echo $staff->num_rows();?>)">
                          <?php foreach ($staff->result() as $stafff) { ?>
                          <option value="a<?php echo $stafff->staff_guid;?>"><?php echo $stafff->firstname;?> <?php echo $stafff->lastname;?></option>
                          <?php } ?> 
                        </optgroup>    
                            
                        <optgroup label="Team (<?php echo $team->num_rows();?>)">         
                          <?php foreach ($team->result() as $teamm) { ?>
                          <option value="t<?php echo $teamm->team_guid;?>"><?php echo $teamm->name;?></option>
                          <?php } ?> 
                        </optgroup>
                      </select>
                    </fieldset></td>
                </tr>

                <tr>
                  <td class="cell" colspan="12" rowspan="1" style="" data-field-id="3">
                    <br><fieldset class="form-group" id="field_71f2433eb7244557" data-field-id="3">
                      <label class="" for="_71f2433eb7244557">
                        &nbsp;Due Date:
                      </label>
                      <div class="input-append date form_datetime">
                        <input style="margin-left: 5px" size="16" type="text" value="" name="duedatetime" autocomplete="off" readonly>
                          <span class="add-on"><i class="icon-calendar"></i></span>
                          <span class="add-on"><i class="icon-remove"></i></span>&nbsp;
                          <span class="faded">(MYT)</span>
                      </div>
                      <script type="text/javascript">
                          $(".form_datetime").datetimepicker({
                              format: "yyyy-mm-dd hh:ii",
                              startDate: new Date(),
                              autoclose: true,
                              minuteStep: 10,
                              pickerPosition: "top-right",
                          });
                      </script>
                    </fieldset></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
                
        <div class="modal-footer">
          <p class="full-width">
            <span class="buttons pull-left">
              <input type="button" data-dismiss="modal" value ="Cancel">
              <input type="reset" value="Reset">
            </span>

            <span class="buttons pull-right">
              <input type="submit" name="submit" value="Add User">
            </span>
          </p>
        </div>
      </form>

    </div>
  </div>
</div>

<?php if ($editallow != 0 ) { ?>
<span class="action-button" data-toggle="modal" data-target="#cstatus" id="checkBtn" title="Change Status"><i class="icon-flag"></i></span>

<?php if ($assignallow != 0 ) { ?>
<span class="action-button" id="assign" data-toggle="modal"  data-target="#claim" title=" Assign"><i class="icon-user"></i></span>
<?php } ?>

<?php if ($transferallow != 0 ) { ?>
<span class="action-button" id="tickets-transfer" data-placement="bottom" data-toggle="modal" data-target="#transfer"><i class="icon-share"></i></span>
<?php } ?>

<?php if ($deleteallow != 0 ) { ?>
<span class="red button action-button" id="tickets-delete" data-placement="bottom" data-toggle="modal" data-target="#delete"><i class="icon-trash"></i></span>
<?php } ?>

<?php } ?>

<script type="text/javascript">
$(function() {

    $(document).off('.tickets');
    $(document).on('click.tickets', 'a.tickets-action', function(e) {
        e.preventDefault();
        var $form = $('form#tickets');
        var count = checkbox_checker($form, 1);
        if (count) {
            var tids = $('.ckb:checked', $form).map(function() {
                    return this.value;
                }).get();
            var url = 'ajax.php/'
            +$(this).attr('href').substr(1)
            +'?count='+count
            +'&tids='+tids.join(',')
            +'&_uid='+new Date().getTime();
            console.log(tids);
            $.dialog(url, [201], function (xhr) {
                $.pjax.reload('#pjax-container');
             });
        }
        return false;
    });
});
</script>
                </div>
            </div>
        <a class="only sticky scroll-up" href="#" data-stop="106"><i class="icon-chevron-up icon-large"></i></a></div>
    </div>
</div>
<div class="clear" style="padding:5px;"></div>

<form action="<?php echo site_url('staff_task_controller/changetaskstatus?direct=task&title=')?><?php echo $_REQUEST['title']; ?>" method="POST" name="tickets" id="tickets">

<div style="overflow:auto; overflow-x: hidden;">
  <!-- <table class="table table-bordered table-hover" id="ttable"  border="0" cellspacing="0" cellpadding="0"> -->

  <table class="list" id="ttable"  border="0" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
            <th style="text-align: center;" ><input type="checkbox" name="tids[]" id="tidsall" onclick="checkedAll ();"></th>
            <th width="8%">Number</th>
            <th width="20%">Date Created</th>
            <th width="38%">Title</th>
            <th width="16%">Department</th>
            <th width="16%">Agent</th>        
        </tr>
    </thead>

    <tbody> 
            <?php foreach ($result->result() as $value) { ?>
            
            <tr id="3">
                <td align="center" class="nohover"><input class="ckb" type="checkbox" name="tids[]" value="<?php echo $value->task_guid;?>"></td>
                <td nowrap=""><a class="preview" href="<?php echo site_url('staff_task_controller/taskinfo');?>?id=<?php echo $value->task_guid;?>"><?php echo $value->number;?></a></td>
                <td nowrap=""><?php echo $value->task_created;?></td>
                <td><a href="<?php echo site_url('staff_task_controller/taskinfo');?>?id=<?php echo $value->task_guid;?>"><?php echo $value->title;?></a>
                    <?php 
                    if ($this->db->query("SELECT COUNT(*) as threadcount FROM ost_thread_entry_test WHERE task_guid = '".$value->task_guid."'")->row('threadcount') != '0' && $this->db->query("SELECT COUNT(*) as threadcount FROM ost_thread_entry_test WHERE task_guid = '".$value->task_guid."'")->row('threadcount') != '1')
                    { ?>
                      <span class="pull-right faded-more">
                        <i class="icon-comments-alt"></i>
                          <small><?php echo $this->db->query("SELECT COUNT(*) as threadcount FROM ost_thread_entry_test WHERE task_guid = '".$value->task_guid."'")->row('threadcount');?></small>
                      </span>
                    <?php } ?></td>
                <td nowrap=""><?php echo $value->name;?></td>
                <td nowrap="">

                <?php 
                if ($value->team_guid == '0')
                { ?>
                  <?php echo $this->db->query("SELECT firstname FROM ost_staff_test AS a
                                              INNER JOIN ost_task_test AS b
                                              ON b.staff_guid = a.staff_guid
                                              WHERE b.task_guid = '".$value->task_guid."'")->row('firstname');?> 
                  <?php echo $this->db->query("SELECT lastname FROM ost_staff_test AS a
                                              INNER JOIN ost_task_test AS b
                                              ON b.staff_guid = a.staff_guid
                                              WHERE b.task_guid = '".$value->task_guid."'")->row('lastname');?>
                <?php }

                if ($value->staff_guid == '0')
                { ?>
                  <?php echo $this->db->query("SELECT name FROM ost_team_test AS a
                                              INNER JOIN ost_task_test AS b
                                              ON b.team_guid = a.team_guid
                                              WHERE b.task_guid = '".$value->task_guid."'")->row('name');?>
                <?php } ?>

                </td>
            </tr>

        <?php } ?>
    </tbody>

<!--         <tfoot>
         <tr>
            <td colspan="7">
                                Select:&nbsp;
                <a id="selectAll" href="#ckb">All</a>&nbsp;&nbsp;
                <a id="selectNone" href="#ckb">None</a>&nbsp;&nbsp;
                <a id="selectToggle" href="#ckb">Toggle</a>&nbsp;&nbsp;
                            </td>
         </tr>
        </tfoot> -->
  </table>

  <?php if($_REQUEST['title'] == 'Closed' ) {?>
  <!-- reopen task status popup modal -->
  <div class="modal fade" id="cstatus" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Open Selected Task(s)</h3>
              </div>
              <div class="modal-body">

                <p id="msg_warning">Are you sure you want to reopen selected task(s)?</p>

                <div id="ticket-status" style="display:block; margin:5px;">

                <table width="100%">
                <tbody>
                  <input type="hidden" name="status_guid" id="status_guid" value="1">
                </tbody>
                <tbody>
                  <tr>
                      <td colspan="2">

                        <br>
                        <div class="popup_selected_task" style="font-size: 15px;background-color: lightyellow;"></div>
                        <br>
                        <textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for status change (internal note)" id="_d8bf82dc954436ab" name="closenote"></textarea>
                      </td>
                  </tr>
                </tbody>
                </table>
                </div>
              </div>
              <div class="modal-footer">
                <p class="full-width">
                <span class="buttons pull-left">
                  <input type="button" data-dismiss="modal" value ="Cancel">
                  <input type="reset" value="Reset">
                </span>
                <span class="buttons pull-right">
                <input id="opennn" type="submit" value="Submit">
                </span>
                </p>
              </div>
            </div>
          </div>
  </div>
  <!-- reopen task status popup modal -->
  <?php } else if ($_REQUEST['title'] == 'Open'){ ?>
  <!-- close task status popup modal -->
  <div class="modal fade" id="cstatus" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Close Selected Task(s)</h3>
              </div>
              <div class="modal-body">

                <p id="msg_warning">Are you sure you want to close selected task(s)?</p>

                <div id="ticket-status" style="display:block; margin:5px;">

                <table width="100%">
                <tbody>
                  <input type="hidden" name="status_guid" id="status_guid" value="0">
                </tbody>
                <tbody>
                  <tr>
                      <td colspan="2">

                        <br>
                        <div class="popup_selected_task" style="font-size: 15px;background-color: lightyellow;"></div>
                        <br>

                        <textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for status change (internal note)" id="_d8bf82dc954436ab" name="closenote"></textarea>
                      </td>
                  </tr>
                </tbody>
                </table>
                </div>
              </div>
              <div class="modal-footer">
                <p class="full-width">
                <span class="buttons pull-left">
                  <input type="button" data-dismiss="modal" value ="Cancel">
                  <input type="reset" value="Reset">
                </span>
                <span class="buttons pull-right">
                <input id="opennn" type="submit" value="Submit">
                </span>
                </p>
              </div>
            </div>
          </div>
  </div>
  <!-- close task status popup modal -->
  <?php } ?>
  <div class="modal fade" id="claim" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Assign Selected Task(s)</h3>
              </div>
              <div class="modal-body">

                <div style="display:block; margin:5px;">
                  <form class="mass-action" method="post" name="assign" id="assign" action="#tickets/mass/assign/agents">
                      <table width="100%">
                                  <tbody>
                              <tr><td colspan="2">
                               <div class="form-simple">
                              <div class="flush-left custom-field" id="field_da489cda559d4795">
                          <div>
                            <div class="field-label required">
                          <label for="da489cda559d4795">
                              Assignee:
                                <span class="error">*</span>
                            </label>
                          </div>
                                    </div><div>
                                  <select class="form-control" name="assignto" id="assignto" data-placeholder="Select an Agent">
                                          <option value="">— Select an Agent —</option>
                              <optgroup label="Agents (<?php echo $this->db->query("SELECT COUNT(*) as agent FROM ost_staff_test")->row('agent');?>)">
                              <?php foreach ($staff->result() as $staff) { ?>
                              <option value="a<?php echo $staff->staff_guid;?>"><?php echo $staff->firstname;?> <?php echo $staff->lastname;?></option>
                              <?php } ?> 
                              </optgroup>    
                              <optgroup label="Team (<?php echo $this->db->query("SELECT COUNT(*) as team FROM ost_team_test")->row('team');?>)">         
                              <?php foreach ($team->result() as $team) { ?>
                              <option value="t<?php echo $team->team_guid;?>"><?php echo $team->name;?></option>
                              <?php } ?> 
                              </optgroup>  

                                  </select>
                                  </div>
                                  </div>
                              <div class="flush-left custom-field" >
                          <div>
                                    </div><div>
                                  <span style="display:inline-block;width:100%">
                                    <br>
                                    <div class="popup_selected_task" style="font-size: 15px;background-color: lightyellow;"></div>
                                    <br>
                          <textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for the assignment" name="assignnote"></textarea>
                          </span>
                                  </div>
                                  </div>
                              <script type="text/javascript">
                            $(function() {
                                              $(document).off('change.assign');
                                  $(document).on('change.assign',
                                      'form#assign :input',
                                      function() {
                                          //Clear any current errors...
                                          var errors = $('#field'+$(this).attr('id')+'_error');
                                          if (errors.length)
                                              errors.slideUp('fast', function (){
                                                  $(this).remove();
                                                  });
                                          //TODO: Validation input inplace or via ajax call
                                          // and set any new errors AND visibilty changes
                                      }
                                     );
                                          });
                          </script>
                          </div>
                              </td> </tr>
                          </tbody>
                      </table>
                  </form>
                  </div>

              </div>
              <div class="modal-footer">

                <p class="full-width">
                          <span class="buttons pull-left">
                            <input type="button" data-dismiss="modal" value ="Cancel">
                            <input type="reset" value="Reset">
                          </span>
                          <span class="buttons pull-right">
                              <input type="submit" value="Assign">
                          </span>
                </p>

              </div>
            </div>
          </div>
  </div>

  <div class="modal fade" id="transfer" style="display: none;">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                  <h3 class="drag-handle">Transfer Selected Task(s)</h3>
                </div>
                <div class="modal-body">

                  <div style="display:block; margin:5px;">

                <table width="100%">
                  <tbody>
              <tr><td colspan="2">
               <div class="form-simple">
              <div class="flush-left custom-field">
            <div>
              <div class="field-label required">
            <label for="b7a7b14540f04e3c">
                Department:
                  <span class="error">*</span>
              </label>
            </div>
                    </div><div>
                  <select class="form-control" name="departmentid" id="departmentid" data-placeholder="Select">
                    <option value="">— Select —</option>
                    <?php foreach ($department->result() as $department) { ?>
                      <option value="<?php echo $department->department_guid;?>"><?php echo $department->name;?></option>
                    <?php } ?>
                  </select>
                  </div>
                  </div>
              <div class="flush-left custom-field">
            <div>
                      </div><div>
                    <span style="display:inline-block;width:100%">
                      <br>
                        <div class="popup_selected_task" style="font-size: 15px;background-color: lightyellow;"></div>
                      <br>
            <textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for the transfer" id="_e8f5989ca9fa6fe1" name="transfernote"></textarea>
            </span>
                    </div>
                  </div>
              <script type="text/javascript">
            $(function() {
                              $(document).off('change.transfer');
                  $(document).on('change.transfer',
                      'form#transfer :input',
                      function() {
                          //Clear any current errors...
                          var errors = $('#field'+$(this).attr('id')+'_error');
                          if (errors.length)
                              errors.slideUp('fast', function (){
                                  $(this).remove();
                                  });
                          //TODO: Validation input inplace or via ajax call
                          // and set any new errors AND visibilty changes
                      }
                     );
                          });
              </script>
                </div>
                    </td> </tr>
                </tbody>
            </table>



            </div>

                </div>
                <div class="modal-footer">

                  <p class="full-width">
                    <span class="buttons pull-left">
                      <input type="button" data-dismiss="modal" value ="Cancel">
                      <input type="reset" value="Reset">
                    </span>
                    <span class="buttons pull-right">
                        <input type="submit" value="Transfer">
                    </span>
                 </p>

                </div>
              </div>
            </div>
  </div>

  <div class="modal fade" id="delete" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Delete Selected Task(s)</h3>
              </div>
              <div class="modal-body">

                <p id="msg_warning">Are you sure you want to DELETE selected task(s)?</p>

                <div style="display:block; margin:5px;">
                <form class="mass-action" method="post" name="delete" id="delete" action="#tickets/mass/delete">
                    <table width="100%">
                                <tbody>
                            <tr><td colspan="2"><strong><strong>Deleted task(s) CANNOT be recovered, including any associated attachments.</strong></strong></td> </tr>
                        </tbody>
                                <tbody>
                            <tr>
                                <td colspan="2">
                                  
                                  <br>
                                    <div class="popup_selected_task" style="font-size: 15px;background-color: lightyellow;"></div>
                                  <br>

                                  <textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for the assignment" name="assignnote"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                </div>

              </div>
              <div class="modal-footer">

                    <p class="full-width">
                      <span class="buttons pull-left">
                        <input type="button" data-dismiss="modal" value ="Cancel">
                        <input type="reset" value="Reset">
                      </span>
                      <span class="buttons pull-right">
                          <input type="submit" class="red button" value="Delete">
                    <select name="delete" id="deletetask" hidden="true" >
                      <option value="5"></option>
                  


                    </select>
                    

                      </span>
                   </p>

              </div>
            </div>
          </div>
  </div>
</div>

</form>
</div>

<div>
    <div id="footer" style="margin-bottom:10px;">
        Copyright © 2006-2018&nbsp;Panda Ticketing System&nbsp;All Rights Reserved.
    </div>
    <div>
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
        <!-- <img src="/helpdesk/scp/autocron.php" alt="" width="1" height="1" border="0"> -->
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
    </div>
</div>

<div id="loading" style="top: 219px; left: 533px;">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>
<!-- <div class="container dialog draggable ui-draggable size-large" id="popup">
    <div id="popup-loading" style="display: none;">
        <h1 style="margin-bottom: 20px; margin-top: 6px;"><i class="icon-spinner icon-spin icon-large"></i>
        Loading ...</h1>
    </div>

</div> -->
<div style="display: none; top: 54.75px; left: 627px;" class="dialog" id="alert">
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
      'order'       : [ [1 , 'desc'] ],
      'info'        : true,
      'autoWidth'   : true,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    })
  })
</script>

<!-- checkbox required -->
<script type="text/javascript">
$(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

      $("#status_guid").attr('required', true);
      $("#departmentid").attr('required', false);
      $("#assignto").attr('required', false);
      $("#deletetask").attr('required', false);
      $("#status_guid").attr('name', 'status_guid');
      $("#departmentid").attr('name', true);
      $("#assignto").attr('name', true);
      $("#deletetask").attr('name', true);

    });

    $('#assign').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

      $("#status_guid").attr('required', false);
      $("#departmentid").attr('required', false);
      $("#departmentid").attr('name', true);
      $("#status_guid").attr('name', true);
      $("#assignto").attr('required', true);
      $("#assignto").attr('name', 'assignto');
      $("#deletetask").attr('required', false);
      $("#deletetask").attr('name', true);

    });


    $('#tickets-transfer').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

      $("#status_guid").attr('required', false);
      $("#assignto").attr('required', false);
      $("#departmentid").attr('required', true);
      $("#deletetask").attr('required', false);
      $("#status_guid").attr('name', true);
      $("#departmentid").attr('name', 'departmentid');
      $("#assignto").attr('name', true);
      $("#deletetask").attr('name', true);

    });

    $('#tickets-delete').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

      $("#status_guid").attr('required', false);
      $("#assignto").attr('required', false);
      $("#departmentid").attr('required', false);
      $("#deletetask").attr('required', true);
      $("#status_guid").attr('name', true);
      $("#departmentid").attr('name', true);
      $("#assignto").attr('name', true);
      $("#deletetask").attr('name', 'delete');

    });
});

</script>

<script type="text/javascript">
function formatBytes(a,b){
    if(0==a) return "0 Bytes";
    var c=1024,
        d=b||2,
        e=["Bytes","kB","MB","GB","TB","PB","EB","ZB","YB"],
        f=Math.floor(Math.log(a)/Math.log(c));
    return parseFloat((a/Math.pow(c,f)).toFixed(d))+" "+e[f];
}

$(document).on('change', '.file', function(){
    if(this.files.length><?php echo $max_files;?>)
    {
        alert('Maximum <?php echo $max_files;?> upload files allowed. ');
        $(".file").val(null);
    }

    files = this.files;
    max_file_size = formatBytes(<?php echo $max_file_size;?>);
    for(i=0;i<files.length;i++)
    {
        if(files[i].size > <?php echo $max_file_size;?>)
        {   
            alert('File(s) uploaded exceeds maximum file size ('+ max_file_size +') allowed.');
            $(".file").val(null);
        }
    }
});
</script>

<script type="text/javascript">
  
                  $(".action-button").click(function(){

                  var check = [];

                  $.each($(".ckb:checked"), function(){        

                  check.push($(this).val());

                  /*+ check.join(", ")*/
                  });
                       

                        $.ajax({
                          url : "<?php echo site_url('staff_task_controller/selected_tasks_ajax?task_guid_string='); ?>" + check,
                          success : function(result){
                            
                          result = JSON.parse(result);

                          html = "";
                          for(i = 0; i < result.length; i++)
                          {
                            //console.log(result[i].invoice_number);
                            
                            html += "<span style='margin: 2px;'><b> #"+ result[i] +"</b></span>";
                            

                            
                          }

                          $('.popup_selected_task').html(html);
                          }
                        });
                    });


                  


</script>

<!-- <script type="text/javascript" src="/helpdesk/js/jquery.pjax.js?9ae093d"></script> -->
<script type="text/javascript" src="/helpdesk/scp/js/bootstrap-typeahead.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/scp.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/jquery-ui-1.10.3.custom.min.js?9ae093d"></script>
<!-- <script type="text/javascript" src="/helpdesk/js/filedrop.field.js?9ae093d"></script> -->
<script type="text/javascript" src="/helpdesk/js/select2.min.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/tips.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor.min.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor-osticket.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/redactor-plugins.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/scp/js/jquery.translatable.js?9ae093d"></script>
<!-- <script type="text/javascript" src="/helpdesk/scp/js/jquery.dropdown.js?9ae093d"></script> -->
<script type="text/javascript" src="/helpdesk/scp/js/bootstrap-tooltip.js?9ae093d"></script>
<script type="text/javascript" src="/helpdesk/js/fabric.min.js?9ae093d"></script>
<link type="text/css" rel="stylesheet" href="/helpdesk/scp/css/tooltip.css?9ae093d">
<script type="text/javascript">
    getConfig().resolve({"lock_time":3600,"html_thread":true,"date_format":"Y-MM-dd","lang":"en_US","short_lang":"en","has_rtl":false,"lang_flag":"us","primary_lang_flag":"us","primary_language":"en-US","secondary_languages":[],"page_size":25});
</script>


<ul class="typeahead dropdown-menu" style="display: none;"></ul><div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-html" style="display: none;">HTML</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-formatting" style="display: none;">Formatting</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-bold" style="display: none;">Bold</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-italic" style="display: none;">Italic</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-underline" style="display: none;">Underline</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-deleted" style="display: none;">Deleted</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-unorderedlist" style="display: none;">• Unordered List</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-orderedlist" style="display: none;">1. Ordered List</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-outdent" style="display: none;">&lt; Outdent</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-indent" style="display: none;">&gt; Indent</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-image" style="display: none;">Insert Image</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-link" style="display: none;">Link</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-alignment" style="display: none;">Alignment</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-horizontalrule" style="display: none;">Insert Horizontal Rule</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-table" style="display: none;">Table</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-video" style="display: none;">Insert Video</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-fontcolor" style="display: none;">Font Color</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-backcolor" style="display: none;">Back Color</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-fontfamily" style="display: none;">Change Font Family</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-deleteDraft" style="display: none;">Delete Draft</span></body></html>