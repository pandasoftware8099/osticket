<div id="content">
    <form action="<?php echo site_url('staff_ticket_controller/opennew');?>" class="form-horizontal" method="post" enctype="multipart/form-data">
        <input type="hidden" name="__CSRFToken__" value="516e28215ca94e12bc64f23b500ef1d31c4e6b31">
        <input type="hidden" name="do" value="create">
        <input type="hidden" name="a" value="open">
 
        <div style="padding-bottom:10px;">
            <div class="col-lg-12" style="padding-top:5px;">
                <div class="pull-left flush-left">
                    <h2>Open a New Ticket</h2>
                </div>
            </div>

            <div class="col-lg-12">
                <div style="text-align:left;border:1px solid #ccc; background: #eee; padding:5px;">
                    <em><strong>User Information</strong>: (Search existing user or key in user)</em>
                    <div class="error"></div>
                </div>
            </div>

            <?php if ($_REQUEST['id'] != "") { ?>
            <div class="col-lg-12" style="margin-top:10px;">
                <div class="form-group" style="margin-bottom:5px;">
                    <div class="col-sm-12" style="margin-bottom:10px;">
                        <input type="text" class="search-input" style="width:100%;" placeholder="Search by name or email" type="text" name="search_text" id="search_text" autofocus="" autocorrect="off" autocomplete="off">
                        <div id="result" style="overflow: hidden;"></div>
                    </div>
                    
                    <label for="inputEmail3" class="col-sm-2 control-label">Email Address <span class="error">*</span></label>
                    
                    <div class="col-sm-10">
                        <div class="input-group input-group-sm" style="width: 100%">
                            <input style="border-radius: 5px;" type="text" size="45" name="email" id="user-email" class="form-control attached" autocomplete="off" autocorrect="off" value="<?php echo $userinfo->row('user_email')?>" required>
                        </div>

                        <div class="error"> </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12" style="margin-top:10px;">
                <div class="form-group" style="margin-bottom:5px;">
                    <label for="inputEmail3" class="col-sm-2 control-label">Full Name 
                        <span class="error">*</span>
                    </label>
                    
                    <div class="col-sm-10">
                        <input type="text" size="45" name="name" id="user-name" class="form-control" value="<?php echo $userinfo->row('user_name')?>" required>
                        <div class="error"></div>
                    </div>
                </div>
            </div>
            <?php }

            elseif ($_REQUEST['id'] == "") { ?>
            <div class="col-lg-12" style="margin-top:10px;">
                <div class="form-group" style="margin-bottom:5px;">
                    <div class="col-sm-12" style="margin-bottom:10px;">
                        <input type="text" class="search-input" style="width:100%;" placeholder="Search by name or email" type="text" name="search_text" id="search_text" autofocus="" autocorrect="off" autocomplete="off">
                        <div id="result" style="overflow: hidden;"></div>
                    </div>
                
                    <label for="inputEmail3" class="col-sm-2 control-label">Email Address <span class="error">*</span></label>

                    <div class="col-sm-10">
                        <div class="input-group input-group-sm" style="width: 100%">
                            <input style="border-radius: 5px;" type="text" size="45" name="email" id="user-email" class="form-control attached" autocomplete="off" autocorrect="off" value="" required>
                        </div>

                        <div class="error"> </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12" style="margin-top:10px;">
                <div class="form-group" style="margin-bottom:5px;">
                    <label for="inputEmail3" class="col-sm-2 control-label">Full Name 
                        <span class="error">*</span>
                    </label>
                      
                    <div class="col-sm-10">
                        <input type="text" size="45" name="name" id="user-name" class="form-control" value="" required>
                        <div class="error"></div>
                    </div>
                </div>
            </div>
            <?php } ?>

<div class="col-lg-12" style="margin-top:10px;">
    <div class="form-group" style="margin-bottom:5px;">
        <label for="inputEmail3" class="col-sm-2 control-label" style="padding-top:4px;">Ticket Notice</label>
        <div class="col-sm-10">
            <div class="checkbox" style="padding-left:20px;">
                <input type="checkbox" style="margin-top:10px;" name="alertuser" value="1" checked="checked">Send alert to user.
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12" style="margin-top:10px;">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label" style="padding-top:0px;">Signature</label>
        <div class="col-sm-10">
            <label><input type="radio" name="signature" value="none" checked="checked"> None</label>
            <label><input type="radio" name="signature" value="mine"> My Signature</label>
            <label><input type="radio" name="signature" value="dept"> Department Signature (if set)</label>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div style="text-align:left;border:1px solid #ccc; background: #eee; padding:5px;">
        <em><strong>Ticket Information and Options</strong></em>
    </div>
