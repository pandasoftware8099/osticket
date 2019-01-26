    <div id="content">
        <h2>Ticket Settings and Options</h2>
<form class="form-horizontal" action="<?php echo site_url('admin_settings_controller/ticket_update')?>" method="post">

<div class="tab">
    <ul class="clean tabs">
        <li class="active"><a href="#settings"><i class="icon-asterisk"></i>
            Settings</a></li>
        <li><a href="#autoresp"><i class="icon-mail-reply-all"></i>
            Autoresponder</a></li>
        <li><a href="#alerts"><i class="icon-bell-alt"></i>
            Alerts and Notices</a></li>
    </ul>
</div>
<div class="tab_content" id="settings">
    <div class="section-break" style="margin-bottom:10px;">
        <em>System-wide default ticket settings and options.</em>
    </div>
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-4 control-label" style="padding-top:0px">Default Ticket Number Format<br/> (Range : 2 - 12)<span class="error">*</span> :</label>
        <div class="col-lg-6">
            <input type="number" name="ticket_number_format" id="ticket_number_format" class="form-control no-spin" min="2" max="12" value="<?php echo $ticket_number_format->row('value');?>" required>
            <div class="error"></div>
        </div>
        <div class="col-lg-2">
            <span class="faded">e.g. <span id="ticket_number_example"></span></span>
        </div>
    </div>
    
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-4 control-label"> Default Ticket Number Sequence :</label>
        <div class="col-lg-6">
            <select name="ticket_sequence_guid" class="form-control" id="ticket_sequence_guid">
                <option value="0" <?php if($ticket_seq=='0'){echo 'selected';}?>>— Random —</option>
                <?php foreach($ticket_seq_list->result() as $value){
                    if($ticket_seq==$value->sequence_guid){
                        echo '<option value="'.$value->sequence_guid.'" selected>'.$value->name.'</option>';
                    }else{
                    echo '<option value="'.$value->sequence_guid.'">'.$value->name.'</option>';
                               }}?>
                            </select>
        </div>
        <div class="col-lg-2">
            <a class="action-button" href="#" onclick="manage()"><i class="icon-gear"></i> Manage</a>
        </div>
    </div>
    <div class="form-group" style="overflow:auto;margin-bottom:0px;">
        <label class="col-lg-4 control-label"><!-- <i class="help-tip icon-question-sign" href="#default_ticket_status"></i> --> Default Status <span class="error">*</span> :
        </label>
        <div class="col-lg-8">
            <span>
                <select name="default_ticket_status" class="form-control">
                    <?php foreach ($default_status->result() as $value) { ?>
                        <option <?php echo ($value->status_guid == $defaultstatusid->row('value') )?"selected":""; ?> value="<?php echo $value->status_guid;?>"><?php echo $value->name;?></option>
                    <?php } ?>
                </select>
                &nbsp; <span class="error"></span>
            </span>
        </div>
    </div>
    <div class="form-group" style="overflow:auto;margin-bottom:0px;">
        <label class="col-lg-4 control-label"><!-- <i class="help-tip icon-question-sign" href="#default_priority"></i> --> Default Priority :</label>
        <div class="col-lg-8">
            <select name="default_priority" class="form-control">
                <?php foreach ($default_priority->result() as $value) { ?>
                    <option <?php echo ($value->priority_guid == $defaultpriorityid->row('value') )?"selected":""; ?> value="<?php echo $value->priority_guid;?>"><?php echo $value->priority_desc;?></option>
                <?php } ?>
            </select>
            &nbsp;<span class="error"></span>
        </div>
    </div>
    <div class="form-group" style="overflow:auto;margin-bottom:0px;">
        <label class="col-lg-4 control-label"><!-- <i class="help-tip icon-question-sign" href="#default_sla"></i> --> Default SLA <span class="error">*</span> :</label>
        <div class="col-lg-8">
            <span>
                <select name="default_sla" class="form-control">
                    <option value="0">— None —</option>
                    <?php foreach ($default_sla->result() as $value) { ?>
                    <option <?php echo ($value->sla_guid == $defaultslaid->row('value') )?"selected":""; ?> value="<?php echo $value->sla_guid;?>" selected="selected"><?php echo $value->sla_name;?></option>
                    <?php } ?>
                </select>
                &nbsp;<span class="error"></span>
            </span>
        </div>
    </div>
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-4 control-label">Default Help Topic :</label>
        <div class="col-lg-8">
            <select name="default_help_topic" class="form-control">
                <option value="0">— None —</option>
                <?php foreach($default_topic->result() as $topic) { ?>
                <option value="<?php echo $topic->topic_guid;?>" <?php echo $topic->topic_guid == $default_help_topic->row('value')?"selected":"";?>><?php echo $topic->topic;?></option>
                <?php } ?>
            </select>
            <span class="error"></span>
        </div>
    </div>

    <!-- <div class="form-group" style="overflow:auto;">
        <label class="col-lg-4 control-label">Lock Semantics :</label>
        <div class="col-lg-8">
            <select name="ticket_lock" class="form-control">
                                    <option value="0">Disabled</option>
                                    <option value="1" selected="selected">Lock on view</option>
                                    <option value="2">Lock on activity</option>
                            </select>
            <div class="error"></div>
        </div>
    </div> -->

    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-4 control-label" style="padding-top:0px"><!-- <i class="help-tip icon-question-sign" href="#maximum_open_tickets"></i> --> Maximum <b>Open</b> Tickets <span class="error">*</span> :</label>
        <div class="col-lg-8">
            <input type="text" name="max_open_tickets" size="4" value="<?php echo $max_open_tickets->value?>">
                per end user                <span class="error"></span>
        </div>
    </div>
    <!-- <div class="form-group" style="overflow:auto;">
        <label class="col-lg-4 control-label">
            <i class="help-tip icon-question-sign" href="#human_verification"></i> 
            Human Verification :
        </label>
        <div class="col-lg-8">
            <input type="checkbox" name="enable_captcha" checked="checked">
                Enable CAPTCHA on new web tickets.                &nbsp;<font class="error">&nbsp;</font>
        </div>
    </div> -->
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-4 control-label" style="padding-top:0px"><!-- <i class="help-tip icon-question-sign" href="#claim_tickets"></i> --> Claim on Response :</label>
        <div class="col-lg-8">
            <input type="hidden" name="auto_claim_tickets" value="0">
            <input type="checkbox" name="auto_claim_tickets" value="1" <?php echo $auto_claim_tickets->row('value') == 1?"checked":"";?>> Enable
        </div>
    </div>
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-4 control-label" style="padding-top:0px">
           <!--  <i class="help-tip icon-question-sign" href="#assigned_tickets"></i> --> Assigned Tickets :
        </label>
        <div class="col-lg-8">
            <input type="hidden" name="show_assigned_tickets" value="0">
            <input type="checkbox" name="show_assigned_tickets" value="1" <?php echo $show_assigned_tickets->row('value') == 1?"checked":"";?>>
                Exclude assigned tickets from open queue.        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-4 control-label" style="padding-top:0px"><!-- <i class="help-tip icon-question-sign" href="#answered_tickets"></i> --> Answered Tickets :</label>
        <div class="col-lg-8">
            <input type="hidden" name="show_answered_tickets" value="0">
            <input type="checkbox" name="show_answered_tickets" value="1" <?php echo $show_answered_tickets->row('value') == 1?"checked":"";?>>
                Exclude answered tickets from open queue.        </div>
    </div>
