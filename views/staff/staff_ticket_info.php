<div id="content">
        <style>
.form-group{
    margin-bottom:0px;
    overflow:auto;
}
</style>

<div>
    <div class="sticky placeholder"></div><div class="sticky bar" style="top: 0px;">
       <div class="content" style="width: 908px;">
        <?php
        if ($editallow != 0 ) { ?>
        <div class="pull-right flush-right">
            
            <span class="action-button pull-right" data-placement="bottom" data-dropdown="#action-dropdown-more" data-toggle="tooltip" title="" data-original-title="More">
                <i class="icon-caret-down pull-right"></i>
                <span><i class="icon-cog"></i></span>
            </span>

            <div id="action-dropdown-more" class="action-dropdown anchor-right" style="left: 988.859px; top: 166px; display: hide;">
                <ul>
                    <li><a class="change-user" data-toggle="modal" data-target="#changeowner"><i class="icon-user"></i> Change Owner</a></li>
                
                    <?php if ($deleteallow != 0 ) { ?>
                    <li class="danger"><a class="ticket-action" id="tickets-delete" data-toggle="modal" data-target="#delete"><i class="icon-trash"></i> Delete Ticket</a></li>
                    <?php } ?>

                </ul>
            </div>
            
            <?php foreach ($result->result() as $value) { ?>         
            <span class="action-button pull-right" title="Edit"><a data-placement="bottom" data-toggle="tooltip" href="<?php echo site_url('staff_ticket_controller/ticketinfoedit');?>?id=<?php echo $value->ticket_guid;?>&uid=" ><i class="icon-edit"></i></a></span>
           
            <a class="action-button pull-right" href="<?php echo site_url('staff_ticket_controller/printpreviewstaff');?>?id=<?php echo $value->ticket_guid;?>" id="ticket-print" href="tickets.php?id=13&amp;a=print" title="Print"><i class="icon-print"></i></a>
    <?php } ?>

                        
<span class="action-button" data-toggle="modal" data-target="#cstatus" id="checkBtn" title="Change Status">
    <a class="tickets-action" href="#statuses"><i class="icon-flag"></i></a>
</span>

<?php if ($assignallow != 0 ) { ?>
<span class="action-button" id="assign" data-toggle="modal"  data-target="#claim" title=" Assign">
    <a class="tickets-action" id="tickets-assign" ><i class="icon-user"></i></a>
</span>
<?php } ?> 


<?php if ($transferallow != 0 ) { ?>
    <span class="action-button" id="tickets-transfer" data-placement="bottom" data-toggle="modal" data-target="#transfer" title="Transfer">
 <a class="tickets-action"  title="" href="#tickets/mass/transfer" data-original-title="Transfer"><i class="icon-share"></i></a>
</span>
<?php } ?> 


           </div>
<?php } ?>

        <div class="flush-left">
             <h2><a onclick="myFunction()" title="Reload"><i class="icon-refresh"></i>
             Ticket #<?php foreach ($result->result() as $value) { ?><?php echo $value->number;?><?php } ?></a>
            </h2>
        </div>

<script>
function myFunction() {
    location.reload();
}
</script>

    <a class="only sticky scroll-up" href="#" data-stop="65"><i class="icon-chevron-up icon-large"></i></a></div>
  </div>
