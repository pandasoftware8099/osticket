<div id="content">
        <form action="<?php echo site_url('staff_faqs_controller/faqedit_process');?>?id=<?php echo $_REQUEST['id'];?>" method="post" class="save" enctype="multipart/form-data">

 <h2>Frequently Asked Questions</h2>
     <div class="faq-title" style="margin:5px 0 15px"><?php echo $faqinfo->row('question') ?></div>
<div>
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-3 control-label">
            Category Listing<span class="error">*</span>
            <div class="faded">FAQ category the question belongs to.</div>
        </label>
        <div class="col-lg-9">
            <select name="category_guid" class="form-control">
                    <?php foreach ($faqcate->result() as $value1) { ?>
                        <option value="<?php echo $value1->category_guid;?>" <?php echo ($value1->category_guid == $faqinfo->row('category_guid') )?"selected":""; ?> ><?php echo $value1->name;?></option>
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
            <select name="ispublished" class="form-control">
                <?php foreach ($faqinfo->result() as $value) { ?> 
                <option value="2" <?php echo ($value->ispublished == 2)?"selected":""; ?> >
                    Featured (promote to front page)                </option>
                <option value="1" <?php echo ($value->ispublished == 1)?"selected":""; ?> >
                    Public (publish)                </option>
                <option value="0" <?php echo ($value->ispublished == 0)?"selected":""; ?> >
                    Internal (private)                </option>
                <?php } ?>
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

<?php foreach ($faqinfo->result() as $value1) { ?>
<div id="trans_container">
    <div class=" " id="lang-en_US">
    <div style="margin-bottom:0.5em;margin-top:9px">
        <b>Question            <span class="error">*</span>
        </b>
        <div class="error"></div>
    </div>
    <input required="true" type="text" size="70" name="question" style="font-size:110%;width:100%;box-sizing:border-box;" value="<?php echo $value1->question;?>">
    <div style="margin-bottom:0.5em;margin-top:9px">
        <b>Answer</b>
        <span class="error">*</span>
        <div class="error"></div>
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
                
                <textarea name="answer" class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $value1->answer;?></textarea>
                <?php } ?>
              
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
                <?php foreach ($faqinfo->result() as $value1) { ?>
                <textarea name="notes" class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $value1->notes;?></textarea>
                <?php } ?>
              
            </div>
          </div>

</div>

<p style="text-align:center;">
    <input type="submit" name="submit" value="Save Changes">
    <input type="reset" name="reset" value="Reset" onclick="javascript:
        $(this.form).find('textarea.richtext')
            .redactor('deleteDraft');
        location.reload();">
    <input type="button" name="cancel" value="Cancel" onclick="window.location.href=&quot;faq.php?id=7&quot;">
</p>
<input type="hidden" name="draft_id"></form>
        <link rel="stylesheet" type="text/css" href="/helpdesk/css/filedrop.css"></div>

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