</div>
<div class="hiddens tab_content" id="autoresp" data-tip-namespace="settings.autoresponder" style="display: none;">
    <div class="section-break" style="margin-bottom:10px;">
    <em>Global setting - can be disabled at department or email level.</em>
</div>
<div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label" style="padding-top:1px"> New Ticket :</label>
    <div class="col-lg-9">
        <input type="hidden" name="ticket_autoresponder" value="0">
        <input type="checkbox" name="ticket_autoresponder" value="1" <?php echo $ticket_autoresponder == 1?"checked":"";?>>
            Ticket Owner&nbsp;
    </div>
</div>
<br><div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label" style="padding-top:1px"> New Ticket by Agent :</label>
    <div class="col-lg-9">
        <input type="hidden" name="ticket_notice_active" value="0">
        <input type="checkbox" name="ticket_notice_active" value="1" <?php echo $ticket_notice_active == 1?"checked":"";?>>
            Ticket Owner&nbsp;
    </div>
</div>
<br><div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label" style="padding-top:1px"> New Message :</label>
    <div class="col-lg-9">
        <input type="hidden" name="message_autoresponder" value="0">
        <input type="checkbox" name="message_autoresponder" value="1" <?php echo $message_autoresponder == 1?"checked":"";?>>
            Submitter: Send receipt confirmation&nbsp;
    </div>
