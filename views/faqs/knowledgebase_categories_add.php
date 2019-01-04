<div id="content">
        <form action="<?php echo site_url('staff_faqs_controller/categories_add_process')?>" method="post" class="save">

 <h2>Add New Category         </h2>

    <div style="margin:8px 0"><strong>Category Type:</strong>
        <span class="error">*</span></div>
    <div style="margin-left:5px">
    <input type="radio" name="ispublic" value="2"><b>Featured</b> (on front-page sidebar)    <br>
    <input type="radio" name="ispublic" value="1"><b>Public</b> (publish)    <br>
    <input type="radio" name="ispublic" value="0" checked="checked">Private (internal)    <br>
    <div class="error"></div>
    </div>

<div style="margin-top:20px"></div>

<div class="tab">
    <ul class="tabs clean" style="margin-top:9px;">
        <li class="active"><a href="#info">Category Information</a></li>
        <li><a href="#notes">Internal Notes</a></li>
    </ul>
</div>

<div class="tab_content" id="info">



    <div class="" id="lang-en_US">
    <div style="padding-bottom:8px;">
        <b>Category Name</b>:
        <span class="error">*</span>
        <div class="faded">Short descriptive name.</div>
    </div>
    <input required="true" type="text" size="70" class="form-control" style="font-size:110%;width:100%;box-sizing:border-box" name="catename" value="">
    <div class="error"></div>

    <div style="padding:8px 0;">
        <b>Category Description</b>:
        <span class="error">*</span>
        <div class="faded">Summary of the category.</div>
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
              
                <textarea name="catedescrip" class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
              
            </div>
          </div>

    </div>
</div>


<div class="tab_content" id="notes" style="display:none;">
    <b>Internal Notes</b>:
    <span class="faded">Be liberal, they're internal</span>
    
    <div class="box">
            <div class="box-header">

              <!-- tools box -->
              <div class="pull-right box-tools">

              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
              
                <textarea name="catenotes" class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
              
            </div>
          </div>
    
</div>


<p style="text-align:center">
    <input type="submit" name="submit" value="Add">
    <input type="reset" name="reset" value="Reset">
    <input type="button" name="cancel" value="Cancel" onclick="window.location.href=&quot;categories.php&quot;">
</p>
</form>
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
<div id="overlay" style="opacity: 0.5; display: none;"></div>
<div id="loading" style="top: 124px; left: 524.5px;">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>
<div class="container dialog draggable ui-draggable" style="display: none; top: 31px; left: 374.5px;" id="popup">
    <div id="popup-loading">
        <h1 style="margin-bottom: 20px;"><i class="icon-spinner icon-spin icon-large"></i>
        Loading ...</h1>
    </div>
    <div class="body"></div>
</div>
<div style="display: none; top: 31px; left: 618.5px;" class="dialog" id="alert">
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


<span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-html" style="display: none;">HTML</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-formatting" style="display: none;">Formatting</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-bold" style="display: none;">Bold</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-italic" style="display: none;">Italic</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-underline" style="display: none;">Underline</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-deleted" style="display: none;">Deleted</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-unorderedlist" style="display: none;">• Unordered List</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-orderedlist" style="display: none;">1. Ordered List</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-outdent" style="display: none;">&lt; Outdent</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-indent" style="display: none;">&gt; Indent</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-link" style="display: none;">Link</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-alignment" style="display: none;">Alignment</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-horizontalrule" style="display: none;">Insert Horizontal Rule</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-table" style="display: none;">Table</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-video" style="display: none;">Insert Video</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-fontcolor" style="display: none;">Font Color</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-backcolor" style="display: none;">Back Color</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-2 redactor-toolbar-tooltip-fontfamily" style="display: none;">Change Font Family</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-3 redactor-toolbar-tooltip-formatting" style="display: none;">Formatting</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-3 redactor-toolbar-tooltip-bold" style="display: none;">Bold</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-3 redactor-toolbar-tooltip-italic" style="display: none;">Italic</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-3 redactor-toolbar-tooltip-underline" style="display: none;">Underline</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-3 redactor-toolbar-tooltip-deleted" style="display: none;">Deleted</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-3 redactor-toolbar-tooltip-unorderedlist" style="display: none;">• Unordered List</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-3 redactor-toolbar-tooltip-orderedlist" style="display: none;">1. Ordered List</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-3 redactor-toolbar-tooltip-outdent" style="display: none;">&lt; Outdent</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-3 redactor-toolbar-tooltip-indent" style="display: none;">&gt; Indent</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-3 redactor-toolbar-tooltip-link" style="display: none;">Link</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-3 redactor-toolbar-tooltip-fontcolor" style="display: none;">Font Color</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-3 redactor-toolbar-tooltip-backcolor" style="display: none;">Back Color</span><span class="redactor-toolbar-tooltip redactor-toolbar-tooltip-3 redactor-toolbar-tooltip-fontfamily" style="display: none;">Change Font Family</span></body></html>