</div>
<div class="col-lg-12" style="margin-top:10px;">
    <div class="form-group" style="margin-bottom:5px;">
        <label for="inputEmail3" class="col-sm-2 control-label">Ticket Source <font class="error"><b>*</b></font></label>
          <div class="col-sm-10">
            <select name="source" class="form-control" required>
                <option value="">— Select Source —</option>
                <option value="Phone">Phone</option>
                <option value="Email">Email</option>
                <option value="Web">Web</option>
                <option value="API">API</option>
                <option value="Other">Other</option>
            </select>
                &nbsp;<font class="error">&nbsp;</font>
          </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="form-group" style="margin-bottom:5px;">
        <label for="inputEmail3" class="col-sm-2 control-label">Help Topic <font class="error"><b>*</b></font></label>
          <div class="col-sm-10">
            <select name="topicId" class="form-control" id="topic" required>
            <option value="" selected="">— Select Help Topic —</option>
            <?php foreach ($stafftopic->result() as $topic) { ?>   
              <option value="<?php echo $topic->topic_id?>" <?php echo $topic->topic_id == $default_help_topic->row('value')?"selected":"";?>><?php echo $topic->topic?></option>
            <?php }?>
            </select>
                &nbsp;<font class="error">&nbsp;</font>
          </div>
    </div>
</div>
<!--<td class="multi-line required" style="min-width:120px;" >-->
<div class="col-lg-12">
    <div class="form-group" style="margin-bottom:5px">
    <label class="col-sm-2 control-label">Subtopic
        <font class="error"><b>*</b></font></label>
        <div class="col-sm-10">
            <select class="form-control" name="subId" id="sub" data-placeholder="Select" required>
            <?php if ($default_help_topic->row('value') != '0') { ?>
            <?php foreach ($current_sub->result() as $sub) { ?>
                <option value="<?php echo $sub->id;?>"><?php echo $sub->value;?></option>
            <?php } ?>
            <?php } ?>
            </select>
            &nbsp;<font class="error"></font>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="form-group" style="margin-bottom:5px;">
        <label for="inputEmail3" class="col-sm-2 control-label">Department <font class="error"><b>*</b></font></label>
          <div class="col-sm-10">
            <select name="deptId" class="form-control" required>
                <option value="" selected="">— Select Department—</option>
                <?php foreach ($staffdepart->result() as $depart) { ?>   
                <option value="<?php echo $depart->id?>"><?php echo $depart->name?></option>
                <?php }?>
            </select>
                &nbsp;<font class="error"></font>
          </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="form-group" style="margin-bottom:5px;">
    <label class="col-sm-2 control-label">
    Priority Level <font class="error"><b>*</b></font></label>

    <div class="col-sm-10">
        <select class="form-control" name="priorityId" id="priorityId" data-placeholder="Select" required>
            <option value="">— Select —</option>
            <?php foreach ($priority->result() as $ticket_priority) { ?>
            <option value="<?php echo $ticket_priority->priority_id;?>" <?php echo $ticket_priority->priority_id == $defaultpriorityid->row('value')?"selected":"";?>><?php echo $ticket_priority->priority_desc;?></option>
            <?php } ?>
        </select>
            &nbsp;<font class="error">&nbsp;</font>
    </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="form-group" style="margin-bottom:5px">
        <label class="col-sm-2 control-label">Ticket Status</label>
        <div class="col-sm-10">
            <select name="statusId" class="form-control">
                <?php foreach ($status->result() as $sticket) { ?>   
                <option value="<?php echo $sticket->id?>" <?php echo $sticket->id == $defaultstatusid->row('value')?"selected":"";?>><?php echo $sticket->name?></option>
                <?php }?>
            </select>
                &nbsp;<font class="error">&nbsp;</font>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="form-group" style="margin-bottom:5px;">
        <label for="inputEmail3" class="col-sm-2 control-label">SLA Plan</label>
          <div class="col-sm-10">
            <select name="slaId" class="form-control">
                <option value="0" selected="selected">— System Default —</option>
                <?php foreach ($sla->result() as $default) { ?>   
                   <option value="<?php echo $default->id?>" <?php echo $default->id == $defaultslaid->row('value')?"selected":"";?>><?php echo $default->sla_name?></option>
                <?php }?>          
            </select>
                &nbsp;<font class="error">&nbsp;</font>
          </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="form-group" style="margin-bottom:5px;">
        <label for="inputEmail3" class="col-sm-2 control-label">Due Date</label>
            <div class="input-append date form_datetime">
            <input style="margin-left: 16px" size="16" type="text" value="" name="datetime" autocomplete="off" readonly>
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
        &nbsp;<font class="error">&nbsp;</font>
    </div>
