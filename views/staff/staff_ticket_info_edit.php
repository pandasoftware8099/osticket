<div id="content">
        <form action="<?php echo site_url('staff_ticket_controller/ticketeditsubmit');?>?uid=<?php echo $_REQUEST['uid'];?>" method="post" class="save" enctype="multipart/form-data">
    <input type="hidden" name="__CSRFToken__" value="88e2535f17c73987d874e660ac61028d8435e0fb">    <input type="hidden" name="do" value="update">
    <input type="hidden" name="a" value="edit">
    <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
    <div style="overflow:auto; padding-top:5px;">
        <div class="pull-left flush-left">
            <?php foreach ($result->result() as $ticket) { ?>
                <h2>Update Ticket #<?php echo $ticket->number?></h2>
            <?php }?>
        </div>
    </div>
    <div class="section-break" style="margin-bottom:10px;">
        <em>
            <strong>User Information</strong>: Currently selected user        </em>
    </div>
        <div class="form-group" style="overflow:auto;">
        <label class="col-lg-2 control-label">User :</label>
        <div class="col-lg-10">
            <div id="client-info">
                <span data-toggle="modal" data-target="#uuser" id="updateuser" title="Update User">
                    <a href="#update"><i class="icon-user"></i>
                        <?php if ($_REQUEST['uid'] != "") { ?>  
                            <span id="client-name"><?php echo $newuser->row('user_name');?></span>
                            &lt;<span id="client-email"><?php echo $newuser->row('user_email');?></span>&gt;
                        <?php } elseif ($_REQUEST['uid'] == "") { ?>
                        <?php foreach ($user->result() as $value) { ?>    
                            <span id="client-name"><?php echo $value->user_name;?></span>
                            &lt;<span id="client-email"><?php echo $value->user_email;?></span>&gt;
                        <?php } ?>
                        <?php } ?>
                    </a>
                </span>

                <span data-toggle="modal" data-target="#cuser" id="changeuser" title="Change User">
                    <a class="inline action-button" style="overflow:inherit"><i class="icon-edit"></i> Change</a>
                </span>

            </div>
        </div>
    </div>

    <div class="section-break" style="margin-bottom:10px;">
        <em>
            <strong>Ticket Information</strong>: Due date overrides SLA's grace period.
        </em>
    </div>

    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-2 control-label required">
            Ticket Source <font class="error"><b>*</b></font>:
        </label>

        <div class="col-lg-10">
            <select name="source" class="form-control" required>
                <option>— Select Source —</option>
                <?php foreach ($result->result() as $source) { ?>
                <option value="Phone" <?php echo ($source->source == "Phone")?"selected":""; ?>>Phone</option>
                <option value="Email" <?php echo ($source->source == "Email")?"selected":""; ?>>Email</option>
                <option value="Web" <?php echo ($source->source == "Web")?"selected":""; ?>>Web</option>
                <option value="API" <?php echo ($source->source == "API")?"selected":""; ?>>API</option>
                <option value="Other" <?php echo ($source->source == "Other")?"selected":""; ?>>Other</option>
                <?php }?>
            </select>
            &nbsp;<font class="error">&nbsp;</font>
        </div>
    </div>

    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-2 control-label">
            Help Topic <font class="error"><b>*</b></font>:
        </label>

        <div class="col-lg-10">
            <select required="true" id="topic" name="topicId" class="form-control">
                    <option>— Select Help Topic —</option>
                <?php foreach ($topic->result() as $reason) { ?>   
                    <option value="<?php echo $reason->topic_guid?>" <?php echo $reason->topic_guid == $result->row('topic_guid')?"selected":"";?>><?php echo $reason->topic?></option>
                <?php }?>
            </select>
            &nbsp;<font class="error">&nbsp;</font>
        </div>
    </div>

    <div class="form-group subtopic" style="overflow:auto;">
        <label class="col-lg-2 control-label">
        Subtopic
            <span class="error">*</span>:
        </label>
                
        <div class="col-lg-10">        
            <select class="form-control" name="subtopicId" id="sub" data-placeholder="Select" required>
            <?php foreach ($current_sub->result() as $ori_sub) { ?>
                <option value = "<?php echo $ori_sub->list_item_guid;?>" <?php echo $ori_sub->list_item_guid == $result->row('subtopic_guid')?"selected":"";?>><?php echo $ori_sub->value;?></option>
            <?php } ?>
            </select>
            &nbsp;<font class="error">&nbsp;</font>
        </div>
    </div>

    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-2 control-label">
            SLA Plan :
        </label>

        <div class="col-lg-10">
            <select name="slaId" class="form-control">
                <option value="0">— None —</option>
                <?php foreach ($sla->result() as $sla) { ?>   
                    <option value="<?php echo $sla->sla_guid?>" <?php echo $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '".$_REQUEST['id']."'")->row('sla_guid') == "1"?"selected":""; ?>><?php echo $sla->sla_name?></option>
                <?php }?>
            </select>
            <font class="error">&nbsp;</font>
        </div>
    </div>

    <div class="form-group" style="overflow:auto;overflow-y:hidden;">
        <label class="col-lg-2 control-label">Due Date :</label>
        <div class="input-append date form_datetime">
            <?php foreach ($result->result() as $datetime) { ?> 
                <input style="margin-left: 16px" size="16" type="text" value="<?php echo $datetime->duedate?>" name="datetime" autocomplete="off" readonly>
            <?php }?>
            <span class="add-on"><i class="icon-calendar"></i></span>
            <span class="add-on"><i class="icon-remove"></i></span>&nbsp;
            <span class="faded">(MYT)</span>
        </div>
        <script type="text/javascript">
            $(".form_datetime").datetimepicker({
                format: "yyyy-mm-dd hh:ii",
                startDate: new Date(),
                autoclose: true,
                minuteStep: 10
            });
        </script>
    </div>

    <div>
        <input type="hidden" name="forms[]" value="549">

        <div class="section-break">
            <em>
                <div class="pull-right"></div>
                    <strong>Ticket Details</strong>: Please Describe The Issue
            </em>
        </div>
    </div>

        <!--<td class="multi-line " style="min-width:120px;" width="160">-->
    <div style="overflow:auto;margin-top:10px;">
        <label class="col-lg-2 control-label">
            Priority Level <font class="error"><b>*</b></font>:</label>
            <div class="col-lg-10">        
                <select class="form-control" name="priorityId" id="_4ab802de58eca46e" data-placeholder="Select" required>
                    <option value="">— Select —</option>
                    <?php foreach ($status->result() as $priority) { ?> 
                    <option value="<?php echo $priority->priority_guid?>" <?php echo $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '".$_REQUEST['id']."'")->row('priority_guid') == "$priority->priority_guid"?"selected":""; ?>><?php echo $priority->priority_desc?></option>
                    <?php }?>
                </select>
            </div>            
    </div>

    <div style="overflow:auto;margin-top:10px;">
        <div class="section-break">
            <em>
                <strong>Internal Note <span class="error">* </span></strong>: Reason for editing the ticket (required)
                <font class="error">&nbsp;</font>
            </em>
        </div>
    </div>

    <div class="box">
        <div class="box-header">

            <!-- tools box -->
            <div class="pull-right box-tools">

            </div>
            <!-- /. tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body pad">
            
            <textarea name="note" class="textarea" required="true" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

        </div>
    </div>

    <p style="text-align:center;overflow:auto;margin-top:10px;">
        <input type="submit" name="submit" value="Save">
        <input type="reset" name="reset" value="Reset">
    </p>