</div>
<div class="clear tixTitle has_bottom_border">
    <h3>
    <?php foreach ($result->result() as $value) { ?>

        <?php echo $value->value;?>   </h3>
</div>
<div class="col-lg-6" style="padding:0px;">
    <table class="ticket_info" width="100%">
        <tbody>

            <tr>
            <th width="147">Status</th>
            <td>:<b> <?php echo $value->name;?></b></td>
        </tr>
        <tr>
            <th>Priority</th>
            <td>: <?php echo $value->priority_desc;?></td>
        </tr>
        <tr>
            <th>Department</th>
            <td>: <?php echo $value->department;?></td>
        </tr>
        <tr>
                <th width="147">Assigned To</th>
                <td>: 
                    <?php if (empty($value->ticket_team_guid) && !empty($value->assigned_to)) { ?>
                        <?php echo $this->db->query("SELECT firstname FROM ost_staff_test AS a
                            INNER JOIN ost_ticket_test AS b ON b.assigned_to = a.staff_guid
                            WHERE b.ticket_guid = '".$value->ticket_guid."'")->row('firstname');?> 
                        <?php echo $this->db->query("SELECT lastname FROM ost_staff_test AS a
                            INNER JOIN ost_ticket_test AS b ON b.assigned_to = a.staff_guid
                            WHERE b.ticket_guid = '".$value->ticket_guid."'")->row('lastname');?>
                    <?php } else if (empty($value->assigned_to) && !empty($value->ticket_team_guid)) { ?>
                        <?php echo $this->db->query("SELECT name FROM ost_team_test AS a
                            INNER JOIN ost_ticket_test AS b ON b.team_guid = a.team_guid
                            WHERE b.ticket_guid = '".$value->ticket_guid."'")->row('name');?>
                    <?php } else { ?>
                        <?php echo '-unassigned-' ?>
                    <?php } ?>
                </td>
            </tr>

            <tr>
                <th width="147">Help Topic</th>
                <td>: <?php foreach ($result->result() as $value) { ?><?php echo $value->topic;?><?php } ?> </td>
            </tr>
            
            <tr>
                <th>SLA Plan</th>
                <td>: <?php echo $this->db->query("SELECT sla_name FROM ost_sla_test AS a
                    INNER JOIN ost_ticket_test AS b ON b.sla_guid = a.sla_guid
                    WHERE b.ticket_guid = '".$value->ticket_guid."'")->row('sla_name');?></td>
            </tr>
            
<?php } ?>
    </tbody>
</table>
</div>
<div class="col-lg-6" style="padding:0px;">
    <table class="ticket_info" width="100%">
        <tbody>

<?php foreach ($user->result() as $value1) { ?>
            <tr>
            <th width="147">User</th>
            <td>: <a class="ticket-action" data-toggle="modal" data-target="#userinfo">
                <i class="icon-user"></i>
                <span id="user-3-name"><?php echo $value1->user_name;?></span></a>
            </td>
        </tr>
        
        <tr>
            <th>Email</th>
            <td>
                : <span id="user-3-email"><?php echo $value1->user_email;?></span>
            </td>
        </tr>
         <tr>
            <th>Organization</th>
            <td>
                : <?php if ($user->row('user_org_guid') != "") {?><i class="icon-building"></i><span id="user-3-email"> <?php echo $value1->name;?></span><?php }?>
            </td>
        </tr>
        <?php }?>
        <?php foreach ($result->result() as $value2) { ?>
        <tr>
            <th>Contact Name</th>
            <td>: <span ><?php echo $value2->contact;?></span>            </td>
        </tr>
        <tr>
            <th>Contact Phone No.</th>
            <td>: <span ><?php echo $value2->phone_no;?></span>            </td>
        </tr>
        <tr>
            <th>Source</th>
            <td>: <?php echo $value2->source;?>&nbsp;&nbsp; <span class="faded">(<?php echo $value2->ipadd;?>)</span>            </td>
        </tr>
        <?php }?>
    </tbody></table>
</div>
<div class="col-lg-12" style="padding:10px;"></div>
<?php foreach ($result->result() as $value) { ?>

<div class="col-lg-6" style="padding:0px">
    <table class="ticket_info" width="100%">
        <tbody>
        <tr>
            <th>Create Date</th>
            <td>: <?php echo $value->created_at;?></td>
        </tr>
        <tr>
            <th nowrap="">Last Updated</th>
            <td>: <?php echo $value->ticket_updated;?></td>
        </tr>
        <tr>
                <th>Due Date</th>
                <td>: <?php if ($value->duedate != '') {
                    echo $value->duedate;
                }  else { echo 'Not Mention'; }?></td>
            </tr>
    </tbody></table>
</div>
<?php } ?>
<br>
<div class="clear"></div>

<div class="tab">
    <ul class="tabs clean threads" id="ticket_tabs">
        <li class="active"><a id="ticket-thread-tab" href="#ticket_thread">Ticket Thread (<?php echo $thread_num->num_rows();?>)</a></li>
        <li><a id="ticket-tasks-tab" href="#tasks" data-url="#tickets/13/tasks">Task (<?php echo $task->num_rows();?>)</a></li>
    </ul>
</div>

<div id="ticket_tabs_container">
    <div id="ticket_thread" class="tab_content">
        <div id="ticketThread">
        <?php foreach ($thread->result() as $value1) { ?>
            <?php if ($value1->type == 'E') { ?>
                <div class="thread-event action">
                    <span class="type-icon">
                        <i class="faded icon-<?php echo $value1->class;?> "></i>
                    </span>
                    <span class="faded description">
                        <?php echo $value1->body;?> 
                    </span>
                </div>
            <?php }  else { ?>
                <div id="thread-entry">
                    <div class="thread-entry <?php echo $value1->class;?> <?php echo $enable_avatars->row('value') == 1?"avatar":"";?>">
                        <?php if ($enable_avatars->row('value') == 1) { ?>
                            <span class="pull-<?php echo $value1->avatar;?>  avatar">
                                <img class="avatar" alt="Avatar" src="//www.gravatar.com/avatar/591979a746b57c8ed09bca89133daeff?s=80&amp;d=mm">
                            </span>
                        <?php } ?>
                        <div class="header">
                            <div class="pull-right">
                                <span class="muted-button pull-right" data-dropdown="#entry-action-more-<?php echo $value1->thread_entry_guid?>">
                                    <i class="icon-caret-down"></i>
                                </span>
                                <div id="entry-action-more-<?php echo $value1->thread_entry_guid?>" class="action-dropdown anchor-right" style="left: 683.25px; top: 32px; display: none;">
                                    <ul class="title">
                                        <li>
                                            <a id="edit" class="open-edit confirm" data-guid="<?php echo $value1->thread_entry_guid?>" data-body1="<?php echo $value1->body?>" data-toggle="modal" data-target="#more-modal" href="#"><i class="icon-pencil"></i> Edit</a>
                                        </li>
                                        <?php if($value1->editor != ''){ ?>
                                        <li>
                                            <a id="view" class="confirm" data-toggle="modal" data-target="#viewh" href="#"><i class="icon-copy"></i> View History</a>
                                        </li>
                                    <?php } ?>
                                    </ul>
                                </div>
                                <span class="textra light">
                                    <?php if($value1->editor != ''){ ?>
                                    <span class="label label-bare">Edited</span>
                                    <?php } ?>
                                </span>
                            </div>

        <script type="text/javascript">
            $(document).on("click", ".open-edit", function () {
                 $(".modal-body #threadguid").val($(this).data('guid'));
                 $("#threadbody").summernote("code", $(this).data('body1'));
            });

             
        </script>

        <div class="modal fade" id="more-modal" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3>Edit Thread Entry </h3>
              </div>
              <div class="modal-body">
                <form method="post" action="<?php echo site_url('staff_ticket_controller/editorupdate')?>">
               <div class="box">
                            <div class="box-header">
                                <!-- tools box -->
                                <div class="pull-right box-tools"></div>
                            <!-- /. tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body pad">
                                <input  type="hidden" value="" id="threadguid" name="threadguid">
                                <textarea class="textarea" id="threadbody" name="threadbody" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                        </div>
              </div>
              
              <div class="modal-footer">
              <p class="full-width">
                <span class="buttons pull-right">
                    <input type="submit" value="Save" class="confirm">
                </span>
                </form>
              </p>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="viewh" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3>Original Thread Entry</h3>
              </div>
              <div class="modal-body">
                <div class="accordian">
                    <dt class="active">
                    <i class ="icon-copy"></i>
                    <?php $editor = $this->db->query("SELECT editor FROM ost_thread_entry_test WHERE thread_entry_guid = '$value1->thread_entry_guid'")->row('editor');
                    echo '<em>Edited by '.$editor.'</em>';
                    ?>
                    </dt>
                    <dd style="background-color: transparent;">
                        <div class="title truncate" style="background-color: transparent;min-height: 50px;font-size: 1.5em;"><?php echo $value1->last_body?></div>
                    </dd>
                </div>
              </div>
              <div class="modal-footer">
              <p class="full-width">
                <span class="buttons pull-right">
                    <input type="button" value="Done" class="close">
                </span>
              </p>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

                            <?php if ($value1->staff_guid == '0') { ?>
                                <b><?php echo $value1->poster;?></b>
                            <?php } else if ($value1->user_guid == '0') { ?>
                                <?php if ($threadname->defaultname == 'mine') { ?>
                                    <b><?php echo $value1->poster;?></b> 
                                <?php } else if ($threadname->defaultname == 'email') { ?>
                                    <b><?php echo $threadname->email;?></b> 
                                <?php } else if ($threadname->defaultname == 'dept') { ?>
                                    <b><?php echo $threadname->name;?></b> 
                                <?php } ?>
                            <?php } ?>
                            posted <time><?php echo $value1->created;?></time> 
                            <span style="max-width:400px" class="faded title truncate"></span>
                        </div>

                        <div class="thread-body no-pjax" style="">
                            <div><?php echo $value1->body;?><br><br> </div>
                            <div class="clear"></div>
                            <?php 
                                $file = $this->db->query("SELECT * FROM ost_file_test AS b
                                    INNER JOIN ost_thread_entry_test AS a
                                    ON a.thread_entry_guid = b.thread_entry_guid
                                    WHERE b.thread_entry_guid = '".$value1->thread_entry_guid."'");
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
                </div>
            <?php } ?>
        <?php } ?>
        </div>

        <script type="text/javascript">
            $(function() {
                var container = 'ticketThread';

                // Set inline image urls.
                    $('#'+container).data('imageUrls', []);
                // Trigger thread processing.
                if ($.thread)
                    $.thread.onLoad(container, {autoScroll: true});
            });
        </script>
        <div class="clear"></div>

        <?php if($openclose->status_guid != '3' ) { ?>
            <?php if ($replyallow != 0 ) { ?>
                <!-- sticky bar stop actions -->
                <div class="sticky bar stop actions" id="response_options">
                    <div class="tab_1">
                        <ul class="tabs_1" id="response-tabs">
                            <li class="active ">
                                <a href="#reply" id="post-reply-tab">Post Reply</a>
                            </li>
                            <li>
                                <a href="#note" id="post-note-tab">Post Internal Note</a>
                            </li>
                        </ul>
                    </div>

                    <form id="reply" class="tab_content_1 spellcheck exclusive save" data-lock-object-id="ticket/13" data-lock-id="" action="<?php echo site_url('staff_ticket_controller/staffupdate')?>?id=<?php echo $_REQUEST['id'];?>" name="reply" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">To</label>
                            <div class="col-sm-10">
                                <select id="emailreply" name="emailreply" class="form-control">
                                    <option value="1" selected="selected"></option>
                                    <option value="0">— Do Not Email Reply —</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Response</label>
                            <div class="col-sm-10">
                                <select id="cannedResp" name="cannedResp" class="form-control">
                                    <option value="0" selected="selected">Select a canned response</option>
                                    <option value="original">Original Message</option>
                                    <option value="lastmessage">Last Message</option>
                                    <option value="0" disabled="disabled">------------- Premade Replies ------------- </option>
                                    <option value="2">Sample (with variables)</option>
                                    <option value="1">What is osTicket (sample)?</option>
                                </select>
                                <div class="box">
                                    <div class="box-header">
                                        <!-- tools box -->
                                        <div class="pull-right box-tools"></div>
                                    <!-- /. tools -->
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body pad">
                                        <textarea required="true" name="response" id="task-response" class="textarea" placeholder="Start writing your message here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                        <?php if($_SESSION['default_signature_type']== 'none'){ ?>
                                        <?php } else if ($_SESSION['default_signature_type']== 'mine'){ ?>
                                            <div id="sign" class="selected-signature" style="height: auto; box-shadow: none; display: none;">
                                                <div class="inner">
                                                    <?php echo $stafflogin->signature ?>
                                                    <input type="hidden" name="sign" value="<?php echo $stafflogin->signature ?>">
                                                </div>
                                            </div>
                                        <?php } else if ($_SESSION['default_signature_type']== 'dept'){ ?>
                                            <div id="sign" class="selected-signature" style="height: auto; box-shadow: none; display: none;">
                                                <div class="inner">
                                                    <?php echo $departmentsign->row()->signature ?>
                                                    <input type="hidden" name="sign" value="<?php echo $departmentsign->row()->signature ?>">
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div id="reply_form_attachments" class="attachments">
                                    <div class="filedrop">
                                        <div class="files"></div>
                                        <div class="dropzone" style="color: black;">
                                            <input style="display:unset;border:0;padding:0;background-color:white;" type="file" name="file[]" id="file" class="file" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Signature</label>
                            <div class="col-sm-10">
                                <label>
                                    <input type="radio" name="signature" value="none" checked="checked" onclick="if(this.checked){nosign()}"> None
                                </label>
                                <label>
                                    <input type="radio" name="signature" value="mine" onclick="if(this.checked){yessign()}"> My Signature
                                </label>

                                <script>
                                    function nosign() {
                                        var text = document.getElementById("sign");
                                    
                                        text.style.display = "none";
                                        
                                        $("#sign").attr('name', true);
                                    }
                                    function yessign() {
                                        var text = document.getElementById("sign");
                                    
                                        text.style.display = "block";
                                    } 
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Solved</label>
                            <div class="col-sm-10">
                                <input type="radio" name="solve" value="2" checked="">Solved&nbsp;
                                <input type="radio" name="solve" value="1">Not
                            </div>
                        </div>
                        <p style="text-align:center;">
                            <input class="save pending" type="submit" name="submit" value="Post Reply">
                            <input class="" type="reset" value="Reset">
                        </p>
                        <input type="hidden" name="draft_id">
                    </form>

                    <form id="note" class="tab_content_1 spellcheck exclusive save hiddens" data-lock-object-id="ticket/13" data-lock-id="" action="<?php echo site_url('staff_ticket_controller/ticketnote')?>" name="note" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
                        <div class="col-sm-12">
                            <label for="inputEmail3" class="col-sm-2 control-label">
                                Internal Note <span class="error">*</span>
                            </label>
                        
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" id="title" size="60" value="" required>
                                <p class="faded">Note title - summary of the note</p>
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <p class="error"></p>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="box">
                                <div class="box-header">
                                    <!-- tools box -->
                                    <div class="pull-right box-tools"></div>
                                    <!-- /. tools -->
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body pad">
                                    <textarea required="true" name="note" id="task-response" class="textarea" placeholder="Note details" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                </div>
                            </div>
                            <div class="attachments">
                                <div id="abb2958915b857de30fdac" class="filedrop">
                                    <div class="files"></div>
                                    <div class="dropzone" style="color: black;">
                                        <input style="display:unset;border:0;padding:0;background-color:white;" type="file" name="file[]" id="file" class="file" multiple>
                                    </div>
                                </div>
                                <span class="error">&nbsp;</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="inputEmail3" class="col-sm-2 control-label">
                                Ticket Status</label>
                            <div class="col-sm-10">
                                <div class="faded"></div>
                                <select name="note_status_guid" class="form-control" required>
                                    <option value="">— Select —</option>
                                    <?php foreach ($ticketstatus->result() as $status) { ?>
                                    <option value="<?php echo $status->status_guid;?>"><?php echo $status->name;?></option>
                                    <?php }?>
                                </select>
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding:10px;"></div>
                            <p style="text-align:center;">
                                <input class="save pending" name="submit" type="submit" value="Post Note">
                                <input class="" type="reset" value="Reset">
                            </p>
                            <input type="hidden" name="draft_id">
                    </form>
                </div>
            <!-- sticky bar stop actions -->
            <?php } ?>

            <?php } else if ($openclose->status_guid == '3') {?>
                <div id="msg_warning">Current ticket status (Closed) does not allow the end user to reply.</div>
            <?php } ?>
    </div>

    <div class="tab_content" id="tasks" style="display: none;">
    <div id="tasks_content" style="display:block;">
        <div class="pull-right">
            <a class="green button action-button ticket-task-action" data-toggle="modal" data-target="#task-modal" href="#users/add">
            <i class="icon-plus-sign"></i> Add New Task</a>

            <span class="action-button" data-toggle="modal" data-target="#taskstatus" id="tastatus" title="Change Status"><i class="icon-flag"></i></span>

            <span class="action-button" id="taassign" data-toggle="modal"  data-target="#taskassign" title=" Assign"><i class="icon-user"></i></span>

            <span class="action-button" id="tatransfer" data-placement="bottom" data-toggle="modal" data-target="#tasktransfer" title="Transfer"><i class="icon-share"></i></span>

            <span class="red button action-button" id="tadelete" data-placement="bottom" data-toggle="modal" data-target="#taskdelete" title="Delete"><i class="icon-trash"></i></span>
        </div>

        <div class="clear" style="padding:10px;"></div>

        <form action="<?php echo site_url('staff_task_controller/changetaskstatus');?>?id=<?php echo $_REQUEST['id'];?>&direct=ticket" method="POST" name="tickets" id="tickets">

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
                <?php foreach ($task->result() as $task) { ?>
                    <tr id="3">
                        <td align="center" class="nohover">
                            <input class="ckb" type="checkbox" name="tids[]" value="<?php echo $task->task_guid;?>"></td>
                        <td nowrap="">
                            <a class="preview" href="<?php echo site_url('staff_task_controller/taskinfo');?>?id=<?php echo $task->task_guid;?>">
                                <b><?php echo $task->task_guid;?></b></a></td>
                        <td nowrap=""><?php echo $task->task_created;?></td>
                        <td>
                            <a href="<?php echo site_url('staff_task_controller/taskinfo');?>?id=<?php echo $task->task_guid;?>"><?php echo $task->title;?></a>
                            <?php 
                            if ($this->db->query("SELECT COUNT(*) as threadcount FROM ost_thread_entry_test WHERE task_guid = '".$task->task_guid."'")->row('threadcount') != '0' && $this->db->query("SELECT COUNT(*) as threadcount FROM ost_thread_entry_test WHERE task_guid = '".$task->task_guid."'")->row('threadcount') != '1')
                            { ?>
                                <span class="pull-right faded-more">
                                    <i class="icon-comments-alt"></i>
                                    <small><?php echo $this->db->query("SELECT COUNT(*) as threadcount FROM ost_thread_entry_test WHERE task_guid = '".$task->task_guid."'")->row('threadcount');?></small>
                                </span>
                            <?php } ?></td>
                        <td nowrap=""><?php echo $task->deptname;?></td>
                        <td nowrap="">
                        <?php 
                        if ($task->taskteam == '0')
                        { ?>
                          <?php echo $task->firstname;?> 
                          <?php echo $task->lastname;?>
                        <?php }

                        if ($task->taskstaff == '0')
                        { ?>
                          <?php echo $task->teamname;?>
                        <?php } ?></td>
                    </tr>
                <?php } ?>
            </tbody>
          </table>

          <div class="modal fade" id="taskstatus" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Close Selected Task(s)</h3>
              </div>
              <div class="modal-body">

                <p id="msg_warning">Are you sure you want to CLOSE selected task(s)?</p>

                <div id="ticket-status" style="display:block; margin:5px;">

                <table width="100%">
                <tbody>
                  <input type="hidden" name="status_guid" id="sta" value="0">
                </tbody>
                <tbody>
                  <tr>
                      <td colspan="2">
                        <textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for status change (internal note)" id="_e8f5989ca9fa6fe1" name="closenote"></textarea>
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

  <div class="modal fade" id="taskassign" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Assign Selected Task(s)</h3>
              </div>
              <div class="modal-body">

                <div style="display:block; margin:5px;">
                  
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
                                  <select class="form-control" name="assignto" id="ass" data-placeholder="Select an Agent">
                                          <option value="">— Select an Agent —</option>
                              <optgroup label="Agents (<?php echo $staff->num_rows();?>)">
                              <?php foreach ($staff->result() as $taskstaff) { ?>
                                <option value="a<?php echo $taskstaff->staff_guid;?>"><?php echo $taskstaff->firstname;?> <?php echo $taskstaff->lastname;?></option>
                              <?php } ?> 
                              </optgroup>

                              <optgroup label="Team (<?php echo $team->num_rows();?>)">         
                              <?php foreach ($team->result() as $taskteam) { ?>
                                <option value="t<?php echo $taskteam->team_guid;?>"><?php echo $taskteam->name;?></option>
                              <?php } ?> 
                              </optgroup>  

                                  </select>
                                  </div>
                                  </div>
                              <div class="flush-left custom-field" id="field_d8bf82dc954436ab">
                          <div>
                                    </div><div>
                                  <span style="display:inline-block;width:100%">
                          <textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for the assignment" id="_d8bf82dc954436ab" name="assignnote"></textarea>
                          </span>
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

  <div class="modal fade" id="tasktransfer" style="display: none;">
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
              <div class="flush-left custom-field" id="field_b7a7b14540f04e3c">
            <div>
              <div class="field-label required">
            <label for="b7a7b14540f04e3c">
                Department:
                  <span class="error">*</span>
              </label>
            </div>
                    </div><div>
                  <select class="form-control" name="departmentid" id="dep" data-placeholder="Select">
                    <option value="">— Select —</option>
                    <?php foreach ($department->result() as $taskdept) { ?>
                      <option value="<?php echo $taskdept->department_guid;?>"><?php echo $taskdept->name;?></option>
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
                        <input type="submit" value="Transfer">
                    </span>
                 </p>

                </div>
              </div>
            </div>
  </div>

  <div class="modal fade" id="taskdelete" style="display: none;">
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
                                  <br><textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for deleting selected tickets" id="_e8f5989ca9fa6fe1" name="deletenote"></textarea>
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
                    <select name="delete" id="del" hidden="true" >
                      <option value="5"></option>
                    </select>
                      </span>
                   </p>

              </div>
            </div>
          </div>
  </div>
</form>


        <div class="clear"></div>
    </div>
</div>
</div>
<div class="clear"></div>
</div>
</div>
<script type="text/javascript">
$(function() {
    $(document).on('click', 'a.change-user', function(e) {
        e.preventDefault();
        var tid = 3;
        var cid = 3;
        var url = 'ajax.php/'+$(this).attr('href').substr(1);
        $.userLookup(url, function(user) {
            if(cid!=user.id
                    && $('.dialog#confirm-action #changeuser-confirm').length) {
                $('#newuser').html(user.name +' &lt;'+user.email+'&gt;');
                $('.dialog#confirm-action #action').val('changeuser');
                $('#confirm-form').append('<input type=hidden name=user_guid value='+user.id+' />');
                $('#overlay').show();
                $('.dialog#confirm-action .confirm-action').hide();
                $('.dialog#confirm-action p#changeuser-confirm')
                .show()
                .parent('div').show().trigger('click');
            }
        });
    });

    // Post Reply or Note action buttons.
    $('a.post-response').click(function (e) {
        var $r = $('ul.tabs_1 > li > a'+$(this).attr('href')+'-tab');
        if ($r.length) {
            // Make sure ticket thread tab is visiable.
            var $t = $('ul#ticket_tabs > li > a#ticket-thread-tab');
            if ($t.length && !$t.hasClass('active'))
                $t.trigger('click');
            // Make the target response tab active.
            if (!$r.hasClass('active'))
                $r.trigger('click');

            // Scroll to the response section.
            var $stop = $(document).height();
            var $s = $('div#response_options');
            if ($s.length)
                $stop = $s.offset().top-125

            $('html, body').animate({scrollTop: $stop}, 'fast');
        }

        return false;
    });

});
</script>
        <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css">

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
<div id="overlay" style="opacity: 0.5; display: none;"></div>
<div id="loading" style="top: 202.667px; left: 524.5px;">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>
<div class="container dialog draggable ui-draggable  size-normal" id="popup" style="display: none; top: 50.6667px; left: 374.5px;">
    <div id="popup-loading" style="display: none;">
        <h1 style="margin-bottom: 20px; margin-top: -10.3333px;"><i class="icon-spinner icon-spin icon-large"></i>
        Loading ...</h1>
    </div>
    <div class="body"></div>
</div>
<div style="display: none; top: 50.6667px; left: 618.5px;" class="dialog" id="alert">
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

<div class="modal fade" id="task-modal" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" class="org" action="<?php echo site_url('staff_task_controller/createtask');?>?id=<?php echo $_REQUEST['id'];?>&direct=ticket" enctype="multipart/form-data">

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
                        <input type="text" class="form-control" id="_31e14e029d68ee1d" size="40" maxlength="50" placeholder="" name="title" value="" required="true">
                      </fieldset>
                    </td>
                  </tr>

                  <tr>
                    <td class="cell" colspan="12" rowspan="1" style="" data-field-id="33">
                      <fieldset class="field " id="field_59f5e50392776c84" data-field-id="33">
                        <label class="required" for="_59f5e50392776c84">
                          Description:
                          <span class="error">*</span>
                        </label>

                        <textarea class="form-control" rows="8" cols="40" placeholder="Details on the reason(s) for creating the task" id="_d8bf82dc954436ab" name="description" required="true"></textarea>

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
              <input type="submit" name="submit" value="Add Task">
            </span>
          </p>
        </div>
      </form>

    </div>
  </div>
</div>

<form action="<?php echo site_url('staff_ticket_controller/ticketinfoupdate?id=').$_REQUEST['id']?>" method="POST" name="tickets" id="tickets">
  <!-- change ticket status popup modal -->
<div class="modal fade" id="cstatus" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <?php foreach ($result->result() as $ticket) { ?>
                    <h3 class="drag-handle">Open Ticket #<?php echo $ticket->number?></h3>
                <?php }?>
              </div>

              <div class="modal-body">
                <div id="ticket-status" style="display:block; margin:5px;">
                <table width="100%">
                        <tbody>
                <tr>
                    <td colspan="2">
                        <span>
                            <strong>Status:&nbsp;<font class="error">*</font></strong>
                            <select name="status_guid" id="status_guid">
                                <option value="">— Select —</option>
                                <?php foreach ($ticketstatus->result() as $status) {?>
                                    <option value="<?php echo $status->status_guid;?>" <?php echo $status->status_guid == $openclose->status_guid?"selected":"";?>><?php echo $status->name;?></option>
                                <?php } ?>                
                            </select>
                        </span>
                    </td>
                </tr>
                </tbody>

                <tbody>
                <tr>
                    <td colspan="2">
                        <br><textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for status change (internal note)" id="_e8f5989ca9fa6fe1" name="statusnote"></textarea>
                    </td>
                </tr>
                </tbody>
                </table>
               
                </div>
              </div>
              <div class="modal-footer">
                <p class="full-width">
                <span class="buttons pull-left">
                    <input type="button" data-dismiss="modal" value ="Close">
                    <input type="reset" value="Reset">
                </span>
                <span class="buttons pull-right">
                <input id="opennn" type="submit" value="Open">
                </span>
                </p>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
  </div>
  <!-- change ticket status popup modal -->

    <!-- assigned ticket  popup modal -->
<div class="modal fade" id="claim" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
                <?php foreach ($result->result() as $ticket) { ?>
                    <h3 class="drag-handle">Ticket #<?php echo $ticket->number?>: Assign to Agent/Team</h3>
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
                                            <optgroup label="Agents (<?php echo $staff->num_rows();?>)">
                                                <?php foreach ($staff->result() as $ticketstaff) { ?>
                                                    <option value="a<?php echo $ticketstaff->staff_guid;?>" <?php echo $ticketstaff->staff_guid == $openclose->assigned_to?"selected":"";?>><?php echo $ticketstaff->firstname;?> <?php echo $ticketstaff->lastname;?></option>
                                                <?php } ?> 
                                            </optgroup>

                                            <optgroup label="Team (<?php echo $team->num_rows();?>)">
                                                <?php foreach ($team->result() as $ticketteam) { ?>
                                                    <option value="t<?php echo $ticketteam->team_guid;?>" <?php echo $ticketteam->team_guid == $openclose->team_guid?"selected":"";?>><?php echo $ticketteam->name;?></option>
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
                        <input type="button" data-dismiss="modal" value ="Close">
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
                <?php foreach ($result->result() as $ticket) { ?>
                    <h3 class="drag-handle">Ticket #<?php echo $ticket->number?>: Transfer</h3>
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
                  <option value="<?php echo $default_depart->row('name');?>" <?php echo $default_depart->row('name') == $openclose->department?"selected":"";?>><?php echo $default_depart->row('name');?></option>
                  <?php foreach ($department->result() as $ticketdept) { ?>
                    <option value="<?php echo $ticketdept->name;?>" <?php echo $ticketdept->name == $openclose->department?"selected":"";?>><?php echo $ticketdept->name;?></option>
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
                        <input type="button" data-dismiss="modal" value ="Close">
                        <input type="reset" value="Reset">
                    </span>
                    <span class="buttons pull-right">
                        <input type="submit" value="Transfer">
                    </span>
                </p>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
  <!-- assigned ticket to department popup modal -->

    <!-- delete ticket to department popup modal -->
<div class="modal fade" id="delete" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <?php foreach ($result->result() as $ticket) { ?>
                <h3 class="drag-handle">Delete Ticket #<?php echo $ticket->number?></h3>
                <?php }?>
              </div>
              <div class="modal-body">

                <p id="msg_warning">Are you sure you want to DELETE this ticket?</p>

                <div style="display:block; margin:5px;">
                <form class="mass-action" method="post" name="delete" id="delete" action="#tickets/mass/delete">
                    <table width="100%">
                                <tbody>
                            <tr><td colspan="2"><strong><strong>Deleted ticket(s) CANNOT be recovered, including any associated attachments.</strong></strong></td> </tr>
                        </tbody>
                                <tbody>
                            <tr>
                                <td colspan="2">
                                  <br><textarea class="form-control" rows="4" cols="40" placeholder="Optional reason for deleting selected tickets" id="_e8f5989ca9fa6fe1" name="deletenote"></textarea>
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
                            <input type="button" data-dismiss="modal" value ="Close">
                            <input type="reset" value="Reset">
                        </span>

                        <span class="buttons pull-right">
                            <input type="submit" class="red button" value="Delete">
                            <input type="hidden" name="deleteticket" id="deleteticket" value="5">
                        </span>
                    </p>
                </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
  <!-- delete ticket to department popup modal -->
</form>

<!-- user info to department popup modal -->
<div class="modal fade" id="userinfo" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Ticket #<?php echo $openclose->number;?>: <?php echo $user->row('user_name');?></h3>
            </div>

            <div class="modal-body">
                <div id="user-profile" style="display:block;margin:5px;">
                    <div class="avatar pull-left" style="margin: 0 10px;">
                        <img class="avatar" alt="Avatar" src="//www.gravatar.com/avatar/591979a746b57c8ed09bca89133daeff?s=80&amp;d=mm">
                    </div>
                    
                    <a class="action-button pull-right change-user" style="overflow:inherit"  data-toggle="modal" data-target="#changeowner"><i class="icon-user"></i>
                    Change User</a>
                    
                    <div><b><?php echo $user->row('user_name');?></b></div>
                    <div class="faded">&lt;<?php echo $user->row('user_email');?>&gt;</div>
                    <div><?php echo $user->row('name');?></div>
    
                    <div class="clear"></div>
                    <div class="tab_2">
                        <ul class="tabs_2" id="user_tabs" style="margin-top:5px">
                            <li class="active"><a href="#info-tab"><i class="icon-info-sign"></i>&nbsp;User</a></li>
                            <li><a href="#org-tab"><i class="icon-fixed-width icon-building"></i>&nbsp;Organization</a></li>
                            <li><a href="#notes-tab"><i class="icon-fixed-width icon-pushpin"></i>&nbsp;Notes</a></li>
                        </ul>
                    </div>

                    <div id="user_tabs_container">
                        <div class="tab_content_2" id="info-tab">
                            <div class="floating-options">
                                <a onclick="updateuser()" id="edituser" class="action" title="Edit"><i class="icon-edit"></i></a>
                                <a href="<?php echo site_url('staff_user_controller/user_info?id=').$openclose->user_guid?>" title="Manage User" class="action"><i class="icon-share"></i></a>
                            </div>
                        
                            <table class="custom-info" width="100%">
                                <tbody>
                                <tr>
                                    <th colspan="2"><strong>Contact Information</strong></th>
                                </tr>

                                <tr>
                                    <td style="width:30%;">Phone Numbers:</td>
                                    <td><?php echo $phone;?></td>
                                </tr>

                                <tr>
                                    <td style="width:30%;">Internal Notes:</td>
                                    <td><?php echo $user->row('notes');?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="hiddens tab_content_2" id="org-tab">
                            <?php if ($user->row('user_org_guid') != "")
                            {?>
                                <div class="floating-options">
                                    <a href="<?php echo site_url('staff_user_controller/org_info?id=').$user->row('user_org_guid')?>" title="Manage Organization" class="action"><i class="icon-share"></i></a>
                                </div>
                            <?php }?>


                            <table class="custom-info" width="100%">
                                <tbody>
                                <tr>
                                    <th colspan="2"><strong>Organization Information</strong></th>
                                </tr>

                                <tr>
                                    <td style="width:30%">Address:</td>
                                    <td><?php echo $org->address;?></td>
                                </tr>

                                <tr>
                                    <td style="width:30%">Phone:</td>
                                    <td><?php echo $org->phone;?></td>
                                </tr>

                                <tr>
                                    <td style="width:30%">Website:</td>
                                    <td><?php echo $org->website;?></td>
                                </tr>

                                <tr>
                                    <td style="width:30%">Internal Notes:</td>
                                    <td><?php echo $org->notes;?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="hiddens tab_content_2" id="notes-tab">
                        <?php 
                            if ($user->row('notes') != "")
                            { ?>
                                <div id="quick-notes">
                                    <div class="quicknote">
                                        <div class="header">
                                            <div class="header-left">
                                                <i class="note-type icon-user" title="User Note"></i>&nbsp;
                                                <b><?php echo $org->firstname;?> <?php echo $org->lastname;?></b> posted <?php echo $org->usernote_created;?>
                                            </div>

                                            <div class="header-right">
                                                <b>Latest User Note</b>
                                            </div>
                                        </div>

                                        <div class="body">
                                            <div class="row">
                                                <div class="col-md-11" style="padding-left:0px">
                                                    <?php echo $user->row('notes');?>
                                                </div>
                                            
                                                <div class="col-md-1" style="padding-left:20px">
                                                    <a href="<?php echo site_url('staff_ticket_controller/deleteticketusernote?id=').$_REQUEST['id']?>" class="action" title="Delete">
                                                        <i class="icon-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php } ?>

                            <div id="new-note-box">
                                <form action="<?php echo site_url('staff_ticket_controller/ticketuser_notes?id=').$_REQUEST['id']?>" method="POST" style="padding-top:10px;">
                                    <div class="box">
                                        <div class="box-header">

                                          <!-- tools box -->
                                          <div class="pull-right box-tools">

                                          </div>
                                          <!-- /. tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body pad">
                                            <textarea class="form-control" rows="8" cols="40" placeholder="Start writing your note here" id="_e8f5989ca9fa6fe1" name="usernote"></textarea>
                                        </div>
                                    </div>
                                    <p class="submit" style="text-align: center;padding-top: 10px"><input type="submit" value="Create Note"></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="user-form" style="display:none;">
                    <div><p id="msg_info"><i class="icon-info-sign"></i>&nbsp; Please note that updates will be reflected system-wide.</p></div>
                    <form method="post" class="user" action="<?php echo site_url('staff_ticket_controller/ticket_user_update');?>?id=<?php echo $_REQUEST['id'];?>&status=info">
                        <input type="hidden" name="uid" value="3">
                        <div class="col-lg-12">
                            <div class="section-break">
                                <em><strong>Contact Information</strong>:</em>
                            </div>
                        </div>

                        <div>
                            <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                <label class="col-lg-3 control-label">
                                    Email Address<span class="error">*</span>:
                                </label>
                                    
                                <div class="col-lg-9">
                                    <input type="email" class="form-control" id="_909c2cdad0bfdee7" size="40" maxlength="64" placeholder="" name="cemail" value="<?php echo $user->row('user_email');?>">
                                </div>
                            </div>

                            <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                <label class="col-lg-3 control-label">
                                    Full Name<span class="error">*</span>:
                                </label>

                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="_ed8f90a883ba33f0" size="40" maxlength="64" placeholder="" name="cusername" value="<?php echo $user->row('user_name');?>">
                                </div>
                            </div>

                            <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                <label class="col-lg-3 control-label">
                                    Phone Numbers  :
                                </label>
                                
                                <div class="col-lg-9">
                                    <input id="_610372fddffb8d66" type="tel" name="cphone" value="<?php echo $user->row('user_phone');?>"> Ext:
                                    <input type="text" name="cphoneext" value="<?php echo $user->row('user_phoneext');?>" size="5">
                                </div>
                            </div>

                            <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                <label class="col-lg-3 control-label">
                                    Internal Notes  :
                                </label>

                                <div class="col-lg-9">
                                    <span style="display:inline-block;width:100%">
                                        <textarea class="form-control" rows="4" cols="40" placeholder="" id="_c49d58667945e2fb" name="cnote"><?php echo $user->row('notes');?></textarea>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <table width="100%"></table>

                        <br><div class="modal-footer">
                            <p class="full-width">
                                <span class="buttons pull-left">
                                    <input type="reset" value="Reset">
                                    <input type="button" name="cancel" class="cancel" value="Cancel" onclick="userinfo()">
                                </span>

                                <span class="buttons pull-right">
                                    <input type="submit" value="Update User">
                                </span>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
  <!-- user info popup modal -->

<!-- change ticket owner popup modal -->
<div class="modal fade" id="changeowner" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>

                <h3 class="drag-handle">Change user for ticket #<?php echo $openclose->number;?></h3>
            </div>

            <div class="modal-body">
                <div><p id="msg_info"><i class="icon-info-sign"></i>&nbsp; Search existing users or add a new user.</p></div>

                <div style="margin-bottom:10px;">
                    <input type="text" class="search-input" style="width:100%;" placeholder="Search by name or email" type="text" name="search_text" id="search_text" autofocus="" autocorrect="off" autocomplete="off">
                    <form method="post" class="org" action="">
                    <div id="result" style="overflow: hidden;"></div>

                    </form>

                </div>

                <div id="ticket-user-info" style="display:block;margin:5px;">
                    <div class="avatar pull-left" style="margin: 0 10px;">
                        <img class="avatar" alt="Avatar" src="//www.gravatar.com/avatar/591979a746b57c8ed09bca89133daeff?s=80&amp;d=mm">
                    </div>

                    <a class="action-button pull-right" style="overflow:inherit" id="unselect-user" onclick="adduser()"><i class="icon-remove"></i>
                        Add New User</a>

                    <div><strong id="user-name"><?php echo $user->row('user_name');?></strong></div>
                    <div>&lt;<span id="user-email"><?php echo $user->row('user_email');?></span>&gt;</div>
                    <div><span id="user-org"><?php echo $user->row('name');?></span></div>
                    
                    <table style="margin-top: 1em;">
                        <tbody>
                            <tr>
                                <td colspan="2" style="border-bottom: 1px dotted black"><strong>Contact Information</strong></td>
                            </tr>

                            <tr style="vertical-align:top">
                                <td style="width:30%;border-bottom: 1px dotted #ccc">Phone Numbers:</td>
                                <td style="border-bottom: 1px dotted #ccc"><?php echo $phone;?></td>
                            </tr>

                            <tr style="vertical-align:top">
                                <td style="width:30%;border-bottom: 1px dotted #ccc">Internal Notes:</td>
                                <td style="border-bottom: 1px dotted #ccc"><?php echo $user->row('notes');?></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="clear"></div>
                    <hr>
                </div>

                <div id="new-user-add" style="display:none;margin:5px;">
                    <form method="post" class="user" action="<?php echo site_url('staff_user_controller/createuser');?>?id=<?php echo $_REQUEST['id'];?>&direct=tinfo">
                    <div class="col-lg-12">
                        <div class="section-break">
                            <em><strong>Create New User</strong>:</em>
                        </div>
                    </div>

                    <div>
                        <!--<td class="multi-line required" style="min-width:120px;" >-->
                        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                            <label class="col-lg-3 control-label">
                                Email Address <span class="error">* </span>:
                            </label>
                            
                            <div class="col-lg-9">
                                <input type="email" class="form-control" id="_3cb58ae1280065e0" size="40" maxlength="64" placeholder="" name="email" value="" required>
                            </div>
                        </div>
                    
                        <!--<td class="multi-line required" style="min-width:120px;" >-->
                        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                            <label class="col-lg-3 control-label">
                                Full Name <span class="error">* </span> :
                            </label>

                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="_0facbaa263091c76" size="40" maxlength="64" placeholder="" name="fullname" value="" required>
                            </div>
                        </div>
                        
                        <!--<td class="multi-line " style="min-width:120px;" >-->
                        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                            <label class="col-lg-3 control-label">
                                Phone Numbers  :
                            </label>
                            
                            <div class="col-lg-9">
                                <input id="_de999dd69c9350c7" type="tel" name="phone" value=""> Ext:
                                <input type="text" name="phoneext" value="" size="5">
                            </div>
                        </div>
                            
                        <!--<td class="multi-line " style="min-width:120px;" >-->
                        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                            <label class="col-lg-3 control-label">
                                Internal Notes  :
                            </label>

                            <div class="col-lg-9">
                                <span style="display:inline-block;width:100%">
                                <textarea class="form-control" rows="4" cols="40" placeholder="" id="_a9e9211b340a6a13" name="note"></textarea>
                                </span>
                            </div>
                        </div>
                    </div>

                    <table width="100%" class="fixed"></table>

                    <br><div class="modal-footer">
                        <p class="full-width">
                            <span class="buttons pull-left">
                                <input type="button" onclick="reroll()" value ="Cancel">
                                <input type="reset" value="Reset">
                            </span>

                            <span class="buttons pull-right">
                                <input type="submit" value="Add User">
                            </span>
                        </p>
                    </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
</div>
  <!-- change ticket owner popup modal -->
</div>

<script type="text/javascript">
    var checked=false;
    function checkedAll () {
        var aa =  document.getElementsByName("tids[]");
        checked = document.getElementById('tidsall').checked;
         
        for (var i =0; i < aa.length; i++) 
            aa[i].checked = checked;
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

          $("#status_guid").attr('required', true);
          $("#departmentid").attr('required', false);
          $("#assignto").attr('required', false);
          $("#deleteticket").attr('required', false);
          $("#status_guid").attr('name', 'status_guid');
          $("#departmentid").attr('name', true);
          $("#assignto").attr('name', true);
          $("#deleteticket").attr('name', true);

        });

        $('#assign').click(function() {

          $("#status_guid").attr('required', false);
          $("#departmentid").attr('required', false);
          $("#departmentid").attr('name', true);
          $("#status_guid").attr('name', true);
          $("#assignto").attr('required', true);
          $("#assignto").attr('name', 'assignto');
          $("#deleteticket").attr('required', false);
          $("#deleteticket").attr('name', true);

        });


        $('#tickets-transfer').click(function() {

          $("#status_guid").attr('required', false);
          $("#assignto").attr('required', false);
          $("#departmentid").attr('required', true);
          $("#deleteticket").attr('required', false);
          $("#status_guid").attr('name', true);
          $("#departmentid").attr('name', 'departmentid');
          $("#assignto").attr('name', true);
          $("#deleteticket").attr('name', true);

        });

        $('#tickets-delete').click(function() {

          $("#status_guid").attr('required', false);
          $("#assignto").attr('required', false);
          $("#departmentid").attr('required', false);
          $("#deleteticket").attr('required', true);
          $("#status_guid").attr('name', true);
          $("#departmentid").attr('name', true);
          $("#assignto").attr('name', true);
          $("#deleteticket").attr('name', 'deleteticket');

        });
    });
</script>

<!-- taskcheckbox required -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#tastatus').click(function() {
          checked = $("input[type=checkbox]:checked").length;

          if(!checked) {
            alert("You must check at least one ticket.");
            return false;
          }

          $("#sta").attr('required', true);
          $("#dep").attr('required', false);
          $("#ass").attr('required', false);
          $("#del").attr('required', false);
          $("#sta").attr('name', 'status_guid');
          $("#dep").attr('name', true);
          $("#ass").attr('name', true);
          $("#del").attr('name', true);

        });

        $('#taassign').click(function() {
          checked = $("input[type=checkbox]:checked").length;

          if(!checked) {
            alert("You must check at least one ticket.");
            return false;
          }

          $("#sta").attr('required', false);
          $("#dep").attr('required', false);
          $("#dep").attr('name', true);
          $("#sta").attr('name', true);
          $("#ass").attr('required', true);
          $("#ass").attr('name', 'assignto');
          $("#del").attr('required', false);
          $("#del").attr('name', true);

        });


        $('#tatransfer').click(function() {
          checked = $("input[type=checkbox]:checked").length;

          if(!checked) {
            alert("You must check at least one ticket.");
            return false;
          }

          $("#sta").attr('required', false);
          $("#ass").attr('required', false);
          $("#dep").attr('required', true);
          $("#del").attr('required', false);
          $("#sta").attr('name', true);
          $("#dep").attr('name', 'departmentid');
          $("#ass").attr('name', true);
          $("#del").attr('name', true);

        });

        $('#tadelete').click(function() {
          checked = $("input[type=checkbox]:checked").length;

          if(!checked) {
            alert("You must check at least one ticket.");
            return false;
          }

          $("#sta").attr('required', false);
          $("#ass").attr('required', false);
          $("#dep").attr('required', false);
          $("#del").attr('required', true);
          $("#sta").attr('name', true);
          $("#dep").attr('name', true);
          $("#ass").attr('name', true);
          $("#del").attr('name', 'delete');

        });
    });
</script>


<script>
    var ticketuser = document.getElementById("ticket-user-info");
    var newuser = document.getElementById("new-user-add");
    var userprofile = document.getElementById("user-profile");
    var userform = document.getElementById("user-form");

    function adduser() {
        ticketuser.style.display = "none";
        newuser.style.display = "block";
    }

    function reroll() {
        ticketuser.style.display = "block";
        newuser.style.display = "none";
    }

    function updateuser() {
        userprofile.style.display = "none";
        userform.style.display = "block";
    }

    function userinfo() {
        userprofile.style.display = "block";
        userform.style.display = "none";
    }
</script>

<!-- ajax search -->
<script>
$(document).ready(function(){

 load_data();

 function load_data(query)
 {
  $.ajax({
   url:"<?php echo site_url('staff_ticket_controller/fetch_user')?>?id=<?php echo $_REQUEST['id'] ?>&direct=new",
   method:"POST",
   data:{query:query},
   success:function(data){
    $('#result').html(data);
   }
  })
 }

 $('#search_text').keyup(function(){
  var search = $(this).val();
  if(search != '')
  {
   load_data(search);


  }
  else
  {
   load_data();
  }
 });
});
</script>
<!-- ajax search -->

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


