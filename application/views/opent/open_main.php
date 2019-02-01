<div id="content" style="padding-top:0px">
  <div class="container">
    <h1>Open a New Ticket</h1><br>
    <p>Please fill in the form below to open a new ticket.</p>
  </div>
  <form id="ticketForm" method="post" action="<?php echo site_url('open_controller/create');?>" enctype="multipart/form-data">
    <div class="col-lg-12" style="overflow:auto;">
      <label for="inputEmail3" class="col-sm-12 control-label">
        <span class="col-sm-2" style="padding-left:0px;">Email :</span>
        <span class="col-sm-10" style="font-weight: normal;"><?php echo $_SESSION["useremail"] ?>
        </span>
      </label>
      <label for="inputEmail3" class="col-sm-12 control-label">
        <span class="col-sm-2" style="padding-left:0px;">Client :</span>
        <span class="col-sm-10" style="font-weight: normal;"><?php echo $_SESSION["username"] ?>
        </span>
      </label>
    </div>
    <div class="col-lg-12" style="overflow:auto;">
      <hr>
        <div class="form-group form-header" style="margin-bottom:0.5em;padding-left:15px;">
          <label for="inputEmail3" class="col-sm-2 control-label" style="padding-left:0px;padding-top:7px">
            <b>Help Topic<font class="error">*&nbsp;</font></b>
          </label>
          <label class="col-sm-9 control-label" style="overflow:auto;padding-left:2px;">
            <select required="true" id="type" name="topicId" class="form-control">
              <option>— Select Help Topic —</option>
              <?php foreach ($topic->result() as $reason) { ?>   
              <option value="<?php echo $reason->topic_guid?>" <?php echo $reason->topic_guid == $default_help_topic->row('value')?"selected":"";?>><?php echo $reason->topic?></option>
              <?php }?>
            </select>
          </label>
        </div>
   </div>
    <div id="dynamic-form">    
      <div class="col-lg-12" style="overflow:auto;">
          <div class="form-header" style="margin-bottom:0.5em;">
          </div>
          <div class="form-group">
            <label for="f15b5d6e30b79e5c" class="col-sm-2 control-label" style="padding-top:7px">
              <span class="required">
                Subtopic<span class="error">*</span>
              </span>                
            </label>
            <div class="col-sm-9 control-label">
              <select id="size" name="subtopic" class="form-control" data-placeholder="Select" required="true">
              <?php if ($default_help_topic->row('value') != '0') { ?>
              <?php foreach ($current_sub->result() as $sub) { ?>
                <option value="<?php echo $sub->list_item_guid;?>"><?php echo $sub->value;?></option>
              <?php } ?>
              <?php } ?>
              </select>
            </div>            
          </div>
      </div>

    <div class="col-lg-12" style="overflow:auto;">
    <hr>
    <div class="form-header" style="margin-bottom:0.5em;">
    <h3>Ticket Details</h3>
    <div>Please Describe The Issue</div>
    </div>
            
        <div class="form-group">
            <div class="box">
                <div class="box-header">

                    <!-- tools box -->
                    <div class="pull-right box-tools">

                    </div>
                    <!-- /. tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body pad">
                    
                    <textarea required="true" name="message" class="textarea" placeholder="Start writing your message here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
                </div>
                
        <div class="filedrop"><div class="files"></div>
            <div class="dropzone">
              <p class="buttons">
                <input style="display:unset;border:0;padding:0;background-color:white;" type="file" name="file[]" id="file" class="file" multiple>
              </p>
            </div>
        </div>

        <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css"></div>           
      </div>
    </div>
  <hr>
  <p class="buttons" style="text-align:center;">
    <input style="display: unset;" type="submit" name='submit' value="Create Ticket">
    <input style="display: unset;" type="reset" name="reset" value="Reset">
  </p>
  </form>
   
<input type="hidden" name="draft_id"><input type="hidden" name="draft_id"></form>
        </div>
    </div>


<script type="text/javascript">
  
$(document).ready(function () {
    $("#type").change(function () {
        var val = $(this).val();

        $.ajax({
          url : "<?php echo site_url('Open_controller/sub?id='); ?>" + val,
          success : function(result){
            result = JSON.parse(result);

            html = '';
            for(i = 0; i < result.length; i++)
            {
              html += "<option value='"+ result[i].list_item_guid +"'>" + result[i].VALUE + "</option>";
            }

            $('#size').html(html);
          }
        });
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