<div style="display: none; top: 50.6667px; left: 658.5px;" class="dialog draggable ui-draggable" id="user-lookup">
    <div class="body"></div>
</div>
<script type="text/javascript">
+(function() {
  var I = setInterval(function() {
    if (!$.fn.sortable)
      return;
    clearInterval(I);
    $('table.dynamic-forms').sortable({
      items: 'tbody',
      handle: 'th',
      helper: function(e, ui) {
        ui.children().each(function() {
          $(this).children().each(function() {
            $(this).width($(this).width());
          });
        });
        ui=ui.clone().css({'background-color':'white', 'opacity':0.8});
        return ui;
      }
    });
  }, 20);
})();
</script>
        <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css"></div>
</div></form>
</div></div>
</div>

<!-- change ticket status popup modal -->
<div class="modal fade" id="uuser" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <?php foreach ($user->result() as $uinfo) { ?>
                    <h3 class="drag-handle">Update <?php echo $uinfo->user_name?></h3>
            </div>

            <div class="modal-body">
                <div>
                    <p id="msg_info"><i class="icon-info-sign"></i>&nbsp; Please note that updates will be reflected system-wide.</p>
                </div>

                <form method="post" class="user" action="<?php echo site_url('staff_ticket_controller/ticket_user_update');?>?id=<?php echo $_REQUEST['id'];?>&status=edit">
                    <div class="col-lg-12">
                        <div class="section-break">
                            <em><strong>Contact Information</strong>:</em>
                        </div>
                    </div>

                    <div>
                        <!--<td class="multi-line required" style="min-width:120px;" >-->
                        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                            <label class="col-lg-3 control-label">
                            Email Address <span class="error">* </span>:
                            </label>

                            <div class="col-lg-9">
                                <input type="email" class="form-control" id="_7bcd4b587e038980" size="40" maxlength="64" placeholder="" name="cemail" value="<?php echo $uinfo->user_email;?>">
                            </div>
                        </div>

                        <!--<td class="multi-line required" style="min-width:120px;" >-->
                        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                            <label class="col-lg-3 control-label">
                            Full Name <span class="error">* </span>:
                            </label>

                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="_c414b1ec8bdcdabc" size="40" maxlength="64" placeholder="" name="cusername" value="<?php echo $uinfo->user_name;?>">
                            </div>
                        </div>

                        <!--<td class="multi-line " style="min-width:120px;" >-->
                        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                            <label class="col-lg-3 control-label">
                            Phone Numbers  :
                            </label>
                            
                            <div class="col-lg-9">
                                <input id="_6ac56d557e0dc9e5" type="tel" name="cphone" value="<?php echo $uinfo->user_phone;?>"> Ext:
                                <input type="text" name="cphoneext" value="<?php echo $uinfo->user_phoneext;?>" size="5">
                            </div>
                        </div>

                        <!--<td class="multi-line " style="min-width:120px;" >-->
                        <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                            <label class="col-lg-3 control-label">
                            Internal Notes  :
                            </label>

                            <div class="col-lg-9">
                                <span style="display:inline-block;width:100%">
                                    <textarea class="form-control" rows="4" cols="40" placeholder="" id="_1d0639a7ce79c22a" name="cnote" value=""><?php echo $uinfo->notes;?></textarea>
                                </span>
                            </div>
                        </div>
                    </div>

                    <table width="100%"></table>

            <br><div class="modal-footer">
                <p class="full-width">
                    <span class="buttons pull-left">
                        <input type="button" data-dismiss="modal" value ="Close">
                        <input type="reset" value="Reset">
                    </span>

                    <span class="buttons pull-right">
                        <input type="submit" value="Update User">
                    </span>
                </p>
            </div>
                </form>
            </div>
            <?php }?>  
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

  <!-- change ticket status popup modal -->
