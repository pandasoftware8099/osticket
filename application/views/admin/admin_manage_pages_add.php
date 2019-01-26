<div id="content">
        <form class="form-horizontal" action="pages.php?a=add" method="post" class="save">
 <input type="hidden" name="__CSRFToken__" value="cf61d8d60a340c4d49d63367580ad0f50f318737" /> <input type="hidden" name="do" value="add">
 <input type="hidden" name="a" value="add">
 <input type="hidden" name="id" value="">
 <h2><i class="help-tip icon-question-sign" href="#site_pages"></i> Add New Page        </h2>
    <div class="section-break" style="margin-bottom:10px;">
        <em>Page information</em>
    </div>
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-2 control-label">Name <span class="error">*</span> :</label>
        <div class="col-lg-10">
            <input type="text" size="40" name="name" class="form-control" value="" autofocus data-translate-tag=""/>
            &nbsp;<span class="error"></span>
        </div>
    </div>
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-2 control-label">Type <span class="error">*</span> :</label>
        <div class="col-lg-10">
            <span>
                <select name="type" class="form-control">
                    <option value="" selected="selected">&mdash; Select Page Type &mdash;</option>
                    <option value="landing" >Landing Page</option><option value="offline" >Offline Page</option><option value="thank-you" >Thank-You Page</option><option value="other" >Other</option>                </select>
                &nbsp;<span class="error"></span>
            </span>
        </div>
    </div>
        <div class="form-group">
        <label class="col-lg-2 control-label" style="padding-top: 0px">Status <span class="error">*</span> :</label>
        <div class="col-lg-10">
            <input type="radio" name="isactive" value="1" >
            <strong>Active</strong>
            <input type="radio" name="isactive" value="0" checked="checked">
            Disabled            &nbsp;<span class="error"></span>
        </div>
    </div>
<div style="margin-top: 10px">
  <div class="tab">
    <ul class="tabs clean">
      <li class="active"><a href="#page-content">Page Content</a></li>
      <li><a href="#notes">Internal Notes</a></li>
    </ul>
  </div>
  <div class="tab_content active" id="page-content">

    <div id="translations_container">
        <div id="translation-en_US" lang="en_US">
            <textarea required="true" name="response" id="task-response" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
        </div>

      <div id="msg_info">
        <em><i class="icon-info-sign"></i> Ticket variables are only supported in thank-you pages.</em>
      </div>

      <div class="error" style="margin: 5px 0"></div>
      <div class="clear"></div>
    </div>
  </div>

    <div class="tab_content" style="display:none" id="notes">
        <em><strong>Internal Notes</strong>:
            Be liberal, they're internal</em>
            <textarea name="response" id="task-response" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
    </div>
</div>

<p style="text-align:center">
    <input type="submit" name="submit" value="Add Page">
    <input type="reset"  name="reset"  value="Reset">
    <input type="button" name="cancel" value="Cancel" onclick='window.location.href="<?php echo site_url('admin_manage_controller/manage_pages')?>"'>
</p>
</form>
</div>
</div>