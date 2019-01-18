<div id="content">
    <div id="task_content">
<div>
    <div class="sticky placeholder"></div>
    <div class="sticky bar" style="top: -14.6293px;">
        <div class="content" style="width: 908px;">
            <div class="pull-left flush-left">
                <?php foreach ($task->result() as $taskinfo) { ?>
                <h2><a id="reload-task" href="<?php echo site_url('staff_task_controller/taskinfo');?>?id=<?php echo $taskinfo->task_guid;?>"><i class="icon-refresh"></i>&nbsp;Task #<?php echo $taskinfo->task_guid;?></a></h2>
            </div>
        <?php if ($editallow != 0 ) { ?>
            <div class="pull-right flush-right">
            
            <?php if ($deleteallow != 0 ) { ?>
            <span class="red button action-button pull-right" id="tickets-delete" data-placement="bottom" data-toggle="modal" data-target="#delete">
             <a class="tickets-action" id="tickets-delete" data-placement="bottom" data-toggle="tooltip" title="" href="#tickets/mass/delete" data-original-title="Delete"><i class="icon-trash"></i></a>
            </span>
            <?php } ?>
            
              
            <span id="task-edit" class="action-button pull-right" data-toggle="modal" data-target="#edit"><a data-placement="bottom" data-toggle="tooltip" title="" data-original-title="Edit"><i class="icon-edit"></i></a></span>
          
           <?php foreach ($task->result() as $value) { ?> 
                <a class="action-button pull-right" href="<?php echo site_url('staff_task_controller/printpreviewstafftask');?>?id=<?php echo $value->task_guid;?>" id="ticket-print"><i class="icon-print"></i></a>
            
            <?php } ?>
                        
            <span class="action-button" data-toggle="modal" data-target="#cstatus" id="checkBtn" title="Close Task">
    
                <a class="tickets-action" href="#statuses"><i class="icon-flag"></i></a>
            </span>

            <?php if ($assignallow != 0 ) { ?>
            <span class="action-button" id="assign" data-toggle="modal"  data-target="#claim" title=" Assign">
                <a class="tickets-action" id="tickets-assign" ><i class="icon-user"></i></a>
            </span>
            <?php } ?>

            <?php if ($transferallow != 0 ) { ?>
            <span class="action-button" id="tickets-transfer" data-placement="bottom" data-toggle="modal" data-target="#transfer">
             <a class="tickets-action"  title="" href="#tickets/mass/transfer" data-original-title="Transfer"><i class="icon-share"></i></a>
            </span>
            <?php } ?>

            <!-- <div id="action-dropdown-statuses" class="action-dropdown anchor-right" style="display: none;">
                <ul>
                    <li>
                        <a class="no-pjax ticket-action" href="#tickets/13/status/reopen/6"><i class="icon-undo"></i> In-Progress</a>
                    </li>
                        <li>
                        <a class="no-pjax ticket-action" href="#tickets/13/status/reopen/8"><i class="icon-undo"></i> Assigned to Staff</a>
                    </li>
                        <li>
                        <a class="no-pjax ticket-action" href="#tickets/13/status/reopen/9"><i class="icon-undo"></i> Assigned to Department</a>
                    </li>
                        <li>
                        <a class="no-pjax ticket-action" href="#tickets/13/status/reopen/2"><i class="icon-undo"></i> Resolved</a>
                    </li>
                        <li>
                        <a class="no-pjax ticket-action" href="#tickets/13/status/close/3" data-redirect="tickets.php"><i class="icon-ok-circle"></i> Closed</a>
                    </li>
                    </ul>
            </div> -->
                       </div>
            <?php } ?>

            <a class="only sticky scroll-up" href="#" data-stop="65"><i class="icon-chevron-up icon-large"></i></a>
        </div>
    </div>
</div>

<div class="clear tixTitle has_bottom_border">
    <h3><?php echo $taskinfo->title;?></h3>
</div>
    
    <div class="col-lg-6" style="overflow:auto;padding:0px;">
        <table class="ticket_info" border="0" cellspacing="" cellpadding="4" width="100%">
            <tbody>
                <tr>
                    <th width="140">Status</th>
                    <td>: <?php if ($taskinfo->task_status == '1')
                                { ?>
                                    <?php echo 'Open';?>
                                <?php }
                                else if ($taskinfo->task_status == '0')
                                { ?>
                                    <?php echo 'Completed';?>
                                <?php } else if ($taskinfo->task_status == '5')
                                { ?>
                                    <?php echo 'Deleted';?>
                           <?php } ?>
                    </td>
                </tr>

                <tr>
                    <th>Created</th>
                    <td>: <?php echo $taskinfo->task_created;?></td>
                </tr>
                            
                <tr>
                    <th>Due Date</th>
                    <td>: <?php echo $taskinfo->taskdue;?></span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-lg-6" style="overflow:auto;padding:0px;">
        <table class="ticket_info" cellspacing="0" cellpadding="4" width="100%" border="0">
            <tbody>
                <tr>
                    <th width="140">Department</th>
                    <td>: <?php echo $taskinfo->deptname;?></td>
                </tr>
                
                <tr>
                    <th>Assigned To</th>
                    <td><?php 
                        if ($taskinfo->taskstaff != '0')
                        { ?>
                          : <?php echo $taskinfo->firstname;?>
                            <?php echo $taskinfo->lastname;?>
                        <?php }

                        else if ($taskinfo->taskteam != '0')
                        { ?>
                          : <?php echo $taskinfo->teamname;?>
                        <?php }

                        else
                        { ?>
                          :
                        <?php }?>

                    </span></td>
                </tr>
                
                <tr>
                    <th>Ticket Number</th>
                    <td><a href="<?php echo site_url('staff_ticket_controller/ticketinfo');?>?id=<?php echo $taskinfo->ticket_guid;?>"> <span id="t22-collaborators">: <?php if ($taskinfo->number != "") {?>#<?php echo $taskinfo->number;?><?php }?></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php } ?>
    <br>
    <br>
    <br>
    <table class="ticket_info" cellspacing="0" cellpadding="0" width="100%" border="0">
        </table>
<div class="clear"></div>
<?php foreach ($taskthread->result() as $thread) { ?>
<div id="task_thread_container">
    <div id="task_thread_content">
    <div id="thread-22">
    <!-- <div id="thread-items" data-thread-id="22"> -->
    <div id="thread-entry-38">
    <div class="thread-entry <?php echo $thread->class;?> <?php echo $enable_avatars->row('value') == 1?"avatar":"";?>">
    <?php if ($enable_avatars->row('value') == 1) { ?>
    <span class="pull-<?php echo $thread->avatar;?> avatar">
    <img class="avatar" alt="Avatar" src="//www.gravatar.com/avatar/591979a746b57c8ed09bca89133daeff?s=80&amp;d=identicon"></span>
    <?php } ?>
    <div class="header">
        <div class="pull-right">
        <span class="muted-button pull-right" data-dropdown="#entry-action-more-38">
            <i class="icon-caret-down"></i>
        </span>
        <div id="entry-action-more-38" class="action-dropdown anchor-right" style="display: none;">
            <ul class="title">
                <li>
                    <a class="no-pjax" href="#" onclick="javascript:
                    var url = 'ajax.php/tickets/3/thread/38/edit';
                        $.dialog(url, [201], function(xhr, resp) {
                          var json = JSON.parse(resp);
                          if (!json || !json.thread_id)
                            return;
                          $('#thread-entry-'+json.thread_id)
                            .attr('id', 'thread-entry-' + json.new_id)
                            .html(json.entry)
                            .find('.thread-body')
                            .delay(500)
                            .effect('highlight');
                        }, {size:'large'});; return false;">
                    <i class="icon-pencil"></i> Edit</a></li>
            </ul>
        </div>
        <span class="textra light">
        </span>
        </div>

    <b>

        <?php if ($threadname->defaultname == 'mine') { ?>
        <b><?php echo $thread->poster;?></b> 
        <?php } else if ($threadname->defaultname == 'email') { ?>
        <b><?php echo $threadname->email;?></b> 
        <?php } else if ($threadname->defaultname == 'dept') { ?>
        <b><?php echo $threadname->name;?></b> 
        <?php } ?>
        

    </b> posted <?php echo $thread->created;?>
    <span style="max-width:400px" class="faded title truncate"></span>
    </div>
    <div class="thread-body no-pjax">
        <div><?php echo $thread->body;?></div>
        <div class="clear"></div>

    <?php 
        $file = $this->db->query("SELECT * FROM ost_file_test AS b
            INNER JOIN ost_thread_entry_test AS a
            ON a.thread_entry_guid = b.thread_entry_guid
            WHERE b.thread_entry_guid = '".$thread->thread_entry_guid."'");
    ?>

    <?php
        if ($file->num_rows() > 0)
        { ?>
            <div class="attachments">

            <?php foreach ($file->result() as $val) {
                $name = $val->name;
            ?>    
            
                <i class="icon-paperclip icon-flip-horizontal"></i>
                <a href="<?php echo base_url('uploads/').$name;?>" download="<?php echo $name;?>" ><?php echo $name;?></a>&nbsp;&nbsp;&nbsp;

            <?php } ?>
            </div>
    <?php } ?>
    </div>
    </div>
    </div><!-- <div class="thread-event action">
        <span class="type-icon">
          <i class="faded icon-magic"></i>
        </span>
        <span class="faded description">
            Created by <b><img class="avatar" alt="Avatar" src="//www.gravatar.com/avatar/591979a746b57c8ed09bca89133daeff?s=80&amp;d=identicon">Hugh Panda</b> <time datetime="2018-11-02T04:35:14+00:00" data-toggle="tooltip" title="" data-original-title=""></time>        </span>
    </div> -->
        <!-- </div> -->
    </div>

    <script type="text/javascript">
        $(function() {
            var container = 'thread-22';

            // Set inline image urls.
                    $('#'+container).data('imageUrls', []);
            // Trigger thread processing.
            if ($.thread)
                $.thread.onLoad(container,
                        {autoScroll: true});
        });
    </script>

    </div>
</div>
<?php } ?>
<div class="clear"></div>

<?php if ($replyallow != 0 ) { ?>

<div id="task_response_options" class=" sticky bar stop actions">
    <div class="tab">
        <ul class="tabs">
                        <li class="active"><a href="#task_reply">Post Update</a></li>
            <li class=""><a href="#task_note">Post Internal Note</a></li>
                    </ul>
    </div>
        <form id="task_reply" class="tab_content spellcheck save" action="<?php echo site_url('staff_task_controller/taskupdate')?>" name="task_reply" method="post" enctype="multipart/form-data" style="display: block;">
        <input type="hidden" name="__CSRFToken__" value="30378cf50306003f20b9a51a2d921cc70a65c01f">        <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
        <input type="hidden" name="a" value="postreply">
        <input type="hidden" name="lockCode" value="">
        <span class="error"></span>
        <table style="width:100%" border="0" cellspacing="0" cellpadding="3">
            <tbody id="update_sec">
            <tr>
                <td>
                    <div class="error"></div>
                        <div class="box">
                            <div class="box-header">
                                <!-- tools box -->
                                <div class="pull-right box-tools"></div>
                                <!-- /. tools -->
                            </div>

                            <!-- /.box-header -->
                            <div class="box-body pad">
                                <textarea required="true" name="response" id="task-response" class="textarea" placeholder="Start writing your message here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                        </div>

                        <div class="selected-signature" style="display: none;">
                            <div class="inner"></div>
                        </div>

                    <div id="task_response_form_attachments" class="attachments">
                    <div id="42939dad8a8973d77aa417" class="filedrop"><div class="files"></div>
                        <div class="dropzone" style="color: black;">
                            <input style="display:unset;border:0;padding:0;background-color:white;" type="file" name="file[]" id="file" class="file" multiple>
                        </div>
                    </div>
                    </div>

               </td>
            </tr>
            <tr>
                <td>
                    <div>Status
                        <span class="faded"> - </span>
                        <select name="task_status">
                            <option value="1"> Open</option>
                            <option value="0"> Closed</option>
                        </select>
                        &nbsp;<span class="error"></span>
                    </div>
                </td>
            </tr>
        </tbody></table>

       <p style="text-align:center;">
           <input class="save pending" type="submit" name="submit" value="Post Update">
           <input type="reset" value="Reset">
       </p>

    <input type="hidden" name="draft_id"></form>
        <form id="task_note" action="<?php echo site_url('staff_task_controller/tasknote')?>" class="tab_content spellcheck save hiddens" name="task_note" method="post" enctype="multipart/form-data" style="display: none;">

            <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">

            <table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tbody>
                    <tr>
                        <td>
                            <div><span class="error"></span></div>
                            <div class="box">
                            <div class="box-header">

                              <!-- tools box -->
                              <div class="pull-right box-tools">

                              </div>
                              <!-- /. tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body pad">
                                
                                <textarea name="note" id="task-note" class="textarea" placeholder="Start writing your note here"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                
                              
                            </div>
                            </div>
                            <div class="attachments">
                                <div id="158f2e4e94aadcd4807c3a" class="filedrop">
                                    <div class="files"></div>
                                    <div class="dropzone" style="color: black;">
                                        <input style="display:unset;border:0;padding:0;background-color:white;" type="file" name="file[]" id="file" class="file" multiple>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                
                    <tr>
                        <td>
                            <div>Status
                                <span class="faded"> - </span>
                                <select name="taskstatus">
                                    <option value="1"> Open</option>
                                    <option value="0"> Closed</option>
                                </select>
                                &nbsp;<span class="error"></span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p style="text-align:center;">
                <input class="save pending" type="submit" name="submit" value="Post Note">
                <input type="reset" value="Reset">
            </p>

            <input type="hidden" name="draft_id">
        </form>
 </div>

<?php } ?>

        <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css">
<script type="text/javascript">
$(function() {
    $(document).off('.tasks-content');
    $(document).on('click.tasks-content', '#all-ticket-tasks', function(e) {
        e.preventDefault();
        $('div#task_content').hide().empty();
        $('div#tasks_content').show();
        return false;
     });

    $(document).off('.task-action');
    $(document).on('click.task-action', 'a.task-action', function(e) {
        e.preventDefault();
        var url = 'ajax.php/'
        +$(this).attr('href').substr(1)
        +'?_uid='+new Date().getTime();
        var $options = $(this).data('dialogConfig');
        var $redirect = $(this).data('redirect');
        $.dialog(url, [201], function (xhr) {
            if (!!$redirect)
                window.location.href = $redirect;
            else
                $.pjax.reload('#pjax-container');
        }, $options);

        return false;
    });

    $(document).off('.tf');
    $(document).on('submit.tf', '.ticket_task_actions form', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $container = $('div#task_content');
        $.ajax({
            type:  $form.attr('method'),
            url: 'ajax.php/'+$form.attr('action').substr(1),
            data: $form.serialize(),
            cache: false,
            success: function(resp, status, xhr) {
                $container.html(resp);
                $('#msg_notice, #msg_error',$container)
                .delay(5000)
                .slideUp();
            }
        })
        .done(function() { })
        .fail(function() { });
     });
    });
</script>
</div>
</div>
</div>
    <div id="footer" style="margin-bottom:10px;">
        Copyright © 2006-2018&nbsp;Panda Ticketing System&nbsp;All Rights Reserved.
    </div>
    <div>
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
        <img src="/helpdesk/scp/autocron.php" alt="" width="1" height="1" border="0">
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
    </div>
</div>
<div id="loading" style="top: 219px; left: 524.5px;">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>
<div class="container dialog draggable ui-draggable" style="display: none; top: 54.75px; left: 374.5px;" id="popup">
    <div id="popup-loading">
        <h1 style="margin-bottom: 20px;"><i class="icon-spinner icon-spin icon-large"></i>
        Loading ...</h1>
    </div>
    <div class="body"></div>
</div>
<div style="display: none; top: 54.75px; left: 618.5px;" class="dialog" id="alert">
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

<form action="<?php echo site_url('staff_task_controller/taskinfoupdate?id=').$_REQUEST['id']?>" method="POST" name="tickets" id="tickets">

<?php if($taskstatus == 1 ) {?>
  <!-- close task status popup modal -->
<div class="modal fade" id="cstatus" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <?php foreach ($task->result() as $number) { ?>
                <h3 class="drag-handle">Close Task #<?php echo $number->task_guid?></h3>
                <?php }?>
              </div>

              <div class="modal-body">

                <div id="ticket-status" style="display:block; margin:5px;">

                <p id="msg_warning">Are you sure you want to close this task?</p>

                <table width="100%">

                <input type="hidden" name="status_guid" id="status_guid" value="0">
                <tbody>
                
                <tr>
                    <td colspan="2">
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
                        <input type="submit" value="Submit">
                    </span>
                </p>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
  </div>
  <!-- close task status popup modal -->
<?php } else if ($taskstatus == 0){ ?>

  <!-- reopen task status popup modal -->
<div class="modal fade" id="cstatus" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <?php foreach ($task->result() as $number) { ?>
                <h3 class="drag-handle">Reopen Task #<?php echo $number->task_guid?></h3>
                <?php }?>
              </div>

              <div class="modal-body">

                <div id="ticket-status" style="display:block; margin:5px;">

                <p id="msg_warning">Are you sure you want to reopen this task?</p>

                <table width="100%">

                <input type="hidden" name="status_guid" id="status_guid" value="1">
                <tbody>
                
                <tr>
                    <td colspan="2">
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
                        <input type="submit" value="Submit">
                    </span>
                </p>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
  </div>
  <!-- reopen task status popup modal -->
<?php } ?>

    <!-- assigned ticket  popup modal -->
<div class="modal fade" id="claim" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <?php foreach ($task->result() as $number) { ?>
                <h3 class="drag-handle">Task #<?php echo $number->task_guid?>: Assign to Agent/Team</h3>
                <?php }?>
            </div>

            <div class="modal-body">
                <div style="display:block; margin:5px;">
                    <table width="100%">
                    <tbody>
                    <tr>
                        <td colspan="2">
                            <div class="form-simple">
                                <div class="flush-left custom-field" id="field_da489cda559d4795">
                                    <div>
                                        <div class="field-label required">
                                            <label for="da489cda559d4795">
                                            Assignee: <span class="error">*</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div>
                                        <select class="form-control" name="assignto" id="assignto" data-placeholder="Select an Agent">
                                            <option value="">— Select an Agent —</option>
                                            <optgroup label="Agents (<?php echo $staff->num_rows()?>)">
                                            <?php foreach ($staff->result() as $staff) { ?>
                                                <option value="a<?php echo $staff->staff_guid;?>" <?php echo $staff->staff_guid == $task->row('staff_guid')?"selected":"";?>><?php echo $staff->firstname;?> <?php echo $staff->lastname;?></option>
                                            <?php } ?> 
                                            </optgroup>    
                                            <optgroup label="Team (<?php echo $team->num_rows()?>)">         
                                            <?php foreach ($team->result() as $team) { ?>
                                                <option value="t<?php echo $team->team_guid;?>" <?php echo $team->team_guid == $task->row('team_guid')?"selected":"";?>><?php echo $team->name;?></option>
                                            <?php } ?> 
                                            </optgroup>  
                                        </select>
                                  </div>
                                </div>

                                <div class="flush-left custom-field" id="field_d8bf82dc954436ab">
                                    <div>
                                        <span style="display:inline-block;width:100%">
                                        <textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for the assignment" id="_d8bf82dc954436ab" name="assignnote"></textarea>
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
                        <input type="submit" value="Assign">
                    </span>
                </p>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
  <!-- assgined ticket popup modal -->

  <!-- assigned ticket to department popup modal -->
<div class="modal fade" id="transfer" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <?php foreach ($task->result() as $number) { ?>
                <h3 class="drag-handle">Task #<?php echo $number->task_guid?>: Transfer</h3>
                <?php }?>
              </div>
              <div class="modal-body">

                <div style="display:block; margin:5px;">

              <table width="100%">
                <tbody>
            <tr><td colspan="2">
             <div class="form-simple">
            <div class="flush-left custom-field" id="field_b7a7b14540f04e3c">
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
                    <option value="<?php echo $department->department_guid;?>" <?php echo $department->department_guid == $task->row('taskdept')?"selected":""; ?>><?php echo $department->name;?></option>
                  <?php } ?>
                </select>
                </div>
                </div>
            <div class="flush-left custom-field" id="field_e8f5989ca9fa6fe1">
          <div>
                    </div><div>
                  <span style="display:inline-block;width:100%">
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
                        <input id="opennn" type="submit" value="Transfer">
                    </span>
               </p>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
  <!-- assigned ticket to department popup modal -->

      <!-- edit ticket to department popup modal -->
<div class="modal fade" id="edit" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
                <?php foreach ($task->result() as $number) { ?>
                    <h3 class="drag-handle">Edit Task #<?php echo $number->task_guid;?></h3>
                <?php }?>
            </div>

            <div class="modal-body">
                <div id="edit-task-form" style="display:block;">
                    <div>
                        <table class="grid form">
                            <tbody>
                                <tr>
                                    <td class="cell" colspan="12" rowspan="1" style="" data-field-id="32">
                                        <fieldset class="field " id="field_aa40a6a42658188c" data-field-id="32">
                                            <label class="required" for="_aa40a6a42658188c">
                                                Title:
                                                <span class="error">*</span>
                                            </label>

                                            <?php foreach ($task->result() as $value) { ?> 
                                            <input type="text" class="form-control" id="ctitle" size="40" maxlength="50" placeholder="" name="ctitle" value="<?php echo $value->title ?>" required>
                                                <?php } ?> 
                                        </fieldset>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="cell" colspan="12" rowspan="1" style="" data-field-id="32">
                                        <fieldset class="field " id="field_aa40a6a42658188c" data-field-id="32">
                                            <div><strong>Internal Note</strong>:
                                                <font class="error">&nbsp;</font></div>
                                                <div>
                                                    <textarea class="form-control" rows="4" cols="40" placeholder="Reason for editing the task (optional)" id="_e8f5989ca9fa6fe1" name="editnote"></textarea>
                                                    </div>
                                                </div>
                                        </fieldset>
                                    </td>
                                </tr>
                            </tbody>
                        </table>    
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <p class="full-width">
                <span class="buttons pull-left">
                    <input type="button" data-dismiss="modal" value ="Cancel">
                    <input type="reset" value="Reset">
                </span>

                <span class="buttons pull-right">
                    <input type="submit" value="Update">
                </span>
                </p>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
  <!-- edit ticket to department popup modal -->

    <!-- delete ticket to department popup modal -->
<div class="modal fade" id="delete" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <?php foreach ($task->result() as $number) { ?>
                    <h3 class="drag-handle">Task #<?php echo $number->task_guid?>: Delete</h3>
                <?php }?>
              </div>
              <div class="modal-body">

                <p id="msg_warning">Are you sure you want to DELETE this task?</p>

                <div style="display:block; margin:5px;">
                <form class="mass-action" method="post" name="delete" id="delete" action="#tickets/mass/delete">
                    <table width="100%">
                                <tbody>
                            <tr><td colspan="2"><strong><strong>Deleted task CANNOT be recovered, including any associated attachments.</strong></strong></td> </tr>
                        </tbody>
                                <tbody>
                            <tr>
                                <td colspan="2">
                                  <br><textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for deleting selected task" id="_e8f5989ca9fa6fe1" name="deletenote"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                </div>

              </div>
              <div class="modal-footer">

                    <span class="buttons pull-left">
                        <input type="button" data-dismiss="modal" value ="Cancel">
                        <input type="reset" value="Reset">
                    </span>
                    <span class="buttons pull-right">
                        <input id="opennn" type="submit" value="Delete">
                    </span>

                    <select name="delete" hidden="true" id="delete" >
                        <option value="5"></option>
                    </select>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
  <!-- delete ticket to department popup modal -->
</form>

<script type="text/javascript">
$(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;


      $("#status_guid").attr('required', true);
      $("#departmentid").attr('required', false);
      $("#assignto").attr('required', false);
      $("#status_guid").attr('name', 'status_guid');
      $("#departmentid").attr('name', true);
      $("#assignto").attr('name', true);
      $("#delete").attr('name', true);
      $("#delete").attr('required', false);
      $("#ctitle").attr('name', true);
      $("#ctitle").attr('required', false);

    });

    $('#assign').click(function() {
      checked = $("input[type=checkbox]:checked").length;


      $("#status_guid").attr('required', false);
      $("#departmentid").attr('required', false);
      $("#departmentid").attr('name', true);
      $("#status_guid").attr('name', true);
      $("#assignto").attr('required', true);
      $("#assignto").attr('name', 'assignto');
      $("#delete").attr('name', true);
      $("#delete").attr('required', false);
      $("#ctitle").attr('name', true);
      $("#ctitle").attr('required', false);

    });


    $('#tickets-transfer').click(function() {
      checked = $("input[type=checkbox]:checked").length;


      $("#status_guid").attr('required', false);
      $("#assignto").attr('required', false);
      $("#departmentid").attr('required', true);
      $("#status_guid").attr('name', true);
      $("#departmentid").attr('name', 'departmentid');
      $("#assignto").attr('name', true);
      $("#delete").attr('name', true);
      $("#delete").attr('required', false);
      $("#ctitle").attr('name', true);
      $("#ctitle").attr('required', false);

    });

    $('#tickets-delete').click(function() {
      checked = $("input[type=checkbox]:checked").length;


      $("#status_guid").attr('required', false);
      $("#assignto").attr('required', false);
      $("#departmentid").attr('required', false);
      $("#status_guid").attr('name', true);
      $("#departmentid").attr('name', true);
      $("#assignto").attr('name', true);
      $("#delete").attr('name', 'delete');
      $("#delete").attr('required', false);
      $("#ctitle").attr('name', true);
      $("#ctitle").attr('required', false);

    });

        $('#task-edit').click(function() {
      checked = $("input[type=checkbox]:checked").length;


      $("#status_guid").attr('required', false);
      $("#assignto").attr('required', false);
      $("#departmentid").attr('required', false);
      $("#status_guid").attr('name', true);
      $("#departmentid").attr('name', true);
      $("#assignto").attr('name', true);
      $("#delete").attr('name', true);
      $("#delete").attr('required', false);
      $("#ctitle").attr('name', 'ctitle');
      $("#ctitle").attr('required', true);
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


<span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-html" style="display: none;">HTML</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-formatting" style="display: none;">Formatting</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-bold" style="display: none;">Bold</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-italic" style="display: none;">Italic</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-underline" style="display: none;">Underline</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-deleted" style="display: none;">Deleted</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-unorderedlist" style="display: none;">• Unordered List</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-orderedlist" style="display: none;">1. Ordered List</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-outdent" style="display: none;">&lt; Outdent</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-indent" style="display: none;">&gt; Indent</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-image" style="display: none;">Insert Image</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-link" style="display: none;">Link</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-alignment" style="display: none;">Alignment</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-horizontalrule" style="display: none;">Insert Horizontal Rule</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-table" style="display: none;">Table</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-video" style="display: none;">Insert Video</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-fontcolor" style="display: none;">Font Color</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-backcolor" style="display: none;">Back Color</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-fontfamily" style="display: none;">Change Font Family</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-deleteDraft" style="display: none;">Delete Draft</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-html" style="display: none;">HTML</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-formatting" style="display: none;">Formatting</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-bold" style="display: none;">Bold</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-italic" style="display: none;">Italic</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-underline" style="display: none;">Underline</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-deleted" style="display: none;">Deleted</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-unorderedlist" style="display: none;">• Unordered List</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-orderedlist" style="display: none;">1. Ordered List</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-outdent" style="display: none;">&lt; Outdent</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-indent" style="display: none;">&gt; Indent</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-image" style="display: none;">Insert Image</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-link" style="display: none;">Link</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-alignment" style="display: none;">Alignment</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-horizontalrule" style="display: none;">Insert Horizontal Rule</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-table" style="display: none;">Table</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-video" style="display: none;">Insert Video</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-fontcolor" style="display: none;">Font Color</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-backcolor" style="display: none;">Back Color</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-fontfamily" style="display: none;">Change Font Family</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-1 redactor-toolbar-tooltip-deleteDraft" style="display: none;">Delete Draft</span></body></html>