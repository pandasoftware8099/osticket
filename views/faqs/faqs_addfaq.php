<style type="text/css">
    
#addstep{

    width: 100%;
    font-size:110%;
    width:100%;
    box-sizing:border-box;
}

</style>

<div id="content">

        <form action="<?php echo site_url('staff_faqs_controller/faqadd_process');?>" method="post" class="save" enctype="multipart/form-data">

 <h2>Frequently Asked Questions</h2>
<div>
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-3 control-label">
            Category Listing<span class="error">*</span>
            <div class="faded">FAQ category the question belongs to.</div>
        </label>
        <div class="col-lg-9">
            <select name="category_id" class="form-control" required="true">
                <option value="" selected="select">
                    --SELECT CATEGORY--</option>
                    <?php foreach ($faqcate->result() as $value1) { ?>
                        <option value="<?php echo $value1->category_id;?>"><?php echo $value1->name;?></option>
                    <?php } ?>
                            </select>
            <div class="error"></div>
        </div>
    </div>
        
        <div class="form-group" style="overflow:auto;">
        <label class="col-lg-3">
            Listing Type<span class="error">*</span>
            <i class="help-tip icon-question-sign" href="#listing_type"></i>
        </label>
        <div class="col-lg-9">
            <select name="ispublished" class="form-control" required="true">
                <option value="" selected="select">
                    --SELECT LISTING TYPE--</option>
                <option value="2">
                    Featured (promote to front page)                </option>
                <option value="1">
                    Public (publish)                </option>
                <option value="0">
                    Internal (private)                </option>
            </select>
            <div class="error"></div>
        </div>
    </div>
</div>

<div style="margin-top:20px"></div>

<div class="tab">
    <ul class="tabs clean" style="margin-top:9px;">
        <li class="active"><a href="#article">Article Content</a></li>
        <li><a href="#attachments">Attachments (0)</a></li>
        <li><a href="#notes">Internal Notes</a></li>
    </ul>
</div>

<div class="tab_content" id="article">
<strong>Knowledgebase Article Content</strong><br>
Here you can manage the question and answer for the article. Multiple languages are available if enabled in the admin panel.<div class="clear"></div>


<div id="trans_container">
    <div class=" " id="lang-en_US">
    <div style="margin-bottom:0.5em;margin-top:9px">
        <b>Question            <span class="error">*</span>
        </b>
        <div class="error"></div>
    </div>
    <input required="true" type="text" size="70" name="question" style="font-size:110%;width:100%;box-sizing:border-box;" value="">
    <div style="margin-bottom:0.5em;margin-top:9px">
        <b>Answer</b>
        <span class="error">*</span>
        <div id="ho" class="error"></div>

<!--         <div id="myDIV">
        <input type="text" id="addstep" name="answer[]" value="">
        <input type="file" name="file[]">
        </div>

        <a onclick="myFunction()">Add Step</a> -->

    <div class="box">
            <div class="box-header">

              <!-- tools box -->
              <div class="pull-right box-tools">

              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
              
                <textarea name="answer" class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
              
            </div>
          </div>


    </div>
    
    </div>
    </div>
</div>

<div class="tab_content" id="attachments" style="display:none">
    <div>
        <strong>Common Attachments</strong>
        <div>These attachments are always available, regardless of the language in which the article is rendered</div>
        <div class="error"></div>
        <div style="margin-top:15px"></div>
    </div>
    <div class="filedrop">
        <div class="files"></div>
            <div class="dropzone">            
                <input style="display:unset;border:0;padding:0;background-color:white;" type="file" name="file[]" id="file" class="file" multiple>
            </div>
    </div>

<div class="clear"></div>
</div>

<div class="tab_content" style="display:none;" id="notes">
    <div>
        <b>Internal Notes</b>:<span class="faded">Be liberal, they're internal</span>
    </div>
    <div style="margin-top:10px"></div>

    <div class="box">
            <div class="box-header">

              <!-- tools box -->
              <div class="pull-right box-tools">

              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
              
                <textarea name="notes" class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
              
            </div>
          </div>
    
</div>

<p style="text-align:center;">
    <input type="submit" name="submit" value="Add FAQ">
    <input type="reset" name="reset" value="Reset" onclick="javascript:
        $(this.form).find('textarea.richtext')
            .redactor('deleteDraft');
        location.reload();">
    <input type="button" name="cancel" value="Cancel" onclick="window.location.href=&quot;faq.php?cid=4&quot;">
</p>

</form>
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
<div id="loading" style="top: 202.667px; left: 524.5px;">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>
<div class="container dialog draggable ui-draggable" style="display: none; top: 50.6667px; left: 374.5px;" id="popup">
    <div id="popup-loading">
        <h1 style="margin-bottom: 20px;"><i class="icon-spinner icon-spin icon-large"></i>
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

<!--         <script>
        function myFunction() {
            var x = document.createElement("INPUT");
            x.setAttribute("type", "text");
            x.setAttribute("name", "answer[]");
            x.setAttribute("id", "addstep");
            var y = document.createElement("INPUT");
            y.setAttribute("type", "file");
            y.setAttribute("name", "imagePost[]");
            
            document.getElementById("myDIV").appendChild(x);
            document.getElementById("myDIV").appendChild(y);
        }
        </script> -->


</body></html>