</div>
<div class="col-lg-12">
    <div class="form-group" style="margin-bottom:5px;">
        <label for="inputEmail3" class="col-sm-2 control-label">Assign To</label>
          <div class="col-sm-10">
            <select id="assignId" name="assignId" class="form-control">
                <option value="">— Select an Agent OR a Team —</option>
                <?php if ($_REQUEST['id'] != "" && $userinfo->row('autoassignment') == '1') {?>
                    <optgroup label="Agents (<?php echo $agent->num_rows();?>)">
                    <?php foreach ($agent->result() as $staff) { ?>
                        <option value="a<?php echo $staff->staff_id?>" <?php echo $userinfo->row('manager') == "a$staff->staff_id"?"selected":""; ?>><?php echo $staff->firstname?> <?php echo $staff->lastname?></option>
                    <?php }?>
                    </optgroup>

                    <optgroup label="Teams (<?php echo $team->num_rows();?>)">
                    <?php foreach ($team->result() as $teams) { ?>
                        <option value="t<?php echo $teams->team_id?>" <?php echo $userinfo->row('manager') == "t$teams->team_id"?"selected":""; ?>><?php echo $teams->name?></option>
                    <?php }?>
                    </optgroup>
                <?php }

                else {?>
                    <optgroup label="Agents (<?php echo $agent->num_rows();?>)">
                    <?php foreach ($agent->result() as $staff) { ?>
                        <option value="a<?php echo $staff->staff_id?>"><?php echo $staff->firstname?> <?php echo $staff->lastname?></option>
                    <?php }?>
                    </optgroup>

                    <optgroup label="Teams (<?php echo $team->num_rows();?>)">
                    <?php foreach ($team->result() as $teams) { ?>
                        <option value="t<?php echo $teams->team_id?>"><?php echo $teams->name?></option>
                    <?php }?>
                    </optgroup>
                <?php }?>

                
            </select>
            <span class="error"></span>
      </div>
    </div>
</div>
            
    <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css">
    <div class="col-lg-12" style="margin-top:15px;">
        <div class="section-break">
            <em><strong>Ticket Details</strong>: Please Describe The Issue</em>
        </div>
    </div>

    <div class="col-lg-12">
    <div>
        <div class="box">
            <div class="box-header">
                <!-- tools box -->
                <div class="pull-right box-tools">
            </div>
            <!-- /. tools -->
            </div>

            <!-- /.box-header -->
            <div class="box-body pad"> 
                <textarea name="message" placeholder="Details on the reason(s) for opening the ticket" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
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
        <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css">
    </div>
</div>

<div class="col-lg-12" style="padding-top: 10px">
    <div style="text-align:left;border:1px solid #ccc; background: #eee; padding:5px;">
        <em><strong>Internal Note</strong>
        <font class="error">&nbsp;</font></em>
    </div>
</div>
<div class="col-lg-12" style="padding-bottom:10px">
    <div class="box">
    <div class="box-header">

        <!-- tools box -->
        <div class="pull-right box-tools">

        </div>
        <!-- /. tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body pad">
        <textarea name="notes" placeholder="Optional internal note (recommended on assignment)" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
    </div>
    </div>
</div>
</div>

<p style="text-align:center;">
    <input type="submit" name="submit" value="Open">
    <input type="reset" name="reset" value="Reset">
</p>

<input type="hidden" name="draft_id">
</form>
<script type="text/javascript">
$(function() {
    $('input#user-email').typeahead({
        source: function (typeahead, query) {
            $.ajax({
                url: "ajax.php/users?q="+query,
                dataType: 'json',
                success: function (data) {
                    typeahead.process(data);
                }
            });
        },
        onselect: function (obj) {
            $('#uid').val(obj.id);
            $('#user-name').val(obj.name);
            $('#user-email').val(obj.email);
        },
        property: "/bin/true"
    });

       /*setTimeout(function() {
      $.userLookup('ajax.php/users/lookup/form', function (user) {
        window.location.href = window.location.href+'&uid='+user.id;
      });
    }, 100);*/
    });
</script>

        <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css"></div>

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

<div id="overlay" style="opacity: 0.5; display: none;"></div>
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
              html += "<option value='"+ result[i].id +"'>" + result[i].VALUE + "</option>";
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
   url:"<?php echo site_url('staff_ticket_controller/fetch_useropenticket')?>?id=<?php echo $_REQUEST['id']?>",
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