</div>
<!-- <div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label" style="padding-top:1px">&nbsp;&nbsp;</label>
    <div class="col-lg-9">
        <input type="hidden" name="message_autoresponder_collabs" value="0">
        <input type="checkbox" name="message_autoresponder_collabs" value="1">
            Participants: Send new activity notice&nbsp;
    </div>
</div> -->
<br><div class="form-group" style="overflow:auto;margin-bottom:0px;">
    <label class="col-lg-3 control-label" style="padding-top:1px"> Overlimit Notice :</label>
    <div class="col-lg-8">
        <input type="hidden" name="overlimit_notice_active" value="0">
        <input type="checkbox" name="overlimit_notice_active" value="1" <?php echo $overlimit_notice_active == 1?"checked":"";?>>
            Ticket Submitter&nbsp;
    </div>
</div></div>
<div class="hiddens tab_content" id="alerts" data-tip-namespace="settings.alerts" style="display: none;">
    <table class="form_table settings_table" width="100%" border="0" cellspacing="0" cellpadding="2">
    <tbody>
        <tr><th><em></i> <b>New Ticket Alert</b> :
            </em></th></tr>
        <tr>
            <td><em><b>Status:</b></em> &nbsp;
                <input type="radio" name="ticket_alert_active" value="1" <?php echo $ticket_alert_active == 1?"checked":"";?>> Enable
                <input type="radio" name="ticket_alert_active" value="0" <?php echo $ticket_alert_active == 0?"checked":"";?>>
                 Disable                &nbsp;&nbsp;<font class="error">&nbsp;</font>
             </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="ticket_alert_admin" <?php echo $ticket_alert_admin == 1?"checked":"";?> value="1">
                Admin Email <em>(<?php echo $admin_email;?>)</em>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="ticket_alert_dept_manager" <?php echo $ticket_alert_dept_manager == 1?"checked":"";?> value="1">
                Department Manager            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="ticket_alert_dept_members" <?php echo $ticket_alert_dept_members == 1?"checked":"";?> value="1">
                Department Members            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="ticket_alert_acct_manager" <?php echo $ticket_alert_acct_manager == 1?"checked":"";?> value="1">
                Organization Account Manager/Team Leader</td>
        </tr>
        <tr><th><em><b>New Message Alert</b> :
            </em></th></tr>
        <tr>
            <td><em><b>Status:</b></em> &nbsp;
              <input type="radio" name="message_alert_active" value="1" <?php echo $message_alert_active == 1?"checked":"";?>> Enable              &nbsp;&nbsp;
              <input type="radio" name="message_alert_active" value="0" <?php echo $message_alert_active == 0?"checked":"";?>>
              Disable            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="message_alert_laststaff" <?php echo $message_alert_laststaff == 1?"checked":"";?> value="1">
                Last Respondent            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="message_alert_assigned" <?php echo $message_alert_assigned == 1?"checked":"";?> value="1">
              Assigned Agent / Team            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="message_alert_dept_manager" <?php echo $message_alert_dept_manager == 1?"checked":"";?> value="1">
              Department Manager            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="message_alert_acct_manager" <?php echo $message_alert_acct_manager == 1?"checked":"";?> value="1">
                Organization Account Manager/Team Leader</td>
        </tr>
        <tr><th><em><b>New Internal Activity Alert</b> :
            </em></th></tr>
        <tr>
            <td><em><b>Status:</b></em> &nbsp;
              <input type="radio" name="note_alert_active" value="1" <?php echo $note_alert_active == 1?"checked":"";?>>
                Enable              &nbsp;&nbsp;
              <input type="radio" name="note_alert_active" value="0" <?php echo $note_alert_active == 0?"checked":"";?>>
                Disable              &nbsp;&nbsp;&nbsp;<font class="error">&nbsp;</font>
            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="note_alert_laststaff" <?php echo $note_alert_laststaff == 1?"checked":"";?> value="1"> Last Respondent            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="note_alert_assigned" <?php echo $note_alert_assigned == 1?"checked":"";?> value="1">
                Assigned Agent / Team            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="note_alert_dept_manager" <?php echo $note_alert_dept_manager == 1?"checked":"";?> value="1">
                Department Manager            </td>
        </tr>
        <tr><th><em><b>Ticket Assignment Alert</b> :
            </em></th></tr>
        <tr>
            <td><em><b>Status: </b></em> &nbsp;
              <input name="assigned_alert_active" value="1" type="radio" <?php echo $assigned_alert_active == 1?"checked":"";?>> Enable              &nbsp;&nbsp;
              <input name="assigned_alert_active" value="0" type="radio" <?php echo $assigned_alert_active == 0?"checked":"";?>> Disable               &nbsp;&nbsp;&nbsp;<font class="error">&nbsp;</font>
            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="assigned_alert_staff" <?php echo $assigned_alert_staff == 1?"checked":"";?> value="1"> Assigned Agent            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="assigned_alert_team_lead" <?php echo $assigned_alert_team_lead == 1?"checked":"";?> value="1"> Team Lead            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="assigned_alert_team_members" <?php echo $assigned_alert_team_members == 1?"checked":"";?> value="1">
                Team Members            </td>
        </tr>
        <tr><th><em><b>Ticket Transfer Alert</b> :
            </em></th></tr>
        <tr>
            <td><em><b>Status:</b></em> &nbsp;
            <input type="radio" name="transfer_alert_active" value="1" <?php echo $transfer_alert_active == 1?"checked":"";?>>
                Enable            
            <input type="radio" name="transfer_alert_active" value="0" <?php echo $transfer_alert_active == 0?"checked":"";?>>
                Disable              &nbsp;&nbsp;&nbsp;<font class="error">&nbsp;</font>
            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="transfer_alert_assigned" <?php echo $transfer_alert_assigned == 1?"checked":"";?> value="1">
                Assigned Agent / Team            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="transfer_alert_dept_manager" <?php echo $transfer_alert_dept_manager == 1?"checked":"";?> value="1">
                Department Manager            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="transfer_alert_dept_members" <?php echo $transfer_alert_dept_members == 1?"checked":"";?> value="1">
                Department Members            </td>
        </tr>
        <tr><th><em><b>Overdue Ticket Alert</b> :
            </em></th></tr>
        <tr>
            <td><em><b>Status:</b></em> &nbsp;
              <input type="radio" name="overdue_alert_active" value="1" <?php echo $overdue_alert_active == 1?"checked":"";?>> Enable              
              <input type="radio" name="overdue_alert_active" value="0" <?php echo $overdue_alert_active == 0?"checked":"";?>> Disable              &nbsp;&nbsp;<font class="error">&nbsp;</font>
            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="overdue_alert_assigned" <?php echo $overdue_alert_assigned == 1?"checked":"";?> value="1"> Assigned Agent / Team            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="overdue_alert_dept_manager" <?php echo $overdue_alert_dept_manager == 1?"checked":"";?> value="1"> Department Manager            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="overdue_alert_dept_members" <?php echo $overdue_alert_dept_members == 1?"checked":"";?> value="1"> Department Members            </td>
        </tr>
        <tr><th>
            <em><b>System Alerts</b>: </em></th></tr>
        <tr>
            <td>
              <input type="checkbox" name="send_sys_errors" checked="checked" disabled="disabled">
                System Errors              <em>(enabled by default)</em>
            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="send_sql_errors">
                SQL errors            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="send_login_errors">
                Excessive failed login attempts            </td>
        </tr>
    </tbody>
