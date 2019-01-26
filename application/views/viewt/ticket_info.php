<div id="content">

         <div style="padding-bottom:10px;">
    <h1>
        <a onclick="reload()" title="Reload"><i class="refresh icon-refresh"></i></a>
        <?php foreach ($result->result() as $value) { ?>
        <b>
        <?php echo $value->value;?></b>
        <small>#
          
          <?php echo $value->number;?>
          <?php } ?>  
          </small>
        <div class="pull-right">
            <a class="action-button" href="<?php echo site_url('ticket_controller/printpreview');?>?id=<?php echo $value->ticket_guid;?>"><i class="icon-print"></i> Print</a>
            <a class="action-button" href="<?php echo site_url('ticket_controller/ticketedit');?>?id=<?php echo $value->ticket_guid;?>"><i class="icon-edit"></i> Edit</a>
        </div>
    </h1>
</div>
<div class="col-lg-6" style="padding:0px;">
        <table class="infoTable" cellspacing="1" cellpadding="3" width="100%" border="0">
            <thead>
                <tr><td class="headline" colspan="2">
                    Basic Ticket Information                </td></tr>
            </thead>
            <tbody>
              <?php foreach ($result->result() as $value) { ?>
                <tr>
                    <th>Ticket Status:</th>
                    <td><?php echo $value->name;?></td>
                </tr>
                <tr>
                    <th>Department:</th>
                    <td><?php echo $value->department;?></td>
                </tr>
                <tr>
                    <th>Create Time:</th>
                    <td><?php echo $value->created_at;?></td>
                </tr>
              <?php } ?>
            </tbody>
       </table>
</div>
<div class="col-lg-6" style="padding:0px;">
    <table class="infoTable" cellspacing="1" cellpadding="3" width="100%" border="0">
        <thead>
            <tr><td class="headline" colspan="2">
                User Information            </td></tr>
        </thead>
       <tbody>
        <?php foreach ($user->result() as $value1) { ?>
        <tr>
           <th>Name:</th>
           <td><?php echo $value1->user_name;?></td>
       </tr>
       <tr>
           <th>Email:</th>
           <td><?php echo $value1->user_email;?></td>
       </tr>
       <tr>
           <th>Phone:</th>
           <td><?php echo $value1->user_phone;?></td>
       </tr>
       <?php } ?>
    </tbody></table>
</div>
<table width="100%" cellpadding="1" cellspacing="0" border="0" id="ticketInfo">
    <tbody><tr>
        <td colspan="2">
<!-- Custom Data -->
        <table class="custom-data" cellspacing="0" cellpadding="4" width="100%" border="0">
        <tbody>
        <?php foreach ($editticket->result() as $edit) { ?>
        <tr><td colspan="2" class="headline flush-left">Contacts</td></tr>
        <tr>
            <th>Name:</th>
            <td><?php echo $edit->contact;?></td>
        </tr>
        <tr>
            <th>Phone Numbers:</th>
            <td><?php echo $edit->phone_no;?></td>
        </tr>
        <?php } ?>
        </tbody></table>
        </td>
</tr>
</tbody></table>
<br>



<?php foreach ($thread->result() as $value1) { ?>

<?php if ($value1->type == 'E') { ?>


<div class="thread-event action">
        <span class="type-icon">
          <i class="faded icon-<?php echo $value1->class;?>"></i>
        </span>
        <span class="faded description">

            <?php echo $value1->body;?> 

        </span>
</div>

<?php }  else { ?>

<div id="thread-entry-38"><div class="thread-entry <?php echo $value1->class;?> <?php echo $enable_avatars->row('value') == 1?"avatar":"";?>">
<?php if ($enable_avatars->row('value') == 1) { ?>
<span class="pull-<?php echo $value1->avatar;?>  avatar">
<img class="avatar" alt="Avatar" src="//www.gravatar.com/avatar/591979a746b57c8ed09bca89133daeff?s=80&amp;d=mm"></span>
<?php } ?>
    <div class="header">
        <div class="pull-right">
        <div id="entry-action-more-38" class="action-dropdown anchor-right" style="left: 683.25px; top: 32px; display: none;">
            <ul class="title">
                <li>
                    <a class="no-pjax" href="#" onclick="javascript:
                    var url = 'ajax.php/tickets/11/thread/38/edit';
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
                <li>
                    <a class="no-pjax" href="#" onclick="javascript:
                    $.dialog('ajax.php/tickets/11/thread/38/previous');; return false;">
                    <i class="icon-copy"></i> View History</a></li>
            </ul>
        </div>
        <span class="textra light">
            <span class="label label-bare" title="Edited on  by Hugh Panda">Edited</span>
        </span>
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

 posted <time><?php echo $value1->created;?></time> </a>        <span style="max-width:400px" class="faded title truncate"></span>
        
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




<div class="clear" style="padding-bottom:10px;"></div>

<?php if ($openclose->status_guid != '3') { ?>
<form id="reply" action="<?php echo site_url('ticket_controller/StatusUpdate')?>" name="reply" method="post" enctype="multipart/form-data">
    <h2>Post a Reply</h2>
    <input type="hidden" name="id" value="<?php  echo $_REQUEST['id']; ?>">
    <div>
        <p><em>To best assist you, we request that you be specific and detailed</em>
        <font class="error">*&nbsp;</font>
        </p>
        <div class="form-group" style="margin-bottom: unset;">
                    
            <div class="box">
                <div class="box-header">

                  <!-- tools box -->
                  <div class="pull-right box-tools">

                  </div>
                  <!-- /. tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body pad">
                    
                    <textarea required="true" name="message" id="task-response" class="textarea" placeholder="Start writing your message here"
                              style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

                </div>
                </div>
                    
    <div class="filedrop">
        <div class="files"></div>
        <div class="dropzone">            
            <input style="display:unset;border:0;padding:0;background-color:white;" type="file" name="file[]" id="file" class="file" multiple>
        </div>
    </div>

    <p class="buttons">
        <label>Solved :</label>&nbsp;
        <input type="radio" name="solve" value="2" checked="">Solved&nbsp;
        <input type="radio" name="solve" value="1">Not
        <input style="float: right;margin-left: 5px;" type="reset" value="Reset">
        <input style="float: right;" type="submit" name='submit' value="Post Reply">
    </p>
        
        <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css"></div>
<input type="hidden" name="draft_id"></form>

<?php } else if ($openclose->status_guid == '3') {?>

    <div id="msg_warning">This ticket is marked as closed and cannot be reopened.</div>

<?php } ?>

<!-- <?Php 
$file = $_SERVER['DOCUMENT_ROOT'] . "/helpme2/uploads/306_Panda Staff Control Panel.csv"; //Path to your *.txt file 
$contents = file($file); 
$string = implode($contents); 

echo $file; 
?>
   
 -->
<script type="text/javascript">
    showImagesInline([]);
</script>
<link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css">
</div>
</div>

<div id="footer">
    <p>Copyright © 2018 Panda Ticketing System - All rights reserved.</p>
    <a id="poweredBy" href="http://osticket.com" target="_blank">Helpdesk software - powered by osTicket</a>
</div>
<div id="overlay" style="opacity: 0.3; top: 0px; left: 0px;"></div>
<div id="loading" style="top: 219px; left: 514.5px;">
    <h4>Please Wait!</h4>
    <p>Please wait... it will take a second!</p>
</div>
<script type="text/javascript">
    getConfig().resolve({"html_thread":true,"lang":"en_US","short_lang":"en","has_rtl":false,"primary_language":"en-US","secondary_languages":[]});
</script>

<script>
function reload() {
    location.reload();
}
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
</body></html>