<div class="modal fade" id="cuser" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <?php foreach ($result->result() as $ticket) { ?>
                    <h3 class="drag-handle">Change User for Ticket #<?php echo $ticket->number?></h3>
                <?php }?>  
            </div>

            <div class="modal-body">
                <div><p id="msg_info"><i class="icon-info-sign"></i>&nbsp; Search existing users or add a new user.</p></div>

                <div style="margin-bottom:10px;">
                    <input type="text" class="search-input" style="width:100%;" placeholder="Search by name or email" name="user_search" id="user_search" autofocus="" autocorrect="off" autocomplete="off">
                    <div id="result" style="overflow: hidden;"></div>
                </div>

                <div id="selected-user-info" style="display:block;margin:5px;">
                    <div class="avatar pull-left" style="margin: 0 10px;">
                        <img class="avatar" alt="Avatar" src="//www.gravatar.com/avatar/591979a746b57c8ed09bca89133daeff?s=80&amp;d=mm">
                    </div>

                    <span data-toggle="modal" data-target="#nuser" id="newuser" title="Change User">
                        <a class="action-button pull-right" style="overflow:inherit" id="unselect-user" href="#addnewuser">
                        <i class="icon-plus-sign"></i> Add New User</a>
                    </span>

                    <?php foreach ($user->result() as $uinfo) { ?>
                        <div><strong id="user-name"><?php echo $uinfo->user_name?></strong></div>
                        <div>&lt;<span id="user-email"><?php echo $uinfo->user_email?></span>&gt;</div>
                        <div><span id="user-org"><?php echo $this->db->query("SELECT * FROM ost_user_test AS a INNER JOIN ost_organization_test AS b ON a.user_org_guid = b.organization_guid WHERE user_guid = '".$uinfo->user_guid."'")->row('name')?></span></div>

                    <table style="margin-top: 1em;">
                        <tbody>
                            <tr>
                                <td colspan="2" style="border-bottom: 1px dotted black"><strong>Contact Information</strong></td>
                            </tr>

                            <tr style="vertical-align:top">
                                <td style="width:40%;border-bottom: 1px dotted #ccc">Phone Numbers</td>
                                <td style="border-bottom: 1px dotted #ccc"> : <?php echo $phone?></td>
                            </tr>

                            <tr style="vertical-align:top">
                                <td style="width:40%;border-bottom: 1px dotted #ccc">Internal Notes</td>
                                <td style="border-bottom: 1px dotted #ccc"> : <?php echo $uinfo->notes?></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php }?>
                    <hr>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Add user popup modal -->