</table>
</div>

<p style="text-align:center;">
    <input class="button" type="submit" name="submit" value="Save Changes">
    <input class="button" type="reset" name="reset" value="Reset Changes">
</p>
</form>


<script type="text/javascript">
    function random_number(digit)
    {   
        number_digit = digit.value;

        do
        {
            var random_number = Math.floor(Math.random()*'1E'.concat(number_digit));
        }
        while (random_number.toString().length != digit.value);

        return random_number;
    }

    function pad (str, max, padding) {  
        str = str.toString(); 
        padding = padding.toString(); 
        return str.length < max ? pad(padding + str, max, padding) : str; 
    }   
        var ticket_no_seq = document.getElementById("ticket_sequence_guid").options[document.getElementById("ticket_sequence_guid").selectedIndex].value;

    var random_number_digit = document.getElementById("ticket_number_format");
    if (ticket_no_seq == '0'){  
            document.getElementById("ticket_number_example").innerHTML = 'YYMMDD' + random_number(random_number_digit); 
             random_number_digit.onkeyup = function (){ 
                if (random_number_digit.value > 1 && random_number_digit.value < 13)    
                {       
                    document.getElementById("ticket_number_example").innerHTML = 'YYMMDD' + random_number(random_number_digit); 
                }   
                else    
                {   
                    do  
                    {                   
                        if (random_number_digit.value <= 1) 
                        {   
                            var random_number_minimum = Math.floor(Math.random()*1E2);  
                        }   
                        else if (random_number_digit.value >= 13)   
                        {   
                            var random_number_minimum = Math.floor(Math.random()*1E12); 
                        }   
                    }   
                    while (random_number_minimum.toString().length != 2 && random_number_minimum.toString().length != 12);
                    document.getElementById("ticket_number_example").innerHTML = 'YYMMDD' + random_number_minimum;
                }
            }
        }
        else
        {
                $.ajax({
                    url : "<?php echo site_url('admin_settings_controller/ticketlist?id='); ?>" + ticket_no_seq,
                    success : function(result){
                    result = JSON.parse(result);
                     document.getElementById("ticket_number_example").innerHTML = 'YYMMDD' + pad(result[0].next,random_number_digit.value,result[0].padding);   
                     random_number_digit.onkeyup = function (){ 
                        if (random_number_digit.value > 1 && random_number_digit.value < 13)    
                        {       
                            document.getElementById("ticket_number_example").innerHTML = 'YYMMDD' + pad(result[0].next,random_number_digit.value,result[0].padding);    
                        }   
                        else    
                        {   
                            do  
                            {                   
                                if (random_number_digit.value <= 1) 
                                {   
                                    var random_number_minimum = pad(result[0].next,2,result[0].padding);    
                                }   
                                else if (random_number_digit.value >= 13)   
                                {   
                                    var random_number_minimum = pad(result[0].next,12,result[0].padding);;  
                                }   
                            }   
                            while (random_number_minimum.toString().length != 2 && random_number_minimum.toString().length != 12);  
                             document.getElementById("ticket_number_example").innerHTML = 'YYMMDD' + random_number_minimum; 
                        }   
                    }   
                        
                  } 
                }); 
        }   
        
    $("#ticket_sequence_guid").change(function () {   
                var val = $(this).val();    
                if (val == '0'){    
            document.getElementById("ticket_number_example").innerHTML = 'YYMMDD' + random_number(random_number_digit); 
             random_number_digit.onkeyup = function (){ 
                if (random_number_digit.value > 1 && random_number_digit.value < 13)    
                {       
                    document.getElementById("ticket_number_example").innerHTML = 'YYMMDD' + random_number(random_number_digit); 
                }
                else
                {
                    do
                    {
                        if (random_number_digit.value <= 1) 
                        {   
                            var random_number_minimum = Math.floor(Math.random()*1E2);  
                        }   
                        else if (random_number_digit.value >= 13)   
                        {   
                            var random_number_minimum = Math.floor(Math.random()*1E12); 
                        }   
                    }   
                    while (random_number_minimum.toString().length != 2 && random_number_minimum.toString().length != 12);  
                     document.getElementById("ticket_number_example").innerHTML = 'YYMMDD' + random_number_minimum; 
                }
            }
        }
        else    
        {   
                
                $.ajax({    
                  url : "<?php echo site_url('admin_settings_controller/ticketlist?id='); ?>" + val,    
                  success : function(result){   
                    result = JSON.parse(result);    
                     document.getElementById("ticket_number_example").innerHTML = 'YYMMDD' + pad(result[0].next,random_number_digit.value,result[0].padding);   
                     random_number_digit.onkeyup = function (){ 
                        if (random_number_digit.value > 1 && random_number_digit.value < 13)    
                        {       
                            document.getElementById("ticket_number_example").innerHTML = 'YYMMDD' + pad(result[0].next,random_number_digit.value,result[0].padding);    
                        }   
                        else    
                        {   
                            do  
                            {                   
                                if (random_number_digit.value <= 1) 
                                {   
                                    var random_number_minimum = pad(result[0].next,2,result[0].padding);    
                                }   
                                else if (random_number_digit.value >= 13)   
                                {   
                                    var random_number_minimum = pad(result[0].next,12,result[0].padding);;  
                                }   
                            }   
                            while (random_number_minimum.toString().length != 2 && random_number_minimum.toString().length != 12);
                             document.getElementById("ticket_number_example").innerHTML = 'YYMMDD' + random_number_minimum;
                         }
                     }
                 }
             });
            }
        });
                
        
    function manage()
        {
          save_method = 'manage';
          $('#manage').modal('show'); // show bootstrap modal
        }
