<div id="content">
    <h2>Task Settings and Options</h2>
<form class="form-horizontal" action="<?php echo site_url('admin_settings_controller/task_update')?>" method="post">
<input type="hidden" name="__CSRFToken__" value="90f6d24e10ae504160eb2be50461de3ff8cd5892"><input type="hidden" name="t" value="tasks">

<div class="tab">
    <ul class="tabs" id="tasks-tabs">
        <li class="active"><a href="#settings">
            <i class="icon-asterisk"></i> Settings</a></li>
        <li><a href="#alerts">
            <i class="icon-bell-alt"></i> Alerts &amp; Notices</a></li>
    </ul>
</div>
<div id="tasks-tabs_container">
   <div id="settings" class="tab_content">
        <div class="section-break" style="margin-bottom:10px;">
            <em>Global default task settings and options.</em>
        </div>
        <div class="form-group" style="overflow:auto;">
        <label class="col-lg-4 control-label" style="padding-top:0px"><i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box');" onmouseleave="MouseOut('tip_box')"></i> Default Task Number Format<br/> (Range : 2 - 12)<span class="error">*</span> :</label>
        <div class="col-lg-6">
            <input type="number" name="ticket_number_format" id="ticket_number_format" class="form-control no-spin" min="2" max="12" value="<?php echo $ticket_number_format->row('value');?>" required>
            <div class="error"></div>
        </div>
        <div class="col-lg-2">
            <span class="faded">e.g. <span id="ticket_number_example"></span></span>
        </div>
    </div>
    
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-4 control-label"><i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box1');" onmouseleave="MouseOut('tip_box1')"></i> Default Task Number Sequence :</label>
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
   </div>
<div class="hiddens tab_content" id="alerts" data-tip-namespace="settings.alerts" style="display: none;">
    <table class="form_table settings_table" width="100%" border="0" cellspacing="0" cellpadding="2">
    <tbody>
        <tr><th><em><i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box2');" onmouseleave="MouseOut('tip_box2')"></i><b>  New Task Alert</b> :
            </em></th></tr>
        <tr>
            <td><em><b>Status:</b></em> &nbsp;
                <input type="radio" name="task_alert_active" value="1" <?php echo $task_alert_active == 1?"checked":"";?>> Enable
                <input type="radio" name="task_alert_active" value="0" <?php echo $task_alert_active == 0?"checked":"";?>>
                 Disable                &nbsp;&nbsp;<font class="error">&nbsp;</font>
             </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="task_alert_admin" <?php echo $task_alert_admin == 1?"checked":"";?> value="1">
                Admin Email <em>(<?php echo $admin_email;?>)</em>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="task_alert_dept_manager" <?php echo $task_alert_dept_manager == 1?"checked":"";?> value="1">
                Department Manager            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="task_alert_dept_members" <?php echo $task_alert_dept_members == 1?"checked":"";?> value="1">
                Department Members            </td>
        </tr>
        <tr><th><em><i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box3');" onmouseleave="MouseOut('tip_box3')"></i><b>  New Message Alert</b> :
            </em></th></tr>
        <tr>
            <td><em><b>Status:</b></em> &nbsp;
              <input type="radio" name="task_activity_alert_active" value="1" <?php echo $task_activity_alert_active == 1?"checked":"";?>> Enable              &nbsp;&nbsp;
              <input type="radio" name="task_activity_alert_active" value="0" <?php echo $task_activity_alert_active == 0?"checked":"";?>>
              Disable            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="task_activity_alert_laststaff" <?php echo $task_activity_alert_laststaff == 1?"checked":"";?> value="1">
                Last Respondent            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="task_activity_alert_assigned" <?php echo $task_activity_alert_assigned == 1?"checked":"";?> value="1">
              Assigned Agent / Team            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="task_activity_alert_dept_manager" <?php echo $task_activity_alert_dept_manager == 1?"checked":"";?> value="1">
              Department Manager            </td>
        </tr>
        <tr><th><em><i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box4');" onmouseleave="MouseOut('tip_box4')"></i><b>  Task Assignment Alert</b> :
            </em></th></tr>
        <tr>
            <td><em><b>Status: </b></em> &nbsp;
              <input name="task_assignment_alert_active" value="1" type="radio" <?php echo $task_assignment_alert_active == 1?"checked":"";?>> Enable              &nbsp;&nbsp;
              <input name="task_assignment_alert_active" value="0" type="radio" <?php echo $task_assignment_alert_active == 0?"checked":"";?>> Disable               &nbsp;&nbsp;&nbsp;<font class="error">&nbsp;</font>
            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="task_assignment_alert_staff" <?php echo $task_assignment_alert_staff == 1?"checked":"";?> value="1"> Assigned Agent            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="task_assignment_alert_team_lead" <?php echo $task_assignment_alert_team_lead == 1?"checked":"";?> value="1"> Team Lead            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="task_assignment_alert_team_members" <?php echo $task_assignment_alert_team_members == 1?"checked":"";?> value="1">
                Team Members            </td>
        </tr>
        <tr><th><em><i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box5');" onmouseleave="MouseOut('tip_box5')"></i><b>  Task Transfer Alert</b> :
            </em></th></tr>
        <tr>
            <td><em><b>Status:</b></em> &nbsp;
            <input type="radio" name="task_transfer_alert_active" value="1" <?php echo $task_transfer_alert_active == 1?"checked":"";?>>
                Enable            
            <input type="radio" name="task_transfer_alert_active" value="0" <?php echo $task_transfer_alert_active == 0?"checked":"";?>>
                Disable              &nbsp;&nbsp;&nbsp;<font class="error">&nbsp;</font>
            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="task_transfer_alert_assigned" <?php echo $task_transfer_alert_assigned == 1?"checked":"";?> value="1">
                Assigned Agent / Team            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="task_transfer_alert_dept_manager" <?php echo $task_transfer_alert_dept_manager == 1?"checked":"";?> value="1">
                Department Manager            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="task_transfer_alert_dept_members" <?php echo $task_transfer_alert_dept_members == 1?"checked":"";?> value="1">
                Department Members            </td>
        </tr>
        <tr><th><em><i class="icon-question-sign" onmouseenter="MouseOver(event,'tip_box6');" onmouseleave="MouseOut('tip_box6')"></i><b>  Overdue Task Alert</b> :
            </em></th></tr>
        <tr>
            <td><em><b>Status:</b></em> &nbsp;
              <input type="radio" name="task_overdue_alert_active" value="1" <?php echo $task_overdue_alert_active == 1?"checked":"";?>> Enable              
              <input type="radio" name="task_overdue_alert_active" value="0" <?php echo $task_overdue_alert_active == 0?"checked":"";?>> Disable              &nbsp;&nbsp;<font class="error">&nbsp;</font>
            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="task_overdue_alert_assigned" <?php echo $task_overdue_alert_assigned == 1?"checked":"";?> value="1"> Assigned Agent / Team            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="task_overdue_alert_dept_manager" <?php echo $task_overdue_alert_dept_manager == 1?"checked":"";?> value="1"> Department Manager            </td>
        </tr>
        <tr>
            <td>
              <input type="checkbox" name="task_overdue_alert_dept_members" <?php echo $task_overdue_alert_dept_members == 1?"checked":"";?> value="1"> Department Members            </td>
        </tr>
    </tbody>