<div class="modal fade" id="nuser" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <?php foreach ($result->result() as $ticket) { ?>
                    <h3 class="drag-handle">Change User for Ticket #<?php echo $ticket->number?></h3>
                <?php }?>
            </div>
              
            <div class="modal-body">
                <div><p id="msg_info">
                    <i class="icon-info-sign"></i>
                    &nbsp; Search existing users or add a new user.</p>
                </div>

                <div id="new-user-form" style="display:block;">
                    <form action="<?php echo site_url('staff_user_controller/createuser');?>?id=<?php echo $_REQUEST['id'];?>&direct=tinfoedit" method="post" class="user">
                        <div class="col-lg-12">
                        <div class="section-break">
                            <em><strong>Create New User </strong>:</em>
                        </div>
                        </div>

                            <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                <label class="col-lg-3 control-label">
                                Email Address <span class="error">* </span>:
                                </label>

                                <div class="col-lg-9">
                                    <input type="email" class="form-control" id="_9cecd7ca5fcc96b6" size="40" maxlength="64" placeholder="" name="email" value="" required="true">
                                </div>
                            </div>

                            <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                <label class="col-lg-3 control-label">
                                Full Name <span class="error">* </span>:
                                </label>

                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="_343f482466a3d4f1" size="40" maxlength="64" placeholder="" name="fullname" value="" required="true">
                                </div>
                            </div>

                            <div class="col-lg-12" style="overflow:auto;margin-top:10px;">
                                <label class="col-lg-3 control-label">
                                Phone Numbers :
                                </label>

                                <div class="col-lg-9">
                                    <input id="_459bd8d15e4ee311" type="tel" name="phone" value=""> Ext :
                                    <input type="text" name="phoneext" value="" size="5">
                                </div>
                            </div>

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

            <table width="100%" class="fixed"></table>
            <div class="modal-footer" style="overflow:auto;margin-top:10px;">
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

<script type="text/javascript">
  
$(document).ready(function () {
    $("#topic").change(function () {
        var val = $(this).val();

        $.ajax({
          url : "<?php echo site_url('staff_ticket_controller/subtopic?id='); ?>" + val,
          success : function(result){
            result = JSON.parse(result);

            html = "";
            for(i = 0; i < result.length; i++)
            {
              html += "<option value='"+ result[i].id +"' selected>" + result[i].VALUE + "</option>";
            }

            $('#sub').html(html);
          }
        });
    });
});

</script>

<!-- ajax search -->
<script>
$(document).ready(function(){

    load_data();

    function load_data(query)
    {
        $.ajax({
            url:"<?php echo site_url('staff_ticket_controller/fetch_user')?>?id=<?php echo $_REQUEST['id']?>&direct=tinfo",
            method:"POST",
            data:{query:query},
            success:function(data){
                $('#result').html(data);
            }
        })
    }

    $('#user_search').keyup(function(){
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