</script>
</div>

<div class="modal fade" id="manage" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <b><a class="close" href="#" data-dismiss="modal"><i class="icon-remove-circle"></i></a></b>
                <div class="body"><h3 class="drag-handle"><i class="icon-wrench"></i> Manage Sequences</h3>
            </div>
            <div class="modal-body form">
                
<hr>Sequences are used to generate sequential numbers. Various sequences can be
used to generate sequences for different purposes.<br>
<br>
<form method="post" action="<?php echo site_url('admin_settings_controller/ticket_seq_update?status=ticket')?>">

<div id="sequences">
<?php foreach($ticket_seq_list->result() as $value){?>
<div class="row-item">
    <div class="col-lg-10">
        <i class="icon-sort-by-order"></i>
        <div style="display:inline-block" class="name">
            <input type="text" value="<?php echo $value->name?>" name="name[]"></input>
        </div>
        <input type="hidden" value="<?php echo $value->sequence_guid?>" name="id[]">
    </div>
        <div class="manage-buttons col-lg-2">
            <span class="faded">next</span>
            <input type="number" value="<?php echo $value->next?>" name="next[]"></input>
        </div>
        <div class="button-group">
            <div class="delete new" style="border:none;">
                <a href="#" class="new"><i class="icon-trash"></i></a>
            </div>
            <div class="manage">
            </div>
        </div>
        <div class="management" data-id="1">
            <table width="100%"><tbody>
                <tr><td><label style="padding:0">Increment:
                    <input class="-increment" type="number" size="4" value="<?php echo $value->increment?>" name="increment[]">
                    </label></td>
                    <td><label style="padding:0">Padding Character:
                    <input class="-padding" maxlength="1" type="number" size="4" value="<?php echo $value->padding?>" name="padding[]">
                    </label></td></tr>
            </tbody></table>
        </div>
    </div> <?php } ?>
