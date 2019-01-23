<div id="content">
    <div class="col-lg-12" style="min-height:40px;">
    <?php foreach ($inforesult->result() as $info) { ?>
        <h2 class="pull-left"><a href="<?php echo site_url('staff_user_controller/user_info');?>?id=<?php echo $info->user_guid;?>" title="Reload"><i class="icon-refresh"></i> <?php echo $info->user_name;?></a></h2>
    
        <div class="pull-right">

            <?php if ($activeallow != 0 ) { ?>
            
            <?php if($inforesultcheckbox->status == '1' || $inforesultcheckbox->status == '2') { ?>

            <span class="action-button pull-right" data-toggle="modal" data-target="#resetpass-modal">
            <span><i class="icon-envelope"></i>
                Send Password Reset Email</span>
            </span>

            <?php } else if ($inforesultcheckbox->status == '3') {?>

            <span class="action-button pull-right" data-toggle="modal" data-target="#activation-modal">
            <span><i class="icon-envelope"></i>
                Send Activation Email</span>
            </span>
            <?php } else if ($inforesultcheckbox->status == '4') {?>

            <?php } ?>

         <?php } ?>

<!-- reset password  popup modal -->
<div class="modal fade" id="resetpass-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h3>Please Confirm</h3>
            </div>
            <div class="modal-body">

            <p class="confirm-action" style="display: block;" id="confirmlink-confirm">
            Are you sure you want to send an <b>Reset Password Request</b> to <em> <?php echo $info->user_email;?> </em>?    </p>
            <div>Please confirm to continue.</div>

            <br><div class="modal-footer">
            <p class="full-width">

            <form method="post" class="user" action="<?php echo site_url('staff_user_controller/user_info_resetpass?id=').$_REQUEST['id']?>">

            <span class="buttons pull-left">
                <input type="button" value="Cancel" class="close">
            </span>
            <span class="buttons pull-right">
                <input type="submit" value="OK">
            </span>

            </form>

            </p>
            </div>
             
            </div>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<!-- reset password popup modal -->

<!-- activation link  popup modal -->
<div class="modal fade" id="activation-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h3>Please Confirm</h3>
            </div>
            <div class="modal-body">

            <p class="confirm-action" style="display: block;" id="confirmlink-confirm">
            Are you sure you want to send an <b>Account Activation Link</b> to <em> <?php echo $info->user_email;?> </em>?</p>
            <div>Please confirm to continue.</div>

            <br><div class="modal-footer">
            <p class="full-width">
            <form method="post" class="user" action="<?php echo site_url('staff_user_controller/user_info_activationemail?id=').$_REQUEST['id']?>">
            <span class="buttons pull-left">
                <input type="button" value="Cancel" class="close">
            </span>
            <span class="buttons pull-right">
                <input type="submit" value="OK">
            </span>
            </form>
            </p>
            </div>
             
            </div>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<!-- activation link popup modal -->   
            <?php if ($deleteallow != 0 ) { ?>
            <a id="user-delete" class="red button action-button pull-right user-action" data-toggle="modal" data-target="#delete-modal">
            <i class="icon-trash"></i>
            Delete User</a>
            <?php } ?>

            <?php foreach ($inforesult->result() as $status) { ?>   
            <?php if ($status->status != 4) { ?>

                <?php if ($edituserallow != 0 ) { ?>

                <a id="user-manage" class="action-button pull-right user-action" data-toggle="modal" data-target="#manage-modal">
                <i class="icon-edit"></i>
                Manage Account</a>

                <?php } ?>

            <?php } else if ($status->status == 4) {?>

                <?php if ($activeallow != 0 ) { ?>

                <a id="user-manage" class="action-button pull-right user-action" data-toggle="modal" data-target="#register-modal">
                <i class="icon-smile"></i>
                Register</a>

                <?php } ?>

            <?php } ?>    
            <?php } ?>
        </div>
    </div>

<div class="col-lg-12" style="overflow:auto;">
    <div class="avatar pull-left" style="margin: 10px; width: 80px;">
        <img class="avatar" alt="Avatar" src="//www.gravatar.com/avatar/591979a746b57c8ed09bca89133daeff?s=80&amp;d=mm">
    </div>
</div>

<div class="col-lg-6" style="padding:0px;">
    <table class="ticket_info" width="100%">
        <tbody>
            <tr>
                <th width="120"><b>Name<b></th>
                <td>: 

                    <?php if ($edituserallow != 0 ) { ?>
                    <a data-toggle="modal" data-target="#user-modal" class="user-action">
                        <?php echo $info->user_name;?></a>

                    <?php } elseif ($edituserallow == 0 ) { ?>

                        <?php echo $info->user_name;?>

                    <?php } ?>
                </td>
            </tr>
        
            <tr>
                <th>Email</th>
                <td>
                    : <span id="user-3-email"><?php echo $info->user_email;?></span>
                </td>
            </tr>
        
            <tr>
                <th>Organization</th>
                <td>
                    : <span id="user-3-org">
                        <?php 
                        
                        if ($info->user_org_guid == ('0' || ''))
                        { ?>
                            <a data-toggle="modal" data-target="#organization-modal" class="user-action">Add Organization</a>
                        <?php }

                        else if ($info->user_org_guid != ('0' || ''))
                        { ?>
                            <a data-toggle="modal" data-target="#organization-modal1" class="user-action">
                            <?php echo $this->db->query("SELECT name FROM ost_user_test AS a
                                INNER JOIN ost_organization_test AS b ON a.user_org_guid = b.organization_guid
                                WHERE a.user_guid = '".$info->user_guid."'")->row('name');?></a>
                        <?php } ?>
                    </span>
                </td>
            </tr>

        </tbody>
    </table>
</div>

<div class="col-lg-6" style="padding:0px;">
    <table class="ticket_info" width="100%">
        <tbody>
            <tr>
                <th width="120">Status</th>
                <td>: <span id="user-3-status"><?php echo $info->name;?></span></td>
            </tr>

            <tr>
                <th>Created</th>
                <td>: <?php echo $info->user_created_at;?></td>
            </tr>

            <tr>
                <th>Updated</th>
                <td>: </td>
            </tr>

        </tbody>
    </table>
</div>
<?php } ?>
<br>

<div class="clear"></div>
<div class="tab">
    <ul class="clean tabs" id="user-view-tabs">
        <li class="active"><a href="#tickets"><i class="icon-list-alt"></i>&nbsp;Tickets</a></li>
        <li><a href="#notes"><i class="icon-pushpin"></i>&nbsp;Note</a></li>
    </ul>
</div>

<div id="user-view-tabs_container">
<div id="tickets" class="tab_content">
<div style="margin-bottom:10px;">
    <div class="pull-right flush-right">
                    <a class="green button action-button" href="<?php echo site_url('staff_ticket_controller/newticket?id=').$_REQUEST['id']?>">
                <i class="icon-plus"></i> Create New Ticket</a>
            </div>
</div>
<br>

<div>
<form action="users.php" method="POST" name="tickets" style="padding-top:10px;">

    <div style="overflow:auto;">
    <table class="list" id="utable" border="0" cellspacing="1" cellpadding="2">
        <thead>
            <tr>
                <th width="10%">Ticket</th>
                <th width="18%">Last Updated</th>
                <th width="12%">Status</th>
                <th width="30%">Subject</th>
                <th width="15%">Department</th>
                <th width="15%">Assignee</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($ticketinfo->result() as $ticket) { ?>
            <tr>
                <td nowrap="">
                  <a class="Icon webTicket preview" title="Preview Ticket" href="<?php echo site_url('staff_ticket_controller/ticketinfo');?>?id=<?php echo $ticket->ticket_guid;?>"><?php echo $ticket->number;?></a>
                </td>
                <td nowrap=""><?php echo $ticket->ticket_updated;?></td></td>
                <td><?php echo $ticket->name;?></td>
                <td><a href="<?php echo site_url('staff_ticket_controller/ticketinfo');?>?id=<?php echo $ticket->ticket_guid;?>"><?php echo $ticket->topic;?></a>

                    <?php 
                    if ($this->db->query("SELECT COUNT(*) as userthread FROM ost_thread_entry_test WHERE ticket_guid = '".$ticket->ticket_guid."'")->row('userthread') != '0' && $this->db->query("SELECT COUNT(*) as userthread FROM ost_thread_entry_test WHERE ticket_guid = '".$ticket->ticket_guid."'")->row('userthread') != '1')
                    { ?>

                    <span class="pull-right faded-more">
                        <i class="icon-comments-alt"></i>
                            <small><?php echo $this->db->query("SELECT COUNT(*) as userthread FROM ost_thread_entry_test WHERE ticket_guid = '".$ticket->ticket_guid."'")->row('userthread');?></small>
                    </span>
                    <?php } ?>
                </td>
                <td><span class="truncate" style="max-wdith:125px"><?php echo $ticket->department;?></span></td>
                <td><span class="truncate" style="max-width:125px">
                    <?php 
                    if ($ticket->team_guid == '0')
                    { ?>
                      <?php echo $this->db->query("SELECT firstname FROM ost_staff_test AS a
                                                  INNER JOIN ost_ticket_test AS b
                                                  ON b.assigned_to = a.staff_guid
                                                  WHERE b.ticket_guid = '".$ticket->ticket_guid."'")->row('firstname');?> 
                      <?php echo $this->db->query("SELECT lastname FROM ost_staff_test AS a
                                                  INNER JOIN ost_ticket_test AS b
                                                  ON b.assigned_to = a.staff_guid
                                                  WHERE b.ticket_guid = '".$ticket->ticket_guid."'")->row('lastname');?>
                    <?php }

                    if ($ticket->assigned_to == '0')
                    { ?>
                      <?php echo $this->db->query("SELECT name FROM ost_team_test AS a
                                                  INNER JOIN ost_ticket_test AS b
                                                  ON b.team_guid = a.team_guid
                                                  WHERE b.ticket_guid = '".$ticket->ticket_guid."'")->row('name');?>
                    <?php } ?>
                    </span>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
</form>
</div>
</div>

<div class="hiddens tab_content" id="notes">
    <?php 
    if ($inforesultcheckbox->usernote != "")
    { ?>
        <div id="quick-notes">
            <div class="quicknote">
                <div class="header">
                    <div class="header-left">
                        <i class="note-type icon-user" i="" title="User Note"></i>&nbsp;
                        <b><?php echo $inforesultcheckbox->firstname;?> <?php echo $inforesultcheckbox->lastname;?></b> posted <?php echo $inforesultcheckbox->usernote_created;?>
                    </div>

                    <div class="header-right">
                        <b>Latest User Note</b>
                    </div>
                </div>

                <div class="body">
                    <div class="row">
                        <div class="col-md-11" style="padding-left:0px">
                            <?php echo $inforesultcheckbox->usernote;?>
                        </div>
                    
                        <div class="col-md-1" style="padding-left:50px">
                            <a href="<?php echo site_url('staff_user_controller/deleteusernote?id=').$_REQUEST['id']?>" class="action" title="Delete">
                                <i class="icon-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div id="new-note-box">
        <form action="<?php echo site_url('staff_user_controller/user_notes?id=').$_REQUEST['id']?>" method="POST" style="padding-top:10px;">
            <div class="box">
            <div class="box-header">

              <!-- tools box -->
              <div class="pull-right box-tools">

              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
                
                <textarea required="true" name="usernote" id="task-response" class="textarea" placeholder="Start writing your note here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
            </div>
            </div>

            <p class="submit" style="text-align: center;padding-top: 10px"><input type="submit" value="Create Note"></p>
        </form>
    </div>
</div>
</div>

<div class="container hiddens dialog" id="confirm-action" style="top: 54.75px; left: 374.5px;">
    <h3>Please Confirm</h3>
    <a class="close" href=""><i class="icon-remove-circle"></i></a>
    <hr>
    <p class="confirm-action" style="display:none;" id="banemail-confirm">
        Are you sure you want to <b>ban</b> hugh@pandasoftware.my?        <br><br>
        New tickets from the email address will be auto-rejected.    </p>
    <p class="confirm-action" style="display:none;" id="confirmlink-confirm">
        Are you sure you want to send an <b>Account Activation Link</b> to <em> hugh@pandasoftware.my </em>?    </p>
    <p class="confirm-action" style="display:none;" id="pwreset-confirm">
        Are you sure you want to send a <b>Password Reset Link</b> to <em> hugh@pandasoftware.my </em>?    </p>
    <div>Please confirm to continue.</div>
    <form action="users.php?id=3" method="post" id="confirm-form" name="confirm-form">

        <hr style="margin-top:1em">
        <p class="full-width">
            <span class="buttons pull-left">
                <input type="button" value="Cancel" class="close">
            </span>
            <span class="buttons pull-right">
                <input type="submit" value="OK">
            </span>
         </p>
    </form>
    <div class="clear"></div>
</div>

<script type="text/javascript">
$(function() {
    $(document).on('click', 'a.user-action', function(e) {
        e.preventDefault();
        var url = 'ajax.php/'+$(this).attr('href').substr(1);
        $.dialog(url, [201, 204], function (xhr) {
            if (xhr.status == 204)
                window.location.href = 'users.php';
            else
                window.location.href = window.location.href;
            return false;
         }, {
            onshow: function() { $('#user-search').focus(); }
         });
        return false;
    });
});
</script>
</div>

</div>
</div>

<!-- manage user popup modal -->
<div class="modal fade" id="manage-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <?php foreach ($inforesult->result() as $info) { ?>
                    <h3 class="drag-handle"><?php echo $info->user_name;?></h3>
                <?php } ?>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="post" action="<?php echo site_url('staff_user_controller/user_infoupdate');?>?id=<?php echo $_REQUEST['id'];?>&direct=manageuser">
                    <div class="tab_1">
                        <ul class="tabs_1" id="user-account-tabs">
                            <li class="active">
                                <a href="#user-account">
                                <i class="icon-user"></i>&nbsp;
                                User Information</a>
                            </li>

                            <li class="">
                                <a href="#user-access">
                                    <i class="icon-fixed-width icon-lock faded"></i>&nbsp;
                                    Manage Access</a>
                            </li>
                        </ul>
                    </div>

                    <div id="user-account-tabs_container">
                        <div class="tab_content_1" id="user-account" style="display: block; margin: 5px;">
                            <div id="user-form" style="display:block;">
                                <div>
                                    <p id="msg_info">
                                    <i class="icon-info-sign"></i>&nbsp; 
                                    Please note that updates will be reflected system-wide.</p>
                                </div>

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
                                        
                                        <?php foreach ($inforesult->result() as $info) { ?>
                                            <div class="col-lg-9">        
                                                <input type="email" class="form-control" id="_f3dc3476a4a46924" size="40" maxlength="64" placeholder="" required="true" name="cemail" value="<?php echo $info->user_email;?>">
                                            </div>
                                    </div>

                                    <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                        <label class="col-lg-3 control-label">
                                            Full Name<span class="error">*</span>:
                                        </label>

                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="_08501590b04f1a03" size="40" maxlength="64" placeholder="" required="true" name="cusername" value="<?php echo $info->user_name;?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                        <label class="col-lg-3 control-label">Phone Numbers  :</label>
                                            
                                        <div class="col-lg-9">
                                            <input id="_0ca08114226a53bf" type="tel" name="cphone" value="<?php echo $info->user_phone;?>"> Ext:
                                            <input type="text" name="cphoneext" value="<?php echo $info->user_phoneext;?>" size="5">
                                        </div>
                                    </div>
                                       
                                    <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                        <label class="col-lg-3 control-label">Internal Notes  :</label>
                                            
                                        <div class="col-lg-9">
                                            <span style="display:inline-block;width:100%">
                                                <textarea class="form-control" rows="4" cols="40" placeholder="" id="_2b5bcdc2eb81972b" value="" name="cnote"><?php echo $info->notes;?></textarea>
                                            </span>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <table width="100%"></table>
                            </div>
                        </div>
                    
                        <div class="tab_content_1" id="user-access" style="margin: 5px; display: none;">
                            <div class="section-break" style="margin-bottom:10px;">
                                <em><strong>Account Access</strong></em>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Status :</label>
                                <div class="col-lg-8">
                                    <?php foreach ($inforesult->result() as $info) { ?>
                                        <?php echo $info->name;?>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-4 control-label">New Password :</label>
                                <div class="col-lg-8">
                                    <input type="password" class="form-control" size="35" name="passwd1" value="">
                                        &nbsp;<span class="error">&nbsp;</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-4 control-label">Confirm Password:</label>
                                <div class="col-lg-8">
                                    <input type="password" class="form-control" size="35" name="passwd2" value="">
                                        &nbsp;<span class="error">&nbsp;</span>
                                </div>
                            </div>

                            <div class="section-break" style="margin-bottom:10px;">
                                <em><strong>Account Flags</strong></em>
                            </div>

                            <div>
                                <?php if($inforesultcheckbox->status == '1') { ?>
                                    <input type="checkbox" name="locked-flag" value="2"> Administratively Locked
                                
                                <?php } else if($inforesultcheckbox->status == '2') { ?>
                                    <input type="checkbox" name="locked-flag" value="2" checked="checked"> Administratively Locked

                                <?php } ?>
                            </div>    

                            <div>
                                <?php if($inforesultcheckbox->resetpass == '0') { ?>
                                    <input type="checkbox" name="pwreset-flag" value="1"> Password Reset Required
                                    
                                <?php } else if($inforesultcheckbox->resetpass == '1') { ?>
                                    <input type="checkbox" name="pwreset-flag" checked="checked" value="1"> Password Reset Required
                                
                                <?php } ?>
                            </div>

                            <div>
                                <?php if($inforesultcheckbox->changepass == '0') { ?>
                                    <input type="checkbox" name="forbid-pwchange-flag" value="1"> User cannot change password
                                    
                                <?php } else if($inforesultcheckbox->changepass == '1') { ?>
                                    <input type="checkbox" name="forbid-pwchange-flag" value="1" checked="checked"> User cannot change password
                                
                                <?php } ?>
                            </div>
                        </div>
                    </div>
            
            <div class="modal-footer">
                <p class="full-width">
                    <span class="buttons pull-left">
                        <input type="reset" value="Reset">
                        <input type="button" name="cancel" class="close" value="Cancel">
                    </span>

                    <span class="buttons pull-right">
                        <input type="submit" value="Save Changes">
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
<!-- manage user popup modal -->

<!-- register user popup modal -->
<div class="modal fade" id="register-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <?php foreach ($inforesult->result() as $info) { ?>
                        <h3 class="drag-handle">Register: <?php echo $info->user_name;?></h3>
                    <?php } ?>
            </div>
            <div class="modal-body">

                <div><p id="msg_info"><i class="icon-info-sign"></i>&nbsp;Complete the form below to create a user account for <b><?php echo $inforesult->row('user_name');?> </b>.</p></div>

                <div id="user-registration" style="display:block; margin:5px;">
                    <form method="post" class="user" action="<?php echo site_url('staff_user_controller/user_info_register?id=').$_REQUEST['id']?>">
                        
                        <table width="100%">
                        <tbody>
                            <tr>
                                <th colspan="2">
                                    <em><strong>User Account Login</strong></em><br><br>
                                </th>
                            </tr>

                        </tbody>
                        <tbody id="activation">
                            <tr>
                                <td width="180">
                                    Status:
                                </td>
                                <td>
                                  <input type="checkbox" id="sendemail" name="sendemail" value="1" onchange="myFunction()" checked>Send account activation email to <?php echo $info->user_email;?>.                </td>
                            </tr>
                        </tbody>
                        <tbody id="password" style="display:none;">
                            <tr>
                                <td width="180" style="padding-top: 10px">
                                    Temporary Password:
                                </td>
                                <td style="padding-top: 10px">
                                    <input type="password" size="35" name="passwd1" value="">
                                    &nbsp;<span class="error">&nbsp;</span>
                                </td>
                            </tr>
                            <tr>
                                <td width="180" style="padding-top: 10px">
                                   Confirm Password:
                                </td>
                                <td style="padding-top: 10px">
                                    <input type="password" size="35" name="passwd2" value="">
                                    &nbsp;<span class="error">&nbsp;</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 10px">
                                    Password Change:
                                </td>
                                <td colspan="2" style="padding-top: 10px">
                                    <input type="checkbox" name="pwreset-flag" value="1">
                                        Require password change on login                    <br>
                                    <input type="checkbox" name="forbid-pwreset-flag" value="1">
                                        User cannot change password                </td>
                            </tr>
                        </tbody>
                        
                        </table>
                        <br><div class="modal-footer">
                        <p class="full-width">
                            <span class="buttons pull-left">
                                <input type="reset" value="Reset">
                                <input type="button" name="cancel" class="close" value="Cancel">
                            </span>
                            <span class="buttons pull-right">
                                <input type="submit" value="Create Account">
                            </span>
                         </p>
                         </div>
                    </form>
                </div>

            </div>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<!-- register user popup modal -->

<!-- delete user popup modal -->
<div class="modal fade" id="delete-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <?php foreach ($inforesult->result() as $info) { ?>
                        
                    <?php } ?>
                    <h3 class="drag-handle">Delete User: <?php echo $info->user_name;?></h3>
            </div>
            <div class="modal-body">

                <p id="msg_warning">Deleted users and tickets CANNOT be recovered</p>

                <div id="user-profile" style="margin:5px;">
                    <div class="avatar pull-left" style="margin: 0 10px;">
                    <img class="avatar" alt="Avatar" src="//www.gravatar.com/avatar/591979a746b57c8ed09bca89133daeff?s=80&amp;d=mm">    </div>
                    <div><b> <?php echo $info->user_name;?></b></div>
                    <div>&lt;<?php echo $info->user_email;?>&gt;</div>
                    <table style="margin-top: 1em;">
                    <tbody><tr><td colspan="2" style="border-bottom: 1px dotted black"><strong>Contact Information</strong></td></tr>
                    <tr style="vertical-align:top"><td style="width:30%;border-bottom: 1px dotted #ccc">Phone Numbers: </td>
                    <td style="border-bottom: 1px dotted #ccc"><?php echo $info->user_phone;?></td>
                    </tr>
                    <tr style="vertical-align:top"><td style="width:30%;border-bottom: 1px dotted #ccc">Internal Notes: </td>
                    <td style="border-bottom: 1px dotted #ccc"> <?php echo $info->notes;?></td>
                    </tr>
                    </tbody></table>
                    <div class="clear"></div>

                    <form method="post" class="user" action="<?php echo site_url('staff_user_controller/user_infodelete?id=').$_REQUEST['id']?>">

                    <?php
                    if ($ticketinfo->num_rows() > "0")
                    { ?>

                        <br><div><input type="checkbox" name="deleteticket" value="1"> <strong>Delete <a href="tickets.php?a=search&amp;uid=3" target="_blank"> <?php echo $ticketinfo->num_rows() ;?> ticket(s) </a> and any associated attachments and data.</strong></div>

                    <?php } ?>

                    <br><div class="modal-footer">   
                    <p class="full-width">
                        <span class="buttons pull-left">
                            <input type="reset" value="Reset">
                            <input type="button" name="cancel" class="close" value="No, Cancel">
                        </span>
                        <span class="buttons pull-right">
                            <input type="submit" value="Yes, Delete User">
                        </span>
                    </p>
                    </div>
                    </form>
                    
                </div>


            </div>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<!-- delete user popup modal -->

<!-- edit user popup modal -->
<div class="modal fade" id="user-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <?php foreach ($inforesult->result() as $info) { ?>
                    <h3 class="drag-handle">Update <?php echo $info->user_name;?></h3>
                <?php } ?>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="post" action="<?php echo site_url('staff_user_controller/user_infoupdate');?>?id=<?php echo $_REQUEST['id'];?>&direct=updateuser">

                    <div id="user-account-tabs_container">
                        <div id="user-form" style="display:block;">
                            <div>
                                <p id="msg_info">
                                <i class="icon-info-sign"></i>&nbsp; 
                                Please note that updates will be reflected system-wide.</p>
                            </div>

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
                                    
                                    <?php foreach ($inforesult->result() as $info) { ?>
                                        <div class="col-lg-9">        
                                            <input type="email" class="form-control" id="_f3dc3476a4a46924" size="40" maxlength="64" placeholder="" required="true" name="cemail" value="<?php echo $info->user_email;?>">
                                        </div>
                                </div>

                                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                    <label class="col-lg-3 control-label">
                                        Full Name<span class="error">*</span>:
                                    </label>

                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="_08501590b04f1a03" size="40" maxlength="64" placeholder="" required="true" name="cusername" value="<?php echo $info->user_name;?>">
                                    </div>
                                </div>

                                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                    <label class="col-lg-3 control-label">Phone Numbers  :</label>
                                        
                                    <div class="col-lg-9">
                                        <input id="_0ca08114226a53bf" type="tel" name="cphone" value="<?php echo $info->user_phone;?>"> Ext:
                                        <input type="text" name="cphoneext" value="<?php echo $info->user_phoneext;?>" size="5">
                                    </div>
                                </div>
                                   
                                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                    <label class="col-lg-3 control-label">Internal Notes  :</label>
                                        
                                    <div class="col-lg-9">
                                        <span style="display:inline-block;width:100%">
                                            <textarea class="form-control" rows="4" cols="40" placeholder="" id="_2b5bcdc2eb81972b" value="" name="cnote"><?php echo $info->notes;?></textarea>
                                        </span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <table width="100%"></table>
                        </div>
                    </div>
            
            <br><div class="modal-footer">
                <p class="full-width">
                    <span class="buttons pull-left">
                        <input type="reset" value="Reset">
                        <input type="button" name="cancel" class="close" value="Cancel">
                    </span>

                    <span class="buttons pull-right">
                        <input type="submit" value="Save Changes">
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
<!-- edit user popup modal -->

<!-- manage organization  popup modal -->
<?php foreach ($organization->result() as $org) { ?>

<div class="modal fade" id="organization-modal1" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>

                    <h3 class="drag-handle"><?php echo $org->user_name;?> — Organization</h3>
            </div>
            <div class="modal-body">
                
                <div id="org-profile" style="display:block;margin:5px;">
                    <i class="icon-group icon-4x pull-left icon-border"></i>
                        <a class="action-button pull-right user-action" style="overflow:inherit" data-toggle="modal" data-target="#useraddorg-modal"><i class="icon-user"></i>
                        Change</a>
                    <a class="action-button pull-right" href="<?php echo site_url('staff_user_controller/org_info');?>?id=<?php echo $org->organization_guid;?>"><i class="icon-share"></i>
                        Manage</a>
                        <div><b><a data-toggle="modal" data-target="#updateorg-modal"><i class="icon-edit"></i>&nbsp;<?php echo $org->name;?></a></b></div>
                    <table style="margin-top: 1em;">
                    <tbody><tr><td colspan="2" style="border-bottom: 1px dotted black"><strong>Organization Information</strong></td></tr>
                    <tr style="vertical-align:top"><td style="width:30%;border-bottom: 1px dotted #ccc">Address:</td>
                    <td style="border-bottom: 1px dotted #ccc"><?php echo $org->address;?></td>
                    </tr>
                    <tr style="vertical-align:top"><td style="width:30%;border-bottom: 1px dotted #ccc">Phone:</td>
                    <td style="border-bottom: 1px dotted #ccc"><?php echo $org->phone;?></td>
                    </tr>
                    <tr style="vertical-align:top"><td style="width:30%;border-bottom: 1px dotted #ccc">Website:</td>
                    <td style="border-bottom: 1px dotted #ccc"><?php echo $org->website;?></td>
                    </tr>
                    <tr style="vertical-align:top"><td style="width:30%;border-bottom: 1px dotted #ccc">Internal Notes:</td>
                    <td style="border-bottom: 1px dotted #ccc"><?php echo $org->notes;?></td>
                    </tr>
                    </tbody></table>
                    <div class="clear"></div>
                    <hr>
                    <div class="faded">Last updated <b> </b></div>
                </div>

             
            </div>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<?php } ?>
<!-- manage organization user popup modal -->

<!-- useraddorg organization  popup modal -->
<?php foreach ($organization->result() as $org) { ?>
<div class="modal fade" id="useraddorg-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h3 class="drag-handle">Organization for <?php echo $org->user_name;?></h3>
            </div>
            <div class="modal-body">

                <div><p id="msg_info"><i class="icon-info-sign"></i>&nbsp; Search existing organizations or add a new one.</p></div>

                <div style="margin-bottom:10px;">
                    <input type="text" class="search-input" style="width:100%;" placeholder="Search by organization name" type="text" name="search_text" id="search_text" autofocus="" autocorrect="off" autocomplete="off">
                    <form method="post" class="org" action="">
                    <div id="result" style="overflow: hidden;"></div>

                    </form>

                </div>



                    <form method="post" class="org" action="#users/3/org">
                        <input type="hidden" id="org-id" name="orgid" value="5">
                        <i class="icon-group icon-4x pull-left icon-border"></i>
                        <a class="action-button pull-right" id="unselect-org" data-toggle="modal" data-target="#organization-modal"><i class="icon-remove"></i>
                            Add New Organization</a>
                        <div><strong id="org-name"><?php echo $org->name;?></strong></div>
                        <table style="margin-top: 1em;">
                        <tbody><tr><td colspan="2" style="border-bottom: 1px dotted black"><strong>Organization Information</strong></td></tr>
                        <tr style="vertical-align:top">
                            <td style="width:30%;border-bottom: 1px dotted #ccc">Address:</td>
                            <td style="border-bottom: 1px dotted #ccc"><?php echo $org->address;?></td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td style="width:30%;border-bottom: 1px dotted #ccc">Phone:</td>
                            <td style="border-bottom: 1px dotted #ccc"><?php echo $org->phone;?></td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td style="width:30%;border-bottom: 1px dotted #ccc">Website:</td>
                            <td style="border-bottom: 1px dotted #ccc"><?php echo $org->website;?></td>
                        </tr>

                        <tr style="vertical-align:top">
                            <td style="width:30%;border-bottom: 1px dotted #ccc">Internal Notes:</td>
                            <td style="border-bottom: 1px dotted #ccc"><?php echo $org->notes;?></td>
                        </tr>
                       </tbody></table>
                     <div class="clear"></div>

                    <br><div class="modal-footer">
                    <p class="full-width">
                        <span class="buttons pull-left">
                            <input type="button" data-dismiss="modal" value ="Cancel">
                        </span>
                        <span class="buttons pull-right">
                            <input type="submit" value="Continue">
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
<?php } ?>
<!-- useraddorg organization user popup modal -->  

<?php foreach ($inforesult->result() as $info) { ?>
<!-- add organization  popup modal -->
<div class="modal fade" id="organization-modal" style="display: none;">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>

                    <h3 class="drag-handle">Organization for <?php echo $info->user_name;?></h3>
            </div>
            <div class="modal-body">

                <p id="msg_info"><i class="icon-info-sign"></i>&nbsp; Search existing organizations or add a new one.</p>

                <div id="new-org-form" style="display:block;">
                    <form method="post" class="org" action="<?php echo site_url('staff_user_controller/userinfo_createorg?id=').$_REQUEST['id']?>">
                        <div class="col-lg-12">
                        <div class="section-break">
                            <em>
                                <strong>Create New Organization</strong>: Details on user organization        </em>
                        </div>
                    </div><div>
                                                <!--<td class="multi-line required" style="min-width:120px;" >-->
                                    <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                        <label class="col-lg-3 control-label">
                                            Name                             <span class="error">*</span>
                                             :
                                        </label>
                                        <div class="col-lg-9">        <input type="text" class="form-control" id="_bcc2ea5a817c57c9" size="40" maxlength="64" placeholder="" name="orgname" value="">
                                                    </div>
                                            </div>
                                                <!--<td class="multi-line " style="min-width:120px;" >-->
                                    <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                        <label class="col-lg-3 control-label">
                                            Address  :
                                        </label>
                                        <div class="col-lg-9">        <span style="display:inline-block;width:100%">
                            <textarea class="form-control" rows="2" cols="40" maxlength="100" placeholder="" id="_c4340b9a509a0f7d" name="orgadd"></textarea>
                            </span>
                                                    </div>
                                            </div>
                                                <!--<td class="multi-line " style="min-width:120px;" >-->
                                    <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                        <label class="col-lg-3 control-label">
                                            Phone  :
                                        </label>
                                        <div class="col-lg-9">        <input id="_da1e94a1236e8471" type="tel" name="orgphone" value=""> Ext:
                                <input type="text" name="orgphoneext" value="" size="5">
                                                    </div>
                                            </div>
                                                <!--<td class="multi-line " style="min-width:120px;" >-->
                                    <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                        <label class="col-lg-3 control-label">
                                            Website  :
                                        </label>
                                        <div class="col-lg-9">        <input type="text" class="form-control" id="_d718ad94c6744bfe" size="40" placeholder="" name="orgweb" value="">
                                                    </div>
                                            </div>
                                                <!--<td class="multi-line " style="min-width:120px;" >-->
                                    <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                        <label class="col-lg-3 control-label">
                                            Internal Notes  :
                                        </label>
                                        <div class="col-lg-9">        <span style="display:inline-block;width:100%">
                            <textarea class="form-control" rows="4" cols="40" placeholder="" id="_197e6f157e5a9fa3" name="orgnotes"></textarea>
                            </span>
                                                    </div>
                                            </div>
                            </div><table width="100%" class="fixed">
                        
                            </table>

                        <br><div class="modal-footer">
                        <p class="full-width">
                            <span class="buttons pull-left">
                                <input type="reset" value="Reset">
                                <input type="button" data-dismiss="modal" value ="Cancel">
                            </span>
                            <span class="buttons pull-right">
                                <input type="submit" value="Add Organization">
                            
                            </span>
                         </p>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>
<!-- add organization user popup modal -->
 <?php } ?>

<?php foreach ($organization->result() as $org) { ?>
<div class="modal fade" id="updateorg-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h3 class="drag-handle">Update <?php echo $org->name;?></h3>
            </div>

            <div class="modal-body">
                <div id="org-form" style="">
                    <div>
                        <p id="msg_info">
                            <i class="icon-info-sign"></i>&nbsp; Please note that updates will be reflected system-wide.
                        </p>
                    </div>

                <form method="post" class="org" action="<?php echo site_url('staff_user_controller/user_orgupdate?id=').$_REQUEST['id']?>">
                    <div class="col-lg-12">
                        <div class="section-break">
                            <em><strong>Organization Information</strong>: Details on user organization</em>
                        </div>
                    </div>

                    <div>
                        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                            <label class="col-lg-3 control-label">
                                Name<span class="error">*</span>:
                            </label>
                            
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="_6f4f5630d56d0ee9" size="40" maxlength="64" placeholder="" name="orgname" value="<?php echo $org->name;?>">
                            </div>
                        </div>

                        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                            <label class="col-lg-3 control-label">
                                Address  :
                            </label>
                                    
                            <div class="col-lg-9">
                                <span style="display:inline-block;width:100%">
                                    <textarea class="form-control" rows="2" cols="40" maxlength="100" placeholder="" id="_43abb639ac0262c1" name="orgadd"><?php echo $org->address;?></textarea>
                                </span>
                            </div>
                        </div>

                        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                            <label class="col-lg-3 control-label">
                                Phone  :
                            </label>
                                    
                            <div class="col-lg-9">
                                <input id="_1c4f662d9489afd9" type="tel" name="orgphone" value="<?php echo $phone;?>"> Ext:
                                <input type="text" name="orgphoneext" value="<?php echo $phoneext;?>" size="5">
                            </div>
                        </div>

                        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                            <label class="col-lg-3 control-label">
                                Website  :
                            </label>
                                    
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="_82e954f66e37a6ee" size="40" placeholder="" name="orgweb" value="<?php echo $org->website;?>">
                            </div>
                        </div>

                        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                            <label class="col-lg-3 control-label">
                                Internal Notes  :
                            </label>
                                    
                            <div class="col-lg-9">
                                <span style="display:inline-block;width:100%">
                                    <textarea class="form-control" rows="4" cols="40" placeholder="" id="_de8a0c9a2ea9bb29" name="orgnotes"><?php echo $org->notes;?></textarea>
                                </span>
                            </div>
                        </div>
                    </div>

                    <table width="100%"></table>

                    <br><div class="modal-footer">
                        <p class="full-width">
                            <span class="buttons pull-left">
                                <input type="reset" value="Reset">
                                <input type="button" data-dismiss="modal" value ="Cancel">
                            </span>
                            <span class="buttons pull-right">
                                <input type="submit" value="Update Organization">
                            </span>
                        </p>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php } ?>

<script>
function myFunction() {
    var checkBox = document.getElementById("sendemail");
    var text = document.getElementById("password");
    if (checkBox.checked == true){
        text.style.display = "none";
    } else {
       text.style.display = "table-row-group";
    }
}
</script>

<script>
  $(document).ready(function () {    
    $('#utable').DataTable({
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


<!-- ajax search -->
<script>
$(document).ready(function(){

 load_data();

 function load_data(query)
 {
  $.ajax({
   url:"<?php echo site_url('staff_user_controller/fetch_org')?>?id=<?php echo $_REQUEST['id'] ?>",
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
