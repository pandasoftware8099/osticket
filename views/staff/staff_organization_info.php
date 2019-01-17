<div id="content">
    <div class="col-lg-12" style="min-height:50px;">
    <?php foreach ($orgresult->result() as $org) { ?>
        <h2 class="pull-left"><a href="orgs.php?id=4" title="Reload"><i class="icon-refresh"></i> <?php echo $org->name;?></a></h2>
        
        <?php if ($deleteorgallow != 0 ) { ?>
        <div class="pull-right">
            <a id="org-delete" class="red button action-button org-action"  data-toggle="modal" data-target="#deleteorg-modal"><i class="icon-trash"></i>
            Delete Organization</a>
        </div>
        <?php } ?>

    </div>
    <script type="text/javascript">
$(function() {

    $(document).off('.tickets');
    $(document).on('click.tickets', 'a.add-user', function(e) {
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

<div class="col-lg-6" style="padding:0px;">
    <table class="ticket_info" border="0" cellspacing="" cellpadding="4" width="100%">
        <tbody>
            <tr>
                <th width="160">Name</th>
                    <td>: 
                        <?php if ($editorgallow != 0 ) { ?>
                        <b>

                        <a data-toggle="modal" data-target="#editorg-modal" class="org-action"><i class="icon-edit"></i>
                        <?php echo $org->name;?> </a>

                        </b>
                        <?php } else {  ?>
          
         
                        <?php echo $org->name;?> 

                
                        <?php } ?>



                    </td>
            </tr>
            
            <tr>
                <th>Account Manager</th>
                <td>: 
                    <?php
                    if ($org->manager != "")
                    { ?>
                    <?php 
                        if ($org->manager{0} == 'a')
                        { ?>
                            <?php $staff_id = substr($org->manager, 1);?>

                            <?php echo $this->db->query("SELECT * FROM ost_staff_test
                                WHERE staff_id = '".$staff_id."'")->row('firstname');?> 
                            <?php echo $this->db->query("SELECT * FROM ost_staff_test
                                WHERE staff_id = '".$staff_id."'")->row('lastname');?>
                        <?php }

                        else if ($org->manager{0} == 't')
                        { ?>
                            <?php $team_id = substr($org->manager, 1);?>

                            <?php echo $this->db->query("SELECT * FROM ost_team_test
                                WHERE team_id = '".$team_id."'")->row('name');?>
                    <?php } ?>
                    <?php } ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="col-lg-6" style="padding:0px;">
     <table class="ticket_info" border="0" cellspacing="" cellpadding="4" width="100%">
        <tbody>
            <tr>
                <th width="160">Created</th>
                    <td>: <?php echo $org->orgcreated;?></td>
            </tr>
            <tr>
                <th>Last Updated</th>
                    <td>: <?php echo $org->orgupdated;?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php } ?>
<br>

<div class="clear"></div>
<div class="tab">
    <ul class="clean tabs" id="orgtabs">
        <li class="active"><a href="#users"><i class="icon-user"></i>&nbsp;Users</a></li>
        <li class=""><a href="#tickets"><i class="icon-list-alt"></i>&nbsp;Tickets</a></li>
        <li class=""><a href="#notes"><i class="icon-pushpin"></i>&nbsp;Note</a></li>
    </ul>
</div>
<div id="orgtabs_container">
<div class="tab_content" id="users" style="display: block;">

<form action="<?php echo site_url('staff_user_controller/org_infodeleteuser?id=').$_REQUEST['id']?>" method="POST" name="users" id="users">
<div class="pull-right flush-right" style="margin-bottom:10px;">

    <?php if ($adduserallow != 0 ) { ?>
    <a data-toggle="modal" data-target="#add-user-modal" class="green button action-button add-user"><i class="icon-plus"></i> Add User</a>
    

    <a data-toggle="modal" data-target="#import-modal" class="button action-button add-user">
        <i class="icon-cloud-upload icon-large"></i>
    Import</a>
    <?php } ?>

    <?php if ($deleteuserallow != 0 ) { ?>
    <a id="remove" data-toggle="modal" data-target="#delete-orguser-modal" class="button action-button add-user" href="#tickets/mass/transfer">
        <i class="icon-trash icon-large"></i>
    Remove</a>
    <?php } ?>

</div>

<div class="clear"></div>


    <div style="overflow:auto">
        <table class="list" border="0" cellspacing="1" cellpadding="0" width="100%" id="otable">
            <thead>
                <tr>
                    <th width="4%" style="text-align: center;"><input type="checkbox" name="tids[]" id="tidsall" onclick="checkedAll();"></th>
                    <th width="38%">Name</th>
                    <th width="35%">Email</th>
                    <th width="8%">Status</th>
                    <th width="15%">Created</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($userinfo->result() as $user) { ?>
                <tr>
                    <td align="center">
                        <input value="<?php echo $user->user_id;?>" type="checkbox" class="ckb" name="tids[]">
                    </td>
                    <td>
                        <a class="preview" href="<?php echo site_url('staff_user_controller/user_info');?>?id=<?php echo $user->user_id;?>"><?php echo $user->user_name;?></a>&nbsp;

                        <?php 
                        if ($this->db->query("SELECT COUNT(*) as ttotal FROM ost_ticket_test WHERE user_id = '".$user->user_id."'")->row('ttotal') != '0')
                        { ?>
                            <i class="icon-fixed-width icon-file-text-alt"></i>
                            <small>(<?php echo $this->db->query("SELECT COUNT(*) as ttotal FROM ost_ticket_test WHERE user_id = '".$user->user_id."'")->row('ttotal');?>)</small>
                        <?php } ?>
                    </td>
                    <td><?php echo $user->user_email;?></td>
                    <td>Active</td>
                    <td><?php echo $user->user_created_at;?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
</div>

<!-- Delete org user popup modal -->
<div class="modal fade" id="delete-orguser-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h3 class="drag-handle">Please Confirm</h3>
            </div>
            <div class="modal-body">

            <p class="confirm-action" style="" id="remove-users-confirm">Are you sure you want to <b>REMOVE</b> selected users from <strong>testing</strong>?    </p>
            <div>Please confirm to continue.</div>

            <br><div class="modal-footer">
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

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<!-- Delete org user popup modal -->

</form>

<div style="display: none; top: 54.75px; left: 559px;" class="dialog" id="confirm-action">
    <h3 class="drag-handle">Please Confirm</h3>
    <a class="close" href=""><i class="icon-remove-circle"></i></a>
    <hr>
    <p class="confirm-action" style="display:none;" id="remove-users-confirm">
        Are you sure you want to <b>REMOVE</b> selected users from <strong>teng</strong>?    </p>
    <div>Please confirm to continue.</div>
    <hr style="margin-top:1em">
    <p class="full-width">
        <span class="buttons pull-left">
            <input type="button" value="No, Cancel" class="close">
        </span>
        <span class="buttons pull-right">
            <input type="button" value="Yes, Do it!" class="confirm">
        </span>
     </p>
    <div class="clear"></div>
</div>


</div>
<div class="hiddens tab_content" id="tickets" style="display: none;">
<div>
<form action="users.php" method="POST" name="tickets" style="padding-top:10px;">
<input type="hidden" name="__CSRFToken__" value="9e9565f65d4b57de4a02e15b4a39519e63220d51"> <input type="hidden" name="a" value="mass_process">
    <input type="hidden" name="do" id="action" value="">
    <div style="overflow:auto;">
    <table class="list" border="0" cellspacing="1" cellpadding="2" id="ottable">
        <thead>
            <tr>
                <th width="4%" style="text-align: center;"><input type="checkbox" name="tidst[]" id="tidstall" onclick="checkedAllt();"></th>
                <th width="10%">Ticket</th>
                <th width="18%">Last Updated</th>
                <th width="8%">Status</th>
                <th width="30%">Subject</th>
                <th width="30%">User</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($tinfo->result() as $orgt) { ?>
            <tr id="19">
                <td align="center">
                        <input type="checkbox" class="ckb" name="tidst[]"></td>
                <td nowrap="">
                    <a class="Icon phoneTicket preview" title="Preview Ticket" href="<?php echo site_url('staff_ticket_controller/ticketinfo');?>?id=<?php echo $orgt->ticket_id;?>"><?php echo $orgt->number;?></a></td>
                <td nowrap=""><?php echo $orgt->ticket_updated;?></td>
                <td><?php echo $orgt->name;?></td>
                <td>
                    <a class="truncate " style="max-width: 230px;" href="<?php echo site_url('staff_ticket_controller/ticketinfo');?>?id=<?php echo $orgt->ticket_id;?>"><?php echo $orgt->topic;?></a>

                    <?php 
                    if ($this->db->query("SELECT COUNT(*) as ticketthread FROM ost_thread_entry_test WHERE ticket_id = '".$orgt->ticket_id."'")->row('ticketthread') != '0' && $this->db->query("SELECT COUNT(*) as ticketthread FROM ost_thread_entry_test WHERE ticket_id = '".$orgt->ticket_id."'")->row('ticketthread') != '1')
                    { ?>

                    <span class="pull-right faded-more">
                        <i class="icon-comments-alt"></i>
                            <small><?php echo $this->db->query("SELECT COUNT(*) as ticketthread FROM ost_thread_entry_test WHERE ticket_id = '".$orgt->ticket_id."'")->row('ticketthread');?></small>
                    </span>
                    <?php } ?>
                <td><a class="truncate" style="max-width:250px" href="<?php echo site_url('staff_user_controller/user_info');?>?id=<?php echo $orgt->user_id;?>" 3=""><?php echo $orgt->user_name;?> <em>&lt;<?php echo $orgt->user_email;?>&gt;</em></a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</form>
</div>
</div>

<div class="hiddens tab_content" id="notes" style="display: none;">
    <?php 
    if ($orgresult->row('orgnote') != "")
    { ?>
        <div id="quick-notes">
            <div class="quicknote">
                <div class="header">
                    <div class="header-left">
                        <i class="note-type icon-user" i="" title="Organization Note"></i>&nbsp;
                        <b><?php echo $orgresult->row('firstname');?> <?php echo $orgresult->row('lastname');?></b> posted <?php echo $orgresult->row('orgnote_created');?>
                    </div>

                    <div class="header-right">
                        <b>Latest Organization Note</b>
                    </div>
                </div>

                <div class="body">
                    <div class="row">
                        <div class="col-md-11" style="padding-left:0px">
                            <?php echo $orgresult->row('orgnote');?>
                        </div>
                    
                        <div class="col-md-1" style="padding-left:50px">
                            <a href="<?php echo site_url('staff_user_controller/deleteorgnote?id=').$_REQUEST['id']?>" class="action" title="Delete">
                                <i class="icon-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div id="new-note-box">
        <form action="<?php echo site_url('staff_user_controller/org_notes?id=').$_REQUEST['id']?>" method="POST" style="padding-top:10px;">
            <div class="box">
            <div class="box-header">

              <!-- tools box -->
              <div class="pull-right box-tools">

              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
                
                <textarea required="true" name="orgnote" id="task-response" class="textarea" placeholder="Start writing your note here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                
              
            </div>
            </div>
            
            <br><p class="submit" style="text-align: center;"><input type="submit" value="Create Note"></p>
        </form>
    </div>
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
<div id="loading" style="top: 219px; left: 533px;">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>
<div class="container dialog draggable ui-draggable size-normal" id="popup">
    <div id="popup-loading" style="display: none;">
        <h1 style="margin-bottom: 20px; margin-top: 6px;"><i class="icon-spinner icon-spin icon-large"></i>
        Loading ...</h1>
    </div>
    <div class="body"><div id="the-lookup-form">
<h3 class="drag-handle">Add User</h3>
<b><a class="close" href="#"><i class="icon-remove-circle"></i></a></b>
<hr>
<div><p id="msg_info"><i class="icon-info-sign"></i>&nbsp; Search existing users or add a new user.</p></div>
<div style="margin-bottom:10px;">
    <input type="text" class="search-input" style="width:100%;" placeholder="Search by name or email" id="user-search" autofocus="" autocorrect="off" autocomplete="off">
</div>
<div id="selected-user-info" style="display:none;margin:5px;">
<form method="post" class="user" action="#orgs/4/add-user">

    <i class="icon-user icon-4x pull-left icon-border"></i>
    <a class="action-button pull-right" style="overflow:inherit" id="unselect-user" href="#"><i class="icon-remove"></i>
        Add New User</a>
    <div class="clear"></div>
    <hr>
    <p class="full-width">
        <span class="buttons pull-left">
            <input type="button" name="cancel" class="close" value="Cancel">
        </span>
        <span class="buttons pull-right">
            <input type="submit" value="Continue">
        </span>
     </p>
</form>
</div>



<div class="clear"></div>
</div>

</div>
</div>
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

<!-- delete org popup modal -->
<?php foreach ($orgresult->result() as $info) { ?>
<div class="modal fade" id="deleteorg-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>

                    <h3 class="drag-handle">Delete <?php echo $info->name;?></h3>
            </div>
                        
                    
            <div class="modal-body">

            <p id="msg_warning">Deleted organization CANNOT be recovered</p>

            <div id="org-profile" style="margin:5px;">
                <i class="icon-group icon-4x pull-left icon-border"></i>
                <div><b> <?php echo $info->name;?></b></div>
                <table style="margin-top: 1em;">
                <tbody><tr><td colspan="2" style="border-bottom: 1px dotted black"><strong>Organization Information</strong></td></tr>
                <tr style="vertical-align:top"><td style="width:30%;border-bottom: 1px dotted #ccc">Address:</td>
                <td style="border-bottom: 1px dotted #ccc"><?php echo $info->address;?></td>
                </tr>
                <tr style="vertical-align:top"><td style="width:30%;border-bottom: 1px dotted #ccc">Phone:</td>
                <td style="border-bottom: 1px dotted #ccc"><?php echo $info->phone;?></td>
                </tr>
                <tr style="vertical-align:top"><td style="width:30%;border-bottom: 1px dotted #ccc">Website:</td>
                <td style="border-bottom: 1px dotted #ccc"><?php echo $info->website;?></td>
                </tr>
                <tr style="vertical-align:top"><td style="width:30%;border-bottom: 1px dotted #ccc">Internal Notes:</td>
                <td style="border-bottom: 1px dotted #ccc"><?php echo $info->orgnote;?></td>
                </tr>
                </tbody></table>
                <div class="clear"></div>
                <br><div>&nbsp;<strong><?php echo $userinfo->num_rows();?> user(s) assigned to this organization will be orphaned.</strong></div>
                <br><div class="modal-footer">
                <form method="delete" class="org" action="<?php echo site_url('staff_user_controller/org_infodelete?id=').$_REQUEST['id']?>">
                    <input type="hidden" name="id" value="<?php echo $_REQUEST['id']?>">
                    <p class="full-width">
                    <span class="buttons pull-left">
                        <input type="reset" value="Reset">
                        <input type="button" name="cancel" class="close" value="No, Cancel">
                    </span>
                    <span class="buttons pull-right">
                        <input type="submit" value="Yes, Delete">
                    </span>
                    </p>
                </form>
                </div>
            </div>


            </div>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<?php } ?>
<!-- delete org popup modal -->

<!-- editorg popup modal -->
<?php foreach ($orgresult->result() as $info) { ?>
<div class="modal fade" id="editorg-modal" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle"><?php echo $info->name;?></h3>
              </div>
              <div class="modal-body">

                <div class="tab_1">
                    <ul class="tabs_1" id="orgprofile">
                        <li class="active"><a href="#profile"><i class="icon-edit"></i>&nbsp;Fields</a></li>
                        <li class=""><a href="#contact-settings"><i class="icon-fixed-width icon-cogs faded"></i>&nbsp;Settings</a></li>
                    </ul>
                </div>

                <form class="form-horizontal" method="post" action="<?php echo site_url('staff_user_controller/org_infoeditorg?id=').$_REQUEST['id']?>" data-tip-namespace="org">
                    <div id="orgprofile_container">
                    <div class="tab_content_1" id="profile" style="margin: 5px; display: block;">
                        
                        <div class="col-lg-12">
                        <div class="section-break">
                            <em>
                                <strong>Organization Information</strong>: Details on user organization        </em>
                        </div>
                    </div><div>
                                                <!--<td class="multi-line required" style="min-width:120px;" >-->
                                    <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                        <label class="col-lg-3 control-label">
                                            Name                             <span class="error">*</span>
                                             :
                                        </label>
                                        <div class="col-lg-9">        <input type="text" class="form-control" id="_0a13065557002c40" size="40" maxlength="64" placeholder="" name="orgname" value="<?php echo $info->name;?>">
                                                    </div>
                                            </div>
                                                <!--<td class="multi-line " style="min-width:120px;" >-->
                                    <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                        <label class="col-lg-3 control-label">
                                            Address  :
                                        </label>
                                        <div class="col-lg-9">        <span style="display:inline-block;width:100%">
                            <textarea class="form-control" rows="2" cols="40" maxlength="100" placeholder="" id="_2adb0e2d057ade2d" name="orgadd"><?php echo $info->address;?></textarea>
                            </span>
                                                    </div>
                                            </div>
                                                <!--<td class="multi-line " style="min-width:120px;" >-->
                                    <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                        <label class="col-lg-3 control-label">
                                            Phone  :
                                        </label>
                                        <div class="col-lg-9">        <input id="_2988e2298d5b301e" type="tel" name="orgphone" value="<?php echo $phone;?>"> Ext:
                                <input type="text" name="orgphoneext" value="<?php echo $phoneext;?>" size="5">
                                                    </div>
                                            </div>
                                                <!--<td class="multi-line " style="min-width:120px;" >-->
                                    <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                        <label class="col-lg-3 control-label">
                                            Website  :
                                        </label>
                                        <div class="col-lg-9">        <input type="text" class="form-control" id="_8d9569c38592a85c" size="40" placeholder="" name="orgweb" value="<?php echo $info->website;?>">
                                                    </div>
                                            </div>
                                                <!--<td class="multi-line " style="min-width:120px;" >-->
                                    <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                        <label class="col-lg-3 control-label">
                                            Internal Notes  :
                                        </label>
                                        <div class="col-lg-9">        <span style="display:inline-block;width:100%">
                            <textarea class="form-control" rows="4" cols="40" placeholder="" id="_fea1db1e1e8b2e8e" name="orgnotes"><?php echo $info->orgnote;?></textarea>
                            </span>
                                                    </div>
                                            </div>
                            </div><table width="100%">
                        
                            </table>
                    </div>

                    <div class="hiddens tab_content_1" id="contact-settings" style="margin: 5px; display: none;">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" style="padding-top:0px">Account Manager :</label>
                            <div class="col-lg-9">
                                <select name="manager" class="form-control">
                                    <option value="">— None —</option>
                                        <optgroup label="Agents (<?php echo $orgstaff->num_rows();?>)">
                                        <?php foreach ($orgstaff->result() as $staff) { ?>
                                            <option value="a<?php echo $staff->staff_id;?>" <?php echo $orgresult->row('manager') == "a$staff->staff_id"?"selected":""; ?>><?php echo $staff->firstname;?> <?php echo $staff->lastname;?></option>
                                        <?php } ?>
                                        </optgroup>

                                        <optgroup label="Teams (<?php echo $orgteam->num_rows();?>)">
                                        <?php foreach ($orgteam->result() as $team) { ?>
                                            <option value="t<?php echo $team->team_id;?>" <?php echo $orgresult->row('manager') == "t$team->team_id"?"selected":""; ?>><?php echo $team->name;?></option>
                                        <?php } ?> 
                                        </optgroup>
                                </select>
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" style="padding-top:0px">Auto-Assignment :</label>
                            <div class="col-lg-9">
                                <?php foreach ($orgresult->result() as $org) { ?>
                                    <input type="checkbox" name="autoassign" value="1" <?php echo ($org->autoassignment == 1)?"checked":""; ?>>
                                <?php } ?>
                                    Assign tickets from this organization to the <em>Account Manager</em>        </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" style="padding-top:0px">Primary Contacts :</label>
                            <div class="col-lg-9">
                                <select name="contacts[]" class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select a State" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <?php foreach ($userinfo->result() as $user) { ?>
                                    <option value="<?php echo $user->user_id;?>" <?php echo $user->user_primary == 1?"selected":""; ?>><?php echo $user->user_name;?></option>
                                    <?php } ?>
                                </select>

                                <span class="selection">
                                    <span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="true" tabindex="-1" aria-owns="select2-zpy9-results" aria-activedescendant="select2-zpy9-result-7nak-Alabama">
                                    </span>
                                </span>
                                <span class="dropdown-wrapper" aria-hidden="true"></span>
                           </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Ticket Sharing :</label>
                            <div class="col-lg-9">
                                <?php foreach ($orgresult->result() as $org) { ?>
                                <select name="sharing" class="form-control">
                                    <option value="0" <?php echo ($org->ticketsharing == 0)?"selected":""; ?>>Disable</option>
                                    <option value="1" <?php echo ($org->ticketsharing == 1)?"selected":""; ?>>Primary contacts see all tickets</option>
                                    <option value="2" <?php echo ($org->ticketsharing == 2)?"selected":""; ?>>All members see all tickets</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Auto Add Members From :</label>
                            <div class="col-lg-9" style="padding-top:10px">
                                <input type="text" size="53" maxlength="60" name="domain" value="<?php echo $org->domain;?>">
                                <?php } ?>
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="clear"></div>
                    <div class="modal-footer">
                    <p class="full-width">
                        <span class="buttons pull-left">
                            <input type="reset" value="Reset">
                            <input type="button" name="cancel" class="close" value="Cancel">
                        </span>
                        <span class="buttons pull-right">
                            <input type="submit" value="Update Organization">
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
<!-- editorg popup modal -->

<!-- Add user popup modal -->
<div class="modal fade" id="add-user-modal" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h3 class="drag-handle">Lookup or add user</h3>
              </div>
              <div class="modal-body">

                <div><p id="msg_info"><i class="icon-info-sign"></i>&nbsp; Search existing users or add a new user.</p></div>

                <div style="margin-bottom:10px;">
                    <input type="text" class="search-input" style="width:100%;" placeholder="Search by name or email" type="text" name="search_text" id="search_text" autofocus="" autocorrect="off" autocomplete="off">
                    <form method="post" class="org" action="">
                    <div id="result" style="overflow: hidden;"></div>

                    </form>

                </div>
                    <div id="selected-user-info" style="display:none;margin:5px;">
                        <form method="post" class="user" action="#users/lookup">

                            <i class="icon-user icon-4x pull-left icon-border"></i>
                            <a class="action-button pull-right" style="overflow:inherit" id="unselect-user" href="#"><i class="icon-remove"></i>
                                Add New User</a>
                            <div class="clear"></div>
                            <hr>
                            <p class="full-width">
                                <span class="buttons pull-left">
                                    <input type="button" name="cancel" class="close" value="Cancel">
                                </span>
                                <span class="buttons pull-right">
                                    <input type="submit" value="Continue">
                                </span>
                             </p>
                        </form>
                    </div>

                    <div id="new-user-form" style="display:block;">
                        <form action="<?php echo site_url('staff_user_controller/org_infoadduser?id=').$_REQUEST['id']?>" method="post" class="user">
                            <div class="col-lg-12">
                            <div class="section-break">
                                <em> <strong>Create New User</strong>:         </em>
                            </div>
                            </div>
            <div>
                            <!--<td class="multi-line required" style="min-width:120px;" >-->
                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                    <label class="col-lg-3 control-label">
                        Email Address                             <span class="error">*</span>
                         :
                    </label>
                    <div class="col-lg-9">        <input type="email" class="form-control" id="_9cecd7ca5fcc96b6" size="40" maxlength="64" placeholder="" name="email" value="" required="true">
                    </div>
                </div>
                            <!--<td class="multi-line required" style="min-width:120px;" >-->
                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                    <label class="col-lg-3 control-label">
                        Full Name                             <span class="error">*</span>
                         :
                    </label>
                    <div class="col-lg-9">        <input type="text" class="form-control" id="_343f482466a3d4f1" size="40" maxlength="64" placeholder="" name="fullname" value="" required="true">
                    </div>
                </div>
                            <!--<td class="multi-line " style="min-width:120px;" >-->
                <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                    <label class="col-lg-3 control-label">
                        Phone Numbers  :
                    </label>
                    <div class="col-lg-9">        <input id="_459bd8d15e4ee311" type="tel" name="phone" value=""> Ext:
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
                        <textarea class="form-control" rows="4" cols="40" placeholder="" id="_2f9131add31b7f7d" name="note"></textarea>
                        </span>
                    </div>
                </div>
            </div>
                <table width="100%" class="fixed"></table>
              <br><div class="modal-footer">
 
                <p class="full-width">
                    <span class="buttons pull-left">
                        <input type="button" data-dismiss="modal" value ="Close">
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

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<!-- Add user popup modal -->

<!-- Import user popup modal -->
<div class="modal fade" id="import-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h3 class="drag-handle">Import Users</h3>
            </div>
            <div class="modal-body">

                <div class="tab_2">
                    <ul class="tabs_2" id="user-import-tabs">
                        <li class="active"><a href="#copy-paste"><i class="icon-edit"></i>&nbsp;Copy Paste</a></li>
                        <li><a href="#upload"><i class="icon-fixed-width icon-cloud-upload"></i>&nbsp;Upload</a></li>
                    </ul>
                </div>

                <div id="user-import-tabs_container">
                 <form method="post" action="<?php echo site_url('staff_user_controller/importcopy');?>?id=<?php echo $_REQUEST['id'];?>&direct=org" enctype="multipart/form-data">
                <div class="tab_content_2" id="copy-paste" style="margin:5px;">
                <h2 style="margin-bottom:10px">Name and Email</h2>
                <p>Enter one name, email address and phone number per line.<br><em>To import more other fields, use the Upload tab.</em>
                </p>
                <textarea name="pasted" style="display:block;width:100%;height:8em" placeholder="e.g. John Doe, john.doe@osticket.com, 012-3456789"></textarea>

                    <br>
                    <div class="modal-footer">
     
                        <p class="full-width">
                            <span class="buttons pull-left">
                                <input type="button" data-dismiss="modal" value ="Close">
                                <input type="reset" value="Reset">
                                
                            </span>

                            <span class="buttons pull-right">
                                
                                
                                <input type="submit" name="submit_file" value="Submit"/>
                    
                            </span>
                        </p>
                    </div>
                
                </div>
                </form>

                <div class="hiddens tab_content_2" id="upload" style="margin:5px;">
                <h2 style="margin-bottom:10px">Import a CSV File</h2>
                <p>
                <em>Use the columns shown in the table below. To add more fields, visit the Admin Panel -&gt; Manage -&gt; Forms -&gt; Contact Information page to edit the available fields.  Only fields with `variable` defined can be imported.</em></p><em>
                <table class="list" style="border: 1px solid black">
                <tbody>
                    <tr>
                        <th style="border: 1px solid black;padding: 5px;">Name</th>
                        <th style="border: 1px solid black;padding: 5px;">Email</th>
                        <th style="border: 1px solid black;padding: 5px;">Phone</th>
                        <th style="border: 1px solid black;padding: 5px;">Notes</th>
                    </tr>

                    <tr>
                        <td style="border: 1px solid black">John Doe</td>
                        <td style="border: 1px solid black">john.doe@osticket.com</td>
                        <td style="border: 1px solid black">012-3456789</td>
                        <td style="border: 1px solid black">Notes</td>
                    </tr>
                </tbody>
                </table>
                
                <br>
                <form method="post" action="<?php echo site_url('staff_user_controller/importcsv');?>?id=<?php echo $_REQUEST['id'];?>&direct=org" enctype="multipart/form-data">
                    <input type="file" name="file" required="true">
                    <br>
                    <div class="modal-footer">
     
                        <p class="full-width">
                            <span class="buttons pull-left">
                                <input type="button" data-dismiss="modal" value ="Close">
                                <input type="reset" value="Reset">
                                
                            </span>

                            <span class="buttons pull-right">
                                
                                
                                <input type="submit" name="submit_file" value="Submit"/>
                    
                            </span>
                        </p>
                    </div>
                </form>

                <div id="wrapper">
                 
                  
                 
                </div>




                </em></div><em>
                </em></div><em>


                </em>
                



            </div>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<!-- Import user popup modal -->



<script type="text/javascript">
    var checked=false;
    function checkedAll () 
    {
        var aa =  document.getElementsByName("tids[]");
        checked = document.getElementById('tidsall').checked;
         
        for (var i = 0; i < aa.length; i++) 
        {
            aa[i].checked = checked;
        }
    }
</script>

<script>
  $(document).ready(function () {    
    $('#otable').DataTable({
      "columnDefs": [{ "orderable": false, "targets": 0 }],
      'paging'      : true,
      'pageLength'  : <?php echo $max_page_size;?>,
      'searching'   : true,
      'ordering'    : true,
      'order'       : [ [1, 'asc'] ],
      'info'        : true,
      'autoWidth'   : true,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    })
  })
</script>

<script type="text/javascript">
    var checked=false;
    function checkedAllt () 
    {
        var aa =  document.getElementsByName("tidst[]");
        checked = document.getElementById('tidstall').checked;
         
        for (var i = 0; i < aa.length; i++) 
        {
            aa[i].checked = checked;
        }
    }
</script>

<script>
  $(document).ready(function () {    
    $('#ottable').DataTable({
      "columnDefs": [{ "orderable": false, "targets": 0 }],
      'paging'      : true,
      'pageLength'  : <?php echo $max_page_size;?>,
      'searching'   : true,
      'ordering'    : true,
      'order'       : [ [1, 'asc'] ],
      'info'        : true,
      'autoWidth'   : true,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    })
  })
</script>

<script type="text/javascript">
$(document).ready(function () {
    $('#remove').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ticket.");
        return false;
      }

    });

    

});

</script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    })
</script>

<!-- ajax search -->
<script>
$(document).ready(function(){

 load_data();

 function load_data(query)
 {
  $.ajax({
   url:"<?php echo site_url('staff_user_controller/fetch_user')?>?id=<?php echo $_REQUEST['id'] ?>",
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


<ul class="typeahead dropdown-menu" style="display: none;"></ul><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-html" style="display: none;">HTML</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-formatting" style="display: none;">Formatting</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-bold" style="display: none;">Bold</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-italic" style="display: none;">Italic</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-underline" style="display: none;">Underline</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-deleted" style="display: none;">Deleted</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-unorderedlist" style="display: none;">• Unordered List</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-orderedlist" style="display: none;">1. Ordered List</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-outdent" style="display: none;">&lt; Outdent</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-indent" style="display: none;">&gt; Indent</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-link" style="display: none;">Link</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-alignment" style="display: none;">Alignment</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-horizontalrule" style="display: none;">Insert Horizontal Rule</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-table" style="display: none;">Table</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-video" style="display: none;">Insert Video</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-fontcolor" style="top: 304px; left: 414.781px; display: none;">Font Color</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-backcolor" style="display: none;">Back Color</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-fontfamily" style="display: none;">Change Font Family</span></body></html>