</table>
</div>
<p style="text-align:center;">
    <input class="button" type="submit" name="submit" value="Save Changes">
    <input class="button" type="reset" name="reset" value="Reset Changes">
</p>
</form>

<div class="tip_box" id="tip_box" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>Task Number Format</h1>This setting is used to generate task numbers. Use hash signs (`#`) where digits are to be placed. Any other text in the number format will be preserved. <br><br> For example, for six-digit numbers, use <code>######</code>.
    </div>
</div>

<div class="tip_box" id="tip_box1" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>Task Number Sequence</h1>Choose a sequence from which to derive new task numbers. The system has a incrementing sequence and a random sequence by default. You may create as many sequences as you wish.
    </div>
</div>

<div class="tip_box" id="tip_box2" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>New Task Alert</h1><p> Alert sent out to Agents when a new task is created. </p><p class="info-banner"> <i class="icon-info-sign"></i> This alert is not sent out if the task is auto-assigned. </p>
    </div>
</div>

<div class="tip_box" id="tip_box3" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>New Activity Alert</h1>Alert sent out to Agents when a new message is appended to an existing task.
    </div>
</div>

<div class="tip_box" id="tip_box4" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>Task Assignment Alert</h1>Alert sent out to Agents on task assignment.
    </div>
</div>

<div class="tip_box" id="tip_box5" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>Task Transfer Alert</h1>Alert sent out to Agents on task transfer between Departments.
    </div>
</div>

<div class="tip_box" id="tip_box6" style="display:none;">
    <div class="tip_content"><a href="#" class="tip_close"><i class="icon-remove-circle"></i></a><img src="./images/tip_arrow.png" class="tip_arrow"><h1><i class="icon-info-sign faded"> </i>Overdue Task Alert</h1>Alert sent out to Agents when a task becomes overdue based on SLA or Due Date.
    </div>
</div>

<script type="text/javascript">
function MouseOver(e,divid) {
    var left  = e.clientX  + "px";
    var top  = e.clientY  + "px";

    var div = document.getElementById(divid);

    div.style.display = 'block';
    div.style.left = left;
    div.style.top = top;
    $("#" + divid).stop();    
}

function MouseOut(divid) {
    document.getElementById(divid).style.display = 'none';
    $("#" + divid).stop();
}

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
<form method="post" action="<?php echo site_url('admin_settings_controller/ticket_seq_update?status=task')?>">

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