</div>

<div class="row-item hiddens">
    <div class="col-lg-10">
        <i class="icon-sort-by-order"></i>
        <div style="display:inline-block" class="name">
            <input type="text" value="" name="name[]"></input>
        </div>
    </div>
    <input type="hidden" value="" name="id[]">
        <div class="manage-buttons col-lg-2">
            <span class="faded">next</span>
            <input type="number" value="" name="next[]" value="0"></input>
        </div>
        <div class="button-group">
            <div class="delete new" style="border:none;">
                <a href="#" class="new"><i class="icon-trash"></i></a>
            </div>
            <div class="manage">
            </div>
        </div>
        <div class="management" data-id="1">
            <table width="100%"><tbody>
                <tr><td><label style="padding:0">Increment:
                    <input class="-increment" type="number" size="4" value="" name="increment[]" value="0">
                    </label></td>
                    <td><label style="padding:0">Padding Character:
                    <input class="-padding" maxlength="1" type="number" size="4" value="" name="padding[]" value="0">
                    </label></td></tr>
            </tbody></table>
        </div>
</div>

<br>
<a class="button" id="add_new"><i class="icon-plus"></i> Add New Sequence</a>
<div id="delete-warning" style="display:none">
<hr>
    <div id="msg_warning">Clicking <strong>Save Changes</strong> will permanently remove the
    deleted sequences.    </div>
</div>
<hr>


<script type="text/javascript">
$("#add_new").on('click',function(){
                    $('.row-item.hiddens').clone()
                        .find("input:text").val("").end()
                        .appendTo('#sequences')
                        .removeClass('hiddens')
                        .alert("div.row-item");
                });

$(document).on('click','.new', function() {
     $(this).closest('div.row-item').remove();
});
</script>
</div>
                </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-sm ">Save</button>
                      <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" >Cancel</button>
                  </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>