<ul class="typeahead dropdown-menu"></ul><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-html" style="display: none;">HTML</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-formatting" style="display: none;">Formatting</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-bold" style="display: none;">Bold</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-italic" style="display: none;">Italic</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-underline" style="display: none;">Underline</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-deleted" style="display: none;">Deleted</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-unorderedlist" style="display: none;">• Unordered List</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-orderedlist" style="display: none;">1. Ordered List</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-outdent" style="display: none;">&lt; Outdent</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-indent" style="display: none;">&gt; Indent</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-image" style="display: none;">Insert Image</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-link" style="display: none;">Link</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-alignment" style="display: none;">Alignment</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-horizontalrule" style="display: none;">Insert Horizontal Rule</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-table" style="display: none;">Table</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-video" style="display: none;">Insert Video</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-fontcolor" style="display: none;">Font Color</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-backcolor" style="display: none;">Back Color</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-fontfamily" style="display: none;">Change Font Family</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-0 redactor-toolbar-tooltip-deleteDraft" style="display: none;">Delete Draft</span><div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ui-datepicker-multi-2 ui-datepicker-multi" style="position: absolute; top: 351.719px; width: 34em; left: 386.828px; z-index: 1; display: none;"><div class="ui-datepicker-group ui-datepicker-group-first"><div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-left"><a class="ui-datepicker-prev ui-corner-all" data-handler="prev" data-event="click" title="Prev"><span class="ui-icon ui-icon-circle-triangle-w">Prev</span></a><div class="ui-datepicker-title"><span class="ui-datepicker-month">October</span>&nbsp;<span class="ui-datepicker-year">2018</span></div></div><table class="ui-datepicker-calendar"><thead><tr><th class="ui-datepicker-week-end"><span title="Sunday">Su</span></th><th><span title="Monday">Mo</span></th><th><span title="Tuesday">Tu</span></th><th><span title="Wednesday">We</span></th><th><span title="Thursday">Th</span></th><th><span title="Friday">Fr</span></th><th class="ui-datepicker-week-end"><span title="Saturday">Sa</span></th></tr></thead><tbody><tr><td class=" ui-datepicker-week-end ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">1</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">2</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">3</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">4</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">5</a></td><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">6</a></td></tr><tr><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">7</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">8</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">9</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">10</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">11</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">12</a></td><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">13</a></td></tr><tr><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">14</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">15</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">16</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">17</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">18</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">19</a></td><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">20</a></td></tr><tr><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">21</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">22</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">23</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">24</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">25</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">26</a></td><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">27</a></td></tr><tr><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">28</a></td><td class=" ui-datepicker-days-cell-over  ui-datepicker-today" data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default ui-state-highlight ui-state-hover" href="#">29</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">30</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="9" data-year="2018"><a class="ui-state-default" href="#">31</a></td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-week-end ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td></tr></tbody></table></div><div class="ui-datepicker-group ui-datepicker-group-last"><div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-right"><a class="ui-datepicker-next ui-corner-all" data-handler="next" data-event="click" title="Next"><span class="ui-icon ui-icon-circle-triangle-e">Next</span></a><div class="ui-datepicker-title"><span class="ui-datepicker-month">November</span>&nbsp;<span class="ui-datepicker-year">2018</span></div></div><table class="ui-datepicker-calendar"><thead><tr><th class="ui-datepicker-week-end"><span title="Sunday">Su</span></th><th><span title="Monday">Mo</span></th><th><span title="Tuesday">Tu</span></th><th><span title="Wednesday">We</span></th><th><span title="Thursday">Th</span></th><th><span title="Friday">Fr</span></th><th class="ui-datepicker-week-end"><span title="Saturday">Sa</span></th></tr></thead><tbody><tr><td class=" ui-datepicker-week-end ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">1</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">2</a></td><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">3</a></td></tr><tr><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">4</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">5</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">6</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">7</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">8</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">9</a></td><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">10</a></td></tr><tr><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">11</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">12</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">13</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">14</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">15</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">16</a></td><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">17</a></td></tr><tr><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">18</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">19</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">20</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">21</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">22</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">23</a></td><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">24</a></td></tr><tr><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">25</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">26</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">27</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">28</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">29</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="10" data-year="2018"><a class="ui-state-default" href="#">30</a></td><td class=" ui-datepicker-week-end ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td></tr></tbody></table></div><div class="ui-datepicker-row-break"></div><div class="ui-datepicker-buttonpane ui-widget-content"><button type="button" class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" data-handler="today" data-event="click">Today</button><button type="button" class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" data-handler="hide" data-event="click">Done</button></div></div></body></html>